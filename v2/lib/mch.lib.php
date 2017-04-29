<?php

function get_mch_by_mid($mid)
{
	global $_sql;
		
	$mid = protect($mid, "uint");
	
	$sql="SELECT *, _DATE_FORMAT(mch_time) as mch_time_formated FROM ".$_sql->prebdd."mch WHERE mch_mid = '$mid' AND mch_etat != ".COM_ETAT_ACH." ORDER BY mch_cid DESC";
	return $_sql->make_array($sql);
}
	
function get_mch($cid)
{
	global $_sql;
		
	$cid = protect($cid, "uint");
	
	$sql="SELECT * FROM ".$_sql->prebdd."mch WHERE mch_cid = '$cid' AND  mch_etat != ".COM_ETAT_ACH;
	return $_sql->make_array($sql);	
}
	
function list_mch($mid = 0,$valide = true)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$valide = protect($valide, "bool");
	$etat = ($valide) ? COM_ETAT_OK : COM_ETAT_ATT;
	
	$sql="SELECT COUNT(*) AS nb,mch_type FROM ".$_sql->prebdd."mch ";
	$sql.=" WHERE ";
	if($mid) $sql.= "mch_mid != $mid AND ";
	$sql.=" mch_etat = $etat ";
	$sql.=" GROUP BY mch_type ";
	$sql.=" ORDER BY mch_type ASC,nb DESC";
	return $_sql->make_array($sql);	
}

function list_mch_res($mid = 0,$type = 0,$valide = true)
{
	global $_sql;
		
	$mid = protect($mid, "uint");
	$type = protect($type, "int");
	$valide = protect($valide, "bool");
	$etat = ($valide) ? COM_ETAT_OK : COM_ETAT_ATT;
	
	$sql="SELECT mch_cid,mch_mid,mch_type,mch_nb,mch_prix,mbr_pseudo ";
	$sql.=" FROM ".$_sql->prebdd."mch ";
	$sql.=" JOIN ".$_sql->prebdd."mbr ON mch_mid = mbr_mid ";
	$sql.=" WHERE ";
	$sql.=" mch_etat = $etat ";
	if($mid) $sql.= " AND mch_mid != $mid ";
	if($type) $sql .= " AND mch_type = $type ";
	$sql.=" ORDER BY mch_type ASC,mch_nb DESC,mch_prix ASC ";
	
	return $_sql->make_array($sql);
}	
	
function mch_achat($mid,$cid)
{
	global $_sql;
		
	$mid = protect($mid, "uint");
	$cid = protect($cid, "uint");	

	$sql="UPDATE ".$_sql->prebdd."mch SET mch_etat=".COM_ETAT_ACH." WHERE mch_cid=$cid AND mch_etat = ".COM_ETAT_OK; 
	return $_sql->query($sql);
}	

function mch_make_infos($com_array,$type)
{
	global $_sql;
		
	$type = protect($type, "uint");
	$com_array = protect($com_array, "array");
	
	if(!$com_array)
		return array();
	
	$nb_ventes = 0;
	$total = array(0,0,0);
	
	foreach($com_array as $value)
	{
		$this_prix = $value['mch_prix'];
		$this_nb1 = $value['mch_nb'];
		
		$nb_ventes++; //nombre de ventes contre ca
		$total[1] += $this_nb1; //ressoures au total contre ca
		$total[2] += $this_prix; //idem
	}
	$return['total_ventes'] = $nb_ventes;
	$return['ventes'] = $total;
	
	return $return;
}

