<div class="menu_module">
Jour : <a href="stat.html?jour=<math oper='{stq_jour}-1'/>&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Précédent"><img src="img/left.png" alt="<-" /></a> 
{stq_jour} <a href="stat.html?jour=<math oper='{stq_jour}+1'/>&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Suivant"><img src="img/right.png" alt="->" /></a> - 
Mois : <a href="stat.html?mois=<math oper='{stq_mois}-1'/>&amp;jour={stq_jour}&amp;annee={stq_annee}" title="Précédent"><img src="img/left.png" alt="<-" /></a> 
{stq_mois} <a href="stat.html?mois=<math oper='{stq_mois}+1'/>&amp;jour={stq_jour}&amp;annee={stq_annee}" title="Suivant"><img src="img/right.png" alt="->" /></a> -
Année : <a href="stat.html?annee=<math oper='{stq_annee}-1'/>&amp;jour={stq_jour}&amp;mois={stq_mois}" title="Précédent"><img src="img/left.png" alt="<-" /></a> 
{stq_annee} <a href="stat.html?annee=<math oper='{stq_annee}+1'/>&amp;mois={stq_mois}&amp;mois={stq_mois}" title="Suivant"><img src="img/right.png" alt="->" /></a>
</div>
<hr />
<if cond="count({stq_infos}) == 2">
<h3>Statistiques</h3>
<p>
Joueurs Actifs: {stq_infos[0][stq_mbr_act]} (<span class="<if cond='{stq_infos[0][stq_mbr_act]} >= {stq_infos[1][stq_mbr_act]}'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_mbr_act]}-{stq_infos[1][stq_mbr_act]}' /></span>)
<br/>
Joueurs Inactifs: {stq_infos[0][stq_mbr_inac]} (<span class="<if cond='{stq_infos[0][stq_mbr_inac]} >= {stq_infos[1][stq_mbr_inac]}'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_mbr_inac]}-{stq_infos[1][stq_mbr_inac]}' /></span>)
<br/>
Connectés (moyenne): {stq_infos[0][stq_mbr_con]} (<span class="<if cond='{stq_infos[0][stq_mbr_con]} >= {stq_infos[1][stq_mbr_con]}'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_mbr_con]}-{stq_infos[1][stq_mbr_con]}' /></span>)
<br/>
</p>
</if>
