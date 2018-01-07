<?php
/* Ajoute un membre */
function add_mbr($login, $pass, $mail, $lang, $etat, $gid, $decal, $ip, $design, $parrain)
{
	global $_sql;

	$login = protect($login, "string");
	$pass  = protect($pass, "string"); /* Le pass doit avoir été crypté ! */
	$lang  = protect($lang, "string");
	$etat = protect($etat, "uint");
	$gid = protect($gid, "uint");
	$decal = protect($decal, "string");
	$design = protect($design, "uint", 1);

	$sql = "INSERT INTO ".$_sql->prebdd."mbr (mbr_login, mbr_pseudo, mbr_pass, mbr_mail, mbr_lang, mbr_etat, mbr_gid, mbr_decal, mbr_ldate, mbr_inscr_date, mbr_lip, mbr_design, mbr_parrain)";
	$sql.= " VALUES ('$login','$login','$pass','$mail','$lang','$etat','$gid','$decal',NOW(),NOW(),'$ip',$design, $parrain)";

	$_sql->query($sql);

	if($_sql->errno) /* Une des clefs unique existe déjà ! */
		return 0;
	else {
		$mid =  $_sql->insert_id();
		$im = imagecreatefrompng(MBR_LOGO_DIR.'0.png');
		imagepng($im, MBR_LOGO_DIR."$mid.png");
		//add_frm($mid, $login, $pass, $gid, $lang);
		return $mid;
	}
}

/* Modifie un membre en particulier */
function edit_mbr($mid, $new)
{
	return edit_mbr_gen(array('mid' => $mid), $new);
}

/* modifie en général */
function edit_mbr_gen($cond, $new) {
		global $_sql;
		
		$mid = 0;
		
		$cond = protect($cond, "array");
		$new = protect($new, "array");
		$mid = protect($cond['mid'], "uint");
		
		if(!$new)
			return;

		$sql = "UPDATE ".$_sql->prebdd."mbr SET ";
		if(isset($new['pseudo'])) {	
			$pseudo = protect($new['pseudo'], "string");
			$sql .= "mbr_pseudo='$pseudo',";
		}
		if(isset($new['login'])) {	
			$login = protect($new['login'], "string");
			$sql .= "mbr_login='$login',";
		}
		if(isset($new['pass'])) {	
			$pass= protect($new['pass'], "string"); /* Le pass doit être crypté ! */
			$sql .= "mbr_pass='$pass',";
		}
		if(isset($new['mail'])) {	
			$mail = protect($new['mail'], "string");
			$sql .= "mbr_mail='$mail',";
		}
		if(isset($new['lang'])) {	
			$lang = protect($new['lang'], "string");
			$sql .= "mbr_lang='$lang',";
		}
		if(isset($new['etat'])) {	
			$etat = protect($new['etat'], "uint");
			$sql .= "mbr_etat='$etat',";
		}
		if(isset($new['gid'])) {	
			$gid = protect($new['gid'], "uint");
			$sql .= "mbr_gid='$gid',";
		}
		if(isset($new['decal'])) {
			$decal = protect($new['decal'], "string");
			$sql .= "mbr_decal='$decal',";
		}
		if(isset($new['mapcid'])) {
			$mapcid = protect($new['mapcid'], "uint");
			$sql .= "mbr_mapcid='$mapcid',";
		}
		if(isset($new['race'])) {	
			$race = protect($new['race'], "uint");
			$sql .= "mbr_race='$race',";
		}
		if(isset($new['population'])) {
			$population = protect($new['population'], "uint");
			$sql .= "mbr_population='$population',";
		}
		if(isset($new['place'])) {
			$place = protect($new['place'], "uint");
			$sql .= "mbr_place='$place',";
		}
		if(isset($new['points'])) {
			$points = protect($new['points'], "uint");
			$sql .= "mbr_points='$points',";
		}
		if(isset($new['sign'])) {
			$sign = protect($new['sign'], "bbcode");
			$sql .= "mbr_sign='$sign',";
		}
		if(isset($new['descr'])) {
			$sign = protect($new['descr'], "bbcode");
			$sql .= "mbr_descr='$sign',";
		}
		if(isset($new['ldate'])) {
			$sql .= "mbr_ldate=NOW(),";
		}
		if(isset($new['atqnb'])) {
			$atqpts = protect($new['atqnb'], "uint");
			$sql .="mbr_atq_nb=$atqnb,";	
		}
		if(isset($new['vlg'])) {
			$vlg = protect($new['vlg'], "string");
			$sql .= "mbr_vlg='$vlg',";
		}
		if(isset($new['design'])) {
			$design = protect($new['design'], "uint");
			$sql .= "mbr_design='$design',";
		}
		if(isset($new['sexe'])) {
			$sexe = protect($new['sexe'], "uint");
			$sql .= "mbr_sexe=$sexe,";
		}
				
		$sql = substr($sql, 0, strlen($sql)-1);
		
		if($mid)
			$sql .= " WHERE mbr_mid='$mid'";

		// si on renomme le village, il faut renommer les 2 pseudo-légions (civils et village)
		if(isset($new['vlg'])) {
			$sql1 = "UPDATE {$_sql->prebdd}leg SET leg_name='$vlg'";
			$sql1 .= " WHERE leg_mid = $mid AND leg_etat IN(".LEG_ETAT_VLG.",".LEG_ETAT_BTC.")";
			$_sql->query($sql1);
		}

		$_sql->query($sql);
		return $_sql->affected_rows();// + edit_frm($mid, $new);
}
	
