<?php
/*
* can_src(), ini_src() ne peuvent être utilisés que dans le site, et pour quelqu'un de connecté
* avec le bon $_user['race']
*/

/* Rajouter la recherche dont la conf est $conf en prévision */
function scl_src($mid, $type) {
	global $_sql;

	$mid = protect($mid, "uint");
	$type = protect($type, "uint");

	add_src($mid, $type);
	$tours = get_conf("src", $type, "tours");

	$sql = "INSERT INTO ".$_sql->prebdd."src_todo VALUES ($mid, $type, $tours, NOW())";
	return $_sql->query($sql);
}

/* Ajoute une recherche pour de vrai */
function add_src($mid, $type) {
	global $_sql;

	$mid = protect($mid, "uint");
	$type = protect($type, "uint");

	$sql = "INSERT INTO ".$_sql->prebdd."src VALUES ($mid, $type)";
	return $_sql->query($sql);
}

/* Verifie qu'on peut faire telle ou telle recherche */
function can_src($mid, $type, & $cache = array()) {
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	$cache = protect($cache, "array");

	$bad_src = array('need_src' => array(), 'need_no_src' => array());
	$bad_btc = array();
	$bad_res = array();
	$done = false;
	
	if(!get_conf("src", $type))
		return array("do_not_exist" => true);

	/* Bâtiments */
	$need_btc = get_conf("src", $type, "need_btc");
	$cond_btc = $need_btc;

	if(!isset($cache['btc_done'])) {
		$have_btc = get_nb_btc_done($mid, $cond_btc);
		$have_btc = index_array($have_btc, "btc_type");
	} else
		$have_btc = $cache['btc_done'];

	/* Recherches */
	$cond_src = array($type);

	$need_src = get_conf("src", $type, "need_src");
	$need_no_src = get_conf("src", $type, "need_no_src");
	$cond_src = array_merge($need_src,$need_no_src);

	if(!isset($cache['src'])) {
		$have_src = get_src_done($mid, $cond_src);
		$have_src = index_array($have_src, "src_type");
	} else
		$have_src = $cache['src'];

	if(!isset($cache['src_todo'])) {
		$todo_src = get_src_todo($mid, array($type));
		$todo_src = index_array($todo_src, "src_type");
	} else
		$todo_src = $cache['src_todo'];

	/* Les recherches qu'on ne doit pas avoir */
	foreach($need_no_src as $src_type) {
		if(isset($have_src[$src_type]))
			$bad_src['need_no_src'][$src_type] = $src_type;
	}

	/* Les recherches qu'il faut avoir */
	foreach($need_src as $src_type) {
		if(!isset($have_src[$src_type]))
			$bad_src['need_src'][$src_type] = $src_type;
	}

	/* La recherche qu'on veut est elle déjà en cours ? */
	$todo = isset($todo_src[$type]);
	$done = (isset($todo_src[$type]) || isset($have_src[$type]));

	/* Ressources */
	$prix_res = get_conf("src", $type, "prix_res");
	$cond_res = array_keys($prix_res);

	if(!isset($cache['res'])) {
		$have_res = get_res_done($mid, $cond_res);
		$have_res = clean_array_res($have_res);
		$have_res = $have_res[0];
	} else
		$have_res = $cache['res'];

	foreach($prix_res as $res_type => $nombre) {
		$diff =  $nombre - $have_res[$res_type];
		if($diff > 0)
			$bad_res[$res_type] =  $diff;
	}

	/* Verifications Bâtiments */
	foreach($need_btc as $btc_type) {
		if(!isset($have_btc[$btc_type]))
			$bad_btc[] = $btc_type;
	}

	return array('need_btc' => $bad_btc, 'need_src' => $bad_src['need_src'], 'need_no_src' => $bad_src['need_no_src'], 'todo' => $todo, 'done' => $done,  'prix_res' => $bad_res);
}

/* Annule la recherche $type */
function cnl_src($mid, $type) {
	global $_sql;

	$mid = protect($mid, "uint");
	$type = protect($type, "uint");

	del_src($mid, $type);

	$sql = "DELETE FROM ".$_sql->prebdd."src_todo WHERE stdo_type = $type AND stdo_mid = $mid";
	$_sql->query($sql);

	return $_sql->affected_rows();
}

/* Supprimer la recherche $type */
function del_src($mid, $type = 0) {
	global $_sql;

	$mid = protect($mid, "uint");
	$type = protect($type, "uint");

	$sql = "DELETE FROM ".$_sql->prebdd."src ";
	$sql.=" WHERE src_mid = $mid ";
	if($type)
		$sql .= " AND src_type = $type";
	
	$_sql->query($sql);

	return $_sql->affected_rows();
}

/* Récupere les recherches de $mid [ et de type $type ] */
function get_src_done($mid, $src = array()) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$src = protect($src, "array");
	$return = array();
	
	$sql = "SELECT src_mid,src_type ";
	$sql.= "FROM ".$_sql->prebdd."src ";
	$sql.= "WHERE src_mid = $mid AND ";
	$sql.= " src_type NOT IN ";
	$sql.= "(SELECT stdo_type FROM ".$_sql->prebdd."src_todo WHERE stdo_mid = $mid)";
	if($src) {
		$sql.= " AND src_type IN ( ";
		foreach($src as $type) {
			$type = protect($type, "uint");
			$sql.= "$type,";
		}
		
		$sql = substr($sql, 0, strlen($sql)-1); /* On vire le 'OR ' en trop */
		$sql.= ")";
	}

	return $_sql->make_array($sql);
}

function get_src_todo($mid, $src = array()) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$src = protect($src, "array");
	$return = array();
	
	$sql = "SELECT stdo_mid,stdo_type, stdo_tours ";
	$sql.= "FROM ".$_sql->prebdd."src_todo ";
	$sql.= "WHERE stdo_mid = $mid ";
	
	if($src) {
		$sql.= " AND stdo_type IN ( ";
		foreach($src as $type) {
			$type = protect($type, "uint");
			$sql.= "$type,";
		}
		
		$sql = substr($sql, 0, strlen($sql)-1); /* On vire le 'OR ' en trop */
		$sql.= ")";
	}
	$sql.= " ORDER BY stdo_time ASC";
	return $_sql->make_array($sql);
}

/* Quand on crée un membre */
function ini_src($mid) {
	$debut = get_conf("race_cfg", "debut", "src");
	foreach($debut as $type) {
		add_src($mid, $type);
	}
}

/* Quand on le vire */
function cls_src($mid) {
	global $_sql;

	$mid = protect($mid, "uint");

	$nb = del_src($mid);
	
	/* les recherches a faire */
	$sql = "DELETE FROM ".$_sql->prebdd."src_todo WHERE stdo_mid = $mid";
	$res = $_sql->query($sql);
	
	return $_sql->affected_rows() + $nb;
}
?>