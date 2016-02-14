<include file="commun/mail_debut.tpl" cache="1" />

Cet email a été envoyé à partir de {cfg_url}
Vous vous êtes inscrit sur le jeu gratuit online {cfg_url} mais vous n'avez pas validé votre compte.

Pour valider votre inscription, copiez le lien suivant dans la barre d'adresse de votre navigateur :

{cfg_url}ini.html?key={vld_key}

Si vous avez oublié votre mot de passe, rendez vous ici pour en recevoir un nouveau :

{cfg_url}inscr-newpass.html?login={mbr_login}&mail={mbr_mail}

Pour supprimer définitivement votre inscription et ne plus recevoir de mails, il vous suffit de la valider puis de le supprimer (lien 'mon compte' puis 'effacer mon compte'). Vous pouvez aussi faire une demande de désinscription ici :

{cfg_url}inscr-del.html?mid={mbr_mid}&mail={mbr_mail}

Rappel de vos coordonnées :
Login: {mbr_login}
Email: {mbr_mail}

Cordialement,

<include file="commun/mail_fin.tpl" cache="1" />
