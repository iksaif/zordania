<?php
/* Met un bâtiment en construction */
function scl_btc($mid, $type) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	
	return add_btc($mid, array($type => array('etat' => BTC_ETAT_TODO, 'vie' => 0)));
}

/* Détruit un bâtiment */
function del_btc($mid, $bid = 0) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$bid = protect($bid, "uint");
	
	
	$sql = "DELETE FROM ".$_sql->prebdd."btc WHERE btc_mid = $mid ";
	if($bid)
		$sql.= "AND btc_id = $bid ";
	
	$_sql->query($sql);
	return $_sql->affected_rows();
}

/* Annule une construction, Attention si bid = 0 TOUT les bâtiments sont supprimés */
function cnl_btc($mid, $bid = 0) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$bid = protect($bid, "uint");
	
	return del_btc($mid, $bid);
}

/* Ajoute des bâtiments */
function add_btc($mid, $btc) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$btc = protect($btc, "array");
	
	if(!$btc) return;
	
	$sql = "INSERT INTO ".$_sql->prebdd."btc VALUES ";
	foreach($btc as $type => $values) {
		$type = protect($type, "uint");
		if(isset($values['etat']))
			$etat = protect($values['etat'], "uint");
		else
			$etat = BTC_ETAT_OK;

		if(isset($values['vie']))
			$vie = protect($values['vie'], "uint");
		else
			$vie = get_conf("btc", $type, "vie");

		$sql.= "('', $mid, $type, $vie, $etat), ";
	}
	
	$sql = substr($sql, 0, strlen($sql)-2);
	
	return $_sql->query($sql);
}


/* Verifie qu'on peut faire tel ou tel bâtiment */
function can_btc($mid, $type, & $cache = array()) {
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	$cache = protect($cache, "array");

	$bad_src = array();
	$bad_res = array();
	$bad_btc = array();
	$bad_unt = array();
	$bad_trn = array();
	$limit_btc = 0;

	if(!get_conf("btc", $type))
		return array("do_not_exist" => true);
	
	/* Bâtiments */
	$need_btc = get_conf("btc", $type, "need_btc");
	$cond_btc = $need_btc;
	
	$limite = (int) get_conf("btc", $type, "limite");
	if($limite)
		$cond_btc[] = $type;

	if(!isset($cache['btc_done'])) {
		$have_btc = get_nb_btc_done($mid, $cond_btc);
		$have_btc = index_array($have_btc, "btc_type");
	} else
		$have_btc = $cache['btc_done'];
	
	/* Recherches */
	$cond_src = array($type);

	$need_src = get_conf("btc", $type, "need_src");
	$cond_src = $need_src;

	if(!isset($cache['src'])) {
		$have_src = get_src_done($mid, $cond_src);
		$have_src = index_array($have_src, "src_type");
	} else
		$have_src = $cache['src'];
	
	
	/* Ressources */
	$prix_res = get_conf("btc", $type, "prix_res");
	$cond_res = array_keys($prix_res);
	
	if(!isset($cache['res'])) {
		$have_res = get_res_done($mid, $cond_res);
		$have_res = clean_array_res($have_res);
		$have_res = $have_res[0];
	} else
		$have_res = $cache['res'];
		
	/* Terrains */
	$prix_trn = get_conf("btc", $type, "prix_trn");
	$cond_trn = array_keys($prix_trn);
	
	if(!isset($cache['trn'])) {
		$have_trn = get_trn($mid, $cond_trn);
		$have_trn = clean_array_trn($have_trn);
		$have_trn = $have_trn[0];
	} else
		$have_trn = $cache['trn'];
		
	/* Unités */
	$prix_unt = get_conf("btc", $type, "prix_unt");
	$cond_unt = array_keys($prix_unt);
	
	if(!isset($cache['unt'])) {
		$have_unt = get_unt_done($mid, $cond_unt);
		$have_unt = index_array($have_unt, "unt_type");
	} else
		$have_unt = $cache['unt'];
		
	/* Les recherches qu'il faut avoir */
	foreach($need_src as $src_type) {
		if(!isset($have_src[$src_type]))
			$bad_src['need_src'][] = $src_type;
	}

	/* Vérifications ressources */
	foreach($prix_res as $res_type => $nombre) {
		$diff =  $nombre - $have_res[$res_type];
		if($diff > 0)
			$bad_res[$res_type] =  $diff;

	}
	
	/* Les terrains */
	foreach($prix_trn as $trn_type => $nombre) {
		$diff =  $nombre - $have_trn[$trn_type];
		if($diff > 0)
			$bad_trn[$trn_type] =  $diff;
	}
	
	/* Les unités */
	foreach($prix_unt as $unt_type => $nombre) {
		if(!isset($have_unt[$unt_type]['unt_nb']))
			$diff = $nombre;
		else
			$diff =  $nombre - $have_unt[$unt_type]['unt_nb'];
			
		if($diff > 0)
			$bad_unt[$unt_type] =  $diff;
	}
	
	/* Verifications Bâtiments */
	foreach($need_btc as $btc_type) {
		if(!isset($have_btc[$btc_type]))
			$bad_btc[] = $btc_type;
	}
	
	/* La limite */
	if($limite && isset($have_btc[$type]['btc_nb']) && $have_btc[$type]['btc_nb'] >= $limite)
		$limit_btc = $limite;

	return array('need_src' => $bad_src, 'need_btc' => $bad_btc, 'prix_res' => $bad_res, 'prix_trn' => $bad_trn, 'prix_unt' => $bad_unt, 'limit_btc' => $limit_btc);
}

