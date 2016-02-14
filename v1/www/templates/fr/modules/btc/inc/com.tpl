<if cond='|{btc_act}| == "my"'>
<br>
	<if cond='is_array(|{vente_array}|)'>
		<p class="info">Attention en cas d'annulation d'une vente, une taxe de {COM_TAX}% sera prélevée sur celle-ci.</p>
		<table class="border1">
		<tr>
			<th>Proposé</th>
			<th>Prix</th>
			<th>Prix Unitaire</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
		<foreach cond='|{vente_array}| as |{key}| => |{com_value}|'>
		<tr>
			<td>
				{com_value[mch_nb]}
				<img src="img/{session_user[race]}/res/{com_value[mch_type]}.png" alt="{res[{session_user[race]}][alt][{com_value[mch_type]}]}" title="{res[{session_user[race]}][alt][{com_value[mch_type]}]}" />
			</td>
			<td>
				{com_value[mch_nb2]}
				<img src="img/{session_user[race]}/res/{com_value[mch_type2]}.png" alt="{res[{session_user[race]}][alt][{com_value[mch_type2]}]}" title="{res[{session_user[race]}][alt][{com_value[mch_type2]}]}" />
			</td>
			<td><math oper="{com_value[mch_nb2]}/{com_value[mch_nb]}" />
			<td>
			<if cond="|{com_value[mch_tours]}| >= 0">
			Expiration: <math oper="{MCH_MAX}-{com_value[mch_tours]}" /> tours
			</if>
			<else>
			En Attente ...
			</else>
			</td>
			<td>
			<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=my&amp;com_cid={com_value[mch_cid]}" title="Annuler la vente: {res[{session_user[race]}][alt][{mch_type}]}">Annuler</a>
			</td>
		</tr>
		</foreach>
		</table>
	</if>
	<elseif cond='|{com_cid}|'>
	Etes vous sûr de vouloir annuler la vente n° {com_cid} ?
	[
	<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=my&amp;com_cid={com_cid}&amp;ok=ok">Oui</a>
	]
	-
	[
	<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}">Non</a>
	]
	</elseif>
	<elseif cond='|{com_cancel}| == true'>
		<p class="ok">Vente Annulée</p>
	</elseif>
	<elseif cond='|{com_cancel}| == false'>
		<p class="error">Erreur.</p>
	</elseif>
	<else>
		<p class="infos">Vous n'avez aucune ressource en vente pour le moment.</p>
	</else>
