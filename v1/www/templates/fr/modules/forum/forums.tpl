<div id="forums">
<if cond='|{frm_act}| == "view_all" OR |{frm_act}| == "view_cat" '>
	<if cond='is_array(|{frm_array}|)'>
	<foreach cond='|{frm_array}| as |{result}|'>
		<if cond='!|{last_cat}| OR |{last_cat}| != |{result[cat_name]}|'>
			<set name='last_cat' value='{result[cat_name]}' />
			<h2>
			<if cond='|{frm_act}| == "view_cat"'>
			<a href="index.php?file=forum" title="Index">Forums</a>
			<img src="img/right.png" alt=">" />
			</if>
			<a href="index.php?file=forum&act=view_cat&cat_cid={result[cat_id]}" title="Forums de {result[cat_name]}">{result[cat_name]}</a>
			</h2>
		</if>
		<if cond='{result[frm_id]}'>
		<p class="forum">
		<a href="index.php?file=forum&act=view_frm&frm_fid={result[frm_id]}" title="Messages dans {result[frm_name]}">{result[frm_name]}</a><br/>
		<em>{result[frm_descr]}</em><br/><br/>
		Sujets: {result[frm_pst_nb]} - Messages: {result[frm_msg_nb]}<br/>
		<if cond="{result[frm_lst_pst_pid]}">
		Dernier message:  <a href="index.php?file=forum&act=view_pst&pst_pid={result[frm_lst_pst_pid]}">{result[frm_lst_pst_titre]}</a>
		par 
		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}" />
		<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
		le {result[pst_ldate_formated]}
		</if>
		</p>
		</if>
	</foreach>
	</if>
</if>
<elseif cond='|{frm_act}| == "view_frm"'>
	<if cond='{frm_empty}'>
	<p class="infos">Forum inexistant.</p>
	</if>
	<else>
		<h2>
		<a href="index.php?file=forum" title="Index">Forums </a>
		<if cond="{frm_fid}">
			<img src="img/right.png" alt=">" /> 
			<a href="index.php?file=forum&act=view_cat&cat_cid={frm_array[0][cat_id]}" title="{frm_array[0][cat_name]}">{frm_array[0][cat_name]}</a>
			<img src="img/right.png" alt=">" /> 
			<a href="index.php?file=forum&act=view_frm&frm_fid={frm_array[0][frm_id]}" title="{frm_array[0][frm_name]}">{frm_array[0][frm_name]}</a>
		</if>
		</h2>
  	<p class="menu_module">
  	<if cond='|{can_pst}| AND |{frm_fid}|'>
  	<a href="index.php?file=forum&act=new_pst&frm_fid={frm_fid}">
  	<img src="img/forum/topic.png" alt=" " /> Nouveau Sujet</a>
		</if>
		</p>
		<if cond='is_array(|{frm_array}|)'>
		<table class="border1">
		<tr>
			<th>&nbsp;</th>
			<th>Sujet</th>
			<th>Créateur</th>
			<th>Réponses</th>
			<th>Dernière action</th>
		</tr>
		<foreach cond='|{frm_array}| as |{result}|'>
			<if cond='{result[pst_id]}'>
			<tr class="topic">
				<td>
				<if cond='|{session_forum[ldate]}| > |{result[pst_ldate]}| OR |{session_forum[lus][{result[pst_id]}]}|'>
					<img src="img/forum/{result[pst_etat]}_{result[pst_open]}_1.png" alt="{forum[etats][{result[pst_etat]}][{result[pst_open]}]} - Lu" title="{forum[etats][{result[pst_etat]}][{result[pst_open]}]} - Lu" />
				</if>
				<else>
					<img src="img/forum/{result[pst_etat]}_{result[pst_open]}_0.png" alt="{forum[etats][{result[pst_etat][{result[pst_open]}]}]} - Non Lu" title="{forum[etats][{result[pst_etat]}][{result[pst_open]}]} - Non Lu" />
				</else>
				</td>
				<td>
				<a href="index.php?file=forum&act=view_pst&pst_pid={result[pst_id]}&pst_page=last#lst_pst" title="Afficher la dernière réponse">
					<img src="img/down.png" alt="Dernier message" />
				</a>
				<a href="index.php?file=forum&act=view_pst&pst_pid={result[pst_id]}" title="Lire ce sujet">{result[pst_titre]}</a>
				<if cond='|{result[pst_msg_nb]}|+1 > |{limite_page}|'>
					[Page: 
					<for cond='|{i}| = 0; |{i}| < |{result[pst_msg_nb]}|+1; |{i}|+=|{limite_page}|'>
   					<a href="index.php?file=forum&act=view_pst&pst_pid={result[pst_id]}&pst_page=<math oper='({i} / {limite_page})' />#last_pst"><math oper='(({i} / {limite_page})+1)' /></a>
  				</for>
  				]
				</if>
				</td>
				<td>
				<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}" />
				<a href="index.php?file=member&act=view&mid={result[pst_mid]}" title="Par {result[mbr_pseudo]} le {result[pst_date_formated]}">{result[mbr_pseudo]}</a><br/> 
				</td>
				<td>
				{result[pst_msg_nb]}
				</td>
				<td>
				<img src="img/groupes/{result[mbr_lgid]}.png" alt="{groupes[{result[mbr_lgid]}]}" title="{groupes[{result[mbr_lgid]}]}" />
				<a href="index.php?file=member&act=view&mid={result[pst_lmid]}" title="Par {result[mbr_lpseudo]} le {result[pst_ldate_formated]}">{result[mbr_lpseudo]}</a><br/> 
				</td>
			</tr>
			</if>
		</foreach>
		</table>
		Page:
		<for cond='|{i}| = |{current_i}| ; |{i}| < |{pst_nb}| AND |{i}|-|{current_i}| < |{limite_nb_page}|*|{limite_page}|; |{i}|+=|{limite_page}|'>
   		<if cond='|{i}| / |{limite_page}| != |{frm_page}|'>
   		<a href="index.php?file=forum&act=view_frm&frm_fid={frm_fid}&frm_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  		</if>
  		<else>
  		<math oper='(({i} / {limite_page})+1)' />
  		</else>
  	</for>
  	<p class="menu_module">
  	<if cond='|{can_pst}| AND |{frm_fid}|'>
  	<a href="index.php?file=forum&act=new_pst&frm_fid={frm_fid}">
  	<img src="img/forum/topic.png" alt=" " /> Nouveau Sujet</a>
		</if>
		</p>
		</if>
		<else>
			<p class="infos">Forum vide</p>
		</else>
	</else>
