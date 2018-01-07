<?php
/* classe IRC - gère la connexion au serveur IRC
 écoute et discute - gère le chan */

class irc {

	var $socket;
	var $connected = false;
	var $server = IRC_SERVER;
	var $port = IRC_PORT;
	var $errno = false;
	var $errstr;
	var $name;
	var $chan; // chan par défaut
	var $chans = array(); // liste de chans
	var $user;
	var $host;
	var $arrsay = array();

	function __construct($name, $user, $autoconnect = true){
		$this->name = $name;
		$this->user = $user;
		if($autoconnect) return $this->connect(); // connect avec param par défaut
		else return true;
	}

	function __destruct(){
		$this->quit('Fin programme');
	}

	function connect($server = false, $port = false){
		if($server !== false) $this->server = $server;
		if($port !== false) $this->port = $port;

		$this->socket = fsockopen( $this->server , $this->port , $this->errno, $this->errstr, 1); // Connexion au serveur.
		if (!$this->socket) return false;
		$this->connected = true;
		
		fputs($this->socket, "USER ".$this->user." ".$this->user." ".$this->user." .\r\n" );
		fputs($this->socket, "NICK ".$this->name."\r\n" ); // Pseudo du bot.
		stream_set_timeout($this->socket, 0);
		
		$continuer = 1;
		/********************************************/
		while($continuer) // Boucle pour la connexion.
		{
			$donnees = fgets($this->socket, 1024);
			$retour = explode(':',$donnees);
			if(rtrim($retour[0]) == 'PING')
				$this->pong($retour[1]);
			if($donnees)
				echo $donnees;
		
			if(preg_match('#:(.+):End Of /MOTD Command.#i',$donnees))
				$continuer = 0;
			usleep(1000);
		}
		return true;
	}
	function pong($data){
		if($this->connected) fputs($this->socket,'PONG :'.$data);
	}

	function join($chan = false){
		if($chan !== false){
			if(substr($chan,0,1) != '#') $chan = "#$chan";
			$this->chans[$chan] = $chan;
			if(!isset($this->chan)) $this->chan = $chan;
		}
		$this->arrsay[] = "JOIN $chan\r\n"; // empiler
	}

	function quit($msg = 'end'){ // quitter & déconnecter
		if(!$this->connected) return true;
		foreach($this->chans as $chan) // quitter c'est partir un peu
			$this->part($chan, $msg);
		fputs($this->socket,"QUIT :$msg\r\n");
		usleep(100000);
		$this->connected = !fclose($this->socket);
		return !$this->connected; // déconnection réussie?
	}

	function part($chan, $msg = '') { // quitter un chan
		if(!$this->connected) return true;
		$this->arrsay[] = "PART $chan :$msg (QUIT)\r\n"; // empiler
		unset($this->chans[$chan]);
	}

function get($donnees = false){ // analyse syntaxe IRC... contient l'anti-kick-ban & le pong
	// lire msg du serveur
	if($donnees === false and $this->connected)
		$donnees = fgets($this->socket, 1024);

	if($donnees) // format: "(ping):pseudo(!user@host) irccmd cible (ircarg):(botcmd) msg"
	{
		echo $donnees;

		$pos = strpos($donnees, ':')+1;
		$ping = trim(substr($donnees, 0, $pos-1));
		if($ping == 'PING'){/* gestion ping-pong */
			$this->pong(substr($donnees, $pos));
			return false;
		}

		$pos0 = strpos($donnees, ':', $pos);
		if($pos0 === false)
			$tmp1 = substr($donnees, $pos);
		else
			$tmp1 = substr($donnees, $pos, $pos0-$pos);

		$tmp1 = explode(' ', $tmp1, 4); // explose en user irccmd cible ircargs
		if(strpos($tmp1[0],'!') !== false){
			$tmp2 = explode('!',$tmp1[0]);
			$pseudo = $tmp2[0];
			$tmp3 = explode('@',$tmp2[1]);
			$user = $tmp3[0];
			$host = $tmp3[1];
		}else{
			$pseudo = $tmp1[0];
			$user = '';
			$host = '';
		}
		$irccmd = $tmp1[1];
		$cible = isset($tmp1[2]) ? $tmp1[2] : '';
		$ircarg = isset($tmp1[3]) ? $tmp1[3] : '';

		$botcmd = '';
		if($pos0 === false)
			$msg = substr($donnees, $pos); // répete tt les infos
		else{
			$msg = trim(substr($donnees, $pos0+1));
			if(strpos($msg, '!') === 0){ // commande
				$tmp1 = explode(' ', $msg, 2);
				$botcmd = substr($tmp1[0], 1);
				$msg = isset($tmp1[1]) ? $tmp1[1] : '';
			}
		}

		if($irccmd == 'KICK' && $ircarg == $this->name ){//anti kick du bot
			$this->join($cible);
			$this->say("On ne me kick pas, bande de malotru !!", $cible);
			return false;
		}
		elseif($irccmd == 'MODE' && strpos($ircarg, '+b') !== false) { //gestion anti ban du bot :)
			// && in_array($this->name, $infos) // manque de vérifier le user@host !
			$this->unbanmeQ($cible);
			$this->join($cible);
			$this->say("On ne me banni pas, non plus !!", $cible);
			return false;
		}
if($ping != "") echo "ping:pseudo!user@host irccmd cible ircarg:botcmd msg => $ping:$pseudo!$user@$host $irccmd $cible $ircarg:$botcmd $msg\n";
		return array(
				'ping'	=> $ping,
				'pseudo'	=> $pseudo,
				'user'	=> $user,
				'host'	=> $host,
				'irccmd'	=> $irccmd, 
				'cible'	=> $cible, 
				'ircarg'	=> $ircarg,
				'botcmd'	=> $botcmd,
				'msg'		=> $msg);
	}
	return false;
} // get

