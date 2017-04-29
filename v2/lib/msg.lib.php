<?php
function get_msg_rec($mid, $msgid = 0) {
	global $_sql;
	
	$msgid = protect($msgid, "uint");
	$mid = protect($mid, "uint");

	$req = "SELECT mrec_titre,mrec_id,mrec_from,mrec_readed,";
	$req.= "_DATE_FORMAT(mrec_date) as mrec_date_formated, msg_sign,";
	$req.= "IFNULL(mbr_pseudo,mold_pseudo) AS mbr_pseudo,ifnull(mbr_gid,1) AS mbr_gid,IFNULL(mbr_sign,'membre disparus') AS mbr_sign";
	if($msgid)
		$req.= ",mrec_texte";
	$req.= " FROM ".$_sql->prebdd."msg_rec LEFT JOIN ";
	$req.= $_sql->prebdd."mbr ON mbr_mid = mrec_from ";
	$req.= " LEFT JOIN ";
	$req.= $_sql->prebdd."mbr_old ON mold_mid = mrec_from ";
	$req.= "WHERE mrec_mid = $mid ";

	if ($msgid)
		$req .= " AND mrec_id='$msgid' ";
	
	if (!$msgid)
		$req .= "ORDER BY mrec_date DESC ";

	return $_sql->make_array($req);
}

function get_msg_env($mid, $msgid = 0) {
	global $_sql;

	$msgid = protect($msgid, "uint");
	$mid = protect($mid, "uint");

	$req = "SELECT menv_titre,menv_id,menv_mid,menv_to, ";
	$req.= "_DATE_FORMAT(menv_date) as menv_date_formated,";
	$req.= "mbr_pseudo,mbr_gid, IFNULL(mrec_readed,1) as mrec_readed";
	if($msgid)
		$req.= ",menv_texte";
	$req.= " FROM ".$_sql->prebdd."msg_env ";
	$req.= " JOIN ".$_sql->prebdd."mbr ON mbr_mid = menv_to ";
	$req.= "LEFT JOIN ".$_sql->prebdd."msg_rec ON menv_mrec_id = mrec_id ";
	$req.= "WHERE menv_mid = $mid ";
	
	if ($msgid)
		$req .= " AND menv_id=$msgid ";
	
	if (!$msgid)
		$req .= "ORDER BY menv_date DESC ";
	
	return $_sql->make_array($req);
}

function flood_msg($mid) {
	global $_sql;

	$mid = protect($mid, "uint");

	$sql="SELECT COUNT(*) AS nb FROM ".$_sql->prebdd."msg_env WHERE menv_mid = '$mid' AND menv_date > (NOW() - INTERVAL ".MSG_FLOOD_TIME." SECOND)";
	return (bool) ($_sql->make_array_result($sql)['nb'] == 0);
}

function send_msg($mid, $mid2, $titre, $text, $copy = true) {
	global $_sql;

	$mid = protect($mid, "uint");
	$mid2 = protect($mid2, "uint");
	$titre = protect($titre, "string");
	$text = protect($text, "bbcode");
	$copy = protect($copy, "bool");

	$sql = "INSERT INTO ".$_sql->prebdd."msg_rec VALUES ";
	$sql.= "(NULL,$mid2,$mid,NOW(),'$titre','$text',0,0)";
	$_sql->query($sql);
		
	$mrec_id = $_sql->insert_id();
		
	$sql = "INSERT INTO ".$_sql->prebdd."msg_env VALUES";
	$sql.= " (NULL,$mid,'$mid2','$mrec_id',NOW(),'$titre','$text')";
	$_sql->query($sql);
}
	
	
function del_msg_env($mid, $msgid = 0)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	if (is_array($msgid))
		$msgid = implode(',',protect($msgid, array('uint')));
	else
		$msgid = protect($msgid, "uint");
	
	$sql="DELETE FROM ".$_sql->prebdd."msg_env WHERE menv_mid = $mid";
	if($msgid)
		$sql.=" AND menv_id IN ($msgid)";

	$_sql->query($sql);
	return $_sql->affected_rows();
}


