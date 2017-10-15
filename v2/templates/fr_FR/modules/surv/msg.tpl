<h3> Message(s) signalé(s) </h3>

<table class="liste">
	<tr>
		<th>Pseudo</th>
		<th>Expéditeur</th>
		<th>Titre message</th>
		<th>Admin</th>
		<th>Date</th>
		<th>Dernière action</th>
	</tr>
<foreach cond="{list_sign} as {value}">
	<tr>
		<td>{value[sign_mbr_pseudo]}</td>
		<td>{value[sign_from_pseudo]}</td>
		<td><strong>{value[sign_msg_titre]}</strong></td>
		<td>{value[sign_adm_pseudo]}</td>
		<td>{value[sign_debut]}</td>
		<td>{value[sign_fin]}</td>
	</tr>
	<tr><td colspan="6">{value[sign_msg_texte]}</td></tr>
	<if cond="!empty({value[sign_com]})">
		<tr><td colspan="6">{value[sign_com]}</td></tr>
	</if>
	<tr><td colspan="6">
		<form action="admin.html?module=surv&act=com" method="post">		
			<textarea name="com" id="com" rows="3" cols="40"></textarea><br/>
			<input type="submit" value="Enregistrer Commentaire" /> - <a href="admin.html?module=surv&act=assignw&mid={_user[mid]}">S'assigner</a>
		</form>
</td></tr>
</foreach>
</table>

