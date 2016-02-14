<?php
function get_map($mid,$x1,$y1,$x2,$y2,$zoom = 1)
{/* infos sur les cases les villages et les légions sur le carré visible */
	global $_sql;
	
	$mid = protect($mid, "uint");
	$x1 = protect($x1, "uint");
	$y1 = protect($y1, "uint");
	$x2 = protect($x2, "uint");
	$y2 = protect($y2, "uint");
	
	$return = array();
	
	/* Infos sur les cases */
	$sql="SELECT * FROM ".$_sql->prebdd."map 
		WHERE (map_x BETWEEN $x1 AND  $x2) AND (map_y BETWEEN $y1 AND $y2)";

	$cases = $_sql->make_array($sql);
		if(!count($cases)) return $return;
	
	/* On indexe par x-y, c'est franchement plus pratique */
	foreach($cases as $result) {
		$return[$result['map_y']][$result['map_x']] = $result;
	}

	/* Personnes par ici */
	$sql="SELECT map_x, map_y,mbr_mid,mbr_pseudo,mbr_points,mbr_etat,mbr_race 
		FROM ".$_sql->prebdd."mbr 
		JOIN ".$_sql->prebdd."map ON map_cid=mbr_mapcid 
		WHERE mbr_etat IN (".MBR_ETAT_OK.", ".MBR_ETAT_ZZZ.") AND (map_x BETWEEN $x1 AND  $x2) AND (map_y BETWEEN $y1 AND $y2)"; 
		
	$members = $_sql->make_array($sql);
	foreach($members as $result)
	{
		$x = $result['map_x']; unset($result['map_x']);
		$y = $result['map_y']; unset($result['map_y']);
		$return[$y][$x]['members'][] = $result;
	}
	
	/* Légions par ici, sauf légions invisibles */
	$sql="SELECT map_x, map_y, leg_id,mbr_pseudo,mbr_etat,mbr_race, leg_name, hro_bonus  
		FROM ".$_sql->prebdd."leg
		LEFT JOIN ".$_sql->prebdd."hero ON leg_id = hro_lid
		JOIN ".$_sql->prebdd."mbr  ON leg_mid=mbr_mid 
		JOIN ".$_sql->prebdd."map ON map_cid = leg_cid 
		WHERE leg_etat IN (".LEG_ETAT_DPL.",".LEG_ETAT_RET.",".LEG_ETAT_ALL.",".LEG_ETAT_ATQ.",
		".LEG_ETAT_GRN.",".LEG_ETAT_POS.",".LEG_ETAT_VLG.") AND IFNULL(hro_bonus,0) <> ".CP_INVISIBILITE."
		AND (map_x BETWEEN $x1 AND  $x2) AND (map_y BETWEEN $y1 AND $y2) ";

	$legions = $_sql->make_array($sql);
	
	foreach($legions as $result)
	{
		$x = $result['map_x']; unset($result['map_x']);
		$y = $result['map_y']; unset($result['map_y']);
		$return[$y][$x]['legions'][] = $result;
	}
		
	
	return $return;
}

/* convertir coord x,y en un map_cid */
function get_cid($x, $y) {
	$x = protect($x, 'uint');
	$y = protect($y, 'uint');
	global $_sql;

	if($x and $y){
		$sql = "SELECT map_cid FROM ".$_sql->prebdd."map WHERE map_x=$x AND map_y=$y";
		return $_sql->result($_sql->query($sql),0);
	}
	else return false;
}

function get_square($cid, $dst = false)
{
	$array = get_square_gen(array($cid), $dst);
	return $array ? $array[0] : array();
}

/* informations sur un map_cid
$dst = array(x, y) => distance à ce point
$dst = true => distance par rapport au village $_user
*/
function get_square_gen($list_cid, $dst = false)
{
	global $_sql;
	$list_cid = protect($list_cid, array("uint"));
	if(empty($list_cid)) return false;

	$cid = implode(',',$list_cid);
	if(isset($dst['x']) && isset($dst['y'])) {
		$dst['x'] = protect($dst['x'], "uint");
		$dst['y'] = protect($dst['y'], "uint");
	} else if($dst && can_d(DROIT_PLAY)) {
		global $_user;
		$dst = array();
		$dst['x'] = $_user['map_x'];
		$dst['y'] = $_user['map_y'];
	}

	$sql ="SELECT map_type,map_rand,map_x,map_y,map_climat,map_region,";
	if(count($dst) == 2)
		$sql .= " GREATEST(ABS( ".$dst['x']." - map_x ), ABS( ".$dst['y']."- map_y)) AS map_dst, ";
	$sql.= "map_cid,mbr_mid,mbr_pseudo,mbr_gid,mbr_etat,mbr_points,mbr_race,hro_bonus FROM ".$_sql->prebdd."map ";
	$sql.=" LEFT JOIN ".$_sql->prebdd."mbr ON map_cid = mbr_mapcid AND mbr_etat IN (".MBR_ETAT_OK.", ".MBR_ETAT_ZZZ.")";
	$sql.=" LEFT JOIN ".$_sql->prebdd."leg ON leg_cid = map_cid";
	$sql.=" LEFT JOIN ".$_sql->prebdd."hero ON hro_lid = leg_id";
	$sql.=" WHERE map_cid IN ($cid)";
	return  $_sql->make_array($sql);
}

function get_square_leg($cid)/* légions présentes en $cid */
{
	return get_square_leg_gen(array($cid));
}

