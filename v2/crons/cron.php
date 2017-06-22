<?php
ignore_user_abort();
error_reporting (E_ALL | E_STRICT | E_RECOVERABLE_ERROR);
date_default_timezone_set("Europe/Paris");

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


mark('start');

//require_once("/home/zorddev/conf/conf.inc.php");
require_once(str_replace('crons','',dirname(__FILE__))."/conf/conf.inc.php");

require_once(SITE_DIR . "lib/divers.lib.php");
$_cache = new cache('global', true);

/* Gestion des erreurs : fonctions dans lib/divers.lib.php */
$_error = array();
set_error_handler("error_handler");

require_once(SITE_DIR . "lib/member.lib.php");
require_once(SITE_DIR . "lib/alliances.lib.php");
require_once(SITE_DIR . "lib/res.lib.php");
require_once(SITE_DIR . "lib/trn.lib.php");
require_once(SITE_DIR . "lib/unt.lib.php");
require_once(SITE_DIR . "lib/src.lib.php");
require_once(SITE_DIR . "lib/btc.lib.php");
require_once(SITE_DIR . "lib/rec.lib.php");
mark('lib');

$_sql = new mysqliext(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);
$_sql->env = 'cron';


mark('mysql');

$_h = (int) date('H');
$_m = (int) date('i');
$_s = (int) date('s');
$_c = "";

/* Calcul du tours courant, sachant qu'il y a 24 tours par cycle, et 4 * 5 périodes par cycle */
$_t = $_cache->tour;
$_ts = $_cache->tours;
$_p = $_cache->period;
if(ZORD_SPEED == ZORD_SPEED_VFAST || !($_m % ZORD_SPEED)) {
	$_ts++;
	$_t = $_ts % 24;
	if(!($_ts % 5))
		$_p++;
	$_p = (($_p - 1) % 4) + 1;
}

if(!($_s % 10))
	$_c = "10s";
if(!($_s % 30))
	$_c = "30s";
if($_s == 0)
	$_c = "1m";
if(!($_m % 2))
	$_c = "2m";
if(!($_m % 5))
	$_c = "5m";
if(!($_m % 10)) /* Toutes les dix minutes */
	$_c = "10m";
if(!($_m % 30))
	$_c = "30m";
if($_m == 0)  /* Toutes les heures */
	$_c = "1h";
if($_m == 0 && !($_h % 6)) /* Toutes les 6h */
	$_c = "6h";
if($_m == 0 && !($_h % 12)) /* Toutes les 12h */
	$_c = "12h";
if($_m == 0 && $_h == 0) /* Toutes les 24h */
	$_c = "24h";
/* correctif vitesse supérieure FAST pour récupérer les minutes impaires 1 3 7 9 */
if ($_c == '') $_c = '1m';

$lockfile = SITE_DIR."logs/cron1.lock"; // ce fichier ne lock pas le jeu (tour transparent)
switch(ZORD_SPEED) {
case ZORD_SPEED_VFAST:
	$lockfile = SITE_DIR."logs/cron.lock";
	break;
case ZORD_SPEED_FAST:
	if (in_array($_c,array('5m','10m','30m','1h','6h','12h','24h')))
		$lockfile = SITE_DIR."logs/cron.lock";
    break;
case ZORD_SPEED_NORMAL:
	if (in_array($_c,array('30m','1h','6h','12h','24h')))
		$lockfile = SITE_DIR."logs/cron.lock";
	break;
default:
case ZORD_SPEED_SLOW:
	if (in_array($_c,array('1h','6h','12h','24h')))
		$lockfile = SITE_DIR."logs/cron.lock";
	break;
}

$_lock = new log($lockfile, "H:i:s d/m/Y", true, true);
$_log = new log(SITE_DIR."logs/crons/bench/bench_".date("d_m_Y").".log");
$_histo = new histo($_sql);
$_user = array();
$_ally = array(); // liste des alliances utilisées pour diplo
$_conf = array();
load_conf(1);
load_conf(2);

/*  Templates  */
$_tpl = new Template();
$_tpl->set_tmp_dir(SITE_DIR.'tmp');
$_tpl->set_dir(SITE_DIR.'templates');
$_tpl->set_ref("_langues", $_langues);
$_tpl->set_lang('fr_FR');
$_tpl->get_config('config/config.config');

mark('class');

$_act = ($argc == 2) ? $argv[1] : "";


mark('args');

require_once('frm.cron.php');
require_once('cache.cron.php');
require_once('clean.cron.php');
require_once('aly.cron.php');
require_once('mbr.cron.php');
require_once('stats.cron.php');
require_once('com.cron.php');
require_once('src.cron.php');
require_once('btc.cron.php');
require_once('res.cron.php');
require_once('leg.cron.php');
require_once('unt.cron.php');
require_once('pts.cron.php');
require_once('map.cron.php');
require_once('dpl.cron.php');


mark('func');

function scl($key, $type, $array) {
	global $acts;
	$acts[$key][$type] = $array;
}

