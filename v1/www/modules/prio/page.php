<?
if(_index_!="ok" or $_SESSION['user']['droits']{4}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
$_tpl->set("need_to_be_loged",true); 
}
else
{

include("lib/res.class.php");
$res = new ressources($_sql,$conf,$game);

include("lib/unt.class.php");
$unt = new unt($_sql, $conf, $game);

$_tpl->set("module_tpl","modules/prio/prio.tpl");
$_tpl->set("prio_act",$_GET['act']);
$_tpl->set("res_conf",$conf->res);

if($_GET['act']=="unt")
{
	if($_POST['unt_prio']) $unt->set_prio($_SESSION['user']['mid'],$_POST['unt_prio']);
	$ar1 = $unt->list_unt($_SESSION['user']['mid']);
	$ar2 = $unt->get_infos($_SESSION['user']['mid'], 0, true);

	$_tpl->set("unt_dispo",$ar1);
	$_tpl->set("unt_infos",$ar2);
	$_tpl->set("unt_nb",count($ar1));
}
elseif($_GET['act']=="res")
{
	if($_POST['res_prio']) $res->set_prio($_SESSION['user']['mid'],$_POST['res_prio']);
	$ar1 = $res->list_res($_SESSION['user']['mid'],true);
	$ar2 = $res->get_infos($_SESSION['user']['mid'], 0, true);

	$_tpl->set("res_dispo",$ar1);
	$_tpl->set("res_infos",$ar2);
	$_tpl->set("res_nb",count($ar2));	
}

}	
?>
