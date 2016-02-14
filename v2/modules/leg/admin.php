<?php
//Verif
if(!defined("_INDEX_") || !can_d(DROIT_ADM_COM)){ exit; }

require_once("lib/unt.lib.php");

$_tpl->set("admin_tpl","modules/leg/admin.tpl");
$_tpl->set("admin_name","Compétences");

$cpt = array();
foreach ($_races as $i => $value) {
	$tmp = get_conf_gen($i, 'comp');
	foreach($tmp as $key => $val)
		$cpt[$val['type']][$key][$i] = $val;
}

$_tpl->set('cpt',$cpt);

?>
