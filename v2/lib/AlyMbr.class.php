<?php
/*
 * SOMMAIRE :
 *
 * MEMBRES : zrd_al_mbr
 *  add
 *  del
 *  cls
 */

class AlyMbr {
	private static $__sql;
	private static $initialized = false;

	// constructeur private pour interdire de faire new Aly();
	private function __construct(){}

	private static function init() {
		if(!self::$initialized){
			self::$__sql = &mysqliext::$bdd;
			self::$initialized = true;
		}
	}


	public static function del($aid, $mid = 0) {
		self::init();
	
		$aid = protect($aid, "uint");
		$mid = protect($mid, "uint");
	
		$sql = "DELETE FROM ".self::$__sql->prebdd."al_mbr ";
		$sql.= "WHERE ambr_aid = $aid  ";
		if($mid) $sql.= "AND ambr_mid = $mid";
	
		self::$__sql->query($sql);
		return self::$__sql->affected_rows();
	}

	function add($aid, $mid, $etat) {
		self::init();
	
		$aid = protect($aid, "uint");
		$mid = protect($mid, "uint");
		$etat = protect($etat, "uint");
	
		$sql = "INSERT INTO ".self::$__sql->prebdd."al_mbr ";
		$sql.= "VALUES ($mid, $aid, NOW(), $etat)";
		return self::$__sql->query($sql);
	}


	function cls($mid) {
		self::init();

		$mid = protect($mid, "uint");

		/* Il est dans une alliance ? */
		$mbr_infos = get_mbr_by_mid_full($mid);
		if(!$mbr_infos)
			return 0;

		$aid = $mbr_infos[0]['ambr_aid'];
		$race = $mbr_infos[0]['mbr_race'];
		$etat = $mbr_infos[0]['ambr_etat'];

		if(!$aid)
			return 0;

		if($etat == ALL_ETAT_DEM)
		{
			return self::del($aid, $mid);
		}

		$ally = allyFactory::getAlly($aid);
		if($ally and $ally->al_mid != $mid)/* il n'est pas le chef on peut supprimer */
		{
			edit_aly($aid, array('nb_mbr' => -1));
			return self::del($aid, $mid);
		}

		/* recherche du nouveau chef par ordre hiérarchique */
		$chef = $ally->getMembers(ALL_ETAT_SECD);
		if(empty($chef)) $chef = $ally->getMembers(ALL_ETAT_INTD);
		if(empty($chef)) $chef = $ally->getMembers(ALL_ETAT_RECR);
		if(empty($chef)) $chef = $ally->getMembers(ALL_ETAT_DPL);

		if(empty($chef))
			foreach($ally->getMembers() as $chef) /* Sinon, on fait n'importe quoi */
					break;

		if(empty($chef) or $chef['mbr_mid'] == $mid) /* Personne ne peut la prendre en charge */
			return Aly::del($aid);
		else
			return self::del($aid, $mid) +
				Aly::edit($aid, array('mid' => $chef['mbr_mid'], 'nb_mbr' => -1));
	}

}

?>
