<?
class forum
{
	var $sql;
	
	function forum(&$sql)
	{
		$this->sql = &$sql; //classe mysql
	}
	
	function get_cat($cid = 0)
	{
		$cid = (int) $cid;
		
		$sql="SELECT cat_id, cat_name, cat_droit, frm_id, frm_descr, frm_droit, frm_name, ";
		$sql.=" frm_pst_nb, frm_msg_nb, frm_lst_pst_pid,";
		$sql.=" frm_lst_pst_titre, formatdate(frm_lst_pst_date) as pst_ldate_formated,  ";
		$sql.=" mbr_mid,mbr_pseudo,mbr_gid";
		$sql.=" FROM ".$this->sql->prebdd."frm_cat";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_frm ON cat_id = frm_cid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON frm_lst_mid = mbr_mid";
		$sql.= ($cid > 0) ? " WHERE cat_id = $cid " : "" ;
		$sql.=" GROUP BY frm_id";
		$sql.=" ORDER BY cat_pos ASC,frm_pos ASC";

		return $this->sql->make_array($sql);
	}
	
	function get_frm_lite($fid)
	{
		$fid = (int) $fid;
		
		$sql="SELECT frm_id, frm_name, frm_droit, frm_cid, cat_name, cat_id ";
		$sql.=" FROM ".$this->sql->prebdd."frm_frm";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_cat ON cat_id = frm_cid";
		$sql.=" WHERE frm_id = $fid";

		return $this->sql->make_array($sql);
	}
	
	function get_frm($fid, $limite1 = 0, $limite2 = -1, $order = array('DESC','pst_ldate'))
	{
		$fid = (int) $fid;
		$limite1 = (int) $limite1;
		$limite2 = (int) $limite2;
		$by = $order[1];
		$order = $order[0];
		
		$sql="SELECT ";
		$sql.="cat_id, cat_name, cat_droit,";
		$sql.=" frm_id, frm_name, frm_droit, ";
		$sql.="pst_id, pst_titre, pst_etat, pst_open, pst_mid,";
		$sql.=" formatdate(pst_date) as pst_date_formated,UNIX_TIMESTAMP(pst_ldate + INTERVAL '".$this->sql->decal."' HOUR_SECOND) as pst_ldate,";
		$sql.=" pst_msg_nb,";
		$sql.=" formatdate(pst_ldate) as pst_ldate_formated,";
		$sql.=" pst_pid, pst_lmid, c.mbr_pseudo as mbr_pseudo,c.mbr_gid as mbr_gid, d.mbr_pseudo as mbr_lpseudo, d.mbr_gid as mbr_lgid";
		$sql.=" FROM ".$this->sql->prebdd."frm_pst";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_frm ON frm_id = pst_fid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_cat ON cat_id = frm_cid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr as c ON c.mbr_mid = pst_mid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr as d ON d.mbr_mid = pst_lmid";
		$sql.=" WHERE pst_pid = 0" ;
		if($fid)
		{
			$sql.=" AND pst_fid = $fid ";
		}
		//$sql.=" GROUP BY a.pst_id";//,b.pst_pid";
		$sql.=" ORDER BY pst_etat ASC,$by $order";
		if($limite2 != -1)
		{
			$sql.=" LIMIT $limite2, $limite1";
		}

		return $this->sql->make_array($sql);
	}
	
	function count_pst($pid = 0, $fid = 0)
	{
		$pid = (int) $pid;
		$fid = (int) $fid;
		
		$sql="SELECT COUNT(*) ";
		$sql.=" FROM ".$this->sql->prebdd."frm_pst";
		
		if($pid)
		{
			$sql.=" WHERE pst_pid = $pid";	
			$sql.=" GROUP BY pst_pid";
		}
		elseif($fid)
		{
			$sql.=" WHERE pst_fid = $fid AND pst_pid = 0";
			$sql.=" GROUP BY pst_fid";
		}
		else
		{
			$sql.=" WHERE pst_pid = 0";
			$sql.=" GROUP BY pst_fid";
		}

		return @mysql_result($this->sql->query($sql), 0);
	}
	
