<?php

//Verifications
if(!defined("_INDEX_")){ exit; }
if(!can_d(DROIT_PLAY))
	$_tpl->set("need_to_be_loged",true); 
else
{
require_once("lib/map.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/res.lib.php");
require_once("lib/member.lib.php");
require_once("lib/war.lib.php");
require_once("lib/btc.lib.php");
require_once("lib/trn.lib.php");
require_once("lib/alliances.lib.php");
require_once("lib/heros.lib.php");

$_tpl->set('module_tpl', 'modules/war/war.tpl');

$_tpl->set("war_act", $_act);
$_tpl->set("war_sub", $_sub);

switch($_act) {
case 'histo':
	$aid = request('aid', 'uint', 'get');
	if(!$_sub || $_sub == "def") {
		$_sub = "def";
		$cond['type'][] = ATQ_TYPE_DEF;
	} else {
		$_sub = "atq";
		$cond['type'][] = ATQ_TYPE_ATQ;
	}
	$_tpl->set("war_sub", $_sub);

	// prévisualisation ajax
	if($_display == "ajax" && $aid) {
		$cond['aid'] = $aid;
		$_tpl->set('module_tpl', 'modules/war/bbcodelog.tpl');
		$atq_array= get_atq_gen( $cond);
		if (isset($atq_array[0]))
			$_tpl->set('value',$atq_array[0]);
	} else if ($aid && SITE_DEBUG) {
		$cond['aid'] = $aid;
		$atq_array= get_atq_gen( $cond);
		$_tpl->set('atq_array',$atq_array);		
		$_tpl->set("atq_nb", 0);
		$_debugvars['bilan'] = $atq_array;

		$cond = array('mid2' => $atq_array[0]['atq_mid1'], 'last' => true, 'type' => array(ATQ_TYPE_ATQ));
		$nbatq = get_atq_vrai($atq_array[0]['atq_mid2'], $cond);
		$_tpl->set("atq_vrai", $nbatq);
	} else {
		$war_page= request("war_page", "uint", "get");
		$war_nb = get_atq_nb($_user['mid'], $cond);
		$limite_page = LIMIT_PAGE;
		$nombre_page = $war_nb / $limite_page;
		$nombre_total = ceil($nombre_page);
		$nombre = $nombre_total - 1;

		if($war_page)
			$limite_mysql = $limite_page * $war_page;
		else
			$limite_mysql = 0;

		$cond['limite1']  = $limite_mysql;
		$cond['limite2'] =  $limite_page;

		$_tpl->set('limite_page', $limite_page);
		$_tpl->set("atq_nb", $war_nb);
		$_tpl->set('war_page', $war_page);
		$atq_array= get_atq($_user['mid'] , $cond);
		$_tpl->set('atq_array',$atq_array);
	}
	break;
case 'make_atq':
	// lancer l'attaque: url/war-make_atq.html?lid1=$lid1
	$lid1 = request("lid1", "uint", "get");

	// on récupère les infos sur la légion attaquante, principalement la case
	$leg_1 = new legion($lid1);
	if (!$leg_1->mid) {
		$_tpl->set("atq_no_leg",true);
		break;
	}

	$mbr_def_array = get_mbr_gen(array('mapcid'=>$leg_1->cid, 'full'=>true)); /* le défenseur principal */
	if (!isset($mbr_def_array[0]['mbr_mid'])) {
		$_tpl->set("atq_no_mbr",true);
		break;
	}

	/* les pactes de l'attaquant */
	$pactes_atq = new diplo(array('aid' => $_user['alaid']));
	$pactes_atq_array = $pactes_atq->actuels(); // les pactes actifs en tableau
	/* gestion de qui qu'on peut attaquer ou pas, atq vs def principal */
	$mbr_def_array = can_atq_lite($mbr_def_array, $_user['pts_arm'], $_user['mid'], $_user['groupe'], $_user['alaid'], $pactes_atq_array); 
	$mbr_def_array = $mbr_def_array[0];
	$mid_def = $mbr_def_array['mbr_mid'];

	$cond = array('cid'=>$mbr_def_array['mbr_mapcid'], 
		'etat' => array(LEG_ETAT_VLG, LEG_ETAT_BTC, LEG_ETAT_GRN, LEG_ETAT_POS, LEG_ETAT_ALL, LEG_ETAT_DPL)); 
	// toutes les légions sur place
	$legions = new legions($cond, true, true);

	/* sa légion est bien prête à attaquer */
	if($legions->legs[$lid1]->mid != $_user['mid']) {
		$_tpl->set("atq_bad_leg1", true);
		break;
	} 
	if ($legions->legs[$lid1]->etat != LEG_ETAT_POS) {
		$_tpl->set("atq_bad_etat", true);
		break;
	}
	
	/* Peut attaquer */
	if(!$mbr_def_array['can_atq']) {
		$_tpl->set("atq_cant", true);
		break;
	}

	/* verif nombre d'attaques */
	$cond = array('mid2' => $mid_def, 'last' => true, 'type' => array(ATQ_TYPE_ATQ));
	$nbatq = get_atq_nb($_user['mid'], $cond);
	
	if ($nbatq >= ATQ_MAX_NB24H)
	{
		$_tpl->set("atq_max_atq", true);
		break;
	}

	/* selection unités de la legion attaquante */
	if($legions->legs[$lid1]->vide()) {
		$_tpl->set("atq_leg_empty", true);
		break;
	}

	/* les alliés de $mid_def en défense */
	$mbr_aly2 = array();
	/* les pactes du défenseur */
	$pactes_def = new diplo(array('aid' => $mbr_def_array['ambr_aid']));
	$pactes_def_array = $pactes_def->actuels(); // les pactes actifs en tableau
	if ($mbr_def_array['ambr_aid'] != 0) {
		/* liste des membres présents */
		$mbr_all_mid = array();
		foreach($legions->legs as $lid => $leg)
			if (!isset($mbr_all_mid[$leg->mid]))
				$mbr_all_mid[$leg->mid] = $leg->mid;
		$mbr_all_array = get_mbr_gen(array('mid'=>$mbr_all_mid));
		$mbr_all_array = index_array($mbr_all_array, 'mbr_mid'); // indexer sur le mid

		/* on peut maintenant vérifier pour chaque membre s'il a un pacte avec le défenseur (et l'attaquant?) */
		foreach($mbr_all_array as $mid => $mbr) {

			if($mbr['ambr_aid'] == $mbr_def_array['ambr_aid']) /* ally du défenseur */
				$mbr_aly2[$mbr['mbr_mid']] = $mbr['mbr_mid'];
			else {
				$pacte = $pactes_def->exist_pacte($mbr['ambr_aid']); // renvoie le type de pacte si existe

				if($pacte !== false and ($pacte == DPL_TYPE_MIL or $pacte == DPL_TYPE_MC))
					$mbr_aly2[$mid] = $mid; // l'ajouter en tant que membre allié
			}
		}
	} else /* sans alliance on n'a pas d'alliés */
		$mbr_aly2[$mid_def] = $mid_def;

	/* pas possible d'attaquer son allié */
	if(isset($mbr_aly2[$_user['mid']])) {
		$_tpl->set("atq_aly", true);
		break;
	}

	/* On recherche les légions du (des) défenseur(s) pouvant défendre : 'def' */
	/* 'autre' = autres légions présentes sauf attaquant ni leg bâtiment */
	$legs = array('def' => array(), 'autre' => array(), 'combat' => array());
	$ordre = 1; $ratio_def = array(); // ordre d'arrivée des défenseurs & ratio
	$bonus_btc = 1; // bonus solidité des bâtiments
	foreach($legions->legs as $lid => $leg){
		if ($lid == $lid1)  // l'attaquant
			$legs['combat'][] = $lid;
		else if ($leg->infos['mbr_etat'] == MBR_ETAT_OK && in_array($leg->mid, $mbr_aly2) && $leg->etat != LEG_ETAT_BTC
				&& (!$leg->vide() || $leg->etat == LEG_ETAT_VLG) ) {
		/* membre pas en veille & défenseur + ses alliés & (légion non vide OU leg village) SAUF legion batiment */

			// ordre d'arrivée pour les défenseurs alliés :
			if ($leg->mid != $mid_def) {
				if (isset($cst_ratio_def[$ordre])) {
					$ratio_def[$lid] = $cst_ratio_def[$ordre];
					$ordre++;
				} else
					$ratio_def[$lid] = 0; // A partir du N défenseur, les légions ne participent pas
				/* compétence défense groupée : bonus supplémentaire défense groupée sur l'allié */
				if ($leg->comp == CP_COLLABORATION) {
					$cp = get_comp( $leg->comp, $leg->race);
					$ratio_def[$lid] += $cp['bonus'] / 100;
				}
				if ($ratio_def[$lid] > 0) {
					$legs['def'][] = $lid;
					$legs['combat'][] = $lid;
				} else // trop de défenseurs, légion écartée
					$legs['autre'][] = $lid;
			} else {
				/* vérifier la compétence protection divine : attaque impossible */
				if ($leg->comp == CP_INVULNERABILITE) {
					$_tpl->set("atq_cp_protect", true);
					break 2; // break foreach+switch
				}
				$ratio_def[$lid] = $cst_ratio_def[0];
				$legs['def'][] = $lid;
				$legs['combat'][] = $lid;
			}
		} else if ($leg->etat != LEG_ETAT_BTC && $leg->etat != LEG_ETAT_VLG) 
			$legs['autre'][] = $lid;
	}

	/* Tout est bon, let's go */
	//mettre l'état des légions en défense dans $etats_def pour pouvoir le restaurer après la bataille
	$etats_defs = array();
	foreach ($legs['def'] as $lid) {
		$etats_defs[$lid] = $legions->legs[$lid]->etat;
	}
	
	$new = array('etat' => LEG_ETAT_ATQ);
	/* mettre toutes les legions en presence en etat ATQ */

	foreach ($legs['combat'] as $lid)
		edit_leg($legions->legs[$lid]->mid, $lid, $new);
	
	/* structure du tableau $bilan :

	[att] = legion (table leg+heros)
	[att][vie_leg]
	[att][comp] si compétence activée
	[att][comp][bonus]
	[att][comp][res] = résultat (valeur ou array selon la comp)
	[att][leg][i = type] = nb
	[att][pertes][unt] (idem que 'leg')
	[att][pertes][deg_sub] dégat subit la légion
	[att][pertes][deg_hro] dégat subit parle héros
	[att][pertes][hro_reste] vie restante au héros
	[att][stat]

	pour chaque defenseur $lid :

	[def][i = lid] = legion (table leg+heros)
	[def][i = lid][vie_leg]
	[def][i = lid][ratio]
	[def][i = lid][stat]
	[def][i = lid][comp] si compétence activée
	[def][i = lid][comp][bonus]
	[def][i = lid][comp][res] = résultat (valeur ou array selon la comp)
	[def][i = lid][leg][i = type] = nb
	[def][i = lid][pertes][unt] (idem que 'leg')
	[def][i = lid][pertes][deg_sub] dégat subit la légion
	[def][i = lid][pertes][deg_hro] dégat subit parle héros
	[def][i = lid][pertes][hro_reste] vie restante au héros

	infos generales :

	[vie_def_tot]
	[deg_bat]
	[mid2] (le défenseur)
	[race2]
	[btc_bonus][gen=>valeur,bon=>valeur]
	[btc_def][type=>nb]
	[btc_edit]
	[legs] = autres légions en présence
	*/

	/* Debut */
	$bilan = array();

	// infos, et calcul vie totale
	$bilan['vie_def_tot'] = 0;
	$bilan['def'] = array();
	foreach ($legs['combat'] as $lid) {
		$leg = $legions->legs[$lid];
		if ($lid == $lid1) {
			$bilan['att'] = $leg->infos;
			$bilan['att']['leg'] = $leg->get_unt();
			$bilan['att']['vie_leg'] = $leg->stats('vie');
		} else { // vie defenseurs & globale
			$bilan['def'][$lid] = $leg->infos;
			$bilan['def'][$lid]['leg'] = $leg->get_unt();
			$bilan['def'][$lid]['vie_leg'] = $leg->stats('vie');
			$bilan['vie_def_tot'] += $leg->stats('vie');
			$bilan['def'][$lid]['ratio_def'] = $ratio_def[$lid]; // ratio défensif
			/* compétence murs fortifiés : double la solidité des bâtiments */
			if ($leg->mid == $mid_def && $leg->comp == CP_MURAILLES_LEGENDAIRES) {
				$cp = get_comp( $leg->comp, $leg->race);
				$bonus_btc = $cp['bonus'] / 100;
				$bilan['def'][$lid]['comp'] = $cp;
			}
		}
	}

	// ratio défensif arrondi au 1% supérieur (kill the fake!)
	foreach ($legs['def'] as $lid)
		$bilan['def'][$lid]['ratio'] = 
			$bilan['vie_def_tot'] == 0 ? 1 : ceil($legions->legs[$lid]->stats('vie') / $bilan['vie_def_tot']*100)/100;


	$race2 = $mbr_def_array['mbr_race'];
	/* Calcul des bonus batiment, une fois pour toute */
	$btc_array = get_btc_done($mid_def); // detail des batiments ($bid, vie, type...)
	$btc_list = btc_milit($btc_array, $race2);
	$btc_edit = array();   // batiments detruits ou endommages
	// unites des batiments, pour le nb d'unites des batiments detruits
	$bat_lid = $legions->btc_lid;

	$bilan['mid2']    = $mid_def;
	$bilan['race2']   = $race2;
	$bilan['btc_bonus'] = $btc_list['bonus'];
	$bilan['btc_def'] = $btc_list['nb_def'];
	
	/* le combat se déroule en 4 étapes :
		- volée de flèches (compétence avant combat) si existe
		- l'attaquant attaque (calcul dégat et pertes défenseurs)
		- l'attaque batiment (calcul des bat détruits)
		- la défense se défend (calcul dégats et pertes attaquant)
	ensuite création du bilan, butins et XP ...................... */

	/* volée de flèches */
	foreach ($legs['combat'] as $lid) {
		$leg = $legions->legs[$lid];
		if ($leg->comp == CP_VOLEE_DE_FLECHES or $leg->comp == CP_FLECHES_SALVATRICES) {
			$cp = get_comp( $leg->comp, $leg->race);
			if ($lid == $lid1) { // volée de flèches de l'attaquant, sur tous les défenseurs
				foreach ($legs['def'] as $liddef) {
					$degat = $bilan['def'][$liddef]['ratio'] * $cp['bonus']/100 * $bilan['def'][$liddef]['vie_leg'];
					$tmp = $legions->legs[$liddef]->pertes($degat , false, false);
					$cp['res'][] = array('race'=>$bilan['def'][$liddef]['mbr_race'], 'degat'=>$degat, 'unt'=>$tmp['unt']);
				}
				$bilan['att']['comp'] = $cp;
			} else { // volée de flèches d'un défenseur sur l'attaquant
				$degat = $cp['bonus']/100 * $bilan['att']['vie_leg'];
				$tmp = $legions->legs[$lid1]->pertes($degat , false, false);
				$cp['res'][$lid] = array('race'=>$bilan['att']['mbr_race'], 'degat'=>$degat, 'unt'=>$tmp['unt']);
				$bilan['def'][$lid]['comp'] = $cp;
			}
		}
	}

	/* Attaque ! calcul des pertes unites des défenseurs */
	$att = $legions->legs[$lid1]->atq_fin();
	$bilan['att']['stat'] = $att;
	$bilan['att']['stat']['bonus'] = $legions->legs[$lid1]->bonus();
	foreach ($legs['def'] as $lid) {
		$leg = $legions->legs[$lid];
		$bilan['def'][$lid]['pertes'] = $leg->pertes(round($bilan['def'][$lid]['ratio'] * $att['fin']));
		/* compétence guérison: récupérer une partie des pertes */
		if ($leg->comp == CP_GUERISON) {
			$cp = get_comp( $leg->comp, $leg->race);
			$cp['res'] = $leg->add_unt($bilan['def'][$lid]['pertes']['unt'], $cp['bonus'] / 100);
			$bilan['def'][$lid]['comp'] = $cp;
		}
	}

	/* Attaque batiment et repartition des degats */
	$att_bat = $att['bat'] * ATQ_RATIO_COEF_BAT;
	//$bilan['deg_bat'] = 0; // apparemment inutile (23.07.2010)
	foreach ($legs['def'] as $lid) { // si la def est consequente on divise l'atq bat par 2
		$leg = $legions->legs[$lid];
		if ($lid != $lid1) // defenseur
			if ((4 * $leg->stats('vie')) >= $bilan['att']['vie_leg']) {
				$att_bat = round($att_bat / 2);
				break;
			}
	}
	$bilan['atq_bat'] = $att_bat;

	//$bilan['atq_bat_mino'] = $att_bat; // apparemment inutile (23.07.2010)
	$update_place = 0;

	$sol_bat_det = 0;

	/* limite à 6 batiments détruits */
	while ($att_bat > 0 && count($btc_edit) < 6) {
		unset($bid);
		// on selectionne le batiment à attaquer
		if (!empty($btc_list['def'])) {// détruire un bâtiment défensif au hasard
			$bid = array_rand($btc_list['def']);
			unset($btc_list['def'][$bid]);
			$btc = $btc_array[$bid];
		} else if (count($btc_array) > 1) {// détruire un bâtiment quelconque au hasard s'il en reste (!)
			$btc_type = array_rand($btc_list['nb']); // choisir un type de bâtiments
			foreach ($btc_array as $bid => $btc)
				if ($btc['btc_type'] == $btc_type)
					break; // sortie de boucle : $btc est le bâtiment touché 
		} else break; // reste plus que le donjon !?

		if ($btc) {
			$btc_list['nb'][$btc['btc_type']] -= 1;
			unset($btc_array[$bid]); // virer le bât de la liste
			/* solidité avec bonus compétence */
			$btc['btc_vie'] = floor($btc['btc_vie'] * $bonus_btc);

			if($btc['btc_vie'] <= $att_bat) { // on fait les modifs sur ce batiment $btc :
				if ($btc['btc_type'] == 1) { // protéger le donjon (bat type 1)
					$att_bat -= $btc['btc_vie'] + 1;
					$btc['btc_vie'] = 1; // laisser 1 PDV pour pouvoir réparer
				} else {
					$att_bat -= $btc['btc_vie'];

					/*bonus de pex destruction de bat*/
					$sol_bat_det = $sol_bat_det + $btc['btc_vie'];

					/* trop de dégats pour ce batiment : il est détruit */
					$btc['btc_vie'] = 0;

					/* Bâtiment détruit, faut virer les unités */
					$prix_unt = get_conf_gen($race2, "btc", $btc["btc_type"], "prix_unt");
					foreach($prix_unt as $type => $nb)
						if ($bat_lid) $legions->legs[$bat_lid]->del_unt($type, $nb);

					/* Et les terrains ! */
					mod_trn($mid_def, get_conf_gen($race2, "btc", $btc["btc_type"], 'prix_trn'));

					/* Et la pop */
					$update_place += (int) get_conf_gen($race2, "btc", $btc["btc_type"], 'prod_pop');
				}
			} else {/* le batiment est seulement endommagé */
				$btc['btc_vie'] -= $att_bat;
				$att_bat = 0;
			}
			$btc_edit[$bid] = $btc;
			$btc_edit[$bid]['vie'] = $btc['btc_vie'];
		}
	} // end while de l'attaque batiment

	$bilan['btc_edit'] = array(); // pertes bâtiment
	foreach ($btc_edit as $bid => $btc)
		$bilan['btc_edit'][] = array('type' => $btc['btc_type'],
					'vie' => $btc['btc_vie'],
					'vie_max' => get_conf_gen($race2,"btc",$btc['btc_type'],"vie"));


	/* defense : cumuler les légions en défense */
	$def_tot = 0;
	$def_tot_unt = 0;
	foreach ($legs['def'] as $lid) {
		$leg = $legions->legs[$lid];

		// bonus bat pour la(les) légion(s) du défenseur seulement
		if ($leg->mid == $mid_def)
			$leg->set_bonus_btc($btc_list['bonus']);
		$def = $leg->def_fin($ratio_def[$lid]);
		$def_tot += $def['fin'];
		$def_tot_unt += $def['unt'];
		$bilan['def'][$lid]['stat'] = $def;
		$bilan['def'][$lid]['stat']['bonus'] = $legions->legs[$lid]->bonus();
	}
	$def_tot_unt += $btc_list['bonus']['gen']; // cumuler avec la défense des bâtiments
	$bilan['att']['pertes'] = $legions->legs[$lid1]->pertes(round($def_tot)); // calcul pertes unités

	/* compétence guérison: récupérer une partie des pertes */
	if ($legions->legs[$lid1]->comp == CP_GUERISON) {
		$cp = get_comp( $legions->legs[$lid1]->comp, $_user['race']);
		$cp['res'] = $legions->legs[$lid1]->add_unt($bilan['att']['pertes']['unt'], $cp['bonus'] / 100);
		$bilan['att']['comp'] = $cp;
	}

	/* fin des combats, calcul des butins et XP */
	foreach ($legs['combat'] as $lid) { // vérifier compétence active pas encore définie
		if ($legions->legs[$lid]->comp != 0)
			if ($lid == $lid1 &&  empty($bilan['att']['comp']))
				$bilan['att']['comp'] = get_comp( $legions->legs[$lid]->comp, $legions->legs[$lid]->race);
			else if ($lid != $lid1 && empty($bilan['def'][$lid]['comp']))
				$bilan['def'][$lid]['comp'] = get_comp( $legions->legs[$lid]->comp, $legions->legs[$lid]->race);
	}

	// butin
	$bilan['butin']['att'] = array();
	foreach ($legs['combat'] as $lid) { // parcourrir les légions 
		if ($lid == $lid1) // le butin pris sur l'attaquant ira au(x) défenseur(s)
			$bilan['butin']['def'] = w_butin($bilan['att']['pertes']['unt'], $_user['race']);
		else // le butin pris sur le(s) défenseur(s) ira à l'attaquant (cumul)
			$bilan['butin']['att'] = w_butin($bilan['def'][$lid]['pertes']['unt'],
							$legions->legs[$lid]->race, $bilan['butin']['att']);
	}

	// 1 ressource de chaque batiment détruit
	foreach ($btc_edit as $bid => $value){
		if (!$value['btc_vie']) { // bâtiment complètement détruit
			$prix =	get_conf_gen($race2,"btc",$value["btc_type"],"prix_res");
			$res = array_rand($prix);
			$vie = get_conf_gen($race2,"btc",$value["btc_type"],"vie");
			$nb = $prix[$res] * round(($vie - $value['btc_vie']) / $vie);
			if($nb) {
				if(!isset($bilan['butin']['att'][$res]))
					$bilan['butin']['att'][$res] = 0;
				$bilan['butin']['att'][$res] += $nb;
			}
		}
	}
	
	/* PILLAGE */
	if ($bilan['att']['pertes'] != $bilan['att']['stat']['nb']) {// si la légion est rasée, pas de pillage
		$res_def = get_res_done($mid_def, array(), 0); // ressources du défenseur
		$res_def = clean_array_res($res_def);
		$res_def = $res_def[0];

		$coef_fake = ($bilan['att']['stat']['nb'] - 1) * 2; // on gère les fakes
		if ($coef_fake >= 100) $coef_fake = 100; // avec un maximum de 100% => coef à 1
		
		if ($res_def[GAME_RES_PRINC] != 0) { // s'il a de l'or
			$gain_or = round(max(1, rand(1, $res_def[GAME_RES_PRINC] / BUT_PILLAGE_COEF) * ($coef_fake / 100))); // on gagne aléatoirement un nombre d'or entre 1 et 25% du total de l'or du défenseur principal
			if(!isset($bilan['butin']['att'][GAME_RES_PRINC]))
				$bilan['butin']['att'][GAME_RES_PRINC] = 0;
			$bilan['butin']['att'][GAME_RES_PRINC] += $gain_or; // ajout des ressources au butin
			unset($res_def[GAME_RES_PRINC]); // on supprime l'or des ressources du défenseur pour ne pas retomber dessus pour la 2e ressource pillée
			mod_res($mid_def, array(1 => $gain_or), -1); // On retire les ressources pillées du joueur
		}
		foreach($res_def as $res => $qtite_res) { // on cherche une ressource qui n'est pas nulle
			if($qtite_res == 0)
				unset($res_def[$res]);//si la qtité de ressource est nulle, on l'enlève de l'array
		}
		$res_pillee = array_rand($res_def, 1); //on sélectionne une clé au hasard dans res_def
		if($res_pillee != 0){ // On vérifie que le défenseur possède des ressources (pas toutes à 0)
			$gain_res =  round(max(1, rand(1, $res_def[$res_pillee] / BUT_PILLAGE_COEF) * ($coef_fake / 100))); // on récupére au minimum 1 et au maximum 25% du total de la ressource
			if(!isset($bilan['butin']['att'][$res_pillee]));
				$bilan['butin']['att'][$res_pillee] = 0;
			$bilan['butin']['att'][$res_pillee] += $gain_res; // on ajoute les ressources au butin
			mod_res($mid_def, array($res_pillee => $gain_res), -1); // On retire les ressources pillées du joueur
		}
	}

	/* REPARTITION DE L'XP */
	$coeff_xp = min($att['fin'],$def_tot) / max($att['fin'],$def_tot);
	$xp_def = ceil( $def_tot * $coeff_xp / 45 );

	$bilan['atq_bat_xp'] = 	floor(($bilan['atq_bat'] - $att_bat) * ((1 + count($btc_edit)) * $sol_bat_det /8000)/ 300); // XP atq bat
	$bilan['att']['xp_won'] = ceil( $att['fin'] * $coeff_xp / 45 + $bilan['atq_bat_xp']);
	
	foreach ($legs['def'] as $lid) { // parcourir les légions en défense
		$bilan['def'][$lid]['xp_won'] = $xp_def * $bilan['def'][$lid]['ratio'];
	}

	/* DEBUT DE L'ENREGISTREMENT EN BDD */
	/* maj des unites batiments aussi, dans la legion bat */
	if ($bat_lid)
		$bilan['btc_unt'] = array($bat_lid => $legions->legs[$bat_lid]->get_edit_unt());
	else
		$bilan['btc_unt'] = array();

	/* Mises a jour  Légions (table 'leg') */
	foreach ($legs['combat'] as $lid) { // parcourrir les legions
		$leg = $legions->legs[$lid];
		if ($lid == $lid1) { // xp gagnee par l'attaquant + retour à la maison
			$new = array('xp' => (int) ($bilan['att']['xp_won']),
				'hro_vie' => $bilan['att']['pertes']['hro_reste']);
    		$new['etat'] = LEG_ETAT_RET;
			$new['vit'] = $leg_1->calc_vit();
    		$new['dest'] = $_user['mapcid'];
		} else {
			$new = array();
			$new['etat'] = $etats_defs[$lid];
			$new['hro_vie'] = (int) $bilan['def'][$lid]['pertes']['hro_reste'];
			$new['xp'] = (int) ($bilan['def'][$lid]['xp_won']);
		}
		$leg->edit($new);
	}

	// Mises a jour unites (table 'unt') 
	$legions->flush_all_units();


	// Population : 'recompter' la population pour tous les joueurs participants
	$edit_mid = array(); // liste des joueurs concernés
	$histo = array();
	foreach ($legs['combat'] as $lid) { // parcourrir les legions
		$leg = $legions->legs[$lid];
		if (!isset($edit_mid[$leg->mid]))
			$edit_mid[$leg->mid]['population'] = count_pop($leg->mid);
		// pour les évènements : attaquant & défenseur seulement sont cités
		$tmp = array('lid' => $lid, 'leg' => $leg->infos['leg_name'],
			'name' => $leg->infos['mbr_pseudo'], 'mid' => $leg->mid);
		if ($lid == $lid1)
			$histo['atq'] = $tmp;
		else if ($lid == $legions->vlg_lid)
			$histo['def'] = $tmp;
	}
	if($update_place) // place perdue si batiments detruits ...
		$edit_mid[$mid_def]["place"] = $mbr_def_array['mbr_place'] - $update_place;

	foreach ($edit_mid as $mid => $edit_tmp) {
		if (!empty($edit_tmp)) // éditer les membres : table 'mbr'
			edit_mbr($mid, $edit_tmp);
		// ajouter un evenement dans l'historique sauf pour l'attaquant
		if ($mid != $_user['mid'])
			$_histo->add($mid, $_user['mid'], ($mid == $mid_def ? HISTO_LEG_ATQ_VLG : HISTO_LEG_ATQ_LEG), $histo);
	}
	//$_histo->flush();

	// Mises a jour des btc
	edit_btc($mid_def, $btc_edit);

	// Mise a jour des ressources
	foreach ($legs['combat'] as $lid) // parcourrir les legions
		if ($lid == $lid1)
			mod_res_leg($lid1, $bilan['butin']['att']);
		else if ($bilan['def'][$lid]['ratio'] > 0) {
			$butin = array(); // le bilan est reparti entre les defenseurs selon le ratio
			foreach($bilan['butin']['def'] as $res => $nb)
				$butin[$res] = floor($bilan['def'][$lid]['ratio'] * $nb);
			$bilan['def'][$lid]['butin'] = $butin;

			if ($lid == $legions->vlg_lid) // ressources du joueur
				
				mod_res($legions->legs[$lid]->mid, $butin);
			else
				mod_res_leg($lid, $butin);
		}
	
	// Ajout du journal de guerre
	add_atq_all($bilan);


	$_tpl->set("bilan", $bilan);
	$_tpl->set("mbr2_array", $mbr_def_array);
	$_tpl->set('leg_array',$legs);
	$_debugvars['bilan'] = $bilan;
	$_debugvars['list_legs'] = $legs;

	break;
}// switch($_act)

}// else can_d(DROIT_PLAY)

?>
