<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<load file="config/config.config" />
	<title>Zordania</title>
	<link rel="shortcut icon" type="image/png" href="img/favicon.png" />
	<link rel="icon"  type="image/png" href="img/favicon.png" />
	<meta content="text/html; charset=utf-8 http-equiv=Content-Type" />
	<meta name="generator" content="Les mains de Iksaif" />
	<meta name="revisit-after" content="7 days" />
	<meta name="description" content="Jeu de Gestion/Stratégie dans un univers Médiéval-Fantastique. Fondez un village, construisez des bâtiments pour produire des ressources, érigez votre armée et partez à la conquête du monde !" />
	<meta name="keywords" content="zordania;jeu;php;medieval;orc;humain;nain;drow;elfe" />
	<meta name="author" content="CHARY Corentin" />

	<link rel="stylesheet" type="text/css" media="screen" title="{css[{_user[design]}][1]}" href="skin/{css[{_user[design]}][0]}/style.css" />
	<script language="JavaScript" type="text/javascript" src="js/thumbnailviewer.js"></script>
</head>
<body>
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

	<div id="connec">
		<div class="haut">&nbsp;</div>
		<div class="centre">
			<div class="contenu">
				<div id="log">
				<form action="module--session-login.html" method="post">
				<label for="login">Login</label>
				<input name="login" id="login" type="text" />
				<label for="pass">Password</label>
				<input name="pass" id="pass" type="password" />
				<input type="submit" value="Connexion" />
				</form>
				<br/>
				[ <a href="inscr-new.html" title="S'inscrire !">Inscription</a>
				] - [
				<a href="inscr-newpass.html" title="Récupérer son mot de passe."> Mot de Passe perdu </a>
				]
				<br/>
				</div>
				<hr />
				
				<img style="float: right;" src="img/5/btc/24.png" alt="Elfes" title="Elfes" />
				<h3>Aperçu de Zordania</h3>
				<img style="float: left;" src="img/3/btc/21.png" alt="Nains" title="Nains" />
				<br />
				<p>
					Incarnez un grand roi pour mener votre civilisation vers la victoire... ou la ruine !<br/>
					Partez en croisades, repoussez des hordes de barbares, commercez avec des milliers d'autres seigneurs, créez ou rejoignez des alliances et assurez la suprématie de votre empire !
				</p>

				<p>
					Zordania est un jeu de stratégie médiévale où vous gérez tous les aspects de votre cité que ce soit au niveau économique ou militaire et même diplomatique.
					<br/>Choisissez votre race et incarnez un seigneur des terres froides du nord ou du désert aride du sud, votre seule possibilité de victoire : votre stratégie.
				</p>
				
				<img style="float: left;" src="img/2/btc/18.png" alt="Orcs" title="Orcs" />
				<img style="float: right;" src="img/4/btc/24.png" alt="Drows" title="Drows" />
				<br />
				
					<a href="img/portail/village.png" rel="thumbnail" title="Un magnifique village Nain!">
					<img style="margin-left: 36px;" border="0" src="img/portail/village.png" width="100" height="75"> </a>
				
			
					<a href="img/portail/recherche.png" rel="thumbnail" title="Les premières recherches des Orcs.">
					<img border="0" src="img/portail/recherche.png" width="100" height="75"> </a> 
				
				
					<a href="img/portail/unite.png" rel="thumbnail" title="Les unités de base des Drows.">
					<img border="0" src="img/portail/unite.png" width="100" height="75"> </a>
				
				
					<a href="img/portail/arbre.png" rel="thumbnail" title="Une partie de l'arbre de developpement des Elfes.">
					<img border="0" src="img/portail/arbre.png" width="100" height="75"> </a>
				
				
					<a href="img/portail/carte.png" rel="thumbnail" title="Quelques villages sur la carte.">
					<img border="0" src="img/portail/carte.png" width="100" height="75"> </a>
				

				<h3 style="margin-top: 35px;">Et Maintenant ?</h3>

				<p>
					<a href="inscr.html" title="S'inscrire !">Inscrivez-vous !</a> L'inscription est rapide, gratuite et sans engagement ! Et si vous voulez de plus amples informations à propos du jeu, vous pouvez consulter notre <a href="presentation-presentation.html" title="Inscription">Présentation Détaillée</a>
					ainsi que notre <a href="manual.html" title="Comment jouer ?">Manuel</a> ou lire les dernières <a href="news.html" title="Voir les dernières news.">News</a> ou, enfin, arpenter nos <a href="forum.html" title="Participer à la vie de la communauté.">Forums</a>.
				</p>
		    	</div>
		</div>
		<div class="bas">&nbsp;</div>
	</div>

	<div id="footer">
	<include file="footer.tpl" cache="1" />
	</div>
	
</div>
</body>
</html>
