<?
if(_index_!="ok"){ exit; }

$_tpl->set("module_tpl","modules/manual/index.tpl");
$page = isset($_GET['page']) ? (int) $_GET['page'] : 0;
$race = (int) (isset($_GET['race']) AND strstr(USER_RACE,$_GET['race']) AND $_GET['race'] > 0) ? $_GET['race'] : (($_SESSION['user']['race'] >0) ? $_SESSION['user']['race'] : 1);
if($race == 0 OR !$race) $race = 1;
$_tpl->set('man_race',$race);
	
if($page != 0)
{
	$_tpl->set('mnl_tpl','modules/manual/pages/'.(int) $_GET['page'].'.tpl');
	$_tpl->set('ATQ_PTS_MIN',ATQ_PTS_MIN);
	$_tpl->set('ATQ_PTS_DIFF',ATQ_PTS_DIFF);
	$_tpl->set('ATQ_PTS_RAP',ATQ_PTS_RAP);
	$_tpl->set('ATQ_DETECT_DST',ATQ_DETECT_DST);
	$_tpl->set('ATQ_MAX_RES_NB',ATQ_MAX_RES_NB);
	
	$_tpl->set('GAME_MAX_UNT_BONUS',GAME_MAX_UNT_BONUS);
	
	$_tpl->set('ATQ_PERC_DEF',ATQ_PERC_DEF*100);
	$_tpl->set('ATQ_PERC_WIN',ATQ_PERC_WIN*100);
	$_tpl->set('ATQ_PERC_NUL',ATQ_PERC_NUL*100);
	$_tpl->set('ATQ_LIM_DIFF',ATQ_LIM_DIFF);
	$_tpl->set('ATQ_PTS_MAX_PER_DAY',ATQ_PTS_MAX_PER_DAY);
	$_tpl->set('ATQ_NB_MAX_PER_DAY',ATQ_NB_MAX_PER_DAY);
	$_tpl->set('ATQ_MAX_BTC',ATQ_MAX_BTC);
		
	$_tpl->set('GAME_MAX_BTC',GAME_MAX_BTC);
	$_tpl->set('GAME_MAX_RES',GAME_MAX_RES);
	$_tpl->set('GAME_MAX_UNT',GAME_MAX_UNT);
	$_tpl->set('GAME_MAX_SRC',GAME_MAX_SRC);
	$_tpl->set('GAME_RES_PRINC',GAME_RES_PRINC);
	$_tpl->set('GAME_RES_BOUF',GAME_RES_BOUF);
	$_tpl->set('GAME_MAX_UNT_TOTAL', GAME_MAX_UNT_TOTAL);
	$_tpl->set('GAME_MAX_BTC_TOTAL', GAME_MAX_BTC_TOTAL);
	
	$_tpl->set('GAME_MAX_BONUS',GAME_MAX_BONUS);
	
	$_tpl->set('GAME_MAX_UNT_BONUS',GAME_MAX_UNT_BONUS);
	
	$_tpl->set('ALL_MAX',ALL_MAX);
	$_tpl->set('ALL_MIN_PTS',ALL_MIN_PTS);
	$_tpl->set('ALL_MIN_ADM_PTS',ALL_MIN_ADM_PTS);
	$_tpl->set('ALL_CREATE_PRICE',ALL_CREATE_PRICE);
	
	$_tpl->set('COM_MAX_NB1',COM_MAX_NB1);
	$_tpl->set('COM_MAX_NB2',COM_MAX_NB2);
	$_tpl->set('COM_MAX_NB3',COM_MAX_NB3);
	$_tpl->set('COM_MAX_VENTES1',COM_MAX_VENTES1);
	$_tpl->set('COM_MAX_VENTES2',COM_MAX_VENTES2);
	$_tpl->set('COM_MAX_VENTES3',COM_MAX_VENTES3);
	
	$_tpl->set('MCH_MAX',MCH_MAX);
	$_tpl->set('MCH_TMP',MCH_TMP);
	
	
	
	if($race != $_SESSION['user']['race'])
	{
		include('conf/'.(int) $race.'.php');
		$name = "config".(int) $race;
		$race_config = new $name();
		$_tpl->set('man_load',(int) $race);
	}else{
		$race_config = $conf;
	}
	$_tpl->set('conf_btc',$race_config->btc);
}
elseif($race AND @file_exists(SITE_DIR."conf/".$race.".php"))
{
	$_tpl->set('mnl_tpl','modules/manual/race.tpl');
	if($race != $_SESSION['user']['race'])
	{
		include('conf/'.(int) $race.'.php');
		$name = "config".(int) $race;
		$race_config = new $name();
		$_tpl->set('man_load',(int) $race);
	}else{
		$race_config = $conf;
	}
	if(!$_GET['type'] OR ($_GET['type'] != 'btc' AND $_GET['type'] != 'unt' AND $_GET['type'] != 'res' AND $_GET['type'] != 'src'))
	{
		$_tpl->set('man_act','liste');
	}else{
		$_tpl->set('man_act',$_GET['type']);
		$_tpl->set('man_array',$race_config->$_GET['type']);
		$_tpl->set('max_bonus',GAME_MAX_UNT_BONUS);
	}
}
?>