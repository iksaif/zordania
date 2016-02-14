Pour atteindre leur cité à la position {mbr_array[map_x]} * {mbr_array[map_y]}, nous devrons parcourir la distance suivante : {mbr_dst}. Celle-ci se situe sur {regions[{mbr_array[map_region]}][name]}.<br/>
<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>
	Ce seigneur fait partie des  <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
	<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>
	{mbr_array[al_name]}</a>.<br/>
</if>

Selon le dernier recensement, il possède {mbr_array[mbr_points]} points au classement des héros.<br/>
Dans le majestueux livre des grandes archives de Zordania, à Egéria, il prend la place {mbr_array[mbr_mid]} .<br/>
<if cond="{mbr_rec}">
	Celui-ci grâce à ses actions a reçu les récompenses suivantes :
	<foreach cond="{mbr_rec} as {rec_value}">
	{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
	</foreach>
</if>
