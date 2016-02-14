<?php

$donnees = array(

':servercentral.il.us.quakenet.org 376 Barnabe :End of /MOTD command.',
':servercentral.il.us.quakenet.org NOTICE Barnabe :on 1 ca 1(4) ft 20(20)',
':servercentral.il.us.quakenet.org 221 Barnabe +i',
':Barnabe!~zordania@falgoret.iksaif.net MODE Barnabe +i',

':Barnabe!~zordania@falgoret.iksaif.net JOIN #zordania',
':servercentral.il.us.quakenet.org 353 Barnabe = #zordania :Barnabe @kokotchy @pifou @tham @Q',

':servercentral.il.us.quakenet.org 366 Barnabe #zordania :End of /NAMES list.',
':Q!TheQBot@CServe.quakenet.org NOTICE Barnabe :[#zordania] Bienvenu sur le chan d un monde ... plus mauvais, plus méchant et plus destructeur !!',
':Q!TheQBot@CServe.quakenet.org MODE #zordania +o Barnabe',
':Q!TheQBot@CServe.quakenet.org NOTICE Barnabe :You are now logged in as zordania.',
':Q!TheQBot@CServe.quakenet.org NOTICE Barnabe :Remember: NO-ONE from QuakeNet will ever ask for your password.  NEVER send your password to ANYONE except Q@CServe.quakenet.org.',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net MODE #zordania +b *!*@falgoret.iksaif.net',
':Q!TheQBot@CServe.quakenet.org KICK #zordania Barnabe :Banned.',
':servercentral.il.us.quakenet.org 461 Barnabe JOIN :Not enough parameters',
':servercentral.il.us.quakenet.org 474 Barnabe #zordania :Cannot join channel, you are banned (+b)',
':servercentral.il.us.quakenet.org 404 Barnabe #zordania :Cannot send to channel',
':servercentral.il.us.quakenet.org 474 Barnabe #zordania :Cannot join channel, you are banned (+b)',
':Q!TheQBot@CServe.quakenet.org NOTICE Barnabe :Removed channel ban *!*@falgoret.iksaif.net from #zordania.',
':Q!TheQBot@CServe.quakenet.org NOTICE Barnabe :Done.',
':servercentral.il.us.quakenet.org 404 Barnabe #zordania :Cannot send to channel',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net PRIVMSG Barnabe :!login pifou ******',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net PRIVMSG Barnabe :!join #zordania',
'PING :port80b.se.quakenet.org',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net PRIVMSG #zordania :!quiz',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net PRIVMSG Barnabe :!join #zordania',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net PRIVMSG #zordania :HA !! :(',
':tham!~tham@f053149159.adsl.alicedsl.de PRIVMSG #zordania :bonne question barnabé',
':port80b.se.quakenet.org 421 Barnabe . :Unknown command',
':tham!~tham@f053149159.adsl.alicedsl.de PRIVMSG #zordania :pas celle de pifou pour une fois',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net MODE #zordania -ooo Barnabe kokotchy pifou',
':Q!TheQBot@CServe.quakenet.org MODE #zordania +o Barnabe',
':tham!~tham@f053149159.adsl.alicedsl.de PRIVMSG #zordania :oO',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net QUIT :Quit: ChatZilla 0.9.86 [Firefox 3.6.13/20101206121845]',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net JOIN #zordania',
':Q!TheQBot@CServe.quakenet.org MODE #zordania +o pifou',
':pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net NICK :petit_four',
':stockholm.se.quakenet.org 436 Barnabe barnabe :Nickname collision KILL',
'ERROR :Closing Link: Barnabe by stockholm.se.quakenet.org (Killed (*.quakenet.org (overruled by older nick)))',
':Iksaif!webchat@ip-83-141-148-53.evc.net PRIVMSG #zordania :ACTION Aldrien'
);


function get($donnees = false){ // lire msg du serveur. contient l'anti-kick-ban
//	if($donnees === false and $this->connected)
//		$donnees = fgets($this->socket, 1024);


	if($donnees) // format: "(ping):pseudo(!user@host) irccmd cible (ircarg):(botcmd) msg"
	{
		echo $donnees;

		$pos = strpos($donnees, ':')+1;
		$ping = trim(substr($donnees, 0, $pos-1));
		if($ping == 'PING'){/* gestion ping-pong */
			//$this->pong(substr($donnees, $pos));
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
/*
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
*/
		$botcmd = '';
		if($pos0 === false)
			$msg = substr($donnees, $pos); // répete tt les infos
		else{
			$msg = trim(substr($donnees, $pos0+1));
			if(strpos($msg, '!') === 0){ // commande
				$tmp1 = explode(' ', $msg, 2);
				$botcmd = $tmp1[0];
				$msg = isset($tmp1[1]) ? $tmp1[1] : '';
			}
		}
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

foreach($donnees as $tmp) print_r(get($tmp));

?>



