<if cond='{btc_act} == "cancel_src"'>
	<if cond='isset({btc_no_sid})'>
		<p class="error">Aucune recherche sélectionnée.</p>
	</if>	
	<elseif cond='{btc_ok}'>
		<p class="ok">Recherche annulée.</p>
	</elseif>
	<else>
		<p class="error">Cette recherche n'existe pas.</p>
	</else>
</elseif>

<elseif cond='{btc_act} == "src"'>

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
			function( data ) { $( "#src_todo" ).append( data); }
		);
	});

});
// -->
</script>

	<div class="block" id="src_todo">
		<h4>Recherches en cours</h4>
		<if cond='{src_todo}'>
			<foreach cond='{src_todo} as {src_type} => {src_result}'>
				<zimgsrc type="{src_type}" race="{_user[race]}" />
				{src[{_user[race]}][alt][{src_type}]} -  <a href="btc-use.html?btc_type={btc_id}&amp;sub=cancel_src&amp;sid={src_type}">Annuler</a><br />

<# <!-- pas possible d'utiliser le tag zimgba2 ici car on doit calculser 100-'stdo_tours' ... -->
				<zimgba2 per="{src_result[stdo_tours]}" max="{src_conf[{src_type}][tours]}" />
#>
				<div class="barres_moyennes">
					<div style="width:<math oper='floor(100-({src_result[stdo_tours]} / {src_conf[{src_type}][tours]})*100)' />%" class="barre_verte"></div>
					<div style="width:<math oper='floor((({src_result[stdo_tours]} / {src_conf[{src_type}][tours]})*100))' />%" class="barre_rouge"></div>
				</div>
				&nbsp;<em><math oper='round(100-({src_result[stdo_tours]} / ({src_conf[{src_type}][tours]})*100))' />%</em>
				<br /><br />
			</foreach>
		</if>
	</div>

	<p class="menu_module">
		[ <a id="res_infos" href="#" class="toggle">Ressources Disponibles</a> ]
	</p>
	<if cond='{res_utils}'>
		<table class="liste" id="res_infos_toggle">
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

	<if cond='{src_dispo}'>
		<foreach cond='{src_dispo} as {src_id} => {src_array}'>
			
			<if cond='!isset({current_group}) OR {current_group} != {src_array[conf][group]}'>
				<if cond='isset({current_group})'>
							</tr>
						</table>
				</if>
				<set name="group_open" value="1"/>
				<set name="current_group" value="{src_array[conf][group]}" />
				<table class="liste">
					<tr>
			</if>
		
				<td>
					<img src="img/plus.png" id="src_{src_id}" class="toggle" />

					<zimgsrc race="{_user[race]}" type="{src_id}" /> {src[{_user[race]}][alt][{src_id}]}
					<if cond='isset({src_array[conf][prix_res]})'>
						<br/>Prix :
						<foreach cond='{src_array[conf][prix_res]} as {res_type} => {res_nb}'>
							<if cond="isset({src_array[bad][prix_res][{res_type}]})">
								<span class="bad">
									{res_nb} <zimgres race="{_user[race]}" type="{res_type}" />
								</span>
							</if>
							<else>
								{res_nb} <zimgres race="{_user[race]}" type="{res_type}" />
							</else>
						</foreach><br/>
					</if>
					<if cond='{src_array[bad][done]}'>
						<br/>
						<if cond='{src_array[bad][todo]}'>
							<span class="red">En cours</span>
						</if>
						<else>
							<span class="good">Effectuée</span>
						</else>
						<br/>
					</if>
					<else>
						<form action="btc-use.html?btc_type={btc_id}&amp;sub=add_src" method="post">
							<input type="hidden" name="type" value="{src_id}" />
							<input type="submit" value="Rechercher" />
						</form>
					</else>
					<div id="src_{src_id}_toggle">
						<if cond="isset({src_array[conf][need_no_src]})">
							Incompatible avec :
							<foreach cond="{src_array[conf][need_no_src]} as {src_no_type}">
								<zimgsrc race="{_user[race]}" type="{src_no_type}" />
							</foreach>
						</if>
						<p>{src[{_user[race]}][descr][{src_id}]}</p>
					</div>
				</td>
		</foreach>
		<if cond="{group_open}">
		</tr>
			</table>		
		</if>
	</if>
	<else>
		<p class="infos">Aucune recherche disponible.</p>
	</else>
</elseif>

<elseif cond='{btc_act} == "add_src"'>
	<if cond='isset({btc_no_type})'>
		<p class="error">Aucune recherche spécifiée.</p>
	</if>
	<elseif cond='isset({btc_src_max})'>
		<p class="infos">Nombre maximal de recherches simultanées atteint ({btc_unt_todo_max}).</p>
	</elseif>
	<elseif cond='isset({src_pending})'>
		<p class="error">Echec ! Recherche <zimgsrc race="{_user[race]}" type="{src_type}" /> déjà en cours....</p>
	</elseif>
	<elseif cond='!{btc_ok}'>
		<p class="error">Impossible de rechercher <zimgsrc race="{_user[race]}" type="{src_type}" /><br/>
			<foreach cond="{src_infos[prix_res]} as {res_type} => {res_nb}">
				{res_nb} <zimgres race="{_user[race]}" type="{res_type}" />
			</foreach>
		</p>
	</elseif>
	<else>
		<p class="ok">Recherche <zimgsrc race="{_user[race]}" type="{src_type}" /> en cours.</p>
	</else>
</elseif> 
