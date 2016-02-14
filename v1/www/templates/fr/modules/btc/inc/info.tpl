 <if cond="!|{btc_act}|">
 	<if cond="{btc_conf[btcopt][def]}">
 		<hr />
 		<h3>Défense</h3>
 		<img src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[{session_user[race]}][alt][{btc_id}]}" title="{btc[{session_user[race]}][alt][{btc_id}]}" /> 
		{btc[{session_user[race]}][alt][{btc_id}]}: {btc_nb}<br /> 
		<if cond="{btc_def}">
			Défense: {btc_def} * {btc_nb} = <math oper='({btc_def} * {btc_nb})' />
			<img src="img/{session_user[race]}/div/def.png" alt="Défense" title="Défense" /><br/>
		</if>
		<if cond="{btc_bonusdef}">
			Bonus de défense: {btc_bonusdef} * {btc_nb} = <math oper='({btc_bonusdef} * {btc_nb})' />
			<img src="img/{session_user[race]}/div/def.png" alt="Bonus de Défense" title="Bonus de Défense" /><br/>
		</if>
	</if>
	<if cond="{btc_conf[btcopt][pop]}">
		<hr />
		<h3>Population</h3>
		<foreach cond='|{btc_pop_utils}| as |{btc_type}| => |{btc_value}|'>
			<img src="img/{session_user[race]}/btc/{btc_type}.png" alt="{btc[{session_user[race]}][alt][{btc_type}]}" title="{btc[{session_user[race]}][alt][{btc_type}]}" /> 
				{btc[{session_user[race]}][alt][{btc_type}]}: {btc_value[btc_nb]}
			<br />
			Par Bâtiment: {btc_value[btc_pop]} <img src="img/{session_user[race]}/res/{GAME_RES_PLACE}.png" title="{res[{session_user[race]}][alt][{GAME_RES_PLACE}]}" alt="{res[{session_user[race]}][alt][{GAME_RES_PLACE}]}" /><br/>
			Total: <math oper='{btc_value[btc_pop]}*{btc_value[btc_nb]}'/> <img src="img/{session_user[race]}/res/{GAME_RES_PLACE}.png" title="{res[{session_user[race]}][alt][{GAME_RES_PLACE}]}" alt="{res[{session_user[race]}][alt][{GAME_RES_PLACE}]}" /><br/>
			<br/><br/>
		</foreach>
		Limite de Population : {GAME_MAX_UNT_TOTAL}<br />
		Population : {btc_pop_used}/{btc_pop_max} <img src="img/{session_user[race]}/res/{GAME_RES_PLACE}.png" alt="{res[{session_user[race]}][alt][{GAME_RES_PLACE}]}" title="{res[{session_user[race]}][alt][{GAME_RES_PLACE}]}" /><br/>
	</if>
	<if cond="|{btc_conf[produit][{GAME_RES_BOUF}]}|">
		<hr/>
		<h3>Nourriture</h3>
		<foreach cond='|{btc_bouf_utils}| as |{btc_type}| => |{btc_value}|'>
			<img src="img/{session_user[race]}/btc/{btc_type}.png" alt="{btc[{session_user[race]}][alt][{btc_type}]}" title="{btc[{session_user[race]}][alt][{btc_type}]}" /> 
				{btc[{session_user[race]}][alt][{btc_type}]}: {btc_value[btc_nb]}
			<br />
			Par Bâtiment: {btc_value[btc_res]} <img src="img/{session_user[race]}/res/{GAME_RES_BOUF}.png" title="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" alt="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" /><br/>			
			Production totale: <math oper='{btc_value[btc_res]}*{btc_value[btc_nb]}'/> <img src="img/{session_user[race]}/res/{GAME_RES_BOUF}.png" title="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" alt="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" /><br/><br/>
			
			Production du Village: {btc_bouf_total} <img src="img/{session_user[race]}/res/{GAME_RES_BOUF}.png" title="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" alt="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" /><br/>
			
			Consommation: {btc_pop_used}  <img src="img/{session_user[race]}/res/{GAME_RES_BOUF}.png" title="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" alt="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" /><br/>
			
			<set name="btc_bouf_diff" value="<math oper='{btc_bouf_total}- {btc_pop_used}'/>"/>
			 <if cond="|{btc_bouf_diff}| > 0">Surplus: <img src="img/up.png" alt="Up" /> <span class="gain"></if>
			 <if cond="|{btc_bouf_diff}| == 0">Surplus: <span></if>
			 <if cond="|{btc_bouf_diff}| < 0">Déficit: <img src="img/down.png" alt="Down" /> <span class="perte"></if>
			 {btc_bouf_diff}
			 </span>
			 <img src="img/{session_user[race]}/res/{GAME_RES_BOUF}.png" title="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" alt="{res[{session_user[race]}][alt][{GAME_RES_BOUF}]}" /><br/>
			<br/><br/>
		</foreach>
			
		
	</if>
	<if cond="|{btc_conf[btcopt][prod]}| OR (|{btc_conf[produit][{GAME_RES_BOUF}]}| AND count(|{btc_conf[produit]}|) > 1)">
		<hr/>
		<h3>Production</h3>
		<img src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[{session_user[race]}][alt][{btc_id}]}" title="{btc[{session_user[race]}][alt][{btc_id}]}" /> 
		{btc[{session_user[race]}][alt][{btc_id}]} {btc_nb}
		<if cond="is_array(|{gis_array}|)">
		<br/><br/>
		<foreach cond="|{gis_array}| as |{res_type}| => |{result}|">
			<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[{session_user[race]}][alt][{res_type}]}" title="{res[{session_user[race]}][alt][{res_type}]}" />
 			<br/>
 			{res[{session_user[race]}][alt][{res_type}]} : {result[total]} <br/>
 			Disponible(s) : {result[dispo]} <br/>
 			Exploitée(s) : {result[utils]} <br/>
 			<br/>
 		</foreach>
 		<foreach cond="|{res_prod_array}| as |{res_type}| => |{res_value}|">
 			<h4>
 			<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[{session_user[race]}][alt][{res_type}]}" title="{res[{session_user[race]}][alt][{res_type}]}" />
 			{res[{session_user[race]}][alt][{res_type}]}
 			</h4>
 			Production : {res_value}<br/>
 			Production Totale : <math oper="{res_value} * {btc_nb} " /><br/>
  			Production Journalière : <math oper="{res_value} * {btc_nb} * 24" /><br/>
  			<br/>
  			<if cond="is_array(|{res_utils_array[{res_type}]}|)">
  			Coût : 
  			<foreach cond="|{res_utils_array[{res_type}]}| as |{res_type2}| => |{res_value2}|">
  				{res_value2[prix]}
  				 <img src="img/{session_user[race]}/res/{res_type2}.png" alt="{res[{session_user[race]}][alt][{res_type2}]}" title="{res[{session_user[race]}][alt][{res_type2}]}" />
  			</foreach>
  			<br/>
  			Coût Total :
  			<foreach cond="|{res_utils_array[{res_type}]}| as |{res_type2}| => |{res_value2}|">
  				<math oper="{res_value2[prix]} * {btc_nb}" />
  				 <img src="img/{session_user[race]}/res/{res_type2}.png" alt="{res[{session_user[race]}][alt][{res_type2}]}" title="{res[{session_user[race]}][alt][{res_type2}]}" />
  			</foreach>
  			 <br/>
  			Coût Journalier : 
  			<foreach cond="|{res_utils_array[{res_type}]}| as |{res_type2}| => |{res_value2}|">
  				<math oper="{res_value2[prix]} * {btc_nb} * 24" />
  				 <img src="img/{session_user[race]}/res/{res_type2}.png" alt="{res[{session_user[race]}][alt][{res_type2}]}" title="{res[{session_user[race]}][alt][{res_type2}]}" />
  			</foreach>
  			 <br/>
  			Stocks: 
  			<foreach cond="|{res_utils_array[{res_type}]}| as |{res_type2}| => |{res_value2}|">
  				{res_value2[nb]}
  				 <img src="img/{session_user[race]}/res/{res_type2}.png" alt="{res[{session_user[race]}][alt][{res_type2}]}" title="{res[{session_user[race]}][alt][{res_type2}]}" />
  			</foreach>
  			 <br/>
  			</if>
 		</foreach>
 		</if>
	</if>
	<if cond="!|{btc_conf[btcopt][def]}| AND !|{btc_conf[btcopt][prod]}| AND !|{btc_conf[btcopt][pop]}|">
		<img src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[{session_user[race]}][alt][{btc_id}]}" title="{btc[{session_user[race]}][alt][{btc_id}]}" /> 
		{btc[{session_user[race]}][alt][{btc_id}]} {btc_nb}<br /> 
		<a href="index.php?file=manual&amp;race={session_user[race]}&type=btc#btc_{btc_id}" title="Voir le Manuel">Manuel</a>
	</if>
</if>