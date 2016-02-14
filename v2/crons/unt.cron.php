<?php

$dep_unt = array("btc", "res");
$log_unt = "Unités";

function mbr_unt(&$_user) {
	global $_sql, $_histo, $hro_list;

	$mid = $_user['mbr_mid'];
	$race = $_user['mbr_race'];

	$unt_todo = get_unt_todo($mid);

	$have_btc = $_user["btc"]; // batiments construits
	$prod_btc = array(); // productions d'unités maxi par batiments
	foreach($have_btc as $btc_type => $btc_nb){
		$prod_unt = get_conf_gen($race, 'btc', $btc_type, 'prod_unt');
		if(is_numeric($prod_unt))
			$prod_btc[$btc_type] = $btc_nb * $prod_unt;
		else
			$prod_btc[$btc_type] = $btc_nb; // prod de 1 par batiments
	}

	$update_unt_todo = $update_unt = array();
	$unt_nb = get_conf_gen($race, "race_cfg", "unt_nb");

	for($i = 1; $i <= $unt_nb; ++$i)
		$update_unt_todo[$i] = $update_unt[$i] = 0;

	foreach($unt_todo as $value) {
		$unt_type = $value["utdo_type"];
		$unt_nb = $value["utdo_nb"];
		$unt_id = $value["utdo_id"];

		$need_btc = get_conf_gen($race, "unt", $unt_type, "in_btc");
		$max = $unt_nb;
		$unt_prod = 0;

		foreach($need_btc as $btc_type) {// liste des batiments requis
			if(isset($prod_btc[$btc_type])){// batiments requis sont construits?
				// on augmente la production du nombre de batiments construits

				if($max > $prod_btc[$btc_type]){ /* Si y'a pas assez de bâtiments */
					$unt_prod += $prod_btc[$btc_type]; /* On en fait autant qu'on a de bâtiment */
					$prod_btc[$btc_type] = 0;// tous ces batiments ont été utilisés
				}else{
					$unt_prod += $max; /* Sinon, on n'utilise pas tout les bâtiments */
					$prod_btc[$btc_type] -= $max;// soustraire le reste à faire, il reste des bats à produire
				}
				$max -= $unt_prod; // si il reste des unités à produire?
				if(!$max)
					break;
			}
		}

		if($unt_prod) {
			$update_unt[$unt_type] += $unt_prod;
			if(isset($_user["unt"]))
				$_user["unt"][$unt_type] += $unt_prod;
			if(!isset($update_unt_todo[$unt_id]))
				$update_unt_todo[$unt_id] = 0;
			$update_unt_todo[$unt_id] -= $unt_prod;
		}
	}

	/* Nourriture */
	$bouf = $_user["res"][GAME_RES_BOUF];
	$sql = "SELECT SUM(unt_nb) ";
	$sql.= "FROM ".$_sql->prebdd."unt ";
	$sql.= "JOIN ".$_sql->prebdd."leg ON leg_id = unt_lid ";
	$sql.= "WHERE leg_etat IN (".LEG_ETAT_VLG.",".LEG_ETAT_BTC.") AND leg_mid = $mid";
	$res = $_sql->query($sql);
	$nb = $_sql->result($res, 0);
	$_sql->free_result($res);

	if($bouf < $nb) { /* On tue des gens */
		$sql = "SELECT unt_type, unt_nb, leg_name FROM ".$_sql->prebdd."unt ";
		$sql.= "JOIN ".$_sql->prebdd."leg ON leg_id = unt_lid ";
		$sql.= "WHERE leg_mid = $mid AND leg_etat = ".LEG_ETAT_VLG." AND unt_nb > 0 ";
		$sql .= ' AND unt_type NOT IN ('. implode(',', $hro_list[$race]). ') ';
		$sql.= "ORDER BY RAND() LIMIT 1";
		$unt_array = $_sql->make_array($sql);

		if($unt_array) {
			$unt_array = $unt_array[0];
			$type = $unt_array['unt_type'];
			$name = $unt_array['leg_name'];

			if(($nb - $bouf) > $unt_array['unt_nb'])
				$killed = rand(1,$unt_array['unt_nb']);
			else
				$killed = rand(1, $nb - $bouf);

			$update_unt[$type] -= $killed;
			$_histo->add($mid, $mid,HISTO_UNT_BOUFF ,array("unt_type" => $type, "unt_nb" => $killed, "leg_name" => $name));
		}

		$nb = $bouf;
	}

	mod_res($mid, array(GAME_RES_BOUF => -$nb));// nourriture consommée

	edit_unt_vlg($mid, $update_unt);// MAJ unités formées ou mort de faim

	$sql = "";
	foreach($update_unt_todo as $id => $nb) {
		if($nb)
			$sql.= "WHEN utdo_id = $id THEN utdo_nb + $nb ";
	}

	if($sql) {
		$sql = "UPDATE ".$_sql->prebdd."unt_todo SET utdo_nb = CASE ". $sql;
		$sql.= " ELSE utdo_nb END WHERE utdo_mid = $mid ";
		$_sql->query($sql);
	}
}

function glob_unt() {
	global $_sql;
	$sql = "DELETE FROM ".$_sql->prebdd."unt_todo WHERE utdo_nb <= 0";
	$_sql->query($sql);

	$sql = "DELETE FROM ".$_sql->prebdd."unt WHERE unt_nb <= 0";
	$_sql->query($sql);

	$sql="UPDATE ".$_sql->prebdd."mbr SET mbr_population = (SELECT SUM(unt_nb) FROM ".$_sql->prebdd."leg JOIN ".$_sql->prebdd."unt ON leg_id = unt_lid WHERE leg_mid = mbr_mid)";
	$_sql->query($sql);

	$sql="UPDATE ".$_sql->prebdd."hero SET hro_bonus = 0 WHERE hro_bonus_to < NOW()";
	$_sql->query($sql);
}
?>
