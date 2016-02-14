<?
//Selection boucle membres inactifs (race + mid)
include("lib/divers.class.php");
include("conf/conf.inc.php");
include("lib/mysql.class.php");
include("lib/game.class.php");
include("lib/member.class.php");
include("conf/1.php");
include("conf/2.php");
include("conf/3.php");
include("conf/4.php");
include("conf/5.php");

$_sql=new mysql(MYSQL_URL, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);
$_div=new divers($_sql);
$game = new game($_sql, $conf);
$mbr = new member($_sql, $game, $conf);


$conf[1] = new config1();
$conf[2] = new config2();
$conf[3] = new config3();
$conf[4] = new config4();
$conf[5] = new config5();

/* correction de la place totale dispo des membres */
/*
$sql = "SELECT mbr_mid, mbr_race, mbr_pseudo, res_nb FROM zrd_mbr JOIN zrd_res ON res_mid = mbr_mid AND res_type = ".GAME_RES_PLACE;
$mbr_array  = $_sql->make_array($sql);
foreach($mbr_array as $mbr_value) {
	$mid = $mbr_value['mbr_mid'];
	$race = $mbr_value['mbr_race'];
	$old = $mbr_value['res_nb'];
	$place = 0;

	$sql = "SELECT btc_type, COUNT(*) as btc_nb FROM zrd_btc WHERE btc_mid = $mid GROUP BY btc_type ";
	$btc_array = $_sql->make_array($sql);
echo mysql_error();
	foreach($btc_array as $btc_value) {
		$place += $btc_value['btc_nb'] * $conf[$race]->btc[$btc_value['btc_type']]['population'];
	}
	if($old != $place) {
		echo " {$mbr_value['mbr_pseudo']} : $old - $place\n ";
		$sql = "UPDATE zrd_res SET res_nb = $place WHERE res_mid = $mid AND res_type = ".GAME_RES_PLACE;
		$_sql->query($sql);
		echo $sql;
	}
}
exit;
*/

/* suppression d'espace sur la carte par la suppression des membres inactifs */
// suppression sur le critere date (6 mois) + points (<1000) + groupe (joueurs normaux)
// $sql="SELECT mbr_pseudo,mbr_mid,mbr_points,mbr_alaid,mbr_ldate FROM zrd_mbr  WHERE mbr_ldate < (NOW() - INTERVAL 6 MONTH) AND mbr_points < 1000 AND `mbr_gid`=3";
// suppression des comptes non initialisés
$sql="SELECT mbr_pseudo,mbr_mid,mbr_points,mbr_alaid,mbr_ldate FROM zrd_mbr  WHERE mbr_etat = 2";

$mbr_array =$_sql->make_array($sql);

//print_r($mbr_array);

foreach($mbr_array as $mbr_value)
{
	$pseudo = $mbr_value['mbr_pseudo'];
	$mid = $mbr_value['mbr_mid'];
	$alaid = $mbr_value['mbr_alaid'];
	$ldate = explode(" ",$mbr_value['mbr_ldate']);
	$array_ldate[$ldate[0]]++;
	$points = $mbr_value['mbr_points'];
	if($points < 10000) {
	  echo "<br/><b>$pseudo</b> (mid:$mid alid:$alaid points:$points): lignes ".$mbr->del($mid,$alaid);
		$i++;
	} else {
		echo "<br/>$pseudo (mid:$mid alid:$alaid points:$points): ";
	}
	flush();
	ob_flush();
	
}
echo "<br/><strong>$i</strong>";
?>
