<?php
class bonus
{
	var $auth = "";
	var $timeout = 30;
	var $errno;
	var $errstr;
	var $sql;
	
	function bonus(&$sql)
	{
		$this->sql = &$sql;
	}
	
	function verifier($recall, $auth, $mid, $type, $nb)
	{
		// $RECALL contient le code d'accès
		$recall = trim(urlencode($recall)); 
		$auth = urlencode($auth);
		$type = protect($type, "uint");
		$nb = protect($nb, "uint");
	
		
		if($this->verify_in_log($mid, $recall))
		{
			$this->log($mid,$recall,"INBDD",$type,$nb);
			return false;	
		}
		elseif ($fp = fsockopen('www.allopass.com', 80, $this->errno, $this->errstr, $this->timeout))
		{
			$url = 'check/vf.php4?CODE='.$recall.'&AUTH='.$auth;
			
			$request = "GET /".$url." HTTP/1.1\n";
			$request.= "Host: www.allopass.com\n";
			$request.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20040911 Firefox/0.10\n";
			$request.= "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png;q=0.5\n";
			$request.= "Accept-Language: fr-fr,fr;q=0.5\n";
			$request.= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\n";
			$request.= "Keep-Alive: 300\n";
			$request.= "Connection: keep-alive\n\n";

			fputs($fp, $request);
			$alltext = "";
			while ($line = fgets($fp, 1024))
			{
				$alltext .= $line;
			}
			fclose($fp);
		}
		else
		{
			$this->log($mid,$recall,"CONERROR",$type,$nb);
			return false;
		}

		//echo $request."--".$alltext;
		$rep = explode("\r\n\r\n",$alltext);
		if (strstr($alltext,"ERR") || strstr($alltext,"NOK")) {
			// Le serveur a répondu ERR ou NOK : l'accès est donc refusé
			$this->log($mid,$recall,$rep[1],$type,$nb);
			return false;
		}
		else
		{
			$this->log($mid,$recall,$rep[1],$type,$nb);
			return true;
		}
			
	}
	
	function verify_in_log($mid, $recall)
	{
		$mid = protect($mid, "uint");
		$recall = protect($recall, "string");
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."bon WHERE `bon_ok` LIKE '%OK%' AND `bon_ok` NOT LIKE '%NOK%' AND bon_code='$recall' AND bon_date > (NOW() - INTERVAL 1 DAY)";
		return mysql_result($this->sql->query($sql), 0);
	}
	
	function log($mid, $recall, $ok, $type, $nb)
	{
		$mid = protect($mid, "uint");
		$ok  = protect($ok, "string");
		$type = protect($type, "uint");
		$nb = protect($nb, "uint");
		
		$sql="INSERT INTO ".$this->sql->prebdd."bon VALUES ('','$mid',NOW(),'$recall','$ok','$type','$nb')";
		return $this->sql->query($sql);
	}
	
	function get_log()
	{
		$req = "SELECT mbr_pseudo,mbr_race,bon_mid,bon_code,bon_ok,bon_res_type,bon_res_nb,_DATE_FORMAT(bon_date) as bon_date,_DATE_FORMAT(bon_date) as bon_date_formated ";
		$req.= "FROM ".$this->sql->prebdd."bon ";
		$req.= "LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = bon_mid ";
		$req.= "ORDER BY bon_date DESC";
		return $this->sql->make_array($req);
	}
}
?>