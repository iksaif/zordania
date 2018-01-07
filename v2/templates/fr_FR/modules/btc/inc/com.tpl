<if cond='{btc_act} == "my"'>
	<if cond='{vente_array}'>
		<p class="info">Attention en cas d'annulation d'une vente, une taxe de {COM_TAX}% sera prélevée sur celle-ci.</p>
		<form action="btc-use.html?btc_type={btc_id}&amp;sub=cnl" method="post">
		<table class="liste">
		<tr>
			<th>Proposé</th>
			<th>Prix</th>
			<th>Prix Unitaire</th>
			<th>Statut</th>
			<th>Annuler</th>
		</tr>
		<foreach cond='{vente_array} as {key} => {com_value}'>
		<tr>
			<td>
				{com_value[mch_nb]} <zimgres race="{_user[race]}" type="{com_value[mch_type]}" />
			</td>
			<td>
				{com_value[mch_prix]} <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" />
			</td>
			<td><math oper="{com_value[mch_prix]}/{com_value[mch_nb]}" />
			<td>
			<if cond="{com_value[mch_etat]} == {COM_ETAT_OK}">
			Expiration: {com_value[mch_time_formated]}
			</if>
			<else>
			En Attente ...
			</else>
			</td>
			<td>
			<input type="checkbox" name="com_cnl[{com_value[mch_cid]}]" />
			</td>
		</tr>
		</foreach>
		</table>
		<p><input type="submit" value="Annuler" /></p>
		</form>
	</if>
	<else>
		<p class="infos">Vous n'avez aucune ressource en vente pour le moment.</p>
	</else>
</if>
<elseif cond='{btc_act}== "cnl"'>
	<if cond="{com_cnl}">
		<div class="ok">
			Ventes annulées :
			<ul>
			<foreach cond="{com_cnl} as {com_value}">
				<li>
				{com_value[mch_nb]} <zimgres race="{_user[race]}" type="{com_value[mch_type]}" />
				contre {com_value[mch_prix]} <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" />
				</li>
			</foreach>
			</ul>
		</div>
	</if>
	<else>
		<p class="error">Aucune vente spécifiée !</p>
	</else>
</elseif>
<elseif cond='{btc_act}== "ven"'>
	<if cond='{max_ventes} AND {max_ventes} <= {nb_ventes}'>
		<p class="infos">Vous avez déjà {nb_ventes}/{max_ventes} ventes simultanées ce qui est le maximum avec votre niveau technologique actuel.</p>
	</if>
	<if cond='{btc_sub} =="choix_type"'>
		Ventes: {nb_ventes}/{max_ventes}<br/><br/>
		Choisissez les types de ressource à échanger.<br/><br/>
			<form action="btc-use.html?btc_type={btc_id}&amp;sub=ven" method="post">
			<p>
			<label for="com_type">A Vendre</label>
			<select id="com_type" name="com_type">
			<foreach cond='{com_list_res} as {res_id} => {res_value}'>
				<if cond='{res_value} > 0 && {res_id} > 1'>
				<option value="{res_id}"> {res[{_user[race]}][alt][{res_id}]} 		({res_value})</option>
				</if>
			</foreach>
			</select>
			<p>
			
			<p><input name="submit" value="Suivant ->" type="submit"></p>
		</form>
	</if>
	<elseif cond='{btc_sub} =="choix_param"'>
		<script type="text/javascript">
		// calcul du prix unitaire
		$(document).ready(  function()
		{
			$("input#com_prix").blur(function () 
			{
				var nb = parseFloat($("input#com_nb").val());
				var prix = parseFloat(this.value);
				$("#prix_unit").val((prix / nb).toFixed(3));
			});
		});
		</script>
		<form name="form" action="btc-use.html?btc_type={btc_id}&amp;sub=ven" method="post">
		<if cond="isset({btc_error})">
		    <p class="error">Cours incorrect.</p>
		</if>
		<p>
		A Vendre : <zimgres race="{_user[race]}" type="{com_type}" /> {res[{_user[race]}][alt][{com_type}]}
		<input type="hidden" value="{com_type}" name="com_type" />
		</p>
		
		<p>
		<label for="com_nb">Quantité à vendre</label>
		<input type="text" value="{com_nb}" id="com_nb" name="com_nb" />
		</p>
		
		<p>
		En Echange (max: {com_max_nb}) : <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" /> {res[{_user[race]}][alt][1]}<br/>
		<label for="com_prix">Prix</label>
		<input type="text" value="{com_prix}" id="com_prix" name="com_prix" />
		</p>

		<p>
		<label for="com_nb">Nombre de ventes similaires</label>
		<input type="text" value="1" id="com_vente" name="com_vente" />
		</p>
		
		<p>
		Prix unitaire : 
		<input type="text" id="prix_unit"/>
		</p>
		
		<p><input type="submit" value="Mettre en vente"></p>
		</form>
		<hr/>
		<h3>Infos sur les ventes de <zimgres race="{_user[race]}" type="{com_type}" /></h3>
		<if cond="{com_infos}">
			<p>{res[{_user[race]}][alt][{com_type}]} en vente : {com_infos[total_ventes]}</p>
			<p>
			<zimgres race="{_user[race]}" type="{com_type}" />
			Total: {com_infos[ventes][1]} <zimgres race="{_user[race]}" type="{com_type}" />
			contre {com_infos[ventes][2]} <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" />
			</p>
		</if>
		<p>
		Prix unitaire minimum : {com_cours_min}<br/>
		<if cond="{com_infos}">
			Prix unitaire moyen : <math oper="round({com_infos[ventes][2]}/{com_infos[ventes][1]},2)" /><br/>
		</if>
		Prix unitaire maximum :
  		{com_cours_max}
		<br/>
		</p>
	</elseif>
	<elseif cond='{btc_sub} =="vente"'>
		<if cond='{vente_ok}'>
			<p class="ok"> Mise en vente effectuée, elle apparaîtra dans le marché dans quelques tours et sera supprimée dans {MCH_MAX} tours s'il n'y a aucun acheteur.</p>
		</if>
		<else>
			<if cond='isset({btc_max_nb})'>
				<if cond='{btc_max_nb}==0'><p class="error">Il faut choisir un nombre de ventes.</p></if>
				<else>
					<p class="error">Impossible de faire des transactions de plus de {btc_max_nb} <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" /> en même temps.</p>
				</else>
			</if>
			<else>
				<p class="error">Vous n'avez pas les ressources que vous voulez mettre en vente.</p>
			</else>
		</else>
	</elseif>
