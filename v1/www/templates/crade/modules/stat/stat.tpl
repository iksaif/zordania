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

<if cond='|{stq_possible}| == 3'>
 Graphique Quotidien
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
 Graphique Mensuel
 <br />
<if cond='|{stq_image_mois}| == true'>
 <img alt="Graphique Mensuel" src="img/stats/{stq_act}_{stq_mois}-{stq_annee}.png" />
</if>
<else>
 Non disponible.
</else>
</p>