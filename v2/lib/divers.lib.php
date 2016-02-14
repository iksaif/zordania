<?php

/* fonction de chargement automatique pour les classes */
function __autoload($classname) {
	require_once(SITE_DIR ."lib/$classname.class.php");
}

/* Envoie un mail */
function mailto($from, $to, $sujet, $message, $html=FALSE)
{
	if($html) {
	  		$from ="From: Zordania <".$from."> \n"; 
	  		$from .= "MIME-Version: 1.0\n";
			$from .= "Content-type: text/html; charset=iso-8859-1\n";
	 }else
		$from="From: $from <$from>";

	return mail($to,$sujet,$message,$from);
}
/* mail en utf8 */
function mail_utf8($to, $subject = '(No subject)', $message = '', $header = '') {
  $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
  mail($to, "=?UTF-8?B?".base64_encode($subject).'?=', $message, $header_ . $header);
}

/* retourne true si le mail est valide */
function mailverif($mail) 
{
	$deb = explode("@",$mail);
	if(count($deb) > 1) {
		$deb2 = explode(".",$deb[1]);
		if(count($deb2) > 1)
			return true;
	}
	return false;
}

/* Vérifie que y'a des char corrects - v2: que des lettres + espace et apostrophe */
function strverif($str)
{
	return preg_match("!^[a-zA-Z 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜàâãäåçèéêëìíîïòóôõöùúûüÿ]*$!i",$str);
	//return preg_match("!^[a-zA-Z0-9_\-' éêèëàêôöäüï]*$!i",$str);
}

/* virer les tab et multi espaces */
function trimUltime($chaine){
	$chaine = trim($chaine);
	$chaine = str_replace("\t", " ", $chaine);
	$chaine = preg_replace("( +)", " ", $chaine);
return $chaine;
}

/* Permet de transformer une chaîne de sorte qu'elle soit compatible avec les regexp de la réécriture d'url */
function str2url($str) {
	// UTILITE
	$str = strtr($str, array(
	    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
	    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
	    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
	    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
	    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
	    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
	    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f', "'"=>'_', ' '=>'_', '-'=>'_'
	));
		//'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜàâãäåçèéêëìíîï©òóôõöùúûüÿ',
		//'AAAAAACEEEEIIIIOOOOOUUUUaaaaaceeeeiiiicooooouuuuy');
	$str = str_replace('&', '_et_', $str);
	$str = str_replace('__', '_', $str);
	
	// SECURITE : opposé de la regexp [a-zA-Z0-9_]+
	// remove all illegal chars
	$str = preg_replace('/[^a-zA-Z0-9_]/', '', $str);
	return (($str == "") ? "_" : $str);
}

function safe_serialize($data)
{
  return base64_encode(serialize($data));
}

function array_utf8_encode($data) {
  if (is_array($data)) {
    foreach ($data as & $value) {
      $value = array_utf8_encode($value);
    }
    return $data;
  } else if (is_string($data))
    return utf8_encode($data);
  else
    return $data;
}

function safe_unserialize($str)
{
  $str64 = base64_decode($str, true);
  $data = false;
  if ($str64 !== false)
	  $data = @unserialize($str64);
  if (!$data or $str64 === false){ /* wasn't base64 data */
	//echo "<pre>$str\n</pre>";
    $data = @unserialize($str);
  }
  if (!$data) {
    $str = utf8_decode($str);
    $data = @unserialize($str);
    $data = array_utf8_encode($data);
  }
  return $data;
}

function calc_key($str1, $str2, $len = GEN_LENGHT) // ex: $_file + pseudo
{
	return substr(md5($str1 . $str2), 0, $len);
}

/* Trouve le pays du type */
function get_pays() {
	$lang = request("lang", "string", "get");
	
	if($lang) {
		setcookie('lang',$lang);
	} else {
		$lang = request("lang", "string", "cookie");
		if(!$lang) {
			$host= @gethostbyaddr(get_ip());
			$code = substr(strrchr($host,'.'),1);
		}
	}
	
	if(!$code)
		$code = "unknown";
		
	return $code;
}
	
function get_lang() {
	global $_langues;
	
	$pays = get_pays();
	if(isset($_langues[$pays]))
		return $_langues[$pays];
	else
		return $_langues["unknown"];
}

function del_cookie($name)
{
	return setcookie($name, "", -1);
}

