<table class="liste" id="showComForm">
<tr>
	<th>Nombre</th>
	<th>Prix</th>
	<th>Prix Unitaire</th>
	<th>Actions</th>
	<th>Joueur</th>
</tr>
<foreach cond='{com_array} as {key} => {res_value}'>
<if cond="{res_value[mch_prix]} <= {com_max_nb}">
	<tr id="tr{res_value[mch_cid]}">
		<td>
			{res_value[mch_nb]} 
			<img src="img/{_user[race]}/res/{mch_type}.png" alt="{res[{_user[race]}][alt][{mch_type}]}" title="{res[{_user[race]}][alt][{mch_type}]}" />
		</td> 
		<td>
			{res_value[mch_prix]} 
			<img src="img/{_user[race]}/res/1.png" alt="{res[{_user[race]}][alt][1]}" title="{res[{_user[race]}][alt][1]}" />
		</td>
		<td>
			<math oper="round({res_value[mch_prix]}/{res_value[mch_nb]},2)" />
		</td>
		<td>
			<if cond="{res_value[mch_mid]} != {_user[mid]}">
			<a href="btc-use.html?btc_type={btc_id}&amp;sub=ach&amp;com_cid={res_value[mch_cid]}" title="Acheter {res[{_user[race]}][alt][{mch_type}]}" class="com">Acheter</a>
			-
			<a href="btc-use.html?btc_type={btc_id}&amp;sub=ach&amp;com_cid={res_value[mch_cid]}&amp;com_neg=true" title="Négocier la vente de {res[{_user[race]}][alt][{mch_type}]}" class="com">Négocier</a>
			</if>
		</td>
		<td>
			<a href="member-view.html?mid={res_value[mch_mid]}" title="Infos sur {res_value[mbr_pseudo]}">{res_value[mbr_pseudo]}</a>
		</td>
	</tr>
</if>
</foreach>
</table>

