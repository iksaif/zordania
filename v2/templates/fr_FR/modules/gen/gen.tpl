<div class="menu_module">
	<h3> {_user[vlg]} village de {_user[pseudo]}</h3>
</div>

<table id="donjon">
<tr>

	<td>
	<h4>Infos :</h4>

		<ul>
			<li><zimgbar per="{_user[population]}" max="{_user[place]}" /> <img src="img/{_user[race]}/{_user[race]}.png" alt="Place" title="Place" /> {_user[population]} / {_user[place]} </li>
			<li>Position sur la carte : X: {_user[map_x]} Y: {_user[map_y]}</li>
			<li>Bâtiments : {gen_nb_btc}</li>
			<li>Population : {_user[population]}</li>
			<li>Points : {_user[points]}</li>
		</ul>
		<br/>
	<h4>Ressources Principales :</h4>
		<if cond='{res_array}'>
		<ul>
			<foreach cond='{res_array} as {res_type} => {res_nb}'>
			<li>
				<zimgres race="{_user[race]}" type="{res_type}" /> {res_nb}
				<if cond="{prod_res[{res_type}]} > 0">
					(<img src="img/up.png" alt="Up" /> <span class="gain">{prod_res[{res_type}]}</span>)
				</if>
				<elseif cond="{prod_res[{res_type}]} < 0">
					(<img src="img/down.png" alt="Down" /> <span class="perte">{prod_res[{res_type}]}</span>)
				</elseif>
				<else>
				</else>
			</li>
			</foreach>
		</ul>
		</if>
	<h4>Terrains :</h4>
		<if cond='{trn_array}'>
		<ul>
			<foreach cond='{trn_array} as {trn_type} => {trn_nb}'>
			<if cond="{trn_nb}">
			<li>
				<zimgtrn race="{_user[race]}" type="{trn_type}" /> {trn_nb}
			</li>
			</if>
			</foreach>
		</ul>
		</if>
	</td>
	<td>
		<if cond='isset({_user[hro_id]}) && isset({_user[hro_nom]})'>
			<h4>Héros : {_user[hro_nom]}</h4>
			<a href="leg-hero.html"><zimgunt race="{_user[race]}" type="{_user[hro_type]}" /></a>
			<zimgbar per="{_user[hro_vie]}" max="{_user[hro_vie_conf]}" /> Vie: {_user[hro_vie]} / {_user[hro_vie_conf]}
			<p>Expérience: {_user[hro_xp]}</p>
<if cond="{_user[bonus]} == 0"><p>Compétence : aucune activée</p>
</if>
<else><p>Compétence : <a href="manual.html?race={_user[race]}&amp;type=comp#comp_{_user[bonus]}"><zimgcomp race="{_user[race]}" type="{_user[bonus]}" /> {comp[{_user[race]}][alt][{_user[bonus]}]} </a></p>
</else>

