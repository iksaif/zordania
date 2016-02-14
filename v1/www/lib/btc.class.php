<?
class btc
{
	var $conf,$db;
	function btc(&$db, &$conf, &$game)
	{
		$this->conf = &$conf; // config
		$this->sql = &$db; // mysql
		$this->game = &$game; //objet game
	}
	
	function list_bat($mid)
	{
		$mid = (int) $mid;
		
		$res = $this->game->get_infos_res($mid);
		$src = $this->game->get_infos_src($mid);
		$unt = $this->game->get_infos_unt($mid);
		$unt = $unt[1];
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);

		foreach($this->conf->btc as $btc_id => $c_btc)
		{
			if(is_array($c_btc))
			{
				$unt_ok = true;
				if(is_array($c_btc['needguy']))
				{
				foreach($c_btc['needguy'] as $key => $value)
				{
					if($unt[$key]['unt_nb'] >= $value AND $unt_ok == true)
					{
						$unt_ok = true;
					}else{
						$unt_ok = false;
					}
				}
				}
				$btc_ok = true;
				if(is_array($c_btc['needbat']))
				{
				foreach($c_btc['needbat'] as $key => $value)
				{
					if(is_array($btc[$key]) AND $btc_ok == true)
					{
						$btc_ok = true;
					}else{
						$btc_ok = false;
					}
				}
				}
				
				$res_ok = true;
				if(is_array($c_btc['prix']))
				{
				foreach($c_btc['prix'] as $key => $value)
				{
					if($res[$key]['res_nb'] >= $value AND $res_ok == true)
					{
						$res_ok = true;
					}else{
						$res_ok = false;
					}
				}
				}
				
				if(isset($c_btc['needsrc']))
				{
					$src_ok = false;
					if(is_array($c_btc['needsrc']))
					{
						foreach($c_btc['needsrc'] as $c_src_type => $true)
						{
							if($src[$c_src_type])
							{
								$src_ok = true;
							}elseif($src_ok == false)
							{
								$src_ok = false;
							}
						}
					}
					else
					{
						if($src[$c_btc['needsrc']])
						{
							$src_ok = true;
						}else{
							$src_ok = false;
						}
					}
				}
				else
				{
					$src_ok = true;
				}
				
				$nb_ok = true;
				
				if($c_btc['limite'] AND $c_btc['limite'] <= $btc[$btc_id]['btc_nb'])
				{
					$nb_ok = false;
				}

				if($src_ok AND $btc_ok)
				{
					$ok = 2;
				}
				else
				{
					$ok = 3;
				}
				if($res_ok AND $nb_ok AND $unt_ok AND $ok == 2)
				{
					$ok = 1;
				}
				$return[$btc_id]['dispo'] = $ok;
				if($ok == 2 or $ok == 1)
				{
					$return[$btc_id]['vars'] = $c_btc;
				}
			}
		}
		return $return;
	}
	
	function can_build($mid,$type)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		
		$res = $this->game->get_infos_res($mid);
		$src = $this->game->get_infos_src($mid);
		$unt = $this->game->get_infos_unt($mid);
		$unt = $unt[1];
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);
		
		//Ce batîment existe ?
		if(!is_array($this->conf->btc[$type]))
		{
			return 0;
		}
		
		//on verifie qu'il n'y en a pas déjà un(des) autre en construction
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."btc WHERE btc_mid='$mid' AND btc_tour > 0";
		
		if(mysql_result($this->sql->query($sql), 0) > 0)
		{
			return 0;
		}
		
		$c_btc = $this->conf->btc[$type];
		
		$unt_ok = true;
		if(is_array($c_btc['needguy']))
		{
		foreach($c_btc['needguy'] as $key => $value)
		{
			//$unt_ok = true;
			if($unt[$key]['unt_nb'] >= $value AND $unt_ok == true)
			{
				$unt_ok = true;
			}else{
				$unt_ok = false;
			}
		}
		}
		$btc_ok = true;
		if(is_array($c_btc['needbat']))
		{
		foreach($c_btc['needbat'] as $key => $value)
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
		if(is_array($c_btc['prix']))
		{
		foreach($c_btc['prix'] as $key => $value)
		{
			if($res[$key]['res_nb'] >= $value AND $res_ok == true)
			{
				$res_ok = true;
			}else{
				$res_ok = false;
			}
		}
		}
		
		if(isset($c_btc['needsrc']))
		{
			$src_ok = false;
			if(is_array($c_btc['needsrc']))
			{
				foreach($c_btc['needsrc'] as $c_src_type => $true)
				{
					if($src[$c_src_type])
					{
						$src_ok = true;
					}elseif($src_ok == false)
					{
						$src_ok = false;
					}
				}
			}
			else
			{
				if($src[$c_btc['needsrc']])
				{
					$src_ok = true;
				}else{
					$src_ok = false;
				}
			}
		}
		else
		{
			$src_ok = true;
		}
		
		$nb_ok = true;
		if($c_btc['limite'] AND $c_btc['limite'] <= $btc[$type]['btc_nb'])
		{
			$nb_ok = false;
		}
				
		if($src_ok AND $btc_ok)
		{
			$ok = 2;
		}
		else
		{
			$ok = 3;
		}
		if($res_ok AND $nb_ok AND $unt_ok AND $ok == 2)
		{
			$ok = 1;
		}
		return $ok;
	}	
	
	function add($mid,$type)
	{	
		$mid = (int) $mid;
		$type = (int) $type;
		if(!is_array($this->conf->btc[$type]))
		{
			return false;
		}
		
		$tours = $this->conf->btc[$type]['tours'];
		$vie = $this->conf->btc[$type]['vie'];
		
		$cfg_btc = $this->conf->btc[$type];
		
		//on paye
		if(is_array($cfg_btc['prix']))
		{
			foreach($cfg_btc['prix'] as $a_type => $nb)
			{
				$this->game->add_res($mid,$a_type,-$nb);
			}
		}		
		
		//on prend les unités
		if(is_array($cfg_btc['needguy']))
		{
			foreach($cfg_btc['needguy'] as $a_type => $nb)
			{
				$this->game->edit_leg($mid, $a_type, $nb, 0, 1);
			}
		}		
		
		
		$sql="INSERT INTO ".$this->sql->prebdd."btc VALUES ('','$mid','$type','$vie','$tours','0')";
		return $this->sql->query($sql);
	}
	
	function del($mid, $bid = 0)
	{
		$mid = (int) $mid;
		$bid = (int) $bid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."btc WHERE btc_mid='$mid'";
		if($bid)
		{
			$sql.=" AND btc_bid='$bid'";
		}
		return $this->sql->query($sql);
	}
	
	function cancel($mid, $bid)
	{
		$mid = (int) $mid;
		$bid = (int) $bid;
		
		//on recupere le type
		$sql="SELECT btc_type,btc_tour FROM ".$this->sql->prebdd."btc WHERE btc_bid='$bid' AND btc_mid='$mid' AND btc_type != 1";
		$req = $this->sql->query($sql);

		$nb_in_db = mysql_num_rows($req);
		if($nb_in_db == 0)
		{
			return false;
		}
		
		$type = mysql_result($req, 0, 'btc_type');
		$tour = mysql_result($req, 0, 'btc_tour');
		
		$cfg_btc = $this->conf->btc[$type];
		
		//on rembourse la moitié
		if(is_array($cfg_btc['prix']))
		{
			foreach($cfg_btc['prix'] as $a_type => $nb)
			{
				$this->game->add_res($mid,$a_type,(ceil($nb / 2)));
			}
		}		
		
		//on rend les unités
		if(is_array($cfg_btc['needguy']))
		{
			foreach($cfg_btc['needguy'] as $a_type => $nb)
			{
				$this->game->edit_leg($mid, $a_type, $nb, 1, 0);
			}
		}
		
		if($cfg_btc['population'] AND $tour == 0)
		{
			$this->game->add_res($mid,GAME_RES_PLACE,(-$cfg_btc['population']));
		}
			
		return $this->del($mid,$bid);
	}
	
	function get_infos($mid, $type = 0, $fini = true,$actif = 1)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;
		$actif = (int) $actif; //0 - tout | 1 - actif | 2 inactif
		
		$sql="SELECT btc_type,btc_tour,btc_bid,btc_vie,btc_etat FROM ".$this->sql->prebdd."btc WHERE btc_mid='$mid'";
		if($type)
		{
			$sql.=" AND btc_type = '$type'";
		}
		
		if($fini)
		{
			$sql.=" AND btc_tour = 0";
		}else{
			$sql.=" AND btc_tour > 0";
		}
		if($actif == 1)
		{
			$sql.=" AND btc_etat = 0";
		}
		elseif($actif == 2)
		{
			$sql.=" AND (btc_etat = 1 OR btc_etat = 2)";
		}
		
		$ar=$this->sql->make_array($sql);
        	if(!is_array($ar))
        	{
        		return false;
        	}
		foreach($ar as $key => $value)
		{
			if(!$type)
			{
				$return[$value['btc_type']] = array('btc_bid' => $value['btc_bid'], 'btc_tour' => $value['btc_tour'], 'btc_nb' => (1 +$return[$value['btc_type']]['btc_nb']) );
			}
			else
			{
				$return[$value['btc_bid']] = array('btc_vie' => $value['btc_vie'],'btc_etat' => $value['btc_etat']);
			}		
		}
		return $return;			
	}
	
	function edit_status($mid, $bid, $etat)
	{
		$mid = (int) $mid;
		$bid = (int) $bid;
		$etat = (int) $etat;
		
		/*
		/etats:
		/0 = ok ou const
		/1 = repar 2 = inactif
		/*/
		
		$sql="UPDATE ".$this->sql->prebdd."btc SET btc_etat='$etat' WHERE btc_bid='$bid' AND btc_mid='$mid' AND btc_tour = 0";
		$this->sql->query($sql);
		return mysql_affected_rows();		
		
	}
	

}
?>