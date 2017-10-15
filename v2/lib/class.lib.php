<?php
function make_class($type, $race = 0, $region = 0)
{
	global $_sql;
	$type = protect($type, "uint");
	$race = protect($race, "uint");
	$region = protect($region, "uint");

	switch($type)
	{
		case 1: //Or
			$sql ="SELECT mbr_gid,res_type1 as res_nb,mbr_mid,mbr_pseudo,mbr_race, mbr_pts_armee, mbr_etat,";
			$sql.= " ambr_etat, mbr_mapcid, IF(ambr_etat=".ALL_ETAT_DEM.", 0, IFNULL(ambr_aid,0)) as al_aid, ";
			$sql.= " IF(ambr_etat=".ALL_ETAT_DEM.", NULL, al_name) as al_name  ";
			$sql.="FROM ".$_sql->prebdd."res LEFT JOIN ".$_sql->prebdd."mbr ";
			$sql.="ON mbr_mid=res_mid ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al ON ambr_aid = al_aid ";
			if ($region) $sql .= "JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
			$sql.="WHERE res_type1 > 0 AND mbr_etat = ".MBR_ETAT_OK. " ";
			if($race) $sql.=" AND mbr_race = $race ";
			if ($region) $sql .= " AND map_region = $region ";
			$sql.="ORDER BY res_type1 DESC LIMIT 50";
			break;
		case 2: //Xp (par légion)
			$sql ="SELECT mbr_gid,leg_id,leg_xp,leg_name,mbr_mid,mbr_pseudo,mbr_pts_armee,mbr_race, ";
			$sql.= " ambr_etat,mbr_mapcid, IF(ambr_etat=".ALL_ETAT_DEM.", 0, IFNULL(ambr_aid,0)) as al_aid, ";
			$sql.= " IF(ambr_etat=".ALL_ETAT_DEM.", NULL, al_name) as al_name  ";
			$sql.="FROM ".$_sql->prebdd."leg LEFT JOIN ".$_sql->prebdd."mbr ";
			$sql.="ON mbr_mid=leg_mid ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al ON ambr_aid = al_aid ";
			if ($region) $sql .= "JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
			$sql.="WHERE leg_xp > 0 AND mbr_etat = ".MBR_ETAT_OK. " ";
			if($race) $sql.=" AND mbr_race = $race ";
			if ($region) $sql .= " AND map_region = $region ";
			$sql.="ORDER BY leg_xp DESC LIMIT 50 ";
			break;
		case 3: // points
			$sql ="SELECT mbr_gid,mbr_mid,mbr_pseudo,mbr_points,mbr_mapcid, mbr_pts_armee,mbr_race, ";
			$sql.= " mbr_etat, ambr_etat, IF(ambr_etat=".ALL_ETAT_DEM.", 0, IFNULL(ambr_aid,0)) as al_aid, ";
			$sql.= " IF(ambr_etat=".ALL_ETAT_DEM.", NULL, al_name) as al_name  ";
			$sql.="FROM ".$_sql->prebdd."mbr ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al ON ambr_aid = al_aid ";
			if ($region) $sql .= "JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
			$sql.="WHERE mbr_points > 0 AND mbr_etat = ".MBR_ETAT_OK. " ";
			if($race) $sql.=" AND mbr_race = $race ";
			if ($region) $sql .= " AND map_region = $region ";
			$sql.="ORDER BY mbr_points DESC LIMIT 50";
			break;
		case 4: // place et population
			$sql ="SELECT mbr_gid,mbr_mid,mbr_pseudo,mbr_place,mbr_pts_armee,mbr_population,mbr_race, ";
			$sql.= " mbr_etat, mbr_mapcid, ambr_etat, IF(ambr_etat=".ALL_ETAT_DEM.", 0, IFNULL(ambr_aid,0)) as al_aid, ";
			$sql.= " IF(ambr_etat=".ALL_ETAT_DEM.", NULL, al_name) as al_name  ";
			$sql.="FROM ".$_sql->prebdd."mbr ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al ON ambr_aid = al_aid ";
			if ($region) $sql .= "JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
			$sql.="WHERE mbr_population > 0 AND mbr_etat = ".MBR_ETAT_OK;
			if($race) $sql.=" AND mbr_race = $race ";
			if ($region) $sql .= " AND map_region = $region ";
			$sql.=" ORDER BY mbr_population DESC LIMIT 50";
			break;
		case 5: // alliances
			$sql="SELECT al_aid,al_name,al_nb_mbr,al_mid,mbr_pseudo,al_points,al_open ";
			$sql.="FROM ".$_sql->prebdd."al ";
			$sql.="LEFT JOIN ".$_sql->prebdd."mbr ON mbr_mid = al_mid ";
			if ($region) $sql .= "JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
			if($race) $sql.=" WHERE mbr_race = $race ";
			if ($region) $sql .= " AND map_region = $region ";
			$sql.= ($race ? ' AND ' : ' WHERE ' ) . ' al_points > 0 ';
			$sql.="ORDER BY al_points DESC LIMIT 50";
			break;
		case 6: // XP héros
			$sql = "SELECT hro_id, hro_mid, hro_nom, hro_type, hro_lid, hro_xp, hro_vie, hro_bonus AS bonus, 
				hro_bonus_from, hro_bonus_to AS bonus_to, mbr_gid,mbr_mid,mbr_pseudo,mbr_race ";
			$sql.= "FROM ".$_sql->prebdd."hero ";
			$sql.="INNER JOIN ".$_sql->prebdd."mbr ON hro_mid = mbr_mid AND mbr_etat = ".MBR_ETAT_OK;
			if ($region) $sql .= " JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
			if($race) $sql.=" WHERE mbr_race = $race ";
			if ($region) $sql .= " AND map_region = $region ";
			$sql.=" ORDER BY hro_xp DESC LIMIT 50";
			break;
		case 7: // force armée
			$sql = "SELECT mbr_gid,mbr_mid,mbr_pseudo, mbr_pts_armee, mbr_race, mbr_etat, mbr_mapcid,";
			$sql.= " ambr_etat, IF(ambr_etat=".ALL_ETAT_DEM.", 0, IFNULL(ambr_aid,0)) as al_aid, ";
			$sql.= " IF(ambr_etat=".ALL_ETAT_DEM.", NULL, al_name) as al_name  ";
			$sql.="FROM ".$_sql->prebdd."mbr ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
			$sql.="LEFT JOIN ".$_sql->prebdd."al ON ambr_aid = al_aid ";
			if ($region) $sql .= "JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
			$sql.="WHERE mbr_pts_armee > 0 AND mbr_etat = ".MBR_ETAT_OK. " ";
			if($race) $sql.=" AND mbr_race = $race ";
			if ($region) $sql .= " AND map_region = $region ";
			$sql.="ORDER BY mbr_pts_armee DESC LIMIT 50";
			break;
		default:
			return array();
	}
	return $_sql->make_array($sql);
}

?>
