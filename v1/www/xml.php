<?
/************************************************************************
* Index - Base                                                          *
*                                                                       *
*                                                       11/01/04  00:26 *
*************************************************************************/

session_start();
ignore_user_abort();

//*******************************//
// Classes - Include + Création  //
//*******************************//
include("lib/divers.class.php");
$sv_t1=divers::getmicrotime();

include("conf/conf.inc.php");
include("lib/mysql.class.php");
include("lib/tpl.class.php");
include("lib/session.class.php");
include("lib/member.class.php");
include('lib/game.class.php');

$_sql=new mysql(MYSQL_URL, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);
$_tpl=new Template();
$_div=new divers($_sql);
$_ses=new session($_sql);

	

//****************//
// Merde Mysql    //
//****************//
if(!$_sql->con)
{
	exit;
}

//*******************************//
// Sessions     + detections     //
//*******************************//
//Si le type se log ou se delog
if($_GET['file'] == "session")
{
	if($_GET['act'] == "login" OR $_GET['act'] == "logout")
	{
		$no_auto_log = true;
	}
}

//Si il est logué ou pas logué
if(isset($_SESSION['user']) and !isset($no_auto_log))
{
	//Update de la session
	if(!$_ses->update(session_id(), $_SESSION['user']['login'], $_SESSION['user']['pass'], $_GET['file']))
	{
		//Autologin
		$_ses->auto_login();
	}
}

//Si toujours rien
if(!isset($_SESSION['user']))
{
	//Autologin
	$_ses->auto_login();
}

$_ses->del_old();

$_sql->set_dbdecal($_SESSION['user']['decal']);
define("_index_","ok");
if(!$_SESSION['user']['race']){ $_SESSION['user']['race'] = 0; }
$_tpl->set('GAME_RES_PLACE',GAME_RES_PLACE);
$_tpl->set('GAME_RES_BOUF',GAME_RES_BOUF);
$_tpl->set('ZORD_VERSION',ZORD_VERSION);
$_tpl->set('session_user',$_SESSION['user']);





$_SESSION['user']['lang'] = isset($_COOKIE['force_lang']) ? divers::read_cookie('force_lang') : $_SESSION['user']['lang'];

$_tpl->set("cfg_url",SITE_URL);

$url['url']['index.php'][0] = array('var' =>  array('file','act'), 'new_url' =>  '%s-%s.html');
$url['url']['index.php'][1] = array('var' =>  array('file'), 'new_url' =>  '%s.html');
$_tpl->url($url);

$_tpl->set_lang($_SESSION['user']['lang']);

$file = isset($_GET['file']) ? $_GET['file'] : exit;

//centre
if(preg_match("/(http|ftp|com|net|\/|\.)/i",$file))
{
	exit;
}

if(file_exists(SITE_DIR."modules_xml/".$file."/page.php"))
{
	include(SITE_DIR."modules_xml/".$file."/page.php");
}
else
{
	exit;
}

$_tpl->set_lang('fr');
$_tpl->set_dir('../templates_xml');

$_tpl->set('GAME_RES_PLACE',GAME_RES_PLACE);
$_tpl->set('cfg_url',SITE_URL);


header("Content-Type: application/xml");
echo $_tpl->get("modules/".$file."/".$file.".tpl",1);

$_sql->close();
?>