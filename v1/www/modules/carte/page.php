<?
if(_index_!="ok" or $_SESSION['user']['droits']{1}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
$_tpl->set("need_to_be_loged",true); 
}
else
{
$_tpl->set("module_tpl","modules/map/map.tpl");
include('lib/carte.class.php');
$map = new carte($_sql);

$act = isset($_GET['act']) ? $_GET['act'] : (isset($_COOKIE['map_type']) ? divers::read_cookie($_COOKIE['map_type']) : "lite");
$_tpl->set("MAP_LIMITE_1",MAP_LIMITE_1);
$_tpl->set("MAP_LIMITE_2",MAP_LIMITE_2);

if($act == "flash")
{
	divers::set_cookie('map_type','flash');
	
	$_tpl->set('map_type','flash');
}
elseif($act == "view")
{
	$_tpl->set('map_type','view');
	$_tpl->set('map_h',MAP_H);
	
	$map_cid = (int) isset($_GET['map_cid']) ? $_GET['map_cid'] : 0;

	$map_array = $map->get_infos($_SESSION['user']['mid'],$map_cid);
	
	$_tpl->set('map_array',$map_array);
}
else
{
	divers::set_cookie('map_type','lite');
	
	$_tpl->set('map_type','lite');
	
	$zoom  = isset($_GET['zoom']) ? 1 : 1;
	$map_x = (int) isset($_GET['map_x']) ? $_GET['map_x'] : -1;
	$map_y = (int) isset($_GET['map_y']) ? $_GET['map_y'] : -1;
	
	$map_pseudo =  isset($_GET['map_pseudo']) ? $_GET['map_pseudo'] : 0;
	
	if($map_pseudo)
	{
		$mbr_array = $mbr->get_infos(0, 1, array('pseudo' => $map_pseudo) ,true);
		$map_x = $mbr_array[0]['map_x'] - 5;
		$map_y = $mbr_array[0]['map_y'] - 5;
	}
	
	if($map_x != -1 AND $map_y != -1)
	{
		if($map_x < 0)
		{
			$map_x = 0;
		}
		if(($map_x+10*$zoom) > MAP_W)
		{
			$map_x = MAP_W - 10*$zoom;
		}
		if($map_y < 0)
		{
			$map_y = 0;
		}
		if(($map_y+10*$zoom) > MAP_H)
		{
			$map_y = MAP_H - 10*$zoom;
		}
	}
	
	if(($map_x < 0) OR (($map_x+10*$zoom) > MAP_W) OR ($map_y < 0) OR (($map_y+10*$zoom) > MAP_H))
	{
		$map_infos = $mbr->get_infos($_SESSION['user']['mid'], false, false, true, false, false);
		$map_x = $map_infos[0]['map_x'] - (5 * $zoom);
		$map_y = $map_infos[0]['map_y'] - (5 * $zoom);
		
		if($map_x < 0) $map_x = 0;
		if(($map_x+10*$zoom) > MAP_W) $map_x = MAP_W - (10 * $zoom);
		if($map_y < 0) $map_y = 0;
		if(($map_y+10*$zoom) > MAP_W) $map_y = MAP_H - (10 * $zoom);	
	}
	
	$max_x2 = $map_x + (10 * $zoom);
	$max_y2 = $map_y + (10 * $zoom);

	$map_array = $map->get_map($mid,array('x1' => $map_x, 'y1' => $map_y, 'x2' => $max_x2, 'y2' => $max_y2));
	
	$_tpl->set('map_x',$map_x);
	$_tpl->set('map_y',$map_y);
	$_tpl->set('map_h',MAP_H);
	$_tpl->set('map_zoom',$zoom);
	$_tpl->set('map_array',$map_array);
}
}
?>