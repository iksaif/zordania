<?php
if(!defined("_INDEX_")){ exit; }

/* Nécessaire */
require_once("lib/res.lib.php");
require_once("lib/btc.lib.php");

$decal = $_user['decal'];

if(strpos($decal, "-")!==false) {
	$decal = str_replace('-','',$decal);
	$delta = 1;
} else
	$delta = -1;	

$decal = strtotime($decal)-strtotime(date("Y-m-d 00:00:00"));
$_tpl->set("stats_date",date("d-m-Y H:i:s",time()-$delta*$decal));

/* On dit que ça commence toujours à 0, et que y'a forcément un nombre pile de tours dans une heure
 * donc le calcul marche bien */
if(!is_float(ZORD_SPEED)) {
	$next_turn = ZORD_SPEED - (date("i") % ZORD_SPEED);
	$next_turn = $next_turn . " min";
} else {
	$speed = ZORD_SPEED * 60;
	$next_turn = round($speed - (date("s") % $speed));
	$next_turn = $next_turn . " sec";
}
 
$_tpl->set("stats_next_turn",$next_turn);

if(!$log_in_out && can_d(DROIT_PLAY) && $_user['etat'] != MBR_ETAT_INI)
{
	$vil_btc = get_conf("race_cfg", "primary_btc", "vil");
	$ext_btc = get_conf("race_cfg", "primary_btc", "ext");
	$array_btc = $vil_btc + $ext_btc;
	$cond_btc = array_keys($array_btc);

	$cond_res = get_conf("race_cfg", "primary_res");
	$prim_res = clean_array_res(get_res_done($_user['mid'], $cond_res));
	if($prim_res)
		$prim_res = $prim_res[0];
	foreach($prim_res as $key => $value)
		if($value >= 1000000)
			$prim_res[$key] = floor($value/1000000).'M';

	$_tpl->set("stats_prim_res", $prim_res);

	$tmp_btc = get_nb_btc($_user['mid'], $cond_btc, array(BTC_ETAT_OK));

	$prim_btc = array('vil' => array(), 'ext' => array());
	foreach($tmp_btc as $values) {
		$type = $values['btc_type'];
		$nb = $values['btc_type'];
		if(isset($vil_btc[$type]))
			$prim_btc['vil'][$type] = $vil_btc[$type];
		if(isset($ext_btc[$type]))
			$prim_btc['ext'][$type] = $ext_btc[$type];
	}
	$_tpl->set("stats_prim_btc", $prim_btc);
}

?>
