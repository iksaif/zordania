<?
if(_index_!="ok" or ($_SESSION['user']['droits']{7}!=1)){ exit; }

include('lib/tplmore.class.php');
$tplm  = new TemplatesGest();
$tplm->set_dir(SITE_DIR.'templates');

$_tpl->set('module_tpl','modules/tpl/tpl.tpl');

$act = isset($_GET['act'])  ? $_GET['act'] : "";

if(!$act)
{
	$_tpl->set('tpl_act','liste');
	
	$dir = isset($_GET['dir'])  ? $_GET['dir'] : "";
	
	$last_dir = explode('/',$dir);
	$last_dir = str_replace($last_dir[count($last_dir)-2]."/","",$dir);
	$_tpl->set('tpl_last_dir',$last_dir);
	
	$_tpl->set('tpl_current_dir',$dir);
	$_tpl->set('tpl_array',$tplm->list_dir("/".$dir));
}
elseif($act == "edit")
{
	$_tpl->set('tpl_act','edit');
	
	$tpl = isset($_GET['tpl'])  ? $_GET['tpl'] : "";
	$_tpl->set('tpl_array',$tplm->get_infos("/".$tpl));
}
elseif($act =="save")
{
	$_tpl->set('tpl_act','save');
	
	$tpl_contenu = isset($_POST['tpl_contenu'])  ? $_POST['tpl_contenu'] : "";
	$tpl = isset($_GET['tpl'])  ? $_GET['tpl'] : "";
	
	if($tpl_contenu AND $tpl)
	{
		$_tpl->set('tpl_save_ok',$tplm->save_tpl($tpl,$tpl_contenu));
	}
	else
	{
		$_tpl->set('tpl_save_ok',false);
	}
}
?>