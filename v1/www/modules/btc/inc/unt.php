<?
if(INDEX_BTC != true){ exit; }

$_tpl->set("cant_form",true);

//de la class unt
if(!is_object($unt)) {
	include("lib/unt.class.php");
	$unt = new unt($_sql, $conf, $game);
}

if(!is_object($res)) {
	include("lib/res.class.php");
	$res = new ressources($_sql, $conf, $game);
}

$nb = isset($_POST['nb']) ? abs($_POST['nb']) : 0;

if($_sub == "cancel_unt")
{
	$_tpl->set("btc_act","cancel_unt");
	$_tpl->set("btc_uid",(int) $_GET['uid']);
	if(!$_GET['uid'])
	{
		$_tpl->set("btc_no_uid",true);
	}
	elseif(!$_POST['nb'])
	{
		$_tpl->set("btc_no_nb",true);
	}else{
		if($unt->cancel($_SESSION['user']['mid'], $_GET['uid'], $_POST['nb']))
		{
			$_tpl->set("btc_ok",true);
		}else{
			$_tpl->set("btc_error",true);
		}	
	}
}
//Formulaire unt + Liste unt
elseif($_sub == "unt")
{
	$_tpl->set("btc_act","unt");
	
	//on recup la liste
	$unt_array = $unt->get_infos($_SESSION['user']['mid'],0,false);
	$unt_array = $unt_array[0];
	
	//on vire les merdes :p
	if(is_array($unt_array))
	{
	foreach($unt_array as $id => $value)
	{
		if($conf->unt[$id]['inbat'][$btc_type] != true)
		{
			unset($unt_array[$id]);
		}
	}
	}
	

	
	$unt_array = count($unt_array) ? $unt_array : 0;
	$_tpl->set("unt_array",$unt_array);
	
	$unt_dispo = $unt->list_unt($_SESSION['user']['mid'],0,false);
	$unt_in_db = $unt->get_infos($_SESSION['user']['mid'],0,true);
	
	//on vire les merdes :p
	if(is_array($unt_dispo))
	{
	foreach($unt_dispo as $id => $value)
	{
		
		if($conf->unt[$id]['inbat'][$btc_type] != true)
		{
			unset($unt_dispo[$id]);
		} else
		{
			if(is_array($conf->unt[$id]['prix'])) {
				foreach($conf->unt[$id]['prix'] as $res_type => $res_nb) {
					$res_utils[$res_type] += $res_nb;
				}
			}
			if(is_array($conf->unt[$id]['needguy'])) {
				foreach($conf->unt[$id]['needguy'] as $unt_type => $unt_nb) {
					$unt_utils[$unt_type] = $unt_in_db[1][$unt_type]['unt_nb'];
				}
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
	
	$_tpl->set("res_array",$res_array);
	$_tpl->set("unt_utils",$unt_utils);
	$_tpl->set("unt_dispo",$unt_dispo);
	
	$unt_nb = count($unt_array);
	$_tpl->set("unt_nb",$unt_nb);

	$_tpl->set("unt_in_db",$unt_in_db);
	
	$_tpl->set("unt_conf",$conf->unt);
	
}
//Nouvelle unt
elseif($_sub == "add_unt")
{
	$unt_array = $unt->get_infos($_SESSION['user']['mid'],0,false);
	if(is_array($unt_array))
	{
	foreach($unt_array as $unt_leg_array)
	{
	foreach($unt_leg_array as $type => $value)
	{
		$unt_nb += $value['unt_nb'];
	}
	}
	}
	else
	{
		$unt_nb = 0;	
	}
	$_tpl->set("unt_nb",$unt_nb);
	
	$_tpl->set("btc_act","add_unt");
	if(!$_POST['type'])
	{
		$_tpl->set("btc_no_type",true);
	}elseif(!$_POST['nb'])
	{
		$_tpl->set("btc_no_nb",true);
	}elseif(!is_array($conf->unt[$_POST['type']]))
	{
		$_tpl->set("btc_unt_not_exist",true);
	}elseif(($unt_nb + abs($_POST['nb'])) > GAME_MAX_UNT)
	{
		$_tpl->set("btc_unt_max",true);
	}elseif($unt->can_build($_SESSION['user']['mid'],$_POST['type'],abs($_POST['nb'])) != 1)
	{
		$_tpl->set("btc_not_enough_res",true);
		$_tpl->set("max_unt_nb",GAME_MAX_UNT_TOTAL);	
	}
	else
	{
		if($unt->add($_SESSION['user']['mid'],$_POST['type'],abs($_POST['nb']),-$_GET['btc_type']))
		{
			$_tpl->set("btc_ok",true);
		}else{
			$_tpl->set("btc_error",true);
		}
	}
}
?>