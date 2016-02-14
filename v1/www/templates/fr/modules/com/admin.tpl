<p class="menu_module">
[ 
<a href="index.php?file=admin&module=com&act=prix">Prix</a>
]
-
[
<a href="index.php?file=admin&module=com&act=ach">Ventes</a> 
]
-
[
<a href="index.php?file=admin&module=com&act=sherif&sub=tmp">Ventes en Attente</a> 
]-[
<a href="index.php?file=admin&module=com&act=cours" title="Cours moyens">Cours</a>
]-[
<a href="index.php?file=admin&module=com&act=cours_sem" title="Cours sur la semaine">Cours de la Semaine</a>
]
</p>
<br />
<if cond='|{btc_act}| == "ach"'>
	<if cond='!|{btc_sub}|'>
		<if cond='is_array(|{com_liste}|)'>
			<foreach cond='|{com_liste}| as |{mch_value}|'>
			<set name="mch_type" value="{mch_value[mch_type]}" />
			<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{res[{session_user[race]}][alt][{mch_type}]}" title="{res[{session_user[race]}][alt][{mch_type}]}" />
			<a href="index.php?file=admin&module=com&act=ach&com_type={mch_type}" title="Afficher {res[{session_user[race]}][alt][{mch_type}]}">{res[{session_user[race]}][alt][{mch_type}]}</a><br />
			<if cond='|{com_type}| == |{mch_type}|'>
				<ul>
				<foreach cond='|{com_array}| as |{key}| => |{res_value}|'>
					<if cond='!|{lst_com_type2}| OR |{lst_com_type2}| != |{res_value[mch_type2]}|'>
						<if cond='|{lst_com_type2}| AND |{com_type2}| == |{lst_com_type2}|'>
						</ul>
						</if>
						<set name="lst_com_type2" value="{res_value[mch_type2]}" />
						<img src="img/{session_user[race]}/res/{res_value[mch_type2]}.png" alt="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" title="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" />
						<a href="index.php?file=admin&module=com&act=ach&com_type={mch_type}&com_type2={res_value[mch_type2]}" title="Afficher {res[{session_user[race]}][alt][{mch_type}]} contre {res[{session_user[race]}][alt][{res_value[mch_type2]}]}">{res[{session_user[race]}][alt][{res_value[mch_type2]}]}</a><br />			
						<if cond='|{com_type2}| == |{res_value[mch_type2]}|'>
						<ul>
						</if>
					</if>
					<if cond='|{com_type2}| == |{res_value[mch_type2]}|'>
					<li>
					Nombre : {res_value[mch_nb]} 
					<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{res[{session_user[race]}][alt][{mch_type}]}" title="{res[{session_user[race]}][alt][{mch_type}]}" />
					| 
					Prix : {res_value[mch_nb2]} 
					<img src="img/{session_user[race]}/res/{res_value[mch_type2]}.png" alt="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" title="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" />
					<if cond="|{res_value[mch_nb]}| <= |{max_nb}| AND |{res_value[mch_nb2]}| <= |{max_nb}|">
					|
					</if>
					|
					<a href="index.php?file=member&act=view&mid={res_value[mch_mid]}" title="Infos sur {res_value[mbr_pseudo]}">{res_value[mbr_pseudo]}</a>
					-  
					<a href="index.php?file=admin&module=com&act=sherif&sub=cancel&com_cid={res_value[mch_cid]}">Annuler</a> 
					- 
					<a href="index.php?file=msg&act=new&mbr_mid={res_value[mch_mid]}">
					<img src="img/msg.png" alt="Avertir" title="Avertir" /></a>
					– 
					<a href="index.php?file=admin&module=com&act=sherif&sub=del&com_cid={res_value[mch_cid]}">Supprimer</a> 
					(<math oper="round({res_value[mch_nb2]}/{res_value[mch_nb]},2)" />)
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
</if>
<elseif cond='|{btc_act}| == "sherif"'>
	<if cond='|{com_sub}| == "cancel_del"'>
		<if cond='{com_ok}'>
		Ok, joueur punnis, hahaha *rire sadique*.
		</if>
		<else>
		Elle existe pas cette vente bourdel.
		</else>
	</if>
	<if cond='|{com_sub}| == "tmp"'>
	<if cond='is_array(|{com_liste}|)'>
	<ul>
		<foreach cond='|{com_liste}| as |{key}| => |{res_value}|'>
			<li>
				Nombre : {res_value[mch_nb]}
				<img src="img/{session_user[race]}/res/{res_value[mch_type]}.png" alt="{res[{session_user[race]}][alt][{res_value[mch_type]}]}" title="{res[{session_user[race]}][alt][{res_value[mch_type]}]}" />
				| 
				Prix : {res_value[mch_nb2]} 
				<img src="img/{session_user[race]}/res/{res_value[mch_type2]}.png" alt="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" title="{res[{session_user[race]}][alt][{res_value[mch_type2]}]}" />
				|
				<a href="index.php?file=member&act=view&mid={res_value[mch_mid]}" title="Infos sur {res_value[mbr_pseudo]}">{res_value[mbr_pseudo]}</a>
				-  
				<a href="index.php?file=admin&module=com&act=sherif&sub=cancel&com_cid={res_value[mch_cid]}">Annuler</a> 
				- 
				<a href="index.php?file=msg&act=new&mbr_mid={res_value[mch_mid]}">
				<img src="img/msg.png" alt="Avertir" title="Avertir" /></a>
				– 
				<a href="index.php?file=admin&module=com&act=sherif&sub=del&com_cid={res_value[mch_cid]}">Supprimer</a> 
					(<math oper="round({res_value[mch_nb2]}/{res_value[mch_nb]},2)" />)
			</li>
		</foreach>
		<if cond='|{lst_com_type2}| AND |{com_type2}| == |{lst_com_type2}|'>
				</ul>
		</if>
	</ul>
	</if>
	<else>
	Rien
	</else>
	</if>
