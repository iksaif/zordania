<?php
/* classe pour les légions */
class legion {
	public    $infos = array(); // infos des légions
	public    $mid = 0; // pour savoir si la légion a été chargée ou pas
	public    $lid;
	public    $cid;
	public    $etat;
	public    $race;
	public    $comp = 0; // id de la compétence active ou 0
	public    $hid = false; // a un héro (id)
	protected $w_load_unt = false; // lecture des unités?
	protected $w_load_res = false; // lecture des ressource?
	protected $unt = array(); // infos des unités : get_unt
	protected $res = array(); // ressources de la légion: get_res
	protected $stats = array();
	/* bonus attaque, defense, heros(XP), batiment, competence */
	protected $bonus = array('atq' => 0, 'def' => 0, 'btc' => 0, 'cpt' => array(), 'vie' => 0);
	private   $cache = array(); // pour la fonction can_unt
	private   $edit_unt = array(); // pour maj unités
	public    $sqr = false; // la case (map)


	function __construct($lid, $mid = 0){ // rechercher la légion par lid et mid si existe
		$lid = protect($lid, "uint");
		$mid = protect($mid, "uint");

		if(!$lid) return false; 
		else $this->lid = $lid;

		$cond = array('leg' => array($lid), 
				'etat' => array(LEG_ETAT_VLG, LEG_ETAT_GRN, LEG_ETAT_POS, 
					LEG_ETAT_DPL, LEG_ETAT_ALL, LEG_ETAT_RET, LEG_ETAT_ATQ), 'mbr' => true);
		if ($mid)
			$cond['mid'] = $mid;

		$leg = get_leg_gen($cond);
		if($leg){
			$this->infos = $leg[0];
			$this->mid = $this->infos['mbr_mid'];
			$this->race = $this->infos['mbr_race'];
			$this->cid = $this->infos['leg_cid'];
			$this->etat = $this->infos['leg_etat'];
			if($this->infos['hro_id']) { // récupérer la vie du héros
				$this->hid = $this->infos['hro_id'];
				$this->infos['hro_vie_conf'] = get_conf_gen($this->race, 'unt', $this->hro('type'), 'vie');
				$this->comp = $this->infos['bonus'];
			}
			return true;
		} else
			return false;
	}

	function __destruct(){
		// destruction de la legion
		if (!empty($this->edit_unt)) $this->flush_edit_unt();
	}

	private function loadUnt(){ // remplace get_unt_leg
		// toutes les unités sauf celles des batiments
		$tmp = get_leg_gen(array('leg' => array($this->lid), 'sum' => true,
			'etat' => array(LEG_ETAT_VLG, LEG_ETAT_GRN, LEG_ETAT_DPL, LEG_ETAT_RET, LEG_ETAT_ATQ)));
		$this->unt = array();
		foreach($tmp as $unt)
			$this->unt[$unt['unt_type']] = $unt['unt_sum'];
		$this->w_load_unt = true; // au cas où la légion est vraiment vide !!
		return !empty($this->unt);
	}

	function hro($val) { // lire une caractérisique du héros (si existe)
		if ($this->hid && isset($this->infos['hro_'.$val]))
			return $this->infos['hro_'.$val];
		else
			return 0;
	}

	function cp_bonus($type) { // donne le bonus de la compétence $type si elle est activée
		if ($this->comp == $type) {
			$return = get_conf_gen($this->race, 'comp', $type, 'bonus');
			if (is_numeric($return))
				return $return;
			else
				return 0;
		}
		else
			return 0;		
	}

	function get_unt($type = 0){ // renvoyer les unités de la légion, toutes ou celles de $type
		$type = protect($type, "uint");

		if(!$this->w_load_unt) // rechercher toutes les unités si pas fait
			$this->loadUnt();

		if($type)
			if(isset($this->unt[$type]))
				return $this->unt[$type];
			else
				return 0;
		else // renvoyer toutes les unités
			return $this->unt;
	}

	function getUntByRole($role){ // rend les unités qui ont ce rôle (constants TYPE_UNT*)
		$role = protect($role, "uint");
		$result = array();

		if(!$this->w_load_unt) // rechercher toutes les unités si pas fait
			$this->loadUnt();

		foreach($this->unt as $type => $nb){
			$untRole = get_conf_gen($this->race, 'unt', $type, 'role');
			if($untRole == $role)
				$result[$type] = $nb;
		}
		return $result;
	}

	function unit_normal($type = 0) { // unités 'normales' = sauf le héros
		$unt = $this->get_unt($type);
		$hro_type = $this->hro('type');
		if ($hro_type) unset($unt[$hro_type]);
		if($type)
			if(isset($unt[$type]))
				return $unt[$type];
			else
				return 0;
		else // renvoyer toutes les unités
			return $unt;
	}

	function vide(){ // la légion est-elle vide ?? ni unités ni héros
		if(!$this->w_load_unt) $this->get_unt(); // rechercher les unités si pas fait
		return empty($this->unt);
	}

	function can_unt($unt, $nb) { // vérifier qu'on peut former $nb unités $unt
		// vérifie prix ressources & unités, et qu'on a les bât et recherches
		$bad = can_unt($this->mid, $unt, $nb, $this->cache);
		if (!empty($bad)) return $bad; // manque qqchose pour former cette unitée
		else return true;
	}

	function add_unt($unt, $nb = 1, $factor = 1){
	/* ajouter $nb unités $unt (peut être négatif)
		ou ($nb * $factor) unités $unt
		si $unt = array : $nb est pris en tant que facteur et $factor est ignoré
		return = modifications effectuées
	*/
		if (is_array($unt)) {
			$return = array();
			foreach ($unt as $key => $value)
				$return[$key] = $this->add_unt($key, $value, $nb);
			return $return;
		} else {
			$nb = round($nb * $factor);
			$rang = (int) get_conf_gen($this->race, 'unt', $unt, 'rang');
			// modifier les unités si déjà chargé
			if ($this->w_load_unt) {
				if (!isset($this->unt[$unt])) $this->unt[$unt] =0;
				if ($this->unt[$unt] + $nb < 0) $nb = -$this->unt[$unt]; // test si on enlève trop!
				$this->unt[$unt] += $nb;
				if ($this->unt[$unt] == 0) unset($this->unt[$unt]);
			}
			// cumuler en cache
			if (isset($this->edit_unt[$rang]) && isset($this->edit_unt[$rang][$unt]))
				$this->edit_unt[$rang][$unt] += $nb;
			else
				$this->edit_unt[$rang][$unt] = $nb;
			return $nb;
		}
	}

	function del_unt($unt, $nb = -1) { // supprimer nb unités; inverser le résultat
		$return = $this->add_unt($unt, $nb, -1);
		if (is_array($unt))
			foreach($return as $key => $val)
				$return[$key] = - $val;
		else
			$return = -$return;
		return $return;
	}

	function get_edit_unt($type = 0) { // recup nb d'unites a modifier
		if ($type) {
			$rang = (int) get_conf_gen($this->race, 'unt', $type, 'rang');
			if(isset($this->edit_unt[$rang][$type]))
				return $this->edit_unt[$rang][$type];
			else
				return 0;
		} else
			return $this->edit_unt;
	}

	function flush_edit_unt($get = false) { // exécuter la MAJ unités ou récupérer
		$tmp = $this->edit_unt;
		$this->edit_unt = array();
		if ($get)
			return $tmp;
		else
			edit_unt_leg($this->mid, $this->lid, $tmp);
	}

	function get_res($type = 0){ // renvoyer les ressources de la légion, toutes ou celles de $type
		$type = protect($type, "uint");

		if(!$this->w_load_res){ // rechercher toutes les ressources
			$res = get_res_leg($this->mid, $this->lid);
			if(!empty($res))
				foreach($res as $value) // réindexer !
					$this->res[$value['lres_type']] = $value['lres_nb'];
			$this->w_load_res = true; // si la légion est vraiment vide !!
		}

		if($type)
			if(isset($this->res[$type]))
				return $this->res[$type];
			else
				return 0;
		else // renvoyer toutes les ressources
			return $this->res;
	}

