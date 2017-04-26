<?php
class session
{
	var $sql;
	var $vars;
	
	function __construct(&$db)
	{
		$this->sql = &$db; //objet de la classe mysql
		if(!CRON) $this->vars = & $_SESSION['user'];
	}

	function __destruct()
	{
		if(!CRON) $_SESSION['user'] = $this->vars;
	}

	function set_cookie($login, $pass) {
		if(CRON) return true;
		else return setcookie("zrd",serialize(array($login,$pass)), time() + 60 * 60 * 24 * 7);
	}

	function del_cookie()
	{
		if(CRON) return true;
		$_COOKIE["zrd"] = array();
		return setcookie("zrd", "", -1);
	}
	
	function id() {
		if(CRON) return $this->get('sesid');
		else return session_id();
	}
	
	function login_as_guest() {
		return $this->login("guest","guest");
	}
	
	function session_opened() {
		return !empty($this->vars);
	}
	
	function get_vars() {
		return empty($this->vars) ? false : $this->vars;
	}
	
	function set($name, $value) {
		//$_SESSION['user'][$name] = $value;
		$this->vars[$name] = $value;
	}
	
	function get($name) {
		return isset($this->vars[$name]) ? $this->vars[$name] : false;
	}
	
	function init_vars() {
		$this->vars = array();
		//$_SESSION['user'] = array();
	}
	
	function set_vars($mbr_infos) {
		$this->set("mid",$mbr_infos['mbr_mid']);
		$this->set("login", $mbr_infos['mbr_login']);
		$this->set("pseudo", $mbr_infos['mbr_pseudo']);
		$this->set("vlg", $mbr_infos['mbr_vlg']);
		$this->set("pass", $mbr_infos['mbr_pass']);
		$this->set("lang", $mbr_infos['mbr_lang']);
		$this->set("race", $mbr_infos['mbr_race']);
		$this->set("droits", get_droits($mbr_infos['mbr_gid']));
		$this->set("groupe", $mbr_infos['mbr_gid']);
		$this->set("decal", $mbr_infos['mbr_decal']);
		$this->set("place", $mbr_infos['mbr_place']);
		$this->set("population", $mbr_infos['mbr_population']);
		$this->set("points", $mbr_infos['mbr_points']);
		$this->set("pts_arm",$mbr_infos['mbr_pts_armee']);
		$this->set("mail", $mbr_infos['mbr_mail']);
		$this->set("mapcid", $mbr_infos['mbr_mapcid']);
		$this->set("etat", $mbr_infos['mbr_etat']);
		$this->set("lmodif", $mbr_infos['mbr_lmodif_date']);
		$this->set("sign", $mbr_infos['mbr_sign']);
		$this->set("ldate", $mbr_infos['mbr_ldate']);
		$this->set("regen", true);
		$this->set("atqnb", $mbr_infos['mbr_atq_nb']);
		if(CRON) $this->set("ip", $mbr_infos['mbr_lip']);
		else     $this->set("ip", get_ip());
		$this->set("design", $mbr_infos['mbr_design']);
		$this->set("parrain", $mbr_infos['mbr_parrain']);
		$this->set("numposts", $mbr_infos['mbr_numposts']);

		/* Visiteur */
		if($this->get("login") == "guest") {
			$this->set("loged", false);
			$this->set("lang", get_lang());
		} else
			$this->set("loged", true);
	}
	
	function update_vars() {
		$this->update_grp();
		$this->update_msg();

		/* Session prise a partir du cache */
		$this->set("regen", false);
	}

	function update_grp() {
		$gid = $this->get("groupe");
		$this->set("droits", get_droits($gid));
	}

	function update_msg() {
		$mid = $this->get("mid");
		
		/* Nouveaux messages */
		if($this->get("login") != "guest") {
			$sql="SELECT COUNT(*) AS nb FROM ".$this->sql->prebdd."msg_rec JOIN ".$this->sql->prebdd."mbr ON mrec_from = mbr_mid WHERE mrec_mid = $mid AND mrec_readed = 0";
			$result = $this->sql->make_array_result($sql);
			$this->set("msg", $result['nb']);
		}
	}

