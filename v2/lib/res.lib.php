<?php
/* Met des ressource en création dans l'ordre du tableau */
function scl_res($mid, $res) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$res = protect($res, "array");

	if(!$res) return;

	$sql = "INSERT INTO ".$_sql->prebdd."res_todo VALUES ";
	foreach($res as $type => $nb) {
		$type = protect($type, "uint");
		$nb = protect($nb, "uint");
		$sql.= " ('', $mid, $type, $nb), ";
	}
	
	$sql = substr($sql, 0, strlen($sql)-2); /* On vire la virgule en trop */
	
	return $_sql->query($sql);
}

/* Annule la création d'une ressources */
function cnl_res($mid, $rid, $nb) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$rid = protect($rid, "uint");
	$nb = protect($nb, "uint");

	$sql = "UPDATE ".$_sql->prebdd."res_todo SET rtdo_nb = rtdo_nb - $nb ";
	$sql .= "WHERE rtdo_mid = $mid AND rtdo_id = $rid";
	$res = $_sql->query($sql);
	
	return $_sql->affected_rows();
}

/* Modifie les ressources d'un membre , mais comparativement (ressources courante + machin) */
function mod_res($mid, $res, $factor = 1) {
	$res = protect($res, "array");
	$factor = protect($factor, "float");
	
	foreach($res as $type => $nb) {
		if($nb && $factor)
			$res[$type] = $nb * $factor;
	}
	return edit_res_gen(array('mid' => $mid, 'comp' => true), $res);
}

/* Modifie le ressources qui remplissent certaines conditions */
function edit_res_gen($cond, $res) {
	global $_sql;
	
	$cond = protect($cond, "array");
	$res = protect($res, "array");
	
	if(!$res) return; /* Rien a faire */
	
	$mid = 0;
	$comp = false;

	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	if(isset($cond['comp']))
		$comp = protect($cond['comp'], "bool");

	$sql = "UPDATE ".$_sql->prebdd."res SET ";
	foreach($res as $type => $nb) {
		
		$type = protect($type, "uint");
		$nb = protect($nb, "int");
		
		$nom = "res_type".$type;
		if($comp)
			$sql .= "$nom = $nb + $nom, ";
		else
			$sql .= "$nom = $nb, ";
	}

	$sql = substr($sql, 0, strlen($sql)-2); /* On vire la virgule en trop */

	if($mid)
		$sql.= " WHERE res_mid = $mid ";

	return $_sql->query($sql);
}

/* Récupère les ressources du joueur */
function get_res_done($mid, $res =  array(), $race = 0, $exc = array()) {
	global $_sql;

	$mid = protect($mid, "uint");
	$res = protect($res, "array");
	$race = protect($race, "uint");
	$exc = protect($exc, "array");
	
	$sql = "SELECT ";
	if(!$res) {
		if($race)
			$nb = get_conf_gen($race, "race_cfg", "res_nb");
		else
			$nb = get_conf("race_cfg", "res_nb");
		for($i = 1; $i <= $nb; ++$i)
			$sql.= "res_type".$i.", ";
	} else {
		if($exc)
			for($i = 1; $i <= 17; $i ++)
				if(!in_array($i, $exc))
					$res[] = $i;
		foreach($res as $type) {
			$type = protect($type, "uint");
			$sql.= "res_type".$type.", ";
		}
	}
	
	$sql = substr($sql, 0, strlen($sql)-2); /* On vire la virgule en trop */
	
	$sql.= " FROM ".$_sql->prebdd."res ";
	$sql.= "WHERE res_mid = $mid ";

	return $_sql->make_array($sql);
}

