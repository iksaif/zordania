<if cond='isset({al_no_al})'>
	<p class="infos">Vous n'êtes pas dans une Alliance.</p>
	<if cond='{_user[points]} >= {ALL_MIN_ADM_PTS}'>
		<h3>Créer une Alliance</h3>
		Prix: {ALL_CREATE_PRICE} <img src="img/{_user[race]}/res/{GAME_RES_PRINC}.png" alt="{res[{_user[race]}][alt][{GAME_RES_PRINC}]}" title="{res[{_user[race]}][alt][{GAME_RES_PRINC}]}" />
		<form action="alliances-new.html" method="post">
			<label for="al_name">Nom:</label>
			<input type="text" name="al_name" id="al_name" />
			<input type="submit" value="Créer" />
		</form>
	</if>
</if>

<elseif cond='isset({al_waiting})'>
	<if cond="isset({al_array})">
	<p>Votre demande de rejoindre <a href="alliances-view.html?al_aid={al_array[al_aid]}" title="Infos sur {al_array[al_name]}">{al_array[al_name]}</a>
	 n'a pas encore été acceptée. Vous recevrez un message si vous êtes accepté.</p>
	 <a href="alliances-cancel.html" title="Annuler la demande">Annuler</a>
	 </if>
	 <else>
		<p class="infos">
		Cette alliance n'existe plus, vous devriez annuler votre demande !
		<a href="alliances-cancel.html" title="Annuler la demande">Annuler</a>
		</p>
	 </else>
</elseif>
<else>
		<if cond='{al_logo}'>
			<img class="blason" src="{al_logo}" alt="Blason" />
		</if>
		<h3>{ally[al_name]}</h3>
		Chef : <zurlmbr mid="{ally[al_mid]}" pseudo="{chef[mbr_pseudo]}"/><br/>
		Points : {ally[al_points]}
		<hr/>
		<if cond='{_user[mid]} != {ally[al_mid]}'>
		[ <a href="alliances-part.html">Quitter l'Alliance</a> ]
		</if>

	<h3>Liste des Joueurs</h3>
	<table class="liste">
	<tr>
		<th>Grade</th>
		<th>Pseudo</th>
		<th>Race</th>
		<th>Pop</th>
		<th>Points</th>
		<th>Dst</th>
		<th>Msg</th>
		<th>Forces armées</th>
	</tr>	 
	<foreach cond='{al_mbr} as {result}'>
	 <tr>
	<td><img src="img/algrp/{result[ambr_etat]}.png" title="{algrp[{result[ambr_etat]}]}" alt="{algrp[{result[ambr_etat]}]}" /></td>
	<if cond='{ally[al_mid]} == {result[mbr_mid]}'>
		<th><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></th>
	</if>
 	<else>
		<td><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></td>
 	</else>
   	<td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
 	<td>{result[mbr_population]}</td>
 	<td>{result[mbr_points]}</td>
 	<td>{result[mbr_dst]}</td>
	 	<td>
 		<if cond='{result[mbr_mid]} != {_user[mid]}'>
  	 		<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
  	 			<img src="img/msg.png" alt="Msg" />
  	 		</a>
 		</if>
 	</td>
	<td>{result[mbr_pts_armee]}
 		<if cond='{result[mbr_mid]} != {_user[mid]} && {result[mbr_etat]} == {MBR_ETAT_OK}'>
			- <a href="leg-move.html?sub=sou&cid={result[mbr_mapcid]}" title="Envoyer une légion chez {result[mbr_pseudo]}">
			<img src="img/{_user[race]}/div/def.png" alt="Envoyer légion" />
			</a>
 		</if>
	</td>
 	</tr>
	</foreach>
	</table>	
<hr />
<div class="block">
	<h3>ShootBox</h3>
	<if cond="isset({al_msg_del})">
		<p class="ok">Message supprimé !</p>
	</if>
	<if cond="isset({al_msg_post})">
		<p class="ok">Message posté !</p>
	</if>

	<form class="center" action="alliances-my.html?sub=post" method="post" id="newpost">
	<include file='commun/bbcode.tpl' cache='1' /><br/>
	<input type="hidden" id="pst_titre" name="pst_titre" value="alliance" />
	<textarea id="message" name="pst_msg" rows="5" cols="40"></textarea><br />
	<input type="submit" value="Envoyer" />
	<input type="button" id="btpreview" value="Prévisualiser" />
	[ <a href="alliances.xml?mid={_user[mid]}&key={al_key}" title="RSS de la shoot"> RSS </a> ]
	</form>

	<div id="preview"></div>

	<if cond='is_array({al_shoot_array})'>
		<for cond='{i} = {current_i} ; {i} < {al_nb} AND {i}-{current_i} < LIMIT_NB_PAGE*LIMIT_PAGE; {i}+=LIMIT_PAGE'>
			<if cond='{i} / LIMIT_PAGE != {al_page}'>
				<a href="alliances-my.html?al_page=<math oper='({i} / LIMIT_PAGE)' />"><math oper='(({i} / LIMIT_PAGE)+1)' /></a>
			</if>
			<else>
				<math oper='(({i} / LIMIT_PAGE)+1)' />
			</else>
		</for>

		<foreach cond='{al_shoot_array} as {result}'>
			<div class="block" id="{result[shoot_msgid]}">
			<img class="blason" title="{result[mbr_pseudo]}" src="img/mbr_logo/{result[shoot_mid]}.png" />
			<h4><zurlmbr mid="{result[shoot_mid]}" pseudo="{result[mbr_pseudo]}"/> le {result[shoot_date_formated]}<br/></h4>
			<p>
			{result[shoot_texte]}
			</p>
			<p class="signature">{result[mbr_sign]}</p>
			<if cond="{result[mbr_mid]} == {_user[mid]} OR {al_admin}">
				<a href="alliances-my.html?sub=del&msgid={result[shoot_msgid]}" title="Supprimer">
					<img src="img/drop.png" alt="Supprimer" title="Supprimer" />
				</a>
			</if>
			</div>
			<br />
		</foreach>
		
		<for cond='{i} = {current_i} ; {i} < {al_nb} AND {i}-{current_i} < LIMIT_NB_PAGE*LIMIT_PAGE; {i}+=LIMIT_PAGE'>
			<if cond='{i} / LIMIT_PAGE != {al_page}'>
				<a href="alliances-my.html?al_page=<math oper='({i} / LIMIT_PAGE)' />"><math oper='(({i} / LIMIT_PAGE)+1)' /></a>
			</if>
			<else>
				<math oper='(({i} / LIMIT_PAGE)+1)' />
			</else>
		 </for>
	</if>
</div>
</else>
