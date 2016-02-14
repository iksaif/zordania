<?php

require_once("../../lib/log.class.php");

/* compter le nombre de relances */
if(isset($argv[1])) $instance = (int)$argv[1];
else $instance = 1;
echo "instance $instance\r\n";

// Fonction normalisant le test, c'est-à-dire retirant les majuscules et les accents.
function normaliser($string)
{ 
        $a = 'âäàéèëêîïûüç-';
        $b = 'aaaeeeeiiuuc '; 
        $string = utf8_decode($string);     
        $string = strtr($string, utf8_decode($a), $b); 
        $string = strtolower($string); 
        return utf8_encode($string); 
}


set_time_limit(0);
$time_format = "Y_m_d";
$server='irc.quakenet.org';
$port='6667';
$name='ZordQuiz';
$user='ZordQuiz';
$chan = '#zordania';
$operators = array();
$voice = array();
$users_online = array();
$admins = array('tham','pifou');

$log = new log("log_chat/log_".date($time_format).".log");
$log->open();
$date=date($time_format);

$socket = fsockopen( $server , $port , $errno, $errstr, 1); // Connexion au serveur.

if (!$socket) exit(); // Si la connexion n'a pas eu lieu, on arrête le script (exit()).
 fputs($socket , "USER $name $chan $user .\r\n" );

 fputs($socket , "NICK $name\r\n" ); // Pseudo du bot.
  
 stream_set_timeout($socket, 0);

 $continuer = 1;
 
/********************************************/
while($continuer) // Boucle pour la connexion.
{

	$donnees = fgets($socket, 1024);
	$retour = explode(':',$donnees);
	if(rtrim($retour[0]) == 'PING')
		fputs($socket,'PONG :'.$retour[1]);
	 if($donnees)
		echo $donnees;

	if(preg_match('#:(.+):End Of /MOTD Command.#i',$donnees))
		$continuer = 0;
}
fputs($socket , "JOIN $chan\r\n" );

fputs($socket,"PRIVMSG Q@CServe.quakenet.org :AUTH zordania iksaif74\r\n");
fputs($socket,"PRIVMSG Q :op #zordania");

//fputs($socket,"PRIVMSG Q : op #zordania\r\n");

$file = file_get_contents('../../templates/fr_FR/commun/question.txt'); // On lit le fichier des questions dans une chaîne.
$questions = explode("\n",$file); // On sépare chaque ligne (\n est le caractère signifiant une nouvelle ligne).

// On sépare la question et la réponse :
for($i=0;isset($questions[$i]);$i++)
	$questions[$i] = explode('<|#()#|>',$questions[$i]);

shuffle($questions);
$i = 0;
$newquestions = array();
foreach($questions as $question)
{
	$newquestions[$i] = $question;
	$i++;
}
$questions = $newquestions;
array_pop($questions);

