<?php
require_once("../conf/conf.inc.php");
require_once("../lib/divers.lib.php");
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


$sql = "SELECT * FROM zrd_mbr JOIN zrd_map ON map_cid = mbr_mapcid WHERE mbr_etat = ".MBR_ETAT_OK;
$mbr_array = $_sql->make_array($sql);

$race = array();

for($i = 1; $i <= 5; ++$i)
	$race[$i] = imagecreatefrompng("../www/img/$i/$i.png");

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
imagepng($im, "../www/out.png");
?>