function btc_milit($btc_array, $race) {
	/* batiments militaires et leurs bonus
	$btc_array = get_btc_done($mid2); // detail des batiments ($bid, vie, type...)
	*/
	$nb = array();     // nb de batiments (type => nb) y compris non defensif
	$nb_def = array(); // nb de bat defensif & actifs seulement
	$def = array();    // liste des batiments defensifs & actifs (sauf donjon)
	$bonus = array('gen' => 0, 'bon' => 0); // bonus & defense batiments
	/* Calcul des bonus batiment, une fois pour toute */
	foreach($btc_array as $bid => $btc) {
		$bonus1 =  get_conf_gen($race, "btc", $btc['btc_type'], "bonus");
		if($bonus1) {
			if($btc['btc_type'] != 1) /* On met pas le donjon */
				$def[$bid] = $btc;
			foreach($bonus1 as $key => $value) /* key=gen ou bon */
				$bonus[$key] += $value;
		}
		if(!isset($nb[$btc['btc_type']]))
			$nb[$btc['btc_type']] = 0;
		$nb[$btc['btc_type']] += 1; // compter le nb de bat par type
	}
	foreach ($def as $bid => $btc) // compter les batiments def par type
		$nb_def[$btc['btc_type']] = $nb[$btc['btc_type']];

	return array('nb'=>$nb, 'def'=>$def, 'bonus'=>$bonus, 'nb_def'=>$nb_def);
}

/* Nombre de bâtiments en construction */
function get_nb_btc_todo($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	
	$sql = "SELECT COUNT(*) FROM ".$_sql->prebdd."btc ";
	$sql.="WHERE btc_mid = $mid AND btc_etat = ". BTC_ETAT_TODO;
	
	$res = $_sql->query($sql);
	return mysql_result($res, 0);
}

function get_nb_btc_done($mid, $btc = array()) {
	return get_btc_gen(array('mid' => $mid, 'etat' => array(BTC_ETAT_OK, BTC_ETAT_DES, BTC_ETAT_REP, BTC_ETAT_BRU), 'count' => true), $btc);
}

function get_nb_btc_act($mid, $btc = array()) {
	return get_btc_gen(array('mid' => $mid, 'etat' => array(BTC_ETAT_OK, BTC_ETAT_BRU), 'count' => true), $btc);
}

function get_btc_done($mid, $btc = array()) {
	return get_btc_gen(array('mid' => $mid, 'etat' => array(BTC_ETAT_OK, BTC_ETAT_REP, BTC_ETAT_BRU)), $btc);
}

/* Nombres de bâtiments de ce type pour ce mid et ces etats */
function get_nb_btc($mid, $btc = array(), $etat = array()) {
	return get_btc_gen(array('mid' => $mid, 'etat' => $etat, 'count' => true), $btc);
}
/* Bâtiments de ce type pour ce mid et ces états */
function get_btc($mid, $btc = array(), $etat = array()) {
	return get_btc_gen(array('mid' => $mid, 'etat' => $etat), $btc);
}

