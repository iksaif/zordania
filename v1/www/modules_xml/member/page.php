<?
if(_index_!="ok"){ exit; }
$mid = (int) isset($_GET['mid']) ? $_GET['mid'] : "";
if(!$mid)
{
	exit;
}
$conf=array();
$mbr = new member($_sql, $game, $conf);
$mbr_array = $mbr->get_infos($mid);

if(!isset($mbr_array[0]) or $mid == 0)
{
	$_tpl->set('bad_mid',true);
}
else
{
	$mbr_array = $mbr_array[0];
	$race = $mbr_array['mbr_race'];
	
	
	$conf_name = "config".$race;
	include("conf/".$race.".php");
	$conf = new $conf_name();
	$game = new game($_sql, $conf);

	
	if($conf->race_cfg)
	{
		$prim_res = $game->get_primary_res($mid, $conf->race_cfg);
		$_tpl->set("res_array",$prim_res);
		$_tpl->set('mbr_array',$mbr_array);
	}
	else
	{
		$_tpl->set('bad_mid',true);
	}
}
?>