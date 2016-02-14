<?php

$log_mbr = "Membres";

function glob_mbr() {
	global $_sql, $_c;

	$sql="DELETE FROM ".$_sql->prebdd."msg_env WHERE menv_date < (NOW() - INTERVAL ".MSG_DEL_OLD." DAY)";
	$_sql->query($sql);
	// supprimer les msg reçu sauf ceux signalés
	$sql="DELETE FROM ".$_sql->prebdd."msg_rec WHERE mrec_date < (NOW() - INTERVAL ".MSG_DEL_OLD." DAY) AND msg_sign = 0";
	$_sql->query($sql);

	$sql="DELETE FROM ".$_sql->prebdd."histo WHERE histo_date < (NOW() - INTERVAL ".HISTO_DEL_OLD." DAY)";
	$_sql->query($sql);

	$sql="UPDATE ".$_sql->prebdd."mbr SET mbr_etat = ".MBR_ETAT_ZZZ." WHERE mbr_ldate < (NOW() - INTERVAL ".ZZZ_TRIGGER." DAY) AND mbr_mid != 1 AND mbr_etat = ".MBR_ETAT_OK;
	$_sql->query($sql);

	/* Chef de région et parrains */
	if($_c == "24h") {
		/* reinit Champions et Champion des Champions */
		$sql = "UPDATE ".$_sql->prebdd."mbr SET mbr_gid = ".GRP_JOUEUR." WHERE mbr_gid IN (".GRP_CHEF_REG.','.GRP_CHAMP_REG.')';
		$_sql->query($sql);

		$sql = "SELECT MAX( mbr_points ) as mbr_points, map_region FROM ".$_sql->prebdd."mbr ";
		$sql.= "JOIN ".$_sql->prebdd."map ON map_cid = mbr_mapcid ";
		$sql.= "WHERE mbr_gid = ".GRP_JOUEUR." ";
		$sql.= " AND mbr_etat = " . MBR_ETAT_OK;
		$sql.= " GROUP BY map_region ";
		$points = $_sql->make_array($sql);

		foreach($points as $value) {
			$pts = $value['mbr_points'];
			$reg = $value['map_region'];

			$sql = "SELECT mbr_mid FROM ".$_sql->prebdd."mbr ";
			$sql.= "JOIN ".$_sql->prebdd."map ON map_cid = mbr_mapcid ";
			$sql.= "WHERE mbr_points = $pts AND map_region = $reg AND mbr_gid = ".GRP_JOUEUR;
			$sql.= " AND mbr_etat = " . MBR_ETAT_OK;
			$mids = $_sql->make_array($sql);

			foreach($mids as $value) {
				$mid = $value['mbr_mid'];

				$new = array();
				$new['gid'] = GRP_CHEF_REG;
				edit_mbr($mid, $new);
			}
		}

		/* Champion des Champions */
		$sql = "SELECT mbr_mid FROM ".$_sql->prebdd."mbr 
			WHERE mbr_points=(SELECT MAX(mbr_points) FROM ".$_sql->prebdd."mbr WHERE mbr_gid = ".GRP_CHEF_REG.") ";
		$champ = $_sql->make_array($sql);
		if(!empty($champ)){ // si existe un champion dans cette province
			$new['gid'] = GRP_CHAMP_REG;
			edit_mbr($champ[0]['mbr_mid'], $new);
		}

		/* effacer puis remettre les récompenses liées au parrainage */
		$sql = "SELECT mbr_parrain, COUNT(*) as mbr_filleuls FROM ".$_sql->prebdd."mbr ";
		$sql.= "WHERE mbr_parrain <> 0 ";
		$sql.= " GROUP BY mbr_parrain HAVING mbr_filleuls >= ".PARRAIN_GRD1;
		$parrains = $_sql->make_array($sql);

		del_rec(NULL, 7);
		del_rec(NULL, 8);
		del_rec(NULL, 9);
		foreach ($parrains as $value)
		{
			$nb = $value['mbr_filleuls'];
			$mid = $value['mbr_parrain'];
			if ($nb >= PARRAIN_GRD3)
				$type = 9;
			else if ($nb >= PARRAIN_GRD2)
				$type = 8;
			else if ($nb >= PARRAIN_GRD1)
				$type = 7;
			else
				continue;
			add_rec($mid, $type);
		}

	}
}

function mbr_mbr( &$user) {
	global $_sql;
	// soigner le heros s'il est au village
	if (isset($user['hro']) && $user['hro']['leg_cid'] == $user['mbr_mapcid']) {
		$vie_max = get_conf_gen($user['mbr_race'], 'unt', $user['hro']['hro_type'], 'vie');
		// s'il n'est pas mort et qu'il n'est pas au max
		if ($user['hro']['hro_vie'] < $vie_max && $user['hro']['hro_vie'] > 0) {
			$addvie = 5; // soigner le heros de +5PDV

			if ($user['hro']['hro_bonus'] == CP_REGENERATION || $user['hro']['hro_bonus'] == CP_REGENERATION_ORC )
			{ // compétence régénération
				$bonus = get_conf_gen($user['mbr_race'], 'comp', $user['hro']['hro_bonus'], 'bonus');
				$addvie = $addvie * (1 + $bonus / 100);
			}

			$vie = $user['hro']['hro_vie'] + $addvie; // soigner le heros de +5PDV
			if ($vie > $vie_max) $vie = $vie_max;
			$sql = 'UPDATE '.$_sql->prebdd."hero SET hro_vie = $vie WHERE hro_lid = ".$user['hro']['hro_lid'];
			$_sql->query($sql);
		}
	}
}

?>
