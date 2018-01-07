<?php
//Verifications
if(!defined("_INDEX_")) exit;
if(!can_d(DROIT_PLAY))
	$_tpl->set("need_to_be_loged",true); 
else {
    
$mbr = new member($_user['mid']);

require_once("lib/btc.lib.php");
require_once("lib/src.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/res.lib.php");
require_once("lib/trn.lib.php");
require_once("lib/member.lib.php");

// construction des batiments
if($_act == 'btc')
{
	$_tpl->set("module_tpl","modules/btc/btc.tpl");

	/* Nombre de travailleurs */
	$_tpl->set("btc_trav", $mbr->nb_unt_done(1));
	$_tpl->set("btc_act",false);

	// tous les batiments
	$cache['btc_done'] = get_nb_btc($_user['mid']); // get_nb_btc_done($_user['mid']);
	// seulement les batiments en construction
    /* le cache est $mbr
	$cache['btc_todo'] = get_nb_btc($_user['mid'], array(), array(BTC_ETAT_TODO));
	$cache['src'] = get_src_done($_user['mid']);
	$cache['src'] = index_array($cache['src'], "src_type");
	$cache['res'] = clean_array_res(get_res_done($_user['mid']));
	$cache['res'] = $cache['res'][0];
	$cache['trn'] = clean_array_trn(get_trn($_user['mid']));
	$cache['trn'] = $cache['trn'][0];
	$cache['unt'] = get_unt_done($_user['mid']);
	$cache['unt'] = index_array($cache['unt'], "unt_type");
    */
    
	if($_sub == 'btc') {// construire un nouveau bâtiment $type
		$_tpl->set("btc_act","btc");
		$type = request("type", "uint", "get");
		
		$btc_todo = $mbr->nb_btc(array(), array(BTC_ETAT_TODO)); // $cache['btc_todo'];
		$btc_nb = 0;
		foreach($btc_todo as $btc_type)
			$btc_nb += $btc_type['btc_nb'];

		if(!$type)
			$_tpl->set("btc_no_type",true);
		else if($btc_nb >= TODO_MAX_BTC)
			$_tpl->set("another_btc", true);
		else {
			$array = can_btc($_user['mid'], $type, $cache);
			
			if(isset($array['do_not_exist']))
				$_tpl->set("btc_no_type",true);
			else {
				$ok = empty($array['need_src']) && empty($array['need_btc']) && $array['limit_btc']==0 && empty($array['prix_res']) && empty($array['prix_trn']) && empty($array['prix_unt']);
			
				$_tpl->set("btc_infos", $array);
				$_tpl->set("const_btc_ok", $ok);
				if($ok) {
					edit_unt_vlg($_user['mid'], get_conf("btc", $type, "prix_unt"), -1);
					edit_unt_btc($_user['mid'], get_conf("btc", $type, "prix_unt"));
					
					mod_trn($_user['mid'], get_conf("btc", $type, "prix_trn"), -1);
					mod_res($_user['mid'], get_conf("btc", $type, "prix_res"), -1);
					
					scl_btc($_user['mid'], $type);
					// MAJ du $cache
					$cache['btc_todo'] = get_nb_btc($_user['mid'], array(), array(BTC_ETAT_TODO));
				}
			}
		}
	} elseif($_sub == 'cancel') {// annuler construction en cours
		$_tpl->set("btc_act","cancel");
		$bid = request("bid", "uint", "get");
		if(!$bid)
			$_tpl->set("btc_no_bid", true);
		else {
			$infos = get_btc_gen(array('bid' => $bid, 'mid' => $_user['mid']));
			$_tpl->set("can_btc_ok", $infos);

			if($infos) {
				$type = $infos[$bid]['btc_type'];
				cnl_btc($_user['mid'], $bid);
				
				edit_unt_vlg($_user['mid'], get_conf("btc", $type, "prix_unt"), 1);
				edit_unt_btc($_user['mid'], get_conf("btc", $type, "prix_unt"), -1);
					
				mod_trn($_user['mid'], get_conf("btc", $type, "prix_trn"), 1);
				mod_res($_user['mid'], get_conf("btc", $type, "prix_res"), 0.5);
				// MAJ du $cache
				$cache['btc_todo'] = get_nb_btc($_user['mid'], array(), array(BTC_ETAT_TODO));
			}
		}
	}

	/* Y'en a en construction ? */
	$btc_todo = get_btc($_user['mid'], array(), array(BTC_ETAT_TODO));

	if($btc_todo) {
		$_tpl->set("btc_conf",get_conf("btc"));
		$_tpl->set("btc_todo",$btc_todo);
	}// else {

	$btc_tmp = array();
	for($i = 1; $i <= get_conf("race_cfg", "btc_nb"); ++$i) {
		$btc_tmp[$i]['bad'] = can_btc($_user['mid'], $i, $cache);
		$btc_tmp[$i]['conf'] = get_conf("btc", $i);
		if(isset($cache['btc_done'][$i]['btc_nb']))
			$btc_tmp[$i]['btc_nb'] = $cache['btc_done'][$i]['btc_nb'];
		else
			$btc_tmp[$i]['btc_nb'] = 0;
		if(isset($cache['btc_todo'][$i]['btc_nb']))
			$btc_tmp[$i]['btc_todo'] = $cache['btc_todo'][$i]['btc_nb'];
	}

	$btc_ok = array(); // constructible, montrable
	$btc_bad = array(); // pas constructible, mais montrable 
	$btc_limit = array(); // limite atteinte, mais montrable
	foreach($btc_tmp as $bid => $array) {
		if($array['bad']['need_src'] || $array['bad']['need_btc']) continue;
		if($array['bad']['limit_btc'] || $array['bad']['prix_trn'])
			$btc_limit[$bid] = $array;
		else if($array['bad']['prix_res'] || $array['bad']['prix_unt'])
			$btc_bad[$bid] = $array;
		else {
			if(count($btc_todo) <= TODO_MAX_BTC)
				unset($array['bad']);
			$btc_ok[$bid] = $array;
		}
	}

	unset($btc_tmp);

	$_tpl->set("btc_const", true);
	$_tpl->set_ref("btc_ok",$btc_ok);
	$_tpl->set_ref("btc_bad",$btc_bad);
	$_tpl->set_ref("btc_limit",$btc_limit);

} elseif($_act == 'use')  {
    // recherche ou formation ou ressources
	$_tpl->set("module_tpl","modules/btc/use.tpl");
	$btc_type = request("btc_type", "uint", "get");
	
	if($btc_type && !get_conf("btc", $btc_type))
		$btc_type = 0;
		
	//On liste les batiments d'un type - ou tous
	if($_sub == 'list')
	{
		$_tpl->set("btc_act","list2");
		
		$btc_type = request("btc_type", "uint", "get");
		if(!$btc_type || !get_conf("btc", $btc_type))
			$btc = array();
		else
			$btc = array($btc_type);
			
		$etat = array(BTC_ETAT_OK, BTC_ETAT_REP, BTC_ETAT_BRU,BTC_ETAT_DES);
		$btc_array = get_btc($_user['mid'], $btc, $etat);
		
		$_tpl->set("btc_array", $btc_array);
		$_tpl->set("btc_conf",get_conf("btc"));
	}
	elseif($_sub == 'det') /* Supprime un bâtiment */
	{
		if(!empty($_POST))
			$arr_bid = request('bid', 'array', 'post');
		else{
			$btc_bid = request("btc_bid", "uint", "get");
			$arr_bid[$btc_bid] = 'on';
		}
		$ok = request("ok", "bool", "post");
		
		$_tpl->set('btc_act','det');
		$_tpl->set('btc_bid',$arr_bid);
		
		if(!$arr_bid)
			$_tpl->set('btc_no_bid',true);
		else if($ok) {
			$_tpl->set('btc_ok', true);
			foreach($arr_bid as $btc_bid => $value){
				$infos = get_btc_gen(array('bid' => $btc_bid, 'mid' => $_user['mid']));
				$_tpl->set("btc_det_ok", $infos);
				if($infos) {
					$type = $infos[$btc_bid]['btc_type'];
					cnl_btc($_user['mid'], $btc_bid);
					edit_unt_vlg($_user['mid'], get_conf("btc", $type, "prix_unt"), 1);
					edit_unt_btc($_user['mid'], get_conf("btc", $type, "prix_unt"), -1);

					mod_trn($_user['mid'], get_conf("btc", $type, "prix_trn"), 1);
					mod_res($_user['mid'], get_conf("btc", $type, "prix_res"), 0.5);

					$place = get_conf("btc", $type, "prod_pop");
					if($place) {
						edit_mbr($_user['mid'], array("place" => $_user['place'] - $place));
						$_user['place'] -= $place;
					}
				}
			}
		} else
			$_tpl->set('btc_ok',false);
		
	} elseif($_sub == 'des' OR $_sub == 'act' OR $_sub == 'rep') {
        // désactiver / activer / réparer un bat
		if(!empty($_POST))
			$arr_bid = request('bid', 'array', 'post');
		else{
			$btc_bid = request("btc_bid", "uint", "get");
			$arr_bid[$btc_bid] = 'on';
		}
		
		$_tpl->set('btc_bid',$arr_bid);
		$_tpl->set('btc_act','mod_etat');
		
		if(!$arr_bid)
			$_tpl->set('btc_no_bid',true);
		else {
			foreach($arr_bid as $btc_bid => $value){
				$infos = get_btc_gen(array('bid' => $btc_bid, 'mid' => $_user['mid']));
				if(!$infos)
					$_tpl->set('btc_no_bid',true);
				else {
					$etat = $infos[$btc_bid]['btc_etat'];
					$bonus = get_conf("btc", $infos[$btc_bid]['btc_type'], "bonus");
					switch($_sub) {
					case 'des':
						if ($bonus)
							$res = -1;
						else if($etat == BTC_ETAT_OK)
							$res = edit_btc($_user['mid'], array($btc_bid => array('etat' => BTC_ETAT_DES)));
						else
							$res = 0;
						break;
					case 'act':
						if($etat == BTC_ETAT_DES || $etat == BTC_ETAT_REP)
							$res = edit_btc($_user['mid'], array($btc_bid => array('etat' => BTC_ETAT_OK)));
						else
							$res = 0;
						break;
					case 'rep':
						$res = edit_btc($_user['mid'], array($btc_bid => array('etat' => BTC_ETAT_REP)));
						break;
					}
					$_tpl->set('btc_mod_etat',$res);
				}
			}
		}
	} else if(!$btc_type) { /* Vue du village */
		$_tpl->set("btc_act","list");
		$btc_array = get_nb_btc_done($_user['mid']);
		$_tpl->set("btc_max", get_conf("race_cfg", "btc_nb"));
		$_tpl->set("btc_conf", get_conf("btc"));
		$_tpl->set("src_conf", get_conf("src"));
		$_tpl->set("src_array", get_src_done($_user['mid']));
		$_tpl->set("btc_array", $btc_array);
        
	//Gérer : formation / recherche / ressources dispo dans le bâtiment
	} else {
		$_tpl->set("btc_act", "use");
		// lister les bâtiments de ce type disponibles
		$btc_array = $mbr->btc(array($btc_type), array(BTC_ETAT_OK, BTC_ETAT_DES, BTC_ETAT_REP, BTC_ETAT_BRU));
		$btc_nb_total = count($btc_array);
		$btc_nb = 0;
		foreach($btc_array as $value) {
			if($value['btc_etat'] == BTC_ETAT_OK)
				$btc_nb++;
		}
		
		if(!$btc_nb) { // aucun bât de ce type
			$_tpl->set("btc_act","no_btc");
			$_tpl->set("btc_id", $btc_type);
		} else {
			define("INDEX_BTC",true);
		
			$btc_conf = get_conf("btc", $btc_type);
			
			$_tpl->set("btc_id",$btc_type);
			$_tpl->set("btc_conf", $btc_conf);
			$_tpl->set("btc_nb",$btc_nb);
			$_tpl->set("btc_nb_total",$btc_nb_total);
            // un template spécifique par race & batiment - vide sauf donjon (btc_type=1)
			$_tpl->set("btc_tpl","modules/btc/".$_user['race']."/".$btc_type.".tpl");
			
			/* Principal */
            // un include spécifique par race & batiment - vide sauf donjon (btc_type=1)
			include(SITE_DIR."modules/btc/" .$_user['race']."/".$btc_type.".php");
			
			/* Autres trucs, en fonction de la conf */
            // former unité, liste des unités, annuler une formation
			if(isset($btc_conf['prod_unt'])) include("modules/btc/inc/unt.php");
            // liste recherches, nouvelle recherche, annuler recherche en cours
			if(isset($btc_conf['prod_src'])) include("modules/btc/inc/src.php");
            // idem ressources
			if(isset($btc_conf['prod_res'])) include("modules/btc/inc/res.php");
            // tout le commerce (marché achat vente cours ...)
			if(isset($btc_conf['com'])) include("modules/btc/inc/com.php");
            // la page "info" du bat
			include("modules/btc/inc/info.php");

			if($_display == "ajax"){
				if(isset($btc_conf['prod_unt']) and ($_sub == 'add_unt' or $_sub == 'cancel_unt'))
					$_tpl->set("module_tpl","modules/btc/inc/unt.tpl");
				else if(isset($btc_conf['prod_src']) and ($_sub == 'add_src' or $_sub == 'cancel_src'))
					$_tpl->set("module_tpl","modules/btc/inc/src.tpl");
				else if(isset($btc_conf['prod_res']) and ($_sub == 'add_res' or $_sub == 'cancel_res'))
					$_tpl->set("module_tpl","modules/btc/inc/res.tpl");
				else if(isset($btc_conf['com']) and ($_sub == 'ach' or $_sub == 'ven'))
					$_tpl->set("module_tpl","modules/btc/inc/com.tpl");
			}
		}
	}

}

}
?>
