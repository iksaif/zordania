<p>Au milieu des bois se dresse la cité {mbr_array[mbr_vlg]}, celle-ci incarne la beauté à l'état pur. Depuis des temps Anciens, ses bâtisseurs ont réussi à unir la grâce et la puissance dans leurs édifices. Leur seigneur est <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}.<br/> Chef des {mbr_array[mbr_population]} elfes habitant la cité. Pour atteindre leur cité à la position {mbr_array[map_x]} * {mbr_array[map_y]}, nous devrons parcourir la distance suivante : {mbr_dst}, dans la belle région {regions[{mbr_array[map_region]}][name]}, où nous devrons rester sur nos gardes, la forêt n'est pas notre amie!<br/>

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Son alliance se nomme <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a>, il faudra donc se méfier si nous nous attaquons à lui.<br/></if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
