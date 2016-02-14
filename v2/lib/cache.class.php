<?php

class cache {

	private $contenu; // cache
	private $save;
	private $name;
	private $file;

	/* constructeur */
	function __construct($cache, $save = false) {
		if($cache!='global' && $cache != 'admin' && $cache != 'words')
			die("erreur cache=$cache: inconnu");

		$this->file = SITE_DIR . "cache/$cache.cache.php";
		include_once($this->file);
		if($cache == 'global') $this->name = '_cache'; else $this->name = '_'.$cache;
		$this->contenu = ${$this->name};

		/* enregistrer ou pas à la fermeture? */
		$this->save = $save;
	}

	function __destruct(){ /* enregistre le fichier ? */
		if($this->save) $this->cache();
	}

	/* méthodes set & get */
	function __set($key, $value) {
		if(isset($this->contenu[$key]))
			$this->contenu[$key] = $value;
		else echo "classe 'cache({$this->name})'->$key = $value\n";
	}

	function __get($key) {
		if(isset($this->contenu[$key])) return $this->contenu[$key];
		else { echo "GET classe 'cache({$this->name})'->$key\n"; return false; }
	}

	function get_array(){
		return $this->contenu;
	}

	function force_save($save=true){
		$this->save = $save;
	}

	function cache(){ /* enregistre le fichier */
		$fp = fopen($this->file, "w");

		$txt = '<?php $'.$this->name.' = ';
		$txt .=  var_export($this->contenu, true);
		$txt .= '; ?>';

		fwrite($fp, $txt);
		fclose($fp);
	}

}

?>
