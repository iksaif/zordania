<?php
if(!defined("_INDEX_") || !can_d(DROIT_PLAY)){ exit; }
if(!can_d(DROIT_PLAY)) 
	$_tpl->set("need_to_be_loged",true); 
else {

require_once("lib/res.lib.php");
require_once("lib/trn.lib.php");

$_tpl->set("module_tpl","modules/res/res.tpl");

$res_array = get_res_done($_user['mid']);
$res_array = clean_array_res($res_array);
$_tpl->set("res_dispo",$res_array[0]);

$trn_array = get_trn($_user['mid']);
$trn_array = clean_array_trn($trn_array);
$_tpl->set("trn_dispo",$trn_array[0]);

}
?>
