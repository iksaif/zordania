<?
function sort_prio_unt($a, $b)
{
   if ($a['unt_prio'] == $b['unt_prio']) return 0;
  		return ($a['unt_prio'] > $b['unt_prio']) ? -1 : 1;
}
	
class unt
{
	var $sql,$conf,$mbr;
	
	//construction
	function unt(&$sql, &$conf, &$mbr)
	{
		$this->sql = &$sql;
		$this->conf = &$conf;
		$this->mbr = &$mbr;
	}
	
	//fonction principale
	function exec()
	{
		//on recherche ce qui est utile
		foreach($this->conf as $race => $value)
		{
			$btc_util[$race]['sql'] = '(';
			$unt_util[$race]['sql'] = '(';
			foreach($this->conf[$race]->unt as $key => $value)
			{
				if(is_array($value['needguy']))
				{
					foreach($value['needguy'] as $guy => $guy_value)
					{
						$unt_util[$race][$guy] = true;
					}
				} 
				if(is_array($value['inbat']))
				{
					foreach($value['inbat'] as $bat => $bat_value)
					{
						$btc_util[$race][$bat] = true;
					}
				} 
			}
			
			
			foreach($btc_util[$race] as $key => $value)
			{
				if(is_int($key))
				{
					$btc_util[$race]['sql'] .=' OR btc_type='.$key;
				}
			}
			
			
			
			foreach($unt_util[$race] as $key => $value)
			{
				if(is_int($key))
				{
					$unt_util[$race]['sql'] .=' OR unt_type='.$key;
				}
			}
			
			$btc_util[$race]['sql'] = str_replace('( OR','(',$btc_util[$race]['sql']).')';
			$unt_util[$race]['sql'] = str_replace('( OR','(',$unt_util[$race]['sql']).')';
		}
		
		//on regarde si y'a des trucs a faire
		$sql="SELECT unt_mid,unt_nb FROM ".$this->sql->prebdd."unt ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = unt_mid ";
		$sql.=" WHERE mbr_etat = 1 AND unt_lid < 0 ORDER BY unt_uid DESC";
		$in_form_old = $this->sql->make_array($sql);
		foreach($in_form_old as $key => $value)
		{
			$in_form[$value['unt_mid']] += $value['unt_nb'];
		}

		
		foreach($this->mbr as $mid => $mbr_values)
		{
			$race = $mbr_values['mbr_race'];
			$population = $mbr_values['mbr_population'];
			$diff_nri = 0;
			$maj_pop = 0;
			$maj_unt = array();
			$unt_array = array();
			$btc_array = array();
			
			$sql="SELECT SUM(unt_nb) as unt_nb
				FROM ".$this->sql->prebdd."unt
				WHERE unt_mid = $mid AND unt_lid >= 0 GROUP BY unt_mid";
			$unt_nb = mysql_result($this->sql->query($sql), 0, 'unt_nb');
			
			/* Ptit prob de population ? */
			if($unt_nb != $population) {
				$population = $unt_nb;

			}
			
			$sql="SELECT res_type,res_nb FROM ".$this->sql->prebdd."res
				WHERE res_mid = $mid AND (res_type='".GAME_RES_BOUF."' OR res_type='".GAME_RES_PLACE."')";
			$res_array = $this->sql->make_array($sql);
			foreach($res_array as $key => $value) {
				if($value['res_type'] == GAME_RES_PLACE)
				{
					$place = $value['res_nb'];
				}elseif($value['res_type'] == GAME_RES_BOUF){
					$bouffe = $value['res_nb'];
				}
			}
			
			/* Bouffe */
			if($bouffe	< $population)
			{
				//$type = rand(0,1) ? 1 : array_rand($this->conf[$race]->unt);
				
				if(rand(0,3) == 1) {
					$sql="SELECT leg_lid FROM ".$this->sql->prebdd."leg WHERE leg_mid = $mid AND leg_etat = 0 ORDER BY RAND()";
					$req = $this->sql->query($sql);
					
					if(mysql_num_rows($req) >= 1) {
						$lid = mysql_result($req, 0, 'leg_lid');
					} else {
						$lid = 0;
					}
				} else {
					$lid = 0; // Seulement au village ...
				}
				$sql="SELECT unt_nb,unt_type FROM ".$this->sql->prebdd."unt WHERE unt_mid = $mid AND unt_lid = $lid ORDER BY RAND()";
				$req = $this->sql->query($sql);
				if(mysql_num_rows($req) >=1) {
					$type=mysql_result($req, 0, 'unt_type');
					$nb=mysql_result($req, 0, 'unt_nb');
					
					$diff_nri = ($population - $bouffe);
					$max_unt_nb = ($diff_nri > $nb) ? ceil($nb) : ceil($diff_nri);
					$nb=rand(0, $max_unt_nb);
					$maj_unt[$type][$lid] -= $nb;
					$population -= $nb;
					$unt_nb -= $nb;
					$maj_pop = 1;
				}

				$diff_nri = 0;
			}
			else
			{
				$diff_nri = $bouffe - $population;
			}
			
			/* Unités */
			if($in_form[$mid]) {
				$unt_array = array();
				$btc_array = array();
				
				$sql="SELECT unt_mid,unt_type,unt_nb,unt_lid,unt_uid,unt_prio FROM ".$this->sql->prebdd."unt WHERE unt_mid = $mid AND unt_nb > 0 AND unt_lid < 0 ORDER BY unt_prio DESC";
				$unt_array_tmp =  $this->sql->make_array($sql);
				//uasort ($unt_array_old, "sort_prio_unt");
				foreach($unt_array_tmp as $key => $value)
				{
					$unt_array[$value['unt_type']][$value['unt_lid']] = $value;
				}
				unset($unt_array_old);
				
				
				$sql="SELECT COUNT(*) as btc_nb,btc_type,btc_mid FROM ".$this->sql->prebdd."btc WHERE ".$btc_util[$race]['sql'];
				$sql.=" AND btc_mid = $mid AND btc_tour = 0 AND btc_etat = 0 GROUP BY btc_type";
				$btc_array_tmp =  $this->sql->make_array($sql);
				foreach($btc_array_tmp as $key => $value)
				{
					$btc_array[$value['btc_type']] += $value['btc_nb'];
				}
				unset($btc_array_tmp);
				
				
				$pop_libre = $place;
				$p_unt_nb  = 0;
				//unités a faire
				//print_r($unt_array);
				//echo"<hr/>$mid<br/>";
				foreach($unt_array as $unt_id => $unt_lid_array)
				{
					foreach($unt_lid_array as $lid => $unt_value)
					{
						//si elle sont a faire
						if($lid < 0)
						{
							$need_btc = $this->conf[$race]->unt[$unt_id]['inbat'];
							$need_btc_nb = 0;
							//print_r($need_btc);
							foreach($need_btc as $btc_id => $btc_value)
							{
								$need_btc_id = $btc_id;	
								$need_btc_nb += $btc_array[$btc_id];
								//echo "$need_btc_id = $btc_id";
								//echo "(".$btc_array[$need_btc_id].")<br/>";
							}

							//nombre posssible a faire en fonction du nb de batiments
							
							if($need_btc_nb > 0 AND $unt_value['unt_nb'] > 0)
							{
								if($unt_value['unt_nb'] >= $need_btc_nb)
								{
									$p_unt_nb = $need_btc_nb;
								}else{
									$p_unt_nb = $unt_value['unt_nb'];
								}
								$p_unt_nb = $p_unt_nb * 0; // On ne forme plus personne
								//echo"Peux faire $p_unt_nb unt de type $unt_id, $p_unt_nb ? (".$unt_value['unt_nb']." >= ".$btc_array[$need_btc_id].") | need $need_btc_id";
								//en fonction de la place libre
								//echo "($pop_libre - $pop_activ) < $p_unt_nb";
								if(($pop_libre - $population) < $p_unt_nb)
								{
									 $p_unt_nb = ($pop_libre - $population);
									//echo " $p_unt_nb = ($pop_libre - $pop_activ);";
								}
	
								if($p_unt_nb > 0)
								{
									$maj_unt[$unt_id][$lid] -= $p_unt_nb;
									$maj_unt[$unt_id][0] += $p_unt_nb;
									
									$population += $p_unt_nb;
									$maj_pop = 1;
									$b_unt_nb = $p_unt_nb;
									foreach($need_btc as $btc_id => $btc_value)
									{
										if($btc_array[$btc_id] >= $b_unt_nb)
										{
											$btc_array[$btc_id] -= $b_unt_nb;
											$b_unt_nb = 0;
										}
										else
										{
											$b_unt_nb -= $btc_array[$btc_id];
											$btc_array[$btc_id] = 0;
										}
										if($b_unt_nb <= 0) break;
									}
									//$need_btc_nb -= $p_unt_nb;
								}
							}
						}
					}
				}
				
			}
			
			
			
			/* Maj des unités */
			if($maj_unt) {
				$sql="UPDATE ".$this->sql->prebdd."unt SET unt_nb = CASE ";
				foreach($maj_unt as $unt_type => $unt_value) {
					foreach($unt_value as $unt_lid => $unt_nb) {
						$sql .= " WHEN unt_lid = $unt_lid AND unt_type = $unt_type ";
						$sql.= "  THEN unt_nb + $unt_nb ";
					}
				}
				$sql.=" ELSE unt_nb END WHERE unt_mid = $mid";
				$this->sql->query($sql);	
			}
			
			
			/* Maj de la bouffe */
			$sql="UPDATE ".$this->sql->prebdd."res SET res_nb = $diff_nri WHERE res_mid = $mid AND res_type = ".GAME_RES_BOUF."";
			$this->sql->query($sql);
			
			/* Maj de la population */
			if($maj_pop) {
				$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_population = '$population' WHERE mbr_mid = $mid";
				$this->sql->query($sql);
			}
		}
	}
	
}
	
?>