</if>

		<if cond="!empty({atq_array})">
			<h4>Légion en approche :</h4>
			<ul>
				<foreach cond='{atq_array} as {result}'>
					<if cond="(max(abs({result[map_x]} - {_user[map_x]}),abs({result[map_y]} - {_user[map_y]}))) < {dst_view_max} AND {result[hro_bonus]} != {CP_INVISIBILITE}">
						<li> 
							<img src="img/info.png" alt="Info" title="Info sur {result[leg_name]}" id="leg{result[leg_id]}" class="toggle" />
							- légion <img src="img/{result[mbr_race]}/{result[mbr_race]}.png" alt="{result[mbr_pseudo]}" title="{result[mbr_pseudo]}" /> de
							<zurlmbr mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}" />
							<fieldset id="leg{result[leg_id]}_toggle" style="display: none;">
								<if cond="!empty({result[ambr_aid]})"> 
									Alliance:
									<a href="alliances-view.html?al_aid={result[ambr_aid]}">
										<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="Alliance" title="Alliance"/> {result[al_name]}
									</a>
								</if>
								<br/>
								Destination: 
								<a href="carte.html?map_cid={result[leg_dest]}" title="Voir">{_user[map_x]}x{_user[map_y]}</a>
								<br/>
								Position : <a href="carte.html?map_cid={result[leg_cid]}" title="Voir">{result[map_x]}x{result[map_y]}</a>
								<br/>
								Distance : <math oper="max(abs({result[map_x]} -{_user[map_x]}),abs({result[map_y]}-{_user[map_y]}))" />
							</fieldset>
						</li>
					</if>
				</foreach>
			</ul>
		</if>
		<if cond="!empty({leg_array})">
			<h4>Légion en déplacement :</h4>
			<ul>
				<foreach cond="{leg_array} as {result}">
					<li>
						<img src="img/info.png" alt="Info" title="Info sur {result[leg_name]}" id="leg{result[leg_id]}" class="toggle" />
						- <a href="leg-view.html?lid={result[leg_id]}">{result[leg_name]}</a> 
						vers
						<img src="img/{result[race_dest]}/{result[race_dest]}.png" alt="{result[pseudo_dest]}" title="{result[pseudo_dest]}" /> 
						<zurlmbr mid="{result[mid_dest]}" pseudo="{result[pseudo_dest]}"/>

						<fieldset id="leg{result[leg_id]}_toggle" style="display: none;">
							Nourriture : {result[lres_nb]} <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
							Position : <a href="carte.html?map_cid={result[leg_cid]}">voir</a> ({result[leg_x]}x{result[leg_y]})<br/>
							Distance : <math oper="max(abs({result[leg_x]} -{_user[map_x]}),abs({result[leg_y]}-{_user[map_y]}))" /><br/>
							Vitesse : {result[leg_vit]}
						</fieldset>
					</li>
				</foreach>
			</ul>
		</if>
		<if cond="!empty({pos_array})">
		<h4>Légion en position d'attaque :</h4>
			<ul>
				<foreach cond="{pos_array} as {result}">
					<li>
						<img src="img/plus.png" alt="Info" title="Info sur {result[leg_name]}" id="leg{result[leg_id]}" class="toggle" />
						- <a href="leg-view.html?lid={result[leg_id]}">{result[leg_name]}</a> 
						chez
						<img src="img/{result[race_dest]}/{result[race_dest]}.png" alt="{result[dest_pseudo]}" title="{result[dest_pseudo]}" />
						<zurlmbr mid="{result[mid_dest]}" pseudo="{result[dest_pseudo]}"/>

						<fieldset id="leg{result[leg_id]}_toggle" style="display: none;">
							Nourriture : {result[lres_nb]} <zimgres type="{GAME_RES_BOUF}" race="{_user[race]}" /><br/>
							Vitesse : {result[leg_vit]}<br/>
							Position : <a href="carte.html?map_cid={result[leg_cid]}">voir</a><br/>
							<img src="img/{_user[race]}/div/atq.png" alt="Attaquer" /> - <a href="leg-view.html?lid={result[leg_id]}">Attaquer !</a>
							- <a href="leg-move.html?sub=sou&cid={_user[mapcid]}&lid={result[leg_id]}">Rentrer</a>
						</fieldset>
					</li>
				</foreach>
			</ul>
		</if>
		
		<h4>En vente :</h4>
		<if cond='{vente_array}'>
		<ul>
			<foreach cond='{vente_array} as {key} => {com_value}'>
			<li>
				{com_value[mch_nb]} <zimgres type="{com_value[mch_type]}" race="{_user[race]}" />
				pour {com_value[mch_prix]} <zimgres type="1" race="{_user[race]}" /> -
				<if cond="{com_value[mch_etat]} == {COM_ETAT_OK}">En vente.</if>
				<else>En Attente ...</else>
			</li>
			</foreach>
		</ul>
		</if>
		<else>
			Rien
		</else>
	</td>
