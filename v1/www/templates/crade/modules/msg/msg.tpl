<p class="menu_module">
	[
	<a href="index.php?file=msg" title="Voir la liste des messages que vous avez reçu">Boite de réception</a>
	]
	-
	[
	<a href="index.php?file=msg&amp;act=new" title="Ecrire un message">Ecrire</a>
	]
	-
	[
	<a href="index.php?file=msg&amp;act=del&amp;msg_msgid=0" title="Tout effacer"><img src="img/drop.png" alt="Effacer" /> Vider</a>
	]
<hr />
	Messages non lus : {session_user[msg]}
</p>
<br />
<if cond='|{msg_act}| == "read"'>
	<if cond='is_array(|{msg_infos}|)'>
		<h3>{msg_infos[msg_titre]}</h3>
		Envoyé par <a href="index.php?file=member&amp;act=view&amp;mid={msg_infos[msg_mid]}" title="infos sur {msg_infos[mbr_pseudo]}">{msg_infos[mbr_pseudo]}</a>
		le {msg_infos[msg_date_formated]}
		<br/><br/>
		<div class="block_1">
		{msg_infos[msg_texte]}
		</div>
		<br/>
		<p class="menu_module">
		[ 
		<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={msg_infos[msg_mid]}&amp;msg_msgid={msg_infos[msg_msgid]}" title="Répondre à ce message"> 
		<img src="img/reply.png" alt="Répondre" /> Répondre</a>
		]
		-
		[ 
		<a href="index.php?file=msg&amp;act=del&amp;msg_msgid={msg_infos[msg_msgid]}" title="Effacer ce message"> 
		<img src="img/drop.png" alt="Effacer" /> Effacer</a>
		]
		</p>
	</if>
	<elseif cond='{msg_pas_tout}'>
		<p class="infos">Il manque des infos.</p>
	</elseif>
	<else>
		<p class="infos">Ce message n'existe pas.</p>
	</else>
</if>
<elseif cond='|{msg_act}| == "del"'>
	<if cond='{msg_del}'>
		<p class="ok">Message(s) supprimé(s) !</p>
	</if>
	<elseif cond='{msg_pas_tout}'>
		<p class="infos">Il manque des infos.</p>
	</elseif>
	<else>
		<p class="error">Ce message n'existe pas.</p>
	</else>
</elseif>
<elseif cond='|{msg_act}| == "new"'>
	<if cond='{msg_pas_tout}'>
		<p class="infos">Il manque des infos.</p>
		<br />
	</if>
	<form action="index.php?file=msg&amp;act=send" method="post">
	<label for="msg_pseudo">Pseudo</label>
	<input type="text" name="msg_pseudo" id="msg_pseudo" value="{msg_pseudo}" />
	( <a href="index.php?file=member&amp;act=liste" title="Liste des joueurs">Liste</a> )<br />
	<label for="msg_titre">Titre</label>
	<input type="text" maxlength="150" name="msg_titre" id="msg_titre" value="{msg_titre}" />
	<br/>
	<include file='commun/bbcode.tpl' cache='1' /><br/>
	<textarea id="message" cols="60" rows="11" name="msg_texte">{msg_texte}</textarea> 
	<input type="submit" value="Envoyer" />
	</form>
</elseif>
<elseif cond='|{msg_act}| == "send"'>
	<if cond='{msg_mbr_not_exist}'>
		<p class="error">Ce joueur n'existe pas.</p>
	</if>
	<if cond='|{msg_sended}| == 1'>
		<p class="ok">Message envoyé !</p>
	</if>
	<elseif cond='|{msg_sended}| == 2'>
		<p class="error">Controle Anti-Flood activé, veuillez patienter 30 secondes avant d'envoyer un nouveau message.</p>
	</elseif>
</elseif>
<else>
	<if cond='count(|{msg_array}|)'>
		<table class="border1">
		<tr>
			<th>Pseudo</th>
			<th>Titre</th>
			<th>Date</th>
			<th>Actions</th>
		</tr>
		<foreach cond='|{msg_array}| as |{rien}| => |{result}|'>
		<tr>
			<td><a href="index.php?file=member&amp;act=view&amp;mid={result[msg_mid]}" title="Infos sur {result[mbr_pseudo]}"> {result[mbr_pseudo]}</a></td>
			<td>
				<if cond='|{result[msg_not_readed]}| == 1'>
					<img src="img/paslu.png" alt="Non lu" title="Non lu" />
				</if>
				<else>
					<img src="img/lu.png" alt="Lu" title="Lu" />
				</else>
				- <a href="index.php?file=msg&amp;act=read&amp;msg_msgid={result[msg_msgid]}" title="Lire ce message">{result[msg_titre]}</a>
			</td>
			<td>{result[msg_date_formated]}</td>
			<td>
			<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[msg_mid]}&amp;msg_msgid={result[msg_msgid]}" title="Reply">
			<img src="img/reply.png" alt="Reply" /></a>
			-
			<a href="index.php?file=msg&amp;act=del&amp;msg_msgid={result[msg_msgid]}" title="Effacer ce message"> 
			<img src="img/drop.png" alt="Effacer" /></a>
			</td>
		</tr>
		</foreach>
		</table>
	</if>
	<else>
		<p class="infos">Aucun message.</p>
	</else>
</else>