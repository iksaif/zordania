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

$_tpl->set('COM_ETAT_OK',COM_ETAT_OK);
$_tpl->set('module_tpl','modules/gen/gen.tpl');


/* Ressources */
$cond_res = get_conf("race_cfg", "second_res");
$prim_res = clean_array_res(get_res_done($_user['mid'], $cond_res));
$_tpl->set("res_array", $prim_res[0]);

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


//Attaques (- de 10 cases)
//$atq_array = get_leg_dst_vlg($_user['map_x'], $_user['map_y'], 5);
// toutes les légions ennemies venant vers le village
$atq_array = get_leg_dest($_user['mid'], $_user['mapcid']);
$_tpl->set('atq_array',$atq_array);
$res = get_leg_dpl($_user['mid'], LEG_ETAT_ALL);
print_r($res);
$_tpl->set('leg_array' ,get_leg_dpl($_user['mid'], LEG_ETAT_ALL));
$_tpl->set('dst_view_max', DST_VIEW_MAX);

//ventes
$vente_array = get_mch_by_mid($_user['mid']);
$_tpl->set('vente_array',$vente_array);
}
?>
