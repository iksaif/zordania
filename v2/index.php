<?php
session_start();
ignore_user_abort();
error_reporting (E_ALL | E_STRICT | E_RECOVERABLE_ERROR);
date_default_timezone_set("Europe/Paris");
define("_INDEX_",true);

/* Fonctions de Bench */
function mtime()
{
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
}

function mark($title_or_get)
{
	static $array = array();

	if($title_or_get === true)
		return $array;
	else {
		$array[$title_or_get] = mtime();
		return true;
	}
}

$t1 = mtime();
mark('start');

/* Includes généraux */
require_once("conf/conf.inc.php");
ini_set("include_path", SITE_DIR);

require_once("lib/divers.lib.php");
$_cache = new cache('global');
/*  infos admin en cache : variable globale */
$admin_cache = new cache('admin');

/* Gestion des erreurs : fonctions dans lib/divers.lib.php */
$_error = array();
set_error_handler("error_handler");

mark('lib');

/*
* Templates
*/
$_tpl = new Template();
$_tpl->set_dir('../templates');

/* display : xhtml - module - ajax - popup - xml */
$_display = request("display", "string", "get", "xhtml"); /* Type d'affichage */
$_tpl->set_ref("_display", $_display);
$_tpl->set_ref("_races", $_races);
$_tpl->set_ref("_races_aly", $_races_aly);
$_tpl->set_ref("_def_atq", $_def_atq);
$_tpl->set_ref("_langues", $_langues);
$_tpl->set("_cache", $_cache->get_array());

$_tpl->set('no_cookies',!$_COOKIE);

