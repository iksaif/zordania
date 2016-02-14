<?
if(!is_object($res)) {
	include("lib/res.class.php");
	$res= new ressources($_sql, $conf, $game);
}

if(!$_sub) {
	if($conf->btc[$btc_type]['btcopt']['def']) {
		$_tpl->set("btc_def",$conf->btc[$btc_type]['defense']);
		$_tpl->set("btc_bonusdef",$conf->btc[$btc_type]['bonusdef']);
	}
	if($conf->btc[$btc_type]['btcopt']['prod']) {
		$all_btc_array = $btc->get_infos($_SESSION['user']['mid']);
		$all_res_array = $res->get_infos($_SESSION['user']['mid']);
	}
	if($conf->btc[$btc_type]['btcopt']['pop']) {
		$btc_pop_utils = array();
		$btc_pop_max = 0;
		/* Pourrais être bien .. .mais illisible ..
		foreach($conf->btc as $type => $value) {
			if($value['btcopt']['pop']) {
				$btc_pop_utils[$type] = array('btc_nb' => $all_btc_array[$type]['btc_nb'],
									'btc_pop' => $conf->btc[$type]['population']);
				$btc_pop_max += $all_btc_array[$type]['btc_nb']*$conf->btc[$type]['population'];
			}
		}
		*/
		$btc_pop_utils[$btc_type] = array('btc_nb' => $btc_nb,
									'btc_pop' => $conf->btc[$btc_type]['population']);
		$btc_pop_max = $btc_nb *  $conf->btc[$btc_type]['population'];
		
		$_tpl->set('btc_pop_utils',$btc_pop_utils);
		$_tpl->set('btc_pop_max',$btc_pop_max);
		$_tpl->set('GAME_MAX_UNT_TOTAL',GAME_MAX_UNT_TOTAL);
		$_tpl->set('btc_pop_used',$_SESSION['user']['population']);
		
	}
	if($conf->btc[$btc_type]['btcopt']['prod'] && $conf->btc[$btc_type]['produit'][GAME_RES_BOUF]) {
		$btc_bouf_utils = array();
		$btc_bouf_total = 0;
		
		foreach($conf->btc as $type => $value) {
			if($value['produit'][GAME_RES_BOUF]) {
				/*$btc_pop_utils[$type] = array('btc_nb' => $all_btc_array[$type]['btc_nb'],
									'btc_pop' => $conf->btc[$type]['population']);*/
				$btc_bouf_total += $all_btc_array[$type]['btc_nb']*$conf->btc[$type]['produit'][GAME_RES_BOUF];
			}
		}
		
		$btc_bouf_utils[$btc_type] = array('btc_nb' => $btc_nb,
									'btc_res' => $conf->btc[$btc_type]['produit'][GAME_RES_BOUF]);

		$_tpl->set('btc_bouf_utils',$btc_bouf_utils);
		$_tpl->set('btc_bouf_total',$btc_bouf_total);
		$_tpl->set('btc_bouf_stock',$all_res_array[GAME_RES_BOUF]['res_nb']);
		$_tpl->set('btc_pop_max',$all_res_array[GAME_RES_PLACE]['res_nb']);
		$_tpl->set('btc_pop_used',$_SESSION['user']['population']);	
	}
	if($conf->btc[$btc_type]['btcopt']['prod'] 
		||
		($conf->btc[$btc_type]['produit'][GAME_RES_BOUF] && count($conf->btc[$btc_type]['produit']) > 1))
		{
		$gis_array = array();
		$res_utils_array = array();
		$res_prod_array = $conf->btc[$btc_type]['produit'];
	
		foreach($conf->btc[$btc_type]['prix'] as $type => $value) {
			if($conf->res[$type]['nobat']) {
				$gis_array[$type] = array('utils' => $btc_nb_total*$value,
									'dispo' => $all_res_array[$type]['res_nb'],
									'total' => $all_res_array[$type]['res_nb']+$btc_nb_total*$value);
			}
		}
		
		foreach($res_prod_array as $type => $value) {
			if($type != GAME_RES_BOUF) {
				if(is_array($conf->res[$type]['needres'])) {
					foreach($conf->res[$type]['needres'] as $type2 => $value2) {
						$res_utils_array[$type][$type2] = array('prix' => $value2,
													'nb' => $all_res_array[$type2]['res_nb']);
					}
				}
			} else {
				unset($res_prod_array[$type]);
			}
		}

		$_tpl->set("gis_array",$gis_array);
		$_tpl->set("res_prod_array",$res_prod_array);
		$_tpl->set("res_utils_array",$res_utils_array);
		
	}
}



?>