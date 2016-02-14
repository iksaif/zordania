<?
class histo
{
	var $sql;
	var $histos;
	
	function histo(&$sql)
	{
		$this->sql = &$sql;
	}
	
	function add($mid, $mid2, $type, $vars, $flush = false)
	{
		$mid = (int) $mid;
		$mid2 = (int) $mid2;
		$type = (int) $type;
		$flush = (bool) $flush;
		
		//ajouter une verification pour le type
		if(!is_array($vars)) return false;
		
		$this->histos[$mid][] = array(
				  	'mid2'=> $mid2,
				  	'type'=> $type,
				  	'vars'=> $vars);

		if($flush) return $this->flush($mid);
		else return true;
	}
	
	function flush($mid = 0)
	{
		$mid = (int) $mid;

		$sql="INSERT INTO ".$this->sql->prebdd."histo VALUES ";
		if($mid)  
		{
			if(!is_array($this->histos[$mid])) return true;
			
			foreach($this->histos[$mid] as $value)
			{
				$sql.="('',NOW(),'$mid','".$value['mid2']."','".$value['type']."'";
				foreach($value['vars'] as $value)
					$sql.=",'$value'";
				$sql.="),";
			}
				
		}
		else
		{
			if(!is_array($this->histos)) return true;
			
			foreach($this->histos as $mid => $mid_array)
			{
				foreach($mid_array as $value)
				{
					$sql.="('',NOW(),'$mid','".$value['mid2']."','".$value['type']."'";
					foreach($value['vars'] as $value)
						$sql.=",'$value'";
					$sql.="),";
				}
			}
		}

		$sql = str_replace(", ","",$sql." ");
		return $this->sql->query($sql);
	}
	
	function get_infos($mid,$limite1 = 0,$limite2 = 0)
	{
		$mid = (int) $mid;
		$limite1 = (int) $limite1;
		$limite2 = (int) $limite2;
		
		$sql="SELECT histo_hid,histo_mid2,mbr_pseudo,mbr_gid,histo_type,histo_var1,histo_var2,histo_var3,histo_var4,";
		$sql.="UNIX_TIMESTAMP(histo_date + INTERVAL '".$this->sql->decal."' HOUR_SECOND) as histo_date,";
		$sql.="formatdate(histo_date) as histo_date_formated,";
		$sql.="DATE_FORMAT(histo_date,'%Y-%m-%dT%H:%i:%s') as histo_date_rss";
		$sql.=" FROM ".$this->sql->prebdd."histo LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = histo_mid2 ";
		$sql.=" WHERE histo_mid = $mid ";
		$sql.=" ORDER BY histo_date DESC";
		if($limite2) $sql.=" LIMIT $limite2,$limite1 "; 
		elseif($limite1) $sql.=" LIMIT $limite1 ";
		
		return $this->sql->make_array($sql);
	}
	
	function calc_key($mid,$pseudo,$pass)
	{
		$mid = (int) $mid;

		$int = (string) $mid*strlen($pseudo)*123456789;
		$intmd5 = md5($int);
		return substr_replace($pass, $intmd5, 0, strlen($int));
	}
	
	function del_old($time, $mid = 0)
	{
		$mid = (int) $mid;
		$time= (int) $time; //temps en jours
		
		$sql="DELETE FROM ".$this->sql->prebdd."histo WHERE histo_date < (NOW() - INTERVAL $time DAY)";
		if($mid) $sql.=" AND histo_mid = $mid";
		
		return $this->sql->query($sql);
	}
}
?>