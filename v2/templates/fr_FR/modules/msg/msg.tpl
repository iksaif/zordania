<p class="menu_module">
	[ <a href="msg.html" title="Voir la liste des messages que vous avez reçus">Boîte de réception</a> ]
	- [ <a href="msg-env.html" title="Voir la liste des messages que vous avez envoyés">Boîte d'envoi</a> ]
	- [ <a href="msg-new.html" title="Ecrire un message">Ecrire</a> ]
	<if cond='{msg_act} == "env"'>
	- [ <a href="msg-del_env.html" title="Tout effacer"><img src="img/drop.png" alt="Effacer" /> Vider</a> ]
	</if>
	<elseif cond='!{msg_act}'>
	- [ <a href="msg-del_rec.html" title="Tout effacer"><img src="img/drop.png" alt="Effacer" /> Vider</a> ]
	</elseif>
	<if cond='can_d({DROIT_MMSG})'>
	- [ <a href="msg-global.html" title="Ecrire un message à tout Zordania">Msg massif</a> ]
	</if>

	<hr />
	Messages non lus : {_user[msg]}
</p>

<if cond='{msg_act} == "env" || !{msg_act}'>
	<div class="infos">Les messages sont supprimés automatiquement au bout de {MSG_DEL_OLD} jours. Pensez à stocker vos messages importants,
 	dans les <a href="notes.html" title="Notes">Notes</a> par exemple.</div>
 </if>
<if cond='{msg_act} == "read"'>
	<include file='modules/msg/read.tpl' cache='1' />
</if>

<elseif cond='{msg_act} == "read_env"'>
	<if cond='isset({msg_infos})'>
		<h4>{msg_infos[menv_titre]}</h4>
		<img src="img/mbr_logo/{msg_infos[menv_to]}.png" title="{msg_infos[mbr_pseudo]}" class="blason" />
		Envoyé à 
		<img src="img/groupes/{msg_infos[mbr_gid]}.png" alt="{groupes[{msg_infos[mbr_gid]}]}" title="{groupes[{msg_infos[mbr_gid]}]}"/>
		<a href="member-view.html?mid={msg_infos[menv_to]}" title="infos sur {msg_infos[mbr_pseudo]}">{msg_infos[mbr_pseudo]}</a>
		le {msg_infos[menv_date_formated]}
		
		<div class="block">
			{msg_infos[menv_texte]}
			<div class="signature">{_user[sign]}</div>
		</div>
		[ <a href="msg-del_env.html?msg_id={msg_infos[menv_id]}" title="Effacer ce message">
		<img src="img/drop.png" alt="Effacer" /> Effacer</a> ]
	</if>
	<elseif cond='isset({msg_pas_tout})'>
		<p class="infos">Il manque des infos.</p>
	</elseif>
	<else>
		<p class="infos">Ce message n'existe pas.</p>
	</else>
</elseif>

<elseif cond='{msg_act} == "del_env" OR {msg_act} == "del_rec"'>
	<if cond='isset({msg_need_conf})'>
		<form action="msg-{msg_act}.html?msg_id={msg_id}" method="post" class="infos">
		Voulez-vous supprimer
		<if cond='is_array({msg_id})'>
			<foreach cond='{msg_id} as {id} => {value}'>
				<input type="hidden" name="msg_id[]" value="{id}" />
			</foreach>
			les <math oper="count({msg_id})" /> messages sélectionnés
		</if>
		<elseif cond='{msg_id}!=0'> le message sélectionné </elseif>
		<else> tous les messages </else>
		dans la boîte
		<if cond='{msg_act} == "del_env"'> d'envoi </if><else> de réception </else> ?
		<input type="submit" name="msg_conf" value="Oui" />
		</form>
	</if>
	<elseif cond='{msg_del}'>
		<p class="ok">Message(s) supprimé(s) !</p>
	</elseif>
</elseif>

<elseif cond='{msg_act} == "new"'>
	<if cond='isset({msg_pas_tout})'>
		<p class="infos">Il manque des infos.</p>
	</if>
	<form action="msg-send.html" method="post" id="newpost">
		<script type="text/javascript">
		<!--
// Ajoute l'autocomplétion sur l'input d'id 'msg_pseudo'
$(document).ready(function(){
	$("#"+"msg_pseudo").autocomplete({
		source: "/json--member-search.html?type=ajax"
	});
});	// -->
		</script>
		<p><label for="msg_pseudo">Pseudo</label>
		<input type="text" id="msg_pseudo" name="msg_pseudo" value="{msg_pseudo}" tabindex="1" maxlength="{TAILLE_MAX_PSEUDO}">
		( <a href="member-liste.html" title="Liste des joueurs">Liste</a> )</p>
	
		<p><label for="pst_titre">Titre</label>
		<input type="text" maxlength="150" name="pst_titre" id="pst_titre" value="{msg_titre}" tabindex="2" /></p>
	
		<include file='commun/bbcode.tpl' cache='1' />
		<p><textarea id="message" cols="60" rows="11" name="pst_msg" tabindex="3">{msg_texte}</textarea> </p>
		<p>
			<input type="submit" value="Envoyer" tabindex="4" />
			<input type="button" id="btpreview" value="Prévisualiser" />
		</p>
	</form>
	<div id="preview"></div>
	<p class="infos">
	Merci de ne pas écrire en langage sms, d'éviter les fautes, de respecter l'ambiance médiévale du jeu (les téléphones portables n'existaient pas etc...), d'utiliser un langage courant ou soutenu, de rédiger vos phrases et d'utiliser la ponctuation à bon escient.
	<br/>
	Merci de respecter ces quelques règles de RP. Plongez-vous dans le jeu, faites comme si vous y étiez.</p>
</elseif>

<elseif cond='{msg_act} == "send"'>
	<if cond='isset({msg_antiflood})'>
		<p class="error">Contrôle Anti-Flood activé, veuillez patienter {SITE_ANTIFLOOD} secondes avant d'envoyer un nouveau message.</p>
	</if>
	<elseif cond='isset({msg_max_mmsg})'>
		<p class="error">Impossible d'envoyer plus de {msg_max_mmsg} messages en même temps.</p>
	</elseif>
	<else>
		<foreach cond="{msg_result} as {pseudo} => {infos}">
			<if cond="{infos}">
				<p class="ok">Message envoyé à
					<img src="img/groupes/{infos[mbr_gid]}.png" alt="{groupes[{infos[mbr_gid]}]}" title="{groupes[{infos[mbr_gid]}]}"/>
					<a href="member-view.html?mid={infos[mbr_mid]}" title="infos sur {infos[mbr_pseudo]}">{infos[mbr_pseudo]}</a>
				</p>
			</if>
			<else>
				<p class="error">{pseudo} n'existe pas !</p>
			</else>
		</foreach>
	</else>
</elseif>

<elseif cond='{msg_act} == "env"'>
<include file='modules/msg/outbox.tpl' cache='1' />
	
</elseif>

<elseif cond='{msg_act} == "global" && can_d({DROIT_MMSG})'>
<include file='modules/msg/global.tpl' cache='1' />
</elseif>

<elseif cond='{msg_act} == "send_massif"'>
	<p class="infos">Vous avez envoyé un message à tout Zordania.</p>
</elseif>

<elseif cond='{msg_act} == "sign"'>
	<if cond='{no_msg} && isset({no_msg})'>
	<p class="ok">Signalement effectué ! Tout abus sera sanctionné !</p>
	</if>
	<else>
	<p class="error">Erreur, recommencer le signalement !</p>
	</else>
</elseif>

<elseif cond='{msg_act} == "fsign"'>
<form method="post" action=msg-sign.html?msgid={msgid} >

<label for="ameliorer">Commentaire initial sur le signalement</label><br />
<textarea name="com" id="commentaire"></textarea>


<input type="submit" name="signaler"/>

</form>
</elseif>

<else>
<include file='modules/msg/inbox.tpl' cache='1' />
</else>
