<?php
class Template
{
	function Template() //constructeur
	{
		$this->var = new stdClass();
		$this->var->tpl = new stdClass();
	$file = __FILE__;
	$pos = strrpos($file, '/');
	$this->var->tpl->dir2 = (is_integer($pos)) ? substr($file, 0, $pos + 1) : substr($file, 0, strrpos($file, '\\') + 1); //path absolu du dossier de la classe avec gestion windows puis linux
	
	$this->set_dir('templates/'); //dossier des templates
	
	$this->set_lang_method(0); //methode employee pour le multi langages
	$this->set_lang('fr'); //langue utilisee par defaut
	
	$this->var->tpl->gzip = 0;
	
	$this->search[0] = '#(.*?)(\{)(get|post|session|cookie|server|tpl|files|request|globals|env)?(?!\')([^\s]*?(?:(?:\.\')|(?:[^\'])))\}(.*)#';
	$this->search[1] = '#<(set)\s*(?:(?:\s*(?:(?:name=(\\\\\'|")(.*?)\\2)|(?:value=(\\\\\'|")(.*?)\\4)))+)\s*/>#s';
	$this->search[2] = '#((\$data \.= \')(\s*)\';)#';
	$this->search[3] = '#<(if|elseif|foreach|for) cond=(\\\\\'|")(.*?)\\2>#s';
	$this->search[4] = '#<(load)(?:(?:\s*(?:(?:file=(\\\\\'|")(.*?)\\2)|(?:cache=(\\\\\'|")(.*?)\\4)))+)\s*/>#';
	$this->search[5] = '#<(math)\s*oper\=(\\\\\'|")(.*?)\\2\s*/>#';
	$this->search[7] = '#<(printf)\s*(?:(?:\s*(?:(?:string=(\\\\\'|")(.*?)\\2)|(?:vars=(\\\\\'|")(.*?)\\4)))+)\s*/>#s';
		
	$this->search_include = '#<(include)(?:(?:\s*(?:(?:file=(\\\\\'|")(.*?)\\2)|(?:type=(\\\\\'|")(.*?)\\4)|(?:cache=(\\\\\'|")(.*?)\\6)|(?:lifetime=(\\\\\'|")(.*?)\\8)|(?:cacheid=(\\\\\'|")(.*?)\\10)))+)\s*/>#s';
	
	$this->url['var'] = array();
	$this->url['url'] = array();
	$this->url['var'][0] = array();
	}
	
	function url($array)
	{
	$this->search[6] = '#(<[^>]+)(href|action|src)(\s*=\s*)(\\\\\'|")(.+)\.(\w+)(?:\?(.*?))?\4([^<]*>)#i';
		if (is_array($array['var']))
		{
		foreach ($array['var'] as $key => $val)
		{
		$tmp = '';
		$i = 0;
			if (is_array($val) AND count($val) > 0)
			{
			foreach ($val as $key2 => $val2)  
			{
			$tmp .= '\'.$this->url[\'var\'][\''.$key.'\'][\'var\']['.$i.'][0].\'=\'.$this->url[\'var\'][\''.$key.'\'][\'var\']['.$i.'][1].\'&amp;';
			$this->url['var'][$key]['var'][$i] = array($key2, $val2);
			$i++;
			}
			}
		$this->url['var'][$key]['string'] = $tmp;
		}
		}
		
		if (isset($array['url']) AND is_array($array['url']))
		$this->url['url'] = $array['url'];
	
	return true;
	}
	
	function set_dir($dir)
	{
		if ($dir{strlen($dir)-1} != '/')
		$dir .= '/';
	$this->var->tpl->dir = $dir;
	}
	
