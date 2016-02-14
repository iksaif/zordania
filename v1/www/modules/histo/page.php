<?
if(_index_!="ok"){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else
{
$_tpl->set('module_tpl','modules/histo/histo.tpl');

$act = isset($_GET['act']) ? $_GET['act'] : "";

if($act == "all")
{
	$limite1 = 0;
	$limite2 = 0;
}
else
{
	$limite1 = LIMIT_PAGE;
	$limite2 = 0;
}
$_tpl->set("histo_array",$histo->get_infos($_SESSION['user']['mid'],$limite1,$limite2));
$_tpl->set('histo_key',$histo->calc_key($_SESSION['user']['mid'],$_SESSION['user']['pseudo'],$_SESSION['user']['pass']));

}
?>