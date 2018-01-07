<p>Depuis peu, des êtres un peu comme des nains, mais d'une couleur de peau similaire aux orcs sont arrivés sur Zordania. <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>{mbr_array[mbr_pseudo]} décida de s'aventurer sur ces plaines et construire son village {mbr_array[mbr_vlg]} dans des ruines fortifiées.<br/>
Le nombre de gobelins s'étant installés est de {mbr_array[mbr_population]} et sont d'une intelligence incroyable.
Pour découvrir cette nouvelle espèce, nous devons voyager sur une distance de {mbr_dst} dans la région {regions[{mbr_array[map_region]}][name]}, où le petit homme vert se trouve aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Pourtant nouvel arrivant, il s'est déjà intégré parmi l'alliance <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}.</a>Attention, ils nous envahissent!<br/></if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
