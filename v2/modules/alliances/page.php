<?php
if(!defined("_INDEX_")) exit;
if(!can_d(DROIT_PLAY)) {
	$_tpl->set("need_to_be_loged",true);
} else {

require_once("lib/msg.lib.php");
require_once("lib/alliances.lib.php");
require_once("lib/ally.class.php");
require_once("lib/res.lib.php");
require_once("lib/member.lib.php");
require_once("lib/diplo.lib.php");
require_once("lib/parser.lib.php");
$smileys_base = getSmileysBase();
$smileys_more = getSmileysMore($smileys_base);
$_tpl->set("smileys_base", $smileys_base);
$_tpl->set("smileys_more", $smileys_more);

$al_aid = request("al_aid", "uint", "get");
$order = array('DESC','points');

$_tpl->set('module_tpl','modules/alliances/alliances.tpl');
$_tpl->set('al_sub','');


/* On fait ça ici, parce que ça serait assez inutile de le faire a chaque page, mais si il faut, ça sera bougé */
$_ses->update_aly();

$ally = false;
if($_user['aetat'] != ALL_ETAT_NULL){
	if($_act != 'view'){ // infos sur mon ally
		$ally = allyFactory::getAlly($_user['alaid']);
		$al_array = $ally->getInfos();
		//$al_mbr   = $ally->getMembers();
		$droits['diplo'] = $ally->isAccesOk($_user['mid'],'diplo');
		$_tpl->set('droits', $droits);
	}
}

$acts = array('admin', 'res', 'reslog', 'join', 'part', 'descr_rules', 'resally');
if($_user['aetat'] == ALL_ETAT_DEM && in_array($_act, $acts))
	$_act = "my";
$acts = array('admin', 'res', 'reslog', 'part', 'descr_rules', 'resally');
if($_user['aetat'] == ALL_ETAT_NULL && in_array($_act, $acts))
	$_act = "my";
if (empty($_act)) $_act = 'liste';
$_tpl->set('al_act',$_act);

if($_user['alaid'] and $_user['aetat'] != ALL_ETAT_DEM) {
	/* mes pactes */
	$dpl_atq = new diplo(array('aid' => $_user['alaid']));
	$dpl_atq_arr = $dpl_atq->actuels(); // les pactes actifs en tableau
	$_tpl->set('mbr_dpl',$dpl_atq_arr);
}
else
	$dpl_atq_arr = array();


switch($_act) {
case 'view': // vue d'une alliance
	$ally = allyFactory::getAlly($al_aid);
	if(!$ally) break;
	$_tpl->set('ally',$ally->getInfos());
	$_tpl->set('chef',$ally->getMembers($ally->al_mid));
	$_tpl->set('al_logo',$ally->getLogo());

	$al_mbr = $ally->getMembers();
	foreach($al_mbr as $key => $value) {
		$al_mbr[$key]['mbr_dst'] = calc_dst($_user['map_x'], $_user['map_y'], $value['map_x'], $value['map_y']);
	}
	$al_mbr = can_atq_lite($al_mbr, $_user['pts_arm'],$_user['mid'],$_user['groupe'], $_user['alaid'], $dpl_atq_arr);

	$_tpl->set('al_mbr',$al_mbr);
	break;

//Mon alliance (Infos (pts, etc ..) + Liste joueurs + Shootbox)
case 'my':
 	
	if($ally)

		$_tpl->set('al_array',$ally->getInfos());

	if($_user['aetat'] == ALL_ETAT_NULL)
		$_tpl->set('al_no_al',true);
	else if($_user['aetat'] == ALL_ETAT_DEM)
		$_tpl->set('al_waiting',$_user['alaid']);	
	else {
		$_tpl->set('ally',$ally->getInfos());
		$_tpl->set('chef',$ally->getMembers($ally->al_mid));
		$_tpl->set('al_logo',$ally->getLogo());
	
		$chef = ($ally->al_mid == $_user['mid']);
		//Sub = post => post un message sur la shootbox
		if($_sub == 'post') {
			$msg = request('pst_msg', 'string', 'post');
			if($msg)
				$_tpl->set('al_msg_post',add_aly_msg($_user['alaid'],parse($msg),$_user['mid']));
		} else if($_sub == "del") {
			$msgid = request('msgid', 'uint', 'get');
			if($msgid)
				$_tpl->set('al_msg_del',del_aly_msg($_user['alaid'],$msgid,$_user['mid'],$chef));
		}
		
		$_tpl->set('al_admin',$chef);
	
		$al_page = request('al_page', 'uint', 'get');
		$al_nb = count_aly_msg($_user['alaid']);
		$_tpl->set("al_nb",$al_nb);
		
		$current_i = $al_page - LIMIT_NB_PAGE/2;
		$current_i = 0+round($current_i < 0 ? 0 : $current_i)*LIMIT_PAGE;
	
		$_tpl->set('current_i',$current_i);
		$_tpl->set('al_page',$al_page);

		if($al_page)
			$limite_mysql = LIMIT_PAGE * $al_page;
		else
			$limite_mysql = 0;

		$al_shoot_array = get_aly_msg($_user['alaid'], LIMIT_PAGE, $limite_mysql);
		$_tpl->set('al_shoot_array',$al_shoot_array);

		$al_mbr = $ally->getMembers();
		foreach($al_mbr as $key => $value)
			$al_mbr[$key]['mbr_dst'] = calc_dst($_user['map_x'], $_user['map_y'], $value['map_x'], $value['map_y']);
	
		$_tpl->set('al_mbr',$al_mbr);
		$_tpl->set('al_key',calc_key($_file, $_user['login']));
	}
	break;

case 'descr_rules':
	if(!$_user['alaid']) {
		$_tpl->set('al_no_al',true);
	} else if($_user['alaid'] > 0) {	
		$_tpl->set('al_array',$ally->getInfos());
	}
	break;

/* Admin alliances (Param + demandes) */
case 'admin':
 	if($_user['alaid']) { /* Faut être dans une alliance */
		if(in_array( $_user['aetat'], array
			(ALL_ETAT_CHEF, ALL_ETAT_SECD, ALL_ETAT_RECR, ALL_ETAT_DPL, ALL_ETAT_INTD))) { // faut un grade
		
			$al_array['al_descr'] = unparse($al_array['al_descr']);
			$al_array['al_rules'] = unparse($al_array['al_rules']);
			$al_array['al_diplo'] = unparse($al_array['al_diplo']);

			$droits = array();
			foreach(allyFactory::$_drts_all as $key => $value)
				if ($ally->isAccesOk($_user['mid'], $key))
					$droits[$key] = true;

			$_tpl->set('droits', $droits);
			$_tpl->set('al_array',$al_array);

			$al_in_mbr = $ally->getMembers();
			$al_race = $ally->getRaces();

			$arr_algrp = array(); // droits transmissibles pour le grade
			if($_user['aetat'] == ALL_ETAT_INTD)
				$arr_algrp = array(
					ALL_ETAT_OK,ALL_ETAT_NOP,ALL_ETAT_INTD,ALL_ETAT_DPL,ALL_ETAT_RECR);
			else if($_user['aetat'] == ALL_ETAT_SECD)
				$arr_algrp = array(
					ALL_ETAT_OK,ALL_ETAT_NOP,ALL_ETAT_INTD,ALL_ETAT_DPL,ALL_ETAT_RECR,ALL_ETAT_SECD);
			else if($_user['aetat'] == ALL_ETAT_CHEF)
				$arr_algrp = array(
					ALL_ETAT_OK,ALL_ETAT_NOP,ALL_ETAT_INTD,ALL_ETAT_DPL,ALL_ETAT_RECR,ALL_ETAT_SECD,ALL_ETAT_CHEF);
			$_tpl->set('arr_algrp',$arr_algrp);

			if ($_sub != '' && !$ally->isAccesOk($_user['mid'], $_sub)){ // action non autorisée pour ce membre
				$_tpl->set('al_sub_forbiden',$_sub);
				$_sub = ''; // default
			}
			$_tpl->set('al_sub',$_sub);

			switch($_sub) {
				case  'logo':
					$logo = request("al_logo", "array", "files");
					$_tpl->set('al_logo',upload_aly_logo($_user['alaid'],$logo));
					break;

				case 'param': //Param -> (description + ouvert)
					$edit = array();
					$edit['descr'] = parse(request("al_descr", "string", "post"));
					$edit['open'] = request("al_open", "bool", "post");
					$_tpl->set('al_param',edit_aly($_user['alaid'],$edit));
					break;

				case 'rules': //rules -> (règles du grenier)
					$edit = array();
					$edit['rules'] = parse(request("al_rules", "string", "post"));
					$_tpl->set('al_param',edit_aly($_user['alaid'],$edit));
					break;

				case 'diplo': //diplo -> (règles du diplomate)
					$edit = array();
					$edit['diplo'] = parse(request("al_diplo", "string", "post"));
					$_tpl->set('al_param',edit_aly($_user['alaid'],$edit));
					break;

				case 'accept':
					$mid = request("mid", "uint", "get");
					$mbr_infos = $ally->getMembers($mid);
					if($ally->isFull())
						$_tpl->set('al_full',true);
					else if($mbr_infos) {
						$race = $mbr_infos['mbr_race'];
						if($al_race[$race] >= $_races_aly[$_user['race']][$race]) {
							$_tpl->set("al_bad_race", true);
						} else if($mbr_infos['ambr_etat'] != ALL_ETAT_DEM) {
							//Verifier que le membre demande bien.
							$_tpl->set('al_bad_mid',true);
						} else {
							$ally->mod_mbr(array($mid => ALL_ETAT_NOOB));

							$text = $_tpl->get('modules/alliances/msg/accept.tpl',1);
							$titre = $_tpl->get('modules/alliances/msg/titre.tpl',1);
							send_msg($_user['mid'], $mid, $titre, parse($text));
							$_tpl->set('al_ok',true);
							$_tpl->set('al_pseudo',$mbr_infos['mbr_pseudo']);
						}
					} else {
						$_tpl->set('al_no_mid',true);
					}
					break;

				case 'refuse': /* Refuser */
					$mid = request("mid", "uint", "get");
					$mbr_infos = $ally->getMembers($mid);
					if($mbr_infos && $mid != $_user['mid']) {
						if($mbr_infos['ambr_aid'] == $_user['alaid']
							&& $mbr_infos['ambr_etat'] == ALL_ETAT_DEM) {
							del_aly_mbr($_user['alaid'], $mid);
							// rembourser le postulant
							mod_res($mid, array(GAME_RES_PRINC => ALL_JOIN_PRICE));
							
							$text = $_tpl->get('modules/alliances/msg/refuse.tpl',1);
							$titre = $_tpl->get('modules/alliances/msg/titre.tpl',1);
							send_msg($_user['mid'], $mid, $titre, parse($text));
							$_tpl->set('al_ok',true);
							$_tpl->set('al_pseudo',$mbr_infos['mbr_pseudo']);
						} else {
							$_tpl->set('al_bad_mid',true);
						}
					} else {
						$_tpl->set('al_no_mid',true);
					}
					break;

				case 'kick': /* Virer */
					$mid = request("mid", "uint", "get");
					$conf = request("conf", "bool", "get");
					$mbr_infos = $ally->getMembers($mid);
					if (!$conf) {
						$_tpl->set('need_conf', $mid); // confirmation
					} else if($mbr_infos && $mid != $_user['mid']) {
						if($mbr_infos['ambr_aid'] == $_user['alaid']) {
							edit_aly($_user['alaid'], array('nb_mbr' => -1));
							del_aly_mbr($_user['alaid'], $mid);
							
							$_tpl->set('al_ok',true);
							$_tpl->set('al_pseudo',$mbr_infos['mbr_pseudo']);
						} else {
							$_tpl->set('al_bad_mid',true);
						}
					} else {
						$_tpl->set('al_no_mid',true);
					}
					break;

				case 'chef': // ainsi le chef redevient simple membre
					$mid = request("mid", "uint", "get");
					$mbr_infos = $ally->getMembers($mid);
					if(!$mbr_infos)
						$_tpl->set('al_bad_mid',true);
					else if($mbr_infos['ambr_etat'] == ALL_ETAT_NOOB)
						$_tpl->set('al_mbr_noob',true);
					else {
						$ally->setChef($mid);
						$_tpl->set('al_ok',true);
						$_tpl->set('al_pseudo',$mbr_infos['mbr_pseudo']);
					}
					break;

				case 'perm':
					$aletat = request("aletat", "array", "post");
					// modifier toutes les permissions pour tout le monde
					$cond = array();
					foreach($al_in_mbr as $result) {
						$mid = $result['mbr_mid'];
						// brider les membres qu'on peut modifier, et les droits qu'on peut leur affecter
						if(!in_array($aletat[$mid], $arr_algrp) or
								!in_array($result['ambr_etat'], $arr_algrp))
							continue;

						if($result['ambr_etat'] != $aletat[$mid])
							$cond[$mid] = $aletat[$mid];
					}
					$_tpl->set('max_perm',allyFactory::$_drts_max);
					$_tpl->set('change_perm',$cond);
					$_tpl->set('al_in_mbr',$al_in_mbr);
					$_tpl->set('change_ok',$ally->mod_mbr($cond));
					break;

				case 'del':
					$ok = request("ok", "bool", "post");
					if(!$ok)
						$_tpl->set('al_del','need_ok');
					else
						$_tpl->set('al_del',del_aly($_user['alaid']));
					break;

				default:
					$_tpl->set('al_stat', $al_race);
					$_tpl->set('al_mbr',$ally->getMembersByEtat(ALL_ETAT_DEM));
					$_tpl->set('al_in_mbr',$al_in_mbr);
					$_tpl->set('al_logo', $ally->getLogo());
					
					$_tpl->set('logo_type',ALL_LOGO_TYPE);
					$_tpl->set('logo_x_y',ALL_LOGO_MAX_X_Y);
					$_tpl->set('logo_size',ALL_LOGO_SIZE);
					break;
			}
		} else
			$_tpl->set('al_not_admin',true);
	} else
		$_tpl->set('al_not_admin',true);

	break;

case 'res': /* grenier */ 
	$_tpl->set('_limite_grenier', $_limite_grenier);
	$_tpl->set('liste_res', array_fill(1, get_conf('race_cfg', 'res_nb'), 0));

	$res_nb = protect(request('res_nb', 'array', 'post'), array('int'));
	if(request('get', 'string', 'post') != '')
		$coef = -1;
	else if(request('put', 'string', 'post') != '')
		$coef = 1;
	else
		$coef =0;

	$have_res = get_res_done2($_user['mid']);
	$have_res = $have_res[0];

	$aly_res = $ally->getRessources(); // Ressources du grenier

	$res_limite = array(); /* si limite atteinte */
	$res_taxed = array();
	$res_ok = array();

	if($coef != 0 and $ally->isGrenierAcces($_user['mid'])) { /* droit à utiliser le grenier */
		foreach($res_nb as $type => $nb){
			$nb = protect($nb, 'uint') * $coef;

			if(!get_conf("res", $type) or 
					($nb >= 0 and $nb < ALL_MIN_DEP)) /*dépot mini au grenier */
				continue;

			if(!isset($aly_res[$type])) $aly_res[$type] = 0;

			if($nb > 0){ // joueur donne
				$nb_tax = floor($nb*(1-(ALL_TAX / 100)));
				if($have_res[$type] < $nb){ //  mais n'a pas assez
					$res_limite[$type] = $_limite_grenier[$type];
					continue;
				}
				else if($aly_res[$type] + $nb_tax > $_limite_grenier[$type]){ // grenier plein
					$res_limite[$type] = $_limite_grenier[$type];
					continue;
				}
			} else if($nb < 0){ /* joueur prend */
				if($aly_res[$type] < ($nb*-1)){
					$res_limite[$type] = $_limite_grenier[$type];
					continue;
				}
				$nb_tax = $nb;
			}

			//message aux modos + aux co-admins si on retire plus que 1/nb_joueur_ally et si le retrait est > au seuil pillage
			$nb_aly_mbr = count($ally->getMembers());
			if($nb < 0 && $type != GAME_RES_BOUF 
				&& abs($nb) > $aly_res[$type] * (2 / $nb_aly_mbr) && abs($nb) > ALL_SEUIL_PILLAGE)
			{
				$_tpl->set('mid', $_user['mid']);
				$_tpl->set('pseudo', $_user['pseudo']);
				$_tpl->set('typres', $type);
				$_tpl->set('alaid', $_user['alaid']);
				$_tpl->get_config("race/{$_user['race']}.config");
				$msg = nl2br($_tpl->get("modules/admin/msg/pillage_$_act.txt.tpl",1));
				$titre = $_tpl->get("modules/admin/msg/pillage.obj.tpl",1);
				send_to_all(MBR_WELC, $titre, $msg, array(GRP_GARDE, GRP_DEMI_DIEU));
			}

			$res_taxed[$type] = $nb_tax;
			$res_ok[$type] = (int) $nb;
			$aly_res[$type] += $nb_tax;
			$have_res[$type] -= $nb;

		} // fin foreach $res_nb...

		/* maj des ressources */
		mod_res($_user['mid'], $res_ok, -1);
		mod_aly_res($_user['alaid'], $_user['mid'], $res_taxed);
	} // fin if ( droits grenier )

	$_tpl->set('res_limit', $res_limite);
	$_tpl->set('res_ok',$res_ok);

	$_tpl->set("have_res", $have_res);
	$_tpl->set('res_array',$aly_res);
	
	$res_log = get_log_aly_res($_user['alaid'],LIMIT_PAGE);
	$_tpl->set('log_array',$res_log);

	$_tpl->set('al_sub',$_sub);
	break;

case 'resally': /* donner des ressources à un allié */
	$_tpl->set('_limite_grenier', $_limite_grenier);
	$_tpl->set('liste_res', array_fill(1, get_conf('race_cfg', 'res_nb'), 0));

	/* prendre / déposer plusieurs */
	$res_nb = request('res_nb', 'array', 'post');

	// ressources du grenier allié
	$al2 = request("al2", "uint", "post",request("al2", "uint", "get"));
	if ($al2) {
		// rechercher le nom de l'alliance
		$ally2 = allyFactory::getAlly($al2);
		if(!$ally2) break;
		$_tpl->set('arr_al2',$ally2->getInfos());
		/* vérifier le pacte commercial valide */
		$pactes = new diplo(array('aid'=>$_user['alaid'], 'full'=>true));
		if ($pactes->exist_pacte($al2, DPL_TYPE_COM) or $pactes->exist_pacte($al2, DPL_TYPE_MC)) {
			/* ressources du grenier de l'allié */
			$res2_array = $ally2->getRessources();
		} else {
			$al2 = false;
			$nb = 0;
		}
	} else {
		$al2 = 0;
		$nb = 0;
	}
	$_tpl->set('al2',$al2);

	$aly_res = $ally->getRessources(); // ressources du grenier
	$nb_aly_mbr = $ally->al_nb_mbr;
	$res_limite = array(); /* si limite atteinte */
	$res_taxed = array();

	foreach($res_nb as $type => $nb){
		$nb *= -1; /* on retire du grenier */
		if(!get_conf("res", $type)) // une ressource valide
			$type = 0;

		if($nb && $type) {
			$res_ok = true;
			if(!isset($aly_res[$type])) $aly_res[$type] = 0;
			if(!isset($res2_array[$type])) $res2_array[$type] = 0;

			if($res_ok && $nb < 0) /* don à l'allié */
				if($aly_res[$type] < ($nb*-1)){ /* on n'a pas assez */
					$res_ok = false;
					$res_limite[$type] = $_limite_grenier[$type];
				}

			if ($res_ok) { /* don à l'allié, vérifier que son grenier n'est pas plein */
				if ($nb > 0)
					$res_ok = false;
				else {
					$nb_tax = -floor($nb*(1-(diplo::DPL_TAX / 100)));
					if($res2_array[$type] + $nb_tax > $_limite_grenier[$type]){
						$res_ok = false;
						$res_limite[$type] = $_limite_grenier[$type];
					}
				}
			}

			if($res_ok) {
				//message aux modos + aux co-admins si on retire plus que 1/nb_joueur_ally et si le retrait est > au seuil pillage
				if($type != GAME_RES_BOUF 
					&& abs($nb) > $aly_res[$type] * (2 / $nb_aly_mbr) && abs($nb) > ALL_SEUIL_PILLAGE)
				{
					$_tpl->set('mid', $_user['mid']);
					$_tpl->set('pseudo', $_user['pseudo']);
					$_tpl->set('typres', $type);
					$_tpl->set('alaid', $_user['alaid']);
					$_tpl->get_config("race/{$_user['race']}.config");
					$msg = nl2br($_tpl->get("modules/admin/msg/pillage_$_act.txt.tpl",1));
					$titre = $_tpl->get("modules/admin/msg/pillage.obj.tpl",1);
					send_to_all(MBR_WELC, $titre, $msg, array(GRP_GARDE, GRP_DEMI_DIEU));
				}

				$res_taxed[$type] = $nb_tax;
				$res_nb[$type] = (int) $nb;
				$aly_res[$type] += (int) $nb;
			}
			else
				unset($res_nb[$type]);

		} // if($nb and $type)
		else
			unset($res_nb[$type]);

	} // fin foreach $res_nb...

	/* maj des ressources */
	mod_aly_res($_user['alaid'], $ally2->al_mid, $res_nb);
	mod_aly_res($al2, $_user['mid'], $res_taxed);

	$_tpl->set('res_limit', $res_limite);
	$_tpl->set('res_array',$aly_res);
	$_tpl->set('res_ok',$res_nb);

	$res_log = get_log_aly_res($_user['alaid'],LIMIT_PAGE);
	$_tpl->set('log_array',$res_log);

	$_tpl->set('al_sub',$_sub);
	break;

case 'reslog': // historique du grenier
	$res_log = get_log_aly_res($_user['alaid'],2000); // (?) pas de pagination 
	$_tpl->set('log_array',$res_log);
	break;

case 'ressyn': // synthèse détaillée format tableau
	$res_log = get_log_aly_res($_user['alaid'],0,0, true);

	$nb_res = get_conf('race_cfg', 'res_nb');
	$row_res = array();
	$tcd = array();
	for($id = 1; $id <= $nb_res; $id++) $row_res[$id] = 0;
	foreach($res_log as $value) {
		if(!isset($tcd[$value['mbr_mid']])) {
			$tcd[$value['mbr_mid']]['mbr'] = $value;
			$tcd[$value['mbr_mid']]['res'] = $row_res;
		}
		$tcd[$value['mbr_mid']]['res'][$value['arlog_type']] = $value['total'];
	}

	$_tpl->set('tcd',$tcd);
	break;

case 'new': // créer une alliance
	
	$aly_res = get_res_done2($_user['mid'], array(GAME_RES_PRINC));
	$aly_res = $aly_res[0];
	
	$name = request("al_name", "string", "post");
	
	if($_user['aetat'] != ALL_ETAT_NULL)
		$_tpl->set('al_have_al', true);
	else if($_user['points'] < ALL_MIN_ADM_PTS)
		$_tpl->set('al_not_enought_pts',ALL_MIN_ADM_PTS);
	else if($aly_res[GAME_RES_PRINC] < ALL_CREATE_PRICE)
		$_tpl->set('al_not_enought_gold',true);
	else if(!strverif($name) || !$name)
		$_tpl->set('al_name_not_correct',true);
	else {
		$al_id = add_aly($_user['mid'], $name);
		exec("cp img/al_logo/0.png img/al_logo/$al_id.png");
		mod_res($_user['mid'], array(GAME_RES_PRINC => ALL_CREATE_PRICE), -1);
		add_aly_mbr($al_id, $_user['mid'], ALL_ETAT_CHEF);
		$_ses->update_aly();
		$_tpl->set('al_new',$al_id);
	}
	break;

case 'join': // demander à rejoindre une alliance

	if($_user['alaid'])
		$_tpl->set('al_have_al',true);
	else {
		$post_aid = request("al_aid", "uint", "post");
		$al_aid = $post_aid ? $post_aid : request("al_aid", "uint", "get");
		$al_ok = false;
		$ally = allyFactory::getAlly($al_aid);
		if($ally) {
			$al_race = $ally->getRaces();

			$_tpl->set('al_array', $ally->getInfos());
			$_tpl->set('al_stat', $al_race);
			$_tpl->set("al_aid", $al_aid);
			$_tpl->set("al_chef", $ally->getChef());
			
			if($ally->al_nb_mbr >= ALL_MAX or !$ally->al_open)
				/* Pas de place ou fermée */
				$_tpl->set('al_full',true);

			else if($_user['points'] < ALL_MIN_PTS) /* Pas assez de points */
				$_tpl->set('al_not_enought_pts',ALL_MIN_PTS);
			else {
				$have_res = get_res_done2($_user['mid'], array(GAME_RES_PRINC));
				$have_res = $have_res[0];
				$chef = $ally->getChef();

				if($have_res[GAME_RES_PRINC] < ALL_JOIN_PRICE) /* Pas assez d'or */
					$_tpl->set('al_not_enought_gold',ALL_JOIN_PRICE);
				else if($al_race[$_user['race']]+1 > $_races_aly[$chef['mbr_race']][$_user['race']])
					/* Trop de monde de cette race là */
					$_tpl->set('al_bad_race',true);
				else if(!$post_aid) // confirmer par formulaire
					$_tpl->set("al_join_price", ALL_JOIN_PRICE);
				else {
					require_once("lib/msg.lib.php");
			
					add_aly_mbr($al_aid, $_user['mid'], ALL_ETAT_DEM);
					mod_res($_user['mid'], array(GAME_RES_PRINC => ALL_JOIN_PRICE), -1);
					$_ses->update_aly();
					/* envoyer un msg au chef */
					$text = $_tpl->get('modules/alliances/msg/demande.tpl',1);
					$titre = $_tpl->get('modules/alliances/msg/titre.tpl',1);
					send_msg($_user['mid'], $ally->al_mid, $titre, parse($text));
					/* envoyer aussi au(x) recruteur(s) */
					$recruteurs = $ally->getMembersByEtat(ALL_ETAT_RECR);
					foreach($recruteurs as $mbr)
						send_msg($_user['mid'], $mbr['mbr_mid'], $titre, parse($text));
					$_tpl->set('al_join',true);
					$al_ok = true;
				}
			}
		} else /* Alliance inéxistante */
			$_tpl->set('al_bad_aid',true);

		$_tpl->set("al_ok", $al_ok);
	}
	break;

case 'part': // quitter une alliance
	if(!$_user['alaid'])
		$_tpl->set('al_no_al', true);
	else if(!request('ok', 'bool', 'post'))
		$_tpl->set('al_need_conf', true);
	else {
		$ally = allyFactory::getAlly($_user['alaid']);
		if($ally && $_user['mid'] == $ally->al_mid) /* le chef ne peut pas quitter */
			$_tpl->set('al_part', false);
		else {
			del_aly_mbr($_user['alaid'],$_user['mid']);
			edit_aly($_user['alaid'], array('nb_mbr' => -1));
			$_ses->update_aly();
			$_tpl->set('al_part', true);
		}
	}
	break;

case  'cancel': // annuler une demande de rejoindre une alliance
	
	if($_user['aetat'] == ALL_ETAT_DEM) {
		del_aly_mbr($_user['alaid'],$_user['mid']);
		$_tpl->set('al_cancel', true);
	} else
		$_tpl->set('al_cancel',false);
	break;

default: // liste des alliances créées
	$_tpl->set('module_tpl','modules/alliances/liste.tpl');
	
	$al_page=request("al_page", "uint", "get");
	$_tpl->set('al_page',$al_page);
	$al_nb = allyFactory::nb();
	$_tpl->set("al_nb",$al_nb);
	
	$current_i = $al_page - (LIMIT_NB_PAGE / 2);
	$current_i = round($current_i < 0 ? 0 : $current_i)*LIMIT_PAGE;
	$_tpl->set('current_i',$current_i);
	
	$limite_mysql = $al_page ? LIMIT_PAGE * $al_page : 0;
	
	$cond = array('limite2'=>$limite_mysql, 'limite1'=>LIMIT_PAGE, 'mini3' => true);
	
	$name = request("name", "string", "post", request("al_name", "string", "get"));
	if($name)
		$cond['name'] = $name;
	$_tpl->set("al_name", $name);
	
	$_tpl->set('al_array',allyFactory::getList($cond));
	break;
}
}
?>
