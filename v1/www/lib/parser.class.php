<?
$GLOBALS['smileys'] = array(
				':)'		=> 's01.png',
				':-)'		=> 's01.png',	
				':p'		=> 's02.png',
				':??:'		=> 's03.png',
				':???:'		=> 's03.png',
				':!!:'		=> 's04.png',
				':!!!:'		=> 's04.png',
				':garde:' 	=> 's05.png',
				'^_^'		=> 's06.png',
				'^^'		=> 's06.png',
				':><:'		=> 's07.png',
				':chevalier:'	=> 's08.png',
				';)' 		=> 's09.png',
				';o)'		=> 's09.png',
				':/' 		=> 's10.png',
				':-°'		=> 's11.png',
				':-*'		=> 's11.png',
				':(' 		=> 's12.png',
				':\'(' 		=> 's12.png',
				':|' 		=> 's10.png',
				'<_<'		=> 's13.png',
				'-_-'		=> 's13.png',
				':lol:'		=> 's15.png',
				':D'		=> 's14.png'
				);
class parser
{

	//html = true
	//autorise de metre du html
	//html = false
	//interdit l'usage de html

	function parse($txt, $html=false,$light = false)
	{
		$txt=htmlentities($txt, ENT_QUOTES);
		

		if(!$light) $txt = preg_replace( "#\[code\](.+?)\[/code\]#ies", "parser::regex_code_tag('\\1')", $txt );
		$txt = preg_replace( "#(^|\s)((http|https|news|ftp)://\w+[^\s\[\]]+)#ie"  , "parser::regex_build_url(array('html' => '\\2', 'show' => '\\2', 'st' => '\\1'))", $txt );
		$txt = preg_replace( "#\[url\](\S+?)\[/url\]#ie"                                       , "parser::regex_build_url(array('html' => '\\1', 'show' => '\\1'))", $txt );
		$txt = preg_replace( "#\[url\s*=\s*\&quot\;\s*(\S+?)\s*\&quot\;\s*\](.*?)\[\/url\]#ie" , "parser::regex_build_url(array('html' => '\\1', 'show' => '\\2'))", $txt );
		$txt = preg_replace( "#\[url\s*=\s*(\S+?)\s*\](.*?)\[\/url\]#ie"                       , "parser::regex_build_url(array('html' => '\\1', 'show' => '\\2'))", $txt );
		$txt = preg_replace("/\[b\](.*?)\[\/b\]/si","<strong>$1</strong>",$txt);
		$txt = preg_replace("/\[i\](.*?)\[\/i\]/si","<em>$1</em>",$txt);
		if(!$light) $txt = preg_replace( "#\[img\](.+?)\[/img\]#ie" , "parser::regex_check_image('\\1')", $txt );
		
		if(!$light) $txt = preg_replace( "#\[quote=(.*?)\](.*?)\[/quote\]#ies" , "parser::regex_parse_quotes('\\2','\\1')"  , $txt );
		if(!$light) $txt = preg_replace( "#\[quote\](.*?)\[/quote\]#ies" , "parser::regex_parse_quotes('\\1')"  , $txt );
		
		
		if(!$light) $txt = preg_replace( "#\[modo\](.*?)\[/modo\]#is", "[color=#1E90FF]\\1[/color]",$txt);
		if(!$light) $txt = preg_replace( "#\[!\](.*?)\[/!\]#is", "[color=#FFC800]\\1[/color]",$txt);
		while( preg_match( "#\[color=([^\]]+)\](.+?)\[/color\]#ies", $txt ) )
		{
			$txt = preg_replace( "#\[color=([^\]]+)\](.+?)\[/color\]#ies"  , "parser::regex_font_attr(array('s'=>'col' ,'1'=>'\\1','2'=>'\\2'))", $txt );
		}
			
		while( preg_match( "#\n?\[list\](.+?)\[/list\]\n?#ies" , $txt ) )
		{
			$txt = preg_replace( "#\n?\[list\](.+?)\[/list\]\n?#ies", "parser::regex_list('\\1')" , $txt );
		}
		
		while( preg_match( "#\n?\[list=(a|A|i|I|1)\](.+?)\[/list\]\n?#ies" , $txt ) )
		{
			$txt = preg_replace( "#\n?\[list=(a|A|i|I|1)\](.+?)\[/list\]\n?#ies", "parser::regex_list('\\2','\\1')" , $txt );
		}
    		foreach ( $GLOBALS['smileys'] as $key=>$contenu )
		{
			if(!$light) $txt = str_replace(" ".$key,' <img alt="'.$key.'" src="'.SITE_URL.'img/smile/'.$contenu.'" />',$txt);
		}
		$txt=nl2br($txt);
		$txt.=" ";
		return $txt;
	}
	