//print_r($questions);
$continuer = 1;
$quiz = 0;
$questionEnCours = -1;
fputs($socket,"PRIVMSG $chan : Test\r\n");
fputs($socket,"PRIVMSG $chan : Bonjour à tous !\r\n");
while($continuer)
{	
	if(date($time_format) != $date){
		$log->close();
		$log = new log("log_chat/log_".date($time_format).".log");
		$log->open();
		$date = date($time_format);
	}
	
	$donnees = fgets($socket, 1024);
	if($donnees)
	{	//:tham!~tham@hebergeur PRIVMSG #zordania :.test toto
		$array = explode(':',$donnees);
		$msg=$array[2];
		$pseudo= explode('!',$array[1]);
		$pseudo = trim($pseudo[0]);
		$infos = explode(' ',$array[1]);
		$chan = trim($infos[2]);
		$cmd = explode(' ',$array[2]);
		
		$log->text(" $pseudo : $msg");

		/*if(rtrim($pseudo) == 'tham' || rtrim($pseudo) == 'pifou') {
		fputs($socket,"PRIVMSG tham : $donnees \r\n");
		fputs($socket,"PRIVMSG pifou : $donnees \r\n");
		}*/
if (in_array($infos[1], array('JOIN', 'PART', 'QUIT'))){print_r($infos);echo "*$chan*$pseudo*";}

		if(rtrim($array[0]) == 'PING')
		{
			fputs($socket,'PONG :'.$array[1]);
			echo $donnees;
		}
	/*elseif($array['irccmd'] == 'MODE' && $mybot->chan == $array['cible'] && rtrim($infos[3]) == '+b') {
//:pifou!~chatzilla@hebergeur MODE #zordania +b *!*@herbergeurban
		$mybot->say($array['unbanme #zordania', 'Q');
		sleep(1);
		$mybot->join();
		}
		elseif($array['irccmd'] == 'KICK' && $array['pseudo'] == $mybot->name ){
				$mybot->join();
				$mybot->say("On ne me kick pas, bande de malotru !!");
		}*/
		elseif(rtrim($infos[1]) == 'KICK') {
			if( rtrim($infos[3]) == $name ){
				fputs($socket , "JOIN $chan\r\n" );
				fputs($socket,"PRIVMSG $chan : On ne me kick pas, bande de malotru !!\r\n");
			}else { $peudo = $infos[3];
				fputs($socket,"PRIVMSG $chan : Au revoir $pseudo, et a bientôt !!\r\n"); }
		}
		elseif(rtrim($infos[1]) == 'JOIN') {
//:pifou!~chatzilla@herbergeur JOIN #zordania
print_r($infos);echo "*$chan*$pseudo*";
			fputs($socket,"PRIVMSG $chan : Bievenue $pseudo sur le chat de zordania !!\r\n");
		}

		elseif(rtrim($infos[1]) == 'PART' || rtrim($infos[1]) == 'QUIT') {
//:pifou!~chatzilla@herbergeur PART #zordania
print_r($infos);echo "*$chan*$pseudo*";
			fputs($socket,"PRIVMSG $chan : Au revoir $pseudo, et a bientôt !!\r\n");
			fputs($socket,"PRIVMSG $chan : Ho mais restez, ne me laissez pas seul j'ai peur du noir !!\r\n");
		}
		elseif(rtrim($infos[1]) == 'MODE' && $chan == '#zordania' && rtrim($infos[3]) == '+b') {
//:pifou!~chatzilla@hebergeur MODE #zordania +b *!*@herbergeurban
		fputs($socket,"PRIVMSG Q :unbanme #zordania\r\n");
		sleep(1);
		fputs($socket , "JOIN $chan\r\n" );
		}
		elseif(rtrim($infos[1]) == 'PRIVMSG')
		{
			//print_r($cmd);
			if(rtrim($cmd[0]) == '!quiz')
			{
				if($quiz == 0)
				{
					$quiz = 1;
					$questionEnCours = 0;
					$questionPosee = 0;
					$highscore = array();
					$questionTime = time()+15;
					fputs($socket,"PRIVMSG $chan :Un quiz a été lancé ! Tentez de répondre aux questions pour être le meilleur !\r\n");
					fputs($socket,"PRIVMSG $chan :Vous disposez de 30 secondes pour répondre.\r\n");
					fputs($socket,"PRIVMSG $chan :Que le meilleur perde, il y a 30 questions maximum\r\n");
					fputs($socket,"PRIVMSG $chan :Départ dans 15 secondes...\r\n");
				}
				else
					fputs($socket,"NOTICE $pseudo :Un quiz est déjà lancé -_-\r\n");
					
				
			}
			if(rtrim($cmd[0]) == '!question')
			{
				if($questionPosee == 1)
				{
					fputs($socket,"NOTICE $pseudo :Question $questionNombre : ".$questions[$questionEnCours][0]."\r\n");
				}
				else
				{
					fputs($socket,"NOTICE $pseudo :Il n'y a aucune question posée...\r\n");
				}
			}
			if(rtrim($cmd[0]) == '!classement')
			{
				if($quiz == 1)
				{
					$classement = '';
					arsort($highscore);
					$nicks = array_keys($highscore);
					$i = 0;
					for($i = 0;$i < count($highscore);$i++)
					{
						$place = $i+1;
						$classement .= "$place. ".$nicks[$i]." (".$highscore[$nicks[$i]].") ";
					}
					fputs($socket,"NOTICE $pseudo :Classement : $classement\r\n");
				}
				else
				{
					fputs($socket,"NOTICE $pseudo :Il n'y a aucun quiz de lancé...\r\n");
				}
			}
			if(rtrim($cmd[0]) == '!stopquiz' && in_array($pseudo,$admins))
			{
				fputs($socket,"PRIVMSG $chan :Le quiz est terminé ! Classement : \r\n");
				$classement = '';
				arsort($highscore);
				$nicks = array_keys($highscore);
				print_r($nicks);
				print_r($highscore);
				$i = 0;
				for($i = 0;$i < count($highscore);$i++)
				{
					$place = $i+1;
					$classement .= "$place. ".$nicks[$i]." (".$highscore[$nicks[$i]].") ";
				}
				fputs($socket,"PRIVMSG $chan :$classement\r\n");
				$quiz = 0;
			}
			if(rtrim($cmd[0]) == '!quitquiz' && in_array($pseudo,$admins))
			{
				$log->close();
				fputs($socket,"PRIVMSG $chan : Il est l'heure de dormir, à plus !! \r\n");
				fputs($socket,"QUIT\r\n");
				$continuer = 0;
			}
			
			if(rtrim($cmd[0]) == '!restart' && in_array($pseudo,$admins))
			{
				$log->text("Restart du bot");
				$log->close();
				$emplacement = realpath('zordbot_dev.php');
				fputs($socket,"QUIT restart demandé par $pseudo ! bye ! ($instance)\r\n");
				sleep(1);
				$instance++;
				exec("php $emplacement $instance > /dev/null &");
				die;
			}

			/*if(rtrim($cmd[0]) == '!nick' && in_array($pseudo,$admins))
			{	$name = $cmd[1];
				fputs($socket,"NICK : $name\r\n");
				fputs($socket,"PRIVMSG $chan : Désormais je suis $name\r\n");
			}*/
			if(rtrim($cmd[0]) == '!help')
			{
				fputs($socket,"NOTICE $pseudo :Liste des commandes : !quiz (pour lancer un quiz), !classement (pour voir le classement actuel), !question (pour réafficher la question courante), !helpadmin (affiche les commandes admin dispo), !help (affiche cette aide).\r\n");
			}
			if(rtrim($cmd[0]) == '!helpadmin')
			{
				fputs($socket,"NOTICE $pseudo :Liste des commandes admin : !quitquiz (pour déconnecter le bot), !stopquiz (pour stopper le quizz en cours), !restart (pour redémarrer le bot)\r\n");
			}
			elseif($questionPosee == 1 && time <= $questionTime && strtolower(ltrim(rtrim(join(' ', $cmd)))) == normaliser(strtolower($questions[$questionEnCours][1])))
			{
				fputs($socket,"PRIVMSG $chan :Bravo $pseudo ! La réponse était bien : ".$questions[$questionEnCours][1].".\r\n");
				$questionPosee = 0;
				if($highscore[$pseudo])
					$highscore[$pseudo]++;
				else
					$highscore[$pseudo] = 1;
				print_r($highscore);
				$questionTime = time()+15;
				$questionEnCours++;
				if(count($questions) > $questionEnCours || $questionEnCours > 29)
					fputs($socket,"PRIVMSG $chan :Prochaine question dans 15 secondes...\r\n");
			}
		}
	}
	if($quiz == 1)
				{
					if($questionPosee == 0 && time() >= $questionTime)
					{
						$questionNombre = $questionEnCours+1;
						fputs($socket,"PRIVMSG $chan :Question $questionNombre : ".$questions[$questionEnCours][0]."\r\n");
						$questionPosee = 1;
						$questionTime = time()+30;
					}
					
					if($questionEnCours >= count($questions) || $questionEnCours > 29)
					{
						fputs($socket,"PRIVMSG $chan :Le quiz est terminé ! Classement : \r\n");
						$classement = '';
						arsort($highscore);
						$nicks = array_keys($highscore);
						print_r($nicks);
						print_r($highscore);
						$i = 0;
						for($i = 0;$i < count($highscore);$i++)
						{
							$place = $i+1;
							$classement .= "$place. ".$nicks[$i]." (".$highscore[$nicks[$i]].") ";
						}
						fputs($socket,"PRIVMSG $chan :$classement\r\n");
						$quiz = 0;
					}
					if($questionPosee == 1 && time() > $questionTime)
					{
						fputs($socket,"PRIVMSG $chan :Le temps est écoulé ! la bonne réponse était : ".$questions[$questionEnCours][1]."\r\n");
						$questionTime = time()+15;
						$questionPosee = 0;
						$questionEnCours++;
						$unanswered++;
						if(count($questions) > $questionEnCours)
						fputs($socket,"PRIVMSG $chan :Prochaine question dans 15 secondes...\r\n");
					}
				}
				usleep(1000);
}

