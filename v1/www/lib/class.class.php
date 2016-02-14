<?
class top50
{
	var $sql;
	function top50(&$sql)
	{
		$this->sql = &$sql;	
	}
	
	function make_class($type, $race = 0)
	{
		$type = (int) $type;
		$race = (int) $race;
		
		switch($type)
		{
			case 1: //Or
				$sql ="SELECT al_aid,al_name,mbr_gid,res_nb,mbr_mid,mbr_pseudo,mbr_race ";
				$sql.="FROM ".$this->sql->prebdd."res LEFT JOIN ".$this->sql->prebdd."mbr ";
				$sql.="ON mbr_mid=res_mid ";
				$sql.="LEFT JOIN ".$this->sql->prebdd."al ";
				$sql.="ON mbr_alaid=al_aid ";
				$sql.="WHERE res_type = 1 AND res_btc = 0 AND res_nb >0 AND mbr_etat = 1 ";
				if($race) $sql.=" AND mbr_race = $race ";
				$sql.="ORDER BY res_nb DESC LIMIT 50";
				break;
			case 2: //Xp (par légion)
				$sql ="SELECT al_aid,al_name,mbr_gid,leg_lid,leg_xp,leg_name,mbr_mid,mbr_pseudo,mbr_race ";
				$sql.="FROM ".$this->sql->prebdd."leg LEFT JOIN ".$this->sql->prebdd."mbr ";
				$sql.="ON mbr_mid=leg_mid ";
				$sql.="LEFT JOIN ".$this->sql->prebdd."al ";
				$sql.="ON mbr_alaid=al_aid ";
				$sql.="WHERE leg_xp > 0 AND mbr_etat = 1 ";
				if($race) $sql.=" AND mbr_race = $race ";
				$sql.="ORDER BY leg_xp DESC LIMIT 50 ";
				break;
			case 3:
				$sql ="SELECT al_aid,al_name,mbr_gid,mbr_mid,mbr_pseudo,mbr_points,mbr_race ";
				$sql.="FROM ".$this->sql->prebdd."mbr ";
				$sql.="LEFT JOIN ".$this->sql->prebdd."al ";
				$sql.="ON mbr_alaid=al_aid ";
				$sql.="WHERE mbr_points > 0 AND mbr_etat = 1 ";
				if($race) $sql.=" AND mbr_race = $race ";
				$sql.="ORDER BY mbr_points DESC LIMIT 50";
				break;
			case 4:
				$sql ="SELECT al_aid,al_name,res_nb,mbr_gid,mbr_mid,mbr_pseudo,mbr_population,mbr_race ";
				$sql.="FROM ".$this->sql->prebdd."mbr LEFT JOIN ".$this->sql->prebdd."res ";
				$sql.="ON mbr_mid=res_mid ";
				$sql.="LEFT JOIN ".$this->sql->prebdd."al ";
				$sql.="ON mbr_alaid=al_aid ";
				$sql.="WHERE res_type = ".GAME_RES_PLACE." AND mbr_population > 0 AND mbr_etat = 1 ";
				if($race) $sql.=" AND mbr_race = $race ";
				$sql.="ORDER BY mbr_population DESC LIMIT 50";
				break;
			case 5:
				$sql="SELECT al_aid,al_name,al_nb_mbr,al_mid,mbr_pseudo,al_points,al_open ";
				$sql.="FROM ".$this->sql->prebdd."al ";
				$sql.="LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = al_mid ";
				if($race) $sql.=" WHERE mbr_race = $race ";
				$sql.="ORDER BY al_points DESC LIMIT 50";
				break;
			default:
				return false;
		}
		return $this->sql->make_array($sql);
	}
}
?>