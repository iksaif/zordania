<if cond='{al_act} == "liste"'>
	<if cond='count({al_array})'>
		<table class="liste">
			<tr>
			<th>Nom</th>
			<th>Points</th>
			<th>Chef</th>
			<th>Race</th>
			<th>Membres</th>
			<th>Logo</th>
			<th>Actions</th>
			</tr>
		<foreach cond='{al_array} as {al_key} => {al_value}'>
		<tr>
			<td><a href="alliances-view.html?al_aid={al_value[al_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
			<td>{al_value[al_points]}</td>
			<td>
				<zurlmbr gid="{al_value[mbr_gid]}" mid="{al_value[al_mid]}" pseudo="{al_value[mbr_pseudo]}"/>
			</td>
			<td><img src="img/{al_value[mbr_race]}/{al_value[mbr_race]}.png" alt="{race[{al_value[mbr_race]}]}" title="{race[{al_value[mbr_race]}]}" /></td>
			<td>{al_value[al_nb_mbr]}</td>
			<td>
			<a href="alliances-view.html?al_aid={al_value[al_aid]}">
			<img src="img/al_logo/{al_value[al_aid]}-thumb.png" class="mini_al_logo" alt="{al_value[al_name]}" title="{al_value[al_name]}"/>
			</a>
			</td>
			<td>
				<if cond='{_user[alaid]} != {al_value[al_aid]}'>
					<a href="msg-new.html?mbr_mid={al_value[al_mid]}" title="Envoyer un message au chef de {al_value[al_name]}">
					<img src="img/msg.png" alt="Msg" />
					</a>
				</if>
				<if cond='{al_value[al_nb_mbr]} < {ALL_MAX} AND {al_value[al_open]} AND {_user[alaid]} == 0'>
					<a href="alliances-join.html?al_aid={al_value[al_aid]}">
					<img src="img/join.png" alt="Rejoindre" title="Rejoindre {al_value[al_name]}" />
					</a> - 
				</if>
				<if cond="isset({mbr_dpl[{al_value[al_aid]}]})">
					<img src="img/dpl/{mbr_dpl[{al_value[al_aid]}]}.png" title="{dpl_type[{mbr_dpl[{al_value[al_aid]}]}]}"/>
				</if>
				<elseif cond='{_user[achef]} == {_user[mid]} AND {_user[alaid]} != {al_value[al_aid]}'>
					<a href="diplo-add.html?al2={al_value[al_aid]}">
					<img src="img/join.png" alt="Pacte" title="Proposer un nouveau pacte avec {al_value[al_name]}" />
					</a>
				</elseif>
			</td>
		</tr>
		</foreach>
		</table>
	<br />Page : 
	<for cond='{i} = 0; {i} < {al_nb}; {i}+=LIMIT_PAGE'>
		<if cond='{i} / LIMIT_PAGE != {al_page}'>
			<a href="alliances.html?al_page=<math oper='({i} / LIMIT_PAGE)' /><if cond='{al_name}'>&al_name={al_name}</if>"><math oper='(({i} / LIMIT_PAGE)+1)' /></a>
		</if>
		<else>
		<math oper='(({i} / LIMIT_PAGE)+1)' />
		</else>	
	</for>
	</if>
	<else>
	<p class="infos">Aucune Alliance</p>
	</else>
	<div class="infos">Vous ne pouvez rejoindre une Alliance que si vous avez plus de {ALL_MIN_PTS} points et qu'une Alliance accepte encore des joueurs (bouton Rejoindre présent).
	<br/>
	Pour créer une Alliance il faut {ALL_MIN_ADM_PTS} points.</div>
	<hr />
	<form action="alliances.html" method="post">
		<label for="name">Nom:</label>
		<input type="text" name="name" id="name" value="{al_name}" />
		<input type="submit" value="Rechercher" />
	</form>
</if>