/* Permet de détecter les multis comptes */
function get_infos_ip($ip = '',$gid = 0)
{

	global $_sql;

	$gid = protect($gid, "uint");
	$ip = protect($ip, 'string');

	if(!$ip){
		$sql="SELECT COUNT(*) as ip_nb,mbr_lip FROM ".$_sql->prebdd."mbr GROUP BY mbr_lip HAVING ip_nb > 1";
		$temp_array = $_sql->make_array($sql);
	
		if(!$temp_array)
			return array();
		
		$where_ip = "(";
		foreach($temp_array as $key => $value) {
			$where_ip .= " OR mbr_lip = '".$value['mbr_lip']."'";
		}
			
		$where_ip = str_replace('( OR','(',$where_ip).')';
	}else
		$where_ip = " mbr_lip = '$ip' ";
			
	$sql = "SELECT mbr_pseudo,mbr_mid,mbr_mail,mbr_login,mbr_lip,mbr_ldate ";
	$sql.= "FROM ".$_sql->prebdd."mbr ";
	$sql.= "WHERE ".$where_ip." ";
	if($gid != GRP_DIEU)
		$sql.= " AND mbr_gid NOT IN (".GRP_GARDE.",".GRP_PRETRE.",".GRP_DEMI_DIEU.",".GRP_DIEU.",".GRP_DEV.",".GRP_ADM_DEV.") ";
	$sql.= "ORDER BY mbr_lip,mbr_pseudo,mbr_ldate DESC";
	
	return $_sql->make_array($sql);
}

/* Récupere la position d'un joueur */
function mbr_get_pos($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	
	if(!$mid) return;
	
	$sql = "SELECT map_cid, map_x, map_y, map_type, map_region, map_rand";
	$sql .=" FROM ".$_sql->prebdd."mbr ";
	$sql .=" JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid";
	$sql .=" WHERE mbr_mid = $mid";
	
	return $_sql->make_array($sql);
}	


/* Initialise un compte */
function ini_mbr($mid, $pseudo, $vlg, $race, $cid, $gid, $sexe=1) {
	$edit = array('gid' => $gid, 'vlg' => $vlg, 'pseudo' => $pseudo, 'race' => $race, 'points' => 0, 'population' => 0, 'place' => 0, 'etat' => MBR_ETAT_OK, 'mapcid' => $cid, 'sexe' => $sexe);
	
	$unt = get_conf("race_cfg", "debut", "unt");
	$btc = get_conf("race_cfg", "debut", "btc");

	$pop = 0; $pla = 0;
	foreach($unt as $id => $nb)
		$pop += $nb;
	foreach($btc as $id => $info)
		$pla += get_conf("btc", $id, "prod_pop");

	$edit['population'] = $pop;
	$edit['place'] = $pla;

	edit_mbr($mid, $edit);

	ini_map($mid, $cid);

	ini_unt($mid, $cid, $vlg);
	ini_res($mid);
	ini_src($mid);
	ini_btc($mid);
	ini_trn($mid);
}

/* Réinitialise un compte */
function reini_mbr($mid, $pseudo, $vlg, $race, $cid, $oldcid, $gid, $sexe=1) {
	cls_map($mid, $oldcid);
	cls_aly($mid);
	cls_unt($mid);
	cls_hro($mid);
	cls_btc($mid);
	cls_res($mid);
	cls_src($mid);
	cls_trn($mid);
	cls_com($mid);
	cls_atq($mid);
	cls_histo($mid);
	cls_vld($mid);

	ini_mbr($mid, $pseudo, $vlg, $race, $cid, $gid, $sexe);
}

