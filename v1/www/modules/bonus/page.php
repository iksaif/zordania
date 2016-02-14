<?
//Verifications
if(_index_!="ok" or $_SESSION['user']['droits']{4}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else
{
include("lib/bonus.class.php");
$bon = new bonus($_sql);

include("lib/com.class.php");
$com = new mch($_sql,$res);

$_tpl->set('module_tpl', 'modules/bonus/bonus.tpl');
$auth = ALLOPASS_AUTH;

$type_res = isset($_GET['DATAS']) ? $_GET['DATAS'] : (isset($_POST['bon_type_res']) ? $_POST['bon_type_res'] : "");
$recall = isset($_GET['RECALL']) ? $_GET['RECALL'] : "";

if(!$type_res or !isset($conf->race_cfg['bonus_res'][$type_res]))
{
	//Formulaire
	$_tpl->set('bon_act','liste');
	
	$res_cfg = array();
	$or = ((MIN_BONUS_NB) + $conf->race_cfg['bonus_res'][1] * $_SESSION['user']['points']);
	$res_cfg[1] = round(($or > GAME_MAX_BONUS) ? GAME_MAX_BONUS : $or);

	$cours = $com->get_cours();
	foreach($cours as $value) {
		if($conf->race_cfg['bonus_res'][$value['mch_cours_res']]) {
			$res_cfg[$value['mch_cours_res']] = ceil($or / $value['mch_cours_cours']);
		}
	}
	/*
	foreach($conf->race_cfg['bonus_res'] as $res_type => $res_nb)
	{
		$new_res_nb = ((MIN_BONUS_NB) + $res_nb * $_SESSION['user']['points']);
		$res_cfg[$res_type] = round(($new_res_nb > GAME_MAX_BONUS) ? GAME_MAX_BONUS : $new_res_nb);
	}
*/
	$_tpl->set('bon_list_res',$res_cfg);	
}	
elseif(!$recall)
{
	$_tpl->set('bon_act','tel');
	if($_act == "error")
	{
		$_tpl->set('bon_error','code_error');
	}
	$_tpl->set('bon_type_res',$type_res);
}
else
{
	$_tpl->set('bon_act','donner');
				
	$res_cfg = array();
	$or = ((MIN_BONUS_NB) + $conf->race_cfg['bonus_res'][1] * $_SESSION['user']['points']);
	$res_cfg[1] = round(($or > GAME_MAX_BONUS) ? GAME_MAX_BONUS : $or);

	$cours = $com->get_cours($type_res);
	foreach($cours as $value) {
		if($conf->race_cfg['bonus_res'][$value['mch_cours_res']]) {
			$res_cfg[$value['mch_cours_res']] = ceil($or / $value['mch_cours_cours']);
		}
	}
	
	$nb_res = $res_cfg[$type_res];
			
	if($bon->verifier($recall, $auth,$_SESSION['user']['mid'],$type_res,$nb_res))
	{
		$_tpl->set('bon_ok', true);
		if($conf->race_cfg['bonus_res'][$type_res])
		{
			$game->add_res($_SESSION['user']['mid'],$type_res,$nb_res,0);
		}
		else
		{
			$nb_res = 0;
		}
		$_tpl->set('bon_nb_res',$nb_res);
		$_tpl->set('bon_type_res',$type_res);
		
	}
	else
	{
		$_tpl->set('bon_error','code_error');
	}	
}

}
?>