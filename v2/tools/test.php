<?php
require_once("../lib/divers.lib.php");
require_once("../conf/conf.inc.php");
require_once("../lib/mysql.class.php");
require_once("../lib/unt.lib.php");
require_once("../lib/member.lib.php");

$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

$sql = "UPDATE ".$_sql->prebdd."mbr SET mbr_gid = ".GRP_JOUEUR." WHERE mbr_gid = ".GRP_CHEF_REG;
$_sql->query($sql);

$sql = "SELECT MAX( mbr_points ) as mbr_points, map_region FROM ".$_sql->prebdd."mbr ";
$sql.= "JOIN ".$_sql->prebdd."map ON map_cid = mbr_mapcid ";
$sql.= "WHERE mbr_gid = ".GRP_JOUEUR." ";
$sql.= "GROUP BY map_region ";
$points = $_sql->make_array($sql);

foreach($points as $value) {
	$pts = $value['mbr_points'];
	$reg = $value['map_region'];

	$sql = "SELECT mbr_mid FROM ".$_sql->prebdd."mbr ";
	$sql.= "JOIN ".$_sql->prebdd."map ON map_cid = mbr_mapcid ";
	$sql.= "WHERE mbr_points = $pts AND map_region = $reg AND mbr_gid = ".GRP_JOUEUR." ";
	$mids = $_sql->make_array($sql);

	foreach($mids as $value) {
		$mid = $value['mbr_mid'];
		echo "$mid\n";
		$new = array();
		$new['gid'] = GRP_CHEF_REG;
		edit_mbr($mid, $new);
	}
}
?>