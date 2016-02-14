<?php
/* Récupère des infos sur les stats */
function get_stats($date1, $date2 = '')
{	
	global $_sql;
	$date1 = protect($date1, "string");
	$date2 = protect($date2, "string");
		
	$sql="SELECT ";
	$sql.="stq_mbr_act,stq_mbr_inac,stq_mbr_con ";
	$sql.="FROM ".$_sql->prebdd."stq ";
	$sql.="WHERE stq_date LIKE '$date1%' ";
	if($date2) $sql.="OR stq_date LIKE '$date2%' ORDER BY stq_date DESC";
		return $_sql->make_array($sql);
}
?>