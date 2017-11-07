<?php

function add_hero($mid, $name, $type) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	$name = protect($name, "string");

	// si l'id qu'on a récupéré c'est pas celui d'un héros ... Ben on lui dit que c'est pas bien de faire ça ! 
	if(get_conf('unt', $type, 'role') != TYPE_UNT_HEROS) 
		return false;
	// récpérer l'id de la légion au village
	$lid = get_id_vlg($mid, LEG_ETAT_VLG);
	$vie = get_conf('unt',$type, 'vie');

	// prix en unités de la légion
	$edit_unt = get_conf('unt', $type, 'prix_unt');
	// prix en ressources
	$prix_res = get_conf('unt', $type, 'prix_res');
	// ajouter le héros, l'unité et payer le prix
	$sql = "INSERT INTO ".$_sql->prebdd."hero ";
	$sql .= "VALUES (NULL,$mid, '$name', $type, $lid, 0,'$vie' ,0, NULL, NULL)";
	$res = $_sql->query($sql);
	$edit_unt[$type] = -1; // ajouter le héros comme unité
	edit_unt_gen($mid, LEG_ETAT_VLG, $edit_unt, -1); // prix unités & héros
	mod_res($mid, $prix_res, -1);// ressources payées
	// maj mbr
	$_sql->query('UPDATE '.$_sql->prebdd.'mbr SET mbr_lmodif_date = NOW()');
	return true;
}

function del_hero($lid, $type) {
	global $_sql;
	
	$lid = protect($lid, "uint");
	$type = protect($type, "uint");
	if(!$lid || !$type) return false;

	// supprimer l'unité dans la légion
	$sql = "DELETE FROM ".$_sql->prebdd."unt ";
	$sql.= "WHERE unt_type = $type AND unt_lid = $lid ";
	$_sql->query($sql);
	$nb = $_sql->affected_rows();

	// supprimer le héros
	$sql = "DELETE FROM ".$_sql->prebdd."hero ";
	$sql.= "WHERE hro_lid = $lid ";
	$_sql->query($sql);
	// maj mbr
	$_sql->query('UPDATE '.$_sql->prebdd.'mbr SET mbr_lmodif_date = NOW()');
	return $nb;
}

function cls_hro($mid) { // supprime le héros (reboot)
	// il faut aussi supprimer l'unité
	global $_sql;
	
	$mid = protect($mid, "uint");
	if(!$mid) return false;

	$sql = "DELETE FROM ".$_sql->prebdd."hero ";
	$sql.= "WHERE hro_mid = $mid ";
	$_sql->query($sql);
	return true;
}

function edit_hero($mid, $new = array()) {
	global $_sql;

	$type = 0; $lid = 0; $vie = false;
	$bonus_from = 0; $bonus_to = 0; $xp = 0; $bonus = false; $nom = "";

	$mid = protect($mid, "uint");
	
	if(isset($new['name']))
		$nom = protect($new['name'], "string");
	if(isset($new['type']))
		$type = protect($new['type'], "uint");
	if(isset($new['lid']))
		$lid = protect($new['lid'], "uint");
	if(isset($new['vie']))
		$vie = protect($new['vie'], "uint");
	if(isset($new['xp']))
		$xp = protect($new['xp'], "int");
	if(isset($new['bonus']))
		$bonus = protect($new['bonus'], "uint");
	if(isset($new['bonus_from']))
		$bonus_from = protect($new['bonus_from'], "uint");
	if(isset($new['bonus_to']))
		$bonus_to = protect($new['bonus_to'], "uint");

	if(!$mid || (!$nom && !$type && !$lid && ($vie==false) && !$xp && ($bonus===false) && !$bonus_from && !$bonus_to))
		return 0; // aucune modif nécessaire

	if($lid) { // transfer du héros de légions
		global $_user;
		// enlever l'unité de la légion actuelle, il suffit de supprimer le rang
		$rang = protect(get_conf_gen($_user['race'], 'unt', $_user['hro_type'], 'rang'));
		del_rang($_user['hro_lid'], $rang);
		// ajouter l'unité dans la nouvelle légion
		add_unt_leg($_user['mid'], $lid, $rang, $_user['hro_type'], 1);
	}

	// maj mbr
	$_sql->query('UPDATE '.$_sql->prebdd.'mbr SET mbr_lmodif_date = NOW()');

	$sql = "UPDATE ".$_sql->prebdd."hero SET ";
	if($nom) $sql.= "hro_nom = '$nom',";
	if($type) $sql.= "hro_type = $type,";
	if($lid) $sql.= "hro_lid = $lid,";
	if($xp) $sql.= "hro_xp = hro_xp + $xp,";
	if($vie !== false) $sql.= "hro_vie = $vie,";
	if($bonus!==false) $sql.= "hro_bonus = $bonus,";
	if($bonus_from) $sql.= "hro_bonus_from = '$bonus_from',";
	if($bonus_to) $sql.= "hro_to = '$bonus_to',";
	$sql = substr($sql, 0, strlen($sql) - 1);
	$sql .= " WHERE hro_mid = $mid ";

	$_sql->query($sql);
	return $_sql->affected_rows();
}

