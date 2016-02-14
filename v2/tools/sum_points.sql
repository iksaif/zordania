SELECT COUNT(*) as src_nb,src_mid
FROM zrd_src GROUP BY src_mid


SELECT SUM(unt_nb) as unt_nb, unt_type,leg_mid 
FROM zrd_leg
JOIN zrd_unt ON unt_lid = leg_id
GROUP BY leg_mid,unt_type

SELECT SUM(leg_xp) as leg_xp,leg_mid
FROM zrd_leg GROUP BY leg_mid

SELECT SUM(btc_vie) as btc_vie_tot, btc_mid
FROM zrd_btc GROUP BY btc_mid

	$pts_btc = array();
	$pts_armee = array();
	foreach($mbr_array as $mid => $value){
		$pts_btc[$mid] = 0;
		$pts_armee[$mid] = 0;
		/* points des XP heros */
		if (isset($hro_array[$mid]))
			$pts_armee[$mid] += $hro_array[$mid]['hro_xp'];
	}
	/* points des batiments */
	foreach($btc_array as $key => $value) {
		$mid = $value['btc_mid'];
		if(!isset($mbr_array[$mid]))
			continue;

		$race = $mbr_array[$mid]["mbr_race"];

		$pts_btc[$mid] += ((int) $value['btc_vie_tot'] / 3);
		//* ((int) get_conf_gen($race, "race_cfg", "modif_pts_btc")) / 3;
	}
	/* points des unites (civils et militaires) */
	foreach($unt_array as $key => $value) {
		$mid = $value['leg_mid'];
		if(!isset($mbr_array[$mid]))
			continue;
		$race = $mbr_array[$mid]["mbr_race"];

		$role = get_conf_gen($race, "unt", $value['unt_type'], "role");
		if ($role != TYPE_UNT_CIVIL) {
			$atq_btc = get_conf_gen($race, "unt", $value['unt_type'], "atq_btc");
			if(empty($atq_btc)) $atq_btc = 0;
			$pts = get_conf_gen($race, "unt", $value['unt_type'], "def") +
				get_conf_gen($race, "unt", $value['unt_type'], "atq_unt") + 
				$atq_btc + 
				get_conf_gen($race, "unt", $value['unt_type'], "vie");
			$pts_armee[$mid] += $value['unt_nb'] * $pts;
		}
	}
	/* points des recherches */
	foreach($src_array as $key => $value) {
		$mid = $value['src_mid'];
		if(!isset($mbr_array[$mid]))
			continue;

		$race = $mbr_array[$mid]["mbr_race"];
		$nbmax = get_conf_gen($race, "race_cfg", "src_nb") + 1;

		$ratio = $value['src_nb'] / $nbmax;
		$pts_btc[$mid] += $ratio * 10000;
	}
	/* points des XP lÃ©gions
	foreach($leg_array as $key => $value) {
		$mid = $value['leg_mid'];
		if(!isset($mbr_array[$mid]))
			continue;
		$pts_armee[$mid] += ($value['leg_xp'] * 25);
	} */

	$sql = "";
	$sql_armee = "";
	foreach($pts_btc as $mid => $nb) {
		$nb = round($nb * get_conf_gen($race, "race_cfg", "modif_pts_btc"));
		if(isset($mbr_array[$mid])){
			$nb += round($pts_armee[$mid]); // points totaux
			$sql_armee.=" WHEN mbr_mid=$mid THEN ".round($pts_armee[$mid])." ";
		}
		$sql.=" WHEN mbr_mid=$mid THEN $nb ";
	}

	if($sql) {
		$sql="UPDATE ".zrd_mbr SET mbr_points = CASE " . $sql;
		$sql.=" ELSE mbr_points END, ";
		$sql.=" mbr_pts_armee = CASE " . $sql_armee . " ELSE mbr_pts_armee END";
		$_sql->query($sql);
	}
}
?>
