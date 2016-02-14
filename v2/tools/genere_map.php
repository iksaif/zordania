<?php

require_once("../lib/divers.lib.php");
require_once("../conf/conf.inc.php");
require_once("../lib/mysql.class.php");


$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

$im = imagecreatefrompng("reg.png");
$col = array(0xa4181b , 0xa56b14 , 0xec951e,
	     0x55ea0b , 0xb2ea18 , 0xecd921,
	     0x17e78f , 0x1eb8ed , 0x2956ea);
$climats = array(MAP_FORET, MAP_MONTAGNE, MAP_HERBE);
$types = array(MAP_LAC, MAP_EAU, MAP_HERBE, MAP_LIBRE);


for($i = 0; $i < MAP_W; ++$i) {
	$sql ="INSERT INTO zrd_map (map_x, map_y, map_climat, map_type, map_rand, map_region) VALUES";
	for($j = 0; $j < MAP_H; ++$j) {
		$rgb = imagecolorat($im, $i, $j);
		$region = array_search($rgb, $col) + 1;

		$climat = $climats[mt_rand(0,2)];
		$type = $types[mt_rand(0,3)];
		$rnd = mt_rand(0, 2);

		$sql .= " ($i, $j, $climat, $type, $rnd, $region)";
		if ($j < MAP_H - 1) $sql.=", ";
	}
	$_sql->query($sql);
}

?>
