<if cond='!isset({mbr_act})'>
	<if cond='isset({mbr_not_loged})'>
		<div class="error">Vous n'êtes pas connecté.</div>
	</if>
	<elseif cond='isset({mbr_array}) AND {mbr_array}'>

	<if cond='{mbr_logo}'>
			<img class="blason" src="{mbr_logo}" alt="Blason" />
	</if>
	Id : {mbr_array[mbr_mid]}<br />
	Mail : {mbr_array[mbr_mail]}<br />
	Pseudo : {mbr_array[mbr_pseudo]}
	<if cond="{mbr_array[mbr_sexe]}==1">(masculin)</if><else>(féminin)</else><br />
	Groupe : <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/> {groupes[{mbr_array[mbr_gid]}]}<br/>
	Langue : <img src="img/{mbr_array[mbr_lang]}.png" alt="{mbr_array[mbr_lang]}" /><br />
	Village : {mbr_array[mbr_vlg]}<br />
	<if cond="{mbr_array[mbr_etat]} != MBR_ETAT_INI">
	Région : {regions[{mbr_array[map_region]}][name]}<br/></if>
	Décalage : {mbr_array[mbr_decal]} H<br /> 
	Flux XML : <a href="{cfg_url}member.xml?mid={mbr_array[mbr_mid]}" title="Vos infos au format XML">{cfg_url}member.xml?mid={mbr_array[mbr_mid]}</a>
	<div class="signature">{mbr_array[mbr_sign]}</div>
	<if cond="is_array({rec_array})">
		<h4>Récompenses</h4>
		<foreach cond="{rec_array} as {rec_value}">
			<img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
		</foreach>
	</if>
	<h4>Description</h4>
	<p>
	{mbr_array[mbr_descr]}
	</p>
	
	<hr />
	<div class="infos">L'apparence du site peut être complètement modifiée en choisissant une autre feuille de style ! Les designs seront aussi appliqués au forum !</div>
	<script type="text/javascript">
	$(document).ready(  function()
	{
		// liste des CSS dans conf.inc.php
		var css = new Array();
		<foreach cond="{css} as {css_id} => {css_value}">
		css[{css_id}] = "{css_value[0]}";</foreach>
		// JS pour changer le CSS
		$("#stylesheet").change(function(){
			$('link[rel="stylesheet"][media="screen"]').attr('href', 'skin/'+css[$(this).val()]+'/style.css')
		});
	});
	</script>
	<form action="member-edit.html?sub=design" method="post">
		<label for="stylesheet">Feuille de style:</label>
		<select name="design" id="stylesheet">
		<foreach cond="{css} as {css_id} => {css_value}">
			<if cond="{css_id} == {_user[design]}">
				<option value="{css_id}" selected="selected">{css_value[1]}</option>
			</if>
			<else>
				<option value="{css_id}">{css_value[1]}</option>
			</else>
		</foreach>
		</select>
		<input type="submit" value="Sauvegarder" />
	</form>
	<hr/>
	<if cond='{vld_array}'>
	<strong>Vous avez une action en cours de validation  ({vldacts[{vld_array[0][vld_act]}]}),
	<a href="member-edit.html?sub=del_vld">Annuler</a>.</strong>
	<hr/>
	</if>
	<p class="menu_module">
	[ <a href="parrain.html" title="Parrainer.">Parrainage</a>
	] - [ <a href="zzz.html" title="Mise en veille du compte.">Mise en veille</a>
	] - [ <a href="member-edit.html" title="Paramétrer mon compte (avatar, signature, etc ...)">Paramétrer mon compte</a>
	]
	<br/>[ <a href="member-del.html?sub=pre" title="Supression du compte">Effacer mon compte</a>
	] - 
	<if cond="{_user[etat]}==MBR_ETAT_INI">[ <a href="ini.html" title="Initialiser">Initialiser mon compte</a>
	]</if><else>[ <a href="member-edit.html?sub=reset" title="Recommencer une partie">Réinitialiser mon compte</a>
	]</else>
	</p>
	</else>
</if>

<elseif cond='{mbr_act} == "del"'>
	<if cond='isset({mbr_sub})'>
		<if cond="isset({mbr_another_valid})">
			<div class="error">Un autre changement est déjà en cours de validation ! Vous pouvez l'annuler via "Mon Compte".</div>
		</if>
		<else>
			<p class="ok">Ok, un mail de confirmation a été envoyé pour confirmer la suppression du compte.</p>
		</else>
	</if>
	<else>
		<if cond="isset({mbr_no_key})">
			<form action="member-del.html" method="post">
				<label for="key">Clef de validation:</label>
				<input type="text" name="key" id="key" value="{vld_key}" />
				<br/>
				<input type="submit" value="Supprimer" />
			</form>
		</if>
		<elseif cond="isset({mbr_no_del})">
			<div class="error">Aucune demande de suppression en cours !</div>
		</elseif>
		<elseif cond="isset({mbr_cls})">
			<div class="ok">Ok, compte supprimé !</div>
		</elseif>
	</else>

	<if cond='isset({mbr_error})'>
		<p class="error"> Erreur.</p>
	</if>
</elseif>

