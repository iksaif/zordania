<?php
class mysql
{
	var $prebdd = '';
	var $errno = 0;
	var $err = '';
	var $dateformat = '%d-%m-%y à %H:%i:%s'; /* Mettre ça dans les tpl */
	var $decal = '00:00:00';
	var $nbreq;
	var $con;
	var $total_time;
	var $debug;
	var $queries;
	var $env = ''; // environnement ajouté pour le log ($act et $file)
	var $log = false; // objet log.class.php

	function __construct($host,$login,$pass,$base) //se connecte a mysql a la creation de classe
	{
		$debut = $this->getmicrotime();

		$this->nbreq = 0;
		$this->con = mysql_connect($host,$login,$pass);
		if($this->con)
			mysql_select_db($base, $this->con);

		$this->total_time = $this->getmicrotime() - $debut;
		mysql_set_charset(MYSQL_CHARSET, $this->con);
		return $this->con;
	}
	function __destruct() {
		if($this->log !== false) $this->log->close();
	}
	function set_debug($debug)
	{
		$this->debug = $debug;
	}
	
	function set_dbdecal($var)
	{
		$this->decal = $var;
	}
	
	function set_prebdd($var)
	{
		$this->prebdd = $var;
	}
	
	function getmicrotime() 
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	function parse_query($req) 
	{
		/* le DATE_FORMAT c'était long a écrire */
		if($this->decal != '00:00:00'){
			$req = preg_replace("/_UDATE_FORMAT\((.*?)\)/i","DATE_FORMAT(FROM_UNIXTIME($1) + INTERVAL '".$this->decal."' HOUR_SECOND,'".$this->dateformat."')",$req);
			$req = preg_replace("/_DATE_FORMAT\((.*?)\)/i","DATE_FORMAT($1 + INTERVAL '".$this->decal."' HOUR_SECOND,'".$this->dateformat."')",$req);
		}else{
			$req = preg_replace("/_UDATE_FORMAT\((.*?)\)/i","FROM_UNIXTIME($1,'".$this->dateformat."')",$req);
			$req = preg_replace("/_DATE_FORMAT\((.*?)\)/i","DATE_FORMAT($1,'".$this->dateformat."')",$req);
		}
		return $req;
	}
	
	/* Fonctions MySQL */
	function errno() {
		return mysql_errno($this->con);
	}
	
	function error() {
		return mysql_error($this->con);
	}
	
	function insert_id() {
		return mysql_insert_id($this->con);
	}

	function affected_rows() {
		return mysql_affected_rows($this->con);
	}
	
	function result($res, $row, $field = NULL) {
		if($field)
			return mysql_result($res, $row, $field);
		else
			return mysql_result($res, $row);
	}

	function num_rows($res) {
		if($res!==false) return mysql_num_rows($res);
		else return 0;
	}
	
	/* Requetes */
	function query($req, $explain = true) //envoie une requete a mysql
	{
		$debut = $this->getmicrotime();
		
		$req = $this->parse_query($req);

		//if ($explain) $this->log(count($this->queries)." | $req\n");
		$res = mysql_query($req, $this->con);
		$this->errno = mysql_errno();
		$this->err = mysql_error();
		
		if($this->errno)  $this->log_error($req);
		
		if($explain) $this->nbreq++;
		
		if($this->debug AND $explain)
		{
			if(stripos($req,'SELECT') !== false AND is_resource($res))
				$num = mysql_num_rows($res);
			else
				$num = 0;

			$this->queries[$this->nbreq] = array('req' => $req,
								'errno'=>$this->errno,
								'err'	=> $this->err,
								'time'=> $this->getmicrotime()-$debut,
								'infos' => mysql_info(),
								'num' => $num
								);

			if(strstr($req,'SELECT') && !strstr($req,'EXPLAIN') && !strstr($req,'INSERT') && !strstr($req,'UPDATE') && !strstr($req,'DELETE'))
			{
				$exp = $this->make_array('EXPLAIN '.$req, false);
				$this->queries[$this->nbreq]['explain'] = $exp;
			}
		}
		if($explain) $this->total_time += $this->getmicrotime()-$debut;
		
		return $res;
	}
	
	function free_result($res) {
		return mysql_free_result($res);
	}
	
	function log_error($req)
	{
		$text = '**** '.date("H:i:s d/m/Y").' '.$this->env." ***\n";
		$text .= $this->errno." | ".$this->err."\n";
		$text .= $this->errno." | ".$req."\n\n";
		echo "$text";
		$this->log($text);
	}

	function log($text) {
		if($this->log === false)
			$this->log = new log(SITE_DIR."logs/mysql/mysql_".date("d_m_Y").".log", false, false);
		$this->log->text($text);
	}

	function make_array_result($req) {// retourne la 1ère ligne du résultat de la requête
		$array = $this->make_array($req);
		return $array ? $array[0] : array();
	}
	
	function make_array($req, $explain = true) //retourne un tableau correspondant a un select sous la forme numero de ligne, puis nom de champ
	{
		$var = array();
		$res = $this->query($req, $explain);
		if(!$res)
			return array();

		while ($row = mysql_fetch_assoc($res)) {
			$var[] = $row;
		}
		$this->free_result($res);
		return $var;
	}

	function index_array($req, $idx = false, $explain = true) //retourne le resultat de la requete sous la forme d'un tableau indexe sur le champ idx
	{
		$var = array();
		$res = $this->query($req, $explain);
		if(!$res)
			return array();

		if ($idx === false)
			while ($row = mysql_fetch_assoc($res))
				$var[] = $row;
		else
			while ($row = mysql_fetch_assoc($res))
				$var[$row[$idx]] = $row;

		$this->free_result($res);
		return $var;
	}

	function escape($str)
	{
		return mysql_real_escape_string($str, $this->con);
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