	function get_global($data) //enregistre les super globales utilisees dans le template compile
	{
		if (is_integer(strpos($data, '$this->var->{\'get\'}')))
		$this->var->get = &$_GET;
		if (is_integer(strpos($data, '$this->var->{\'post\'}')))
		$this->var->post = &$_POST;
		if (is_integer(strpos($data, '$this->var->{\'server\'}')))
		$this->var->server = &$_SERVER;
		if (is_integer(strpos($data, '$this->var->{\'globals\'}')))
		$this->var->globals = &$GLOBALS;
		if (is_integer(strpos($data, '$this->var->{\'cookie\'}')))
		$this->var->cookie = &$_COOKIE;
		if (is_integer(strpos($data, '$this->var->{\'session\'}')))
		$this->var->session = &$_SESSION;
		if (is_integer(strpos($data, '$this->var->{\'env\'}')))
		$this->var->env = &$_ENV;
		if (is_integer(strpos($data, '$this->var->{\'request\'}')))
		$this->var->request = &$_REQUEST;
		if (is_integer(strpos($data, '$this->var->{\'files\'}')))
		$this->var->files = &$_FILES;
	}
	
	function set_gzip() //met en route la compresssion gzip des pages
	{
		if (ob_start('ob_gzhandler'))
		{
			$this->var->tpl->gzip = 1;
			return true;
		}
		else
			return false;
	}
	
	function set_lang($lang) //definit la langue utilisee pour le template
	{ //set_lang('fr')
	$this->var->tpl->set_lang = $lang;
		if ($this->var->tpl->lang_method === 1)
		$this->var->tpl->lang = '';
		else
		$this->var->tpl->lang = $this->var->tpl->set_lang.'/';
	return true;
	}
	
	function set_lang_method($method) //definit la methode de gestion des langues
	{ //methode 1 : par balises <lang='fr'></lang>
	// methode 0 : par dossier 'fr'
	$this->var->tpl->lang_method = (int) $method;
	$lang = (isset($this->var->tpl->set_lang)) ? $this->var->tpl->set_lang : '';
	return $this->set_lang($lang);
	}
	
	function set($nvar,$vvar) //definit une variable ou un tableau ou un objet template
	{ //set('var', 'salut ca va ?')
	return ($this->var->$nvar = $vvar);
	}
	
	function replace($data, $cache) // remplace les donnees templates par du php
	{
	$data = strtr($data, array(
	"'" => "\'",
	'\\' => '\\\\',
	'</if>' => "'; } \$data .= '",
	'</elseif>' => "'; } \$data .= '",
	'<else>' => "'; else { \$data .= '",
	'</else>' => "'; } \$data .= '",
	'</foreach>' => "'; } \$data .= '",
	'</for>' => "'; } \$data .= '"
	));
	$search[] = $this->search[0];
		if ($cache == 1 OR $cache == 0)
		$search[] = $this->search_include;
	
	$search[] = $this->search[3];
	$search[] = $this->search[1];
	$search[] = $this->search[2];
	$search[] = $this->search[4];
	$search[] = $this->search[5];
	$search[] = $this->search[7];
		if (isset($this->search[6]))
		$search[] = $this->search[6];
	$data = preg_replace_callback($search, array($this,'var_back'), $data);
	return strtr(strtr('$data = \''.$data.'\';', array("\\''." => '\\\'\'; $data .= ')), array("{''}" => '', "''." => '', ".''" => '', ".''." => '.'));
	}
	