</elseif>
<elseif cond='{btc_act} == "ach"'>

	<if cond="isset({cpt_nego})"><p class="ok">La compétence <zimgcomp race="{_user[race]}" type="{CP_GENIE_COMMERCIAL}" /> vous procure un bonus supplémentaire à l'achat tant que le bonus est actif. Profitez-en !</p></if>

	<if cond='!isset({btc_sub}) || !{btc_sub}'>
		<if cond='{com_liste}'>

			<foreach cond='{com_liste} as {mch_value}'>
				<set name="mch_type" value="{mch_value[mch_type]}" />
				<zimgres race="{_user[race]}" type="{mch_type}" />
				<a href="btc-use.html?btc_type={btc_id}&amp;sub=ach&amp;com_type={mch_type}" title="Afficher {res[{_user[race]}][alt][{mch_type}]}">{res[{_user[race]}][alt][{mch_type}]}</a><br />
				<if cond='isset({com_type}) && {com_type} == {mch_type}'>
				<include file="modules/btc/inc/com_list_res.tpl" cache="1" />
				</if>
			</foreach>

			<if cond='isset({com_infos}) && {com_infos}'>	
				<hr/>
				<h3>Infos sur les ventes de <zimgres race="{_user[race]}" type="{com_type}" /></h3>
				<if cond="{com_infos}">
					<p>{res[{_user[race]}][alt][{com_type}]} en vente : {com_infos[total_ventes]}</p>
					<p>
					<zimgres race="{_user[race]}" type="{com_type}" />
					Total: {com_infos[ventes][1]} <zimgres race="{_user[race]}" type="{com_type}" />
					contre {com_infos[ventes][2]} <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" />
					</p>
				</if>
				<p>
				Prix unitaire moyen : <math oper="round({com_infos[ventes][2]}/{com_infos[ventes][1]},2)" /><br/>
				</p>
			</if>
		</if>
		<else>
			<p class="infos">Aucune marchandise n'est en vente.</p>
		</else>	
	</if>
	<elseif cond='{btc_sub} == "achat"'>
		<if cond='{btc_achat} == "ok"'>
			<p class="ok">Achat effectué !
			<if cond="isset({com_neg})">
				<if cond="{com_neg}<1">
					Votre réputation de marchand n'est plus à faire : vous avez négocié avec succès une ristourne de  <math oper="abs({com_neg}*100-100)" />% sur le prix de base !
				</if>
				<elseif cond="{com_neg}>1">
					Votre tentative de négocier un prix pourtant si attrayant choque le vendeur : vous payez <math oper="abs({com_neg}*100-100)" />% de plus.
				</elseif>
				<else>
					Vous êtes tombé sur un dur, il ne lâchera rien de plus !
				</else>
			</if>
			</p>
		</if>
		<elseif cond='{btc_achat} == "nores"'>
			<p class="error">Vous n'avez pas les ressources nécessaires pour acheter cela.</p>
		</elseif>
		<elseif cond='isset({btc_max_nb})'>
			<p class="error">Avec votre niveau de développement actuel vous ne pouvez acheter plus de {btc_max_nb} <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" /> à la fois !</p>
		</elseif>
		<else>
			<p class="error">Erreur.</p>
		</else>
	</elseif>
