<?
if(_index_!="ok" or $_SESSION['user']['droits']{4}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
$_tpl->set("need_to_be_loged",true); 
}
else
{
	$_tpl->set("module_tpl","modules/unt/unt.tpl");
	
	//de la class unt
	include("lib/unt.class.php");
	$unt = new unt($_sql, $conf, $game);
	
	$act = isset($_GET['act']) ? $_GET['act'] : "";
	
	if(!$act)
	{
		//on file les infos aux tpl
		$ar1 = $unt->list_unt($_SESSION['user']['mid']);
		$ar2 = $unt->get_infos($_SESSION['user']['mid'], 0, true);
		
		$_tpl->set("unt_dispo",$ar1);
		$_tpl->set("unt_infos",$ar2);
		$_tpl->set("unt_nb",count($ar1));
		
		if(isset($_GET['unt_type']))
		{
			if(is_array($conf->unt[$_GET['unt_type']]))
			{
				$_tpl->set('unt_type',(int) $_GET['unt_type']);
				foreach($conf->unt[$_GET['unt_type']]['inbat'] as $btc_type => $true)
				{
					$_tpl->set('btc_type',$btc_type);
					break;
				}
				
			}
		}
	}
	elseif($act == "pend")
	{
		$_tpl->set('unt_act','pend');
		
		$unt_type = (int) isset($_GET['unt_type']) ? $_GET['unt_type'] : 0;
		$unt_nb = abs((int) isset($_POST['unt_nb']) ? $_POST['unt_nb'] : 0);
		
		if(!$unt_type or !$unt_nb or !$conf->unt[$unt_type])
		{
			$_tpl->set('unt_sub','error');
		}
		else
		{
			$array = $unt->get_infos($_SESSION['user']['mid'], $unt_type, true, true);
			$infos = $array[0][$unt_type];
			
			if($unt_nb > $infos['unt_nb'] OR $unt_lid != 0)
			{
				$_tpl->set('unt_sub','paspossible');
			}
			else 
			{
				//$game->add_unt($_SESSION['user']['mid'],$unt_type,(-$unt_nb),0,true);
				$unt->add($_SESSION['user']['mid'],$unt_type,(-$unt_nb));
				$unt->update_pop($_SESSION['user']['mid']);
				$_tpl->set('unt_sub','ok');
			}

		}
	}
}
?>