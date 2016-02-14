<?
class msg
{
	var $sql,$flood_time;
	
	function msg($sql)
	{
		$this->sql = &$sql;
		$this->flood_time = SITE_FLOOD_TIME;
	}

	function get_msg($mid,$msgid = -1, $to_mid = true)
	{
		$msgid = (int) $msgid;
		$mid 	= (int) $mid;
		$to_mid = (bool) $to_mid;
		
		$req .="SELECT msg_titre,msg_msgid,msg_mid,msg_mid2,msg_not_readed,";
		$req .="formatdate(msg_date) as msg_date_formated,";
		$req .="mbr_pseudo,mbr_gid";
		if($msgid >= 0)
			$req.=",msg_texte";
		$req .=" FROM ".$this->sql->prebdd."msg LEFT JOIN ";
		$req .= $this->sql->prebdd."mbr ON ";
		
		if($to_mid)
			$req.="mbr_mid = msg_mid ";
		else
			$req.="mbr_mid = msg_mid2 ";
		
		if($to_mid)
			$req .=" WHERE (msg_mid2 = '$mid' OR msg_mid2 = 0) ";
		else
			$req .=" WHERE (msg_mid = '$mid' OR msg_mid2 = 0) ";
		
		if ($msgid >=0)
			$req .= " AND msg_msgid='$msgid' ";
		$req .= "GROUP BY msg_msgid ";
		if ($msgid == -1)
		{
			$req .= "ORDER BY ";
			$req .= "msg_date DESC ";
		}
		return $this->sql->make_array($req);
	}
	
	function new_msg($mid, $mid2, $titre, $text, $antiflood = true)
	{
		$mid = (int) $mid;
		$mid2 = (int) $mid2;
		$titre = htmlentities($titre, ENT_QUOTES);
		$text = parser::parse($text);
		$antiflood = (bool) $antiflood;
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."msg WHERE msg_mid = '$mid' AND msg_date > (NOW() - INTERVAL ".$this->flood_time." SECOND)";
		if(@mysql_result($this->sql->query($sql), 0) >= 1 AND $antiflood)
		{
			return 2;
		}
		$sql="INSERT INTO ".$this->sql->prebdd."msg VALUES ('','$mid','$mid2',NOW(),'$titre','$text',1)";
		return $this->sql->query($sql);
	}
	
	function delete_msg($mid,$msgid = 0)
	{
		$mid = (int) $mid;
		$msgid = (int) $msgid;
		
		$sql="DELETE FROM ".$this->sql->prebdd."msg WHERE msg_mid2 = '$mid'";
		if($msgid)
		{
			$sql.=" AND msg_msgid = '$msgid'";
		}
		$this->sql->query($sql);
		return mysql_affected_rows();
	}
	
	function mark_as_readed($mid,$msgid)
	{
		$mid = (int) $mid;
		$msgid = (int) $msgid;
		
		$sql="UPDATE ".$this->sql->prebdd."msg SET msg_not_readed = 0 WHERE msg_msgid = $msgid AND msg_mid2 = $mid";
		$this->sql->query($sql);
		return mysql_affected_rows();
	}
}
?>
