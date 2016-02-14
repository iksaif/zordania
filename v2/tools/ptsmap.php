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

$map = array();
for($i = 0; $i < 500; ++$i)
	for($j = 0; $j < 500; ++$j)
		$map[$i][$j] = 0;

$im = imagecreatefrompng("map.png");
foreach($mbr_array as $value) {
	$x = $value['map_x'];
	$y = $value['map_y'];
	$pts = $value['mbr_points'];

	fill_map($x, $y, $pts, $map);
}
$im2 = color_map($map);

imagecopymerge ($im, $im2, 0, 0, 0, 0, 1500, 1500, 50);
imagepng($im, "../www/outpts.png");


function fill_map($x, $y, $pts, &$map) {
	$r = log($pts);
	for($i = $x - $r; $i < $x + $r; ++$i) {
		for($j = $y - $r; $j < $y + $r; ++$j) {
			$l = abs($i - $x);
			$h = abs($j - $y);
			$r2 = $l * $l + $h * $h;

			if(sqrt($r2) < $r)
				$map[$i][$j] += $r;
		}
	}
}

function get_max($map) {
	$max = 0;

	for($i = 0; $i < 500; ++$i)
		for($j = 0; $j < 500; ++$j)
			$max = max($max, $map[$i][$j]);

	return $max;
}

function calc_color($max, $val) {
	$r = $g = $a = $b = 0;
	if($val) {
		$r = ceil(255 * ($val / $max));
		$g = ceil(255 - $r);
		$a = 75;
	}

	return array($r, $g, $b, $a);
}

function color_map($map) {
	$im = imagecreatetruecolor(1500, 1500);
	imagecolortransparent($im, imagecolorallocate($im, 0, 0, 0));

	$max = get_max($map);

	for($i = 0; $i < 500; ++$i) {
		for($j = 0; $j < 500; ++$j) {
			$rgba = calc_color($max, $map[$i][$j]);
			list($r, $g, $b, $a) = $rgba;
			$c = imagecolorallocatealpha($im, $r, $g, $b, $a);
			for($ii = 0; $ii < 3; ++$ii)
				for($jj = 0; $jj < 3; ++$jj)
					imagesetpixel($im, $i*3+$ii, $j*3+$jj, $c);
		}
	}
	return $im;
}
?>