	function mod_res($res){ // ajouter / enlever les ressources
		mod_res_leg($this->lid, $res);
		// modifier les ressources si déjà chargé
		foreach($res as $type => $nb)
			if(isset($this->res[$type]))
				$this->res[$type] += $nb;
	}

	function back_unt($type){ // rentrer les unités $type au village
		global $_user, $_sql;

		if(!$this->vide())
			if(isset($this->unt[$type]) && $this->unt[$type])
				if($_user['mapcid'] == $this->cid && $this->infos['leg_etat'] == LEG_ETAT_GRN) {
					$nb = $this->unt[$type];
					// supprimer les unités de la légion en cours
					$sql = "DELETE FROM ".$_sql->prebdd."unt WHERE unt_lid = {$this->lid} AND unt_type = $type ";
					$_sql->query($sql);
					// ajouter au village
					edit_unt_vlg($_user['mid'], array($type => $nb));
					unset($this->unt[$type]); // suppr en mémoire
				}

	}

	function stats($type = ''){ // stats de la légion
		if(empty($this->stats)){ // calculer les stats
			$this->stats = array('unt_nb' => 0, 'atq_unt' => 0, 'atq_btc' => 0, 'def' => 0, 'vit' => 0,
				'vie' => 0); // zero par défaut
			if(!$this->vide()) {
				foreach($this->unt as $unt => $nb) {
					/* on ne prend pas en compte les unités civiles */
					$role = get_conf_gen($this->race, 'unt', $unt, 'role');
					if ($role != TYPE_UNT_CIVIL) {
						$this->stats['unt_nb']  += $nb;
						$this->stats['atq_unt'] += (int) get_conf_gen($this->race, 'unt', $unt, 'atq_unt') * $nb;
						$this->stats['atq_btc'] += (int) get_conf_gen($this->race, 'unt', $unt, 'atq_btc') * $nb;
						$this->stats['def']     += (int) get_conf_gen($this->race, 'unt', $unt, 'def') * $nb;
						if ($role == TYPE_UNT_HEROS) // vie restante du héros
							$this->stats['vie'] += $this->hro('vie');
						else
							$this->stats['vie'] += (int) get_conf_gen($this->race, 'unt', $unt, 'vie') * $nb;
						$bon_unt = get_conf_gen($this->race, "unt", $unt, "bonus");
						foreach ($bon_unt as $key => $value)
							$this->bonus[$key] += $value * $nb;
					}
				}
				// bonus maxi = 30
				$this->bonus['atq'] = min( 30, $this->bonus['atq']);
				$this->bonus['def'] = min( 30, $this->bonus['def']);
				// vie : bonus maxi = 70. formule alambiquée
				$this->bonus['vie'] = min(round(log10(($this->bonus['vie']+20)/20) * ATQ_RATIO_DIST, 1), 70);
				//$this->bonus['hro'] = round($this->hro('xp') / 100,1); // plus de bonus XP

				if ($this->comp) {
					$bonus = get_conf_gen($this->race, 'comp', $this->comp, 'bonus');
					if ($this->comp == CP_BOOST_OFF || $this->comp == CP_BOOST_OFF_DEF)
						$this->bonus['cpt']['atq'] = $bonus;
					if ($this->comp == CP_BOOST_DEF || $this->comp == CP_BOOST_OFF_DEF)
						$this->bonus['cpt']['def'] = $bonus;
					if ($this->comp == CP_RESISTANCE)
						$this->bonus['cpt']['vie'] = $bonus;
					if ($this->comp == CP_CASS_BAT)
						$this->bonus['cpt']['btc'] = $bonus;
					if ($this->comp == CP_VITESSE)
						$this->bonus['cpt']['vit'] = $bonus;
				}
				// calculer la vitesse
				if($this->etat == LEG_ETAT_DPL)
					$this->stats['vit'] = $this->infos['leg_vit'];
				else
					$this->stats['vit'] = $this->calc_vit();
			}
			$this->stats = $this->stats;
		}

		if($type != '')
			return (isset($this->stats[$type]) ? $this->stats[$type] : 0);
		else
			return $this->stats;
	}

	function bonus($type = '') { // les bonus de la légion
		if(empty($this->stats)) // le 1er appel force à calculer les stats
			$this->stats();
		if ($type != '')
			return (isset($this->bonus[$type]) ? $this->bonus[$type] : 0);
		else
			return $this->bonus;
	}

	function set_bonus_btc($bonus) {
		if ($this->comp == CP_DEFENSE_EPIQUE)
			$bonus_cp = get_conf_gen($this->race, 'comp', $this->comp, 'bonus');
		else
			$bonus_cp = 0;
		$this->bonus['btc'] = $bonus['bon'] + $bonus_cp;
	}

	function vitesse(){ // méthode publique pour récupérer la vitesse
		return $this->stats('vit');
	}

	function nb_unt(){ return $this->stats('unt_nb'); }
	/* calcul du total avec tous les bonus possibles */
	function atq_unt(){
		return round($this->stats('atq_unt')
			* ( 1 + ( $this->bonus('atq')
				+ (isset($this->bonus['cpt']['atq']) ? $this->bonus['cpt']['atq'] : 0)
			) / 100 ) ) ;
	}
	function atq_btc(){
		return round($this->stats('atq_btc')
			* ( 1 + ( $this->bonus('atq')
				+ (isset($this->bonus['cpt']['btc']) ? $this->bonus['cpt']['btc'] : 0)
			) / 100 ) ) ;
	}
	function def_unt(){
		return round($this->stats('def')
			* ( 1 + ( $this->bonus('def')
				+ $this->bonus('btc')
				+ (isset($this->bonus['cpt']['def']) ? $this->bonus['cpt']['def'] : 0)
			) / 100 ) ) ;
	}
	function unt_vie($type = 0){ // vie des unités $type avec bonus compétence
		if ($type == 0) // vie globale légion
			return round( $this->stats('vie')
				* ( 1 + (isset($this->bonus['cpt']['vie'])?$this->bonus['cpt']['vie']:0) / 100));
		else if(empty($this->unt[$type]))
			return 0;
		else // nb unités * vie * bonus compétence
			return round( $this->get_unt[$type] * (int) get_conf_gen($this->race, 'unt', $unt, 'vie')
				* ( 1 + (isset($this->bonus['cpt']['vie'])?$this->bonus['cpt']['vie']:0) / 100));
	}

	function atq_fin() { // caractéristiques pour l'attaque
		$att   = $this->atq_unt();
		return array('unt' => $att,
			'fin' => round($att / ATQ_RATIO_COEF_ATQ),
			'bat' => $this->atq_btc(),
			'nb' => $this->nb_unt());
	}

	function def_fin($ratio = 1) { // caractéristiques pour la défense
		// $ratio = coef pour la défense groupée [0-1]
		$def = $this->def_unt();
		return array('unt' => round($def * $ratio),
			'fin' => round($def * $ratio / ATQ_RATIO_COEF_DEF),
			'nb' => $this->nb_unt());
	}

	public function calc_vit() { // calculer la vitesse d'après les unités de la légion
		$have_unt = $this->get_unt();	
		if(empty($have_unt))
			return 0;

		$speed_array = $carry_array = array();
		foreach($have_unt as $type => $nb) {
			$vit = protect(get_conf_gen($this->race, "unt", $type, "vit"), "uint");
			$carry = protect(get_conf_gen($this->race, "unt", $type, "carry"), "uint");
		
			if($carry) {
				if(!isset($carry_array[$vit]))
					$carry_array[$vit] = 0;
				$carry_array[$vit] += $nb * $carry; // capacité de transport
			}
			if(!isset($speed_array[$vit]))
				$speed_array[$vit] = 0;
			$speed_array[$vit] += $nb; // nb d'unités par vitesse
		}
		ksort($speed_array);
		ksort($carry_array);
	
		foreach($carry_array as $vitc => $nbc) {// décompter les unités transportées
			foreach($speed_array as $vitu => $nbu) {
				if($vitc <= $vitu || !$nbc)
					continue;
				if(!isset($speed_array[$vitc]))
					$speed_array[$vitc] = 0;
			
				if($nbc >= $nbu) {
					$nbc -= $nbu;
					$speed_array[$vitu] -= $nbu;
					$speed_array[$vitc] += $nbu;
				} else {
					$speed_array[$vitu] -= $nbc;
					$speed_array[$vitc] += $nbc;
					$nbc = 0;
				}
			}
		}

		$total = 0; $nbt = 0; // calcul vitesse totale (moyenne)	
		foreach($speed_array as $vit => $nb) {
			$total += $vit * $nb;
			$nbt += $nb;
		}
		/* compétence 'pas de course' : ajouter x % */
		if (isset($this->bonus['cpt']['vit'])) {
			$total = floor($total(1 + $this->bonus['cpt']['vit']));
		}
		return ($nbt == 0 ? 0 : round($total / $nbt));
	}

