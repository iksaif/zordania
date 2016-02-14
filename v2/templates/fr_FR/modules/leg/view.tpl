<div class="block">
	<h3>{leg[leg_name]}</h3>

	<h3>Unités</h3>
	<table class="liste">
	<thead>
		<if cond='{leg[leg_etat]} != {LEG_ETAT_VLG}'><th>suppr.</th></if>
		<th>Type</th>
		<th>Nombre</th>
		<th>Attaque</th>
		<th>Défense</th>
	</thead>
	<tbody>
	<foreach cond="{unt_leg[{leg[leg_id]}]} as {type} => {nb}">
		<tr>

	<if cond="{leg[leg_etat]} != {LEG_ETAT_VLG}">
		<td>
		<if cond="{leg[leg_cid]} == {_user[mapcid]} && ({leg[leg_etat]} == {LEG_ETAT_GRN})">
			<if cond="{type} == {_user[hro_type]}">
				<a href="leg-hero.html?sub=move_hero&to=vlg"><img src="img/drop.png" alt="Rentrer au village" /></a>
			</if>
			<else>
				<a href="leg-view.html?lid={leg[leg_id]}&amp;type={type}&amp;sub=del"><img src="img/drop.png" alt="Rentrer au village" /></a>
			</else>
		</if>
		</td>
	</if>

			<td><zimgunt race="{_user[race]}" type="{type}" /> {unt[{_user[race]}][alt][{type}]}</td>
			<td>{nb}</td>

	<if cond="isset({unt_conf[{type}][def]})">
		<td>
			<math oper="{nb} * {unt_conf[{type}][atq_unt]}" /> <img src="img/{_user[race]}/div/atq.png" alt="Attaque Unité" />
			<if cond="isset({unt_conf[{type}][atq_btc]})">
			- <math oper="{nb} * {unt_conf[{type}][atq_btc]}" /> <img src="img/{_user[race]}/div/atq_btc.png" alt="Attaque Bâtiment" />
			</if>
		</td>
		<td>
			<math oper="{nb} * {unt_conf[{type}][def]}" /> <img src="img/{_user[race]}/div/def.png" alt="Défense" />
		</td>
	</if>
	<else>
			<td>x</td><td>x</td>
	</else>

		</tr>
	</foreach>
	</tbody>
	<tfoot>
		<th>Total</th>
		<if cond='{leg[leg_etat]} != {LEG_ETAT_VLG}'><th>&nbsp;</th></if>
		<th>{unt_stats[unt_nb]}</th>
		<th>{unt_stats[atq_unt]} <img src="img/{_user[race]}/div/atq.png" alt="Attaque Unité" />
		- {unt_stats[atq_btc]} <img src="img/{_user[race]}/div/atq_btc.png" alt="Attaque Bâtiment" /></th>
		<th>{unt_stats[def]} <img src="img/{_user[race]}/div/def.png" alt="Défense" /></th>
	</tfoot>
	</table>
	
	<if cond='{leg[leg_etat]} != {LEG_ETAT_VLG}'>
		<p>
		<img src="img/{_user[race]}/div/atq.png" alt="Attaque Unité" /> <strong>Attaque :</strong>
		{unt_stats[atq_unt]}
			<if cond="{unt_bonus[atq]} != 0">+ {unt_bonus[atq]} % (unités)</if>
			<if cond="isset({unt_bonus[cpt][atq]})">+ {unt_bonus[cpt][atq]} % <zimgcomp type="{_user[bonus]}" race="{_user[race]}" /></if>
			= {unt_total[atq_unt]}
		<br/>
		<img src="img/{_user[race]}/div/atq_btc.png" alt="Attaque Bâtiment" /> <strong>Attaque bâtiments :</strong>
		{unt_stats[atq_btc]}
			<if cond="{unt_bonus[atq]} != 0">+ {unt_bonus[atq]} % (unités)</if>
			<if cond="isset({unt_bonus[cpt][btc]})">+ {unt_bonus[cpt][btc]} % <zimgcomp type="{_user[bonus]}" race="{_user[race]}" /></if>
			= {unt_total[atq_btc]}
		<br/>
		<img src="img/{_user[race]}/div/def.png" alt="Défense" /> <strong>Défense :</strong>
		{unt_stats[def]}
			<if cond="{unt_bonus[def]} != 0">+ {unt_bonus[def]} % (unités)</if>
			<if cond="isset({unt_bonus[cpt][def]})">+ {unt_bonus[cpt][def]} % <zimgcomp type="{_user[bonus]}" race="{_user[race]}" /></if>
			+ {unt_bonus[btc]} % (bâtiments) = {unt_total[def]}
		<br/>
		<img src="img/{_user[race]}/div/vie.png" alt="Vie" /> <strong>Vie :</strong> {unt_total[vie]} 
		<if cond="{unt_bonus[vie]} != 0"><img src="img/{_user[race]}/div/tir.png" alt="Vie" /> <strong>Tir :</strong> protection de {unt_bonus[vie]} %</if>
		<br />
		<strong>Vitesse :</strong> {unt_stats[vit]}
		<if cond="isset({unt_bonus[cpt][vit]})"> avec {unt_bonus[cpt][vit]} % <zimgcomp type="{_user[bonus]}" race="{_user[race]}" /></if>
		<br/>
		<strong>Etat :</strong> {leg_etat[{leg[leg_etat]}]}
		<br/>
		<strong>Position :</strong> <a href="carte.html?map_cid={leg[leg_cid]}" title="Afficher la position">Voir</a>
		<set name="result" value="{pos_array}" />
		<include file="modules/carte/tile.tpl" cache="1" /> 
	</if>
	<if cond='{leg[leg_etat]} == {LEG_ETAT_DPL}'>
		Destination : <a href="carte.html?map_cid={leg[leg_dest]}" title="Afficher la position">Voir</a>
		<set name="result" value="{dst_array}" />
		<include file="modules/carte/tile.tpl" cache="1" />
	</if>

	<if cond='{leg[leg_etat]} != {LEG_ETAT_VLG}'>
		<h3>Ressources</h3>
		<if cond="isset({lres_ok})"><div class="ok">Ressources modifiées !</div></if>

		<p>Nourriture : <if cond="isset({res_array[{GAME_RES_BOUF}]})">{res_array[{GAME_RES_BOUF}]}</if><else>0</else> <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
		Consommation: {unt_stats[unt_nb]} <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
		Consommation Journalière: <math oper="{unt_stats[unt_nb]} * 24" /> <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /></p>

		<if cond="{leg[leg_cid]} == {_user[mapcid]} && {leg[leg_etat]} != {LEG_ETAT_VLG}">
			<form method="post" action="leg-view.html?sub=res&amp;lid={leg[leg_id]}">
				<fieldset>
					<legend>Nourriture</legend>
					<input type="hidden" name="res_type" value="{GAME_RES_BOUF}" />
					<select name="factor">
						<option value="1">Envoyer</option>
						<option value="-1">Récupérer</option>
					</select>
					<input type="text" name="res_nb" />
					<input type="submit" value="Ok" />
				</fieldset>
			</form>
		</if>

		<table class="liste">
			<thead>
				<th>Type</th>
				<th>Nombre</th>
			</thead>
			<tbody>
				<foreach cond="{res_array} as {res} => {nb}">
				<if cond="{nb}">
				<tr>
					<td><zimgres type="{res}" race="{_user[race]}" /> {res[{_user[race]}][alt][{res}]} </td>
					<td> {nb} </td>
				</tr>
				</if>
				</foreach>
			</tbody>
		</table>
	</if>

	<include file="modules/leg/act.tpl" cache="1" thisetat="{leg[leg_etat]}" />
</div>
