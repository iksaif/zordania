<if cond="{msg_array}">
	<form method="post" action="msg-del_env.html">
	<table class="liste">
	<tr>
		<th>Pseudo</th>
		<th>Titre</th>
		<th>Date</th>
		<th>Actions</th>
	</tr>
	<foreach cond='{msg_array} as {result}'>
	<tr>
		<td>
			<zurlmbr gid="{result[mbr_gid]}" mid="{result[menv_to]}" pseudo="{result[mbr_pseudo]}"/>
		</td>
		<td>
			<a href="msg-read_env.html?menv_id={result[menv_id]}" title="Lire ce message">
			<if cond='!{result[mrec_readed]}'>
				<img src="img/paslu.png" alt="Non lu" title="Non lu" />
			</if>
			<else>
				<img src="img/lu.png" alt="Lu" title="Lu" />
			</else>
			-
			{result[menv_titre]}</a>
		</td>
		<td>{result[menv_date_formated]}</td>
		<td>
			<a href="msg-del_env.html?msg_id={result[menv_id]}" title="Effacer ce message"> 
			<img src="img/drop.png" alt="Effacer" /></a> -
			<input type="checkbox" name="msg_id[{result[menv_id]}]">
		</td>
	
	</tr>
	</foreach>
	</table>
	<input type="submit" value="Effacer Sélection" />
	</form>
</if>
<else>
	<p class="infos">Aucun message.</p>
</else>
