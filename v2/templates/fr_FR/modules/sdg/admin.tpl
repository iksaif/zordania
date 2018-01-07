<p class="menu_module">
	[ <a href="admin-new.html?module=sdg">Nouveau sondage</a> ] - 
	[ <a href="admin-view.html?module=sdg">Liste</a> ]
</p>

<if cond='{adm_act} == "new" || {adm_act}=="mod"'>
	<if cond='isset({sdg_nb})'>
		<if cond="isset({sdg_ok})">
			<div class="ok">Sondage ajouté ! </div>
		</if>
		<elseif cond="isset({mod_sdg_ok})">
			<div class="ok">Sondage modifié ! </div>
		</elseif>
		<else>
			<form class="center" action="admin-new.html?module=sdg" method="post">
				<label for="sdg_texte">Question</label>
		  		<include file='commun/bbcode.tpl' cache='1' />
		   		<textarea name="sdg_texte" id="message" rows="6" cols="50">{sdg_texte}</textarea>
				<br/>
				<for cond='{i} = 0; {i} < {sdg_nb}; {i}+=1'>
					<label for="sdg_rep{i}">Choix {i}</label>
					<input type="text" name="sdg_rep[{sdg_rep[{i}][srep_id]}]" id="sdg_rep{i}" value="{sdg_rep[{i}][srep_texte]}" size="40"/><br/>
				</for>
				<input type="hidden" name="sdg_nb" value="{sdg_nb}" />
				<if cond='{adm_act}=="mod"'>
				<input type="hidden" name="sdg_id" value="{sdg_id}" />
				<input type="submit" name="submit" value="Modifier ce sondage"/>
				</if>
				<else>
				<input type="submit" name="submit" value="Ajouter le sondage"/>
				</else>
			</form>
		</else>
	</if>
	<else>
		<form action="admin-new.html?module=sdg" method="post">
			<label for="sdg_nb">Nombre de questions</label>
			<input type="text" name="sdg_nb" id="sdg_nb" value=""/><br/>
			<input type="submit" name="submit" value="Valider"/>
		</form>
	</else>
</elseif>
<elseif cond='{adm_act}=="del"'>
	<if cond="isset({sdg_ok})">
		<div class="ok">Ok, sondage supprimé !</div>
	</if>
	<else>
		<div class="infos">Êtes-vous sûr de vouloir supprimer le sondage #{sdg_id} ? [<a href="admin-del.html?module=sdg&amp;sdg_id={sdg_id}&amp;valid=ok">Oui</a>] - [<a href="admin.html?module=sdg">Non</a>]</div>
	</else>
</elseif>
<elseif cond='{adm_act}=="view"'>
		<table class="liste">
		<tr>
		<th>Sondage</th><th>Date</th><th>Réponses</th><th>Action</th>
		</tr>
		<foreach cond="{liste_array} as {value}">
			<tr>
			<td><a href="sdg.html?sdg_id={value[sdg_id]}">{value[sdg_texte]}</a></td>
			<td>{value[sdg_date]}</td>
			<td>{value[sdg_rep_nb]}</td>
			<td><a href="admin-mod.html?module=sdg&amp;sdg_id={value[sdg_id]}"><img src="img/editer.png" alt="Modifier" /></a> - 
			<a href="admin-del.html?module=sdg&amp;sdg_id={value[sdg_id]}"><img src="img/drop.png" alt="Supprimer" /></a>
			</td>
			</tr>
		</foreach>
		</table>
</elseif>



<p class="menu_module">[ <a href="admin.html">Retour</a> ]</p>