</elseif>
<elseif cond='|{btc_act}| == "list_sherif"'>
	<if cond='is_array(|{mbr_array}|)'>
		<foreach cond='|{mbr_array}| as |{result}|'>
		<p>
		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos about {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   		<br/>
   		Language: <img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /><br/>
		Message: <a href="index.php?file=msg&act=new&mbr_mid={result[mbr_mid]}" title="Send a message to {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="Msg" />
   		</a>
   		</p>
		</foreach>
	</if>
</elseif>
<elseif cond='|{btc_act}| == "cours"'>
	<if cond="count(|{mch_cours}|)">
		<if cond="{mch_type}">
		</if>
		<else>
			<form method="post" action="index.php?file=admin&module=com&act=cours">
			<table class="border1">
			<tr>
				<th>Ressource ({com_nb})</th>
				<th>Prix Min</th>
				<th>Prix Conseillé</th>
				<th>Modifier</th>
				<th>Prix Max</th>
			<tr>
			<foreach cond="|{mch_cours}| as |{mch_value}|">
			<tr>
				<td>
				<img src="img/{session_user[race]}/res/{mch_value[mch_cours_res]}.png" alt="{res[{session_user[race]}][alt][{mch_value[mch_cours_res]}]}" title="{res[{session_user[race]}][alt][{mch_value[mch_cours_res]}]}" />
				 {res[{session_user[race]}][alt][{mch_value[mch_cours_res]}]}
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
				<input type="text" name="com_mod[{mch_value[mch_cours_res]}]"  value="<math oper="{mch_value[mch_cours_cours]}*{com_nb}" />"/>
				</td>
				<td>
				<math oper="{mch_value[mch_cours_cours]}*{COM_TAUX_MAX}*{com_nb}" />
				<img src="img/{session_user[race]}/res/1.png" alt="{res[{session_user[race]}][alt][1]}" title="{res[{session_user[race]}][alt][1]}" />
				</td>
			</tr>
			</foreach>
			</table>
			<input type="hidden" id="com_nb" name="com_nb" value="{com_nb}" />
			<input type="submit" value="Modifier les cours" />
			</form>
			
			<form action="index.php?file=btc&act=use&btc_type={btc_id}&sub=cours" method="post">
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

<!--
<foreach cond="|{mch_cours}| as |{mch_type}| => |{mch_res_array}|">
</foreach>
-->

	<if cond="count(|{mch_cours}|)">
		<form method="post" action="index.php?file=admin&module=com&act=cours_sem">
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
		<foreach cond="|{res[{session_user[race]}][alt]}| as |{mch_type}| => |{descr}|">
		<tr>
			<td>
			<img src="img/{session_user[race]}/res/{mch_type}.png" alt="{descr}" title="{descr}" />
			 {descr}
			</td>

			<set name="mch_last_cours" value="0" />

	<if cond="isset(|{mch_cours[{mch_type}]}|)">
			<set name="mch_res_array" value="{mch_cours[{mch_type}]}" />
			<foreach cond="|{mch_res_array}| as |{mch_result}|">
			<td>
			<input type="text" size="4" name="com_mod[{mch_result[mch_sem_jour]}][{mch_result[mch_sem_res]}]"  value="{mch_result[mch_sem_cours]}"/>
			<set name="mch_last_cours" value="{mch_result[mch_sem_cours]}" />
			</td>
			</foreach>

	</if>
	<else>
			<td><input type="text" size="4" name="com_mod[1][{mch_type}]" value="0" /></td>
			<td><input type="text" size="4" name="com_mod[2][{mch_type}]" value="0" /></td>
			<td><input type="text" size="4" name="com_mod[3][{mch_type}]" value="0" /></td>
			<td><input type="text" size="4" name="com_mod[4][{mch_type}]" value="0" /></td>
			<td><input type="text" size="4" name="com_mod[5][{mch_type}]" value="0" /></td>
			<td><input type="text" size="4" name="com_mod[6][{mch_type}]" value="0" /></td>
			<td><input type="text" size="4" name="com_mod[7][{mch_type}]" value="0" /></td>

	</else>
		</tr>
		</foreach>
		</table>
		<input type="submit" value="Modifier les cours" />
		</form>
	</if>
	<else>
		<p class="infos">Aucun cours à afficher.</p>
	</else>	
</elseif>