function get_ip()
{
	$realip = "127.0.0.1"; /* Quand on trouve pas, c'est que c'est en cli */

	if (isset($_SERVER)) { 
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) { 
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
		} elseif (isset($_SERVER["HTTP_CLIENT_IP"])) { 
			$realip = $_SERVER["HTTP_CLIENT_IP"]; 
		} elseif(isset($_SERVER["REMOTE_ADDR"])) { 
			$realip = $_SERVER["REMOTE_ADDR"]; 
		} 
	} else { 
		if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) { 
			$realip = getenv( 'HTTP_X_FORWARDED_FOR' ); 
		} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) { 
			$realip = getenv( 'HTTP_CLIENT_IP' ); 
		} else { 
			$realip = getenv( 'REMOTE_ADDR' ); 
		} 
	} 
	return $realip; 
}
		
function genstring($longueur) //genere une chaine a x caracteres aleatoirement
{
	$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; //²&"~`%*$^|
	$gen = '';

	for ($i=0;$i<$longueur;$i++)
	$gen.= substr($str, mt_rand(0, strlen($str) - 1), 1);
	
	return $gen;
}
	
/* protège une chaine avant de la mettre dans mysql */
function protect($var, $type = "unknown")
{	
	if(is_array($type)){
		if(is_array($var))
			foreach($var as $key => $value)
				$var[$key] = protect($value, $type[0]);
		else $var = array();
	} else {
		switch($type) {
		case "bool":
			$var = (bool) $var;
			break;
		case "int":
			$var = (int) $var;
			break;
		case "uint":
			$var = (int) $var;
			if($var < 0) $var = 0;
			break;
		case "float":
			$var = (float) $var;
			break;
		case "array":
			if(!is_array($var)) $var = array();
			break;
		case "serialize":
			if(!is_array($var)) $var = array();
			$var = safe_serialize($var);
			break;
		case "string":
			$var = htmlspecialchars($var);
			break;
		case "bbcode": /* Rien a faire */
			break;
		}
	}

	/* Protection si ce n'est pas un entier */
	if (is_string($var)) {
		$var = mysql_real_escape_string($var);
	}
	return $var;
}

/* Permet de prendre des trucs dans GET et POST même si ils y sont pas, avec une var par defaut .. */
function request($name, $type, $method, $default = false)
{
	$def = array("bool" => false, "uint" =>0, "int" => 0, "float" => 0,
			"array" => array(),"string" => "");

	if($method == 'get' && isset($_GET[$name])) 
		$var = $_GET[$name]; 
	elseif($method == 'post' && isset($_POST[$name])) 
		$var = $_POST[$name]; 
	elseif($method == 'cookie' && isset($_COOKIE[$name])) 
		$var = $_COOKIE[$name];
	elseif($method == 'session' && isset($_SESSION[$name])) 
		$var = $_SESSION[$name];
	elseif($method == 'files' && isset($_FILES[$name]))
		$var = $_FILES[$name];
	elseif($method == 'server' && isset($_SERVER[$name]))
		$var = $_SERVER[$name];
	elseif($default)
		return $default;
	elseif(is_array($type))
		return $def['array'];
	else
		return $def[$type];

	if(is_array($type)){// récupérer un array[string]
		if(!is_array($var))
			$var = array();
		else switch($type[0]){
		case 'string':
			foreach($var as $key => $value){
				$var[$key] = (string) $value;
				if(get_magic_quotes_gpc())
					$var[$key] = stripslashes($var[$key]);
			}
			break;
		}
	}else{
		switch($type) {
		case "bool":
			$var = (bool) $var;
			break;
		case "int":
			$var = (int) $var;
			break;
		case "uint":
			/*$var = abs((int) $var);*/
			$var = (int) $var;
			if($var < 0) $var = $def['uint'];
			break;
		case "float":
			$var = (float) $var;
			break;
		case "array":
			if($method == "cookie" && is_string($var)) $var = @safe_unserialize($var);
			if(!is_array($var)) $var = array();
			break;
		case "string":
			$var = (string) $var;
			if(get_magic_quotes_gpc())
				$var = stripslashes($var);
			break;
		case "raw":
		default:
			break;
		}
	}
	return $var;
}

/* Index un array a partir d'une de ses valeurs */
function index_array(& $array, $key) {
	$array = protect($array, "array");
	$key = protect($key, "string");
	$tmp = array();

	foreach($array as $value) {
		if(isset($value[$key]))
			$tmp[$value[$key]] = $value;
	}

	return $tmp;
}

