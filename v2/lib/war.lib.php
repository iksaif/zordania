<?php
function add_atq($mid1, $mid2, $lid1, $lid2, $bilan, $cid) {
// ajoute l'attaque de $mid1 (attaquant) sur $mid2 (defenseur) avec le $bilan
// $bilan contient tout, les autres variables sont redondantes
	global $_sql;

	$mid1 = protect($mid1, "uint");
	$mid2 = protect($mid2, "uint");
	$lid1 = protect($lid1, "uint");
	$lid2 = protect($lid2, "uint");
	$cid = protect($cid, "uint");
	$bilan = protect($bilan, "serialize");

	$sql = "INSERT INTO ".$_sql->prebdd."atq VALUES ";
	$sql.= "(NULL,$mid1, $mid2, $lid1, $lid2, ".ATQ_TYPE_ATQ.", NOW(), $cid, '$bilan')";

	if ($_sql->query($sql)) // récupérer l'identifiant créé
		return $_sql->insert_id();
	else
		return false;
}

function add_atq_all($bilan) {
// ajoute l'attaque dans zrd_atq et tous les liens dans zrd_atq_mbr
	global $_sql;

	$mid1 = protect($bilan['att']['leg_mid'], "uint");
	$lid1 = protect($bilan['att']['leg_id'], "uint");
	$cid = protect($bilan['att']['leg_cid'], "uint");
	$mid2 = protect($bilan['mid2'], 'uint');

	$add_atq = 0;
	$arr_sql = array();
	foreach($bilan['def'] as $lid => $leg){
		if(!$add_atq && $leg['leg_mid'] == $mid2){ // ajouter le résultat de l'attaque
			$lid2 = protect($leg['leg_id'], "uint");
			$add_atq = add_atq($mid1, $mid2, $lid1, $lid2, $bilan, $cid);
			if(!$add_atq) die('erreur add_atq');
			break;
		}
	}
	if (!$add_atq) return false;

	foreach($bilan['def'] as $lid => $leg){
		$lid_def = $leg['leg_mid'];
		$arr_sql[$lid_def] = "($add_atq,$lid_def)";
	}
	
	if (!empty($arr_sql)) { /* s'il y a eu defenseurs */
		$sql = "INSERT INTO ".$_sql->prebdd."atq_mbr (atq_aid, atq_mid) VALUES ". implode(',', $arr_sql).';';
			
		$_sql->query($sql);
	}
}

function del_atq($mid, $aid = 0) {
	global $_sql;

	$mid = protect($mid, "uint");
	$aid = protect($aid, "uint");

	$sql = "DELETE FROM ".$_sql->prebdd."atq_mbr ";
	if($aid)
		$sql.= "WHERE atq_aid = $aid ";
	else
		$sql.= "WHERE atq_aid IN (
		SELECT atq_aid FROM ".$_sql->prebdd."atq
		WHERE atq_mid1 = $mid )";
	$rows = $_sql->affected_rows($_sql->query($sql));

	$sql = "DELETE FROM ".$_sql->prebdd."atq ";
	$sql.= "WHERE atq_mid1 = $mid ";
	if($aid) $sql.= "AND atq_aid = $aid ";

	return $rows + $_sql->affected_rows($_sql->query($sql));
}

function get_atq($mid, $cond = array()) {
	$cond['mid'] = $mid;
	return get_atq_gen($cond);
}

function get_atq_nb($mid, $cond = array()) {
	$cond['count'] = true;
	return get_atq($mid, $cond);
}

// compte le nombre de 'vraies' attaques (i.e. on ne compte pas l'espion fake)
function get_atq_vrai($mid, $cond = array()){
	$cond = array();
	$cond['type'][] = ATQ_TYPE_DEF;
	$cond['mid'] = $mid;
	$atq_array = get_atq_gen($cond);
	$nb_atq = 0;
	foreach($atq_array as $atq){
		$nb_dead = 0;
		// additionner les x rangs de la légion
		foreach($atq['atq_bilan']['def'] as $lid => $leg)
			if(isset($leg['pertes']['unt']))
				foreach($leg['pertes']['unt'] as $uid => $nb)
					if($nb > 0) { // compter l'atq et passer à la suivante
						$nb_atq++;
						break;
					}
	}
	return $nb_atq;
}