</tr>
<tr>
	<td>
	<h4>Bâtiment en réparation :</h4>
		<if cond='{btc_rep}'>
		<ul>
			<foreach cond='{btc_rep} as {btc_nid} => {btc_infos}'>
			<li>
				<set name="btc_id" value="{btc_infos[btc_type]}" />
				<zimgbtc race="{_user[race]}" type="{btc_infos[btc_type]}" /> {btc[{_user[race]}][alt][{btc_id}]}<br/>
				<zimgbar per="{btc_infos[btc_vie]}" max="{btc_conf[{btc_id}][vie]}" /> <em>{btc_infos[btc_vie]}/{btc_conf[{btc_id}][vie]}</em>
			</li>
			</foreach>
		</ul>
		</if>
		<else>
			Aucun.
		</else>

	<h4>Bâtiment en train de brûler :</h4>
		<if cond='{btc_bru}'>
		<ul>
			<foreach cond='{btc_bru} as {btc_nid} => {btc_infos}'>
			<li>
				<set name="btc_id" value="{btc_infos[btc_type]}" />
				<zimgbtc race="{_user[race]}" type="{btc_infos[btc_type]}" /> {btc[{_user[race]}][alt][{btc_id}]}<br/>
				<zimgbar per="{btc_infos[btc_vie]}" max="{btc_conf[{btc_id}][vie]}" /> <em>{btc_infos[btc_vie]}/{btc_conf[{btc_id}][vie]}</em>
			</li>
			</foreach>
		</ul>
		</if>
		<else>
			Aucun.
		</else>

	<h4>Bâtiment en construction :</h4>
		<if cond='{btc_todo}'>
		<ul>
			<foreach cond='{btc_todo} as {btc_nid} => {btc_infos}'>
			<li>
				<set name="btc_id" value="{btc_infos[btc_type]}" />
				<zimgbtc race="{_user[race]}" type="{btc_infos[btc_type]}" /> {btc[{_user[race]}][alt][{btc_id}]}<br/>
				<zimgbar per="{btc_infos[btc_vie]}" max="{btc_conf[{btc_id}][vie]}" /> <em><math oper='floor(({btc_infos[btc_vie]}) / {btc_conf[{btc_id}][vie]}*100)' />%</em>
			</li>
			</foreach>
		</ul>
		</if>
		<else>
			Aucun.
		</else>

	 <if cond="{demn_ok}">
	<h4>Déménagement :</h4>

	<if cond="isset({depl_ok})">
		<if cond='{depl_ok} === true'><p class="ok">La caravane se met en route !</p></if>
		<elseif cond='{depl_ok} === false'>

			<fieldset><legend>Déplaçons notre village aux coordonnées:</legend>
				<form method="post" action="gen.html?sub=move">
					<label for="map_x">X :</label><input type="text" size="6" id="map_x" name="map_x">
					<label for="map_y">Y :</label><input type="text" size="6" id="map_y" name="map_y">
					<label for="map_cid"> ou donner le map_cid :</label><input type="text" size="6" id="map_cid" name="map_cid">
					<br/>
					<input type="button" value="Vérifier la case" onclick="return showMapInfo();" />
					<input type="submit" value="Déménagement"/>
				</form>
				<div id="carte_infos"></div>
			</fieldset>
		</elseif>
		<elseif cond='{depl_ok} === "no_free"'><p class="error">La destination n'est pas un emplacement libre ! {depl_ok}</p></elseif>
		<elseif cond='{depl_ok} === "out"'><p class="error">La destination est hors carte !</p></elseif>
		<elseif cond='{depl_ok} === "unt_au_vlg"'><p class="error">La caravane est au village. Vous devez déplacer cette unité dans une légion. N'oubliez pas de prévoir assez de nourriture pour qu'elle se rende jusqu'à sa destination!</p></elseif>
		<else><p>Déménagement en cours... <zimgbar per="{depl_ok}" max="1" /> <em><math oper='floor({depl_ok}*100)' />%</em></p></else>
	</if>

</if>
	</td>

	<td>

	
	<h4>Recherches en cours :</h4>
		<if cond='{src_todo}'>
		<ul>
			<foreach cond='{src_todo} as {src_result}'>
			<li>
				<set name="src_type" value="{src_result[stdo_type]}" />
				<zimgsrc race="{_user[race]}" type="{src_type}" /> {src[{_user[race]}][alt][{src_type}]} <br />
				<zimgbar per="{src_result[raf]}" max="{src_conf[{src_type}][tours]}" /> <em><math oper='round(100-({src_result[stdo_tours]} / ({src_conf[{src_type}][tours]})*100))' />%</em>
			</li>
			</foreach>
		</ul>
		</if>
		<else>
			Aucune
		</else>

	<h4>Unités en formation :</h4>
		<if cond='{unt_todo}'>
		<ul>
			<foreach cond='{unt_todo} as {unt_result}'>
			<li><zimgunt race="{_user[race]}" type="{unt_result[utdo_type]}" /> {unt_result[utdo_nb]} <br />
			</li>
			</foreach>
		</ul>
		</if>
		<else>
			Aucune unité en formation.
		</else>

	<h4>Ressources :</h4>
		<if cond='{res_todo}'>
		<ul>
			<foreach cond='{res_todo} as {res_result}'>
			<li><zimgres race="{_user[race]}" type="{res_result[rtdo_type]}" /> {res_result[rtdo_nb]}
			</li>
			</foreach>
		</ul>
		</if>
		<else>
			Aucune ressource en fabrication.
		</else>
	</td>
</tr>
</table>
