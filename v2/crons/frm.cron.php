<?php
/*
$log_frm = "Forum";

function mbr_frm(& $_user) {
	global $_sql;

	$sql = "UPDATE ".$_sql->prebdd."frm_users SET ";
	$sql.= "points = {$_user['mbr_points']}, ";
	if($_user['ambr_aid'] && $_user['ambr_etat'] != ALL_ETAT_DEM) {
		$name = protect($_user['al_name'], "string");
		$sql.= "alliance = '$name', alliance_id = {$_user['ambr_aid']} ";
	} else {
		$sql.= "alliance = '', alliance_id = 0 ";
	}
	$sql.= " WHERE id = {$_user['mbr_mid']}";
	$_sql->query($sql);
}
*/
?>