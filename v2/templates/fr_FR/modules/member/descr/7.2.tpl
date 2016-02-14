<p>Créature gobeline... c'est nouveau? Apparemment, cet être s'appelant <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>{mbr_array[mbr_pseudo]}, a découvert notre monde et s'est installée dans les ruines Drak Dovars en la cité {mbr_array[mbr_vlg]}. Ecuyers, artisants, ingénieurs, ils sont ainsi {mbr_array[mbr_population]} gobelins vivant dans cet univers de fortune.<br/> {regions[{mbr_array[map_region]}][name]}, c'est la région dans laquelle cette créature a décidé de se réfugier. Il faut compter une distance de {mbr_dst} pour visiter cet endroit, plus exactement aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]} sur la carte.<br/>

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Attention chers seigneurs, vous pouvez vous aventurer sur ses terres, mais <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a> veillent sur elle.<br/></if>

<if cond="{mbr_rec}">
Celle-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
