<form action="msg-send_massif.html" method="post" id="newpost">
	<if cond='isset({forbidden}) && {forbidden}'><p class="error">Vous ne pouvez pas envoyer de message aux joueurs, seulement au staff.</p></if>
	<elseif cond='isset({msg_pas_tout})'><p class="infos">Il manque des infos.</p></elseif>
	<p><label for="pst_titre">Titre</label>
	<input type="text" maxlength="150" name="pst_titre" id="pst_titre" <if cond="isset({msg_titre})">value="{msg_titre}"</if> /></p>

	<em>Sélectionner un ou plusieurs groupe(s). Aucune sélection = tous!</em>
	<table><tr><th>Destinataires :</th>
	<foreach cond="{groupes} as {key} => {val}">
		<td><input type="checkbox" id="groupes[{key}]" name="groupes[{key}]" />
			<label for="groupes[{key}]">{val}</label>
		</td>
		<if cond="({key} % 5) == 4"></tr><tr></if>
	</foreach>
	</tr></table>

	<include file='commun/bbcode.tpl' cache='1' />
	<p><textarea id="message" cols="60" rows="11" name="pst_msg"><if cond="isset({msg_texte})">{msg_texte}</if></textarea> </p>
	<p>
		<input type="submit" value="Envoyer" />
		<input type="button" id="btpreview" value="Prévisualiser" />
	</p>
</form>

<div id="preview"></div>

