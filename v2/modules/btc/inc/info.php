<?php
if(!defined("INDEX_BTC")){ exit; }
require_once("lib/res.lib.php");
require_once("lib/trn.lib.php");

if(!$_sub) { 
	$_tpl->set("btc_act", "infos");
	if(isset($btc_conf['defense']))
		$_tpl->set("btc_def",$btc_conf['defense']['bonus']);

	if(isset($btc_conf['prod_res_auto'])) {
		$btc_array = get_nb_btc_done($_user['mid']);
		$btc_array = index_array($btc_array, "btc_type");
		$res_array = get_res_done($_user['mid']);
		$res_array = clean_array_res($res_array);
		$res_array = $res_array[0];
	}
	if(isset($btc_conf['prod_pop'])) {
		$btc_pop_utils = array();
		$btc_pop_max = 0;

		$btc_pop_utils[$btc_type] = array('btc_nb' => $btc_nb, 'btc_pop' => $btc_conf['prod_pop']);

		$btc_pop_max = $btc_nb *  $btc_conf['prod_pop'];
		$btc_pop_max = $_user['place'];

		$_tpl->set('btc_pop_utils',$btc_pop_utils);
		$_tpl->set('btc_pop_max',$btc_pop_max);
		$_tpl->set('TOTAL_MAX_UNT',TOTAL_MAX_UNT);
		$_tpl->set('btc_pop_used',$_user['population']);
	}
	$btc_bouf = false;
	if(isset($btc_conf['prod_res_auto'][GAME_RES_BOUF])) {
		$btc_bouf_utils = array();
		$btc_bouf_total = 0;

		$conf_all_btc = get_conf("btc");

		foreach($conf_all_btc as $type => $value) {
			$prod = get_conf("btc", $type, "prod_res_auto");
			if(isset($btc_array[$type]) && isset($prod[GAME_RES_BOUF])) {
				$btc_bouf_utils[$type] = array('btc_nb' => $btc_array[$type]['btc_nb'], 'btc_res' => $prod[GAME_RES_BOUF]);
				$btc_bouf_total += $btc_array[$type]['btc_nb']* $prod[GAME_RES_BOUF];
			}
		}

		$leg_bouf_tmp = get_res_leg($_user['mid']);
		$leg_unt = get_legions_unt( $_user['mid']);
		$leg_unt = index_array($leg_unt, "leg_id");

		foreach ($leg_bouf_tmp as $value)
			if ($value['lres_type'] == GAME_RES_BOUF){
				if($leg_unt[$value['lres_lid']]['unt_nb'] <= $value['lres_nb'])
					unset($leg_unt[$value['lres_lid']]);
				else
					$leg_unt[$value['lres_lid']]['res_bouf'] = $value['lres_nb'];
			}
		foreach($leg_unt as $lid => $leg)
			if(!isset($leg['res_bouf']))
				$leg_unt[$lid]['res_bouf'] = 0;

		$leg_need_bouf = 0;
		foreach ($leg_unt AS $lid => $value)// décompter la nourriture consommée
		{
			$nb = $value['unt_nb'];// nb d'unités de la légion
			if (isset($value['res_bouf']))// si la légion a de la nourriture
				$nb -= $value['res_bouf'];// elle se nourrit
			if ($nb > 0)// s'il reste des unités non nourries
				$leg_need_bouf += $nb;// on les comptabilise
		}

		$vlg_need_bouf = count_pop($_user['mid'], array(LEG_ETAT_VLG, LEG_ETAT_BTC));

		$_tpl->set('btc_bouf', true);
		$_tpl->set('btc_bouf_utils',$btc_bouf_utils);
		$_tpl->set('leg_array',$leg_unt);
		$_tpl->set('btc_bouf_total',$btc_bouf_total);
		$_tpl->set('btc_bouf_stock',$res_array[GAME_RES_BOUF]);
		$_tpl->set('btc_pop_max',$_user['place']);
		$_tpl->set('btc_pop_used',$vlg_need_bouf + $leg_need_bouf);
		$_tpl->set('btc_pop_vlg', $vlg_need_bouf);
		$_tpl->set('btc_pop_leg', $leg_need_bouf);
	}
	if(($btc_bouf && count($btc_conf['prod_res_auto']) > 1) || (!$btc_bouf && isset($btc_conf['prod_res_auto']))) {
		$gis_array = array();
		$res_utils_array = array();
		$res_prod_array = $btc_conf['prod_res_auto'];
	
		$trn_array = get_trn($_user['mid']);
		$trn_array = clean_array_trn($trn_array);
		
		if(isset($btc_conf['prox_trn'])) {
			foreach($btc_conf['prix_trn'] as $type => $value) {
				$nb = isset($trn_array[$type]) ? $trn_array[$type] : 0;
				
				$gis_array[$type] = array('utils' => $btc_nb_total*$value,
									'dispo' => $nb,
									'total' => $nb + $btc_nb_total*$value);
			}
		} else
			$gis_array = array();
		
		foreach($res_prod_array as $type => $value) {
			if($type != GAME_RES_BOUF) {
				$needres = get_conf("res", $type, "prix_res");
				foreach($needres as $type2 => $value2) {
					$res_utils_array[$type][$type2] = array('prix' => $value2, 'nb' => $res_array[$type2]);
				}
			} else {
				unset($res_prod_array[$type]);
			}
		}

		$_tpl->set("btc_prod", true);
		$_tpl->set("gis_array",$gis_array);
		$_tpl->set("res_prod_array",$res_prod_array);
		$_tpl->set("res_utils_array",$res_utils_array);
		
	}
}



?>
