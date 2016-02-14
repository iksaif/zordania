<?
/************************************
* génère le xml pour le fichier swf *
************************************/   

//Session, config, classes.
session_start();
//ob_start("ob_gzhandler");
include("../../lib/mysql.class.php");
include("../../lib/divers.class.php");
include("../../conf/conf.inc.php");
$db=new mysql(MYSQL_URL, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);

//x et y
$x = (int) $_GET['x'];
$y = (int) $_GET['y'];
$get_pseudo = htmlentities($_GET['pseudo'], ENT_QUOTES);
$error  = 0;

//Si rien de spécifié
	
	
if($get_pseudo)
{
	$sql = $db->query("
		SELECT COUNT(mbr_mid) as mbr_test,map_x,map_y FROM ".$db->prebdd."mbr 
		LEFT JOIN ".$db->prebdd."map ON map_cid = mbr_mapcid 
		WHERE mbr_pseudo = '".$get_pseudo."' AND (mbr_etat = 1 OR mbr_etat = 3) GROUP BY mbr_mid
		");
	$x_in_db = @mysql_result($sql,0,"map_x") - 5;
	$y_in_db = @mysql_result($sql,0,"map_y") - 5;
	$test = @mysql_result($sql,0,"mbr_test");
	if($test != 1)
	{
		$x_in_db = 115;
		$y_in_db = 115;
		$error= 1;
	}
}

//le type est logué
if($_SESSION['user']['loged'] == true)
{
	$sql = $db->query("
		SELECT mbr_mid,mbr_pseudo,mbr_race,map_x,map_y FROM ".$db->prebdd."mbr 
		LEFT JOIN ".$db->prebdd."map ON map_cid = mbr_mapcid 
		WHERE mbr_mid = '".$_SESSION['user']['mid']."' AND (mbr_etat = 1 OR mbr_etat = 3)
		");
	if((!$x AND !$y) AND (!$x_in_db AND !$y_in_db))
	{
		$x_in_db = mysql_result($sql,0,"map_x") - 5;
		$y_in_db = mysql_result($sql,0,"map_y") - 5;
	}
	$pseudo  = mysql_result($sql,0,"mbr_pseudo");
	$mid     = mysql_result($sql,0,"mbr_mid");
}
elseif((!$x AND !$y) AND (!$x_in_db AND !$y_in_db))
{
	//sinon on commence au centre (cas impossible, carte seulement pour les gens logués)
	$x_in_db = 115;
	$y_in_db = 115;
}
	
//si pas d'x ou d'y ..
if(!$x)
{
	$x=$x_in_db - 50;
	$x_player = $x_in_db;
}
if(!$y)
{
	$y=$y_in_db - 50;
	$y_player = $y_in_db;
}
	
if($x < 0)
{
	$x=0;
}
if($y < 0)
{
	$y=0;
}
	

$max_x = $x + 100;
$max_y = $y + 100;

//données principales.
echo "&error=".$error."&x=".$x."&y=".$y."&xp=".$x_player."&yp=".$y_player."&pseudo=".$pseudo."&mapH=".MAP_H."&mapW=".MAP_W;


//bases
$sql2 = $db->query("
		SELECT map_x,map_y,mbr_mid,mbr_pseudo,mbr_race,mbr_points
		FROM ".$db->prebdd."mbr 
		LEFT JOIN ".$db->prebdd."map ON map_cid=mbr_mapcid 
		WHERE (map_x >= $x AND map_x <= $max_x) AND (map_y >= $y AND map_y <= $max_y)
		AND (mbr_etat = 1 OR mbr_etat = 3)
		");

echo "&other=";		
while($res = mysql_fetch_array($sql2))
{
	$res['mbr_pseudo'] = str_replace(' ','_',str_replace(',','',str_replace('|','',urlencode(html_entity_decode($res['mbr_pseudo'], ENT_QUOTES)))));
	echo $res['map_x'].",".$res['map_y'].",".$res['mbr_mid'].",".$res['mbr_pseudo'].",".$res['mbr_race'].",".$res['mbr_points'].",1|";
}

$sql2 = $db->query("
		SELECT map_x,map_y
		FROM ".$db->prebdd."map
		WHERE map_cid = ".($_SESSION['user']['mapcid']+1)."
		");
$player_x = mysql_result($sql2, 0, 'map_x');
$player_y = mysql_result($sql2, 0, 'map_y');
$min_det_x = ($player_x - 5);
$min_det_y = ($player_y - 5);
$max_det_x = ($player_x + 5);
$max_det_y = ($player_y + 5);


//armées
/*$sql2 = $db->query("
		SELECT map_x,map_y,leg_lid,mbr_pseudo 
		FROM ".$db->prebdd."leg LEFT JOIN ".$db->prebdd."mbr 
		ON leg_mid=mbr_mid 
		LEFT JOIN ".$db->prebdd."map 
		ON map_cid = leg_cid 
		WHERE 
		(map_x >= $x AND map_x <= $max_x) AND (map_y >= $y AND map_y <= $max_y) 
		AND mbr_mid = ' ".$mid."'
		AND leg_etat != 0	
		");
while($res = mysql_fetch_array($sql2))
{
	echo $res['map_x'].",".$res['map_y'].",".$res['leg_lid'].",".$res['mbr_pseudo'].",2|";
}*/
/*$sql2 = $db->query("
		     SELECT atq_dst,atq_mid,map_x,map_y,atq_lid,mbr_pseudo
		     FROM ".$db->prebdd."atq 
		     LEFT JOIN ".$db->prebdd."mbr ON atq_mid = mbr_mid
		     LEFT JOIN ".$db->prebdd."leg ON leg_lid = atq_lid
		     LEFT JOIN ".$db->prebdd."map ON map_cid = leg_cid 
		     WHERE  atq_dst <= ".ATQ_DETECT_DST." AND atq_mid2='$mid' 
		     ");
while($res = mysql_fetch_array($sql2))
{
	echo $res['map_x'].",".$res['map_y'].",".$res['leg_lid'].",".$res['mbr_pseudo'].",3|";
}		     
*/
echo "&cases=";
///cases
$req = $db->query("
		SELECT * FROM ".$db->prebdd."map 
		WHERE (map_x >= $x AND map_x <= $max_x) AND (map_y >= $y AND map_y <= $max_y)
		");


while($res = mysql_fetch_array($req))
{
	if($res['map_y'] != $y)
	{
		$y = $res['map_y'];
	}
	$x = $res['map_x'];
	if($y <= 150)
	{
		//neige
		$type=1;
	}elseif($y >= 150 AND $y <= 300)
	{
		//herbe
		$type=2;
	}elseif($y >= 300){
		//desert
		$type=3;
	}
	
	echo $x.",".$y.",".$type.",".$res['map_type']."|";	
	/******************
	* ok 		3 *		
	* Eau 		0 *
	* Montagne 	1 *		
	* Forêt 	2 *
	* herbe 	4 *
	* construit 	5 *
	******************/	
}
?>
