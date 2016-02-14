<?php
if(!defined("_INDEX_")){ exit; }

require_once("lib/mch.lib.php");

$jours = request("jours", "uint", "post", request('jours', 'uint', 'get'));

$_module_tpl = "modules/com/cours_xml.tpl";

$tmp = mch_get_cours_sem(0,$jours);
$array = array();
foreach($tmp as $values) {
	$array[$values['msem_date']][$values['msem_res']] = $values['msem_cours'];
}

$_tpl->set("com_cours", $array);

?>