	function pertes ($deg, $civils = false, $hit_hro = true) { /* pertes unités */
	/* 'consomme' les dégats en éliminant les unités
	IN : $deg = nb de points de dégats infligés
		 $civils = true pour tuer (aussi) les civils
	OUT: array ('unt' => array(type => nombre des unités perdues),
			'deg_hro' => dégats subit par le héros,
			'hro_reste' => vie restante)
	*/
		$unt = $this->get_unt();
		$pertes = array();
		$bonus = min($this->bonus('vie'), 100); // dégat minoré si bonus unités distance
		$deg_min = $deg * (1 - $bonus / 100);
		$deg_calc = $deg_min;

		foreach($unt as $type => $nb) {
			/* supprimer les unites civiles ?? pas les heros */
			$role = get_conf_gen($this->race, "unt", $type, "role");
			if (($civils || $role != TYPE_UNT_CIVIL) && $role != TYPE_UNT_HEROS) {
				$vie_unt = get_conf_gen($this->race, "unt", $type, "vie");
				$nb_max = round($deg_calc / $vie_unt);
				$pertes[$type] = $this->del_unt($type, $nb_max);
				$deg_calc -= $nb * $vie_unt;
				if ($deg_calc <= 0) break;
			}
		}

		/* gestion du héros :
		mini ATQ_RATIO_HEROS% s'il est bien entouré
		maxi 100% du dégat s'il est tout seul dans la legion
		*/
		$deg_hro = 0; $hro_reste = 0; $ratio = 0; /* initialisation si aucun héros */
		if ($hit_hro && $this->hro('vie')) {
			$ratio = $this->hro('vie_conf') / $this->stats('vie') * ATQ_RATIO_HEROS;
			$deg_hro = ceil($deg * $ratio);
			$hro_reste = max(0, $this->hro('vie') - $deg_hro);
			if ($hro_reste <= 0) { /* tuer le heros, sauf compétence resurrection ! */
				if ($this->comp == CP_RESURECTION) {
					/* ressucité dans la légion */
					$hro_reste = $this->hro('vie_conf');
				} else
					$pertes[$this->hro('type')] = 1;
			}
		}

		return array('deg_sub' => $deg_min, 'deg_rest' => $deg_calc,'degats' => $deg, 'unt' => $pertes, 'bonus_vie' => $bonus,
			'deg_hro' => $deg_hro, 'hro_reste' => $hro_reste, 'hro_ratio' => $ratio);
	} /* fin calcul des pertes unités & héros */

	function edit($new) {
		global $_sql;
		$etat = 0; $vit = 0; $cid = 0;
		$dest = -1; $xp = 0; $fat = 0; $leg_name = '';

		// editer aussi le heros si existe
		if ($this->hid) {
			$edit_hro = array();
			if(isset($new['hro_name']))
				$edit_hro['name'] = $new['hro_name'];
			if(isset($new['hro_type']))
				$edit_hro['type'] = $new['hro_type'];
			if(isset($new['hro_lid']))
				$edit_hro['lid'] = $new['hro_lid'];
			if(isset($new['xp']))
				$edit_hro['xp'] = $new['xp'];
			if(isset($new['bonus']))
				$edit_hro['bonus'] = $new['bonus'];
			if(isset($new['bonus_from']))
				$edit_hro['bonus_from'] = $new['bonus_from'];
			if(isset($new['bonus_to']))
				$edit_hro['bonus_to'] = $new['bonus_to'];
			if(isset($new['hro_vie'])){
				$edit_hro['vie'] = $new['hro_vie'];
				if($edit_hro['vie'] == 0) // héros mort = annuler son bonus
					$edit_hro['bonus'] = 0;
			}
			if (!empty($edit_hro))
				edit_hero($this->mid, $edit_hro);
		}

		if(isset($new['etat'])) {
			$etat = protect($new['etat'], "uint");
			$this->etat = $etat;
			$this->infos['leg_etat'] = $etat;
		}
		if(isset($new['vit'])) {
			$vit = protect($new['vit'], "uint");
			$this->infos['leg_vit'] = $vit;
		}
		if(isset($new['dest'])) {
			$dest = protect($new['dest'], "uint");
			$this->infos['leg_dest'] = $dest;
		}
		if(isset($new['cid'])) {
			$cid = protect($new['cid'], "uint");
			$this->cid = $cid;
			$this->infos['leg_cid'] = $cid;
		}
		if(isset($new['name'])) {
			$leg_name = trim(protect($new['name'], "string"));
			$this->infos['leg_name'] = $leg_name;
		}

		if(!$etat && !$vit && !$dest && !$leg_name)
			return 0;

		$sql = "UPDATE ".$_sql->prebdd."leg SET ";
		if($etat) $sql.= "leg_etat = $etat,";
		if($vit) $sql.= "leg_vit = $vit,";
		if($dest>=0) $sql.= "leg_dest = $dest,";
		if($cid) $sql.= "leg_cid = $cid,leg_stop=NOW(),"; // position ET heure d'arrivée!
		if($leg_name) $sql.= "leg_name = '$leg_name',";
		$sql = substr($sql, 0, strlen($sql) - 1);
		$sql .= " WHERE leg_mid = {$this->mid} AND leg_id = {$this->lid} ";

		$_sql->query($sql);
		return $_sql->affected_rows();
	}

	function move($dest) {
		// donne la destination et la vitesse, et fait le départ sans attendre le tour
		global $_sql;
		$new = array('vit' => $this->vitesse(), 'dest' => $dest, 'etat' => LEG_ETAT_DPL);
		$this->edit($new);
	}

} /* fin classe légion */


class leg_gen extends legion { /* surcharge du constructeur pour 1 légion ... */

	function __construct($leg, $unt = array(), $res = array()){ /* les 'data' dans les tableaux */
		$this->infos = $leg;
		$this->mid = $this->infos['mbr_mid'];
		$this->race = $this->infos['mbr_race'];
		$this->cid = $this->infos['leg_cid'];
		$this->lid = $this->infos['leg_id'];
		$this->etat = $this->infos['leg_etat'];
		if($this->infos['hro_id']) { // récupérer la vie du héros
			$this->hid = $this->infos['hro_id'];
			$this->infos['hro_vie_conf'] = get_conf_gen($this->race, 'unt', $this->hro('type'), 'vie');
			$this->comp = $this->infos['bonus'];
		}

		if(is_array($unt)) {
			$this->unt = $unt; // définir les unités si on connait
			$this->w_load_unt = true;
		} else
			$this->w_load_unt = (bool) $unt;

		if(is_array($res)) {
			$this->res = $res; // les ressources de la légion si on connait
			$this->w_load_res = true;
		} else
			$this->w_load_res = (bool) $res;
		return true;
	}
	function __destruct() { parent::__destruct(); }

} /* fin classe leg_gen extends legion */



class legions { /* classe pour plusieurs légions ... */
	public  $legs = array(); // tableau d'objets
	public  $vlg_lid = 0; // id légion du village
	public  $btc_lid = 0; // id legion batiments
	public  $mid = 0; // mid du joueur si toutes les légions ont le même mid
	public  $cid = 0; // si toutes les légions sont à la même place
	public  $cids = array(); // emplacements de chaque légion
	public  $lids = array(); // liste des id des légions
	private $load_res = false;
	private $load_unt = false;

