<p>Acolytes, wyrmes, zombies, tous revenus du royaumes des morts...<br/>
{mbr_array[mbr_population]} mort-vivants surgissant de nul part pour continuer leur travail! <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>{mbr_array[mbr_pseudo]} dirige cette légion à présent immortelle...<br/>
Ne vous avanturez pas dans la région {regions[{mbr_array[map_region]}][name]}, vous risqueriez d'y laisser votre peau! C'est en effet peuplé de créatures sortie d'outre tombe, prenant ainsi les ruines de {mbr_array[mbr_vlg]} comme quartier générale. Voyageur je vous conseille d'éliminer ce point de votre itinéraire, la reine liche occupe ces coordonnées: {mbr_array[map_x]} * {mbr_array[map_y]}, distantes de {mbr_dst}, elle n'aura aucun scrupule ni remort à votre égard!<br/> 

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Alliée avec <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a>, l'idée de vouloir la défier et la vaincre, devient utopique et illusoire!<br/></if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
