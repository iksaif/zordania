<div class="menu_module">
[ <a href="admin.html?module=surv" title="Liste des surveillances en cours">Membres</a> ]
[ <a href="admin.html?module=msg" title="Messages signalés">Messages</a> ]
</div>
<hr/>

<if cond='{act} == "read" or {act} == "com"'>
	<if cond='isset({msg_bad_id})'>
		<p class="error">Ce message n'existe pas.</p>
	</if>
	<else>
		<if cond='isset({com_ajoute})'><p class="ok">Commentaire ajouté</p></if>
		<p class="infos">
			Message envoyé le {msg_infos[mrec_date_formated]}, à <a href="admin-view.html?module=member&amp;mid={msg_infos[mrec_mid]}" title="Plus d'infos Admin">{msg_infos[sign_to_pseudo]}</a>, qui l'a signalé le {msg_infos[sign_debut]}
			<br/>
			<if cond="{msg_infos[sign_admid]}">
				Dernière action par {msg_infos[sign_adm_pseudo]}, le {msg_infos[sign_fin]}.
			</if>
			<else>
				<strong>signalement non traité par un admin !</strong>
			</else>
		</p>
		<if cond="{msg_infos[mrec_mid]} == {_user[mid]}">
			<p class="error">Ne pas répondre à TON message via le panel admin SVP !</p>
		</if>
		<include file='modules/msg/read.tpl' cache='1' />

		<p>{msg_infos[sign_com]}</p>
		<form action="admin.html?module=msg&amp;act=com&amp;sid={msg_infos[sign_id]}" method="post">		
			<textarea name="com" id="com" rows="3" cols="40"></textarea><br/>
			<input type="submit" value="Enregistrer Commentaire" />
			<if cond="{msg_infos[sign_admid]} == {_user[mid]}">
				- ce message m'est déjà assigné.
			</if>
			<else>
				- <a href="admin.html?module=msg&amp;act=assign&amp;sid={msg_infos[sign_id]}">S'assigner</a>
			</else>
		</form>
	</else>
</if>

<else>
	<if cond='{act} == "assign"'><p class="ok">Je me suis assigné un message.</p></if>
	<include file='modules/msg/admin_msg.tpl' cache='1' />
</else>	
