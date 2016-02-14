<?
class alliances
{
	var $sql;
	
	function alliances(&$sql)
	{
		$this->sql = &$sql;
	}
	
	function get_infos($limite1_or_alid, $limite2 = false)
	{
		$limite1_or_alid = (int) $limite1_or_alid;
		$limite2 = (int) $limite2;
		
		$sql="SELECT al_aid,al_name,al_nb_mbr,al_mid,mbr_pseudo,al_points,al_open";
		if(!$limite2)
		{
			$sql.=",al_descr,al_rules";	
		}
		$sql.=" FROM ".$this->sql->prebdd."al ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = al_mid ";
		if(!$limite2)
		{
			$sql.=" WHERE al_aid = $limite1_or_alid ";
		}
		else
		{
			$sql.=" ORDER BY al_points DESC LIMIT $limite1_or_alid,$limite2";
		}

		return $this->sql->make_array($sql);
	}
	
	
	function search($src)
	{	
		$sql="SELECT al_aid,al_name,al_nb_mbr,al_mid,mbr_pseudo,al_points,al_open";
		if(!$limite2)
		{
			$sql.=",al_descr,al_rules";	
		}
		$sql.=" FROM ".$this->sql->prebdd."al ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = al_mid ";
		$sql.=" WHERE ";
		if(isset($src['name']))
		{
			$name = htmlentities($src['name'], ENT_QUOTES);
			$sql.=" al_name LIKE '%$name%' AND";
		}
		$sql.="ORDER BY al_points DESC";
		$sql=str_replace("ANDORDER","ORDER",$sql);

		return $this->sql->make_array($sql);
	}
	
	function edit($alid, $edit)
	{
		$alid = (int) $alid;
		
		$sql="UPDATE ".$this->sql->prebdd."al SET ";
		if(isset($edit['open']))
		{
			$open = (int) $edit['open'];
			$sql.="al_open = $open,";
		}
		if(isset($edit['nb_mbr']))
		{
			$nb_mbr = (int) $edit['nb_mbr'];
			$sql.="al_nb_mbr = al_nb_mbr + $nb_mbr,";
		}
		if(isset($edit['mid']))
		{
			$mid = (int) $edit['mid'];
			$sql.="al_mid = $mid,";
		}
		if(isset($edit['name']))
		{
			$name = htmlentities($edit['name'], ENT_QUOTES);
			$sql.="al_name = '$name',";
		}
		if(isset($edit['descr']))
		{
			$descr = $edit['descr'];
			$sql.="al_descr = '$descr',";
		}
		if(isset($edit['rules']))
		{
			$rules = $edit['rules'];
			$sql.="al_rules = '$rules',";
		}
		
		$sql.=" WHERE al_aid = $alid";
		$sql = str_replace(', WHERE',' WHERE',$sql);
		$this->sql->query($sql);
		
		return mysql_affected_rows();
	}
	
	function nb()
	{
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."al";
		return mysql_result($this->sql->query($sql), 0);
	}
	
	function count_msg($alid)
	{
		$alid = (int) $alid;
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."al_shoot WHERE shoot_aid = $alid";

		return mysql_result($this->sql->query($sql), 0 );
	}
	
	function get_msg($alid,$limite1, $limite2 = 0)
	{
		$alid = (int) $alid;
		$limite1 = (int) $limite1;
		$limite2 = (int) $limite2;
		
		$sql="SELECT shoot_msgid, shoot_mid, shoot_texte,mbr_pseudo,mbr_sign,formatdate(shoot_date) as shoot_date_formated";
		$sql.=" FROM ".$this->sql->prebdd."al_shoot ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = shoot_mid ";
		$sql.=" WHERE shoot_aid = '$alid' ";
		$sql.=" ORDER BY shoot_date DESC";
		if($limite2)
		{ 
			$sql.=" LIMIT $limite2,$limite1"; 
		}
		else
		{
			$sql.=" LIMIT $limite1";
		}
		
		return $this->sql->make_array($sql);
	}
	
