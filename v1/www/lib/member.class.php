<?
class member
{
var $sql, $flood_time, $game, $conf;

	function member(&$db, &$game, &$conf)
	{
	    $this->sql = &$db; //objet de la classe mysql
	    $this->game = &$game; //objet de la classe game
	    $this->conf = &$conf;
	}
	 
	function set_conf(&$conf)
	{
		$this->conf = &$conf;
	}
	
	//Nouvelle entrée dans la table
	function mbr_new($login,$pseudo, $pass, $mail, $lang, $etat, $gid, $decal, $race, $ip)
	{
		$pseudo= htmlentities($pseudo, ENT_QUOTES);
		$login= htmlentities($login, ENT_QUOTES);
		$pass  = md5($pass);
		$lang  = htmlentities($lang, ENT_QUOTES);
		$etat = (int) $etat;
		$gid = (int) $gid;
		$decal = htmlentities($decal, ENT_QUOTES);
		$race = (int) $race;
		if(!@file_exists("conf/$race.php")){exit;}
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."mbr WHERE mbr_pseudo LIKE '$pseudo' OR mbr_login LIKE '$login' GROUP BY mbr_mid";
		if(@mysql_result($this->sql->query($sql),0) >= 1)
		{
			return false;
		}
		$sql="INSERT INTO ".$this->sql->prebdd."mbr VALUES";
		$sql.=" ('','$login','$pseudo','$pass','$mail','$lang','$etat','$gid','$decal','','$race',0,0,0,0,NOW(),NOW(),NOW(),'$ip','','')";
		$this->sql->query($sql);
		if($this->sql->errno != 1062)
		{
			$key=sha1(divers::genstring(20));
			$mid=mysql_insert_id();
			$this->new_vld($key, $mid, 'new');
			
			return array('key' => $key, 'mid' =>$mid);
			
		}else{
			return false;
		}	
	}
	
	//le membre existe
	function mbr_exists($mid)
	{
		$mid =(int) $mid;
		$sql = "SELECT COUNT(*) FROM ".$this->sql->prebdd."mbr WHERE mbr_mid='$mid'";
		return mysql_result($this->sql->query($sql), 0);	
	}
	
	//Todo : validation au changement mdp ou mail
	// $new est un array avec les diffrentes colonne de mysql sans le "mbr_"
	function edit($mid, $new)
	{
		$mid = (int) $mid;
		if(!is_array($new))
		{
			return true;
		}
		$sql = "UPDATE ".$this->sql->prebdd."mbr SET ";
		if($new['pseudo'])
		{	
			$pseudo = htmlentities($new['pseudo'], ENT_QUOTES);
			$sql .= "mbr_pseudo='$pseudo',";
		}
		if($new['login'])
		{	
			$login = htmlentities($new['login'], ENT_QUOTES);
			$sql .= "mbr_login='$login',";
		}
		if($new['pass'])
		{	
			if(!$new['passmd5'])
			{
				$pass = md5($new['pass']);
			}
			else
			{
				$pass= htmlentities($new['pass'], ENT_QUOTES);
			}
			$sql .= "mbr_pass='$pass',";
		}
		if($new['mail'])
		{	
			$mail = htmlentities($new['mail'], ENT_QUOTES);
			$sql .= "mbr_mail='$mail',";
		}
		if($new['lang'])
		{	
			$lang = htmlentities($new['lang'], ENT_QUOTES);
			$sql .= "mbr_lang='$lang',";
		}
		if($new['etat'])
		{	
			$etat = (int) $new['etat'];
			$sql .= "mbr_etat='$etat',";
		}
		if($new['gid'])
		{	
			$gid = (int) $new['gid'];
			$sql .= "mbr_gid='$gid',";
		}
		if($new['decal'])
		{	
			$decal = htmlentities($new['decal'], ENT_QUOTES);
			$sql .= "mbr_decal='$decal',";
		}
		if(isset($new['alaid']))
		{	
			$alaid = (int) $new['alaid'];
			$sql .= "mbr_alaid = '$alaid',";
		}
		if($new['mapcid'])
		{	
			$mapcid = (int) $new['mapcid'];
			$sql .= "mbr_mapcid='$mapcid',";
		}
		if($new['race'])
		{	
			$race = (int) $new['race'];
			$sql .= "mbr_race='$race',";
		}
		if($new['population'])
		{	
			$population = (int) $new['population'];
			$sql .= "mbr_population='$population',";
		}
		if($new['points'])
		{	
			$points = (int) $new['points'];
			$sql .= "mbr_points='$points',";
		}
		if($new['sign'])
		{
			$sign = $new['sign'];
			$sql .= "mbr_sign='$sign',";
		}
		if($new['descr'])
		{
			$sign = $new['descr'];
			$sql .= "mbr_descr='$sign',";
		}
		if($new['ldate'])
		{
			$sql .= "mbr_ldate=NOW(),";
		}
		if($new['atqnb'])
		{
			$atqpts = (int) $new['atqnb'];
			$sql .="mbr_atq_nb=$atqnb,";	
		}
		
		$sql .= " WHERE mbr_mid='$mid'";
		$sql=str_replace(", WHERE"," WHERE",$sql);

		return $this->sql->query($sql);
	}
	
