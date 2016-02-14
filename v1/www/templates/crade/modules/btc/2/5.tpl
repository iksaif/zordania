{btc[alt][5]} : {btc_nb_ferme}<br />
{btc[alt][17]} : {btc_nb_ferme_plus}<br />
<br/>
Production : {btc_prod} <img src="img/{session_user[race]}/res/4.png" alt="{res[alt][4]}" title="{res[alt][4]}" /><br />
Consommation : {btc_pop_used}<br />
<if cond='|{btc_pop_used}| < |{btc_prod}|'>
 Surplus : <math oper='(-{btc_pop_used} + {btc_prod})' />
</if>
<elseif cond='|{btc_pop_used}| > |{btc_prod}|'>
 Déficit :  <math oper='({btc_pop_used} - {btc_prod})' />
</elseif>
<br/><br/>
Stocks de {res[alt][4]} : {btc_prod_stock} <br />
Population : {btc_pop_total}/{btc_pop} <img src="img/{session_user[race]}/res/20.png" alt="{res[alt][20]}" title="{res[alt][20]}" />