<?
class session
{
	var $sql;
	
	function session(&$db)
	{
		$this->sql = &$db; //objet de la classe mysql
	}
	
	function login($login, $pass, $passmd5 = false)
	{
		$login = htmlentities($login, ENT_QUOTES);

		if(!$passmd5)
		{
		$pass = md5($pass);
		}
		$pass = htmlentities($pass, ENT_QUOTES);

		$sql="SELECT mbr_mid,mbr_login,mbr_pseudo,mbr_lang,mbr_race,mbr_atq_nb,grp_droits,mbr_gid,mbr_decal,mbr_sign,mbr_population,mbr_points,mbr_mail,mbr_mapcid,mbr_etat,SUM(msg_not_readed) as msg_nb,mbr_alaid, UNIX_TIMESTAMP(mbr_lmodif_date) as mbr_lmodif_date";
		$sql.=",UNIX_TIMESTAMP(mbr_ldate + INTERVAL '".$this->sql->decal."' HOUR_SECOND) as mbr_ldate ";
		$sql.=" FROM ".$this->sql->prebdd."mbr";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."grp ON grp_gid=mbr_gid ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."msg ON msg_mid2=mbr_mid ";
		$sql.=" WHERE mbr_login='$login' AND mbr_pass='$pass' AND (mbr_etat = 1 OR mbr_etat = 3) GROUP BY mbr_mid";
		$req = $this->sql->make_array($sql);
		$req = $req[0];
		if(is_array($req))
		{
			$sesid = session_id();
			$mid = $req['mbr_mid'];
			$ip=divers::getip();
			$sql="DELETE FROM ".$this->sql->prebdd."ses WHERE ses_sesid='$sesid' OR ((ses_mid='$mid' AND ses_mid != 1) OR (ses_mid = '$mid' AND ses_ip = '$ip'))";
			$this->sql->query($sql);
			$sql="INSERT INTO ".$this->sql->prebdd."ses VALUES ('$sesid','$mid','$ip','".$_GET['file']."', NOW());";
			$this->sql->query($sql);
			
			$sql=" UPDATE ".$this->sql->prebdd."mbr SET mbr_lip = '$ip'";
			if($req['mbr_etat'] != 3)
			{
				$sql.=",mbr_ldate = NOW() ";
			}
			$sql.=" WHERE mbr_mid = '$mid'";
			$this->sql->query($sql);
			
			divers::set_cookie("zrd",array($login,$pass));
			$_SESSION['user'] = array(
					"mid"			=> $req['mbr_mid'],
					"login"		=> $req['mbr_login'],
					"pseudo"		=> $req['mbr_pseudo'],
					"pass"		=> $pass,
					"lang"		=> $req['mbr_lang'],
					"race"		=> $req['mbr_race'],
					"droits"		=> $req['grp_droits'],
					"groupe"		=> $req['mbr_gid'],
					"decal"		=> $req['mbr_decal'],
					"population"	=> $req['mbr_population'],
					"points"		=> $req['mbr_points'],
					"mail"		=> $req['mbr_mail'],
					"mapcid"		=> $req['mbr_mapcid'],
					"etat"		=> $req['mbr_etat'],
					"msg"		=> $req['msg_nb'] + 0,
					"lmodif"		=> $req['mbr_lmodif_date'],
					"sign"		=> $req['mbr_sign'],
					"ldate"		=> $req['mbr_ldate'],
					"regen"		=> true,
					"atqnb"		=> $req['mbr_atq_nb'],
					"ip"			=> $ip,
					"alaid" 		=> $req['mbr_alaid'],
					);
			
			$_SESSION['forum']['ldate'] = $req['mbr_ldate'];
			$_SESSION['forum']['lus'] = array();
			
			if($_SESSION['user']['login'] == "guest")
			{
				$_SESSION['user']['loged'] = false;
				$_SESSION['user']['lang'] = divers::get_lang();
			}else{
				$_SESSION['user']['loged'] = true;
			}
			return true;
		}else{
			return false;		
		}
	}
	
	function logout($no_relog = false)
	{
		unset($_SESSION);
		divers::del_cookie("zrd");
		$this->sql->query("DELETE FROM ".$this->sql->prebdd."ses WHERE ses_sesid='".session_id()."'");
		session_destroy();
		session_start();
		if(!$no_relog)
		{
			return  $this->auto_login();
		}else{
			return true; 
		}
	}
	
	function auto_login()
	{
		if(isset($_COOKIE['zrd']))
		{
			$zrd = divers::read_cookie('zrd');

			if(isset($zrd[0]) and isset($zrd[1]))
			{
				if($this->login(html_entity_decode($zrd[0], ENT_QUOTES), html_entity_decode($zrd[1], ENT_QUOTES), true))
		  		{
		  			 return true;
		  		}else{
		  			 return $this->login("guest","guest");
		  		}
		 	}else{
		 	  	$this->logout(true);
		 	  	return $this->login("guest","guest");
		 	}
		}else{
		  $this->logout(true);
		  return  $this->login("guest","guest");
		}
	}
	
	function del_old()
	{
		$sql="DELETE FROM ".$this->sql->prebdd."ses WHERE ";
		$sql.="ses_ldate < (NOW() - INTERVAL 300 SECOND)";
		return $this->sql->query($sql);
	}
	
