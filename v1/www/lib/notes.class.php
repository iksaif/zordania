<?
class notes
{
	var $sql;
	
	function notes($sql)
	{
		$this->sql = &$sql;
	}
	
	function add($mid, $titre, $texte, $import)
	{
		$mid = (int) $mid;
		$titre = htmlentities($titre, ENT_QUOTES);
		//$texte = htmlentities($texte, ENT_QUOTES);
		$import = (int) $import;
		
		$sql = "INSERT INTO ".$this->sql->prebdd."ntes VALUES ('',$mid,'$titre',NOW(),'$texte','$import')";
		return $this->sql->query($sql);
	}
	
	function get_infos($mid, $nid = 0)
	{
		$mid = (int) $mid;
		$nid = (int) $nid;	
		
		$sql="SELECT nte_nid, nte_titre, nte_import, formatdate(nte_date) as nte_date_formated ";
		if($nid) $sql.=",nte_texte ";
		$sql.="FROM ".$this->sql->prebdd."ntes WHERE nte_mid = $mid ";
		if($nid) $sql.="AND nte_nid = $nid ";
		$sql.="ORDER BY nte_date DESC";
		
		return $this->sql->make_array($sql);
	}
	
	function edit($mid, $nid, $titre, $texte, $import)
	{
		$mid = (int) $mid;
		$nid = (int) $nid;
		$titre = htmlentities($titre, ENT_QUOTES);
		//$texte = htmlentities($texte, ENT_QUOTES);
		$import = (int) $import;
		
		$sql="UPDATE ".$this->sql->prebdd."ntes SET nte_date = NOW(), nte_texte = '$texte', nte_titre = '$titre', nte_import = '$import' WHERE nte_nid = $nid AND nte_mid = $mid";
		$this->sql->query($sql);
		return mysql_affected_rows();
	}
	
	function del($mid, $nid = 0)
	{
		$mid = (int) $mid;
		$nid = (int) $nid;	
		
		$sql="DELETE FROM ".$this->sql->prebdd."ntes WHERE nte_mid = $mid";
		if($nid) $sql.=" AND nte_nid = $nid";
		
		$this->sql->query($sql);
		return mysql_affected_rows();
	}
	
}
?>