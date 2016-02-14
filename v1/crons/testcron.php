<style>
.mysql{
text-align:left;
background-color: #DDD;
color: #000;

border: 1px #AAA solid;
}
</style>

<?
set_time_limit(0);
//define("DIR","/home/zordania/www/");
define("DIR","../");
include(DIR."conf/conf.inc.php");
include(DIR."conf/1.php");
include(DIR."conf/2.php");
include(DIR."conf/3.php");
include(DIR."conf/4.php");
include(DIR."lib/mysql.class.php");
include(DIR."lib/log.class.php");
include(DIR."lib/divers.class.php");
include(DIR."lib/histo.class.php");

$sql=new mysql(MYSQL_URL, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);
$conf[1] = new config1();
$conf[2] = new config2();
$conf[3] = new config3();
$conf[4] = new config4();
$log 	 = new log();

$req="SELECT mbr_mid,mbr_race,mbr_population FROM ".$sql->prebdd."mbr WHERE mbr_race != 0 AND mbr_etat = 1 ORDER BY mbr_race ASC";
$mbr_tmp_array = $sql->make_array($req);
foreach($mbr_tmp_array as $key => $value)
{
	$GLOBALS['mbr_array'][$value['mbr_mid']] = $value['mbr_race'];
	$mbr_array[$value['mbr_mid']] = $value;
}		
$histo = new histo($sql);
/*
include("war.php");
$war = new war($sql, $conf,$histo);
$war->exec();
*/
/*
include("mch.php");
$mch = new mch($sql);
$mch->exec();
*/


include("unt.php");
$unt = new unt($sql, $conf, $mbr_array);
$unt->exec();


include("res.php");
$res = new res($sql, $conf, $mbr_array);
$res->exec();

include("btc.php");
$btc = new btc($sql, $conf, $histo);
$btc->exec();
/*
include("stats.php");
$stq = new stq($sql);
$stq->exec();
*/


include("clean.php");
$cl = new clea($sql);
$cl->exec();
/*
include("points.php");
$pt = new pt($sql,$conf);
$pt->exec();
unset($pt);*/

//print_r($sql->queries);
?>
