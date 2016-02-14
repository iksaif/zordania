<?
class war
{
	var $sql,$conf,$histo;	
	
	//construction
	function war(&$sql, &$conf, &$histo)
	{
		$this->sql = &$sql;
		$this->conf = &$conf;
		$this->histo = &$histo;
	}

	
	//fonction principale
	function exec()	
	{
		//Selection des	légions	utiles
		$sql="SELECT leg_xp,leg_lid,leg_mid,leg_cid,leg_etat,map_x,map_y FROM ".$this->sql->prebdd."leg	
		     LEFT JOIN ".$this->sql->prebdd."map ON map_cid = leg_cid
		     WHERE leg_etat != 0 AND leg_etat != 3";
		$leg_tmp_array = $this->sql->make_array($sql);
		
		//on fait le array avec toutes les infos sur les légions
		foreach($leg_tmp_array as $key => $leg_value)
		{
			$leg_array[$leg_value['leg_mid']][$leg_value['leg_lid']] = array(
										'leg_cid' => $leg_value['leg_cid'],
										'leg_etat' => $leg_value['leg_etat'],
										'leg_x'	=> $leg_value['map_x'],	
										'leg_y'	=> $leg_value['map_y'],	
										'leg_xp' => $leg_value['leg_xp']
										);
			if($leg_value['leg_etat'] == 2)
			{
				$where_lid .= " OR atq_lid = ".$leg_value['leg_lid']." ";
			}
		}
		//echo"<pre>";
		//print_r($leg_array);
		unset($leg_tmp_array);
		
		//on selectionnes les attaques qui n'ont pas eu lieu, et celle qui ont eu lieu mais dont on a besoin pour recuperer la vitesse
		$sql="SELECT atq_aid, atq_mid, atq_lid,	atq_mid2, atq_dst, atq_speed , atq_res1_type, atq_res1_nb, atq_res2_type, atq_res2_nb FROM ".$this->sql->prebdd."atq WHERE atq_dst > 0 OR (atq_date_vil = '0000-00-00 00:00:00' AND (0 ".$where_lid."))"; //(atq_dst != 0 OR atq_date_vil = '0000-00-00 00:00:00') AND
		$atq_tmp_array = $this->sql->make_array($sql);
		unset($where_lid);
		//on forme le array
		foreach($atq_tmp_array as $key => $atq_value)
		{
			$atq_array[$atq_value['atq_lid']] = $atq_value;	
			
		}
		//print_r($atq_array);
		unset($atq_tmp_array);
		
		//Bon bha y'a aucune légion active, donc bon
		if(count($leg_array) ==	0)
		{
			return;	
		}

		//On parcoure toutes les légions pour savoir quelles selections on doit faire (btc, unt, membres (pour la position)
		foreach($leg_array as $leg_mid => $leg_first_value)
		{
			foreach($leg_first_value as $leg_lid =>	$leg_value)
			{				
				//retour
				if($leg_value['leg_etat'] == 2)	
				{
					$where_mbr .= "	OR mbr_mid = ".$leg_mid;
				}
				//existe pas
				elseif(!$GLOBALS['mbr_array'][$atq_array[$leg_lid]['atq_mid2']])
				{
					$update_leg_sql[$leg_lid] = 2;
					$delete_atq_sql[$atq_array[$leg_lid]['atq_aid']] = true;
					unset($leg_array[$leg_mid][$leg_lid]);
					unset($atq_array[$leg_lid]);
				}
				else
				{
					$where_mbr .= "	OR mbr_mid = ".$atq_array[$leg_lid]['atq_mid2'];
				}
			}
		}
		
		//Selection des	x et y des membres
		if($where_mbr)
		{
			$sql="SELECT mbr_mid,map_x,map_y FROM ".$this->sql->prebdd."mbr	
				LEFT JOIN ".$this->sql->prebdd."map
				ON mbr_mapcid =	map_cid	
				WHERE (0".$where_mbr.")";
			$map_tmp_array = $this->sql->make_array($sql);
			foreach($map_tmp_array as $key => $map_value)
			{
				$map_array[$map_value['mbr_mid']] = array(
									'map_x'	=> $map_value['map_x'],	
									'map_y'	=> $map_value['map_y']
									);
				
			}
			unset($map_tmp_array);
		}
	
	

		//Parcour du array
		foreach($leg_array as $leg_mid => $leg_first_value)
		{
			foreach($leg_first_value as $leg_lid =>	$leg_value)
			{
				//Si attaque ->	
				/*if(!$atq_array[$leg_lid])
				{
					echo "-$leg_lid-";
					echo"§§§§§§§§§§";
					exit;	
				}*/
				
				
				if($leg_value['leg_etat'] == 1)	
				{
					$x = $leg_value['leg_x'];
					$y = $leg_value['leg_y'];
					$new_x = $x;
					$new_y = $y;
					$speed = $atq_array[$leg_lid]['atq_speed'];
					$mbr_mid = $atq_array[$leg_lid]['atq_mid2'];
					$mbr_x = $map_array[$mbr_mid]['map_x'];	
					$mbr_y = $map_array[$mbr_mid]['map_y'];	
					$atq_aid = $atq_array[$leg_lid]['atq_aid'];
					
					while(($speed >	0) AND (($new_x	!=  $mbr_x) OR ($new_y != $mbr_y)))
					{
						if($new_x > $mbr_x)
						{
							$new_x -= 1;	
						}elseif($new_x < $mbr_x)
						{	
							$new_x += 1;
						}
						if($new_y > $mbr_y)
						{
							$new_y -= 1;	
						}elseif($new_y < $mbr_y)
						{
							$new_y += 1;	
						}
						$speed--;
					}	
					$move[$leg_lid]['x'] = $new_x;
					$move[$leg_lid]['y'] = $new_y;
					$move[$leg_lid]['dst'] = round(sqrt(($new_x - $mbr_x)*($new_x -	$mbr_x)	+ ($new_y - $mbr_y)*($new_y - $mbr_y)));
					//si arrivé
					if(($new_x ==  $mbr_x) AND ($new_y == $mbr_y))
					{
						$this->histo->add($atq_array[$leg_lid]['atq_mid'], $atq_array[$leg_lid]['atq_mid2'], 42,array(0,0,0,0));
						$this->histo->add($atq_array[$leg_lid]['atq_mid2'], $atq_array[$leg_lid]['atq_mid'], 41,array(0,0,0,0));
						$update_leg_sql[$leg_lid] = 3;
					}
				}

				//déplacement vers le village
				if($leg_value['leg_etat'] == 2)	
				{	
					$x = $leg_value['leg_x'];
					$y = $leg_value['leg_y'];
					$new_x = $x;
					$new_y = $y;
					$speed = ($atq_array[$leg_lid]['atq_speed'] > 0) ? $atq_array[$leg_lid]['atq_speed'] : 10;
					$mbr_mid = $leg_mid;
					$mbr_x = $map_array[$mbr_mid]['map_x'];	
					$mbr_y = $map_array[$mbr_mid]['map_y'];	
					
					while(($speed >	0) AND (($new_x	!=  $mbr_x) OR ($new_y != $mbr_y)))
					{
						if($new_x > $mbr_x)
						{
							$new_x -= 1;	
						}elseif($new_x < $mbr_x)
						{	
							$new_x += 1;
						}
						if($new_y > $mbr_y)
						{
							$new_y -= 1;	
						}elseif($new_y < $mbr_y)
						{
							$new_y += 1;	
						}
						$speed--;
					}	
					$move[$leg_lid]['x'] = $new_x;
					$move[$leg_lid]['y'] = $new_y;
					$move[$leg_lid]['dst'] = round(sqrt(($new_x - $mbr_x)*($new_x -	$mbr_x)	+ ($new_y - $mbr_y)*($new_y - $mbr_y)));
					//echo $new_x."-".$mbr_x."-".$new_y."-".$mbr_y;
					//si arrivé
					if(($new_x ==  $mbr_x) AND ($new_y == $mbr_y))
					{
						$update_leg_sql[$leg_lid] = 0;
						$update_res_sql[$leg_mid][$atq_array[$leg_lid]['atq_res1_type']]+=$atq_array[$leg_lid]['atq_res1_nb']+0;
						$update_res_sql[$leg_mid][$atq_array[$leg_lid]['atq_res2_type']]+=$atq_array[$leg_lid]['atq_res2_nb']+0;
						
						$this->histo->add($atq_array[$leg_lid]['atq_mid'], $atq_array[$leg_lid]['atq_mid2'], 45,array($atq_array[$leg_lid]['atq_res1_nb'],$atq_array[$leg_lid]['atq_res1_type'],$atq_array[$leg_lid]['atq_res2_nb'],$atq_array[$leg_lid]['atq_res2_type']));
						
						$update_atq_sql[$atq_array[$leg_lid]['atq_aid']] = true;
					}		//Si arrivée
				}
			}
		}
		/******Requettes sql******/
		if(is_array($move))
		{
			$sql="UPDATE ".$this->sql->prebdd."leg SET leg_cid = CASE ";
			$sql2="UPDATE ".$this->sql->prebdd."atq	SET atq_dst = CASE ";
			foreach($move as $leg_lid => $coord)
			{
				$sql.="WHEN leg_lid = $leg_lid THEN ".((MAP_W*$coord['y'])+1+$coord['x'])." ";
				
				$where_lid .=" OR leg_lid = $leg_lid";
				$where_lid2 .="	OR atq_lid = $leg_lid";	
				
				$sql2.="WHEN atq_lid = $leg_lid	THEN '".$coord['dst']."' ";
			}
			$sql.="	ELSE leg_cid END WHERE (0 ".$where_lid.")";
			$sql2.=" ELSE atq_dst END,atq_date_dep = atq_date_dep WHERE (0 ".$where_lid2.")	AND atq_date_arv = '0000-00-00 00:00:00'";	
			//echo $sql."<hr>";
			//echo $sql2."<hr>";
			$this->sql->query($sql);
			$this->sql->query($sql2);
			unset($where_lid);
		}
		
		if(is_array($update_leg_sql))
		{
			$sql="UPDATE ".$this->sql->prebdd."leg SET leg_etat = CASE ";
			foreach($update_leg_sql	as $leg_lid => $leg_etat)
			{
				$sql.="	WHEN leg_lid = $leg_lid	THEN $leg_etat ";
				$where_lid .= "	OR leg_lid = $leg_lid ";
			}
			$sql.="	ELSE leg_etat END WHERE	(0 ".$where_lid.")";
			//echo $sql."<hr>";
			$this->sql->query($sql);
			unset($where_lid);	
		}

		if(is_array($update_atq_sql))
		{
			$sql="UPDATE ".$this->sql->prebdd."atq SET atq_date_vil = NOW() WHERE 0";
			foreach($update_atq_sql	as $atq_aid => $atq_value)
			{
				$sql .= "	OR atq_aid = '$atq_aid' ";
			}

			//echo $sql."<hr>";
			$this->sql->query($sql);	
		}


		//Donner les ressources
		if(is_array($update_res_sql))
		{
			$sql="UPDATE ".$this->sql->prebdd."res SET res_nb = CASE ";
			
			foreach($update_res_sql as $res_mid => $res_array)
			{
				foreach($res_array as $res_type => $res_nb)
				{
					//echo "Mid: $res_mid -> Nb $res_nb | Type: $res_type\n";
					if($res_nb > 0)
					{
						$sql.="	WHEN res_type = $res_type AND res_mid = $res_mid THEN res_nb + $res_nb ";
						$where_res .= " OR res_mid = $res_mid ";
						$make_sql = true;	
					}
				}
			}
			$sql .= " ELSE res_nb END WHERE res_btc = 0 AND (0 ".$where_res.")";
			if($make_sql) $this->sql->query($sql);
		}
		//echo" \nDEL §§§ \n";
		//print_r($delete_atq_sql);
		if(is_array($delete_atq_sql))
		{
			$sql="DELETE FROM ".$this->sql->prebdd."atq WHERE (0 ";	
			foreach($delete_atq_sql	as $atq_aid => $rien)
			{
				$sql.="	OR atq_aid=$atq_aid ";
			}
			$sql.="	)";
			//echo $sql."<hr>";
			$this->sql->query($sql);
		}
	}
}
?>