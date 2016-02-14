<include file="commun/mail_debut.tpl" cache="1" />
Cet email a été envoyé à partir de {cfg_url}
Vous avez reçu cet email pour valider votre compte.

Vos identifiants sont :
Login: {mbr_login}
Mot de passe: {mbr_pass}
Pseudo: {mbr_pseudo}

Pour valider cette inscription, copier le lien suivant sur dans la barre d'adresse de votre navigateur.
{cfg_url}?sub=new&file=member&act=vld&key={vld_key}&mid={vld_mid}

(Les utilisateurs d'hotmail devront peut être copier et coller ce lien dans leur navigateur).

Si vous n'avez rien demandé, veuillez ignorer ce mail.<br/>

Cordialement,
<include file="commun/mail_fin.tpl" cache="1" />