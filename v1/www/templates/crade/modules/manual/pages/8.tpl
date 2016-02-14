<h3>Intro</h3>
<p>
Vous pouvez commencer à attaquer d'autres joueurs à partir de {ATQ_PTS_MIN} points.<br/>
Vous ne pouvez attaquer que les joueurs ayant votre nombre de points ({session_user[points]}) +- {ATQ_PTS_DIFF}.
<br/>
Les unités de combats ont des caractéristiques spécifiques :<br/>
<dl>
	<dt>Vie</dt>
	<dd>La vie de l'unité</dd>
	<dt>Défense</dt>
	<dd>Les points de dommage que l'unité infligera si elle est attaquée.</dd>
	<dt>Attaque</dt>
	<dd>Les points de dommage que l'unité infligera si elle attaque des unités.</dd>
	<dt>Attaque Bâtiments</dt>
	<dd>Les points de dommage que l'unité infligera si elle attaque des bâtiments.</dd>
	<dt>Vitesse</dt>
	<dd>Vitesse de déplacement sur la carte.</dd>
</dl>
<br/>
Certains Bâtiments ont aussi des points de défense.<br/>
<br>
Infos about l'issue finale d'une attaque:
<dl>
	<dt><span class="victoire">victoire</span></dt>
	<dd>Vous perdez {ATQ_PERC_DEF}% de vos soldats au maximum, et tuez {ATQ_PERC_WIN}% des soldats ennemis au maximum</dl>
	<dt><span class="defaite">Défaite</span></dt>
	<dd>Vous perdez {ATQ_PERC_WIN}% de vos soldats au maximum, et tuez {ATQ_PERC_DEF}% des soldats ennemis au maximum</dl>
	<dt><span class="defaite">Défaite Partielle</span></dt>
	<dd>Vous perdez {ATQ_PERC_NUL}% de vos soldats au maximum.</dl>	
	<dt>Butin (pour celui qui attaque)</dt>
	<dd>
		<dl>
		<dt>Cas d'attaque sur des soldats</dt>
		<dd>Une des ressources nécessaires pour former les unités tuées * nombre de tués</dd>
		<dt>Cas d'attaque sur des bâtiments</dt>
		<dd>Une des ressources nécessaires pour construire le bâtiment * un nombre bizarre que j'expliquerais pas.</dd>
		</dl>
	</dd>
	<dt>Butin (pour celui qui se fait attaquer)</dt>
	<dd>
		<dl>
		<dt>Victoire</dt>
		<dd>Une des ressources nécessaires pour former les unités tuées * nombre de tués</dd>
		<dt>Défaite</dt>
		<dd>Une des ressources nécessaires pour former les unités tuées * 0.6</dd>
		</dl>
	</dd>
	</dd></dl>
	<dt>Bonus</dt>
	<dd>Certaines unités donnent un bonus d'attaque ou de défense. Il marche comme ceci :
	<br/>
	<code>
	Si Bonus_Total > {GAME_MAX_UNT_BONUS}<br/>
	Alors Bonus_Total = {GAME_MAX_UNT_BONUS}<br/>
	Bonus = (Points_De_Dommage / 100) * Bonus_Total<br/>
	Points_De_Domage = Points_De_Domage + Bonus
	</code>
	</dd>
	<dt>Expérience</dt>
	<dd>
	<code>
	Si Victoire<br/>
	  atq_xp = 3<br/>
	Sinon<br/>
	  atq_xp = 1<br/>
	  <br/>
	atq_xp = round(nombre_bâtiment_détruits + nombre_tues / 100) + atq_xp
	</code>
	</dd>
	<dt>Espionnage</dt>
	<dd>
	Il est possible d'espionner les adversaires pour obtenir des estimations de leur défense.<br/>
	Cette à plus de chance de réussir si la légion est rapide !
	</dd>
	<dt>dégâts Max par jour</dt>
	<dd>
	Pour éviter de se faire massacrer en un seul jour, une limite journalière de points de dégâts a été instaurée.
	Ainsi un joueur ne pourra subir plus de {ATQ_PTS_MAX_PER_DAY}+ [Points] /10.
	</dd>
</dl>		
</p>
<hr />
<h3>Attaque</h3>
<p>
Une bataille se déroule en 3 actes :<br/>
<dl>
	<dt>
	Le Déplacement
	</dt>
	<dd>
	Vous choisissez un joueur à attaquer, et pendant un temps défini par la distance entre vous et lui et la moyenne des vitesses des unités de la légion qui attaque, la légion se déplace jusqu'a lui.
	<br/>
	Chaque tour la légion peu avancer  de x (vitesse de la légion) nombre de cases, que ce soit en diagonale ou en ligne droite.
	</dd>
	<dt>L'Attaque</dt>
	<dd>
	Une fois la légion arrivée, vous devez lui donner l'ordre d'attaquer.<br/>
	Ici il y'a deux possibilitées :
	<ul>
		<li>
		Le Village est défendu par des soldats, dans ce cas vous attaquez les soldats.
		<ul>
			<li>La somme de vos points d'attaque est supérieure à la somme des points de défense de l'ennemi : <span class="victoire">Victoire</span></li>
			<li>La somme de vos points d'attaque est inférieure à la somme des points de défense de l'ennemi : <span class="defaite">Défaite</span></li>
		</ul>
		</li>
		<li>
		Le Village n'est pas défendu, vous attaquez les bâtiments ({ATQ_MAX_BTC} au maximum). Apres chaque bâtiments attaqués, la force d'attaque restante est divisée par deux.
		<ul>
			<li>La somme de vos points d'attaque est supérieure à la somme des points de défense de l'ennemi : <span class="victoire">Victoire</span></li>
			<li>La somme de vos points d'attaque est inférieure à la somme des points de défense de l'ennemi mais vous détruisez un bâtiment : <span class="defaite">Défaite partielle</span></li>
			<li>La somme de vos points d'attaque est inférieure à la somme des points de défense de l'ennemi : <span class="defaite">Défaite</span></li>
		</ul>
		</li>
	</ul>
	</dd>
	<dt>Retour au village</dt>
	<dd>Même chose qu'au début</dd>
</dl>
</p>