</elseif>
<elseif cond='|{frm_act}| == "view_pst"'>
	<if cond='{pst_empty}'>
	<p class="infos">Sujet inexistant.</p>
	</if>
	<else>
		<h2>
		<a href="index.php?file=forum" title="Index">Forums </a>
		<img src="img/right.png" alt=">" /> 
		<a href="index.php?file=forum&act=view_cat&cat_cid={frm_array[cat_id]}" title="{frm_array[cat_name]}">{frm_array[cat_name]}</a>
		<img src="img/right.png" alt=">" /> 
		<a href="index.php?file=forum&act=view_frm&frm_fid={frm_array[frm_id]}" title="{frm_array[frm_name]}">{frm_array[frm_name]}</a>
		</h2>
		<p class="menu_module">
		<a href="index.php?file=forum&act=view_pst&pst_pid={pst_pid}#lst_pst" id="fst_pst">
		<img src="img/down.png" alt=" " /> Fin</a>
		<if cond='{can_pst}'>
		- <a href="index.php?file=forum&act=new_pst&frm_fid={frm_array[frm_id]}">
		<img src="img/forum/topic.png" alt=" " /> Nouveau Sujet</a>
		-  <a href="index.php?file=forum&act=new_pst&pst_pid={pst_pid}">
		<img src="img/forum/post.png" alt=" " /> Répondre</a>
		</if>
		</p>
		</br>
            Page:
            <for cond='|{i}| = 0 ; |{i}| < |{pst_nb}|; |{i}|+=|{limite_page}|'>
   		<if cond='|{i}| / |{limite_page}| != |{pst_page}|'>
   		<a href="index.php?file=forum&act=view_pst&pst_pid={pst_pid}&pst_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  		</if>
  		<else>
  		<math oper='(({i} / {limite_page})+1)' />
  		</else>
  	     </for>
		<if cond='is_array(|{pst_array}|)'>
		<foreach cond='|{pst_array}| as |{result}|'>
			<if cond='{result[pst_id]}'>
				<div class="pst">
				<img src="img/mbr_logo/{result[pst_mid]}.png" title="{result[mbr_pseudo]}" class="img_right" />
				<h2>
				<a id="{result[pst_id]}" href="index.php?file=forum&act=view_pst&pst_pid={pst_pid}#{result[pst_id]}" title="Titre">{result[pst_titre]}</a>
				</h2>
				{result[pst_texte]}
				<div class="signature">
				{result[mbr_sign]}
				</div>
				<div class="infos_pst">
						<if cond='(|{session_user[mid]}| == |{result[pst_mid]}| AND (|{can_edit}|) OR |{is_modo}|)'>
							<a href="index.php?file=forum&act=edit_pst&pst_pid={result[pst_id]}">
							<img src="img/editer.png" alt="Modifier" title="Modifier" />
							</a>
							<a href="index.php?file=forum&act=del_pst&pst_pid={result[pst_id]}">
							<img src="img/drop.png" alt="Effacer" title="Effacer" />
							</a>
						</if>
						Le {result[pst_date_formated]} 
						Par 
						<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}" /> 
						<a href="index.php?file=member&act=view&mid={result[pst_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
						<if cond="|{result[mbr_alaid]}| > 0">
							- <a href="index.php?file=alliances&act=view&al_aid={result[mbr_alaid]}" title="Infos sur {result[al_name]}">
							<img src="img/al_logo/{result[mbr_alaid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
   							</a>
						</if>
				</div>
				</div>
			</if>
		</foreach>
		<p class="menu_module">
		<a href="index.php?file=forum&act=view_pst&pst_pid={pst_pid}#fst_pst" id="lst_pst">
		<img src="img/up.png" alt=" " /> Début</a>
		<if cond='{can_pst}'>
		- <a href="index.php?file=forum&act=new_pst&frm_fid={frm_array[frm_id]}">
		<img src="img/forum/topic.png" alt=" " /> Nouveau Sujet</a>
		-  <a href="index.php?file=forum&act=new_pst&pst_pid={pst_pid}">
		<img src="img/forum/post.png" alt=" " /> Répondre</a>
		</if>
		</p>
		<br/>
		Page:
		<for cond='|{i}| = 0 ; |{i}| < |{pst_nb}|; |{i}|+=|{limite_page}|'>
   		<if cond='|{i}| / |{limite_page}| != |{pst_page}|'>
   		<a href="index.php?file=forum&act=view_pst&pst_pid={pst_pid}&pst_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  		</if>
  		<else>
  		<math oper='(({i} / {limite_page})+1)' />
  		</else>
  	</for>
		</if>
		<else>
			<p class="infos">Sujet vide</p>
		</else>
	</else>