	//Recupere les ip doubles, etc ...
	function get_infos_ip()
	{
		$sql="SELECT COUNT(*) as ip_nb,mbr_lip FROM ".$this->sql->prebdd."mbr GROUP BY mbr_lip HAVING COUNT(*) > 1";
		$temp_array = $this->sql->make_array($sql);
		if(is_array($temp_array))
		{
			foreach($temp_array as $key => $value)
			{
				if($value['ip_nb'] > 1)
				{
					$where_ip .= " OR mbr_lip = '".$value['mbr_lip']."'";
				}
			}
			if($where_ip)
			{
				$sql="SELECT mbr_pseudo,mbr_mid,mbr_lip,mbr_ldate FROM ".$this->sql->prebdd."mbr WHERE (0 ".$where_ip.") ORDER BY mbr_lip,mbr_pseudo,mbr_ldate DESC";
				return $this->sql->make_array($sql);
			}
		}
		return false;
	}
	
	//Recupere les infos sur les membres suivant les critères
	//$src est un array avec les differentes possibilitées de where + limites (ou mid)
	function get_infos($limite1_or_mid, $limite2 = false, $src = false, $map = false, $count = false, $order = false)
	{
		$limite1_or_mid = (int) $limite1_or_mid;
		$limite2 = (int) $limite2;
		$count = (bool) $count;
		
		$map_x = (int) $map['map_x'];
		$map_y = (int) $map['map_y'];
		
		if(!$count)
		{
			$sql = "SELECT mbr_mid,mbr_pseudo,mbr_mail,mbr_lang,mbr_etat,mbr_gid,mbr_decal,mbr_alaid,mbr_race,mbr_mapcid,mbr_population,mbr_points,mbr_atq_nb,formatdate(mbr_ldate) as mbr_ldate,formatdate(mbr_inscr_date) as mbr_inscr_date,formatdate(mbr_lmodif_date) as mbr_lmodif_date,mbr_lip,al_name";
			
            		if(!$limite2) $sql.=",mbr_sign,mbr_pass,mbr_login,mbr_descr";
            		if($map) $sql .=",map_cid,map_x,map_y,map_type";
            		if(isset($map['map_x'],$map['map_y'])) $sql.=", ROUND(SQRT(($map_x - map_x)*($map_x - map_x) + ($map_y - map_y)*($map_y - map_y)), 2) as mbr_dst  ";
            		$sql .=" FROM ".$this->sql->prebdd."mbr ";
            		$sql.=" LEFT JOIN ".$this->sql->prebdd."al ON al_aid = mbr_alaid ";
		}else{
			$sql = "SELECT COUNT(*) AS mbr_nb FROM ".$this->sql->prebdd."mbr ";
		}
		if($map)
		{
			$sql.=" LEFT JOIN ".$this->sql->prebdd."map ON map_cid = mbr_mapcid ";
		}
		if(is_array($src))
		{
			$sql.="WHERE ";
		}elseif(!$limite2 and !$count)
		{
			//$sql.="LEFT JOIN ".$this->sql->prebdd."al ON mbr_alaid = al_aid ";
			$sql.=" WHERE mbr_mid='$limite1_or_mid' AND ";	
		}
		if(isset($src['pseudo']))
		{	
			$pseudo = htmlentities($src['pseudo'], ENT_QUOTES);
			$sql .= "mbr_pseudo LIKE '%$pseudo%' AND ";
		}
		if(isset($src['pseudo_exact']))
		{	
			$pseudo = htmlentities($src['pseudo_exact'], ENT_QUOTES);
			$sql .= "mbr_pseudo LIKE '$pseudo' AND ";
		}
		if(isset($src['ip']))
		{	
			$ip = htmlentities($src['ip'], ENT_QUOTES);
			$sql .= "mbr_lip LIKE '$ip' AND ";
		}
		if(isset($src['pass']))
		{	
			$pass = md5($src['pass']);
			$sql .= "mbr_pass = '$pass' AND ";
		}
		if(isset($src['mail']))
		{	
			$mail = htmlentities($src['mail'], ENT_QUOTES);
			$sql .= "mbr_mail = '$mail' AND ";
		}
		if(isset($src['lang']))
		{	
			$lang = htmlentities($src['lang'], ENT_QUOTES);
			$sql .= "mbr_lang = '$lang' AND ";
		}
		if(isset($src['etat']))
		{	
			$etat = (int) $src['etat'];
			$sql .= "mbr_etat = '$etat' AND ";
		}
		if(isset($src['gid']))
		{	
			if(is_array($src['gid']))
			{
				$sql.='(';
				foreach($src['gid'] as $gid)
				{
					$gid = (int) $gid;
					$sql.="mbr_gid='$gid' OR ";
				}
				$sql.=')';
				$sql=str_replace('OR )',')',$sql);
			}
			else
			{
				$gid = (int) $src['gid'];
				$sql .= "mbr_gid = '$gid' AND ";
			}
		}
		if(isset($src['alaid']))
		{	
			$alaid = (int) $src['alaid'];
			$sql .= "mbr_alaid = '$alaid' AND ";
		}
		if(isset($src['mid']))
		{	
			$mid = (int) $src['mid'];
			$sql .= "mbr_mid = '$mid' AND ";
		}
		if(isset($src['decal']))
		{	
			$decal = htmlentities($src['decal'], ENT_QUOTES);
			$sql .= "mbr_decal = '$decal' AND ";
		}
		if(isset($src['mapcid']))
		{	
			$mapcid = (int) $src['mapcid'];
			$sql .= "mbr_mapcid = '$mapcid' AND ";
		}
		if(isset($src['race']))
		{	
			$race = (int) $src['race'];
			$sql .= "mbr_race = '$race' AND ";
		}
		if(isset($src['population']))
		{	
			$population = (int) $src['population'];
			$sql .= "mbr_population = '$population' AND ";
		}
		if(isset($src['points']))
		{	
			$points = (int) $src['points'];
			$sql .= "mbr_points = '$points' AND ";
		}
		if(isset($src['pg_points']))
		{	
			$points = (int) $src['pg_points'];
			$sql .= "mbr_points > '$points' AND ";
		}
		if(isset($src['pp_points']))
		{	
			$points = (int) $src['pp_points'];
			$sql .= "mbr_points < '$points' AND ";
		}
		if(isset($src['alid']))
		{
			$al_aid = (int) $new['alid'];
			$sql .= "mbr_alid = $al_aid AND ";
		}
		if(is_array($order))
		{
			$by = $order[1];
			$order = $order[0];
			if($by == 'pseudo')
			{
				$sql.="ORDER BY mbr_pseudo $order ";
			}
			if($by == 'points')
			{
				$sql.="ORDER BY mbr_points $order ";
			}
			if($by == 'population')
			{
				$sql.="ORDER BY mbr_population $order ";
			}	
			if($by == 'alliance')
			{
				$sql.="ORDER BY mbr_alaid $order ";
			}
			if($by == 'groupe')
			{
				$sql.="ORDER BY mbr_gid $order ";
			}
			if($by == 'dst' AND is_array($map) AND isset($map['map_x'],$map['map_y']))
			{
				$sql.="ORDER BY mbr_dst $order ";
			}
		}
		if($limite2)
		{
			$sql.= "LIMIT $limite1_or_mid, $limite2";
		}
		$sql .= ";";
		if(strpos($sql, "WHERE"))
		{
			//$sql=substr($sql, 0, strpos($sql, "AND"));
			//$sql=str_replace('AND LIMIT','LIMIT',$sql);
			$sql=preg_replace("/(.*) AND (;|LIMIT|ORDER)(.*)/","$1 $2 $3",$sql);
			$sql=preg_replace("/(.*) WHERE (;|LIMIT|ORDER)(.*)/","$1 $2 $3",$sql);
		}
		//echo $sql."<br>";
		return $this->sql->make_array($sql);
	}
	
