<?php
if(!defined("_INDEX_") or !can_d(DROIT_SDG)){ exit; }

require_once("lib/sdg.lib.php");

require_once('lib/parser.lib.php');
$smileys_base = getSmileysBase();
$smileys_more = getSmileysMore($smileys_base);
$_tpl->set("smileys_base", $smileys_base);
$_tpl->set("smileys_more", $smileys_more);

$_tpl->set("module_tpl","modules/sdg/admin.tpl");

switch($_act) {
case 'new':
	$_tpl->set('adm_act','new');
	
	$nb = request("sdg_nb", "uint", "post");
	
	if($nb) {
		$_tpl->set('sdg_nb',$nb);
		
		$sdg_id = request("sdg_id", "uint", "post");
		$texte = parse(request("sdg_texte", "string", "post"));
		$sdg_request = request("sdg_rep", array('string'), "post");
		
		$rep = array(); $err=0;

		if($sdg_id)// sondage existant (modif)
			$sdg_rep = get_sdg_result($sdg_id);
		for($a=0;$a<$nb;$a++) {
			if($sdg_id){// modifier le sondage
				$rep[$a]['srep_texte'] =  $sdg_request[$sdg_rep[$a]['srep_id']];
				if(empty($rep[$a]['srep_texte']))
					$err++;
				$rep[$a]['srep_id'] = $sdg_rep[$a]['srep_id'];
			}else{// nouveau sondage
				if(!empty($sdg_request[$a]))
					$rep[$a]['srep_texte'] =  $sdg_request[$a];
				else
					{$rep[$a]['srep_texte']='';$err++;}
				$rep[$a]['srep_id'] = $a;
			}
		}
		
		if(!$texte  || $err!=0) {
			$_tpl->set('sdg_texte',$texte);
			$_tpl->set("sdg_rep",$rep);
		} else {
			if(!$sdg_id){// ajout du sondage
				$sid = add_sdg($texte);
				foreach($rep as $value)
					$rep2[]=parse($value['srep_texte']);
				add_rep_sdg($sid, $rep2);
				$_tpl->set("sdg_ok",true);
			}else{// modification du sondage
				edit_sdg($sdg_id, $texte);
				foreach($rep as $value)
					edit_rep_sdg($value['srep_id'], parse($value['srep_texte']));
				$_tpl->set("mod_sdg_ok",true);
			}
		}
	}
	break;
case 'mod':
	$sdg_id = request("sdg_id", "uint", "get");
	$sdg_array = get_sdg($sdg_id, $_user['mid']);
	if($sdg_array) {
		$_tpl->set('sdg_id', $sdg_id);
		$_tpl->set("sdg_texte",unparse($sdg_array[0]['sdg_texte']));
		$sdg_rep = get_sdg_result($sdg_id);
		foreach($sdg_rep as $key => $rep)
			$sdg_rep[$key]['srep_texte']=unparse($rep['srep_texte']);
		$_tpl->set("sdg_rep",$sdg_rep);
		$_tpl->set('sdg_nb', count($sdg_rep));
	} else
		$_tpl->set("sdg_bad_sid",true);

	$_tpl->set('adm_act','mod');
	break;
case 'del':
	$_tpl->set('adm_act','del');
	
	$sdg_id = request("sdg_id", "uint", "get");
	$valid = request("valid", "string", "get");
	
	if($sdg_id && $valid) {
			del_sdg($sdg_id);
			$_tpl->set("sdg_ok",true);
	}

	$_tpl->set('sdg_id',$sdg_id);
	break;
case 'view':
default:
	$_tpl->set('adm_act','view');
	
	$liste_array = get_sdg_gen();
	// pour la liste, tronquer le texte à la 1ere ligne
	foreach($liste_array as $key => $sdg){
		$txt=explode('<br />', $sdg['sdg_texte'], 2);
		$liste_array[$key]['sdg_texte']=$txt[0];
	}
	$_tpl->set('liste_array',$liste_array);

	break;
}

?>