/* Libère les trucs d'un compte */
function cls_mbr($mid, $cid, $race) {
	add_old_mbr($mid) ;
	cls_aly($mid);
	cls_unt($mid);
	cls_btc($mid);
	cls_res($mid);
	cls_src($mid);
	cls_trn($mid);
	cls_com($mid);
	cls_atq($mid);
	cls_histo($mid);
	// cls_msg($mid); // on garde les messages
	cls_vld($mid);
	cls_map($mid, $cid);
	cls_nte($mid);
	//cls_frm($mid);
	
	del_mbr($mid);
}

function del_mbr($mid) {
	global $_sql;
	
	$mid = protect($mid, "uint");
	
	$sql = "DELETE FROM ".$_sql->prebdd."mbr WHERE mbr_mid = $mid ";
	
	$res = $_sql->query($sql);
	return $_sql->affected_rows();
}

function get_nb_race($race = 0)
{
	global $_sql;
	$race = protect($race, "uint");
	
	$sql="SELECT mbr_race,COUNT(*) as race_nb FROM ".$_sql->prebdd."mbr ";
	if($race) $sql.=" WHERE mbr_race = $race ";
	$sql.=" GROUP BY mbr_race ";
	
	return $_sql->make_array($sql);
}

// vérifier sur chaque membre de $mbr_array s'il peut attaquer / défendre qq1
function can_atq_lite($mbr_array, $points, $mid, $groupe, $alaid, $dpl_array = false)
{
	$mid = protect($mid, "uint");
	$points = protect($points, "uint");
	$groupe = protect($groupe, "uint");
	$alaid = protect($alaid, "int");
	if($dpl_array !== false) $dpl_array = protect($dpl_array, 'array');

	foreach($mbr_array as $key => $mbr) {
		$pts = $mbr['mbr_pts_armee'];	
		$alid = $mbr['ambr_aid'];

		/* si c'est un allié qu'on peut défendre */
		$mbr_array[$key]['can_def'] = false;
		$mbr_array[$key]['pna'] = false;

		/* staff intouchable  - sauf par lui même */
		$staff = array(GRP_GARDE, GRP_PRETRE, GRP_DEMI_DIEU, GRP_DIEU, GRP_DEV, GRP_ADM_DEV);
		if (in_array($mbr['mbr_gid'], $staff) and !in_array($groupe, $staff)) {
			$mbr_array[$key]['can_atq'] = false;
			continue;
		}

		/* grade event = protégé */
		if ($mbr['mbr_gid'] == GRP_EVENT and $groupe != GRP_EVENT) {
			$mbr_array[$key]['can_atq'] = false;
			continue;
		}

		if($alid && $alaid){
			if ($alid == $alaid) // même alliance
				$mbr_array[$key]['can_def'] = true;
			elseif (isset($dpl_array[$alid])) { // a un pacte
				if($dpl_array[$alid] == DPL_TYPE_MIL or $dpl_array[$alid] == DPL_TYPE_MC)
					$mbr_array[$key]['can_def'] = true;
				if($dpl_array[$alid] == DPL_TYPE_PNA)
					$mbr_array[$key]['pna'] = true;
			}
		}

		$mbr_array[$key]['can_atq'] = false;
		if((!$mbr_array[$key]['can_def'] // pas allié
			&& !$mbr_array[$key]['pna'] // pas de PNA
		) && (
			(abs($pts - $points) < ATQ_PTS_DIFF)  /* Trop de points de différences */
			&& ($pts > ATQ_PTS_MIN)  /* Pas assez de points pour etre attaqué */
			&& ($points > ATQ_PTS_MIN)  /* Pas assez de points pour attaquer */
			|| ($pts >= ATQ_LIM_DIFF && $points >= ATQ_LIM_DIFF) /* Arène */
		) && $mbr['mbr_mid'] != $mid /* Soit même */
		&& $groupe != GRP_VISITEUR /* Faut pas être un visiteur */
		&& $mbr['mbr_etat'] == MBR_ETAT_OK) /* Validé et pas en Veille */
			$mbr_array[$key]['can_atq'] = true;
	}
	return $mbr_array;	
}


