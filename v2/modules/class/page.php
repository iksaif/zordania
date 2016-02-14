<?php
if(!defined("_INDEX_")){ exit; }

require_once("lib/class.lib.php");
require_once("lib/member.lib.php");

$_tpl->set("module_tpl","modules/class/class.tpl");

$type = protect($_act, "uint");
$race = request("race", "uint", "get", 0);
$region = request("region", "uint", "get", 0);
if($race != 0 and (!in_array($race,$_races) or !$_races[$race]))
	$race = 0;
if($type==0)
	$type=1;

$_tpl->set("class_race",$race);
$_tpl->set("class_type",$type);
$_tpl->set("class_region",$region);
$array = get_nb_race();
$array = index_array($array, "mbr_race");
foreach($_races as $key => $value)
	if(!$value)
		unset($_races[$key]); /* masquer cette race */
	else if(!isset($array[$key]))
		$array[$key] = 0;

$_tpl->set("class_race_nb", $array);
$tab_class = make_class($type, $race, $region);
if ($type != 6)
{
	foreach ($tab_class as $key => $mbr)
	{
		$tab_class[$key]['ambr_aid'] = $mbr['al_aid'];
		unset($tab_class[$key]['al_aid']);
	}
}

if($_user['alaid']) {
	/* mes pactes */
	$dpl_atq = new diplo(array('aid' => $_user['alaid']));
	$dpl_atq_arr = $dpl_atq->actuels(); // les pactes actifs en tableau
	$_tpl->set('mbr_dpl',$dpl_atq_arr);
}
else
	$dpl_atq_arr = array();

if($type != 5 && $type != 6)
	$tab_class = can_atq_lite($tab_class, $_user['pts_arm'], $_user['mid'], $_user['groupe'], $_user['alaid'], $dpl_atq_arr);
	
$_tpl->set("class_array", $tab_class);
?>
