<?php
require_once("../lib/divers.lib.php");
require_once("../conf/conf.inc.php");
require_once("../lib/mysql.class.php");
require_once("../lib/unt.lib.php");

$conf = array();
for($i = 1; $i <= 5; ++$i) {
	require_once("../conf/" . $i . ".php");
	$name = "config".$i;
	$conf[$i] = new $name();
}

$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

/*
$sql = "SELECT * FROM zrd_mbr JOIN zrd_map ON map_cid = mbr_mapcid WHERE mbr_etat = ".MBR_ETAT_OK;
$mbr_array = $_sql->make_array($sql);

$race = array();

for($i = 1; $i <= 5; ++$i)
	$race[$i] = imagecreatefrompng("www/img/$i/$i.png");

$im = imagecreatefrompng("map.png");
foreach($mbr_array as $value) {
	$x = $value['map_x'] * 3;
	$y = $value['map_y'] * 3;
	$r = $g = $b = 255;
	$color = imagecolorallocate ($im, $r, $g, $b );
	imagecopymerge ( $im, $race[$value['mbr_race']], $x, $y, 0, 0, 15, 15, 100 );
	$x += 20;
	imagestring($im, 3, $x, $y, $value['mbr_pseudo'], $color);
}
imagepng($im, "www/out.png");
exit;
*/

$sql = "SELECT * FROM zrd_mbr WHERE mbr_etat = ".MBR_ETAT_OK;
$mbr_array = $_sql->make_array($sql);

foreach($mbr_array as $value) {
	$race = $value['mbr_race'];
	$mid = $value['mbr_mid'];
	$place = 0;

	$sql = "SELECT * FROM zrd_btc WHERE btc_etat != ".BTC_ETAT_TODO." AND btc_mid = $mid";
	$btc_array = $_sql->make_array($sql);

	foreach($btc_array as $result) {
		$type = $result['btc_type'];
		if(isset($conf[$race]->btc[$type]['prod_pop']))
			$place += $conf[$race]->btc[$type]['prod_pop'];
	}
	echo $value['mbr_pseudo']. " ".$place." != ".$value['mbr_place']."\n";
	if($place != $value['mbr_place']) {
		$_sql->query("UPDATE zrd_mbr SET mbr_place = $place WHERE mbr_mid = $mid");
	}
}

/* UPDATE TRN
for($i = 1; $i <= 5; ++$i) {
	$sql = "UPDATE zrd_trn SET ";
	$set = array();
	foreach($conf[$i]->race_cfg['debut']['trn'] as $type => $nb) {
		$set[] = "trn_type".$type." = trn_type".$type." + ".$nb;
	}
	$sql .= implode($set, ",");
	$sql .= " WHERE trn_mid IN (SELECT mbr_mid FROM zrd_mbr WHERE mbr_race = ".$i.")";
	$_sql->query($sql);
}
*/
/*

$_sql->query("TRUNCATE zrd_mch_cours");
$_sql->query("INSERT INTO `zrd_mch_cours` (`mcours_res`, `mcours_cours`) VALUES (2, 1), (3, 1), (4, 0.2), (5, 3), (6, 3), (7, 30), (8, 10), (9, 50), (10, 2), (11, 25), (12, 2), (13, 40), (14, 4), (15, 25), (16, 30), (17, 60)");
$_sql->query("TRUNCATE zrd_mch_sem");
for($i = 0; $i < 7; ++$i) {
	for($j = 2; $j <= 17; ++$j) {
		$sql = "SELECT mcours_cours FROM zrd_mch_cours WHERE mcours_res = $j";
		$cours = mysql_result($_sql->query($sql), 0, 'mcours_cours');

		$sql = "INSERT INTO zrd_mch_sem VALUES ($j, NOW() - INTERVAL $i DAY, $cours)";
		$_sql->query($sql);
	}
}
*/
?>
