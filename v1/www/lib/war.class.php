<?
class war
{
	var $sql,$conf;
	
	function war(&$db,&$conf)
	{
		$this->sql = &$db; //class mysql
		$this->conf = &$conf; //config
	}
	
	function tri_unt($a, $b)
	{			
		if ($a['unt_role'] == $b['unt_role']) return 0;
		return ($a['unt_role'] > $b['unt_role']) ? 1 : -1;	
	}
	
	function list_leg($mid)
	{
		$mid = (int) $mid;
		//on prend la liste des legions + les distances
		$sql="SELECT * FROM ".$this->sql->prebdd."leg LEFT JOIN ".$this->sql->prebdd."atq";
		$sql.=" ON leg_lid = atq_lid LEFT JOIN ".$this->sql->prebdd."map ON map_cid = leg_cid ";
		$sql.=" WHERE leg_mid = '$mid'";
		
		//Penser a prendre ce qui correspond au coordonée de la map en passant par le cid !
		$tmp = $this->sql->make_array($sql);
		foreach($tmp as $key => $value)
		{
			$return[$value['leg_lid']] = $value;
		}
		return $return;
	}
	
	function leg_count($mid, $lid = 0, $etat = -1)
	{
		$mid = (int) $mid;
		$lid = (int) $lid;
		$etat = (int) $etat;
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."leg WHERE leg_mid='$mid'";
		if($lid)
		{
			$sql.=" AND leg_lid='$lid'";
		}
		if($etat != -1)
		{
			$sql.=" AND leg_etat='$etat'";
		}
		return mysql_result($this->sql->query($sql), 0);
	}
	
	function atq($mid1, $lid, $mid2, $cid)
	{
		$mid1 = (int) $mid1;
		$mid2 = (int) $mid2;
		$lid  = (int) $lid;
		$cid  = (int) $cid;
		
		//on verifie que la legion existe
		if($this->leg_count($mid1, $lid, 0) == 0)
		{
			//2 => leg existe pas
			return 2;
		}
		
		//on recupere les infos sur les deux membres (en passant on verifie que le deuxieme existe)
		$sql="SELECT mbr_mid,map_x,map_y FROM ".$this->sql->prebdd."mbr LEFT JOIN ".$this->sql->prebdd."map";
		$sql.=" ON map_cid = mbr_mapcid WHERE mbr_mid='$mid1' OR mbr_mid='$mid2' AND mbr_etat = 1";
		
		$array = $this->sql->make_array($sql);

        	if(!isset($array[1]['map_x']))
        	{
			//le deuxieme existe pas
			return 3;
		}
		
		//on calcule la distance
		$dst_y = abs($array[0]['map_y'] - $array[1]['map_y']);
		$dst_x = abs($array[0]['map_x'] - $array[1]['map_x']);
		$dst = round(sqrt($dst_y * $dst_y + $dst_x * $dst_x) , 3);
		
		//on selectionne toutes les unités pour determiner la vitesse
		$sql="SELECT unt_type,unt_nb FROM ".$this->sql->prebdd."unt WHERE unt_lid = $lid AND unt_mid = $mid1";
		$unt_array = $this->sql->make_array($sql);
		
		$atq_btc = 0;
		$atq_unt = 0;
		$speed   = 0;
		$unt_nb  = 0;
		foreach($unt_array as $key => $unt_value)
		{
			if($unt_value['unt_nb'] > 0)
			{
				$unt_conf = $this->conf->unt[$unt_value['unt_type']];
				
				$atq_btc += ($unt_conf['attaquebat'] * $unt_value['unt_nb']);
				$atq_unt += ($unt_conf['attaque'] * $unt_value['unt_nb']);
				//$speed   += ($unt_conf['speed'] * $unt_value['unt_nb']);
				
				$speed_array[$unt_conf['type']][$unt_value['unt_type']]=array(
										'nb' => $unt_value['unt_nb'],
										'speed'=>$unt_conf['speed']
										);
				
				if($unt_conf['carry'])
				{
					$carry_array[$unt_conf['carry']][$unt_value['unt_type']]['speed']= $unt_conf['speed'];
					$carry_array[$unt_conf['carry']][$unt_value['unt_type']]['capacity'] += $unt_conf['capacity']*$unt_value['unt_nb'];
				}
				
				//$unt_nb  += $unt_value['unt_nb'];
			}
		}

		if(is_array($carry_array))
		{
		foreach($carry_array as $type_unt => $carry_sub_array)
		{
			foreach($carry_sub_array as $carry_type => $carry_value)
			{		
				$capacity = $carry_value['capacity'];
				$carry_speed = $carry_value['speed'];
				
				if(is_array($speed_array[$type_unt]))
				{
				foreach($speed_array[$type_unt] as $unt_type => $unt_value)
				{
					if($capacity <= 0) break;
					$cap_modif = $capacity > $unt_value['nb'] ? $unt_value['nb'] : $capacity;

					if($carry_speed > $unt_value['speed'])
					{
						$speed_array[0][]=array('nb' => $cap_modif, 'speed' => $carry_speed);	
						$speed_array[$type_unt][$unt_type]['nb'] -= $cap_modif;
						$capacity -= $cap_modif;
					}
				}
				}
			}
		}
		}

		if(is_array($speed_array))
		{
			foreach($speed_array as $unt_value)
			{
				foreach($unt_value as $values)
				{
					if($values['nb'] > 0)
					{
						$speed += $values['speed']*$values['nb'];
						//echo $values['speed']."*".$values['nb'];
						$unt_nb += $values['nb'];
					}
				}
			}
			$speed = ($speed / $unt_nb);
		}
		else
		{
			$speed = 0;
		}
		//echo $speed;
		if($unt_nb == 0)
		{
			return 4;
		}
		
		//on stoque tout ca	 
		$sql="INSERT INTO ".$this->sql->prebdd."atq VALUES ('','$mid1', NOW(),'','','$lid','$mid2','$dst','$atq_unt','$atq_btc','','$speed','','','','','','')";
		$this->sql->query($sql);
		$sql=" UPDATE ".$this->sql->prebdd."leg SET leg_etat = '1', leg_cid = '$cid' WHERE leg_lid = '$lid'";
		$this->sql->query($sql);
		return 1;
	}
	
