<?php

function get_aly_gen($cond) {
	global $_sql;

	$limite1 = 0; $limite2 = 0;
	$limite = 0;
	$aid = 0; $name = 0;

	if(isset($cond['limite1'])) {
		$limite1 = protect($cond['limite1'], "uint");
		$limite++;	
	}
	if(isset($cond['limite2'])) {
		$limite2 = protect($cond['limite2'], "uint");
		$limite++;	
	}
	
	if(isset($cond['aid']))
		$aid = protect($cond['aid'], "uint");
	if(isset($cond['name']))
		$name = protect($cond['name'], "string");
		
	$sql="SELECT al_aid,al_name,al_nb_mbr,al_mid,mbr_pseudo,mbr_race, mbr_gid, al_points,al_open";
	if(!$limite)
		$sql.=",al_descr,al_rules";	
	
	$sql.=" FROM ".$_sql->prebdd."al ";
	$sql.=" JOIN ".$_sql->prebdd."mbr ON mbr_mid = al_mid ";
	
	if($aid || $name) {
		$sql .= "WHERE ";
		if($aid)
			$sql.= "al_aid = $aid AND ";
		if($name)
			$sql.=" al_name LIKE '%$name%' AND ";

		$sql = substr($sql, 0, strlen($sql) - 4);
	}

	$sql .= "ORDER BY al_points DESC ";

	if($limite) {
		if($limite == 2)
			$sql .= "LIMIT $limite2, $limite1 ";
		else
			$sql .= "LIMIT $limite1 ";
	}

	return $_sql->make_array($sql);
}

function get_aly($aid)
{
	if(!$aid)
		return array();
	return get_aly_gen(array('aid' => $aid));
}

function edit_aly($alid, $edit)
{
	global $_sql;

	$alid = protect($alid, "uint");

	$sql="UPDATE ".$_sql->prebdd."al SET ";
	if(isset($edit['open'])) {
		$open = protect($edit['open'], "uint");
		$sql.="al_open = $open,";
	}
	if(isset($edit['nb_mbr'])) {
		$nb_mbr = protect($edit['nb_mbr'], "int");
		$sql.="al_nb_mbr = al_nb_mbr + $nb_mbr,";
	}
	if(isset($edit['mid'])) {
		$mid = protect($edit['mid'], "uint");
		$sql.="al_mid = $mid,";
	}
	if(isset($edit['name'])) {
		$name = protect($edit['name'], "string");
		$sql.="al_name = '$name',";
	}
	if(isset($edit['descr'])) {
		$descr = protect($edit['descr'], "bbcode");
		$sql.="al_descr = '$descr',";
	}
	if(isset($edit['rules'])) {
		$rules = protect($edit['rules'], "bbcode");
		$sql.="al_rules = '$rules',";
	}
	if(isset($edit['diplo'])) {
		$diplo = protect($edit['diplo'], "bbcode");
		$sql.="al_diplo = '$diplo',";
	}
		
	$sql = substr($sql, 0, strlen($sql) - 1);
	
	$sql.=" WHERE al_aid = $alid";
	$_sql->query($sql);
		
	return $_sql->affected_rows();
}

function count_aly_msg($alid)/* nb msg shootbox */
{
	global $_sql;
	
	$alid = protect($alid, "uint");
	
	$sql="SELECT COUNT(*) FROM ".$_sql->prebdd."al_shoot WHERE shoot_aid = $alid";
	return $_sql->result($_sql->query($sql), 0 );
}
	
function get_aly_msg($alid,$limite1, $limite2 = 0)
{
	global $_sql;
	
	$alid = protect($alid, "uint");
	$limite1 = protect($limite1, "uint");
	$limite2 = protect($limite2, "uint");
	
	$sql="SELECT mbr_mid, shoot_msgid, shoot_mid, shoot_texte,mbr_pseudo,mbr_sign,_DATE_FORMAT(shoot_date) as shoot_date_formated,
		DATE_FORMAT(shoot_date,'%a, %d %b %Y %T') as shoot_date_rss";
	$sql.=" FROM ".$_sql->prebdd."al_shoot ";
	$sql.=" JOIN ".$_sql->prebdd."mbr ON mbr_mid = shoot_mid ";
	$sql.=" WHERE shoot_aid = '$alid' ";
	$sql.=" ORDER BY shoot_date DESC";
	
	if($limite2) 
		$sql.=" LIMIT $limite2,$limite1"; 
	else
		$sql.=" LIMIT $limite1";

	return $_sql->make_array($sql);
}
	
function add_aly_msg($alid,$text,$mid)
{
	global $_sql;
	
	$alid = protect($alid, "uint");
	$mid = protect($mid, "uint");
	$text = protect($text, "bbcode");
	
	$sql="INSERT INTO ".$_sql->prebdd."al_shoot VALUES ('','$mid','$alid',NOW(),'$text')";
	return $_sql->query($sql);
}
	
