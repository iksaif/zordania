<?
class src
{
	var $sql,$conf,$histo;
	
	//construction
	function src(&$sql, &$conf, &$histo)
	{
		$this->sql = &$sql;
		$this->conf = &$conf;
		$this->histo = &$histo;
	}

	
	//fonction principale
	function exec()
	{

		//on selectionne les recherches
		$sql="SELECT src_tour,src_mid,src_sid,src_type FROM ".$this->sql->prebdd."src WHERE src_tour > 0 ORDER BY src_sid ASC";
		$src_array = $this->sql->make_array($sql);
		if(count($src_array) == 0)
		{
			return;
		}
		
		$sql = "";
		//on prepare le where pour les btc
		foreach($src_array as $key => $value)
		{
			$sql.=" OR btc_mid='".$value['src_mid']."' ";
		}
		foreach($this->conf as $race => $value)
		{
			foreach($value->btc as $btc_type => $btc_value)
			{
				if($btc_value['doublesrc'])
				{
					$where_btc .= " OR btc_type = '$btc_type'";
					$doublesrc[] = $btc_type;
				}
			}
		}
		
		$sql="SELECT btc_type,btc_mid FROM ".$this->sql->prebdd."btc WHERE btc_tour = 0 AND btc_etat = 0  AND (0".$sql.") AND (0".$where_btc." OR btc_type = '1')";
		$btc_tmp = $this->sql->make_array($sql);
		
		foreach($btc_tmp as $key => $value)
		{
			$nb = in_array($value['btc_type'], $doublesrc) ? 2 : 1;
			$btc_array[$value['btc_mid']] += $nb;
		}
		
		$sql="UPDATE ".$this->sql->prebdd."src SET src_tour = CASE ";
		foreach($src_array as $key => $value)
		{	
			$mid 	= $value['src_mid'];
			$tours 	= $value['src_tour'];
			$sid	= $value['src_sid'];
			$nb	= $btc_array[$mid];
			if($GLOBALS['mbr_array'][$mid])
			{
				if($tours - $nb > 0)
				{
					$sql.=" WHEN src_sid='$sid' THEN  src_tour - '$nb'";
				}else{
					$sql.=" WHEN src_sid='$sid' THEN  0";
					$this->histo->add($mid, $mid, 31,array($value['src_type'],0,0,0));
				}
				$where_src .= " OR src_mid='$mid'";
				$btc_array[$mid] -= (($tours - $nb) > 0) ? $nb : ($nb - $tours); 
			}
		}
		$sql .=" ELSE src_tour END WHERE (0 ".$where_src.")";
		//echo $sql;
		$this->sql->query($sql);
	
	}
}
?>