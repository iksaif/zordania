<p class="menu_module">
	[ <a href="admin.html?module=member" title="Retour">Retour</a> ] -
	[ <a href="admin-liste.html?module=member" title="Liste">Liste</a> ] -
	[ <a href="admin-liste_online.html?module=member" title="Liste Online">Liste Online</a> ] -
	[ <a href="admin-liste_ip.html?module=member" title="Liste IP doubles">Liste IP</a> ] -
	[ <a href="admin-old.html?module=member" title="Vieux comptes">Vieux comptes</a> ]
</p>
<hr />

<if cond="isset({act_interdit})"><p class="error">Action interdite ! Vous n'avez pas le droit d'effectuer cette action.</p></if>

<if cond='{mbr_act} == "liste"'>
	<table class="liste">
		<tr>
			<th>Id</th>
			<th>Pseudo</th>
			<th>IP</th>
			<th>Population</th>
			<th>Points</th>
			<th>Groupe</th>
			<th>Etat</th>
			<th>Actions</th>
		</tr>
		
		<foreach cond='{mbr_array} as {result}'>
			<tr>
				<td>{result[mbr_mid]}</td>
				<td>
					<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
					<a href="admin-view.html?module=member&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a></td>
				<td>{result[mbr_lip]}</td>
				<td>{result[mbr_population]}</td>
				<td>{result[mbr_points]}</td>
				<td>{result[mbr_gid]}</td>
				<td>{etat[{result[mbr_etat]}]}</td>
				<td>
					<a href="admin-edit.html?module=member&amp;mid={result[mbr_mid]}"><img src="img/editer.png" alt="Editer" /></a>
					-
					<a href="admin-del.html?module=member&amp;mid={result[mbr_mid]}"><img src="img/drop.png" alt="Drop :D" /></a>
					-
					<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
						<img src="img/msg.png" alt="Msg" />
					</a>
				</td>
			</tr>
		</foreach>
	</table>
	Page : 
	<for cond='{i} = 0; {i} < {mbr_nb}; {i}+={limite_page}'>
		<a href="admin-liste.html?module=member&amp;mbr_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
	</for>
		
	<hr />
	<form action="admin-liste.html?module=member" method="post">
		<fieldset>
			<legend>Options</legend>
			<p><label for="pseudo">Pseudo: </label><input type="text" value="{mbr_pseudo}" id="pseudo" name="pseudo" /></p>
			<p><label for="ip">Ip: </label><input type="text" value="{mbr_ip}" id="îp" name="ip" /></p>
			
			<p><label for="by">Trier par:</label>
			<select name="by" id="by">
				<option value="pseudo" <if cond='{mbr_by} == "pseudo"'> selected="selected"</if>  >Pseudo</option>  
				<option value="population" <if cond='{mbr_by} == "population"'> selected="selected"</if> >Population</option>
				<option value="points" <if cond='{mbr_by} == "points"'> selected="selected"</if> >Points</option>
			</select>
			</p>
			
			<p><label for="order">Ordre</label>
			<select name="order" id="order">
				<option value="1" <if cond='{mbr_order} == "1"'> selected="selected"</if>>Ascendant</option>
				<option value="2" <if cond='{mbr_order} == "2"'> selected="selected"</if>>Descendant</option>
			</select> </p>
		</fieldset>
		<input type="submit" value="Trier" />
	</form>
		
</if>
<if cond='{mbr_act} == "liste_online"'>
	<table class="liste">
		<tr>
			<th>Id</th>
			<th>Pseudo</th>
			<th>Langue</th>
			<th>Population</th>
			<th>Points</th>
			<th>Ip</th>
			<th>Act</th>
			<th>Groupe</th>
			<th>Actions</th>
		</tr>
		
		<foreach cond='{mbr_array} as {result}'>
			<tr>
				<td>{result[ses_mid]}</td>
				<td>
					<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
					<a href="admin-view.html?module=member&amp;mid={result[ses_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
				</td>
				<td><img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /></td>
				<td>{result[mbr_population]}</td>
				<td>{result[mbr_points]}</td>
				<td>{result[ses_ip]}</td>
				<td>{pages[{result[ses_lact]}]}</td>
				<td>{result[mbr_gid]}</td>
				<td>
					<a href="admin-edit.html?module=member&amp;mid={result[mbr_mid]}"><img src="img/editer.png" alt="Editer" /></a>
					-
					<a href="admin-del.html?module=member&amp;mid={result[mbr_mid]}"><img src="img/drop.png" alt="Drop :D" /></a>
					-
					<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
						<img src="img/msg.png" alt="Msg" />
					</a>
				</td>
			</tr>
		</foreach>
	</table>
	Page : 
	<for cond='{i} = 0; {i} < {mbr_nb}; {i}+={limite_page}'>
			<a href="admin-liste_online.html?module=member&amp;mbr_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
	</for>
