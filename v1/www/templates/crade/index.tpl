<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<if cond='|{session_user[race]}| >= 1'><load file="race/{session_user[race]}.config" /><load file="race/{session_user[race]}.descr.config" /></if><load file="config/config.config" />
<title>Zordania - {pages[{module}]}<if cond='|{btc[alt][{btc_id}]}|'>- {btc[alt][{btc_id}]}</if></title>
<link rel="shortcut icon" type="image/png" href="{cfg_url}img/favicon.png" />
<link rel="icon"  type="image/png" href="/img/favicon.png" />
<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
<meta name="generator" content="Les mains de Iksaif" />
<meta name="revisit-after" content="7 days" />
<meta name="description" content="Jeu de Gestion/Stratégie dans un univers Médiéval-fantastique. Fondez un village, construisez des bâtiments pour produire des ressources, érigez votre armée et partez à la conquète de monde !" />
<meta name="keywords" content="zordania;jeu;php;medieval" />
<meta name="author" content="CHARY Corentin" />
<link rel="<if cond="|{cfg_style}| !='Marron'">
alternate</if>stylesheet"type="text/css"media="screen"title="Marron"href="{cfg_url}css/marron.css"/>
<link rel="<if cond="|{cfg_style}| !='Classik'">
alternate</if>stylesheet"type="text/css"media="screen"title="Classik"href="{cfg_url}css/classik.css"/>
<link rel="<if cond="|{cfg_style}| !='Pixel'">
alternate</if>stylesheet"type="text/css"media="screen"title="Pixel"href="{cfg_url}css/pixel.css"/>
<link rel="<if cond="|{cfg_style}| !='Metal'">
alternate</if>stylesheet"type="text/css"media="screen"title="Metal"href="{cfg_url}css/metal.css"/>
<link rel="<if cond="|{cfg_style}| !='Vide'">
alternate</if>stylesheet"type="text/css"media="screen"title="Vide"href="{cfg_url}css/rien.css"/>
<link rel="stylesheet" type="text/css" media="handheld" title="Portables" href="{cfg_url}css/handled.css" />
<base href="{cfg_url}" />
<script type="text/javascript">
<!--
var cfg_url = '{cfg_url}';
-->
</script>
<script type="text/javascript" src="{cfg_url}js/nicetitle.js"></script>
<script type="text/javascript" src="{cfg_url}js/script.js"></script>
</head><body> 
<if cond='|{no_html}| != true'> 
<div id="amour"><a href="http://www.amour-propre.com"><img src="img/amour_propre.png" width="140" height="10" alt="Amour-Propre.com" title="Amour-Propre.com - Devenez webophile" /></a> <a href="{cfg_ap_news[url]}">{cfg_ap_news[texte]}</a></div> 
<table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
  <tr> 
    <td valign="top" width="250"><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
        <tr> 
          <td><include file="stats.tpl" cache="1" /></td> 
        </tr> 
        <tr> 
          <td><include file="menu.tpl" cache="1" /></td> 
        </tr> 
      </table></td> 
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
        <tr> 
          <td> <span id="text_logo"><a href="{cfg_url}">Zordania</a> - <a href="#menu">Menu</a> - <a href="#content">Contenu</a></span> 
            <h1><a href="{cfg_url}">Zordania</a></h1> 
  </td> 
        </tr> 
        <tr> 
          <td><include file="modules/session/header.tpl" cache="1" /></td> 
        </tr> 
        <tr> 
          <td> <a id="content"></a> <if cond='|{cron_lock}| == true'> 
            <p class="infos">Calculs des tours en cours, patientez quelques secondes, puis actualisez la page ...</p> 
            </if> <if cond='|{need_to_be_loged}| == true'> 
            <p class="infos">Il faut se connecter pour accéder à cette partie du site.</p> 
            </if> <if cond='|{no_cookies}| == true'> 
            <p class="infos">Il faut activer les cookies pour pouvoir profiter du site !</p> 
            </if> <if cond='|{can_view_this}| == true'> 
            <p class="infos">Vous n'avez pas les droits nécessaires pour voir cette partie du site.</p> 
            </if> <elseif cond='isset(|{module_tpl}|)'> 
            <h1 class="titre_module">{pages[{module}]}</h1> 
            <include file="{module_tpl}" cache="1" /> </elseif></td> 
        </tr> 
      </table></td> 
  </tr> 
</table> 
<div id="footer"> 
  <ul> 
    <li> <a href="http://www.php.net/"> <img src="img/php-power-black.png" alt="PHP Powered!" title="PHP Powered!" height="31" width="88" /> </a> </li> 
    <li> <a href="http://www.mysql.com/"> <img src="img/powered-by-mysql.png" alt="MySQL Powered!" title="MySQL Powered!" height="31" width="88" /> </a> </li> 
    <li> <a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=30257&amp;t=61"> <img border="0" alt="Get Firefox!" title="Get Firefox!" src="img/firefox.png"/> </a> </li> 
  </ul> 
  <span id="copy_and_stats">Iksaif © 2004-2005 - Zordania v {ZORD_VERSION} - <a href="index.php?file=a_propos&amp;act=legal">Mentions Légales</a> - {sv_nbreq} Requêtes SQL - Page générée en <math oper='round(divers::getmicrotime()-{sv_diff},4)' /> secondes - Smileys By <a href="http://www.deepnight.net/">Deepnight.net</a></span> </div> 
</div> 
</if> <else> <if cond='|{need_to_be_loged}| == true'> 
<p class="infos">Il faut se connecter pour accéder à cette partie du site.</p> 
</if> <if cond='isset(|{module_tpl}|)'> <include file="{module_tpl}" cache="1" /> </if> <if cond='isset(|{popup}|)'> 
<div class="close_popup infos"> [ <a href="javascript:self.close()" title="Fermer la fenêtre">Fermer</a> ] </div> 
</if> </else> <if cond="{sv_site_debug}"> <include file="debug.tpl" cache="1" /> </if> 
</body>
</html>
