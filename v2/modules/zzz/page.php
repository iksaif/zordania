<?php
if(!defined("_INDEX_") || !can_d(DROIT_PLAY)) exit;
if(!can_d(DROIT_PLAY))
	$_tpl->set("need_to_be_loged",true); 
else {

require_once("lib/member.lib.php");

$_tpl->set("module_tpl","modules/zzz/zzz.tpl");

$_tpl->set("ZZZ_MIN",ZZZ_MIN);

$passmd5 = $_ses->crypt($_user['login'],request("mbr_pass", "string", "post"));

if($_act == "ronflz" && $_user['etat'] == MBR_ETAT_OK && $_user['pass'] == $passmd5) {
	edit_mbr($_user['mid'], array('etat' => 3,'ldate' => true));
	$_tpl->set('zzz_act','ronflz');
} elseif($_act == "dring" && $_user['etat'] == MBR_ETAT_ZZZ) {
	$_tpl->set('zzz_act','dring');

	$mbr_array = get_mbr_by_mid_full($_user['mid']);
	$ldate  = $mbr_array[0]['mbr_ldate'];

	$ldate = explode(' ',$ldate);
	$ldate[0] = explode('-',$ldate[0]);
	$ldate[1] = explode(':',$ldate[2]);

	$ltimestamp = mktime($ldate[1][0], $ldate[1][1], $ldate[1][2], $ldate[0][1], $ldate[0][0], $ldate[0][2]);
	$timestamp =time();

	if(($timestamp - $ltimestamp) > ZZZ_MIN * 24 * 60 * 60) {
		edit_mbr($_user['mid'], array('etat' => 1,'ldate' => true));
		$_tpl->set('zzz_ok',true);
	} else
		$_tpl->set('zzz_ok',false);

} else if($_user['etat'] == MBR_ETAT_ZZZ) {
	$_tpl->set('zzz_act','stats');

	$mbr_array = get_mbr_by_mid_full($_user['mid']);
	$ldate  = $mbr_array[0]['mbr_ldate'];

	$ldate_aff=$ldate;
	$ldate = explode(' ',$ldate);
	$ldate[0] = explode('-',$ldate[0]);
	$ldate[1] = explode(':',$ldate[2]);

	$ltimestamp = mktime($ldate[1][0], $ldate[1][1], $ldate[1][2], $ldate[0][1], $ldate[0][0], $ldate[0][2]);
	$timestamp = time();

	$_tpl->set('zzz_date',$ldate_aff);

	if(($timestamp - $ltimestamp) > ZZZ_MIN * 24 * 60 * 60)
		$_tpl->set('zzz_ok',true);
	else
		$_tpl->set('zzz_ok',false);
} else
	$_tpl->set('zzz_act','rien');

}
?>