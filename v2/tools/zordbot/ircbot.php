<?php
/*
 * le new bot de zordania
 * CPU econome grace a smartirc
 */

require_once('../../conf/conf.inc.php');
require_once(SITE_DIR . "lib/divers.lib.php");
//require_once(SITE_DIR . "lib/forum.lib.php");
// liste des mots du forum - voir tools/words.php :
require_once(SITE_DIR . "cache/words.cache.php");

error_reporting (E_ALL | E_STRICT | E_RECOVERABLE_ERROR);
date_default_timezone_set("Europe/Paris");


/* BDD
$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);
 */

/*  Templates
$_tpl = new Template();
$_tpl->set_tmp_dir(SITE_DIR . 'tmp');
$_tpl->set_dir(SITE_DIR . 'templates');
$_tpl->set_ref("_langues", $_langues);
$_tpl->set_lang('fr_FR');
$_tpl->get_config('config/config.config');
  */

/* compter le nombre de relances = arg du script CLI */
if(isset($argv[1])) $instance = (int)$argv[1];
else $instance = 1;

// Fonction normalisant le test, c'est-à-dire retirant les majuscules, les accents et les tirets en espace.
function normaliser($string)
{ 
        $a = 'âäàéèëêîïûüç-';
        $b = 'aaaeeeeiiuuc '; 
        $string = utf8_decode($string);     
        $string = strtr($string, utf8_decode($a), $b); 
        $string = strtolower(trim($string)); 
        return utf8_encode($string); 
}

// fonction pour rechercher un msg au hasard du forum d'après un mot
function cite_forum($word){
	$kw_results = search_keywords_results($word, 0);
	if(count($kw_results) >0){
		$post = get_post($kw_results[array_rand($kw_results)]); // 1 résultat au hasard
		$arr_word = split_words($word);
		$res = explode('<br />', nl2br(str_replace('.', "\n",$post['message'])));
		foreach($res as $msg){
			$pos = strpos($msg, $arr_word[0]);
			if($pos) break;
		}
		if(!$pos) $msg = $post['message'];
		return $msg." ... par ".$post['poster']." le ".$post['posted'].".(".count($kw_results)." résultats pour $word)";
	}
	return "Aucune idée pour $word";
}


$date_format = "Y_m_d";
$time = time(); // pour regénérer certains trucs régulièrement

$log = new log(SITE_DIR .'logs/irc/log_irc_'.date($date_format).'.log', false, false); //On ouvre la gestion des logs
$date=date($date_format); //Pour avoir un fichier de log journalier

include_once(SITE_DIR . 'lib/SmartIRC.php');

$Net_SmartIRC = new Net_SmartIRC();
$Net_SmartIRC->setDebug(SMARTIRC_DEBUG_ALL);
$Net_SmartIRC->setUseSockets(TRUE);
$Net_SmartIRC->setAutoReconnect(TRUE);
$Net_SmartIRC->setAutoRetry(TRUE);
$Net_SmartIRC->setChannelSyncing(TRUE); // track all users

$mybot = new bot(IRC_CHAN, $Net_SmartIRC);

// enregistrer des réponses à de messages
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!ops', $mybot, 'op_list');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!kick', $mybot, 'kick');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!time', $mybot, 'saytime_once');
// log tout ce qui est dit sur le chan
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '.*', $mybot, 'logging');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_JOIN, '.*', $mybot, 'onjoin_greeting');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!quit', $mybot, 'quit');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_QUERY|SMARTIRC_TYPE_NOTICE, '^test', $mybot, 'query_test');

// register saytime() to be called every 30 sec. (30,000 milliseconds)
$Net_SmartIRC->registerTimehandler(30000, $mybot, 'saytime');
// register saytime_once() to be called in 10 sec. (10,000 milliseconds) and save the assigned id
// which is needed for unregistering the timehandler.
$saytime_once_id = $Net_SmartIRC->registerTimehandler(10000, $mybot, 'saytime_once');

$Net_SmartIRC->connect(IRC_SERVER, IRC_PORT);
$Net_SmartIRC->login(IRC_PSEUDO, 'Net_SmartIRC Client '.SMARTIRC_VERSION.' (example.php)', 0, IRC_USER);
$Net_SmartIRC->join(array('#smartirc-test',IRC_CHAN));
// identification sur Q@CServe.quakenet.org
$Net_SmartIRC->message(SMARTIRC_TYPE_QUERY, "Q@CServe.quakenet.org", "auth ".IRC_USER." ".IRC_PASS);

