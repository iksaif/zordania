<p class="menu_module">
[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}">Vos Ventes</a> 
]-[
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ven">Vendre</a> 
]-[
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ach">Acheter</a> 
]-[
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=list_sherif">Sheriffs</a> 
]
</p>
<br />
<if cond='!|{btc_act}|'>
<br>
	<if cond='is_array(|{vente_array}|)'>
		<ul>
		<foreach cond='|{vente_array}| as |{key}| => |{com_value}|'>
			<li>
			Proposé : {com_value[mch_nb]} 
			<img src="img/{session_user[race]}/res/{com_value[mch_type]}.png" alt="{res[alt][{com_value[mch_type]}]}" title="{res[alt][{com_value[mch_type]}]}" />
			|
			Prix : {com_value[mch_nb2]} 
			<img src="img/{session_user[race]}/res/{com_value[mch_type2]}.png" alt="{res[alt][{com_value[mch_type2]}]}" title="{res[alt][{com_value[mch_type2]}]}" />
			|
			<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;com_cid={com_value[mch_cid]}" title="Annuler la vente: {res[alt][{mch_type}]}">Annuler</a>
			</li>
		</foreach>
		</ul>
	</if>
	<elseif cond='|{com_cid}|'>
	Etes vous sûr de vouloir annuler la vente n° {com_cid} ?
	[
	<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;com_cid={com_cid}&amp;ok=ok">Oui</a>
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
	<if cond='{com_only_gold}'>
		<p class="infos">Tant que vous n'aurez pas effectué la recherche commerce niveau 2, vous ne pourez demander que de l'or en échange de vos marchandises.</p>
	</if>
	<if cond='|{btc_sub}| =="choix_type"'>
		Ventes: {nb_ventes}/{max_ventes}<br/><br/>
		Choisissez les types de ressource à échanger.<br/><br/>
		<form action="index.php?file=btc&amp;act=use&amp;btc_type=8&amp;sub=ven" method="post">
		A Vendre :
		<select name="com_type">
		<foreach cond='|{com_user_res}| as |{res_id}| => |{res_value}|'>
			<if cond='|{res_value[res_nb]}| > 0 AND |{com_list_res[{res_id}][vars][nobat]}| != true'>
			<option value="{res_id}"> 
			{res[alt][{res_id}]} 		({res_value[res_nb]})
			</option>
			</if>
		</foreach>
		</select>
		<br/>
		En Echange :
		<select name="com_type2">
		<if cond='|{com_only_gold}|'>
			<option value="1"> 
			{res[alt][1]} 		({com_user_res[1][res_nb]})
			</option>
		</if>
		<else>
		<foreach cond='|{com_list_res}| as |{res_id}| => |{res_value}|'>
			<if cond='|{res_value[vars][nobat]}| != true AND |{res_value[dispo]}| == 1'>
			<option value="{res_id}"> 
			{res[alt][{res_id}]} 		({com_user_res[{res_id}][res_nb]})
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
				prix_unit = ((Math.round((nb2 / nb)*10))/10);
				document.form.prix_unit.value = prix_unit;
			}
		}
		</script>
		<form name="form" action="index.php?file=btc&amp;act=use&amp;btc_type=8&amp;sub=ven" method="post">
		
		A Vendre : {res[alt][{com_type}]}
		<input type="hidden" value="{com_type}" name="com_type" />
		<br/>
		
		Quantité a vendre (max: {com_max_nb}) :
		<br/>
		<input type="text" onkeyup="set_prix_unit();"  value="{com_nb}" name="com_nb" />
		<br/>
		<br/>
		En Echange : {res[alt][{com_type2}]}
		<br/>
		Quantité :
		<br/><input type="text" onkeyup="set_prix_unit();"  value="{com_nb2}" name="com_nb2" />
		<input type="hidden" value="{com_type2}" name="com_type2"/>
		<br/><br/>Prix unitaire : 
		<input type="text" name="prix_unit"/><br/>
		<br/>
		<input type="submit" value="Mettre en vente">
		</form>
	</elseif>
	<elseif cond='|{btc_sub}| =="vente"'>
		<if cond='|{vente_ok}|'>
			<p class="ok"> Mise en vente effectuée ! </p>
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
			<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{res[alt][{mch_type}]}" title="{res[alt][{mch_type}]}" />
			<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ach&amp;com_type={mch_type}" title="Afficher {res[alt][{mch_type}]}">{res[alt][{mch_type}]}</a><br />
			<if cond='|{com_type}| == |{mch_type}|'>
				<ul>
				<foreach cond='|{com_array}| as |{key}| => |{res_value}|'>
					<if cond='!|{lst_com_type2}| OR |{lst_com_type2}| != |{res_value[mch_type2]}|'>
						<if cond='|{lst_com_type2}| AND |{com_type2}| == |{lst_com_type2}|'>
						</ul>
						</if>
						<set name="lst_com_type2" value="{res_value[mch_type2]}" />
						<img src="img/{session_user[race]}/res/{res_value[mch_type2]}.png" alt="{res[alt][{res_value[mch_type2]}]}" title="{res[alt][{res_value[mch_type2]}]}" />
						<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ach&amp;com_type={mch_type}&amp;com_type2={res_value[mch_type2]}" title="Afficher {res[alt][{mch_type}]} contre {res[alt][{res_value[mch_type2]}]}">{res[alt][{res_value[mch_type2]}]}</a><br />			
						<if cond='|{com_type2}| == |{res_value[mch_type2]}|'>
						<ul>
						</if>
					</if>
					<if cond='|{com_type2}| == |{res_value[mch_type2]}|'>
					<li>
					Nombre : {res_value[mch_nb]} 
					<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{res[alt][{mch_type}]}" title="{res[alt][{mch_type}]}" />
					| 
					Prix : {res_value[mch_nb2]} 
					<img src="img/{session_user[race]}/res/{res_value[mch_type2]}.png" alt="{res[alt][{res_value[mch_type2]}]}" title="{res[alt][{res_value[mch_type2]}]}" />
					|
					<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=ach&amp;com_cid={res_value[mch_cid]}" title="Acheter {res[alt][{mch_type}]}">Acheter</a>
					<if cond='{is_sherif}'>
					|
					<a href="index.php?file=member&amp;act=view&amp;mid={res_value[mch_mid]}" title="Infos sur {res_value[mbr_pseudo]}">{res_value[mbr_pseudo]}</a>
					-  
					<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=sherif&amp;sub2=cancel&amp;com_cid={res_value[mch_cid]}">Annuler</a> 
					- 
					<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={res_value[mch_mid]}">
					<img src="img/msg.png" alt="Avertir" title="Avertir" /></a>
					– 
					<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=sherif&amp;sub2=del&amp;com_cid={res_value[mch_cid]}">Supprimer</a> 
					(<math oper="round({res_value[mch_nb2]}/{res_value[mch_nb]},2)" />)
					</if>
					</li>
					</if>
				</foreach>
				<if cond='|{lst_com_type2}| AND |{com_type2}| == |{lst_com_type2}|'>
						</ul>
				</if>
				</ul>
			</if>
			</foreach>
			<if cond='is_array(|{com_infos}|)'>	
				<hr/>
				<h2>Infos sur les ventes de <img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[alt][{com_type}]}" title="{res[alt][{com_type}]}" /></h2>
				{res[alt][{com_type}]} en vente : {com_infos[total_ventes]}
				<img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[alt][{com_type}]}" title="{res[alt][{com_type}]}" />
				<br/>
				Ventes contre:<br/>
				<dl>
				<foreach cond='|{com_infos[ventes]}| as |{res_type}| => |{res_value}|'>
					<dt>
					<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
		  		{res[alt][{res_type}]} ({com_infos[nb_ventes][{res_type}]})
		  		</dt>
					<dd>
					Total: {res_value[1]} <img src="img/{session_user[race]}/res/{com_type}.png" alt="{res[alt][{com_type}]}" title="{res[alt][{com_type}]}" />
		  		contre {res_value[2]} <img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
		  		<br/>
		  		Prix unitaire moyen : <math oper="round({res_value[2]}/{res_value[1]},2)" />
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
			<p class="ok">Achat effectué !</p>
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
<elseif cond='|{btc_act}| == "sherif"'>
	<if cond='|{com_sub}| == "cancel_del"'>
		<if cond='{com_ok}'>
		Ok, joueur punnis, hahaha *rire sadique*.
		</if>
		<else>
		Elle existe pas cette vente bourdel.
		</else>
	</if>
</elseif>
<elseif cond='|{btc_act}| == "list_sherif"'>
	<if cond='is_array(|{mbr_array}|)'>
		<foreach cond='|{mbr_array}| as |{result}|'>
		<p>
		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos about {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   		<br/>
   		Language: <img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /><br/>
		Message: <a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Send a message to {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
   		</a>
   		</p>
		</foreach>
	</if>
</elseif>