/* trier un array d'arrays par rapport à une valeur */
function sksort(&$array, $subkey="id", $sort_ascending=false) {
	$temp_arr = array();
	foreach($array as $key => $val){
		$val['nid'] = $key; // conserver l'id
		$temp_array[$val[$subkey]] = $val;
	}
	if ($sort_ascending) ksort($temp_array);
	else krsort($temp_array);
	$array = $temp_array;
}

/* cumuler les arrays par clé */
function array_ksum(&$arr1, $arr2, $factor = 1) {
	foreach($arr2 as $key => $value)
		if(isset($arr1[$key]))
			$arr1[$key] += $value * $factor;
		else
			$arr1[$key] = $value * $factor;
}

/* comparer $arr2 à $arr1 par clé et donner le "manque" dans un 3eme */
function array_compare($arr1, $arr2) {
	$return = array();
	foreach($arr2 as $key => $val)
		if(!isset($arr1[$key])) // manque tout ça
			$return[$key] = $val;
		elseif($arr1[$key] < $val) // manque un peu quand meme!
			$return[$key] = $val - $arr1[$key];
	return $return;
}

/* Pour jouer avec la conf 
 * /!\ $_user['race'] doit être bon !!!
 */
function get_conf($type = "", $key0 = "", $key1 = "") {
	global $_user;

	$race = $_user['race'];
	return get_conf_gen($race, $type, $key0, $key1);
}
function get_btc_prod_auto() {
	global $_user;
	$race = $_user['race'];
	$cfg_btc = get_conf_gen($race, 'btc');
	$result = array();
	foreach($cfg_btc as $key => $btc) {
		if(isset($btc['prod_res_auto'])) {
			foreach($btc['prod_res_auto'] as $res => $nb) {
				$result[$res][] = $key;
			}
		}
	}
	
	return $result; 
}

function load_conf($race) {
	global $_conf;
	$race = protect($race, "uint");
	if(!isset($_conf[$race])) {
		if(file_exists(SITE_DIR . "conf/".$race.".php")) {
			require_once(SITE_DIR . "conf/".$race.".php");
			$confname = "config".$race;
			$_conf[$race] = new $confname;
			return true;
		} else
			return false;
	} else
		return true;
}

/* fonction générale */
function get_conf_gen($race, $type = "", $key0 = "", $key1 = "") {
	global $_conf;

	if(!load_conf($race))
		return array();
	else
		$conf = &$_conf[$race];

	if(!$type)
		return $conf;

	if(!isset($conf->$type))
		return array();

	if(!$key0)
		return $conf->$type;
	
	$list = & $conf->$type;
	if(!isset($list[$key0]))
		return array();

	if(!$key1)
		return $list[$key0];

	if(!isset($list[$key0][$key1]))
		return array();

	return $list[$key0][$key1];
}

/* Récupère les droits pour un groupe donné */
function get_droits($gid) {
	global $_droits;
	if(!isset($_droits[$gid]))
		return array();
	else
		return $_droits[$gid];
}

/* Regarde si on a un droit */
function can_d($droit) {
	global $_user;
	if(!is_array($_user) || !isset($_user['droits']))
		return false;
	else
		return in_array($droit,$_user['droits']);
}

/* recuperer les constantes qui commencent par $prefix */
function get_const($prefix,$const = false) {
	if (!$const) {
		$const = get_defined_constants(true);
		$const = $const['user'];
	}
	$return = array();
	foreach($const as $key => $value) {
		$str = str_replace($prefix, '', $key);
		if($str != $key) {
			$return[$str] = $value;
		}
	}
	return $return;
}
function get_flip_const($prefix){ // retrouver les constantes, inverser clé/valeur
	$const = get_defined_constants(true);
	$const = $const['user'];

	$return = array();
	foreach($const as $key => $value)
		if(strpos($key, $prefix) === 0)
			$return[$value] = $key;
	return $return;
}

