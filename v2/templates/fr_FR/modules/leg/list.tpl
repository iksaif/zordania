<dl>
<foreach cond="{leg_array} as {leg}">
<if cond="!isset({thisetat}) || {leg[leg_etat]} == {thisetat}">
	<dt><if cond="!isset({thisetat})">{leg_etat[{leg[leg_etat]}]} : </if>
		{leg[leg_name]} <if cond='{leg[leg_etat]} == {LEG_ETAT_VLG}'>(Village)</if></dt>
	<dd>

		<if cond="isset({unt_leg[{leg[leg_id]}]})"><p>
		<foreach cond="{unt_leg[{leg[leg_id]}]} as {type} => {nb}">
			<if cond='{type} != {_user[hro_type]}'>{nb} <zimgunt race="{leg_race}" type="{type}" /></if>
		</foreach>
		</p></if>


		<if cond='{_user[hro_id]} != 0 || isset({_user[hro_lid]})'> 
		<if cond='{leg[leg_id]} == {_user[hro_lid]}'>
		<fieldset><legend>{_user[hro_nom]}</legend>
			<zimgunt race="{leg_race}" type="{_user[hro_type]}" />
			<zimgbar per="{_user[hro_vie]}" max="{_user[hro_vie_conf]}" />
			Vie: {_user[hro_vie]} / {_user[hro_vie_conf]}
			<p>Expérience: {_user[hro_xp]}</p>
			<if cond='{_user[hro_vie]} <= 0'><p class="infos">Votre héros est mort...</p></if>
		</fieldset>
		</if>
		</if>


		<if cond="isset({res_leg[{leg[leg_id]}]})">
		<p><foreach cond="{res_leg[{leg[leg_id]}]} as {type} => {nb}">
			<if cond="{nb}">{nb} <zimgres race="{leg_race}" type="{type}" /></if>
		</foreach></p>
		</if>


		<if cond='isset({leg_act}) && {leg_act} =="move" && isset({show_form}) && {show_form}'>
			<if cond="!isset({res_leg[{leg[leg_id]}]}) || !isset({res_leg[{leg[leg_id]}][{GAME_RES_BOUF}]}) || {res_leg[{leg[leg_id]}][{GAME_RES_BOUF}]} == 0"><span class="error">Aucune réserve de <zimgres race="{leg_race}" type="{GAME_RES_BOUF}" /></span></if>
			<input type="checkbox" name="move[{leg[leg_id]}]" id="move[{leg[leg_id]}]" />
			<label for="move[{leg[leg_id]}]"> Sélectionner pour envoyer</label>
			<if cond='{_user[hro_id]} != 0 && {leg[leg_id]} == {_user[hro_lid]}'>
				<input type="checkbox" name="tele[{leg[leg_id]}]" id="tele[{leg[leg_id]}]" />
				<label for="tele[{leg[leg_id]}]"> Sélectionner pour déplacement instantanné !</label>
			</if>
			<if cond="isset({leg_sqr[{leg[leg_cid]}]})">
				<h3>Position actuelle</h3>
				<set name="result" value="{leg_sqr[{leg[leg_cid]}]}" />
				<include file="modules/carte/tile.tpl" cache="1" /> 
			</if>
		</if>
		<elseif cond="{leg[mbr_mid]} == {_user[mid]}">
			<include file="modules/leg/act.tpl" cache="1" />
		</elseif>

	</dd>
</if>
</foreach>
</dl>
