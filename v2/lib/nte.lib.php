<?php	
function add_nte($mid, $titre, $texte, $import)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$titre = protect($titre, "string");
	$texte = protect($texte, "bbcode");
	$import = protect($import, "uint");
	
	$sql = "INSERT INTO ".$_sql->prebdd."ntes VALUES (NULL,$mid,'$titre',NOW(),'$texte','$import')";
	return $_sql->query($sql);
}
	
function get_nte($mid, $nid = 0)
{
	global $_sql;

	$mid = protect($mid, "uint");
	$nid = protect($nid, "uint");
	
	$sql="SELECT nte_nid, nte_titre, nte_import, _DATE_FORMAT(nte_date) as nte_date_formated ";
	if($nid)
		$sql.=",nte_texte ";
	
	$sql.="FROM ".$_sql->prebdd."ntes WHERE nte_mid = $mid ";
	
	if($nid)
		$sql.="AND nte_nid = $nid ";
	else
		$sql.="ORDER BY nte_date DESC";
	
	return $_sql->make_array($sql);
}
	
function edit_nte($mid, $nid, $titre, $texte, $import)
{
	global $_sql;

	$mid = protect($mid, "uint");
	$nid = protect($nid, "uint");
	$titre = protect($titre, "string");
	$texte = protect($texte, "bbcode");
	$import = protect($import, "uint");
	
	$sql="UPDATE ".$_sql->prebdd."ntes SET nte_date = NOW(), nte_texte = '$texte', nte_titre = '$titre', nte_import = '$import' WHERE nte_nid = $nid AND nte_mid = $mid";
	$_sql->query($sql);
	return $_sql->affected_rows();
}
	
function del_nte($mid, $nid = 0)
{
	global $_sql;

	$mid = protect($mid, "uint");
	$nid = protect($nid, "uint");
	
	$sql="DELETE FROM ".$_sql->prebdd."ntes WHERE nte_mid = $mid";
	if($nid)
		$sql.=" AND nte_nid = $nid";
	
	$_sql->query($sql);
	return $_sql->affected_rows();
}
	
function cls_nte($mid) {
	return del_nte($mid);
}
?>