	function get_pst($pid,$limite1 = 0, $limite2 = 0, $order = array('ASC','pst_date'))
	{		
		$pid = (int) $pid;
		$limite1 = (int) $limite1;
		$limite2 = (int) $limite2;
		$by = $order[1];
		$order = $order[0];
		
		$sql="SELECT pst_pid, frm_droit, frm_id,pst_id, pst_date, pst_open, pst_etat, pst_mid, pst_titre, pst_texte, formatdate(pst_date) as pst_date_formated, pst_ldate, mbr_pseudo, mbr_gid, mbr_population, mbr_points, mbr_sign,mbr_alaid,al_name ";
		$sql.=" FROM ".$this->sql->prebdd."frm_pst";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = pst_mid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."al ON mbr_alaid = al_aid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_frm ON frm_id = pst_fid";
		$sql.=" WHERE pst_id = $pid ";
		if($limite1 or $limite2)
		{
			$sql.=" OR pst_pid = $pid";
		}
		//$sql.=" GROUP BY pst_id ";
		$sql.=" ORDER BY $by $order";

		if($limite1 or $limite2)
		{
			$sql.=" LIMIT $limite2, $limite1";
		}

		return $this->sql->make_array($sql);
	}
	
	function highlight_pst($pst_array, $hl)
	{
		$hl = htmlentities($hl, ENT_QUOTES);
		$hl = explode(' ',$hl);
		
		if(is_array($pst_array))
		{
		foreach($pst_array as $key => $pst_values)
		{
			for($i = 0; $i < FRM_MAX_HL; $i++)
			{	if(isset($hl[$i]) && ctype_alnum($hl[$i]))
					$pst_array[$key]['pst_texte'] = preg_replace('!'.$hl[$i].'!i',"<span class=\"infos\">".$hl[$i]."</span>",$pst_array[$key]['pst_texte']);
			}
		}
		}
		return $pst_array;
	} 
	
	function search_pst($match, $fid = 0)
    	{
    		$match = htmlentities($match, ENT_QUOTES);
    		$cid = (int) $cid;
    		$fid = (int) $fid;
    		
    		$sql="SELECT pst_id,pst_pid, frm_name, frm_droit, frm_name, frm_id, pst_date, pst_etat, pst_texte,pst_mid, pst_titre, formatdate(pst_date) as pst_date_formated, pst_ldate, mbr_pseudo, mbr_gid, mbr_population, mbr_points ";
		$sql.=",MATCH(pst_titre,pst_texte) AGAINST('$match') as pst_score ";
		$sql.=" FROM ".$this->sql->prebdd."frm_pst";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = pst_mid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_frm ON frm_id = pst_fid";
		$sql.=" WHERE MATCH(pst_titre,pst_texte) AGAINST('$match')";
		if($fid) $sql.=" AND pst_fid = $fid ";
		$sql.=" LIMIT ".FRM_MAX_SEARCH_RESULT;
		
    		return $this->sql->make_array($sql);
    	}
    
	function set_as_readed($pid)
	{
		$_SESSION['forum']['lus'][$pid] = true;
	}
	
	function new_pst($mid, $titre, $texte, $pid, $fid, $etat, $open)
	{
		$mid = (int) $mid;
		$pid = (int) $pid;
		$fid = (int) $fid;
		$etat = (int) $etat;
		$titre = htmlentities($titre, ENT_QUOTES);
		
		if($pid)
		{
			$sql="UPDATE ".$this->sql->prebdd."frm_pst "; 
			$sql.=" SET pst_msg_nb=pst_msg_nb+1, pst_ldate = NOW(),pst_lmid = $mid ";
			$sql.=" WHERE pst_id = $pid ";
			$this->sql->query($sql);
		}
		
		$sql = "INSERT INTO ".$this->sql->prebdd."frm_pst "; 
		$sql.= "VALUES ('', '$mid', '$fid', NOW(), '$titre', '$texte', '$pid','$etat', '$open', '$mid',NOW(),0)";

		$this->sql->query($sql);
		
		$lst_id = $pid ? $pid : mysql_insert_id();
		$sql = "UPDATE ".$this->sql->prebdd."frm_frm SET frm_lst_pst_titre ='$titre',frm_lst_pst_pid = $lst_id, frm_lst_pst_date=NOW(),frm_lst_mid=$mid ";
		if($pid) $sql.=",frm_pst_nb=frm_pst_nb+1";
		$sql.=",frm_msg_nb=frm_msg_nb+1";
		$sql.= " WHERE frm_id = $fid";

		/*$this->set_as_readed(mysql_insert_id());
		$this->set_as_readed($lst_id);*/
		return $this->sql->query($sql);
	}
	
	function new_cat($name, $droit)
	{
		$name = htmlentities($name, ENT_QUOTES);
		$droit = (int) $droit;
		
		$sql="INSERT INTO ".$this->sql->prebdd."frm_cat "; 
		$sql.=" VALUES ('','$name','$droit','')";
		
		return $this->sql->query($sql);
	}
	
