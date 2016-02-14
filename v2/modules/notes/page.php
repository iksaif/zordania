<?php
if(!defined("_INDEX_")){ exit; }
if(!can_d(DROIT_PLAY)) { 
	$_tpl->set("need_to_be_loged",true); 
} else {
$_tpl->set('module_tpl','modules/notes/notes.tpl');

require_once('lib/nte.lib.php');

require_once('lib/parser.lib.php');
$smileys_base = getSmileysBase();
$smileys_more = getSmileysMore($smileys_base);
$_tpl->set("smileys_base", $smileys_base);
$_tpl->set("smileys_more", $smileys_more);

$nid = request("nid", "uint", "get");

$_tpl->set('nte_act',$_act);

switch($_act) {
case "del":
	//Effacer
	if(del_nte($_user['mid'], $nid))
		$_tpl->set('nte_ok',true);
	else
		$_tpl->set('nte_bad_nid',true);

	break;
case "edit":
	//Editer ou ajouter
	$titre = request("pst_titre", "string", "post");
	$texte = request("pst_msg", "string", "post");
	$import = request("nte_import", "uint", "post");

	if($nid) { // edit
		$_tpl->set('nte_nid',$nid);
		$nte_array = get_nte($_user['mid'], $nid);
		if($nte_array) {
			$nte_array = $nte_array[0];
			$_tpl->set('nte_titre',$nte_array['nte_titre']);
			$_tpl->set('nte_texte',unparse($nte_array['nte_texte']));
			$_tpl->set('nte_import',$nte_array['nte_import']);
		} else
			$_tpl->set('nte_bad_nid',true);

		if($titre && $texte)
			$_tpl->set('nte_ok',edit_nte($_user['mid'], $nid, $titre, parse($texte), $import));

	}else{ // new
		$_tpl->set('nte_nid',0);

		if($titre && $texte)
			$_tpl->set('nte_ok',add_nte($_user['mid'], $titre, parse($texte), $import));
		else {
			$_tpl->set('nte_titre',htmlspecialchars($titre));
			$_tpl->set('nte_texte',htmlspecialchars($texte));
			$_tpl->set('nte_import',$import);	
		}	

		if($titre || $texte || $import) {
			$_tpl->set('nte_titre',$titre);
			$_tpl->set('nte_texte',$texte);
			$_tpl->set('nte_import',$import);	
		}

	}
	break;
case "view":
	//Voir
	if($nid) {
		$nte_array = get_nte($_user['mid'], $nid);
		if($nte_array)
			$nte_array = $nte_array[0];
		$_tpl->set('nte_array',$nte_array);
	} else
		$_tpl->set('nte_bad_nid',true);

	break;
default:
	$nte_array = get_nte($_user['mid']);
	$_tpl->set('nte_array',$nte_array);
	break;
}
}
?>