	//Afficher les attaques qui sont proches (a 5 cases)
	function detect($mid)
	{
		$sql="SELECT atq_dst,atq_mid,mbr_pseudo
		     FROM ".$this->sql->prebdd."atq LEFT JOIN ".$this->sql->prebdd."mbr ON atq_mid = mbr_mid
		     WHERE  atq_dst <= ".ATQ_DETECT_DST." AND atq_mid2='$mid'";
		return $this->sql->make_array($sql);
	}
	
	function nb_atq($mid,$fini)
	{
		$mid = (int) $mid;
		$fini = (bool) $fini;
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."atq WHERE ";
		if($fini)
		{
			$sql.="(atq_mid='$mid' OR atq_mid2='$mid') AND atq_date_arv != '0000-00-00 00:00:00'";	
		}
		else
		{
			$sql.="(atq_mid2='$mid' OR atq_mid='$mid') AND atq_date_arv = '0000-00-00 00:00:00'";
		}

		$res = $this->sql->query($sql);
		return mysql_result($res,0);
	}
	
	function get_infos($mid, $fini = true, $limite1_or_aid = 0, $limite2 = 0)
	{
		$mid = (int) $mid;
		$fini = (bool) $fini;
		$limite1_or_aid = (int) $limite1_or_aid;
		$limite2 = (int) $limite2;
		
	
		if($fini)
		{
			$sql="SELECT atq_aid, atq_mid, 
			formatdate(atq_date_dep) as atq_date_dep_formated,
			formatdate(atq_date_arv) as atq_date_arv_formated,
			atq_res1_type, atq_result, atq_res1_nb, atq_res2_type, atq_res2_nb,atq_speed, atq_lid, atq_mid2, atq_dst, atq_atq_unt, atq_atq_btc, atq_def, mbr_pseudo, mbr_etat, mbr_race,leg_name, atq_bilan, mbr_atq_nb, mbr_points
			FROM ".$this->sql->prebdd."atq 
			LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = CASE WHEN  atq_mid = '$mid' THEN atq_mid2 ELSE atq_mid END
			LEFT JOIN ".$this->sql->prebdd."leg ON leg_lid = atq_lid
			WHERE  atq_date_arv != '0000-00-00 00:00:00' AND mbr_race > 0 AND mbr_etat = 1";
			$sql .= " AND (atq_mid=$mid OR atq_mid2=$mid)";
		}
		else
		{
			$sql="SELECT atq_aid, atq_mid, 
			formatdate(atq_date_dep) as atq_date_dep_formated,
			leg_name,atq_speed, atq_lid, atq_mid2, atq_dst, mbr_pseudo, atq_atq_unt, atq_atq_btc, mbr_etat, mbr_race, mbr_atq_nb, mbr_points
			FROM ".$this->sql->prebdd."atq LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = CASE WHEN  atq_mid = '$mid' THEN atq_mid2 ELSE atq_mid END
			LEFT JOIN ".$this->sql->prebdd."leg ON leg_lid = atq_lid
			WHERE  atq_date_arv = '0000-00-00 00:00:00'";
			$sql .= " AND (atq_mid=$mid OR (atq_mid2=$mid AND atq_dst <= ".ATQ_DETECT_DST."))";
		}
		
		if(!$limite2)
		{
			$sql.=" AND atq_aid='$limite1_or_aid'";
		}
		else
		{
			$sql .=" ORDER BY atq_date_arv DESC";
			$sql.=" LIMIT $limite1_or_aid,$limite2";
		}

		$return = $this->sql->make_array($sql);
		
		if($fini)
		{
			foreach($return as $key => $value)
			{
				$return[$key]['bilan_war'] = unserialize($value['atq_bilan']);
			}
		}
		
		//print_r($return);
		return $return;
	}
	
