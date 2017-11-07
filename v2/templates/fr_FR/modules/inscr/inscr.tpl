<if cond='{mbr_act} == "new"'>
	<if cond='isset({mbr_max_inscrit})'>
		<p class="error">Le site est au maximum de sa capacité, les comptes inutilisés (pas de connexion depuis un mois) sont supprimés toutes les semaines, il y aura sûrement de la place lundi prochain.</p>
	</if>
	<if cond='isset({mbr_is_loged})'>
		<p class="error">Vous êtes déjà logué !</p>
	</if>
	<if cond='isset({mbr_name_not_correct})'>
		<p class="error">Login incorrect, seuls les lettres et les chiffres sont autorisés. Les caractères accentués sont interdits.</p>
	</if>
	<elseif cond='isset({mbr_notallpost})'>
		<p class="error">Il manque des informations.</p>
	</elseif>
	<elseif cond='isset({mbr_pass_inegal})'>
		<p class="error">Les Mots de Passe sont différents.</p>
	</elseif>
	<elseif cond='isset({mbr_mail_inegal})'>
		<p class="error">Les emails sont différents.</p>
	</elseif>
	<elseif cond='isset({mbr_ok})'>
		<p class="ok">Ok, compte créé ! Un Mail de Validation a été envoyé. Vous trouverez dans ce Mail toutes les informations nécessaires pour continuer.</p>
	</elseif>
	<elseif cond='isset({mbr_error})'>
		<p class="error">Erreur. Ce Login ou cet email est déjà pris !</p>
	</elseif>
	<elseif cond='isset({mbr_not_human})'>
		<p class="error">Erreur. Vous n'êtes pas humain !</p>
	</elseif>
	<if cond='{mbr_show_form}'>
		<form method="post" action="inscr-new.html">
		<p><label for="pseudo">Login : </label>
		<input type="text" id="login" name="login" value="{mbr_login}" maxlength="{TAILLE_MAX_LOGIN}" /></p>
		<p class="infos">Le login n'est utilisé que pour vous connecter. Il ne doit contenir que des chiffres et des lettres. Un nom RP sera choisi plus tard.</p>
		
		<p><label for="pass">Mot de Passe : </label>
		<input type="password" id="pass" name="pass" /></p>
		
		<p><label for="pass2">Confirmation :</label> 
		<input type="password" id="pass2" name="pass2" /></p>
		<p class="infos">Conseil: 6 caractères minimum, et mélanger lettres et chiffres.</p>
		
		<p><label for="mail">Email :</label> 
		<input type="text" id="mail" name="mail" maxlength="{TAILLE_MAX_MAIL}" /></p>
		
		</p><label for="mail2">Confirmation :</label>
		<input type="text" id="mail2" name="mail2" maxlength="{TAILLE_MAX_MAIL}" /></p>
		<p class="infos">
		Attention, l'adresse doit être valide ! Surveillez vos spams si vous ne recevez pas le mail de confirmation.
		</p>

		<input type="hidden" name="mbr_parrain" value="{mbr_parrain}" />

		<hr />
		<p><label for="lang">Langage :</label>
		<select id="lang" name="lang">
			<foreach cond='{lang} as {lang_abr} => {lang_name}'>
				 <if cond='{_user[lang]} == {lang_abr}'>
					<option value="{lang_abr}" selected="selected">{lang_name}</option>
				</if>
				<else>
					<option value="{lang_abr}">{lang_name}</option>
				</else>
			</foreach>
		</select></p>
		
		<p><label for="decal">Décalage Horaire</label> 
		<if cond='{mbr_decal}'>
			<input type="text" value="{mbr_decal}" name="decal" id="decal" />
		</if>
		<else>
			<input type="text" value="00:00:00" name="decal" id="decal" />
		</else>
		</p>
		 <p class="infos">Format: HH:MM:SS exemple 01:00:00, l'heure du serveur est {mbr_date})</p>
	
		<hr />
		<p class="infos">
			Toutes les questions suivantes sont là pour vous faire comprendre les choses à faire et à ne pas faire...
			Bien sûr les réponses sont évidentes, mais au cours du jeu si les règles induites par ces questions ne sont pas appliquées, votre compte se verra supprimé pour toute récidive après un avertissement.
		</p>
		<if cond='isset({mbr_questionaire_faux})'>
			<p class="error">Réponses fausses.</p>
		</if>
		<br/>
		<p>Vous vous inscrivez à un jeu de stratégie médiévale : 
		<select id="question1" name="questions[]"><option value="1">oui</option><option value="0">non</option></select>
		</p>
		
		<p>Vous avez le droit d'insulter un autre joueur :
		<select id="question2" name="questions[]"><option value="0">oui</option><option value="1">non</option></select></p>
		
		<p>Vous êtes un seigneur zordanien, vous vous comportez donc comme un seigneur et parlez comme un seigneur :
		<select id="question3" name="questions[]"><option value="1">oui</option><option value="0">non</option></select></p>
		
		<p>Vous pouvez écrire en langage sms dans le forum :
		<select id="question4" name="questions[]"><option value="0">oui</option><option value="1">non</option></select></p>
		
		<p>Vous pouvez faire plusieurs comptes :
		<select id="question5" name="questions[]"><option value="0">oui</option><option value="1">non</option></select></p>
		
		<p>Vous trouvez une faille dans le jeu, vous l'exploitez sans le dire à personne :
		<select id="question6" name="questions[]"><option value="0">oui</option><option value="1">non</option></select></p>

		<!-- formulaire Are You a Human -->
		<# commentaire tpl // {ayah_html_form} #>

		<input type="submit" value="Envoyer" name="submit" />
		</form>
		<hr />
		<div class="infos">
		En application de la loi nº 78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés, chaque joueur dispose des droits d'opposition, d'accès et de rectification des données le concernant.
		</div>
		<div class="infos">
			Un seul compte par personne est autorisé. Il est interdit de "prêter" son compte ou de le donner.
		</div>
	</if>
