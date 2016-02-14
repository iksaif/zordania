<?php
/*
class tpl {
	function tpl() {}
}
*/
class Template
{
	function Template() //constructeur
	{
		$this->var = new stdClass();
		$this->var->tpl = new stdClass();
		$this->var->tpl->dir2 = dirname(__FILE__)."/";

		$this->set_dir('templates/'); //dossier des templates
		$this->set_tmp_dir(SITE_DIR.'tmp/'); // dossier du cache 
	
		$this->set_lang_method(0); //methode employee pour le multi langages
		$this->set_lang('fr'); //langue utilisee par defaut
		
		$this->mtime = filemtime(__FILE__);

		$this->var->tpl->gzip = 0;
		$this->sha1 = false; /* Modifier le nom des fichiers */

		$this->search[0] = '#(.*?)(\{)(get|post|session|cookie|server|tpl|files|request|globals|env)?(?!\')([^\s]*?(?:(?:\.\')|(?:[^\'])))\}(.*)#';
		$this->search[1] = '#<(set)\s*(?:(?:\s*(?:(?:name=(\\\\\'|")(.*?)\\2)|(?:value=(\\\\\'|")(.*?)\\4)))+)\s*/>#s';
		$this->search[2] = '#((\$data \.= \')(\s*)\';)#';
		$this->search[3] = '#<(if|elseif|foreach|for) cond=(\\\\\'|")(.*?)\\2>#s';
		$this->search[4] = '#<(load)(?:(?:\s*(?:(?:file=(\\\\\'|")(.*?)\\2)|(?:cache=(\\\\\'|")(.*?)\\4)))+)\s*/>#';
		$this->search[5] = '#<(math|eval)\s*oper\=(\\\\\'|")(.*?)\\2\s*/>#';
		$this->search[6] = '#<(printf)\s*(?:(?:\s*(?:(?:string=(\\\\\'|")(.*?)\\2)|(?:vars=(\\\\\'|")(.*?)\\4)))+)\s*/>#s';
		$this->search[7] = '#<(debug)\s*print\=(\\\\\'|")(.*?)\\2\s*/>#';
		//$this->search[8] = '#<(zurl)(mbr|gid|race)\s*(?:(?:\s*(?:(?:mid=(\\\\\'|")(.*?)\\3)|(?:pseudo=(\\\\\'|")(.*?)\\5)|(?:gid=(\\\\\'|")(.*?)\\7)))+)\s*/>#s';
		$this->search[8] = '#<(zurl)(mbr|gid|race)\s*(?:(?:\s*(?:(?:mid=(\\\\\'|")(.*?)\\3)|(?:pseudo=(\\\\\'|")(.*?)\\5)|(?:gid=(\\\\\'|")(.*?)\\7)|(?:race=(\\\\\'|")(.*?)\\9)))+)\s*/>#s';
		
		$this->replace[0] = '#<(zimg)(res|unt|trn|btc|src|comp)\s*(?:(?:\s*(?:(?:race=(\\\\\'|")(.*?)\\3)|(?:type=(\\\\\'|")(.*?)\\5)))+)\s*(.*?)/>#s';
		$this->replaceby[0] = '<img src="img/$4/$2/$6.png" alt="{$2[$4][alt][$6]}" title="{$2[$4][alt][$6]}" $7 />';

		$this->replace[1] = '#<(bbimg)(res|unt|trn|btc|src|comp)\s*(?:(?:\s*(?:(?:race=(\\\\\'|")(.*?)\\3)|(?:type=(\\\\\'|")(.*?)\\5)))+)\s*/>#s'; // tpl -> bbcode
		$this->replaceby[1] = '[img]'.SITE_URL.'img/$4/$2/$6.png[/img]';
		$this->replace[2] = '#<(zimgrace)\s*(?:race=(\\\\\'|")(.*?)\\2)\s*/>#s';
		$this->replaceby[2] = '<img src="img/$3/$3.png" title="{race[$3]}" alt="{race[$3]}"/>';
		$this->replace[3] = '#<(bbimgrace)\s*(?:race=(\\\\\'|")(.*?)\\2)\s*/>#s';
		$this->replaceby[3] = '[img]'.SITE_URL.'img/$3/$3.png[/img]';
		$this->replace[4] = '|<#.*?#>|s'; // commentaires de template
		$this->replaceby[4] = '';
		$this->replace[5] = '#<(zimgpact)\s*(?:type=(\\\\\'|")(.*?)\\2)\s*/>#s';
		$this->replaceby[5] = '<img src="img/dpl/$3.png" title="{dpl_type[$3]}"/>';

		$this->macro[1] = '#<(zimg)(bar|ba2|ba3)\s*(?:(?:\s*(?:(?:per=(\\\\\'|")(.*?)\\3)|(?:max=(\\\\\'|")(.*?)\\5)))+)\s*/>#s';
		
		//$this->search_include =  '#<(include)(?:(?:\s*(?:(?:file=(\\\\\'|")(.*?)\\2)|(?:cache=(\\\\\'|")(.*?)\\4)))+)\s*/>#s';	
		$this->search_include =  '#<(include)(\s*((\w*)=(\\\\\'|")(.*?)\\2)*)*\s*/>#s';
	}
	
