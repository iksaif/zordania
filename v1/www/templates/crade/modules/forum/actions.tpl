<div id="forums">
<if cond='|{frm_act}| == "new_pst" AND |{can_pst}|'>
	<if cond='{can_post_here}'>
	<p class="infos">Impossible, ce forum n'existe pas ou vous n'avez pas les droits pour le voir.</p>
	</if>
	<elseif cond='{bad_pid}'>
	<p class="error">Sujet inexistant ou fermé.</p>
	</elseif>
	<elseif cond='{bad_fid}'>
	<p class="error">Forum inexistant.</p>
	</elseif>
	<elseif cond='{pst_ok}'>
	<p class="ok">Ok message posté.</p>
	<if cond='{pst_pid}'>
		<meta http-equiv="refresh" content="2; url={cfg_url}?file=forum&amp;act=view_pst&amp;pst_page=last&amp;pst_pid={pst_pid}">
	</if>
	<else>
		<meta http-equiv="refresh" content="2; url={cfg_url}?file=forum&amp;act=view_frm&amp;pst_page=last&amp;frm_fid={frm_fid}">
	</else>
	</elseif>
	<else>
		<h2>
		<a href="index.php?file=forum" title="Index">Forums </a>
		<img src="img/right.png" alt=">" /> 
		<a href="index.php?file=forum&amp;act=view_cat&amp;cat_cid={frm_array[cat_id]}" title="{frm_array[cat_name]}">{frm_array[cat_name]}</a>
		<img src="img/right.png" alt=">" /> 
		<a href="index.php?file=forum&amp;act=view_frm&amp;frm_fid={frm_array[frm_id]}" title="{frm_array[frm_name]}">{frm_array[frm_name]}</a>
		<if cond='{pst_pid}'>
			<img src="img/right.png" alt=">" /> 
			<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid={pst_pid}" title="{pst_array[0][pst_titre]}">{pst_array[0][pst_titre]}</a>
		</if>
		</h2>
		
		<if cond='{pst_pid}'>
			<form action="index.php?file=forum&amp;act=new_pst&amp;pst_pid={pst_pid}" method="post">
		</if>
		<else>
			<form action="index.php?file=forum&amp;act=new_pst&amp;frm_fid={frm_fid}" method="post">
		</else>
		<label for="pst_titre">Titre</label>
		<input type="text" size="50" maxlength="250" name="pst_titre" id="pst_titre" value="<if cond="{pst_titre}">{pst_titre}</if><else>{pst_array[0][pst_titre]}</else>" />
		<br/>
		<include file='commun/bbcode.tpl' cache='1' /><br/>
		<textarea id="message" cols="60" rows="11" name="pst_message">{pst_message}</textarea> 
		<input type="submit" name="pst_submit" value="Envoyer" /> <input type="submit" name="pst_preview" value="Prévisualiser" />
		</form>
		<div class="pst">
		<h2>{pst_titre}</h2>
		{pst_message_formated}
		</div>
	</else>
</if>
<elseif cond='|{frm_act}| == "edit_pst"'>
	<if cond='{bad_pid}'>
	<p class="error">Le Post n'existe pas ou vous n'avez pas le droit de le modifier.</p>
	</if>
	<elseif cond='!|{pst_ok}|'>
		<h2>
		<a href="index.php?file=forum" title="Index">Forums </a>
		<img src="img/right.png" alt=">" /> 
		<a href="index.php?file=forum&amp;act=view_pst&amp;pst_pid=<if cond="{pst_array[0][pst_pid]}">{pst_array[0][pst_pid]}</if><else>{pst_pid}</else>" title="{pst_array[0][pst_titre]}">{pst_array[0][pst_titre]}</a>
		</h2>
		
		<form action="index.php?file=forum&amp;act=edit_pst&amp;pst_pid={pst_pid}" method="post">
		<label for="pst_titre">Titre</label>
		<input type="text" size="50" maxlength="250" name="pst_titre" id="pst_titre" value="<if cond="{pst_titre}">{pst_titre}</if><else>{pst_array[0][pst_titre]}</else>" />
		<br/>
		<include file='commun/bbcode.tpl' cache='1' /><br/>
		<textarea id="message" cols="60" rows="11" name="pst_message">{pst_message}</textarea> 
		<br />
		<if cond='|{is_modo}|'>
		<label for="pst_etat">Etat:</label>
		<select id="pst_etat" name="pst_etat">
		<for cond='|{i}| = 1; |{forum[etats][{i}]}|; |{i}|++'>
   			<option value="{i}" <if cond="|{pst_etat}| == |{i}|">selected="selected"</if>>{forum[etats][{i}]}</option>
   		</for>
		</select>
		-
		<label for="pst_forum">Déplacer</label>
		<select id="pst_forum" name="pst_forum">
			<if cond='is_array(|{frm_array}|)'>
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
		</if>
		
		<input type="submit" name="pst_submit" value="Envoyer" /> <input type="submit" name="pst_preview" value="Prévisualiser" />
		</form>
		<div class="pst">
		<h2>{pst_titre}</h2>
		{pst_message_formated}
		</div>
	</elseif>
	<else>
	<p class="ok">Post modifié</p>
	<meta http-equiv="refresh" content="2; url={cfg_url}?file=forum&amp;act=view_pst&amp;pst_pid={pst_pid}">
	</else>	
</elseif>
<elseif cond='|{frm_act}| == "del_pst"'>
	<if cond='{bad_pid}'>
	<p class="error">Le Post n'existe pas ou vous n'avez pas le droit de l'effacer.</p>
	</if>
	<elseif cond='!|{pst_ok}|'>
	<p class="infos">Effacer ce message ?
	[ 
	<a href="index.php?file=forum&amp;act=del_pst&amp;pst_pid={pst_pid}&amp;ok=ok">oui</a>
	] - [ 
	<a href="index.php?file=forum">non</a>
	]
	</elseif>
	<else>
	<p class="ok">Post effacé.</p>
	<meta http-equiv="refresh" content="2; url={cfg_url}?file=forum&amp;act=view_pst&amp;pst_pid=<if cond="{pst_array[0][pst_pid]}">{pst_array[0][pst_pid]}</if><else>{pst_pid}</else>">
	</else>	
</elseif>
</div>