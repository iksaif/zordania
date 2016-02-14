<if cond='is_array({trn_dispo})'>
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