	function __construct($cond, $unt = false, $res = false){ /* plusieurs légions objet */
		/* $cond = tableau des critères pour la fonction get_leg_gen :
		$cond['mid'] pour toutes les légions du joueur $mid
		$cond['lid'] = tableau lid des légions
		$cond['cid'] toutes les légions à cette position
		$cond['etat'] = filtre les légions sur leur état (tableau)
		*/
		$cond['leg'] = true;
		$cond['mbr'] = true;
		if(isset($cond['etat']))
			$cond['etat'] = protect($cond['etat'], array('uint'));
		else
			$cond['etat'] = array(LEG_ETAT_VLG, LEG_ETAT_GRN, LEG_ETAT_POS,
				LEG_ETAT_DPL, LEG_ETAT_ALL, LEG_ETAT_RET, LEG_ETAT_ATQ);

		$leg_array = get_leg_gen($cond); // récupérer les légions

		if(empty($leg_array)) return false;
		// initialisation
		$this->mid = $leg_array[0]['mbr_mid'];
		$this->cid = $leg_array[0]['leg_cid'];

		foreach($leg_array as $leg){
			$this->lids[$leg['leg_id']]  = $leg['leg_id'];  // lister les légions trouvées
			$this->cids[$leg['leg_cid']] = $leg['leg_cid']; // lister les emplacements
			if($this->mid != $leg['mbr_mid']) $this->mid = 0; // plusieurs joueurs
			if($this->cid != $leg['leg_cid']) $this->cid = 0; // plusieurs positions
			if($leg['leg_etat'] == LEG_ETAT_VLG)
				$this->vlg_lid = $leg['leg_id']; // la légion au village
			else if($leg['leg_etat'] == LEG_ETAT_BTC)
				$this->btc_lid = $leg['leg_id']; // legion batiments
		}

		if($res)
			$res_leg = $this->get_all_res();
		else
			$res_leg = array();

		if($unt)
			$unt_leg = $this->get_all_unts();
		else
			$unt_leg = array();

		foreach($leg_array as $leg){ // définir les objets legion
			$lid = $leg['leg_id'];
			if(!$unt) $unt_leg[$lid] = false; // non initialisé
			else if(!isset($unt_leg[$lid])) $unt_leg[$lid] = true;
			if(!$res) $res_leg[$lid] = false; // non initialisé
			else if(!isset($res_leg[$lid])) $res_leg[$lid] = true;
			$this->legs[$lid] = new leg_gen($leg, $unt_leg[$lid], $res_leg[$lid]);
		}
		return true;
	}

	function get_all_unts(){// toutes les unités pour ces légions
		$unt_leg = array();
		if ($this->load_unt){// déjà chargé
			foreach($this->legs as $leg)
				$unt_leg[$leg->lid] = $leg->get_unt();
		} elseif ($this->lids) {
			$cond = array('unt' => true, 'leg' => $this->lids);
			$unt_array = get_leg_gen($cond);
			foreach($unt_array as $values) // rassembler les unités par $lid
				$unt_leg[$values['unt_lid']][$values['unt_type']] = $values['unt_nb'];
			$this->load_unt = true;
		}
		return $unt_leg;
	}

	function get_all_res(){ // toutes les ressources des légions sélectionnées
		$res_leg = array();
		if ($this->load_res){// déjà chargé
			foreach($this->legs as $leg)
				$res_leg[$leg->lid] = $leg->get_res();
		} elseif ($this->lids) {
			global $_sql;
			$sql = "SELECT lres_type, lres_nb, lres_lid ";
			$sql.= "FROM ".$_sql->prebdd."leg_res ";
			$sql.= "WHERE lres_lid IN(".implode(',',$this->lids).') AND lres_nb <> 0 ';
			$res_array = $_sql->make_array($sql);
			foreach($res_array as $values) // rassembler les ressources par $lid
				$res_leg[$values['lres_lid']][$values['lres_type']] = $values['lres_nb'];
			$this->load_res = true;
		}
		return $res_leg;
	}

	function hasUntByRole($role){ // oui si au moins une légion a une unité de ce rôle
		foreach($this->legs as $leg){
			$unts = $leg->getUntByRole($role);
			if(!empty($unts))
				return true;
		}
		return false;
	}

	function get_cids($dst = false) { // get_square pour toutes les légions
	/* $dst = true pour la distance au village
	ou array(x=>xx, y=>yy)  pour distance Ã  {xx,yy} */
		$squares = get_square_gen($this->cids, $dst);
		$this->cids = array();
		foreach ($squares as $key => $sqr)
			$this->cids[$sqr['map_cid']] = $sqr;

		foreach($this->legs as $leg)
			if (isset($this->cids[$leg->cid]))
				$leg->sqr = &$this->cid;
		return $this->cids;
	}

	function get_all_legs_infos(){
		$legs = array();
		foreach($this->legs as $leg)
			$legs[$leg->lid] = $leg->infos;
		return $legs;
	}

	function flush_all_units($unt = array()) { 
		global $_sql;
		// MAJ edit unités : $unt = autre légion à MAJ aussi (leg bât par exemple)
		foreach($this->legs as $lid => $leg) // récup toutes modifs des légions
			$unt[$lid] = $leg->flush_edit_unt(true);

		$sql_list = array();
		foreach($unt as $lid => $leg)
			foreach($leg as $rang => $value)
				foreach($value as $type => $nb) {
					$rang = protect($rang, "uint");
					$type = protect($type, "uint");
					$nb = protect($nb, "int") ;
					$sql_list[] =  "($lid, $type, $rang, $nb)";
				}
		if (!empty($sql_list)) {
			$sql = "INSERT INTO ".$_sql->prebdd."unt (unt_lid, unt_type, unt_rang, unt_nb) ";
			$sql.= "VALUES ".implode(',',$sql_list);
			$sql.= " ON DUPLICATE KEY ";
			$sql.= "UPDATE unt_nb = unt_nb + VALUES(unt_nb) ";
			return $_sql->query($sql);
		}
	}



} /* fin classe legions */

/* FIN DES NOUVEAUX OBJETS LEGION */



/* Gestion des légions */
function add_leg($mid, $cid, $etat, $name) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$cid = protect($cid, "uint");
	$etat = protect($etat, "uint");
	$name = protect($name, "string");
	
	$sql = "INSERT INTO ".$_sql->prebdd."leg (leg_id, leg_mid, leg_cid, leg_etat, leg_name)" .
		"VALUES (NULL,$mid, $cid, $etat, '$name') ";
	
	$res = $_sql->query($sql);
	
	return $_sql->insert_id();
}

function del_leg_unt($mid, $lid = 0) {
	global $_sql;
	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");
	
	$sql = "DELETE FROM ".$_sql->prebdd."unt WHERE unt_lid ";
	if($lid)
		$sql.= "= $lid";
	else
		$sql.= "IN (SELECT leg_id FROM ".$_sql->prebdd."leg WHERE leg_mid = $mid)";
	
	$_sql->query($sql);
	return $_sql->affected_rows();
}

function del_leg_res($mid, $lid = 0) {
	global $_sql;
	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");
	
	$sql = "DELETE FROM ".$_sql->prebdd."leg_res WHERE lres_lid ";
	if($lid)
		$sql.= "= $lid";
	else
		$sql.= "IN (SELECT leg_id FROM ".$_sql->prebdd."leg WHERE leg_mid = $mid)";

	$_sql->query($sql);
	$nb = $_sql->affected_rows();
}

function del_leg($mid, $lid = 0) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");

	$nb = del_leg_unt($mid, $lid);
	$nb+= del_leg_res($mid, $lid);

	$sql = "DELETE FROM ".$_sql->prebdd."leg ";
	$sql.= "WHERE leg_mid = $mid ";
	if($lid)
		$sql.= " AND leg_id = $lid ";
		
	$_sql->query($sql);
	
	return $_sql->affected_rows() + $nb;
}

function get_leg_dst_vlg($x, $y, $near) {
	global $_sql;
	$x = protect($x, "uint");
	$y = protect($y, "uint");
	$near = protect($near, "uint");
	
	$sql = "SELECT leg_name, mbr_pseudo, mbr_gid, ";
	$sql.= "a.map_x AS dst_x, a.map_y AS dst_y, leg_dest, mbr_mid, ";
	$sql.= "b.map_x, b.map_y , leg_cid ";
	$sql.= "FROM ".$_sql->prebdd."map AS a ";
	$sql.= "JOIN ".$_sql->prebdd."leg  ON leg_dest = a.map_cid ";
	$sql.= "JOIN ".$_sql->prebdd."map AS b ON leg_cid = b.map_cid ";
	$sql.= "JOIN ".$_sql->prebdd."mbr ON mbr_mid = leg_mid ";
	$sql.= "WHERE a.map_x BETWEEN ".($x-$near)." AND ".($x+$near)." ";
	$sql.= "AND a.map_y BETWEEN ".($y-$near)." AND ".($y+$near)." ";
	$sql.= " AND mbr_etat = ".MBR_ETAT_OK." AND leg_etat = ".LEG_ETAT_DPL. " ";
	
	return $_sql->make_array($sql);
}