</if>
<elseif cond='|{btc_act}|== "ven"'>
	<if cond='|{max_ventes}| AND |{max_ventes}| <= |{nb_ventes}|'>
		<p class="infos">Vous avez déjà {nb_ventes}/{max_ventes} ventes simultanées ce qui est le maximum avec votre niveau technologique actuel.</p>
	</if>
	<if cond='|{btc_sub}| =="choix_type"'>
		Ventes: {nb_ventes}/{max_ventes}<br/><br/>
		Choisissez les types de ressource à échanger.<br/><br/>
		<form action="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ven" method="post">
		A Vendre :
		<select name="com_type">
		<foreach cond='|{com_user_res}| as |{res_id}| => |{res_value}|'>
			<if cond='|{res_value[res_nb]}| > 0 AND |{com_list_res[{res_id}][vars][nobat]}| != true AND !(|{com_only_gold}| AND |{res_id}| == 1)'>
			<option value="{res_id}"> 
			{res[{session_user[race]}][alt][{res_id}]} 		({res_value[res_nb]})
			</option>
			</if>
		</foreach>
		</select>
		<br/>
		En Echange :
		<select name="com_type2">
		<if cond='|{com_only_gold}|'>
			<option value="1"> 
			{res[{session_user[race]}][alt][1]} 		({com_user_res[1][res_nb]})
			</option>
		</if>
		<else>
		<foreach cond='|{com_list_res}| as |{res_id}| => |{res_value}|'>
			<if cond='|{res_value[vars][nobat]}| != true AND |{res_value[dispo]}| == 1'>
			<option value="{res_id}"> 
			{res[{session_user[race]}][alt][{res_id}]} 		({com_user_res[{res_id}][res_nb]})
			</option>
			</if>
		</foreach>
		</else>
		</select>
		<input name="submit" value="Suivant ->" type="submit">
		</form>
		
	</if>
	<elseif cond='|{btc_sub}| =="choix_param"'>
		<script language="javascript">
		function set_prix_unit()
		{
			var nb = document.form.com_nb.value;
			var nb2 = document.form.com_nb2.value;
			if(nb && nb2)
			{
				prix_unit = ((Math.round((nb2 / nb)*1000))/1000);
				document.form.prix_unit.value = prix_unit;
			}
		}
		</script>
		<form name="form" action="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ven" method="post">
		
		A Vendre : 
		<img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[{session_user[race]}][alt][{com_type}]}" title="{res[{session_user[race]}][alt][{com_type}]}" />
		{res[{session_user[race]}][alt][{com_type}]}
		<input type="hidden" value="{com_type}" name="com_type" />
		<br/>
		
		Quantité a vendre (max: {com_max_nb}) :
		<br/>
		<input type="text" onkeyup="set_prix_unit();"  value="{com_nb}" name="com_nb" />
		<br/>
		<br/>
		En Echange : 
		<img src="img/{session_user[race]}/res/{com_type2}.png" alt="{res[{session_user[race]}][alt][{com_type2}]}" title="{res[{session_user[race]}][alt][{com_type2}]}" />
		{res[{session_user[race]}][alt][{com_type2}]}
		<br/>
		Quantité :
		<br/><input type="text" onkeyup="set_prix_unit();"  value="{com_nb2}" name="com_nb2" />
		<input type="hidden" value="{com_type2}" name="com_type2"/>
		<br/><br/>Prix unitaire : 
		<input type="text" name="prix_unit"/><br/>
		<br/>
		<input type="submit" value="Mettre en vente">
		</form>
		<if cond='is_array(|{com_cours}|)'>	
				<hr/>
				<h2>Infos sur les ventes de <img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[{session_user[race]}][alt][{com_type}]}" title="{res[{session_user[race]}][alt][{com_type}]}" /></h2>
				{res[{session_user[race]}][alt][{com_type}]} en vente : {com_infos[total_ventes]}
				<img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[{session_user[race]}][alt][{com_type}]}" title="{res[{session_user[race]}][alt][{com_type}]}" />
				<br/>
				Ventes contre:<br/>
				<dl>
				<foreach cond='|{com_cours}| as |{res_type}| => |{com_value}|'>
					<dt>
					<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[{session_user[race]}][alt][{res_type}]}" title="{res[{session_user[race]}][alt][{res_type}]}" />
		  			{res[{session_user[race]}][alt][{res_type}]} 
		  			<if cond="|{com_infos[nb_ventes][{res_type}]}|">
		  				({com_infos[nb_ventes][{res_type}]})
		  			</if>
		  			</dt>
					<dd>
					Total: {res_value[1]} <img src="img/{session_user[race]}/res/{com_type}.png" 	alt="{res[{session_user[race]}][alt][{com_type}]}" title="{res[{session_user[race]}][alt][{com_type}]}" />
		  			contre {res_value[2]} <img src="img/{session_user[race]}/res/1.png" alt="{res[{session_user[race]}][alt][1]}" title="{res[{session_user[race]}][alt][1]}" />
		  			<br/>
		  			Prix unitaire minimum : <math oper="round({com_cours[{com_type}]}*{COM_TAUX_MIN},2)" /><br/>
		  			<if cond="|{com_infos[ventes][{com_type}][1]}|">
		  				Prix unitaire moyen : <math oper="round({com_infos[ventes][{com_type}][2]}/{com_infos[ventes][{com_type}][1]},2)" /><br/>
		  			</if>
		  			Prix unitaire maximum : <math oper="round({com_cours[{com_type}]}*{COM_TAUX_MAX},2)" /><br/>
					</dd>
				</foreach>
				</dl>
		</if>
	</elseif>
	<elseif cond='|{btc_sub}| =="vente"'>
		<if cond='|{vente_ok}|'>
			<p class="ok"> Mise en vente effectuée, elle apparaîtra dans le marché dans quelques tours et sera supprimée dans {MCH_MAX} tours si il n'y a aucun acheteur.</p>
		</if>
		<else>
			<if cond='|{btc_max_nb}|'>
				<p class="error">Impossible de faire des transaction de plus de {btc_max_nb} en même temps</p>
			</if>
			<else>
				<p class="error">Vous n'avez pas les ressources que vous voulez mettre en vente</p>
			</else>
		</else>
	</elseif>	
