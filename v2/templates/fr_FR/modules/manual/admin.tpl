<p class="menu_module">
	[ <a href="admin.html?module=manual&amp;race={man_race}&amp;cfg=unt">config</a> ]
	[ <a href="admin.html?module=manual&amp;race={man_race}">tests</a> ]
	[ <a href="admin-edit.html?module=tpl&amp;tpl=fr_FR/race/{man_race}.config" title="Editer les noms">noms</a> ]
	[ <a href="admin-edit.html?module=tpl&amp;tpl=fr_FR/race/{man_race}.descr.config" title="Editer les descriptions">descriptions</a> ]
</p>

<if cond="{man_race} && isset({man_load})">
	<load file="race/{man_race}.config" />
	<load file="race/{man_race}.descr.config" />
</if>


<if cond="isset({cfg})">

	<p class="menu_module">
		[ <a href="admin.html?module=manual&amp;race={man_race}&amp;cfg=unt">unités</a> ]
		[ <a href="admin.html?module=manual&amp;race={man_race}&amp;cfg=btc">bâtiments</a> ]
		[ <a href="admin.html?module=manual&amp;race={man_race}&amp;cfg=src">recherches</a> ]
		<!-- [ <a href="admin.html?module=manual&amp;race={man_race}&amp;cfg=trn">terrains</a> ] -->
		[ <a href="admin.html?module=manual&amp;race={man_race}&amp;cfg=res">ressources</a> ]
		[ <a href="admin.html?module=manual&amp;race={man_race}&amp;cfg=comp">compétences</a> ]
	</p>

	<form method="post" action="admin.html?module=manual&amp;race={man_race}" class="infos">
		Un fichier (maximum) par jour : [race].[mid].[jj-mm-aaaa].php<br/>
	Choisir la config à <strong>modifier</strong> ou <strong>installer</strong> la config sélectionnée ou copier comme <strong>nouveau</strong> fichier.
		<select name="selfichier" id="selfichier">
			<foreach cond="{pg_conf} as {file}">
				<if cond="{file}=={selfichier}"><option value="{file}" selected="selected">{file}</option></if>
				<else><option value="{file}">{file}</option></else>
			</foreach>
		</select>
		<input type="submit" value="Modifier" name="mod" />
		<input type="submit" value="Installer" name="set" />
		<input type="submit" value="Copier" name="copy" />
		<br/>
		Fichier sélectionné = <strong>{selfichier}</strong>.
	</form>

	<if cond="isset({msg_update})"><p class="infos">{msg_update}</p></if>

