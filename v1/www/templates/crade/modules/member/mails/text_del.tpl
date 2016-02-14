<include file="commun/mail_debut.tpl" cache="1" />
Cet email a été envoyé à partir de {cfg_url}<br/>
Vous avez reçu cet email pour supprimer votre compte.<br/>
Pour valider cette suppression, cliquez sur le lien suivant:<br/>
<br/>
<a href="{cfg_url}?file=member&amp;act=vld&amp;actsub=del&amp;key={vld_key}&amp;mid={vld_mid}">{cfg_url}?sub=del&file=member&act=vld&key={vld_key}&mid={vld_mid}</a>
<br/><br/>
(Les utilisateurs d'AOL devront peut être copier et coller ce lien dans leur navigateur).<br/>
<br/>
Cordialement,<br/>
<br/>
<include file="commun/mail_fin.tpl" cache="1" />