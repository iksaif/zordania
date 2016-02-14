<?php
//Verif
if(!defined("_INDEX_") || !can_d(DROIT_ADM_COM)){ exit; }

$race = request('race','uint','get',1);
$_tpl->set("admin_tpl","modules/btc/admin.tpl");
$_tpl->set("admin_name","Compétences");
$_tpl->set('list_btc',get_conf_gen($race, 'btc'));
$_tpl->set('race_sel',$race);

?>
