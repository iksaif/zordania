<p class="menu_module">
<a href="notes.html" title="Notes">Notes</a>
- <a href="notes-edit.html" title="Ajouter une note">Nouvelle Note</a>
- <a href="notes-del.html?nid=0" title="Vider"><img src="img/drop.png" alt="Vider" /> Vider</a>
</p>

<if cond='{nte_act} == "edit"'>
	<if cond="isset({nte_bad_nid})">
		<p class="error">Note Inexistante !</p>
	</if>
	<else>
		<if cond="isset({nte_ok})">
			<p class="ok">Note enregistrée !</p>
		</if>
		<form action="notes-edit.html?nid={nte_nid}" method="post" id="newpost">
		<label for="pst_titre">Titre:</label> <input type="text" id="pst_titre" name="pst_titre" value="{nte_titre}" /><br/>
		<label for="nte_import">Importance:</label>
		<select name="nte_import" id="nte_import">
		<foreach cond="{import} as {imp_id} => {imp_name}">
			<option value="{imp_id}" <if cond="{imp_id} == {nte_import}">selected="selected"</if>>{imp_name}</option>
		</foreach>
		</select><br/>
		<include file='commun/bbcode.tpl' cache='1' /><br/>
		<textarea id="message" cols="60" rows="11" name="pst_msg">{nte_texte}</textarea> 
		<br/>
		<input type="submit" value="Enregistrer" />
		<input type="button" id="btpreview" value="Prévisualiser" />
		</form>
		<div id="preview"></div>
	</else>
</elseif>
<elseif cond='{nte_act} == "del"'>
	<if cond="isset({nte_ok})">
		<p class="ok">Note(s) Supprimée(s) !</p>
	</if>
	<elseif cond="isset({nte_bad_nid})">
		<p class="error">Note Inexistante !</p>
	</elseif>
</elseif>
<elseif cond='{nte_act} == "view"'>
<if cond="{nte_array}">
	<h4>{nte_array[nte_titre]}</h3>
	Importance:  {import[{nte_array[nte_import]}]} <br/>
	Date: Le {nte_array[nte_date_formated]}<br/>
	Actions:
	<a href="notes-edit.html?nid={nte_array[nte_nid]}"><img src="img/editer.png" alt="Editer" title="Editer" /></a>
	-
	<a href="notes-del.html?nid={nte_array[nte_nid]}"><img src="img/drop.png" alt="Supprimer" title="Supprimer" /></a>
	<div class="block">
	{nte_array[nte_texte]}
	</div>
</if>
</elseif>
<else>
		<if cond="{nte_array}">
			<table class="liste">
				<tr>
				<th>Titre</th>
				<th>Date</th>
				<th>Importance</th>
				<th>Actions</th>
				</tr>
			<foreach cond="{nte_array} as {result}">
				<tr>
				<td><a href="notes-view.html?nid={result[nte_nid]}" title="Voir '{result[nte_titre]}'">{result[nte_titre]}</td>
				<td>Le {result[nte_date_formated]}</td>
				<td>{import[{result[nte_import]}]}</td>
				<td>
					<a href="index.php?file=notes&amp;act=edit&amp;nid={result[nte_nid]}"><img src="img/editer.png" alt="Editer" title="Editer" /></a>
					-
					<a href="index.php?file=notes&amp;act=del&amp;nid={result[nte_nid]}"><img src="img/drop.png" alt="Supprimer" title="Supprimer" /></a>
				</td>
				</tr>
			</foreach>
			</table>
		</if>
		<else>
			<p class="infos">Aucune note.</p>
		</else>
</elseif>
<p class="retour_module"><a href="notes.html" title="Retour">Retour</a></p>
