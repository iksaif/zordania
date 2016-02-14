<p class="menu_module">
[
<a href="index.php?file=war&amp;act=histo" title="Historique de vos attaques, et de celle de vos ennemis.">Journal de guerre</a>
]
- 
[
<a href="index.php?file=leg" title="Créer, Modifier, Déplacer vos Légions">Gestion des Légions</a>
] -
[
<a href="index.php?file=war&amp;act=atq" title="Attaquer un autre membre.">Attaquer</a>
] -
[
<a href="index.php?file=war&amp;act=enc" title="Voir les attaques en cours.">Attaques en cours</a>
]
<hr />

</p>

<if cond='!|{leg_act}|'>
	<if cond='is_array(|{leg_array}|)'>
		<foreach cond='|{leg_array}| as |{leg_id}| => |{leg_value}|'>
		
		<div class="list_univ">
		Etat : {leg[{leg_value[leg_etat]}]} - Nom {leg_value[leg_name]}<br />
		Experience : {leg_value[leg_xp]}
		<if cond='|{leg_value[leg_etat]}| != 0'>
		 - Position X: {leg_value[map_x]} Y: {leg_value[map_y]} - Distance : <math oper="round(sqrt(({leg_value[map_x]}-{mbr_map_x})*({leg_value[map_x]}-{mbr_map_x}) + ({leg_value[map_y]}-{mbr_map_y})*({leg_value[map_y]}-{mbr_map_y})))" />
		</if> <br />
			<if cond='is_array(|{unt_array[{leg_id}]}|)'>
				<img src="img/{session_user[race]}/div/atq.png" alt="Attaque Unités" title="Attaque Unités" />
				{leg_value[leg_atq]} - 
				<img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bâtiments" title="Attaque Bâtiments" />
				{leg_value[leg_atq_btc]} - 
				<img src="img/{session_user[race]}/div/def.png" alt="Défense" title="Défense" />
				{leg_value[leg_def]}<br/>
				<foreach cond='|{unt_array[{leg_id}]}| as |{unt_type}| => |{unt_value}|'>
				{unt_value[unt_nb]} <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
				</foreach>
			</if>
			<else>
				<br />Aucune unité dans cette Légion - <a href="index.php?file=leg&act=del_leg&lid={leg_id}" title="Supprimer cette légion">Supprimer</a>
		
			</else>
		</div>
		</foreach>
	</if>
	<if cond='is_array(|{unt_array[0]}|)'>
		<div class="list_univ">
		Unités sans légion.<br />
				<img src="img/{session_user[race]}/div/atq.png" alt="Attaque" title="Attaque" />
				{leg_village[leg_atq]} - 
				<img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bâtiments" title="Attaque Bâtiments" />
				{leg_village[leg_atq_btc]} - 
				<img src="img/{session_user[race]}/div/def.png" alt="Défense" title="Défense" />
				{leg_village[leg_def]}<br/>
		<foreach cond='|{unt_array[0]}| as |{unt_type}| => |{unt_value}|'>
			<if cond='|{unt_conf[{unt_type}][speed]}|'>
				{unt_value[unt_nb]} <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
			</if>
		</foreach>
		</div>
	</if>
	Total : 
	<img src="img/{session_user[race]}/div/atq.png" alt="Attaque" title="Attaque" />
	{leg_total[leg_atq]} - 
	<img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bâtiments" title="Attaque Bâtiments" />
	{leg_total[leg_atq_btc]} - 
	<img src="img/{session_user[race]}/div/def.png" alt="Défense" title="Défense" />
	{leg_total[leg_def]}<br/>
