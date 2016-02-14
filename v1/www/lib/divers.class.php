<?
class divers
{
var $sql;

	function divers(&$sql)
	{
	$this->sql = &$sql;
	}
	
	function get_pays() {
		if($_GET['lang'])
		{
			$code = $_GET['lang'];
			divers::set_cookie('lang',$_GET['lang']);
		}
		elseif($_COOKIE['lang'])
		{
			$code = divers::read_cookie($_COOKIE['lang']);
		}
		else
		{
			$host= @gethostbyaddr(divers::getip());
			$code = substr(strrchr($host,'.'),1);
		}
		
		if($code)
		{
			return $code;
		}else{
			return "unknow";
		}
	}
	
	function get_lang()
	{
		$pays=divers::get_pays();
		$langues=array(
		"unknow"=>	"fr",
		"fr"	=>	"fr",
		//"en"	=>	"en"
		);
		if($langues[$pays])
		{
			return $langues[$pays];
		}else{
			return $langues["unknow"];
		}	
	}
	
  	function mailverif($mail) // retourne true si le mail est valide
  	{
  	  $deb = explode("@",$mail);
  	  if(count($deb) > 1)
  	  {
  	    $deb2 = explode(".",$deb[1]);
  	    if(count($deb2) > 1)
  	        return true;
  	    
  	  }
  	  return false;
  	}
	
	function strverif($str)
	{
		return preg_match("!^[a-zA-Z0-9_\-' יטאך]*$!i",$str);
	}
	
    	function getip()
    	{
    		if(@$_SERVER)
    		{
        		if(@$_SERVER['HTTP_X_FORWARDED_FOR']) {$ip = @$_SERVER['HTTP_X_FORWARDED_FOR'];}
        		elseif(@$_SERVER['HTTP_CLIENT_IP'])   {$ip = @$_SERVER['HTTP_CLIENT_IP'];}
        		else {$ip = @$_SERVER['REMOTE_ADDR'];}
        	}
    		else
        	{
        		if(@getenv('HTTP_X_FORWARDED_FOR')) {$ip = @getenv('HTTP_X_FORWARDED_FOR');}
        		elseif(@getenv('HTTP_CLIENT_IP'))   {$ip = @getenv('HTTP_CLIENT_IP');}
        		else {$ip = @getenv('REMOTE_ADDR');}
        	}
    		return $ip;
	}
	
	function genstring($longueur) //genere une chaine a x caracteres aleatoirement
	{
		$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; //²&"~`%*$^|
		
		for ($i=0;$i<$longueur;$i++)
		$gen.= substr($str, mt_rand(0, strlen($str) - 1), 1);
		
		return $gen;
	}
	
	function getmicrotime() 
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}
	
	function log_error($file,$text)
	{
		$fp = fopen($file,"a+");	
		fwrite($fp, $text);
		fclose($fp);
	}
	
	function log($mid) //enregistre une tentative de hack
	{
		$mid = (int) $mid;
		$ip = $this->getip();
		$url =htmlentities($_SERVER['REQUEST_URI']);
		$post=htmlentities(serialize($_POST), ENT_QUOTES);
		$cook=htmlentities(serialize($_COOKIE), ENT_QUOTES);
		$req = "INSERT INTO ".$this->sql->prebdd."log VALUES('','$mid','$ip',NOW(),'$url','$post','$cook')";	  						
		return $this->sql->query($req);
	}
	
	function get_log()
	{
		$req = "SELECT mbr_pseudo,log_mid,log_ip,log_url,log_post,log_cookie,formatdate(log_date) as log_date_formated ";
		$req.= "FROM ".$this->sql->prebdd."log ";
		$req.= "LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid = log_mid ";
		$req.= "ORDER BY log_date DESC";
		$log_array = $this->sql->make_array($req);
		foreach($log_array as $rien => $result)
		{ 
			$log_array[$rien]['log_post'] = print_r(unserialize(html_entity_decode($result['log_post'], ENT_QUOTES)),true);
			$log_array[$rien]['log_cookie'] = urldecode(print_r(unserialize(html_entity_decode($result['log_cookie'], ENT_QUOTES)),true));
		}
		return $log_array;
	}
		
	function getreferer()
	{
		if($_GET['file'] AND $_GET['file'] != "404")
		{
			return htmlentities($_GET['file']);
		}else{
			if($_SERVER['REQUEST_URI'])
			{
				return $_SERVER['REQUEST_URI'];
				
			}
			$referer = $_SERVER['HTTP_REFERER'];
			$referer = parse_url($referer);
			return $referer['path'];
		}
	}
	
	function mailto($from,$to,$sujet,$message,$html=FALSE)// envoi un mail
	{

		if(!$from and !$html)
	 	{
	 		$from="From: ".$from." <".$from.">";
	 	}
	 
	 	if($html)
	 	{
	  		$from ="From: Zordania <".$from."> \n"; 
	  		$from .= "MIME-Version: 1.0\n";
			$from .= "Content-type: text/html; charset=iso-8859-1\n";
	 	}

		return mail($to,$sujet,$message,$from);
	}
	
	function set_cookie($name,$value, $time = 604800, $dir = "/")
	{
		$time = (int) $time;
		$len = strlen((string)$value);
		$value=serialize($value);
		
		///cookies pour une semaine
		//echo $name.$value;
		return setcookie($name, urlencode($value), time() + $time,$dir); ;
	}
	
	//virage de cookies
	function del_cookie($name)
	{
		return setcookie($name, "", time() - 3600, "/");
	}
	
	function read_cookie($name, $unserialize = true)
	{
		if($unserialize)
			return unserialize(urldecode($_COOKIE[$name]));
		else
			return urldecode($_COOKIE[$name]);
		
	}
}
?>
