<?
class mch
{
	var $sql,$res;
	
	function mch(&$sql, &$res)
	{
		$this->sql = &$sql;
		$this->res = &$res;
	}
	
	function get_infos($mid)
	{
		$mid = (int) $mid;
		
		//Récuperer les choses que le joueur (mid) a mis en vente
		$sql="SELECT * FROM ".$this->sql->prebdd."mch WHERE mch_mid = '$mid' AND mch_ach = 0 ORDER BY mch_tours DESC";
		return $this->sql->make_array($sql);
	}
	
	function get_mch($cid)
	{
		$cid = (int) $cid;
		
		$sql="SELECT * FROM ".$this->sql->prebdd."mch WHERE mch_cid = '$cid' AND mch_ach = 0 ";
		return $this->sql->make_array($sql);	
	}
	
	function list_mch($mid,$valide = true)
	{
		$mid = (int) $mid;
		$valide = (bool) $valide;
		
		$sql="SELECT COUNT(*),mch_type FROM ".$this->sql->prebdd."mch ";
		$sql.=" WHERE mch_mid != '$mid' ";
		$sql.=" AND mch_tours ".(($valide) ? ">=" : "<")." 0";
		$sql.=" AND mch_ach = 0 ";
		$sql.=" GROUP BY mch_type ";
		$sql.=" ORDER BY mch_type ASC,mch_type2 ASC,mch_nb DESC,mch_nb2 ASC ";
		return $this->sql->make_array($sql);	
	}

	function list_mch_res($mid,$type = 0,$valide = true)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		$valide = (bool) $valide;
		
		$sql="SELECT mch_cid,mch_mid,mch_type,mch_nb,mch_type2,mch_nb2,mbr_pseudo ";
		$sql.=" FROM ".$this->sql->prebdd."mch ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mch_mid = mbr_mid ";
		$sql.=" WHERE mch_mid != '$mid'";
		if($type) $sql .= " AND mch_type = $type "; 
		$sql.=" AND mch_tours ".(($valide) ? ">=" : "<")." 0";
		$sql.=" AND mch_ach = 0 ";
		$sql.=" ORDER BY mch_type ASC,mch_type2 ASC,mch_nb DESC,mch_nb2 ASC ";
		$com_array = $this->sql->make_array($sql);	
		foreach($com_array as $key => $value)
		{
			$return[]=array(		'mch_nb' => $value['mch_nb'],
							'mch_type' => $value['mch_type'],
							'mch_tours' => $value['mch_tours'],
							'mch_type2' => $value['mch_type2'],
							'mch_nb2'   => $value['mch_nb2'],
							'mch_cid'   => $value['mch_cid'],
							'mch_mid'=> $value['mch_mid'],
							'mbr_pseudo'=> $value['mbr_pseudo'],
							);
		}

