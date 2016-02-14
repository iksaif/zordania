<include file="commun/mail_debut.tpl" cache="1" />
Cet email a été envoyé à partir de {cfg_url}
Vous avez reçu cet email pour valider votre compte.

Vos identifiants sont :
Login: {mbr_login}
<if cond="{mbr_pass}">Mot de passe: {mbr_pass}</if>
Clef de Validation: {vld_key}

Pour valider cette inscription, connectez-vous, puis copiez le lien suivant dans la barre d'adresse de votre navigateur:

{cfg_url}ini.html?key={vld_key}

Si vous n'avez rien demandé, veuillez ignorer ce mail.

Cordialement,
<include file="commun/mail_fin.tpl" cache="1" />
