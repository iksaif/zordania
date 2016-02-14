<if cond='|{ses_loged}| == "yes"'>
<if cond='|{ses_can_play}| == "1"'>

		<div class="menu_gauche">
		<h1>Village</h1>
			<ul>
				<li><a href="index.php?file=gen" title="Vue générale du village..">Donjon</a></li>
				<li><a href="index.php?file=btc&amp;act=btc" title="Construire des bâtiments, annuler les constructions ..">Construire</a></li>
        			<li><a href="index.php?file=btc&amp;act=use" title="Gérer le village, former des unités ...">Village</a></li>
				<li>
				<ul>
				<if cond='is_array(|{stats_prim_btc}|)'>
				<foreach cond='|{stats_prim_btc}| as |{btc_menu_type}| => |{btc_menu_array}|'>
        			<if cond='|{btc_menu_array[end]}| == "vil"'>
        				<foreach cond='|{btc_menu_array[sub]}| as |{btc_menu_sub}|'>
        				<li><a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_menu_type}&amp;sub={btc_menu_sub}" title="{btcact[{session_user[race]}][descr][{btc_menu_type}][{btc_menu_sub}]}">{btcact[{session_user[race]}][title][{btc_menu_type}][{btc_menu_sub}]}</a></li>
        				</foreach>
        			</if>
        			</foreach>
        			</if>
       				</ul>
        			</li>
				<li>------</li>
				<li><a href="index.php?file=res" 
				    OnClick="my_popup('res', '', 650,300);return false;" title="Voir les Ressources.">Ressources</a></li>					
				<li><a href="index.php?file=unt" title="Voir la Population.">Population</a></li>
				<li><a href="index.php?file=prio" title="Gestion des priorités">Priorités</a></li>	
			</ul>
		</div>
</if>		
		<div class="menu_gauche">
		<h1>Extérieur</h1>
			<ul>
			<if cond='|{ses_can_play}| == "1"'>
				<li><a href="index.php?file=carte" title="Carte de Zordania">Carte</a></li>
				<li><a href="index.php?file=leg" title="Attaques, Légions, ...">Armée</a></li>
				<if cond='is_array(|{stats_prim_btc}|)'>
				<foreach cond='|{stats_prim_btc}| as |{btc_menu_type}| => |{btc_menu_array}|'>
        			<if cond='|{btc_menu_array[end]}| == "ext"'>
        				<foreach cond='|{btc_menu_array[sub]}| as |{btc_menu_sub}|'>
        				<li><a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_menu_type}&amp;sub={btc_menu_sub}" title="{btcact[{session_user[race]}][descr][{btc_menu_type}][{btc_menu_sub}]}">{btcact[{session_user[race]}][title][{btc_menu_type}][{btc_menu_sub}]}</a></li>
        				</foreach>
        			</if>
        			</foreach>
        		</if>
        			<li>------</li>
				<li><a href="index.php?file=alliances" title="Liste des Alliances">Alliances</a></li>
				<if cond='|{session_user[alaid]}| != 0  OR |{session_user[points]}| >= |{ALL_MIN_PTS}|'>
				<li><a href="index.php?file=alliances&amp;act=my" title="Informations et Gestion de votre Alliance">Votre Alliance</a></li>
				</if>
				<li>------</li>
</if>
				<li><a href="index.php?file=member&amp;act=liste" title="Liste des Joueurs">Liste</a></li>
				<li><a href="index.php?file=member&amp;act=liste_online" title="Joueurs connectés">Liste online</a></li>
				<li><a href="index.php?file=msg" title="Envoyer/Recevoir des messages." <if cond='|{session_user[msg]}| > 0'> class="evidence"</if>>Messagerie ({session_user[msg]})</a>
			</ul>
		</div>
</if>
		<div class="menu_gauche">
		<h1>Zordania</h1>
			<ul>
				<li><a href="index.php?file=news">News</a></li>
				<li><a href="index.php?file=manual&amp;race={session_user[race]}" title="Comment jouer, Explications, Faq, etc ....">Manuel</a></li>
				<li><a href="index.php?file=faq" titl="Faq Officielle.">FAQ</a></li>
				<li><a href="index.php?file=forum">Forums</a></li>
				<li><a href="index.php?file=irc">Chat</a></li>
				<if cond='|{ses_loged}| == "yes"'>
				<li>------</li>
				<li><a href="index.php?file=notes" title="Gerez vos notes ...">Notes</a></li>
				<li><a href="index.php?file=histo" title="Evenements importants ...">Evenements</a></li>
				<li><a href="index.php?file=bonus" title="Gagner des ressources !" class="evidence">Bonus</a></li>
				<li><a href="index.php?file=session&amp;act=logout" title="Se Déconnecter ..">Déconnexion</a></li>
				<li><a href="index.php?file=member" title="Modifier mes informations personnelles ou Supprimer mon compte.">Mon compte</a></li>
				<li><a href="index.php?file=zzz" title="Mise en veille du compte.">Mise en veille</a></li>
				<li><a href="index.php?file=class" title="Classement des joueurs.">TOP 50</a></li>
				</if>
				<li>------</li>
				<li><a href="index.php?file=stat">Statistiques</a></li>
				<li><a href="index.php?file=a_propos" title="A propos du site.">A propos</a></li>
				<li>-- Fans</li>
				<li><a href="http://zordania.free.fr" title="Lieu du savoir et de la mémoire">Archives</a></li>
				<li><a href="http://faqzordania.free.fr/" title="Faq par Kazaam">FAQ</a></li>
			</ul>
		</div>
		
		<div class="menu_gauche">
		<h1>Liens</h1>
		<ul>
			<li>
				<script type="text/javascript">mtshow(683,2);</script>
			</li>
			<li>
				<script type="text/javascript">mtshow(683,10);</script>
			</li>
			<li>
				<a href="http://go.astikoo.com/XF" title="Astikoo.com - Jeux en ligne">Astikoo</a>
			</li>
			<li>
				<a href="http://www.finestown.com" title="Finestown.com - Construis ta ville">Finestown</a>
			</li>
			<li>
				<a href="http://www.guerredesgangs.com/frompartenaire-3" title="La Guerre Des Gangs">Dealer</a>
			</li>
			<li>	
				<a href="http://www.adelian.net/" title="Adelian - Ecole de magie virtuelle">Adelian</a>
			</li>
			<li>
				<a href="http://www.treaseek.com" title="TreaSeek - La Ruée vers l'Or">TreaSeek</a>
			</li>
		</ul>
		</div>
<if cond='|{ses_admin}| == "1"'>		
		<div class="menu_gauche">
		<h1>Admin</h1>
			<ul>
				<li><a href="index.php?file=admin&amp;module=news">Admin des news</a></li>
				<li><a href="index.php?file=admin">Admin</a></li>
			</ul>
		</div>
</if>