function get_btc_gen($cond, $btc = array()) {
	global $_sql;
	
	$mid = 0;
	$etat = array();
	$count = false;
	$bid = 0;
	
	$btc = protect($btc, "array");
	$cond = protect($cond, "array");
	
	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	if(isset($cond['etat']))
		$etat = protect($cond['etat'], "array");
	if(isset($cond['count']))
		$count = protect($cond['count'], "bool");
	if(isset($cond['bid']))
		$bid = protect($cond['bid'], "uint");
	
	if($count)
		$sql = "SELECT btc_mid, btc_type, COUNT(*) as btc_nb ";
	else
		$sql = "SELECT btc_id, btc_mid, btc_type, btc_etat, btc_vie ";
	
	$sql.= "FROM ".$_sql->prebdd."btc ";
	
	if($bid || $mid || $btc || $etat) {
		$sql.="WHERE ";
	}
	
	if($mid) {
		$sql.= "btc_mid = $mid ";
	}
	
	if($bid) {
		$sql.= "AND btc_id = $bid ";
	}
	
	if($btc) {
		if($mid) $sql.= "AND btc_type IN (";
		foreach($btc as $type) {
			$type = protect($type, "uint");
			$sql.= "$type,";
		}
		
		$sql = substr($sql, 0, strlen($sql) - 1); /* On vire le OR en trop */
		$sql.= ") ";
	}
	
	if($etat) {
		if($mid || $btc) $sql .= "AND btc_etat IN (";
		foreach($etat as $id) {
			$id = protect($id, "uint");
			$sql.= "$id,";
		}
		
		$sql = substr($sql, 0, strlen($sql) - 1); /* On vire le OR en trop */
		$sql.= ") ";
	}
	
	if($count) {
		$sql.= "GROUP BY btc_type ";
		if($mid)
			return $_sql->index_array($sql, 'btc_type');
		else
			return $_sql->make_array($sql);
	} else
		return $_sql->index_array($sql, 'btc_id');
}


/* Modifie l'état ou la vie de bâtiments */
function edit_btc($mid, $btc) {
	global $_sql;

	$clean = false;
	$mid = protect($mid, "uint");
	$btc = protect($btc, "array");

	if(!$btc)
		return;

	$sql1 = "";
	$sql2 = "";

	foreach($btc as $bid => $values) {
		if(isset($values['vie'])) { /* Vie absolue */
			$vie = protect($values['vie'], "uint");
			$sql1.= "WHEN btc_id = $bid THEN $vie ";
			$clean = true;
		} else if(isset($values['vie_comp'])) { /* Relative */
			$vie = protect($values['vie_comp'], "uint");
			$sql1.= "WHEN btc_id = $bid THEN btc_vie + $vie ";
		}
		if(isset($values['etat'])) { /* Etat (réparation, construction, etc ..) */
			$etat = protect($values['etat'], "uint");
			$sql2.= "WHEN btc_id = $bid THEN $etat ";
		}
	}
	
	if($sql1)
		$sql1 = " btc_vie = CASE ".$sql1." ELSE btc_vie END ";

	if($sql2)
		$sql2 = " btc_etat = CASE ".$sql2." ELSE btc_etat END ";
	if($sql1 && $sql2)
		$sql = "UPDATE ".$_sql->prebdd."btc SET ".$sql1." , ".$sql2." WHERE btc_mid = $mid AND btc_id IN (";
	else
		$sql = "UPDATE ".$_sql->prebdd."btc SET ".$sql1." ".$sql2." WHERE btc_mid = $mid AND btc_id IN (";
	
	foreach($btc as $bid => $values)
		$sql.= "$bid,";
		
	$sql = substr($sql, 0, strlen($sql) - 1).")";
	$_sql->query($sql);
	if ($clean)
	{
		$sql = "DELETE FROM ".$_sql->prebdd."btc WHERE btc_etat != ".BTC_ETAT_TODO." AND btc_vie = 0 ";
		$_sql->query($sql);
	}
	return true;
}

/* Quand on crée un membre */
function ini_btc($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");

	return add_btc($mid, get_conf("race_cfg", "debut", "btc"));
}

/* Quand on le vire */
function cls_btc($mid) {
	global $_sql;
	
	return cnl_btc($mid);
}
?>