	function set_dir($dir)
	{
		if ($dir{strlen($dir)-1} != '/')
			$dir .= '/';
		$this->var->tpl->dir = $dir;
	}

	function set_tmp_dir($dir)
	{
		if(!is_dir($dir))
			if(!mkdir($dir, 0700, true)) echo "Echec création rep $dir";
		if ($dir{strlen($dir)-1} != '/')
		$dir .= '/';
		$this->tmpdir = $dir;
	}
	
	function set_globals() /* Permet d'utiliser les superglobales dans les templates */
	{
		$this->var->_get = &$_GET;
		$this->var->_post = &$_POST;
		$this->var->_server = &$_SERVER;
		$this->var->_globals = &$GLOBALS;
		$this->var->_cookie = &$_COOKIE;
		$this->var->_session = &$_SESSION;
		$this->var->_env = &$_ENV;
		$this->var->_request = &$_REQUEST;
		$this->var->_files = &$_FILES;
	}
	
	function set_gzip() //met en route la compresssion gzip des pages
	{
		if (ob_start('ob_gzhandler')) {
			$this->var->tpl->gzip = 1;
			return true;
		} else
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
	
	function set($nvar,$vvar = '') //definit une variable ou un tableau ou un objet template
	{ //set('var', 'salut ca va ?')
		if(is_array($nvar)) {
			foreach($nvar as $k => $v)
				$this->var->$k = $v;
			return true;
		} else
			return ($this->var->$nvar = $vvar);
	}
	
	function set_ref($nvar, & $vvar = '') //definit une variable ou un tableau ou un objet template
	{ //set('var', 'salut ca va ?')
		if(is_array($nvar)) {
			foreach($nvar as $k => $v)
				$this->var->$k = &$v;
			return true;
		} else
			return ($this->var->$nvar = &$vvar);
	}
	
	function merge($name,$array)
	{
		return ($this->var->$name = array_merge($this->var->$name,$array));
	}
	
	function replace($data, $cache) // remplace les donnees templates par du php
	{
		$data = preg_replace($this->replace, $this->replaceby, $data);

		$data = strtr($data, array(
			"'" => "\'",
			'\\' => '\\\\',
			'</if>' => "'; }\n \$data .= '",
			'</elseif>' => "'; }\n \$data .= '",
			'<else>' => "';\n else { \$data .= '",
			'</else>' => "'; }\n \$data .= '",
			'</foreach>' => "'; }\n \$data .= '",
			'</for>' => "'; }\n \$data .= '"
			));
		$search[] = $this->search[0]; // les variables entre { }
		
		if ($cache == 1 OR $cache == 0)
			$search[] = $this->search_include;
		
		//$search[] = $this->macro[0]; // zimg* sauf bar
		$search[] = $this->search[3]; // if|elseif|foreach|for
		$search[] = $this->search[1]; // set
		$search[] = $this->search[2];
		$search[] = $this->search[4]; // load
		$search[] = $this->search[5]; // math|eval
		$search[] = $this->search[6]; // printf
		$search[] = $this->search[7]; // debug
		$search[] = $this->search[8]; // zurl*
		$search[] = $this->macro[1]; // zimgba*, doit être avant math
	
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
		elseif ($var[1] == 'if'  || $var[1] == 'elseif' || $var[1] == 'foreach' || $var[1] == 'for')
		{
			return "';\n".$var[1]." (".strtr($var[3], array("''." => '', ".''" => '', ".''." => '.', "'." => '', '.\'' => '')).") { \n \$data .= '";
		}
		elseif ($var[1] == 'include')
		{

			$return = ''; $cache = 1; $file = '';
			preg_match_all('#([a-z]+)=(\\\\\'|")(.*?)\\2#', $var[0], $out);

			foreach($out[1] as $num=>$key)
				if ($key == 'cache' or $key == 'file') // variables nécessaires
					${$key} = $out[3][$num];
				else // autre variable facultative = affectation d'un paramère pour l'include
					$return .= "';\n\$this->var->{'$key'} = '{$out[3][$num]}';\n\$data .= '";
			return $return . "'.\$this->get('$file', '$cache').'";

		}
		elseif ($var[1] == 'load')
			return "';\n\$this->get_config('".$var[3]."', 1);\n\$data .= '";
		elseif ($var[1] == 'math')
			return '\'.('.strtr($var[3], array("''." => '', ".''" => '', ".''." => '.', "'." => '', '.\'' => '')).').\'';
		elseif ($var[1] == 'debug') // afficher variable
			if (!SITE_DEBUG) return '';
			else return '\'.print_debug('.strtr($var[3], array("''." => '', ".''" => '', ".''." => '.', "'." => '', '.\'' => '')).').\'';
		elseif($var[1] == 'eval')
			return '\'; '.strtr($var[3], array("''." => '', ".''" => '', ".''." => '.', "'." => '', '.\'' => '')).'; $data .= \'';
		elseif ($var[1] == 'set')
			return '\'; $this->var->{\''.$var[3].'\'} = \''.$var[5].'\'; $data .= \'';
		elseif ($var[1] == 'printf')
			return '\'; $data .= sprintf(\''.$var[3].'\',\''.str_replace(',','\',\'',$var[5]).'\'); $data .= \'';
		elseif($var[1] == 'zimg')
		{
			if($var[2] == 'bar' or $var[2] == 'ba2' or $var[2] == 'ba3')
			{
				// affichage barre de progression : $var[4] = % et $var[6] = maxi
				switch($var[2])
				{ // ba2 = moyennes, ba3 = grandes, bar = petites
					case 'ba2': $size = 'moyennes'; break;
					case 'ba3': $size = 'grandes'; break;
					default:    $size = 'petites';
				}
				$width1 = "'\n\t.floor('{$var[4]}'/'{$var[6]}'*100)\n\t.'";
				$width2 = "'\n\t.floor(( '{$var[6]}' - '{$var[4]}' )/ '{$var[6]}' *100)\n\t.'";

				return "\n<div class=\"barres_$size\" title=\"$width1%\">
	<div style=\"width:$width1%;\" class=\"barre_verte\"></div>
	<div style=\"width:$width2%;\" class=\"barre_rouge\"></div>
</div>\n";
			} else { // affichage d'une image de zordania
				// $var[2] = unt|src|trn|btc|res / $var[4] = race / $var[6] = type
				$alt = '{'.$var[2].'['.$var[4].'][alt]['.$var[6].']}';
				return '<img src="img/'.$var[4].'/'.$var[2].'/'.$var[6].'.png" alt="'.$alt.'" title="'.$alt.'" />';
			}
		}
		elseif ($var[1] == 'zurl')
		{
			if($var[2] == 'mbr'){
				$return = '';
				if(!empty($var[8])) // lien membre + img groupe
					$return .= '<img src="img/groupes/'.$var[8].'.png" alt="\'.$this->var->{\'groupes\'}[\''.$var[8].'\'].\'" title="\'.$this->var->{\'groupes\'}[\''.$var[8].'\'].\'"/>&nbsp;
';
				if(!empty($var[10])) // lien membre + img race
					$return .= '<img src="img/'.$var[10].'/'.$var[10].'.png" alt="\'.$this->var->{\'race\'}[\''.$var[10].'\'].\'" />&nbsp;
';
				// lien membre simple
				return $return . '<a href="member-\'.str2url(\''.$var[6].'\').\'.html?mid='.$var[4].'" title="Infos sur '.$var[6].'">'.$var[6].'</a>';
			}
			elseif($var[2] == 'gid') // pour TEST
				return (isset($var[4]) ? 'var4='.$var[4] : "").'|'.(isset($var[6]) ? 'var6='.$var[6] : "").'|'.(isset($var[8]) ? 'var8='.$var[8] : "").'|'.(isset($var[10]) ? 'var10='.$var[10] : "");

		}
		elseif ($var[2] == '$data .= \'')
			return '';
		else
			return $var[0];
	}

	function file_get($file) //retourne le contenu d'un fichier dans une variable
	{
		$data = "";

		$size = filesize($file);
		if(!$size) return $data;

		$fopen = fopen($file, 'r') or die('Cannot open the file : '.$file);
		$data = fread($fopen, $size);	
		fclose($fopen);
		return $data;
	}
	
	function file_write($file, $data) //ecrit en ecrasant dans un fichier
	{
		$data = "<?php\n $data \n ?>";
		$fopen = fopen($file, 'w+') or die('Cannot open or create the file : '.$file);
		$return = fwrite($fopen, $data);
		fclose($fopen);
		return $return;
	}
	
	function eval_php($file) //evalue un fichier $file et renvoit le html correspondant
	{
		$data = '';
		require($file);
		return $data;
	}
	
	function get($nomtpl2, $cache = 0) //compile et evalue le template avec un cache donne
	{
		$nomtpl = substr($nomtpl2, 0, strrpos($nomtpl2, '.'));
		
		$this->var->tpl->nomtpl = $nomtpl2;
		
		if($this->sha1)
			$dir = $this->tmpdir.sha1($this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$nomtpl);
		else
			$dir =  $this->tmpdir.str_replace("/","_",$this->var->tpl->lang.$nomtpl);

		$dir1 = $dir.'.compiled.php';
		//$dir2 = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$nomtpl2;
		$dir2 = $this->var->tpl->dir.$this->var->tpl->lang.$nomtpl2;
		//echo "$dir1\n$dir2";

		if($cache == 0 || !file_exists($dir1)) {
			$this->file_write($dir1, $this->replace($this->file_get($dir2), 1));
			$data = $this->eval_php($dir1);
			
			return $data;
		} else if($cache == 1) {
			$mtime = filemtime($dir1);
			if (filemtime($dir2) < $mtime && $this->mtime < $mtime)
				return $this->eval_php($dir1);
			else
				return $this->get($nomtpl2, 0);
		} else {
			return '';
		}
	}

	function replace_config($data) {
		$search[] = $this->search[0];
		$search[] = '#\'\.\$this->var->(.*?)\.\'\s*\=\s*(\#\#)(.*?)(?<!\\\\)\#\##s';
		$data = preg_replace_callback($search, array($this, 'config_back'), $data);
		$data = strtr($data, array("{''}" => '', "''." => '', ".''" => '', ".''." => '.'));
		return $data;
	}

	function get_config($config, $cache = 1) //compile un fichier de configuration
	{
		if($this->sha1)
			$dir = $this->tmpdir.sha1($this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$config);
		else
			$dir =  $this->tmpdir.str_replace("/","_",$this->var->tpl->lang.$config);

		$dir1 = $dir.'.compiled.php';
		//$dir2 = $this->var->tpl->dir2.$this->var->tpl->dir.$this->var->tpl->lang.$config;
		$dir2 = $this->var->tpl->dir.$this->var->tpl->lang.$config;
		
		if($cache == 0 || !file_exists($dir1)) {
			$this->file_write($dir1, $this->replace_config($this->file_get($dir2)));
			$this->eval_php($dir1);
		} else if($cache == 1) {
			$mtime = filemtime($dir1);
			if (filemtime($dir2) < $mtime && $this->mtime < $mtime)
				$this->eval_php($dir1);
			else
				$this->get_config($config, 0);
		}
	}
	
	function config_back($var) //callback de la compilation des fichiers de configuration
	{
		if (isset($var[4]))
		{
			$var[4] = strtr($var[4], array('[' => "'}['", ']' => "']{'", '->' => "'}->{'"));
			$var[4] = strtr($var[4], array("'}'}[''" => "'}['", "'']{'{'" => "']{'"));
			
			$return = $var[1]."'.\$this->var->{'".$var[3].$var[4]."'}.'".$var[5];
			
			if (preg_match($this->search[0], $return))
				return preg_replace_callback($this->search[0], array($this, 'config_back'), $return);
			else
				return $return;
		}
		elseif ($var[2] == '##')
			return '$this->var->'.$var[1]." = '".strtr($var[3], array("'" => "\'", '\\' => '\\\\'))."';";
		else
			return $var[0];
	}
}
?>
