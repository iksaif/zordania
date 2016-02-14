<?
if(_index_!="ok"){ exit; }
if($_act == "dev")
{
	$_tpl->set('module_tpl','modules/a_propos/dev.tpl');
}
elseif($_act == "whatiszord")
{
	$_tpl->set('module_tpl','modules/a_propos/whatiszord.tpl');
}
elseif($_act == "legal")
{
	$_tpl->set('module_tpl','modules/a_propos/legal.tpl');
}
else
{
	$team_array = $mbr->get_infos(0,50, $src = array('gid' => array(4,5,6,7,8)),false,false,array('ASC','groupe'));
	//print_r($team_array);
	$_tpl->set('team_array',$team_array);
	$_tpl->set('module_tpl','modules/a_propos/a_propos.tpl');
}
?>