<?php

$log_aly = 'Alliances';

function glob_aly() {
	global $_sql;
	// vider les msg de la shootbox
	$sql = 'DELETE FROM '.$_sql->prebdd.'al_shoot WHERE shoot_date < (NOW() - INTERVAL '.MSG_DEL_OLD.' DAY)';
	$_sql->query($sql);
	// vider l'historique du grenier
	$sql = 'DELETE FROM '.$_sql->prebdd.'al_res_log WHERE arlog_date < (NOW() - INTERVAL '.HISTO_DEL_LOG_ALLY.' DAY)';
	$_sql->query($sql);
	// maj du statut 'noob'
	$sql = 'UPDATE '.$_sql->prebdd.'al_mbr SET ambr_etat = '.ALL_ETAT_NOP.' WHERE ambr_etat = '.ALL_ETAT_NOOB.' ';
	$sql.= ' AND ambr_date < (NOW() - INTERVAL '.ALL_NOOB_TIME.' DAY)';
	$_sql->query($sql);
	// calcul des points de l'alliance
	$sql = 'UPDATE '.$_sql->prebdd.'al SET al_points = (';
	$sql.= 'SELECT SUM(mbr_points) FROM '.$_sql->prebdd.'mbr ';
	$sql.= 'JOIN '.$_sql->prebdd.'al_mbr ON mbr_mid = ambr_mid ';
	$sql.= 'WHERE ambr_aid = al_aid AND mbr_etat = '.MBR_ETAT_OK;
	$sql.= ' AND ambr_etat != '.ALL_ETAT_DEM.'  GROUP BY ambr_aid)';
	$_sql->query($sql);
	// MAJ du nombre de membres dans l'ally
	$sql = 'UPDATE '.$_sql->prebdd.'al SET al_nb_mbr = 
		(SELECT count(ambr_mid) FROM '.$_sql->prebdd.'al_mbr WHERE ambr_aid = al_aid AND ambr_etat > 1)';
	$_sql->query($sql);

}
?>
