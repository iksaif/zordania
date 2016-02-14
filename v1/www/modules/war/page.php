<?
//Verifications
if(_index_!="ok" or $_SESSION['user']['droits']{4}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else
{
	
include("lib/war.class.php");
$war = new war($_sql, $conf);
include("lib/unt.class.php");
$unt = new unt($_sql, $conf, $game);

$_tpl->set('module_tpl', 'modules/war/war.tpl');

$_tpl->set('ATQ_PTS_MAX_PER_DAY',ATQ_PTS_MAX_PER_DAY);
$_tpl->set('ATQ_NB_MAX_PER_DAY',ATQ_NB_MAX_PER_DAY);
$_tpl->set('ATQ_PTS_MIN',ATQ_PTS_MIN);

if($_GET['act'] == 'atq')
{
	$_tpl->set('war_act','atq');
	if(!$_GET['mid'] OR $_GET['mid'] == $_SESSION['user']['mid'])
	{
		$_tpl->set('war_sub','war_no_mid');
		if(ATQ_PTS_MIN > $_SESSION['user']['points'])
		{
			$_tpl->set('pas_assez_de_pts',ATQ_PTS_MIN);
		}
		
	}
	else
	{
		$_tpl->set('atq_mid',(int) $_GET['mid']);
		
		$can_atq = $war->can_atq($_SESSION['user']['mid'],$_SESSION['user']['points'],$_GET['mid']);
		if($can_atq > 0)
		{
			$_tpl->set('war_sub', 'war_cant_atq');
			$_tpl->set('war_can_atq',$can_atq);
		}
		elseif(!$_POST['lid'])
		{
			$_tpl->set('war_sub','choix_leg');

			$leg_array = $war->list_leg($_SESSION['user']['mid']);
			$unt_array = $unt->get_infos($_SESSION['user']['mid'], 0, true, true);
			
		
			$leg_total['leg_def'] += 0;
			$leg_total['leg_atq'] += 0;
			$leg_total['leg_atq_btc'] += 0;
					
			if(is_array($unt_array))
			{
			foreach($unt_array as $leg_lid => $leg_value)
			{
				$bonus_xp = 0; $bonus_atq = 0; $bonus_def = 0; //faut tout remetre a 0 :)
				uasort($leg_value,array("war","tri_unt"));
				$unt_array[$leg_lid] = $leg_value;
				
				foreach($leg_value as $unt_type => $unt_value)
				{
					if($value['leg_etat'] == 0)
					{
						if($conf->unt[$unt_type]['type'] != TYPE_UNT_CIVIL AND $unt_value['unt_lid'] != 1)
						{
						$unt_nb = $unt_value['unt_nb'];
	
						$leg_array[$leg_lid]['leg_def'] += $conf->unt[$unt_type]['defense']*$unt_nb;
						$leg_array[$leg_lid]['leg_atq'] += $conf->unt[$unt_type]['attaque']*$unt_nb;
						$leg_array[$leg_lid]['leg_atq_btc'] += $conf->unt[$unt_type]['attaquebat']*$unt_nb;
			
						$bonus_def  += $conf->unt[$unt_type]['bonus']['def']*$unt_nb;
						$bonus_atq  += $conf->unt[$unt_type]['bonus']['atq']*$unt_nb;
			
						$leg_total['leg_def'] += $conf->unt[$unt_type]['defense']*$unt_nb;
						$leg_total['leg_atq'] += $conf->unt[$unt_type]['attaque']*$unt_nb;
						$leg_total['leg_atq_btc'] += $conf->unt[$unt_type]['attaquebat']*$unt_nb;
				
						$calc_bonus = true;
						}
					}
					else
					{
						unset($leg_array[$leg_lid]);
					}
				
				}

				if($calc_bonus)
				{
					$bonus_xp = floor($unt_value['leg_xp'] / 100);
		
					//$bonus_xp = ($bonus_xp < GAME_MAX_UNT_BONUS) ? $bonus_xp :  GAME_MAX_UNT_BONUS;
					$bonus_def = ($bonus_def < GAME_MAX_UNT_BONUS) ? $bonus_def :  GAME_MAX_UNT_BONUS;
					$bonus_atq = ($bonus_atq < GAME_MAX_UNT_BONUS) ? $bonus_atq :  GAME_MAX_UNT_BONUS;
			
					$leg_array[$leg_lid]['leg_bonus']['bonus_xp'] = $bonus_xp;
					$leg_array[$leg_lid]['leg_bonus']['bonus_atq']= $bonus_atq;
					$leg_array[$leg_lid]['leg_bonus']['bonus_def']= $bonus_def;
						$calc_bonus = false;
				}
		
			}
			}
	
			$leg_village = $leg_array[0];
			unset($leg_array[0]);
			unset($leg_array[1]);
			
			//Bâtiments
			$bonus_def = 0;
			$btc = $game->get_infos_btc($_SESSION['user']['mid'], 0, true,false);
			if(is_array($btc))
			{
			foreach($btc as $btc_value)
			{
				$defense += $conf->btc[$btc_value['btc_type']]['defense'];
				$bonus_def += $conf->btc[$btc_value['btc_type']]['bonusdef'];
			}
			}
			$nb_btc = count($btc);
			$_tpl->set('btc_def',$defense);
			$_tpl->set('btc_bonus_def',$bonus_def);
			$_tpl->set('leg_array', $leg_array);
			$_tpl->set('unt_array', $unt_array);
			$_tpl->set('leg_total', $leg_total);
			$_tpl->set('leg_village',$leg_village);
			$_tpl->set('unt_conf', $conf->unt);
			$_tpl->set('GAME_MAX_UNT_BONUS',GAME_MAX_UNT_BONUS);

		}
		else
		{
			$atq = $war->atq($_SESSION['user']['mid'], $_POST['lid'], $_GET['mid'], $_SESSION['user']['mapcid']);
			$_tpl->set('war_sub', 'war_atq');
			$_tpl->set('war_ok',$atq);
		}
	}
}elseif($_GET['act'] == "histo")
{
	$_tpl->set('war_act','histo');
	//liste des atq
	$war_page=(int) $_GET['war_page'];
	$_tpl->set('war_page',(int) $_GET['war_page']);
	$war_nb = $war->nb_atq($_SESSION['user']['mid'],true);
	$limite_page = LIMIT_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set("atq_nb",$war_nb);
	$nombre_page = $war_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	if(isset($war_page) || $war_page != '0' )
	{	 
		$limite_mysql = $limite_page * $war_page;
	}else{
		$limite_mysql = '0';
	}
	$atq_array = $war->get_infos($_SESSION['user']['mid'], true, $limite_mysql,$limite_page);

	$_tpl->set('atq_array',$atq_array);
	$_tpl->set('user_mid',$_SESSION['user']['mid']);
}elseif($_GET['act'] == "enc")
{
	$_tpl->set('war_act','enc');
	//liste des atq
	$war_page=(int) $_GET['war_page'];
	$_tpl->set('war_page',(int) $_GET['war_page']);
	$war_nb = $war->nb_atq($_SESSION['user']['mid'],false);
	$limite_page = LIMIT_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set("atq_nb",$war_nb);
	$nombre_page = $war_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	if(isset($war_page) || $war_page != '0' )
	{	 
		$limite_mysql = $limite_page * $war_page;
	}else{
		$limite_mysql = '0';
	}
	$atq_array = $war->get_infos($_SESSION['user']['mid'], false, $limite_mysql,$limite_page);

	$_tpl->set('atq_array',$atq_array);
	$_tpl->set('user_mid',$_SESSION['user']['mid']);
}elseif($_GET['act'] == "cancel")
{
	$_tpl->set('war_act','cancel');
	if(!$_GET['aid'])
	{
		$_tpl->set('war_cancel','no_aid');
	}
	elseif($war->cancel($_SESSION['user']['mid'],$_GET['aid']))
	{
		$_tpl->set('war_cancel','ok');
	}
	else
	{
		$_tpl->set('war_cancel','error');
	}	
}	 
elseif($_GET['act'] == "make_attack")
{
	$_tpl->set('war_act','make_attack');
	
	if(!$_GET['aid'])
	{
		$_tpl->set('no_atq_aid',true);
	}
	else
	{
		$atq_array = $war->get_infos($_SESSION['user']['mid'], false, $_GET['aid']);
		if(count($atq_array) == 0 OR $atq_array[0]['atq_mid'] != $_SESSION['user']['mid'] OR $atq_array[0]['atq_dst'] != 0 OR $_SESSION['user']['atqnb'] >= ATQ_NB_MAX_PER_DAY)
		{
			$_tpl->set('no_atq_aid',true);
		}
		elseif($atq_array[0]['mbr_etat'] == 3 OR !$atq_array[0]['mbr_race'])
		{
			$war->cancel($_SESSION['user']['mid'], $_GET['aid']);
			$_tpl->set('atq_canceled',true);
			$_tpl->set('atq_mbr_inac',true);
		}
		elseif($war->can_atq($atq_array[0]['atq_mid'], $_SESSION['user']['points'], $atq_array[0]['atq_mid2']))
		{
			$war->cancel($_SESSION['user']['mid'], $_GET['aid']);
			$_tpl->set('atq_canceled',true);
		} else
		{
			$_tpl->set('atq_aid',$_GET['aid']);
			
			$atq_array = $atq_array[0];
			$mid1 = $_SESSION['user']['mid'];
			$mid2 = $atq_array['atq_mid2'];
			
			$unt_array_mid1 = $unt->get_infos($mid1, 0, true, true);
			
			if($_SESSION['user']['race'] != $atq_array['mbr_race'])
			{
				include('conf/'.$atq_array['mbr_race'].'.php');
				$conf_name = 'config'.$atq_array['mbr_race'];
				$conf_mid2 = new $conf_name();
				$game_mid2= new game($_sql, $conf_mid2);
				$unt_mid2 = new unt($_sql, $conf_mid2, $game_mid2);
			}
			else
			{
				$conf_mid2 = $conf;
				$game_mid2 = $game;
				$unt_mid2 = $unt;
			}
			echo "toto";
			
			
			$unt_array_mid2 = $unt_mid2->get_infos($mid2, 0, true, true);
			unset($unt_array_mid2[1]);
			$res_array_mid2	= $game_mid2->get_infos_res($mid2, 0, true);
			$btc_array_mid2 = $game_mid2->get_infos_btc($mid2, 0, true, false, 0);
			
			$mbr2_array	= $mbr->get_infos($mid2);
			
			$leg_lid = $atq_array['atq_lid'];
			$unt_array_mid1 = $unt_array_mid1[$leg_lid];


			
			if($_GET['sub'] == "esp")
			{
				$speed = $atq_array['atq_speed'];
				foreach($unt_array_mid1 as $unt_value)
					$unt_nb += $unt_value['unt_nb'];
				
				$tx	= ($speed * $speed) / ($unt_nb * 2);

				$esp_ok= ($tx - rand(0,5) > 5);
				if($esp_ok) $esp_ok = (rand(0,3) == 2);
				$_tpl->set('atq_esp',true);
				$_tpl->set('atq_esp_ok',$esp_ok);
			}
			
			
			if($esp_ok)
			{
				$leg_seen = $unt_nb; $res_seen = $unt_nb; $btc_seen = $unt_nb;
				$bilan_esp = array('unt_array' => array(),'res_array' => array(),'btc_array' => array());
				foreach($unt_array_mid2 as $leg_lid => $leg_value)
				{
					$unt_value = current($leg_value);
					if(rand(1,2) == 1 AND $leg_seen > 0 AND !$unt_value['leg_etat']){ $bilan_esp['unt_array'][$leg_lid] = $leg_value; $leg_seen--; }
				}
				foreach($res_array_mid2 as $res_type => $res_value)
				{
					if(rand(1,2) == 1 AND $res_seen > 0){ $bilan_esp['res_array'][$res_type] = $res_value; $res_seen--; }
				}
				foreach($btc_array_mid2 as $btc_bid => $btc_value)
				{
					if(rand(1,2) == 1 AND $btc_seen > 0){ $bilan_esp['btc_array'][$btc_bid] = $btc_value; $btc_seen--; }
				}
				
				//print_r($bilan_esp);
				$histo->add($mid2, $_SESSION['user']['mid'], 44,array(0,0,0,0), true);
				$_tpl->set('atq_array',array('mbr_race' => $mbr2_array[0]['mbr_race']));
				$_tpl->set('bilan_esp',$bilan_esp);
			}
			else
			{
				$bilan_war = $war->make_atq($mid1, $mid2, $atq_array, $unt_array_mid1, $unt_array_mid2, $btc_array_mid2, $res_array_mid2, $conf_mid2, true);
				$histo->add($mid2, $_SESSION['user']['mid'], 43,array(0,0,0,0), true);
				$unt->update_pop($mid1);
				$unt->update_pop($mid2);
				$_tpl->set('bilan_war',$bilan_war);
				$_tpl->set('atq_array',$atq_array);
				
				uasort($unt_array_mid1,array("war","tri_unt"));
				$_tpl->set('unt_array_mid1',$unt_array_mid1);
				$_tpl->set('unt_array_mid2',$unt_array_mid2);
				$_tpl->set('conf_mid2_btc',$conf_mid2->btc);
				
			}
		}
	}
}	
	
}
?>