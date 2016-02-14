<?
//Verifications
if(_index_!="ok" or $_SESSION['user']['droits']{4}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else
{
include('lib/res.class.php');
$res = new ressources($_sql, $conf, $game);

include('lib/com.class.php');
$com = new mch($_sql, $res);

include(SITE_DIR.'lib/war.class.php');
$war = new war($_sql, $conf);

$_tpl->set('MCH_MAX',MCH_MAX);
$_tpl->set('MCH_TMP',MCH_TMP);

$_tpl->set('module_tpl','modules/gen/gen.tpl');

$_tpl->set('gen_mbr',$_SESSION['user']['pseudo']);
$_tpl->set('gen_population',$_SESSION['user']['population']);
$_tpl->set('gen_points',$_SESSION['user']['points']);
//Carte
$carte = $game->get_position($_SESSION['user']['mid']);
$_tpl->set('gen_map_array', $carte);

//Ressources Principales
$sec_res = $game->get_second_res($_SESSION['user']['mid'], $_SESSION['user']['race'], $conf->race_cfg);
foreach($sec_res as $res_key => $res_value)
{
	if($res_value['res_nb'] == 0 AND $conf->res[$res_value['res_type']]['nobat'])
	{
		unset($sec_res[$res_key]);
	}
}
$_tpl->set('res_array',$sec_res);

//Population en construction
$unt_in_form = $game->get_infos_unt($_SESSION['user']['mid'], 0, false);
$_tpl->set('unt_array',$unt_in_form[0]);

//Batiment en reparation
$btc_en_rep = $game->get_infos_btc($_SESSION['user']['mid'], 0, true, false,2);
if(is_array($btc_en_rep))
{
	foreach($btc_en_rep as $btc_bid => $btc_value)
	{
		if($btc_value['btc_etat'] != 1)
		{
			unset($btc_en_rep[$btc_bid]);
		}
	}
}

if(!count($btc_en_rep))
{
	unset($btc_en_rep);
}
$_tpl->set('btc_en_rep',$btc_en_rep);

//Batîment en construction
$btc_en_const = $game->get_infos_btc($_SESSION['user']['mid'], 0, false,false);
$_tpl->set('btc_en_const',$btc_en_const);


$_tpl->set("btc_conf",$conf->btc);

//Bâtiments 
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
$_tpl->set('gen_def',$defense);
$_tpl->set('gen_bonus_def',$bonus_def);
$_tpl->set('gen_nb_btc',$nb_btc);

//Recherche
$src = $game->get_infos_src($_SESSION['user']['mid'], 0, true);
$nb_src = count($src);
$_tpl->set('gen_nb_src',$nb_src);

//Recherche en cours
$src_in_form = $game->get_infos_src($_SESSION['user']['mid'], 0, false);
$_tpl->set('src_array',$src_in_form);
$_tpl->set("src_infos",$conf->src);

//Ressources en cours
$res = $game->get_infos_res($_SESSION['user']['mid'], 0, false);
$_tpl->set('res_enc_array',$res);

//Attaques (- de 10 cases)
$atq_array = $war->get_infos($_SESSION['user']['mid'], false, 0,50);
$_tpl->set('atq_array',$atq_array);

//ventes
$vente_array = $com->get_infos($_SESSION['user']['mid']);
$_tpl->set('vente_array',$vente_array);
}
?>