$Net_SmartIRC->listen();
$Net_SmartIRC->disconnect();

die('fin bot irc OK');




/*
 boucle infinie tant que le bot est connecté à IRC 
*/
while($mybot->connected)
{


/*
 vérifier toutes les 5 min certaines actions
*/
	if($time + 300 < time()) {
		foreach($users as $pseudo => $_usr){	// regénérer sessions
			//$mybot->say('PING '.$pseudo , $pseudo);
			// si le user est encore online
			$_usr->update('irc');
		}
		if(date($date_format) != $date){ //gestion changement de fichier de log à minuit
			$log->close();
			$log = new log(SITE_DIR .'logs/irc/log_irc_'.date($date_format).'.log', false, false);
			$date = date($date_format);
		}
		$time = time();
	}



/*
 lire IRC et faire les actions correspondantes :
 "(ping):pseudo(!user@host) irccmd cible (ircarg):(botcmd) msg"
*/
	if($array = $mybot->get())
	{
		if(!$mybot->user && !$mybot->host && $array['irccmd'] == 'MODE' && $mybot->name == $array['pseudo'])
		{ // récupérer mon user@host
			$mybot->user = $array['user'];
			$mybot->host = $array['host'];
		}

//echo "*".$array['irccmd']."*\n";
	if ($array['irccmd'] == '353') { // and $array['ircarg'] == "= ".IRC_CHAN) {
		$chan = explode(' ', $array['ircarg']); // "= #chan"
		$msg = str_replace(array('@', '+'), '', $array['msg']);
		$msg = str_replace($mybot->name, '', $msg); // sauf le bot
		$mybot->say(chr(1)."ACTION entre discrètement dans la salle ... ".chr(1), $chan[1]);
		$mybot->say("Bonsoir $msg :) ", $chan[1]);
		$tmp = explode(' ', $array['msg']);
		foreach($tmp as $pseudo)
			$users[$pseudo] = new ircuser($_sql, $pseudo);
		echo "\nNAMES : *$msg* *" . $array['ircarg']."*\n";
	}
/*
 SI on me cause en privé - réponse spécifique
*/
		if($array['irccmd'] == 'PRIVMSG')
		{
			if($array['cible'] == $mybot->name) // on me cause en privé
			{
				switch($array['botcmd']){

				case 'login';
					if($users[$array['pseudo']]->session_opened())
						$mybot->say("Je te connais déjà {$array['pseudo']} :) ", $array['pseudo']);
					else{
						// login zordania : informe sur les droits avec le bot (admin / opé)
						$ident = explode(' ',$array['msg']);
						if(count($ident)<2){
							$mybot->say("usage: !login <login> <passe>", $array['pseudo']);
							$mybot->say("permet de se connecter à zordania via IRC (mêmes login/passe que sur zordania)", $array['pseudo']);
						}else{
							$pseudo = $ident[0];
							$pass   = $ident[1];
							$_usr   = $users[$pseudo]; //new ircuser($_sql, $pseudo);
							if($_usr->login( $pseudo, $pass)){
								$msg = "Connexion OK :) ";
								if($_usr->get('msg') > 1) $msg .= 'Vous avez '.$_usr->get('msg'). ' nouveaux messages !';
								else if($_usr->get('msg') == 1) $msg .= 'Vous avez 1 nouveau message !';
								$mybot->say($msg, $array['pseudo']);
								$mybot->say('Je connais '.$array['pseudo'].' ! C\'est '.$_usr->get('pseudo').' ! '.$_usr->get('groupe'));
								foreach($_usr->get_vars() as $key => $value)
									$mybot->say("TEST: [$key] = *$value*", $array['pseudo']);
								if($_usr->admin)
								{
									$mybot->op($array['pseudo'], IRC_CHAN);
								}
								if($_usr->ope and !$_usr->admin)
								{
									$mybot->voice($array['pseudo'], IRC_CHAN);
								}
								$users[$array['pseudo']] = $_usr;
							} else
								$mybot->say("Connexion KO ! *".trim($ident[0]).'* / *'.trim($ident[1]).'*' , $array['pseudo']);
						}
					}
				break;

				case 'help';
				case 'aide'; // TODO : maj de l'aide du bot
					$mybot->notice($array['pseudo'], "Liste des commandes : !quiz (pour lancer un quiz), " .
						"!classement (pour voir le classement actuel), " .
						"!question (pour réafficher la question courante), " .
						"!help (affiche cette aide).");
				break;

				case 'update';
					if($users[$array['pseudo']]->session_opened()){
						if($users[$array['pseudo']]->update('irc')){
							$mybot->notice($array['pseudo'], 'update ok.');
							foreach($users[$array['pseudo']]->get_vars() as $key => $value)
								$mybot->say("TEST: [$key] = *$value*", $array['pseudo']);
						}else
							$mybot->notice($array['pseudo'], 'update KO!');
					}else{
						$mybot->notice($array['pseudo'], 'pas connecté : !login <pseudo> <pass>');
					}
				break;

				case 'do';
					if($users[$array['pseudo']]->admin){
						$mybot->send($array['msg']);
						$mybot->say("J'ai dit : ".$array['msg'], $array['pseudo']);
					}else
						$mybot->say('interdit', $array['pseudo']);
				break;

				case 'who';
					if($users[$array['pseudo']]->admin){
						$mybot->send("NAMES #zordania");
						$mybot->say("BANLIST #zordania", "Q");
						//$mybot->say($array['msg'], $array['pseudo']);
					}else
						$mybot->say('interdit', $array['pseudo']);
				break;

				case 'date';
				case 'time';
					$mybot->notice($array['pseudo'], "Il est ".date('r')." TIMESTAMP : ".time());
				break;

				case 'join';
					if($users[$array['pseudo']]->admin)
						$mybot->join($array['msg']);
				break;
				case 'part';
					if($users[$array['pseudo']]->admin)
						$mybot->part($array['msg']);
				break;

				case 'quit';
				case 'quitquiz';
					if($users[$array['pseudo']]->admin){
						if($mybot->quit($array['msg'])) die($array['msg']); // fin de la boucle infinie
						else echo 'continue...';
					}
				break;

				case 'restart';
					if($users[$array['pseudo']]->admin)
						if($mybot->quit("restart demandé par ".$array['pseudo']." ! bye ! ($instance)")){
							$instance++;
							$command = "php ".realpath(__FILE__)." $instance > /dev/null &";
							echo $command;
							exec($command);
							die("Fin programme ($instance)");
						}
				break;

				default: // rechercher une réponse à la question en cours
					$mybot->say("commande non reconnue : ".$array['botcmd']." (!aide pour la liste des commandes)", $array['pseudo']);
				}
			}

/*
 SI on me cause sur un #chan ...
*/
			else
			{	
				if($array['cible'] == IRC_CHAN) // log du chan #zordania
					$log->text($array['pseudo']." : ".($array['botcmd']?'!':'').$array['botcmd']." ".$array['msg']);

				switch($array['botcmd']){
				case 'quiz';
				break;

				case 'question';
					if($questionPosee == 1)
						$mybot->notice($array['pseudo'], "Question $questionNombre : ".$questions[$questionEnCours][0]);
					else
						$mybot->notice($array['pseudo'], 'Il n\'y a aucune question posée...');
				break;

				case 'classement';
				break;

				case 'stopquiz';
				break;

				case 'date';
				case 'time';
					$mybot->notice($array['pseudo'], "Il est ".date('r')." TIMESTAMP : ".time());
				break;

				case 'quit';
				case 'quitquiz';
					if($users[$array['pseudo']]->admin){
						if($mybot->quit($array['msg'])) die($array['botcmd']); // fin de la boucle infinie
						else echo 'continue...';
					}else
						$mybot->say("T'a pas le droit, ". $array['pseudo'].", désolé :) ");
				break;

				case 'citation';
				case 'cite';
					if($array['msg'])
						$mybot->say(cite_forum($array['msg']));
					else
						$mybot->say("J'ai pas d'inspiration ...");
				break;

				case 'restart';
					if($users[$array['pseudo']]->admin){
						if($mybot->quit("restart demandé par ".$array['pseudo']." ! bye ! ($instance)")){
							$instance++;
							$command = "php ".realpath(__FILE__)." $instance > /dev/null &";
							echo $command;
							exec($command);
							die("Fin programme ($instance)");
						}
					}else
						$mybot->say("Tu peux pas me demander ça, ". $array['pseudo']." !");
				break;

				case 'help';
				case 'aide';
					$mybot->notice($array['pseudo'], "Liste des commandes : !quiz (pour lancer un quiz), " .
						"!classement (pour voir le classement actuel), " .
						"!question (pour réafficher la question courante), " .
						"!help (affiche cette aide).");
				break;

				default: // rechercher une réponse à la question en cours
					if(!empty($array['botcmd'])) echo "\n*".$array['botcmd']."*\n";
					if($questionPosee == 1 && time() <= $questionTime 
						&& normaliser($array['msg']) == normaliser($questions[$questionEnCours][1]))
					{
						$mybot->say("Bravo ".$array['pseudo']." ! La réponse était bien : ".$questions[$questionEnCours][1].".", $array['cible']);
						$questionPosee = 0;
						if($highscore[$array['pseudo']])
							$highscore[$array['pseudo']]++;
						else
							$highscore[$array['pseudo']] = 1;
						$questionTime = time()+15;
						$questionEnCours++;
						if(count($questions) > $questionEnCours || $questionEnCours > 99)
							$mybot->say("Prochaine question dans 15 secondes...", $array['cible']);
					}
				} // END switch botcmd
			} // fin IF on cause sur le chan
		} // if PRIVMSG
/*
 autres commandes ici (KICK JOIN PART MODE NICK etc)
*/
		elseif($array['irccmd'] == 'JOIN' && $array['pseudo'] != $mybot->name)
		{
			$mybot->say($array['cible'].' : Bienvenue '.$array['pseudo'].' sur le chat de '.$array['cible'].' !!', $array['cible']);
			$users[$array['pseudo']] = new ircuser($_sql, $array['pseudo']);
		}
		elseif(($array['irccmd'] == 'PART' or $array['irccmd'] == 'QUIT') && $array['pseudo'] != $mybot->name)
		{
			$mybot->say(IRC_CHAN.' : Bybye '.$array['pseudo'].' ! reviens quand tu veux !', IRC_CHAN);
			unset($users[$array['pseudo']]);
		}
		elseif($array['irccmd'] == 'NICK' && $array['pseudo'] != $mybot->name)
		{
			$mybot->say(IRC_CHAN.' : '.$array['pseudo'].' devient '.$array['msg'].' !!', IRC_CHAN);
			$users[$array['msg']] = $users[$array['pseudo']];
			unset($users[$array['pseudo']]);
		}
	
	} // if get data


/*
 GESTION du QUIZZ en cours
*/
	if($quiz == 1)
	{
		if($questionPosee == 0 && time() >= $questionTime)
		{ // nouvelle question
			$questionNombre = $questionEnCours+1;
			$mybot->say("Question $questionNombre : ".$questions[$questionEnCours][0]);
			$questionPosee = 1;
			$questionTime = time()+30;
		}

		if($questionEnCours >= count($questions) || $questionEnCours > 99)
		{
			$mybot->say("Le quiz est terminé ! Classement : ");
			$classement = '';
			arsort($highscore);
			$nicks = array_keys($highscore);
			print_r($nicks);
			print_r($highscore);
			$i = 0;
			for($i = 0;$i < count($highscore);$i++)
			{
				$classement .= "$place. ".$nicks[$i]." (".$highscore[$nicks[$i]].") ";
			}
			$mybot->say($classement);
			$quiz = 0;
		}
		if($questionPosee == 1 && time() > $questionTime)
		{ // question expirée
			$mybot->say("Le temps est écoulé ! la bonne réponse était : ".$questions[$questionEnCours][1]);
			$questionTime = time()+15;
			$questionPosee = 0;
			$questionEnCours++;
			$unanswered++;
			if(count($questions) > $questionEnCours)
				$mybot->say("Prochaine question dans 15 secondes...");
		}
	} // if quiz

	usleep(500); // temporisation indispensable dans la boucle infinie
	$mybot->send(); // dépiler & envoyer
}

?>
