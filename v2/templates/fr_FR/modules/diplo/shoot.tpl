	<h3>Discussion commune avec nos alliés: <a href="alliances-view.html?al_aid={pacte[dpl_al]}" title="{pacte[al_name]}">
		<img class="mini_al_logo" alt="{pacte[al_name]}" src="img/al_logo/{pacte[dpl_al]}-thumb.png" />
		{pacte[al_name]}</a></h3>


<if cond="isset({dpl_msg_del})">
		<p class="ok">Message supprimé !</p>
	</if>
	<if cond="isset({dpl_msg_post})">
		<p class="ok">Message posté !</p>
	</if>

	<form class="center" action="diplo-shoot.html?did={pacte[dpl_did]}&amp;sub=post" method="post" id="newpost">
	<include file='commun/bbcode.tpl' cache='1' /><br/>
	<input type="hidden" id="pst_titre" name="pst_titre" value="{pacte[al_name]}" />
	<textarea id="message" name="pst_msg" rows="5" cols="40"></textarea><br />
	<input type="submit" value="Envoyer" />
	<input type="button" id="btpreview" value="Prévisualiser" />
	</form>
	<div id="preview"></div>

	<if cond='is_array({dpl_shoot_array})'>
		<for cond='{i} = {current_i} ; {i} < {dpl_nb} AND {i}-{current_i} < LIMIT_NB_PAGE*LIMIT_PAGE; {i}+=LIMIT_PAGE'>
			<if cond='{i} / LIMIT_PAGE != {dpl_page}'>
				<a href="diplo-shoot.html?did={pacte[dpl_did]}&amp;dpl_page=<math oper='({i} / LIMIT_PAGE)' />"><math oper='(({i} / LIMIT_PAGE)+1)' /></a>
			</if>
			<else>
				<math oper='(({i} / LIMIT_PAGE)+1)' />
			</else>
		</for>

		<foreach cond='{dpl_shoot_array} as {result}'>
			<div class="block" id="{result[dpl_shoot_msgid]}">
			<img class="blason" title="{result[mbr_pseudo]}" src="img/mbr_logo/{result[dpl_shoot_mid]}.png" />
			<h4><zurlmbr mid="{result[dpl_shoot_mid]}" pseudo="{result[mbr_pseudo]}"/> le {result[dpl_shoot_date_formated]}<br/></h4>
			<p>
			{result[dpl_shoot_texte]}
			</p>
			<p class="signature">{result[mbr_sign]}</p>
			<if cond="{result[mbr_mid]} == {_user[mid]}">
				<a href="diplo-shoot.html?did={pacte[dpl_did]}&amp;sub=del&amp;msgid={result[dpl_shoot_msgid]}" title="Supprimer">
					<img src="img/drop.png" alt="Supprimer" title="Supprimer" />
				</a>
			</if>
			</div>
			<br />
		</foreach>
		
		<for cond='{i} = {current_i} ; {i} < {dpl_nb} AND {i}-{current_i} < LIMIT_NB_PAGE*LIMIT_PAGE; {i}+=LIMIT_PAGE'>
			<if cond='{i} / LIMIT_PAGE != {dpl_page}'>
				<a href="diplo-shoot.html?did={pacte[dpl_did]}&amp;dpl_page=<math oper='({i} / LIMIT_PAGE)' />"><math oper='(({i} / LIMIT_PAGE)+1)' /></a>
			</if>
			<else>
				<math oper='(({i} / LIMIT_PAGE)+1)' />
			</else>
		 </for>
	</if>
