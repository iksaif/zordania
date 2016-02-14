<?php
include_once("divers.lib.php");

function bonus_test() {
	$ip = get_ip();
	$query = request("QUERY_STRING", "string", "server");

	$requete = "http://secure.rentabiliweb.com/Micropaiement.php?act=ss&";
	$requete.= $query;
	$requete.= "&REMOTE_ADDR=".$ip;
	$tabrep = @file($requete);

	return $tabrep && $tabrep[0] == "OUI";
}

function bonus_verify_in_log($mid, $recall)
{
	global $_sql;

	$mid = protect($mid, "uint");
	$code = protect($code, "string");

	$sql = "SELECT COUNT(*) FROM ".$_sql->prebdd."bon ";
	$sql.= "WHERE `bon_ok` = 1 AND bon_code='$code' AND bon_date > (NOW() - INTERVAL 1 DAY)";
	return mysql_result($_sql->query($sql), 0);
}

function bonus_log($mid, $code, $ok, $type, $nb)
{
	global $_sql;

	$mid = protect($mid, "uint");
	$ok  = protect($ok, "bool");
	$type = protect($type, "uint");
	$nb = protect($nb, "uint");

	$sql="INSERT INTO ".$_sql->prebdd."bon VALUES ('','$mid',NOW(),'$code','$ok','$type','$nb')";
	return $_sql->query($sql);
}

function bonus_get_log()
{
	global $_sql;

	$req = "SELECT mbr_pseudo,mbr_race,bon_mid,bon_code,bon_ok,bon_res_type,bon_res_nb,_DATE_FORMAT(bon_date) as bon_date,_DATE_FORMAT(bon_date) as bon_date_formated ";
	$req.= "FROM ".$_sql->prebdd."bon ";
	$req.= "JOIN ".$_sql->prebdd."mbr ON mbr_mid = bon_mid ";
	$req.= "ORDER BY bon_date DESC";
	return $_sql->make_array($req);
}

?>