	function new_frm($cid, $name, $descr, $droit)
	{
		$cid = (int) $cid;
		$name = htmlentities($name, ENT_QUOTES);
		$droit = (int) $droit;
		
		$sql="INSERT INTO ".$this->sql->prebdd."frm_cat "; 
		$sql.=" VALUES ('','$cid','$name','$descr','$droit','','','','','','')";
		
		return $this->sql->query($sql);
	}
	
	function edit_pst($pid, $edit)
	{
		$pid = (int) $pid;
		
		if(!is_array($edit))
		{
			return false;
		}
		
		$pst_array = $this->get_pst($pid);
		$pst_array = $pst_array[0];
		
		if($pst_array['pst_pid'] == 0)
		{
			if(isset($edit['fid']))
			{
				$fid = (int) $edit['fid'];
				$sql="UPDATE ".$this->sql->prebdd."frm_frm SET frm_lst_pst_pid=0 WHERE frm_lst_pst_pid=$pid ";
				$this->sql->query($sql);
				$sql="UPDATE ".$this->sql->prebdd."frm_frm SET frm_lst_pst_pid=$pid WHERE frm_id = $fid ";
				$this->sql->query($sql);
			}
			if(isset($edit['titre']))
			{
				$titre = htmlentities($edit['titre'], ENT_QUOTES);
				$sql="UPDATE ".$this->sql->prebdd."frm_frm SET frm_lst_pst_titre='$titre' WHERE  frm_lst_pst_pid=$pid ";
				$this->sql->query($sql);
			}
		}
		
		$sql="UPDATE ".$this->sql->prebdd."frm_pst SET ";
		if(isset($edit['titre']))
		{
			$titre = htmlentities($edit['titre'], ENT_QUOTES);
			$sql.="pst_titre='$titre',";
		}
		if(isset($edit['texte']))
		{
			$texte = $edit['texte'];
			$sql.="pst_texte='$texte',";
		}
		if(isset($edit['etat']))
		{
			$etat = (int) $edit['etat'];
			$sql.="pst_etat='$etat',";
		}
		if(isset($edit['open']))
		{
			$open = (int) $edit['open'];
			$sql.="pst_open='$open',";
		}
		if(isset($edit['fid']))
		{
			$fid = (int) $edit['fid'];
			$sql.="pst_fid='$fid',";
		}

		$sql.=" WHERE pst_id=$pid";
		$sql= str_replace(', WHERE',' WHERE',$sql);
		
		$this->sql->query($sql);
		return mysql_affected_rows();
	}
	
	function edit_cat($cid, $edit)
	{
		$pid = (int) $cid;
		
		if(!is_array($edit))
		{
			return false;
		}
		
		$sql="UPDATE ".$this->sql->prebdd."frm_cat SET ";
		if(isset($edit['name']))
		{
			$name = htmlentities($edit['name'], ENT_QUOTES);
			$sql.="cat_name='$name',";
		}
		if(isset($edit['pos']))
		{
			$pos = (int) $edit['pos'];
			$sql.="cat_pos='$pos',";
		}
		
		$sql.=" WHERE cat_cid=$cid";
		$sql= str_replace(', WHERE',' WHERE',$sql);
		
		$this->sql->query($sql);
		return mysql_affected_rows();
	}
	
	function edit_frm($fid, $edit)
	{
		$fid = (int) $fid;
		
		if(!is_array($edit))
		{
			return false;
		}
		
		$sql="UPDATE ".$this->sql->prebdd."frm_frm SET ";
		if(isset($edit['name']))
		{
			$name = htmlentities($edit['name'], ENT_QUOTES);
			$sql.="frm_name='$name',";
		}
		if(isset($edit['descr']))
		{
			$descr = htmlentities($edit['descr'], ENT_QUOTES);
			$sql.="frm_descr='$descr',";
		}
		if(isset($edit['pos']))
		{
			$pos = (int) $edit['pos'];
			$sql.="frm_pos='$pos',";
		}
		
		$sql.=" WHERE frm_fid=$fid";
		$sql= str_replace(', WHERE',' WHERE',$sql);
		
		$this->sql->query($sql);
		return mysql_affected_rows();
	}