</elseif>
<elseif cond='|{frm_act}| == "list_modo"'>
	<if cond='is_array(|{mbr_sherif}|)'>
		<h3>Modérateurs</h3>
		<foreach cond='|{mbr_sherif}| as |{result}|'>
		<p>
		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   		<br/>
   		Langue: <img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /><br/>
		Message: <a href="index.php?file=msg&act=new&mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="Msg" />
   		</a>
   		</p>
		</foreach>
	</if>
	<if cond='is_array(|{mbr_modo}|)'>
		<h3>Co-Admin</h3>
		<foreach cond='|{mbr_modo}| as |{result}|'>
		<p>
		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   		<br/>
   		Langue: <img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /><br/>
		Message: <a href="index.php?file=msg&act=new&mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="Msg" />
   		</a>
   		</p>
		</foreach>
	</if>
</elseif>
<elseif cond='|{frm_act}| == "search"'>
	<form action="index.php?file=forum&act=search" method="post">
	<label for="pst_search">Texte:</label> 
	<input type="text" name="pst_search" id="pst_search" value="{pst_search}" /> 
	<label for="pst_frm">Dans:</label>
	<select id="pst_forum" name="pst_forum">
	<if cond='is_array(|{frm_array}|)'>
	<option value="0">Tous</option>
	<foreach cond='|{frm_array}| as |{result}|'>
		<if cond='!|{last_cat}| OR |{last_cat}| != |{result[cat_name]}|'>
		<set name='last_cat' value='{result[cat_name]}' />
		<option class="gras" disabled="disabled">{result[cat_name]}</option>
		</if>
		<if cond='{result[frm_id]}'>
		<option value="{result[frm_id]}" <if cond="|{pst_forum}| == |{result[frm_id]}|">selected="selected"</if>>- {result[frm_name]}</option>
		</if>
	</foreach>
	</if>
	</select>
	<br/>
	<input type="submit" value="Rechercher" />
	</form>
	
	<if cond="{pst_search}">
	<if cond="is_array(|{pst_array}|)">
		<foreach cond="|{pst_array}| as |{result}|">
			<div class="pst">
				<h2>
				<a href="index.php?file=forum&act=view_frm&frm_fid={frm_fid}">{result[frm_name]}</a> 
				<img src="img/right.png" alt="->" />
				<a href="index.php?file=forum&act=view_pst&pst_pid={result[pst_pid]}&hl=<math oper="urlencode({pst_search})" />#{result[pst_id]}" title="Titre">{result[pst_titre]}</a>
				</h2>
				<strong>Score: {result[pst_score]}</strong>
				<p>
				{result[pst_texte]}
				</p>
				<div class="infos_pst">
						Le {result[pst_date_formated]} 
						Par 
						<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}" /> 
						<a href="index.php?file=member&act=view&mid={result[pst_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
				</div>
			</div>
		</foreach>
	</if>
	<else>
		<p class="infos">Aucun Résultat</span>
	</else>
	</if>
</elseif>
</div>
<p class="menu_module">
[ <a href="index.php?file=forum">Retour</a> ]
-
[ <a href="index.php?file=forum&act=view_frm&frm_fid=0" title="Utile pour voir les nouveaux messages">Tous les messages</a>
]
-
[ <a href="index.php?file=forum&act=search" title="Rechercher sur le forum">Rechercher</a> ]
-
[
<a href="index.php?file=forum&act=list_modo">Moderateurs</a>
]