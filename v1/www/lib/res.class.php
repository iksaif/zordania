<?
class ressources
{
	var $sql,$conf,$game;
	function ressources(&$db, &$conf, &$game)
	{
		$this->conf = &$conf; // config
		$this->sql = &$db; //objet mysql
		$this->game = &$game; //objet game
	}
	 
	function add($mid,$type,$nb,$btc = 0)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$nb = (int) $nb;
		$btc = (int) $btc;
		
		if(isset($this->conf->res[$type]))
		{
			$cfg_res = $this->conf->res[$type];
		
			//on rembourse la moitié
			if(is_array($cfg_res['needres']))
			{
				foreach($cfg_res['needres'] as $r_type => $nbres)
				{
					$this->game->add_res($mid,$r_type,-($nbres*$nb));
				}
			}	
			
			$sql="UPDATE ".$this->sql->prebdd."res SET res_nb=res_nb+$nb WHERE res_type='$type' AND res_mid='$mid' AND res_btc = $btc";
			$this->sql->query($sql);
			if(!mysql_affected_rows() AND $nb > 0 AND $btc > 0)
			{
				$sql="SELECT res_prio FROM ".$this->sql->prebdd."res WHERE res_type=$type AND res_mid=$mid AND res_btc=0";
				$prio = mysql_result($this->sql->query($sql), 0,'res_prio');
				$sql="INSERT INTO ".$this->sql->prebdd."res VALUES ('','$mid','$type','$nb','$btc','$prio')";
				return $this->sql->query($sql);
			}
			return true;
		}else{
			return false;
		}
	}
	
	function del($mid, $rid = 0)
	{
		$mid = (int) $mid;
		$rid = (int) $rid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."res WHERE res_mid='$mid'";
		if($rid)
		{
			$sql.=" AND res_rid='$rid'";
		}
		return $this->sql->query($sql);
	}
	
	function get_infos($mid, $type = 0, $fini = true)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;
		
		$sql="SELECT res_type,res_nb,res_btc,res_rid,res_prio FROM ".$this->sql->prebdd."res WHERE res_mid='$mid'";
		if($type)
		{
			$sql.=" AND res_type = '$type'";
		}
		if($fini)
		{
			$sql.=" AND res_btc = 0 ORDER BY res_type ASC";
		}
		else
		{
			$sql.=" AND res_btc > 0 ORDER BY res_prio DESC";
		}
		$ar=$this->sql->make_array($sql);
        
		foreach($ar as $key => $value)
		{
			$return[$value[res_type]] = array('res_rid' => $value['res_rid'],'res_nb' => $value['res_nb'], 'res_btc' => $value['res_btc'],'res_prio' => $value['res_prio']);
		}
		return $return;
	}
	
	function list_res($mid, $res_nb_ok = false)
	{
		$mid = (int) $mid;
		$res_nb_ok = (bool) $res_nb_ok;
		
		$res = $this->game->get_infos_res($mid);
		$src = $this->game->get_infos_src($mid);
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);
		
		$res_nb = $this->get_infos($mid);
		
		foreach($this->conf->res as $res_id => $c_res)
		{
			if(is_array($c_res))
			{
				$btc_ok = true;
				if($c_res['needbat'])
				{
					if(is_array($btc[$c_res['needbat']]) AND $btc_ok == true)
					{
						$btc_ok = true;
					}else{
						$btc_ok = false;
					}
				}
				
				$res_ok = true;
				if(is_array($c_res['prix']))
				{
				foreach($c_res[prix] as $key => $value)
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
				if(isset($c_res['needsrc']))
				{
				if($src[$c_res['needsrc']])
				{
					$src_ok = true;
				}else{
					$src_ok = false;
				}
				}

				if($res_nb_ok AND $res[$res_id]['res_nb'] > 0)
				{
					$src_ok = true;
					$btc_ok = true;
					$res_ok = true;	
				}
				
				if($src_ok AND $btc_ok)
				{
					$ok = 2;
				}
				else
				{
					$ok = 3;
				}
				if($res_ok AND $ok == 2)
				{
					$ok = 1;
				}
				$return[$res_id]['dispo'] = $ok;
				if($ok == 2 or $ok == 1)
				{
					$return[$res_id]['vars'] = $c_res;
					$return[$res_id]['in_db'] = $res_nb[$res_id];
				}
			}
		}
		return $return;
	}
	
	function can_build($mid,$type,$nb = 1)
	{
		$mid = (int) $mid;
		$type = is_array($type) ? $type : array((int) $type);
		$nb = (int) $nb;
		
		$res = $this->game->get_infos_res($mid);
		$src = $this->game->get_infos_src($mid);
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);
		
		$res_nb = $this->get_infos($mid);
		
		foreach($type as $res_id)
		{
		$c_res = $this->conf->res[$res_id];
		
		if(is_array($c_res))
		{
			$btc_ok = true;
			if(is_array($c_res['needbat']))
			{
			foreach($c_res['needbat'] as $key => $value)
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
			if(is_array($c_res['needres']))
			{
			foreach($c_res['needres'] as $key => $value)
			{
				if($res[$key]['res_nb'] >= $value * $nb AND $res_ok == true)
				{
					$res_ok = true;
				}else{
					$res_ok = false;
				}
			}
			}
			$src_ok = true;
			
			if(isset($c_res['needsrc']))
			{			
			if($src[$c_res['needsrc']])
			{
				$src_ok = true;
			}else{
				$src_ok = false;
			}
			}
			
			if($src_ok AND $btc_ok)
			{
				$ok = 2;
				//echo"Pour $res_id, src et btc ok<br/>";
			}
			else
			{
				$ok = 3;
				//echo"Pour $res_id, rien n'est bon<br/>";
			}
			if($res_ok AND $ok == 2)
			{
				$ok = 1;
			}
			if($ok != 1)
			{
				return $ok;
			}
		}else{
			return false;
		}
		}
		return $ok;
	}
	
	function btc($type)
	{
		$type = (int) $type;
		if(!$this->conf->res[$type]['nobat'])
		{
			$return = array(1);
		}
		
		foreach($this->conf->res as $res_id => $c_res)
		{
			if(is_array($c_res['needres']))
			{
				if(array_key_exists($type,$c_res['needres']))
				{
					if(!in_array($c_res['needbat'],$return))
					{
						$return[] = $c_res['needbat'];
					}
				}
			}
			
		}
		
		return $return;		
	}
	
	function cancel($mid, $rid, $nb)
	{
		$mid = (int) $mid;
		$rid = (int) $rid;
		$nb = (int) $nb;
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."res WHERE res_btc > 0 AND res_rid='$rid' AND res_mid='$mid'";
		$nb_in_db = mysql_result($this->sql->query($sql), 0);
		if($nb_in_db == 0)
		{
			return false;
		}
		
		//on recupere le type et le nombre
		$sql="SELECT res_type, res_nb FROM ".$this->sql->prebdd."res WHERE res_rid='$rid' AND res_mid='$mid' AND res_btc > 0 ";
		
		$req = $this->sql->query($sql);
		
		$type = mysql_result($req, 0, 'res_type');
		$nb_in_db = mysql_result($req, 0, 'res_nb');
		
		if($nb_in_db < $nb)
		{
			return false;
		}
		
		$cfg_res = $this->conf->res[$type];
		
		//on rembourse la moitié
		if(is_array($cfg_res['needres']))
		{
			foreach($cfg_res['needres'] as $r_type => $nbres)
			{
				$this->game->add_res($mid,$r_type,(ceil(($nbres/2)*$nb)));
			}
		}		
				
		if($nb_in_db <= $nb)
		{
			//il y'en a autant que dans la bdd
			return $this->del($mid,$rid);
		}else{
			//il y'en a moins
			$sql="UPDATE ".$this->sql->prebdd."res SET res_nb=res_nb-$nb WHERE res_rid='$rid' AND res_mid='$mid'";
			return $this->sql->query($sql);
		}
	}
	
	function set_prio($mid,$prios)
	{
		$mid = (int) $mid;
		
		if(!is_array($prios))
		return false;

		$sql="UPDATE ".$this->sql->prebdd."res SET res_prio = CASE ";
		foreach($prios as $res_type => $res_prio)
		{
			$res_type = (int) $res_type;
			$res_prio = (int) $res_prio;
			if(!is_array($this->conf->res[$res_type])) return false;
			$sql.=" WHEN res_type = $res_type THEN $res_prio ";
		}
		$sql.=" END WHERE res_mid = $mid";	
		return $this->sql->query($sql);
	}
}
?>