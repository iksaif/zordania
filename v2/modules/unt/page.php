<?php
if(!defined("_INDEX_")){ exit; }
if(!can_d(DROIT_PLAY)){
	$_tpl->set("need_to_be_loged",true); 
}else{

require_once("lib/res.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/btc.lib.php");
require_once("lib/src.lib.php"); 
require_once("lib/member.lib.php");

$_tpl->set("module_tpl","modules/unt/unt.tpl");

$mbr = new member($_user['mid']);
$unt_type = request("unt_type", "uint", "get");

if($_act == "pend") {
	$unt_nb = request("unt_nb", "uint", "post");

	if(!$unt_type || !$unt_nb || !$mbr->get_conf("unt", $unt_type)) {
		$_act = false;
		$_tpl->set('unt_sub','error');
	} else if ($mbr->get_conf('unt', $unt_type, 'role') == TYPE_UNT_HEROS) {
		$_act = false;
		$_tpl->set('no_heros',false);
	} else {
		$_tpl->set('unt_act','pend');
		if($unt_nb > $mbr->nb_unt($unt_type))
			$_tpl->set('unt_sub','paspossible');
		else  {
			edit_unt_vlg($_user['mid'], array($unt_type => $unt_nb), -1);
			edit_mbr($_user['mid'], array('population' => count_pop($_user['mid'])));
			// on rembourse 50% du prix de ressources
			mod_res($_user['mid'], $mbr->get_conf("unt", $unt_type, "prix_res"), 0.5 * $unt_nb);
			$_tpl->set('unt_sub','ok');

		}
	}
}

if(!$_act) {
	// config des unités: vie/group/role/prix_res/in_btc/need_btc ...
	$conf_unt = $mbr->get_conf("unt");

	$unt_tmp = array();

	// calculer tout ce qu'on peut former ... ou pas
	foreach($conf_unt as $type => $value) {
        // requete pour 1 seul type d'unité
        if(!empty($unt_type) && $unt_type != $type) continue;
		$unt_tmp[$type]['bad'] = $mbr->can_unt($type, 1);
		$unt_tmp[$type]['conf'] = $value;
	}

	$unt_array = array();
	foreach($unt_tmp as $uid => $array) {
        // requete pour 1 seul type d'unité
        if(!empty($unt_type) && $unt_type != $uid) continue;
        // si manque une recherche ou un bat, on ignore cette unité
        if(!empty($array['bad']['need_src']) || !empty($array['bad']['need_btc'])) continue;
		$unt_array[$uid] = $array;
	}
	unset($unt_tmp);

	$unt_done = array();
	$nb = $mbr->get_conf("race_cfg", "unt_nb");
	for($i = 1; $i <= $nb; ++$i)
		$unt_done['tot'][$i] = $unt_done['vlg'][$i] = $unt_done['btc'][$i] = 0;

	$unt_tmp = $mbr->unt();
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
    $_tpl->set('unt_todo', $mbr->unt_todo());

	if($unt_type) {
		if ($mbr->get_conf('unt', $unt_type, 'role') == TYPE_UNT_HEROS)
			$_tpl->set('no_heros',false);
		else {
			$btc = $mbr->get_conf("unt", $unt_type, "in_btc");
			if($btc) {
				$_tpl->set('unt_type',$unt_type);
				$_tpl->set('btc_type',$btc[0]);
			}
        }
        $_tpl->set("unt_dispo",$unt_array[$unt_type]);
    }
    else{
        $_tpl->set("unt_dispo",$unt_array);
    }
}

}
?>
