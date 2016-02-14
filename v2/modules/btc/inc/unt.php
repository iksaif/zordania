<?php

if(!defined("INDEX_BTC")){ exit; }

require_once("lib/res.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/src.lib.php");
require_once("lib/btc.lib.php");
require_once("lib/member.lib.php");

$_tpl->set('TOTAL_MAX_UNT', TOTAL_MAX_UNT);
if($_sub == "cancel_unt")
{
	$uid = request("uid", "uint", "get");
	$nb = request("nb", "uint", "post");
	
	$_tpl->set("btc_act","cancel_unt");
	$_tpl->set("btc_uid", $uid);
	
	if(!$uid)
		$_tpl->set("btc_no_uid",true);
	elseif(!$nb)
		$_tpl->set("btc_no_nb",true);
	else {
		$infos = get_unt_todo($_user['mid'], array('uid' => $uid));
		
		if($infos && $infos[0]['utdo_nb'] >= $nb) {
			$_tpl->set("btc_ok",true);
			$_tpl->set("unt_canceled",$infos);

			$type = $infos[0]['utdo_type'];
			cnl_unt($_user['mid'], $uid, $nb);
			/* on récupère les unités mais que 50% des ressources: */
			edit_unt_vlg($_user['mid'], get_conf("unt", $type, "prix_unt"), 1 * $nb);
			mod_res($_user['mid'], get_conf("unt", $type, "prix_res"), 0.5 * $nb);
			edit_mbr($_user['mid'], array('population' => count_pop($_user['mid'])));
		} else
			$_tpl->set("btc_ok",false);
	}

} else if($_sub == "unt") {
	$_tpl->set("btc_act","unt");
	
	$unt_todo = get_unt_todo($_user['mid']);// toutes les unités 'todo'
	
	foreach($unt_todo as $id => $value) {// filtrer les unités du batiment concerné
		if(!in_array($btc_type,get_conf("unt",$value['utdo_type'],"in_btc")))
			unset($unt_todo[$id]);
	}

	$_tpl->set("unt_todo",$unt_todo);
	
	$conf_unt = get_conf("unt");// toutes les unités de la race
	$need_btc = array();// contiendra les bat requis pour les unités de ce batiment(?)
	$need_src = array();// contiendra les recherches requises pour les unités de ce batiment
	$need_unt = array();// contiendra les unités requises pour les unités de ce batiment
	$need_res = array();// contiendra les ressources requises pour les unités de ce batiment
	
	foreach($conf_unt as $type => $value) { 
		if(!in_array($btc_type, $value['in_btc']))// filtrer les unités du batiment
			unset($conf_unt[$type]);
		else { /* un peu de ménage */
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
	}
	
	$need_btc = array_unique($need_btc);
	$need_res = array_unique($need_res);
	$need_unt = array_unique($need_unt);
	$need_src = array_unique($need_src);
	asort($need_btc);
	asort($need_res);
	asort($need_unt);
	asort($need_src);

	$cache = array();// liste des res &  unt & bat ... disponibles (remplis les tables escamotables)
	$cache['btc'] = get_nb_btc_done($_user['mid'], $need_btc);
	$cache['btc'] = index_array($cache['btc'], "btc_type");
	$cache['src'] = get_src_done($_user['mid'], $need_src);
	$cache['src'] = index_array($cache['src'], "src_type");
	$cache['res'] = clean_array_res(get_res_done($_user['mid'], $need_res));
	$cache['res'] = $cache['res'][0];
	$cache['unt_todo'] = get_unt_todo($_user['mid']);
	$cache['unt_todo'] = index_array($cache['unt_todo'], "unt_todo");

	$cond = array('mid' => $_user['mid'], 'unt' => $need_unt, 'leg' => true);// ici on compte les unités (total & dispo)
	$unt_tmp = get_leg_gen($cond);
	$unt_done = array();

	$unt_done['vlg'] = $unt_done['btc'] = array();
	foreach($unt_tmp as $value) {
		if($value['leg_etat'] == LEG_ETAT_VLG) {
			$unt_done['vlg'][$value['unt_type']] = $value['unt_nb'];
		} else {
			$unt_done['btc'][$value['unt_type']] = $value['unt_nb'];
		}
		
		if(!isset($unt_done['tot'][$value['unt_type']]))
			$unt_done['tot'][$value['unt_type']] = 0;
		$unt_done['tot'][$value['unt_type']] += $value['unt_nb'];
	}

	$cache['unt'] = $unt_done['vlg'];
	$cache['unt_leg'] = $unt_done['btc'];

	foreach($unt_todo as $value) {
		if(!isset($cache['unt_todo'][$value['utdo_type']]['utdo_nb']))
			$cache['unt_todo'][$value['utdo_type']]['utdo_nb'] = 0;
			
		$cache['unt_todo'][$value['utdo_type']]['utdo_nb'] += $value['utdo_nb'];
	}

	$unt_tmp = array();// on va lister les unités qu'on peut former dans ce batiment
	
	foreach($conf_unt as $type => $value) { 
		$unt_tmp[$type]['bad'] = can_unt($_user['mid'],  $type, 1, $cache);// vérifie qu'on peut faire 1 unité du $type, indique ce qui manque
		$unt_tmp[$type]['conf'] = $value;
	}
	
	$unt_array = array();
	foreach($unt_tmp as $uid => $array) {
		if($array['bad']['need_src'] || $array['bad']['need_btc']) continue;
		$unt_array[$uid] = $array;// on ne garde que les unités dont on a tous les batiments et recherches
	}
	
	unset($unt_tmp);

	/* Sert a rien d'afficher les unités qu'ont peut former */
	foreach($conf_unt as $type => $value) {// i.e: on enlève du cache les unités formées dans ce batiment
		if(in_array($btc_type, $value['in_btc'])) {
			unset($cache['unt'][$type]);
		}
	}

	$_tpl->set("unt_dispo", $unt_array);// unités possibles à former
	$_tpl->set("res_utils", $cache['res']);
	$_tpl->set("unt_utils", $cache['unt']);
	$_tpl->set("unt_done", $unt_done);
	
	$_tpl->set("unt_conf", $conf_unt);
	$_tpl->set("btc_pop_used", $_user['population']);
	$_tpl->set("btc_pop_max", $_user['place']);
	$_debugvars['unt_array'] = $unt_array;

}
//Nouvelle unt (sauf de type heros)
elseif($_sub == "add_unt")
{
	$type = request("type", "uint", "post");
	$role = get_conf("unt", $type, "role");
	$nb = request("nb", "uint", "post");

	if($type) { /* calcul pop y compris formation en cours */
		$unt_todo = get_unt_todo($_user['mid']);
		$unt_todo_nb = 0;
		foreach($unt_todo as $value)
			$unt_todo_nb += $value['utdo_nb'];

		$prix_nb = 0;
		$prix_unt = (array) get_conf("unt", $type, "prix_unt");
		foreach($prix_unt as $key => $value)
			$prix_nb += $value * $nb;

		$unt_nb = $_user['population'] + $nb + $unt_todo_nb - $prix_nb;
	}

	$_tpl->set("btc_act","add_unt");
	if(!$type)
		$_tpl->set("btc_no_type",true);
	else if($role == TYPE_UNT_HEROS)
		$_tpl->set("type_no_heros",true);
	else if(!$nb)
		$_tpl->set("btc_no_nb",true);
	else if($unt_todo_nb + $nb > TODO_MAX_UNT)
		$_tpl->set("btc_unt_todo_max",TODO_MAX_UNT);
	else if($unt_nb > TOTAL_MAX_UNT || $unt_nb > $_user['place'])
		$_tpl->set("btc_unt_total_max",TOTAL_MAX_UNT);
	else {
			$array = can_unt($_user['mid'], $type, $nb);

			if(isset($array['do_not_exist']))
				$_tpl->set("btc_no_type",true);
			else {
				$ok = !($array['need_src'] || $array['need_btc'] || $array['limit_unt'] || $array['prix_res'] || $array['prix_unt']);
				$_tpl->set("unt_type", $type);
				$_tpl->set("unt_nb", $nb);
				$_tpl->set("unt_infos", $array);
				$_tpl->set("btc_ok", $ok);
				if($ok) {
					edit_unt_vlg($_user['mid'], get_conf("unt", $type, "prix_unt"), -1 * $nb);
						// si nb vaut 1 alors on fait le calcul normal, LIGNE ORIGINAL A GARDER sans la condition
						if ($nb == 1 ) {mod_res($_user['mid'], get_conf("unt", $type, "prix_res"), -1 * $nb);}
						// si impaire alors 50% - 1
						elseif ($nb&1 ) {mod_res($_user['mid'], get_conf("unt", $type, "prix_res"), -1 * $nb / 2 -1 );}
						//si non pair donc 50%
						else {mod_res($_user['mid'], get_conf("unt", $type, "prix_res"), -1 * $nb / 2);}
					scl_unt($_user['mid'], array($type =>$nb));
					edit_mbr($_user['mid'], array('population' => count_pop($_user['mid'])));
				}
			}
	}
}
?>
