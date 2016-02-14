<if cond='{ses_act} == "login"'>
	<if cond='isset({ses_is_loged})'>
		<p class="error">Vous êtes déjà connecté !</p>
 	</if>
	<elseif cond='isset({ses_noallpost})'>
		<p class="error">Tous les champs n'ont pas été renseignés !</p>
	</elseif>
	<elseif cond='isset({ses_redir})'>
		<meta http-equiv="refresh" content="1; url={cfg_url}">
		<p class="infos">Connexion ...
		<a href="{cfg_url}"><img src="img/right.png" alt="Passer" /></a>
		</p>
	</elseif>
	<elseif cond='isset({ses_loginerror})'>
		<p class="error">Pseudo ou mot de passe incorrect. Il est aussi possible que votre compte ne soit pas encore validé. <a href="{cfg_url}" title="Retour">Retour</a></p>
	</elseif>
</if>
<elseif cond='{ses_act} == "logout"'>
	<if cond='isset({ses_is_not_loged})'>
		<p class="error">Tu n'es pas connecté !</p>
	</if>
	<elseif cond='isset({ses_redir})'>
		<meta http-equiv="refresh" content="1; url={cfg_url}">
		<p class="infos">Déconnexion ... <a href="{cfg_url}"><img src="img/right.png" alt="Passer" /></a></p>
	</elseif>
</elseif>