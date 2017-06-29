<dl>
<foreach cond='{man_array} as {comp_id} => {comp_value}'>
	<dt id="comp_{comp_id}">
		<a href="manual.html?race={man_race}&type=comp#comp_{comp_id}">
		{comp[{man_race}][alt][{comp_id}]}</a>
	</dt>
	<dd>
		<span class="right"><zimgcomp type="{comp_id}" race="{man_race}" /></span>
		<p><strong>Compétence {type_comp[{comp_value[type]}]}</strong> : 
		<printf string="{comp[{man_race}][descr][{comp_id}]}" vars="{comp_value[bonus]},{comp_value[tours]}" />
		</p>
		<p><em>Prix (en expérience) :</em> {comp_value[prix_xp]} XP
<#
		<if cond="{comp_value[tours]}">- <em>durée :</em> {comp_value[tours]} tours</if>
		<if cond="{comp_value[bonus]}">
			- <em>
			<if cond="{comp_value[bonus]} > 0">Bonus accordé :</if>
			<else>Malus :</else>
			</em> {comp_value[bonus]} %</p>
		</if>
#>
		<p>Les Héros qui peuvent avoir cette compétence :
		<foreach cond="{comp_value[heros]} as {unit}"><zimgunt type="{unit}" race="{man_race}" />
		</foreach>
	</dd>
</foreach>
</dl>