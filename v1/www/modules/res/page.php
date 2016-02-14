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

$_tpl->set("module_tpl","modules/res/res.tpl");

if(!$_GET['act'])
{
//Stats sur les ressources
	$res_array = $res->list_res($_SESSION['user']['mid'],true);
	$_tpl->set("res_dispo",$res_array);
	$_tpl->set("res_nb",count($res_array));
}

}	
?>
