<?php
if(!defined("_INDEX_") || !can_d(DROIT_PLAY)){ exit; }

require_once("lib/res.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/btc.lib.php");
require_once("lib/src.lib.php"); 
require_once("lib/member.lib.php");

$_tpl->set("module_tpl","modules/unt/unt.tpl");

$mbr = new member($_user['mid']);

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
			// on rembourse 50% du prix de ressources
			mod_res($_user['mid'], get_conf("unt", $unt_type, "prix_res"), 0.5 * $unt_nb);
			$_tpl->set('unt_sub','ok');

		}
	}
}

if(!$_act) {
	// config des unités: vie/group/role/prix_res/in_btc/need_btc ...
	$conf_unt = $mbr->get_conf("unt");
	/*
	// lister les besoins btc/src/unt/res
	// tout cela n'est utile que pour filtrer les requetes SQL
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
	*/
	
	// en cache tous les bat/src/res déjà fait
	$cache = array();
	$cache['btc'] = $mbr->nb_btc(); //(TODO: filter sur $need_btc ?);
	$cache['src'] = $mbr->src(); // TODO filtrer  $need_src ?
	$cache['res'] = $mbr->res(); // TODO filtrer $need_res?;
	// et aussi les unt, et unt_todo
	$cache['unt_todo'] = array();
	$cache['unt_leg'] = $mbr->unt_leg();
	$cache['unt'] = $mbr->unt();

	$unt_tmp = array();

	// calculer tout ce qu'on peut former ... ou pas
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

	$unt_tmp = $mbr->unt_leg();
	$unt_done = array();
	$nb = $mbr->get_conf("race_cfg", "unt_nb");
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
