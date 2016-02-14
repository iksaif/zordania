<?
class TemplatesGest
{
	var $dir,$ext_ok;
	
	function set_dir($dir)
	{
		$this->dir = $dir;
		$this->ext_ok = array('tpl','php','dir','config');
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
 		     	if ($file != "." && $file != ".." && in_array($ext,$this->ext_ok)) {
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
	
	function get_infos($file)
	{
		$file = str_replace('..','.',$file);
		
		if(!file_exists($this->dir.$file))
		{
			return false;
		}
		else
		{
			$fp = fopen($this->dir.$file,'r');
			$contenu = fread($fp,filesize($this->dir.$file));
			$contenu = str_replace('&nbsp;','[espace]',$contenu);
			$final_text = htmlentities($contenu, ENT_QUOTES);
			fclose($fp);
		
			return array('name' => $file,
 		     		'date' => date ("F d Y H:i:s.", filemtime($this->dir.$dir.$file)),
 		     		'size' => filesize($this->dir.$dir.$file),
 		     		'text' => $final_text,
 		     	);
		}
	}
	
	function save_tpl($file,$contenu)
	{
		$file = str_replace('..','.',$file);
		
		if(!file_exists($this->dir.$file))
		{
			return false;
		}
		else
		{
			$fp = fopen($this->dir.$file,"w+");
			$contenu = html_entity_decode($contenu, ENT_QUOTES);
			$contenu = str_replace('[espace]','&nbsp;',$contenu);
			fputs($fp,$contenu);
			fclose($fp);
			return true;
		}
	}
}
?>