<script type="text/javascript">
	var cst = new Array;
	// écriture des CONSTANTES PHP dans un tableau JAVASCRIPT
	<foreach cond="{const} as {key} => {value}">
	cst['{key}'] = new Array();<foreach cond="{value} as {key1} => {value1}">
		cst['{key}']['{value1}'] = '{key1}';</foreach>
	</foreach>

	var alt = new Array;
	// écriture des descriptions dans un tableau JAVASCRIPT
	<foreach cond="{const} as {key} => {value}">
	alt['{key}'] = {
		<foreach cond="{value} as {key1} => {value1}">
		"{value1}" : <if cond='{key}=="U"'>
<if cond="isset({unt[{man_race}][alt][{value1}]})"> "{unt[{man_race}][alt][{value1}]}"</if>
<else> "UNITE {value1}"</else>
		</if>
		<elseif cond='{key}=="R"'>
<if cond="isset({res[{man_race}][alt][{value1}]})"> "{res[{man_race}][alt][{value1}]}"</if>
<else> "RESSOURCE {value1}"</else>
		</elseif>
		<elseif cond='{key}=="B"'>
<if cond="isset({btc[{man_race}][alt][{value1}]})"> "{btc[{man_race}][alt][{value1}]}"</if>
<else> "BATIMENT {value1}"</else>
		</elseif>
		<elseif cond='{key}=="S"'>
<if cond="isset({src[{man_race}][alt][{value1}]})"> "{src[{man_race}][alt][{value1}]}"</if>
<else> "RECHERCHE {value1}"</else>
		</elseif>
		<elseif cond='{key}=="T"'> "{trn[{man_race}][alt][{value1}]}"</elseif>
		<elseif cond='{key}=="TYPE_UNT"'> "{roles[{value1}]}"</elseif>
		<elseif cond='{key}=="CP"'>
<if cond="isset({comp[{man_race}][alt][{value1}]})">"{comp[{man_race}][alt][{value1}]}"</if>
<else> "COMPETENCE {value1}"</else>
		</elseif>
		<else>'{key}'</else>,</foreach>
	};</foreach>

	function fillselect(select, selectValues)
	{
		$.each(selectValues, function(key, value) {
			$(select)
				.append($('<option>', { value : key })
				.text(value));
		});
	}

	$(document).ready(  function()
	{
		$('select.listU').each(function(index){
			fillselect($(this), alt['U']);
			$(this).val( $(this).attr('init'));
		});
		$('select.listR').each(function(index){
			fillselect($(this), alt['R']);
			$(this).val( $(this).attr('init'));
		});
		$('select.listB').each(function(index){
			fillselect($(this), alt['B']);
			$(this).val( $(this).attr('init'));
		});
		$('select.listS').each(function(index){
			fillselect($(this), alt['S']);
			$(this).val( $(this).attr('init'));
		});
		$('select.listT').each(function(index){
			fillselect($(this), alt['T']);
			$(this).val( $(this).attr('init'));
		});
		$('select.listCP').each(function(index){
			fillselect($(this), alt['CP']);
			$(this).val( $(this).attr('init'));
		});
		$('select.listTYPE_UNT').each(function(index){
			fillselect($(this), alt['TYPE_UNT']);
			$(this).val( $(this).attr('init'));
		});
		// masquer / montrer les indefini
		$('dt > input[type=checkbox]').click(function(){
			$('#dd'+$(this).attr('value')+' p.infos').toggle();
		});
		// masquer / montrer le bloc
		$('dt > img').click(function(){
			$('#dd'+$(this).attr('id')).toggle();
		});
		$('input').removeAttr('disabled');
		$('select').removeAttr('disabled');
		$('#plz_wait').hide();
	}); // fin fonction $(document).ready

	// ajouter 2 champs avec son "name" propre, JS-onchange sur la liste
	// 1 seul champ textbox si liste=''
	function plus(cadre,liste){
		var id = cadre.replace(/[\[|\]]/g,'');
		if (liste!="") // générer la liste
			var select = addElement(cadre,liste);

		var input = addElement(cadre,''); // input text
		$('#field'+id).append("<br>").append(select).append(input);
		$('#sup'+id).show();
	}
	function plusUnite(cadre,liste){ // liste seule
		var id = cadre.replace(/[\[|\]]/g,'');
		var nb = $('#field'+id+' > select').length+1;
		var ch = $('<select>')
			.attr('name', cadre+'['+nb+']')
			.attr('id', id+nb);
		fillselect( ch, alt[liste]);
		$('#field'+id).append('<br>').append(ch);
		// afficher le bouton >suppression<
		$('#sup'+id).show();
	}

	// supprimer le dernier champ;
	function moins(cadre){
		var id = cadre.replace(/[\[|\]]/g,'');
		$('#field'+id+' > input[type=text]:last').remove();
		$('#field'+id+' > select:last').remove();
		// masquer le bouton >suppression< si plus aucun champs
		if($('#field'+id+' > input[type=text]').length==0)
			$('#sup'+id).hide();
	}

	// ajouter 1 seul champs, liste ou text si liste=''
	function addElement(cadre,liste){
		var id = cadre.replace(/[\[|\]]/g,'');
		if (liste!="") {
			var nb = $('#field'+id+' > select').length+1;
			var ch = $('<select>')
				.attr('name', 'type'+cadre+'['+nb+']')
				.attr('id', 'type'+id+nb);
			fillselect( ch, alt[liste]);
			ch.change(function(){ // fonction onchange
				$('#'+id+nb).attr('name',cadre+'['+this.value+']');
			});
			return ch;
		}else{
			var nb = $('#field'+id+' > input[type=text]').length+1;
			return $('<input>')
				.attr('type',"text")
				.attr('name', cadre+'['+nb+']')
				.attr('id', id+nb)
				.attr('size',4);
		}
	}

