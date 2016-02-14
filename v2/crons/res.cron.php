<?php

$dep_res = array("btc", "res");
$log_res = "Ressources";

function mbr_res(&$_user) {
	global $_sql;
	
	$mid = $_user['mbr_mid'];
	$race = $_user['mbr_race'];
	
	$update_res_todo = $update_res = array();
	$res_nb = get_conf_gen($race, "race_cfg", "res_nb");

	for($i = 1; $i <= $res_nb; ++$i)
		$update_res[$i] = 0;

	foreach($_user["btc"] as $btc_type => $btc_nb){ // boucle sur les batiments
		$prod_res = get_conf_gen($race, "btc", $btc_type, "prod_res_auto");
		if(!$prod_res) // ne produit rien
			continue;

		foreach($prod_res as $res_type => $res_nb) { // boucle sur le type de ressources produites
			$prix = get_conf_gen($race, "res", $res_type, "prix_res");
			if($prix) { // prix de production (ex: mithril consomme acier+or)
				$max = $res_nb * $btc_nb;
				foreach($prix as $prix_type => $prix_nb) {
					if($max * $prix_nb > $_user["res"][$prix_type]) { // manque de ressources
						$max = floor($_user["res"][$prix_type] / $prix_nb);
					}
				}
				foreach($prix as $prix_type => $prix_nb) {
					$_user["res"][$prix_type] -= $prix_nb * $max;
					$update_res[$prix_type] -= $prix_nb * $max;
				}
				$res_nb = $max;
			} else { // prod gratuite
				/* compétence avec bonus/malus sur la prod de ressources */
				if (isset($_user['hro']) &&
						($_user['hro']['hro_bonus'] == CP_PRODUCTIVITE
						 or $_user['hro']['hro_bonus'] == CP_INVULNERABILITE))
					$_bonus = get_conf_gen($race, 'comp', $_user['hro']['hro_bonus'], 'bonus')/100;
				else
					$bonus = 1;
				$res_nb = floor($res_nb * $btc_nb * $bonus);
			}

			$update_res[$res_type] += $res_nb;
			$_user["res"][$res_type] += $res_nb;
		}
	}
	
	$res_todo = get_res_todo($mid); // production sur demande (armes)
	$have_btc = $_user["btc"];
	
	foreach($res_todo as $value) {
		$res_type = $value["rtdo_type"];
		$res_nb = $value["rtdo_nb"];
		$res_id = $value["rtdo_id"];
		$need_btc = get_conf_gen($race, "res", $res_type, "need_btc");
		$max = $res_nb;
		if(!isset($update_res[$res_type])) $update_res[$res_type] = 0;
		if(!isset($_user["res"][$res_type])) $_user["res"][$res_type] = 0;

		if(!isset($have_btc[$need_btc])) // bat non disponible
			$max = 0;
		else {
			if($max > $have_btc[$need_btc]) // prod = 1 unit par bat
				$max = $have_btc[$need_btc];
			$have_btc[$need_btc] -= $max;
		}

		if($max) {
			$update_res[$res_type] += $max;
			$_user["res"][$res_type] += $max;
			$update_res_todo[$res_id] = $max;
		}
	}

	mod_res($mid, $update_res);

	$sql = "";
	foreach($update_res_todo as $id => $nb) {
		if($nb)
			$sql.= "WHEN rtdo_id = $id THEN rtdo_nb - $nb ";
	}
	if($sql) {
		$sql = "UPDATE ".$_sql->prebdd."res_todo SET rtdo_nb = CASE ". $sql;
		$sql.= " ELSE rtdo_nb END WHERE rtdo_mid = $mid ";
		$_sql->query($sql);
	}
}

function glob_res() {
	global $_sql;
	
	$sql = "DELETE FROM ".$_sql->prebdd."res_todo WHERE rtdo_nb = 0";
	$_sql->query($sql);
}

?>
