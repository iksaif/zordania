<?
/*******************************************************************
*
* Crons :
* -echanges.php : 	echanges de res entre joueurs
* 			à chaque tour
* -unt.php	:	formation des unités
*			à chaque tour
* -btc.php	:	construction des batiments
*			à chaque tour
* -res.php	:	recolte des ressources
*			à chaque tour
* -war.php	:	gestion des attaques
*			à chaque tour
* -clean.php	:	nettoyage | comptes inutilisés
*			chaque semaine
* -points.php	:	recompte des points
*			chaque semaine
******************************************************************/

/************ General ************/
set_time_limit(0);
date_default_timezone_set("Europe/Paris");
include("/home/zordania/v1/www/conf/conf.inc.php");
include(SITE_DIR."conf/1.php");
include(SITE_DIR."conf/2.php");
include(SITE_DIR."conf/3.php");
include(SITE_DIR."conf/4.php");
include(SITE_DIR."conf/5.php");
include(SITE_DIR."lib/mysql.class.php");
include(SITE_DIR."lib/log.class.php");
include(SITE_DIR."lib/divers.class.php");
include(SITE_DIR."lib/histo.class.php");

$sql=new mysql(MYSQL_URL, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);
$conf[1] = new config1();
$conf[2] = new config2();
$conf[3] = new config3();
$conf[4] = new config4();
$conf[5] = new config5();
$log 	 = new log();
$lock 	 = new log();
$histo 	 = new histo($sql);

$t0 = $log->getmicrotime();

$lock->set_file(SITE_DIR."logs/cron.lock");
$log->set_file(SITE_DIR."logs/crons/bench/bench_".date("d_m_Y").".log");
$log->open();
$lock->open();

/************ Qui ? ****************/
$req="SELECT mbr_mid,mbr_race,mbr_population FROM ".$sql->prebdd."mbr WHERE mbr_race != 0 AND mbr_etat = 1 ORDER BY mbr_race ASC";
$mbr_tmp_array = $sql->make_array($req);
foreach($mbr_tmp_array as $key => $value)
{
	$GLOBALS['mbr_array'][$value['mbr_mid']] = $value['mbr_race'];
	$_mbr_array[$value['mbr_mid']] = $value;
}


/************ Crons ***************/
$jour 	= date("d");
$heure 	= date("H");
$log->text("Include & Class Heure :".$heure." Jour: ".$jour);
$lock->text("Début du calcul ..");

include("res.php");
$res = new res($sql, $conf, $_mbr_array);
include("unt.php");
$unt = new unt($sql, $conf, $_mbr_array);
include("btc.php");
$btc = new btc($sql, $conf, $histo);
include("src.php");
$src = new src($sql, $conf, $histo);
include("war.php");
$war = new war($sql, $conf, $histo);
include("stats.php");
$stq = new stq($sql, $conf);
include("clean.php");
$clea = new clea($sql);
include("mch.php");
$mch = new mch($sql);

/************ Exec ****************/

$log->text("Exec cron_res ...");
$lock->text("Création des ressources.");
$t1 = $log->getmicrotime();
$res->exec();
unset($res);
$log->text("Fin res: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

$log->text("Exec cron_unt ...");
$lock->text("Création des unités.");
$t1 = $log->getmicrotime();
$unt->exec();
unset($unt);
$log->text("Fin unt: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

$log->text("Exec cron_btc ...");
$lock->text("Création et réparation des bâtiments.");
$t1 = $log->getmicrotime();
$btc->exec();
unset($btc);
$log->text("Fin btc: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

$log->text("Exec cron_src ...");
$lock->text("Recherches en cours.");
$t1 = $log->getmicrotime();
$src->exec();
$log->text("Fin src: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

$log->text("Exec cron_war ...");
$lock->text("Déplacement des armées.");
$t1 = $log->getmicrotime();
$war->exec();
unset($war);
$log->text("Fin war: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

$log->text("Exec cron_stq ...");
$lock->text("Calcul des statistiques.");
$t1 = $log->getmicrotime();
$stq->exec();
unset($stq);
$log->text("Fin stq: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

$log->text("Exec cron_mch ...");
$lock->text("Calcul des Cours du marché.");
$t1 = $log->getmicrotime();
$mch->exec();
unset($mch);
$log->text("Fin mch: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

$log->text("Exec cron_clea ...");
$lock->text("Nettoyage.");
$t1 = $log->getmicrotime();
$clea->exec();
unset($clea);
$log->text("Fin clea: ".round(($log->getmicrotime() - $t1))."s ...");
$log->text("-------------");

if($heure == 14)
{
	$log->text("Crons de 14H activés...");
	include("points.php");
	$pt = new pt($sql,$conf);
	
	/************* Points *************/
	$log->text("Exec cron_pt ...");
	$lock->text("Calcul des points.");
	$t1 = $log->getmicrotime();
	$pt->exec();
	unset($pt);
	$log->text("Fin pt: ".round(($log->getmicrotime() - $t1))."s ...");
	$log->text("-------------");
}

if($heure == 00)
{
	$log->text("Crons journaliés activés...");
	include("points.php");
	$pt = new pt($sql,$conf);
	
	/************* Points *************/
	$log->text("Exec cron_pt ...");
	$lock->text("Calcul des points.");
	$t1 = $log->getmicrotime();
	$pt->exec();
	unset($pt);
	$log->text("Fin pt: ".round(($log->getmicrotime() - $t1))."s ...");
	$log->text("-------------");	
}

if($jour == "Sun")
{
	$log->text("Crons hebdomadaires activés...");
}

/************ Fin *****************/
$log->text("Fin des crons: ".round(($log->getmicrotime() - $t0))."secondes (".round(($log->getmicrotime() - $t0)*1000)." ms) et ".$sql->nbreq." Requettes sql ...");
$log->close();

$lock->text("Mise à jour des évenements.");
$lock->close();
$histo->flush();
unlink(SITE_DIR.'logs/cron.lock');
?>