</script>
<p id="plz_wait" class="error">Patientez pendant l'initialisation du formulaire...</p>
<dl>
	<form method="post" action="admin.html?module=manual&amp;race={man_race}&amp;cfg={cfg}">
	<foreach cond="{race_cfg} as {key} => {cfg_val}"><# lister les items #>
	<dt>

<if cond='{cfg}=="unt"'>
	<if cond="isset({btc[{man_race}][alt][{key}]})">
		  <zimgunt type="{key}" race="{man_race}" id="{cfg}{key}" /> {unt[{man_race}][alt][{key}]}
	</if><else>
		<img src="img/{man_race}/{cfg}/{key}.png" title="NOM INDISPONIBLE ! {key}" id="{cfg}{key}" />NOM INDISPONIBLE ({key})
	</else>
</if>
<elseif cond='{cfg}=="res"'>
	<if cond="isset({res[{man_race}][alt][{key}]})">
		  <zimgres type="{key}" race="{man_race}" id="{cfg}{key}" /> {res[{man_race}][alt][{key}]}
	</if><else>
		<img src="img/{man_race}/{cfg}/{key}.png" title="NOM INDISPONIBLE ! {key}" id="{cfg}{key}" />NOM INDISPONIBLE ({key})
	</else>
</elseif>
<elseif cond='{cfg}=="btc"'>
	<if cond="isset({btc[{man_race}][alt][{key}]})">
		  <zimgbtc type="{key}" race="{man_race}" id="{cfg}{key}" /> {btc[{man_race}][alt][{key}]}
	</if><else>
		<img src="img/{man_race}/btc/{key}.png" title="NOM INDISPONIBLE ! {key}" id="{cfg}{key}" />NOM INDISPONIBLE ({key})
	</else>
</elseif>
<elseif cond='{cfg}=="src"'>
	<if cond="isset({res[{man_race}][alt][{key}]})">
		  <zimgsrc type="{key}" race="{man_race}" id="{cfg}{key}" /> {src[{man_race}][alt][{key}]}
	</if><else>
		<img src="img/{man_race}/{cfg}/{key}.png" title="NOM INDISPONIBLE ! {key}" id="{cfg}{key}" />NOM INDISPONIBLE ({key})
	</else>
