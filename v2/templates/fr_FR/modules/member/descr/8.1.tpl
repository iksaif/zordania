<p>De l'envahisseur, il ne reste plus rien! Quoi que...<br/>
 <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>{mbr_array[mbr_pseudo]} pourtant mort, se promène sur les terres zordaniennes, quelque part dans le lieu dit {regions[{mbr_array[map_region]}][name]}. Cet être ne semble pas être vivant... ni mort d'ailleurs! De ce que l'on racconte, Il s'agirait de seigneurs issus des champs de batailles contre les Drak Dovars. C'est ainsi {mbr_array[mbr_population]} qui se sont regroupés sous son commandements afin de se vanger de ceux qui les ont abandonnés! <br/> 
Ils se sont installés dans l'ancienne cité {mbr_array[mbr_vlg]} aujourd'hui décimée. {mbr_dst} Nous sépare de ce fléau, aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Devenant de plus en plus fort et craint, cet être fut recruté dans l'alliance <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}.</a>Prenez garde, ils sont de retour!<br/></if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