	function unparse($txt)
	{
		$txt = preg_replace( "#<table class=\"center quote\"><tr><th>QUOTE</th></tr><tr><td>(.*?)</td></tr></table>#s","\[QUOTE\]\\1[\/QUOTE\]",$txt);
		
		$txt = preg_replace( "#<div class=\"quote\"><strong>(.*?)</strong><br/>(.*?)</div>#s","\[QUOTE=\\1\]\\2[\/QUOTE\]",$txt);
		$txt = preg_replace( "#<div class=\"quote\">(.*?)</div>#s","\[QUOTE\]\\1[\/QUOTE\]",$txt);
		
		$txt = preg_replace( "#<div class=\"code\"><h5>Code</h5>(.*?)</div>#s","\[CODE\]\\1[\/CODE\]",$txt);
		
		$txt=preg_replace("/<strong>(.*?)\<\/strong>/si","[b]$1[/b]",$txt);
		$txt=preg_replace("/<em>(.*?)\<\/em>/si","[i]$1[/i]",$txt);
		$txt = preg_replace( "#(\n){0,}<ul>#" , "\\1\[LIST\]"  , $txt );
		$txt = preg_replace( "#(\n){0,}<ol type='(a|A|i|I|1)'>#" , "\\1\[LIST=\\2\]\n"  , $txt );
		$txt = preg_replace( "#(\n){0,}<li>#" , "\n\[*\]"     , $txt );
		$txt = preg_replace( "#(\n){0,}</ul>(\n){0,}#", "\n\[/LIST\]\\2" , $txt );
		$txt = preg_replace( "#(\n){0,}</ol>(\n){0,}#", "\n\[/LIST\]\\2" , $txt );
		$txt = preg_replace( "#<a href=[\"'](http://|https://|ftp://|news://)?(\S+?)['\"]>(.+?)</a>#" , "\[URL=\\1\\2\]\\3\[/URL\]"  , $txt );
		$txt = str_replace( "</li>", "", $txt );
		$txt = preg_replace( "#<img src=[\"'](\S+?)['\"].+?".">#"           , "\[IMG\]\\1\[/IMG\]"            , $txt );

		
		while ( preg_match( "#<span style=['\"]color:(.+?)['\"]>(.+?)</span>#is", $txt ) )
		{
			$txt = preg_replace( "#<span style=['\"]color:(.+?)['\"]>(.+?)</span>#is"    , "\[color=\\1\]\\2\[/color\]", $txt );
		}
			
		$txt=str_replace("<br />","",$txt);
		$txt=str_replace("\n\n","",$txt);
		//$txt=str_replace("\\'","'",$txt);

			
		foreach ( $GLOBALS['smileys'] as $key=>$contenu )
		{
			$txt = str_replace('<img alt="'.$key.'" src="'.SITE_URL.'img/smile/'.$contenu.'" />',$key,$txt);
		}
		
		return trim(stripslashes($txt));
	}
	
