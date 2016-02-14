<?php
if(!defined("_INDEX_")){ exit; }

require_once("lib/res.lib.php");
require_once("lib/member.lib.php");

$mid = request("mid", "string", "get", $_user['mid']);

if(!$mid)
	exit;

$_module_tpl = "modules/member/member_xml.tpl";

$mbr_array = get_mbr_by_mid_full($mid);

if($mbr_array) {
	$mbr_array = $mbr_array[0];
	$race = $mbr_array['mbr_race'];
	if($mbr_array['ambr_etat'] == ALL_ETAT_DEM) {
		$mbr_array['al_name'] = "";
		$mbr_array['ambr_aid'] = 0;
	}
}

if(!$mbr_array || !in_array($race, $_races))
{
	$_tpl->set('bad_mid',true);
} else {
	load_conf($race);
	$cond_res = get_conf_gen($race, "race_cfg", "primary_res");
	$prim_res = clean_array_res(get_res_done($mid, $cond_res));

	$_tpl->set("res_array",$prim_res[0]);
	$_tpl->set('mbr_array',$mbr_array);
	$_tpl->set('mbr_online',is_online($mid));
}
?>