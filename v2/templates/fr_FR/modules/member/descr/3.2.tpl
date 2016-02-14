<p>Une naine n'a pas froid aux yeux! C'est peu de le dire, sachant qu'un nain vit dans la montagne...
Cette citadelle, que <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}<br/> a nommé {mbr_array[mbr_vlg]} a été creusée par des bâtisseurs de qualités! On reconnait bien la précision des naines et leur cupidité face aux métaux précieux qu'elles exploitent. C'est ainsi {mbr_array[mbr_population]} guerriers et guerrières de petite taille qui habitent la région dite {regions[{mbr_array[map_region]}][name]}.<br/> Du coup, pour nous y rendre, nous devrons voyager et escalader la montage sur une distance de {mbr_dst} pour atteindre l'objectif {mbr_array[map_x]} * {mbr_array[map_y]}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>D'un point de vue commerciale ou militaire, elle choisi de rejoindre l'alliance connue sous le nom: <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a>.<br/></if>

<if cond="{mbr_rec}">
Celle-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