	function add_msg($alid,$text,$mid)
	{
		$alid = (int) $alid;
		$mid  = (int) $mid;
		
		$sql="INSERT INTO ".$this->sql->prebdd."al_shoot VALUES ('','$mid','$alid',NOW(),'$text')";

		return $this->sql->query($sql);
	}
	
	function del_msg($alid,$msgid,$mid,$chef = false)
	{
		$alid = (int) $alid;
		$msgid = (int) $msgid;
		$mid  = (int) $mid;
		$chef = (bool) $chef;
		
		$sql="DELETE FROM ".$this->sql->prebdd."al_shoot WHERE shoot_msgid=$msgid AND shoot_aid=$alid";
		if(!$chef) $sql.=" AND shoot_mid=$mid";

		$this->sql->query($sql);
		echo mysql_error();
		return mysql_affected_rows();
	}
	
	function add_al($mid,$nom)
	{
		$mid  = (int) $mid;
		$nom  = htmlentities($nom, ENT_QUOTES);
		
		$sql="INSERT INTO ".$this->sql->prebdd."al VALUES ('','$nom','$mid','0','1','1','','')";
		$this->sql->query($sql);
		
		return mysql_insert_id();
	}
	
	function del_al($alid)
	{
		$alid = (int) $alid;
		
		$sql = "DELETE FROM ".$this->sql->prebdd."al_shoot WHERE shoot_aid = '$alid'";
		$this->sql->query($sql);
		
		$sql = "DELETE FROM ".$this->sql->prebdd."al_res WHERE al_res_aid = '$alid'";
		$this->sql->query($sql);
		
		$sql = "DELETE FROM ".$this->sql->prebdd."al_res_log WHERE al_res_log_aid = '$alid'";
		$this->sql->query($sql);
		
		$sql = "UPDATE ".$this->sql->prebdd."mbr SET mbr_alaid = 0 WHERE mbr_alaid = '$alid'";
		$this->sql->query($sql);
		
		$sql = "DELETE FROM ".$this->sql->prebdd."al WHERE al_aid = '$alid'";
		$this->sql->query($sql);
		
		return mysql_affected_rows();
		
	}
	
	function upload_logo($alid, $fichier)
	{
		$alid = (int) $alid;
		
		if(!is_array($fichier))
		{
			return false;
		}
		$nom    	= $fichier['name'];
		$taille   = $fichier['size'];
		$tmp      = $fichier['tmp_name'];
		$type     = $fichier['type'];
		$erreur   = $fichier['error'];
		
		if($erreur)
		{
			return $erreur;
		}
		
		if($taille > ALL_LOGO_SIZE OR !strstr(ALL_LOGO_TYPE, $type))
		{
			return false;
		}
		
		
		$nom_destination = ALL_LOGO_DIR.$alid.'.png';
		move_uploaded_file($tmp, $nom_destination);

		list($width, $height, $type, $attr) = getimagesize(ALL_LOGO_DIR.$alid.'.png');
		if($width <= ALL_LOGO_MAX_X_Y AND $height <= ALL_LOGO_MAX_X_Y)
		{
			return $this->make_thumb($alid,$width,$height);
		}
		else
		{
			//Tailles
			$owidth = $width;
			$oheight= $height;
			$rap = $width / $height;
			$width = round(($width == $height) ? ALL_LOGO_MAX_X_Y : (($width > $height) ? ALL_LOGO_MAX_X_Y : ALL_LOGO_MAX_X_Y * $rap));
			$height = round($width / $rap);
			
			$im1 = imagecreatefrompng($nom_destination);
			
			$im2 = imagecreatetruecolor ($width, $height);
			imagecopyresized ( $im2, $im1, 0, 0, 0, 0, $width, $height, $owidth, $oheight);

			//unlink(ALL_LOGO_DIR.$alid.'.png');
			imagepng($im2,ALL_LOGO_DIR.$alid.'.png');
			
			return $this->make_thumb($alid,$width,$height);
		}
	}
	