function del_msg_rec($mid, $msgid = 0)
{
	global $_sql;

	$mid = protect($mid, "uint");
	if (is_array($msgid))
		$msgid = implode(',',protect($msgid, array('uint')));
	else
		$msgid = protect($msgid, "uint");

	$sql="DELETE FROM ".$_sql->prebdd."msg_rec WHERE mrec_mid = $mid";
	if($msgid)
		$sql.=" AND mrec_id IN ($msgid)";

	$_sql->query($sql);
	$return = $_sql->affected_rows();
	
	/* avec le msg reçu on supprime aussi les signalements */
	$sql="DELETE FROM ".$_sql->prebdd."sign ";
	if($msgid)
		$sql.=" WHERE sign_msgid IN ($msgid)";
	else
		$sql.=" WHERE sign_msgid IN (SELECT mrec_id FROM zrd_msg_rec WHERE mrec_mid = $mid)";
	return $return + $_sql->affected_rows();
}

function mark_msg_as_readed($mid,$msgid = 0)
{
	global $_sql;

	$mid = protect($mid, "uint");
	$msgid = protect($msgid, "uint");
	
	$sql = "UPDATE ".$_sql->prebdd."msg_rec SET mrec_readed = 1 ";
	$sql.= "WHERE mrec_mid = $mid ";
	if($_sql)
		$sql.= "AND mrec_id = $msgid";
	$_sql->query($sql);
	return $_sql->affected_rows();
}

function cls_msg($mid) {
	return (del_msg_rec($mid) + del_msg_env($mid));
}

function send_to_all($mid, $titre, $text, $grp = array()) {
	global $_sql;

	$mid = protect($mid, "uint");
	$titre = protect($titre, "string");
	$text = protect($text, "bbcode");
	$grp = protect($grp, array('uint'));

	$sql = "INSERT INTO ".$_sql->prebdd."msg_rec (mrec_mid, mrec_from, mrec_date, mrec_titre, mrec_texte, mrec_readed) ";
	$sql .=" SELECT mbr_mid,$mid,NOW(),'$titre','$text',0 FROM ".$_sql->prebdd."mbr ";
	$sql .=" WHERE mbr_etat = ".MBR_ETAT_OK ;
	if (!empty($grp)) $sql .= ' AND mbr_gid IN ('.implode(',',$grp).') ';
	$_sql->query($sql);

	$mrec_id = $_sql->insert_id();
	$sql = "INSERT INTO ".$_sql->prebdd."msg_env VALUES";
	$sql.= " (NULL,$mid,'$mid','$mrec_id',NOW(),'$titre','$text')";
	$_sql->query($sql);
}


/* fonction de signalement des messages par les membres */
function add_sign ($msgid,$com){ // signaler un message
	$msgid = protect ($msgid,"uint");
	$com = protect ($com,"bbcode");
	
	global $_sql;
	
	$sql = "INSERT INTO ".$_sql->prebdd."sign (sign_id, sign_msgid, sign_debut,sign_com) ";
	$sql .= "VALUES ('', '$msgid', NOW(),'$com') ";
	$_sql->query($sql);
	$sql= "UPDATE ".$_sql->prebdd."msg_rec";
	$sql.= " SET msg_sign = 1";
	$sql.= " WHERE mrec_id= ".$msgid;
	return $_sql->query($sql);
}

function set_adm_sign($sid, $mid, $com = '') { // assigner le signalement à un admin
	global $_sql;
	$sid = protect ($sid,"uint");
	$mid = protect ($mid,"uint");
	$com = protect ($com,"bbcode");

	if(!$sid) return false;
	$sql = "UPDATE ".$_sql->prebdd."sign ";
	$sql.= " SET sign_admid = $mid, sign_fin = NOW() ";
	if($com != '')
		$sql .= ", sign_com = CONCAT(sign_com, '\n<hr/>\n$com') ";
	$sql.= " WHERE sign_id = $sid";
	return $_sql->query($sql);
}
function add_com_sign($sid, $com = '') { // ajouter un commentaire
	global $_sql;
	$sid = protect ($sid,"uint");
	$com = protect ($com,"bbcode");

	if(!$sid) return false;
	$sql = "UPDATE ".$_sql->prebdd."sign ";
	$sql .= " SET sign_com = CONCAT(sign_com, '\n<hr/>\n$com') ";
	$sql .= " WHERE sign_id = $sid";
	return $_sql->query($sql);
}

