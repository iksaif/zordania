<p class="menu_module">
[
<a href="admin-cours.html?module=com" title="Cours moyens">Cours</a>
]-[
<a href="admin-cours_sem.html?module=com" title="Cours sur la semaine">Cours de la Semaine</a>
]
</p>
<if cond='{btc_act} == "cours"'>
	<form method="post" action="admin-cours.html?module=com">
		<table class="liste">
			<tr>
				<th>Ressource ({com_nb})</th>
				<th>Prix Min</th>
				<th>Prix Conseillé</th>
				<th>Modifier</th>
				<th>Prix Max</th>
			<tr>
			<foreach cond="{mch_cours} as {mch_value}">
			<tr>
				<td>
				<img src="img/{_user[race]}/res/{mch_value[mcours_res]}.png" alt="{res[{_user[race]}][alt][{mch_value[mcours_res]}]}" title="{res[{_user[race]}][alt][{mch_value[mcours_res]}]}" />
				 {res[{_user[race]}][alt][{mch_value[mcours_res]}]}
				</td>
				<td>
				<math oper="round({mch_value[mcours_cours]}*{COM_TAUX_MIN}*{com_nb},2)" />
				<img src="img/{_user[race]}/res/1.png" alt="{res[{_user[race]}][alt][1]}" title="{res[{_user[race]}][alt][1]}" />
				</td>
				<td>
				<math oper="round({mch_value[mcours_cours]}*{com_nb},2)" />
				<img src="img/{_user[race]}/res/1.png" alt="{res[{_user[race]}][alt][1]}" title="{res[{_user[race]}][alt][1]}" />
				</td>
				<td>
				<input type="text" name="com_mod[{mch_value[mcours_res]}]"  value="<math oper="{mch_value[mcours_cours]}*{com_nb}" />"/>
				</td>
				<td>
				<if cond="round({mch_value[mcours_cours]}*{COM_TAUX_MAX}*{com_nb},2) > {MCH_COURS_MIN}">
					<math oper="round({mch_value[mcours_cours]}*{COM_TAUX_MAX}*{com_nb},2)" />
				</if>
				<else>
					{MCH_COURS_MIN}
				</else>
				<img src="img/{_user[race]}/res/1.png" alt="{res[{_user[race]}][alt][1]}" title="{res[{_user[race]}][alt][1]}" />
				</td>
			</tr>
			</foreach>
		</table>
		<input type="hidden" id="com_nb" name="com_nb" value="{com_nb}" />
		<input type="submit" value="Modifier les cours" />
	</form>
			
	<form action="admin-cours.html?module=com" method="post">
		<label for="com_nb">Modifier le nombre de ressources</label>
		<input type="text" id="com_nb" name="com_nb" value="{com_nb}" />
		<input type="submit" value="Modifier" />
	</form>
</if>
<elseif cond='{btc_act} == "cours_sem"'>
	<form method="post" action="admin-cours_sem.html?module=com">
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
			<img src="img/{_user[race]}/res/{mch_type}.png" alt="{res[{_user[race]}][alt][{mch_type}]}" title="{res[{_user[race]}][alt][{mch_type}]}" />
			 {res[{_user[race]}][alt][{mch_type}]}
			</td>
			<foreach cond="{mch_res_array} as {mch_result}">
			<td>
			<input type="text" size="4" name="com_mod[{mch_result[msem_date]}][{mch_result[msem_res]}]"  value="{mch_result[msem_cours]}"/>
			<set name="mch_last_cours" value="{mch_result[msem_cours]}" />
			</td>
			</foreach>
		</tr>
		</foreach>
		</table>
		<input type="submit" value="Modifier les cours" />
	</form>
</elseif>