	function regex_build_url($url=array())
	{
		$skip_it = 0;
		
		//-----------------------------------------
		// Make sure the last character isn't punctuation..
		// if it is, remove it and add it to the
		// end array
		//-----------------------------------------
		
		if ( preg_match( "/([\.,\?]|&#33;)$/", $url['html'], $match) )
		{
			$url['end'] .= $match[1];
			$url['html'] = preg_replace( "/([\.,\?]|&#33;)$/", "", $url['html'] );
			$url['show'] = preg_replace( "/([\.,\?]|&#33;)$/", "", $url['show'] );
		}
		
		//-----------------------------------------
		// Make sure it's not being used in a
		// closing code/quote/html or sql block
		//-----------------------------------------
		
		if (preg_match( "/\[\/(quote|code)/i", $url['html']) )
		{
			return $url['html'];
		}
		
		//-----------------------------------------
		// clean up the ampersands / brackets
		//-----------------------------------------
		
		$url['html'] = str_replace( "&amp;" , "&"   , $url['html'] );
		$url['html'] = str_replace( "["     , "%5b" , $url['html'] );
		$url['html'] = str_replace( "]"     , "%5d" , $url['html'] );
		
		//-----------------------------------------
		// Make sure we don't have a JS link
		//-----------------------------------------
		
		$url['html'] = preg_replace( "/javascript:/i", "java script&#58; ", $url['html'] );
		
		//-----------------------------------------
		// Do we have http:// at the front?
		//-----------------------------------------
		
		if ( ! preg_match("#^(http|news|https|ftp|aim)://#", $url['html'] ) )
		{
			$url['html'] = 'http://'.$url['html'];
		}
		
		//-----------------------------------------
		// Tidy up the viewable URL
		//-----------------------------------------

		if (preg_match( "/^<img src/i", $url['show'] )) $skip_it = 1;

		$url['show'] = preg_replace( "/&amp;/" , "&" , $url['show'] );
		$url['show'] = preg_replace( "/javascript:/i", "javascript&#58; ", $url['show'] );
		
		if ( (strlen($url['show']) -58 ) < 3 )  $skip_it = 1;
		
		//-----------------------------------------
		// Make sure it's a "proper" url
		//-----------------------------------------
		
		if (!preg_match( "/^(http|ftp|https|news):\/\//i", $url['show'] )) $skip_it = 1;
		
		$show     = $url['show'];
		
		if ($skip_it != 1)
		{
			$stripped = preg_replace( "#^(http|ftp|https|news)://(\S+)$#i", "\\2", $url['show'] );
			$uri_type = preg_replace( "#^(http|ftp|https|news)://(\S+)$#i", "\\1", $url['show'] );
			
			$show = $uri_type.'://'.substr( $stripped , 0, 35 ).'...'.substr( $stripped , -15   );
		}
		
		return $url['st'] . "<a href=\"".$url['html']."\">".$show."</a>" . $url['end'];
		
	}
	
	function regex_list( $txt="", $type="" )
	{
		if ($txt == "")
		{
			return;
		}
		
		//$txt = str_replace( "\n", "", str_replace( "\r\n", "\n", $txt ) );
		
		if ( $type == "" )
		{
			// Unordered list.
			
			return "<ul>".parser::regex_list_item($txt)."</ul>";
		}
		else
		{
			return "<ol type=\"$type\">".parser::regex_list_item($txt)."</ol>";
		}
	}
	
	function regex_list_item($txt)
	{
		$txt = preg_replace( "#\[\*\]#", "</li><li>" , trim($txt) );
		
		$txt = preg_replace( "#^</?li>#"  , "", $txt );
		
		return str_replace( "\n</li>", "</li>", $txt."</li>" );
	}
	
	function regex_check_image($url="") {
		
		if (!$url) return;
		
		$url = trim($url);
		
		$default = "[img]".$url."[/img]";
		
		// Are they attempting to post a dynamic image, or JS?
		
		if (preg_match( "/[?&;]/", $url))
		{
			return $default;
		}
		if (preg_match( "/javascript(\:|\s)/i", $url ))
		{
			return $default;
		}
		
		// Is the img extension allowed to be posted?
		
		$extension = preg_replace( "#^.*\.(\S+)$#", "\\1", $url );
			
		$extension = strtolower($extension);
		
		if ( (! $extension) OR ( preg_match( "#/#", $extension ) ) )
		{
			return $default;
		}
		
		$ibforums->vars['img_ext'] = strtolower($ibforums->vars['img_ext']);
		
		$img_ext = "png|jpg|gif";
		if (!preg_match( "/".preg_quote($extension, '/')."(\||$)/", $img_ext ))
		{
			return $default;
		}
		
		// Is it a legitimate image?
		
		if (!preg_match( "/^(http|https|ftp):\/\//i", $url )) {
			return $default;
		}
		
		// If we are still here....
		
		$url = str_replace( " ", "%20", $url );
		
		return "<img src=\"$url\" border=\"0\" alt=\"user posted image\" />";
	}
	