//$page est la page courante
//$nb_page le nombre de pages totales
//$nb le nombre de page à retourner à droite et à gauche
function get_list_page($page, $nb_page, $nb = 3)
{
	$list_page = array();
	for ($i=1;$i <= $nb_page;$i++){
		if (($i <= $nb) OR ($i >= $nb_page - $nb) OR (($i < $page + $nb) AND ($i > $page -$nb)))
			$list_page[] = $i;
		else{
			if ($i >= $nb AND $i <= $page - $nb)
				$i = $page - $nb;
			elseif ($i >= $page + $nb AND $i <= $nb_page - $nb)
				$i = $nb_page - $nb;
			$list_page[] = '...';
		}
	}
	return $list_page;
}

function print_debug($arr = false, $title = ''){
	if ($arr === false) {
		global $_tpl;
		return print_debug($_tpl->var);
	}
	if ($title!='') $rep = "<dt>$title</dt>\n"; else $rep = '';
	$rep1 = '<table><tr>'; $rep2 = ''; $i = 0;
	foreach($arr as $key => $val)
		if(!is_array($val) && !is_object($val)) { // les variables simples
			//echo "$title\[$key] = $val<br/>\n";
			$rep1 .= "<td>[$key] =&gt; $val</td>\n";
			$i++;
			if($i == 5) { // nouvelle ligne du tableau
				$i=0;
				$rep1 .= "</tr><tr>\n";
			}
		} else if ($key !='GLOBALS' && $key != 'tpl' && substr($key,1,5)!='MYSQL' && $key != '_globals' && $key != '_server' && $key != '_session'&& $key != 'sv_queries'	) { // récursivité infinie /!\
			$rep2 .= print_debug($val, "$title [$key]")."\n";
		}
	return $rep.$rep1."</tr></table>\n".$rep2;
}

function array_to_xml($array, $rootName='root'){
	$xml = "";
	$xml .= "<".$rootName.">";
	foreach($array as $key => $value){
		$xml .= "<record key='".$key."'>";
		foreach($value as $nomChamp => $val){
			$xml .= "<champ key='".$nomChamp."'>";
			$xml .= $val;
			$xml .= "</champ>";
		}
		$xml .= "</record>";
	}
	$xml .= "</".$rootName.">";
	return $xml;
}

function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "\"".str_replace('"', '\"', $key)."\"";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "\"".str_replace('"', '\"', $value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".str_replace('"', '\"', $value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}


 
/* Gestion des erreurs */
function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
{
	global $_error;

	/* Ignore error, @ */
	if (error_reporting() === 0)
	   return ;

	$error = array('errno' => $errno, 'errstr' => $errstr, 'errfile' => $errfile, 'errline' => $errline, 'errcontext' => $errcontext, 
		'errmsg' => sprintf('File: %s[%03d]', pathinfo($errfile, PATHINFO_FILENAME), $errline), 'callstack' => callstack());
	if(SITE_DEBUG)
		echo "<div style=\"border:1px #000 solid;text-align:left; font-family: monospace;\">"
			.nl2br(error_print($error))."</div>";
	$_error[] = $error;
}

function error_print($error) {
	$errmsg = array(
		E_ERROR        => 'Fatal Error',
		E_WARNING      => 'Warning',
		E_NOTICE       => 'Notice',
		E_USER_ERROR   => 'User Fatal Error',
		E_USER_WARNING => 'User Warning',
		E_USER_NOTICE  => 'User Notice'
	);
	$txt = '';
	if(isset($errmsg[$error['errno']]))
		$txt .= '<strong>'.$errmsg[$error['errno']]."</strong> : ".$error['errstr']."\n";
	if(CRON)
		$txt .= "CRON: ".$_SERVER['PHP_SELF']."\n";
	else
		$txt .= "URL: ".$_SERVER["REQUEST_URI"]."\n";
	$txt .= $error['errmsg']."\n";
	$txt .= "<strong>callstack</strong>\n".implode("\n", $error['callstack']);
	return $txt;
}

function callstack() { /* pile d'appel */
	$retval = array();
	$backtrace = debug_backtrace();
	for ($idx = count($backtrace) - 1; $idx > 0; $idx--) {
		$item = $backtrace[$idx];
		if (isset($item['file']))
			$file = sprintf('%s[%03d]', pathinfo($item['file'], PATHINFO_FILENAME), $item['line']);
		else
			$file = 'eval()';
		if (isset($item['class']))
			$func = $item['class'] . '->' . $item['function'];
		else
			$func = $item['function'];
		if ($func == 'error_handler') break; // fin d'analyse de la pile
		$retval[] = sprintf("\t%-32s\t%s()", $file, $func);
	}
	return $retval;
}

?>
