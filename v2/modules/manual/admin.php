<?php

if(!defined("_INDEX_")) exit;

if (can_d(DROIT_ADM_TRAV)) {

/******************************************/
/*	fonctions spécifiques aux constantes  */
/******************************************/

// écrire dans le fichier $file entre les balises //<$tag> //</$tag> le texte $text
function file_replace_text($file, $tag, $text) {
	if ($str = file_get_contents($file)) {
		$begintag = "//<$tag>";
		$endtag = "//</$tag>";
		$start = strpos($str, $begintag);
		$end = strpos($str, $endtag);
		if (($start === false) or ($end === false)) {
			return "Modifications non enregistrées ! délimiteurs '$tag' introubables.";
		} else {
			$start = $start + 1 + strlen($begintag);
			$end -= 1;
			if (file_put_contents($file, substr_replace($str, $text, $start, $end-$start)))
				return "$tag : mise à jour dans $file ok.";
			else
				return "Mise à jour dans le fichier $file en erreur.";
		}
	}else
		return "Impossible de lire le fichier $file.";
}

// définition de la structure de chaque objet des races
function get_config_type($cfg, $race = false){
	switch($cfg){
		// $cfg_frm['def'] = array('res'=>'R', 'unt'=>'U', 'btc'=>'B', 'src'=>'S', 'trn'=>'T');
		/* config générale 'race_cfg'
		case 'race_cfg' :
		return array('res_nb'=>'uint', 'trn_nb'=>'uint', 
			'btc_nb'=>'uint', 'unt_nb'=>'uint', 'src_nb'=>'uint',
			'primary_res' => array('R'), 'second_res'=> array('R'),
			'primary_btc'=> array('vil' => array('B'=>array('string')),
				'ext' => array('B'=>array('string'))),
			'bonus_res' => array('R'=>'uint'),
			'modif_pts_btc'=>'float',
			'debut'=> array( 'res'=> array('R'=>'uint'), 
				'trn'=> array('R'=>'uint'), 
				'unt'=> array('R'=>'uint'), 
				'btc'=> array('R'=>'uint'), 
				'src'=> array('R'=>'uint')),
			'trn'=> array( 'MAP'=> array('T'=>'uint'))
			);
	break;*/
		case 'const':
			if($race === false) return 'param $race absent dans fonction get_type_config';
			// constantes dans les tableaux
			$const = array();
			$const['U'] = get_const("U" . $race . "_");
			$const['R'] = get_const("R" . $race . "_");
			$const['T'] = get_const("T" . $race . "_");
			$const['B'] = get_const("B" . $race . "_");
			$const['S'] = get_const("S" . $race . "_");
			$const['CP'] = get_const("CP_");
			$const['TYPE_UNT'] = get_const("TYPE_UNT_");
			return $const;
		case 'const_flip':
			if($race === false) return 'param $race absent dans fonction get_type_config';
			// constantes dans les tableaux
			$const = array();
			$const['U'] = get_flip_const("U" . $race . "_");
			$const['R'] = get_flip_const("R" . $race . "_");
			$const['T'] = get_flip_const("T" . $race . "_");
			$const['B'] = get_flip_const("B" . $race . "_");
			$const['S'] = get_flip_const("S" . $race . "_");
			$const['CP'] = get_flip_const("CP_");
			$const['TYPE_UNT'] = get_flip_const("TYPE_UNT_");
			return $const;
	break;
		case 'btc':
		/* Config btc : liste des balistes bat */
		return array('vie' => 'uint', 'defense' => 'uint', 
		//'defense'=>array('bonus'=>'uint', 'def'=>'uint', 'prio'=>'bool'), 'vie'=>'uint',
			'prod_pop'=>'uint', 'tours'=>'uint', 
			'limite'=>'uint',
			'prix_res'=> array('R'=>'uint'),
			'prix_trn'=> array('T'=>'uint'),
			'prix_unt'=> array('U'=>'uint'),
			'prod_src'=> 'bool',
			'prod_unt'=> 'bool',
			'prod_res_auto'=> array('R'=>'uint'),
			'need_btc'=> array('B'),
			'need_src'=> array('S'));
	break;
		case 'trn':
		/* Config trn (vide) */
		return array();
	break;
		case 'res':
		/* Config res */
		return array('need_btc'=>'B', 
			'need_src'=>array('S'), 
			'prix_res'=> array('R'=>'uint'), 
			'group'=>'uint',
			'cron'=>'uint');
	break;
		case 'unt':
		/* Config unt */
		return array('vie'=>'uint', 'group'=>'uint',
			'role'=>'TYPE_UNT',
			'prix_res'=> array('R'=>'uint'),
			'need_btc'=> array('B'),
			'in_btc'=> array('B'),
			'need_src'=> array('S'),
			'def'=>'uint', 'atq_unt'=>'uint', 
			'atq_btc'=>'uint', 'vit'=>'uint',
			'prix_unt'=> array('U'=>'uint'),
			'carry' => 'uint',
			'rang' => 'uint',
			'bonus'=> array('atq'=>'uint', 'def'=>'uint', 'vie'=>'uint'));
	break;
		case 'src':
		/* Config src */
		return array('tours'=>'uint', 'group'=>'uint',
			'prix_res'=> array('R'=>'uint'),
			'need_src'=> array('S'),
			'need_btc'=> array('B'),
			'vlg' => 'bool');
	break;
		case 'comp':
		/* Config comp */
		return array('heros'=> array('U'),
			'tours'=>'uint',
			'bonus'=>'uint',
			'prix_xp'=> 'uint',
			'type' => 'uint');
	break;
		case 'labels':
		return array('prod_unt' => 'production d\'unités',
			'prix_res' => 'prix en ressources',
			'need_src' => 'recherches requises',
			'need_btc' => 'bâtiments nécessaires',
			'atq_unt' => 'attaque unité',
			'atq_btc' => 'attaque bâtiment',
			'def' => 'défense',
			'vit' =>'vitesse',
			'prix_unt' => 'prix en unités', 
			'role' => 'rôle',
			'carry' => 'places de transport',
			'in_btc' => 'présent dans bâtiments',
			'prix_xp' => 'prix XP',
			'prod_pop' => 'places disponibles',
			'prod_src' => 'participe aux recherches',
			'prix_trn' => 'terrain nécessaire',
			'prod_res_auto' => 'production automatique de ressources',
			'TYPE_UNT' => 'rôle de l\'unité',
			'vlg' => 'affichage dans le village');
	break;
	}

}

// comme var_export mais avec les libellés des constantes
function conf_export($post, $cfg, $race){
	$race_frm = get_config_type($cfg);
	$const = get_config_type('const_flip', $race);
	$convert = array('unt'=>'U', 'btc'=>'B', 'trn'=>'T', 'src'=>'S', 'comp'=>'CP', 'res'=>'R', 'TYPE_UNT'=>'TYPE_UNT');
	$return = '';

	foreach($post as $item => $conf1){ // lister les items
		if(!isset($const[$convert[$cfg]][$item]))
			$return .= "//cfg=$cfg : item $item inexistant dans const!\n";
		else{
			$return .= "//<$cfg-$item>\n".'$this->' . $cfg . '[' . $const[$convert[$cfg]][$item] . "] = array(\n";
			foreach($conf1 as $key => $value) { // lister la config
				$frm1 = $race_frm[$key];
				if(is_array($frm1)) {
/* distinger 2 cas: "prix_res"=>array(R1_OR => 1) OU "need_btc"=>array(B1_DONJON) ... */
					$return .= "\t'$key' => array(";
					foreach($frm1 as $key2 => $val2){
						if(isset($const[$key2]))
							foreach($value as $key3 => $val3)
								$return .= $const[$key2][$key3] . " => $val3, ";
						else if(isset($const[$val2]))
							foreach($value as $val3)
								$return .= $const[$val2][$val3] . ", ";
						else if($val2 == 'uint')
							foreach($value as $key3 => $val3){
								if($key2 == $key3 & is_numeric($val3))
									$return .= "\n\t\t'$key2' => $val3";
							}
						else
							$return .= "key2=$key2; val2=$val2, ". print_r($value, true);
					}
					$return .= "),\n";
				}else if(isset($const[$frm1])) /* constante */
					$return .= "\t'$key' => ". $const[$frm1][$value] . ",\n";
				else /* uint */
					$return .= "\t'$key' => $value,\n";
			}
			$return .= ");\n//</$cfg-$item>\n\n";
		}
	}
	return $return;
}

// nettoyage récursif du tableau
function recursive_clean_array($arr){
	foreach($arr as $key => $value)
		if (empty($value)) unset($arr[$key]);
		else if(is_array($value)) $arr[$key] = recursive_clean_array($value);
	return $arr;
}

/************************/
/*	fin des fonctions   */
/************************/

//$fic = request('fic', 'string', 'get');
$cfg = request('cfg', 'string', 'get');
if($cfg && $_user['groupe'] != GRP_DIEU) // on ne peut editer que sa race
	$race = $_user['race'];
else
	$race = request("race", "uint", "get", $_user['race']);
if(!in_array($race,$_races))
	$race = $_user['race'];

load_conf($race);
$race_config = $_conf[$race];

$_tpl->set('man_race',$race);
$_tpl->set('races',$_races);
if($race != $_user['race'])
	$_tpl->set('man_load', $race);

/*  infos admin en cache : ne pas redéfinir si existe ! */
if(!isset($admin_cache)) $admin_cache = new cache('admin',true);
$selconf = $admin_cache->{"conf$race"};
$_tpl->set("selfichier",$selconf);
$_tpl->set("module_tpl","modules/manual/admin.tpl");


/* chercher les fichiers existants */
$pages = scandir(SITE_DIR."logs/adm/$race");
foreach($pages as $key => $pg)
	if ($pg == '.' || $pg == '..' || strpos($pg, '.')===0) unset($pages[$key]); else break;

// nom du fichier fixé = [race].[mid].[dd-mm-aaaa].php
$file = SITE_DIR."logs/adm/$race/$race.{$_user['mid']}.".date("d-m-Y").'.php';

if(isset($cfg) && !empty($cfg)){  /* gestion du fichier */
	if(empty($pages)) { // aucun ? copier le conf actuel
		if (copy(SITE_DIR."conf/$race.php", $file))
			$_tpl->set('msg_update', "copie de la conf actuelle dans $file");
		else
			$_tpl->set('msg_update', "erreur copie fichier $file");
		$pages[] = basename($file);
	}
}
$_tpl->set("pg_conf",$pages);


/* selection d'un fichier de conf*/
$selfichier = request('selfichier', 'string', 'post', '');
if($selfichier != '') {

	$tmp = explode('.', $selfichier);
	$race = $tmp[0];
	if(isset($_POST['mod'])) { // sélectionner le fichier à modifier
		$file = SITE_DIR."logs/adm/$race/$selfichier";

	} else if(isset($_POST['set'])){
		/* installer le fichier dans /conf */
		$file = SITE_DIR."logs/adm/$race/$selfichier";
		if(copy($file, SITE_DIR."conf/$race.php"))
			$_tpl->set('msg_update', "$file copié comme nouveau fichier de conf.");
		else
			$_tpl->set('msg_update', "erreur de copie de fichier ! '$file' vers 'conf/$race.conf.php'");

	}else if(isset($_POST['copy'])){
		/* copie le fichier sélectionné comme nouveau fichier */
		$file2 = SITE_DIR."logs/adm/$race/$selfichier";
		if (in_array($selfichier, $pages))
			$_tpl->set('msg_update', "le fichier $file2 existe déjà");
		if (copy($file2, $file))
			$_tpl->set('msg_update', "copie de $file2 dans $file");
		else
			$_tpl->set('msg_update', "erreur copie fichier $file2 dans $file");
		$pages[] = basename($file);
	}else
		$_tpl->set('msg_update', "Comment t'es arrivé la?");

	$admin_cache->{"conf$race"} = $selfichier;
	$admin_cache->cache();

} else if($cfg) {


	// enregistrer le fichier si on a posté
	if(!empty($_POST)) {
		$msg = '';
		// gérer l'ajout de nouvelles caractéristiques
		if(!empty($_POST['add']) && isset($_POST['add'][$cfg]))
			foreach($_POST['add'][$cfg] as $key => $item)
				foreach($item as $key2 => $value) {
					if(!isset($_POST[$cfg]))
						$msg .= "{$cfg}[$key][$key2]=$value : POST[$cfg] n'existe pas<br/>\n";
					else if(!isset($_POST[$cfg][$key]))
						$msg .= "{$cfg}[$key][$key2]=$value : POST[$cfg][$key] n'existe pas<br/>\n";
					else if(!empty($value) and !(is_array($value) and empty($value[0]))) {
						// initialiser avec la bonne valeur
						$msg .= "{$cfg}[$key][$key2]=". print_r($value, true) . "<br/>\n";
						$_POST[$cfg][$key][$key2] = $value;
					}
				}

		// la suppression ? si == 0 alors supprimer l'item
		$_post_cfg = recursive_clean_array($_POST[$cfg]);

		/* vérifier la cohérence d'une configuration
		 - champ obligatoire?
		 --- role pour les unt
		 --- si role != CIVIL, vit atq_unt def vie ... sont obligatoires (atq_bat bonus non)
		 - nom et description existe?
		 - (tous les need * existent?)
		 - tous les items existent -même si vide, ex: trn
		*/
		if($cfg == 'unt')
		foreach($_post_cfg as $key => $value){
			if(!isset($value['role'])) $msg .= "unité $key: manque role<br/>\n";
			else if($value['role'] != TYPE_UNT_CIVIL){
				if(!isset($value['atq_unt'])) $msg .= "unité militaire $key: manque atq_unt<br/>\n";
				if(!isset($value['def'])) $msg .= "unité militaire $key: manque def<br/>\n";
				if(!isset($value['vit'])) $msg .= "unité militaire $key: manque vie<br/>\n";
			}
		}
		$_tpl->get_config("race/$race.config");
		foreach($_post_cfg as $key => $value)
			if(!isset($_tpl->var->{$cfg}[$race]['alt'][$key]))
				$msg .= "$cfg $key: manque le nom<br/>\n";
		$_tpl->get_config("race/$race.descr.config");
		foreach($_post_cfg as $key => $value)
			if(!isset($_tpl->var->{$cfg}[$race]['descr'][$key]))
				$msg .= "$cfg $key: manque la description<br/>\n";


		// si le fichier n'existe pas: copier le fichier de conf actuel
		if(!file_exists($file)){
			copy(SITE_DIR."conf/$race.php", $file);
			$pages[] = $file;
		}

		$text = conf_export($_post_cfg, $cfg, $race);

		// mise à jour dans le fichier de la config du formulaire
		$msg .= file_replace_text($file, $cfg, $text);
		$_tpl->set('msg_update', $msg);

		$race_cfg = $_post_cfg;
	} else {
		// charger la config
		$race_cfg = $race_config->$cfg;
	}

	$_tpl->set('lbl',get_config_type('labels'));
	$_tpl->set('cfg',$cfg);
	$_tpl->set('race_cfg',$race_cfg);
	$_tpl->set('cfg_frm',get_config_type($cfg));
	$_tpl->set('const',get_config_type('const', $race));

}else{ // test unités

	$race_cfg = $race_config->unt;
	$_tpl->set('man_unt',$race_cfg);

	$nbr = request('nbr', 'array', 'post');
	$total = array('prix_res' => array(), 'prix_unt' => array(),
		'bonus' => array('atq' => 0, 'def' => 0, 'vie' => 0)
	);
	$boucle = array('vie', 'def', 'atq_unt', 'atq_btc', 'carry'); // pas la vitesse

	foreach ($race_cfg as $key => $value) {
		// cumuler les stats & prix
		if (isset($nbr[$key]))
			$nbr[$key] = protect($nbr[$key], 'uint', 0);
		else
			$nbr[$key] = 0;

		foreach($boucle as $item) // cumul stats
			if (isset($value[$item])) {
				if (isset($total[$item]))
					$total[$item] += $nbr[$key] * $value[$item];
				else
					$total[$item] = $nbr[$key] * $value[$item];
		}

		if(isset($value['bonus'])) // cumul des bonus
			foreach($value['bonus'] as $bon => $val)
				$total['bonus'][$bon] += $nbr[$key] * $val;

		if (isset($value['prix_res'])) // prix en ressources
		foreach ($value['prix_res'] as $res => $nb) {
				if (isset($total['prix_res'][$res]))
					$total['prix_res'][$res] += $nbr[$key] * $nb;
				else
					$total['prix_res'][$res] = $nbr[$key] * $nb;
		}

		if (isset($value['prix_unt'])) // prix en unitÃ©s
		foreach ($value['prix_unt'] as $unt => $nb) {
				if (isset($total['prix_unt'][$unt]))
					$total['prix_unt'][$unt] += $nbr[$key] * $nb;
				else
					$total['prix_unt'][$unt] = $nbr[$key] * $nb;
		}

	}
	$total['atq_unt'] += $total['atq_unt'] * ($total['bonus']['atq']/100);
	$total['atq_btc'] += $total['atq_btc'] * ($total['bonus']['atq']/100);
	$total['def']     += $total['def'] * ($total['bonus']['def']/100);

	$_tpl->set('nbr',$nbr);
	$_tpl->set('total',$total);

} // else - tester une légion

} //  if can_d(DROIT_ADM_MBR)
?>
