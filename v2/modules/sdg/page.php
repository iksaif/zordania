<?php
if(!defined("_INDEX_")){ exit; }
if(!can_d(DROIT_PLAY))
	$_tpl->set("need_to_be_loged",true);
else if(!can_d(DROIT_PLAY))
	$_tpl->set("cant_view_this", true);
else {
	$_tpl->set('module_tpl','modules/sdg/sdg.tpl');
	
	require_once('lib/sdg.lib.php');
	require_once('lib/parser.lib.php');
	
	$sdg_id = request("sdg_id", "uint", "get");

	if($sdg_id) {
		$sdg_array = get_sdg($sdg_id, $_user['mid']);
		if($sdg_array) {
			$sdg_array = $sdg_array[0];

			if(get_vte_nb_by_mid($sdg_id,$_user['mid']))
				$can_vote = false;
			else
				$can_vote = true;
			
			$vote = request("vote", "uint", "post");
			
			if($can_vote && $vote)
			{
				vte_sdg($sdg_id, $_user['mid'], $vote);
				$_tpl->set('sdg_ok',true);
				$can_vote = false;
				$sdg_array['sdg_rep_nb']++;
			}
			
			$_tpl->set("sdg_array",$sdg_array);
			$_tpl->set("sdg_result",get_sdg_result($sdg_id));
			$_tpl->set("can_vote", $can_vote);
			$_tpl->set('adm_sdg', can_d(DROIT_SDG));
		} else
			$_tpl->set("sdg_bad_sid",true);
		
	} else {
		$liste_array = get_sdg_gen(array('mid' => $_user['mid']));
		// pour la liste, tronquer le texte à la 1ere ligne
		foreach($liste_array as $key => $sdg){
			$txt=explode('<br />', $sdg['sdg_texte'], 2);
			$liste_array[$key]['sdg_texte']=$txt[0];
		}
		$_tpl->set('liste_array',$liste_array);
	}
}
?>
