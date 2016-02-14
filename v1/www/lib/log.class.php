<?
class log
{
	var $time_format;
	var $file;
	var $fp;
	var $dir;
	
	function log()
	{
		$this->time_format 	= "H:i:s d/m/Y";
		$this->file		= "log.log";	
	}
	
	function getmicrotime() //retourne le time actuel en microsecondes
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}
	
	function set_file($file)
	{
		$this->file = $file;
	}
	
	function set_time_format($time_format)
	{
		$this->time_format = $time_format;
	} 
	
	function open($file = false)
	{
		$file = $file ? $file : $this->file;
		$this->fp = fopen($file,"a+");
		$this->text("Ouverture du fichier log");
		return $this->fp;
	}
	
	function text($text)
	{
		$text = date($this->time_format)." - ".$text."\n";
		fwrite($this->fp, $text);
	}
	
	function close($fp = false)
	{
		$fp = $fp ? $fp : $this->fp;
		$this->text("Fermeture du fichier log");
		$this->text("_____________________________________________");
		return fclose($fp);
	}
	
	function set_dir($dir)
	{
		$this->dir = $dir;
	}
	
	function get_file($file)
	{
		$file = str_replace('..','.',$file);

		if(!file_exists($this->dir.$file))
		{
			return false;
		}
		
		if(filesize($this->dir.$file) == 0)
		{
			return "Empty/Vide";
		}
		
		$fp = fopen($this->dir.$file,'r');
		$contenu = fread($fp,filesize($this->dir.$file));
		$contenu = nl2br(htmlentities($contenu, ENT_QUOTES));
		fclose($fp);
		
		return $contenu;
	}
	
	function list_dir($dir)
	{
 		$files = array();
		$dir = str_replace('..','.',$dir);
		
 		if(!is_dir($this->dir.$dir))
 		{
 			return false;
 		}
 		elseif ($handle = opendir($this->dir.$dir)) 
		{
 		  while (false !== ($file = readdir($handle))) {
 		  	
 		  	if(!strstr($file,'.'))
 		  	{
 		  		$ext = "dir";
 		  	}
 		  	else
 		  	{
 		  		$ext = end(explode(".",$file));
 		  	}
 		     	if ($ext == "log" && $file != "." && $file != ".." && filesize($this->dir.$dir.$file) > 0) {
 		     		$files[] = array('name' => $file,
 		     				'date' => date ("F d Y H:i:s.", filemtime($this->dir.$dir.$file)),
 		     				'size' => filesize($this->dir.$dir.$file),
 		     				'ext'	=> $ext,
 		     				);
 		     		
 		     	}
		   }

		   return $files;
		}
		else
		{
			return false;
		}
	}
}
?>