	function update_heros() {
		$mid = $this->get("mid");
		
		if($this->get("login") != "guest") {
			/* si on a un héros ? et une compétence active ? */
			$sql = "SELECT hro_id, hro_nom, hro_type, hro_lid, hro_xp, hro_vie, 
				hro_bonus AS bonus, hro_bonus_from, hro_bonus_to AS bonus_to ";
			$sql.= "FROM ".$this->sql->prebdd."hero ";
			$sql.= "WHERE hro_mid = $mid";
			$result = $this->sql->make_array($sql);

			if(!$result){ // aucun héros
				$this->set('hro_id', 0);
				$this->set("hro_nom", null);
				$this->set("hro_type", null);
				$this->set("hro_lid", null);
				$this->set("hro_xp", null);
				$this->set("hro_vie", null);
				$this->set("bonus", null);
				$this->set("hro_bonus_from", null);
				$this->set("hro_bonus_to", null);
			} else { // placer en session toutes les infos du héros
				foreach($result[0] as $key => $value)
					$this->set($key, $value);
				$this->set('hro_vie_conf', get_conf_gen($this->get('race'), 'unt', $result[0]['hro_type'], 'vie'));
			}
		}
	}
	
	function update_aly() {
		$mid = $this->get("mid");
		
		$this->set("alaid", 0);
		$this->set("aetat", ALL_ETAT_NULL);
		$this->set("achef", false);
		
		/* alliance */
		if($this->get("login") != "guest") {
			$sql = "SELECT ambr_aid, ambr_etat, al_mid, al_name ";
			$sql.= "FROM ".$this->sql->prebdd."al_mbr ";
			$sql.= "INNER JOIN ".$this->sql->prebdd."al ON ambr_aid = al_aid ";
			$sql.= "WHERE ambr_mid = $mid"; //AND ambr_etat <> ".ALL_ETAT_DEM;
			
			$array = $this->sql->make_array($sql);
			if($array) {
				$this->set("alaid", $array[0]['ambr_aid']);
				$this->set("aetat", $array[0]['ambr_etat']);
				$this->set("achef", $array[0]['al_mid']);
			}
		}
	}
	
	function update_pos() {
		$mapcid = $this->get("mapcid");

		if($mapcid) {
			$sql = "SELECT map_x, map_y FROM ".$this->sql->prebdd."map WHERE map_cid = $mapcid";
			$map_array = $this->sql->make_array($sql);
			if($map_array) {
				$this->set("map_x", $map_array[0]['map_x']);
				$this->set("map_y", $map_array[0]['map_y']);
			}
		}
	}

	/* Trucs spécifiques a certains modules */
	function set_forum_vars($ldate) {
		/* Pour le forum */
		$this->set("forum_ldate", $ldate);
		$this->set("forum_lus", array());
	}
	
	function crypt($login, $pass) {
		return md5($login.strrev($pass));
	}
	
