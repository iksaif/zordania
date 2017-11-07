<p>Une femme barbare? Oui cela existe! En fait, les orcs femelles ne se distinguent pas très bien de leurs homologues masculins. C'est pourquoi <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}<br/> sera aussi sans état d'âme face à son ennemi!
Avec ses {mbr_array[mbr_population]} cogneurs et bersekers, son fortin {mbr_array[mbr_vlg]} en bois, peaux et autres matériaux est réfugié dans une partie de Zordania nommée {regions[{mbr_array[map_region]}][name]}.<br/>
Avec du courage, nous pouvons parcourir une distance égale à {mbr_dst} et oser nous y frotter. Si nous passons les huttes nous éviterons de rester empalés sur les pieux en bois du repaire en {mbr_array[map_x]} * {mbr_array[map_y]}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Et avec un peu de chance, nous pourrons ne pas affronter son clan nommé <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a>.<br/></if>

<if cond="{mbr_rec}">
Celle-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
