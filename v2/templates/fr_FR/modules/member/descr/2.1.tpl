<p>Au milieu de la plaine, faite de rondins mal taillés et de paille, se trouve le fortin {mbr_array[mbr_vlg]} du seigneur <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}<br/>, orc guerrier sanguinaire et féroce.
Le dernier recensement de sa population est de {mbr_array[mbr_population]} sans compter les visiteurs empalés sur le mur d'enceinte.
Les orcs y habitant vivent dans de misérables huttes.
Si nous avons l'odace de nous frotter à ses créature répugnantes, il faudra avoir le courage de se rendre dans {regions[{mbr_array[map_region]}][name]}.<br/> et voyager sur une distance de {mbr_dst} où en fait se situe le petit village aux coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Aussi effrayant qu'ils en ont l'air, il se peut qu'ils demandent l'aide d'autres guerriers, comme l'alliance dite <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}</a>.<br/></if>

<if cond="{mbr_rec}">
Celui-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
