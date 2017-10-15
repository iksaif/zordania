<?php
if(defined("_INDEX_") and can_d(DROIT_ADM_TRAV)){

//include('lib/tplmore.class.php'); AUTOLOAD

$tplm  = new TemplatesGest();
$tplm->set_dir(SITE_DIR.'templates');

$_tpl->set('module_tpl','modules/tpl/tpl.tpl');

$act = request('act', 'string', 'get');

if(!$act){
	$_tpl->set('tpl_act','liste');
	
	$dir = request('dir', 'string', 'get');
	if($dir){
		$last_dir = explode('/',$dir);
		$last_dir = str_replace($last_dir[count($last_dir)-2]."/","",$dir);
	}else
		$last_dir='';
	$_tpl->set('tpl_last_dir',$last_dir);
	
	$_tpl->set('tpl_current_dir',$dir);
	$_tpl->set('tpl_array',$tplm->list_dir("/".$dir));

}elseif($act == "edit"){
	$_tpl->set('tpl_act','edit');
	
	$tpl = request('tpl', 'string', 'get');
	$_tpl->set('tpl_array',$tplm->get_infos("/".$tpl));

}elseif($act =="save"){
	$_tpl->set('tpl_act','save');
	
	$tpl_contenu = request('tpl_contenu', 'string', 'post');
	$tpl = request('tpl', 'string', 'get');
	
	if($tpl_contenu AND $tpl)
		$_tpl->set('tpl_save_ok',$tplm->save_tpl($tpl,$tpl_contenu));
	else
		$_tpl->set('tpl_save_ok',false);

} /* elseif ($_act) */
} /* if (droits) */
?>