	function can_atq($mid, $points, $mid2)
	{
		$mid 	= (int) $mid;
		$points = (int) $points;
		$mid2 	= (int) $mid2;
		
		$sql="SELECT mbr_points FROM ".$this->sql->prebdd."mbr WHERE mbr_mid = '$mid2' AND mbr_etat = 1 GROUP BY mbr_mid";
		$req = $this->sql->query($sql);
		$nb  = mysql_num_rows($req);
		if($nb != 1)
		{
			return 3;
		}
		$pts = mysql_result($req, 0);
		
		if($pts >= ATQ_LIM_DIFF AND $points >= ATQ_LIM_DIFF)
		{
			return 0;
		}

		if($points <= ATQ_PTS_MIN)
		{
			//pas le droit d'attaquer, trop faible
			return 2;
		}
		//elseif(($pts / $points < ATQ_PTS_RAP) OR ($pts < ATQ_PTS_MIN))
		elseif(abs($pts - $points) >= ATQ_PTS_DIFF)
		{
			//pas le droit d'attaquer $mid2, il est trop faible
			return 1;
		}else{
			return 0;
		}
	}
	
	function cancel($mid, $aid)
	{
		$mid = (int) $mid;
		$aid = (int) $aid;
		
		$sql="SELECT atq_lid FROM ".$this->sql->prebdd."atq WHERE atq_aid = $aid AND atq_mid = $mid";
		$lid=@mysql_result($this->sql->query($sql), 0);
		if($lid)
		{
			$sql="UPDATE ".$this->sql->prebdd."leg SET leg_etat = 2 WHERE leg_lid = $lid AND leg_mid = $mid";
			$this->sql->query($sql);
			$sql="DELETE FROM ".$this->sql->prebdd."atq WHERE atq_aid = $aid AND atq_mid = $mid";
			$this->sql->query($sql);
			return true;
		}else{
			return false;
		}
	}
	
