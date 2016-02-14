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
			<a href="index.php?file=forum&amp;act=view_cat&amp;cat_cid={result[cat_id]}" title="Forums de {result[cat_name]}">{result[cat_name]}</a>
			</h2>
		</if>
		<if cond='{result[frm_id]}'>
		<p class="forum">
		<a href="index.php?file=forum&amp;act=view_frm&amp;frm_fid={result[frm_id]}" title="Messages dans {result[frm_name]}">{result[frm_name]}</a><br/>
		{result[frm_descr]}<br/>
		Sujets: {result[pst_nb]}<br/>
		<if cond="{result[pst_id]}">
		Dernier message:  <a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid=<if cond='{result[pst_pid]}'>{result[pst_pid]}</if><else>{result[pst_id]}</else>">{result[pst_titre]}</a>
		par <a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
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
			<a href="index.php?file=forum&amp;act=view_cat&amp;cat_cid={frm_array[0][cat_id]}" title="{frm_array[0][cat_name]}">{frm_array[0][cat_name]}</a>
			<img src="img/right.png" alt=">" /> 
			<a href="index.php?file=forum&amp;act=view_frm&amp;frm_fid={frm_array[0][frm_id]}" title="{frm_array[0][frm_name]}">{frm_array[0][frm_name]}</a>
		</if>
		</h2>
  	<p class="menu_module">
  	<if cond='|{can_pst}| AND |{frm_fid}|'>
  	<a href="index.php?file=forum&amp;act=new_pst&amp;frm_fid={frm_fid}">
  	<img src="img/forum/topic.png" alt="" /> Nouveau Sujet</a>
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
					<img src="img/forum/{result[pst_etat]}_1.png" alt="{forum[etats][{result[pst_etat]}]} - Lu" title="{forum[etats][{result[pst_etat]}]} - Lu" />
				</if>
				<else>
					<img src="img/forum/{result[pst_etat]}_0.png" alt="{forum[etats][{result[pst_etat]}]} - Non Lu" title="{forum[etats][{result[pst_etat]}]} - Non Lu" />
				</else>
				</td>
				<td>
				<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={result[pst_id]}&amp;pst_page=last#lst_pst" title="Afficher la dernière réponse">
					<img src="img/down.png" alt="Dernier message" />
				</a>
				<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={result[pst_id]}" title="Lire ce sujet">{result[pst_titre]}</a>
				<if cond='|{result[pst_nb]}|+1 > |{limite_page}|'>
					[Page: 
					<for cond='|{i}| = 0; |{i}| < |{result[pst_nb]}|+1; |{i}|+=|{limite_page}|'>
   					<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={result[pst_id]}&amp;pst_page=<math oper='({i} / {limite_page})' />#last_pst"><math oper='(({i} / {limite_page})+1)' /></a>
  				</for>
  				]
				</if>
				</td>
				<td>
				<a href="index.php?file=member&amp;act=view&amp;mid={result[pst_mid]}" title="Par {result[mbr_pseudo]} le {result[pst_date_formated]}">{result[mbr_pseudo]}</a><br/> 
				</td>
				<td>
				{result[pst_nb]}
				</td>
				<td>
				<a href="index.php?file=member&amp;act=view&amp;mid={result[pst_lmid]}" title="Par {result[mbr_lpseudo]} le {result[pst_ldate_formated]}">{result[mbr_lpseudo]}</a><br/> 
				</td>
			</tr>
			</if>
		</foreach>
		</table>
		Page:
		<for cond='|{i}| = |{current_i}| ; |{i}| < |{pst_nb}| AND |{i}|-|{current_i}| < |{limite_nb_page}|*|{limite_page}|; |{i}|+=|{limite_page}|'>
   		<if cond='|{i}| / |{limite_page}| != |{frm_page}|'>
   		<a href="index.php?file=forum&amp;act=view_frm&amp;frm_fid={frm_fid}&amp;frm_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  		</if>
  		<else>
  		<math oper='(({i} / {limite_page})+1)' />
  		</else>
  	</for>
  	<p class="menu_module">
  	<if cond='|{can_pst}| AND |{frm_fid}|'>
  	<a href="index.php?file=forum&amp;act=new_pst&amp;frm_fid={frm_fid}">
  	<img src="img/forum/topic.png" alt="" /> Nouveau Sujet</a>
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
		<a href="index.php?file=forum&amp;act=view_cat&amp;cat_cid={frm_array[cat_id]}" title="{frm_array[cat_name]}">{frm_array[cat_name]}</a>
		<img src="img/right.png" alt=">" /> 
		<a href="index.php?file=forum&amp;act=view_frm&amp;frm_fid={frm_array[frm_id]}" title="{frm_array[frm_name]}">{frm_array[frm_name]}</a>
		</h2>
		<p class="menu_module">
		<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={pst_pid}#lst_pst" id="fst_pst">
		<img src="img/down.png" alt="" /> Fin</a>
		<if cond='{can_pst}'>
		- <a href="index.php?file=forum&amp;act=new_pst&amp;frm_fid={frm_array[frm_id]}">
		<img src="img/forum/topic.png" alt="" /> Nouveau Sujet</a>
		-  <a href="index.php?file=forum&amp;act=new_pst&amp;pst_pid={pst_pid}">
		<img src="img/forum/post.png" alt="" /> Répondre</a>
		</if>
		</p>
		</br>
		<if cond='is_array(|{pst_array}|)'>
		<foreach cond='|{pst_array}| as |{result}|'>
			<if cond='{result[pst_id]}'>
				<div class="pst">
				<img src="img/mbr_logo/{result[pst_mid]}.png" title="{result[mbr_pseudo]}" class="img_right" />
				<h2>
				<a id="{result[pst_id]}" href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={pst_pid}#{result[pst_id]}" title="Titre">{result[pst_titre]}</a>
				</h2>
				{result[pst_texte]}
				<div class="infos_pst">
						<if cond='(|{session_user[mid]}| == |{result[pst_mid]}| AND (|{can_edit}|) OR |{is_modo}|)'>
							<a href="index.php?file=forum&amp;act=edit_pst&amp;pst_pid={result[pst_id]}">
							<img src="img/editer.png" alt="Modifier" title="Modifier" />
							</a>
							<a href="index.php?file=forum&amp;act=del_pst&amp;pst_pid={result[pst_id]}">
							<img src="img/drop.png" alt="Effacer" title="Effacer" />
							</a>
						</if>
						Le {result[pst_date_formated]} 
						Par 
						<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}" /> 
						<a href="index.php?file=member&amp;act=view&amp;mid={result[pst_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
				</div>
				</div>
			</if>
		</foreach>
		<p class="menu_module">
		<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={pst_pid}#fst_pst" id="lst_pst">
		<img src="img/up.png" alt="" /> Début</a>
		<if cond='{can_pst}'>
		- <a href="index.php?file=forum&amp;act=new_pst&amp;frm_fid={frm_array[frm_id]}">
		<img src="img/forum/topic.png" alt="" /> Nouveau Sujet</a>
		-  <a href="index.php?file=forum&amp;act=new_pst&amp;pst_pid={pst_pid}">
		<img src="img/forum/post.png" alt="" /> Répondre</a>
		</if>
		</p>
		<br/>
		Page:
		<for cond='|{i}| = 0 ; |{i}| < |{pst_nb}|; |{i}|+=|{limite_page}|'>
   		<if cond='|{i}| / |{limite_page}| != |{pst_page}|'>
   		<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={pst_pid}&amp;pst_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
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
<elseif cond='|{btc_act}| == "list_modo"'>
	<if cond='is_array(|{mbr_sherif}|)'>
		<h3>Sheriffs</h3>
		<foreach cond='|{mbr_sherif}| as |{result}|'>
		<p>
		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   		<br/>
   		Langue: <img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /><br/>
		Message: <a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
   		</a>
   		</p>
		</foreach>
	</if>
	<if cond='is_array(|{mbr_modo}|)'>
		<h3>Moderateurs</h3>
		<foreach cond='|{mbr_modo}| as |{result}|'>
		<p>
		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   		<br/>
   		Langue: <img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /><br/>
		Message: <a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
   		</a>
   		</p>
		</foreach>
	</if>
</elseif>
</div>
<p class="menu_module">
[ <a href="index.php?file=forum">Retour</a> ]
-
[ <a href="index.php?file=forum&amp;act=view_frm&amp;frm_fid=0" title="Utile pour voir les nouveaux messages">Tous les messages</a>
]
-
[
<a href="index.php?file=forum&amp;act=list_modo">Moderateurs</a>
]