	function login($login, $pass, $raw = false)
	{
		$login = protect($login, "string");

		/* $pass est censé être le mot de passe en md5 */
		if(!$raw) $pass = $this->crypt($login, $pass);
		
		$sql="SELECT mbr_mid,mbr_login,mbr_pseudo,mbr_vlg,mbr_pass,mbr_lang,mbr_race,
			mbr_atq_nb,mbr_gid,mbr_decal,mbr_sign,mbr_population,mbr_place,
			mbr_points,mbr_pts_armee,mbr_mail,mbr_mapcid,mbr_etat,mbr_design,mbr_parrain,mbr_numposts,mbr_lip,
			UNIX_TIMESTAMP(mbr_lmodif_date) as mbr_lmodif_date";
		$sql.=",UNIX_TIMESTAMP(mbr_ldate + INTERVAL '".$this->sql->decal."' HOUR_SECOND) as mbr_ldate ";
		$sql.=" FROM ".$this->sql->prebdd."mbr";
		$sql.=" WHERE mbr_login='$login' AND mbr_pass='$pass'";
		$req = $this->sql->make_array($sql);

		if($req)
		{
			$req = $req[0];
			
			$mid = $req['mbr_mid'];
			$this->set('mid',$mid);

			if(CRON) { /* récupérer la session WEB active si existe */
				$sql="SELECT * FROM ".$this->sql->prebdd."ses WHERE ses_mid = $mid";
				$resultat = $this->sql->make_array($sql);
				if($resultat){ // déjà co sur web
					$this->set('sesid', $resultat[0]['ses_sesid']);
					$this->set('ip', $resultat[0]['ses_ip']);
					return $this->update('irc');
				}else{ // créer une session CRON
					$ip = $req['mbr_lip']; // dernière ip connue
					$sesid = genstring(26);
				}
			}else{					
				$sesid = $this->id();
				$ip = get_ip();
			}

			/* On vire les anciennes sessions qu'il pouvait avoir */
			$sql = "DELETE FROM ".$this->sql->prebdd."ses ";
			$sql.= "WHERE ses_sesid='$sesid' ";
			//$sql.= "OR (ses_mid = '$mid' AND ses_ip = '$ip') ";
			$sql.= "OR (ses_mid='$mid' AND ses_mid != 1 AND ses_ip != '$ip') ";

			$this->sql->query($sql);
			
			/* On en remet une, en disant qu'il est sur la page session */
			$sql="INSERT INTO ".$this->sql->prebdd."ses VALUES ('$sesid','$mid','$ip','session', NOW(),0);";
			$this->sql->query($sql);
			
			if($login != "guest" and !CRON) {
			/* Sa derniere ip ..  la dernière fois qu'il s'est connecté -> dans zrd_mbr */
				$sql=" UPDATE ".$this->sql->prebdd."mbr SET mbr_lip = '$ip'";
				if($req['mbr_etat'] != MBR_ETAT_ZZZ) { /* Seulement si pas en veille */
					$sql.=",mbr_ldate = NOW() ";
				}
				$sql.=" WHERE mbr_mid = '$mid'";
				$this->sql->query($sql);
				
			/* On rajoute son ip et la date_heure dans zrd_mbr_log à chaque changement d'ip. 
			   Les anciennes ip sont conservées. */
				$sql="SELECT mlog_ip";
				$sql.=" FROM ".$this->sql->prebdd."mbr_log";
				$sql.=" WHERE mlog_mid = $mid";
				$sql.=" ORDER BY mlog_date DESC LIMIT 0,1";
				$req2 = $this->sql->make_array($sql);
				
				if ( (!isset($req2[0])) || ($ip != $req2[0]['mlog_ip']) ){
					$sql="INSERT INTO ".$this->sql->prebdd."mbr_log";
					$sql.=" (mlog_id , mlog_mid , mlog_ip , mlog_date)";
					$sql.=" VALUES (NULL , '$mid', '$ip', NOW() )";
					$this->sql->query($sql);
				}
			}
			
			$this->init_vars();
			$this->set_vars($req);
			$this->set_forum_vars($req['mbr_ldate']);
			$this->update_msg();
			$this->update_heros();
			$this->update_aly();
			$this->update_pos();

			if($login != "guest")
				$this->set_cookie($login, $pass);

			return $this->get_vars();
		}else{
			return false;		
		}
	}
	
	function logout()
	{
		$this->sql->query("DELETE FROM ".$this->sql->prebdd."ses WHERE ses_sesid='".$this->id()."'");
		if(!CRON){ // interdit en CLI
			unset($_SESSION);
			$this->del_cookie();
			session_destroy();
			session_start();
		}
		return true;
	}
	
	function auto_login()
	{
		$zrd = request("zrd", "array", "cookie");
		if(count($zrd) == 2)
		{
			$login = $zrd[0];
			$pass = $zrd[1];
			if($this->login($login, $pass, true))
		  		 return true;
		  	else
				return $this->login_as_guest();
		 } else {
		   	$this->logout();
		   	return $this->login_as_guest();
		 }
	}
	
