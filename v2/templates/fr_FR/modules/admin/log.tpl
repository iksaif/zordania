<p class="menu_module">
<foreach cond="{arr_rep} as {rep}">
	[ <a href="admin-log.html?module=admin&amp;sub={rep}">{rep}</a> ]
</foreach>
[ <a href="admin-sql.html?module=admin">Autres infos</a> ]
</p>

<if cond="isset({sub})">
	<h3>Logs de Zordania - {sub}</h3>

	<if cond="!empty({arr_sub})"><p class="menu_module">
		<foreach cond="{arr_sub} as {rep}">
			[ <a href="admin-log.html?module=admin&amp;sub={sub}/{rep}">{rep}</a> ]
		</foreach>
	</p></if>

	<if cond="!empty({arr_fic})">
		<form method="post" action="admin-log.html?module=admin&amp;sub={sub}">
		<select name="fic">
			<foreach cond="{arr_fic} as {fic}">
				<option value="{fic}">{fic}</option>
			</foreach>
		</select>
		<input type="submit" value="Sélectionner"/>
		</form>
	</if>

	<if cond="isset({content})">
		<pre>{content}</pre>
	</if>
</if>
<else>
	<h3>Logs de Zordania</h3>
	<ul>
	<li> adm : administration, contient les fichiers de configs enregistrés</li>
	<li> crons : contient les logs php des crons, ainsi que ceux du bash / le script</li>
	<li> irc : log du chan #zordania faite par le bot lorsqu'il est online</li>
	<li> mep : log des "mises en prod" les fichiers modifiés lors des mis à jour de zordania</li>
	<li> mysql : log de erreurs BDD</li>
	<li> phperr : log des erreurs PHP</li>
	<li> autres infos = les constantes, et informations sur la BDD</li>
	</ul>
</else>