</elseif>
<elseif cond='|{btc_act}| == "ach"'>
	<if cond='!|{btc_sub}|'>
		<if cond='is_array(|{com_liste}|)'>
			<foreach cond='|{com_liste}| as |{mch_value}|'>
			<set name="mch_type" value="{mch_value[mch_type]}" />
			<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{res[{session_user[race]}][alt][{mch_type}]}" title="{res[{session_user[race]}][alt][{mch_type}]}" />
			<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ach&amp;com_type={mch_type}" title="Afficher {res[{session_user[race]}][alt][{mch_type}]}">{res[{session_user[race]}][alt][{mch_type}]}</a><br />
			<if cond='|{com_type}| == |{mch_type}|'>
				<table class="border1">
				<tr>
				<th>Nombre</th>
				<th>Prix</th>
				<th>Prix Unitaire</th>
				<th>Actions</th>
				<if cond='{is_sherif}'><th>Pseudo</th></if>
				</tr>
				<foreach cond='|{com_array}| as |{key}| => |{res_value}|'>
					<if cond="|{res_value[mch_nb]}| <= |{max_nb}| AND |{res_value[mch_nb2]}| <= |{max_nb}|">
					<tr>
					<td>
					{res_value[mch_nb]} 
					<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{res[{session_user[race]}][alt][{mch_type}]}" title="{res[{session_user[race]}][alt][{mch_type}]}" />
					</td> 
					<td>
					{res_value[mch_nb2]} 
					<img src="img/{session_user[race]}/res/{res_value[mch_type2]}.png" alt="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" title="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" />
					</td>
					<td>
					<math oper="round({res_value[mch_nb2]}/{res_value[mch_nb]},2)" />
					</td>
					<td>
					<if cond="|{res_value[mch_nb]}| <= |{max_nb}| AND |{res_value[mch_nb2]}| <= |{max_nb}|">
					<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ach&amp;com_cid={res_value[mch_cid]}" title="Acheter {res[{session_user[race]}][alt][{mch_type}]}">Acheter</a>
					-
					<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ach&amp;com_cid={res_value[mch_cid]}&amp;com_neg=true" title="Négocier la vente de {res[{session_user[race]}][alt][{mch_type}]}">Négocier</a>
					</if>
					</td>
					<if cond='{is_sherif}'>
					<td>
					<a href="index.php?file=member&amp;act=view&amp;mid={res_value[mch_mid]}" title="Infos sur {res_value[mbr_pseudo]}">{res_value[mbr_pseudo]}</a>
					</td>
					</if>
					</tr>
					</if>
				</foreach>
				</table>
			</if>
			</foreach>
			<if cond='is_array(|{com_infos}|)'>	
				<hr/>
				<h2>Infos sur les ventes de <img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[{session_user[race]}][alt][{com_type}]}" title="{res[{session_user[race]}][alt][{com_type}]}" /></h2>
				{res[{session_user[race]}][alt][{com_type}]} en vente : {com_infos[total_ventes]}
				<img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[{session_user[race]}][alt][{com_type}]}" title="{res[{session_user[race]}][alt][{com_type}]}" />
				<br/>
				Ventes contre:<br/>
				<dl>
				<foreach cond='|{com_infos[ventes]}| as |{res_type}| => |{res_value}|'>
					<dt>
					<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[{session_user[race]}][alt][{res_type}]}" title="{res[{session_user[race]}][alt][{res_type}]}" />
		  		{res[{session_user[race]}][alt][{res_type}]} ({com_infos[nb_ventes][{res_type}]})
		  		</dt>
					<dd>
					Total: {res_value[1]} <img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[{session_user[race]}][alt][{com_type}]}" title="{res[{session_user[race]}][alt][{com_type}]}" />
		  		contre {res_value[2]} <img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[{session_user[race]}][alt][{res_type}]}" title="{res[{session_user[race]}][alt][{res_type}]}" />
		  		<br/>
		  		Prix unitaire minimum : <math oper="round({com_cours[{com_type}]}*{COM_TAUX_MIN},2)" /><br/>
		  		Prix unitaire moyen : <math oper="round({res_value[2]}/{res_value[1]},2)" /><br/>
		  		Prix unitaire maximum : <math oper="round({com_cours[{com_type}]}*{COM_TAUX_MAX},2)" />
					</dd>
				</foreach>
				</dl>
			</if>
		</if>
		<else>
			<p class="infos">Aucune marchandise n'est en vente.</p>
		</else>	
	</if>
	<if cond='|{btc_sub}| == "achat"'>
		<if cond='|{btc_achat}| == "ok"'>
			<p class="ok">Achat effectué !
			<if cond="{com_neg}">
				<if cond="|{com_neg}|<1">
					Votre réputation de marchand n'est plus à faire : vous avez négocié avec succès une ristourne de  <math oper="abs({com_neg}*100-100)" />% sur le prix de base !
				</if>
				<elseif cond="|{com_neg}|>1">
					Votre tentative de négocier un prix pourtant si attrayant choque le vendeur : vous payez <math oper="abs({com_neg}*100-100)" />% de plus.
				</elseif>
				<else>
					Vous etes tombé sur un dur, il ne lachera rien de plus !
				</else>
			</if>
			</p>
		</if>
		<elseif cond='|{btc_achat}| == "nores"'>
			<p class="error">Vous n'avez pas les ressources nécessaires pour acheter cela</p>
		</elseif>
		<elseif cond='isset(|{btc_max_nb}|)'>
			<p class="error">Avec votre niveau de développement actuel vous ne pouvez acheter plus de {btc_max_nb} ressources a la fois !</p>
		</elseif>
		<else>
			<p class="error">Erreur.</p>
		</else>
	</if>
