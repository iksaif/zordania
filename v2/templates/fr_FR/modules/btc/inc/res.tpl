<if cond='{btc_act} == "cancel_res"'>
	<if cond='isset({btc_no_rid})'>
		<p class="error">Aucune ressource sélectionnée.</p>
	</if>
	<elseif cond='isset({btc_no_nb})'>
		<p class="infos">Il faut choisir un nombre de ressources à annuler.</p>
		<form action="btc-use.html?btc_type={btc_id}&amp;sub=cancel_res&amp;rid={btc_rid}" method="post">
			<input type="text" name="nb" size="1" maxlength="2"  />
			<input type="submit" value="Annuler" />
		</form>
	</elseif>	
	<elseif cond='{btc_ok}'>
		<p class="ok">Ressources(s) annulée(s).</p>
	</elseif>
	<else>
		<p class="error">Ces ressources n'existent pas ou vous tentez d'en annuler plus qu'il n'y en a en cours.</p>
	</else>
</elseif>
<elseif cond='{btc_act} == "res"'>
	<div class="block" id="res_todo">
		<h4>{btcopt[{_user[race]}][{btc_id}][res_todo]}</h4>
		<if cond='{res_todo}'>
			<foreach cond='{res_todo} as {res_result}'>
				<set name="res_type" value="{res_result[rtdo_type]}" />
				<zimgres race="{_user[race]}" type="{res_type}" /> {res[{_user[race]}][alt][{res_type}]} - {res_result[rtdo_nb]} - <a href="btc-use.html?btc_type={btc_id}&amp;sub=cancel_res&amp;rid={res_result[rtdo_id]}">Annuler</a><br />
			</foreach>
		</if>
	</div>
	
	<p class="infos">Les unités "disponibles" sont les unités formées qui ne travaillent pas dans un bâtiments, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
	
	<p class="menu_module">
	[ <a id="res_infos" href="#" class="toggle">Ressources Disponibles</a> ]</p>
	<if cond='{res_utils}'>
		<table id="res_infos_toggle" class="liste">
			<tr>
				<th>Type</th>
				<th>Nombre</th>
			</tr>
			<foreach cond='{res_utils} as {res_id} => {res_value}'>
				<tr>
					<td><zimgres race="{_user[race]}" type="{res_id}" /> {res[{_user[race]}][alt][{res_id}]}</td>
					<td>{res_value}</td>      
				</tr>
			</foreach>
		</table>
	</if>

	<if cond='{res_dispo}'>

<script type="text/javascript">
<!-- // jquery sur les formulaires de formation
$(document).ready(function()
{
	// Lorsqu'un formulaire est soumis
	$("form").submit(function(event) {

		event.preventDefault(); 
		var term = $(this).serialize(),
			url = 'ajax--' + $(this).attr( 'action' );

		$.post( url, term,
			function( data ) { $( "#res_todo" ).append( data); }
		);
	});

});
// -->
</script>

		<foreach cond='{res_dispo} as {res_id} => {res_array}'>			
			<if cond='!isset({current_group}) OR {current_group} != {res_array[conf][group]}'>
				<if cond='isset({current_group})'>
							</tr>
						</table>
				</if>
				<set name="group_open" value="1"/>
				<set name="current_group" value="{res_array[conf][group]}" />
				<table class="liste">
					<tr>
			</if>
			<td>
				<img src="img/0.png" id="res_{res_id}" class="toggle" />
				<zimgres race="{_user[race]}" type="{res_id}" /> - 
				{res[{_user[race]}][alt][{res_id}]} <br/>
				Stock : {res_utils[{res_id}]}<br/>
				
				<if cond='isset({res_array[conf][prix_res]})'>
					Prix :
					<foreach cond='{res_array[conf][prix_res]} as {res_type} => {res_nb}'>
						<if cond="isset({res_array[bad][prix_res][{res_type}]})">
							<span class="bad">
							{res_nb} <zimgres race="{_user[race]}" type="{res_type}" />
							</span>
						</if>
						<else>
							{res_nb} <zimgres race="{_user[race]}" type="{res_type}" />
						</else>
					</foreach><br/>
				</if>


				<div id="res_{res_id}_toggle">
					<p>
						{res[{_user[race]}][descr][{res_id}]}
					</p>
				</div>
				<form action="btc-use.html?btc_type={btc_id}&amp;sub=add_res" method="post">
					<input type="hidden" name="type" value="{res_id}" />
					<input type="text" name="nb" size="1" maxlength="2"  />
					<input type="submit" value="{btcopt[{_user[race]}][{btc_id}][res]}" />
				</form>
			</td>
		</foreach>
		<if cond="{group_open}">
					</tr>
				</table>
		</if>
 	</if>
</elseif>

<elseif cond='{btc_act} == "add_res"'>
	<if cond='isset({btc_no_type})'>
		<p class="error">Aucun type spécifié.</p>
	</if>
	<elseif cond='isset({btc_no_nb})'>
		<p class="error">Il faut choisir un nombre de ressources.</p>
	</elseif>
	<elseif cond='isset({btc_res_todo_max})'>
		<p class="infos">Nombre maximal de ressources simultanées atteint ({btc_res_todo_max}).</p>
	</elseif>
	<elseif cond='!{btc_ok}'>
		<p class="error">Impossible de faire {btc_res_nb}
		<zimgres race="{_user[race]}" type="{res_id}" /><br/>
		Il manque :
			<foreach cond="{res_infos[prix_res]} as {res_type} => {res_nb}">
				{res_nb} <zimgres race="{_user[race]}" type="{res_type}" />
			</foreach>
		</p>
	</elseif>
	<else>
		<p class="ok">{btc_res_nb}<zimgres race="{_user[race]}" type="{res_id}" /> {btcopt[{_user[race]}][{btc_id}][res_todo]} !</p>
	</else>
</elseif>