function del_aly_msg($alid,$msgid,$mid,$chef = false)
{
	global $_sql;
	
	$alid = protect($alid, "uint");
	$msgid = protect($msgid, "uint");
	$mid = protect($mid, "uint");
	$chef = protect($chef, "bool");
	
	$sql="DELETE FROM ".$_sql->prebdd."al_shoot WHERE shoot_msgid=$msgid AND shoot_aid=$alid";
	if(!$chef) $sql.=" AND shoot_mid=$mid";
	
	$_sql->query($sql);
	return $_sql->affected_rows();
}
	
function add_aly($mid,$nom)/* création nouvelle alliance */
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$nom = protect($nom, "string");
	
	$sql="INSERT INTO ".$_sql->prebdd."al VALUES ('','$nom','$mid','0','1','1','','', '')";
	$_sql->query($sql);
	
	$aid = $_sql->insert_id();
	
	$im = imagecreatefrompng(ALL_LOGO_DIR.'0.png');
	imagepng($im, ALL_LOGO_DIR."$aid.png");
	make_aly_thumb($aid,imagesx($im),imagesy($im));
	
	return $aid;
}
	
function del_aly($alid)
{
	global $_sql;
	
	$rows = 0;
	$alid = protect($alid, "uint");
	
	$sql = "DELETE FROM ".$_sql->prebdd."al_shoot WHERE shoot_aid = '$alid'";
	$_sql->query($sql); $rows += $_sql->affected_rows();
	
	$sql = "DELETE FROM ".$_sql->prebdd."al_res WHERE ares_aid = '$alid'";
	$_sql->query($sql); $rows += $_sql->affected_rows();
	
	$sql = "DELETE FROM ".$_sql->prebdd."al_res_log WHERE arlog_aid = '$alid'";
	$_sql->query($sql); $rows += $_sql->affected_rows();
	
	$sql = "DELETE FROM ".$_sql->prebdd."al WHERE al_aid = '$alid'";
	$_sql->query($sql); $rows += $_sql->affected_rows();
	
	$rows += del_aly_mbr($alid);
	
	return $rows;
	
}
	
function upload_aly_logo($alid, $fichier)
{
	$alid = protect($alid, "uint");
	
	$fichier = protect($fichier, "array");
	
	$nom = protect($fichier['name'], "string");
	$taille = protect($fichier['size'], "uint");
	$tmp = protect($fichier['tmp_name'], "string");
	$type = protect($fichier['type'], "string");
	$erreur = protect($fichier['error'], "string");
	
	if($erreur)
		return $erreur;
	
	if($taille > ALL_LOGO_SIZE OR !strstr(ALL_LOGO_TYPE, $type))
		return false;
		
	$nom_destination = ALL_LOGO_DIR.$alid.'.png';
	move_uploaded_file($tmp, $nom_destination);
	list($width, $height, $type, $attr) = getimagesize(ALL_LOGO_DIR.$alid.'.png');
	if($width <= ALL_LOGO_MAX_X_Y AND $height <= ALL_LOGO_MAX_X_Y)
		return make_aly_thumb($alid,$width,$height);
	else
	{
		$owidth = $width;
		$oheight= $height;
		$rap = $width / $height;
		$width = round(($width == $height) ? ALL_LOGO_MAX_X_Y : (($width > $height) ? ALL_LOGO_MAX_X_Y : ALL_LOGO_MAX_X_Y * $rap));
		$height = round($width / $rap);
		
		$im1 = imagecreatefrompng($nom_destination);	
		$im2 = imagecreatetruecolor ($width, $height);
		imagecopyresized ( $im2, $im1, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
		imagepng($im2,ALL_LOGO_DIR.$alid.'.png');
		
		return make_aly_thumb($alid,$width,$height);
	}
}

function make_aly_thumb($alid,$owidth,$oheight)
{
	$alid = protect($alid, "uint");
	$logo = ALL_LOGO_DIR.$alid.'.png';
	$owidth = protect($owidth, "uint");
	$oheight = protect($oheight, "uint");
	$width = 20;
	$height = 20;
	
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefrompng($logo);
	$col = imagecolorallocatealpha($image_p, 255,255,255,255);
	imagecolortransparent($image_p, $col);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0,$width, $height, $owidth, $oheight);
	return imagepng($image_p, ALL_LOGO_DIR.$alid.'-thumb.png');	
}

function get_aly_res($aid, $type = 0)/* grenier */
{
	global $_sql;
	
	$aid = protect($aid, "uint");
	$type = protect($type, "uint");
	
	$sql="SELECT ares_type,ares_nb FROM ".$_sql->prebdd."al_res WHERE ares_aid = $aid";
	if($type) $sql.=" AND ares_type = $type";
	if(!$type) $sql.=" ORDER BY ares_type ASC";
	
	return $_sql->make_array($sql);
}
function get_aly_res_norm($aid) // grenier "normalisé" ('id'= ressource et valeur = nb)
{
	$result = get_aly_res($aid);
	$return = array();
	foreach($result as $row)
		$return[$row['ares_type']] = $row['ares_nb'];
	return $return;
}

