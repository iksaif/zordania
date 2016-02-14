<?php

$log_stats = "Statistiques";

function glob_stats() {
	global $_sql, $_m, $_h;
	
	if($_m == 0) { /* Nombre de connectés */
		$sql = "INSERT INTO ".$_sql->prebdd."con (con_nb) ";
		$sql.= "SELECT COUNT(*) FROM ".$_sql->prebdd."ses ";
		$_sql->query($sql);
	}
	
	if($_h == 0) { /* Statistiques */
		$sql = "INSERT INTO ".$_sql->prebdd."stq VALUES (NOW(),";
		$sql.= "(SELECT COUNT(*) FROM ".$_sql->prebdd."mbr WHERE mbr_etat = ".MBR_ETAT_OK."),";
		$sql.= "(SELECT COUNT(*) FROM ".$_sql->prebdd."mbr WHERE mbr_etat = ".MBR_ETAT_ZZZ."),";
		$sql.= "((SELECT SUM(con_nb) FROM ".$_sql->prebdd."con) / (SELECT COUNT(*) FROM ".$_sql->prebdd."con)));";
		$_sql->query($sql);
	}	
}
?>