<?


if(INDEX_BTC != true){ exit; }

//de la class unt
if(!is_object($res)) {
	include("lib/res.class.php");
	$res= new ressources($_sql, $conf, $game);
}

$nb = isset($_POST['nb']) ? abs($_POST['nb']) : 0;
$rid = isset($_GET['rid']) ? abs($_GET['rid']) : 0;

//Annuler res
if($_sub == "cancel_res")
{
	$_tpl->set("btc_act","cancel_res");
	$_tpl->set("btc_rid",$rid);
	if(!$rid)
	{
		$_tpl->set("btc_no_rid",true);
	}
	elseif(!$nb)
	{
		$_tpl->set("btc_no_nb",true);
	}else{
		if($res->cancel($_SESSION['user']['mid'], $rid, $nb))
		{
			$_tpl->set("btc_ok",true);
		}else{
			$_tpl->set("btc_error",true);
		}	
	}
}
//Formulaire res + Liste res
elseif($_sub == "res")
{
	$_tpl->set("btc_act","res");
	
	$res_array = $res->get_infos($_SESSION['user']['mid'],0,false);
	
	//on vire les merdes :p
	
	if(is_array($res_array))
	{
	foreach($res_array as $id => $value)
	{
		if($conf->res[$id]['needbat'] != $btc_type)
		{
			unset($res_array[$id]);
		}
	}
	}
	$res_array = count($res_array) ? $res_array : 0;
	$_tpl->set("res_array",$res_array);
	
	$res_tmp = $res->list_res($_SESSION['user']['mid']);
	//on vire les merdes :p
	if(is_array($res_tmp))
	{
	foreach($res_tmp as $id => $value)
	{
		if($conf->res[$id]['needbat'] != $btc_type)
		{
			unset($res_tmp[$id]);
		} else if(is_array($conf->res[$id]['needres'])) {
			foreach($conf->res[$id]['needres'] as $res_type => $res_nb) {
				$res_utils[$res_type] = $res_nb;
			}
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
	
	$res_nb = count($res_tmp);
	$_tpl->set("res_nb",$res_nb);
	
	$res_in_db = $res->get_infos($_SESSION['user']['mid'],0,true);
	$_tpl->set("res_in_db",$res_in_db);
	
	$_tpl->set("res_conf",$conf->res);
	
}
//Nouvelle res
elseif($_sub == "add_res")
{
	$res_array = $res->get_infos($_SESSION['user']['mid'],0,false);
	if(is_array($res_array))
	{
		foreach($res_array as $key => $value)
		{
			$res_nb += $value['res_nb'];
		}
	}
	else
	{
		$res_nb = 0;
	}
	$_tpl->set("res_nb",$res_nb);
	$_tpl->set("btc_act","add_res");
	
	$res_cfg = $conf->res[$_POST['type']];

	if(!$_POST['type'] OR $res_cfg['onlycron'] OR $res_cfg['nobat'])
	{
		$_tpl->set("btc_no_type",true);
	}elseif(!$nb)
	{
		$_tpl->set("btc_no_nb",true);
	}elseif(!is_array($conf->res[$_POST['type']]))
	{
		$_tpl->set("btc_res_not_exist",true);
	}elseif(($res_nb + $nb) > GAME_MAX_RES)
	{
		$_tpl->set("btc_res_max",GAME_MAX_RES);
	}elseif($res->can_build($_SESSION['user']['mid'],$_POST['type'],$nb) != 1)
	{
		$_tpl->set("btc_not_enough_res",true);	
	}
	else
	{
		if($res->add($_SESSION['user']['mid'],$_POST['type'],$nb,$_GET['btc_type']))
		{
			$_tpl->set("btc_ok",true);
		}else{
			$_tpl->set("btc_error",true);
		}
	}
} 
?>