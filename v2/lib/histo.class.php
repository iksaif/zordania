<?php
/* Historique */
define('HISTO_HRO_CP',1);
define('HISTO_COM_ACH',11);
define('HISTO_BTC_OK',21);
define('HISTO_BTC_REP',22);
define('HISTO_BTC_BRU',23);
define('HISTO_SRC_DONE',31);
define('HISTO_LEG_ARV', 41);
define('HISTO_LEG_ATQ_VLG', 42);
define('HISTO_LEG_ATQ_LEG', 43);
define('HISTO_LEG_VIDE_BACK', 44);
define('HISTO_LEG_IDLE', 45);
define('HISTO_MSG_NEW',51);
define('HISTO_UNT_BOUFF',61);
define('HISTO_PARRAIN_BONUS',71);

class histo
{
	var $sql;
	var $histos = array();
	
	function __construct(&$sql)
	{
		$this->sql = &$sql;
	}
	
	function add($mid, $mid2, $type, $vars = array(), $flush = false)
	{
		$mid = protect($mid, "uint");
		$mid2 = protect($mid2, "uint");
		$type = protect($type, "uint");
		$vars = protect($vars, "array");
		$flush = protect($flush, "bool");
		
		$this->histos[$mid][] = array('mid2'=> $mid2,'type'=> $type,'vars'=> $vars);

		if($flush) 
			return $this->flush();
		else 
			return;
	}
	
	function __destruct()
	{
		if(empty($this->histos)) return;
		
		$sql="INSERT INTO ".$this->sql->prebdd."histo VALUES ";
		
		foreach($this->histos as $mid => $mid_array) {
			foreach($mid_array as $value) {
				$vars = protect($value['vars'], "serialize");
				$sql.="('',NOW(),'$mid','".$value['mid2']."','".$value['type']."', '$vars'),";
			}
		}
		
		$this->histos = array();
		$sql = substr($sql, 0, strlen($sql) - 1);
		return $this->sql->query($sql);
	}
}

function get_histo($mid,$limite1 = 0,$limite2 = 0)
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$limite1 = protect($limite1, "uint");
	$limite2 = protect($limite2, "uint");
	
	$sql="SELECT histo_hid,histo_mid2,mbr_pseudo,mbr_gid,histo_type,histo_vars,";
	$sql.="UNIX_TIMESTAMP(histo_date + INTERVAL '".$_sql->decal."' HOUR_SECOND) as histo_date,";
	$sql.="_DATE_FORMAT(histo_date) as histo_date_formated,";
	$sql.="DATE_FORMAT(histo_date,'%Y-%m-%dT%H:%i:%s') as histo_date_rss";
	$sql.=" FROM ".$_sql->prebdd."histo JOIN ".$_sql->prebdd."mbr ON mbr_mid = histo_mid2 ";
	$sql.=" WHERE histo_mid = $mid ";
	$sql.=" ORDER BY histo_date DESC";
	
	if($limite2)
		$sql.=" LIMIT $limite2,$limite1 "; 
	else if($limite1)
		$sql.=" LIMIT $limite1 ";
	
	$array = $_sql->make_array($sql);
	foreach($array as $key => $result) /* Rendre ça exploitable */ 
		if($result['histo_vars']) {
			$array[$key]['histo_vars'] = safe_unserialize($result['histo_vars']);
		}
	return $array;
}

function calc_key_histo($mid, $login)
{
	$str = md5($mid . $login);
	
	return substr($str, 0, GEN_LENGHT);
}

function cls_histo($mid) {
	global $_sql;

	$sql = "DELETE FROM ".$_sql->prebdd."histo WHERE histo_mid = $mid ";
	$res = $_sql->query($sql);
	return $_sql->affected_rows();
}

function del_old_histo($time, $mid = 0)
{
	$mid = protect($mid, "uint");
	$time= protect($time, "uint");
		
	$sql="DELETE FROM ".$this->sql->prebdd."histo WHERE histo_date < (NOW() - INTERVAL $time DAY)";
		
	if($mid) 
		$sql.=" AND histo_mid = $mid";
		
	return $this->sql->query($sql);
}
?>
