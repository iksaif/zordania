<if cond='!empty({mbr_array})'>
	<if cond='{mbr_logo}'>
				<img class="blason blason" src="{mbr_logo}" alt="Blason" />
	</if>
	<h3>{mbr_array[mbr_pseudo]}</h3>

<!-- sous-menu membre -->
<script type="text/javascript">
	// Une fois le chargment de la page terminé ...
	var showmsg = false;
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
			if(contenu_aff == 'contient_msg' && !showmsg){
				//fonction jqShowMod dans js/jquery.zordania.js
				jqShowMod('forum-search.html?action=show_user&sort_dir=DESC&user_id={mbr_array[mbr_mid]}','contient_msg');
				showmsg = true;
			}
			$("#" + contenu_aff).slideDown();
			return false;
		});
	});
</script>

	<a href="#" descr="contient_infos" class="tab active">Informations</a> -
	<if cond="{mbr_array[mbr_descr]}"><a href="#" descr="contient_descr" class="tab active">Description</a> - </if>
	<a href="#" descr="contient_msg" class="tab"><img src="img/frm.png" title="Messages sur le forum"/> Messages sur le forum</a>
	- <a href="http://{ZORDLOG_URL}/membre.html?id={mbr_array[mbr_mid]}" title="Plus d'informations sur les Archives" ><img src="img/sablier.png"/> Archives</a>

	<if cond='{mbr_array[can_def]}'> - 
		<a href="leg-move.html?sub=atq&cid={mbr_array[mbr_mapcid]}" title="Soutenir {mbr_array[mbr_pseudo]}"><img src="img/{_user[race]}/div/def.png" /> Soutenir</a>
	</if>
	<elseif cond='{mbr_array[can_atq]}'> - 
		<a href="leg-move.html?sub=atq&cid={mbr_array[mbr_mapcid]}" title="Attaquer {mbr_array[mbr_pseudo]}"><img src="img/{_user[race]}/div/atq.png" /> Attaquer</a>
	</elseif>
	- <a href="msg-new.html?mbr_mid={mbr_array[mbr_mid]}" title="Envoyer un message à {mbr_array[mbr_pseudo]}"><img src="img/msg.png"/> Ecrire</a>


