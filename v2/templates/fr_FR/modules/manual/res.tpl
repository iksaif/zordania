<foreach cond="{race} as {race_id} => {race_name}"><if cond="{race_id} != 0">
	<load file="race/{race_id}.config" />
	<load file="race/{race_id}.descr.config" />
</if></foreach>

<h3>Equivalence et Prix des Ressources par Races</h3>

<table class="border">
<tr>
<foreach cond="{race} as {race_id} => {race_name}"><if cond="{race_id} != 0 && isset({_races[{race_id}]}) && {_races[{race_id}]}">
	<th colspan="2"><img src="img/{race_id}/{race_id}.png" title="{race_name}" alt="{race_name}"/> {race_name}</th>
</if></foreach>
<tr>

<foreach cond="{res_array} as {key} => {res_array_tmp}">
	<tr>
	<foreach cond="{res_array_tmp} as {race_id} => {val_res}"><if cond="{_races[{race_id}]}">
		<th rowspan="2"><zimgres race="{race_id}" type="{key}" /></th>
		<td><strong>{res[{race_id}][alt][{key}]}</strong></td></if>
	</foreach>
	</tr>

<tr>
	<foreach cond="{res_array_tmp} as {race_id} => {val_res}"><if cond="{_races[{race_id}]}">	<td>
		<if cond="empty({val_res}) or isset({val_res[dummy]})"><em>indisponible</em></if>
		<elseif cond="isset({val_res[prix_res]})">
<foreach cond="{val_res[prix_res]} as {res_id} => {nb}">{nb} <zimgres race="{race_id}" type="{res_id}" />
</foreach>
		</elseif>
		<elseif cond="isset({val_res[cron]})"><em>Prod auto</em></elseif>
		<else><debug print="{val_res}" /></else>	</td></if>
	</foreach>
</tr>
<tr><th colspan="<math oper='count({res_array})*2'/>">&nbsp;</th></tr>
</foreach>

</table>

<p align="center" class="menu_module">
[ <a href="manual.html?race={man_race}&page=7">Précédent : Commerce</a>  ]
-
[ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
-
[ <a href="manual.html?race={man_race}&page=23">Suivant : Egeria, Capitale de Zordania</a> ]
</p>