	function var_back($var) //callback pour compiler le template
	{
		if ($var[2] == '{')
		{
		$var[4] = strtr($var[4], array('[' => "'}['", ']' => "']{'", '->' => "'}->{'"));
		$var[4] = strtr($var[4], array("'}'}[''" => "'}['", "'']{'{'" => "']{'"));
		$return = $var[1]."'.\$this->var->{'".$var[3].$var[4]."'}.'".$var[5];
		if (preg_match($this->search[0], $return))
		return preg_replace_callback($this->search[0], array($this, 'var_back'), $return);
		else
		return $return;
		}
		elseif ($var[1] == 'if' OR $var[1] == 'elseif' OR $var[1] == 'foreach' OR $var[1] == 'for')
		{
		$search = array('#(?<!\\\)\|#');
		$replace = array("'");
		if ($var[1] == 'if' OR $var[1] == 'elseif')
		{
		$search[] = '#(^|\()\'\.(\$this->var->[\w\'\{\}\[\]>-]+)\.\'($|\))#';
		$replace[] = '$1$2$3';
		}
		elseif ($var[1] == 'foreach' OR $var[1] == 'for')
		{
		$search[] = '#([^\|\']|^)\'\.(\$this->var->[\w\'\{\}\[\]>-]+?)\.\'([^\|]|$)#';
		$replace[] = '$1$2$3';
		}
		return "'; ".$var[1]." (".preg_replace($search,$replace,stripslashes($var[3])).") { \$data .= '";
		}
		elseif ($var[1] == 'include')
		{
		if (!isset($var[5]) OR $var[5] != 1)
		{
		$var[3] = (isset($var[3])) ? $var[3] : '';
		$var[7] = (isset($var[7])) ? $var[7] : '';
		$var[9] = (isset($var[9])) ? $var[9] : '';
		$var[11] = (isset($var[11])) ? $var[11] : '';
		return "'.\$this->get('".$var[3]."', '".$var[7]."', '".$var[9]."', '".$var[11]."').'";
		}
		else
		{
		$var[3] = (isset($var[3])) ? $var[3] : '';
		return "'.\$this->file_get('".$var[3]."').'";
		}
		}
		elseif ($var[1] == 'load')
		return "'; \$this->get_load('".$var[3]."', 1); \$data .= '";
		elseif ($var[1] == 'math')
		return '\'.('.strtr($var[3], array("''." => '', ".''" => '', ".''." => '.', "'." => '', '.\'' => '')).').\'';
		elseif ($var[1] == 'set')
		return '\'; $this->var->{\''.$var[3].'\'} = \''.$var[5].'\'; $data .= \'';
		elseif ($var[1] == 'printf')
		return '\'; $data .= sprintf(\''.$var[3].'\',\''.str_replace(',','\',\'',$var[5]).'\'); $data .= \'';
		elseif ($var[2] == '$data .= \'')
		return '';
		elseif (strtolower($var[2]) == 'href' OR strtolower($var[2]) == 'src' OR strtolower($var[2]) == 'action')
		{
		$var[7] = strtr(strtr($var[7], array('&' => '&amp;')), array('&amp;amp;' => '&amp;'));
		if (substr($var[7], -5) != '&amp;' AND !empty($var[7]))
		$var[7] .= '&amp;';
		$tmp = $var[7];
			
		if (isset($this->url['var'][0]['string']))
		$tmp .= $this->url['var'][0]['string'];
		
		if (isset($this->url['var'][$var[6]]))
		$tmp .= $this->url['var'][$var[6]]['string'];
		
		if (!empty($tmp))
		$tmp = '?'.substr($tmp, 0, -5);
		return $var[1].$var[2].$var[3].$var[4].$var[5].'.'.$var[6].$tmp.$var[4].$var[8];
		}
		else
		return $var[0];
	}
	
	function get_load($config, $cache = 1) //compile un fichier de configuration
	{
	$dir = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$config.'.compiled.php';
	$dir2 = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$config;
		if ($cache == 1)
		{
			if (file_exists($dir))
			{
				if (filemtime($dir2) > filemtime($dir) OR filemtime(__FILE__) > filemtime($dir))
				{
					$datatmp = $this->get_load($config, 0);
					$this->file_write($dir, $datatmp);	
				}
				else
				{
					$datatmp = $this->file_get($dir);
				}
			}
			else
			{
				$datatmp = $this->get_load($config, 0);
				$this->file_write($dir, $datatmp);
			}
		}
		else
		{
			$data = $this->file_get($dir2);
			$search[] = $this->search[0];
			$search[] = '#\'\.\$this->var->(.*?)\.\'\s*\=\s*(\#\#)(.*?)(?<!\\\\)\#\##s';
			$datatmp = preg_replace_callback($search, array($this, 'load_back'), $data);
		}
	$datatmp = strtr($datatmp, array("{''}" => '', "''." => '', ".''" => '', ".''." => '.'));
	eval($datatmp);
	return $datatmp;
	}
	