</elseif>
<elseif cond='{cfg}=="trn"'>
<zimgtrn type="{key}" race="{man_race}" id="{cfg}{key}" /> {trn[{man_race}][alt][{key}]}
</elseif>
<elseif cond='{cfg}=="comp"'>
<zimgcomp type="{key}" race="{man_race}" id="{cfg}{key}" /> {comp[{man_race}][alt][{key}]}
</elseif>
<else><p class="error">ERREUR !</p></else>
<input type="submit" value="Enregistrer" name="OK" disabled="disabled" />
<input id="chk{cfg}{key}" name="indefini" type="checkbox" value="{cfg}{key}" disabled="disabled" />
<label for="chk{cfg}{key}"> montrer indéfini ?</label>

	</dt>
	<dd id="dd{cfg}{key}">
		<foreach cond="{cfg_frm} as {key2} => {val2}"><# lister sa config #>

			<if cond="isset({cfg_val[{key2}]})">

				<if cond="is_array({val2})">
		<fieldset id="field{cfg}{key}{key2}">
		<legend><if cond="isset({lbl[{key2}]})">{lbl[{key2}]}</if><else>{key2}</else></legend>
		Ajouter / Supprimer des éléments pour {key2} :
					<foreach cond="{val2} as {key3} => {val3}"><# plusieurs éléments pour cet item #>
						<if cond="isset({const[{key3}]})"><# ex prix res = array('R'=> 'uint') #>
		<!-- boutons pour ajouter / supprimer un item -->
		<input type="button" id="add{cfg}{key}{key2}" value="[ + ]" onclick="plus('{cfg}[{key}][{key2}]','{key3}');" disabled="disabled" />
		<input type="button" id="sup{cfg}{key}{key2}" value="[ - ]" onclick="moins('{cfg}[{key}][{key2}]');" disabled="disabled" />

							<foreach cond="{cfg_val[{key2}]} as {cfg_type} => {cfg_nb}">

		<br/>{cfg_type} : <select name="type{cfg}[{key}][{key2}]" class="list{key3}" init="{cfg_type}" onchange="$('#{cfg}{key}{key2}{cfg_type}').attr('name','{cfg}[{key}][{key2}]['+this.value+']');" id="type{cfg}{key}{key2}{cfg_type}" disabled="disabled">
		</select>
		<input name="{cfg}[{key}][{key2}][{cfg_type}]" id="{cfg}{key}{key2}{cfg_type}" size="4" type="text" value="{cfg_nb}" disabled="disabled" />


							</foreach>

						</if>

						<elseif cond="isset({const[{val3}]})"><# ex need_btc = array('B') #>
		<!-- boutons pour ajouter / supprimer un item -->
		<input type="button" id="add[{key}][{key2}]" value="[ + ]" onclick="plusUnite('{cfg}[{key}][{key2}]','{val3}');" disabled="disabled" />
		<input type="button" id="add[{key}][{key2}]" value="[ - ]" onclick="moins('{cfg}[{key}][{key2}]');" disabled="disabled" />
							<foreach cond="{cfg_val[{key2}]} as {cfg_type}">
		<br/>{cfg_type} : <select name="{cfg}[{key}][{key2}][{cfg_type}]" class="list{val3}" init="{cfg_type}" id="type{cfg}{key}{key2}{cfg_type}" disabled="disabled">
		</select>


							</foreach>
						</elseif>

						<elseif cond='{val3}=="uint"'>
							<if cond="isset({cfg_val[{key2}][{key3}]})">
	{key3} : <input name="{cfg}[{key}][{key2}][{key3}]" size="4" type="text" value="{cfg_val[{key2}][{key3}]}" disabled="disabled" />
							</if>
							<else><p class="infos" style="display:none">{key2}-{key3} = non défini : ajouter ? <input name="{cfg}[{key}][{key2}][{key3}]" size="4" type="text" value="" disabled="disabled" /></p>
							</else>
						</elseif>

						<else><p class="error">{key2} = non géré !</p></else>
					</foreach>
	</fieldset>
				</if>

				<elseif cond="isset({const[{val2}]})"><if cond="isset({lbl[{key2}]})">{lbl[{key2}]}</if><else>{key2}</else>
	<select name="{cfg}[{key}][{key2}]" class="list{val2}" init="{cfg_val[{key2}]}" disabled="disabled">
	</select>
				</elseif>
				<elseif cond='{val2}=="uint"'>
					<if cond="isset({lbl[{key2}]})">{lbl[{key2}]}</if><else>{key2}</else>
	<input name="{cfg}[{key}][{key2}]" size="4" type="text" value="{cfg_val[{key2}]}" disabled="disabled" />
				</elseif>

				<elseif cond='{val2}=="bool"'>
					<if cond="isset({lbl[{key2}]})">{lbl[{key2}]}</if><else>{key2}</else>
	<input name="{cfg}[{key}][{key2}]" type="checkbox" value="{cfg_val[{key2}]}" checked="checked" />
				</elseif>

				<else><p class="error">{key2} = non géré !</p></else>
			</if>

			<else>


	<p class="infos" style="display:none">
	<label for="add[{cfg}][{key}][{key2}]">{key2} <if cond="isset({lbl[{key2}]})">({lbl[{key2}]})</if> = non défini : ajouter ?

