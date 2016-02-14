<if cond='|{btc_no_src}| == true'>
	<div class="infos">Ce Bâtiment sera inactif tant que vous n'aurez pas fait la recherche suivante : <img src="img/{session_user[race]}/src/7.png" alt="{src[alt][7]}" title="{src[alt][7]}" /> {src[alt][7]}.	
	</div>
</if>
<else>
	{btc[alt][13]} : {btc_nb_ate}<br /><br/>
	Production : {btc_prod} <img src="img/{session_user[race]}/res/8.png" alt="{res[alt][8]}" title="{res[alt][8]}" /><br />
	Production Totale : <math oper='({btc_prod} * {btc_nb_ate})' /> <img src="img/{session_user[race]}/res/8.png" alt="{res[alt][8]}" title="{res[alt][8]}" /><br />
	Production Journalière : <math oper='({btc_prod} * {btc_nb_ate} * 24)' /> <img src="img/{session_user[race]}/res/8.png" alt="{res[alt][8]}" title="{res[alt][8]}" /><br />
	Stocks : 
	{btc_stock_aci}
	<img src="img/{session_user[race]}/res/8.png" alt="ressource" title="{res[alt][8]}" /><br />
	<br/>
	
	Coût : {btc_ct} <img src="img/{session_user[race]}/res/5.png" alt="ressource" title="{res[alt][5]}" />
	       {btc_ct} <img src="img/{session_user[race]}/res/6.png" alt="ressource" title="{res[alt][6]}" /><br />
	Coût Total : <math oper='({btc_ct} * {btc_nb_ate})' />  <img src="img/{session_user[race]}/res/5.png" alt="{res[alt][5]}" title="{res[alt][5]}" />
	             <math oper='({btc_ct} * {btc_nb_ate})' />  <img src="img/{session_user[race]}/res/6.png" alt="{res[alt][6]}" title="{res[alt][6]}" /><br />
	Coût Total Journalier : <math oper='({btc_ct} * {btc_nb_ate} * 24)' />   
	                                                      <img src="img/{session_user[race]}/res/5.png" alt="{res[alt][5]}" title="{res[alt][5]}" />
	        <math oper='({btc_ct} * {btc_nb_ate} * 24)' />   <img src="img/{session_user[race]}/res/6.png" alt="{res[alt][6]}" title="{res[alt][6]}" /><br />
	Stocks : {btc_stock_fer} <img src="img/{session_user[race]}/res/5.png" alt="{res[alt][5]}" title="{res[alt][5]}" />
	         {btc_stock_charb} <img src="img/{session_user[race]}/res/6.png" alt="{res[alt][6]}" title="{res[alt][6]}" /><br />
</else>