/* Ressources en cours du joueur */
function get_res_todo($mid, $cond =  array()) {
	global $_sql;

	$res = array(); $rid = 0;

	$mid = protect($mid, "uint");
	$cond = protect($cond, "array");

	if(isset($cond['res']))
		$res = protect($cond['res'], "array");
	if(isset($cond['rid']))
		$rid = protect($cond['rid'], "uint");

	$sql = "SELECT rtdo_id, rtdo_type, rtdo_nb ";
	$sql.= "FROM ".$_sql->prebdd."res_todo ";
	$sql.= "WHERE rtdo_mid = $mid  AND rtdo_nb > 0 ";
	
	if($rid) {
		$sql .= "AND rtdo_id = $rid ";
	}
	
	if($res) {
		$sql.= "AND rtdo_type IN (";
		foreach($res as $type) {
			$type = protect($type, "uint");
			$sql.= "$type,";
		}
			
		$sql = substr($sql, 0, strlen($sql)-1); /* On vire le 'OR ' en trop */
		$sql.= ")";
	}
	$sql.= " ORDER BY rtdo_id ASC";
	return $_sql->make_array($sql);
}

/* Verifie qu'on peut faire telle ou telle ressource */
function can_res($mid, $type, $nb, & $cache = array()) {
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	$cache = protect($cache, "array");

	$bad_src = array();
	$bad_res = array();
	$bad_btc = array();

	if(!get_conf("res", $type))
		return array("do_not_exist" => true);
	
	/* Bâtiments */
	$need_btc = get_conf("res", $type, "need_btc");
	$cond_btc = array($need_btc);

	if(!isset($cache['btc'])) {
		$have_btc = get_nb_btc_done($mid, $cond_btc);
		$have_btc = index_array($have_btc, "btc_type");
	} else
		$have_btc = $cache['btc'];

	/* Recherches */
	$cond_src = array($type);

	$need_src = get_conf("res", $type, "need_src");
	$cond_src = $need_src;

	if(!isset($cache['src'])) {
		$have_src = get_src_done($mid, $cond_src);
		$have_src = index_array($have_src, "src_type");
	} else
		$have_src = $cache['src'];
	
	/* Ressources */
	$prix_res = get_conf("res", $type, "prix_res");
	$cond_res = array_keys($prix_res);

	if(!isset($cache['res'])) {
		$have_res = get_res_done($mid, $cond_res);
		$have_res = clean_array_res($have_res);
		$have_res = $have_res[0];
	} else
		$have_res = $cache['res'];

	

	/* Les recherches qu'il faut avoir */
	foreach($need_src as $src_type) {
		if(!isset($have_src[$src_type]))
			$bad_src['need_src'][] = $src_type;
	}

	/* Vérifications ressources */
	foreach($prix_res as $res_type => $nombre) {
		$diff =  $nombre * $nb - $have_res[$res_type];
		if($diff > 0)
			$bad_res[$res_type] =  $diff;
	}

	/* Verifications Bâtiments */
	if(!isset($have_btc[$need_btc]))
		$bad_btc = $cond_btc;

	return array('need_src' => $bad_src, 'need_btc' => $bad_btc, 'prix_res' => $bad_res);
}

/* Permet d'avoir un tableau plus utilisable lors d'un get_res_done
 * Le array qu'on lui file doit être directement celui qui sort de get_res_done ou équivalent
 */
function clean_array_res($array) {
	$array = protect($array, "array");

	if(!$array) return array();

	$return = array();
	foreach($array as $line => $value) {
		foreach($value as $key => $val) {
			$key = str_replace("res_type","",$key);
			$return[$line][$key] = $val;
		}
	}

	return $return;
}
/* Récupère les ressources du joueur + mise en forme */
function get_res_done2($mid, $res =  array(), $race = 0, $exc = array()) {
	$result = get_res_done($mid,$res, $race, $exc);
	return clean_array_res($result);
}

/* Quand on crée un membre */
function ini_res($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");

	/* On met la ligne de ressources */	
	$sql = "INSERT INTO ".$_sql->prebdd."res (res_mid) VALUES ($mid)";
	$_sql->query($sql);

	return mod_res($mid, get_conf("race_cfg", "debut", "res"));
}

/* Quand on le vire */
function cls_res($mid) {
	global $_sql;
	
	$sql = "DELETE FROM ".$_sql->prebdd."res WHERE res_mid = $mid";
	$res = $_sql->query($sql);
	$nb = $_sql->affected_rows();
	
	$sql = "DELETE FROM ".$_sql->prebdd."res_todo WHERE rtdo_mid = $mid";
	$res = $_sql->query($sql);
	
	return $_sql->affected_rows();
}
?>
