<?php
if(!defined("_INDEX_") || !can_d(DROIT_PLAY)){ exit; }

require_once("lib/res.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/btc.lib.php");
require_once("lib/src.lib.php"); 
require_once("lib/member.lib.php");

$_tpl->set("module_tpl","modules/unt/unt.tpl");

if($_act == "pend") {
	$unt_type = request("unt_type", "uint", "get");
	$unt_nb = request("unt_nb", "uint", "post");

	if(!$unt_type || !$unt_nb || !get_conf("unt", $unt_type)) {
		$_act = false;
		$_tpl->set('unt_sub','error');
	} else if (get_conf('unt', $unt_type, 'role') == TYPE_UNT_HEROS) {
		$_act = false;
		$_tpl->set('no_heros',false);
	} else {
		$_tpl->set('unt_act','pend');
		$unt_array = get_unt_done($_user['mid'], array($unt_type));
		if(!$unt_array || $unt_nb > $unt_array[0]['unt_nb'])
			$_tpl->set('unt_sub','paspossible');
		else  {
			edit_unt_vlg($_user['mid'], array($unt_type => $unt_nb), -1);
			edit_mbr($_user['mid'], array('population' => count_pop($_user['mid'])));
			mod_res($_user['mid'], get_conf("unt", $unt_type, "prix_res"), 0.5 * $unt_nb);
			$_tpl->set('unt_sub','ok');

		}
	}
}

if(!$_act) {
	// config des unités: vie/group/role/prix_res/in_btc/need_btc ...
	$conf_unt = get_conf("unt");
	// lister les besoins btc/src/unt/res
	$need_btc = array();
	$need_src = array();
	$need_unt = array();
	$need_res = array();

	foreach($conf_unt as $type => $value) {
		if(isset($value['need_btc']))
			$need_btc = array_merge($value['need_btc'], $need_btc);
		if(isset($value['prix_res']))
			$need_res = array_merge(array_keys($value['prix_res']), $need_res);
		if(isset($value['prix_unt']))
			$need_unt = array_merge(array_keys($value['prix_unt']), $need_unt);
		if(isset($value['need_src']))
			$need_src = array_merge($value['need_src'], $need_src);
		array_push($need_unt,$type);
	}

	$need_btc = array_unique($need_btc); asort($need_btc);
	$need_res = array_unique($need_res); asort($need_res);
	$need_unt = array_unique($need_unt); asort($need_unt);
	$need_src = array_unique($need_src); asort($need_src);

	// en cache tous les bat/src/res déjà fait
	$cache = array();
	$cache['btc'] = get_nb_btc_done($_user['mid'], $need_btc);
	$cache['btc'] = index_array($cache['btc'], "btc_type");
	$cache['src'] = get_src_done($_user['mid'], $need_src);
	$cache['src'] = index_array($cache['src'], "src_type");
	$cache['res'] = clean_array_res(get_res_done($_user['mid'], $need_res));
	$cache['res'] = $cache['res'][0];
	// et aussi les unt, et unt_todo
	$cache['unt_todo'] = array();
	$cache['unt_leg'] = array();
	$cache['unt'] = array();
	$cond = array('mid' => $_user['mid'], 'unt' => array(), 'leg' => true);
	$unt_tmp = get_leg_gen($cond);
	foreach($unt_tmp as $value) {
		$t_type = $value['unt_type'];
		$t_nb = $value['unt_nb'];
		$t_etat = $value['leg_etat'];
		if($t_etat == LEG_ETAT_VLG) {
			if(!isset($cache['unt'][$t_type]))
				$cache['unt'][$t_type] = 0;
			$cache['unt'][$t_type] += $t_nb;
		} else {
			if(!isset($cache['unt_leg'][$t_type]))
				$cache['unt_leg'][$t_type] = 0;
			$cache['unt_leg'][$t_type] += $t_nb;
		}
	}

	$unt_tmp = array();

	foreach($conf_unt as $type => $value) {
		$unt_tmp[$type]['bad'] = can_unt($_user['mid'],  $type, 1, $cache);
		$unt_tmp[$type]['conf'] = $value;
	}

	$unt_array = array();
	foreach($unt_tmp as $uid => $array) {
		$vlg_unt = isset($cache['unt'][$uid]) && $cache['unt'][$uid];
		$leg_unt = isset($cache['unt_leg'][$uid]) && $cache['unt_leg'][$uid];
		if(!$vlg_unt && !$leg_unt  &&  ($array['bad']['need_src'] || $array['bad']['need_btc'])) continue;
		$unt_array[$uid] = $array;
	}
	unset($unt_tmp);

	$cond = array('mid' => $_user['mid'], 'unt' => array(), /*'etat' => array(LEG_ETAT_VLG, LEG_ETAT_BTC),*/ 'leg' => true);
	$unt_tmp = get_leg_gen($cond);
	$unt_done = array();
	$nb = get_conf("race_cfg", "unt_nb");
	for($i = 1; $i <= $nb; ++$i)
		$unt_done['tot'][$i] = $unt_done['vlg'][$i] = $unt_done['btc'][$i] = 0;

	foreach($unt_tmp as $value) {
		if($value['leg_etat'] == LEG_ETAT_VLG)
			$unt_done['vlg'][$value['unt_type']] = $value['unt_nb'];
		else
			$unt_done['btc'][$value['unt_type']] = $value['unt_nb'];

		if(!isset($unt_done['tot'][$value['unt_type']]))
			$unt_done['tot'][$value['unt_type']] = 0;
		$unt_done['tot'][$value['unt_type']] += $value['unt_nb'];
	}

	$_tpl->set("unt_done", $unt_done);
	$_tpl->set("unt_dispo",$unt_array);

	$unt_type = request("unt_type", "uint", "get");
	if($unt_type) {
		if (get_conf('unt', $unt_type, 'role') == TYPE_UNT_HEROS)
			$_tpl->set('no_heros',false);
		else {
			$btc = get_conf("unt", $unt_type, "in_btc");
			if($btc) {
				$_tpl->set('unt_type',$unt_type);
				$_tpl->set('btc_type',$btc[0]);
			}
		}
	}
}
?>
