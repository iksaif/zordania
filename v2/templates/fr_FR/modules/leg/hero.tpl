<if cond='isset({no_bid})'>
	<p class="error">Vous devez sélectionner une compétence.</p>
</if>
<elseif cond='isset({bad_bid})'>
	<p class="error">Votre héros ne peut invoquer cette compétence.</p>
</elseif>
<elseif cond='isset({ok_bonus})'>
	<p class="ok">Compétence <if cond="{ok_bonus} == 0">annulée.</if><else>activée.</else></p>
</elseif>
<elseif cond='isset({move_error})'>
	<p class="error">Erreur ! La légion n'existe pas ou elle n'est pas rentrée au village.</p>
</elseif>
<elseif cond='isset({no_id_form})'>
	<p class="error">Vous devez sélectionner un héros.</p>
</elseif>
<elseif cond='isset({already_hro})'>
	<p class="error">Erreur. Vous avez déjà un héros.</p>
</elseif>
<elseif cond='isset({bad_hid})'>
	<p class="error">Erreur : ce héros n'existe pas.</p>
</elseif>
<elseif cond='isset({error_form})'>
	<p class="error">Votre héros n'a pas assez d'expérience !</p>
</elseif>
<elseif cond='isset({bad_lid_hro})'>
	<p class="error">Cette légion n'existe pas.</p>
</elseif>
<elseif cond='isset({ok_hero_move})'>
	<p class="ok">Ok Héros déplacé.</p>
</elseif>
<elseif cond='isset({ok_del_hro})'>
	<p class="ok">{ok_del_hro} n'est plus. Son âme repose en paix auprès de ses ancêtres...</p>
</elseif>
<elseif cond='isset({no_res_hro})'>
	<p class="error">Vous n'avez pas les ressources nécessaires pour former ce héros.
	<foreach cond="{no_res_hro} as {what} => {arr_qte}">
		<if cond='{what} == "need_src"'><foreach cond="{arr_qte} as {type} => {nb}">
			{nb} <zimgsrc type="{type}" race="{_user[race]}" /></foreach>
		</if>
		<elseif cond='{what} == "need_btc"'><foreach cond="{arr_qte} as {type} => {nb}">
			 {nb} <zimgbtc type="{type}" race="{_user[race]}" /></foreach>
		</elseif>
		<elseif cond='{what} == "prix_res"'><foreach cond="{arr_qte} as {type} => {nb}">
			 {nb} <zimgres type="{type}" race="{_user[race]}" /></foreach>
		</elseif>
		<elseif cond='{what} == "prix_unt"'><foreach cond="{arr_qte} as {type} => {nb}">
			 {nb} <zimgunt type="{type}" race="{_user[race]}" /></foreach>
		</elseif>
		<elseif cond="{arr_qte} > 0"> Limite atteinte : {arr_qte}</else>
	</foreach>
	</p>
</elseif>
<elseif cond='isset({no_name})'>
	<form method="post" action="leg-hero.html?sub=form&id_hro={id_hro}">
		<fieldset>			
			<legend>Vous devez donner un nom à votre héros</legend>
			<label for="hro_name">Nom :</label>
			<input type="text" name="hro_name" id="hro_name" />
			<input type="submit" value="Valider" />
		</fieldset>
	</form>
</elseif>
<elseif cond='isset({no_hero})'>
	<p class="error">Vous n'avez aucun héros.</p>
