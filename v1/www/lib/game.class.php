<?
//classe pour les truc du jeu utilisés souvent
class game
{
	var $sql,$conf;
	
	function game(&$db, &$conf)
	{
		$this->sql = &$db; //objet mysql
		$this->conf = &$conf; //objet de config
	}
	
	//**********************Divers**************************
	function get_position($mid)
	{
		$mid = (int) $mid;	
		$sql="SELECT mbr_mapcid,map_x,map_y FROM ".$this->sql->prebdd."mbr LEFT JOIN ".$this->sql->prebdd."map ON mbr_mapcid = map_cid WHERE mbr_mid ='$mid'";
		return $this->sql->make_array($sql);
	}
	
	//*************** Ressources ******************
	function get_infos_res($mid, $type = 0, $fini = true)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;

		$sql="SELECT res_type,res_nb,res_btc FROM ".$this->sql->prebdd."res WHERE res_mid='$mid'";
		if($type)
		{
			$sql.=" AND res_type = '$type'";
		}
		if($fini)
		{
			$sql.=" AND res_btc = 0";
		}
		else
		{
			$sql.=" AND res_btc > 0";
		}
		$ar=$this->sql->make_array($sql);

 		if(is_array($ar))
		{       
		foreach($ar as $key => $value)
		{
			$return[$value['res_type']] = array('res_nb' => $value['res_nb'], 'res_btc' => $value['res_btc']);
		}
		}
		return $return;
	}
	
	function get_primary_res($mid, $race_cfg)
	{
		$mid = (int) $mid;
		
		$sql="SELECT res_type,res_nb FROM ".$this->sql->prebdd."res WHERE res_mid='$mid' AND ( ";
		
		$nb_prim = count($race_cfg['primary_res']);
		$i = 0;

		foreach($race_cfg['primary_res'] as $res_type)
		{
			$sql.=" res_type='$res_type' ";
			$i++;
			if($i < $nb_prim)
			{
				$sql.="OR";
			}
		}
		$sql.=") ORDER BY res_type ASC";
		return $this->sql->make_array($sql);
	}

	function get_second_res($mid, $race, $race_cfg)
	{
		$mid = (int) $mid;
		$race = (int) $race;
		
		$sql="SELECT res_type,res_nb FROM ".$this->sql->prebdd."res WHERE res_mid='$mid' AND ( ";
		
		$nb_prim = count($race_cfg['second_res']);
		$i = 0;
		
		foreach($race_cfg['second_res'] as $res_type)
		{
			$sql.=" res_type='$res_type' ";
			$i++;
			if($i < $nb_prim)
			{
				$sql.="OR";
			}
		}
		$sql.=")";
		return $this->sql->make_array($sql);
	}	
	
	function add_res($mid,$type,$nb,$btc = 0,$verif = true)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$nb = (int) $nb;
		$btc = (int) $btc;
		$verif = (bool) $verif;
		
		if(isset($this->conf->res[$type]) OR !$verif)
		{
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
	
	function new_res($mid, $res_array)
	{
		$sql="INSERT INTO ".$this->sql->prebdd."res VALUES";
		foreach($res_array as $type => $nb)
		{
			$sql.="('','$mid','$type','$nb','0','')";
		}
		$sql=str_replace(')(','),(',$sql);
		return $this->sql->query($sql);
	}
	
	function del_res($mid, $rid = 0)
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
	
	
	//****************** Unités ******************
	function get_infos_unt($mid, $type = 0, $fini = true)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;
		
		$sql="SELECT unt_type,unt_nb,unt_lid,unt_uid FROM ".$this->sql->prebdd."unt WHERE unt_mid='$mid'";
		if($type)
		{
			$sql.=" AND unt_type = '$type'";
		}
		
		if($fini)
		{
			$sql.=" AND (unt_lid >= 0)";
		}else{
			$sql.=" AND unt_lid < 0";
		}
		
		$ar=$this->sql->make_array($sql);
		
		if(is_array($ar))
		{
		foreach($ar as $key => $value)
		{
			if($value['unt_lid'] == 0)// AND $value['unt_lid'] >= 0)
			{
				$dispo = 1;
			}else{
				$dispo = 0;
			}
			
			if(!$return[$dispo][$value['unt_type']])
			{
				$return[$dispo][$value['unt_type']] = array('unt_nb' => $value['unt_nb'], 'unt_lid' => $value['unt_lid'],'unt_uid' => $value['unt_uid']);
			}else{
				$return[$dispo][$value['unt_type']]['unt_nb'] = $value['unt_nb'] + $return[$dispo][$value['unt_type']]['unt_nb'];
			}
		}
		}
		return $return;		
	}
	
	function add_unt($mid,$type,$nb,$leg = 0,$pop = false)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$nb = (int) $nb;
		$leg = (int) $leg;
	 	$pop = (bool) $pop;
	 	
		if(isset($this->conf->unt[$type]))
		{
			if($pop)
			{
				$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_population=mbr_population+$nb WHERE mbr_mid='$mid'";
				$this->sql->query($sql);
			}
				
			$sql="UPDATE ".$this->sql->prebdd."unt SET unt_nb=unt_nb+$nb WHERE unt_type=$type AND unt_mid=$mid AND unt_lid=$leg";
			$this->sql->query($sql);
			if(!mysql_affected_rows() AND $nb > 0)
			{
				$sql="SELECT unt_prio FROM ".$this->sql->prebdd."unt WHERE unt_type=$type AND unt_mid=$mid AND unt_lid=0";
				$prio = mysql_result($this->sql->query($sql), 0,'unt_prio');
				$sql="INSERT INTO ".$this->sql->prebdd."unt VALUES ('','$mid','$leg','$type','$nb','$prio')";
				return $this->sql->query($sql);
			}
		}else{
			return false;
		}
	}
	
	function new_unt($mid, $unt_array)
	{
		$sql="INSERT INTO ".$this->sql->prebdd."unt VALUES ";
		foreach($unt_array as $type => $nb)
		{
			$sql.="('','$mid','0','$type','$nb','')";
		}
		$sql=str_replace(')(','),(',$sql);
		return $this->sql->query($sql);
	}
	
	function del_unt($mid, $uid = 0)
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
		
		if($leg_to > 1)
		{
			//on verifie que la légion existe et qu'elle est du bon type
			$sql="SELECT leg_etat FROM ".$this->sql->prebdd."leg WHERE leg_lid='$leg_to' AND leg_mid='$mid' GROUP BY leg_lid";
			$req = $this->sql->query($sql);
			$leg_nb = mysql_num_rows($req);
			$leg_etat = @mysql_result($req, 0);
	
			if($leg_etat != 0)
			{
				return false;
			}
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
	
	function unt_count_pop($mid)
	{
		$sql="SELECT SUM(unt_nb) FROM ".$this->sql->prebdd."unt WHERE unt_mid='$mid' AND unt_lid >= 0";
		$nb = mysql_result($this->sql->query($sql), 0);
		$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_population='$nb' WHERE mbr_mid='$mid'";
		return $this->sql->query($sql);
	} 
	
	//****************** Recherches ******************
	function get_infos_src($mid, $type = 0, $fini = true)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;
		
		$sql="SELECT src_type,src_tour FROM ".$this->sql->prebdd."src WHERE src_mid='$mid'";
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
     
		if(is_array($ar))
		{
		foreach($ar as $key => $value)
		{
			$return[$value['src_type']] = array('src_tour' => $value['src_tour']);
		}
		}
		return $return;			
	}
	
	function del_src($mid)
	{
		$mid = (int) $mid;
		$uid = (int) $uid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."src WHERE src_mid='$mid'";
		return $this->sql->query($sql);	
	}
	
	
	//******** Batîments ****************//
	function get_infos_btc($mid, $type = 0, $fini = true, $count = true,$actif = 1)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$fini = (bool) $fini;
		$count = (bool) $count;
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
			if(!$type AND $count)
			{
				$return[$value['btc_type']] = array('btc_bid' => $value['btc_bid'], 'btc_tour' => $value['btc_tour'], 'btc_nb' => (1 +$return[$value['btc_type']]['btc_nb']) );
			}
			elseif(!$count)
			{
				$return[$value['btc_bid']] = array('btc_vie' => $value['btc_vie'],'btc_tour' => $value['btc_tour'],'btc_type' => $value['btc_type'],'btc_etat' => $value['btc_etat']);
			}
			else
			{
				$return = array('btc_nb' => (1 +$return['btc_nb']));	
			}		
		}

		return $return;			
	}	
	
	function new_btc($mid, $btc_array)
	{
		$sql="INSERT INTO ".$this->sql->prebdd."btc VALUES";
		foreach($btc_array as $type => $value)
		{
			$vie = $value['btc_vie'];
			$nb  = $value['btc_nb'];
			for($i = 0; $i < $nb; $i++)
			$sql.="('','$mid','$type','$vie','','')";
		}
		$sql=str_replace(')(','),(',$sql);
		return $this->sql->query($sql);
	}
	
	function get_primary_btc($mid, $race_cfg)
	{
		$mid = (int) $mid;
		
		$sql="SELECT btc_type FROM ".$this->sql->prebdd."btc WHERE btc_mid='$mid' AND (0 ";
		
		foreach($race_cfg['primary_btc'] as $res_endroit => $res_array)
		{
			foreach($res_array as $btc_type => $btc_sub_array)
			{
				$sql.=" OR btc_type='$btc_type' ";
				$btc_array[$btc_type] = array('end' => $res_endroit,'sub' => $btc_sub_array);
			}
		}
		$sql.=") AND btc_tour = 0 GROUP BY btc_type";
		
		$array = $this->sql->make_array($sql);
		foreach($array as $key => $btc_result)
		{
			$return[$btc_result['btc_type']] = $btc_array[$btc_result['btc_type']];
		}

		return $return;
	}
}
?>