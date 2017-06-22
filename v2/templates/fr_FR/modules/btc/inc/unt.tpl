<if cond='{btc_act} == "cancel_unt"'>
	<if cond='isset({btc_no_uid})'>
		<p class="error">Aucune unité sélectionnée.</p>
	</if>
	<elseif cond='isset({btc_no_nb})'>
		<p class="infos">Il faut choisir un nombre d'unités à annuler.</p>
		<form action="btc-use.html?btc_type={btc_id}&sub=cancel_unt&uid={btc_uid}" method="post">
			<input type="number" name="nb" size="1" maxlength="2" style="width:3em" />
			<input type="submit" value="Annuler" />
		</form>
	</elseif>
	<elseif cond='{btc_ok}'>
		<p class="ok">Unité(s) annulée(s).</p>
	</elseif>
	<else>
		<p class="error">Ces unités n'existent pas ou vous tentez d'en annuler plus qu'il n'y en a en cours.</p>
	</else>
</elseif>

<elseif cond='{btc_act} == "unt"'>
	<div class="block" id="unt_todo">
		<h4>{btcopt[{_user[race]}][{btc_id}][unt_todo]}</h4>
		<if cond='{unt_todo}'>
			<foreach cond='{unt_todo} as {unt_result}'>
				<set name="unt_type" value="{unt_result[utdo_type]}" />
				<zimgunt race="{_user[race]}" type="{unt_type}" /> {unt[{_user[race]}][alt][{unt_type}]} - {unt_result[utdo_nb]} - <a href="index.php?file=btc&act=use&btc_type={btc_id}&sub=cancel_unt&uid={unt_result[utdo_id]}">Annuler</a><br />
			</foreach>
		</if>
	</div>
	
	<p class="infos">Les unités "disponibles" sont les unités formées qui ne travaillent pas dans un bâtiment, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
	
	<p class="menu_module">[ <a id="unt_infos" class="toggle" href="#">Unités Disponibles</a> ] -
	[ <a id="res_infos" class="toggle" href="#">Ressources Disponibles</a> ]</p>

	<if cond='{res_utils}'>
	<table id="res_infos_toggle" class="liste" style="display: none;">
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
	<else><p id="res_infos_toggle" class="infos" style="display: none;">Aucune ressource utile disponible.</p></else>

	<if cond='{unt_utils}'>
	<table class="liste" id="unt_infos_toggle" style="display: none;">
		<tr>
			<th>Type</th>
			<th>Nombre</th>
		</tr>
		<foreach cond='{unt_utils} as {unt_id} => {unt_nb}'>
		<tr>
			<td><zimgunt race="{_user[race]}" type="{unt_id}" /> {unt[{_user[race]}][alt][{unt_id}]}</td>
			<td>{unt_nb}</td>      
		</tr>
		</foreach>
	</table>
	</if>
	<else><p id="unt_infos_toggle" class="infos" style="display: none;">Aucune unité utile disponible.</p></else>

	<if cond='{unt_dispo}'>

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
			function( data ) { $( "#unt_todo" ).append( data); }
		);
	});

});
// -->
</script>

	<!-- liste des unités disponibles à la formation -->
	<foreach cond='{unt_dispo} as {unt_id} => {unt_array}'>			

	<if cond='!isset({current_group}) OR {current_group} != {unt_array[conf][group]}'>
		<if cond='isset({current_group})'>
			</tr>
		</table>
		</if>
		<set name="group_open" value="1"/>
		<set name="current_group" value="{unt_array[conf][group]}" />
		<table class="liste">
	</if>

	<td>
		<img src="img/plus.png" id="unt_{unt_id}" class="toggle" />
		<zimgunt race="{_user[race]}" type="{unt_id}" /> - {unt[{_user[race]}][alt][{unt_id}]} <br/>
		
		Disponibles :
		<if cond='isset({unt_done[vlg][{unt_id}]})'>{unt_done[vlg][{unt_id}]}</if><else>0</else>/
		<if cond='isset({unt_done[tot][{unt_id}]})'>{unt_done[tot][{unt_id}]}</if><else>0</else><br/>

		<if cond='isset({unt_array[conf][prix_res]})'>
			Prix :
			<foreach cond='{unt_array[conf][prix_res]} as {res_type} => {res_nb}'>
				<if cond="isset({unt_array[bad][prix_res][{res_type}]})">
					<span class="bad">{res_nb} <zimgres race="{_user[race]}" type="{res_type}" /></span>
				</if>
				<else>{res_nb} <zimgres race="{_user[race]}" type="{res_type}" /></else>
			</foreach>
		</if>

		<if cond="isset({unt_array[conf][prix_unt]})">
			<foreach cond='{unt_array[conf][prix_unt]} as {unt_type} => {unt_nb}'>
				<if cond="isset({unt_array[bad][prix_unt][{unt_type}]})">
					<span class="bad">{unt_nb}<zimgunt race="{_user[race]}" type="{unt_type}" /></span>
				</if>
				<else>{unt_nb}<zimgunt race="{_user[race]}" type="{unt_type}" /></else>
			</foreach>
		</if>

		<if cond="isset({unt_array[conf][need_src]})">
			<foreach cond='{unt_array[conf][need_src]} as {src_type}'>
				<zimgsrc race="{_user[race]}" type="{src_type}" />
			</foreach><br/>
		</if>

		<if cond="isset({unt_array[conf][limite]})">
			Limite: 
			<if cond="{unt_array[bad][limit_unt]}"><span class="bad">{unt_array[bad][limit_unt]}</span></if>
			<else>{unt_array[bad][limit_unt]}</else>
		</if>

		<p id="unt_{unt_id}_toggle">
			<if cond="isset({unt_array[conf][vit]})">
				<if cond='isset({unt_array[conf][atq_unt]}) OR isset({unt_array[conf][atq_btc]}) OR isset({unt_array[conf][def]})'>
		[ <if cond='isset({unt_array[conf][atq_unt]})'>{unt_array[conf][atq_unt]} <img src="img/{_user[race]}/div/atq.png" alt="Attaque Unité" /></if>
		<if cond="isset({unt_array[conf][atq_btc]})"> - {unt_array[conf][atq_btc]} <img src="img/{_user[race]}/div/atq_btc.png" alt="Attaque Bâtiment" /></if>
		<if cond="isset({unt_array[conf][def]})">  - {unt_array[conf][def]} <img src="img/{_user[race]}/div/def.png" alt="Défense" /></if> ]</if><br/>
              <if cond="isset({unt_array[conf][vie]})"> Vie: {unt_array[conf][vie]}<br /></if>
              <if cond="isset({unt_array[conf][vit]})"> Vitesse: {unt_array[conf][vit]} <br /> </if> 
			       <if cond='isset({unt_array[conf][bonus]})'>
				    Bonus: 
				    <if cond='isset({unt_array[conf][bonus][atq]})'>{unt_array[conf][bonus][atq]} <img src="img/{_user[race]}/div/atq.png" alt="Bonus atq" /></if>
				    <if cond='isset({unt_array[conf][bonus][def]})'>{unt_array[conf][bonus][def]} <img src="img/{_user[race]}/div/def.png" alt="Bonus def" /></if>
					<if cond='isset({unt_array[conf][bonus][vie]})'>{unt_array[conf][bonus][vie]} <img src="img/{_user[race]}/div/tir.png" alt="Vie" /></if>
				    <br />
			       </if>

			</if>
			{unt[{_user[race]}][descr][{unt_id}]}
		</p>

		<if cond='{unt_array[conf][role]} == {TYPE_UNT_HEROS}'>
			<if cond="{_user[hro_id]}">Vous avez déjà un héros.</if>
			<else>
				<a href="leg-hero.html?sub=form&id_hro={unt_id}" title="Former un héros !" />Former un héros !</a>
			</else>
		</if>
		<else>
			<form action="btc-use.html?btc_type={btc_id}&sub=add_unt" method="post">
			<input type="hidden" name="type" value="{unt_id}" />
			<input type="number" name="nb" size="1" maxlength="2" style="width:3em" />
			<input type="submit" value="{btcopt[{_user[race]}][{btc_id}][unt]}" />
			</form>
		</else>				
	</td>
	</foreach>

	<!-- fin liste unités disponibles -->
	<if cond="{group_open}">
			</tr>
		</table>
	</if>
 	</if>