function get_atq_gen($cond) { /* mid = attaquant, mid2 = defenseur */
	global $_sql;

	$mid = 0; $mid2 = 0; $type = array(ATQ_TYPE_ATQ, ATQ_TYPE_DEF);
	$lite = false; $count = false; $limite1 = 0; $limite2 = 0; $aid = 0;
	$limite = 0; $last = false;

	$cond = protect($cond, "array");
	if(isset($cond['limite1'])) {
		$limite1 = protect($cond['limite1'], "uint");
		$limite++;
	}
	if(isset($cond['limite2'])) {
		$limite2 = protect($cond['limite2'], "uint");
		$limite++;
	}
	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	if(isset($cond['mid2']))
		$mid2 = protect($cond['mid2'], "uint");
	if(isset($cond['lid']))
		$lid = protect($cond['lid'], "array");
	if(isset($cond['aid']))
		$aid = protect($cond['aid'], 'uint');
	if(isset($cond['type']))
		$type = protect($cond['type'], "array");
	if(isset($cond['lite']))
		$lite = protect($cond['lite'], "bool");
	if(isset($cond['last']))
		$last = protect($cond['last'], "bool");
	if(isset($cond['count']))
		$count = protect($cond['count'], "bool");

	if($count)
		$sql = "SELECT COUNT(*) AS nbatq ";
	else {
		$sql = "SELECT atq_aid, _DATE_FORMAT(atq_date) as atq_date_formated, ";
		if(!$lite)
			$sql.= " atq_bilan, atq_cid, ";
		$sql.= " atq_mid1, atq_lid1, ";
		$sql.= " atq_mid2, atq_lid2, ";
		if(!$lite)
			$sql.= "b.mbr_race as mbr_race2, b.mbr_pseudo as mbr_pseudo2, b.mbr_gid as mbr_gid2 ";
	}
	$sql.= "FROM ".$_sql->prebdd."atq ";
	if ($mid && count($type) == 1 && $type[0] == ATQ_TYPE_DEF)
		$sql.= "JOIN ".$_sql->prebdd."atq_mbr USING(atq_aid) ";
	if(!$lite && !$count)
		if (count($type) == 1 && $type[0] == ATQ_TYPE_DEF)
			$sql.= "JOIN ".$_sql->prebdd."mbr AS b ON  b.mbr_mid = atq_mid2 ";
		else
			$sql.= "JOIN ".$_sql->prebdd."mbr AS b ON  b.mbr_mid = atq_mid2 ";
	if(!$mid && !$type && !$lid && !$aid)
		return;

	$sql_where = array();
	if($mid && count($type) == 1) { /* attaque OU defense sinon c'est pas un filtre */
		if ($type[0] == ATQ_TYPE_ATQ) /* attaque:  mid1 */
			$sql_where[] = "atq_mid1 = $mid";
		else /* défense : mid dans la table atq_mbr */
			$sql_where[] = "atq_mid = $mid";
	} else if($mid)
		$sql_where[] = "atq_mid1 = $mid";

	if($mid2) {
		$sql_where[] = "atq_mid2 = $mid2";
		if ($last)
			$sql_where[] = "atq_date > (NOW() - INTERVAL 24 HOUR)";
	}
	if($aid)
		$sql_where[] = "atq_aid = $aid";
	if(!empty($sql_where))
		$sql .= " WHERE ".implode(" AND ", $sql_where);

	$sql.= " ORDER BY atq_date DESC ";

	if($limite)
		if($limite == 2)
			$sql .= " LIMIT $limite1, $limite2 ";
		else
			$sql .= " LIMIT $limite1 ";
	if($count)
		return $_sql->result($_sql->query($sql), 0, 'nbatq');
	else {
		if($lite)
			return $_sql->make_array($sql);
		else {
			$array = $_sql->make_array($sql);
			foreach($array as $key => $value)
				$array[$key]['atq_bilan'] = safe_unserialize($value['atq_bilan']);
			return $array;
		}
	}
}

function cls_atq($mid) {
	return del_atq($mid);
}

/* fonctions pour calcul des pertes et butins ... */

function w_butin($pertes, $race, $butin = array()){
/* calcul du butin : 33% de chaque ressource nécessaire
IN : $pertes = array (type => nombre d'unités)
     $race
     $butin (optionnel) = butin déjà récupéré à cumuler
OUT: array (type => nombre) des butins
*/
	if(empty($pertes)) return $butin;
	foreach ($pertes as $type => $nb_pertes) {
		$prix = get_conf_gen($race,"unt",$type,"prix_res");
		if ($prix && $type) {
			foreach($prix as $res => $prix_uni) {
				$nb = round($prix_uni * $nb_pertes / 3);// 33%
				if($nb) {
					if(!isset($butin[$res]))
						$butin[$res] = 0;
					$butin[$res] += $nb;
				}
			}
		}
	}
	return $butin;
}

?>
