<?php

/* devra remplacer alliances.lib.php */
class ally {

	/* variables */
	//private static $sql; // objet mysql.class.php -> global $_sql

	private $fields = array();
	// type des variables pour protect()
	private $type = array(
		'al_aid' => 'uint',
		'al_name' => 'string',
		'al_mid' => 'uint',
		'al_points' => 'uint',
		'al_open' => 'bool',
		'al_nb_mbr' => 'uint',
		'al_descr' => 'string',
		'al_diplo' => 'string',
		'al_rules' => 'string');

	private $members = array(
		'ambr_aid' => 'uint',
		'ambr_mid' => 'uint',
		'ambr_date' => 'date',
		'ambr_etat' => 'uint',
		'mbr_pseudo' => 'string',
		'mbr_race' => 'uint',
		'mbr_gid' => 'uint',
		'mbr_mid' => 'uint',
		'mbr_etat' => 'uint',
		'mbr_mapcid' => 'uint',
		'mbr_population' => 'uint',
		'mbr_place' => 'uint',
		'mbr_points' => 'uint',
		'mbr_pts_armee' => 'uint',
		'map_x' => 'uint',
		'map_y' => 'uint',
		'mbr_lang' => 'string',
		'mbr_lip' => 'string',
		);

	private $mbrs = array(); // liste des membres
	private $mbrsDem = array(); // liste des postulants
	private $mbrTmp = array(); // un membre
	private $isMbrLoaded = false;
	private $res = array(); // ressources du grenier


	/* constructeur */
	function __construct( $cond = array()) {
		if (!empty($cond)) { // lecture
			foreach($cond as $key => $value)
				$this->$key = $value;
			$this->addMbr($this->mbrTmp);
		}
	}

	// ajouter un membre dans la liste
	private function addMbr($row){
		if(isset($row['mbr_mid']))
			if($row['ambr_etat'] == ALL_ETAT_DEM)
				$this->mbrsDem[$row['mbr_mid']] = $row;
			else
				$this->mbrs[$row['mbr_mid']] = $row;
	}

	// chargement des membres (à défaut d'avoir une classe mbr)
	private function loadMbrs(){
		$cond = array('op' => 'AND', 'list' => true, 'limite1' => ALL_MAX);
		$cond['aid'] = $this->al_aid;
		if(!isset($cond['orderby']))
			$cond['orderby'] = array('DESC', 'points');
		$al_mbr = get_mbr_gen($cond);

		foreach($al_mbr as $row){
			foreach($row as $key => $value)
				$this->$key = $value;
			$this->addMbr($this->mbrTmp);
		}
		// recalcul des membres
		if($this->al_nb_mbr != count($this->mbrs)) // TODO : MAJ BDD?
			echo 'echec nombre de membres d\'ally:'.$this->al_nb_mbr.'!='.
				count($this->mbrs).'('.count($this->mbrsDem).')';
		$this->isMbrLoaded = true;
	}

	// chargement des ressources
	private function loadRes(){
		global $_sql;
	
		$sql="SELECT ares_type,ares_nb FROM ".$_sql->prebdd."al_res WHERE ares_aid = ".$this->al_aid;
		$sql.=" ORDER BY ares_type ASC";
	
		$result = $_sql->make_array($sql);
		$res = array();
		foreach($result as $row)
			$res[$row['ares_type']] = $row['ares_nb'];
		$this->res = $res;
	}

	/* méthodes set & get */
	function __set($key, $value) {
		/* pour l'alliance: $key = nom du champ, value sa valeur
		  pour les membres: l'enregistrer dans mbrTmp
		*/
		if(isset($this->type[$key]))
			$this->fields[$key] = ($this->type[$key]=='string' ? $value: protect($value, $this->type[$key]));
		else if(isset($this->members[$key]))
			// 'ambr_date': /* TODO conversion date à étudier */
			$this->mbrTmp[$key] = ($this->members[$key]=='string' ? $value: protect($value, $this->members[$key]));
		else echo "SET 'ally'->$key = $value\n";
	}
	function __get($key) {
		if(isset($this->fields[$key])) return $this->fields[$key];
		// pas possible de faire un get direct sur un membre.
		else { echo "GET 'ally'->$key\n"; return false; }
	}


	function getEtatMbr($mid)
	{
		if(!$this->isMbrLoaded) $this->loadMbrs();
		return (isset($this->mbrs[$mid]) ? $this->mbrs[$mid]['ambr_etat'] : false);
	}

	function getInfos() // infos ally + chef
	{
		return array_merge($this->fields, $this->getChef());
	}

	function getMembers($mid = false)
	{
		if(!$this->isMbrLoaded) $this->loadMbrs();
		//
		if ($mid !== false){
			if(isset($this->mbrs[$mid])) return $this->mbrs[$mid];
			else if(isset($this->mbrsDem[$mid])) return $this->mbrsDem[$mid];
			else return array();
		}else // par défaut tous les membres (sauf en demande)
			return $this->mbrs;
	}

