<?
class mysql
{
var $prebdd = 'zrd_';
var $errno = 0;
var $err = '';
var $dateformat = '%d-%m-%y à %H:%i:%s';//'%y-%m-%d %H:%i:%s';
var $decal = '00:00:00';
var $nbreq;
var $con;
var $total_time;
var $queries;
	
	function mysql($host,$login,$pass,$base) //se connecte a mysql a la creation de classe
	{
	$this->nbreq = 0;
	$this->con = @mysql_connect($host,$login,$pass);
	if($this->con) mysql_select_db($base, $this->con);
	mysql_query("SET NAMES 'latin1';");
	return $this->con;
	}
	
	function set_dbdecal($var)
	{
	$this->decal = $var;	
	}
	
	function set_prebdd($var)
	{
	$this->prebdd = $var;	
	}
	
	function query($req,$count=true) //envoie une requete a mysql
	{
		if(SITE_DEBUG AND $count)
			$debut = divers::getmicrotime();
			
		$req = preg_replace("/formatdate\((.*?)\)/i","DATE_FORMAT($1 + INTERVAL '".$this->decal."' HOUR_SECOND,'".$this->dateformat."')",$req);
		
		$res = mysql_query($req, $this->con);
		$this->errno = mysql_errno();
		$this->err = mysql_error();
		
		if($this->errno)
		{
			$this->log_error($req);
		}
		

		//echo $req;
		if($count) $this->nbreq++;
		
		if(SITE_DEBUG AND $count)
		{
				$this->queries[$this->nbreq] = array('req' => $req,
									'errno'=>$this->errno,
									'err'	=> $this->err,
									'time'=> divers::getmicrotime()-$debut,
									'infos' => mysql_info(),
									'num' => @mysql_num_rows($res),
									);
				
				if(strstr($req,'SELECT') AND !strstr($req,'EXPLAIN'))
				{
					$explain = $this->make_array('EXPLAIN '.$req,false);
					$this->queries[$this->nbreq]['explain'] = $explain[0];
				}

				$this->total_time += divers::getmicrotime()-$debut;
		}
		
	return $res;
	}
	
	function log_error($req)
	{
		$text = date("H:i:s d/m/Y")." - ".$this->errno." | ".$this->err."\n";
		$text .= date("H:i:s d/m/Y")." - ".$this->errno." | ".$req."\n";
		$text .= "\n";
				divers::log_error(SITE_DIR."logs/mysql.log",$text);
	}
	
	function make_array($req,$count=true) //retourne un tableau correspondant a un select sous la forme numero de ligne, puis nom de champ
	{
	$var = array();
	$res = $this->query($req,$count);
		while ($row = mysql_fetch_assoc($res))
		{
		$var[] = $row;
		}
	return $var;
	}
	
	function close()
	{
		if($this->con)
		return mysql_close($this->con);
		else
		return false;
	}

}

?>