function get_square_leg_gen($list_cid)/* légions présentes en $cid = array(cid)*/
{
	global $_sql;
	$list_cid = protect($list_cid, array("uint"));
	if(empty($list_cid)) return false;

	$cid = implode(',',$list_cid);
	$sql ="SELECT map_type,map_rand,map_x,map_y,map_climat,map_region, 
		mbr_mid,mbr_pseudo,mbr_race, mbr_gid, mbr_points, mbr_pts_armee, mbr_etat, 
		hro_bonus,
		leg_mid, leg_name, leg_xp, leg_id, leg_cid, leg_etat, IFNULL(ambr_aid, 0) as ambr_aid ";
	$sql.= " FROM ".$_sql->prebdd."map ";
	$sql.=" JOIN ".$_sql->prebdd."leg ON map_cid = leg_cid ";
	$sql.=" LEFT JOIN ".$_sql->prebdd."hero ON leg_id = hro_lid ";
	$sql.=" JOIN ".$_sql->prebdd."mbr ON mbr_mid = leg_mid ";
	$sql.=" LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
	$sql.=" WHERE map_cid IN ($cid) AND mbr_etat = ".MBR_ETAT_OK." AND leg_etat != ".LEG_ETAT_BTC
		." AND IFNULL(hro_bonus,0) <> ".CP_INVISIBILITE;

	return $_sql->make_array($sql);
}

function get_rand_map($rid) {
	global $_sql;

	$rid = protect($rid, "uint");

	$sql = "SELECT map_cid FROM ".$_sql->prebdd."map ";
	$sql.= "WHERE map_region = $rid ";
	$sql.= "AND map_type = ".MAP_LIBRE." ";
	$sql.= "ORDER BY RAND() LIMIT 1";
	$res = $_sql->query($sql);
	if(mysql_numrows($res))
		$ncid = $_sql->result($res, 0, 'map_cid');
	else
		$ncid = 0;

	if(!$ncid) {
		$sql = "SELECT map_cid FROM ".$_sql->prebdd."map ";
		$sql.= "WHERE map_type != ".MAP_VILLAGE." ";
		$sql.= "AND map_region = $rid ";
		$sql.= "ORDER BY RAND() LIMIT 1";
		$res = $_sql->query($sql);
		$ncid = $_sql->result($res, 0, 'map_cid');
	}
	return $ncid;
}

/* liste des emplacememnts libres autour de x,y */
function select_free_map($x, $y) {
	global $_sql;

	$x = protect($x, "uint");
	$y = protect($y, "uint");

	$sql = "SELECT *, round( sqrt( pow(map_x-$x,2) + pow(map_y-$y,2)), 3) AS distance ";
	$sql.= "FROM ".$_sql->prebdd."map ";
	$sql.= "WHERE map_type = ".MAP_LIBRE." ";
	$sql.= "ORDER BY distance LIMIT 0 , 5";
	$res = $_sql->index_array($sql, 'map_cid');

	return $res;
}

function get_regions_infos($regions) {
	global $_sql, $_regions, $_races;

	$regions = protect($regions, "array");

	$sql = "SELECT COUNT(*) mbr_nb, mbr_race, map_region ";
	$sql.= " FROM ".$_sql->prebdd."mbr";
	$sql.= " JOIN ".$_sql->prebdd."map ON map_cid = mbr_mapcid";
	$sql.= " WHERE mbr_etat = ".MBR_ETAT_OK." ";
	if($regions) {
		$sql.= " AND map_region IN (";
		foreach($regions as $rid => $value)
			$sql .= protect($rid, "uint").",";

		$sql = substr($sql, 0, strlen($sql)-1);
		$sql.= ")";
	}
	$sql.= " GROUP BY map_region, mbr_race";

	$infos = $_sql->make_array($sql);

	$sum = array('total' => 0);
	foreach($infos as $value) {
		$sum['total'] += $value['mbr_nb'];

		if(!isset($sum[$value['map_region']]))
			$sum[$value['map_region']]['total'] = $value['mbr_nb'];
		else
			$sum[$value['map_region']]['total'] += $value['mbr_nb'];

		if(!isset($sum[$value['map_region']][$value['mbr_race']]))
			$sum[$value['map_region']][$value['mbr_race']] = $value['mbr_nb'];
		else
			$sum[$value['map_region']][$value['mbr_race']] += $value['mbr_nb'];
	}


	$libre = array();
	foreach($_regions as $rid => $val) {
		$total = isset($sum[$rid]) ? $sum[$rid]['total'] : 0;
		foreach($_races as $race => $visible) {
			if(!$_regions[$rid][$race])
				$libre[$rid][$race] = 0;
			else if(!$total)
				$libre[$rid][$race] = 1;
			else
				$libre[$rid][$race] = ceil($total * $_regions[$rid][$race] / 100);
		}
	}

	return array('libre' => $libre, 'occ' => $sum);
}

function ini_map($mid, $cid) {
	global $_sql;

	$cid = protect($cid, "uint");

	$sql = "UPDATE ".$_sql->prebdd."map SET map_type = ".MAP_VILLAGE." WHERE map_cid = $cid ";
	$_sql->query($sql);
}

/* Désinitialise la carte pour $mid
 */
function cls_map($mid, $cid) {
	global $_sql;

	$cid = protect($cid, "uint");

	$sql = "UPDATE ".$_sql->prebdd."map SET map_type = ".MAP_LIBRE." WHERE map_cid = $cid ";
	$_sql->query($sql);
	return $_sql->affected_rows();
}


?>