	function say($msg, $cible = false){ // dire sur le chan
		if($cible == false) $cible = $this->chan;
		$this->arrsay[] = "PRIVMSG $cible :$msg\r\n"; // empiler
	}
	function action($msg, $cible = false){ // /me sur le chan
		if($cible == false) $cible = $this->chan;
		$this->arrsay[] = "PRIVMSG $cible :".chr(1)."ACTION $msg".chr(1)."\r\n"; // empiler
	}

	function notice($pseudo, $msg){ // dire en privé à qq1
		if($this->connected)
			$this->arrsay[] = "NOTICE $pseudo :$msg\r\n"; // empiler
	}

	function voice($pseudo, $chan, $off = false){ // +v ou -v
		if ($off !== false) $mode = '-v'; else $mode = '+v';
		$this->arrsay[] = "MODE $chan $mode $pseudo \r\n"; // empiler
	}

	function op($pseudo, $chan, $off = false){ // +o ou -o
		if ($off !== false) $mode = '-o'; else $mode = '+o';
		$this->arrsay[] = "MODE $chan $mode $pseudo \r\n"; // empiler
	}

	function ban($pseudo, $chan, $off = false){ // +b ou -b
		if ($off !== false) $mode = '-b'; else $mode = '+b';
		$this->arrsay[] = "MODE $chan $mode $pseudo \r\n"; // empiler
	}

	function unbanmeQ($chan = false){ // demander unban au bot Q
		if($chan == false) $chan = $this->chan;
		$this->say("unbanme $chan", 'Q');
		sleep(1);
		$this->join();
		return false;
	}

	function send($msg = false){ // envoyer une commande et/ou dépiler la file d'envoi
		static $max = 5; // nb maxi d'envoi simultané
		static $timesay = false;
		if($timesay === false) $timesay = time();

		if($msg !== false)
			$this->arrsay[] = "$msg\r\n"; // empiler

		// traiter la file d'envoi si pas trop rapide
		// MAXI 3 lignes par seconde
		if($timesay + 1 < time()){
			$timesay = time();
			$bool = $this->connected;
			if(count($this->arrsay) == 0){ // silencieux pendant + d'une seconde ?
				if($max < 5) $max++;
			}else{
				if(count($this->arrsay) >= $max) $max--; // stop le flood
				for($i = 1; $i <= $max; $i++) // envoie jusqu'à $max msg!
					if($bool && $msg = array_shift($this->arrsay)) {$bool = fputs($this->socket,$msg);echo $msg;}
				$this->connected = (bool) $bool;
			}
		}
	}

}
?>