</elseif>
<elseif cond='{btc_act} == "cours"'>
	<table class="liste">
		<tr>
			<th>Ressource ({com_nb})</th>
			<th>Prix Min</th>
			<th>Prix Conseillé</th>
			<th>Prix Max</th>
			<th>Tendances</th>
		<tr>
		<foreach cond="{mch_cours} as {mch_value}">
		<tr>
			<td>
			<a href="btc-use.html?btc_type={btc_id}&amp;sub=cours_sem&amp;com_type={mch_value[mcours_res]}" title="Cours de  {res[{_user[race]}][alt][{mch_value[mcours_res]}]}">
				<zimgres race="{_user[race]}" type="{mch_value[mcours_res]}" /> {res[{_user[race]}][alt][{mch_value[mcours_res]}]}
			</a>
			</td>
			<td>
				<math oper="{mch_value[mcours_cours]}*{COM_TAUX_MIN}*{com_nb}" /> <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" />
			</td>
			<td>
				<math oper="{mch_value[mcours_cours]}*{com_nb}" /> <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" />
			</td>
			<td>
				<math oper="max(1, {mch_value[mcours_cours]}*{COM_TAUX_MAX}*{com_nb})" /> <zimgres race="{_user[race]}" type="{GAME_RES_PRINC}" />
			</td>
			<td>
				<a href="http://{zordlog_url}/commerce.html?res_id={mch_value[mcours_res]}" title="Archives">anciens cours</a>
			</td>
		</tr>
		</foreach>
	</table>
		
	<form action="btc-use.html?btc_type={btc_id}&amp;sub=cours" method="post">
		<label for="com_nb">Modifier le nombre de ressources</label>
		<input type="text" id="com_nb" name="com_nb" value="{com_nb}" />
		<input type="submit" value="Modifier" />
	</form>
</elseif>
<elseif cond='{btc_act} == "cours_sem"'>

	<hr />
	<div class="menu_module">
	Jour : <a href="btc-use.html?btc_type={btc_id}&sub=cours_sem&amp;jour=<math oper='{stq_jour}-1'/>&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Précédent"><img src="img/left.png"/></a> 
	{stq_jour} <a href="btc-use.html?btc_type={btc_id}&sub=cours_sem&amp;jour=<math oper='{stq_jour}+1'/>&amp;mois={stq_mois}&amp;annee={stq_annee}" title="Suivant"><img src="img/right.png"/></a> - 
	Mois : <a href="btc-use.html?btc_type={btc_id}&sub=cours_sem&amp;mois=<math oper='{stq_mois}-1'/>&amp;jour={stq_jour}&amp;annee={stq_annee}" title="Précédent"><img src="img/left.png"/></a> 
	{stq_mois} <a href="btc-use.html?btc_type={btc_id}&sub=cours_sem&amp;mois=<math oper='{stq_mois}+1'/>&amp;jour={stq_jour}&amp;annee={stq_annee}" title="Suivant"><img src="img/right.png"/></a> -
	Année : <a href="btc-use.html?btc_type={btc_id}&sub=cours_sem&amp;annee=<math oper='{stq_annee}-1'/>&amp;jour={stq_jour}&amp;mois={stq_mois}" title="Précédent"><img src="img/left.png"/></a> 
	{stq_annee} <a href="btc-use.html?btc_type={btc_id}&sub=cours_sem&amp;annee=<math oper='{stq_annee}+1'/>&amp;mois={stq_mois}&amp;mois={stq_mois}" title="Suivant"><img src="img/right.png"/></a>
	</div>

	<if cond="{mch_cours}">
		<table class="liste">
		<tr>
			<th>Ressource</th>
			<th>J-7</th>
			<th>J-6</th>
			<th>J-5</th>
			<th>J-4</th>
			<th>J-3</th>
			<th>J-2</th>
			<th>J-1</th>
		</tr>
		<foreach cond="{mch_cours} as {mch_type} => {mch_res_array}">
		<tr>
			<td>
			<set name="mch_last_cours" value="0" />
			<a href="http://{zordlog_url}/commerce.html?res_id={mch_type}" title="Archives">
			<zimgres race="{_user[race]}" type="{mch_type}" /> {res[{_user[race]}][alt][{mch_type}]} </a>
			</td>
			<foreach cond="{mch_res_array} as {mch_result}">
			<td>
			<if cond="{mch_last_cours}">
				<if cond="{mch_last_cours} < {mch_result[msem_cours]}">
					<span class="gain">{mch_result[msem_cours]}</span>
					<img src="img/up.png" alt="up" />
				</if>
				<elseif cond="{mch_last_cours} > {mch_result[msem_cours]}">
					<span class="perte">{mch_result[msem_cours]}</span>
					<img src="img/down.png" alt="down" />
				</elseif>
				<else>
					{mch_result[msem_cours]}
				</else>
			</if>
			<else>
				{mch_result[msem_cours]}
			</else>
			<set name="mch_last_cours" value="{mch_result[msem_cours]}" />
			</td>
			</foreach>
		</tr>
		</foreach>
		</table>
	</if>
	<else>
		<p class="infos">Aucun cours à afficher.</p>
	</else>	
</elseif>