/*
* MySQL
*/
$_sql = new mysqliext(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

mark('mysql');

if(!$_sql->con) /* Utiliser Display = module */
{
	$_tpl->set_lang('all');
	$_tpl->set('page','mysql_error.tpl');
	if(!$_display != "xml")
		echo $_tpl->get('index.tpl',1);

	exit;
}

/*
* Sessions
*/
$_ses = new session($_sql);
$_file = request("file", "string", "get", "news");
$_type = request("type", "string", "get");
$_act = request("act", "string", "get");
$_sub = request("sub", "string", "get");

/* pour le fichier html de verification google */
if($_file == 'google0ae71ec825ebe77e')
	die(file_get_contents(WWW_DIR.$_SERVER['REQUEST_URI']));

// marquer l'environnement dans $_sql
$_sql->env = $_file.($_act?'-'.$_act:'').'.html';
if ($_sub) $_sql->env .= '?sub='.$_sub;

if($_file == "session" AND ($_act == "login" OR $_act == "logout"))
	$log_in_out = true;
else
	$log_in_out = false;

/* Si c'est la première fois qu'on vient, on se connecte automatiquement*/
if(!$_ses->session_opened()) {
	if(!$_ses->auto_login()) die( "Erreur auto-login");
} elseif(!$log_in_out) { /* Sinon, si on est sur une page normale */
	if(!$_ses->update($_file)) { /* On maj la session */
		if(!$_ses->auto_login()) die( "Erreur auto-login"); /* Ca a merdé .. on tente de se connecter en n'importe quoi */
	}
}

$_user = & $_ses->vars;
if($_file == "connec" && $_user["loged"]) {
	$_file = "news";
}

mark('ses');

/* Historique */
$_histo = new histo($_sql);

if(SITE_TRAVAUX && !can_d(DROIT_ADM_TRAV))
{
	//die( "DROIT $_file $_act $cron_lock");
	$_ses->logout();
	$_tpl->set('sv_site_debug', false);
	$_tpl->set("cfg_url",SITE_URL);
	$_tpl->set_lang('all');
	$_tpl->set('page','tests.tpl');
	echo $_tpl->get('index.tpl',1);
	exit;
}

/*
* Petit trucs a faire une fois qu'on a $_user
*/
$_sql->set_dbdecal($_user['decal']);
$_tpl->set_lang($_user['lang']);
$_tpl->set_ref('_user',$_user);
$_tpl->set('_file',$_file);

/*
* Conf
*/
$_conf = array(); /* Inutile de la charger, get_conf s'en charge ! */

/*
* Affichage
*/
if(file_exists(SITE_DIR.'logs/cron.lock'))
	$cron_lock = nl2br(file_get_contents(SITE_DIR.'logs/cron.lock'));
else
	$cron_lock = "";

$_tpl->set("cron_lock",$cron_lock);

/* Const */
$const = get_defined_constants(true);
$_tpl->set($const['user']);

/* Config */
$_tpl->set("cfg_url",SITE_URL);
$_tpl->set("cfg_style",request("style", "string", "cookie", "Marron"));
$_tpl->set("zordlog_url",ZORDLOG_URL);
$_tpl->set("adsense_code",$_adsense_css[$_user['design']]);

/* Droits */
$_tpl->set("ses_loged", ($_user['login'] != "guest"));
$_tpl->set("ses_admin", can_d(DROIT_ADM));
$_tpl->set("ses_can_play", can_d(DROIT_PLAY));
$_tpl->set("ses_mbr_etat_ok", ($_user['etat'] == MBR_ETAT_OK));
$_tpl->set("ses_adm_msg", can_d(DROIT_ADM_MBR) && $admin_cache->msg_report > 0);


$lock_array = array('msg','forum','news','admin','404','manual','faq','irc','a_propos','notes','bonus','session');

if(preg_match("/(http|ftp|\/|\.)/i",$_file))
	$_file = "404";

/* header utf-8 pour tout le site */
$charset = "utf-8"; // iso-8859-1
$_tpl->set("charset", $charset);

if($_display == "xml") { /* Sortie en XML */
	header("Content-Type: application/xml; charset=$charset");
	$filen = SITE_DIR."modules/".$_file."/xml.php";

	if(!file_exists($filen))
		exit;

	require_once($filen);
	mark($_file);

	if($_type != "ajax"){
		echo $_tpl->get($_module_tpl,1);
	}
	mark('tpl');
} else if($_display == "json") {
	if($_user['etat'] != MBR_ETAT_ZZZ and $_user['etat'] != MBR_ETAT_INI and !$cron_lock) {
		header("Content-Type: application/json; charset=$charset");
		$filen = SITE_DIR."modules/".$_file."/json.php";

		if(!file_exists($filen))
			exit;

		require_once($filen);
		mark($_file);

		if($_type != "ajax"){
			echo $_tpl->get($_module_tpl,1);
		}
		mark('tpl');
	}
} else if($_display == "ajax") {
	if($_user['etat'] == MBR_ETAT_ZZZ || $_user['etat'] == MBR_ETAT_INI and !$cron_lock)
		exit;
		
	header("Content-Type: text/html; charset=$charset");
	if(!$cron_lock || in_array($_file,$lock_array)) {
		$filen = SITE_DIR."modules/".$_file."/page.php";

		if(!file_exists($filen)) {
			$_file = "404";
			require_once(SITE_DIR."modules/404/page.php");
		} else
			require_once($filen);

		mark($_file);
	}

	$_tpl->set('module',$_file);
	$_tpl->set("cant_view_this",!can_d(DROIT_SITE));
	echo $_tpl->get("ajax.tpl",1);
	mark('tpl');
} else {
	header("Content-Type: text/html; charset=$charset");
	
	if($_file != "session") {
		if($_user['etat'] == MBR_ETAT_ZZZ)
			$_file = 'zzz';
		else if($_user['etat'] == MBR_ETAT_INI) {
			$ok = array('ini', 'carte', 'manual', 'inscr', 'forum', 'a_propos', 'sdg', 'news', 'stat', 'member', 'parrain', 'irc', 'notes', 'msg', 'histo');
			if(!in_array($_file, $ok))
				$_file = 'ini';
		}
	}
	
	// var contenant des infos de débugage ! $debugvars
	$_debugvars = array();
	$_tpl->set_ref('debugvars', $_debugvars);

	if(!$cron_lock || in_array($_file,$lock_array)) {
		$filen = SITE_DIR."modules/".$_file."/page.php";

		if(!file_exists($filen)) {
			$_file = "404";
			require_once(SITE_DIR."modules/404/page.php");
		} else
			require_once($filen);
		mark($_file);
	}

	$_tpl->set('module',$_file);

	require_once("include/stats.php");
	mark('stats');

	$_tpl->set("cant_view_this",!can_d(DROIT_SITE));

	$_tpl->set("sv_nbreq",$_sql->nbreq);
	$_tpl->set("sv_diff",$t1);

	if(SITE_DEBUG)
	{
		//$_histo->flush();
		$_tpl->set_globals();
		$_tpl->set('sv_site_debug',true);
		$_tpl->set('sv_total_sql_time',$_sql->total_time);
		$_tpl->set_ref('sv_queries',$_sql->queries);
		$t2 = mtime();
	}

	if($_file == "connec")
		echo $_tpl->get("connec.tpl", 1);
	else
		echo $_tpl->get("index.tpl",1);

	mark('tpl');

	if(SITE_DEBUG) {
		echo '<div class="debug"><ul>';
		foreach(mark(true) as $title => $time)
		{
			if(!isset($prev_time))
			$prev_time = $time;
			echo  "<li>$title: ".round($time-$prev_time, 5). "</li>";
			$prev_time = $time;
		}

		$total = (mtime() - $t1);
		$mysql = $_sql->total_time;
		$templ = (mtime() - $t2);
		$php = $total - $mysql - $templ;
		echo "<li>Mysql: ".$mysql."</li>";
		echo "<li>Templates: ".$templ."</li>";
		echo "<li>Php: ".$php."</li>";
		echo "<li>Total: ".$total."</li>";
		echo "</ul></div>";
	}
}

if(!empty($_error)) { // log des erreurs PHP
	$err_log = new log(SITE_DIR."logs/phperr/php_".date("d_m_Y").".log", "H:i:s", false);
	$err_log->text("****** Erreurs pour {$_user['pseudo']} ( {$_user['mid']} ) à ".date("H:i:s")." *****");
	foreach($_error as $key => $err){
		$err_log->text(error_print($err));
		if($key>4) {
			$err_log->text('Plus de 4 erreurs **** le reste ignoré *** '.count($_error));
			break;
		}
	}
	//$err_log->close();
}

/* Fin de la page */
//$_histo->flush();
//$_sql->close();
?>
