<?php
if(!defined("_INDEX_")) exit;
if(!can_d(DROIT_PLAY)) 
	$_tpl->set("need_to_be_loged",true); 
else {
	$_tpl->set('module_tpl','modules/histo/histo.tpl');

	if($_act == "all") {
		$limite1 = 0;
		$limite2 = 0;
	} else {
		$limite1 = LIMIT_PAGE;
		$limite2 = 0;
	}
	
	$_tpl->set("histo_array",get_histo($_user['mid'],$limite1,$limite2));
	$_tpl->set('histo_key',calc_key($_file, $_user['login']));
/*
foreach ($_tpl->var->histo_array as $key => $val) 
	if ($val['histo_type'] == HISTO_LEG_ATQ_LEG or $val['histo_type'] == HISTO_LEG_ATQ_VLG) print_r($val);
*/
$_debugvars['histo'] = $_tpl->var->histo_array ;
}
?>
