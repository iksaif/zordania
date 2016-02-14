<?php
if(!defined("_INDEX_")){ exit; }
if(!can_d(DROIT_PLAY)) {
	$_tpl->set("need_to_be_loged",true);
} else {

require_once ('lib/diplo.class.php');
require_once ('lib/diplo.lib.php');
require_once ('lib/alliances.lib.php');
require_once ('lib/member.lib.php');
require_once ('lib/msg.lib.php');
require_once ('lib/parser.lib.php');

$_tpl->set("module_tpl","modules/diplo/diplo.tpl");
$_tpl->set("act",$_act);
$_tpl->set("sub",$_sub);
// constantes
$_tpl->set('max_pactes', diplo::$max);
$_tpl->set('prix_pactes', diplo::$prix);
// droit de diplomate ?
$droits = array();
if($_user['aetat'] != ALL_ETAT_NULL and $_user['aetat'] != ALL_ETAT_DEM){
	$ally = allyFactory::getAlly($_user['alaid']);
	$al_array = $ally->getInfos();
	if ($ally->isAccesOk($_user['mid'],'diplo'))
		$droits['diplo'] = true;
	$_tpl->set('droits', $droits);
}
else
	$_user['alaid'] = 0;

switch ($_act) {
case 'add': // al1 propose l'alliance à al2
	// vérifier que c'est bien le chef de l'ally
	if(!$_user['alaid'])
		$_tpl->set('err','no_aid');
	else if(!isset($droits['diplo'])) // qu'il est autorisé
		$_tpl->set('err','no_chef');
	else {
		$al2 = request('al2', 'uint', 'get');
		$dpl_add = request('dpl_add', 'string', 'post');
		$type = request('type', 'uint', 'post');
		if($_user['alaid']==$al2) {
			$_tpl->set('err','meme_al');
			break;
		}

		// pactes de mon alliance
		$al1_pactes = new diplo(array('aid'=>$_user['alaid']));
		$_tpl->set('al1_pactes', $al1_pactes->count());

		if ($al2) {
			// rechercher le nom de l'alliance
			$ally = allyFactory::getAlly($al2);
			if ($ally) $al_name = $ally->al_name;
			else $al2 = 0;
		} else {
			$al_name = request('ally','string','post');
			if ($al_name)
				$allies = allyFactory::select(array('name' => $al_name));
			if (!empty($allies)) {
				$ally = array_shift($allies);
				$al2 = $ally->al_aid;
			}
		}

		if ($al2) {
			if ($al1_pactes->exist_pacte($al2)) { // déjà un pacte avec cette alliance
				$_tpl->set('err','exist');
			} else {
				$al2_pactes = new diplo(array('aid'=>$al2));
				$_tpl->set('al2',$ally->getInfos());
				$_tpl->set('al2_pactes', $al2_pactes->count());
				$_tpl->set('al_diplo_descr',$ally->al_diplo);
	
				if ($dpl_add && $type) {
					// vérifier que mon alliance n'a pas déjà atteint son quota de pactes
					if ($al1_pactes->count($type) >= diplo::$max[$type])
						$_tpl->set('err','nb_pactes ('.$al1_pactes->count($type).')');
					else {
						// si ok ajouter le pacte : dpl_al2 propose le pacte à dpl_al1=al2
						$result = $al2_pactes->proposer($_user['alaid'], $type);
						$_tpl->set('dpl_add',$result);
						if ($result) {
							// envoyer un mail au chef de l'ally
							$text = $_tpl->get('modules/diplo/msg/propose.tpl',1);
							$titre = $_tpl->get('modules/diplo/msg/titre.tpl',1);
							send_msg($_user['mid'], $ally->al_mid, $titre, parse($text));
						} else
							$_tpl->set('err',$al2_pactes->err);
					}
				}
			}
		}
		$_tpl->set("ally",$ally->al_name);
	}
break;

case 'ok': // accepter un pacte
case 'no': // refuser un pacte
case 'del': // rompre un pacte / annuler une demande
	// vérifier que c'est bien le chef de l'ally
	if(!$_user['alaid'])
		$_tpl->set('err','no_aid');
	else if(!isset($droits['diplo']))
		$_tpl->set('err','no_chef');
	else {
		$did = request('did','uint','get');
		if ($did) {
			$pacte = new diplo(array('aid'=>$_user['alaid'], 'did'=>$did, 'full' => true));
			$old_etat = $pacte->dpl_etat;
			if ($_act == 'ok') $result = $pacte->accepter();
			if ($_act == 'no') $result = $pacte->refuser();
			if ($_act == 'del') $result = $pacte->rompre();
			$_tpl->set('act_ok',$result);
			if ($result) {
				$_tpl->set('pacte',$pacte->result[$did]);
				// envoyer un mail au chef de l'ally
				$_tpl->get_config('config/config.config',1);
				// si j'annule un pacte en cours de proposition
				if ($pacte->auteur() == $_user['alaid'] and $_act == 'no' and $old_etat == DPL_ETAT_PROP) {
					$text = $_tpl->get("modules/diplo/msg/cancel.tpl",1); // j'annule ma prop
				} else {
					$text = $_tpl->get("modules/diplo/msg/$_act.tpl",1); // je décline la prop de l'autre (ou ok ou del)
				}
				$mid = $pacte->result[$did]['al_mid'];
				$titre = $_tpl->get('modules/diplo/msg/titre.tpl',1);
				send_msg($_user['mid'], $pacte->result[$did]['al_mid'], $titre, parse($text));
			} else
				$_tpl->set('err',$pacte->err);
		} else
			$_tpl->set('err',true);
	}

case 'my':
	if(!$_user['alaid']){
		$_tpl->set('err','no_aid');
		break;
	}
	// sinon continuer ...
case 'histo':
default:
	// diplo de l'alliance
	$al1 = request('al1', 'uint', 'get');
	if (!$al1) $al1 = $_user['alaid'];
	if ($al1) {
		$mespactes = new diplo(array('aid'=>$al1, 'full' => true));
		$_tpl->set("mespactes",$mespactes->result);
		$_tpl->set('al1',$al1);
		// rechercher le nom de l'alliance
		$ally = allyFactory::getAlly($al1);

		$_tpl->set('al_name',$ally->al_name);
		$_tpl->set('al_diplo_descr',$ally->al_diplo);
	}
break;

		//Sub = post => post un message sur la shootbox
case 'shoot':
		$did = request('did','uint','get');
		$pacte = new diplo(array('aid'=>$_user['alaid'], 'did'=>$did, 'full' => true));
		$_tpl->set('pacte',$pacte->result[$did]);
		$al1 = request('al1', 'uint', 'get');
		$mespactes = new diplo(array('aid'=>$al1, 'full' => true));
		$_tpl->set("mespactes",$mespactes->result);
		$_tpl->set('al1',$al1);
		$smileys_base = getSmileysBase();
		$smileys_more = getSmileysMore($smileys_base);
		$_tpl->set("smileys_base", $smileys_base);
		$_tpl->set("smileys_more", $smileys_more);
		$_tpl->set('chef',$ally->getMembers($ally->al_mid));
		$chef = ($ally->al_mid == $_user['mid']);
		$name = request("al_name", "string", "post");
		$_tpl->set("al_name", $name);
		$_tpl->set('al_diplo_descr',$ally->al_diplo);
		if($_sub == 'post') {
			$msg = request('pst_msg', 'string', 'post');
			if($msg)
				$_tpl->set('dpl_msg_post',add_diplo_msg($did,parse($msg),$_user['mid']));
		} else if($_sub == "del") {
			$msgid = request('msgid', 'uint', 'get');
			if($msgid)
				$_tpl->set('dpl_msg_del',del_diplo_msg($did,$msgid,$_user['mid'],$chef));
		}
		
		$_tpl->set('dpl_admin',$chef);
	
		$dpl_page = request('dpl_page', 'uint', 'get');
		$dpl_nb = count_diplo_msg($_user['alaid']);
		$_tpl->set("dpl_nb",$dpl_nb);
		
		$current_i = $dpl_page - LIMIT_NB_PAGE/2;
		$current_i = 0+round($current_i < 0 ? 0 : $current_i)*LIMIT_PAGE;
	
		$_tpl->set('current_i',$current_i);
		$_tpl->set('dpl_page',$dpl_page);

		if($dpl_page)
			$limite_mysql = LIMIT_PAGE * $dpl_page;
		else
			$limite_mysql = 0;

		$dpl_shoot_array = get_diplo_msg($did, LIMIT_PAGE, $limite_mysql);
		$_tpl->set('dpl_shoot_array',$dpl_shoot_array);

		$dpl_mbr = $ally->getMembers();
		/*foreach($dpl_mbr as $key => $value)
			$dpl_mbr[$key]['mbr_dst'] = calc_dst($_user['map_x'], $_user['map_y'], $value['map_x'], $value['map_y']);*/
	
		$_tpl->set('dpl_mbr',$dpl_mbr);
		$_tpl->set('dpl_key',calc_key($_file, $_user['login']));
	

	break;

} /* fin switch */
}

?>
