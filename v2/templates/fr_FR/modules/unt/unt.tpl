<if cond='!isset({unt_act}) || !{unt_act}'>

	<if cond='isset({no_heros})'><p class="error">Impossible de pendre / former un héros ici.</p></if>
	<if cond='isset({unt_sub}) && {unt_sub} == "error"'><p class="error">Erreur, il manque des paramètres.</p></if>

	<if cond='isset({unt_type})'>
    
        <if cond='isset({unt_dispo[conf][prix_res]})'>
			Prix :
			<foreach cond='{unt_dispo[conf][prix_res]} as {res_type} => {res_nb}'>
                <a href="manual.html?race={_user[race]}&type=res&value={res_type}" class="zrdPopUp" title="Ressource">
				<if cond="isset({unt_dispo[bad][prix_res][{res_type}]})">
					<span class="bad">{res_nb} <zimgres race="{_user[race]}" type="{res_type}" /></span>
				</if>
				<else>{res_nb} <zimgres race="{_user[race]}" type="{res_type}" /></else>
                </a>
			</foreach>
		</if>

		<if cond="isset({unt_dispo[conf][prix_unt]})">
			<foreach cond='{unt_dispo[conf][prix_unt]} as {typ_dispo} => {unt_nb}'>
                <a href="manual.html?race={_user[race]}&type=unt&value={typ_dispo}" class="zrdPopUp" title="Unité">
				<if cond="isset({unt_dispo[bad][prix_unt][{typ_dispo}]})">
					<span class="bad">{unt_nb}<zimgunt race="{_user[race]}" type="{typ_dispo}" /></span>
				</if>
				<else>{unt_nb}<zimgunt race="{_user[race]}" type="{typ_dispo}" /></else>
                </a>
			</foreach>
		</if>

		<if cond="isset({unt_dispo[conf][need_src]})">
			<foreach cond='{unt_dispo[conf][need_src]} as {src_type}'>
                <a href="manual.html?race={_user[race]}&type=src&value={src_type}" class="zrdPopUp" title="Recherche">
				<if cond="isset({unt_dispo[bad][need_src]}) && in_array({src_type},{unt_dispo[bad][need_src]})">
					<span class="bad"><zimgsrc race="{_user[race]}" type="{src_type}" /></span>
				</if>
				<else><zimgsrc race="{_user[race]}" type="{src_type}" /></else>
                </a>
			</foreach>
		</if>

		<if cond="isset({unt_dispo[conf][need_btc]})">
			<foreach cond='{unt_dispo[conf][need_btc]} as {btc_type}'>
                <a href="manual.html?race={_user[race]}&type=btc&value={btc_type}" class="zrdPopUp" title="Batiment">
				<if cond="isset({unt_dispo[bad][need_btc]}) && in_array({btc_type},{unt_dispo[bad][need_btc]})">
					<span class="bad"><zimgbtc race="{_user[race]}" type="{btc_type}" /></span>
				</if>
				<else><zimgbtc race="{_user[race]}" type="{btc_type}" /></else>
                </a>
			</foreach><br/>
		</if>

		<if cond="isset({unt_dispo[conf][limite]})">
			Limite: 
			<if cond="{unt_dispo[bad][limit_unt]}"><span class="bad">{unt_dispo[bad][limit_unt]}</span></if>
			<else>{unt_dispo[bad][limit_unt]}</else>
		</if>

		<p id="unt_{unt_type}_toggle">
			<if cond="isset({unt_dispo[conf][vit]})">
				<if cond='isset({unt_dispo[conf][atq_unt]}) OR isset({unt_dispo[conf][atq_btc]}) OR isset({unt_dispo[conf][def]})'>
		[ <if cond='isset({unt_dispo[conf][atq_unt]})'>{unt_dispo[conf][atq_unt]} <img src="img/{_user[race]}/div/atq.png" alt="Attaque Unité" /></if>
		<if cond="isset({unt_dispo[conf][atq_btc]})"> - {unt_dispo[conf][atq_btc]} <img src="img/{_user[race]}/div/atq_btc.png" alt="Attaque Bâtiment" /></if>
		<if cond="isset({unt_dispo[conf][def]})">  - {unt_dispo[conf][def]} <img src="img/{_user[race]}/div/def.png" alt="Défense" /></if> ]</if><br/>
              <if cond="isset({unt_dispo[conf][vie]})"> Vie: {unt_dispo[conf][vie]}<br /></if>
              <if cond="isset({unt_dispo[conf][vit]})"> Vitesse: {unt_dispo[conf][vit]} <br /> </if> 
			       <if cond='isset({unt_dispo[conf][bonus]})'>
				    Bonus: 
				    <if cond='isset({unt_dispo[conf][bonus][atq]})'>{unt_dispo[conf][bonus][atq]} <img src="img/{_user[race]}/div/atq.png" alt="Bonus atq" /></if>
				    <if cond='isset({unt_dispo[conf][bonus][def]})'>{unt_dispo[conf][bonus][def]} <img src="img/{_user[race]}/div/def.png" alt="Bonus def" /></if>
					<if cond='isset({unt_dispo[conf][bonus][vie]})'>{unt_dispo[conf][bonus][vie]} <img src="img/{_user[race]}/div/tir.png" alt="Vie" /></if>
				    <br />
			       </if>

			</if>
			{unt[{_user[race]}][descr][{unt_type}]}
		</p>

		<if cond='{unt_dispo[conf][role]} == {TYPE_UNT_HEROS}'>
			<if cond="{_user[hro_id]}">Vous avez déjà un héros.</if>
			<else>
				<a href="leg-hero.html?sub=form&id_hro={unt_type}" title="Former un héros !" />Former un héros !</a>
			</else>
		</if>

        <table><tbody><tr><td>
            <form id="untFormer" class="ajax" method="post" action="btc-use.html?btc_type={btc_type}&amp;sub=add_unt">
                <fieldset><legend>{btcopt[{_user[race]}][{btc_type}][unt]}</legend>
                    <label for="nb">
                    <zimgbtc race="{_user[race]}" type="{btc_type}"  />
                    </label>
                    <input type="hidden" name="type" value="{unt_type}" />
                    <input type="number" name="nb" id="nb" style="width:2em" />
                    <input type="submit" value="{btcopt[{_user[race]}][{btc_type}][unt]}" />
                </fieldset>
            </form>
        </td><td>
            <form id="untPendre" class="ajax" method="post" action="unt-pend.html?unt_type={unt_type}">
                <fieldset><legend>Pendaison.</legend>
                    <label for="unt_nb">
                        <zimgunt race="{_user[race]}" type="{unt_type}"  /><img class="left" src="img/{_user[race]}/div/pendre.png" alt="Pendre" />
                    </label>
                    <input type="number" name="unt_nb" id="nb" style="width:2em"/>
                    <input type="submit" value="Pendez-les !!!" />
                </fieldset>
            </form>
        </td></tr></tbody></table>
	</if>
    
	<if cond='isset({unt_dispo}) && {_display}!="ajax"'>
    
        <if cond='{unt_todo}'>
            <div class="block" id="unt_todo">
                    <foreach cond='{unt_todo} as {unt_result}'>
                        <set name="type_todo" value="{unt_result[utdo_type]}" />
                        <set name="btc_id" value="{unt_dispo[{type_todo}][conf][in_btc][0]}" />
                        <h5>{btcopt[{_user[race]}][{btc_id}][unt_todo]} </h5>
                        <zimgunt race="{_user[race]}" type="{type_todo}" /> {unt[{_user[race]}][alt][{type_todo}]} - {unt_result[utdo_nb]} - 
                        <a href="index.php?file=btc&act=use&btc_type={btc_id}&sub=cancel_unt&uid={unt_result[utdo_id]}">Annuler</a><br />
                    </foreach>
            </div>
        </if>

        <div id="output"></div>
		<p class="infos">Les unités "disponibles" sont celles qui ne travaillent pas dans un bâtiment et qui ne sont pas dans une légion, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
		<table class="liste" id="showUntForm">
			<tr>
				<th>Type</th>
				<th>Disponibles</th>
				<th>Total</th>
				<th>Infos</th>
			</tr>
            <tbody>
			<foreach cond='{unt_dispo} as {unt_type} => {unt_array}'>
				<tr>
					<td>
						<a href="unt.html?unt_type={unt_type}" title="Gérer les {unt[{_user[race]}][alt][{unt_type}]}">
							<zimgunt race="{_user[race]}" type="{unt_type}"  />
						</a>
						{unt[{_user[race]}][alt][{unt_type}]}
					</td>
					<td>{unt_done[vlg][{unt_type}]}</td>
					<td>{unt_done[tot][{unt_type}]}</td>
					<td>
						{roles[{unt_array[conf][role]}]}
						
<if cond='isset({unt_array[conf][atq_unt]}) OR isset({unt_array[conf][atq_btc]}) OR isset({unt_array[conf][def]})'>
		[ <if cond='isset({unt_array[conf][atq_unt]})'>{unt_array[conf][atq_unt]} <img src="img/{_user[race]}/div/atq.png" alt="Attaque Unité" /></if>
		<if cond="isset({unt_array[conf][atq_btc]})"> - {unt_array[conf][atq_btc]} <img src="img/{_user[race]}/div/atq_btc.png" alt="Attaque Bâtiment" /></if>
		<if cond="isset({unt_array[conf][def]})">  - {unt_array[conf][def]} <img src="img/{_user[race]}/div/def.png" alt="Défense" /></if> ]
</if>
					</td>
				</tr>
                </tbody>
			</foreach>
		</table>
		<div class="retour_module"><a href="unt.html" title="Retour">Retour</a></div>
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