function mch_get_price($type)
{
	global $_sql;
		
	$type = protect($type, "uint");
	
	$sql="SELECT mch_nb,mch_prix FROM ".$_sql->prebdd."mch WHERE mch_type=$type AND mch_etat =".COM_ETAT_OK;
	$tmp = $_sql->make_array($sql);
	
	$total = array(1 => 0, 2 => 0);
	
	if(!$tmp) 
		return array();
	
	foreach($tmp as $key => $value)
	{
		$total[1] += $value['mch_nb'];
		$total[2] += $value['mch_prix'];
		$prix_unit = $value['mch_prix'] /$value['mch_nb'];
		
		if(!isset($min) || $prix_unit < $min)
			$min = $prix_unit;
		
		if(!isset($max) || $prix_unit > $max)
			$max = $prix_unit;
	}
	
	if(!$total[1])
		$avg = 0;
	else
		$avg = round($total[2] / $total[1]);

	return array('min'=> round($min), 'max' => round($max), 'avg' => $avg);
}
	
function mch_vente($mid, $type, $nb , $prix)
{
	global $_sql;
		
	$mid = protect($mid, "uint");
	$type = protect($type, "uint");
	$nb = protect($nb, "uint");
	$prix = protect($prix, "uint");
	
	$sql="INSERT INTO ".$_sql->prebdd."mch VALUES ('','$mid','$type','$nb','$prix',NOW(),".COM_ETAT_ATT.")";
	return $_sql->query($sql);
}
	
function cnl_mch($mid, $cid)
{
	global $_sql;
		
	$mid = protect($mid, "uint");
	$cid = protect($cid, "array");
	
	if(!$cid)
		return;
		
	$sql = "DELETE FROM ".$_sql->prebdd."mch WHERE mch_mid=$mid ";
	$sql.= " AND mch_cid IN (";
	foreach($cid as $value) {
		$value = protect($value, "uint");
		$sql.= "$value,";
	}
	$sql = substr($sql, 0, strlen($sql) - 1). ")";
	$sql.= " AND mch_etat != ".COM_ETAT_ACH;
	$_sql->query($sql);
	
	return $_sql->affected_rows();
}
	
function mch_get_cours($res = 0)
{
	global $_sql;
		
	$res = protect($res, "uint");
	
	$sql="SELECT * FROM ".$_sql->prebdd."mch_cours ";
	if($res) $sql.=" WHERE mcours_res = $res";
	$sql.=" ORDER BY mcours_res ASC";
	
	return $_sql->make_array($sql);
}
	
function mch_get_cours_sem($res = 0, $jours) // cours entre J et J+7
{
	global $_sql;

	$res = protect($res, "uint");
	$debut = protect($jours, "uint");
	$fin = $debut + 7;

	$sql="SELECT * FROM ".$_sql->prebdd."mch_sem ";
	if($res) $sql.=" WHERE msem_res = $res ";
	if($debut) $sql.= ($res ? "AND" : "WHERE")." msem_date BETWEEN (NOW() - INTERVAL $fin DAY) AND (NOW() - INTERVAL $debut DAY)";
	else	   $sql.= ($res ? "AND" : "WHERE")." msem_date BETWEEN (NOW() - INTERVAL 7 DAY) AND (NOW())";
	$sql.=" ORDER BY msem_res ASC,msem_date ASC LIMIT 112";
	return $_sql->make_array($sql);
}
	
function mch_update_cours_sem($res,$cours,$date)
{
	global $_sql;
		
	$res = protect($res, "uint");
	$cours = protect($cours, "float");
	$date = protect($date, "string");
	
	$sql="UPDATE ".$_sql->prebdd."mch_sem SET msem_cours = '$cours' WHERE msem_res = $res AND msem_date = '$date'";
	$_sql->query($sql);
	
	return $_sql->affected_rows();
}
	
function mch_update_cours($res,$cours)
{
	global $_sql;
		
	$res = protect($res, "uint");
	$cours = protect($cours, "float");
	
	$sql="UPDATE ".$_sql->prebdd."mch_cours SET mcours_cours = '$cours' WHERE mcours_res = $res";
	$_sql->query($sql);
	
	return mysql_affected_rows();
}

function cls_com($mid) {
	global $_sql;
		
	$mid = protect($mid, "uint");
	
	$sql="DELETE FROM ".$_sql->prebdd."mch WHERE mch_mid=$mid";
	$_sql->query($sql);
	
	return $_sql->affected_rows();
}
?>
