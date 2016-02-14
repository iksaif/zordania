<?
/********************
*   Classes         *
********************/
include("../../conf/conf.inc.php");
include("../../lib/divers.class.php");

/********************
*   Sessions        *
********************/
session_start();
if($_SESSION['code'])
{
	$chaine = $_SESSION['code'];
}else{
	$chaine = divers::genstring(5);
	$_SESSION['code'] = $chaine;
}
/********************
*   Création        *
********************/
header("Content-type: image/png");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", FALSE);
header("Pragma: no-cache");
$im = @imagecreate (100, 50);

/********************
*   Couleurs        *
********************/
$bgc = imagecolorallocate($im, 0, 0, 0);
$noir = imagecolorallocate($im, 0, 0, 0);
$blanc = imagecolorallocate($im, 255, 255, 255);
$gris = imagecolorallocate($im, 128, 128, 128);


/********************
*   Deco            *
********************/
imagefilledrectangle($im, 0, 0, 72, 25, $bgc);
//imagecolortransparent ( $im , $bgc);

/********************
*   Texte           *
********************/
$font=SITE_DIR."/img/rand/verdana.ttf";
imagettftext($im, 17, 10, 15, 40, $gris, $font, $chaine); 

/********************
*   Afficahge       *
********************/
imagepng ($im);
?> 
