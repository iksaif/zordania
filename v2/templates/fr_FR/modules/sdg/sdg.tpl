<if cond='isset({sdg_array})'>
	<if cond='isset({sdg_bad_sid})'>
		<div class="error">Ce sondage n'existe pas.</div>
	</if>
	<else>
		<if cond='isset({sdg_ok})'>
			<div class="ok">Ok, vote bien enregistré pour ce sondage !</div>
		</if>
		
		<div class="block">{sdg_array[sdg_texte]}</div>
		<if cond='{adm_sdg}==true'>
		<a href="admin-mod.html?module=sdg&amp;sdg_id={sdg_array[sdg_id]}"><img src="img/editer.png" alt="Modifier" /></a> - 
		<a href="admin-del.html?module=sdg&amp;sdg_id={sdg_array[sdg_id]}"><img src="img/drop.png" alt="Supprimer" /></a>
		</if>
		<h4>Résultat</h4>
			
		<if cond="{sdg_result}">
			<dl>
			<foreach cond="{sdg_result} as {result}">
				<dt>{result[srep_texte]}</dt>
				<dd>
					<div class="barres_grandes">
					<if cond="{sdg_array[sdg_rep_nb]}">
					<div style="width:<math oper='100-floor(({sdg_array[sdg_rep_nb]}-{result[srep_nb]}) / {sdg_array[sdg_rep_nb]} *100)' />%" class="barre_verte"></div>
					</div>
					&nbsp;<em><math oper='100-floor(({sdg_array[sdg_rep_nb]}-{result[srep_nb]}) / {sdg_array[sdg_rep_nb]} *100)' />%</em>
					</if>
					<else>
					<div style="width:0%" class="barre_verte"></div>
					</div>
					&nbsp;<em><math oper='0' />%</em>
					</else>
					<br/>
					Réponses: {result[srep_nb]}
				</dd>
			</foreach>
			</dl>
		</if>
		Réponses: {sdg_array[sdg_rep_nb]}
		<if cond="{can_vote}">
			<h4>Voter</h4>
			<form action="sdg.html?sdg_id={sdg_array[sdg_id]}" method="post">
			<foreach cond="{sdg_result} as {result}">
				 <p>
				 	{result[srep_texte]}
					<input type="radio" name="vote" value="{result[srep_id]}" id="vote{result[srep_id]}"/>
				 </p>
			</foreach>
			<br/>
			<input type="submit" name="submit" value="Voter"/>
			</form>
		</if>
	</else>
</if>
<else>
	<if cond="isset({liste_array}) && {liste_array}">
		<table class="liste">
		<tr>
		<th>Sondage</th><th>Date</th><th>Réponses</th><th>Répondu ?</th>
		</tr>
		<foreach cond="{liste_array} as {value}">
			<tr>
			<td><a href="sdg.html?sdg_id={value[sdg_id]}">{value[sdg_texte]}</a></td>
			<td>{value[sdg_date]}</td>
			<td>{value[sdg_rep_nb]}</td>
			<td>
			<if cond='{value[sdg_my_vte]}'>
				<img src="img/lu.png" alt="Répondu" title="Déjà répondu à ce sondage"/>
			</if>
			<else>
				<a href="sdg.html?sdg_id={value[sdg_id]}"><img src="img/paslu.png" title="Répondre à ce sondage"/></a>
			</else>
			</td>
			</tr>
		</foreach>
		</table>
	</if>
	<else>
		<div class="infos">Aucun sondage.</div>
	</else>
</else>

<div class="menu_module"> [ <a href="sdg.html">Retour</a> ] </div>
