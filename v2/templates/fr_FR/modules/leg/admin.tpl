<include file="commun/races.tpl" general="0" admin="1" url="admin.html?module=leg" />

<foreach cond="{race} as {race_id} => {race_name}">
	<load file="race/{race_id}.config" />
	<load file="race/{race_id}.descr.config" />
</foreach>

<h3>Liste des compétences par races</h3>

<foreach cond="{cpt} as {cpt_type} => {cpt1}">
	<h4>Compétence {type_comp[{cpt_type}]}</h4>

	<table>
		<tr>
		<foreach cond="{race} as {race_id} => {race_name}">
			<if cond="isset({_races[{race_id}]}) and {_races[{race_id}]}">
			<td><img src="img/{race_id}/{race_id}.png" alt="{race_name}" title="{race_name}" /></td>
			</if>
		</foreach>
		</tr>

		<foreach cond="{cpt1} as {cpt_id} => {value}">
			<tr>
				<foreach cond="{race} as {race_id} => {race_name}">
				<if cond="isset({_races[{race_id}]}) and {_races[{race_id}]}">
				<if cond="isset({value[{race_id}]})">
					<td>
<a href="manual.html?race={race_id}&amp;type=comp#comp_{cpt_id}"><zimgcomp race="{race_id}" type="{cpt_id}" /></a>
					</td>
				</if>
				<else>
					<td></td>
				</else>
				</if>
				</foreach>
			</tr>
		</foreach>

	</table>

</foreach>


