<if cond='{msg_array}'>
<form method="post" action="msg-del_rec.html">
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
			<zurlmbr gid="{result[mbr_gid]}" mid="{result[mrec_from]}" pseudo="{result[mbr_pseudo]}"/>
		</td>
		<td>
			<a href="msg-read.html?mrec_id={result[mrec_id]}" title="Lire ce message">
			<if cond='!{result[mrec_readed]}'><img src="img/paslu.png"/></if>
			<else><img src="img/lu.png"/></else>
			- {result[mrec_titre]}</a>
		</td>
		<td>{result[mrec_date_formated]}</td>
		<td>
		<a href="msg-new.html?mbr_mid={result[mrec_from]}&mrec_id={result[mrec_id]}" title="Répondre">
		<img src="img/reply.png"/></a>
		- <a href="msg-del_rec.html?msg_id={result[mrec_id]}" title="Effacer ce message"> 
		<img src="img/drop.png"/></a>
		- <input type="checkbox" name="msg_id[{result[mrec_id]}]">
		<if cond="{result[msg_sign]} == 1">
			- <img src="img/up.png" title="Message déjà signalé"/>
		</if>
		<else>
			- <a href="msg-fsign.html?msgid={result[mrec_id]}" title="signaler ce message"><img src="img/surv.png"/></a>
		</else>
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
