<if cond='{mbr_act} == "liste"'>
<if cond='is_array({mbr_array})'>
	<script>
	<!--
	function change_sort_form(value){
		$('#by').val(value);
		if(value != '{mbr_by}'){
			$('#order').val('1');
		}
		else{
			if({mbr_order} == 1){
				$('#order').val('2');
			}
			else{
				$('#order').val('1');
			}
		}
		$('#form_sort').submit();
	}

	// Ajoute l'autocomplétion sur l'input d'id 'pseudo'
	$(document).ready(function(){
		$("#pseudo").autocomplete({
			source: "/json--member-search.html?type=ajax"
		});
	});
	-->
	</script>
	
	<set name="sort_img" value="<img style='vertical-align:top;' " />
	<if cond='{mbr_order} == "1"'>
		<set name="sort_img" value="{sort_img}src='img/sort-up.gif' alt='^' title='croissant'" />
	</if>
	<if cond='{mbr_order} == "2"'>
		<set name="sort_img" value="{sort_img}src='img/sort-down.gif' alt='v' title='décroissant'" />
	</if>
	<set name="sort_img" value="{sort_img} />" />

	<h3>Liste des Joueurs</h3>
	<table class="liste">
	<tr>
		<th class="sortable" onclick="change_sort_form('pseudo');">
			Pseudo<if cond='{mbr_by} == "pseudo"'> {sort_img}</if>
		</th>
		<th>
			Race
		</th>
		<th class="sortable" onclick="change_sort_form('population');">
			Population<if cond='{mbr_by} == "population"'> {sort_img}</if>
		</th>
		<th class="sortable" onclick="change_sort_form('points');">
			Points<if cond='{mbr_by} == "points"'> {sort_img}</if>
		</th>
		<th class="sortable" onclick="change_sort_form('dst');">
			Distance<if cond='{mbr_by} == "dst"'> {sort_img}</if>
		</th>
		<th class="sortable" onclick="change_sort_form('alliance_name');">
			Al<if cond='{mbr_by} == "alliance_name"'> {sort_img}</if>
		</th>
		<th>
			Msg
		</th>
		<th class="sortable" onclick="change_sort_form('pts_armee');">
		Forces armées<if cond='{mbr_by} == "pts_armee"'> {sort_img}</if>
		</th>
	</tr>

	<foreach cond='{mbr_array} as {result}'>
	<if cond='{result[mbr_pseudo]} != "guest"'>
	<tr<if cond='{_user[alaid]} == {result[ambr_aid]} AND {_user[alaid]} > 0'> class="allie"</if>>
		<td>
			<zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/>
		</td>
		<td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
		<td>{result[mbr_population]}</td>
		<td>{result[mbr_points]}</td>
		<td>{result[mbr_dst]}</td>
		<td>
			<if cond='{result[ambr_aid]} > 0'>
			<a href="alliances-view.html?al_aid={result[ambr_aid]}">
				<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
			</a>
			</if>
			<else>&nbsp;</else>
		</td>
		<td>
			<if cond='{result[mbr_mid]} != {_user[mid]}'>
			<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
			</if>
		</td>
		<td>
			{result[mbr_pts_armee]}
			<if cond="isset({mbr_dpl[{result[ambr_aid]}]})">
				<img src="img/dpl/{mbr_dpl[{result[ambr_aid]}]}.png" title="{dpl_type[{mbr_dpl[{result[ambr_aid]}]}]}"/>
			</if>
			<if cond='{result[mbr_mid]} != {_user[mid]}'>
				<if cond='{result[can_def]}'> - 
					<a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Soutenir {result[mbr_pseudo]}"><img src="img/{_user[race]}/div/def.png" /></a>
				</if>
				<elseif cond='{result[can_atq]}'> - 
					<a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}"><img src="img/{_user[race]}/div/atq.png" /></a>
				</elseif>
			</if>
		</td>
	</tr>
	</if>
	</foreach>
	</table>

	<br />Page :
	<for cond='{i} = {current_i} ; {i} < {mbr_nb} AND {i}-{current_i} < {limite_nb_page}*{limite_page}; {i}+={limite_page}'>
		<if cond='{i} / {limite_page} != {mbr_page}'>
			<a href="member-liste.html?mbr_page=<math oper='({i} / {limite_page})' />&amp;order={mbr_order}&amp;by={mbr_by}
			<if cond="{mbr_race}">&amp;race={mbr_race}</if>
			<if cond="{mbr_pseudo}">&amp;pseudo={mbr_pseudo}</if>
			<if cond="{mbr_diffpoint}">&amp;diffpoint={mbr_diffpoint}</if>
			<if cond="{mbr_diffpts_arm}">&amp;diffpts_arm={mbr_diffpts_arm}</if>
			"><math oper='(({i} / {limite_page})+1)' /></a>
		</if>
		<else>
			<math oper='(({i} / {limite_page})+1)' />
		</else>
	</for>
	<hr />
	<form id="form_sort" action="member-liste.html#actbar" method="post">
		<p class="infos">limite pour partir au combat : {ATQ_PTS_MIN}. Limite de points = {ATQ_PTS_DIFF}. L'arène est à {ATQ_LIM_DIFF} points.</p>
		<fieldset>
			<legend>Options</legend>
			<p><label for="pseudo">Pseudo: </label><input type="text" value="{mbr_pseudo}" id="pseudo" name="pseudo" /></p>
			<p><label for="diffpoint">Différence de points: </label><input type="text" value="{mbr_diffpoint}" id="diffpoint" name="diffpoint" /></p>
			<p><label for="diffpts_arm">Différence de force armées: </label><input type="text" value="{mbr_diffpts_arm}" id="diffpts_arm" name="diffpts_arm" /></p>
			<p><label for="race">Race:</label>
			<select name="race" id="race">
				<option value="">Toutes</option>
				<foreach cond="{_races} as {race_id} => {visible}">
					<if cond="{visible}">
					<if cond="{mbr_race} == {race_id}">
						<option value="{race_id}" selected="selected">{race[{race_id}]}</option>
					</if>
					<else>
						<option value="{race_id}">{race[{race_id}]}</option>
					</else>
					</if>
				</foreach>
			</select>	
			</p>
			<p>
			<label for="by">Trier par:</label>
			<select name="by" id="by">
				<option value="dst" <if cond='{mbr_by} == "dst"'> selected="selected"</if>  >Distance</option>  
				<option value="pseudo" <if cond='{mbr_by} == "pseudo"'> selected="selected"</if>  >Pseudo</option>  
				<option value="population" <if cond='{mbr_by} == "population"'> selected="selected"</if> >Population</option>
				<option value="points" <if cond='{mbr_by} == "points"'> selected="selected"</if> >Points</option>
				<option value="pts_armee" <if cond='{mbr_by} == "pts_armee"'> selected="selected"</if> >Force armée</option>
				<option value="alliance_name" <if cond='{mbr_by} == "alliance_name"'> selected="selected"</if> >Alliance</option>
			</select>
		       </p>
			
		       <p>
		       <label for="order">Ordre :</label>
			<select name="order" id="order">
				<option value="1" <if cond='{mbr_order} == "1"'> selected="selected"</if>>Ascendant</option>
				<option value="2" <if cond='{mbr_order} == "2"'> selected="selected"</if>>Descendant</option>
			</select>
			</p>
		</fieldset>
		<input type="submit" value="Trier" />
	</form>
		
