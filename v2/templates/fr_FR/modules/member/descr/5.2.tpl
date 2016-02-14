<p>Les elfes sont immortels. Leur sagesse et leur agilité, ils l'obtiennent dans leur forêt enchantée. <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/>
{mbr_array[mbr_pseudo]}<br/>, comme beaucoup d'autres de sa race, bâti sa cité sylvestre {mbr_array[mbr_vlg]} autour de sa colonie. Serviteurs, acolytes, archers, gardes, tous au nombre de {mbr_array[mbr_population]} protègent leur domaine dans la région dite {regions[{mbr_array[map_region]}][name]}, et ce depuis la nuit des temps.<br/>
Dotée d'une agilité, rapidité et d'une précision supérieure aux elfes masculins, il ne sera pas chose aisée de les affronter, mais en parcourant une distance de {mbr_dst}, nous pourrons atteindre ses coordonnées {mbr_array[map_x]} * {mbr_array[map_y]}.

<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>Néanmoins, nous devrons faire attention de ne pas rencontrer les membres de son alliance, <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{mbr_array[al_name]}" title="{mbr_array[al_name]}"/>{mbr_array[al_name]}!</a><br/></if>

<if cond="{mbr_rec}">
Celle-ci grâce à ses actions a reçu les récompenses suivantes :
<foreach cond="{mbr_rec} as {rec_value}">
{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
</foreach>
</if></p>