	function load_back($var) //callback de la compilation des fichiers de configuration
	{
		if (isset($var[4]))
		{
		$var[4] = strtr($var[4], array('[' => "'}['", ']' => "']{'", '->' => "'}->{'"));
		$var[4] = strtr($var[4], array("'}'}[''" => "'}['", "'']{'{'" => "']{'"));
		$return = $var[1]."'.\$this->var->{'".$var[3].$var[4]."'}.'".$var[5];
		if (preg_match($this->search[0], $return))
		return preg_replace_callback($this->search[0], array($this, 'load_back'), $return);
		else
		return $return;
		}
		elseif ($var[2] == '##')
		return '$this->var->'.$var[1]." = '".strtr($var[3], array("'" => "\'", '\\' => '\\\\'))."';";
		else
		return $var[0];
	}
	
	function file_get($file) //retourne le contenu d'un fichier dans une variable
	{
		$fopen = fopen($file, 'r') or die('Cannot open the file : '.$file);
		$data = fread($fopen, filesize($file));
		fclose($fopen);
		return $data;
	}
	
	function file_write($file, $data) //ecrit en ecrasant dans un fichier
	{
		$fopen = fopen($file, 'w+') or die('Cannot open or create the file : '.$file);
		$return = fwrite($fopen, $data);
		fclose($fopen);
		return $return;
	}
	
	function eval_php($file) //evalue un fichier $file et renvoit le html correspondant
	{
		//$contents = $this->file_get($file);
		//eval($contents);
		//ob_start(); // start output buffering to capture contents
		$data = '';
		include($file) or die('Cannot open the file : '.$file);
		//$highlight = ob_get_contents(); // capture output
		return $data;
	}
	
	function get($nomtpl2, $cache = 1, $lifetime = 0, $cacheid = '') //compile et evalue le template avec un cache donne
	{
		if ($cacheid) $cacheid = htmlentities($cacheid);
		else $cacheid = '';
	
		$nomtpl = substr($nomtpl2, 0, strrpos($nomtpl2, '.'));
		$this->var->tpl->cacheid = $cacheid;
		$this->var->tpl->nomtpl = $nomtpl2;
		$this->var->tpl->lifetime = $lifetime;
		$dir = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$nomtpl.$cacheid.'.compiled.php';
		$dir2 = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$nomtpl2;
		$dir3 = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$nomtpl.$cacheid.'.serial.php';
		$dir4 = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$nomtpl.$cacheid.'.evalued.php';
	
		if ($cache == 1)
		{
			if (file_exists($dir))
			{
			$mtime = filemtime($dir);
				if (filemtime($dir2) > $mtime OR filemtime(__FILE__) > $mtime OR ($mtime < time()-$lifetime) * ($lifetime))
					$this->file_write($dir, $this->replace($this->file_get($dir2), 1));
			}
			else
				$this->file_write($dir, $this->replace($this->file_get($dir2), 1));
		
			$tpl = $this->file_get($dir);
			$data = '';
			$this->get_global($tpl);
//			echo $tpl;
			eval($tpl);
			if (count($this->url['url']) > 0)
				$data = preg_replace_callback($this->search[6], array($this, 'url_back'), $data);
			return $data;
		}
		elseif ($cache == 2)
		{
			if (file_exists($dir))
			{
				$this->get_global($this->file_get($dir));
				if (file_exists($dir4))
				{
					$mtime = filemtime($dir4);
					$cond = ($lifetime <= 0) ? true : ($mtime+$lifetime > time());
					if (filemtime($dir2) < $mtime AND $cond AND filemtime(__FILE__) < $mtime)
					{
						if ($this->file_get($dir3) == "<?php\n//".serialize($this)."\n?>")
							return $this->eval_php($dir4);
						else
							return $this->get($nomtpl2, -1, $lifetime, $cacheid);
					}
					else
						return $this->get($nomtpl2, -1, $lifetime, $cacheid);
				}
				else
					return $this->get($nomtpl2, -1, $lifetime, $cacheid);
			}
			else
				return $this->get($nomtpl2, 1, $lifetime, $cacheid);
		}
		elseif ($cache == 3)
		{
			if (file_exists($dir4))
			{
				$mtime = filemtime($dir4);
				$cond = ($lifetime <= 0) ? 1 : ($mtime+$lifetime > time());
				if (filemtime($dir2) < $mtime AND $cond AND filemtime(__FILE__) < $mtime)
					return $this->eval_php($dir4);
				else
					return $this->get($nomtpl2, -1, 0, $cacheid);
			}
			else
				return $this->get($nomtpl2, -1, 0, $cacheid);
		}
		elseif ($cache == -1)
		{
			$this->file_write($dir3, "<?php\n//".serialize($this)."\n?>");
			$this->file_write($dir, $this->replace($this->file_get($dir2), -1));
		
			$tpl = $this->file_get($dir);
			$this->get_global($tpl);
			eval($tpl);
			$tpl = $data;
			$tpl = '$data = \''.strtr($tpl, array("'" => "\'")).'\';';
			$tpl = preg_replace($this->search_include, '\'.$this->get(\'$3\', $9).\'', $tpl);
	
			$this->file_write($dir4, $tpl);
			eval($tpl);
		
			if (count($this->url['url']) > 0)
				$data = preg_replace_callback($this->search[6], array($this, 'url_back'), $data);
			return $data;
		}
		else
		{
			$data = '';
			$tpl = $this->replace($this->file_get($dir2), $cache);
			$this->get_global($tpl);
			eval($tpl);
			if (count($this->url['url']) > 0)
				$data = preg_replace_callback($this->search[6], array($this, 'url_back'), $data);
			return $data;
		}
	}
		
