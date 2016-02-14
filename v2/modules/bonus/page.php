<?php
//Verifications
if(!defined("_INDEX_")){ exit; }
if(can_d(DROIT_PLAY)!=true)
	$_tpl->set("need_to_be_loged",true); 
else
{
//require_once("lib/votes.lib.php");
require_once("lib/bonus.lib.php");
require_once("lib/member.lib.php");
require_once("lib/mch.lib.php");
require_once("lib/res.lib.php");

$_tpl->set('module_tpl', 'modules/bonus/bonus.tpl');

$type_res = request("type_res", "uint", "post", request("type_res", "uint", "get"));
$id = request("id", "uint", "get");
//$votes=get_conf("votes");

if(!get_conf("res", $type_res))
	$type_res = 0;

if($id == 66656) {
	$_tpl->set('bon_act','donner');

	$res_cfg = array();
	$coef = get_conf("race_cfg", "bonus_res", GAME_RES_PRINC);
	$or = ((MIN_BONUS_NB) + $coef * $_user['points']);
	$res_cfg[1] = round(($or > GAME_MAX_BONUS) ? GAME_MAX_BONUS : $or);

	$cours = mch_get_cours($type_res);
	foreach($cours as $value) {
		$res_cfg[$value['mcours_res']] = ceil($or / max(0.1, $value['mcours_cours']));
	}
	$nb_res = isset($res_cfg[$type_res]) ? $res_cfg[$type_res] : 0;

	if($nb_res && bonus_test()) {
		$_tpl->set('bon_ok', true);
		mod_res($_user['mid'], array($type_res => $nb_res));
		if ($_user['parrain'])
		{
			$parrain = get_mbr_by_mid_full($_user['parrain']);
			if ($parrain)
			{
				$nb = ceil($nb_res * PARRAIN_BONUS_PRC / 100);
				mod_res($_user['parrain'], array($type_res => $nb));
				$_histo->add($_user['parrain'], $_user['mid'], HISTO_PARRAIN_BONUS,array("res_type" => $type_res, "res_nb" => $nb));
			}
		}
		$_tpl->set('bon_nb_res',$nb_res);
		$_tpl->set('bon_type_res',$type_res);
	} else {
		$_tpl->set('bon_error','code_error');
		$nb_res = 0;
	}

	$code = request("code", "string", "get");
	bonus_log($_user['mid'], $code, ($nb_res != 0), $type_res, $nb_res);
} else if(!$type_res) {
	//Formulaire
	$_tpl->set('bon_act','liste');

	$res_cfg = array();
	$coef = get_conf("race_cfg", "bonus_res", GAME_RES_PRINC);
	$or = ((MIN_BONUS_NB) + $coef * $_user['points']);
	$res_cfg[1] = round(($or > GAME_MAX_BONUS) ? GAME_MAX_BONUS : $or);

	$cours = mch_get_cours();
	foreach($cours as $value) {
		$res_cfg[$value['mcours_res']] = ceil($or / max(0.1,$value['mcours_cours']));
	}

	$_tpl->set('bon_list_res',$res_cfg);
} else {
	$_tpl->set('bon_act','tel');
	if($_act == "error")
		$_tpl->set('bon_error','code_error');
	$_tpl->set('type_res',$type_res);
}

}
?>
