<p class="menu_module">
<if cond='{_user[alaid]} AND {al_act} != "view"'>
[ <a href="alliances-admin.html" title="Gestion de l'Alliance">Gestion</a> ]
-
[ <a href="alliances-my.html" title="Discuter, etc ...">Table ronde</a> ]
-
[ <a href="alliances-descr_rules.html" title="Decriptifs et Règles ...">Règles</a> ]
-
[ <a href="alliances-res.html" title="Stocks de ressources ...">Grenier</a> ]
-
[ <a href="diplo-my.html" title="Gestion de la diplomatie ...">Diplomatie</a> ]
</if>
</p>
<hr />

<if cond='{al_act} == "view"'>
	<include file='modules/alliances/view.tpl' cache='1' />
</if>

<elseif cond='{al_act} == "my"'>
	<include file='modules/alliances/my.tpl' cache='1' />
</elseif>

<elseif cond='{al_act} == "descr_rules"'>
  <h3>Règles:</h3>
  {al_array[al_rules]}
  <h3>Description:</h3>
  {al_array[al_descr]}
</elseif>

<elseif cond='{al_act} == "admin"'>
	<include file='modules/alliances/chef.tpl' cache='1' />
</elseif>

<elseif cond='{al_act} == "new"'>
	<if cond='isset({al_not_enought_pts})'>
		<p class="infos">Il faut au minimum {al_not_enought_pts}pts pour créer une Alliance.</p>
	</if>
	<if cond='isset({al_not_enought_gold})'>
		<p class="infos">Il faut au minimum  {ALL_CREATE_PRICE} <img src="img/{_user[race]}/res/{GAME_RES_PRINC}.png" alt="{res[{_user[race]}][alt][{GAME_RES_PRINC}]}" title="{res[{_user[race]}][alt][{GAME_RES_PRINC}]}" /> pour créer une Alliance.</p>
	</if>
	<if cond='isset({al_name_not_correct})'>
		<p class="infos">Nom incorrect, seuls les lettres et les chiffres sont autorisés.</p>
	</if>
	<if cond='isset({al_new}) && {al_new}'>
		<p class="ok">Ok, Alliance créée.</p>
	</if>
	<else>
		<p class="error">Erreur ...</p>
	</else>
</elseif>

<elseif cond='{al_act} == "join"'>
	<include file='modules/alliances/join.tpl' cache='1' />
</elseif>

<elseif cond='{al_act} == "part"'>
	<if cond="isset({al_need_conf})">
		<div class="infos">Voulez-vous vraiment quitter cette alliance ?
		<form method="post" action="alliances-part.html">
			<input type="submit" name="ok" value="Oui" />
		</div>
 	</if>
	<else>
		<if cond='isset({al_no_al})'>
			<p class="error">Vous n'êtes pas dans une Alliance.</p>
		</if>
		<elseif cond='{al_part}'>
			<p class="ok">Ok, vous avez bien quitté cette Alliance.</p>
		</elseif>
		<else>
			<p class="infos">Le Chef d'une Alliance ne peut pas fuir !</p>
		</else>
	</else>
</elseif>

<elseif cond='{al_act} == "cancel"'>
	<if cond='{al_cancel}'>
		<p class="ok">Ok, vous avez bien annulé votre demande.</p>
	</if>
	<else>
		<p class="error">Vous ne faites aucune demande !</p>
	</else>
</elseif>

<elseif cond='{al_act} == "res" or {al_act} == "resally"'>
	<include file='modules/alliances/res.tpl' cache='1' />
</elseif>

<elseif cond='{al_act} == "reslog"'>
	<h3>Dernières actions</h3>
	<ul>
	<foreach cond="{log_array} as {result}">
	<li>
	Le {result[arlog_date_formated]} - 
		<zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/>
		- <if cond="{result[arlog_nb]} > 0"><span class="gain">{result[arlog_nb]}</span></if>
		<else><span class="perte">{result[arlog_nb]}</span></else>
		<zimgres type="{result[arlog_type]}" race="{_user[race]}" />
	</li>
	</foreach>
	</ul>
	<div class="infos">Ces chiffres concernent les actions des {HISTO_DEL_LOG_ALLY} derniers jours.</div>
	<div class="menu_module">
	[ <a href="alliances-reslog.html" title="Historique">Voir tout l'historique</a> -
	<a href="alliances-ressyn.html" title="Synthèse">Voir la synthèse</a> ]
	</div>
</elseif>

<elseif cond='{al_act} == "ressyn"'>
	<h3>Synthèse des dernières actions</h3>
	<table>
	<tr><td></td>
		<for cond="{i}=1;{i}<=17;{i}++"><th><zimgres race="{_user[race]}" type="{i}" /></th></for>
	</tr>

	<foreach cond="{tcd} as {result}">
	<tr>
		<td>
			<zurlmbr gid="{result[mbr][mbr_gid]}" mid="{result[mbr][mbr_mid]}" pseudo="{result[mbr][mbr_pseudo]}"/>
		</td>
		<foreach cond="{result[res]} as {lres}">
		<td>
			<if cond="{lres} > 0"><span class="gain">{lres}</span></if>
			<elseif cond="{lres} < 0"><span class="perte">{lres}</span></elseif>
		</td>
		</foreach>
	</tr>
	</foreach>
	</table>

	<div class="infos">Ces chiffres concernent les actions des {HISTO_DEL_LOG_ALLY} derniers jours.</div>
	<div class="menu_module">
	[ <a href="alliances-reslog.html" title="Historique">Voir tout l'historique</a> -
	<a href="alliances-ressyn.html" title="Synthèse">Voir la synthèse</a> ]
	</div>
</elseif>

<p class="retour_module">[ <a href="alliances<if cond='{al_act} == "admin" || {al_act} == "my"'>-{al_act}</if>.html">Retour</a> ]</p>