function get_leg_gen($cond) {
	global $_sql;
	
	$mid = 0;
	$leg = array();
	$unt = array();
	$etat = array();
	$get_unt = false; /* Pour avoir des infos sur les unités */
	$get_leg = false; /* Pour avoir des infos sur la legion */
	$cid = 0;
	$dest = 0; // destination d'une légion
	$rang = 0;
	$sum = false; /* Fait la somme des unités du même type */
	$count_unt = false;
	$mbr = false; /* informations membre */
	$map = false; /* afficher des infos supplémentaires de la carte (x y) */

	if(isset($cond['count_unt']))
		$count_unt = true;
	if(isset($cond['map']))
		$map = true;

	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	if(isset($cond['unt'])) {
		$unt = protect($cond['unt'], array('uint'));
		$get_unt = true;
	}
	if(isset($cond['leg'])) {
		$leg = protect($cond['leg'], array('uint'));
		$get_leg = true;
	}
	if(isset($cond['etat']))
		$etat = protect($cond['etat'], array('uint'));
	if(isset($cond['cid'])){
		$cid = protect($cond['cid'], "uint");
		$get_leg = true;
	}
	if(isset($cond['dest'])){
		$dest = protect($cond['dest'], "uint");
		$get_leg = true;
	}
	if(isset($cond['sum']))
		$sum = protect($cond['sum'], "bool");
	if(isset($cond['mbr']))
		$mbr = protect($cond['mbr'], "bool");
	if(isset($cond['rang']))
		$rang = protect($cond['rang'], "uint");
	
	if(!$get_leg && !$get_unt && !$sum) return array(); /* Rien a faire */
	
	$sql = "SELECT ";
	
	if($sum) {
		$sql.= "unt_type, unt_rang, SUM(unt_nb) as unt_sum ";
	} else if(!$get_leg || !$get_unt) {
		if($get_leg) {
			$sql.= "leg_id, leg_mid, leg_cid, leg_etat, leg_vit, leg_name, leg_xp, leg_dest, leg_tours, leg_fat, leg_stop ";
			if(!$get_unt && $count_unt)
				$sql.=", SUM(unt_nb) as unt_nb ";
			else if ($map)
				$sql.=', p.map_x map_x, p.map_y map_y, d.map_x dest_x, d.map_y dest_y ';
			else if ($dest || $mbr)
				$sql .= ', mbr_pseudo, mbr_gid, mbr_mid, mbr_race, mbr_etat ';
			if(!$get_unt && !$count_unt)
				$sql .= ', hro_id, hro_nom, hro_type, hro_xp, hro_vie, hro_bonus AS bonus, hro_bonus_from, hro_bonus_to AS bonus_to ';
		}
		if($get_leg && $get_unt) $sql .= ",";
		if($get_unt) $sql.= "unt_type, unt_rang, unt_nb ";
	} else
		$sql.= "* ";

	if(!$get_unt) {
		$sql.= "FROM ".$_sql->prebdd."leg ";
		if($count_unt || $sum) {
			$sql.= " LEFT JOIN ".$_sql->prebdd."unt ON leg_id = unt_lid ";
		} else if ($map) {
			$sql.=' JOIN '.$_sql->prebdd.'map AS p ON p.map_cid = leg_cid ';
			$sql.=' LEFT JOIN '.$_sql->prebdd.'map AS d ON d.map_cid = leg_dest ';
		} else if ($dest || $mbr) {
			$sql.= "JOIN ".$_sql->prebdd."mbr ON mbr_mid = leg_mid ";
		}
		if ($get_leg && !$count_unt && !$sum) {
			$sql .= 'LEFT JOIN '.$_sql->prebdd.'hero ON leg_id = hro_lid ';
		}
 	} else {
		$sql.= "FROM ".$_sql->prebdd."unt ";
		$sql.= "JOIN ".$_sql->prebdd."leg ON leg_id = unt_lid ";
	}

	if($unt)
		$sql.= "WHERE unt_nb > 0 AND ";
	else	if($etat || $unt || $leg || $mid || $cid || $dest)
		$sql.= "WHERE ";

	if($mid)
		$sql.= "leg_mid = $mid AND ";
	
	if($leg)
		$sql.= "leg_id IN (".implode(',',$leg).') AND ';
	
	if($unt)
		$sql.= "unt_type IN (".implode(',',$unt).') AND ';
	
	if($get_unt)
		$sql .= "unt_nb > 0 AND ";
	
	if($etat)
		$sql.= "leg_etat IN (".implode(',',$etat).') AND ';
	
	if($cid)
		$sql.= "leg_cid = $cid AND ";
	if($dest)
		$sql.= "leg_dest = $dest AND ";
		
	if($rang)
		$sql.= "unt_rang = $rang AND ";
		
	$sql = substr($sql, 0, strlen($sql)-4); /* On vire le AND en trop */
	
	if($sum || $count_unt){
		$sql.= "GROUP BY ";
		if($sum)
			$sql.= " unt_type ".($count_unt ? ',':'');
		if($count_unt)
			$sql.= " leg_id ";
	}

	if($get_unt or $sum) // leg_stop: classement par ordre d'arrivée
		$sql.= "ORDER BY leg_stop, unt_rang ";
	else
		$sql.= "ORDER BY leg_stop ";

	return $_sql->make_array($sql);
}

/* Gestion des unités */

/* Toutes les légions ennemies se dirigeant vers $dest (cid) ou déjà sur place */
function get_leg_dest($mid, $dest) {
	global $_sql;
	$mid = protect($mid, "uint");
	$dest = protect($dest, "uint");
	
	$sql = "SELECT leg_name, leg_id, mbr_pseudo, mbr_race, mbr_gid, ambr_aid, al_name, hro_bonus, leg_cid, ";
	$sql.= "a.map_x, a.map_y, leg_dest, mbr_mid ";
	$sql.= "FROM ".$_sql->prebdd."leg ";
	$sql.= "JOIN ".$_sql->prebdd."mbr ON mbr_mid = leg_mid ";
	$sql.= "LEFT JOIN ".$_sql->prebdd."al_mbr ON ambr_mid = leg_mid ";
	$sql.= "LEFT JOIN ".$_sql->prebdd."al ON al_aid = ambr_aid ";
	$sql.=" LEFT JOIN ".$_sql->prebdd."hero ON leg_id = hro_lid ";
	$sql.= "LEFT JOIN ".$_sql->prebdd."map AS a ON leg_cid = a.map_cid ";
	$sql.= "WHERE (leg_cid = $dest OR leg_dest = $dest) ";
	$sql.= "AND mbr_mid <> $mid ";
	$sql.= " AND mbr_etat = ".MBR_ETAT_OK;
	
	return $_sql->make_array($sql);
}
/* Toutes les légions au village sauf batiments (du moins sur la case cid)
function get_legions_vlg_all($mid, $cid) {
	$leg = get_leg_gen(array('mid' => $mid, 'sum' => true, 'cid' => $cid));
	foreach($leg as $key => $unt) $leg[$key]['unt_nb'] = $unt['unt_sum'];
	return $leg;
} */
/* Toutes les légions sauf village et batiments (état par défaut) */
function get_legions($mid, $etat = array(LEG_ETAT_GRN, LEG_ETAT_POS, LEG_ETAT_DPL, 
			LEG_ETAT_ALL, LEG_ETAT_RET, LEG_ETAT_ATQ)) {
	return get_leg_gen(array('mid' => $mid, 'leg' => true, 'etat' => $etat));
}
/* Toutes les légions & leurs unités, sauf village et batiments (état par défaut) */
function get_legions_unt($mid, $etat = array(LEG_ETAT_GRN, LEG_ETAT_POS, LEG_ETAT_DPL, 
			LEG_ETAT_ALL, LEG_ETAT_RET, LEG_ETAT_ATQ)) {
	return get_leg_gen(array('mid' => $mid, 'leg' => true, 'count_unt' => true, 'etat' => $etat));
}
function get_leg_map($mid, $etat = array(LEG_ETAT_GRN, LEG_ETAT_POS, LEG_ETAT_DPL, 
			LEG_ETAT_ALL, LEG_ETAT_RET, LEG_ETAT_ATQ)) {
	return get_leg_gen(array('mid' => $mid, 'leg' => true, 'etat' => $etat, 'map' => true));
}

