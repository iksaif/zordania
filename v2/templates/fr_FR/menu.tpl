<if cond='{ses_loged}'> 
<if cond='{ses_can_play} AND {ses_mbr_etat_ok}'>

<div class="menu_gauche">
<h2><label for="menu1">Village</label></h2>
<input id="menu1" name="menu" type="radio" />
	<ul>
	<foreach cond='{stats_prim_btc[vil]} as {btc_menu_type} => {btc_menu_array}'>
		<foreach cond='{btc_menu_array} as {btc_menu_sub}'>
		<li><a href="btc-use.html?btc_type={btc_menu_type}&amp;sub={btc_menu_sub}" title="{btcact[{_user[race]}][descr][{btc_menu_type}][{btc_menu_sub}]}">{btcact[{_user[race]}][title][{btc_menu_type}][{btc_menu_sub}]}</a></li>
		</foreach>
	</foreach>
	<li>---</li>
	<li><a href="alliances.html" title="Liste des Alliances.">Alliances</a></li>
	<li><a href="class.html" title="Classement des Joueurs.">TOP 50</a></li>
	<li>
		<a href="member-liste.html" title="Liste des Joueurs.">Joueurs</a>
		(<a href="member-liste_online.html" title="Joueurs connectés.">online</a>)
	</li>
	<li><a href="bonus.html" title="Gagner des ressources !" class="bonus">Bonus</a></li>
	<li><a href="votes.html" title="Votez pour Zordania !" class="votes">Votes</a></li>
	</ul>
</div>

</if>
</if>

<div class="menu_gauche">
<h2><label for="menu2">Zordania</label></h2>
<input id="menu2" name="menu" type="radio" />
	<ul>
		<if cond='!{ses_can_play} OR !{ses_mbr_etat_ok}'>
		<li><a href="presentation.html" title="Présentation.">Accueil</a></li>
		</if>
		<li><a href="news.html" title="Voir les dernières news.">News</a></li>
		<li><a href="manual.html?race={_user[race]}" title="Comment jouer ?">Manuel</a> (<a href="http://www.zordania.com/forum-post.html?tid=2925" title="Foire aux Questions.">FAQ</a>)</li>
		<li><a href="forum.html" title="Participer à la vie de la communauté.">Forums</a></li>
		<li><a href="irc.html" title="Discuter directement entre Zordaniens !">Chat</a></li>
		<li><a href="sdg.html" title="Faites connaître votre avis !">Sondages</a></li>
		<li><a href="a_propos.html" title="A propos du site.">A propos</a></li>
		<li><a href="http://{ZORDLOG_URL}" title="Lieu du savoir et de la mémoire.">Archives</a></li>
		<if cond='{ses_loged}'>
		<li><a href="stat.html" title="Zordania en chiffres.">Statistiques</a></li>
		<li>---</li>
		<li><a href="member.html" title="Modifier mes informations personnelles ou Supprimer mon compte.">Mon compte</a></li>
		<li><a href="session-logout.html?display=module" title="Se déconnecter...">Déconnexion</a></li>
		</if>
	</ul>
</div>

<div class="menu_gauche">
<h2><label for="menu3">Liens</label></h2>
<input id="menu3" name="menu" type="radio" />
<ul>
	<li>
		<a href="https://twitter.com/Zordania" title="Twittes pour Zordania!">Twitter</a>
	</li>
	<li>
		<a href="https://fr-fr.facebook.com/zordania2015" title="Facebook">Facebook</a>
	</li>
	<li>
		<a href="http://www.tourdejeu.net/annu/fichejeu.php?id=9167" title="tourdejeu">tourdejeu.net</a>
	</li>
	<li>
		<a href="http://www.jeux-web.com/" title="La communauté des joueurs de jeux en ligne alternatifs">Jeux-Web.com</a>
	</li>
</ul>
</div>
