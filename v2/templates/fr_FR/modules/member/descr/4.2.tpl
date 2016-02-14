<p>Dans l'ombre est dissimulée la cité noire {mbr_array[mbr_vlg]}, nid de la reine sombre <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}.<br/>
Sa population drow est estimée à {mbr_array[mbr_population]} sujets sans compter les visiteurs encore accrochés aux gibets. Pour nous y rendre, nous devons voyager aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]} situées dans la région {regions[{mbr_array[map_region]}][name]}<br/>, ce qui fera une marche de {mbr_dst} à parcourir.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Mais méfiance, en faisant partie de l'alliance <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a>, elle devient une cible moins facile.<br/></if>

<if cond="{mbr_rec}">
Celle-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
