<?
class clea
{
	var $sql;
	
	//construction
	function clea(&$sql)
	{
		$this->sql = &$sql;
	}

	
	//fonction principale
	function exec()
	{
		/*$sql="DELETE FROM ".$this->sql->prebdd."atq WHERE atq_dst = -1";
		$this->sql->query($sql);*/
		$sql="DELETE FROM ".$this->sql->prebdd."btc WHERE btc_vie <= 0";
		$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."res WHERE res_nb <= 0 AND res_btc > 0";
		$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."unt WHERE unt_nb <= 0 AND (unt_lid < 0 OR unt_lid > 1)";
		$this->sql->query($sql);
		
		$sql="DELETE FROM ".$this->sql->prebdd."al_shoot WHERE shoot_date < (NOW() - INTERVAL ".MSG_DEL_OLD." DAY)";
		$this->sql->query($sql);
		
		$sql="DELETE FROM ".$this->sql->prebdd."msg WHERE msg_date < (NOW() - INTERVAL ".MSG_DEL_OLD." DAY)";
		$this->sql->query($sql);
		
		$sql="DELETE FROM ".$this->sql->prebdd."al_res_log WHERE al_res_log_date < (NOW() - INTERVAL ".HISTO_DEL_OLD." DAY)";
		$this->sql->query($sql);
		
		$sql="DELETE FROM ".$this->sql->prebdd."histo WHERE histo_date < (NOW() - INTERVAL ".HISTO_DEL_OLD." DAY)";
		$this->sql->query($sql);
		
		$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_etat = 3 WHERE mbr_ldate < (NOW() - INTERVAL ".USER_INACTIF." SECOND) AND mbr_etat = 1";
		$this->sql->query($sql);
		
		//Effacer WAR
		$sql="DELETE
		      FROM ".$this->sql->prebdd."atq
		      WHERE atq_date_vil != '0000-00-00 00:00:00' AND atq_date_vil < (NOW() - INTERVAL ".ATQ_DEL_OLD." SECOND)
		      ";
		$this->sql->query($sql);

		$heure = (int) date('H');
		if($heure == 22)
		{
			$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_atq_nb = 0";
			$this->sql->query($sql);
		}
		

		//Eviter des conneries :
		$sql="SELECT atq_aid,atq_date_dep,atq_date_arv,atq_date_vil,atq_lid,atq_res1_type,leg_etat
			FROM zrd_atq
			LEFT JOIN zrd_leg ON atq_lid = leg_lid
			WHERE `atq_date_vil` = \"0\"
			AND leg_etat = 0 ORDER BY `atq_date_dep` DESC";
		
		//On stoque dans un array
		$atq_array = $this->sql->make_array($sql);
		//On update
		$sql="UPDATE zrd_atq SET atq_date_vil = NOW() WHERE atq_date_vil = \"0\"  AND (0 ";
		foreach($atq_array as $values)
		{
			$sql.=" OR atq_lid = $lid ";
			$make_sql = true;
		}
		$sql.=" )";
		if($make_sql) $this->sql->query($sql);
	}
}
?>