</if>
</if>
<if cond='{mbr_act} == "liste_online"'>
<if cond='is_array({mbr_array})'>
	<table class="liste">
	<tr>
		<th>Pseudo</th>
		<th>Race</th>
		<th>Alliance</th>
		<th>Population</th>
		<th>Points</th>
		<th>Page</th>
		<th>Date</th>
		<th>Actions</th>
	</tr>

	<foreach cond='{mbr_array} as {result}'>
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
		<td>{result[mbr_points]}</td>
		<td>{pages[{result[ses_lact]}]}</td>
		<td>{result[ses_ldate]}</td>
		<td>
			<if cond='{result[mbr_mid]} != {_user[mid]}'>
				<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}"><img src="img/msg.png" /></a>
				<if cond="isset({mbr_dpl[{result[ambr_aid]}]})">
					<img src="img/dpl/{mbr_dpl[{result[ambr_aid]}]}.png" title="{dpl_type[{mbr_dpl[{result[ambr_aid]}]}]}"/>
				</if>
				<if cond='{result[can_def]}'> - 
					<a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Soutenir {result[mbr_pseudo]}">
					<img src="img/{_user[race]}/div/def.png" />
					</a>
				</if>
				<elseif cond='{result[can_atq]}'> - 
					<a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}">
					<img src="img/{_user[race]}/div/atq.png" />
					</a>
				</elseif>
			</if>
		</td>
	</tr>
	</foreach>
	</table>
	Page : 
	<for cond='{i} = 0; {i} < {mbr_nb}; {i}+={limite_page}'>
		<if cond='{i} / {limite_page} != {mbr_page}'>
		<a href="member-liste_online.html?mbr_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
		</if>
		<else>
			<math oper='(({i} / {limite_page})+1)' />
		</else>
	</for>
	</if>
</if>
