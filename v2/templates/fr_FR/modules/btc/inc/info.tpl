<if cond="isset({btc_conf[defense]})">
	<hr />
	<h4>Défense</h4>
	<img src="img/{_user[race]}/btc/{btc_id}.png" alt="{btc[{_user[race]}][alt][{btc_id}]}" title="{btc[{_user[race]}][alt][{btc_id}]}" /> 
	{btc[{_user[race]}][alt][{btc_id}]}: {btc_nb}<br /> 
	<if cond="{btc_def}">
		Défense: {btc_def} * {btc_nb} = <math oper='({btc_def} * {btc_nb})' />
		<img src="img/{_user[race]}/div/def.png" alt="Bonus de Défense" title="Bonus de Défense" /><br/>
	</if>
</if>
<if cond="isset({btc_conf[prod_pop]})">
	<hr />
	<h4>Population</h4>
	<foreach cond='{btc_pop_utils} as {btc_type} => {btc_value}'>
		<img src="img/{_user[race]}/btc/{btc_type}.png" alt="{btc[{_user[race]}][alt][{btc_type}]}" title="{btc[{_user[race]}][alt][{btc_type}]}" /> 
		{btc[{_user[race]}][alt][{btc_type}]}: {btc_value[btc_nb]}
		<br />
		Par Bâtiment: {btc_value[btc_pop]} <img src="img/{_user[race]}/{_user[race]}.png" title="Place" alt="Place" /><br/>
		Total: <math oper='{btc_value[btc_pop]}*{btc_value[btc_nb]}'/> <img src="img/{_user[race]}/{_user[race]}.png" title="Place" alt="Place" /><br/>
		<br/><br/>
	</foreach>
	Limite de Population : {TOTAL_MAX_UNT}<br />
	Population : {btc_pop_used}/{btc_pop_max} <img src="img/{_user[race]}/{_user[race]}.png" alt="Place" title="Place" /><br/>
</if>
<if cond="isset({btc_bouf})">
	<hr/>
	<h4>Nourriture</h4>
	<foreach cond='{btc_bouf_utils} as {btc_type} => {btc_value}'>
		<zimgbtc type="{btc_type}" race="{_user[race]}" />
		{btc[{_user[race]}][alt][{btc_type}]}: {btc_value[btc_nb]}
		<br />
		Par Bâtiment: {btc_value[btc_res]} <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
		Production Totale: <math oper='{btc_value[btc_res]}*{btc_value[btc_nb]}'/> <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/><br/>
	</foreach>

	<if cond="!empty({leg_array})">
		<h4>Consommation des Légions</h4>
		<foreach cond="{leg_array} as {lid} => {leg}">
			<if cond="!isset({leg[res_bouf]})">
			légion {leg[leg_name]} : {leg[unt_nb]} unités, consomment <math oper="{leg[unt_nb]}" />
			<zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br />
			</if>
			<elseif cond="{leg[res_bouf]} < {leg[unt_nb]}">
			légion {leg[leg_name]} : {leg[unt_nb]} unités, consomment <math oper="{leg[unt_nb]} - {leg[res_bouf]}" />
			<zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br />
			</elseif>
		</foreach>
	</if>

	<div class="infos">Les légions en garnison prennent automatiquement de la nourriture dans le donjon
	si leur propre stock est vide.</div>
	Production du Village: {btc_bouf_total} <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
	Consommation village: {btc_pop_vlg} <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
	Consommation légions : {btc_pop_leg} <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
	
	<if cond="{btc_bouf_total} > {btc_pop_used}">
		Surplus: <img src="img/up.png" alt="Up" /> <span class="gain"><math oper="{btc_bouf_total} - {btc_pop_used}" /></span>
	</if>
	<elseif cond="{btc_bouf_total} < {btc_pop_used}">
		Déficit: <img src="img/down.png" alt="Down" /> <span class="perte"><math oper="{btc_bouf_total} - {btc_pop_used}" /></span>
	</elseif>
	<else>
		Surplus: 0
	</else>
	<zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>

