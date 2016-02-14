<?php
/* Modifie les terrain d'un membre , mais comparativement (terrain courant + machin) */
function mod_trn($mid, $trn, $factor = 1) {
	$trn = protect($trn, "array");
	$factor = protect($factor, "float");
	
	if(!$trn) return;

	foreach($trn as $type => $nb) {
		$trn[$type] = $nb * $factor;
	}
	
	return edit_trn_gen(array('mid' => $mid, 'comp' => true), $trn);
}

/* Modifie le terrain qui remplissent certaines conditions */
function edit_trn_gen($cond, $trn) {
	global $_sql;
	
	$cond = protect($cond, "array");
	$trn = protect($trn, "array");

	$mid = 0;
	$comp = false;

	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	if(isset($cond['comp']))
		$comp = protect($cond['comp'], "bool");
	

	$sql = "UPDATE ".$_sql->prebdd."trn SET ";
	foreach($trn as $type => $nb) {
		$type = protect($type, "uint");
		$nb = protect($nb, "int");
		
		$nom = "trn_type".$type;
		
		if($comp)
			$sql .= "$nom = $nb + $nom, ";
		else
			$sql .= "$nom = $nb, ";
	}

	$sql = substr($sql, 0, strlen($sql)-2); /* On vire la virgule en trop */
	
	if($mid)
		$sql.= " WHERE trn_mid = $mid ";	
	
	return $_sql->query($sql);
}

/* Récupère les terrains du joueur */
function get_trn($mid, $trn =  array()) {
	global $_sql;

	$mid = protect($mid, "uint");
	$trn = protect($trn, "array");

	$sql = "SELECT ";
	if(!$trn) {
		$nb = get_conf("race_cfg", "trn_nb");
		
		for($i = 1; $i <= $nb; ++$i)
			$sql.= "trn_type".$i.", ";
	} else {
		foreach($trn as $type) {
			$type = protect($type, "uint");
			$sql.= "trn_type".$type.", ";
		}
	}
	$sql = substr($sql, 0, strlen($sql) - 2);
	
	$sql.= " FROM ".$_sql->prebdd."trn ";
	$sql.= "WHERE trn_mid = $mid ";

	return $_sql->make_array($sql);
}

function clean_array_trn($array) {
	$array = protect($array, "array");

	if(!$array) return array();

	$return = array();
	foreach($array as $line => $value) {
		foreach($value as $key => $val) {
			$key = str_replace("trn_type","",$key);
			$return[$line][$key] = $val;
		}
	}

	return $return;
}

/* Quand on crée un membre */
function ini_trn($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");

	/* On met la ligne de terrain */	
	$sql = "INSERT INTO ".$_sql->prebdd."trn (trn_mid) VALUES ($mid)";
	$_sql->query($sql);

	return mod_trn($mid, get_conf("race_cfg", "debut", "trn"));
}

/* Quand on le vire */
function cls_trn($mid) {
	global $_sql;
	
	$sql = "DELETE FROM ".$_sql->prebdd."trn WHERE trn_mid = $mid";

	return $_sql->query($sql);
}
?>