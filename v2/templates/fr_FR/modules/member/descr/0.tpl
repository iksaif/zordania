<p class="infos">Ce membre n'a pas initialisé son compte.<br/>
<img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}.
</p>

<if cond="{mbr_rec}">
	Celui-ci grâce à ses actions a reçu les récompenses suivantes :
	<foreach cond="{mbr_rec} as {rec_value}">
	{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
	</foreach>
</if>

