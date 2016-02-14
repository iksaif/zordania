<?php

function add_sdg($texte) 
{
	global $_sql;

	$question = protect($texte, "bbcode");
	

	$sql="INSERT INTO ".$_sql->prebdd."sdg VALUES('','$question','',NOW())";
	$_sql->query($sql);
	
	return $_sql->insert_id();
}

function add_rep_sdg($sid, $reponses)
{
	global $_sql;

	$sid = protect($sid, "uint");
	$reponses = protect($reponses, "array");

	if(!$reponses) return;

	$sql="INSERT INTO ".$_sql->prebdd."sdg_rep VALUES";
	foreach($reponses as $reponse) {
		$reponse = protect($reponse, "bbcode");
		$sql.= "('','$sid','$reponse',''),";
	}
	$sql = substr($sql, 0, strlen($sql) - 1); /* , en trop */
	return $_sql->query($sql);
}

function get_sdg_gen($cond = array())
{
	global $_sql;

	$mid = 0;
	$sid = 0;

	$cond = protect($cond, "array");

	if(isset($cond['mid']))
		$mid = protect($cond['mid'], "uint");
	if(isset($cond['sid']))
		$sid = protect($cond['sid'], "uint");
	
	$sql= "SELECT sdg_id, sdg_texte, _DATE_FORMAT(sdg_date) as sdg_date, sdg_rep_nb ";
	
	if($mid)
		$sql.= ", svte_rid as sdg_my_vte";
	
	$sql.= " FROM ".$_sql->prebdd."sdg";
	
	if($mid) { /* Selectionner les sondages ou on a voté */
		$sql.= " LEFT JOIN ".$_sql->prebdd."sdg_vte ";
		$sql.= " ON  (svte_sid = sdg_id AND svte_mid = $mid )  ";
	}

	if($sid)
		$sql.= " WHERE sdg_id = $sid"; 
	
	if(!$sid)
		$sql.= " ORDER BY sdg_id DESC";
	
	return $_sql->make_array($sql);
}

/* Infos sur un sondage */
function get_sdg($sid, $mid = 0)
{
	if($mid)
		return get_sdg_gen(array('sid' => $sid, 'mid' => $mid));
	else
		return get_sdg_gen(array('sid' => $sid));
}

/* Réponses possibles pour $id */
function get_sdg_result($sid)
{
	global $_sql;

	$sid = protect($sid, "uint");
	
	$sql="SELECT srep_id,srep_texte,srep_nb FROM ".$_sql->prebdd."sdg_rep WHERE srep_sid = $sid";
	return $_sql->make_array($sql);
}

/* Modifie la question du sondage $id */
function edit_sdg($sid, $texte)
{
	global $_sql;

	$question = protect($texte, "bbcode");
	$sid = protect($sid, "uint");
	
	$sql="UPDATE ".$_sql->prebdd."sdg SET sdg_texte = '$question' WHERE sdg_id= $sid";
	return $_sql->query($sql);
}

/* Modifie la réponse $id */
function edit_rep_sdg($rid, $texte)
{
	global $_sql;

	$choix = protect($texte, "bbcode");
	$rid = protect($rid, "uint");
	
	$sql="UPDATE ".$_sql->prebdd."sdg_rep SET srep_texte = '$choix' WHERE srep_id = $rid";
	$_sql->query($sql);
}

/* $mid vote $vid au sondage $sid */
function vte_sdg($sid,$mid,$rid)
{
	global $_sql;

	$sid = protect($sid, "uint");
	$mid = protect($mid, "uint");
	$vid = protect($rid, "uint");

	$sql="INSERT INTO ".$_sql->prebdd."sdg_vte VALUES ('$sid','$mid','$rid')";
	$_sql->query($sql);

	if(!$_sql->err)
		inc_vte($sid, $rid);
}

function inc_vte($sid, $rid)
{
	global $_sql;

	$sid = protect($sid, "uint");
	$rid = protect($rid, "uint");
	
	$sql="UPDATE ".$_sql->prebdd."sdg_rep SET srep_nb = srep_nb+1 WHERE srep_id = $rid";
	$_sql->query($sql);
	$sql="UPDATE ".$_sql->prebdd."sdg SET sdg_rep_nb = sdg_rep_nb + 1 WHERE sdg_id = $sid";
	$_sql->query($sql);
}

function del_sdg($id)
{
	global $_sql;

	$id = protect($id, "uint");
	
	$sql="DELETE FROM ".$_sql->prebdd."sdg WHERE sdg_id = $id";
	$_sql->query($sql);
	$nb = $_sql->affected_rows();
	$sql="DELETE FROM ".$_sql->prebdd."sdg_rep WHERE srep_sid = $id";
	$_sql->query($sql);
	$nb += $_sql->affected_rows();
	$sql="DELETE FROM ".$_sql->prebdd."sdg_vte WHERE svte_sid = $id";
	$_sql->query($sql);
	$nb += $_sql->affected_rows();

	return $nb;
}

function get_vte_nb_by_mid($sid, $mid) {
	global $_sql;

	$sid = protect($sid, "uint");
	$mid = protect($mid, "uint");

	$sql = "SELECT COUNT(*) FROM ".$_sql->prebdd."sdg_vte WHERE svte_sid = $sid AND svte_mid = $mid";
	return $_sql->result($_sql->query($sql), 0); 
}

?>
