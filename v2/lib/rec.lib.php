<?php

/* Récompenses */
function get_rec($mid, $type = 0)
{
	global $_sql;

	$mid = protect($mid, "uint");
	$type = protect($type, "uint");

	$sql = "SELECT rec_mid, rec_type, rec_nb FROM ".$_sql->prebdd."rec ";
	$sql.= "WHERE rec_mid = $mid ";
	if($type) $sql.= " AND rec_type = $type ";

	return $_sql->make_array($sql);
}

function del_rec($mid = 0, $type = 0)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	
	$sql = "DELETE FROM ".$_sql->prebdd."rec ";
	if ($mid || $type)
		$sql.= "WHERE ";
	if ($mid)
		$sql.= "rec_mid = $mid ";
	if ($mid && $type)
		$sql.= " AND ";
	if($type)
		$sql.="rec_type = $type ";
	if ($mid && $type)
		$sql.= "LIMIT 1 ";
	$_sql->query($sql);
	return mysql_affected_rows();
}

function add_rec($mid,$type)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	
	
	$sql = "INSERT INTO ".$_sql->prebdd."rec  (rec_mid, rec_type, rec_nb) ";
	$sql.= "VALUES ($mid, $type,1) ";
	$sql.= "ON DUPLICATE KEY UPDATE rec_nb = rec_nb + 1";
	
	return $_sql->query($sql);
}

function cls_rec($mid) {
	return del_rec($mid);
}

function get_rec_array($rec) {
	global $_sql;
	
	$sql = "SELECT m.mbr_mid, m.mbr_pseudo FROM ".$_sql->prebdd."mbr m JOIN ".$_sql->prebdd."rec r ON m.mbr_mid = r.rec_mid AND r.rec_type = '$rec'";
	
	return $_sql->make_array($sql);
}


?>