/* Toutes les légions alliés en déplacement (état par défaut) */
function get_leg_dpl($mid, $etat = array(LEG_ETAT_RET, LEG_ETAT_ALL, LEG_ETAT_DPL)){
	global $_sql;
	$mid = protect($mid, "uint");
	$etat = protect($etat, array('uint'));
	
	$sql = " SELECT leg_name, leg_mid, leg_cid, leg_etat, leg_id, leg_vit, mbr_dest.mbr_pseudo AS pseudo_dest, mbr_dest.mbr_race AS race_dest, mbr_dest.mbr_mid AS mid_dest, leg_dest,";
	$sql.= " lres_type, lres_nb,";
	$sql.= " pst.map_x AS leg_x, pst.map_y AS leg_y,";
	$sql.= " dest.map_x AS dest_x, dest.map_y AS dest_y";
	$sql.= " FROM ".$_sql->prebdd."leg ";
	$sql.= " JOIN ".$_sql->prebdd."mbr AS mbr_dest ON mbr_dest.mbr_mapcid = leg_dest ";
	$sql.= " JOIN ".$_sql->prebdd."leg_res ON lres_lid = leg_id AND lres_type = ".GAME_RES_BOUF." ";
	$sql.= " JOIN ".$_sql->prebdd."map AS pst ON pst.map_cid = leg_cid ";
	$sql.= " LEFT JOIN ".$_sql->prebdd."map AS dest ON dest.map_cid = leg_dest";
	$sql.= " WHERE leg_mid = $mid";
	$sql.= " AND leg_etat IN (".implode(',',$etat).") ";
	
	return $_sql->make_array($sql);
}

function get_leg_pos($mid){
	global $_sql;
	$mid = protect($mid, "uint");
	
	$sql = "SELECT leg_name, leg_mid, leg_cid, leg_etat, leg_id, leg_vit, mbr_pseudo AS dest_pseudo, mbr_dest.mbr_race AS race_dest, mbr_dest.mbr_mid AS mid_dest, ";
	$sql.= " lres_type, lres_nb ";
	$sql.= " FROM ".$_sql->prebdd."leg ";
	$sql.= " JOIN ".$_sql->prebdd."mbr AS mbr_dest ON mbr_dest.mbr_mapcid = leg_cid ";
	$sql.= " JOIN ".$_sql->prebdd."leg_res ON lres_lid = leg_id AND lres_type = ".GAME_RES_BOUF." ";
	$sql.= " WHERE leg_mid = $mid";
	$sql.= " AND leg_etat = ".LEG_ETAT_POS." ";
	
	return $_sql->make_array($sql);
}

/* Toutes les unités faites */
function get_unt_total($mid, $unt = array()) {
	return get_leg_gen(array('mid' => $mid, 'unt' => $unt, 'sum' => true));
}

/* Les unités faites, mais au village */
function get_unt_done($mid, $unt = array()) {
	return get_leg_gen(array('mid' => $mid, 'unt' => $unt, 'etat' => array(LEG_ETAT_VLG)));
}

/* Les unités faites, dans des bâtiments */
function get_unt_btc($mid, $unt = array()) {
	return get_leg_gen(array('mid' => $mid, 'unt' => $unt, 'etat' => array(LEG_ETAT_BTC)));
}

/* Les unités en formations */
function get_unt_todo($mid, $cond = array()) {
	global $_sql;
	$unt = array();
	$uid = 0;
	$cond = protect($cond, "array");
	if(isset($cond['unt']))
		$unt = protect($cond['unt'], "array");
	if(isset($cond['uid']))
		$uid = protect($cond['uid'], "uint");

	$sql = "SELECT utdo_id, utdo_type, utdo_nb FROM ".$_sql->prebdd."unt_todo ";
	$sql.= "WHERE utdo_mid = $mid AND utdo_nb > 0 ";
	
	if($uid) {
		$sql.= "AND utdo_id = $uid ";
	}
	if($unt) {
		$sql.= "AND unt_type IN (";
		foreach($unt as $unt_type) {
			$unt_type = protect($unt_type, "uint");
			$sql.= "$unt_type,";
		}
		
		$sql = substr($sql, 0, strlen($sql)-1);
		$sql.= ") ";
	}
	
	$sql.= " ORDER BY utdo_id ASC ";
	return $_sql->make_array($sql);
}

/* Verifie qu'on peut faire $nb unités du type $type */
function can_unt($mid, $type, $nb, $cache = array()) {
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	$cache = protect($cache, "array");

	$bad_src = array();
	$bad_res = array();
	$bad_btc = array();
	$bad_unt = array();
	$limit_unt = 0;

	if(!get_conf("unt", $type))
		return array("do_not_exist" => true);
	
	/* Bâtiments */
	$need_btc = get_conf("unt", $type, "need_btc");
	$cond_btc = $need_btc;
	
	if(!isset($cache['btc'])) {
		$have_btc = get_nb_btc_done($mid, $cond_btc);
		$have_btc = index_array($have_btc, "btc_type");
	} else
		$have_btc = $cache['btc'];
	
	/* Recherches */
	$cond_src = array($type);

	$need_src = get_conf("unt", $type, "need_src");
	$cond_src = $need_src;

	if(!isset($cache['src'])) {
		$have_src = get_src_done($mid, $cond_src);
		$have_src = index_array($have_src, "src_type");
	} else
		$have_src = $cache['src'];
	
	
	/* Ressources */
	$prix_res = get_conf("unt", $type, "prix_res");
	$cond_res = array_keys($prix_res);
	
	if(!isset($cache['res'])) {
		$have_res = get_res_done($mid, $cond_res);
		$have_res = clean_array_res($have_res);
		$have_res = $have_res[0];
	} else
		$have_res = $cache['res'];
		
	/* Unités */
	$prix_unt = get_conf("unt", $type, "prix_unt");
	$cond_unt = array_keys($prix_unt);
	
	$limite = get_conf("unt", $type, "limite");
	if($limite)
		$cond_unt += array($type);
	
	if(!isset($cache['unt'])) {
		$cond = array('mid' => $mid, 'unt' => array(), 'leg' => true);
		$unt_tmp = get_leg_gen($cond);
		foreach($unt_tmp as $value) {
			$t_type = $value['unt_type'];
			$t_nb = $value['unt_nb'];
			$t_etat = $value['leg_etat'];
			if($t_etat == LEG_ETAT_VLG) {
				if(!isset($have_unt[$t_type]))
					$have_unt[$t_type]['unt_nb'] = 0;
				$have_unt[$t_type]['unt_nb'] += $t_nb;
			} else {
				if(!isset($have_unt_leg[$t_type]))
					$have_unt_leg[$t_type] = 0;
				$have_unt_leg[$t_type] += $t_nb;
			}
		}
	} else {
		var_dump($cache['unt']);
		$have_unt = $cache['unt'];
		$have_unt_leg = $cache['unt_leg'];
	}

	if(!isset($cache['unt_todo'])) {
		$have_unt_todo = get_unt_todo($mid, $type);
		$have_unt_todo = index_array($have_unt_todo, "unt_todo");
	} else
		$have_unt_todo = $cache['unt_todo'];
		
	/* Les recherches qu'il faut avoir */
	foreach($need_src as $src_type) {
		if(!isset($have_src[$src_type]))
			$bad_src['need_src'][] = $src_type;
	}

	/* Vérifications ressources */
	foreach($prix_res as $res_type => $nombre) {
		$diff =  $nombre * $nb - $have_res[$res_type];
		if($diff > 0) {
			$bad_res[$res_type] =  $diff;
		}
	}

	/* Les unités */
	foreach($prix_unt as $unt_type => $nombre) {
		if(!isset($have_unt[$unt_type]))
			$diff = $nombre * $nb;
		else
			$diff = $nombre * $nb - $have_unt[$unt_type];

		if($diff > 0) {
			$bad_unt[$unt_type] =  $diff;
		}
	}
	
	/* Verifications Bâtiments */
	foreach($need_btc as $btc_type) {
		if(!isset($have_btc[$btc_type]))
			$bad_btc[] = $cond_btc;
	}

	/* La limite */
	$unt_nb = 0;
	if(isset($have_unt[$type])){
		var_dump($have_unt[$type]);
		$unt_nb += $have_unt[$type]['unt_nb'];
	}
	if(isset($have_unt_leg[$type]))
		$unt_nb += $have_unt_leg[$type]['unt_nb'];
	if(isset($have_unt_todo[$type]['utdo_nb']))
		$unt_nb += $have_unt_todo[$type]['utdo_nb'];

	if($limite && $unt_nb >= $limite)
		$limit_unt = $limite;

	return array('need_src' => $bad_src, 'need_btc' => $bad_btc, 'prix_res' => $bad_res,  'prix_unt' => $bad_unt, 'limit_unt' => $limit_unt);
}