</if>
<elseif cond='{mbr_act} == "view"'>
	<if cond='isset({mbr_array}) && {mbr_array}'>
		<div class="block">
			<strong>{mbr_array[mbr_pseudo]} : </strong>
			<a href="admin-edit.html?module=member&amp;mid={mbr_array[mbr_mid]}"><img src="img/editer.png" alt="Editer" /></a>
			-
			<a href="admin-del.html?module=member&amp;mid={mbr_array[mbr_mid]}"><img src="img/drop.png" alt="Drop :D" /></a>
			-
			<a href="msg-new.html?mbr_mid={mbr_array[mbr_mid]}" title="Envoyer un message à {mbr_array[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
			-
			<a href="admin-exp.html?module=member&amp;mid={mbr_array[mbr_mid]}" title="Export SQL">SQL</a>
		</div>

<!-- sous-menu membre -->
<script type="text/javascript">
	// Une fois le chargment de la page terminé ...
	$(document).ready(  function()
	{
		// Lorsqu'un lien a.tab est cliqué
		$("a.tab").click(   function () 
		{
			// Mettre tous les onglets non actifs
			$(".active").removeClass("active");
			// Mettre l'onglet cliqué actif
			$(this).addClass("active");
			// Cacher les boîtes de contenu
			$(".content").slideUp();

			// Pour afficher la boîte de contenu associé, nous
			// avons modifié le titre du lien par le nom de
			// l'identifiant de la boite de contenu
			var contenu_aff = $(this).attr("descr");
			$("#" + contenu_aff).slideDown();
			return false;
		});
	});
</script>
		<p class="menu_module">
			[<a href="#leg" class="tab active" title="Informations du compte" descr="infos_gene"> Compte </a>]
			[<a href="#leg" class="tab" title="journal des connexions" descr="infos_ip"> Log IP </a>]
			[<a href="#leg" class="tab" title="Légions" descr="infos_leg"> Légions </a>]
			[<a href="#res" class="tab" title="Ressources" descr="infos_res"> Ressources </a>]
			[<a href="#trn" class="tab" title="Terrains" descr="infos_trn"> Terrains </a>]
			[<a href="#unt" class="tab" title="Unités" descr="infos_unt"> Unités </a>]
			[<a href="#src" class="tab" title="Recherches" descr="infos_src"> Recherches </a>]
			[<a href="#bat" class="tab" title="Bâtiments" descr="infos_btc"> Bâtiments </a>]
			[<a href="admin-histo.html?mid={mbr_array[mbr_mid]}&amp;module=war" title="Journal de Guerre"> Journal </a>]
		</p>

		<div class="content" id="infos_gene">
			Id : {mbr_array[mbr_mid]}<br />
			Mail : {mbr_array[mbr_mail]}<br />
			Pseudo : {mbr_array[mbr_pseudo]}<br />
			Village : {mbr_array[mbr_vlg]}<br />
			Login : {mbr_array[mbr_login]}<br />
			Groupe : <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/><br/>
			Race : <img src="img/{mbr_array[mbr_race]}/{mbr_array[mbr_race]}.png" title="{race[{mbr_array[mbr_race]}]}" alt="{race[{mbr_array[mbr_race]}]}"/> {race[{mbr_array[mbr_race]}]}<br/>
			Langue : <img src="img/{mbr_array[mbr_lang]}.png" alt="{mbr_array[mbr_lang]}" /><br />
			Décalage : {mbr_array[mbr_decal]} H<br /> 
			Points : {mbr_array[mbr_points]}<br />
			Force armée : {mbr_array[mbr_pts_armee]}<br />
			Population : {mbr_array[mbr_population]}<br />
			<if cond='isset({mbr_array[al_name]})'>
				Alliance: <a href="admin-view.html?module=alliances&amp;al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">{mbr_array[al_name]}</a><br/>
			</if>
			Ip : {mbr_array[mbr_lip]} - <a href="admin-liste_ip.html?module=member&amp;ip={mbr_array[mbr_lip]}"><img src="img/plus.png" alt="Liste IP" /></a><br/>
			Dernière connexion : {mbr_array[mbr_ldate]}<br/>
			Inscription : {mbr_array[mbr_inscr_date]} <br/>

		</div>

		<div class="content" id="infos_ip" style="display: none;">
			<if cond='{log_ip}'>
				<table class="liste">
				<tr>
					<th>Ip</th>
					<th>Date</th>
				</tr>
				<foreach cond='{log_ip} as {ip}'>
					<tr>
						<td>{ip[mlog_ip]} <a href="admin-liste_ip.html?module=member&amp;ip={ip[mlog_ip]}"><img src="img/plus.png" alt="Liste IP" /></a></td>
						<td>{ip[mlog_date]}</td>
					</tr>
				</foreach>
				</table>
			</if>
			<else>Aucun log d'adresse IP</else>
		</div>

		<if cond="{mbr_array[mbr_etat]} != MBR_ETAT_INI && {mbr_array[mbr_race]} != 0">
			<include file='modules/member/liste_infos_max.tpl' cache='1' />
		</if>
	</if>
	<elseif cond="isset({mbr_staff}) and {mbr_staff}">
		<p class="error">Membre du staff.</p>
	</elseif>
	<else>
		<p class="error">Ce membre n'existe pas.</p>
	</else>
