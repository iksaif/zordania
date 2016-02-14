<if cond='isset({need_to_be_loged})'>

</if>
<elseif cond="isset({mbr_ini})">
	<div class="error">Votre compte est déjà initialisé !</div>
</elseif>
<elseif cond="isset({mbr_not_ini})">
	<div class="error">Votre compte n'est pas encore initialisé !</div>
</elseif>
<elseif cond="isset({mbr_pseudo_exist})">
	<div class="error">Ce pseudo est déjà pris !</div>
</elseif>
<elseif cond="isset({mbr_ini_ok})">
	<div class="ok">Votre compte est initialisé, vous pouvez aller faire un tour dans votre <a href="btc-use.html" title="Aller voir le village">Village</a> !</div>
</elseif>
<else>
	<form action="ini.html" method="post">
		<if cond='{mbr_error} == "bad_vlg"'><div class="error">Aucun emplacement disponible.</div></if>
		
		<p>
			<if cond="{_user[etat]}!=MBR_ETAT_INI">
				<label for="key">Clef de validation</label>
				<input type="text" name="key" id="key" value="{mbr_key}" />
			</if>
			<if cond='{mbr_error} == "bad_key"'><div class="error">Clef incorrecte</div></if>
		</p>
		
		<if cond='{mbr_error} == "bad_pseudo"'><div class="error">Pseudo incorrect, merci de ne pas utiliser de caractères spéciaux</div></if>
		<if cond='{mbr_error} == "pseudo_unavailable"'><div class="error">Pseudo déjà utilisé</div></if>
		<if cond='{mbr_error} == "sexe_undefined"'><div class="error">Choisissez le sexe de votre personnage</div></if>
		
		<p><label for="pseudo">Nom de votre personnage :</label>
		<input name="pseudo" id="pseudo" type="text" value="{mbr_pseudo}" /><br/>
		<label for="sexe1"><input type="radio" id="sexe1" name="sexe" value="1" <if cond='{mbr_sexe}==1'>checked="checked"</if> /> Masculin</label>
		<label for="sexe2"><input type="radio" id="sexe2" name="sexe" value="2" <if cond='{mbr_sexe}==2'>checked="checked"</if> /> Féminin</label>
		</p>

		<p class="infos">Veuillez si possible utiliser un nom de personnage qui respecte l'ambiance médiévale fantastique du jeu. Par exemple "Drizzt 	Seerear" pour un Drow, "Thorik Morselame" pour Nain, "Orrusk Tourne-crâne" pour un Orc ou "Bran Rivebise" pour un Humain.</p>
		
		<if cond='{mbr_error} == "bad_vlg"'><div class="error">Nom incorrect, merci de ne pas utiliser de caractères spéciaux</div></if>
		<p><label for="vlg">Nom du village:</label>
		<input name="vlg" id="vlg" type="text" value="{mbr_vlg}" /></p>
		
		<p>
		<label for="race">Race:</label>
		<select name="race" id="race">
			<foreach cond="{_races} as {race_id} =>  {value}">
				<if cond="{mbr_race} == {race_id}">
					<option value="{race_id}" selected="selected">{race[{race_id}]}</option>
				</if>
				<else>
					<option value="{race_id}">{race[{race_id}]}</option>
				</else>
			</foreach>
		</select></p>
		
		<p><foreach cond="{_races} as {race_id} =>  {value}">
			[
			<img src="img/{race_id}/{race_id}.png" alt="{race[{race_id}]}" />
			<a href="manual.html?race={race_id}" title="Manuel des {race[{race_id}]}">{race[{race_id}]}</a>
			( <if cond="isset({infos_races[{race_id}]})">{infos_races[{race_id}][race_nb]}</if><else>0</else> )
			]
		</foreach></p>
		<div class="infos">Vous pouvez lire le manuel avant de choisir votre race !</div>

		<if cond='{mbr_error} == "reg_full"'><div class="error">Quotas atteints pour cette race dans cette région.</div></if>
		Vous devez choisir un emplacement aléatoire dans la région de votre choix, ou bien sélectionner votre emplacement directement sur la carte :
		<table><tr>
		<foreach cond="{_regions} as {region_id} => {quotas}">
			<td>
			<if cond="{region_id} == {_user[map_region]}">
				<input type="radio" name="region"  id="region{region_id}" value="{region_id}" checked /><span class="ok">Votre région actuelle :</span>
			</if>
			<else>
				<input type="radio" name="region"  id="region{region_id}" value="{region_id}" />
			</else>
			<strong><label for="region{region_id}">{regions[{region_id}][coord]}: {regions[{region_id}][name]}</label></strong>
			<br/>Quotas: 
			<foreach cond="{quotas} as {race} => {perc}">
				<if cond="isset({_races[{race}]}) and {perc}!=0"><img src="img/{race}/{race}.png" alt="{race[{race}]}" /> {perc}%
				</if>
			</foreach>
			<br/>
			Places: 
			<foreach cond="{regions_infos[libre][{region_id}]} as {race} => {nb}">
				<if cond="isset({_races[{race}]}) and {quotas[{race}]}!=0"><img src="img/{race}/{race}.png" alt="{race[{race}]}" /> {nb}
				</if>
			</foreach>
			</td>
<# nouvelle colonne sur module 2 #>
			<if cond="!({region_id} % 2)"></tr>
			<tr></if>
		</foreach>
		</tr></table>
		
		<p><a href="carte-rp.html" id="map_link" >Afficher la carte RP</a></p>

		<div id="map_rp">
			<div id="carte_lite"><img src="img/map/rp-lite/princ.png" alt="Carte Role Play" id="carte_img" /></div>

			<fieldset><legend>Position libre trouvée :</legend>
				<label for="map_x">X:</label><input type="text" name="map_x" id="map_x" size="6" />
				<label for="map_y">Y:</label><input type="text" name="map_y" id="map_y" size="6" />
				<input type="button" id="searchmbr" value="Aller"/>
				<div id="map_free"></div>
			</fieldset>
			<fieldset>
			<legend>Chercher</legend>
				<label for="map_pseudo">Pseudo:</label><input type="text" name="map_pseudo" id="map_pseudo" />
				<input type="button" id="searchpos" value="Chercher"/>
			</fieldset>

			<script type="text/javascript">
			<!-- // coordonnées du clic sur l'image
			$("#carte_img").click(function(e){
				var pos = $("#carte_img").offset();
				$("#map_x").val(parseInt(e.pageX-pos.left));
				$("#map_y").val(parseInt(e.pageY-pos.top));
			});
			// Ajoute l'autocomplétion sur l'input d'id 'map_pseudo'
			$(document).ready(function(){
				$("#map_pseudo").autocomplete({
					source: "/json--member-search.html?type=ajax", delay: 500, minLength: 2
				});
			});
			$("#map_link").click(function() {
				$("#map_rp" ).toggle('slide'); return false;
			});
			$("#map_rp" ).hide();
			$("#searchmbr").click(function (e) {
				var map_x=$("#map_x").val();
				var map_y=$("#map_y").val();
				$.getJSON('json--member-map.html?type=ajax',{'x': map_x, 'y': map_y},
					function(data) {
						// update status element
						$('#map_free').html(data);
						alert('go!'+map_x+'-'+map_y);
					}
					//error: function(xhr) {alert('Erreur! Status = ' + xhr.status);}
				);
			}); // -->
			</script>
		</div>

		<input type="submit" value="Initialiser" />
	</form>
</else>	
