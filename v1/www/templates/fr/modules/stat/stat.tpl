<p class="menu_module">
[ <a href="index.php?file=stat&amp;act=mbr&amp;jour={stq_jour}&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Nombre de joueurs, connectés, ...">Membres</a> ] - 
[ <a href="index.php?file=stat&amp;act=res&amp;jour={stq_jour}&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Ressources">Ressources</a> ] - 
[ <a href="index.php?file=stat&amp;act=btc&amp;jour={stq_jour}&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Bâtiments">Bâtiments</a> ] - 
[ <a href="index.php?file=stat&amp;act=unt&amp;jour={stq_jour}&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Unités">Unités</a> ] - 
[ <a href="index.php?file=stat&amp;act=src&amp;jour={stq_jour}&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Recherches">Recherches</a> ] 
<br />
[ Jour : <a href="index.php?file=stat&amp;act={stq_act}&amp;jour=<math oper='{stq_jour}-1'/>&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Précédent"><img src="img/left.png" alt="<-" /></a> {stq_jour} <a href="index.php?file=stat&amp;act={stq_act}&amp;jour=<math oper='{stq_jour}+1'/>&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Suivant"><img src="img/right.png" alt="->" /></a> ] - 
[ Mois : <a href="index.php?file=stat&amp;act={stq_act}&amp;mois=<math oper='{stq_mois}-1'/>&amp;jour={stq_jour}&amp;annee={stq_annee}" title="Précédent"><img src="img/left.png" alt="<-" /></a> {stq_mois} <a href="index.php?file=stat&amp;act={stq_act}&amp;mois=<math oper='{stq_mois}+1'/>&amp;jour={stq_jour}&amp;annee={stq_annee}" title="Suivant"><img src="img/right.png" alt="->" /></a> ] -
[ Année : <a href="index.php?file=stat&amp;act={stq_act}&amp;annee=<math oper='{stq_annee}-1'/>&amp;jour={stq_jour}&amp;mois={stq_mois}" title="Précédent"><img src="img/left.png" alt="<-" /></a> {stq_annee} <a href="index.php?file=stat&amp;act={stq_act}&amp;annee=<math oper='{stq_annee}+1'/>&amp;mois={stq_mois}&amp;mois={stq_mois}" title="Suivant"><img src="img/right.png" alt="->" /></a> ]
<hr />
<if cond="count(|{stq_infos}|) == 2">
<h2>Statistiques</h2>
Joueurs Actifs: {stq_infos[0][stq_mbr_act]} (<span class="<if cond='|{stq_infos[0][stq_mbr_act]}| >= |{stq_infos[1][stq_mbr_act]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_mbr_act]}-{stq_infos[1][stq_mbr_act]}' /></span>)
<br/>
Joueurs Inactifs: {stq_infos[0][stq_mbr_inac]} (<span class="<if cond='|{stq_infos[0][stq_mbr_inac]}| >= |{stq_infos[1][stq_mbr_inac]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_mbr_inac]}-{stq_infos[1][stq_mbr_inac]}' /></span>)
<br/>
Connectés (moyenne): {stq_infos[0][stq_mbr_con]} (<span class="<if cond='|{stq_infos[0][stq_mbr_con]}| >= |{stq_infos[1][stq_mbr_con]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_mbr_con]}-{stq_infos[1][stq_mbr_con]}' /></span>)
<br/>
Unités: {stq_infos[0][stq_unt_tot]} (<span class="<if cond='|{stq_infos[0][stq_unt_tot]}| >= |{stq_infos[1][stq_unt_tot]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_unt_tot]}-{stq_infos[1][stq_unt_tot]}' /></span>)
<br/>
Unités par joueur: {stq_infos[0][stq_unt_avg]} (<span class="<if cond='|{stq_infos[0][stq_unt_avg]}| >= |{stq_infos[1][stq_unt_avg]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_unt_avg]}-{stq_infos[1][stq_unt_avg]}' /></span>)
<br/>
Bâtiments: {stq_infos[0][stq_btc_tot]} (<span class="<if cond='|{stq_infos[0][stq_btc_tot]}| >= |{stq_infos[1][stq_btc_tot]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_btc_tot]}-{stq_infos[1][stq_btc_tot]}' /></span>)
<br/>
Bâtiments par joueur: {stq_infos[0][stq_btc_avg]} (<span class="<if cond='|{stq_infos[0][stq_btc_avg]}| >= |{stq_infos[1][stq_btc_avg]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_btc_avg]}-{stq_infos[1][stq_btc_avg]}' /></span>)
<br/>
Ressources par joueurs: {stq_infos[0][stq_res_avg]} (<span class="<if cond='|{stq_infos[0][stq_res_avg]}| >= |{stq_infos[1][stq_res_avg]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_res_avg]}-{stq_infos[1][stq_res_avg]}' /></span>)
<br/>
Recherches par joueurs: {stq_infos[0][stq_src_avg]} (<span class="<if cond='|{stq_infos[0][stq_src_avg]}| >= |{stq_infos[1][stq_src_avg]}|'>gain</if><else>perte</else>"><math oper='{stq_infos[0][stq_src_avg]}-{stq_infos[1][stq_src_avg]}' /></span>)
<br/>
</if>
<if cond='|{stq_possible}| == 3'>
 <h2>Graphique Quotidien</h2>
 <br />
<if cond='|{stq_image_jour}| == true'>
 <img alt="Graphique Quotidien" src="img/stats/{stq_act}_{stq_jour}-{stq_mois}-{stq_annee}.png" />
</if>
<else>
 Non disponible.
</else>
 <br />
 <br />
</if>
 <h2>Graphique Mensuel</h2>
 <br />
<if cond='|{stq_image_mois}| == true'>
 <img alt="Graphique Mensuel" src="img/stats/{stq_act}_{stq_mois}-{stq_annee}.png" />
</if>
<else>
 Non disponible.
</else>
</p>