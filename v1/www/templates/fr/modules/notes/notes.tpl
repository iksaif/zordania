<p class="menu_module">
[
<a href="index.php?file=notes" title="Notes">Notes</a>
] - [
<a href="index.php?file=notes&amp;act=add" title="Ajouter une note">Nouvelle Note</a>
] - [
<a href="index.php?file=notes&amp;act=del&amp;nid=0" title="Vider">
<img src="img/drop.png" alt="Vider" /> Vider 
</a>
]
</p>

<if cond="|{nte_act}| == 'add'">
<if cond="{nte_ok}">
<p class="ok">Note enregistrée !</p>
</if>
<else>
	<form action="index.php?file=notes&amp;act=add" method="post">
	<label for="nte_titre">Titre:</label> <input type="text" id="nte_titre" name="nte_titre" value="{nte_titre}" /><br/>
	<label for="nte_import">Importance:</label>
	<select name="nte_import" id="nte_import">
	<foreach cond="|{import}| as |{imp_id}| => |{imp_name}|">
		<option value="{imp_id}" <if cond="|{imp_id}| == |{nte_import}|">selected="selected"</if>>{imp_name}</option>
	</foreach>
	</select><br/>
	<include file='commun/bbcode.tpl' cache='1' /><br/>
	<textarea id="message" cols="60" rows="11" name="nte_texte">{nte_texte}</textarea> 
	<br/>
	<input type="submit" value="Enregistrer" />
	</form>
</else>
</if>
<elseif cond="|{nte_act}| == 'edit'">
<if cond="{nte_bad_nid}">
<p class="error">Note Inexistante !</p>
</if>
<else>
	<if cond="{nte_ok}">
	<p class="ok">Note Editée !</p>
	</if>
	<form action="index.php?file=notes&amp;act=edit&amp;nid={nte_nid}" method="post">
	<label for="nte_titre">Titre:</label> <input type="text" id="nte_titre" name="nte_titre" value="{nte_titre}" /><br/>
	<label for="nte_import">Importance:</label>
	<select name="nte_import" id="nte_import">
	<foreach cond="|{import}| as |{imp_id}| => |{imp_name}|">
		<option value="{imp_id}" <if cond="|{imp_id}| == |{nte_import}|">selected="selected"</if>>{imp_name}</option>
	</foreach>
	</select><br/>
	<include file='commun/bbcode.tpl' cache='1' /><br/>
	<textarea id="message" cols="60" rows="11" name="nte_texte">{nte_texte}</textarea> 
	<br/>
	<input type="submit" value="Enregistrer" />
	</form>
</else>

</elseif>
<elseif cond="|{nte_act}| == 'del'">
<if cond="{nte_ok}">
<p class="ok">Note(s) Supprimée(s) !</p>
</if>
<elseif cond="{nte_bad_nid}">
<p class="error">Note Inexistante !</p>
</elseif>
</elseif>
<elseif cond="|{nte_act}| == 'view'">
<h3>{nte_array[nte_titre]}</h2>
Importance:  {import[{nte_array[nte_import]}]} <br/>
Date: Le {nte_array[nte_date_formated]}<br/>
Actions:
<a href="index.php?file=notes&amp;act=edit&amp;nid={nte_array[nte_nid]}"><img src="img/editer.png" alt="Editer" title="Editer" /></a>
-
<a href="index.php?file=notes&amp;act=del&amp;nid={nte_array[nte_nid]}"><img src="img/drop.png" alt="Supprimer" title="Supprimer" /></a>
<div class="block_1">
{nte_array[nte_texte]}
</div>
</elseif>
<else>
<if cond="count(|{nte_array}|)">
	<table class="border1">
		<tr>
		<th>Titre</th>
		<th>Date</th>
		<th>Importance</th>
		<th>Actions</th>
		</tr>
	<foreach cond="|{nte_array}| as |{result}|">
		<tr>
		<td><a href="index.php?file=notes&amp;act=view&amp;nid={result[nte_nid]}" title="Voir '{result[nte_titre]}'">{result[nte_titre]}</td>
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
</else>

<p class="retour_module">[ <a href="index.php?file=notes" title="Retour">Retour</a> ]</p>