</elseif>

<elseif cond='{mbr_act} == "del"'>
	<if cond='isset({mbr_no_mid})'>
		<p class="error">Aucun mid !</p>
	</if>
	<elseif cond='isset({mbr_need_ok})'> 
		Supprimer le membre {mbr_mid} ?
		<form method="post" action="admin-del.html?module=member&amp;mid={mbr_mid}">
			<input type="submit" name="ok" value="Oui" />
		</form>
	</elseif>
	<else>
		<p class="ok">Ok, membre {mbr_mid} supprimé !</p>
	</else>
</elseif>
<elseif cond='{mbr_act} == "edit"'>
	<if cond='isset({mbr_edit})'>
		<p class="ok">Ok, compte édité !</p>
	</if>
	<if cond='isset({mbr_pseudo_exist})'>
		<p class="error">Ce pseudo est déjà pris !</p>
	</if>
	<if cond='isset({mbr_not_exist})'>
		<p class="error">Ce membre n'existe pas.</p>
	</if>

	<form method="post" action="admin-edit.html?module=member&amp;sub=edit&amp;mid={mbr_mid}">
		
		<p><label for="lang">Langue</label>
		<select name="lang" id="lang">
			<foreach cond='{lang} as {lang_abr} => {lang_name}'>
				<option value="{lang_abr}" <if cond='{mbr_lang} == {lang_abr}'>selected="selected"</if>>{lang_name}</option>
			</foreach>
		</select></p>
		
		(Format: HH:MM:SS exemple 01:00:00, l'heure du serveur est {mbr_date})
		<p><input type="text" value="{mbr_decal}" name="decal" /></p>
		<!-- <p><label for="login">Login</label><input type="text" name="login" id="login" value="{mbr_login}" /></p> -->
		<p><label for="pseudo">Pseudo</label><input type="text" name="pseudo" id="pseudo" value="{mbr_pseudo}" /></p>
		<p><label for="village">Village</label><input type="text" name="village" id="village" value="{mbr_vlg}" /></p>
		<p><label for="admpass">Mot de Passe</label><input type="password" name="admpass" id="admpass" /><br /></p>
		<p><label for="mail">eMail</label><input type="text" value="{mbr_mail}" name="mail" id="mail"/></p>
			
		<p><label for="mbr_gid">Groupe</label>
		<select id="mbr_gid" name="gid">
			<foreach cond="{groupes} as {i} => {value}">
				<option value="{i}" <if cond="{mbr_gid} == {i}">selected="selected"</if>>{groupes[{i}]}</option>
			</for>
		</select>
		</p>
			
		<p>
			<label for="sign">Signature (max 255 signes):</label>
			<input type="text" size="50" name="sign" id="sign" value="{mbr_sign}">
		</p>
		
		<p>
			<include file='commun/bbcode.tpl' cache='1' /><br/>
			<textarea id="message" cols="60" rows="11" name="descr">{mbr_descr}</textarea> 
		</p>
		
		<p><input type="submit" value="Envoyer" name="submit" /></p>
	</form>

	<a name="move_mbr"></a><h4>Déménagement</h4>

	<if cond="isset({depl_ok})">
		<if cond='{depl_ok} == 1'><p class="ok">Village déplacé !</p></if>
		<elseif cond='{depl_ok} == "out"'><p class="error">La destination est hors carte !</p></elseif>
		<else><p class="error">La destination n'est pas un emplacement libre ! ({depl_ok})</p></else>
	</if>

	<fieldset><legend>Déplacer le village du membre en position</legend>
		<form method="post" action="admin-edit.html?module=member&amp;sub=move_mbr&amp;mid={mbr_mid}#move_mbr">
			<label for="map_x">X :</label><input type="text" size="6" id="map_x" name="map_x">
			<label for="map_y">Y :</label><input type="text" size="6" id="map_y" name="map_y">
			<label for="map_cid">OU donner le map_cid :</label><input type="text" size="6" id="map_cid" name="map_cid">
			<br/>
			<input type="button" value="Vérifier la case" onclick="return showMapInfo();" />
			<input type="submit" value="Déménagement"/>
		</form>
		<div id="carte_infos"></div>
	</fieldset>

	<h4>Récompenses</h4>
	<foreach cond="{rec_array} as {rec_value}">
		{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
	</foreach>
	
	<form method="post" action="admin-edit.html?module=member&amp;sub=add_rec&amp;mid={mbr_mid}">
		<select name="rec_type" id="rec_type">
			<foreach cond="{recompense} as {rec_type} => {rec_name}">
				<option value="{rec_type}">{rec_name}</option>
			</foreach>
		</select>
		<input type="submit" value="Ajouter"/>
	</form>
	<if cond="{rec_array}">
		<form method="post" action="admin-edit.html?module=member&amp;sub=del_rec&amp;mid={mbr_mid}">
			<select name="rec_type" id="rec_type">
				<foreach cond="{rec_array} as {rec_value}">
					<option value="{rec_value[rec_type]}">{recompense[{rec_value[rec_type]}]}</option>
				</foreach>
			</select>
			<input type="submit" value="Virer"/>
		</form>
	</if>

	<a name="legions" /><h3>Légions :</h3>
	<if cond='isset({ren_leg_not_exists})'>
		<p class="error">Cette légion n'existe pas.</p>
	</if>
	<if cond='isset({ren_leg_name_exists})'>
		<p class="error">Une légion existe déjà avec ce nom, ou similaire : {ren_leg_name}</p>
	</if>
	<if cond='isset({ren_leg_ok})'>
		<p class="ok">Ok, légion renommée : {ren_leg_name}</p>
	</if>
	<if cond='{leg}'>
		<table class="liste">
		<tr>
			<th>id</th>
			<th>Nom</th>
			<th>xp</th>
			<th>Fatigue</th>
			<th>Renommer ?</th>
		</tr>
		<foreach cond='{leg} as {leg_nb} => {leg_array}'>
			<tr>
				<td>{leg_array[leg_id]}</td>
				<td>{leg_array[leg_name]}</td>
				<td>{leg_array[leg_xp]}</td>
				<td>{leg_array[leg_fat]}</td>
				<td>
					<form method="post" action="admin-edit.html?module=member&amp;sub=ren_leg&amp;mid={mbr_mid}&amp;lid={leg_array[leg_id]}#legions">
					<input type="text" size="20" maxlength="40" name="leg_name" id="leg_name" value="{leg_array[leg_name]}">
					<input type="submit" value="Renommer"/>
					</form>
				</td>
			</tr>
		</foreach>
		</table>
	</if>
	<else>Aucune légion.</else>

</elseif>
<elseif cond='{mbr_act} == "liste_ip"'>

	<if cond='{mbr_array}'>
		<h3>IP connues des dernière connexions</h3>
		<set name='temp_lip' value='' />
		<foreach cond='{mbr_array} as {key} => {mbr_value}'>
			<if cond='{temp_lip} != {mbr_value[mbr_lip]}'>
				<if cond="{temp_lip}"></table></if>
				<set name='temp_lip' value='{mbr_value[mbr_lip]}' />
				<h3>{mbr_value[mbr_lip]} <!-- math oper="@gethostbyaddr({mbr_value[mbr_lip]})" />--></h3>
		
				<table class="liste">
					<tr>
						<th>Pseudo</th>
						<th>lDate</th>
						<th>Mail</th>
						<th>Login</th>
					</tr>
			</if>
			<tr>
				<td><a href="admin-view.html?module=member&amp;mid={mbr_value[mbr_mid]}" title="Infos sur {mbr_value[mbr_pseudo]}">{mbr_value[mbr_pseudo]}</a></td>
				<td>{mbr_value[mbr_ldate]}</td>
				<td>{mbr_value[mbr_mail]}</td>
				<td>{mbr_value[mbr_login]}</td>
			</tr>
		</foreach> 
		</table>
	</if>
	<else>
		A Perfect World ! (aucun multi compte ce jour)
	</else>
	<if cond="!empty({log_ip})">
		<h3>Log des connexions précédentes sur cette IP {log_ip[0][mlog_ip]}</h3>
		<table class="liste">
		<tr>
			<th>Pseudo</th>
			<th>Date de connexion</th>
			<th>Mail</th>
		</tr>
		<foreach cond="{log_ip} as {ip}">
		<tr>
			<td>
			<if cond="{ip[mbr_gid]} != 0">
				<img src="img/groupes/{ip[mbr_gid]}.png" alt="{groupes[{ip[mbr_gid]}]}" title="{groupes[{ip[mbr_gid]}]}"/><a href="admin-view.html?module=member&amp;mid={ip[mlog_mid]}" title="Infos sur {ip[mbr_pseudo]}"> {ip[mbr_pseudo]}</a>
			</if>
			<else>
				<img src="img/drop.png" alt="Compte supprimé" title="Compte supprimé"/><a href="admin-old.html?module=member&amp;mid={ip[mlog_mid]}" title="Infos sur {ip[mbr_pseudo]}"> {ip[mbr_pseudo]}</a>
			</else>
			</td>
			<td>{ip[mlog_date]}</td>
			<td>{ip[mbr_mail]}</td>
		</tr>
		</foreach> 
		</table>
	</if>
	<else>
		<p class="error">Aucune connexion passée enregistrée sur cette IP !</p>
	</else>
</else>
<elseif cond='{mbr_act} == "old"'>
	<table class="liste">
		<tr>
			<th>Id</th>
			<th>Pseudo</th>
			<th>IP</th>
			<th>Mail</th>
			<th>Date</th>
		</tr>
		<foreach cond='{mbr_array} as {result}'>
			<tr>
				<td>{result[mold_mid]}</td>
				<td>{result[mold_pseudo]}</td>
				<td><a href="admin-liste_ip.html?module=member&amp;ip={result[mold_lip]}">{result[mold_lip]}</a></td>
				<td>{result[mold_mail]}</td>
				<td>{result[mold_date]}</td>
			</tr>
		</foreach>
	</table>

	<hr />
	<form action="admin-old.html?module=member" method="post">
		<fieldset>
			<legend>Options</legend>
			<p><label for="mid">Mid: </label><input type="text" value="{mbr_mid}" id="mid" name="mid" /></p>
			<p><label for="pseudo">Pseudo: </label><input type="text" value="{mbr_pseudo}" id="pseudo" name="pseudo" /></p>
			<p><label for="ip">Ip: </label><input type="text" value="{mbr_ip}" id="îp" name="ip" /></p>
		<input type="submit" value="Trier" />
	</form>
		
</elseif>
<elseif cond='{mbr_act} == "exp"'>
	<pre>{sql}</pre>
</elseif>

