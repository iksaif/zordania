<p>Rare sont les femmes au combat, il faut l'avouer! Pourtant, dans nos contrées Zordaniennes, il existe des humaines ayant hérité de la hargne de la guerre. C'est ainsi le cas de la cheffe de guerre <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}.<br/>.
Ses travailleurs, paladins, et autres humains se comptent, au dernier rapport, à {mbr_array[mbr_population]} femmes et hommes prêts au combat.
Si vous voulez la défier, il faudra se rendre jusque la région nommée {regions[{mbr_array[map_region]}][name]}.<br/>. Sa cité {mbr_array[mbr_vlg]} se trouve aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}, à une distance approximative de {mbr_dst}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'><img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}.<br/> a décidé d'obtenir le soutien de l'alliance <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]} </a>et se battre à leur côté.<br/></if>

<if cond="{mbr_rec}">
Celle-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
