<?php
class tplmore
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
				$ext = explode(".",$file);
 		  		$ext = end($ext);
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
			$html = $this->colorizeHTML($contenu);
			$contenu = str_replace('&nbsp;','[espace]',utf8_decode($contenu));
			//$contenu = str_replace('&nbsp;','[espace]',$contenu);
			$final_text = htmlentities($contenu, ENT_QUOTES);
			fclose($fp);
		
			return array('name' => $file,
 		     		'date' => date ("F d Y H:i:s.", filemtime($this->dir.$file)),
 		     		'size' => filesize($this->dir.$file),
 		     		'text' => $final_text,
				'html' => $html
 		     	);
		}
	}
	
	/* fonction colorisation du code template */
	function colorizeHTML($src)
	{
		$patterns = array(
		'#=(["|\'])([^"|\']*)(["|\'])#Smi', // attributes & values
		'#<!--([^-]+)-->#Smi', // comments
		'#<([^\s^>]+)(.*?)>#Smi' // tags
		);
		$replaces = array(
		'[span class="html-schar"]=\\1[/span][span class="html-attribut"]\\2[/span][span class="html-schar"]\\3[/span]',
		'[span class="html-cmt"]&lt;!--\\1--&gt;[/span]',
		'[span class="html-tag"]&lt;[b]\\1[/b]\\2&gt;[/span]'
		);
		$src = preg_replace($patterns, $replaces, $src);
		$src = str_replace('[', '<', $src);
		$src = str_replace(']', '>', $src);
		return '<span class="html-norm">'.nl2br($src).'</span>';
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
			if(!$fp = fopen($this->dir.$file,"w+"))
				return false;
			$contenu = html_entity_decode($contenu, ENT_QUOTES);
			$contenu = str_replace('[espace]','&nbsp;',$contenu);
			fputs($fp,$contenu);
			fclose($fp);
			return true;
		}
	}
}
?>