		return $return;
	}	
	
	function achat($mid,$cid,$max_nb,$mod = 1)
	{
		$mid = (int) $mid;
		$cid = (int) $cid;
		$max_nb = (int) $max_nb;
		$mod = (float) $mod;
		
		//Verifier qu'il a assez pour acheter ca et que ca existe bien
		$sql="SELECT * FROM ".$this->sql->prebdd."mch WHERE mch_cid = '$cid' AND mch_tours >= 0 AND mch_ach = 0";
		$mch_array = $this->sql->make_array($sql);
		$mch_array = $mch_array[0];
		if(!isset($mch_array['mch_mid']) OR !$this->res->can_build($mid,array($mch_array['mch_type'],$mch_array['mch_type2']),0))
		{
			return false;
		}
		
		$sql="SELECT res_nb FROM ".$this->sql->prebdd."res WHERE res_mid = '$mid' AND res_btc = 0 AND res_type='".$mch_array['mch_type2']."'";
		$nb_res = mysql_result($this->sql->query($sql), 0);

		if($nb_res < $mch_array['mch_nb2'])
		{
			return 2;
		}
		$mid2 =$mid;
		$mid1 = $mch_array['mch_mid'];
		$mch_type1 = $mch_array['mch_type'];
		$mch_nb1 = $mch_array['mch_nb'];
		$mch_type2 = $mch_array['mch_type2'];
		$mch_nb2 = $mch_array['mch_nb2'];

		if($mch_nb1 > $max_nb OR $mch_nb2 > $max_nb OR $mid1 == $mid2)
		{
			return 3;
		}
		
		//lui enlever et rajouter a l'autre
		$sql="UPDATE ".$this->sql->prebdd."res  SET res_nb = CASE ";
		$sql.=" WHEN res_mid='$mid2' AND res_type='$mch_type2' THEN res_nb - ".round($mod*$mch_nb2);
		$sql.=" WHEN res_mid='$mid2' AND res_type='$mch_type1' THEN res_nb + $mch_nb1";
		$sql.=" WHEN res_mid='$mid1' AND res_type='$mch_type2' THEN res_nb + $mch_nb2";
		$sql.=" ELSE res_nb END";
		$sql.=" WHERE (res_mid='$mid1' OR res_mid='$mid2') AND res_btc = 0";

		$this->sql->query($sql);

		
		//virer le truc
		$sql="UPDATE ".$this->sql->prebdd."mch SET mch_ach=1 WHERE mch_cid='$cid' AND mch_tours >= 0"; 
		//$sql="DELETE FROM ".$this->sql->prebdd."mch WHERE mch_cid='$cid' AND mch_tours >= 0";
		return $this->sql->query($sql);
		
	}	

	function make_infos($com_array,$type)
	{
		$type = (int) $type;
		if(!is_array($com_array))
		{
			return false;
		}
		
		foreach($com_array as $value)
		{
			$type2 = $value['mch_type2'];
			$this_nb2 = $value['mch_nb2'];
			$this_nb1 = $value['mch_nb'];
			
			$nb_ventes['total']++; //au total
			$nb_ventes[$type2]++; //nombre de ventes contre ca
			$total_ventes+= $this_nb1; //ressoures au total
			$total[$type2][1]	+= $this_nb1; //ressoures au total contre ca
			$total[$type2][2] += $this_nb2; //idem
		}
		$return['nb_ventes'] = $nb_ventes;
		$return['ventes'] = $total;
		$return['total_ventes'] = $total_ventes;

		return $return;
	}
	
	function get_price($type, $type2)
	{
		$type = (int) $type;
		$type2= (int) $type2;
		
		$sql="SELECT mch_nb,mch_nb2 FROM ".$this->sql->prebdd."mch WHERE mch_type='$type' AND mch_type2='$type2' AND mch_tours >= 0";
		$tmp = $this->sql->make_array($sql);
		foreach($tmp as $key => $value)
		{
			$total[1] += $value['mch_nb'];
			$total[2] += $value['mch_nb2'];
			$prix_unit = $value['mch_nb2'] /$value['mch_nb'];
			if($prix_unit < $min OR !$min)
			{
				$min = $prix_unit ? $prix_unit : 0;
			}
			if($prix_unit > $max or !$max)
			{
				$max = $prix_unit ? $prix_unit : 0;;
			}
		}

		if($total[1] == 0)
		{
			$avg = 0;
		}
		else
		{
			$avg = round($total[2] / $total[1]);
		}
		return array('min'=> round($min), 'max' => round($max), 'avg' => $avg);
	}
	
	function vente($mid, $type1, $nb1 , $type2, $nb2)
	{
		//verifier qu'il a ce qu'il veut vendre
		$sql="SELECT res_nb FROM ".$this->sql->prebdd."res WHERE res_mid = '$mid' AND res_btc = 0 AND res_type='$type1'";
		$nb_res = mysql_result($this->sql->query($sql), 0);
		if($nb_res < $nb1)
		{
			return false;
		}
		$sql="UPDATE ".$this->sql->prebdd."res SET res_nb = res_nb - $nb1 WHERE res_mid = '$mid' AND res_type = '$type1' AND res_btc = 0";
		$this->sql->query($sql);
		//ajouter :)
		$sql="INSERT INTO ".$this->sql->prebdd."mch VALUES ('','$mid','$type1','$nb1','$type2','$nb2','".MCH_TMP."','0')";
		return $this->sql->query($sql);
	}
	
	function cancel($mid,$cid)
	{
		$mid = (int) $mid;
		$cid = (int) $cid;
		
		$sql="SELECT * FROM ".$this->sql->prebdd."mch WHERE mch_mid='$mid' AND mch_cid='$cid' AND mch_ach = 0 ";
		$tmp_array = $this->sql->make_array($sql);
		
		$sql="DELETE FROM ".$this->sql->prebdd."mch WHERE mch_mid='$mid' AND mch_cid='$cid' AND mch_ach = 0 ";
		$this->sql->query($sql);
		if(mysql_affected_rows())
		{
			$nb = $tmp_array[0]['mch_nb'] * (1 - (COM_TAX / 100));
			$type = $tmp_array[0]['mch_type'];
 			$sql="UPDATE ".$this->sql->prebdd."res SET res_nb = res_nb + $nb WHERE res_type='$type' AND res_mid='$mid' AND res_btc = 0";
			return $this->sql->query($sql); 
		}else{
		 	return false;
		}	
	}
	
	function sher_cancel($cid, $remb = true)
	{
		$cid = (int) $cid;
		$remb = (bool) $remb;
		
		$sql="SELECT * FROM ".$this->sql->prebdd."mch WHERE mch_cid='$cid' AND mch_ach = 0 ";
		$tmp_array = $this->sql->make_array($sql);
		
		$sql="DELETE FROM ".$this->sql->prebdd."mch WHERE mch_cid='$cid' AND mch_ach = 0 ";
		$this->sql->query($sql);
		if(mysql_affected_rows())
		{
			$mid  =  $tmp_array[0]['mch_mid'];
			if($remb)
			{
				$nb = $tmp_array[0]['mch_nb'];
				$type = $tmp_array[0]['mch_type'];
 				$sql="UPDATE ".$this->sql->prebdd."res SET res_nb = res_nb + $nb WHERE res_type='$type' AND res_mid='$mid' AND res_btc = 0";
				$this->sql->query($sql); 
			}
			return $mid;
		}else{
		 	return false;
		}			
	}
	
	function get_cours($res = 0)
	{
		$res = (int) $res;
		
		$sql="SELECT * FROM ".$this->sql->prebdd."mch_cours ";
		if($res) $sql.=" WHERE mch_cours_res = $res";
		$sql.=" ORDER BY mch_cours_res ASC";

		return $this->sql->make_array($sql);
	}
	
	function get_cours_sem($res = 0, $jour = 0)
	{
		$res = (int) $res;
		$jour= (int) $jour;
		
		$sql="SELECT * FROM ".$this->sql->prebdd."mch_sem ";
		if($res) $sql.=" WHERE mch_sem_res = $res ";
		if($jours) $sql.= ($res1 ? "AND" : "WHERE")." mch_sem_jour = $jour ";
		$sql.=" ORDER BY mch_sem_res ASC,mch_sem_jour ASC";
		
		return $this->sql->make_array($sql);
	}
	
	function update_cours_sem($res,$cours,$jour)
	{
		$res = (int) $res;
		$jour= (int) $jour;
		$cours = (float) $cours;
		
		$sql="UPDATE ".$this->sql->prebdd."mch_sem SET mch_sem_cours = '$cours' WHERE mch_sem_res = $res AND mch_sem_jour = $jour";
		$this->sql->query($sql);
		
		return mysql_affected_rows();
	}
	
	function update_cours($res,$cours)
	{
		$res = (int) $res;
		$cours = (float) $cours;
		
		$sql="UPDATE ".$this->sql->prebdd."mch_cours SET mch_cours_cours = '$cours' WHERE mch_cours_res = $res";
		$this->sql->query($sql);
		
		return mysql_affected_rows();
	}	
}

?>