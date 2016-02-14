<p>Du haut de son donjon, le Seigneur <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}.<br/> peut admirer sa région {regions[{mbr_array[map_region]}][name]}.<br/>.
Croyant que sa forteresse {mbr_array[mbr_vlg]} domine le secteur, il se sent en sécurité avec les {mbr_array[mbr_population]} humains à son service, habitant ainsi cette cité en aimant vivre dans le luxe et profitant de leur courte vie.
Pour atteindre leur cité aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}, nous devrons parcourir la distance suivante : {mbr_dst}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Ce seigneur n'a pas fait la folie de se battre seul et a préféré rejoindre l'alliance <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}.</a><br/></if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