function clean_scl() {
	global $acts;
	$times = array("10s","30s","1m","2m","5m","10m","30m","1h","6h","12h","24h");
	$types = array("glob", "mbr");

	foreach($types as $type) {
		$tmp = array();
		foreach($times as $key) {
			if(isset($acts[$key][$type])) {
				$tmp = array_merge($acts[$key][$type], $tmp);
				$acts[$key][$type] = $tmp;
			} else
				$acts[$key][$type] = $tmp;
		}
	}
}
$acts = array();

switch(ZORD_SPEED) {
case ZORD_SPEED_VFAST:
	scl("1m", "mbr", array("res", "unt", "btc", "src", "mbr"));

	scl("5m", "glob", array("com"));
	scl("1m", "glob", array("leg", "res", "unt", "btc", "src", 'dpl', "cache", "pts"));
	scl("1h", "glob", array("aly", "mbr"));

	scl("6h", "glob", array("stats"));
	break;
case ZORD_SPEED_FAST:
    scl("5m", "mbr", array("res", "unt", "btc", "src", "mbr"));

    scl("5m", "glob", array("leg", "res", "unt", "btc", "src", 'dpl', "cache", "com"));
    scl("6h", "glob", array("aly", "mbr", "pts"));

    scl("24h", "glob", array("stats"));
    break;
case ZORD_SPEED_NORMAL:
	scl("30m", "mbr", array("res", "unt", "btc", "src", "mbr"));

	scl("5m", "glob", array("cache", "com"));
	scl("30m", "glob", array("leg", "res", "unt", "btc", "src", 'dpl'));
	scl("6h", "glob", array("aly", "mbr", "pts"));

	scl("24h", "glob", array("stats"));
	break;
default:
case ZORD_SPEED_SLOW:
	scl("1h", "mbr", array("res", "unt", "btc", "src", "mbr"));

	scl("5m", "glob", array("cache", "com"));
	scl("1h", "glob", array("stats", "leg", "res", "unt", "btc", "src", 'dpl'));
	scl("6h", "glob", array("mbr", "pts", "aly"));

	scl("24h", "glob", array("stats", "map"));
	break;
}
clean_scl();


/* ajouter XP en mode débug */
if(SITE_DEBUG && !($_m % 30))
	$_sql->query("UPDATE ".$_sql->prebdd."hero SET hro_xp = hro_xp + 100 WHERE hro_xp < 100");

/* Ici quelques fonctions pour éviter de faire trop de trucs inutiles */
/* liste des recherches à faire: src_todo */
$sql = "SELECT DISTINCT stdo_mid FROM ".$_sql->prebdd."src_todo ";
$src_todo_mid = $_sql->index_array($sql, "stdo_mid");

/* liste des batiments a faire */
$sql = "SELECT DISTINCT btc_mid FROM ".$_sql->prebdd."btc ";
$sql.= "WHERE btc_etat IN (".BTC_ETAT_TODO.", ".BTC_ETAT_BRU.", ".BTC_ETAT_REP.")";
$btc_todo_mid = $_sql->index_array($sql, 'btc_mid');

/* liste des membres actifs */
$sql = "SELECT mbr_mid,mbr_race, mbr_mapcid FROM ".$_sql->prebdd."mbr ";
$sql.= "WHERE mbr_etat = ". MBR_ETAT_OK ." AND mbr_mid != 1 ORDER BY RAND() ";
$mid_array = $_sql->make_array($sql);

/* liste des héros */
$sql = "SELECT hro_id, hro_lid, hro_mid, hro_type, hro_vie, leg_cid, hro_xp, hro_bonus ";
$sql.= "FROM ".$_sql->prebdd."hero LEFT JOIN ".$_sql->prebdd."leg ON hro_lid = leg_id ";
$hro_array = $_sql->index_array($sql, 'hro_mid');


$hro_list = array();
$leg_move_list = array(); // légions contenant une unités déménagement
$btc_def_list = array();

/* ici on analyse les configs des races pour avoir les unités & batiments particuliers
 * héros, unité caravane et les batiments défensifs
 */
foreach ($_races as $race => $visible) {
	$conf_unt = get_conf_gen($race, "unt");
	foreach($conf_unt as $unt => $conf)
		if (isset($conf['role'])){
			// liste des types de heros (pour ne pas les tuer de faim)
			if ($conf['role'] == TYPE_UNT_HEROS)
				$hro_list[$race][$unt] = $unt; // plusieurs héros par race
			// liste des types de caravanes
			else if ($conf['role'] == TYPE_UNT_DEMENAGEMENT)
				$unt_move_list[$race][$conf['rang']] = $unt; // 1 seule unité de déménagement par race! mais on garde aussi son rang
		}

	// liste des bat défensifs pour la défense TIR
	$conf_btc = get_conf_gen($race, "btc");
	foreach($conf_btc as $btc => $conf)
		if (isset($conf['bonus']['tir']))
			$btc_def_list[$race][$btc] = 1;
}

