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

$_tpl->set('module_tpl', 'modules/leg/leg.tpl');


if($_GET['act'] == 'edit_leg')
{
	$_tpl->set('leg_act', 'edit_leg');
	
	if(!isset($_POST['from_leg']) OR !isset($_POST['to_leg']) OR !$_POST['nb_unt'] OR !$_POST['type_unt'] OR (!$_POST['leg_name'] AND $_POST['to_leg'] == "-1"))
	{
		$_tpl->set('leg_sub', 'not_all_input');
	}
	else
	{
		if($unt->edit_leg($_SESSION['user']['mid'], $_POST['type_unt'], abs($_POST['nb_unt']), $_POST['from_leg'], $_POST['to_leg'], $_POST['leg_name'], $_SESSION['user']['mapcid']))
		{
			$_tpl->set('leg_edit', true);
		}	
	}
	
}
elseif($_GET['act'] == 'del_leg')
{
	$_tpl->set('leg_act', 'del_leg');
	if(!$_GET['lid'])
	{
		$_tpl->set('leg_sub', 'no_lid');
	}
	elseif($unt->del_leg($_SESSION['user']['mid'], $_GET['lid']))
	{
		$_tpl->set('leg_ok', true);
	}

}
//Gestion Légion
if(!$_GET['act'] OR $_GET['act'] == 'edit_leg' OR $_GET['act'] == 'del_leg')
{
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

	$_tpl->set('leg_array', $leg_array);
	$_tpl->set('unt_array', $unt_array);
	$_tpl->set('leg_total', $leg_total);
	$_tpl->set('leg_village',$leg_village);
	$_tpl->set('unt_conf', $conf->unt);
	$_tpl->set('GAME_MAX_UNT_BONUS',GAME_MAX_UNT_BONUS);
	
				
	//Bâtiments
	$btc = $game->get_infos_btc($_SESSION['user']['mid'], 0, true,false);
	$bonus_def = 0;
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
	$_tpl->set('GAME_MAX_BTC_BONUS',GAME_MAX_BTC_BONUS);
			
	//Pour avoir la distance
	$map = $mbr->get_infos($_SESSION['user']['mid'], false, false, true, false, false);
	$_tpl->set("mbr_map_x",$map[0]['map_x']);
	$_tpl->set("mbr_map_y",$map[0]['map_y']);
	
}

}
?>