	//Recupere la liste des mails (utile pour la newsletter), en fonction d'une diff de date (en jours)
	function get_emails($diff = 0, $valide = true)
	{
		$diff = (int) $diff;
		$valide = (bool) $valide;
		$sql="SELECT mbr_mail,mbr_pseudo FROM ".$this->sql->prebdd."mbr ";
		$sql.="WHERE ";
		if($valide)
		{
			$sql.=" (mbr_etat = 1 OR mbr_etat = 3) ";
		}
		else
		{
			$sql.=" mbr_etat = 2 ";
		}
		$sql.=" AND mbr_pseudo != 'guest' ";
		if($diff)
		{
			$sql.=" AND mbr_ldate < (NOW() - INTERVAL $diff DAY)";
		}
		return $this->sql->make_array($sql);
	}
	
	//Nombre de membres
	function nb_mbr($points = -1)
	{
		$points = (int) $points;
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."mbr";
		if($points != -1)
		{
			$sql.=" WHERE mbr_points < $points";
		}
		return mysql_result($this->sql->query($sql),0);
	}
	
	//Prepare la supresion
	function pre_del($mid)
	{
		$mid = (int) $mid;
		$sql = "SELECT COUNT(*) FROM ".$this->sql->prebdd."mbr WHERE mbr_mid='$mid'";
		$res = $this->sql->query($sql);
		if(mysql_result($res,0) == 1)
		{
			$mbr = $this->get_infos($mid);
			$mbr = $mbr[0];
			$key=sha1(divers::genstring(20));
			$this->new_vld($key, $mid, 'del');
		
			$this->sql->query($sql);
			return array('key' => $key,'mid' => $mbr['mbr_mid']);;
		}else{
			return false;
		}	
	}
	
