<if cond='|{nws_act}| == "new"'>
	<form id="myForm" method="post" action="index.php?file=admin&amp;module=newsletter">
		<label for="nws_titre">Titre :</label>
		<input type="text" value="{nws_titre}" name="nws_titre" id="nws_titre" />
		<br />
		<label for="nws_diff">Envoyer à :</label>
		<select name="nws_diff" id="nws_diff">
			<option value="0">Tous</option>
			<option value="7">Depuis une semaine</option>
			<option value="30">Depuis un mois</option>
		</select>
		<input type="checkbox" value="1" name="mbr_valide" id="mbr_valide" /> <label for="mbr_valide">Validé</label>
		<br />
		<include file='commun/bbcode.tpl' cache='1' /><br/>
		<textarea id="message" name="nws_message" rows="5" cols="40">{nws_message}</textarea><br />
		<input type="submit" value="Voir"> <input type="submit" onClick="document.getElementById('myForm').action='index.php?file=admin&amp;act=send&amp;module=newsletter';" value="Envoyer">
	</form>
	<hr />
	Aperçu :<br/>
	<div class="news">
	<h1>{nws_titre_parsed}</h1>
	{nws_message_parsed}
	</div>
</if>
<elseif cond='|{nws_act}| == "send"'>
	<if cond='{nwsl_ok}'>
		<p class="ok">Ok envoyé {nwsl_nb} mails !</p>
	</if>
	<else>
		<p class="error">Merde ...</p>
	</else>
</elseif>
<p class="retour_module">[ <a href="index.php?file=admin&amp;module=newsletter" title="Retour">Retour</a> ]</p>