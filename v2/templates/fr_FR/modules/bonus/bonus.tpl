<if cond='isset({bon_error})'>
 	<p class="error">Code Faux !</p>
</if>
<if cond='{bon_act} == "liste"'>
    <div class="infos">La quantité de ressources dépend de vos points et des cours du marché !</div>



	<form method="post" action="bonus.html">
    	<fieldset><legend>Choix de la ressource.</legend>
    	<foreach cond='{bon_list_res} as {res_id} => {res_nb}'>
    		<label>
    		<input type="radio" name="type_res" value="{res_id}" />
  		{res_nb} <zimgres type="{res_id}" race="{_user[race]}" />
  		</label>
    		<br />
	</foreach>
	<br />
	</fieldset>
	<br />
	<input type="submit" name="submit" value="Suivant >>" />
	</form>
</if>
<elseif cond='{bon_act} == "tel"'>
<script type="text/javascript">
function rwf_ouvrir_popup(rwf_code){
	var rwf_width = 300;
	var rwf_height = 377;
	var rwf_left	= ((screen.width - rwf_width) / 2);
	var rwf_url = "http://composants.rentabiliweb.com/form/popup.php?doc_id=66656&site_id=318750&skin_color=blue2&default_language=fr&default_payment_type=audiotel";
	rwf_url += "&pays_code=" + rwf_code;
	window.open(rwf_url, "MicroPaiement",
	'toolbar=0, location=0, directories=0, status=0, scrollbars=0,' +
	'resizable=1, copyhistory=0, menuBar=0, width='+rwf_width+', height='+rwf_height+','+
	'left='+rwf_left+',top=40');
}
</script>
<a href="http://www.rentabiliweb.com/?parrain=39596042880"><img src="http://data.rentabiliweb.com/i/form2007/imgs/logo.gif" alt="Rentabiliweb.com" /></a>
<div class="infos">Pour accéder à ce service payant et pour obtenir votre code, veuillez cliquer sur le drapeau de votre pays puis choisir votre mode de paiement :</div>

<a onclick="rwf_ouvrir_popup('fr')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/74.gif" alt="France" title="France" />
</a>
	<a  onclick="rwf_ouvrir_popup('dt')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/238.gif" alt="France DOM TOM" 
title="France DOM TOM" />
</a>
	<a onclick="rwf_ouvrir_popup('be')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/22.gif" alt="Belgium" title="Belgium" 
/>
</a>
	<a onclick="rwf_ouvrir_popup('ch')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/205.gif" alt="Switzerland" 
title="Switzerland" />
</a>
	<a onclick="rwf_ouvrir_popup('ca')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/38.gif" alt="Canada" title="Canada" />
</a>
	<a onclick="rwf_ouvrir_popup('lu')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/131.gif" alt="Luxembourg" 
title="Luxembourg" />
</a>
	<a onclick="rwf_ouvrir_popup('ro')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/180.gif" alt="Romania" title="Romania" 
/>
</a>
	<a onclick="rwf_ouvrir_popup('de')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/5.gif" alt="Germany" title="Germany" />
</a>
	<a onclick="rwf_ouvrir_popup('es')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/63.gif" alt="Spain" title="Spain" />
</a>
	<a onclick="rwf_ouvrir_popup('it')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/114.gif" alt="Italy" title="Italy" />
</a>
	<a onclick="rwf_ouvrir_popup('uk')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/81.gif" alt="United KingDom" 
title="United KingDom" />
</a>
	<a onclick="rwf_ouvrir_popup('at')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/16.gif" alt="Austria" title="Austria" 
/>
</a>
	<a onclick="rwf_ouvrir_popup('pl')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/171.gif" alt="Poland" title="Poland" />
</a>
	<a onclick="rwf_ouvrir_popup('nz')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/159.gif" alt="New Zealand" title="New 
Zealand" />
</a>
	<a onclick="rwf_ouvrir_popup('au')">
<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/15.gif" alt="Australia" 
title="Australia" />
</a>
	<form action="http://secure.rentabiliweb.com/micropaiement.php" method="get">
		<label for="code">
			Saisissez votre code:  
		</label>
		<input type="text" id="code" name="code" value="" />
		<br/>
		<input type="hidden" name="id" value="66656" />
		<input type="hidden" name="type_res" value="{type_res}" />
		<input type="submit" name="submit" value="Ok" />
	</form>
	<div class="infos">Attention ! Si la v1 est ouverte dans un autre onglet, veuillez le fermer, et recharger cette page.</div>
</else>
<elseif cond='{bon_act} == "donner"'>
	<if cond='isset({bon_ok})'>
 	<div class="ok">Code Ok ! Les ressources ({bon_nb_res} <zimgres type="{bon_type_res}" race="{_user[race]}" />)
 	 demandées ont été transferées dans votre Donjon.</div>
	</if>
</elseif>