function get_log_aly_res($aid, $limite2, $limite1 = 0, $synth = false)/* qui a pris quoi au grenier */
{
	global $_sql;
	
	$aid = protect($aid, "uint");
	$limite1 = protect($limite1, "uint");
	$limite2 = protect($limite2, "uint");
	$synth = protect($synth, 'bool');

	if ($synth)
		$sql="SELECT mbr_pseudo, mbr_gid,mbr_mid,arlog_mid,arlog_type,SUM(arlog_nb) as total,arlog_ip ";
	else
		$sql="SELECT mbr_pseudo, mbr_gid,mbr_mid,arlog_mid,arlog_type,arlog_nb,_DATE_FORMAT(arlog_date) as arlog_date_formated ,arlog_ip ";

	$sql.=" FROM ".$_sql->prebdd."al_res_log ";
	$sql.=" LEFT JOIN ".$_sql->prebdd."mbr ON mbr_mid = arlog_mid ";
	$sql.=" WHERE arlog_aid = $aid";
	if ($synth)
		$sql .= ' GROUP BY arlog_mid,arlog_type';

	$sql.=" ORDER BY arlog_date DESC ";
	if($synth === false)
		$sql.="LIMIT ". ($limite1 ? "$limite1,$limite2" : $limite2);

	return $_sql->make_array($sql);	
}

function add_aly_res($aid, $mid, $type, $nb)/* prendre/retirer au grenier 1 ressource */
{
	return mod_aly_res($aid, $mid, array($type => $nb));
}

function mod_aly_res($aid, $mid, $res, $coef = 1)/* prendre/retirer au grenier plusieurs ressources */
{
	global $_sql;
	
	$aid = protect($aid, "uint");
	$mid = protect($mid, "uint");
	$res = protect($res, "array");
	$sql = '';
	$sql_log = array();
	$ip = get_ip();

	foreach($res as $type => $nb){
		if($nb){
			$nb = $nb * $coef;
			$sql = "INSERT INTO ".$_sql->prebdd."al_res VALUES ($aid,$type,$nb)";
			$sql .= " ON DUPLICATE KEY UPDATE ares_nb = ares_nb + $nb;";
			$_sql->query($sql);

			$sql_log[] = "('',$aid,$mid,$type,$nb,NOW(),'$ip')";
		}
	}

	if(!empty($sql_log)){
		//$_sql->query($sql);
	
		$sql = "INSERT INTO ".$_sql->prebdd."al_res_log VALUES ". implode(',', $sql_log);
		return $_sql->query($sql);
	}
}

function del_aly_mbr($aid, $mid = 0) {
	global $_sql;
	
	$aid = protect($aid, "uint");
	$mid = protect($mid, "uint");
	
	$sql = "DELETE FROM ".$_sql->prebdd."al_mbr ";
	$sql.= "WHERE ambr_aid = $aid  ";
	if($mid) $sql.= "AND ambr_mid = $mid";
	
	$_sql->query($sql);
	return $_sql->affected_rows();
}

function add_aly_mbr($aid, $mid, $etat) {
	global $_sql;
	
	$aid = protect($aid, "uint");
	$mid = protect($mid, "uint");
	$etat = protect($etat, "uint");
	
	$sql = "INSERT INTO ".$_sql->prebdd."al_mbr ";
	$sql.= "VALUES ($mid, $aid, NOW(), $etat)";
	return $_sql->query($sql);
}


function cls_aly($mid) {
	global $_sql;

	$mid = protect($mid, "uint");

	/* Il est dans une alliance ? */
	$mbr_infos = get_mbr_by_mid_full($mid);
	if(!$mbr_infos)
		return 0;

	$aid = $mbr_infos[0]['ambr_aid'];
	$race = $mbr_infos[0]['mbr_race'];
	$etat = $mbr_infos[0]['ambr_etat'];

	if(!$aid)
		return 0;

	if($etat == ALL_ETAT_DEM)
	{
		return del_aly_mbr($aid, $mid);
	}

	$ally = allyFactory::getAlly($aid);
	if($ally and $ally->al_mid != $mid)/* il n'est pas le chef on peut supprimer */
	{
		edit_aly($aid, array('nb_mbr' => -1));
		return del_aly_mbr($aid, $mid);
	}

	/* recherche du nouveau chef par ordre hiérarchique */
	$chef = $ally->getMembers(ALL_ETAT_SECD);
	if(empty($chef)) $chef = $ally->getMembers(ALL_ETAT_INTD);
	if(empty($chef)) $chef = $ally->getMembers(ALL_ETAT_RECR);
	if(empty($chef)) $chef = $ally->getMembers(ALL_ETAT_DPL);

	if(empty($chef))
		foreach($ally->getMembers() as $chef) /* Sinon, on fait n'importe quoi */
				break;

	if(empty($chef) or $chef['mbr_mid'] == $mid) /* Personne ne peut la prendre en charge */
		return del_aly($aid);
	else
		return del_aly_mbr($aid, $mid) +
			edit_aly($aid, array('mid' => $chef['mbr_mid'], 'nb_mbr' => -1));
}

?>
