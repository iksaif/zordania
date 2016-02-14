<p>Sous la montagne, le seigneur <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}.<br/> a fait creuser son bastion, abritant {mbr_array[mbr_population]} âmes creusant et se battant pour lui. Leur amour pour les métaux précieux est sans égal et on les appelle les nains. Pour atteindre leur citadelle {mbr_array[mbr_vlg]}, il faudra marcher et braver les danger de la région où il s'est implanté: {regions[{mbr_array[map_region]}][name]}.<br/> aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}, nous devrons ainsi parcourir la distance suivante : {mbr_dst}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>De sa petite taille, il a pris la décision de se faire aider par l'alliance que l'on nomme: <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}.</a><br/></if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
