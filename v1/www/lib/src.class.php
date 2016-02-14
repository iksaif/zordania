<?
class src
{
	var $conf,$db,$game;
	function src(&$db, &$conf, &$game)
	{
		$this->conf = &$conf; // config
		$this->sql = &$db; // mysql
		$this->game = &$game; //Game
	}
	
	function get_infos($mid, $type = 0, $fini = true)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;
		
		$sql="SELECT src_sid,src_type,src_tour FROM ".$this->sql->prebdd."src WHERE src_mid='$mid'";
		if($type)
		{
			$sql.=" AND src_type = '$type'";
		}
		if($fini)
		{
			$sql.=" AND src_tour = 0";
		}else{
			$sql.=" AND src_tour > 0";
		}	

		$ar=$this->sql->make_array($sql);
        
		foreach($ar as $key => $value)
		{
			$return[$value['src_type']] = array( 'src_tour' => $value['src_tour'], 'src_sid' => $value['src_sid']);
		}
		return $return;			
	}
	
	function list_src($mid)
	{
		$mid = (int) $mid;
		
		$res = $this->game->get_infos_res($mid);
		$src = $this->game->get_infos_src($mid);
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);
		
		$src_en_cours = $this->get_infos($mid, 0, false);
		foreach($this->conf->src as $src_id => $c_src)
		{
			if(is_array($c_src))
			{	
				$res_ok = true;
				if(is_array($c_src['prix']))
				{
				foreach($c_src['prix'] as $key => $value)
				{
					if($res[$key]['res_nb'] >= $value AND $res_ok == true)
					{
						$res_ok = true;
					}else{
						$res_ok = false;
					}
				}
				}
				
				$btc_ok = true;
				if(is_array($c_src['needbat']))
				{
					foreach($c_src['needbat'] as $key => $value)
					{
					if($btc[$key] AND $btc_ok == true)
					{
						$btc_ok = true;
					}else{
						$btc_ok = false;
					}
					}
				}
				
				$src_ok = true;
				if(isset($c_src['needsrc']))
				{
					if($src[$c_src['needsrc']])
					{
						$src_ok = true;
					}else{
						$src_ok = false;
					}
				}
				
				if(isset($c_src['incompat']))
				{
					if($src[$c_src['incompat']] OR $src_en_cours[$c_src['incompat']])
					{
						$src_ok = false;
					}
				}
				
				if($btc_ok AND $src_ok AND !is_array($src_en_cours[$src_id]))
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
				$return[$src_id]['dispo'] = $ok;
				if($ok == 2 or $ok == 1)
				{
					$return[$src_id]['vars'] = $c_src;
				}
			}
		}
		return $return;		
		
	}
	
	function cancel($mid,$sid)
	{
		$mid = (int) $mid;
		$sid = (int) $sid;
				
		//on verifie si elle existe
		$sql="SELECT COUNT(*) as src_nb,src_type FROM ".$this->sql->prebdd."src WHERE src_tour > 0 and src_sid = '$sid' AND src_mid='$mid' GROUP BY src_sid";
		
		$req = $this->sql->query($sql);
		$nb_in_db = mysql_result($req, 0, 'src_nb');
		$type = mysql_result($req, 0, 'src_type');
		
		if($nb_in_db == 0)
		{
			return false;
		}
		
		$cfg_src = $this->conf->src[$type];
		
		//on rembourse la moitié
		if(is_array($cfg_src['prix']))
		{
			foreach($cfg_src['prix'] as $a_type => $nb)
			{
				$this->game->add_res($mid,$a_type,(ceil($nb/2)));
			}
		}
		
		return $this->del($mid, $sid);
	}
	
	function add($mid,$type)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		
		//on verifie que ca existe
		if(isset($this->conf->src[$type]))
		{
			$cfg_src = $this->conf->src[$type];
			//on paye
			if(is_array($cfg_src['prix']))
			{
				foreach($cfg_src['prix'] as $a_type => $nbres)
				{
					$this->game->add_res($mid,$a_type,-$nbres);
				}
			}

			$tour = $this->conf->src[$type]['tours'];
			//on lance la recherche
			$sql="INSERT INTO ".$this->sql->prebdd."src VALUES ('','$mid','$type','$tour')";
			
			return $this->sql->query($sql);
		}
		return false;
	}
	
	function can_build($mid, $type)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		
		$res = $this->game->get_infos_res($mid);
		$src = $this->game->get_infos_src($mid);
		$src_en_cours = $this->get_infos($mid, 0, false);
		$btc = $this->game->get_infos_btc($mid,0,true,true,0);
		
		//Cette recherche existe ?
		if(!is_array($this->conf->src[$type]))
		{
			return 0;
		}
		
		$c_src = $this->conf->src[$type];
		
		
		$res_ok = true;
		if(is_array($c_src['prix']))
		{
		foreach($c_src['prix'] as $key => $value)
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
		if(isset($c_src['needsrc']))
		{
			if($src[$c_src['needsrc']])
			{
				$src_ok = true;
			}else{
				$src_ok = false;
			}
		}
		
		$btc_ok = true;
		if(is_array($c_src['needbat']))
		{
			foreach($c_src['needbat'] as $key => $value)
			{
			if($btc[$key] AND $btc_ok == true)
			{
				$btc_ok = true;
			}else{
				$btc_ok = false;
			}
			}
		}
				
		if(isset($c_src['incompat']))
		{
			if($src[$c_src['incompat']] OR $src_en_cours[$c_src['incompat']])
			{
				$src_ok = false;
			}
		}
				
		if($btc_ok AND $src_ok AND !is_array($src_en_cours[$src_id]) AND !is_array($src[$src_id]))
		{
			//manque quelque chose
			$ok = 2;
		}
		else
		{
			//impossible
			$ok = 3;
		}
		if($res_ok AND $ok == 2)
		{
			//tout est bon
			$ok = 1;
		}
		return $ok;
		
	}
	
	function del($mid, $sid = 0)
	{
		$mid = (int) $mid;
		$sid = (int) $sid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."src WHERE src_mid='$mid'";
		if($sid)
		{
			$sql.=" AND src_sid='$sid'";
		}
		//suppresion pawa
		return $this->sql->query($sql);
	}
}
?>