	function del_pst($pid)
	{
		$pid = (int) $pid;
		if(!$pid)
		{
			return;
		}
		
		$sql="SELECT pst_pid,pst_fid FROM ".$this->sql->prebdd."frm_pst WHERE pst_id= $pid ";
		$ppid=mysql_result($this->sql->query($sql),0,'pst_pid');
		$fid=mysql_result($this->sql->query($sql),0,'pst_fid');
		if(!$ppid) $ppid=$pid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."frm_pst WHERE pst_id = $pid OR pst_pid = $pid";
		
		$this->sql->query($sql);
		$msg_nb = mysql_affected_rows();
		
		
		$sql="UPDATE ".$this->sql->prebdd."frm_frm SET frm_lst_pst_titre='',frm_lst_mid=0, frm_lst_pst_pid = 0 WHERE frm_lst_pst_pid = $ppid";
		$this->sql->query($sql);
		
		$sql="UPDATE ".$this->sql->prebdd."frm_frm SET frm_pst_nb=frm_pst_nb -1,frm_msg_nb=frm_msg_nb - $msg_nb WHERE frm_id = $fid";
		$this->sql->query($sql);
		
		$sql="UPDATE ".$this->sql->prebdd."frm_pst SET pst_msg_nb=pst_msg_nb-1 WHERE pst_id = $ppid";
		$this->sql->query($sql);
		return $msg_nb;
	}
	
	function del_cat($cid, $newcid)
	{
		$cid = (int) $cid;
		$newcid = (int) $newcid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."frm_cat WHERE cat_id = $cid";
		
		$this->sql->query($sql);
		if(!mysql_affected_rows())
		{
			return false;
		}
		

		$sql="UPDATE ".$this->sql->prebdd."frm_frm SET frm_cid = $newcid WHERE frm_cid = $cid";
		
		$this->sql->query($sql);
	}
	
	function del_frm($fid, $newfid)
	{
		$fid = (int) $fid;
		$newfid = (int) $newfid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."frm_frm WHERE frm_id = $fid";
		
		$this->sql->query($sql);
		if(!mysql_affected_rows())
		{
			return false;
		}
		
		$sql="UPDATE ".$this->sql->prebdd."frm_pst SET pst_fid = $newfid WHERE pst_fid = $fid";
		$this->sql->query($sql);
	}
	
	function can_pst($pid, $droits)
	{
		$pid = (int) $pid;
		$droits = htmlentities($droits, ENT_QUOTES);
		
		$pst_array = $this->get_pst($pid,1, 1);
		$pst_array = $pst_array[0];

		if(!is_array($pst_array) OR !$pst_array['pst_open'])
		{
			return false;
		}
		else
		{
			$droit = $pst_array['frm_droit'];
			if($droits{$droit})
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	function can_view_frm($fid, $droits)
	{
		$fid = (int) $fid;
		$droits = htmlentities($droits, ENT_QUOTES);
		
		$frm_array = $this->get_frm($fid, 0, 0);
		$frm_array = $frm_array[0];
		
		if(!is_array($frm_array) OR !$droits{$frm_array['frm_droit']})
		{
			return false;
		}
	}
	
	function can_view($array, $key_array, $droits)
	{
		$droits = htmlentities($droits, ENT_QUOTES);
		if(!is_array($array))
		{
			return false;
		}
		
		
		foreach($array as $index => $value)
		{
			$test = true;
			foreach($key_array as $key)
			{
				if($droits{$value[$key]} == '0' AND $test)
				{
					$test = false;
				}
			}
			if($test)
			{
				$return[$index] = $value;
			}
		}
		
		return $return;
	}
	
	function recount()
	{
		$sql="SELECT cat_id,  frm_id, a.pst_id,";
		$sql.=" COUNT(b.pst_id) as pst_nb,";
		$sql.=" a.pst_pid";
		$sql.=" FROM ".$this->sql->prebdd."frm_pst as a";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_pst as b ON a.pst_id = b.pst_pid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_frm ON frm_id = a.pst_fid";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."frm_cat ON cat_id = frm_cid";
		$sql.=" WHERE a.pst_pid = 0" ;
		if($fid)
		{
			$sql.=" AND a.pst_fid = $fid ";
		}
		$sql.=" GROUP BY a.pst_id,b.pst_pid";

		$pst_array = $this->sql->make_array($sql);
		
		foreach($pst_array as $pst_value)
		{
			$sql="UPDATE ".$this->sql->prebdd."frm_pst SET pst_msg_nb = ".$pst_value['pst_nb']." WHERE pst_id = ".$pst_value['pst_id'];
			$this->sql->query($sql);
			$frm_array[$pst_value['frm_id']]['msg_nb'] += $pst_value['pst_nb'] + 1;
			$frm_array[$pst_value['frm_id']]['post_nb'] ++;
		}
		
		foreach($frm_array as $frm_id => $frm_value)
		{
			$sql="UPDATE ".$this->sql->prebdd."frm_frm SET frm_pst_nb = ".$frm_value['post_nb'].", frm_msg_nb = ".$frm_value['msg_nb']." WHERE frm_id = $frm_id";
			$this->sql->query($sql);
		}
		
		
	}
}
?>