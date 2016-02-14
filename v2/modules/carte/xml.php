<?php
if(!defined("_INDEX_")){ exit; }

/* Longueur / Largeur Max d'un réctangle, pour éviter que ça casse tout */
$size_max = 20;


require_once('lib/map.lib.php');

$x1 = request("x1", "uint", "get");
$y1 = request("y1", "uint", "get");
$x2 = request("x2", "uint", "get");
$y2 = request("y2", "uint", "get");

/* On fait en sorte que ça face un rectangle qui peut exister */
if($x2 > MAP_W) $x2 = MAP_W;
if($y2 > MAP_H) $y2 = MAP_H;

if($x2 < $x1) {
	$tmp = $x2;
	$x2 = $x1;
	$x1 = $tmp;
}

if($y2 < $y1) {
	$tmp = $y2;
	$y2 = $y1;
	$y1 = $tmp;
}

if($x2 - $x1 > $size_max) $x2 = $x1 + $size_max;
if($y2 - $y1 > $size_max) $y2 = $y1 + $size_max;

$map_array = get_map($_user['mid'],$x1,$y1,$x2,$y2);
$_module_tpl = "modules/carte/carte_xml.tpl";
$_tpl->set("map_array", $map_array);
?>