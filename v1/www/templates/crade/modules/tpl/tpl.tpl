<p class="menu_module">
[ <a href="index.php?file=admin&amp;module=tpl" title="Liste des templates">Liste</a> ]
</p>
<hr />
<if cond='|{tpl_act}| == "liste"'>
	<h2>Liste des Templates</h2>
	<if cond='is_array(|{tpl_array}|)'>
		<if cond='count(|{tpl_array}|) > 0'>
			<table class="border1">
			<tr>
				<th>Nom</th>
				<th>Date</th>
				<th>Taille</th>
				<th>Actions</th>
			</tr>
			<if cond='{tpl_last_dir}'>
			<tr>
				<td><a href="index.php?file=admin&amp;module=tpl&amp;dir={tpl_last_dir}" title=".."> ..</a></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</if>
			<foreach cond='|{tpl_array}| as |{rien}| => |{file_array}|'>
			<tr>
				<td><img src="img/files/{file_array[ext]}.png" alt="{file_array[ext]}" />
				    <if cond='|{file_array[ext]}| == "dir"'>
				    <a href="index.php?file=admin&amp;module=tpl&amp;dir={tpl_current_dir}{file_array[name]}/" title="Lister {file_array[name]}">{file_array[name]}/</a>
				    </if>
				    <else>
				    {file_array[name]}
				    </else>
				</td>
				<td>{file_array[date]}</td>
				<td>{file_array[size]}</td>
				<td>
					<if cond='|{file_array[ext]}| != "dir"'>
					<a href="index.php?file=admin&amp;module=tpl&amp;act=edit&amp;tpl={tpl_current_dir}{file_array[name]}" title="Editer {file_array[name]}"><img src="img/editer.png" alt="Editer" /></a>
					</if>
				</td>
			</tr>
			</foreach>
			</table>
		</if>
		<else>
			Aucun Fichier.
		</else>
	</if>
	<else>
		Ce r�pertoire n'existe pas.
	</else>
</if>
<elseif cond='|{tpl_act}| == "edit"'>
	<if cond='is_array(|{tpl_array}|)'>
	<h2>Modification de {tpl_array[name]}</h2>
	Taille : {tpl_array[size]}<br/>
	Derni�re modif : {tpl_array[date]}<br/>	  
	<form method="post" action="index.php?file=admin&amp;module=tpl&amp;act=save&amp;tpl={tpl_array[name]}">
	<textarea name="tpl_contenu" cols="70" rows="30">{tpl_array[text]}</textarea>
	<input type="submit" value="Enregistrer" />
	</form>
	</if>
	<else>
	Ce Fichier n'existe pas.
	</else>

</elseif>
<elseif cond='|{tpl_act}| == "save"'>
	<if cond='|{tpl_save_ok}|'>
	<p class="ok">Ok flemmard !</p>
	</if>
	<else>
	<p class="error">Pas de chance, �a marche pas :p</p>
	</else>
</else>