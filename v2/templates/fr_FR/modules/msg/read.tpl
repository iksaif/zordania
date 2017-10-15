<if cond='isset({msg_infos})'>
	<h4>{msg_infos[mrec_titre]}</h4>
	<img src="img/mbr_logo/{msg_infos[mrec_from]}.png" title="{msg_infos[mbr_pseudo]}" class="blason" />
	Envoyé par <zurlmbr gid="{msg_infos[mbr_gid]}" mid="{msg_infos[mrec_from]}" pseudo="{msg_infos[mbr_pseudo]}"/>
	le {msg_infos[mrec_date_formated]}

	<div class="block">
		{msg_infos[mrec_texte]}
		<div class="signature">{msg_infos[mbr_sign]}</div>
	</div>

	<if cond="isset({msg_infos[mrec_id]})">
		<p class="menu_module">
		[ <a href="msg-new.html?mbr_mid={msg_infos[mrec_from]}&amp;mrec_id={msg_infos[mrec_id]}" title="Répondre à ce message"><img src="img/reply.png"/> Répondre</a> ]
		- [ <a href="msg-del_rec.html?msg_id={msg_infos[mrec_id]}" title="Effacer ce message"> <img src="img/drop.png"/> Effacer</a> ]
		- [	<a href="msg-fsign.html?msgid={msg_infos[mrec_id]}" title="signaler ce message"><img src="img/surv.png"/> Signaler</a> ]
		</p>
	</if>
</if>
<elseif cond='isset({msg_bad_id}) && {msg_bad_id}'>
	<p class="error">Ce message n'existe pas.</p>
</elseif>
<else>
	<p class="error"">Il manque des infos (titre / texte)</p>
</else>