function is_sign ($msgid){
	$msgid = protect ($msgid,"uint");
	global $_sql;

	$sql = "SELECT msg_sign ";
	$sql.= " FROM ".$_sql->prebdd."msg_rec";
	$sql.= " WHERE mrec_id=".$msgid;
	$array = $_sql->make_array($sql);
	if($array[msg_sign] == 1)
		{return true;}
	else{return false;}
}

function get_sign_list($cond = array()){ // liste des messages signalés
	global $_sql;

	$cond = protect($cond, 'array');
	if (isset($cond['etat']))
		$etat = protect($cond['etat'], 'uint');
	else
		$etat = false;
	if (isset($cond['id']))
		$id = protect($cond['id'], 'uint');
	else
		$id = 0;
	if (isset($cond['mrec_id']))
		$mrec_id = protect($cond['mrec_id'], 'uint');
	else
		$mrec_id = 0;
	if (isset($cond['pge']))
		$limit1 = protect($cond['pge'], 'uint')*LIMIT_PAGE;
	else
		$limit1 = 0;

	$sql = ' SELECT sign_id, msg.mrec_id, sign_admid, 
		_DATE_FORMAT(sign_debut) AS sign_debut, 
		_DATE_FORMAT(sign_fin) AS sign_fin, sign_com, 
		IFNULL(mbr2.mbr_pseudo,\'aucun\') AS sign_adm_pseudo, 
		_DATE_FORMAT(msg.mrec_date) as mrec_date_formated, 
		msg.mrec_titre, mbr.mbr_sign, ';
	$sql .= 'msg.mrec_mid, msg.mrec_from, 
		mbr.mbr_pseudo AS sign_to_pseudo, mbr.mbr_gid AS sign_to_gid, fro.mbr_gid, fro.mbr_pseudo ';
	if($id or $mrec_id)
		$sql .= ', msg.mrec_texte ';

	$sql.= " FROM ".$_sql->prebdd."sign ";
	$sql.= " LEFT JOIN ".$_sql->prebdd."mbr as mbr2 ON mbr2.mbr_mid = sign_admid";
	$sql.= " JOIN ".$_sql->prebdd."msg_rec AS msg ON msg.mrec_id = sign_msgid";
	$sql.= " JOIN ".$_sql->prebdd."mbr AS mbr ON mbr.mbr_mid = msg.mrec_mid";
	$sql.= " JOIN ".$_sql->prebdd."mbr AS fro ON fro.mbr_mid = msg.mrec_from";

	$where = array();
	if ($etat !== false) //0 n'est pas faux
		$where[] = " sign_etat = $etat ";
	if ($id)
		$where[] = " sign_id = $id ";
	if ($mrec_id)
		$where[] = " mrec_id = $mrec_id ";

	if (empty($where)) return false; // aucune sélection
	$sql.= " WHERE ".implode(' AND ', $where);
	$sql.= " ORDER BY ".$_sql->prebdd."sign.sign_debut DESC";
	if($limit1) $sql.= " LIMIT $limit1 ".LIMIT_PAGE;
	else $sql.= " LIMIT ".LIMIT_PAGE;

	return $_sql->make_array($sql);
}

function count_sign ($cond = array()){
	$cond = protect ($cond,'array');
	global $_sql;

	if (isset($cond['admid']))
		$admid = protect($cond['admid'], 'uint');

	$sql = "SELECT COUNT(sign_id) AS count_sign ";
	$sql.= " FROM ".$_sql->prebdd."sign ";
	if (isset($admid))
		$sql .= " WHERE sign_admid = $admid";
	return $_sql->make_array_result($sql);
}

?>
