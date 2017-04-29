<?php
/*
 * classe équivalent de mysql.class.php
 * utilise mysqli au lieu de mysql qui est obsolete
 */
class mysqliext
{

	/* statique : la connexion active */
	public static $bdd = false;
	private static $initialized = false;


	var $prebdd = '';
	var $errno = 0;
	var $err = '';
	var $dateformat = '%d-%m-%y à %H:%i:%s'; /* Mettre ça dans les tpl */
	var $decal = '00:00:00';
	var $nbreq;
	var $con = false;
	var $total_time;
	var $debug;
	var $queries;
	var $env = ''; // environnement ajouté pour le log ($act et $file)
	var $log = false; // objet log.class.php
	var $mysqli;

	function __construct($host,$login,$pass,$base) //se connecte a mysql a la creation de classe
	{
		$debut = $this->getmicrotime();

		$this->nbreq = 0;
		$this->mysqli = new mysqli($host,$login,$pass, $base);

		// Fonctionne depuis PHP 5.2.9 et 5.3.0.
		if ($this->mysqli->connect_error) {
			echo('Erreur de connexion : ' . $this->mysqli->connect_error);
		} else
			$this->con = true;
		if (!$this->mysqli->set_charset("utf8")) {
		    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $this->mysqli->error);
		}

		$this->total_time = $this->getmicrotime() - $debut;

		if(!self::$initialized){
			// seule la 1ere connexion bdd est mise en statique
			self::$bdd = $this;
			self::$initialized = true;
		}
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
		return $this->mysqli->errno;
	}
	
	function error() {
		return $this->mysqli->error;
	}
	
	function insert_id() {
		return $this->mysqli->insert_id;
	}

	function affected_rows() {
		return $this->mysqli->affected_rows;
	}
	
	function result($res, $row, $field = NULL) {
		if (!$res->data_seek($row))
			return false;
		if(!$result = $res->fetch_assoc())
			return false;
		if($field && isset($result[$field]))
			return $result[$field];
		else
			return $result;
	}

	function num_rows($res = false) {
		if($res!==false) return $res->num_rows;
		else return 0;
	}
	
	/* Requetes */
	function query($req, $explain = true) //envoie une requete a mysql
	{
		$debut = $this->getmicrotime();
		
		$req = $this->parse_query($req);

		if ($explain) $this->log(count($this->queries)." | $req\n");
		$res = $this->mysqli->query($req);
		$this->errno = $this->mysqli->errno;
		$this->err = $this->mysqli->error;
		
		if($this->errno)  $this->log_error($req);

		if($explain) $this->nbreq++;
		
		if($this->debug AND $explain)
		{
			if(stripos($req,'SELECT') !== false AND is_resource($res))
				$num = $res->num_rows;
			else
				$num = 0;

			$this->queries[$this->nbreq] = array('req' => $req,
								'errno'=>$this->errno,
								'err'	=> $this->err,
								'time'=> $this->getmicrotime()-$debut,
								'infos' => $this->mysqli->info,
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
		$res->free();
	}
	
	function log_error($req)
	{
		$text = '**** '.date("H:i:s d/m/Y").' '.$this->env." ***\n";
		$text .= $this->errno." | ".$this->err."\n";
		$text .= $this->errno." | ".$req."\n\n";
		$this->log($text);
		if($this->debug)
			$this->log("CALLSTACK:\n".implode("\n", callstack()));
	}

	function log($text) {
		if($this->log === false)
			$this->log = new log(SITE_DIR."logs/mysql/mysqli_".date("d_m_Y").".log", false, false);
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
		while ($row =  $res->fetch_assoc())
			$var[] = $row;
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
			while ($row =  $res->fetch_assoc())
				$var[] = $row;
		else
			while ($row =  $res->fetch_assoc())
				$var[$row[$idx]] = $row;

		$this->free_result($res);
		return $var;
	}

	function close()
	{
		if($this->con)
			return $this->mysqli->close();
		else
			return false;
	}

}

?>