	function getMembersByEtat($etat)
	{
		if(!$this->isMbrLoaded) $this->loadMbrs();

		if ($etat == ALL_ETAT_DEM) return $this->mbrsDem;
		$return = array();
		if(is_array($etat))
			foreach($etat as $value)
				$return += $this->getMembersByEtat($value);
		else
			foreach($this->mbrs as $mid => $mbr)
				if ($mbr['ambr_etat'] == $etat)
					$return[$mid] = $mbr;
		return $return;
	}

	// nb de membres par race (sauf postulants)
	function getRaces()
	{
		if(!$this->isMbrLoaded) $this->loadMbrs();
		global $_races;

		$stats = array();
		foreach($_races as $id => $value)
			$stats[$id] = 0;
		foreach($this->mbrs as $values)
			$stats[$values['mbr_race']]++;
		return $stats;	
	}

	function isFull()
	{ // alliance pleine?
		return ($this->al_nb_mbr >= ALL_MAX);
	}

	/* edit 1 ou plusieurs mbr = array et MAJ alliance */
	function mod_mbr($edit)
	{
		global $_sql;

		$aid = $this->al_aid;
		$edit = protect($edit, "array");
		$arr_sql = array();
		$count = array();
		$return = array();

		foreach($edit as $mid => $etat){
			$arr_sql[] = "WHEN $mid THEN $etat";
			if ($etat == ALL_ETAT_CHEF) $chef = $mid;
		}
		foreach($this->mbrs as $mid => $mbr){
			$new_etat = isset($edit[$mid]) ? $edit[$mid] : $mbr['ambr_etat'];
			if(isset($count[$new_etat]))
				$count[$new_etat]++;
			else
				$count[$new_etat] = 1;
		}

		foreach($count as $etat => $nb)
			if(isset(allyFactory::$_drts_max[$etat]) && $nb > allyFactory::$_drts_max[$etat])
				$return['count'][$etat] = $nb; // maj impossible, trop de membres dans un état spécial

		// faut absolument un chef
		if(!isset($count[ALL_ETAT_CHEF]) || $count[ALL_ETAT_CHEF] != 1) $return['chef'] = true;

		if(empty($arr_sql)) $return['vide'] = true; // aucune modification

		if(empty($return)){
			foreach($edit as $mid => $etat) // appliquer les modifications
				$this->mbrs[$mid]['ambr_etat'] = $etat;

			$sql = "UPDATE ".$_sql->prebdd."al_mbr ";
			$sql.= "SET ambr_etat = CASE ambr_mid ".implode(' ',$arr_sql) ." ELSE ambr_etat END, ambr_date = NOW() ";
			$sql.= "WHERE ambr_aid = $aid";
			$_sql->query($sql);

			// recompter le nombre de membres parce que ça se met pas à jour
			$sql = "UPDATE ".$_sql->prebdd."al ";
			$sql.= "SET al_nb_mbr = (SELECT count(*) FROM ".$_sql->prebdd."al_mbr WHERE ambr_aid = $aid AND ambr_etat <> ".ALL_ETAT_DEM.")";
			if (isset($chef)) {
				$sql .= ", al_mid = $chef"; // maj du chef aussi
				$this->al_mid = $chef;
			}
			$sql.= " WHERE al_aid = $aid";
			$_sql->query($sql);
			$return = true;
		}
		return $return;
	}

	// changer le chef - ainsi l'ancien chef redevient simple membre
	function setChef($mid)
	{
		return $this->mod_mbr( array($mid => ALL_ETAT_CHEF, $this->al_mid => ALL_ETAT_OK));
	}
	function getChef()
	{
		return $this->getMembers($this->al_mid);
	}

	function getLogo()
	{
		$aid = $this->al_aid;
		$file = ALL_LOGO_DIR.$aid.'.png';
		return file_exists($file) ? 'img/al_logo/'.$aid.'.png' : 'img/al_logo/0.png';
	}

	function getRessources($type = 0){ /* grenier */
		if(empty($this->res)) $this->loadRes();
		$type = protect($type, "uint");
		if($type)
			return isset($this->res[$type]) ? $this->res[$type] : 0;
		else
			return $this->res;
	}

	// vérifier les accès: grenier, diplo, recrutement, chef & second
	function isAccesOk($mid, $acces){ // fonction générique
		$mbr = $this->getMembers($mid);
		if(isset($mbr['ambr_etat']))
			return in_array($mbr['ambr_etat'], allyFactory::$_drts_all[$acces]);
		else
			return false;
	}
	function isGrenierAcces($mid){ // modifier les permissions au grenier
		return $this->isAccesOk($mid, 'grenier');
	}

	function isIntandantAcces($mid){ // gérer les accès au grenier
		$return = $this->getMembers($mid);
		return $return['ambr_etat'] == ALL_ETAT_INTD;
	}

	function isDiploAcces($mid){ // gérer la diplomatie
		$return = $this->getMembers($mid);
		return $return['ambr_etat'] == ALL_ETAT_DPL;
	}

	function isRecrutAcces($mid){ // recruter
		$return = $this->getMembers($mid);
		return $return['ambr_etat'] == ALL_ETAT_RECR;
	}

	function isSecondAcces($mid){ // modifier les rôles
		$return = $this->getMembers($mid);
		return $return['ambr_etat'] == ALL_ETAT_SECD;
	}
}
?>