	function make_atq($mid1, $mid2, $atq_infos, $unt_array_mid1, $unt_array_mid2, $btc_array_mid2, $res_array_mid2, $conf_mid2, $make_atq = true)
	{
		#Definition des variables
		$atq_aid = $atq_infos['atq_aid'];
		
		$mid1_atq_btc = $atq_infos['atq_atq_btc'];	
		$mid1_atq_unt = $atq_infos['atq_atq_unt'];	

		$mid2_def_unt = 0;
		$mid2_def_btc = 0;
		
		$atq_unt_nb[0] = 0;
		$atq_unt_nb[1] = 0;
		
		$leg_lid = $atq_infos['atq_lid'];
		
		$bonus_atq = 0;
		$bonus_def = array();
		
		$leg_xp = array();
		
		#calcul des unités de $mid1
		uasort($unt_array_mid1,array("war","tri_unt"));
		foreach($unt_array_mid1 as $unt_type => $unt_value)
		{
				$unt_nb = $unt_value['unt_nb'];
				$atq_unt_nb[0]+= $unt_nb;
				$unt_array[$mid1][$unt_type] = array('unt_nb' => $unt_nb,'unt_lid' => $leg_lid);
				$bonus_atq += $this->conf->unt[$unt_type]['bonus']['atq']*$unt_nb;
		}
		
		$bonus_atq = ($bonus_atq < GAME_MAX_UNT_BONUS) ? $bonus_atq :  GAME_MAX_UNT_BONUS;
		$bonus_atq += floor($unt_array_mid1[$unt_type]['leg_xp'] / 100);
		
		$mid1_atq_unt +=  round(($mid1_atq_unt / 100)*$bonus_atq);
		$mid1_atq_btc +=  round(($mid1_atq_unt / 100)*$bonus_atq);
		
		#calcul de la force de l'autre
		if(is_array($unt_array_mid2))
		{
			foreach($unt_array_mid2 as $unt_leg_lid => $unt_leg_value)
			{
				uasort($unt_leg_value,array("war","tri_unt"));
				$unt_array_mid2[$unt_leg_lid] = $unt_leg_value;
				foreach($unt_leg_value as $unt_type => $unt_value)
				{
					if($unt_leg_lid == 0 OR $unt_value['leg_etat'] == 0)
					{
						$unt_nb = $unt_value['unt_nb'];
						if($conf_mid2->unt[$unt_type]['type'] != TYPE_UNT_CIVIL)
						{
							$atq_unt_nb[1]+= $unt_nb;
							$mid2_def_leg[$unt_leg_lid] += $conf_mid2->unt[$unt_type]['defense'] * $unt_nb;
							$unt_array[$mid2][$unt_leg_lid][$unt_type] = array('unt_nb' => $unt_nb, 'unt_lid' => $unt_leg_lid, "0" => $unt_value['unt_role']);
						}
						$bonus_def_tmp['leg'][$unt_leg_lid] += $conf_mid2->unt[$unt_type]['bonus']['def']*$unt_nb;
						$bonus_def_tmp_xp['leg'][$unt_leg_lid] = round($unt_value['leg_xp'] / 100);					
					}
				}
				$mid2_def_unt += $mid2_def_leg[$unt_leg_lid];
			}
		}
		$mid2_is_def = ($mid2_def_unt > 0) ? true : false;

		#Calcul du bonus differencié
		if(is_array($bonus_def_tmp['leg']))
		{
			foreach($bonus_def_tmp['leg'] as $bonus_def_lid => $bonus_def_value)
			{
				#On dépasse pas les 30% :]
				if($bonus_def_value > GAME_MAX_UNT_BONUS) {
					$bonus_def_value = GAME_MAX_UNT_BONUS + $bonus_def_tmp_xp['leg'][$bonus_def_lid];
					/*if($bonus_def_tmp_xp['leg'][$bonus_def_lid] > GAME_MAX_UNT_BONUS)
						$bonus_def_value += GAME_MAX_UNT_BONUS;
					else
						$bonus_def_value += $bonus_def_tmp_xp['leg'][$bonus_def_lid];*/
				}
				//$bonus_def_value = (($bonus_def_value < GAME_MAX_UNT_BONUS) ? $bonus_def_value : GAME_MAX_UNT_BONUS) + ;
				$bonus_def['leg'][$bonus_def_lid] = $bonus_def_value;
				#Calcul
				if($bonus_def_value) { $mid2_def_unt += round(($mid2_def_leg[$bonus_def_lid] / 100)*$bonus_def_value);
				}
			}
		}
		
		#Il a pas d'unités
		if(is_array($btc_array_mid2))
		{
			foreach($btc_array_mid2 as $btc_bid => $btc_value)
			{
				$btc_type = $btc_value['btc_type'];
				if($conf_mid2->btc[$btc_type]['def_prio'])
				{
					$btc_prio[$btc_bid] = $btc_bid; //gestion des priorité d'attaque
				}
				$mid2_def_btc += $conf_mid2->btc[$btc_type]['defense']; //defense des bâtiments
				$bonus_def['btc'] += $conf_mid2->btc[$btc_type]['bonusdef']; //bonus de def des btc
				if($conf_mid2->btc[$btc_type]['bonusdef'] OR $conf_mid2->btc[$btc_type]['defense'] OR rand(0,30) == 1)
				{
					$btc_mid2_vus[$btc_type]++;
				}
			}
		}
		
		#Calcul du bonus des btc
		$bonus_def['btc'] = ($bonus_def['btc'] > 0) ? $bonus_def['btc'] : 0;
		
		#Calculs zarbis
		$atq_atq = ($mid2_is_def) ? $mid1_atq_unt : $mid1_atq_btc;
		$atq_def = ($mid2_is_def) ? $mid2_def_unt+$mid2_def_btc : $mid2_def_btc;

		if(($mid1_atq_unt + $mid1_atq_btc + $atq_def) == 0 OR ($atq_def + $atq_atq) == 0)
		{
			$atq_tot_unt = 0;
			$atq_tot_btc = 0;
			$tx_atq = 0.5;
			$tx_def = 0.5;
		}
		else
		{
			$atq_tot_unt = ($mid1_atq_unt + $atq_def) / ATQ_COEF;
			$atq_tot_btc = ($mid1_atq_btc + $atq_def) / ATQ_COEF;
			$tx_atq = $atq_atq / ($atq_def + $atq_atq);
			$tx_def = $atq_def / ($atq_def + $atq_atq);
		}

					
		$mid2_atq_def_eff = round($tx_def * (($mid2_is_def) ? $atq_tot_unt : $atq_tot_btc));
		$mid1_atq_unt_eff = round($tx_atq * $atq_tot_unt);
		$mid1_atq_btc_eff = round($tx_atq * $atq_tot_btc); //$atq_atq; 
		
		/*
		echo $tx_atq."-".$tx_def;
		
		echo "<br/>".($atq_def / 5)." - $mid2_atq_def_eff = round($tx_def * (($mid2_is_def) ? $atq_tot_unt : $atq_tot_btc))";
		echo "<br/>".($atq_atq / 5)." - $mid1_atq_unt_eff = round($tx_atq * $atq_tot_unt)<br/>";
		echo "<br/>".($atq_atq / 5)." - $mid1_atq_btc_eff = round($tx_atq * $atq_tot_btc)"; //$atq_atq; 
		*/
			
		#Application du bonus des btc et ajout def btc
		if($mid2_is_def) $mid2_atq_def_eff += round(($mid2_atq_def_eff * $bonus_def['btc']) / 100);
		
		$atq_atq_unt_eff = $mid1_atq_unt_eff;
		$atq_atq_btc_eff = $mid1_atq_btc_eff;
		
		$atq_def_eff	= $mid2_atq_def_eff;
		
		//L'attaquant [le défenseur] gagne "(ATK [DEF] / 500) * (PTMIN / PTMAX)" pts d'XP.
		//Le 500 est un nombre arbitraire qui limite la quantité d'XP gagnée. Il pourra être ajusté ultérieurement si besoin est (mais il semble correct).
		//Enfin, faire qu'une armée qui devient vide (tombe à 0 pts de vie lors d'un combat) perde 20 pts d'XP
		
		$coef_xp = min($mid2_atq_def_eff,($mid2_is_def) ? $mid1_atq_unt_eff : $mid1_atq_btc_eff) /  max($mid2_atq_def_eff,($mid2_is_def) ? $mid1_atq_unt_eff : $mid1_atq_btc_eff);
		$leg_def_xp = ceil(($mid2_atq_def_eff / ATQ_LIM_XP) * $coef_xp);
		$leg_atq_xp = ceil(((($mid2_is_def) ? $mid1_atq_unt_eff : $mid1_atq_btc_eff) / ATQ_LIM_XP) * $coef_xp);
		
		/*$leg_def_xp = ceil($mid2_atq_def_eff / 100);
		$leg_atq_xp = ceil((($mid2_is_def) ? $mid1_atq_unt_eff : $mid1_atq_btc_eff) / 100);
		*/
		
		#on attaque les gens
		if($mid2_is_def)
		{
			#victoire ?
			$victoire = ($mid2_def_unt < $mid1_atq_unt);
			#ceux de celui qui attaque
			$unt_mort_max = $atq_unt_nb[0];//$victoire ? round($atq_unt_nb[0] * ATQ_PERC_DEF) : round($atq_unt_nb[0] * ATQ_PERC_WIN);
			#ceux des autres
			$unt_tues_max = $atq_unt_nb[1];//$victoire ? round($atq_unt_nb[1] * ATQ_PERC_WIN) : round($atq_unt_nb[1] * ATQ_PERC_DEF);

			foreach($unt_array[$mid2] as $unt_lid => $unt_leg_value) #parcours de toutes les légions
			{
			foreach($unt_leg_value as $unt_type => $unt_value) #parcours des unités dans les légions
			{
				$unt_nb = $unt_value['unt_nb'];
				if($unt_tues_max  > 0 AND $mid1_atq_unt_eff > 0 AND $conf_mid2->unt[$unt_type]['type'] != TYPE_UNT_CIVIL)
				{
					$leg_xp[$unt_lid] = $leg_def_xp;
					$vie = $conf_mid2->unt[$unt_type]['vie'];
					$morts = 0;
					if((($vie * $unt_nb) - $mid1_atq_unt_eff) > 0)
					{
						$morts = floor($mid1_atq_unt_eff / $vie);
						$morts = ($morts > $unt_tues_max) ? $unt_tues_max : $morts;

						$unt_array[$mid2][$unt_lid][$unt_type]['unt_nb'] -= $morts;
						$update_unt_sql[$mid2][$unt_lid][$unt_type] += $morts;
						$atq_tues += $morts;
						$mid1_atq_unt_eff = 0;
					}
					else
					{
						$morts = ($unt_nb > $unt_tues_max) ? $unt_tues_max : $unt_nb;

						$unt_array[$mid2][$unt_lid][$unt_type]['unt_nb'] -= $morts;
						$update_unt_sql[$mid2][$unt_lid][$unt_type] += $morts;
						$atq_tues += $morts;
						$mid1_atq_unt_eff -= ($vie * $morts);
					}
					$unt_tues_max -= $morts;
					
					#Butin
					if($morts)
					{
						$prix = $conf_mid2->unt[$unt_type]['prix'];
						$atq_res2_type = array_rand ($prix);
						$atq_res2_nb   = ($prix[$atq_res2_type] * $morts);
					}
				}
			}
			}
			
			if($mid1_atq_unt_eff <= ($atq_atq_unt_eff / 2))
			{
				$atq_finie = true;
				$mid1_atq_btc_eff = 0;
				$atq_atq_btc_eff = 0;
			}
			else
			{
				$mid1_atq_btc_eff = $mid1_atq_btc_eff / 2;
				$atq_atq_btc_eff  = $atq_atq_btc_eff / 2;
			}
				
			
			#Butin
			if(!$atq_res2_type)
			{
				$atq_res1_type = 1;
				$atq_res1_nb   = 0;
			}
			
			foreach($unt_array[$mid1] as $unt_type => $unt_value)
			{
				$unt_nb = $unt_value['unt_nb'];
				$unt_lid = $unt_value['unt_lid'];
				if($unt_mort_max > 0 AND $mid2_atq_def_eff > 0)
				{
					$vie = $this->conf->unt[$unt_type]['vie'];
					if((($vie * $unt_nb) - $mid2_atq_def_eff) > 0)
					{
						$morts = floor($mid2_atq_def_eff / $vie);
						$morts = ($morts > $unt_mort_max) ? $unt_mort_max : $morts;

						$update_unt_sql[$mid1][$unt_lid][$unt_type] += $morts;
						$unt_array[$mid][$unt_type]['unt_nb'] -= $morts;
						$atq_mort += $morts;
						$mid2_atq_def_eff = 0;
					}
					else
					{
						$morts = ($unt_nb > $unt_mort_max) ? $unt_mort_max : $unt_nb;

						$unt_array[$mid1][$unt_type]['unt_nb'] -= $morts;
						$update_unt_sql[$mid1][$unt_lid][$unt_type] += $morts;
						$atq_mort += $morts;
						$mid2_atq_def_eff -= ($vie * $morts);
					}
					$unt_mort_max -= $morts;
				}
			}
			$leg_all_killed = ($atq_unt_nb[0] <= $atq_mort) ? true : false;
			
		}
		#on attaques les batiments
		
		if((!$mid2_is_def OR $atq_finie != true) AND count($btc_array_mid2) > 0)
		{		
			$victoire = ($mid2_def_btc < $mid1_atq_btc);
			
			#ceux de celui qui attaque
			$unt_mort_max = $atq_unt_nb[0]; //$victoire ? round($atq_unt_nb[0] * ATQ_PERC_DEF) : round($atq_unt_nb[0] * ATQ_PERC_WIN);

			#choisir ATQ_BTC_MAX fois un btc au hazard et le massacrer		
			$i = 0;
			while($i < ATQ_MAX_BTC)
			{
				$i++;
				$rand = round(rand(round((count($btc_array_mid2) * 3/4)),count($btc_array_mid2))-1); $j = 0;
				
				#selection dans la prio
				if(is_array($btc_prio) AND count($btc_prio) > 0)
				{
					$btc_bid = array_rand($btc_prio);
					unset($btc_prio[$btc_bid]);	
				}
				#dans la fin du village
				else
				{
					reset($btc_array_mid2);
					//if(!$btc_atq)
					//{
						while($j < $rand)
						{
							next($btc_array_mid2);
							$j++;
						}
						$btc_bid = key($btc_array_mid2);
					//}
				}
				
				#si on a plus rien -> au hazard
				if(/*$btc_atq OR */!$btc_bid OR !$btc_array_mid2[$btc_bid]['btc_type'] OR $btc_array_mid2[$btc_bid]['btc_type'] == 1)
				{
					$btc_bid = array_rand($btc_array_mid2);
					//$mid1_atq_btc_eff = ($mid1_atq_btc_eff / 2);	
				}
				
				#si on a rien, on arrete 
				if(!$btc_bid) break;
				
				
				$btc_type = $btc_array_mid2[$btc_bid]['btc_type'];
				$btc_vie_actuel = $btc_array_mid2[$btc_bid]['btc_vie'];
				
				if(!isset($update_btc_sql[$btc_bid]['btc_vie']))
				{
					$update_btc_sql[$btc_bid]['btc_vie'] = $btc_vie_actuel;	
					$update_btc_sql[$btc_bid]['btc_type'] = $btc_type;
				}
				
				#on enleve
				/*if($mid1_atq_btc_eff <= 0)
					break;*/
				
				if(($btc_vie_actuel - $mid1_atq_btc_eff) > 0)
				{
					$update_btc_sql[$btc_bid]['btc_vie'] -= $mid1_atq_btc_eff;
					$btc_vie_enlevee = $mid1_atq_btc_eff;
					$atq_btc_end++;
					$break = true; #on lui dit de sortir apres le calcul des ressources, si un bâtiment est juste endommagé, inutile de continuer
				}
				else
				{
					$victoire = true;
					$unt_mort_max = $atq_unt_nb[0]; //$victoire ? $unt_mort_max : round($atq_unt_nb[0] * ATQ_PERC_NUL); 
					
					$update_btc_sql[$btc_bid]['btc_vie'] = 0; #on eleve la vie, il sera viré par clean.php
					$delete_btc_sql[$btc_bid] = true;
					$mid1_atq_btc_eff -= $btc_vie_actuel;
					$btc_vie_enlevee = $btc_vie_actuel;
					
					unset($btc_array_mid2[$btc_bid]); #on le vire du tableau
					$atq_btc++; #un bâtiment tué en plus
					
					$res_bonus = true;
					#on rend les gisements, etc, parce que bon
					if(is_array($conf_mid2->btc[$btc_type]['prix']))
					{
						foreach($conf_mid2->btc[$btc_type]['prix'] as $res_type => $res_nb)
						{
						if($conf_mid2->res[$res_type]['nobat'] == true)
						{
							$update_res_sql[$mid2][$res_type] += $res_nb;
						}
						}
					}
					
					#on remet la population
					if($conf_mid2->btc[$btc_type]['population'])
					{
						$update_res_sql[$mid2][GAME_RES_PLACE] -= $conf_mid2->btc[$btc_type]['population'];
					}
								
					#on tue les gens qui travaillaient dedans aussi *niark*
					if(is_array($conf_mid2->btc[$btc_type]['needguy']))
					{
						foreach($conf_mid2->btc[$btc_type]['needguy'] as $c_unt_type => $c_unt_nb)
						{
							$update_unt_sql[$mid2][1][$c_unt_type] += $c_unt_nb;
							$atq_tues += $c_unt_nb;
						}
					}
					
								
				}
							
				#recuperer les res du btc
				$produit = $conf_mid2->btc[$btc_type]['produit'];
				if(!$atq_res2_type)
				{
					if(is_array($produit))
					{
						$atq_res2_type = array_rand($produit);
						while($conf_mid2->res[$atq_res2_type]['nobat'] == true)
						{
							$atq_res2_type = array_rand($produit);
						}
					}
					$atq_res2_nb  = $res_bonus ? $produit[$atq_res2_type] * ATQ_PROD_BONUS : $atq_res2_nb;
				}
				
				
				if(!$atq_res2_type)
				{
					$produit = $conf_mid2->btc[$btc_type]['prix'];
					if(is_array($produit))
					{
						$atq_res2_type = array_rand($produit);
						while($conf_mid2->res[$atq_res2_type]['nobat'] == true)
						{
							$atq_res2_type = array_rand($produit);
						}
					}
					$atq_res2_nb = $res_bonus ? $produit[$atq_res2_type] * 0.5 : 0;
				}
				
				
				
				if($break == true)
				{
					break;
				}
				$break = false;
				$res_bonux = false;
			}
			
			#on tue notre armée
			foreach($unt_array[$mid1] as $unt_type => $unt_value)
			{
				$unt_nb = $unt_value['unt_nb'];
				$unt_lid = $unt_value['unt_lid'];
				if($unt_mort_max > 0 AND $mid2_atq_def_eff > 0)
				{
					$vie = $this->conf->unt[$unt_type]['vie'];
					if((($vie * $unt_nb) - $mid2_atq_def_eff) > 0)
					{
						$morts = floor($mid2_atq_def_eff / $vie);
						$morts = ($morts > $unt_mort_max) ? $unt_mort_max : $morts;

						$update_unt_sql[$mid1][$unt_lid][$unt_type] += $morts;
						$unt_array[$mid][$unt_type]['unt_nb'] -= $morts;
						$atq_mort += $morts;
						$mid2_atq_def_eff = 0;
					}
					else
					{
						$morts = ($unt_nb > $unt_mort_max) ? $unt_mort_max : $unt_nb;

						$unt_array[$mid1][$unt_type]['unt_nb'] -= $morts;
						$update_unt_sql[$mid1][$unt_lid][$unt_type] += $morts;
						$atq_mort += $morts;
						$mid2_atq_def_eff -= ($vie * $morts);
					}
					$unt_mort_max -= $morts;
				}
			}

			$leg_all_killed = ($atq_unt_nb[0] <= $atq_mort) ? true : false;	
			$atq_finie = true;	
		}
		
		if($atq_finie != true)
		{
			$mid1_atq_btc = 0;
			$mid2_def_unt = 0;
			$atq_res1_type = GAME_RES_PRINC;
			$atq_res1_nb   = 0;
			$atq_res2_type = GAME_RES_PRINC;
			$atq_res2_nb   = 0;
		}
		
		# Affectation de l'xp
		if($leg_all_killed) $leg_atq_xp = -5;
		$leg_xp[$leg_lid] = $leg_atq_xp;
		
		# Butin N°1
		$atq_res1_type = array_rand($res_array_mid2);
		$atq_res1_nb   = $res_array_mid2[$atq_res1_type]['res_nb'];
		$i = 0;
		while($conf_mid2->res[$atq_res1_type]['nobat'] == true OR ($atq_res1_nb == 0 AND $i < 50))
		{
			$atq_res1_type = array_rand($res_array_mid2);
			$atq_res1_nb = $res_array_mid2[$atq_res1_type]['res_nb'];
			$i++;
		}

		if($conf_mid2->res[$atq_res1_type]['nobat'])
		{
			$atq_res1_type = GAME_RES_PRINC;
			$atq_res1_nb = 0;
		}
		
		#Butin N°2
		if($conf_mid2->res[$atq_res2_type]['nobat'])
		{
			$atq_res2_type = GAME_RES_PRINC;
			$atq_res2_nb = 0;
		}
		
		$tx_res = $tx_atq - ATQ_BUTIN_MDL;
		$tx_res = ($tx_res < ATQ_BUTIN_MIN) ? ATQ_BUTIN_MIN : (($tx_res > ATQ_BUTIN_MAX) ? ATQ_BUTIN_MAX : $tx_res);
		$atq_res1_nb = ceil($atq_res1_nb * $tx_res);
		$atq_res1_nb = (int) (($leg_all_killed) ? 0 : ($atq_res1_nb > ATQ_MAX_RES_NB) ? ATQ_MAX_RES_NB : $atq_res1_nb);
		$update_res_sql[$mid2][$atq_res1_type] -= $atq_res1_nb;
		
		# Butin N°2
		$atq_res2_nb = (int) (($atq_res2_nb > ATQ_MAX_RES_NB) ? ATQ_MAX_RES_NB : $atq_res2_nb);
		if($leg_all_killed) $atq_res2_nb = 0;
		$leg_etat =  ($leg_all_killed) ? 0 : 2;
    		
    		#resultat
    		$atq_result = ($tx_atq <= ATQ_PERC_DEF) ? 1 : (($tx_atq <= ATQ_PERC_NUL) ? 2 : 3);
    		
    		
    		$bilan_war = array(
					'atq_result'    => $atq_result,
					
					/*'atq_atq_btc'		=> $mid1_atq_btc,
					'atq_atq_unt'		=> $mid1_atq_unt,
					'atq_def'		=> ($mid2_is_def) ? $mid2_def_unt+$mid2_def_btc : $mid2_def_btc;,
					*/
					'atq_atq_unt_eff' => $atq_atq_unt_eff,
					'atq_atq_btc_eff' => $atq_atq_btc_eff,
					'atq_def_eff'	=> $atq_def_eff,
					
					'atq_def'	=> $atq_def+0, //Defence
					'atq_morts'	=> $atq_mort+0, //Nombre de morts 
					'atq_tues'	=> $atq_tues+0, //Nombre de tués
					'atq_btc'	=> $atq_btc+0, //Nombre de btc détruits
					'atq_btc_end'	=> $atq_btc_end+0, //Nombre de btc endomagés
					
					'leg_xp'	=> $leg_xp, //un array qui contient les infos sur l'xp
					'leg_lid'	=> $leg_lid+0, //Légion
					'leg_all_killed'=> $leg_all_killed, //Tout le monde est mort ?
					
					'atq_res1_type' => $atq_res1_type+0, //butin 1
					'atq_res1_nb'	=> round($atq_res1_nb+0), 
					'atq_res2_type' => $atq_res2_type+0, //butin 2
					'atq_res2_nb'	=> round($atq_res2_nb+0),
					
					'atq_mid1'	=> $mid1, //mid 1
					'atq_mid2'	=> $mid2, //mid 2
					
					'unt_array_mid1'=> $unt_array_mid1,
					'details_unt' 	=> $update_unt_sql, //details sur les unités
					'details_btc' 	=> $update_btc_sql, //details sur les bâtiments
					
					'btc_mid2_vus' => $btc_mid2_vus,
					
					'bonus_def'	=> $bonus_def, //bonus de defense (array pour stoquer btc, et conneries du genre)
					'bonus_atq'	=> $bonus_atq, //bonus d'attaque (int)
					'atq_unt_nb'	=> $atq_unt_nb, //Nombre d'attaquants
					);


		/*print_r($bilan_war); *///return $bilan_war;

		//Modifier le batiment
		if(is_array($update_btc_sql))
		{
		foreach($update_btc_sql as $btc_bid => $btc_value)
		{
			$btc_vie = $btc_value['btc_vie'];
			$sql="UPDATE ".$this->sql->prebdd."btc SET btc_vie = $btc_vie WHERE btc_bid = $btc_bid AND btc_mid = $mid2";
			if($btc_bid) $this->sql->query($sql);
		}
		}
		
		if(is_array($delete_btc_sql))
		{
		foreach($delete_btc_sql as $btc_bid => $btc_value)
		{
			$sql="DELETE FROM ".$this->sql->prebdd."btc WHERE btc_bid = '$btc_bid'";
			$this->sql->query($sql);
		}	
		}
		
		//Virer les unt
		if(is_array($update_unt_sql))
		{
			$sql="UPDATE ".$this->sql->prebdd."unt SET unt_nb = CASE ";
			foreach($update_unt_sql	as $unt_mid => $unt_value_1)
			{
				foreach($unt_value_1 as	$leg_tmp_lid => $unt_value_2)
				{
					foreach($unt_value_2 as	$unt_type => $unt_nb)
					{
						$sql.=" WHEN unt_type = $unt_type AND unt_mid = $unt_mid AND unt_lid = $leg_tmp_lid THEN unt_nb - $unt_nb ";
						$where_unt .= " OR unt_mid = $unt_mid";
						$update_pop_sql[$unt_mid] = $unt_nb;
					}
				}
			}
			$sql.=" ELSE unt_nb END WHERE (0 ".$where_unt.")";
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
					if($res_nb)
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
		
		//Updater atq
		//atq_extra
		$bilan_war_sql  = serialize($bilan_war);
		$sql="UPDATE ".$this->sql->prebdd."atq SET 
					atq_result = $atq_result, 
					atq_date_arv = NOW(),
					atq_def = ".$bilan_war['atq_def'].",
					atq_res1_type = ".$bilan_war['atq_res1_type'].",
					atq_res1_nb = ".$bilan_war['atq_res1_nb'].",
					atq_res2_type = ".$bilan_war['atq_res2_type'].",
					atq_res2_nb = ".$bilan_war['atq_res2_nb'].",
					atq_bilan = '$bilan_war_sql'";

		if($leg_all_killed) $sql.= ",atq_date_vil = NOW()";
		$sql.=" WHERE atq_aid = $atq_aid";
		$this->sql->query($sql);
		

		
		//pour la limite
		$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_atq_nb = "; 
		$sql.= "mbr_atq_nb + 1 ";
		$sql.= " WHERE mbr_mid = $mid1 ";
		$this->sql->query($sql);
		
		#donner l'xp
		$sql="UPDATE ".$this->sql->prebdd."leg SET leg_xp = CASE ";
		foreach($leg_xp as $leg_lid => $nb_xp)
		{
		$sql.=" WHEN leg_lid = $leg_lid THEN leg_xp + $nb_xp";	
		$where_lid.= " OR leg_lid = $leg_lid ";
		}
		$sql.=" END WHERE (0 ".$where_lid.")";
		$this->sql->query($sql);
		
		//Metre la légions en "retour"
		$sql="UPDATE ".$this->sql->prebdd."leg SET leg_etat = $leg_etat WHERE leg_lid = '$leg_lid'";
		$this->sql->query($sql);
		return $bilan_war;
	}
}
?>