</elseif>
<elseif cond='|{btc_act}| == "cours"'>
	<if cond="count(|{mch_cours}|)">
		<if cond="{mch_type}">
		</if>
		<else>
			<table class="border1">
			<tr>
				<th>Ressource ({com_nb})</th>
				<th>Prix Min</th>
				<th>Prix Conseillé</th>
				<th>Prix Max</th>
			<tr>
			<foreach cond="|{mch_cours}| as |{mch_value}|">
			<tr>
				<td>
				<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cours_sem&amp;com_type={mch_value[mch_cours_res]}" title="Cours de  {res[{session_user[race]}][alt][{mch_value[mch_cours_res]}]}">
				<img src="img/{session_user[race]}/res/{mch_value[mch_cours_res]}.png" alt="{res[{session_user[race]}][alt][{mch_value[mch_cours_res]}]}" title="{res[{session_user[race]}][alt][{mch_value[mch_cours_res]}]}" />
				 {res[{session_user[race]}][alt][{mch_value[mch_cours_res]}]}
				</a>
				</td>
				<td>
				<math oper="{mch_value[mch_cours_cours]}*{COM_TAUX_MIN}*{com_nb}" />
				<img src="img/{session_user[race]}/res/1.png" alt="{res[{session_user[race]}][alt][1]}" title="{res[{session_user[race]}][alt][1]}" />
				</td>
				<td>
				<math oper="{mch_value[mch_cours_cours]}*{com_nb}" />
				<img src="img/{session_user[race]}/res/1.png" alt="{res[{session_user[race]}][alt][1]}" title="{res[{session_user[race]}][alt][1]}" />
				</td>
				<td>
				<math oper="{mch_value[mch_cours_cours]}*{COM_TAUX_MAX}*{com_nb}" />
				<img src="img/{session_user[race]}/res/1.png" alt="{res[{session_user[race]}][alt][1]}" title="{res[{session_user[race]}][alt][1]}" />
				</td>
			</tr>
			</foreach>
			</table>
			
			<form action="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cours" method="post">
				<label for="com_nb">Modifier le nombre de ressource</label>
				<input type="text" id="com_nb" name="com_nb" value="{com_nb}" />
				<input type="submit" value="Modifier" />
			</form>
		</else>
	</if>
	<else>
		<p class="infos">Aucun cours à afficher.</p>
	</else>
</elseif>
<elseif cond='|{btc_act}| == "cours_sem"'>
	<if cond="count(|{mch_cours}|)">
		<table class="border1">
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
		<foreach cond="|{mch_cours}| as |{mch_type}| => |{mch_res_array}|">
		<tr>
			<td>
			<set name="mch_last_cours" value="0" />
			<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{res[{session_user[race]}][alt][{mch_type}]}" title="{res[{session_user[race]}][alt][{mch_type}]}" />
			 {res[{session_user[race]}][alt][{mch_type}]}
			</td>
			<foreach cond="|{mch_res_array}| as |{mch_result}|">
			<td>
			<if cond="{mch_last_cours}">
				<if cond="|{mch_last_cours}| < |{mch_result[mch_sem_cours]}|">
					<span class="gain">{mch_result[mch_sem_cours]}</span>
					<img src="img/up.png" alt="up" />
				</if>
				<elseif cond="|{mch_last_cours}| > |{mch_result[mch_sem_cours]}|">
					<span class="perte">{mch_result[mch_sem_cours]}</span>
					<img src="img/down.png" alt="down" />
				</elseif>
				<else>
					{mch_result[mch_sem_cours]}
				</else>
			</if>
			<else>
				{mch_result[mch_sem_cours]}
			</else>
			<set name="mch_last_cours" value="{mch_result[mch_sem_cours]}" />
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