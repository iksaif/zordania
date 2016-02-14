<?php
/* Tout ce qu'il faut pour les validations */
function vld($key, $mid)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$key = protect($key, "string");

	$sql = "DELETE FROM ".$_sql->prebdd."vld WHERE vld_mid='$mid' and vld_rand='$key'";
	
	$res = $_sql->query($sql);
	
	return $_sql->affected_rows();
}
	
	
/* Ajoute un acte à valider */
function new_vld($key, $mid, $act)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$key = protect($key, "string");
	$act = protect($act, "string");
	
	$sql="INSERT INTO ".$_sql->prebdd."vld VALUES ($mid,'$key',NOW(),'$act')";	
	return $_sql->query($sql);
}	

/* Supprime tout ce que le membre peut avoir a valider, par type d'action */
function del_vld($mid, $act = 0)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	if($act) $act = protect($act, 'string');
	
	$sql = "DELETE FROM ".$_sql->prebdd."vld WHERE vld_mid= $mid";
	if($act) $sql .= " AND vld_act = '$act'";
	
	$res =  $_sql->query($sql);
	
	return $_sql->affected_rows();
}


function get_vld($mid)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	
	$sql = "SELECT vld_act, vld_rand, _DATE_FORMAT(vld_date) as vld_date_formated ";
	$sql.= "FROM ".$_sql->prebdd."vld WHERE vld_mid = $mid";
	
	return $_sql->make_array($sql);
}

function cls_vld($mid)
{
	return del_vld($mid);
}
?>
