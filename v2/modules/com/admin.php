<?php
//Verif
if(!defined("_INDEX_") || !can_d(DROIT_ADM_COM)){ exit; }

require_once("lib/mch.lib.php");

$_tpl->set("admin_tpl","modules/com/admin.tpl");
$_tpl->set("admin_name","Commerce");

$_tpl->set('COM_TAUX_MIN',COM_TAUX_MIN);
$_tpl->set('COM_TAUX_MAX',COM_TAUX_MAX);
$_tpl->set('MCH_COURS_MIN',MCH_COURS_MIN);
$_tpl->set('btc_act','');

if($_act == "cours") {
	$_tpl->set('btc_act','cours');
	
	$com_nb = request("com_nb", "uint", "post", 1);
	$com_mod = request("com_mod", "array", "post");
	
	foreach($com_mod as $res_id => $res_cours) 
		mch_update_cours($res_id, ($res_cours/$com_nb) );
		
	$_tpl->set('mch_cours',mch_get_cours());
	$_tpl->set('com_nb',$com_nb);
} else if($_act == "cours_sem") {
	$_tpl->set('btc_act','cours_sem');
	
	$com_mod = request("com_mod", "array", "post");
	foreach($com_mod as $res_jour => $res_value)
		foreach($res_value as $res_id => $res_cours)
			mch_update_cours_sem($res_id,$res_cours,$res_jour); 
	
	$tmp = mch_get_cours_sem(0,7);
	foreach($tmp as $result)
		$mch_cours[$result['msem_res']][] = $result;
		
	$_tpl->set('mch_cours',$mch_cours);
}
?>