</if>
<elseif cond='{mbr_act} == "newpass"'>
	<h3>Perte du mot de passe</h3>
	<if cond='isset({mbr_not_exist})'><p class="error">Ce membre n'existe pas.</p></if>
	<if cond='isset({mbr_form})'>
	<form method="post" action="">
	      	<p>
     		<label for="mbr_login">Login</label>
		<input type="text" id="mbr_login" name="login" value="{mbr_login}" maxlength="{TAILLE_MAX_LOGIN}" />
		</p>
		<p>
		<label for="mbr_mail">Mail</label>
		<input type="text" id="mbr_mail" name="mail" value="{mbr_mail}" maxlength="{TAILLE_MAX_MAIL}" />
		</p>
		<input type="submit" value="Envoyer" />
	</form>
	</if>
	<elseif cond='isset({mbr_edit})'>
		<if cond="{mbr_edit} == true"><p class="infos">Un mail a été envoyé pour valider les changements.</p></if>
		<else><p class="error">Une autre demande est en cours de validation !</p></else>
	</elseif>
</elseif>
<elseif cond='{mbr_act} == "vldpass"'>
	<if cond='isset({mbr_edit})'>
		<p class="ok">Mot de passe changé ! Vous pouvez maintenant vous connecter.</p>
		<if cond="isset({mbr_newkey})">
			<if cond="{mbr_newkey} == true"><p class="infos">Votre compte n'est pas initialisé ! un mail avec une nouvelle clé de validation vient de vous être envoyé pour initialiser le compte.</p></if>
			<else><p class="error">Votre compte n'est pas initialisé ! Une erreur est survenue lors de l'envoi de mail ! Contactez l'administrateur en précisant votre login et votre mail.</p></else>
		</if>
	</if>
	<else>
		<p class="error">Erreur.</p>
	</else>
</elseif>
<elseif cond='{mbr_act} == "del"'>
	<if cond="isset({send_mail})">
		<if cond="{send_mail}==true"><p class="infos">Un mail a été envoyé pour valider les changements.</p></if>
		<else><p class="error">Une erreur est survenue ! Une autre demande est en cours de validation !(1)</p></else>
	</if>
	<else>
		<if cond="isset({mbr_no_del})"><p class="infos">Un mail a été envoyé pour valider les changements.</p></if>
		<elseif cond="isset({mbr_another_valid})"><p class="error">Une erreur est survenue ! Une autre demande est en cours de validation !(2)</p></elseif>
		<elseif cond="isset({mbr_no_key})"><p class="error">Erreur de Clé ! Ou aucune demande de suppression en cours...</p></elseif>
		<elseif cond="isset({mbr_cls})">
			<if cond="{mbr_cls}==true"><p class="ok">Compte supprimé.</p></if>
			<else><p class="error">Erreur de suppression du compte !</p></else>
		</elseif>
		<else><p class="error">Aucune action</p></else>
	</else>
</elseif>
<elseif cond='{mbr_act} == "rest"'>
	<h3>Relance par mail</h3>
	<if cond="isset({err_no_param})"><p class="error">Erreur : il manque des informations !</p></if>
	<elseif cond="isset({mbr_bad_pass})"><p class="error">Erreur : identification erronée !</p></elseif>
	<elseif cond="isset({mbr_no_del})"><p class="error">Erreur : aucune demande de résiliation n'a été enregistrée !</p>
		<a href="member-del.html?sub=pre" title="Effacer mon compte">Effacer mon compte !</a>
	</elseif>
	<elseif cond="isset({mbr_another_valid})">
		<if cond='{mbr_another_valid}=="new"'>
			<p class="infos">Vous êtes à présent connecté, vous pouvez commencer un nouveau départ dans Zordania ! il vous faut tout d'abord incarner une race et élire domicile dans une région...
			<a href="ini.html?key={key}" title="Poursuivre l'inscription">Cliquer ici pour continuer</a></p>
		</if>
		<else><p class="error">Une erreur est survenue ! Une autre demande est en cours de validation !</p></else>
	</elseif>
	<elseif cond="isset({mbr_no_key})"><p class="error">Erreur de Clé !</p></elseif>
	<else>
		Souhaitez vous réactiver votre compte, ou bien vous désinscrire définitivement de Zordania ?
		<p class="ok"><a href="news.html" title="Vive Zordania !">Je reste !</a></p>

		<p class="error"><a href="inscr-del.html?mid={mid}&amp;key={key}" title="Abandonner">Je quitte Zordania</a> Attention ! La suppression est définitive.</p>
	</else>
</elseif>
