<?
//Verif
if(_index_!="ok" or $_SESSION['user']['droits']{1}!=1){ exit; }
$max_connected = SITE_MAX_CONNECTED;
$max_inscrits = SITE_MAX_INSCRITS;
date_default_timezone_set('Europe/Paris');


$connected=$_ses->nb_online();
$inscrits=$mbr->nb_mbr();

$_tpl->set("stats_connected",$connected);
$_tpl->set("stats_inscrits",$inscrits);
$_tpl->set("ses_admin",$_SESSION['user']['droits']{3});

$stats_max_connected[] = 100-round(($max_connected-$connected)/ $max_connected *100);
$stats_max_connected[] = round(($max_connected-$connected)/ $max_connected *100);
$stats_max_inscrits[] = 100-round(($max_inscrits-$inscrits)/ $max_inscrits *100);
$stats_max_inscrits[] = round(($max_inscrits-$inscrits)/ $max_inscrits *100);

$_tpl->set("stats_inscrits",$inscrits);
$_tpl->set("stats_connected",$connected);

$_tpl->set("stats_max_inscrits",$stats_max_inscrits);
$_tpl->set("stats_max_connected",$stats_max_connected);

$decal = $_SESSION['user']['decal'];
if(substr("-",$decal))
{
	$decal = str_replace('-','',$decal);
	$delta = -1;
}
else
{
	$delta = 1;	
}
$decal = strtotime($decal)-strtotime(date("Y-m-d 00:00:00"));
$_tpl->set("stats_date",date("d-m-Y H:i:s",time()-$delta*$decal));
//$_tpl->set("stats_flash_date",urlencode(date("Y-m-d H:i:s")));
$next_turn =  (60-date("i"))%10;
$_tpl->set("stats_next_turn",$next_turn);

if($_SESSION['user']['loged'] == true)
{
	if($conf->race_cfg AND !$cron_lock)
	{
		$prim_res = $game->get_primary_res($_SESSION['user']['mid'], $conf->race_cfg);
		$prim_btc = $game->get_primary_btc($_SESSION['user']['mid'], $conf->race_cfg);
	}
	
	$_tpl->set("stats_prim_res",$prim_res);
	$_tpl->set("stats_prim_btc",$prim_btc);
	$_tpl->set("stats_population",$_SESSION['user']['population']);
	$_tpl->set("stats_points",$_SESSION['user']['points']);
}

?>