<div id="contient_infos" class="content">

	<if cond="{mbr_array[mbr_etat]} == MBR_ETAT_INI">
		<include file="modules/member/descr/0.tpl" cache="1" />
	</if>
	<else>

	<include file="modules/member/descr/{mbr_array[mbr_race]}.{mbr_array[mbr_sexe]}.tpl" cache="1" />
	<hr />
	<p>
		<if cond='{mbr_online}'><span class="ok">En Ligne</span></if>
		<else><span class="infos">Hors Ligne</span></else>
	</p>
	Groupe : <img src="img/groupes/{mbr_array[mbr_gid]}.png" alt="{groupes[{mbr_array[mbr_gid]}]}" title="{groupes[{mbr_array[mbr_gid]}]}"/> {groupes[{mbr_array[mbr_gid]}]}<br/>
	Etat : {etat[{mbr_array[mbr_etat]}]}<br/>
	Langue : <img src="img/{mbr_array[mbr_lang]}.png" alt="{mbr_array[mbr_lang]}" /><br />
	Décalage : {mbr_array[mbr_decal]} H<br /> 

	Village : {mbr_array[mbr_vlg]}<br />
	Race : <zimgrace race="{mbr_array[mbr_race]}" /><br/>

	Points : {mbr_array[mbr_points]}<br />
	Force armée : {mbr_array[mbr_pts_armee]}<br />
	Population : {mbr_array[mbr_population]}<br />
	Position : <a href="carte.html?map_cid={mbr_array[mbr_mapcid]}" title="voir la carte">{mbr_array[map_x]}x{mbr_array[map_y]}</a><br/>
	Région : {regions[{mbr_array[map_region]}][name]}<br/>
	Distance : {mbr_dst}<br/>
	<if cond='isset({mbr_array[al_name]}) && {mbr_array[ambr_aid]}'>
	Alliance: <a href="alliances-view.html?al_aid={mbr_array[ambr_aid]}" title="Infos sur {mbr_array[al_name]}">
		<img src="img/al_logo/{mbr_array[ambr_aid]}-thumb.png" class="mini_al_logo"/>
		{mbr_array[al_name]}</a>
		<if cond="{mbr_array[al_open]} == 1">
			<a href="alliances-join.html?al_aid={mbr_array[ambr_aid]}">Cette alliance recrute !
			<img src="img/join.png" alt="Rejoindre" title="Rejoindre {mbr_array[al_name]}" />
			</a>
		</if>
		<br/>
		<if cond="isset({mbr_dpl[{mbr_array[ambr_aid]}]})">
			Pacte : <zimgpact type="{mbr_dpl[{mbr_array[ambr_aid]}]}"/> {dpl_type[{mbr_dpl[{mbr_array[ambr_aid]}]}]}
			<br/>
		</if>

	</if>
	</else>

	<div class="signature">{mbr_array[mbr_sign]}</div>

	<if cond='{ses_admin} == "1"'>
		<p class="infos">
	   	<a href="admin-view.html?module=member&mid={mbr_array[mbr_mid]}"><img src="img/plus.png" alt="Plus d'infos Admin" /></a>
	   	- <a href="admin-edit.html?module=member&mid={mbr_array[mbr_mid]}"><img src="img/editer.png" alt="Editer ce compte" /></a>
		<if cond="!empty({mbr_surv})">
			<a class="error" href="admin-view.html?module=surv&act=view&sid={mbr_surv[surv_id]}">Surveillance en cours</a>
		</if>
		<else>- <a href="admin-new.html?module=surv&mid={mbr_array[mbr_mid]}"><img src="img/groupes/9.png" alt="Surveiller ce compte" /></a></else>
	   	- <a href="admin-histo.html?module=war&mid={mbr_array[mbr_mid]}"><img src="img/info.png" alt="Journal" /></a>
		</p>
	</if>
	
	<if cond="{mbr_rec}">
	<h4>Récompenses</h4>
		<foreach cond="{mbr_rec} as {rec_value}">
			{rec_value[rec_nb]} <img src="img/rec/{rec_value[rec_type]}.png" title="{recompense[{rec_value[rec_type]}]}" alt="{recompense[{rec_value[rec_type]}]}" />
		</foreach>
	</if>
	<hr />
	
	<h3><a id="parrain_infos" class="toggle">Filleuls</a></h3>
	<table id="parrain_infos_toggle" class="liste" style="display: none;">
	   <tr>
			<th>Pseudo</th>
			<th>Race</th>
			<th>Alliance</th>
			<th>Population</th>
			<th>Points</th>
			<th>Actions</th>
		</tr>
		<foreach cond='{filleuls} as {result}'>
			<tr<if cond='{_user[alaid]} == {result[ambr_aid]} AND {_user[alaid]} != 0'> class="allie"</if>>
				<td>
					<zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/>
				</td>
				<td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
				<td>
		<if cond='{result[ambr_aid]}'>
			<a href="alliances-view.html?al_aid={result[ambr_aid]}">
				<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
			</a>
		</if>
		<else>&nbsp;</else>

				</td>
				<td>{result[mbr_population]}</td>
				<td>{result[mbr_points]} / {result[mbr_pts_armee]}</td>
				<td>
		<if cond='{result[mbr_mid]} != {_user[mid]}'>
			<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
		</if>
		<if cond='{result[can_atq]}'>
			-
			<a href="leg-move.html?sub=atq&cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/atq.png" alt="Attaquer" />
			</a> 
		</if>
		<if cond='{result[ambr_aid]} && {result[ambr_aid]} == {_user[alaid]}'>
			-
			<a href="leg-move.html?sub=sou&cid={result[mbr_mapcid]}" title="Protéger {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/def.png" alt="Protéger" />
			</a> 
		</if>
			&nbsp;
				</td>
			</tr>
		</foreach>
	</table>
</div>


	<if cond="{mbr_array[mbr_descr]}">
	<div id="contient_descr" class="content" style="display: none;">
		<h4>Description</h4>
		<p>{mbr_array[mbr_descr]}</p>
	</div>
	</if>


	<div id="contient_msg" class="content" style="display: none;">
		<h4>Messages du forum</h4>
		<p>recherche en cours, veuillez patienter...</p>
	</div>


</if>
<else>
	<p class="error">Ce membre n'existe pas.</p>

	<if cond='{ses_admin} == "1"'>
		<p class="infos"><a href="admin-old.html?module=member&mid={mbr_mid}">Recherche Admin</a></p>
	</if>
</else>