function get_hero($mid){
	global $_sql;

	$mid = protect($mid, "uint");
	
	$sql = "SELECT hro_id, hro_mid, hro_nom, hro_type, hro_lid, hro_xp, hro_vie, hro_bonus AS bonus, hro_bonus_from, hro_bonus_to AS bonus_to ";
	$sql.= "FROM ".$_sql->prebdd."hero ";
	$sql.= "WHERE hro_mid = $mid";
	
	return $_sql->make_array($sql);
}

function edit_bonus($mid, $bonus_id){ // Pour 'supprimer' un bonus, donc le désactiver, mettre $bonus_id à 0. Donc edit_bonus(151,0); va virer le bonus du héro du membre 151. 
// Pour activer un bonus, suffit de mettre l'id du bonus.
	global $_sql;
	
	$mid = protect($mid, "uint");
	$bonus_id = protect($bonus_id, "uint");
	$prix_xp = get_conf("comp", $bonus_id, "prix_xp");
	$array_hero = get_hero($mid);
	
	if($prix_xp <= $array_hero[0]['hro_xp'] or $bonus_id == 0){ // savoir si y'a assez d'xp pour payer le cout du bonus ou non.
		
		$sql = "UPDATE ".$_sql->prebdd."hero ";
		$sql.= " SET hro_bonus = $bonus_id ";
		if ($bonus_id != 0){
			$tours = get_conf("comp", $bonus_id, "tours");//délais du bonus.
			/* ZORD_SPEED = durée d'un tour en minutes */
			$tours *= ZORD_SPEED;
			$sql.= ", hro_bonus_from = NOW(), ";
			$sql.= " hro_bonus_to =  DATE_ADD(NOW(), INTERVAL $tours MINUTE), ";
			$sql.= " hro_xp = hro_xp - $prix_xp ";
		}
		$sql.= " WHERE hro_mid = $mid";	
		$_sql->query($sql);
		// maj mbr
		$_sql->query('UPDATE '.$_sql->prebdd.'mbr SET mbr_lmodif_date = NOW()');
		return true;
	}
	else
		return false;
}

function get_comp($cp_id, $race, $res = false) {
// récupérer toutes les infos d'un bonus, format array
// tableau générique array( heros=> array, bonus=> %, tours=>tours, prix_xp=>prix, race=>$race, res=>$resultat)
	$cp = get_conf_gen($race, 'comp', $cp_id);
	$cp['cpid'] = $cp_id;
	$cp['race'] = $race;
	if ($res !== false)
		$cp['res'] = $res;
	return $cp;
}

function hro_resurrection($id, $mid, $lid) {
	/* retour au village, -50% XP */
	global $_sql;
	$sql_leg_vlg = 'SELECT leg_id FROM '.$_sql->prebdd.'leg '.
		' WHERE leg_mid = '.$this->mid.' AND leg_etat = '.LEG_ETAT_VLG;
	$sql = 'UPDATE '.$_sql->prebdd.'hero 
		SET hro_lid = ('.$sql_leg_vlg.'),
			hro_bonus = 0,
			hro_xp = FLOOR(hro_xp/2),
			hro_vie=FLOOR('.$this->hro('vie_conf').'/2)
		WHERE hro_id ='.$hid;
	$_sql->query($sql); // héros retour maison
	/* déplacer l'unité correspondante */
	$sql = 'UPDATE '.$_sql->prebdd.'unt SET unt_lid = ('.$sql_leg_vlg.
		') WHERE unt_lid ='.$lid.' AND unt_type='.$this->hro('type');
	$_sql->query($sql);

}
?>