<if cond="is_array({val2})">
<foreach cond="{val2} as {key3} => {val3}">
	<if cond="isset({const[{key3}]})">
		<select name="addtype{cfg}[{key}][{key2}]" class="list{key3}" onchange="$('#{cfg}{key}{key2}').attr('name','{cfg}[{key}][{key2}]['+this.value+']');" id="type{cfg}{key}{key2}" disabled="disabled">
		</select>
		<input name="addno[]" id="{cfg}{key}{key2}" size="4" type="text" value="" disabled="disabled" />
	</if>
	<elseif cond="isset({const[{val3}]})">
		<select name="add[{cfg}][{key}][{key2}][]" class="list{val3}" disabled="disabled">
			<option value="" />
		</select>
	</elseif>
	<elseif cond='{val3}=="uint"'>
		{key3} : <input name="add[{cfg}][{key}][{key2}][{key3}]" size="4" type="text" value="" disabled="disabled" />
	</elseif>
</foreach>
</if>
<elseif cond="isset({const[{val2}]})">
	<select name="add[{cfg}][{key}][{key2}]" class="list{val2}" disabled="disabled">
		<option value="" />
	</select>
</elseif>
<elseif cond='{val2}=="uint"'>
	<input name="add[{cfg}][{key}][{key2}]" size="4" type="text" value="" disabled="disabled" />
</elseif>
<elseif cond='{val2}=="bool"'>
	<input name="add[{cfg}][{key}][{key2}]" type="checkbox" value="" disabled="disabled" />
</elseif>

	</label>
	</p>

			</else>
		</foreach>
	</dd>
	</foreach>
	</form>
</dl>
</if>


<elseif cond="isset({man_unt})">
<p class="menu_module">
	<foreach cond="{_races} as {race_id} => {value}">
	[ <if cond="{man_race} != {race_id}"><a href="admin.html?module=manual&amp;race={race_id}"><img src="img/{race_id}/{race_id}.png" alt="{race[{race_id}]}" title="{race[{race_id}]}" /> {race[{race_id}]}</a></if>
	<else><a href="admin.html?module=manual&amp;race={race_id}"><img src="img/{race_id}/{race_id}.png" alt="{race[{race_id}]}" title="{race[{race_id}]}" /> <strong>{race[{race_id}]}</strong></a></else> ]
	</foreach>
</p>

