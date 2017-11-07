<?php
error_reporting (E_ALL | E_STRICT | E_RECOVERABLE_ERROR);

$donnees = ":Q!TheQBot@CServe.quakenet.org NOTICE Barnabe :Remember: NO-ONE from QuakeNet will ever ask for your password.  NEVER send your password to ANYONE except Q@CServe.quakenet.org.";
//$donnees = ":pifou!~chatzilla@vll06-3-78-224-176-67.fbx.proxad.net MODE #pifou +vo pifou Barnabe";

				$pos = strpos($donnees, ':')+1;
				$ping = trim(substr($donnees, 0, $pos-1));

				$posa = strpos($donnees, '!', $pos)+1;
				$pseudo = trim(substr($donnees, $pos, $posa-$pos-1));
				
				$posb = strpos($donnees, '@', $posa)+1;
				$user = trim(substr($donnees, $posa, $posb-$posa-1));
				
				$posc = strpos($donnees, ' ', $posb)+1;
				$host = trim(substr($donnees, $posb, ($posc-$posb-1)));

echo substr(':Q!TheQBot@CServe.quakenet.org NOTICE Barnabe', 11, 19)."\n";
echo ($posc-$posb-1);
echo "\n$donnees\n";
echo "trim(substr('donnes', $posb, $posc-$posb-1))=$host
";					
				$posd = strpos($donnees, ' ', $posc)+1;
				$irccmd = trim(substr($donnees, $posc, $posd-$posc-1));
				
				$pose = strpos($donnees, ' ', $posd);
				if($pose === false) $pose = strlen($donnees); // fin après cible
				else $pose++;
				$pos2 = strpos($donnees, ':', $posd); // existe 2 partie botcmd & msg ?
				if($pos2 === false) $pos3 = strlen($donnees);
				else $pos3 = $pos2 + 1;
				if($pose > $pos3) $pose = $pos3; // pas dépasser la fin
echo "\n*$pose* *$pos2* *$pos3*\n";

				$cible = trim(substr($donnees, $posd, $pose-$posd-1));

				$ircarg = ($pose < $pos3 ? trim(substr($donnees, $pose, $pos3-$pose-1)) : '');

				if($pos2 === false){
					$msg = substr($donnees, $pos); // répete tt les infos
					print_r( array(
							'ping'	=> $ping,
							'pseudo'	=> $pseudo,
							'user'	=> $user,
							'host'	=> $host,
							'irccmd'	=> $irccmd, 
							'chan'	=> $cible, 
							'ircarg'	=> $ircarg,
							'botcmd'	=> '',
							'msg'		=> $msg));
				}else{
					$pos2++;
					if($pose === false or $pose > $pos2)
						$pose = $pos2;
					else
						$pose++;


					
					if(substr($donnees, $pose, 1) == '!') // commande
						$pos3 = strpos($donnees, ' ', $pos2)+1;
					else $pos3 = false;
					$botcmd = ($pos3 ? trim(substr($donnees, $pos2, $pos3-$pos2-1)) : '');
					$msg = ($pos3 ? trim(substr($donnees, $pos3)) : trim(substr($donnees, $pos2)));

echo "$pos-$posa-$posb-$posc-$posd-$pose-$pos3";
					print_r( array(
							'ping'	=> $ping,
							'pseudo'	=> $pseudo,
							'user'	=> $user,
							'host'	=> $host,
							'irccmd'	=> $irccmd, 
							'chan'	=> $cible, 
							'ircarg'	=> $ircarg,
							'botcmd'	=> $botcmd,
							'msg'		=> $msg));
				}

?>
