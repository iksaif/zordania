<?php
if(!defined("_INDEX_")){ exit; }
if(!can_d(DROIT_SITE))
	$_tpl->set("need_to_be_loged",true);
else if(!can_d(DROIT_MSG))
	$_tpl->set("cant_view_this",true);
else {

require_once('lib/msg.lib.php');
require_once('lib/member.lib.php');

require_once('lib/parser.lib.php');
$smileys_base = getSmileysBase();
$smileys_more = getSmileysMore($smileys_base);
$_tpl->set("smileys_base", $smileys_base);
$_tpl->set("smileys_more", $smileys_more);

$_tpl->set('module_tpl','modules/msg/msg.tpl');
$_tpl->set('msg_act',$_act);

switch($_act) {
/* Liste des messages envoyés */
case "env":
	$msg_array = get_msg_env($_user['mid']);
	$_tpl->set('msg_array',$msg_array);
	break;
/* Lecture */
case "read":
	$mrec_id = request("mrec_id", "uint", "get");
	if($mrec_id) {
		$msg_infos = get_msg_rec($_user['mid'], $mrec_id);
		
		if(!$msg_infos)
			$_tpl->set("msg_bad_id",true);
		else {
			if(!$msg_infos[0]['mrec_readed'])
				mark_msg_as_readed($_user['mid'], $mrec_id);
			
			$_tpl->set('msg_infos',$msg_infos[0]);
		}
	} else
		$_tpl->set("msg_bad_id",true);
	break;
	
/* Lecture d'un message envoyé */
case "read_env":
	$menv_id = request("menv_id", "uint", "get");
	if($menv_id) {
		$msg_infos = get_msg_env($_user['mid'], $menv_id);
		
		if(!$msg_infos)
			$_tpl->set("msg_bad_id",true);
		else
			$_tpl->set('msg_infos',$msg_infos[0]);
	} else
		$_tpl->set("msg_bad_id",true);
	break;
	
/* Suppression */
case "del_rec":
case "del_env":
	$conf = request("msg_conf", "bool", "post");
	$msg_id = request("msg_id", "array", "post");
	if (empty($msg_id))
		$msg_id = request("msg_id", "uint", "get");
	
	$_tpl->set("msg_id",$msg_id);
	if(!$conf)
		$_tpl->set("msg_need_conf", true);
	elseif ($_act == 'del_rec')
		$_tpl->set("msg_del", del_msg_rec($_user['mid'], $msg_id));
	else // del_env
		$_tpl->set("msg_del", del_msg_env($_user['mid'], $msg_id));
	break;

/* Nouveau */
case "new":
	$midto = request("mbr_mid", "uint", "get");
	$mrec_id = request("mrec_id", "uint", "get");
	
	$_tpl->set('msg_texte',"");
	$_tpl->set('msg_titre',"");
	$_tpl->set('msg_pseudo',"");

	if($mrec_id) {
		$msg_infos = get_msg_rec($_user['mid'], $mrec_id);
		
		if($msg_infos) {
			$msg_infos = $msg_infos[0];
			if(!$msg_infos['mrec_readed'])
				mark_msg_as_readed($_user['mid'], $mrec_id);

			$texte = "\n\n\n\n";
			$texte .= "[b]".$msg_infos['mbr_pseudo']." @ ".$msg_infos['mrec_date_formated']."[/b]\n";
			$texte .="| ";
			$texte .= str_replace("\n","\n| ",unparse($msg_infos['mrec_texte']));
			$titre = str_replace("Re: Re: ","Re: ","Re: ".$msg_infos['mrec_titre']);	
		
			$_tpl->set('msg_texte',$texte);
			$_tpl->set('msg_titre',$titre);
			$_tpl->set('msg_pseudo',$msg_infos['mbr_pseudo']);
		}
	} else if($midto) {
		$mbr_infos = get_mbr_by_mid_lite($midto);
		
		if($mbr_infos)
			$_tpl->set('msg_pseudo',$mbr_infos[0]['mbr_pseudo']);
	}
	break;
	
/* Send */
case "send":
	$pseudo = request("msg_pseudo", "string", "post");
	$texte = request("pst_msg", "string", "post");
	$titre = request("pst_titre", "string", "post");
	
	// prévisualisation ajax
	if($_display == "ajax"){
		//on vérifie que le message n'est pas vide
		if ($texte && $titre){
			$post = array();
			$post['mrec_titre'] = $titre;
			$post['mrec_from'] = $_user['mid'];
			$post['mbr_pseudo'] = $_user['pseudo'];
			$post['mbr_gid'] = $_user['groupe'];
			$post['mrec_date_formated'] = date('j-n-Y');
			$post['mrec_texte'] = parse($texte);
			$post['mbr_sign'] = $_user['sign'];
			$_tpl->set('msg_infos', $post);
		}
		$_tpl->set("module_tpl","modules/msg/read.tpl");
		break;
	} // fin ajax

	if(!$pseudo || !$texte || !$titre) {
		$_tpl->set('msg_act','new');
		$_tpl->set('msg_pseudo', htmlspecialchars($pseudo));
		$_tpl->set('msg_texte', htmlspecialchars($texte));
		$_tpl->set('msg_titre', htmlspecialchars($titre));
		$_tpl->set('msg_pas_tout',true);	
		if($_display == "ajax")
			$_tpl->set("module_tpl","modules/msg/read.tpl");
	} else {
		$pseudos = explode( ";",$pseudo);

		if(count($pseudos) > 1 && !can_d(DROIT_MMSG))
			$_tpl->set('msg_max_mmsg',1);
		else if(count($pseudos) > MSG_MAX_MMSG)
			$_tpl->set('msg_max_mmsg',MSG_MAX_MMSG);
		else {
			$result = array();
			foreach($pseudos as $pseudo) {
				$pseudo = trim($pseudo);
				
				if(isset($result[$pseudo])) /* Pas faire deux fois le même */
					continue;
					
				$mbr_infos = get_mbr_gen(array('pseudo' => $pseudo));
				if(!$mbr_infos)
					$result[$pseudo] = false;
				else {
					$mid2 = $mbr_infos[0]['mbr_mid'];
					
					send_msg($_user['mid'], $mid2, $titre, parse($texte), true);
					$result[$pseudo] = $mbr_infos[0];
					
					$_histo->add($mid2, $_user['mid'], HISTO_MSG_NEW);
				}
				$_tpl->set("msg_result", $result);
			}
		}
	}
	break;

// signalement des messages
case "sign";
	$msgid = request("msgid", "uint", "get");
	$com = '<em>'.$_user['pseudo'] .' le '.date("d/m/Y H:i:s")."</em><br/>\n".parse(request("com", "string", "post"));
	if(isset($msgid) && !is_surv($msgid) && isset($com)){
		add_sign($msgid,$com);
		/*  infos admin en cache */
		$admin_cache->msg_report++;
		$admin_cache->force_save();
		$_tpl->set("no_msg",true);}
	else {
		$_tpl->set("no_msg",false);}
	break;

case "fsign";
	$msgid = request("msgid", "uint", "get");
	if(isset($msgid) && !is_surv($msgid)){
		$_tpl->set('msgid',$msgid);}
	else {
		$_tpl->set("no_msg",false);}
	break;

case "send_massif"; // spam = message à un groupe de joueurs
	$texte = request("pst_msg", "string", "post");
	$titre = request("pst_titre", "string", "post");
	$groupes = request("groupes", "array", "post");

	$grp = array();
	foreach($groupes as $key => $value) $grp[] = $key;
	/* filtre : seul les admin & co peuvent envoyer Ã  tout le monde */
	$forbidden = !can_d(DROIT_MMSG);

	if(!$texte || !$titre || $forbidden) {
		$_tpl->set('msg_act','global');
		$_tpl->set('msg_texte', htmlspecialchars($texte));
		$_tpl->set('msg_titre', htmlspecialchars($titre));
		$_tpl->set('msg_pas_tout',true);
		$_tpl->set('forbidden',$forbidden);
	}else
		send_to_all($_user['mid'], $titre, parse($texte), $grp);
	break;

default:
	$msg_array = get_msg_rec($_user['mid']);
	$_tpl->set('msg_array',$msg_array);
	break;
}
}

?>
