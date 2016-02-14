<?php

$log_clean = "Ramasse-miettes";

function zrd_clean() {
	global $_sql, $_h, $_m;

	$sql="DELETE FROM ".$_sql->prebdd."ses WHERE ";
	$sql.="ses_ldate < (NOW() - INTERVAL 600 SECOND)";
	$_sql->query($sql);

	$sql = "DELETE FROM ".$_sql->prebdd."atq_mbr ";
	$sql.= "WHERE atq_aid IN (
		SELECT atq_aid FROM ".$_sql->prebdd."atq
		WHERE atq_date < (NOW() - INTERVAL ".HISTO_DEL_OLD." DAY))";
	$_sql->query($sql);

	$sql="DELETE FROM ".$_sql->prebdd."atq WHERE ";
	$sql.="atq_date < (NOW() - INTERVAL ".HISTO_DEL_OLD." DAY)";
	$_sql->query($sql);

	if($_h == 0) {
		$sql = "SHOW TABLES ";
		$tables = $_sql->make_array($sql);

		$sql = "OPTIMIZE TABLE ";
		foreach($tables as $value)
			foreach($value as $name)
				$sql.= "$name,";

		$sql = substr($sql, 0, strlen($sql)-1);
		$_sql->query($sql);
	}
}
?>
