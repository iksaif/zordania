<if cond='|{ses_act}| == "login"'>
 <if cond='|{ses_is_loged}| == true'>
 <p class="error">Vous êtes déjà connectés !</p>
 </if>
 <elseif cond='|{ses_noallpost}| == true'>
 <p class="error">Tous les champs n'ont pas été renseignés !</p>
 </elseif>
 <elseif cond='|{ses_redir}| == true'>
  <meta http-equiv="refresh" content="1; url={cfg_url}">
 <p class="infos">Connexion ...
 <a href="{cfg_url}"><img src="img/right.png" alt="Passer" /></a>
 </p>
 </elseif>
 <elseif cond='|{ses_loginerror}| == true'>
 <p class="error">Pseudo ou mot de passe incorect. Il est aussi possible que votre compte ne sois pas encore validé.</p>
 </elseif>
</if>
<elseif cond='|{ses_act}| == "logout"'>
 <if cond='|{ses_is_not_loged}| == true'>
 <p class="error">Tu n'es pas connecté !</p>
 </if>
 <elseif cond='|{ses_redir}| == true'>
 <meta http-equiv="refresh" content="1; url={cfg_url}">
 <p class="infos">Déconnexion ... <a href="{cfg_url}"><img src="img/right.png" alt="Passer" /></a></p>
 </elseif>
</elseif>