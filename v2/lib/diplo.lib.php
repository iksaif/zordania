<?php	//shout commune pactes
	function count_diplo_msg($alid)/* nb msg shootbox */
	{
		global $_sql;
	
		$alid = protect($alid, "uint");
	
		$sql="SELECT COUNT(*) FROM ".$_sql->prebdd."diplo_shoot WHERE dpl_shoot_did = $alid";
		return $_sql->result($_sql->query($sql), 0 );
	}
	
	function get_diplo_msg($alid,$limite1, $limite2 = 0)
	{
		global $_sql;
		
		$alid = protect($alid, "uint");
		$limite1 = protect($limite1, "uint");
		$limite2 = protect($limite2, "uint");
	
		$sql="SELECT mbr_mid, dpl_shoot_msgid, dpl_shoot_mid, dpl_shoot_texte,mbr_pseudo,mbr_sign,_DATE_FORMAT(dpl_shoot_date) as dpl_shoot_date_formated,
			DATE_FORMAT(dpl_shoot_date,'%a, %d %b %Y %T') as dpl_shoot_date_rss";
		$sql.=" FROM ".$_sql->prebdd."diplo_shoot ";
		$sql.=" JOIN ".$_sql->prebdd."mbr ON mbr_mid = dpl_shoot_mid ";
		$sql.=" WHERE dpl_shoot_did = '$alid' ";
		$sql.=" ORDER BY dpl_shoot_date DESC";
	
		if($limite2) 
			$sql.=" LIMIT $limite2,$limite1"; 
		else
			$sql.=" LIMIT $limite1";

		return $_sql->make_array($sql);
	}
	
	function add_diplo_msg($alid,$text,$mid)
	{
		global $_sql;
		
		$alid = protect($alid, "uint");
		$mid = protect($mid, "uint");
		$text = protect($text, "bbcode");
	
		$sql="INSERT INTO ".$_sql->prebdd."diplo_shoot VALUES ('','$mid','$alid',NOW(),'$text')";
		return $_sql->query($sql);
	}
	
	function del_diplo_msg($alid,$msgid,$mid,$chef = false)
	{
		global $_sql;
	
		$alid = protect($alid, "uint");
		$msgid = protect($msgid, "uint");
		$mid = protect($mid, "uint");
		$chef = protect($chef, "bool");
	
		$sql="DELETE FROM ".$_sql->prebdd."diplo_shoot WHERE dpl_shoot_msgid=$msgid AND dpl_shoot_did=$alid";
		if(!$chef) $sql.=" AND dpl_shoot_mid=$mid";
	
		$_sql->query($sql);
		return $_sql->affected_rows(); 

	}
?>
