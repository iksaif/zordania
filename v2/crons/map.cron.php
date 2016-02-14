<?php
$log_map = "Cartes";

function glob_map() {
	global $_sql;
	$sql = "SELECT mbr_race, mbr_points, map_x, map_y ";
	$sql.= "FROM zrd_mbr JOIN zrd_map ON map_cid = mbr_mapcid ";
	$sql.= "WHERE mbr_etat = ".MBR_ETAT_OK;
	$mbr_array = $_sql->make_array($sql);

	pts_map($mbr_array);
	pop_map($mbr_array);
}


function pts_map(&$mbr_array) {
	$map = array();
	for($i = 0; $i < 500; ++$i)
		for($j = 0; $j < 500; ++$j)
			$map[$i][$j] = 0;

	$im = imagecreatefrompng(SITE_DIR ."crons/map.png");

	foreach($mbr_array as $value) {
		$x = $value['map_x'];
		$y = $value['map_y'];
		$pts = $value['mbr_points'];
		pts_fill_map($x, $y, $pts, $map);
	}
	$im2 = pts_color_map($map);

	imagecopymerge ($im, $im2, 0, 0, 0, 0, MAP_W, MAP_H, 50);
	imagepng($im, SITE_DIR . "www/img/map/rp-lite/pts.png");
}

function pts_fill_map($x, $y, $pts, &$map) {
	$r = log($pts / 10);
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

function pts_get_max($map) {
	$max = 0;

	for($i = 0; $i < 500; ++$i)
		for($j = 0; $j < 500; ++$j)
			$max = max($max, $map[$i][$j]);

	return $max;
}

function pts_calc_color($max, $val) {
	$r = $g = $a = $b = 0;
	if($val) {
		$r = ceil(255 * ($val / $max));
		$g = 255 - $r;
		$a = 75;
	}

	return array($r, $g, $b, $a);
}

function pts_color_map($map) {
	$im = imagecreatetruecolor(MAP_W, MAP_H);
	imagecolortransparent($im, imagecolorallocate($im, 0, 0, 0));

	$max = pts_get_max($map);

	for($i = 0; $i < MAP_W; ++$i) {
		for($j = 0; $j < MAP_H; ++$j) {
			$rgba = pts_calc_color($max, $map[$i][$j]);
			list($r, $g, $b, $a) = $rgba;
			$c = imagecolorallocatealpha($im, $r, $g, $b, $a);
			imagesetpixel($im, $i, $j, $c);
		}
	}
	return $im;
}


function pop_map(&$mbr_array) {
	global $_races;

	$im = imagecreatefrompng(SITE_DIR . "crons/map-big.png");
	$coef = 3;
	$colors = array();
	foreach($_races as $i)
		$ims[$i] = imagecreatefrompng(SITE_DIR . "www/img/$i/$i.png");

	foreach($mbr_array as $value) {
		$x = $value['map_x'];
		$y = $value['map_y'];
		$race = $value['mbr_race'];
		imagecopymerge ( $im, $ims[$race], $x*$coef, $y*$coef, 0, 0, 15, 15, 100 );
	}

	imagejpeg($im, SITE_DIR . "www/img/map/rp-lite/pop-big.jpg");

	$im2 = imagecreatetruecolor(MAP_W, MAP_H);
	imagecopyresampled ($im2, $im, 0, 0, 0, 0, MAP_W, MAP_H, (MAP_W*$coef), (MAP_H*$coef));
	imagepng($im2, SITE_DIR . "www/img/map/rp-lite/pop.png");
}
?>
