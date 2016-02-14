<?
if(_index_!="ok" or $_SESSION['user']['droits']{1}!=1){ exit; }
if($_SESSION['user']['loged']!=true) { 
	$_tpl->set("need_to_be_loged",true); 
} else {


$_tpl->set("module_tpl","modules/zzz/zzz.tpl");

$passmd5 = isset($_POST['mbr_pass']) ? md5($_POST['mbr_pass']) : "";

if($_act == "ronflz" && $_SESSION['user']['etat'] == 1 && $_SESSION['user']['pass'] == $passmd5) {
	$mbr->edit($_SESSION['user']['mid'], array('etat' => 3,'ldate' => true));
	$_tpl->set('zzz_act','ronflz');
} elseif($_act == "dring" && $_SESSION['user']['etat'] == 3) {
	$_tpl->set('zzz_act','dring');
	
	$mbr_array = $mbr->get_infos($_SESSION['user']['mid']);
	$ldate  = $mbr_array[0]['mbr_ldate'];
	
	$ldate = explode(' ',$ldate);
	$ldate[0] = explode('-',$ldate[0]);
	$ldate[1] = explode(':',$ldate[2]);

	$ltimestamp = mktime($ldate[1][0], $ldate[1][1], $ldate[1][2], $ldate[0][1], $ldate[0][0], $ldate[0][2]);
	$timestamp =time();
	
	
	if(($timestamp - $ltimestamp) > USER_INACTIF) {
		$mbr->edit($_SESSION['user']['mid'], array('etat' => 1,'ldate' => true));
		$_tpl->set('zzz_ok',true);
	} else {
		$_tpl->set('zzz_ok',false);
	}
} elseif($_SESSION['user']['etat'] == 3) {
	$_tpl->set('zzz_act','stats');
	
	$mbr_array = $mbr->get_infos($_SESSION['user']['mid']);
	$ldate  = $mbr_array[0]['mbr_ldate'];
	
	$ldate_aff=$ldate;
	$ldate = explode(' ',$ldate);
	$ldate[0] = explode('-',$ldate[0]);
	$ldate[1] = explode(':',$ldate[2]);

	$ltimestamp = mktime($ldate[1][0], $ldate[1][1], $ldate[1][2], $ldate[0][1], $ldate[0][0], $ldate[0][2]);
	$timestamp =time();

	$_tpl->set('zzz_date',$ldate_aff);
	
	if(($timestamp - $ltimestamp) > USER_INACTIF) {
		$_tpl->set('zzz_ok',true);
	} else {
		$_tpl->set('zzz_ok',false);
	}
} else {
	$_tpl->set('zzz_act','rien');
}

}
?>