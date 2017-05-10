<if cond='!isset({unt_act}) || !{unt_act}'>
	<if cond='isset({no_heros})'><p class="error">Impossible de pendre / former un héros ici.</p></if>
	<if cond='isset({unt_sub}) && {unt_sub} == "error"'><p class="error">Erreur, il manque des paramètres.</p></if>
	<if cond='isset({unt_type})'>
		<h3>Gérer les {unt[{_user[race]}][alt][{unt_type}]}</h3>
		Actions possibles :
		<form id="untPendre" class="ajax" method="post" action="unt-pend.html?unt_type={unt_type}">
			<fieldset><legend>Pendaison.</legend>
				<zimgunt race="{_user[race]}" type="{unt_type}"  /><img class="left" src="img/{_user[race]}/div/pendre.png" alt="Pendre" />
				<label for="nb">Nombre</label>
				<input type="text" name="unt_nb" id="nb" />
				<input type="submit" value="Pendez-les !!!" />
			</fieldset>
		</form>
		<form id="untFormer" class="ajax" method="post" action="btc-use.html?btc_type={btc_type}&amp;sub=add_unt">
			<fieldset><legend>Former/Entraîner.</legend>
				<zimgbtc race="{_user[race]}" type="{btc_type}"  />
				<label for="nb">Nombre</label>
				<input type="hidden" name="type" value="{unt_type}" />
				<input type="text" name="nb" id="nb" />
				<input type="submit" value="Ok" />
			</fieldset>
		</form>
	</if>
	<if cond='isset({unt_dispo}) && {_display}!="ajax"'>
		<div id="output"></div>
		<p class="infos">Les unités "disponibles" sont celles qui ne travaillent pas dans un bâtiment et qui ne sont pas dans une légion, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
		<table class="liste" id="showUntForm">
			<tr>
				<th>Type</th>
				<th>Disponibles</th>
				<th>Total</th>
				<th>Infos</th>
			</tr>
			<foreach cond='{unt_dispo} as {unt_id} => {unt_array}'>
				<tr>
					<td>
						<a href="unt.html?unt_type={unt_id}" title="Gérer les {unt[{_user[race]}][alt][{unt_id}]}">
							<zimgunt race="{_user[race]}" type="{unt_id}"  />
						</a>
						{unt[{_user[race]}][alt][{unt_id}]}
					</td>
					<td>{unt_done[vlg][{unt_id}]}</td>
					<td>{unt_done[tot][{unt_id}]}</td>
					<td>
						{roles[{unt_array[conf][role]}]}
						
<if cond='isset({unt_array[conf][atq_unt]}) OR isset({unt_array[conf][atq_btc]}) OR isset({unt_array[conf][def]})'>
		[ <if cond='isset({unt_array[conf][atq_unt]})'>{unt_array[conf][atq_unt]} <img src="img/{_user[race]}/div/atq.png" alt="Attaque Unité" /></if>
		<if cond="isset({unt_array[conf][atq_btc]})"> - {unt_array[conf][atq_btc]} <img src="img/{_user[race]}/div/atq_btc.png" alt="Attaque Bâtiment" /></if>
		<if cond="isset({unt_array[conf][def]})">  - {unt_array[conf][def]} <img src="img/{_user[race]}/div/def.png" alt="Défense" /></if> ]
</if>
					</td>
				</tr>
			</foreach>
		</table>
		<div class="retour_module">[ <a href="unt.html" title="Retour">Retour</a> ]</div>
	</if>
</if>
<elseif cond='{unt_act} == "pend"'>
	<if cond='{unt_sub} == "paspossible"'>
		<p class="error">Impossible de pendre des unités qui travaillent (civils dans les bâtiments ou soldats dans les légions).</p>
	</if>
	<elseif cond='{unt_sub} == "ok"'>
		<p class="ok">Ok, ils ont bien été pendus !</p>
	</elseif>
</elseif>