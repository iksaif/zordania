<?php
/* tableau d'alliances et fonctions SQL dédiées */
class allyFactory {

	private static $allies = array(); // tableau d'alliances
	private static $table; // tableau de la dernière requete SQL SELECT = cache

	/* STATIC et CONSTANTES */
	/* droits & restrictions pour l'alliance : $_sub pour la page gestion alliance, et qui y a droit */
	/* + grenier + diplo */
	static $_drts_all = array(
		'grenier'=> array(ALL_ETAT_OK,ALL_ETAT_INTD,ALL_ETAT_DPL,ALL_ETAT_RECR,ALL_ETAT_SECD,ALL_ETAT_CHEF),
		'accept' => array(ALL_ETAT_RECR,ALL_ETAT_SECD, ALL_ETAT_CHEF),
		'refuse' => array(ALL_ETAT_RECR,ALL_ETAT_SECD, ALL_ETAT_CHEF),
		'param'  => array(ALL_ETAT_RECR,ALL_ETAT_SECD, ALL_ETAT_CHEF),
		'rules'  => array(ALL_ETAT_INTD,ALL_ETAT_SECD,ALL_ETAT_CHEF),
		'perm'   => array(ALL_ETAT_INTD,ALL_ETAT_SECD,ALL_ETAT_CHEF),
		'diplo'  => array(ALL_ETAT_DPL,ALL_ETAT_SECD,ALL_ETAT_CHEF),
		'logo'   => array(ALL_ETAT_SECD,ALL_ETAT_SECD,ALL_ETAT_CHEF),
		'kick'   => array(ALL_ETAT_CHEF),
		'chef'   => array(ALL_ETAT_CHEF),
		'del'    => array(ALL_ETAT_CHEF),
	);

	static $_drts_max = array(ALL_ETAT_CHEF => 1, ALL_ETAT_SECD => 1, ALL_ETAT_RECR => 1, ALL_ETAT_DPL => 1, ALL_ETAT_INTD => 1);

	/* méthodes statiques */
	static function select($cond) {
		global $_sql;

		$limite1 = 0; $limite2 = 0; $limite = 0; $aid = 0; $name = 0;

		if(isset($cond['limite1'])) {
			$limite1 = protect($cond['limite1'], "uint");
			$limite++;	
		}
		if(isset($cond['limite2'])) {
			$limite2 = protect($cond['limite2'], "uint");
			$limite++;	
		}
	
		if(isset($cond['aid']))
			$aid = protect($cond['aid'], "uint");
		if(isset($cond['name']))
			$name = protect($cond['name'], "string");
		$mini3 = isset($cond['mini3']); // 3 membres mini?
		
		$sql="SELECT al_aid,al_name,al_nb_mbr,al_mid, al_points,al_open,mbr_pseudo,mbr_race, mbr_gid,mbr_mid,". ALL_ETAT_CHEF . " AS ambr_etat";
		if(!$limite)
			$sql.=",al_descr,al_rules,al_diplo";	
	
		$sql.=" FROM ".$_sql->prebdd."al ";
		$sql.=" JOIN ".$_sql->prebdd."mbr ON mbr_mid = al_mid ";
	
		if($aid || $name || $mini3) {
			$sql .= "WHERE ";
			if($aid)
				$sql.= "al_aid = $aid AND ";
			if($name)
				$sql.=" al_name LIKE '%$name%' AND ";
			if($mini3)
				$sql.= "al_nb_mbr >= 3 AND ";

			$sql = substr($sql, 0, strlen($sql) - 4);
		}

		$sql .= "ORDER BY al_points DESC ";

		if($limite) {
			if($limite == 2)
				$sql .= "LIMIT $limite2, $limite1 ";
			else
				$sql .= "LIMIT $limite1 ";
		}
		
		self::$table = $_sql->make_array($sql);
		$result = array();
		foreach(self::$table as $row){
			if (isset($result[$row['al_aid']]))
				$result[$row['al_aid']]->addMbr($row);
			else
				$result[$row['al_aid']] = new ally($row);
			if(!isset(self::$allies[$row['al_aid']]))
				self::$allies[$row['al_aid']] = $result[$row['al_aid']];
		}

		return $result;
	}

	static function getList($cond){
		self::select($cond);
		return self::$table;
	}

	static function nb($all = false)/* nb d'alliances */
	{
		global $_sql;
	
		$sql="SELECT COUNT(*) as nb FROM ".$_sql->prebdd."al";
		if($all === false)
			$sql.= " WHERE al_nb_mbr >= 3 ";
		return $_sql->result($_sql->query($sql), 0, 'nb');
	}

	static function getAlly($aid){
		if(!isset(self::$allies[$aid]))
			allyFactory::select(array('aid' => $aid));
		return isset(self::$allies[$aid]) ? self::$allies[$aid] : null;
	}

}
?>
