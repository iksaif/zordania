<?	
class unt
{
	var $sql,$conf,$game;
	function unt(&$db, &$conf, &$game)
	{
		$this->conf = &$conf; // config
		$this->sql = &$db; //objet mysql
		$this->game = &$game; // game
	}
	
	function add($mid,$type,$nb,$leg = false,$pend = false)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$nb = (int) $nb;
		//$leg <0  = a construire
		$leg = (int) $leg;
		$pend = (bool) $pend;
		if(isset($this->conf->unt[$type]))
		{
			$cfg_unt = $this->conf->unt[$type];
			
			//on paye
			if(is_array($cfg_unt['prix']))
			{
				foreach($cfg_unt['prix'] as $a_type => $nbres)
				{
					if($pend) $nbres = $nbres / 2;
					$this->game->add_res($mid,$a_type,-($nbres*$nb));
				}
			}

			//on paye les unités
			
			if(is_array($cfg_unt['needguy']))
			{
				foreach($cfg_unt['needguy'] as $a_type => $nbguy)
				{
					if($pend) $nbguy = $nbguy / 2;
					$this->game->add_unt($mid,$a_type ,-($nbguy*$nb), 0,true);
				}
			}
			
			$sql="UPDATE ".$this->sql->prebdd."unt SET unt_nb=unt_nb+$nb WHERE unt_type=$type AND unt_mid=$mid AND unt_lid = '$leg' ";
			$req = $this->sql->query($sql);
			if(!mysql_affected_rows() AND $nb != 0)
			{
				$sql="SELECT unt_prio FROM ".$this->sql->prebdd."unt WHERE unt_type=$type AND unt_mid=$mid AND unt_lid=0";
				$prio = mysql_result($this->sql->query($sql), 0,'unt_prio');
				$sql="INSERT INTO ".$this->sql->prebdd."unt VALUES ('','$mid','$leg','$type','$nb','$prio')";
				return $this->sql->query($sql);
			}
			return $req;
		}else{
			return false;
		}
	}
	
	function update_pop($mid)
	{
		$mid = (int) $mid;

		$sql="SELECT SUM(unt_nb) FROM ".$this->sql->prebdd."unt WHERE unt_mid= '$mid' AND unt_lid >= 0 GROUP BY unt_mid";
		$pop = mysql_result($this->sql->query($sql),0);
		$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_population = $pop WHERE mbr_mid = $mid";
		
		return $this->sql->query($sql);
	}
	
	function list_unt($mid)
	{
		$mid = (int) $mid;
		
		$res = $this->game->get_infos_res($mid);
		$src = $this->game->get_infos_src($mid);
		$unt = $this->game->get_infos_unt($mid);
		//$unt = $unt[1];
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);
		
		foreach($this->conf->unt as $unt_id => $c_unt)
		{
		
			if(is_array($c_unt))
			{
				$unt_ok = true;
				if(is_array($c_unt['needguy']))
				{
				foreach($c_unt['needguy'] as $key => $value)
				{
					$unt_ok = true;
					if($unt[1][$key]['unt_nb'] >= $value AND $unt_ok == true)
					{
						$unt_ok = true;
					}else{
						$unt_ok = false;
					}
				}
				}
				$btc_ok = true;
				if(is_array($c_unt['needbat']))
				{
					foreach($c_unt['needbat'] as $key => $value)
					{
					if($btc[$key] AND $btc_ok == true)
					{
						$btc_ok = true;
					}else{
						$btc_ok = false;
					}
				}
				}
				
				$res_ok = true;
				if(is_array($c_unt['prix']))
				{
				foreach($c_unt['prix'] as $key => $value)
				{
					if($res[$key]['res_nb'] >= $value AND $res_ok == true)
					{
						$res_ok = true;
					}else{
						$res_ok = false;
					}
				}	
				}
				
				$src_ok = true;
				if($c_unt['needsrc'])
				{
					if(!$src[$c_unt['needsrc']])
					{
						$src_ok = false;
					}
				}
				
				$nb_ok = true;
				if($c_unt['limite'] AND $c_unt['limite'] < ($unt[1][$unt_id]['unt_nb']+$unt[0][$unt_id]['unt_nb']+1))
				{
					$nb_ok = false;
				}
				
				if($btc_ok AND $src_ok AND $nb_ok)
				{
					//manque quelque chose
					$ok = 2;
				}else
				{
					//impossible
					$ok = 3;
				}
				if($res_ok AND $unt_ok AND $ok == 2)
				{
					//tout est bon
					$ok = 1;
				}
				$return[$unt_id]['dispo'] = $ok;
				if($ok == 2 or $ok == 1)
				{
					$return[$unt_id]['vars'] = $c_unt;
				}
			}
		}	
		return $return;	
	}		
		
	
	function can_build($mid,$type,$nb = 1)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$nb = (int) $nb;
		
		$res = $this->game->get_infos_res($mid);
		$unt = $this->game->get_infos_unt($mid);
		$unt_en_const = $this->game->get_infos_unt($mid,0,false);
		$src = $this->game->get_infos_src($mid);
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);

		if(is_array($unt_en_const[0]))
		{
		foreach($unt_en_const[0] as $key => $value)
		{
			$unt_en_const_nb += $value['unt_nb'];
		}
		}
		if(is_array($unt[0]))
		{
		foreach($unt[0] as $key => $value)
		{
			$unt_total_nb += $value['unt_nb'];
		}
		}
		if(is_array($unt[1]))
		{
		foreach($unt[1] as $key => $value)
		{
			$unt_total_nb += $value['unt_nb'];
		}
		}
		//$unt = $unt[1];
		
		//Cette unité existe ?
		if(!is_array($this->conf->unt[$type]))
		{
			return 0;
		}
		
		$c_unt = $this->conf->unt[$type];
		
		$unt_ok = true;
		if(is_array($c_unt['needguy']))
		{
		foreach($c_unt['needguy'] as $key => $value)
		{
			//$unt_ok = true;
			$unt_total_nb -= $unt[1][$key]['unt_nb'];
			if($unt[1][$key]['unt_nb'] >= ($value*$nb) AND $unt_ok == true)
			{
				$unt_ok = true;
			}else{
				$unt_ok = false;
			}
		}
		}
		$btc_ok = true;
		if(is_array($c_unt['needbat']))
		{
		foreach($c_unt['needbat'] as $key => $value)
		{
			if($btc[$key] AND $btc_ok == true)
			{
				$btc_ok = true;
			}else{
				$btc_ok = false;
			}
		}
		}
		
		$res_ok = true;
		if(is_array($c_unt['prix']))
		{
		foreach($c_unt['prix'] as $key => $value)
		{
			if($res[$key]['res_nb'] >= ($value * $nb) AND $res_ok == true)
			{
				$res_ok = true;
			}else{
				$res_ok = false;
			}
		}
		}
		
		$src_ok = true;
		if($c_unt['needsrc'])
		{
			if(!$src[$c_unt['needsrc']])
			{
				$src_ok = false;
			}
		}
		
		$pop_ok = true;
		if(($nb + $unt_total_nb) > $res[GAME_RES_PLACE]['res_nb'] OR ($nb + $unt_en_const_nb+$unt_total_nb) > GAME_MAX_UNT_TOTAL)
		{
			$pop_ok = false;
		}
		
		$nb_ok = true;
		if($c_unt['limite'] AND $c_unt['limite'] < ($nb+$unt[0][$type]['unt_nb']+$unt[1][$type]['unt_nb']+$unt_en_const[0][$type]['unt_nb']))
		{
			$nb_ok = false;
		}

		if((($btc_ok AND $src_ok) OR !$pop_ok) AND $nb_ok)
		{
			//manque quelque chose
			$ok = 2;
		}
		else
		{
			//impossible
			$ok = 3;
		}
		
		if($res_ok AND $unt_ok AND $ok == 2 AND $pop_ok)
		{
			//tout est bon
			$ok = 1;
		}

		return $ok;
	}
	
	function cancel($mid, $uid, $nb)
	{
		$mid = (int) $mid;
		$uid = (int) $uid;
		$nb = (int) $nb;
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."unt WHERE unt_lid < 0 AND unt_uid='$uid' AND unt_mid = '$mid'";
		$nb_in_db = mysql_result($this->sql->query($sql), 0);
		if($nb_in_db == 0)
		{
			return false;
		}
		
		//on recupere le type et le nombre
		$sql="SELECT unt_type, unt_nb, unt_lid FROM ".$this->sql->prebdd."unt WHERE unt_uid='$uid' AND unt_mid='$mid' AND unt_lid < 0";
		
		$req = $this->sql->query($sql);
		
		$type = mysql_result($req, 0, 'unt_type');
		$nb_in_db = mysql_result($req, 0, 'unt_nb');
		$unt_lid = mysql_result($req, 0, 'unt_lid');
		
		if($nb_in_db < $nb)
		{
			return false;
		}
		
		$cfg_unt = $this->conf->unt[$type];
		
		//on rembourse la moitié
		if(is_array($cfg_unt['prix']))
		{
			foreach($cfg_unt['prix'] as $r_type => $nbres)
			{
				$this->game->add_res($mid,$r_type,(ceil(($nbres/2)*$nb)));
			}
		}		
		
		//on rend les unités
		if(is_array($cfg_unt['needguy']))
		{
			foreach($cfg_unt['needguy'] as $u_type => $nbguy)
			{
				$this->game->add_unt($mid,$u_type ,($nbguy*$nb), 0, true);
				//$this->game->edit_leg($mid, ($nbguy*$nb), $nb, 1, 0);
			}
		}
				
		if($nb_in_db <= $nb AND $unt_lid < 0)
		{
			//il y'en a autant que dans la bdd
			return $this->del($mid,$uid);
		}else{
			//il y'en a moins
			$sql="UPDATE ".$this->sql->prebdd."unt SET unt_nb=unt_nb-$nb WHERE unt_uid='$uid' AND unt_mid='$mid'";
			return $this->sql->query($sql);
		}
	}
	
	function del($mid, $uid = 0)
	{
		$mid = (int) $mid;
		$uid = (int) $uid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."unt WHERE unt_mid='$mid'";
		if($uid)
		{
			$sql.=" AND unt_uid='$uid'";
		}
		return $this->sql->query($sql);
	}
	
	function get_infos($mid, $type = 0, $fini = true, $leg_diff = false)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;
		$leg_diff = (bool) $leg_diff;
		
		$sql="SELECT unt_uid,unt_type,unt_nb,unt_lid,unt_prio ";
		if($leg_diff)
		{
			$sql.=",leg_etat,leg_name,leg_xp ";
		}
		$sql.=" FROM ".$this->sql->prebdd."unt ";
		if($leg_diff)
		{
			$sql.="LEFT JOIN ".$this->sql->prebdd."leg ON leg_lid = unt_lid ";
		}
		$sql.=" WHERE unt_mid='$mid' ";
		
		if($type)
		{
			$sql.=" AND unt_type = '$type'";
		}

		if($fini)
		{
			$sql.=" AND (unt_lid >= 0)";
		}else{
			$sql.=" AND unt_lid < 0 ORDER BY unt_prio DESC";
		}
		
		$ar=$this->sql->make_array($sql);

		foreach($ar as $key => $value)
		{
			if($value['unt_lid'] == 0)
			{
				$dispo = 1;
			}else{
				$dispo = 0;
			}
			
			if($leg_diff)
			{
				if($value['unt_nb'] > 0)
				{
					if(!$return[$value['unt_lid']][$value['unt_type']])
					{
						$return[$value['unt_lid']][$value['unt_type']] = array('unt_nb' => $value['unt_nb'], 
													'unt_lid' => $value['unt_lid'],
													'unt_uid' => $value['unt_uid'],
													'leg_etat' => $value['leg_etat'],
													'leg_name' => $value['leg_name'],
													'leg_xp' => $value['leg_xp'],
													'unt_prio' => $value['unt_prio'],
													'unt_role' => $this->conf->unt[$value['unt_type']]['role']);
					}
					else
					{
						$return[$value['unt_lid']][$value['unt_type']]['unt_nb'] += $value['unt_nb'];	
					}
				}
			}
			elseif(!$return[$dispo][$value['unt_type']])
			{
				$return[$dispo][$value['unt_type']] = array('unt_nb' => $value['unt_nb'], 'unt_lid' => $value['unt_lid'],'unt_uid' => $value['unt_uid'],'unt_prio' => $value['unt_prio']);
			}else{
				$return[$dispo][$value['unt_type']]['unt_nb'] += $value['unt_nb'];
			}
		}

		return $return;		
	}
	
	function edit_leg($mid, $type, $nb, $leg_from, $leg_to, $name='noname', $mapcid = 0)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$leg_from = (int) $leg_from;
		$leg_to = (int) $leg_to;
		$mapcid = (int) $mapcid;
		//$leg_to -> FALSE => on crée une nouvelle | TRUE => on deplace | -2 => on laisse tomber
		$nb = (int) $nb;
		$name = htmlentities($name, ENT_QUOTES);
		
		//si il n'y a rien a faire
		if($nb <= 0 OR $leg_from == $leg_to)
		{
			return true;
		}
		
		//on verifie que les unités existent
		$sql="SELECT unt_nb FROM ".$this->sql->prebdd."unt WHERE unt_lid='$leg_from' AND unt_mid='$mid' AND unt_type='$type'";
		$unt_nb = mysql_result($this->sql->query($sql), 0);

		if($unt_nb < $nb)
		{
			return false;
		}

		if($leg_from > 1) {
		  $sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."leg WHERE leg_lid = $leg_from AND leg_mid='$mid' AND leg_etat = 0";
		  $req = $this->sql->query($sql);
		  //		echo $sql;
		  if(mysql_result($req, 0) != 1)
		    return false;
		}

		
		if($leg_to > 1)
		{
			//on verifie que la légion existe et qu'elle est du bon type
			$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."leg WHERE leg_lid = $leg_to AND leg_mid='$mid' AND leg_etat = 0";
			$req = $this->sql->query($sql);
			$leg_nb = mysql_result($req, 0);
			if(!$leg_nb) return false;
		}
		elseif($leg_to == 1 OR $leg_to == 0)
		{
			$leg_nb = 1;
		}
		else
		{
			$leg_nb = 0;
		}
		
		//on les enleve
		$sql="UPDATE ".$this->sql->prebdd."unt SET unt_nb=unt_nb-$nb WHERE unt_lid='$leg_from' AND unt_mid='$mid' AND unt_type='$type'";
		$this->sql->query($sql);
		
		if($leg_nb > 0)
		{
			//on deplace vers l'autre légion
			$sql="UPDATE ".$this->sql->prebdd."unt SET unt_nb=unt_nb+$nb WHERE unt_lid='$leg_to' AND unt_mid='$mid' AND unt_type='$type'";
			$this->sql->query($sql);	
			if(!mysql_affected_rows())
			{
				$sql="INSERT INTO ".$this->sql->prebdd."unt VALUES ('','$mid','$leg_to','$type','$nb','')";
				$this->sql->query($sql);
			}	
		}
		else
		{
			//si elle n'existe pas, on crée le groupe
			if($leg_to > 1 OR $leg_to <= -1)
			{
				$sql="INSERT INTO ".$this->sql->prebdd."leg VALUES ('','$mid','$mapcid','0','$name','0')";
				$this->sql->query($sql);
				$leg_to = mysql_insert_id();
			}
			$sql="INSERT INTO ".$this->sql->prebdd."unt VALUES ('','$mid','$leg_to','$type','$nb','')";
			$this->sql->query($sql);
		}
		return true;
	}
	
	function del_leg($mid, $lid)
	{
		$mid = (int) $mid;
		$lid = (int) $lid;
		
		$sql="SELECT COUNT(leg_lid) as leg_nb, SUM(unt_nb) as unt_nb FROM ".$this->sql->prebdd."leg LEFT JOIN ".$this->sql->prebdd."unt ON unt_lid = leg_lid WHERE leg_lid = '$lid' AND leg_mid = '$mid' GROUP BY leg_lid";
		$req = $this->sql->query($sql);
		if(mysql_num_rows($req))
		{
			$leg_nb = (int) mysql_result($req, 0, 'leg_nb');
			$unt_nb = (int) mysql_result($req, 0, 'unt_nb');
		}
		else
		{
			$leg_nb = 0;
			$unt_nb = 0;
		}
		if($unt_nb > 0 OR !($leg_nb > 0))
		{
			return false;
		}
		else
		{
			$sql="DELETE FROM ".$this->sql->prebdd."leg WHERE leg_lid='$lid' AND leg_mid = '$mid'";
			$this->sql->query($sql);
			$sql="DELETE FROM ".$this->sql->prebdd."unt WHERE unt_lid='$lid' AND unt_mid = '$mid'";
			$this->sql->query($sql);
			return true;
		}
		
	}
	
	function set_prio($mid,$prios)
	{
		$mid = (int) $mid;
		
		if(!is_array($prios))
		return false;
		
		$sql="UPDATE ".$this->sql->prebdd."unt SET unt_prio = CASE ";
		foreach($prios as $unt_type => $unt_prio)
		{
			$unt_type = (int) $unt_type;
			$unt_prio = (int) $unt_prio;
			if(!$this->conf->unt[$unt_type]) return false;
			$sql.=" WHEN unt_type = $unt_type THEN $unt_prio ";
		}
		$sql.=" END WHERE unt_mid = $mid";	
		return $this->sql->query($sql);
	}
}
?>