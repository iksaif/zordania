<?php
//Verif
if(defined("_INDEX_") and can_d(DROIT_ADM_MBR)){

require_once("lib/msg.lib.php");
require_once("lib/parser.lib.php");

$_tpl->set("module_tpl","modules/msg/admin.tpl");
$_tpl->set('act',$_act);

switch($_act) {

case 'com': /* ajouter commentaire admin */
	$sid = request("sid", "uint", "get");
	if($sid) {
		$com = '<em>'.$_user['pseudo'] .' le '.date("d/m/Y H:i:s")."</em><br/>\n".parse(request("com", "string", "post"));
		if($com)
			$_tpl->set("com_ajoute",add_com_sign($sid, $com));

		$msg_infos = get_sign_list(array('id'=>$sid));
		if(!$msg_infos)
			$_tpl->set("msg_bad_id",true);
		else
			$_tpl->set('msg_infos',$msg_infos[0]);
	} else
		$_tpl->set("msg_bad_id",true);

	break;

case "read": /* Lecture */
	$sign_id = request("mrec_id", "uint", "get");
	if($sign_id) {
		$msg_infos = get_sign_list(array('mrec_id'=>$sign_id));

		if(!$msg_infos)
			$_tpl->set("msg_bad_id",true);
		else
			$_tpl->set('msg_infos',$msg_infos[0]);
	} else
		$_tpl->set("msg_bad_id",true);
	break;

case 'assign': /* s'assigner un msg signalé */
	$sid = request("sid", "uint", "get");
	$com = "{$_user['pseudo']} s'est assigné ce message le".date("d/m/Y H:i:s")."<hr/>\n";
	$_tpl->set("msg_assigne",set_adm_sign($sid, $_user['mid'], $com));
	/* peut pas passer négatif */
	if($admin_cache->msg_report > 0) $admin_cache->msg_report--;
	$admin_cache->force_save();
	// continuer sur la liste des msg = default

// case'msg': // mp signalés
default:
	if ($_act == 'maj') { /* maj du nb de messages signalés */
		$count_sign = count_sign(array('admid' => 0));
		$admin_cache->msg_report = $count_sign['count_sign'];
		$admin_cache->force_save();
	}

	$_tpl->set("list_sign", get_sign_list(array('etat'=>0)));
	$count_sign = count_sign();
	$nb_pages = floor($count_sign['count_sign'] / LIMIT_PAGE);
	$pge = protect('pge', 'get', 'uint', 1);
	$_tpl->set('nb_sign', $admin_cache->msg_report);
	$_tpl->set('pge', $pge);
	$_tpl->set('arr_pge', get_list_page( $pge, $nb_pages));
	break;

} /* fin switch $_act */

} /* fin si droits ok */

?>
