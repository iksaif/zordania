 <?

if(INDEX_BTC != true){ exit; }

//de la class src
if(!is_object($src)) {
	include("lib/src.class.php");
	$src = new src($_sql, $conf, $game);
}
 
if(!is_object($res)) {
	include("lib/res.class.php");
	$res = new ressources($_sql, $conf, $game);
}

 if($_sub == "cancel_src")
{
	$_tpl->set("btc_act","cancel_src");
	
	if(!$_GET['sid'])
	{
		$_tpl->set("btc_no_sid",true);
	}else{
		if($src->cancel($_SESSION['user']['mid'], $_GET['sid']))
		{
			$_tpl->set("btc_ok",true);
		}else{
			$_tpl->set("btc_error",true);
		}	
	}
	
}
//Formulaire src + Liste src
elseif($_sub == "src")
{
	$src_array = $src->get_infos($_SESSION['user']['mid'],0,false);
	$_tpl->set("src_array",$src_array);
	$_tpl->set("src_infos",$conf->src);
	
	$_tpl->set("btc_act","src");
	
	$src_dispo = $src->list_src($_SESSION['user']['mid'],0,false);
	foreach($src_dispo as $src_type => $src_value) {
		if(is_array($conf->src[$src_type]['prix'])) {
			foreach($conf->src[$src_type]['prix'] as $res_type => $res_nb) {
				$res_utils[$res_type] = $res_nb;
			}
		}
	
	}
	$res_array = $res->get_infos($_SESSION['user']['mid']);
	foreach($res_array as $res_type => $res_nb) {
		if(!isset($res_utils[$res_type])) {
			unset($res_array[$res_type]);
		} 
	}
	
	$_tpl->set("res_utils",$res_array);
	$_tpl->set("res_dispo",$res_tmp);
	
	$_tpl->set("src_dispo",$src_dispo);
	
	$src_nb = count($src_array);
	$_tpl->set("src_nb",$src_nb);
	
	$src_in_db = $src->get_infos($_SESSION['user']['mid'],0,true);
	$_tpl->set("src_in_db",$src_in_db);
}
//Nouvelle src
elseif($_sub == "add_src")
{
	$_tpl->set("btc_act","add_src");
		
	$src_array = $src->get_infos($_SESSION['user']['mid'],0,false);
	$src_nb = count($src_array);
	$_tpl->set("src_nb",$src_nb);
	
	if(!$_POST['type'])
	{
		$_tpl->set("btc_no_type",true);
	}elseif(!is_array($conf->src[$_POST['type']]))
	{
		$_tpl->set("btc_src_not_exist",true);
	}elseif($src_nb >= GAME_MAX_SRC)
	{
		$_tpl->set("btc_src_max",true);
	}elseif($src->can_build($_SESSION['user']['mid'], $_POST['type']) == 1)
	{	
		if($src->add($_SESSION['user']['mid'],$_POST['type']))
		{
			$_tpl->set("btc_ok",true);
		}else{
			$_tpl->set("btc_error",true);
		}
	}else{
		$_tpl->set("btc_not_enough_res",true);
	}
}
?>