/* vérifications pour renommer une légion */
function can_ren_leg($mid, $lid, $leg_name){
	global $_sql;

	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");
	$leg_name = trimUltime(protect($leg_name, "string"));

	if(!$mid || !$leg_name)
		return false;

	$sql = "SELECT COUNT(*) AS leg_cnt FROM ".$_sql->prebdd."leg ";
	$sql .= " WHERE leg_mid = $mid AND leg_id <> $lid ";
	$sql .= " AND leg_name LIKE '$leg_name'";
	//$sql .= " AND leg_name LIKE CONVERT( _utf8 '$leg_name' USING latin1 ) COLLATE latin1_swedish_ci";

	$res = $_sql->query($sql);
	return ($_sql->result($res, 0, 'leg_cnt') == 0);

}

function edit_leg($mid, $lid, $new = array()) {
	global $_sql;
	$etat = 0; $vit = 0; $cid = 0;
	$dest = -1; $xp = 0; $fat = 0; $leg_name = '';

	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");
	
	if(isset($new['etat']))
		$etat = protect($new['etat'], "uint");
	if(isset($new['vit']))
		$vit = protect($new['vit'], "uint");
	if(isset($new['dest']))
		$dest = protect($new['dest'], "uint");
	if(isset($new['cid']))
		$cid = protect($new['cid'], "uint");
	if(isset($new['xp']))
		$xp = protect($new['xp'], "int");
	if(isset($new['fat']))
		$fat = protect($new['fat'], "int");
	if(isset($new['name']))
		$leg_name = trim(protect($new['name'], "string"));

	if(!$mid || !$lid || (!$etat && !$vit && !$dest && !$xp && !$fat && !$leg_name))
		return 0;

	$sql = "UPDATE ".$_sql->prebdd."leg SET ";
	if($etat) $sql.= "leg_etat = $etat,";
	if($vit) $sql.= "leg_vit = $vit,";
	if($xp) $sql.= "leg_xp = leg_xp + $xp,";
	if($fat) $sql.= "leg_fat = leg_fat + $fat,";
	if($dest>=0) $sql.= "leg_dest = $dest,";
	if($cid) $sql.= "leg_cid = $cid,";
	if($leg_name) $sql.= "leg_name = '$leg_name',";
	$sql = substr($sql, 0, strlen($sql) - 1);
	$sql .= " WHERE leg_mid = $mid AND leg_id = $lid ";

	$_sql->query($sql);
	return $_sql->affected_rows();
}

/* Modifications des unités dans le village*/
function edit_unt_vlg($mid, $unt, $factor = 1) {
	return edit_unt_gen($mid, LEG_ETAT_VLG, $unt, $factor);
}

/* Modifications des unités dans les bâtiments */
function edit_unt_btc($mid, $unt, $factor = 1) {
	return edit_unt_gen($mid, LEG_ETAT_BTC, $unt, $factor);
}

/* A n'utiliser que sur les légions avec les états VLG et BTC !! */
function edit_unt_gen($mid, $etat, $unt, $factor = 1) {
	global $_sql, $_user;

	$mid = protect($mid, "uint");
	$etat = protect($etat, "uint");
	$unt = protect($unt, "array");
	$factor = protect($factor, "float");

	if(!$unt || ($etat != LEG_ETAT_VLG && $etat != LEG_ETAT_BTC))
		return 0;
	
	$sql = "SELECT leg_id FROM ".$_sql->prebdd."leg WHERE leg_mid = $mid AND leg_etat = $etat";
	$res = $_sql->query($sql);
	if($res && $_sql->num_rows($res) > 0)
		$lid = $_sql->result($res, 0, 'leg_id');
	else{
		if(SITE_DEBUG) echo "edit_unt_gen KO: mid=$mid etetat=$etat";
		return 0;
	}

	$sql = "";
	foreach($unt as $type => $nb) {
		$nb = protect($nb, "int") * $factor;
		$type = protect($type, "uint");
		$race = isset($_user['mbr_race']) ? $_user['mbr_race'] : $_user['race'];
		if(get_conf_gen($race, "unt", $type, 'role') == TYPE_UNT_CIVIL)
			$rang = 0;
		else // rechercher le rang pour les unités militaires
			$rang = get_conf_gen($race, "unt", $type, 'rang');
		
		if($nb)
			$sql.= "($lid, $type, $rang, $nb),";
	}
	if($sql) {
		$sql = "INSERT INTO ".$_sql->prebdd."unt (unt_lid, unt_type, unt_rang, unt_nb) VALUES ". substr($sql, 0, strlen($sql)-1);
		$sql.= " ON DUPLICATE KEY UPDATE unt_nb = unt_nb + VALUES(unt_nb)";

		$res = $_sql->query($sql);
		return $_sql->affected_rows();
	}
	return 0;
}

/* Peut on rajouter ces unités dans cette légion a ce rang là ? */
function can_add_unt_leg($mid, $lid, $rang, $type, $nb) {
	global $_sql;

	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");
	$rang = protect($rang, "uint");
	$type = protect($type, "uint");
	$nb = protect($nb, "uint");

	if($rang > LEG_MAX_RANG)
		return false;

	$sql = "SELECT leg_etat, unt_rang, unt_type, unt_nb ";
	$sql.= "FROM ".$_sql->prebdd."leg ";
	$sql.= "LEFT JOIN ".$_sql->prebdd."unt ON unt_lid = leg_id ";
	$sql.= "WHERE leg_mid = $mid AND leg_id = $lid ";

	$have_leg = $_sql->make_array($sql);

	if(!$have_leg || !in_array($have_leg[0]['leg_etat'], array( LEG_ETAT_GRN)))
		return false; /* Légion qui n'existe pas ou pas en formation */

	if($nb > LEG_MAX_RANG_UNT)
		return false;

	$rang_same = 1;
	foreach($have_leg as $values) { /* Rang avec la même unité */
		if($values['unt_type'] == $type)
			$rang_same++;
	}

	foreach($have_leg as $values) {
		if($values['unt_rang'] == $rang) {
			if($values['unt_type'] == $type && $values['unt_nb'] + $nb <= LEG_MAX_RANG_UNT) {
				$rang_same--; /* on utilise un rang déjà fait */
				break; /* faut pas partir de suite, on a des trucs a verifier après */
			} else
				return false;
		}
	}

	if($rang_same > LEG_MAX_RANG_SAME_UNT)
		return false;

	return true; /* Le rang demandé n'est pas pris, et est autorisé */
}

// retrouver à quel rang sont les unités du type.
function find_rang($leg_array, $type) {
	foreach($leg_array as $key => $unit)
		if($unit['unt_type']==$type)
			return $key;
	return count($leg_array)+1;
}

/* Ajout d'unités dans une légion */
function add_unt_leg($mid, $lid, $rang, $type, $nb) {
	return edit_unt_leg($mid, $lid, array($rang => array($type => $nb)));;
}