	function update($sesid, $login, $pass, $act)
	{
		$login = html_entity_decode(htmlentities($login, ENT_QUOTES), ENT_QUOTES);

		$act = htmlentities($act, ENT_QUOTES);
		
		//Verification de changement, si pas de changement, on fait pas la grosse requette :)
		$sql="SELECT UNIX_TIMESTAMP(mbr_lmodif_date) FROM ".$this->sql->prebdd."mbr WHERE mbr_login = '$login' AND mbr_pass='$pass'";
		$lmodif = (int) @mysql_result($this->sql->query($sql), 0);
		
		
		if(!$lmodif OR $lmodif > $_SESSION['user']['lmodif']) //une modif, on reprend tout
		{
			$sql="SELECT mbr_mid,mbr_pseudo,mbr_login,mbr_atq_nb,mbr_lang,mbr_race,grp_droits,mbr_gid,mbr_decal,mbr_sign,mbr_population,mbr_points,mbr_mail,mbr_mapcid,mbr_etat,SUM(msg_not_readed) as msg_nb,mbr_alaid,UNIX_TIMESTAMP(mbr_lmodif_date) as mbr_lmodif_date ";
			$sql.=",UNIX_TIMESTAMP(mbr_ldate + INTERVAL '".$this->sql->decal."' HOUR_SECOND) as mbr_ldate ";
			$sql.=" FROM ".$this->sql->prebdd."ses";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid=ses_mid";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."grp ON grp_gid=mbr_gid ";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."msg ON msg_mid2=mbr_mid ";
			$sql.=" WHERE ses_sesid = '$sesid' AND mbr_login='$login' AND mbr_pass='$pass' AND (mbr_etat = 1 OR mbr_etat = 3) GROUP BY mbr_mid";
		}
		else //on se sert du cache :)
		{
			$sql="SELECT mbr_mid,grp_droits,SUM(msg_not_readed) as msg_nb,mbr_alaid ";
			$sql.=" FROM ".$this->sql->prebdd."ses";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid=ses_mid";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."grp ON grp_gid=".$_SESSION['user']['groupe']." ";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."msg ON msg_mid2=mbr_mid ";
			$sql.=" WHERE ses_sesid = '$sesid' GROUP BY mbr_mid";
		}
		$req=$this->sql->make_array($sql);
		$req = $req[0];
		if(is_array($req))
		{
			$mid = $req['mbr_mid'];
			$ip=divers::getip();
			$sql="UPDATE ".$this->sql->prebdd."ses SET ses_mid='$mid', ses_ip='$ip',ses_lact='$act',ses_ldate=NOW() WHERE ses_sesid='$sesid'";
			$this->sql->query($sql);
			
			if($lmodif > $_SESSION['user']['lmodif']) //une modif, on reprend tout
			{
				divers::set_cookie("zrd",array($login,$pass));
				$_SESSION['user'] = array(
					"mid"			=> $req['mbr_mid'],
					"login"		=> $req['mbr_login'],
					"pseudo"		=> $req['mbr_pseudo'],
					"pass"		=> $pass,
					"lang"		=> $req['mbr_lang'],
					"race"		=> $req['mbr_race'],
					"droits"		=> $req['grp_droits'],
					"decal"		=> $req['mbr_decal'],
					"groupe"		=> $req['mbr_gid'],
					"population"	=> $req['mbr_population'],
					"points"		=> $req['mbr_points'],
					"mail"		=> $req['mbr_mail'],
					"sign"		=> $req['mbr_sign'],
					"mapcid"		=> $req['mbr_mapcid'],
					"lmodif"		=> $lmodif,
					"etat"		=> $req['mbr_etat'],
					"msg"		=> $req['msg_nb'] + 0,
					"ip"			=> $ip,
					"atqnb"		=> $req['mbr_atq_nb'],
					"regen"		=> true,
					"alaid" 		=> $req['mbr_alaid'],
					"ldate"		=> $req['mbr_ldate'],
					);
			}
			else
			{
				$_SESSION['user']['droits'] = $req['grp_droits'];
				$_SESSION['user']['msg'] = $req['msg_nb'] + 0;
				$_SESSION['user']['regen'] = false;
			}		
			if($_SESSION['user']['login'] == "guest")
			{
				$_SESSION['user']['loged'] = false;
				$_SESSION['user']['lang'] = divers::get_lang();
			}else{
				$_SESSION['user']['loged'] = true;
			}
			return true;
		}else{
			return false;		
		}	
	}
	
	//Nombre de membres
	function nb_online()
	{
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."ses WHERE ses_mid != 1 ";
		return mysql_result($this->sql->query($sql),0);
	}
	
	//liste
	function get_liste($limite1, $limite2)
	{
		$limite1 = (int) $limite1;
		$limite2 = (int) $limite2;

		$sql="SELECT ";
		$sql.="mbr_etat,mbr_alaid,mbr_gid,mbr_mid,mbr_pseudo,mbr_race,mbr_population,mbr_gid,ses_ip,ses_lact,mbr_points,ses_mid,mbr_lang,formatdate(ses_ldate) as ses_ldate ";
		$sql.=" FROM ".$this->sql->prebdd."ses ";	
		$sql.="LEFT JOIN ".$this->sql->prebdd."mbr ON ses_mid=mbr_mid ";
		$sql.= "WHERE mbr_mid != 1 ORDER BY ses_ldate DESC LIMIT $limite1, $limite2";
		return $this->sql->make_array($sql);
	}
	
}
?>