<elseif cond='{mbr_act} == "edit"'>
	<if cond='isset({mbr_is_not_loged})'>
		<p class="error">Il faut être connecté pour éditer son compte.</p>
	</if>
	<elseif cond='{mbr_sub} == "design"'>
		<if cond="isset({mbr_edit})">
			<div class="ok">Feuille de style changée !</div>
		</if>
		<else>
			<div class="error">Cette feuille de style n'existe pas !</div>
		</else>
	</elseif>
	<elseif cond='{mbr_sub} == "reset"'>
		<if cond='isset({mbr_edit})'>
			<p class="infos">Un mail a été envoyé pour valider les changements.</p>
		</elseif>
		<elseif cond='isset({mbr_another_valid})'>
			<p class="error">Un autre changement est déjà en cours de validation, vous pouvez l'annuler dans "Mon Compte".</p>
		</elseif>
	</elseif>
	<elseif cond='{mbr_sub} == "pass"'>
		<if cond='isset({mbr_not_all_post})'>
			<p class="error">Il manque des informations.</p>
		</if>
		<elseif cond='isset({mbr_not_same_pass})'>
			<p class="error">Les Mots de Passe sont différents.</p>
		</elseif>
		<elseif cond='{mbr_edit}'>
			<p class="ok">Mot de Passe modifié !</p>
		</elseif>
	</elseif>
	<elseif cond='{mbr_sub} == "mail"'>
		<if cond='isset({mbr_not_all_post})'>
			<p class="error">Il manque des informations.</p>
		</if>
		<elseif cond='isset({mbr_not_same_pass})'>
			<p class="error">Les Mots de Passe sont différents.</p>
		</elseif>
		<elseif cond='{mbr_edit} == -1'><p class="error">Cet email existe déjà !</p></elseif>
		<else><p class="ok">Email modifié !</p></else>
	</elseif>
	<elseif cond='{mbr_sub} == "oth"'>
		<if cond='{mbr_edit}'>
			<p class="ok">Ok, infos mises à jour !</p>
		</if>
		<else>
			<p class="error">Erreur.</p>
		</else>
	</elseif>
	<elseif cond='{mbr_sub} == "logo"'>
		<if cond='{mbr_edit}'>
			<p class="ok">Ok, infos mises à jour !</p>
		</if>
		<else>
			<p class="error">Erreur, taille ou type incorrect.</p>
		</else>
		</elseif>
	<elseif cond='{mbr_sub} == "del_vld"'>
		<if cond='isset({mbr_edit})'>
			<p class="ok">Ok, action annulée.</p>
		</if>
		<else>
			<p class="error">Erreur.</p>
		</else>
	</elseif>
	<else>
	<p class="infos">Le Blason doit être une image de type {logo_type}, de taille inférieure ou égale à {logo_size} octets et {logo_x_y}px.</p>
		<form class="block" enctype="multipart/form-data" action="member-edit.html?sub=logo" method="post">
		<if cond='{mbr_logo}'>
			<img class="blason" src="{mbr_logo}" alt="Blason" />
		</if>
		Envoyez ce fichier: <input name="mbr_logo" type="file" />
		<input type="submit" value="Envoyer" />
		</form>
				
		<hr />
		<form method="post" action="member-edit.html?sub=oth">
	
	<label for="lang">Langue :</label>
	<select id="lang" name="lang">
	<foreach cond="{lang} as {lang_abrv} => {lang_name}">
	<option value="{lang_abrv}" <if cond='{mbr_lang} == {lang_abrv}'>selected="selected"</if>>{lang_name}</option>
	</foreach>
	</select><br />

	<label for="decal">Décalage Horaire</label>
	<input type="text" value="{mbr_decal}" name="decal">
	<br/>
	<div class="infos"> (Format: HH:MM:SS exemple 01:00:00, l'heure du serveur est {mbr_date})</div>
	
	Sexe de votre personnage :
	<label for="sexe1"><input type="radio" id="sexe1" name="sexe" value="1" <if cond='{mbr_sexe}==1'>checked="checked"</if> /> Masculin</label>
	<label for="sexe2"><input type="radio" id="sexe2" name="sexe" value="2" <if cond='{mbr_sexe}==2'>checked="checked"</if> /> Féminin</label>
	<p class="infos">Vous pouvez faire une demande à un admin / co-admin pour renommer votre personnage.</p>
		
	<br />
	<label for="sign">Signature:</label>
	<input type="text" size="50" maxlength="255" name="sign" id="sign" value="{mbr_sign}"><br/>
	Description:
	<br/>
	<include file='commun/bbcode.tpl' cache='1' /><br/>
	<textarea id="message" cols="60" rows="11" name="descr">{mbr_descr}</textarea> 
	<br/>
	<input type="submit" value="Envoyer" name="submit" />
	</form>
	
	<hr />
	<h4>Changement du Mot de Passe:</h4>
	<form method="post" action="member-edit.html?sub=pass">
	<label for="oldpass">Ancien Mot de Passe : </label><input id="oldpass" type="password" name="oldpass" /><br />
	<label for="pass">Nouveau Mot de Passe : </label><input type="password" id="pass" name="pass" /><br />
	<label for="pass2">Confirmation : </label><input type="password" id="pass2" name="pass2" /><br />
	<input type="submit" value="Envoyer" name="submit" />
	</form>
	
	<hr />
	<h4>Changement du Mail: </h4>
	<form method="post" action="member-edit.html?sub=mail">
	<label for="passmail">Mot de Passe :</label> <input id="passmail" type="password" name="pass" /><br />
	<label for="mail">email :</label> <input id="mail" type="text" value="{mbr_mail}" name="mail" />
	<br/>
	<input type="submit" value="Envoyer" name="submit" />
	</form>
	
	</else>
	<p class="retour_module">
	[ <a href="member.html">Retour</a>
	]
	</p>
</elseif>