</elseif>

<elseif cond='{btc_act} == "add_unt"'>
	<if cond='isset({btc_no_type})'>
		<p class="error">Aucun type spécifié.</p>
	</if>
	<elseif cond='isset({type_no_heros})'>
		<p class="error">Impossible de former de héros ainsi.</p>
	</elseif>	
	<elseif cond='isset({btc_no_nb})'>
		<p class="error">Il faut choisir un nombre d'unités.</p>
	</elseif>	
	<elseif cond='isset({btc_unt_todo_max})'>
		<p class="infos">Nombre maximal de formations simultanées atteint ({btc_unt_todo_max}).</p>
	</elseif>
	<elseif cond='isset({btc_unt_total_max})'>
		<p class="error">Pas assez de place ou nombre maximal d'unités atteint ({btc_unt_total_max}).</p>
	</elseif>
	<elseif cond='!{btc_ok}'>
		<p class="error">Impossible de former {unt_nb} 
		<zimgunt race="{_user[race]}" type="{unt_type}" /><br/>
			<foreach cond="{unt_infos[prix_res]} as {res_type} => {res_nb}">
				{res_nb}<zimgres race="{_user[race]}" type="{res_type}" />
			</foreach>
			<foreach cond="{unt_infos[prix_unt]} as {unt_type} => {unt_nb}">
				{unt_nb}<zimgunt race="{_user[race]}" type="{unt_type}" />
			</foreach>
			<if cond="{unt_infos[limit_unt]}">
				<br/>
				Limite: {unt_infos[limit_unt]}
			</if>
		</p>
	</elseif>
	<else>
		<p class="ok">{unt_nb}<zimgunt race="{_user[race]}" type="{unt_type}" /> en formation !</p>
	</else>
</elseif>
