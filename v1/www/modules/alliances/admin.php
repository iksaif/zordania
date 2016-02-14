<?
if(_index_!="ok" or $_SESSION['user']['droits']{DROIT_ADM_MBR}!=1){ exit; }


include('lib/alliances.class.php');
$al  = new alliances($_sql);

$_tpl->set("module_tpl","modules/alliances/admin.tpl");

//Liste des alliances
if(!$_act)
{

	$al_page=(int) $_GET['al_page'];
	$_tpl->set('al_page',$al_page);
	$al_nb = $al->nb();
	$limite_page = LIMIT_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set("al_nb",$al_nb);
	$nombre_page = $al_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	
	if(isset($al_page) || $al_page != '0' )
	{	 
		$limite_mysql = $limite_page * $al_page;
	}else{
		$limite_mysql = '0';
	}
	$al_array = $al->get_infos($limite_mysql,$limite_page);

	$_tpl->set('al_array',$al_array);
	$_tpl->set('al_max_mbr_nb',ALL_MAX);
}
//Infos sur une alliance
elseif($_act=='search')
{
	$_tpl->set('module_tpl','modules/alliances/liste.tpl');
	$_tpl->set('al_act','search');
	
	$al_array = $al->search($_POST);

	$_tpl->set('al_array',$al_array);
	$_tpl->set('al_max_mbr_nb',ALL_MAX);	
}
elseif($_act == 'view')
{
	$_tpl->set('al_act','view');
	
	$al_array = $al->get_infos($_GET['al_aid']);
	$_tpl->set('al_array',$al_array[0]);
	$_tpl->set('al_max_mbr_nb',ALL_MAX);
	
	if(is_array($al_array[0]))
	{
		if($_sub == "add_res")
		{
			$al->add_res($_GET['al_aid'], $_SESSION['user']['mid'], $_GET['res_type'], $_POST['res_nb'], true);
		}
	}
	
	if(is_array($al_array[0]))
	{
		if(file_exists(ALL_LOGO_DIR.$_GET['al_aid'].'.png'))
		{
			$_tpl->set('al_logo',ALL_LOGO_URL.$_GET['al_aid'].'.png');
		}
	}
	
	$map = $mbr->get_infos($_SESSION['user']['mid'], false, false, true, false, false);
	$map = $map[0];
	
	$al_mbr = $mbr->get_infos(0, ALL_MAX, array('alaid' => $_GET['al_aid']), $map, false, $order);
	$al_mbr = $mbr->can_atq_lite($al_mbr, $_SESSION['user']['points'],$_SESSION['user']['mid'],$_SESSION['user']['groupe'], $_SESSION['user']['alaid']);
	
	$_tpl->set('al_mbr',$al_mbr);
	
	$res_array = $al->get_infos_res($_GET['al_aid']);
	$_tpl->set('res_array',$res_array);
	
	if(!$_GET['al_page'])
	{
		$res_log = $al->get_log_res($_GET['al_aid'],LIMIT_PAGE);
	}
	else
	{
	$al_page=(int) $_GET['al_page'];
	$_tpl->set('al_page',$al_page);
	$limite_page = LIMIT_PAGE;
	
	if(isset($al_page) || $al_page != '0' )
	{	 
		$limite_mysql = $limite_page * $al_page;
	}else{
		$limite_mysql = '0';
	}
	
		$res_log = $al->get_log_res($_GET['al_aid'],LIMIT_PAGE,$limite_mysql);
	}
	$_tpl->set('log_array',$res_log);
}


?>