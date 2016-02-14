<?php

$log_btc = "Batîments";
/* Bâtiments */
// define('BTC_BRU_PERC', 95);

function mbr_btc(&$_user) {
	global $_sql, $_histo;

	if(isset($_user["no_btc_todo"]))
		return;
	
	$mid = $_user["mbr_mid"];
	$race = $_user["mbr_race"];
	
	/* Selection des bâtiments utiles */
	$btc_array = get_btc($mid, array(), array(BTC_ETAT_TODO, BTC_ETAT_REP)); // BTC_ETAT_BRU
	if(!$btc_array)
		return;

	$trav = get_unt_done($mid, array(1));
	if($trav)
		$trav = $trav[0]['unt_nb'];
	else
		$trav = 0;
	
	$update_btc = array();
	$update_place = 0;
	
	foreach($btc_array as $key => $value) {
		$type = $value["btc_type"];
		$vie = protect(get_conf_gen($race, "btc", $type, "vie"), "uint");
		$place = protect(get_conf_gen($race, "btc", $type, "prod_pop"), "uint");
		$tours = protect(get_conf_gen($race, "btc", $type, "tours"), "uint");

		switch($value["btc_etat"]) {
/*
		case BTC_ETAT_BRU:
			if($value["btc_vie"]) {
				$value["btc_vie"] -= $vie * (1 - (BTC_BRU_PERC / 100));
				if($value["btc_vie"] <= 0) {
					$value["btc_vie"] = 0;
					if(isset($_user["btc"][$type]))
						$_user["btc"][$type]--;
					$update_place -= $place;

					$prix_unt = get_conf_gen($race, "btc", $type, "prix_unt");
					edit_unt_btc($mid, $prix_unt, -1);

					// Et les terrains !
					mod_trn($mid, get_conf_gen($race, "btc", $type, 'prix_trn'));

					$_histo->add($mid, $mid,HISTO_BTC_BRU ,array("btc_type" => $type));
				}
				$update_btc[$value["btc_id"]]["vie"] = $value["btc_vie"];
			}
			break;
*/
		case BTC_ETAT_TODO:
		case BTC_ETAT_REP:
			if(!$trav)
				continue;
			$old = $value["btc_vie"];
			$value["btc_vie"] += ($vie / $tours) * $trav;
			if($value["btc_vie"] >= $vie) {
				if(isset($_user["btc"][$type]))
					$_user["btc"][$type]++;
				$value["btc_vie"] = $vie;

				if($value["btc_etat"] == BTC_ETAT_TODO)
					$update_place += $place;

				$update_btc[$value["btc_id"]]["etat"] = BTC_ETAT_OK;

				$histo_type = ($value["btc_etat"] == BTC_ETAT_TODO)  ? HISTO_BTC_OK : HISTO_BTC_REP;
				$_histo->add($mid, $mid, $histo_type ,array("btc_type" => $type));
			}

			$trav -= (($value["btc_vie"] - $old) / $vie) * $tours;

			$update_btc[$value["btc_id"]]["vie"] = $value["btc_vie"];
			break;
		}
	}

	if($update_place)
		edit_mbr($mid, array("place" => $_user['mbr_place'] + $update_place));
	if($update_btc) {
	foreach($update_btc as $bid => $value) {
		$sql = "UPDATE ".$_sql->prebdd."btc SET ";
		if(isset($value['vie']))
			$sql.= " btc_vie = {$value['vie']}";
		if(isset($value['etat']))
			$sql.= " , btc_etat = {$value['etat']} ";
		$sql.= " WHERE btc_id = $bid ";
		$_sql->query($sql);
	}
	}
}

function glob_btc() {
	global $_sql;
		
	$sql = "DELETE FROM ".$_sql->prebdd."btc WHERE btc_etat != ".BTC_ETAT_TODO." AND btc_vie = 0 ";
	$_sql->query($sql);
}
?>
