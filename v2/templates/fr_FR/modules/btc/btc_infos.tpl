<dt>
	<zimgbtc type="{btc_id}" race="{_user[race]}" /> 
	{btc[{_user[race]}][alt][{btc_id}]}
</dt>
<dd>
	<if cond='!isset({btc_array[bad]}) and (!isset({btc_todo}) or count({btc_todo}) < TODO_MAX_BTC)'>
		<img src="img/construire.png" alt="Construire" />
		<a href="btc-btc.html?sub=btc&amp;type={btc_id}">Construire</a>
		<br/>
	</if>

	<if cond="isset({btc_array[conf][defense]})">
		<br />Défense: 
		<if cond="isset({btc_array[conf][defense][def]})">
			{btc_array[conf][defense][def]} <img src="img/{_user[race]}/div/def.png" alt="Défense" />
		</if>
		<if cond="isset({btc_array[conf][defense][bonus]})">
			{btc_array[conf][defense][bonus]}% <img src="img/{_user[race]}/div/def.png" alt="Bonus" />
		</if>
	</if>
	
	<br />Temps : <if cond="{btc_trav}"><math oper='ceil({btc_array[conf][tours]} / {btc_trav})' /></if><else>{btc_array[conf][tours]}</else> Tour(s)
	
	<if cond='isset({btc_array[conf][prix_res]})'>
	<br />Prix :
		<foreach cond='{btc_array[conf][prix_res]} as {res_type} => {res_nb}'>
			<if cond="isset({btc_array[bad][prix_res][{res_type}]})"><span class="bad"></if>
			{res_nb}<zimgres race="{_user[race]}" type="{res_type}" />
			<if cond="isset({btc_array[bad][prix_res][{res_type}]})"></span></if>
		</foreach>
	</if>
	
	<if cond='isset({btc_array[conf][prix_trn]})'>
	<br />Terrain :
		<foreach cond='{btc_array[conf][prix_trn]} as {trn_type} => {trn_nb}'>
			<if cond="isset({btc_array[bad][prix_trn][{trn_type}]})"><span class="bad"></if>
			{trn_nb}<zimgtrn race="{_user[race]}" type="{trn_type}" />
			<if cond="isset({btc_array[bad][prix_trn][{trn_type}]})"></span></if>
		</foreach>
	</if>
	
	<if cond='isset({btc_array[conf][prix_unt]})'>
	<br />Unités Nécessaires:
		<foreach cond='{btc_array[conf][prix_unt]} as {unt_type} => {unt_nb}'>
			<if cond="isset({btc_array[bad][prix_unt][{unt_type}]})"><span class="bad"></if>
			{unt_nb}<zimgunt race="{_user[race]}" type="{unt_type}" />
			<if cond="isset({btc_array[bad][prix_unt][{unt_type}]})"></span></if>
		</foreach>	 
	</if>
	
	<if cond='isset({btc_array[conf][prod_pop]})'>
		<br/>Place : {btc_array[conf][prod_pop]} <img src="img/{_user[race]}/{_user[race]}.png" alt="Population" />
	</if>

	<br />
	Construits : 
	<if cond='isset({btc_array[conf][limite]})'>
	    <if cond="{btc_array[conf][limite]} == {btc_array[btc_nb]}">
	    	<span class="bad">{btc_array[btc_nb]}</span>
   	    </if>
	    <else>
		{btc_array[btc_nb]}
	    </else>
	    / {btc_array[conf][limite]}
	</if>
	<else>{btc_array[btc_nb]}</else>
	<if cond="isset({btc_array[btc_todo]})"><strong> dont {btc_array[btc_todo]} en construction</strong></if>
	<br/><br/>
	{btc[{_user[race]}][descr][{btc_id}]}
	
</dd>
