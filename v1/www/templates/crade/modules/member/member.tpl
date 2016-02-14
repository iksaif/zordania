<if cond='|{mbr_act}| == "new"'>
 <if cond='|{mbr_max_inscrit}| == true'>
  <p class="infos">Le site est au maximum de sa capacité, les comptes inutilisés (pas de connexions depuis un mois) sont supprimés toutes les semaines, il y'aura sûrement de la place lundi prochain</p>
 </if>
 <if cond='|{mbr_is_loged}| == true'>
  <p class="error">Vous êtes déjà logué !</p>
 </if>
 <elseif cond='|{mbr_notallpost}| == true'>
  <p class="error">Il manque des informations.</p>
 </elseif>
 <elseif cond='|{mbr_pass_inegal}| == true'>
  <p class="error">Les Mots de Passe sont différents.</p>
 </elseif>
 <elseif cond='|{mbr_mail_inegal}| == true'>
  <p class="error">Les eMails sont différents.</p>
 </elseif>
 <elseif cond='|{mbr_bad_code}| == true'>
  <div class="error">Code de vérification (image) faux , merci de le retaper.
  Le code est sensible à la casse, il faut respecter les majuscules. Vos "cookies" sont aussi peut-être désactivés.
  </div>
 </elseif>
 <elseif cond='|{mbr_ok}| == true'>
  <p class="ok">Ok compte créé ! Un Mail de Validation a été envoyé.</p>
 </elseif>
 <elseif cond='|{mbr_error}| == true'>
  <p class="error">Erreur. Ce Pseudo ou cet email est déjà pris !</p>
 </elseif>
 <if cond='|{mbr_bad_code}| OR |{mbr_notallpost}| OR |{mbr_pass_inegal}| OR |{mbr_mail_inegal}| OR |{mbr_error}| OR |{mbr_new}| AND |{mbr_max_inscrit}| != true'>
  <if cond='|{user_browser[0]}| == "ie"'>
  	<div class="infos">Il semble que vous utilisez Microsoft Internet Explorer {user_browser[1]}, ce site a été
  	fait pour être au maximum conforme aux normes définies par le <a href="http://www.w3.org/">w3c</a>.
  	Pour éviter tout problème sur le site (surtout avec les version inférieures à la 6.0) je vous conseille d'utiliser un navigateur 
  	alternatif qui respecte mieux ces normes (et qui sera plus sécurisé et agréable a utiliser) comme 
  	<a href="http://www.spreadfirefox.com/?q=affiliates&id=30257&t=70" target="_blank" title="Télécharger Firefox"><img src="img/fox.png" alt="Firefox icon" /> Firefox</a> (gratuit).
  	Néanmoins le site est censé pouvoir fonctionner avec Internet Explorer 6.0.
  	</div>
  </if>
  
  <br />
  <form method="post" action="index.php?file=member&amp;act=new">
   <label for="pseudo">Pseudo : </label>
   <br /><input type="text" id="pseudo" name="pseudo" value="{mbr_pseudo}" /><br /><br />
   <label for="pass">Mot de Passe : </label>
   <br /><input type="password" id="pass" name="pass" /><br /><br />
   <label for="pass2">Confirmation du Mot de Passe :</label> 
   <br /><input type="password" id="pass2" name="pass2" /><br /><br />
   <label for="mail">eMail (un mail de validation sera envoyé) :</label> 
   <br /><input type="text" id="mail" name="mail" /><br />
   <label for="mail2">Confirmation de l'eMail</label>
   <br /><input type="text" id="mail2" name="mail2" /><br />
    (les adresses hotmail et caramail posent parfois des problèmes préférez en une autre dans la mesure du possible)<br/>
   <!-- 
   <img src="img/rand/rand.php" alt="code" /><br / >
   <label for="code">Code dans l'image ci-dessus:</label>
   <br /><input type="text" id="code" name="code" />
   <p class="infos">Le code est sensible à la casse, il faut respecter les majuscules.</p>
   -->
   <hr />
   <label for="lang">
   Language :<br />
   </label>
   <select id="lang" name="lang">
	   <foreach cond='|{lang}| as |{lang_abr}| => |{lang_name}|'>
    		<option value="{lang_abr}" <if cond='|{session_user[lang]}| == "{lang_abr}"'>selected="selected"</if>>{lang_name}</option>
	 	 </foreach>
   </select><br />
   

   <label for="race">
   Race :<br />
   </label>
   <select id="race" name="race">
	   <foreach cond='|{race}| as |{race_id}| => |{race_name}|'>
    		<option value="{race_id}">{race_name}</option>
	 	 </foreach>
   </select><br />
  
   <label for="decal">Décalage Horaire (Format: HH:MM:SS exemple 01:00:00, l'heure du serveur est {mbr_date})</label>
   <br /> 
   <if cond='|{mbr_decal}|'>
   	<input type="text" value="{mbr_decal}" name="decal" id="decal" />
   </if>
   <else>
   	<input type="text" value="00:00:00" name="decal" id="decal" />
   </else>
  
   <br />
   <input type="submit" value="Envoyer" name="submit" />
  </form>
  <hr />
  <div class="infos">
  En application de la loi nº 78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés, chaque joueur dispose des droits d'opposition, d'accès et de rectification des données le concernant.
  </div>
 </if>
</if>
<elseif cond='|{mbr_act}| == "del"'>
 <if cond='|{mbr_is_not_loged}| ==  true'>
 <p class="error">Il faut être connecté pour supprimer son compte.</p>
 </if>
 <if cond='|{mbr_ok}| == true'>
 <p class="ok">Ok, un mail de confirmation a été envoyer pour confirmer la suppression du compte.</p>
 </if>
 <if cond='|{mbr_error}| == true'>
 <p class="error"> Erreur.</p>
 </if>
</elseif>
<elseif cond='|{mbr_act}| == "vld"'>
 <if cond='|{mbr_not_exist}| == true'>
 <p class="error">Ce compte n'existe pas ou a déjà été validé.</p>
 </if>
</elseif>
<elseif cond='|{mbr_act}| == "vld_new"'>
 <if cond='|{mbr_is_loged}| == true'>
  <p class="error">Vous êtes déjà logué !</p>
 </if>
 <elseif cond='|{mbr_vld_ok}| == true'>
  <p class="ok">Compte validé.</p>
  <p class="infos">
  Vous pouvez vous connecter en utilisant le formulaire ci-dessus.
  Il est conseillé de lire le manuel avant de commencer à jouer.<br/>
  Vous pouvez faire des réglages via "Mon Compte" dans le menu de gauche.<br/>
  </p>
 </elseif>
 <else>
  <p class="error">La clé de validation est fausse, vérifiez qu'elle contient bien 20 lettres ou chiffres.</p>
 </else>
</elseif>
<elseif cond='|{mbr_act}| == "vld_del"'>
 <if cond='|{mbr_vld_ok}| == true'>
  <p class="ok">Compte supprimé.</p>
 </if>
 <else>
  <p class="error">La clé de validation est fausse, vérifiez qu'elle contient bien 20 lettres ou chiffres.</p>
 </else>
</elseif>
<elseif cond='|{mbr_act}| == "vld_reset"'>
 <if cond='|{mbr_no_race}| == true'>
 	<form method="post" action="index.php?file=member&amp;act=vld&amp;actsub=edit&amp;key={vld_key}&amp;mid={vld_mid}">
 	<label for="race">
 	Nouvelle race:
 	</label>
 	<select name="race" id="race">
		<foreach cond='|{race}| as |{race_id}| => |{race_name}|'>
  		<option value="{race_id}">{race_name}</option>
		</foreach>
	</select> 
		<br/>
	<input type="submit" value="Recommencer !"/>
	</form>
 </if>
 <elseif cond='|{mbr_vld_ok}| == true'>
  <p class="ok">Compte réinitialisé.</p>
 </elseif>
 <else>
  <p class="error">La clé de validation est fausse, vérifiez qu'elle contient bien 20 lettres ou chiffres.</p>
 </else>
</elseif>
<elseif cond='|{mbr_act}| == "vld_mail_pass"'>
 <if cond='|{mbr_vld_ok}| == true'>
  <p class="ok">Compte modifié.</p>
 </if>
 <else>
  <p class="error">La clé de validation est fausse, vérifiez qu'elle contient bien 20 lettres ou chiffres.</p>
 </else>
</elseif>
<elseif cond='|{mbr_act}| == "view"'>
 <if cond='is_array(|{mbr_array}|)'>
 <if cond='{mbr_logo}'>
			<img class="img_right blason" src="{mbr_logo}" alt="Blason" />
 </if>
 Id : {mbr_array[mbr_mid]}<br />
 Pseudo : {mbr_array[mbr_pseudo]}<br />
 Etat : {etat[{mbr_array[mbr_etat]}]}<br/>
 Race : <img src="img/{mbr_array[mbr_race]}/{mbr_array[mbr_race]}.png" title="{race[{mbr_array[mbr_race]}]}" alt="{race[{mbr_array[mbr_race]}]}"/><br/>
 Langue : <img src="img/{mbr_array[mbr_lang]}.png" alt="{mbr_array[mbr_lang]}" /><br />
 Décalage : {mbr_array[mbr_decal]} H<br /> 
 Points : {mbr_array[mbr_points]}<br />
 Population : {mbr_array[mbr_population]}<br />
 Position : {mbr_array[map_x]} * {mbr_array[map_y]}<br/>
 <if cond='{al_array[al_name]}'>
 Alliance: <a href="index.php?file=alliances&amp;act=view&amp;al_aid={al_array[al_aid]}" title="Infos sur {al_array[al_name]}">{al_array[al_name]}</a><br/>
 </if>
 <hr />
 <if cond='|{mbr_array[can_atq]}|'>
 	<a href="index.php?file=war&act=atq&mid={mbr_array[mbr_mid]}" title="Attaquer {mbr_array[mbr_pseudo]}">
 	<img src="img/{session_user[race]}/div/atq.png" alt="Attaquer" />
 	</a> -
 </if>
 <a href="index.php?file=msg&amp;act=new&amp;mbr_mid={mbr_array[mbr_mid]}" title="Envoyer un message à {mbr_array[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
  </a>
 </if>
 <else>
 <p class="error">Ce membre n'existe pas.</p>
 </else>
</elseif>
<elseif cond='|{mbr_act}| == "edit"'>
  <if cond='|{mbr_is_not_loged}| == true'>
  <p class="error">Il faut être connecté pour éditer son compte.</p>
  </if>
  <if cond='|{mbr_sub}| == "mp"'>
   <if cond='|{mbr_not_all_post}| == true'>
    <p class="error">Il manque des informations.</p>
   </if>
   <elseif cond='|{mbr_not_same_pass}| == true'>
    <p class="error">Les Mots de Passe sont différents.</p>
   </elseif>
   <elseif cond='|{mbr_edit}| == true'>
    <p class="infos">Un mail a été envoyé pour valider les changements.</p>
   </elseif>
   <elseif cond='|{mbr_another_valid}| == true'>
    <p class="error">Un autre changement est déjà en cours de validation, vous pouvez l'annuler dans "Mon Compte".</p>
   </elseif>
  </if>
  <elseif cond='|{mbr_sub}| == "oth"'>
   <if cond='|{mbr_edit}| == true'>
    <p class="ok">Ok, infos mises à jour !</p>
   </if>
   <else>
    <p class="error">Erreur.</p>
   </else>
  </elseif>
  <elseif cond='|{mbr_sub}| == "logo"'>
   <if cond='|{mbr_edit}| == true'>
    <p class="ok">Ok, infos mises à jour !</p>
   </if>
   <else>
    <p class="error">Erreur, taille ou type incorect.</p>
   </else>
  </elseif>
  <elseif cond='|{mbr_sub}| == "del_vld"'>
   <if cond='|{mbr_edit}| == true'>
    <p class="ok">Ok, action annulée.</p>
   </if>
   <else>
    <p class="error">Erreur.</p>
   </else>
  </elseif>
  <else>
  <p class="infos">Le Blason doit être une image de type {logo_type}, de taille inférieure ou égale à {logo_size} octets et {logo_x_y}px</p>
	<form class="block_1" enctype="multipart/form-data" action="index.php?file=member&amp;act=edit&amp;sub=logo" method="post">
	<if cond='{mbr_logo}'>
		<img class="img_right" src="{mbr_logo}" alt="Blason" />
	</if>
 	Envoyez ce fichier: <input name="mbr_logo" type="file" />
 	<input type="submit" value="Envoyer" />
	</form>
			
 	<hr />
 	<form method="post" action="index.php?file=member&amp;act=edit&amp;sub=oth">

   Langue :<br />
   <select name="lang">
   <option value="fr" <if cond='|{mbr_lang}| == "fr"'>selected="selected"</if>>Français</option>
   <option value="en" <if cond='|{mbr_lang}| == "en"'>selected="selected"</if>>Anglais</option>
   </select><br />
    
   Décalage Horaire (Format: HH:MM:SS exemple 01:00:00, l'heure du serveur est {mbr_date})
   <br /> <input type="text" value="{mbr_decal}" name="decal">
  
   <br />
   <input type="submit" value="Envoyer" name="submit" />
  </form>
  
  <hr />
  
  <form method="post" action="index.php?file=member&amp;act=edit&amp;sub=mp">
   Mot de Passe : <input type="password" name="pass" /><br /><br />
   Confirmation du Mot de Passe : <input type="password" name="pass2" /><br /><br />
   eMail (un mail de validation sera envoyé) : <input type="text" value="{mbr_mail}" name="mail" />
  <input type="submit" value="Envoyer" name="submit" />
  </form>
  </else>
  <p class="retour_module">
  [ <a href="index.php?file=member">Retour</a>
  ]
  </p>
</elseif>
<elseif cond='|{mbr_act}| == "newpass"'>
	<if cond='|{mbr_form}| == true'>
 	<form method="post" action="">
 	Id de membre* : <input type="text" name="mid" /> 
 	<input type="submit" value="Envoyer" />
 	<br /><br />
 	<div class="infos">Cet id peut être trouvée  [ <a href="index.php?file=member&amp;act=liste">ici</a>
 	] </div>
 	</form>
 	</if>
	<elseif cond='|{mbr_edit}| == true'>
	    <p class="infos">Un mail a été envoyé pour valider les changements.</p>
	</elseif>
	<elseif cond='|{mbr_another_valid}| == true'>
	    <p class="error">Un autre changement est déjà en cours de validation, vous pouvez l'annuler dans "Mon Compte".</p>
	</elseif>
	<elseif cond='|{mbr_not_exist}| == true'>
	    <p class="error">Ce membre n'existe pas.</p>
	</elseif>	
</elseif>
<elseif cond='is_array(|{mbr_array}|)'>
 <if cond='|{mbr_not_loged}| == true'>
 <div class="error">Vous n'êtes pas connecté.</a>
 </if>
 <else>
 <if cond='{mbr_logo}'>
		<img class="img_right" src="{mbr_logo}" alt="Blason" />
 </if>
 Id : {mbr_array[mbr_mid]}<br />
 Mail : {mbr_array[mbr_mail]}<br />
 Pseudo : {mbr_array[mbr_pseudo]}<br />
 Langue : <img src="img/{mbr_array[mbr_lang]}.png" alt="{mbr_array[mbr_lang]}" /><br />
 Décalage : {mbr_array[mbr_decal]} H<br /> 
 Flux XML : <a href="{cfg_url}xml.php?mid={mbr_array[mbr_mid]}" title="Vos infos au format XML">{cfg_url}xml.php?mid={mbr_array[mbr_mid]}</a>
 <hr />
 Choisir un skin:
 <form>
 	<select id="stylesheet" OnChange="setActiveStyleSheet(this.options[this.selectedIndex].value);" >
 	<option value="Marron">Marron</option>
 	<option value="Pixel">Pixel</option>
 	<option value="Metal">Metal</option>
 	<option value="Classik">Classik</option>
 	</select>
 </form>
 <p class="infos">Vous pouvez aussi utiliser les fonctions intégrées a votre navigateur pour ça ;)</p>
 <noscript>Le Javascript doit être activé !</noscript>
 <hr/>
 <if cond='{vld_array}'>
 <strong>Vous avez une action en cours de validation  ({vldacts[{vld_array}]}),
 <a href="index.php?file=member&amp;act=edit&amp;sub=del_vld">Annuler</a>.</strong>
 <hr/>
 </if>
 <p class="menu_module">
 [ <a href="index.php?file=member&amp;act=edit" title="Editer mon compte">Editer mon compte</a>
 ] - [ <a href="index.php?file=member&amp;act=del" title="Supression du compte">Effacer mon compte</a>
 ] - [ <a href="index.php?file=member&amp;act=edit&amp;sub=reset" title="Recommencer une partie">Réinitialiser mon compte</a>
 ]
 </p>
 </else>
</elseif>