<h3>Liste des unités</h3>
<# ICI ON PROTEGE LES NOMS / DESCRIPTIONS SI JAMAIS C'EST PAS ENCORE DEFINI DANS LES FICHIERS TPL / CONFIG* #>
<form action="admin.html?module=manual&amp;race={man_race}" method="post">
<dl>
<foreach cond="{man_unt} as {key} => {value}">
	<if cond="{value[role]} != TYPE_UNT_CIVIL">
	<dt>{key}

		<if cond="isset({unt[{man_race}][alt][{key}]})">
			<zimgunt race="{man_race}" type="{key}" /> {unt[{man_race}][alt][{key}]}
		</if><else>
			<img src="img/{man_race}/unt/{key}.png" title="NOM INDISPONIBLE ! {key}" />DESCRIPTION INDISPONIBLE ! {key}
		</else>

		: {roles[{value[role]}]}
		<input type="text" id="nbr[{key}]" name="nbr[{key}]" value="{nbr[{key}]}" />
	</dt>
	<dd>

		<p>
		<if cond='isset({value[prix_res]})'>Prix :
			<foreach cond='{value[prix_res]} as {res_type} => {res_nb}'>
				{res_nb} <zimgres type="{res_type}" race="{man_race}" />
			</foreach>
		</if>
		<if cond="isset({value[need_src]})">Recherches :
			<foreach cond="{value[need_src]} as {src_id}">
				  <zimgsrc type="{src_id}" race="{man_race}" />
			</foreach>
		</if>
		<if cond="isset({value[need_btc]})">Bâtiment :
			<foreach cond="{value[need_btc]} as {btc_id}">

				<if cond="isset({btc[{man_race}][alt][{btc_id}]})">
					  <zimgbtc type="{btc_id}" race="{man_race}" /> {btc[{man_race}][alt][{btc_id}]}
				</if><else>
					<img src="img/{man_race}/btc/{btc_id}.png" title="NOM INDISPONIBLE ! {btc_id}" />NOM INDISPONIBLE ! {btc_id}
				</else>

			</foreach>
		</if>
		<if cond="isset({value[prix_unt]})">Unités :
			<foreach cond='{value[prix_unt]} as {unt_type} => {unt_nb_for}'>
				{unt_nb_for} <zimgunt type="{unt_type}" race="{man_race}" />
			</foreach>
		</if>
		</p>

       <if cond='isset({value[vit]})'>
       <p>[
			<if cond="isset({value[atq_unt]})">{value[atq_unt]} <img src="img/{man_race}/div/atq.png" alt="Attaque Unité" /> - </if>
			<if cond="isset({value[atq_btc]})">{value[atq_btc]} <img src="img/{man_race}/div/atq.png" alt="Attaque Bâtiment" /> - </if>
			<if cond="isset({value[def]})">{value[def]} <img src="img/{man_race}/div/def.png" alt="Défense" /></if>
			- Vie: {value[vie]}
			- Vitesse: {value[vit]}
           <if cond='isset({value[bonus]})'>
                - Bonus: 
                <if cond='isset({value[bonus][atq]})'>
					{value[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus atq" />
				</if>
                <if cond='isset({value[bonus][def]})'>
					{value[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus def" />
				</if>
                <if cond='isset({value[bonus][vie]})'>
					{value[bonus][vie]} <img src="img/{man_race}/div/tir.png" alt="Bonus vie" />
				</if>
           </if> ]
           </p>
           <if cond="isset({value[limite]})">
                <p>Maximum: {value[limite]}</p>
           </if>
           <if cond="isset({value[carry]})">
                <p>Capacité de transport: {value[carry]}</p>
           </if>
       </if>

	</dd>
   </if>
</foreach>
<input type="submit" value="recalculer" />
</form>


<dt>Cout et stats Totales de l'armée<br/>
	<foreach cond="{nbr} as {key} => {nb}">
		<if cond="{nb}">{nb} <zimgunt race="{man_race}" type="{key}" />; </if>
	</foreach>
</dt>
<dd>
	<p>
	<if cond='isset({total[prix_res]})'>Prix :
		<foreach cond='{total[prix_res]} as {res_type} => {res_nb}'>
			<if cond="{res_nb} != 0">{res_nb} <zimgres type="{res_type}" race="{man_race}" />; </if>
		</foreach>
	</if>
	<if cond="isset({total[prix_unt]})">Unités :
		<foreach cond='{total[prix_unt]} as {unt_type} => {unt_nb_for}'>
			{unt_nb_for} <zimgunt type="{unt_type}" race="{man_race}" />; 
		</foreach>
	</if>
	</p>

   <if cond='isset({total[atq_unt]})'>
       <p>[ {total[atq_unt]} <img src="img/{man_race}/div/atq.png" alt="Attaque Unité" />
       <if cond="isset({total[atq_btc]})"> - {total[atq_btc]} <img src="img/{man_race}/div/atq.png" alt="Attaque Bâtiment" /></if>
       - {total[def]} <img src="img/{man_race}/div/def.png" alt="Défense" />
       - Vie: {total[vie]}
       - bonus : {total[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus Attaque" />
       / {total[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus Défense" />
       / {total[bonus][vie]} <img src="img/{man_race}/div/tir.png" alt="Bonus Vie" /> (addition) ]
        </p>
       <if cond="isset({total[carry]})">
            <p>Capacité de transport: {total[carry]}</p>
       </if>
   </if>

</dd>
</dl>

</elseif>
<else>
	<if cond="isset({msg_update})"><p class="infos">{msg_update}</p></if>
	<p>Recharger la page.</p>
</else>

