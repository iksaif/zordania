<p>Les Drows vivent dans les milieux reculés et obscurs de Zordania, avec ses {mbr_array[mbr_population]} esclaves et créatures à sa disposition, le dirigeant drow <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]} a choisi d'y bâtir sa cité noire {mbr_array[mbr_vlg]}.
Afin de nous rendre chez ce fameux seigneur, nous devons parcourir la distance suivante : {mbr_dst}, plus précisément dans la région {regions[{mbr_array[map_region]}][name]} aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>
Mais attention, il n'est pas seul, en faisant partie de l'alliance <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a>, il dispose d'alliés aussi redoutable pour sa défense.<br/>
</if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
