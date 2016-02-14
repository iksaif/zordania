<?php
/*
 * update la région dans la table zrd_map
 * utilise l'image (reg.png) et ses couleurs pour déterminer la région
 */

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


$im = imagecreatefrompng("reg.png");
$col = array(0xa4181b , 0xa56b14 , 0xec951e,
	     0x55ea0b , 0xb2ea18 , 0xecd921,
	     0x17e78f , 0x1eb8ed , 0x2956ea);

for($i = 0; $i < 500; ++$i) {
	for($j = 0; $j < 500; ++$j) {
		$rgb = imagecolorat($im, $i, $j);

		$n = array_search($rgb, $col) + 1;
		$sql = "UPDATE zrd_map SET map_region = $n WHERE map_x = $i AND map_y = $j";
		$_sql->query($sql);
	}
}

?>