	function url_back($var)
	{
	//print_r($var);
	$url = $var[5].'.'.$var[6];
		if (isset($this->url['url'][$url]))
		{
		if (is_string($this->url['url'][$url]))
		$url = $this->url['url'][$url];
		elseif (count($this->url['url'][$url]) > 0)
		{
			if (is_int(strpos($var[7], '=')))
			{
			$tmp = explode('&amp;', $var[7]);
			foreach ($tmp as $val)
			{
			$tmp2 = explode('=', $val);
			$get_var_array[$tmp2[0]] = $tmp2[1];
			}
			}
			else
			$get_var_array = array();
		$res = false;
		unset($tmp);
			foreach ($this->url['url'][$url] as $key => $val)
			{
			if (isset($val['without_same_count']) AND $val['without_same_count']
			AND count($val['var']) !== count($get_var_array))
			$res = false;
			else
			{
				foreach ($val['var'] as $key2 => $val2)
				{
				if (is_integer($key2))
				{
					if (isset($get_var_array[$val2]))
					{
					$res = $key;
					$tmp[$val2] = $get_var_array[$val2];
					if (!isset($val['del_others_vars']) OR !$val['del_others_vars'])
					$var[7] = strtr($var[7], array('&amp;'.$val2.'='.$get_var_array[$val2] => ''));
										
					$var[7] = preg_replace('/'.$val2.'=([a-zA-Z0-9_]+)(&amp;|)/si','',$var[7]);
				}
					else
					{
					$res = false;
					break(1);
					}
				}
				else
				{
					if (isset($get_var_array[$key2]) AND $get_var_array[$key2] == $val2)
					{
					$res = $key;
					$tmp[$key2] = $val2;
					if (!isset($val['del_others_vars']) OR !$val['del_others_vars'])
					$var[7] = strtr($var[7], array('&amp;'.$key2.'='.$val2 => ''));
					}
					else
					{
					$res = false;
					break(1);
					}
				}
				}
			}
			if ($res === $key)
			break(1);
			}
			
			if ($res !== false)
			$url = vsprintf($this->url['url'][$url][$res]['new_url'],$tmp);
		}
		if (isset($val['del_others_vars']) AND $val['del_others_vars'])
		$get_var = '';
		elseif (!empty($var[7]))
		$get_var = '?'.$var[7];
		else
		$get_var = '';
		return $var[1].$var[2].$var[3].$var[4].$url.$get_var.$var[4].$var[8];
		}
		else
		return $var[0];
	}
}
?>