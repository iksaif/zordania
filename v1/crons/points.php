<?
class pt
{
	var $sql,$conf;
	
	function pt(&$sql,&$conf)
	{
		$this->sql = &$sql;
		$this->conf = &$conf;
	}
	
	function exec()
	{
		
		$points = array();
		
		/*$sql="SELECT SUM(res_nb) as res_nb,res_mid FROM `".$this->sql->prebdd."res` WHERE res_nb > 0 AND res_btc = 0 AND res_type = ".GAME_RES_PRINC." GROUP BY res_mid";
		$res_array = $this->sql->make_array($sql);
		*/
		$sql="SELECT SUM(btc_vie) as btc_vie_tot,btc_mid FROM `".$this->sql->prebdd."btc` WHERE btc_tour = 0 GROUP BY btc_mid";
		$btc_array = $this->sql->make_array($sql);
		
		/*$sql="SELECT count(*) as btc_nb,btc_mid FROM `".$this->sql->prebdd."btc` WHERE btc_tour = 0 GROUP BY btc_mid";
		$btc_array = $this->sql->make_array($sql);
		*/
		$sql="SELECT count(*) as src_nb,src_mid FROM `".$this->sql->prebdd."src` WHERE src_tour = 0 GROUP BY src_mid";
		$src_array = $this->sql->make_array($sql);

		$sql="SELECT SUM(unt_nb) as unt_nb, unt_type,unt_mid FROM `".$this->sql->prebdd."unt` WHERE unt_nb > 0 AND unt_lid >=0 GROUP BY unt_mid,unt_type";
		$unt_array = $this->sql->make_array($sql);
		
		$sql="SELECT SUM(leg_xp) as leg_xp,leg_mid FROM ".$this->sql->prebdd."leg WHERE leg_xp > 0 GROUP BY leg_mid";
		$leg_array = $this->sql->make_array($sql);
		/*foreach($res_array as $key => $value)
		{
			$points[$value['res_mid']] += ($value['res_nb']);
		}*/

		foreach($btc_array as $key => $value)
		{
			$points[$value['btc_mid']] += ($value['btc_vie_tot']*$this->conf[$GLOBALS['mbr_array'][$value['btc_mid']]]->race_cfg['modif_pts_btc']) / 3;
		}

		foreach($unt_array as $key => $value)
		{
			$coef = ($this->conf[$GLOBALS['mbr_array'][$value['unt_mid']]]->unt[$value['unt_type']]['type'] == TYPE_UNT_CIVIL) ? 1 : 2;
			$points[$value['unt_mid']] += ($value['unt_nb'] * 25 * $coef);
		}

		foreach($src_array as $key => $value)
		{
			$points[$value['src_mid']] += ($value['src_nb'] * 100);
		}
		foreach($leg_array as $key => $value)
		{
			$points[$value['leg_mid']] += ($value['leg_xp'] * 25);
		}
		
		$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_points = CASE ";
		foreach($points as $mid => $nb)
		{
			if($GLOBALS['mbr_array'][$mid]) $sql.=" WHEN mbr_mid='$mid' THEN $nb ";
		}
		$sql.=" ELSE mbr_points END WHERE mbr_etat = 1";
		$this->sql->query($sql);
		
		$sql="SELECT SUM(mbr_points) as mbr_points,mbr_alaid FROM ".$this->sql->prebdd."mbr WHERE mbr_alaid > 0 GROUP BY mbr_alaid";
		$pts_array = $this->sql->make_array($sql);
		
		foreach($pts_array as $key => $value)
		{
			$al_array[$value['mbr_alaid']] += $value['mbr_points'];
		}

		$sql="UPDATE ".$this->sql->prebdd."al SET al_points = CASE ";
		foreach($al_array as $al_aid => $al_pts)
		{
			$sql.=" WHEN al_aid = $al_aid THEN $al_pts ";
		}
		$sql.=" ELSE al_points END ";
		$this->sql->query($sql);
	}
}
?>