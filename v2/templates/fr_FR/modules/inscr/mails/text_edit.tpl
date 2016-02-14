<include file="commun/mail_debut.tpl" cache="1" />
Cet email a été envoyé à partir de {cfg_url}
Vous avez reçu cet email car une modification à été effectuée sur votre compte.

Pour valider cette modification, copiez le lien suivant dans la barre d'adresse de votre navigateur:

{cfg_url}inscr.html?act=vldpass&key={vld_key}&mid={vld_mid}&pass={vld_pass}

Mot de passe: {vld_pass2}
Email: {vld_mail}

Si vous n'avez rien demandé, veuillez ignorer ce mail.

Cordialement,
<include file="commun/mail_fin.tpl" cache="1" />