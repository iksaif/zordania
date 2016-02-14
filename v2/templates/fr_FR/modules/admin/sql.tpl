<p class="menu_module">
<foreach cond="{arr_rep} as {rep}">
	[ <a href="admin-log.html?module=admin&amp;sub={rep}">{rep}</a> ]
</foreach>
[ <a href="admin-sql.html?module=admin">Autres infos</a> ]
</p>

<h3>Configuration des combats</h3>

<table>
<th>CONSTANTE</th>
<th>valeur</th>
<tr>
<th>ATQ_MAX_NB24H </th><td>= {ATQ_MAX_NB24H} Nb d'attaques par jour</td>
</tr><tr>
<th>ATQ_PTS_DIFF </th><td>= {ATQ_PTS_DIFF} Trop de points de différences</td>
</tr><tr>
<th>ATQ_PTS_MIN </th><td>= {ATQ_PTS_MIN} Pas assez de points armée pour attaquer</td>
</tr><tr>
<th>ATQ_LIM_DIFF </th><td>= {ATQ_LIM_DIFF} Arène  =>  dépends des points armée</td>
</tr><tr>
<th>ATQ_RATIO_COEF_ATQ </th><td>= {ATQ_RATIO_COEF_ATQ} ratio dégats créé par l'attaquant</td>
</tr><tr>
<th>ATQ_RATIO_COEF_DEF </th><td>= {ATQ_RATIO_COEF_DEF} ratio dégats créé par le défenseur</td>
</tr><tr>
<th>ATQ_RATIO_COEF_BAT </th><td>= {ATQ_RATIO_COEF_BAT} ratio dégats batiments</td>
</tr><tr>
<th>ATQ_RATIO_HEROS </th><td>= {ATQ_RATIO_HEROS} % perte dégats PDV héros</td>
</tr><tr>
<th>ATQ_RATIO_DIST </th><td>= {ATQ_RATIO_DIST} bonus unités à distance (log)</td>
</tr><tr>
<th>ATQ_FAT </th><td>= {ATQ_FAT} ( inutile ici )</td>
</tr><tr>
<th>ATQ_LEG_IDLE </th><td>= {ATQ_LEG_IDLE} legion idle en position d'attaque - nb jours</td>
</tr>
</table>

<if cond="{arr_tbl}">
	<h3>Status des tables SQL en erreur</h2>
	<table>
	<tr>
		<th>Table</th>
		<th>Status</th>
		<th>message</th>
	</tr>
	<foreach cond="{arr_tbl} as {tbl}">
	<if cond='{tbl[Msg_type]}!="status"'>
	<tr>
		<td>{tbl[Table]}</td>
		<td>{tbl[Msg_type]}</td>
		<td>{tbl[Msg_text]}</td>
	</tr>
	</if>
	</foreach>
	</table>
</if>

