<?php
/*
 * un recordset php
 * table : le nom de la table
 * pk : le(s) champ(s) clé primaire
 * prefix : deviner le préfixe de colonne
 * gère les états C (nouveau) D (delete) U (update) pour répercussion sur chaque champ sauf id
 *
 * constructeur : un mysqli_result
 */
class row {

	/* pas public mais vu par les classes filles */
	protected $table; // nom de la table
	protected $num_rows;
	protected $datas; // tableau associatif

	private $fields = array(); // nom des colonnes avec préfixe
	private $types = array(); // type SQL des colonnes
	private $pk = array(); // clé primaire
	private $prefix = false; // préfixe des colonnes
	private $state = array();
	private $multi = false; // requete multi-tables?


	public function __construct($result)
	{
		// ectraire les meta-data des colonnes
		while ($finfo = $result->fetch_field()) {
			if(!isset($this->table))
				$this->table = $finfo->table;
			else if($this->table != $finfo->table)
				$this->multi = true;

			$this->fields[] = $finfo->name;
			$this->types[$finfo->name] = $finfo->type;
			// pk ?
			if($finfo->flags & 2)
				$this->pk[] = $finfo->name;
			// prefix
			if(!$this->prefix) {
				$tmp = explode('_', $finfo->name);
				$this->prefix = $tmp[0];
			}
		}
		// data
		$this->num_rows = $result->num_rows;
		if($result->num_rows == 1)
			$this->datas = $result->fetch_assoc();
		else
			$this->datas = $result->fetch_all(MYSQLI_ASSOC);
	}

	public function __destruct()
	{
		if(!$this->multi && !empty($this->state))
		{ /* une modif a transmettre */

			/* clause WHERE */
			$where = array();
			foreach($this->pk as $value) /* update */
				$where[] = $value.'='.$this->datas[$value];

			if(is_array($this->state))
			{
				/* clause SET */
				$set = array();
				foreach($this->state as $key => $value)
					$set[] = $key.'='.self::echap($this->datas[$key], $this->types[$key]);
				$sql = 'UPDATE '.$this->table.' SET '.implode(', ', $set).' WHERE '.implode(' AND ', $where);

			}
			else if($this->state == 'D') /* delete */
				$sql = 'DELETE FROM '.$this->table.' WHERE '.implode(' AND ', $where);
			else if($this->state == 'N') /* insert */
				echo("<br/>INSERT pas géré. Pour ".$this->table.'-'.$this->prefix);

			/* TODO: exécuter la requête de MAJ Sql */
			if(isset($sql) && SITE_DEBUG)
				echo "<br/>$sql";
		}
	}

	/* méthodes set & get */
	public function __set($key, $value)
	{
		$prefkey = $this->prefix.'_'.$key;
		/* pk en lecture seulement ET requete simple */
		if(!$this->multi && !in_array($key, $this->pk) && !in_array($prefkey, $this->pk))
		{
			if(isset($this->fields[$key]))
			{
				$this->datas[$key] = $value;
				if(is_array($this->state))
					$this->state[$key] = 'U'; /* MAJ du champ */
			}
			else if(isset($this->fields[$prefkey]))
			{
				$this->datas[$prefkey] = $value;
				if(is_array($this->state))
					$this->state[$prefkey] = 'U'; /* MAJ du champ */
			}
			else if(SITE_DEBUG)
			{ /* notice debug */
				echo("<br/>SET $key='$value' pour ".$this->table.'-'.$this->prefix);
			}
		}
	}

	public function __get($key)
	{
		$prefkey = $this->prefix.'_'.$key;
		if(isset($this->fields[$key]))
			return $datas[$key];
		else if(isset($this->fields[$prefkey]))
			return $datas[$prefkey];
		else if(SITE_DEBUG) /* notice debug */
			echo("<br/>GET $key pour ".$this->table.'-'.$this->prefix);
		return null;

	}

	/* transforme le type sql en type php */
	function getPhpType($sqlType)
	{
		/* numerics
		-------------
		BIT: 16
		TINYINT: 1
		BOOL: 1
		SMALLINT: 2
		MEDIUMINT: 9
		INTEGER: 3
		BIGINT: 8
		SERIAL: 8
		FLOAT: 4
		DOUBLE: 5
		DECIMAL: 246
		NUMERIC: 246
		FIXED: 246
		*/
		if($sqlType == 1 || $sqlType == 16)
			return 'bool';
		else if(in_array($sqlType, array(2,3,8,9)))
			return 'int';
		else if(in_array($sqlType, array(4,5,246)))
			return 'float';
		/*
		dates
		------------
		DATE: 10
		DATETIME: 12
		TIMESTAMP: 7
		TIME: 11
		YEAR: 13

		strings & binary
		------------
		CHAR: 254
		VARCHAR: 253
		ENUM: 254
		SET: 254
		BINARY: 254
		VARBINARY: 253
		TINYBLOB: 252
		BLOB: 252
		MEDIUMBLOB: 252
		TINYTEXT: 252
		TEXT: 252
		MEDIUMTEXT: 252
		LONGTEXT: 252
		*/
		else
			return 'string';
	}

	/* echapper les strings et proteger */
	function echap($value, $sqlType) {
		$phpType = self::getPhpType($sqlType);
		if($phpType == 'string')
			return '\''.protect($value, $phpType).'\'';
		else
			return protect($value, $phpType);
	}

}
?>