	function update($act)
	{
		$mid = $this->get("mid");
		$pass = $this->get("pass");
		$login = $this->get("login");
		$sesid = $this->id();
		$act = protect($act, "string");
		
		/* Est ce que la ligne a changée depuis la dernière fois ? on peut utiliser mid, parce que si elle est pas changée, elle a pas changée :D 
		   Par contre, si on vient de régénérer la session, il ne faut pas verifier la date, puisqu'on vient de la changer !
		*/
		$sql="SELECT UNIX_TIMESTAMP(mbr_lmodif_date) FROM ".$this->sql->prebdd."mbr WHERE mbr_mid = $mid";
		$res = $this->sql->query($sql);

		if(!$this->sql->num_rows($res)) 
			return false;
		
		$lmodif = $this->sql->result($res, 0);
		
		/* Mise a jour des sessions */
		$rand = gettimeofday(); /* Pour être sur de metre a jour */
		$rand = $rand['usec'];
		$sql="UPDATE ".$this->sql->prebdd."ses SET ses_lact = '$act', ses_ldate = NOW(), ses_rand = $rand WHERE ses_sesid = '$sesid'";
		$this->sql->query($sql);
		if(!$this->sql->affected_rows()) {
			if(!CRON) { // on peut etre connecté à la fois sur IRC et sur le jeu
				$sql = "SELECT COUNT(*) FROM ".$this->sql->prebdd."ses WHERE ses_mid = $mid ";
				if($this->sql->result($this->sql->query($sql), 0)) /* On est connecté ailleur, donc on part .... */
					$this->del_cookie();
			}
			/* Sinon, c'est juste qu'on a pas touché a la page depuis longtemps, mais qu'on a laissé le nav ouvert */
			return false;
		}	
		
		if(!CRON and (!$lmodif OR $lmodif > $this->get("lmodif"))) /* une modif, on reprend tout - sauf CRON */
		{
			$sql="SELECT mbr_mid,mbr_pseudo,mbr_vlg,mbr_login,mbr_pass,mbr_atq_nb,mbr_lang,mbr_race,mbr_gid,mbr_decal,
					mbr_sign,mbr_population,mbr_place,mbr_points,mbr_pts_armee,mbr_mail,mbr_mapcid,mbr_etat,
					mbr_design,mbr_parrain,mbr_numposts";
			$sql.=",UNIX_TIMESTAMP(mbr_ldate + INTERVAL '".$this->sql->decal."' HOUR_SECOND) as mbr_ldate ";
			$sql.=" FROM ".$this->sql->prebdd."ses";
			$sql.=" JOIN ".$this->sql->prebdd."mbr ON ses_sesid = '$sesid'";
			$sql.=" WHERE mbr_login='$login' AND mbr_pass='$pass' GROUP BY mbr_mid";
			
			$req = $this->sql->make_array($sql);
			
			if(!$req) {
				return false;
			} else {
				$req = $req[0];
				$req['mbr_lmodif_date'] = $lmodif;
				$this->set_cookie($login,$pass);
				$this->set_vars($req);
				$this->update_msg();
				$this->update_pos();
				$this->update_heros();
				$this->update_aly();
				
				return true;
			}
		} else {
			//on se sert du cache :)
			$this->update_vars();
			return true;
		}
	}
}

function del_old_ses()
{
	global $_sql;
	
	$sql = "DELETE FROM ".$_sql->prebdd."ses WHERE ";
	$sql.= "ses_ldate < (NOW() - INTERVAL 300 SECOND)";
	return $_sql->query($sql);
}

/* Nombre de membres en ligne */
function nb_online()
{
	global $_sql;
	
	$sql = "SELECT COUNT(*) FROM ".$_sql->prebdd."ses ";
	$sql.= "JOIN ".$_sql->prebdd."mbr ON mbr_mid = ses_mid ";
	$sql.= "WHERE ses_mid != 1 AND mbr_etat = ".MBR_ETAT_OK;
	return $_sql->query($sql);
}
	
function is_online($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	
	$sql = "SELECT COUNT(*) FROM ".$_sql->prebdd."ses WHERE ses_mid = $mid";
	return $_sql->query($sql);
}

/* Liste */
function get_liste_online($limite1, $limite2)
{
	global $_sql;
	
	$limite1 = protect($limite1, "uint");
	$limite2 = protect($limite2, "uint");

	$sql = "SELECT ";
	$sql.= "mbr_etat,mbr_gid,mbr_mid,mbr_pseudo,mbr_mapcid,mbr_race,mbr_population,mbr_place,";
	$sql.= "mbr_gid,ses_ip,ses_lact, mbr_points,mbr_pts_armee, ses_mid,mbr_lang,";
	$sql.= "DATE_FORMAT(MAX(ses_ldate) + INTERVAL '".$_sql->decal."' HOUR_SECOND,'".$_sql->dateformat."') as ses_ldate,";
	$sql.= " ambr_etat, IF(ambr_etat=".ALL_ETAT_DEM.", 0, IFNULL(ambr_aid,0)) as ambr_aid, ";
	$sql.= " IF(ambr_etat=".ALL_ETAT_DEM.", NULL, al_name) as al_name  ";
	$sql.= " FROM ".$_sql->prebdd."ses ";	
	$sql.= " JOIN ".$_sql->prebdd."mbr ON ses_mid=mbr_mid ";
	$sql.= " LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
	$sql.= " LEFT JOIN ".$_sql->prebdd."al ON al_aid = ambr_aid ";
	$sql.= "WHERE mbr_mid != 1 AND mbr_etat = ".MBR_ETAT_OK." ";
	$sql.= "GROUP BY ses_mid ";
	$sql.= "ORDER BY ses_ldate DESC LIMIT $limite1, $limite2";

	return $_sql->make_array($sql);
}
?>