	function make_thumb($alid,$owidth,$oheight)
	{
		$alid = (int) $alid;
		$logo = ALL_LOGO_DIR.$alid.'.png';
		$owidth = (int) $owidth;
		$oheight = (int) $oheight;
		$width = 20;
		$height = 20;
		
  		
  		
   		$image_p = imagecreatetruecolor($width, $height);
   		$image = imagecreatefrompng($logo);

		imagecopyresampled($image_p, $image, 0, 0, 0, 0,
                                     $width, $height, $owidth, $oheight);

                return imagepng($image_p, ALL_LOGO_DIR.$alid.'-thumb.png');
	
	}
	
	function get_infos_res($aid, $type = 0)
	{
		$aid = (int) $aid;
		$type = (int) $type;
		$sql="SELECT al_res_type,al_res_nb FROM ".$this->sql->prebdd."al_res WHERE al_res_aid = $aid";
		if($type) $sql.=" AND al_res_type = $type";
		$sql.=" ORDER BY al_res_type ASC";
		
		return $this->sql->make_array($sql);
	}
	
	function get_log_res($aid, $limite2, $limite1 = 0)
	{
		$aid = (int) $aid;
		$limite2 = (int) $limite2;
		$limite1 = (int) $limite1;
		
		$sql="SELECT mbr_pseudo, mbr_gid,mbr_mid,al_res_log_mid ,al_res_log_res_type,al_res_log_res_nb,formatdate(al_res_log_date) as al_res_log_date_formated ,al_res_log_ip ";
		$sql.=" FROM ".$this->sql->prebdd."al_res_log ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = al_res_log_mid ";
		$sql.=" WHERE al_res_log_aid = $aid";
		$sql.=" ORDER BY al_res_log_date DESC LIMIT ";
		$sql.= $limite1 ? "$limite1,$limite2" : $limite2;
		
		return $this->sql->make_array($sql);	
	}
	
	function add_res($aid, $mid, $type, $nb, $admin = false)
	{
		$aid = (int) $aid;
		$mid = (int) $mid;
		$type = (int) $type;
		$nb = (int) $nb;
		$admin = (bool) $admin;
		
		if($nb == 0)
		return true;
		
		//> 0 -> assez ?
		if(!$admin)
		{
			if($nb > 0)
			{
				$nb2 = floor(abs($nb-$nb*ALL_TAX));
				if($nb2 == 0) $nb2 = 1;
				
				$sql="SELECT res_nb FROM ".$this->sql->prebdd."res WHERE res_mid = $mid AND res_btc = 0 AND res_type = $type";
				$nb_in_db = mysql_result($this->sql->query($sql), 0,'res_nb');
				if($nb_in_db < $nb)
					return false;	
			}
			//< 0 -> assez ?
			else{
				$nb2 = $nb;
				
				$sql="SELECT al_res_nb FROM ".$this->sql->prebdd."al_res WHERE al_res_aid = $aid AND al_res_type = $type";
				$nb_in_db = @mysql_result($this->sql->query($sql), 0,'al_res_nb');
				if($nb_in_db < (-$nb))
					return false;	
			}
		}
		else
		{
			$nb2=$nb;
		}
		
		if(!$admin)
		{
			//update
			$sql="UPDATE ".$this->sql->prebdd."res SET res_nb = res_nb - $nb WHERE res_mid = $mid AND res_btc = 0 AND res_type = $type";
			$this->sql->query($sql);
			//update
		}

		$sql="UPDATE ".$this->sql->prebdd."al_res SET al_res_nb = al_res_nb + $nb2 WHERE al_res_aid = $aid AND al_res_type = $type";
		$this->sql->query($sql);
		if(!mysql_affected_rows())
		{
			$sql="INSERT INTO ".$this->sql->prebdd."al_res VALUES ('','$aid','$type','$nb2') ";
			$this->sql->query($sql);
		}
		//log
		$sql="INSERT INTO ".$this->sql->prebdd."al_res_log VALUES ('','$aid','$mid','$type','$nb2',NOW(),'".divers::getip()."')";
		return $this->sql->query($sql);
	}
	
}