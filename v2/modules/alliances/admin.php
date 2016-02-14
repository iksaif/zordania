<?php
if(!defined("_INDEX_") or !can_d(DROIT_ADM_AL)){ exit; }

require_once("lib/member.lib.php");
require_once("lib/alliances.lib.php");
require_once("lib/parser.lib.php");

$_tpl->set("module_tpl","modules/alliances/admin.tpl");

if(in_array($_sub, array('add_res', 'shoot', 'chef', 'edit_mbr'))) {
	if(!can_d(DROIT_ADM_EDIT)) {
		$_sub = "";
	}
}

//Liste des alliances
if(!$_act)
{
	$_tpl->set('al_act','liste');	
	$al_page=request("al_page", "uint", "get");
	$_tpl->set('al_page',$al_page);
	$al_nb = allyFactory::nb();
	$limite_page = LIMIT_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set('limite_nb_page',LIMIT_NB_PAGE);
	$_tpl->set("al_nb",$al_nb);
	
	$nombre_page = $al_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;

	$current_i = $al_page - (LIMIT_NB_PAGE / 2);
	$current_i = round($current_i < 0 ? 0 : $current_i)*LIMIT_PAGE;
	$_tpl->set('current_i',$current_i);
	
	if($al_page)
		$limite_mysql = $limite_page * $al_page;
	else
		$limite_mysql = 0;
	
	$cond = array();
	$cond['limite2'] = $limite_mysql;
	$cond['limite1'] = $limite_page;
	
	$name = request("name", "string", "post", request("al_name", "string", "get"));
	if($name)
		$cond['name'] = $name;
	$_tpl->set("al_name", $name);
	
	$_tpl->set('al_array',allyFactory::getList($cond));
}
elseif($_act == 'view')
{
	$al_grades = get_flip_const('ALL_ETAT');

	$al_aid = request("al_aid", "uint", "get");
	$ally = allyFactory::getAlly($al_aid);
	$_tpl->set('al_act','view');
	
	/* actions d'edition sur l'alliance */
	if($ally) {
		switch($_sub) {
		case "add_res": // ressources du grenier
			$nb = request("res_nb", "array", "post");
			mod_aly_res($al_aid, $_user['mid'], $nb);
			break;
		case "shoot": // ajouter un msg
			$text = parse(request("text", "string", "post"));
			add_aly_msg($al_aid, $text, $_user['mid']);
			break;
		case 'chef': 
			$mid = request("mid", "uint", "get");
			$mbr_infos = $ally->getMembers($mid);
			if($mbr_infos && $mbr_infos['ambr_aid'] == $al_aid)
					$_tpl->set('set_chef',$ally->setChef($mid));
			break;
		case 'edit_mbr': // modifier les grades de tous les membres
			$aletat = request('grd', 'array', 'post');
			// modifier toutes les permissions pour tout le monde
			$cond = array();
			foreach($ally->getMembers() as $result) {
				$mid = $result['mbr_mid'];
				if($result['ambr_etat'] != $aletat[$mid])
					$cond[$mid] = $aletat[$mid];
			}
			$_tpl->set('max_perm',allyFactory::$_drts_max);
			$_tpl->set('err_msg_aly',$ally->mod_mbr($cond));
			break;
		}
		$_tpl->set('al_array',$ally->getInfos());
		$_tpl->set('res_array',$ally->getRessources());
	
		$al_page = request("al_page", "uint", "get");
		$_tpl->set('al_page',$al_page);
		$limite_page = LIMIT_PAGE;
		if($al_page)
			$limite_mysql = $limite_page * $al_page;
		else
			$limite_mysql = 0;
	
		$res_log = get_log_aly_res($al_aid, LIMIT_PAGE, $limite_mysql);
		$_tpl->set('log_array',$res_log);
	
		$_tpl->set('al_logo',$ally->getLogo());
		$_tpl->set('al_mbr',$ally->getMembers());
		$_tpl->set('chef',$ally->getMembers($ally->al_mid));
		$_tpl->set('al_act','view');
		$_tpl->set('_limite_grenier', $_limite_grenier);
		$_tpl->set('al_grades', $al_grades);
	}
	
}


?>
