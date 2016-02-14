<?php

$dep_src = array("btc");
$log_dpl = "Diplomatie";

function glob_dpl() {
	global $_tpl, $_ally;

	// liste des pactes en attente
	$cond = array('etat'=>DPL_ETAT_ATT, 'jdeb'=>diplo::DUREE_PROBA);
	$arr_pactes = new diplo($cond);

	/* validation des pactes en attente, & paiement du prix */
	foreach($arr_pactes->result as $did => $pacte) {

		// vérifier que chaque alliance a assez de ressource dans le grenier
		if (!isset($_ally[$pacte['dpl_al1']])) {
			$al = get_aly($pacte['dpl_al1']);
			$_ally[$pacte['dpl_al1']]['al'] = $al[0];
			$_ally[$pacte['dpl_al1']]['grenier'] = get_aly_res_norm($pacte['dpl_al1']);
			$manque_res_al1 = array_compare($_ally[$pacte['dpl_al1']]['grenier'], diplo::$prix[$pacte['dpl_type']]);
		}
		if (!isset($_ally[$pacte['dpl_al2']])) {
			$al = get_aly($pacte['dpl_al2']);
			// si l'alliance n'existe plus?
			if(empty($al)) continue;
			$_ally[$pacte['dpl_al2']]['al'] = $al[0];
			$_ally[$pacte['dpl_al2']]['grenier'] = get_aly_res_norm($pacte['dpl_al2']);
			$manque_res_al2 = array_compare($_ally[$pacte['dpl_al2']]['grenier'], diplo::$prix[$pacte['dpl_type']]);
		}

		// décompter les 2 grenier du prix du pacte si OK
		// pour l'instant c'est un membre par défaut qui retire les ressources
		if (empty($manque_res_al1) and empty($manque_res_al2)) {
			foreach(diplo::$prix[$pacte['dpl_type']] as $res_type => $nb) {
				$_ally[$pacte['dpl_al1']]['grenier'][$res_type] -= $nb;
				add_aly_res($pacte['dpl_al1'], $_ally[$pacte['dpl_al2']]['al']['al_mid'], $res_type, -$nb);
				$_ally[$pacte['dpl_al2']]['grenier'][$res_type] -= $nb;
				add_aly_res($pacte['dpl_al2'], $_ally[$pacte['dpl_al1']]['al']['al_mid'], $res_type, -$nb);
			}
			// MAJ état pacte
			$cond = array('etat'=>DPL_ETAT_OK, 'deb'=>'now', 'did'=>$did);
			diplo::edit($cond);
		} else {
			$_tpl->set('pacte',$pacte);
			// si manque de ressource dans l'1 des 2 greniers : msg dans la shoot!
			if (!empty($manque_res_al1))
			{
				$_tpl->set('mq_res',$manque_res_al1);
				$text = $_tpl->get("modules/diplo/msg/no_res.tpl",1);
				add_aly_msg($pacte['dpl_al1'], $text, $_ally[$pacte['dpl_al2']]['al']['al_mid']);
			}
			if (!empty($manque_res_al2))
			{
				$_tpl->set('mq_res',$manque_res_al2);
				$text = $_tpl->get("modules/diplo/msg/no_res.tpl",1);
				add_aly_msg($pacte['dpl_al2'], $text, $_ally[$pacte['dpl_al1']]['al']['al_mid']);
			}
		}		
	}
}

?>
