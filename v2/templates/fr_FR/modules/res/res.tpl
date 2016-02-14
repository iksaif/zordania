<p class="menu_module">
[ <a href="bonus.html" OnClick="goOpener(this.href);return false;" title="Gagner des ressources !" class="bonus">Gagner des ressources</a> ]
</p>

<if cond='is_array({res_dispo})'>
	<table class="liste">
		<tr>
			<th>Type</th>
			<th>Nombre</th>
		</tr>
		<foreach cond='{res_dispo} as {res_id} => {res_nb}'>
			<tr>
			<td>
				<img src="img/{_user[race]}/res/{res_id}.png" alt="{res[{_user[race]}][alt][{res_id}]}" title="{res[{_user[race]}][alt][{res_id}]}" />
				{res[{_user[race]}][alt][{res_id}]}
			</td>
			<td>{res_nb}</td>
			</tr>
		</foreach>
	</table>
</if>

<if cond='is_array({trn_dispo})'>
<h2 class="titre_module">Terrains</h2>
	<table class="liste">
		<tr>
			<th>Type</th>
			<th>Nombre</th>
		</tr>
		<foreach cond='{trn_dispo} as {trn_id} => {trn_nb}'>
			<tr>
			<td>
				<img src="img/{_user[race]}/trn/{trn_id}.png" alt="{trn[{_user[race]}][alt][{trn_id}]}" title="{trn[{_user[race]}][alt][{trn_id}]}" />
				{trn[{_user[race]}][alt][{trn_id}]}
			</td>
			<td>{trn_nb}</td>
			</tr> 
		</foreach>
	</table>
</if>