</if>
<if cond="isset({btc_prod})">
	<hr/>
	<h4>Production</h4>
	<img src="img/{_user[race]}/btc/{btc_id}.png" alt="{btc[{_user[race]}][alt][{btc_id}]}" title="{btc[{_user[race]}][alt][{btc_id}]}" /> 
	{btc[{_user[race]}][alt][{btc_id}]} {btc_nb}
	<if cond="is_array({gis_array})">
		<br/><br/>
		<foreach cond="{gis_array} as {res_type} => {result}">
			<img src="img/{_user[race]}/res/{res_type}.png" alt="{res[{_user[race]}][alt][{res_type}]}" title="{res[{_user[race]}][alt][{res_type}]}" /><br/>
			{res[{_user[race]}][alt][{res_type}]} : {result[total]} <br/>
			Disponible(s) : {result[dispo]} <br/>
			Exploité(s) : {result[utils]} <br/>
			<br/>
		</foreach>
		<foreach cond="{res_prod_array} as {res_type} => {res_value}">
			<h4>
				<img src="img/{_user[race]}/res/{res_type}.png" alt="{res[{_user[race]}][alt][{res_type}]}" title="{res[{_user[race]}][alt][{res_type}]}" />
				{res[{_user[race]}][alt][{res_type}]}
			</h4>
			Production : {res_value}<br/>
			Production Totale : <math oper="{res_value} * {btc_nb} " /><br/>
			Production Journalière : <math oper="{res_value} * {btc_nb} * 24" /><br/>
			<br/>
			<if cond="isset({res_utils_array[{res_type}]})">
				Coût : 
				<foreach cond="{res_utils_array[{res_type}]} as {res_type2} => {res_value2}">
					{res_value2[prix]}
					<img src="img/{_user[race]}/res/{res_type2}.png" alt="{res[{_user[race]}][alt][{res_type2}]}" title="{res[{_user[race]}][alt][{res_type2}]}" />
				</foreach>
				<br/>
				Coût Total :
				<foreach cond="{res_utils_array[{res_type}]} as {res_type2} => {res_value2}">
					<math oper="{res_value2[prix]} * {btc_nb}" />
					<img src="img/{_user[race]}/res/{res_type2}.png" alt="{res[{_user[race]}][alt][{res_type2}]}" title="{res[{_user[race]}][alt][{res_type2}]}" />
				</foreach>
				<br/>
				Coût Journalier : 
				<foreach cond="{res_utils_array[{res_type}]} as {res_type2} => {res_value2}">
					<math oper="{res_value2[prix]} * {btc_nb} * 24" />
					<img src="img/{_user[race]}/res/{res_type2}.png" alt="{res[{_user[race]}][alt][{res_type2}]}" title="{res[{_user[race]}][alt][{res_type2}]}" />
				</foreach>
				<br/>
				Stocks: 
				<foreach cond="{res_utils_array[{res_type}]} as {res_type2} => {res_value2}">
					{res_value2[nb]}
					<img src="img/{_user[race]}/res/{res_type2}.png" alt="{res[{_user[race]}][alt][{res_type2}]}" title="{res[{_user[race]}][alt][{res_type2}]}" />
				</foreach>
				<br/>
			</if>
		</foreach>
	</if>
</if>
<if cond="!isset({btc_conf[defense]}) AND !isset({btc_conf[prod_res]}) AND !isset({btc_conf[prod_res_auto]}) AND !isset({btc_conf[prod_pop]})">
	<img src="img/{_user[race]}/btc/{btc_id}.png" alt="{btc[{_user[race]}][alt][{btc_id}]}" title="{btc[{_user[race]}][alt][{btc_id}]}" /> 
	{btc[{_user[race]}][alt][{btc_id}]} {btc_nb}<br /> 
</if>
<p>
	Manuel : 
	<a href="manual.html?race={_user[race]}&type=btc#btc_{btc_id}" title="Voir le Manuel">{btc[{_user[race]}][alt][{btc_id}]}</a>
	<if cond="isset({btc_conf[com]})">
		- <a href="manual.html?race={_user[race]}&page=7" title="Voir le Manuel">Commerce</a>
	</if>
	<if cond="isset({btc_conf[prod_unt]}) || isset({btc_conf[prod_pop]})">
		- <a href="manual.html?race={_user[race]}&page=3" title="Voir le Manuel">Unités</a>
	</if>
	<if cond="isset({btc_conf[prod_src]})">
		- <a href="manual.html?race={_user[race]}&page=4" title="Voir le Manuel">Recherches</a>
	</if>
	<if cond="isset({btc_conf[prod_res]}) || isset({btc_conf[prod_res_auto]})">
		- <a href="manual.html?race={_user[race]}&page=5" title="Voir le Manuel">Ressources</a>
	</if>
	<if cond="isset({btc_conf[defense]})">
		- <a href="manual.html?race={_user[race]}&page=8" title="Voir le Manuel">Armée</a>
	</if>
</p>