	function regex_parse_quotes($txt="",$from="") 
	{
		$default = "\[quote\]$txt\[/quote\]";

		if ($txt == "") return;
		
		if (preg_match( "/\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\]/i", $txt) ) {
			return $default;
		}
		
		$return = '<div class="quote">';
		if($from)
			$return.= '<strong>'.$from.'</strong><br/>';

		$return.= $txt;
		$return.= '</div>';
		
		return $return;
		
	}
	
	function regex_code_tag($txt="")
	{	
		$default = "\[code\]$txt\[/code\]";
		
		if ($txt == "") return;
		
		//-----------------------------------------
		// Too many embedded code/quote/html/sql tags can crash Opera and Moz
		//-----------------------------------------
		
		if (preg_match( "/\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\].+?\[(quote|code)\]/i", $txt) ) {
			return $default;
		}
		
		//-----------------------------------------
		// Take a stab at removing most of the common
		// smilie characters.
		//-----------------------------------------
		
		//$txt = str_replace( "&" , "&amp;", $txt );
		$txt = preg_replace( "#&lt;#"   , "&#60;", $txt );
		$txt = preg_replace( "#&gt;#"   , "&#62;", $txt );
		$txt = preg_replace( "#&quot;#" , "&#34;", $txt );
		$txt = preg_replace( "#:#"      , "&#58;", $txt );
		$txt = preg_replace( "#\[#"     , "&#91;", $txt );
		$txt = preg_replace( "#\]#"     , "&#93;", $txt );
		$txt = preg_replace( "#\)#"     , "&#41;", $txt );
		$txt = preg_replace( "#\(#"     , "&#40;", $txt );
		$txt = preg_replace( "#\r#"     , "<br />", $txt );
		$txt = preg_replace( "#\n#"     , "<br />", $txt );
		$txt = preg_replace( "#\s{1};#" , "&#59;", $txt );
		
		//-----------------------------------------
		// Ensure that spacing is preserved
		//-----------------------------------------
		
		$txt = preg_replace( "#\s{2}#", " &nbsp;", $txt );

		$return = '<div class="code">';
		$return.= '<h5>Code</h5>';
		$return.= $txt;
		$return.= '</div>';
		
		return $return;
		
	}
	function regex_font_attr($IN)
	{
		if (!is_array($IN)) return "";
		
		//-----------------------------------------
		// Trim out stoopid 1337 stuff
		// [color=black;font-size:500pt;border:orange 50in solid;]hehe[/color]
		//-----------------------------------------
		
		if ( preg_match( "/;/", $IN['1'] ) )
		{
			$attr = explode( ";", $IN['1'] );
			
			$IN['1'] = $attr[0];
		}
		
		$IN['1'] = preg_replace( "/[&\(\)\.\%]/", "", $IN['1'] );
		
		if ($IN['s'] == 'size')
		{
			$IN['1'] = $IN['1'] + 7;
			
			if ($IN['1'] > 30)
			{
				$IN['1'] = 30;
			}
			
			return "<span style=\"font-size:".$IN['1']."pt;line-height:100%\">".$IN['2']."</span>";
		}
		else if ($IN['s'] == 'col')
		{
			return "<span style=\"color:".$IN['1']."\">".$IN['2']."</span>";
		}
		else if ($IN['s'] == 'font')
		{
			return "<span style=\"font-family:".$IN['1']."\">".$IN['2']."</span>";
		}
	}
}
?>