<script type="text/javascript">
<!--
	function vide(the_select)
	{
		if(the_select.options.length > 0)
		{	
			the_select.options.length=0;
		}
	}
	
	function ajoute(the_select, value, text){
		the_select.options[the_select.options.length]=new Option(text,value);
	}

	function update_unt()
	{
		var type_unt = document.getElementById("type_unt");
		var from_leg = document.getElementById("from_leg");
		
		var value_from_leg = from_leg.options[from_leg.selectedIndex].value;

		var unt_in_leg = legions[value_from_leg]['unt'];
		
		vide(type_unt);
		
		for(var i = 0; i < unt_in_leg.length; i++)
    {
      if(unt_in_leg[i])
      {
        var unt_nb = unt_in_leg[i][1];
        var unt_type = i;
        var unt_name = unt_in_leg[i][0];
        ajoute(type_unt , unt_type, unt_name + '  (' + unt_nb + ')');
      }
    }
	}

	function make_form()
	{
		var type_unt = document.getElementById("type_unt");
		var from_leg = document.getElementById("from_leg");
		var to_leg = document.getElementById("to_leg");

		vide(from_leg);
		vide(to_leg);
		//ajoute(from_leg, 0, 'Village');
		ajoute(to_leg, -1, 'Nouvelle Légion');
		for(var i = 0; i < legions.length; i++)
    {
    	if(legions[i])
    	{
    		var leg_lid = i;
    		var leg_name = legions[i]['name'];
    		ajoute(from_leg , leg_lid, leg_name);
    		ajoute(to_leg , leg_lid, leg_name);
    	}
    }
		
		vide(type_unt);
		if(legions[0]['unt'])
		{
		var unt_in_leg = legions[0]['unt'];
		for(var i = 0; i < unt_in_leg.length; i++)
    {
    	if(unt_in_leg[i])
    	{
      	var unt_nb = unt_in_leg[i][1];
      	var unt_type = i;
      	var unt_name = unt_in_leg[i][0];
      	ajoute(type_unt , unt_type, unt_name + '  (' + unt_nb + ')');
      }
     }
     }
	}
	
	function check_leg_name()
	{
		var to_leg = document.getElementById("to_leg");
		var to_leg_value = to_leg.options[to_leg.selectedIndex].value;
		var leg_name = document.getElementById("leg_name");
		
		if(to_leg_value == "-1")
		{
			leg_name.value = '';
			leg_name.disabled = false;
		}else{
			leg_name.value = legions[to_leg_value]['name'];
			leg_name.disabled = "disabled";
		}
	}
		
	var legions = new Array();
	<if cond='is_array(|{unt_array[0]}|)'>
		legions[0] = new Array();
		legions[0]['name'] = 'Village';
		legions[0]['unt']  = new Array();
			<foreach cond='|{unt_array[0]}| as |{unt_type}| => |{unt_value}|'>
			<if cond='|{unt_conf[{unt_type}][speed]}|'>
				legions[0]['unt'][{unt_type}] = new Array('{unt[alt][{unt_type}]}',{unt_value[unt_nb]});
			</if>
			</foreach>
	</if>
	
	<if cond='is_array(|{leg_array}|)'>
		<foreach cond='|{leg_array}| as |{leg_id}| => |{leg_value}|'>
		<if cond='|{leg_value[leg_etat]}| == 0'>
		legions[{leg_id}] = new Array();
		legions[{leg_id}]['name'] = '<math oper="addslashes(html_entity_decode({leg_value[leg_name]}, ENT_QUOTES))" />';
		legions[{leg_id}]['unt']  = new Array();
		
				<if cond='is_array(|{unt_array[{leg_id}]}|)'>
					<foreach cond='|{unt_array[{leg_id}]}| as |{unt_type}| => |{unt_value}|'>
					legions[{leg_id}]['unt'][{unt_type}]= new Array('{unt[alt][{unt_type}]}',{unt_value[unt_nb]});
					</foreach>
				</if>
		</if>
		</foreach>
	</if>
-->
</script>
<p class="infos">Les légions qui ne sont pas au village ne peuvent être modifiées, les bonus ne sont calculés qu'au moment de l'attaque.</p>
<br /><br />
<form method="post" action="index.php?file=leg&act=edit_leg" id="unt_form" name="unt_form">
	Déplacer de 
	<select name="from_leg" id="from_leg" onChange="update_unt();">
	<option value="0">Village</value>
	<if cond='is_array(|{leg_array}|)'>
		<foreach cond='|{leg_array}| as |{leg_id}| => |{leg_value}|'>
		<if cond='|{leg_value[leg_etat]}| == 0'>
		<option value="{leg_id}">{leg_value[leg_name]}</value>
		</if>
		</foreach>
	</if>
	</select>
	vers
	<select name="to_leg" id="to_leg" onChange="check_leg_name();">
		<option value="-1">Nouvelle legion</option>
		<if cond='is_array(|{leg_array}|)'>
			<foreach cond='|{leg_array}| as |{leg_id}| => |{leg_value}|'>
				<if cond='|{leg_value[leg_etat]}| == 0'>
				<option value="{leg_id}">{leg_value[leg_name]}</value>
				</if>
			</foreach>
		</if>
	</select><br />
	<label for="leg_name">Nom de la légion : </label>
	<input id="leg_name" type="text" name="leg_name" maxlength="20" size="11" />
	<br/>
	<label for="nb_unt">Nombre :</label>
	<input id="nb_unt" type="text" name="nb_unt" maxlength="5" size="5" />
	Type :
	<select id="type_unt" name="type_unt" />
	<if cond='is_array(|{leg_array}|)'>
		<foreach cond='|{leg_array}| as |{leg_id}| => |{leg_value}|'>
		<if cond='|{leg_value[leg_etat]}| == 0'>
				<if cond='is_array(|{unt_array[{leg_id}]}|)'>
					<foreach cond='|{unt_array[{leg_id}]}| as |{unt_type}| => |{unt_value}|'>
					<option value="{unt_type}">{unt_value[unt_nb]} {unt[alt][{unt_type}]} dans {leg_value[leg_name]}</option>
					</foreach>
				</if>
		</if>
		</foreach>
	</if>
	</select>
	<input type="submit" value="Appliquer" />
</form>
<script type="text/javascript">
	make_form();
</script>
<br />
</if>
<elseif cond='|{leg_act}| == "edit_leg"'>
	<if cond='|{leg_sub}| == "not_all_input"'>
	<p class="error">Il manque des parametres.</p>
	</if>
	<elseif cond='|{leg_edit}|'>
	<p class="ok">Changement effectué.</p>
	</elseif>
	<else>
	<p class="error">Erreur</p>
	</else>
	<br />
	<br />
	<p class="retour_module">[ <a href="index.php?file=leg">Retour</a> ]</p>
</elseif>
<elseif cond='|{leg_act}| == "del_leg"'>
	<if cond='|{leg_sub}| == "no_lid"'>
	<p class="error">Il manque des parametres.</p>
	</if>
	<elseif cond='|{leg_ok}|'>
	<p class="ok">Supprimée.</p>
	</elseif>
	<else>
	<p class="error">Erreur, il est possible que cette légion ne soit pas vide.</p>
	</else>
	<br />
	<br />
	<div class="retour">[ <a href="index.php?file=leg">Retour</a> ]</div>
</elseif>