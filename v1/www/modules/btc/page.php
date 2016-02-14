<?
//Verifications
if(_index_!="ok" or $_SESSION['user']['droits']{DROIT_PLAY}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else
{


//de la class btc
include("lib/btc.class.php");
$btc = new btc($_sql, $conf, $game);

if($_act == 'btc')
{
	$_tpl->set("module_tpl","modules/btc/btc.tpl");

	$trav = $game->get_infos_unt($_SESSION['user']['mid'], 1, true);
	$trav = $trav[1];
	
	$_tpl->set("btc_trav",(int) $trav[1]['unt_nb']);
	
	if(!$_sub)
	{	
		//on regarde si y'en a pas un en construction
		$btc_en_const = $btc->get_infos($_SESSION['user']['mid'], 0, false);
		if(!$btc_en_const)
		{
			$array=$btc->list_bat($_SESSION['user']['mid']);
			$_tpl->set("btc_dispo",$array);
			$_tpl->set("btc_num",1);
		}else{	
			foreach($btc_en_const as $btc_id => $btc_infos)
			{
				$btc_tours[$btc_id] = $conf->btc[$btc_id]['tours'];
			}
			$_tpl->set("btc_tours",$btc_tours);
			$_tpl->set("btc_en_const",$btc_en_const);
		}
		
	}
	elseif($_sub == 'btc')
	{
		$_tpl->set("btc_act","btc");
		if(!$_GET['type']) /* OR $_GET['type'] == 1) */
		{
			$_tpl->set("btc_no_type",true);
		}else{
		
			$peu_construire = $btc->can_build($_SESSION['user']['mid'], $_GET['type']);
			if($peu_construire ==0)
			{//deja un autre batiment en construction
				$_tpl->set("btc_peuconstruire", 0);
			}
			elseif($peu_construire ==1)
			{//ok
				$_tpl->set("btc_peuconstruire", 1);
				if($btc->add($_SESSION['user']['mid'], $_GET['type']))
				{
					//ok
					$_tpl->set("btc_ok", true);
				}
				else
				{
					//pas ok (??)
					$_tpl->set("btc_ok", false);
				}
			}
			elseif($peu_construire ==2)
			{//manque des ress
				$_tpl->set("btc_peuconstruire", 2);
			}
			elseif($peu_construire ==3)
			{//impossible
				$_tpl->set("btc_peuconstruire", 3);
			}
		}
	}		
	elseif($_sub == 'cancel')
	{
		$_tpl->set("btc_act","cancel");
		if(!$_GET['bid'])
		{
			$_tpl->set("btc_no_bid", true);
		}
		elseif($btc->cancel($_SESSION['user']['mid'], $_GET['bid']))
		{
			$_tpl->set("btc_ok", true);
		}
		else
		{
			$_tpl->set("btc_not_exist", true);	
		}	
	}		
}
elseif($_act == 'use') //On "utilise" un batiment
{
	//tpl use
	$_tpl->set("module_tpl","modules/btc/use.tpl");
	
	//On liste les batiments d'un type
	if($_sub == 'list')
	{
		$_tpl->set("btc_act","list2");
		//if(!$_GET['btc_type'] OR !$conf->btc[$_GET['btc_type']])
		if(!$_GET['btc_type'] OR !$conf->btc[$_GET['btc_type']])
		{
			$_tpl->set("btc_array",$game->get_infos_btc($_SESSION['user']['mid'], 0, true, false,0));
			$_tpl->set("btc_conf",$conf->btc);
		}else{
			$_tpl->set("btc_array",$btc->get_infos($_SESSION['user']['mid'],$_GET['btc_type'],true,0));
			$_tpl->set("btc_vie",$conf->btc[$_GET['btc_type']]['vie']);
			$_tpl->set("btc_id",(int) $_GET['btc_type']);
		}
	}
	elseif($_sub == 'vue')
	{
		$_tpl->set("btc_act","vue");

		$_tpl->set("btc_array",$game->get_infos_btc($_SESSION['user']['mid'], 0, true, false,0));
		$_tpl->set("btc_conf",$conf->btc);
	}
	//Détruit un btc
	elseif($_sub == 'det')
	{
		$_tpl->set('btc_act','det');
		$_tpl->set('btc_bid',(int) $_GET['btc_bid']);
		
		if(!$_GET['btc_bid'])
		{
			$_tpl->set('btc_no_bid',true);
		}
		elseif($_GET['ok'])
		{
			$_tpl->set('btc_ok',true);
			if($btc->cancel($_SESSION['user']['mid'], $_GET['btc_bid']))
			{
				$_tpl->set('btc_det_ok',true);
			}else{
				$_tpl->set('btc_det_ok',true);
			}
		}else{
			$_tpl->set('btc_ok',false);
		}
		
	}
	elseif($_sub == 'des' OR $_sub == 'act' OR $_sub == 'rep')
	{
		$_tpl->set('btc_act','mod_etat');
		$_tpl->set('btc_bid',(int) $_GET['btc_bid']);
		
		if(!$_GET['btc_bid'])
		{
			$_tpl->set('btc_no_bid',true);
		}
		else
		{
			switch($_sub) {
			case 'des':
				$res = $btc->edit_status($_SESSION['user']['mid'], $_GET['btc_bid'], '2');
				break;
			case 'act':
				$res = $btc->edit_status($_SESSION['user']['mid'], $_GET['btc_bid'], '0');
				break;
			case 'rep':
				$res = $btc->edit_status($_SESSION['user']['mid'], $_GET['btc_bid'], '1');
				break;
			}
			$_tpl->set('btc_mod_etat',$res);
		}
	}
	//Liste tout
	elseif(!is_array($conf->btc[$_GET['btc_type']]) OR !$_GET['btc_type'])
	{
		$_tpl->set("btc_act","list");
		$_tpl->set("btc_array",$btc->get_infos($_SESSION['user']['mid'],0,true,0));	
	//Gérer 
	}
	else
	{
		$btc_array =  $btc->get_infos($_SESSION['user']['mid'], $_GET['btc_type'], true,0);
		$btc_nb_total = count($btc_array);
		$btc_nb = 0;
		foreach($btc_array as $value) {
			if($value['etat'] == 0) {
				$btc_nb++;
			}
		}
		if($btc_nb == 0)
		{
			$_tpl->set("btc_act","no_btc");
			$_tpl->set("btc_id",(int) $_GET['btc_type']);
		}
		else
		{
			$btc_type = $_GET['btc_type'];
			define("INDEX_BTC",true);
			$_tpl->set("btc_id",$btc_type);
			$_tpl->set("btc_conf",$conf->btc[$btc_type]);
			$_tpl->set("btc_nb",$btc_nb);
			$_tpl->set("btc_nb_total",$btc_nb_total);
			$_tpl->set("btc_tpl","modules/btc/".$_SESSION['user']['race']."/".$btc_type.".tpl");
			
			/* Principal */
			include($_SESSION['user']['race']."/".$btc_type.".php");
			
			/* Autres trucs, en fonction de la conf */
			if($conf->btc[$btc_type]['btcopt']['unt']) include("modules/btc/inc/unt.php");
			if($conf->btc[$btc_type]['btcopt']['src']) include("modules/btc/inc/src.php");
			if($conf->btc[$btc_type]['btcopt']['res']) include("modules/btc/inc/res.php");
			if($conf->btc[$btc_type]['btcopt']['com']) include("modules/btc/inc/com.php");
			include("modules/btc/inc/info.php");
		}
	}

}

}
?>