<?php
//Verifications
if(!defined("_INDEX_")){ exit; }
if(!can_d(DROIT_PLAY))
	$_tpl->set("need_to_be_loged",true); 
else {
require_once("lib/res.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/btc.lib.php");
require_once("lib/src.lib.php");
require_once("lib/trn.lib.php");
require_once("lib/mch.lib.php");
require_once("lib/map.lib.php");
require_once("lib/member.lib.php");


$_tpl->set('COM_ETAT_OK',COM_ETAT_OK);
$_tpl->set('module_tpl','modules/gen/gen.tpl');

/* Ressources */
// Init
$btc_conf = get_conf("btc");
$res_conf = get_conf("res");
$prod_res = array();
for($j = 1; $j <= 9; $j++) { $prod_res[$j] = 0; }
// On récupère les index correspondants entre les batiments et ressources, selon race
$indexBat = get_btc_prod_auto();
// On veut l'index inverse, pour obtenir le sens batiment -> ressource
$indexBatRev = array();
foreach ($indexBat AS $typeRes => $bats) {
	foreach ($bats AS $typeBat) {
		if (!isset($indexBatRev[$typeBat])) { $indexBatRev[$typeBat] = array(); }
		array_push($indexBatRev[$typeBat], $typeRes);
	}
}
$indexBat = $indexBatRev;

// On recup les batiments du joueur
$batiments = get_nb_btc($_user['mid'], array(), array(BTC_ETAT_OK));
$batiments = index_array($batiments, "btc_type");
$nbBatiments = get_conf_gen($_user["race"], "race_cfg", "btc_nb");
for($j = 1; $j <= $nbBatiments; ++$j) {
	$batiments[$j] = isset($batiments[$j]) ? $batiments[$j]["btc_nb"] : 0;
}

// On calcule le taux de production des batiments
foreach ($batiments AS $typeBat => $nbBat) {
	if ($nbBat > 0 && isset($indexBat[$typeBat])) {
		foreach ($indexBat[$typeBat] AS $typeRes) {
			if ($typeRes <=9 && isset($btc_conf[$typeBat]['prod_res_auto'])) {
				$prod = $btc_conf[$typeBat]['prod_res_auto'];
				$prod_res[$typeRes] += $prod[$typeRes] * $nbBat;
				if (isset($res_conf[$typeRes]['prix_res'])) {
					foreach ($res_conf[$typeRes]['prix_res'] AS $stripRes => $nb) {
						$prod_res[$stripRes] -= $nbBat * $nb;
					}
				}
			}
		}
	}
}
// On ajuste le taux de production de nourriture, en fonction de la population
$prod_res[GAME_RES_BOUF] -= $_user['population'];

$cond_res = get_conf("race_cfg", "second_res");
$prim_res = clean_array_res(get_res_done($_user['mid'], $cond_res));
$_tpl->set("res_array", $prim_res[0]);
$_tpl->set("prod_res", $prod_res);

/* Terrains */
$trn_array = clean_array_trn(get_trn($_user['mid']));
$_tpl->set("trn_array", $trn_array[0]);

/* Bâtiments */
$btc_array = get_btc($_user['mid'],array(),array(BTC_ETAT_TODO,BTC_ETAT_REP,BTC_ETAT_BRU));

$btc_todo = array();
$btc_rep = array();
$btc_bru = array(); 

foreach($btc_array as $value) {
	switch($value['btc_etat']) {
	case BTC_ETAT_TODO:
		$btc_todo[] = $value;
		break;
	case BTC_ETAT_REP:
		$btc_rep[] = $value;
		break;
	case BTC_ETAT_BRU:
		$btc_bru[] = $value;
		break;
	}
}

$_tpl->set("btc_todo", $btc_todo);
$_tpl->set("btc_rep", $btc_rep);
$_tpl->set("btc_bru", $btc_bru);

$_tpl->set("btc_conf",get_conf("btc"));
$_tpl->set("src_conf",get_conf("src"));

$btc_array = get_nb_btc($_user['mid']);
$nb_btc = 0;
foreach($btc_array as $value)
	$nb_btc += $value['btc_nb'];
$_tpl->set('gen_nb_btc',$nb_btc);

/* Unités */
$unt_todo = get_unt_todo($_user['mid']);
$_tpl->set('unt_todo',$unt_todo);

/* Recherches  en cours */
$src_todo = get_src_todo($_user['mid']);
foreach($src_todo as $key => $src) { // calculer RAF
	$conf = get_conf('src', $src['stdo_type'], 'tours');
	if ($conf) $src_todo[$key]['raf'] = (int) $conf - $src['stdo_tours'];
}
$_tpl->set('src_todo',$src_todo);

/* Ressources en cours */
$res_todo = get_res_todo($_user['mid']);
$_tpl->set('res_todo',$res_todo);


/*Déménagement en cours*/
/*avant tout il faut l'unité de déménagement*/
$legions = new legions(array('mid' => $_user['mid']), true);
$demn_ok = $legions->hasUntByRole(TYPE_UNT_DEMENAGEMENT);
// dans le tpl cette variable dit si un déménagement est possible
$_tpl->set('demn_ok', $demn_ok); 

/*Déménagement possible ou en cours */
if($demn_ok){
	$map_x = request("map_x", "uint", "post");
	$map_y = request("map_y", "uint", "post");
	$map_cid = request("map_cid", "uint", "post");

	if($map_x and $map_y){ // chercher map_cid
		$map_cid = get_cid($map_x,$map_y);
		if($map_cid == false)
			$_tpl->set('depl_ok', 'out');
	}

    if($map_cid) { // vérifier que la destination est libre
            $arr_cid = get_square($map_cid);
            if(!empty($arr_cid)) { // destination connue
                if($arr_cid['map_type'] == MAP_LIBRE){ // emplacement libre
                    	/*
                    	 * - envoi de la légion qui contient la caravane vers cet emplacement libre
                    	 * - la caravane ne doit pas etre au village
                    	 */
						foreach($legions->legs as $leg) {
							$unts = $leg->getUntByRole(TYPE_UNT_DEMENAGEMENT);
							if (!empty($unts)) {
								if($leg->etat == LEG_ETAT_VLG) /* légion au village, il faut créer une légion */
									$_tpl->set('depl_ok', 'unt_au_vlg');
								else{ /* déplacer la légion existante vers cette nouvelle destination */
									// calculer et enregistrer la vitesse de la légion
									$new = array('vit' => $leg->vitesse(), 'dest' => $arr_cid['map_cid'], 
										'etat' => LEG_ETAT_ALL);
									$leg->edit($new);
						            $_tpl->set('depl_ok', true);
								}
								break;
							}
						}
						            	}else
                      $_tpl->set('depl_ok', 'no_free');
            } else
                    $_tpl->set('depl_ok', 'out');
    }else{
    	/*
    	 * vérifier si le déménagement est déjà en cours
    	 * si oui calculer (!) le temps restant
    	 * pour l'afficher dans le template
    	 */
		$_tpl->set('depl_ok', false);
		foreach($legions->legs as $leg) {
			$unts = $leg->getUntByRole(TYPE_UNT_DEMENAGEMENT);
			if (!empty($unts) and $leg->etat == LEG_ETAT_ALL) {
				/* calcul de l'avancement */
				$squares = get_square_gen(
					array($leg->infos['leg_dest'], $leg->cid), 
					array('x'=>$_user['map_x'], 'y'=>$_user['map_y']));
				$squares = index_array($squares, 'map_cid');
				$_tpl->set('depl_ok', $squares[$leg->cid]['map_dst'] / $squares[$leg->infos['leg_dest']]['map_dst']);
			}
		}
    }
}


//Attaques (- de 10 cases)
//$atq_array = get_leg_dst_vlg($_user['map_x'], $_user['map_y'], 5);
// toutes les légions ennemies venant vers le village
$atq_array = get_leg_dest($_user['mid'], $_user['mapcid']);
$_tpl->set('atq_array', $atq_array);
$_tpl->set('leg_array', get_leg_dpl($_user['mid']));
$_tpl->set('pos_array', get_leg_pos($_user['mid']));
$_tpl->set('dst_view_max', DST_VIEW_MAX);

//ventes
$vente_array = get_mch_by_mid($_user['mid']);
$_tpl->set('vente_array',$vente_array);
}
?>
