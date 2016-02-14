<?
function sort_prio_res($a, $b)
{
   if ($a['res_prio'] == $b['res_prio']) return 0;
  		return ($a['res_prio'] > $b['res_prio']) ? -1 : 1;
}
	
class res
{
	var $sql,$conf,$mbr;
	
	//construction
	function res(&$sql, &$conf, &$mbr)
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
			$src_util[$race]['sql'] = '(';
			$res_util[$race]['sql'] = '(';
			foreach($this->conf[$race]->res as $key => $value)
			{
				$value['needsrc'] ? $src_util[$race][$value['needsrc']] = true : 1 ;
				$value['needbat'] ? $btc_util[$race][$value['needbat']] = true : 1 ;
			}
			
			foreach($this->conf[$race]->btc as $key => $value)
			{
				if(is_array($value['produit']))
				{
					$btc_util[$race][$key] = true;
				}
				if($btc_util[$race][$key])
				{
					if(is_array($value['produit']))
					{
					foreach($value['produit'] as $id => $nb)
					{
						if(is_array($this->conf[$race]->res[$id]))
						{
						foreach($this->conf[$race]->res[$id] as $needres => $neednbres)
						{
							$res_util[$race][$id] = true;
						}	
						}
					}
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
			
			foreach($res_util[$race] as $key => $value)
			{
				if(is_int($key))
				 $res_util[$race]['sql'] .=' OR res_type='.$key;
			}
			
			foreach($src_util[$race] as $key => $value)
			{
				if(is_int($key))
				 $src_util[$race]['sql'] .=' OR src_type='.$key;
			}
			
			$src_util[$race]['sql'] = str_replace('( OR','(',$src_util[$race]['sql']).')';
			$btc_util[$race]['sql'] = str_replace('( OR','(',$btc_util[$race]['sql']).')';
			$res_util[$race]['sql'] = str_replace('( OR','(',$res_util[$race]['sql']).')';
		}

		
		
		//boucle membres ...
		$sql_array = array();

		foreach($this->mbr as $mid => $mbr_values)
		{
			$btc_array = array();
			$src_array = array();
			$res_array = array();
			
			$race = $mbr_values['mbr_race'];

			$sql="SELECT COUNT(*) as btc_nb,btc_type,btc_mid FROM ".$this->sql->prebdd."btc ";
			$sql.=" WHERE ".$btc_util[$race]['sql'];
			$sql.=" AND btc_tour = 0 AND btc_etat = 0 AND btc_mid = $mid GROUP BY btc_type";
			$btc_tmp =  $this->sql->make_array($sql);

			foreach($btc_tmp as $key => $value)
			{
				$btc_array[$value['btc_type']] += $value['btc_nb'];
			}
			unset($btc_tmp);
			
			$sql="SELECT src_mid,src_type FROM ".$this->sql->prebdd."src WHERE src_mid= $mid AND ".$src_util[$race]['sql'];
			$sql.=" AND src_tour = 0";
			
			$src_tmp=$this->sql->make_array($sql);
	
			foreach($src_tmp as $key => $value)
			{
				$src_array[$value['src_type']] = true;
			}
			unset($src_tmp);
	
			
			//res array
			$sql="SELECT res_type,res_nb,res_btc,res_mid FROM ".$this->sql->prebdd."res WHERE res_nb != 0 AND res_mid=$mid AND (res_btc > 0 OR ".$res_util[$race]['sql'].") ORDER BY res_mid ASC, res_prio DESC";
			
			$res_tmp=$this->sql->make_array($sql);
			
			foreach($res_tmp as $key => $value)
			{
				if($value['res_btc'] == 0)
				{
					$res_array[0][$value['res_type']] = array('res_nb' => $value['res_nb'], 'res_btc' => $value['res_btc']);
				}
				else
				{
					$res_array[1][$value['res_type']] = array('res_nb' => $value['res_nb'], 'res_btc' => $value['res_btc']);
				}
			}
			unset($res_tmp);


			$res_a_construire = $res_array[1];
			$res_array = $res_array[0];
			
			if(is_array($btc_array))
			{
			//chaque btc
			foreach($btc_array as $btc_id => $btc_nb)
			{
				//si il produit
				if(is_array($this->conf[$race]->btc[$btc_id]['produit']))
				{
					//chaque chose qu'il produit
					foreach($this->conf[$race]->btc[$btc_id]['produit'] as $res_id => $res_nb)
					{
						$res_max = -1;
						$res_nb_final=0;
						$p_res_nb = 0;
						
						$needsrc = $this->conf[$race]->res[$res_id]['needsrc'];
						$res1pday = $this->conf[$race]->res[$res_id]['1pday'];
						if((!$needsrc OR isset($src_array[$needsrc])) AND ((date('H') == 00 AND $res1pday) OR !$res1pday))
						{
							if(!isset($this->conf[$race]->res[$res_id]['needres']))
							{
								$sql_array[$mid][0][$res_id] += ($res_nb * $btc_nb);
								$res_array[$res_id]['res_nb']  += ($res_nb * $btc_nb);
							}
							//si ca a besoin de quelque chose
							else
							{
								$res_ok = true;
								//chaque chose que ca coute
								foreach($this->conf[$race]->res[$res_id]['needres'] as $need_res_id => $need_res_nb)
								{
									//echo "a besoin de $need_res_nb fois $need_res_id , il y'en a ".$res_array[$need_res_id]['res_nb']."<br>";
									
									if($res_max >= 0) {
										$res_max = min($res_max,floor($res_array[$need_res_id]['res_nb']/ $need_res_nb));
									} else {
										$res_max = floor($res_array[$need_res_id]['res_nb']/ $need_res_nb);
									}

									//echo "calcul : ".$res_array[$need_res_id]['res_nb']."/ $need_res_nb = $res_max<br>";
									//echo "#(".$btc_array[$btc_id]." * ".$btc_array[$btc_id]['produit'][$res_id].") >= $res_max<br/>";
									if( ($btc_array[$btc_id] * $this->conf[$race]->btc[$btc_id]['produit'][$res_id]) >= $res_max)
									{
										$p_res_nb = $res_max;
									}
									else
									{
										$p_res_nb = $btc_array[$btc_id]*$this->conf[$race]->btc[$btc_id]['produit'][$res_id];
									}
									
									if(!$res_nb_final OR $p_res_nb < $res_nb_final)
									{
										$res_nb_final = $p_res_nb;
									}
								}

								foreach($this->conf[$race]->res[$res_id]['needres'] as $need_res_id => $need_res_nb)
								{
									$sql_array[$mid][0][$need_res_id] -= ($need_res_nb * $res_nb_final);
									$res_array[$need_res_id]['res_nb'] -= ($need_res_nb * $res_nb_final);
									//echo "Need $need_res_id : $need_res_nb * $res_nb_final =".$sql_array[$mid][0][$need_res_id]."<br/>";
								}
							
								//echo"On produit $p_res_nb de $res_id, res_max = $res_max<br/>";
								$sql_array[$mid][0][$res_id] += $p_res_nb;
								$res_array[$res_id]['res_nb']  +=  $p_res_nb;
							}
						}
					}
				}
			}
			}
			
			//on regarde si y'a des trucs a construire
			if(is_array($res_a_construire) AND $GLOBALS['mbr_array'][$mid])
			{
				foreach($res_a_construire as $res_id => $res_value)
				{
					$need_btc = $this->conf[$race]->res[$res_id]['needbat'];
					if($res_value['res_nb'] >= $btc_array[$need_btc])
					{
						$p_res_nb = $btc_array[$need_btc];
					}else{
						$p_res_nb = $res_value['res_nb'];
					}
					
					$btc_array[$need_btc] = $btc_array[$need_btc] - $p_res_nb;
					//si y'a qq chose a faire ...
					if($p_res_nb > 0)
					{
						$sql_array[$mid][1][$res_id] -= $p_res_nb;
						$sql_array[$mid][0][$res_id] += $p_res_nb;
					}
				}
			}
			/*print_r($res_array);
			print_r($btc_array);
			print_r($unt_array);
			print_r($src_array);*/
		}
		
		if(is_array($sql_array))
		{
				foreach($sql_array as $mid => $sub_sql_array)
				{
					$sql="UPDATE ".$this->sql->prebdd."res SET res_nb = CASE ";
					if(is_array($sub_sql_array[0]))
					{
					foreach($sub_sql_array[0] as $res_id => $res_nb)
					{
						if($res_nb != 0)
						{
							$sql.=" WHEN (res_btc = 0 AND res_type = $res_id) THEN res_nb + $res_nb\n";
							//$final_where_mbr .= " OR res_type = $res_id ";
						}
					}
					}

					if(is_array($sub_sql_array[1]))
					{
					foreach($sub_sql_array[1] as $res_id => $res_nb)
					{
						if($res_nb != 0)
						{
							$sql.=" WHEN (res_btc > 0 AND res_type = $res_id) THEN res_nb + $res_nb\n";
						}
					}
					}
					$sql.=" ELSE res_nb END WHERE res_mid = $mid ";
					$this->sql->query($sql);
				}	
		}
	}
	
	
}
?>