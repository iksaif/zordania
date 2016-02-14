<if cond='isset({al_not_admin})'>
	<p class="infos">Vous n'avez aucune compétence à gérer au sein de l'alliance.</p>
</if>

<else>
	<if cond='!{al_sub}'>
		<if cond='isset({droits[logo]})'>
			<p class="infos">Le Blason doit être une image de type {logo_type}, de taille inférieure ou égale à {logo_size} octets et {logo_x_y} px.</p>
			<form class="block" enctype="multipart/form-data" action="alliances-admin.html?sub=logo" method="post">
			<img class="blason" src="{al_logo}" alt="Blason" />
			Envoyez ce fichier: <input name="al_logo" type="file" />
			<input type="submit" value="Envoyer" />
			</form>
		</if>

		<if cond='isset({droits[param]})'>
			<form class="block" action="alliances-admin.html?sub=param" method="post">
			<label for="al_open">Demandes Ouvertes:</label><br/>
			<input id="al_open" type="checkbox" name="al_open" value="1" <if cond='{al_array[al_open]}'>checked="checked"</if> />
			<label for="al_open">Oui</label><br/>
			<label for="al_descr">Description :</label><br/>
			<include file='commun/bbcode.tpl' cache='1' message="al_descr" /><br/>
			<textarea id="al_descr" cols="60" rows="11" name="al_descr">{al_array[al_descr]}</textarea> 
			<br/>
			<input type="submit" value="Enregistrer" />
			</form>
		</if>
		<label for="al_name">Nom de l'Alliance :</label><br/>
		<input type="text" id="al_name" name="al_name" value="{al_array[al_name]}" disabled="disabled"/><br />

		<if cond='isset({droits[diplo]})'>
			<form class="block" action="alliances-admin.html?sub=diplo" method="post">
			<label for="al_diplo">Diplomatie :</label><br/>
			<include file='commun/bbcode.tpl' cache='1' message="al_diplo" /><br/>
			<textarea id="al_diplo" cols="60" rows="11" name="al_diplo">{al_array[al_diplo]}</textarea> 
			<br/>
			<input type="submit" value="Enregistrer" />
			</form>
		</if>

		<if cond='isset({droits[rules]})'>
			<form class="block" action="alliances-admin.html?sub=rules" method="post">
			<label for="al_rules">Règles :</label><br/>
			<include file='commun/bbcode.tpl' cache='1' message="al_rules" /><br/>
			<textarea id="al_rules" cols="60" rows="11" name="al_rules">{al_array[al_rules]}</textarea> 
			<br/>
			<input type="submit" value="Enregistrer" />
			</form>
		</if>

		<hr />

		<h3>Actions</h3>
		<if cond='isset({droits[del]})'>
			[ <a href="alliances-admin.html?sub=del">Détruire l'Alliance</a> ]
		</if>

		<if cond='isset({droits[perm]})'>
		<h3>Membres de l'alliance</h3>
		<form action="alliances-admin.html?sub=perm" method="post">
		<table class="liste">
			<tr>
				<th>Id</th>
				<th>Pseudo</th>
				<th>Grade</th>
				<th>Actions</th>
			</tr>	 

			<foreach cond='{al_in_mbr} as {result}'>
			<tr>
				<td>{result[mbr_mid]}</td>
				<td>
					<zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/>
				</td>
				<td>
					<if cond="{result[ambr_etat]} == ALL_ETAT_NOOB">{algrp[{result[ambr_etat]}]}</if>
					<else>
					<select name="aletat[{result[mbr_mid]}]" id="aletat[{result[mbr_mid]}]">
					<foreach cond="{arr_algrp} as {grp}">
						<if cond="{result[ambr_etat]}=={grp}">
							<option value="{grp}" selected="selected">{algrp[{grp}]}</option>
						</if>
						<else>
							<option value="{grp}">{algrp[{grp}]}</option>
						</else>
					</foreach>
					</select>
					</else>
				</td>
				<td>
					<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
						<img src="img/msg.png" alt="Msg" />
					</a>
					<if cond='isset({droits[chef]}) && {_user[mid]} != {result[mbr_mid]}'>
						-
						<a href="alliances-admin.html?sub=chef&mid={result[mbr_mid]}" title="Donner le pouvoir à {result[mbr_pseudo]}">
							<img src="img/join.png" alt="Chef" />
						</a>
					</if>
					<if cond='isset({droits[kick]})'>
					- 
					<a href="alliances-admin.html?sub=kick&mid={result[mbr_mid]}" title="Bannir {result[mbr_pseudo]}">
						<img src="img/drop.png" alt="Ban" />
					</a>
					</if>
				</td>
				</tr>
			</foreach>
		</table>
		<input type="submit" value="Changer les permissions du grenier" />
		</form>
		</if>

		<if cond='isset({droits[accept]})'>
		<if cond='{al_mbr}'>
			<h3>Liste des Joueurs en Attente</h3>
				<table class="liste">
				<tr>
				<th>Id</th>
				<th>Pseudo</th>
				<th>Population</th>
				<th>Points</th>
				<th>Actions</th>
				</tr>	 
				<foreach cond='{al_mbr} as {result}'>
				<tr>
				<td>{result[mbr_mid]}</td>
				<td>
					<zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/>
				</td>
				<td>{result[mbr_population]}</td>
				<td>{result[mbr_points]}</td>
					<td>
					<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
						<img src="img/msg.png" alt="Msg" />
					</a>
					-
					<a href="alliances-admin.html?sub=accept&mid={result[mbr_mid]}" title="Accepter {result[mbr_pseudo]}">
						<img src="img/join.png" alt="Join" />
					</a>
					<if cond='isset({droits[refuse]})'>	-
					<a href="alliances-admin.html?sub=refuse&mid={result[mbr_mid]}" title="Refuser {result[mbr_pseudo]}">
						<img src="img/drop.png" alt="Refuse" />
					</a>
					</if>
				</td>
				</tr>
				</foreach>
				</table>	
		</if>
		<else><p class="infos">Aucune demande d'adhésion actuellement.</p></else>
		</if>
	</if>

	<if cond='{al_sub} == "logo"'>
		<if cond='{al_logo}'>
			<p class="ok">Ok, blason uploadé !</p>
		</if>
		<else>
			<p class="error">Taille ou type de fichier incorrect.</p>
		</else>
	</if>
</else>

<if cond='{al_sub} == "param" or {al_sub} == "rules" or {al_sub} == "diplo"'>
	<if cond='{al_param}'>
		<p class="ok">Paramètres enregistrés.</p>
	</if>
	<else>
		<p class="error">Erreur.</p>
	</else>
</if>

<if cond='{al_sub} == "accept"'>
	<if cond='isset({al_full})'>
		<p class="error">Alliance pleine.</p>
	</if>
	<elseif cond='isset({al_bad_race})'>
		<p class="ok">Impossible d'accepter quelqu'un de cette race !</p>
	</elseif>
	<elseif cond='isset({al_ok})'>
		<p class="ok">Ok, {al_pseudo} accepté !</p>
	</elseif>
	<elseif cond='isset({al_bad_mid}) OR isset({al_no_mid})'>
		<p class="error">Ce membre n'existe pas ou ne demande pas à entrer dans votre Alliance.</p>
	</elseif>
</if>

<if cond='{al_sub} == "refuse"'>
	<if cond='isset({al_ok})'>
		<p class="ok">Ok, {al_pseudo} refusé !</p>
	</if>
	<elseif cond='issset({al_bad_mid}) OR isset({al_no_mid})'>
		<p class="error">Ce membre n'existe pas ou ne demande pas à entrer dans votre Alliance.</p>
	</elseif>
</if>

<if cond='{al_sub} == "kick"'>
	<if cond='isset({need_conf})'>
		<p class="infos">Voulez-vous vraiment bannir ce membre ? <a href="alliances-admin.html?sub=kick&mid={need_conf}&conf=1">Oui</a></p>
	</if>
	<elseif cond='isset({al_ok})'>
		<p class="ok">Ok. {al_pseudo} banni !</p>
	</elseif>
	<elseif cond='isset({al_bad_mid}) OR isset({al_no_mid})'>
		<p class="error">Ce membre n'existe pas ou n'est pas dans votre Alliance.</p>
	</elseif>
</if>

<if cond='{al_sub} == "chef"'>
	<if cond='isset({al_ok})'>
		<p class="ok">Ok. {al_pseudo} dirige maintenant l'Alliance !</p>
	</if>
	<elseif cond='isset({al_bad_mid})'>
		<p class="error">Ce membre n'existe pas ou n'est pas dans votre Alliance.</p>
	</elseif>
	<elseif cond='isset({al_mbr_noob})'>
		<p class="error">Ce membre est encore trop nouveau, impossible de lui donner une telle responsabilité.</p>
	</elseif>
</if>

<if cond='{al_sub} == "del"'>
	<if cond='{al_del} === "need_ok"'>
		<p class="error">
		 Attention ! Toutes les ressources dans le Grenier seront perdues !
		</p>
		<p class="infos">Êtes-vous sûr de vouloir détruire votre alliance ?
		<form action="alliances-admin.html?sub=del" method="post">
		<input type="submit" name="ok" value="ok" />
		</form>
		</p>
	</if>
	<elseif cond='{al_del}'>
		<p class="ok">Ok. Alliance supprimée !</p>
	</elseif>
	<else>
		<p class="error">Cette alliance n'existe pas.</p>
	</else>
</if>

<if cond='{al_sub} == "perm"'>
	<if cond="{change_ok} === true">
		<p class="ok">Changements effectués :
		<foreach cond="{change_perm} as {mid} => {etat}">
			<br/><zurlmbr gid="{al_in_mbr[{mid}][mbr_gid]}" mid="{al_in_mbr[{mid}][mbr_mid]}" pseudo="{al_in_mbr[{mid}][mbr_pseudo]}"/> devient {algrp[{etat}]}
		</foreach></p>
	</if>
	<elseif cond="empty({change_perm})">
		<p class="error">Aucune modification effectuée.</p>
	</elseif>
	<else>
		<p class="error">Erreur dans les grades !
		<foreach cond="{change_perm} as {mid} => {etat}">
			<br/><zurlmbr gid="{al_in_mbr[{mid}][mbr_gid]}" mid="{al_in_mbr[{mid}][mbr_mid]}" pseudo="{al_in_mbr[{mid}][mbr_pseudo]}"/> devient {algrp[{etat}]}
		</foreach>
		</p>
		<p class="infos">Il faut respecter le nombre maximum pour les grades suivants : <if cond="isset({change_ok[chef]})">... Et surtout, un et un seul {algrp[{ALL_ETAT_CHEF}]} !</if></p>
		<ul class="infos"><foreach cond="{max_perm} as {grp} => {nb}">
			<li>
			<if cond="isset({change_ok[count][{grp}]})"><strong>{nb} {algrp[{grp}]} ({change_ok[count][{grp}]})</strong></if>
			<else>{nb} {algrp[{grp}]}</else>
			</li>
		</foreach></ul>
		
	</else>
</if>