	// Etat 1 -> validé | 2 -> en attente de validation | 3 -> Inactif
	//Valide une action
	function vld($key, $mid)
	{
		$mid = (int) $mid;
		$sql = "DELETE FROM ".$this->sql->prebdd."vld WHERE vld_mid='$mid' and vld_rand='$key'";
		$this->sql->query($sql);
		if(mysql_affected_rows())
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	//ajoute une ligne dans vld
	function new_vld($key, $mid, $act)
	{
		$mid = (int) $mid;
		
		$sql="INSERT INTO ".$this->sql->prebdd."vld VALUES ('$mid','$key',NOW(),'$act')";	
		return $this->sql->query($sql);
	}	
	
	function del_vld($mid)
	{
		$sql = "DELETE FROM ".$this->sql->prebdd."vld WHERE vld_mid='$mid'";
		return $this->sql->query($sql);
	}
		
	function get_vld($mid)
	{
		$mid = (int) $mid;
		
		$sql="SELECT vld_act FROM ".$this->sql->prebdd."vld WHERE vld_mid = '$mid'";
		return @mysql_result($this->sql->query($sql), 0);
	}
			
	//nouveau membre (apres validation),inverser
	function new_mbr($mid,$mapcid)
	{
		$mapcid = (int) $mapcid;
		$mid = (int) $mid;
		$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_etat='1',mbr_mapcid='$mapcid' ";
		$sql.="WHERE mbr_mid='$mid' AND mbr_etat='2'";
		$this->sql->query($sql);
		if(mysql_affected_rows())
		{		
			$this->gen_nb_res($mid,1,true);
			$this->game->unt_count_pop($mid);
			
			return true;
		}else{
			return false;
		}
	}
	
	function reinit($mid,$race)
	{
		$mid = (int) $mid;
		$race= (int) $race;

		$mbr_array = $this->get_infos($mid);
		
		//delete de tout ce qui le concerne
		if(!count($mbr_array))
		{
			return false;
		}
		$mbr_array = $mbr_array[0];
		$alaid = $mbr_array['mbr_alaid'];
		
				//Foutre ce truc en parametre
		if($alaid > 0)
		{
			$sql="UPDATE ".$this->sql->prebdd."al SET al_nb_mbr = al_nb_mbr - 1 WHERE al_aid = '$alaid'";
			$this->sql->query($sql);
			

			$sql="SELECT mbr_mid,al_mid FROM ".$this->sql->prebdd."mbr ";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."al ON al_aid = mbr_alaid";
			$sql.=" WHERE mbr_alaid='$alaid' AND mbr_mid != '$mid' AND mbr_etat = 1 ORDER BY mbr_points DESC LIMIT 1";
			$result = $this->sql->make_array($sql);
			$mbr_mid = $result[0]['mbr_mid'];
			if($result[0]['al_mid'] == $mid)
			{
				if($mbr_mid)
				{
					$sql="UPDATE ".$this->sql->prebdd."al SET al_mid = '$mbr_mid' WHERE al_aid = '$alaid'";
					$this->sql->query($sql);
					$nb_rows += mysql_affected_rows();
				}
				else
				{
					$sql="DELETE FROM ".$this->sql->prebdd."al,".$this->sql->prebdd."al_shoot,".$this->sql->prebdd."al_res,".$this->sql->prebdd."al_res_log WHERE al_res_mid = $alaid OR al_aid = $alaid OR shoot_aid = $alaid OR al_res_log_aid = $alaid";
					$this->sql->query($sql);
					$nb_rows += mysql_affected_rows();
				}
			}
		}
		
		$sql="UPDATE ".$this->sql->prebdd."mbr SET mbr_race = $race,mbr_alaid = 0,mbr_points = 0, mbr_population = 0, mbr_ldate = NOW() WHERE mbr_mid = $mid";
		$this->sql->query($sql);
		if(!mysql_affected_rows())
		{
			return false;
		}
		
		$sql="DELETE FROM ".$this->sql->prebdd."unt WHERE unt_mid=$mid";$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."btc WHERE btc_mid=$mid";$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."res WHERE res_mid=$mid";$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."src WHERE src_mid=$mid";$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."mch WHERE mch_mid=$mid";$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."atq WHERE atq_mid=$mid";$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."leg WHERE leg_mid=$mid";$this->sql->query($sql);
		$sql="DELETE FROM ".$this->sql->prebdd."histo WHERE histo_mid=$mid";$this->sql->query($sql);
		
		$this->gen_nb_res($mid,1,true);
		$this->game->unt_count_pop($mid);
		return true;
	}
	
	//Drop :p
	function del($mid)
	{
		$mid = (int) $mid;
		
		$mbr_array = $this->get_infos($mid);
		
		//delete de tout ce qui le concerne
		if(!count($mbr_array))
		{
			return false;
		}
		$mbr_array = $mbr_array[0];
		$alaid = $mbr_array['mbr_alaid'];
		
		$sql="DELETE FROM ".$this->sql->prebdd."unt WHERE unt_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."btc WHERE btc_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."res WHERE res_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."src WHERE src_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."mch WHERE mch_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."atq WHERE atq_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."leg WHERE leg_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."msg WHERE msg_mid2=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."vld WHERE vld_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."ntes WHERE nte_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		$sql="DELETE FROM ".$this->sql->prebdd."histo WHERE histo_mid=$mid";$this->sql->query($sql);$nb_rows += mysql_affected_rows();
		
		$sql="UPDATE ".$this->sql->prebdd."map,".$this->sql->prebdd."mbr SET map_type = '3'";
		$sql.=" WHERE map_cid = mbr_mapcid AND mbr_mid = '$mid'";
		$this->sql->query($sql);
		$nb_rows += mysql_affected_rows();
		
		//Foutre ce truc en parametre
		if($alaid > 0)
		{
			$sql="UPDATE ".$this->sql->prebdd."al SET al_nb_mbr = al_nb_mbr - 1 WHERE al_aid = '$alaid'";
			$this->sql->query($sql);
			

			$sql="SELECT mbr_mid,al_mid FROM ".$this->sql->prebdd."mbr ";
			$sql.=" LEFT JOIN ".$this->sql->prebdd."al ON al_aid = mbr_alaid";
			$sql.=" WHERE mbr_alaid='$alaid' AND mbr_mid != '$mid' AND mbr_etat = 1 ORDER BY mbr_points DESC LIMIT 1";
			$result = $this->sql->make_array($sql);
			$mbr_mid = $result[0]['mbr_mid'];
			if($result[0]['al_mid'] == $mid)
			{
				if($mbr_mid)
				{
					$sql="UPDATE ".$this->sql->prebdd."al SET al_mid = '$mbr_mid' WHERE al_aid = '$alaid'";
					$this->sql->query($sql);
					$nb_rows += mysql_affected_rows();
				}
				else
				{
					$sql="DELETE FROM ".$this->sql->prebdd."al,".$this->sql->prebdd."al_shoot,".$this->sql->prebdd."al_res,".$this->sql->prebdd."al_res_log WHERE al_res_mid = $alaid OR al_aid = $alaid OR shoot_aid = $alaid OR al_res_log_aid = $alaid";
					$this->sql->query($sql);
					$nb_rows += mysql_affected_rows();
				}
			}
		}
		
		$sql="DELETE FROM ".$this->sql->prebdd."mbr WHERE mbr_mid='$mid'";
		$this->sql->query($sql);
		$nb_rows += mysql_affected_rows();
		
		return $nb_rows;
	}
	
	//selectionne un carré de map au hasard le plus proche du centre
	function select_map_rand()
	{
		$moitie = round(MAP_H / 2);
		$rand = rand(($moitie-15),($moitie+15));
		$sql1="SELECT map_x, ABS(map_x- $rand) FROM ".$this->sql->prebdd."map WHERE map_type = 3 ORDER BY 2 LIMIT 1";
		$x = mysql_result($this->sql->query($sql1), 0);
   		$sql2="SELECT map_y, ABS(map_y- $rand) FROM ".$this->sql->prebdd."map WHERE map_type = 3 AND map_x = ".$x." ORDER BY 2 LIMIT 1";
		$y = mysql_result($this->sql->query($sql2), 0);
		$sql3="SELECT map_cid FROM ".$this->sql->prebdd."map WHERE map_x=$x AND map_y=$y";
		$cid = mysql_result($this->sql->query($sql3), 0);
		$sql="UPDATE ".$this->sql->prebdd."map set map_type=5 WHERE map_cid='$cid'";
		$this->sql->query($sql);
		return $cid;
	}
	
	//Rajouter "distance" en parametre
	function gen_nb_res($mid,$distance = 0,$init = false)
	{
		$mid = (int) $mid;
		$distance = (int) $distance;
		$init = (bool) $init;
		
		//Normal
		if($init)
		{
			$sql="SELECT mbr_race FROM ".$this->sql->prebdd."mbr WHERE mbr_mid='$mid'";
			$race= mysql_result($this->sql->query($sql), 0);
			//ajout des unités-batiments-ressources
			foreach($this->conf->debut[$race]['btc'] as $btc_id => $btc_value)
			{
				$btc_ids[$btc_id] = $btc_value;
			}
			$this->game->new_btc($mid,$btc_ids);
			foreach($this->conf->debut[$race]['unt'] as $unt_id => $unt_nb)
			{
				$unt_ids[$unt_id] = $unt_nb;
			}
			$this->game->new_unt($mid,$unt_ids);
			foreach($this->conf->debut[$race]['res'] as $res_id => $res_nb)
			{
				$res_ids[$res_id] = $res_nb;
			}
			$this->game->new_res($mid,$res_ids);
		}
			
		//En plus
		$sql = "SELECT map_x,map_y FROM ".$this->sql->prebdd."map LEFT JOIN ".$this->sql->prebdd."mbr
		        ON map_cid = mbr_mapcid WHERE mbr_mid = '$mid'";

		$mbr_array = $this->sql->make_array($sql);

		$x = $mbr_array[0]['map_x'];
		$y = $mbr_array[0]['map_y'];
		$min_x = $x-$distance;
		$min_y = $y-$distance;
		$max_x = $x+$distance;
		$max_y = $y+$distance;
		
		$sql = "SELECT map_type FROM ".$this->sql->prebdd."map WHERE";
		$sql .=" map_x >= $min_x AND map_y >= $min_y";
		$sql .=" AND map_x <= $max_x AND map_y <= $max_y";

		$result = $this->sql->make_array($sql);
		foreach($result as $key => $value)
		{
			$res_array = isset($this->conf->debut[$race]['map'][$value['map_type']]) ? $this->conf->debut[$race]['map'][$value['map_type']] : array();
			$res_nb	   = count($res_array);
			
			if($res_nb > 0)
			{
				$res_type = array_rand($res_array);
				$this->game->add_res($mid, $res_type, $res_array[$res_type], 0,false);	
			}
		}
	}
	
	function can_atq_lite($mbr_array, $points, $mid, $groupe, $alaid)
	{
		$points = (int) $points;
		$mid = (int) $mid;
		$groupe = (int) $groupe;
		$alaid = (int) $alaid;
		
		if(is_array($mbr_array[0]))
		{
		foreach($mbr_array as $rien => $un_mbr_array)
		{
			$pts = $un_mbr_array['mbr_points'];	
			$alid = $un_mbr_array['mbr_alaid'];
			if(($alid == 0 OR $alid != $alaid) AND ((abs($pts - $points) < ATQ_PTS_DIFF) AND ($pts > ATQ_PTS_MIN) OR ($pts >= ATQ_LIM_DIFF AND $points >= ATQ_LIM_DIFF)) AND $un_mbr_array['mbr_mid'] != $mid AND $groupe != 1 AND $un_mbr_array['mbr_etat'] ==1)
			{
				$mbr_array[$rien]['can_atq'] = true;
			}
		}
		}
		else
		{
			$pts = $mbr_array['mbr_points'];	
			$alid = $mbr_array['mbr_alaid'];
			if(($alid == 0 OR $alid != $alaid) AND ((abs($pts - $points) < ATQ_PTS_DIFF) AND ($pts > ATQ_PTS_MIN) OR ($pts >= ATQ_LIM_DIFF AND $points >= ATQ_LIM_DIFF)) AND $mbr_array['mbr_mid'] != $mid AND $groupe != 1 AND $mbr_array['mbr_etat'] ==1)
			{
				$mbr_array['can_atq'] = true;
			}	
		}
		//print_r($mbr_array);
		return $mbr_array;	
	}

	function upload_logo($mid, $fichier)
	{
		$mid = (int) $mid;
		
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

		if($taille > MBR_LOGO_SIZE OR !strstr(MBR_LOGO_TYPE, $type))
		{
			return false;
		}
		
		$nom_destination = MBR_LOGO_DIR.$mid.'.png';
		move_uploaded_file($tmp, $nom_destination);

		list($width, $height, $type, $attr) = getimagesize(MBR_LOGO_DIR.$mid.'.png');
		//echo"$width <= ".MBR_LOGO_MAX_X_Y." AND $height <= ".MBR_LOGO_MAX_X_Y;
		if($width <= MBR_LOGO_MAX_X_Y AND $height <= MBR_LOGO_MAX_X_Y)
		{
			return true;
		}
		else
		{
			//Tailles
			$owidth = $width;
			$oheight= $height;
			$rap = $width / $height;
			$width = round(($width == $height) ? MBR_LOGO_MAX_X_Y : (($width > $height) ? MBR_LOGO_MAX_X_Y : MBR_LOGO_MAX_X_Y * $rap));
			$height = round($width / $rap);
			
			$im1 = imagecreatefrompng($nom_destination);
			
			$im2 = imagecreatetruecolor ($width, $height);
			imagecopyresized ( $im2, $im1, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
			//echo"imagecopyresized ( $im2, $im1, 0, 0, 0, 0, $width, $height, $owidth, $oheight);";

			//unlink($nom_destination);
			imagepng($im2,$nom_destination);
			return true;
		}
	}
	
	function get_nb_race($race = 0)
	{
		$race = (int) $race;
		
		$sql="SELECT mbr_race,COUNT(*) as race_nb FROM ".$this->sql->prebdd."mbr ";
		if($race) $sql.=" WHERE mbr_race = $race ";
		$sql.=" GROUP BY mbr_race ";
		
		$race_tmp =  $this->sql->make_array($sql);
		foreach($race_tmp as $race_value)
		{
			$return[$race_value['mbr_race']] = $race_value['race_nb'];
		}
		return $return;
	}
	
	function get_rec($mid,$type=0)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		
		$sql="SELECT rec_id, rec_mid, rec_type FROM ".$this->sql->prebdd."rec ";
		if($mid OR $type) $sql.=" WHERE ";
		if($mid) $sql.=" rec_mid = $mid ";
		if($mid AND $type) $sql.=" AND ";
		if($type) $sql.=" rec_type = $type ";

		return $this->sql->make_array($sql);
	}
	
	function del_rec($rid,$mid=0)
	{
		$mid = (int) $mid;
		$rid = (int) $rid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."rec ";
		$sql.=" WHERE rec_id=$rid ";
		if($mid) $sql.="AND rec_mid = $mid ";
		
		$this->sql->query($sql);
		
		return mysql_affected_rows();
	}
	
	function add_rec($mid,$type)
	{
		$mid = (int) $mid;
		$type = (int) $type;
		
		$sql="INSERT INTO ".$this->sql->prebdd."rec  VALUES ('','$mid','$type') ";
		
		return $this->sql->query($sql);
	}
}
?>
