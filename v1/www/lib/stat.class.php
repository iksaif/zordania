<?
class stats
{
	var $sql;
	function stats(&$sql)
	{
		$this->sql = &$sql;	
	}
	
	function get_infos($date1, $date2 = false)
	{	
		$date1 = htmlentities($date1, ENT_QUOTES);
		$date2 = htmlentities($date2, ENT_QUOTES);
		
		$sql="SELECT ";
		$sql.="stq_mbr_act,stq_mbr_inac,stq_mbr_con,stq_unt_tot,stq_btc_tot,stq_unt_avg,stq_btc_avg,stq_res_avg,stq_src_avg ";
		$sql.="FROM ".$this->sql->prebdd."stq ";
		$sql.="WHERE stq_date LIKE '$date1%' ";
		if($date2) $sql.="OR stq_date LIKE '$date2%' ORDER BY stq_date DESC";
		return $this->sql->make_array($sql);
	}
}
?>