function upload_logo_mbr($mid, $fichier)
{
	$mid = protect($mid, "uint");
	$fichier = protect($fichier, "array");
		
	if(!$fichier)
		return false;
		
	$nom = $fichier['name'];
	$taille = $fichier['size'];
	$tmp = $fichier['tmp_name'];
	$type = $fichier['type'];
	$erreur = $fichier['error'];
		
	if($erreur)
		return false;

	if($taille > MBR_LOGO_SIZE || !strstr(MBR_LOGO_TYPE, $type))
		return false;
		
	$nom_destination = MBR_LOGO_DIR.$mid.'.png';
	move_uploaded_file($tmp, $nom_destination);

	list($width, $height, $type, $attr) = getimagesize(MBR_LOGO_DIR.$mid.'.png');
		
	if($width <= MBR_LOGO_MAX_X_Y && $height <= MBR_LOGO_MAX_X_Y)
		return true;
	else { /* On redimensionne */
		$owidth = $width;
		$oheight= $height;
		$rap = $width / $height;
		$width = round(($width == $height) ? MBR_LOGO_MAX_X_Y : (($width > $height) ? MBR_LOGO_MAX_X_Y : MBR_LOGO_MAX_X_Y * $rap));
		$height = round($width / $rap);
			
		$im1 = imagecreatefrompng($nom_destination);
			
		$im2 = imagecreatetruecolor ($width, $height);
		imagecopyresized ( $im2, $im1, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
		imagepng($im2,$nom_destination);
		return true;
	}
}


/* Ce dont on a besoin en général */
function get_mbr_by_mid_lite($mid) {
	$mid = protect($mid, "uint");
	if(!$mid)
		return array();
	else
		return get_mbr_gen(array('mid' => $mid));
}

/* Sur les pages d'infos */
function get_mbr_by_mid_full($mid) {
	$mid = protect($mid, "uint");
	if(!$mid)
		return array();
	else
		return get_mbr_gen(array('mid' => $mid, 'full' => true));
}

/* En général : */
function get_mbr_gen($cond) {
	global $_sql;

	$cond = protect($cond, "array");

	$count = false; $list = false; $full = false; $mid = 0; $mid_excl = 0; $login = ""; $mail = ""; $pseudo = "";
	$etat = array(); $race =array(); $order = ""; $by = ""; $ltpoint = 0; $gtpoint = 0; $pass='';
	$ltpts_arm = 0; $gtpts_arm = 0; $mapcid = 0;
	$aid = 0; $ip = ""; $gid = array(); $dst = array();
	$limite1 = 0; $limite2 = 0; $aetat = array();
	$limite = 0; $group = ""; $parrain = 0;

	if(isset($cond['op']) && protect($cond['op'], "string") == "AND")
		$op = "AND";
	else
		$op = "OR";

	if(isset($cond['limite1'])) {
		$limite1 = protect($cond['limite1'], "uint");
		$limite++;
	}
	if(isset($cond['limite2'])) {
		$limite2 = protect($cond['limite2'], "uint");
		$limite++;
	}
	if(isset($cond['dst'][0]))
		$dst['x'] = protect($cond['dst'][0], "uint");
	if(isset($cond['dst'][1]))
		$dst['y'] = protect($cond['dst'][1], "uint");
	if(isset($cond['aid']))
		$aid = protect($cond['aid'], "uint");
	if(isset($cond['aetat']) && $aid)
		$aetat = protect($cond['aetat'], "array");
	if(isset($cond['etat']))
		$etat = protect($cond['etat'], "array");
	if(isset($cond['gid']))
		$gid = protect($cond['gid'], "array");
	if(isset($cond['race']))
		$race = protect($cond['race'], "array");
	if(isset($cond['mid'])){ /* peut etre 1 seul membre ou un tableau */
		if(is_array($cond['mid'])) $mid = protect($cond['mid'], array("uint"));
		else $mid = protect($cond['mid'], "uint");
	}
	if(isset($cond['mid_excl'])) // exclure un mid (pour compter par exemple)
		$mid_excl = protect($cond['mid_excl'], "uint");
	if(isset($cond['parrain']))
		$parrain = protect($cond['parrain'], "uint");
	if(isset($cond['login']))
		$login = protect($cond['login'], "string");
	if(isset($cond['pass']))
		$pass = protect($cond['pass'], "string");
	if(isset($cond['mail']))
		$mail = protect($cond['mail'], "string");
	if(isset($cond['pseudo']))
		$pseudo = protect($cond['pseudo'], "string");
	if(isset($cond['ip']))
		$ip = protect($cond['ip'], "string");
	if(isset($cond['ltpoint']))
		$ltpoint = protect($cond['ltpoint'], "uint");
	if(isset($cond['gtpoint']))
		$gtpoint = protect($cond['gtpoint'], "uint");
	if(isset($cond['ltpts_arm']))
		$ltpts_arm = protect($cond['ltpts_arm'], "uint");
	if(isset($cond['gtpts_arm']))
		$gtpts_arm = protect($cond['gtpts_arm'], "uint");
	if(isset($cond['full']))
		$full = protect($cond['full'], "bool");
	if(isset($cond['list']))
		$list = protect($cond['list'], "bool");
	if(isset($cond['count']))
		$count = protect($cond['count'], "bool");
	if(isset($cond['orderby']) && count($cond['orderby']) == 2) {
		$order = protect($cond['orderby'][0], "string");
		$by = protect($cond['orderby'][1], "string");
	}
	if(isset($cond['group'])) {
		$group = protect($cond['group'], "string");
	}
	if(isset($cond['mapcid']))
		$mapcid = protect($cond['mapcid'], "uint");

	//if(!$mid && !$login && !$mail && !$pseudo) return array();

	if($full) {
		$sql = "SELECT mbr_mid,mbr_login,mbr_pseudo,mbr_vlg,mbr_mail,mbr_lang,mbr_etat";
		$sql.= ",mbr_gid,mbr_decal,mbr_race,mbr_mapcid,mbr_population,mbr_place,";
		$sql.= "mbr_points,mbr_pts_armee,mbr_atq_nb, _DATE_FORMAT(mbr_ldate) as mbr_ldate,";
		$sql.= " _DATE_FORMAT(mbr_inscr_date) as mbr_inscr_date, ";
		$sql.= "_DATE_FORMAT(mbr_lmodif_date) as mbr_lmodif_date,mbr_lip,mbr_sexe,";
		$sql.= " ambr_etat, al_name, ambr_aid, al_nb_mbr,al_open ";
		$sql.= ",mbr_sign, mbr_descr, mbr_lip ";
		$sql.= ",map_cid,map_x,map_y,map_type,map_region, mbr_parrain, mbr_numposts ";
	} else if($list) {
		$sql = "SELECT mbr_mid,mbr_pseudo,mbr_lang,mbr_etat,mbr_gid,mbr_race,mbr_mapcid, mbr_population, mbr_place, mbr_points, mbr_pts_armee, ";
		$sql.= " mbr_lip,ambr_etat, IF(ambr_etat=".ALL_ETAT_DEM.", 0, IFNULL(ambr_aid,0)) as ambr_aid, ";
		$sql.= " IF(ambr_etat=".ALL_ETAT_DEM.", NULL, al_name) as al_name  ";
		$sql.= ",map_x,map_y ";
	} else if($count) {
		$sql = "SELECT COUNT(*) as mbr_nb ";
	} else {
		$sql = "SELECT mbr_mid, mbr_pseudo, mbr_gid, mbr_etat, mbr_points, mbr_pts_armee, IFNULL(ambr_aid,0) as ambr_aid , mbr_race, mbr_sexe ";
	}
	if(!$count && count($dst) == 2) {
		$sql .= ", GREATEST(ABS( ".$dst['x']." - map_x ), ABS( ".$dst['y']."- map_y)) AS mbr_dst ";
	}

	$sql.= "FROM ".$_sql->prebdd."mbr ";

	if($aid && (!$full && !$list))
		$sql.= "JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";

	if($full || $list || count($dst) == 2) {
		$sql.= "LEFT JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
		if(!$aid) {
			$sql.= "LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
			$sql.= "LEFT JOIN ".$_sql->prebdd."al ON ambr_aid = al_aid ";
		} else {
			$sql.= "JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
			$sql.= "JOIN ".$_sql->prebdd."al ON ambr_aid = al_aid ";
		}
	} else {
		$sql.= "LEFT JOIN ".$_sql->prebdd."al_mbr ON mbr_mid = ambr_mid ";
	}

	if($mid || $login || $mail || $pseudo || $etat || $gid || $race || $ip || $aid || $parrain || $mapcid) {
		$sql.= "WHERE ";

		if($aid)
			$sql.= "ambr_aid = $aid $op ";
		if($mid){
			if(is_array($mid)) // liste de $mid
				$sql.= "mbr_mid IN(".implode(',',$mid).") $op ";
			else
				$sql.= "mbr_mid = $mid $op ";
		}
		if($mid_excl)
			$sql.= "mbr_mid <> $mid_excl $op ";
		if($parrain)
			$sql.= "mbr_parrain = $parrain $op ";
		if($login)
			$sql.= "mbr_login = '$login' $op ";
		if($pass)
			$sql.= "mbr_pass = '$pass' $op ";
		if($mail)
			$sql.= "mbr_mail = '$mail' $op ";
		if($pseudo)
			$sql.= "mbr_pseudo LIKE '$pseudo' $op ";
		if($ip)
			$sql.= "mbr_lip LIKE '$ip' $op ";
		if($aetat) {
			$sql.= "ambr_etat IN (";
			foreach($aetat as $id)
				$sql.="$id,";
			$sql = substr($sql, 0, strlen($sql) - 1) . ") $op ";
		}
		if($etat) {
			$sql.= "mbr_etat IN (";
			foreach($etat as $id)
				$sql.="$id,";
			$sql = substr($sql, 0, strlen($sql) - 1) . ") $op ";
		}
		if($gid) {
			$sql.= "mbr_gid IN (";
			foreach($gid as $id)
				$sql.="$id,";
			$sql = substr($sql, 0, strlen($sql) - 1) . ") $op ";
		}
		if($race) {
			$sql.= "mbr_race IN (";
			foreach($race as $id)
				$sql.="$id,";
			$sql = substr($sql, 0, strlen($sql) - 1) . ") $op ";
		}
		if($ltpoint)
			$sql.= "mbr_points < $ltpoint $op ";
		if($gtpoint)
			$sql.= "mbr_points > $gtpoint $op ";
		if($ltpts_arm)
			$sql.= "mbr_pts_armee < $ltpts_arm $op ";
		if($gtpts_arm)
			$sql.= "mbr_pts_armee > $gtpts_arm $op ";
		if($mapcid)
			$sql.= "mbr_mapcid = $mapcid $op ";

		$sql = substr($sql, 0, strlen($sql) - strlen($op) - 1);
	}

	if($group)
		$sql.= " GROUP BY $group ";

	$valid_mbr_by = array('mid', 'points', 'pts_armee', 'population', 'race', 'pseudo','gid', 'dst');
	$valid_al_by = array('alliance_aid', 'alliance_name', 'alliance_points', 'alliance_open', 'alliance_nb_mbr');
	if(in_array($order,array('DESC','ASC'))){
		if(in_array($by, $valid_mbr_by)) {
			$sql.= "ORDER BY mbr_$by $order";
		}
		else if(in_array($by, $valid_al_by)) {
			$tmpBy = str_replace("alliance_", "al_", $by);
			$sql.= "ORDER BY $tmpBy $order";
		}
	}

	if($limite)
		if($limite == 2)
			$sql .= " LIMIT $limite2, $limite1 ";
		else
			$sql .= " LIMIT $limite1 ";

	return $_sql->make_array($sql);
}

function get_id_vlg($mid, $etat){ // récupére l'id du village suivant l'état 
	global $_sql;
	$mid = protect($mid, "uint");
	$etat = protect($etat, "uint");
	
	$sql = "SELECT leg_id FROM ".$_sql->prebdd."leg WHERE leg_mid = $mid AND leg_etat = $etat";
	$res = $_sql->query($sql);
	$lid = $_sql->result($res, 0, 'leg_id');
	
	return $lid;
}

/* Compte le nombre de membres */
function count_mbr($cond = array()) {
	$cond['count'] = true;
	$ret = get_mbr_gen($cond);
	if($ret && isset($ret[0]['mbr_nb']))
		return $ret[0]['mbr_nb'];
	else
		return 0;
}

function mbr_exists($mid) {
	$mid = protect($mid, "uint");
	if($mid)
		return count_mbr(array('mid' => $mid));
	else
		return 0;
}

/* Pour les listes de membres */
function get_liste_mbr($cond, $limite1, $limite2, $orderby) {
	$cond['orderby'] = $orderby;
	$cond['limite2'] = $limite1;
	$cond['limite1'] = $limite2;
	$cond['list'] = true;
	return get_mbr_gen($cond);
}

/* Récupere la position */
function get_mbr_pos($cond) {
	global $_sql;
	
	$mid = 0;
	$pseudo = "";
	
	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	else if(isset($cond['pseudo']))
		$pseudo = protect($cond['pseudo'], "string");
	else
		return array();
	
	$sql = "SELECT mbr_mid, mbr_mapcid, map_x, map_y, mbr_pseudo, mbr_points ";
	$sql.= "FROM ".$_sql->prebdd."mbr ";
	$sql.= "JOIN ".$_sql->prebdd."map ON mbr_mapcid = map_cid ";
	$sql.= "WHERE ";
	
	if($mid) 
		$sql.= "mbr_mid = $mid ";
	else
		$sql.= "mbr_pseudo LIKE '%$pseudo%' LIMIT 1 ";
	
	return $_sql->make_array($sql);
}

function get_mbr_logo($mid) {
	$mid = protect($mid, "uint");
	
	$file = MBR_LOGO_DIR.$mid.'.png';
	if(file_exists($file))
		return 'img/mbr_logo/'.$mid.'.png';
	else
		return 'img/mbr_logo/0.png';
}

function get_race_info($races = array()) {
	global $_sql, $_races;

	$races = protect($races, "array");

	$sql = "SELECT mbr_race,COUNT(*) as race_nb ";
	$sql.= "FROM ".$_sql->prebdd."mbr ";
	if($races) {
		$sql.= "WHERE ";
		foreach($races as $race_value) {
			$race_id = protect($race_id, "uint");
			$sql.= "mbr_race = $race_id OR ";	
		}
		$sql = substr($sql, 0, strlen($sql) - 3);
	}
	$sql.= "GROUP BY mbr_race ORDER BY mbr_race ASC";

	return $_sql->make_array($sql);
}

function get_nb_mbr($cond = array()) {
	global $_sql;

	
	$sql = "SELECT COUNT(*) as nb ";
	$sql.= "FROM ".$_sql->prebdd."mbr ";
	
	$ret = $_sql->make_array_result($sql)['nb'];
	return  $ret;
}

function calc_dst($x1, $y1, $x2, $y2) {
	$x1 = protect($x1, "uint");
	$y1 = protect($y1, "uint");
	$x2 = protect($x2, "uint");
	$y2 = protect($y2, "uint");

	/* On ne calcule pas la distance a vol d'oiseau, mais la distance que la légion devrais parcourir */
	$diffx = abs($x1 - $x2); 
	$diffy = abs($y1 - $y2);
	if($diffx == $diffy) { /* juste une diagonale */
		return $diffx;
	} else {
		return max($diffx, $diffy); 
	}
}

function add_old_mbr($mid) {
	global $_sql;

	$mid = protect($mid, "uint");
	
	$sql = "INSERT INTO ".$_sql->prebdd."mbr_old (mold_mid, mold_pseudo, mold_mail, mold_lip) ";
	$sql.= "SELECT mbr_mid, mbr_pseudo, mbr_mail, mbr_lip FROM ".$_sql->prebdd."mbr WHERE mbr_mid = $mid";
	return $_sql->query($sql);
}

function get_old_mbr($cond = array()) {
	global $_sql;
	
	$cond = protect($cond, "array");
	
	$mid = 0; $pseudo = ""; $ip = "";
	
	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	if(isset($cond['pseudo']))
		$pseudo = protect($cond['pseudo'], "string");
	if(isset($cond['ip']))
		$ip = protect($cond['ip'], "string");
		
	$sql = "SELECT * FROM ".$_sql->prebdd."mbr_old ";
	if($mid || $pseudo || $ip) {
		$sql .= "WHERE ";
			
		if($mid) $sql .= "mold_mid = $mid AND ";
		if($pseudo) $sql .= "mold_pseudo LIKE '%$pseudo%' AND ";
		if($ip) $sql .= "mold_lip LIKE '%$ip%' AND ";
		
		$sql = substr($sql, 0, strlen($sql) - 4);
	}
	return $_sql->make_array($sql);
}

function get_log_ip($mid = 0, $ip = '', $select = '',$gid = ''){
	global $_sql;

	$gid = protect($gid, "uint");
	$mid = protect($mid, 'uint');
	$ip = protect($ip, 'string');

	if($select == 'full')
		$sql = 'SELECT mlog_mid, IFNULL(mbr_pseudo, mold_pseudo) AS mbr_pseudo, IFNULL(mbr_gid,0) AS mbr_gid, IFNULL(mbr_mail, mold_mail) AS mbr_mail, mlog_ip, _DATE_FORMAT(mlog_date) AS mlog_date
		FROM '.$_sql->prebdd.'mbr_log
		LEFT JOIN '.$_sql->prebdd.'mbr ON mlog_mid = mbr_mid
		LEFT JOIN '.$_sql->prebdd.'mbr_old ON mlog_mid = mold_mid';
	else
		$sql = 'SELECT mlog_mid, mlog_ip, _DATE_FORMAT(mlog_date) AS mlog_date
		FROM '.$_sql->prebdd.'mbr_log';
	$where = '';
	if($mid)
		$where .= " AND mlog_mid = $mid ";
	if($ip)
		$where .= " AND mlog_ip = '$ip' ";
	if($where)
		$sql .= ' WHERE '.substr($where, 4);
	if($select == 'full' and $gid != GRP_DIEU)
		$sql.= " AND mbr_gid NOT IN (".GRP_GARDE.",".GRP_PRETRE.",".GRP_DEMI_DIEU.",".GRP_DIEU.",".GRP_DEV.",".GRP_ADM_DEV.") ";
	$sql .= ' ORDER BY '.$_sql->prebdd.'mbr_log.mlog_date DESC LIMIT 0, 15';

	return $_sql->make_array($sql);
}

//ajoute une surveillance
function add_surv($mid, $mid_admin, $type, $cause){
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	$mid_admin = protect($mid_admin, "uint");
	$cause = protect($cause, "string");
	global $_sql;
	
	$sql = "INSERT INTO ".$_sql->prebdd."surv (surv_id, surv_mid, surv_admin, surv_debut, surv_etat, surv_type, surv_cause) ";
	$sql .= "VALUES (NULL, '$mid', '$mid_admin', NOW(), '".SURV_OK."', '$type', '$cause') ";
	
	return $_sql->query($sql);
}

//renvoie les surveillances admin affectées au joueur dont on passe l'id comme argument
function get_surv($mid){
	$mid = protect($mid, 'uint');
	global $_sql;
	
	$sql = "SELECT surv_id, surv_mid, surv_etat, surv_admin, _DATE_FORMAT(surv_debut) as debut, ";
	$sql.= " _DATE_FORMAT(surv_debut + INTERVAL ".SURV_DUREE." SECOND) as fin, surv_type, surv_cause"; 
	$sql.= " FROM ".$_sql->prebdd."surv";
	$sql.= " WHERE surv_mid=".$mid;
	$sql.= " AND surv_etat = ".SURV_OK;
	return $_sql->make_array($sql);
}

function get_surv_by_sid($sid){
	$sid = protect($sid, 'uint');
	global $_sql;
	
	$sql = "SELECT surv_mid, surv_type, surv_etat, _DATE_FORMAT(surv_debut + INTERVAL ".SURV_DUREE." SECOND) as fin ";
	$sql.= "FROM ".$_sql->prebdd."surv";
	$sql.= " WHERE surv_id = ".$sid;
	$sql.= " AND surv_etat = ".SURV_OK;
	return $_sql->make_array($sql);
}

function get_surv_list(){
	global $_sql;
	$sql = " SELECT surv_id, surv_mid, surv_admin, surv_type, surv_debut, surv_cause, mbr.mbr_pseudo AS surv_pseudo, mbr2.mbr_pseudo AS surv_adm_pseudo ";
	$sql.= " FROM ".$_sql->prebdd."surv ";
	$sql.= " JOIN ".$_sql->prebdd."mbr as mbr ON mbr.mbr_mid = surv_mid";
	$sql.= " JOIN ".$_sql->prebdd."mbr as mbr2 ON mbr2.mbr_mid = surv_admin";
	$sql.= " WHERE surv_etat = ".SURV_OK;
	return $_sql->make_array($sql);
}
function get_fin_surv_list (){
	global $_sql;
	$sql = " SELECT surv_id, surv_mid, surv_admin, surv_type, surv_fin, surv_cause, mbr.mbr_pseudo AS surv_pseudo, mbr2.mbr_pseudo AS surv_adm_pseudo ";
	$sql.= " FROM ".$_sql->prebdd."surv ";
	$sql.= " JOIN ".$_sql->prebdd."mbr as mbr ON mbr.mbr_mid = surv_mid";
	$sql.= " JOIN ".$_sql->prebdd."mbr as mbr2 ON mbr2.mbr_mid = surv_admin";
	$sql.= " WHERE surv_etat = ".SURV_CLOSE. " AND surv_fin >= DATE_SUB(NOW(),INTERVAL 1 MONTH)";
	return $_sql->make_array($sql);

}
function close_surv($sid){
	$sid =  protect($sid, "uint");
	global $_sql;
	
	$sql = " UPDATE ".$_sql->prebdd."surv ";
	$sql.= " SET surv_fin = NOW(), surv_etat = ".SURV_CLOSE;
	$sql.= " WHERE surv_id = ".$sid;
	return $_sql->query($sql);
}

function is_surv($mid){
	$mid = protect($mid, "uint");
	$array = get_surv($mid);
	if(empty($array))
		return false;
	return true;
}

function move_member($mid, $move_to) {
	$mid =  protect($mid, "uint");
	$move_to =  protect($move_to, "uint");
	global $_sql;

	if($mid and $move_to)
		return $_sql->query("CALL move_member($mid, $move_to);");
	else
		return false;
}

?>
