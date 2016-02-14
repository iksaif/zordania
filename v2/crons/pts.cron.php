<?php

$log_pts = "Points";

function glob_pts() {
	global $_sql, $mid_array, $hro_array;
	/* debug pour les points */
	$_logpts = new log(SITE_DIR."logs/crons/pts_".date("d_m_Y").".csv", false, false);

	$mbr_array = index_array($mid_array, "mbr_mid");

	$sql = "SELECT COUNT(*) as src_nb,src_mid";
	$sql.= " FROM ".$_sql->prebdd."src GROUP BY src_mid";
	$src_array = $_sql->index_array($sql, 'src_mid');

	$sql = "SELECT SUM(unt_nb) as unt_nb, unt_type,leg_mid FROM ".$_sql->prebdd."leg";
	$sql.= " JOIN ".$_sql->prebdd."unt ON unt_lid = leg_id ";
	$sql.= " GROUP BY leg_mid,unt_type";
	$unt_array = $_sql->make_array($sql);

	$sql = "SELECT SUM(btc_vie) as btc_vie_tot, btc_mid ";
	$sql.= "FROM ".$_sql->prebdd."btc GROUP BY btc_mid ";
	$btc_array = $_sql->index_array($sql, 'btc_mid');

	$pts_btc = array();
	$pts_armee = array();
	foreach($mbr_array as $mid => $value){
		$pts_btc[$mid] = 0;
		$pts_armee[$mid] = 0;
		$race = $mbr_array[$mid]["mbr_race"];

		/* points des XP heros */
		if (isset($hro_array[$mid]))
			$pts_armee[$mid] += $hro_array[$mid]['hro_xp'];

		/* points des recherches */
		if(isset($src_array[$mid])){
			$nbmax = get_conf_gen($race, "race_cfg", "src_nb") + 1;
			$pts_btc[$mid] += $src_array[$mid]['src_nb'] / $nbmax * 10000;
		}

		/* points des batiments */
		if(isset($btc_array[$mid])){
			$pts_btc[$mid] += ((int) $btc_array[$mid]['btc_vie_tot'] / 3);
			//* ((int) get_conf_gen($race, "race_cfg", "modif_pts_btc")) / 3;
		}
	}

	/* points des unites (civils et militaires) */
	foreach($unt_array as $key => $value) {
		$mid = $value['leg_mid'];
		if(!isset($mbr_array[$mid]))
			continue;

		$race = $mbr_array[$mid]["mbr_race"];
		$role = get_conf_gen($race, "unt", $value['unt_type'], "role");

		if ($role != TYPE_UNT_CIVIL) {
			$unt_cfg = get_conf_gen($race, "unt", $value['unt_type']);

			$pts = (isset($unt_cfg['def']) ? $unt_cfg['def'] : 0)
				 + (isset($unt_cfg['atq_unt']) ? $unt_cfg['atq_unt'] : 0)
				 + 1.8*(( isset($unt_cfg['atq_btc']) ? $unt_cfg['atq_btc'] : 0 ))
				 + $unt_cfg['vie'];

			$pts_armee[$mid] += $value['unt_nb'] * $pts;
		}
	}

	$sql_total = "";
	$sql_armee = "";
	$_logpts->text("mid;armee;nb src;vie btc;xp hro;points total");
	foreach($pts_btc as $mid => $nb) {
		// probleme: ici $race n'est pas calculé pour chaque $mid !!!
		//$nb = round($nb * get_conf_gen($race, "race_cfg", "modif_pts_btc"));
		if(isset($pts_armee[$mid])){
			$nb += round($pts_armee[$mid]); // points totaux
			$sql_armee.=" WHEN mbr_mid=$mid THEN ".round($pts_armee[$mid])." ";
		}
		$sql_total.=" WHEN mbr_mid=$mid THEN $nb ";
		/* debug pour les points */
		$_logpts->text(sprintf("%s;%s;%s;%s;%s;%s",
			$mid,
			isset($pts_armee[$mid]) ? $pts_armee[$mid] : 0,
			isset($src_array[$mid]['src_nb']) ? $src_array[$mid]['src_nb'] : 0,
			isset($btc_array[$mid]['btc_vie_tot']) ? $btc_array[$mid]['btc_vie_tot'] : 0,
			isset($hro_array[$mid]['hro_xp']) ? $hro_array[$mid]['hro_xp'] : 0,
			round($nb)
		));
	}

	if($sql_total) {
		$sql="UPDATE ".$_sql->prebdd."mbr SET mbr_points = CASE " . $sql_total;
		$sql.=" ELSE mbr_points END, ";
		$sql.=" mbr_pts_armee = CASE " . $sql_armee . " ELSE mbr_pts_armee END";
		$_sql->query($sql);
	}
}
?>
