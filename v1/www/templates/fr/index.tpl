<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<if cond='|{session_user[race]}| >= 1'>
  <load file="race/{session_user[race]}.config" />
  <load file="race/{session_user[race]}.descr.config" />
</if>
<load file="config/config.config" />
<title>Zordania - {pages[{module}]} <if cond='|{btc[{session_user[race]}][alt][{btc_id}]}|'>- {btc[{session_user[race]}][alt][{btc_id}]}</if></title>
<link rel="shortcut icon" type="image/png" href="{cfg_url}img/favicon.png" />
<link rel="icon"  type="image/png" href="/img/favicon.png" />
<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
<meta name="generator" content="Les mains de Iksaif" />
<meta name="revisit-after" content="7 days" />
<meta name="description" content="Jeu de Gestion/Stratégie dans un univers Médiéval-fantastique. Fondez un village, construisez des bâtiments pour produire des ressources, érigez votre armée et partez à la conquète de monde !" />
<meta name="keywords" content="zordania;jeu;php;medieval" />
<meta name="author" content="CHARY Corentin" />

<foreach cond="|{css}| as |{css_value}|">
	<link rel="<if cond="|{cfg_style}| !=|{css_value[1]}|">alternate </if>stylesheet" type="text/css" media="screen" title="{css_value[1]}" href="{cfg_url}css/{css_value[0]}.css" />
</foreach>

<link rel="stylesheet" type="text/css" media="handheld" title="Portables" href="{cfg_url}css/handled.css" />



<script type="text/javascript">
<!--
var cfg_url = '{cfg_url}';
-->
</script>
<script type="text/javascript" src="{cfg_url}js/functionAddEvent.js"></script>
<script type="text/javascript" src="{cfg_url}js/toolTipLib.js"></script>
<!-- <script type="text/javascript" src="{cfg_url}js/nicetitle.js"></script> -->
<script type="text/javascript" src="{cfg_url}js/script.js"></script>
<script type="text/javascript" src="http://pub.motion-twin.com/friends.js"></script>
</head>
<body>
<if cond='|{no_html}| != true'>
<div id="contenu">

	<div id="logo">
		<div class="haut">&nbsp;</div>
		<div class="centre">
			<div class="contenu">&nbsp;
				<span id="text_logo"><a href="{cfg_url}">Zordania</a> - <a href="#menu">Menu</a> - <a href="#content">Contenu</a></span>
				<h1><a href="{cfg_url}">Zordania</a></h1>&nbsp;
			</div>
		</div>
		<div class="bas">&nbsp;</div>
	</div>
	
	<div id="stats">
		<div class="haut">&nbsp;</div>
		<div class="centre">
			<div class="contenu">
				<include file="stats.tpl" cache="1" />
			</div>
		</div>
		<div class="bas">&nbsp;</div>
	</div>
	
	<div id="espace_stats_pub">&nbsp;</div>

	<div id="pub">
		<div class="haut">&nbsp;</div>
		<div class="centre">
			<div class="contenu">
				<include file="modules/session/header.tpl" cache="1" />
			</div>
		</div>
		<div class="bas">&nbsp;</div>
	</div>
	
	<div class="cleaner">&nbsp;</div>
	
	<div id="menu">
	<include file="menu.tpl" cache="1" />
	</div>
	
	<div id="espace_menu_centre">&nbsp;</div>
	
	<div id="div_page">
		<div class="haut2">&nbsp;</div>
		<div class="centre2">
			<div class="contenu2">
			

			  <a id="content"></a>
			  <if cond='|{cron_lock}| == true'>
			  <p class="infos">Calculs des tours en cours, patientez quelques minutes, puis actualisez la page ...</p>
			  <div class="block_1">{cron_lock}</div>
			  </if>
			  <if cond='|{need_to_be_loged}| == true'>
			  <p class="infos">Il faut se connecter pour accéder à cette partie du site.</p>
			  </if>
			  <if cond='|{no_cookies}| == true'>
			  <p class="infos">Il faut activer les cookies pour pouvoir profiter du site !</p>
			  </if>
			  <if cond='|{can_view_this}| == true'>
			  <p class="infos">Vous n'avez pas les droits nécessaires pour voir cette partie du site.</p>
			  </if>
			  <elseif cond='isset(|{module_tpl}|)'>
			  <h1 class="titre_module">{pages[{module}]}</h1>
			  <include file="{module_tpl}" cache="1" />
			  </elseif>

		    	</div>
		</div>
		<div class="bas2">&nbsp;</div>
	</div>
	
	<div class="cleaner">&nbsp;</div>
	
	<div id="footer">
	<ul>
   	<li>
    		<a href="http://www.php.net/">
    		<img src="img/php.png" alt="PHP Powered!" title="PHP Powered!" />
    		</a>
	</li>
	<li>
    		<a href="http://www.mysql.com/">
    		<img src="img/mysql.png" alt="MySQL Powered!" title="MySQL Powered!" />
    		</a>
	</li>
	<li>
    		<a href="http://httpd.apache.org/">
    		<img src="img/apache.png" alt="Apache Powered!" title="Apache Powered!" />
    		</a>
	</li>
	<li>
    		<a href="http://www.debian.org/">
    		<img src="img/debian.png" alt="Debian Powered!" title="Debian Powered!" />
    		</a>
	</li>
	<li>
		<a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=30257&amp;t=61">
		<img border="0" alt="Get Firefox!" title="Get Firefox!" src="img/firefox.png"/>
		</a>
	</li>
  	</ul>

	<span id="copy_and_stats">Iksaif © 2004-2005 - <a href="index.php?file=a_propos">Zordania v {ZORD_VERSION}</a> - <a href="index.php?file=a_propos&amp;act=legal">Mentions Légales</a> - {sv_nbreq} Requêtes SQL - Page générée en <math oper='round(divers::getmicrotime()-{sv_diff},4)' /> secondes <if cond="{session_user[regen]}">- Session Régénérée</if> - Smileys By <a href="http://www.deepnight.net/">Deepnight.net</a></span>
	</div>
	
</div>
</if>
<else>

  <if cond='|{need_to_be_loged}| == true'>
	  <p class="infos">Il faut se connecter pour accéder à cette partie du site.</p>
  </if>
	  
  <if cond='isset(|{module_tpl}|)'>
	  <include file="{module_tpl}" cache="1" />
  </if>
  
  <if cond='isset(|{popup}|)'>
  	<div class="close_popup infos">
  	[ 
  	<a href="javascript:self.close()" title="Fermer la fenêtre">Fermer</a>
  	]
  	</div>
  </if>
</else>
	<if cond="{sv_site_debug}">
	<include file="debug.tpl" cache="1" />
	</if>
</body>
</html>