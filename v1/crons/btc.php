<?
class btc
{
	var $sql,$conf;
	
	//construction
	function btc(&$sql, &$conf, &$histo)
	{
		$this->sql = &$sql;
		$this->conf = &$conf;
		$this->histo = &$histo;
	}

	
	//fonction principale
	function exec()
	{

		//on selectionne les batiments a construire
		$sql="SELECT btc_type,btc_tour,btc_mid,btc_bid,btc_etat,btc_vie FROM ".$this->sql->prebdd."btc 
			LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = btc_mid
			WHERE mbr_etat = 1 AND (btc_tour > 0 OR btc_etat = 1)";
		$btc_array = $this->sql->make_array($sql);
		
		
		if(count($btc_array) == 0)
		{
			return;
		}
		
		unset($sql);
		//on prepare le where pour les unt
		foreach($btc_array as $key => $value)
		{
			$sql.=" OR unt_mid='".$value['btc_mid']."' ";
		}
		$sql="SELECT unt_nb,unt_mid FROM ".$this->sql->prebdd."unt WHERE unt_type='1' AND unt_lid = 0 AND (0".$sql.")";
		$travail_array = $this->sql->make_array($sql);
		
		foreach($travail_array as $key => $value)
		{
			$unt_array[$value['unt_mid']] = $value['unt_nb'];
		}
		

		$sql="UPDATE ".$this->sql->prebdd."btc SET btc_tour = CASE ";

		$where_btc = "";
		$where_sql2_block = array();
		//Constructions
		foreach($btc_array as $key => $value)
		{	
			$mid 	= $value['btc_mid'];
			$tours 	= $value['btc_tour'];
			$bid	= $value['btc_bid'];
			$race   = $GLOBALS['mbr_array'][$mid];

			$type   = $value['btc_type'];
			if($tours > 0)
			{
				$travail = $unt_array[$mid];
				if($tours - $travail > 0)
				{
					$sql.=" WHEN btc_bid='$bid' THEN  btc_tour - '$travail'";
					$where_btc .= " OR btc_mid = $mid ";
				}else{
					if(isset($this->conf[$race]->btc[$type]['population']))
					{
						$sql2.=" WHEN res_mid='$mid' AND res_type='".GAME_RES_PLACE."' THEN res_nb + ".$this->conf[$race]->btc[$type]['population']." ";
						if(!$where_sql2_block[$mid])
						{
							$where_sql2.= " OR res_mid='$mid' ";
							$where_sql2_block[$mid] = true;
						}
					}
					$sql.=" WHEN btc_bid='$bid' THEN  0";
					$where_btc .= " OR btc_mid = $mid ";
					$this->histo->add($mid, $mid, 21,array($type,0,0,0));
				}
				$unt_array[$mid] = (($tours - $travail) > 0) ? 0 : ($travail - $tours); 
				unset($btc_array[$key]);
				$make_sql1 = true;
			}
		}
		$sql .=" ELSE btc_tour END WHERE (0 ".$where_btc.")";
		
		
		//Réparations
		$where_btc = "";
		foreach($btc_array as $key => $value)
		{	
			$mid 	= $value['btc_mid'];
			$bid	= $value['btc_bid'];
			$vie    = $value['btc_vie'];
			$race   = $GLOBALS['mbr_array'][$mid];
			$type   = $value['btc_type'];
			$rapport = (1-($vie/ $this->conf[$race]->btc[$type]['vie']));
			//echo "\nRapport vie : $rapport = (1-($vie/".$this->conf[$race]->btc[$type]['vie'].")<br/>";
			$tours = $this->conf[$race]->btc[$type]['tours'] * $rapport;//calcul de merde
			$prix  = $this->conf[$race]->btc[$type]['prix'] ; //calcul de merde
			
			$travail = $unt_array[$mid];
			
			$rapport = ($travail / $this->conf[$race]->btc[$type]['tours']);
			if($tours - $travail > 0)
			{
				//$sql3.=" WHEN btc_bid='$bid' THEN  btc_tour - '$travail'";
				$sql3_array['vie'][$bid] = floor($vie + ($this->conf[$race]->btc[$type]['vie']*$rapport));//calcul de merde 
			}else{
				$sql3_array['vie'][$bid] = $this->conf[$race]->btc[$type]['vie'];
				$sql3_array['etat'][$bid] = 0;
				$this->histo->add($mid, $mid, 22,array($type,0,0,0));
						
			}
			$where_btc .= " OR btc_mid = $mid ";
			
			foreach($prix as $res_type => $res_nb)
			{
				$res_nb = round(($res_nb * $rapport)/2);
				$sql2.=" WHEN res_mid='$mid' AND res_type='$res_type' THEN res_nb - '$res_nb' ";
				//echo "\nCa coute : $res_nb * $res_type<br/>";
				if(!$where_sql2_block[$mid])
				{
					$where_sql2.= " OR res_mid='$mid' ";
					$where_sql2_block[$mid] = true;
				}
			}
					
			$unt_array[$mid] = (($tours - $travail) > 0) ? 0 : ($travail - $tours); 
			$make_sql3 = true;
			unset($btc_array[$key]);
		}
		$sql3="UPDATE ".$this->sql->prebdd."btc \n SET btc_vie = CASE ";

		if(is_array($sql3_array['vie']))
		{
		foreach($sql3_array['vie'] as $bid => $vie)
		{
			$sql3 .=" WHEN btc_bid = $bid THEN $vie \n";
		}
		}
		$sql3 .=" ELSE btc_vie END";
		if(is_array($sql3_array['etat']))
		{
		$sql3 .=" ,\n btc_etat = CASE ";
		foreach($sql3_array['etat'] as $bid => $etat)
		{
			$sql3 .=" WHEN btc_bid = $bid THEN $etat \n";
		}
		$sql3 .=" ELSE btc_etat END ";
		}
		$sql3 .="\n WHERE (0 ".$where_btc.")";
		
		if($make_sql1) { $this->sql->query($sql); }
		if($make_sql3) { $this->sql->query($sql3); }

		
		//$this->sql->query($sql3);
		if($sql2)
		{
			$sql2="UPDATE ".$this->sql->prebdd."res SET res_nb = CASE ".$sql2." ELSE res_nb END WHERE (0 ".$where_sql2.")";	
			$this->sql->query($sql2);
		}
	
	}
}
?>