/* liste des unités de déménagement par joueurs: requete fixe par config:
 * SELECT unt_nb, unt_type, leg_id, mbr_mid, mbr_race 
 * FROM zrd_unt LEFT JOIN zrd_leg ON unt_lid = leg_id 
 * LEFT JOIN zrd_mbr ON leg_mid = mbr_mid 
 * WHERE CASE mbr_race  WHEN 1 THEN 27 WHEN 2 THEN 33 WHEN 3 THEN 28 WHEN 4 THEN 28 WHEN 5 THEN 27 WHEN 7 THEN 27 ELSE 0 END = unt_type
 *  */
$sql = "SELECT unt_nb, unt_type, leg_id, mbr_mid, mbr_race ";
$sql.= "FROM ".$_sql->prebdd."unt LEFT JOIN ".$_sql->prebdd."leg ON unt_lid = leg_id ";
$sql.= "LEFT JOIN ".$_sql->prebdd."mbr ON leg_mid = mbr_mid ";
$sql .= "WHERE CASE mbr_race ";

foreach($unt_move_list as $race => $unt_type)
	$sql .= " WHEN $race THEN ".array_shift($unt_type);
$sql .= " ELSE 0 END = unt_type";
$leg_move_array = $_sql->index_array($sql, 'leg_id');


// construire les 'dependances' (recherche depend de batiment etc)
function make_dep($funcs) {
	$deps = array();
	foreach($funcs as $func) {
		$name = "dep_" . $func;
		global $$name;
		if(isset($$name))
			foreach($$name as $dep)
				$deps[] = $dep;
	}
	return array_unique($deps);
}

function get_mbr(&$dep) {
	global $src_todo_mid, $mid_array, $btc_todo_mid, $hro_array;

	if(!current($mid_array))
		return array();

	$mid = current($mid_array);

	$cond = array();
	$cond['full'] = true;
	$cond['mid'] = $mid['mbr_mid'];
	$user = get_mbr_gen($cond);

	if(!$user)
		return array();

	$user = $user[0];
	if(!isset($src_todo_mid[$user['mbr_mid']]))
		$user["no_src_todo"] = true;
	if(!isset($btc_todo_mid[$user['mbr_mid']]))
		$user["no_btc_todo"] = true;
	if(isset($hro_array[$user['mbr_mid']]))
		$user['hro'] = $hro_array[$user['mbr_mid']];

	if(in_array("btc", $dep)) {
		$user["btc"] = get_nb_btc($user['mbr_mid'], array(), array(BTC_ETAT_OK));
		$user["btc"] = index_array($user["btc"], "btc_type");
		$btc_nb = get_conf_gen($user["mbr_race"], "race_cfg", "btc_nb");
		for($j = 1; $j <= $btc_nb; ++$j)
			$user["btc"][$j] = isset($user["btc"][$j]) ? $user["btc"][$j]["btc_nb"] : 0;
	}
	if(in_array("unt", $dep)) {
		$user["unt"] = get_unt_done($user['mbr_mid']);
		$user["unt"] = index_array($user["unt"], "unt_type");
	}
	if(in_array("res", $dep)) {
		$user["res"] = get_res_done($user['mbr_mid'], array(), $user["mbr_race"]);
		$user["res"] = clean_array_res($user["res"]);
		$user["res"] = $user["res"][0];
	}

	next($mid_array);
	return $user;
}

function write_log($text) {
	global $_lock;
	global $_log;

	$_log->text($text);
	$_lock->text($text);
}


// $func = liste des 'fonctions' à appliquer à chaque membre
function map_mbr($funcs) {
	global $_user;
	$funcs = array_unique($funcs);
	$dep = make_dep($funcs);

	write_log("Calcul pour chaque joueur");

	while($_user = get_mbr($dep)) {
		foreach($funcs as $func) {
			$func = "mbr_".$func;
			$func($_user);
		}
	}
	mark('map_mbr');
}

// $func = liste des 'fonctions' à appliquer à tout le monde
function apply_mbr($funcs) {
	$funcs = array_unique($funcs);
	foreach($funcs as $func) {
		$log = "log_".$func;
		global $$log;
		write_log($$log." (global) ");
		$func = "glob_".$func;
		$func();
		mark($func);
	}
}

/*
$acts = array();
$acts[$_c]['glob'] = array("pts");
$acts[$_c]['mbr'] = array();
*/
if(isset($acts[$_c])) {
	map_mbr($acts[$_c]['mbr']);
	apply_mbr($acts[$_c]['glob']);
	zrd_clean();
}

mark('clean');

if (SITE_DEBUG) sleep(1);

//$_histo->flush();
//$_lock->close();
//$_log->close();
//$_sql->close();

mark('close');

if(SITE_DEBUG) {
	foreach(mark(true) as $title => $time)
	{
		if(!isset($prev_time))
			$prev_time = $time;

		echo  "$title: ".round($time-$prev_time, 5). "\n";
		$prev_time = $time;
	}
	echo "SQL :\n";
	echo "Time: ". $_sql->total_time . "\n";
	echo "Req: ". $_sql->nbreq . "\n";
}
?>
