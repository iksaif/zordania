<include file="commun/mail_debut.tpl" cache="1" />
Cet email a été envoyé à partir de {cfg_url}<br/>
Vous avez reçu cet email car une modification à été effectuée sur votre compte.<br/>
Pour valider cette modification, cliquez sur le lien suivant:<br/>
<br/>
<a href="{cfg_url}?file=member&amp;act=vld&amp;actsub=edit&amp;key={vld_key}&amp;mid={vld_mid}&amp;mail={vld_mail}&amp;pass={vld_pass}">{cfg_url}?sub=edit&file=member&act=vld&key={vld_key}&mid={vld_mid}&mail={vld_mail}&pass={vld_pass}</a>
<br/><br/>
Mot de passe : {vld_pass2}<br/>
Email : {vld_mail}
<br/><br/>
(Les utilisateurs d'AOL devront peut être copier et coller ce lien dans leur navigateur).
<br/><br/>
Cordialement,<br/><br/>
<include file="commun/mail_fin.tpl" cache="1" />