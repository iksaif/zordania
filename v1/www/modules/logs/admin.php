<?
if(_index_!="ok" or ($_SESSION['user']['droits']{7}!=1)){ exit; }

include('lib/log.class.php');
$log = new log();

$log->set_dir(SITE_DIR."logs/");


$_tpl->set('module_tpl','modules/logs/logs.tpl');

$act = isset($_GET['act'])  ? $_GET['act'] : "";

if($act == 'hack')
{
	$_tpl->set('log_act','hack');
	$_tpl->set('log_array',$_div->get_log());
}
elseif($act == 'crons_result')
{
	$_tpl->set('log_act','crons_result');
	$log->set_dir(SITE_DIR);
	$_tpl->set('log_array',$log->list_dir('logs/crons/bench/'));
}
elseif($act == 'crons_temps')
{
	$_tpl->set('log_act','crons_temps');
	$log->set_dir(SITE_DIR);
	$_tpl->set('log_array',$log->list_dir('logs/crons/out/'));
}
elseif($act == 'view')
{
	$log_file = isset($_GET['log_file'])  ? $_GET['log_file'] : "";
	
	$_tpl->set('log_act','view');
	
	if(!$file)
	{
		$_tpl->set('log_contenu',false);
	}
	else
	{
		$_tpl->set('log_contenu',$log->get_file($log_file));
	}
}
elseif($act == 'bonus')
{
	include('lib/bonus.class.php');
	$bon = new bonus($_sql);
	$_tpl->set('log_act','bonus');
	
	$_tpl->set('bon_date',(isset($_GET['bon_date']) ? urldecode($_GET['bon_date']) : false));
	
	$_tpl->set('bon_array',$bon->get_log());
}