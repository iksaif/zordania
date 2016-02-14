<?php
if(!defined("_INDEX_")){ exit; }
if($_act == "dev")
{
	$_tpl->set('module_tpl','modules/a_propos/dev.tpl');
}
elseif($_act == "legal")
{
	$_tpl->set('module_tpl','modules/a_propos/legal.tpl');
}
elseif($_act == "rec") // SI REC : n'affiche que les recompenses de get_rec_gen
{
	$_tpl->set('module_tpl','modules/a_propos/a_propos.tpl');
	$_tpl->set("a_propos_act","rec");
	require_once("lib/rec.lib.php");
	$rec_rois = array ( 1,2,3,4,5,6,7,8,9,10);
	foreach ($rec_rois as $i) $rec_array[$i]=get_rec_array($i);
	$_tpl->set('rec_array',$rec_array);
}
elseif($_act == "roi") // SI ROI : les nouvelles recompenses
{
	$_tpl->set('module_tpl','modules/a_propos/a_propos.tpl');
	$_tpl->set("a_propos_act","roi");
	require_once("lib/rec.lib.php");
	$rec_rois = array ( 11,12,21,22,31,32,41,42,51,52,71,72);
	$rec_array = array();
	foreach ($rec_rois as $i) {
		$temp = get_rec_array($i);
		if(!empty($temp))
			$rec_array[$i] = $temp;
	}
	$_tpl->set('rec_array',$rec_array);
}
elseif($_act == "le_site")
{
	$_tpl->set('module_tpl','modules/a_propos/a_propos.tpl');
	$_tpl->set("a_propos_act","le_site");
}
elseif($_act == "boutons")
{
	$_tpl->set('module_tpl','modules/a_propos/a_propos.tpl');
	$_tpl->set("a_propos_act","boutons");
}
else
{
	$_tpl->set("a_propos_act","equipe");
	$_tpl->set('module_tpl','modules/a_propos/a_propos.tpl');
		
	require_once("lib/member.lib.php");
	$cond = array();
	$cond['gid'] = array(GRP_DIEU,GRP_DEMI_DIEU,GRP_ADM_DEV,GRP_PRETRE,GRP_DEV,GRP_GARDE,GRP_SAGE,GRP_NOBLE);
	//$cond['orderby'] = array('ASC','gid');
	$team_array = get_mbr_gen($cond);
	//regrouper & ordonner
	$team_order=array();
	foreach($cond['gid'] as $grp)
		foreach($team_array as $key => $mbr)
			if($mbr['mbr_gid']==$grp){
				$team_order[$grp][] = $mbr;
				//unset($team_array[$key]);
			}
	$_tpl->set('team_order',$team_order);
	$_tpl->set('module_tpl','modules/a_propos/a_propos.tpl');
}
?>