function edit_unt_leg($mid, $lid, $unt, $factor = 1) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");
	$unt = protect($unt, "array");
	$factor = protect($factor, "int");
	
	if(!$unt || !$factor)
		return;

	$sql = "INSERT INTO ".$_sql->prebdd."unt (unt_lid, unt_type, unt_rang, unt_nb) ";
	$sql.= "VALUES ";
	foreach($unt as $rang => $value) {
		$rang = protect($rang, "uint");
		foreach($value as $type => $nb) {
			$type = protect($type, "uint");
			$nb = protect($nb, "int") * $factor;
			$sql.=  "($lid, $type, $rang, $nb),";
		}
	}
	$sql = substr($sql, 0, strlen($sql) - 1);
	$sql.= " ON DUPLICATE KEY ";
	$sql.= "UPDATE unt_nb = unt_nb + VALUES(unt_nb) ";
	return $_sql->query($sql);
}

function del_rang($lid, $rang) {
	global $_sql;

	$lid = protect($lid, "uint");
	$rang = protect($rang, "uint");
	
	$sql = "DELETE FROM ".$_sql->prebdd."unt WHERE unt_lid = $lid AND unt_rang = $rang ";
	$_sql->query($sql); $nb = $_sql->affected_rows();
	
	/*$sql = "UPDATE ".$_sql->prebdd."unt SET unt_rang = unt_rang - 1 WHERE unt_lid = $lid AND unt_rang > $rang ";
	$_sql->query($sql);*/
	
	return $_sql->affected_rows() + $nb;
}

function get_res_leg($mid, $lid = 0) {
	global $_sql;

	$mid = protect($mid, "uint");
	$lid = protect($lid, "uint");

	$sql = "SELECT lres_type, lres_nb, lres_lid ";
	$sql.= "FROM ".$_sql->prebdd."leg ";
	$sql.= "JOIN ".$_sql->prebdd."leg_res ON leg_id = lres_lid ";
	$sql.= "WHERE leg_mid = $mid ";
	if($lid) $sql.= " AND leg_id = $lid ";

	return $_sql->make_array($sql);
}

function mod_res_leg($lid, $res) {
	global $_sql;
	
	$lid = protect($lid, "uint");
	$res = protect($res, "array");
	
	if(!$res)
		return;
		
	$sql = "INSERT INTO ".$_sql->prebdd."leg_res (lres_lid, lres_type, lres_nb) ";
	$sql.= "VALUES ";
	foreach($res as $type => $nb) {
		$type = protect($type, "uint");
		$nb = protect($nb, "int");
		$sql.= "($lid, $type, $nb),";
	}
	$sql = substr($sql, 0, strlen($sql) -1);
	$sql.= "ON DUPLICATE KEY ";
	$sql.= "UPDATE lres_nb = lres_nb + VALUES(lres_nb) ";
	
	return $_sql->query($sql);
}

/* Met des unités dans la liste des unités a faire */
function scl_unt($mid, $unt) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$unt = protect($unt, "array");

	if(!$unt) return;

	$sql = "INSERT INTO ".$_sql->prebdd."unt_todo VALUES ";
	foreach($unt as $type => $nb) {
		$type = protect($type, "uint");
		$nb = protect($nb, "uint");
		$sql.= " (NULL, $mid, $type, $nb), ";
	}
	
	$sql = substr($sql, 0, strlen($sql)-2); /* On vire la virgule en trop */
	
	return $_sql->query($sql);
}

/* Annule des unités a faire */
function cnl_unt($mid, $uid, $nb) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$uid = protect($uid, "uint");
	$nb = protect($nb, "uint");
	
	$sql = "UPDATE ".$_sql->prebdd."unt_todo SET utdo_nb = utdo_nb - $nb ";
	$sql .= "WHERE utdo_mid = $mid AND utdo_id = $uid AND utdo_nb >= $nb";
	
	$res = $_sql->query($sql);
	
	return $_sql->affected_rows();
}

/* Initialisation des unités */
function ini_unt($mid, $cid, $vlg) {
	
	add_leg($mid, $cid, LEG_ETAT_VLG, $vlg);
	add_leg($mid, $cid, LEG_ETAT_BTC, $vlg);
	
	$debut = get_conf("race_cfg", "debut", "unt");
	edit_unt_vlg($mid, $debut);
}

/* Quand le membre part */
function cls_unt($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	
	$nb = del_leg($mid);
	
	$sql = "DELETE FROM ".$_sql->prebdd."unt_todo WHERE utdo_mid = $mid";
	$_sql->query($sql);
	
	return $_sql->affected_rows() + $nb;
}

function get_leg_nb($mid, $etat = array()) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$etat = protect($etat, "array");
	foreach($etat as $k => $v)
		$etat[$k] = protect($v, "uint");

	$sql = "SELECT COUNT(*) FROM ".$_sql->prebdd."leg ";
	$sql.= "WHERE leg_mid = $mid ";
	if($etat) {
		$sql.= "AND leg_etat IN (";
		$sql.= implode($etat, ",");
		$sql.= ")";
	}
	return $_sql->result($_sql->query($sql), 0);
}

/* Retourne la population */
function count_pop($mid, $etat = array()) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	$etat = protect($etat, "array");

	$sql = "SELECT SUM(unt_nb) ";
	$sql.= "FROM ".$_sql->prebdd."leg ";
	$sql.= "JOIN ".$_sql->prebdd."unt ON leg_id = unt_lid ";
	$sql.= "WHERE leg_mid = $mid ";
	if($etat)
		$sql.= " AND leg_etat IN (". implode(",", $etat) .")";
	$res = $_sql->query($sql);

	$num_rows = $_sql->num_rows();
	if(!$num_rows)
		return 0;
	else
		return num_rows;
}

/* les légions dans $leg_array peuvent être attaquées par un joueur ($mid) qui a $points, ($groupe) et ally=$alaid */
function leg_can_atq_lite($leg_array, $points, $mid, $groupe, $alaid, $dpl_array = array())
{
	$mid = protect($mid, "uint");
	$points = protect($points, "uint");
	$groupe = protect($groupe, "uint");
	$alaid = protect($alaid, "int");
	$leg_array = protect($leg_array, "array");
	$dpl_array = protect($dpl_array, 'array');

	$arr_cid = array();
	foreach($leg_array as $key => $value)
		if($value['mbr_mid'] == $mid)
			$arr_cid[$value['leg_cid']] = true;

	foreach($leg_array as $key => $value) {
		$pts = $value['mbr_pts_armee'];
		$alid = $value['ambr_aid'];
		$mid2 = $value['mbr_mid'];
		$etat = $value['mbr_etat'];
		$leg_etat = $value['leg_etat'];

		/* si c'est un allié qu'on peut défendre */
		$leg_array[$key]['can_def'] = false;
		if($alid && $alaid){
			if ($alid == $alaid) // même alliance
				$leg_array[$key]['can_def'] = true;
			elseif (isset($dpl_array[$alid]) and 
				($dpl_array[$alid] == DPL_TYPE_MIL or $dpl_array[$alid] == DPL_TYPE_MC)) // a un pacte
				$leg_array[$key]['can_def'] = true;
		}

		if((!$leg_array[$key]['can_def'] // pas allié
			&& (!$alid or !isset($dpl_array[$alid]) or $dpl_array[$alid] != DPL_TYPE_PNA) // pas de PNA
		) && (
			(abs($pts - $points) < ATQ_PTS_DIFF)  /* Trop de points de différences */
			&& ($pts > ATQ_PTS_MIN)  /* Pas assez de points pour attaquer */
			|| ($pts >= ATQ_LIM_DIFF && $points >= ATQ_LIM_DIFF) /* Arène */
		)
		&& can_d(DROIT_PLAY)/* Faut pas être un visiteur */
		&& $etat == MBR_ETAT_OK /* Validé et pas en Veille */
		&& isset($arr_cid[$value['leg_cid']])/* légion sur la même case */
		&& in_array($leg_etat,array(LEG_ETAT_VLG,LEG_ETAT_GRN,LEG_ETAT_DPL))/* légion en attende d'ordre*/
		)
			$leg_array[$key]['can_atq'] = true;
		else
			$leg_array[$key]['can_atq'] = false;
	}

	return $leg_array;
}


?>
