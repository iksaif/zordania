<?php

/************************************************************************
* Index - Base                                                          *
*                                                                       *
*                                                       11/01/04  00:26 *
*************************************************************************/

session_start();
ignore_user_abort();
date_default_timezone_set("Europe/Paris");

//*******************************//
// Classes - Include + Création  //
//*******************************//
include("lib/divers.class.php");
$sv_t1=divers::getmicrotime();

include("conf/conf.inc.php");
include("lib/mysql.class.php");
include("lib/tpl.class.php");
include("lib/session.class.php");

$_sql=new mysql(MYSQL_URL, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);
$_tpl=new Template();
$_div=new divers($_sql);
$_ses=new session($_sql);

$_tpl->set_dir('../templates');

//****************//
// Merde Mysql    //
//****************//
if(!$_sql->con)
{
	$_tpl->set_lang('all');
	$_tpl->set('page','mysql_error.tpl');
	echo $_tpl->get('index.tpl',1);
	exit;
}

//*******************************//
// Sessions     + detections     //
//*******************************//
//Si le type se log ou se delog
$_file = isset($_GET['file']) ? $_GET['file'] : "";
$_act = isset($_GET['act']) ? $_GET['act']  : "";
$_sub = isset($_GET['sub']) ? $_GET['sub'] : "";

if($_file == "session" AND ($_act == "login" OR $_act == "logout"))
		$log_in_out = true;
else
		$log_in_out = false;

//Si il est logué ou pas logué
if(isset($_SESSION['user']) and !$log_in_out)
{
	//Update de la session
	if(!$_ses->update(session_id(), $_SESSION['user']['login'], $_SESSION['user']['pass'], $_file))
	{
		//Autologin
		$_ses->auto_login();
	}
}

/* Antiflood moisis
*if(isset($_SESSION['time']) AND $_SESSION['time'] == time())
*	exit;
*/

//$_SESSION['time'] = time();

//Si toujours rien
if(!isset($_SESSION['user']))
{
	//Autologin
	$_ses->auto_login();
}

if(!$_COOKIE)
{
	$_tpl->set('no_cookies',true);
}

$_ses->del_old();

/*
$auto = array(8);
if(!in_array($_SESSION['user']['groupe'],$auto) AND $_COOKIE['yeah'] != 'sugus')
{
  //$_tpl->set_lang('all');
	//$_tpl->set('page','travaux.tpl');
	//$_tpl->set('page','tests.tpl');
	//$_tpl->set('page','fuckcliranet.tpl');
	//echo $_tpl->get('index.tpl',1);
  echo"Travaux pas encore finis :] ";
	exit;
}
*/
//*******************************//
// Defines                       //
//*******************************//
$_sql->set_dbdecal($_SESSION['user']['decal']);
define("_index_","ok");
if(!$_SESSION['user']['race']){ $_SESSION['user']['race'] = 0; }
$_tpl->set('GAME_RES_PLACE',GAME_RES_PLACE);
$_tpl->set('GAME_RES_BOUF',GAME_RES_BOUF);
$_tpl->set('ALL_MIN_PTS',ALL_MIN_PTS);
$_tpl->set('ZORD_VERSION',ZORD_VERSION);
$_tpl->set('session_user',$_SESSION['user']);

//*******************************//
// Conf  +    lang   + theme     //
//*******************************//
//Forcage de la langue
if(isset($_GET['force_lang']))
{
	divers::set_cookie("force_lang",$_GET['force_lang']);
}
$_SESSION['user']['lang'] = isset($_COOKIE['force_lang']) ? divers::read_cookie('force_lang') : $_SESSION['user']['lang'];

//Fichier de configuration des unitées
include("conf/".$_SESSION['user']['race'].".php");
$_tpl->set("cfg_url",SITE_URL);
$_tpl->set("cfg_style",isset($_COOKIE['style']) ? divers::read_cookie('style', false) : "Marron");

$url['url']['index.php'][0] = array('var' =>  array('file','act'), 'new_url' =>  '%s-%s.html');
$url['url']['index.php'][1] = array('var' =>  array('file'), 'new_url' =>  '%s.html');
$_tpl->url($url);

include("lib/game.class.php");
$conf_name = "config".$_SESSION['user']['race'];
$conf = new $conf_name();

$game = new game($_sql, $conf);

include("lib/member.class.php");
$mbr = new member($_sql, $game, $conf);

include("lib/histo.class.php");
$histo = new histo($_sql);
//********************************//
//  html                          //
//********************************//

if(file_exists('logs/cron.lock'))
	$cron_lock = nl2br(file_get_contents('logs/cron.lock'));
else
	$cron_lock = false;
$_tpl->set('cron_lock',$cron_lock);

if($_file != "session")
{
	$_file = ($_SESSION['user']['etat'] == 3) ? 'zzz' : (isset($_GET['file']) ? $_GET['file'] : 'news');
}

$_tpl->set_lang($_SESSION['user']['lang']);
$_tpl->set("ses_loged",$_SESSION['user']['loged']);
$_tpl->set("ses_can_play",$_SESSION['user']['droits']{DROIT_PLAY});

//centre
if(preg_match("/(http|ftp|com|net|\/|\.)/i",$_file))
{
	$_file = "404";
}

$lock_array = array('msg','forum','news','admin','404','manual','faq','irc','a_propos','notes','bonus','session');
if(!$cron_lock OR in_array($_file,$lock_array))
{
	if(file_exists(SITE_DIR."modules/".$_file."/page.php") AND $_file!="404")
	{
		include(SITE_DIR."modules/".$_file."/page.php");
	}else{
		include(SITE_DIR."modules/404/page.php");
		$_div->log($_SESSION['user']['mid']);
	}
}

$_tpl->set('module',$_file);
/************************
* Stats                 *
************************/
if(!$log_in_out) include("include/stats.php");
$_tpl->set("sv_nbreq",$_sql->nbreq);

$_tpl->set("can_view_this",$_SESSION['user']['droits']{1}!=1);
$_tpl->set("sv_diff",$sv_t1);

if(isset($_GET['only_file']))
{
	$_tpl->set('no_html',true);
	$_tpl->set('popup', true);
}

if(SITE_DEBUG)
{
	$_tpl->set('sv_site_debug',true);
	$_tpl->set('sv_total_sql_time',$_sql->total_time);
	$_tpl->set('sv_queries',$_sql->queries);
}
echo $_tpl->get("index.tpl",1);
//********************************//
//  On ferme le tout              //
//********************************//
$_sql->close();
?>
