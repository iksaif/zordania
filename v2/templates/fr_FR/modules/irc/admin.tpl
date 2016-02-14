<p class="menu_module">
[
<a href="admin.html" title="Admin">Admin</a>
]</p>

<if cond='{act} == "kill"'>
	<if cond="{pid}">
		<debug print="{lres}"/>
		<p class="ok">OK Processus PHP supprimé</p>
	</if>
	<else>Aucun processus sélectionné !</else>
</if>
<if cond='{act} == "go"'>
	<debug print="{lres}"/>
	<p class="ok">démarrage de Barnabé ...</p>
</if>

<h3>Liste des processus PHP actifs</h3>

<if cond="empty({pids})"><p class="error">Aucun processus actif !</p></if>
<else>
	<table class="liste">
	<tr>
		<foreach cond="{titre} as {value}"><th>{value}</th>
		</foreach>
		<th>SCRIPT</th>
		<th>?</th>
		<th>ACT</th>
	</tr>
	<foreach cond="{pids} as {pid} => {row}"><tr>
		<foreach cond="{row} as {value}"><td>{value}</td>
		</foreach>
		<td><a href="admin-kill.html?module=irc&amp;pid={pid}" title="KILL process"><img src="img/drop.png"/></td>
	</tr></foreach>
	</table>

	<p class="infos">ATTENTION ! ne pas supprimer le CRON</p>
</else>

<p class="menu_module">[ <a href="admin-go.html?module=irc" title="Relancer le BOT">Relancer le BOT</a> ]</p>
