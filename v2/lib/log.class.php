<?php
class log
{
	var $time_format;
	var $file;
	var $fp;
	var $dir;
	var $verbose;
	private $lock = false; // fichier qui verrouille le site, à supprimer dans le destructeur
	private $open = false; // indique si le fichier est bien ouvert

	function __construct($file = "log.log", $time = "H:i:s d/m/Y", $verbose = false, $lock = false)
	{
		$this->time_format = $time;
		$this->file = $file;	
		$this->verbose = $verbose;
		$this->lock = $lock;
		$this->open();
	}

	function __destruct() {
		if($this->open) $this->close();
		if($this->lock) unlink($this->file); // supprimer le verrou
	}
	function open()
	{
		$file = $this->file;
        // linux only: default mask if creating new log file: rw-rw-
        if(!is_file($file)) umask(0117);
		$this->fp = fopen($file,"a+");
		if ($this->verbose) $this->text("Ouverture du fichier log");
		$this->open = true;
		return $this->fp;
	}
	
	function text($text)
	{
		if ($this->time_format !== false) $text = date($this->time_format)." - ".$text."\n";
		else $text .= "\n";
		if($this->open)
			fwrite($this->fp, $text);
		if($this->verbose)
			echo basename($this->file) . ": ". $text;
	}
	
	function close($fp = false)
	{
		if(!$this->open) return false; // déjà fermé
		$fp = $fp ? $fp : $this->fp;
		if($this->verbose) {
			$this->text("Fermeture du fichier log");
			$this->text("__________________");
		}
		$this->open = false;
		return fclose($fp);
	}
	
	function set_dir($dir)
	{
		$this->dir = $dir;
	}
}
?>