</elseif>
<else>
	<div class="block">
		<if cond='isset({verif_del_hro})'>
			<form method="post" action="leg-hero.html?sub=del_hero" class="infos">
			Êtes-vous sûr de vouloir supprimer votre Héros ?
				<input name="Oui" type="submit" value="Oui" />
			</form>
		</if>
		<elseif cond='isset({ok_form_hro})'>
			<p class="ok">Ok, Héros créé. Envoyez le au combat pour l'aguerrir et lui faire gagner de l'expérience...
			<br />Longue vie à {_user[hro_nom]} !</p>
		</elseif>
		<if cond='{_user[hro_vie]} <= 0'>
			<p class="infos">Votre héros est mort...<br/>
			Vous devez le supprimer avant de pouvoir en former un autre.</p>
		</if>

		<h3>{_user[hro_nom]}</h3>
		<table class="liste"><tr><td style="width: 50%">

			<p><img src="img/{_user[race]}/unt/{_user[hro_type]}.png" title="{_user[hro_nom]}" /></p>
			<p><zimgbar per="{_user[hro_vie]}" max="{_user[hro_vie_conf]}" />Vie: {_user[hro_vie]} / {_user[hro_vie_conf]}</p>
			<p>Expérience: {_user[hro_xp]}</p>
		
		</td><td style="width: 50%">

			<if cond='isset({leg_array}) && {_user[hro_vie]} > 0'>
			<form method="post" action="leg-hero.html?sub=move_hero">
				<label for="to">Déplacer le héros vers</label><br />
				<select name="to" id="to">
				<foreach cond="{leg_array} as {value}">
					<if cond='{_user[hro_lid]} != {value[leg_id]}'><option value="{value[leg_id]}">
						<if cond='{value[leg_etat]} != {LEG_ETAT_VLG}'>{value[leg_name]}</if>
						<else>Rentrer au village</else>
					</option>
					</if>
				</foreach>
				</select>
				<br /><input type="submit" value="Déplacer" />
			</form>
			</if>
			<elseif cond='{_user[hro_vie]} <= 0'><p class="error">Votre héros est mort...<br/>
				Vous devez le supprimer avant de pouvoir en former un autre.</p></elseif>
			<else>Le héros doit être au village pour changer de légion.</else>
			<hr /><a href="leg-hero.html?sub=del_hero">Supprimer son Héros</a>

		</td></tr></table>

		<hr />
		<if cond='isset({bonus_already})'>
			<h2>Compétences</h2>
			<set name="compa" value="{comp_array[{_user[bonus]}]}" />
			<dl>
				<dt>En cours : {comp[{_user[race]}][alt][{_user[bonus]}]}</dt>
				<dd>						
					<zimgcomp type="{_user[bonus]}" race="{_user[race]}" />
					<p><strong>Fin le : {_user[bonus_to]}</strong> (Durée totale : {compa[tours]} tours)
					<br />{comp[{_user[race]}][descr][{_user[bonus]}]}</p>
					<p>Vous pouvez <a href="leg-hero.html?sub=bns&amp;bid=0" title="annuler">annuler</a> la compétence pour en activer une autre. <span class="infos">Aucun remboursement d'XP!</span></p>
				</dd>
			</dl>
		</if>
		<elseif cond='{_user[hro_vie]} > 0'>
			<h2>Compétences</h2>
			<form method="post" action="leg-hero.html?sub=bns">
			<foreach cond='{comp_array} as {id} => {compa}'>
			<dl>
				<dt>
					<input type="radio" name="bid" id="bid{id}" value="{id}" />
					<label for="bid{id}"> Compétence {type_comp[{compa[type]}]} :
					<strong>{comp[{_user[race]}][alt][{id}]}</strong></label>
				</dt>
				<dd>						
					<zimgcomp type="{id}" race="{_user[race]}" class="blason" />
					<printf string="{comp[{_user[race]}][descr][{id}]}" vars="{compa[bonus]},{compa[tours]}" />
					<br/>
					<if cond="{compa[prix_xp]} > {_user[hro_xp]}"><spanp class="error">Coût: {compa[prix_xp]} XP</spanp></if>
					<else>Coût: <strong>{compa[prix_xp]} XP</strong></else>
				</dd>
			</dl>
			</foreach>
			<input type="submit" value="Envoyer" />
			</form>
		</elseif>

	</div>
</else>
