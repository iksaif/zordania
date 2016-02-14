<dl>
<foreach cond="{leg_array} as {leg}">
<if cond="!isset({thisetat}) || {leg[leg_etat]} == {thisetat}">
	<dt><if cond="!isset({thisetat})">{leg_etat[{leg[leg_etat]}]} : </if>
		{leg[leg_name]} <if cond='{leg[leg_etat]} == {LEG_ETAT_VLG}'>(Village)</if>
	</dt>
	<dd>
		<if cond="isset({unt_leg[{leg[leg_id]}]})"><p>
		<foreach cond="{unt_leg[{leg[leg_id]}]} as {type} => {nb}">
			<if cond='{type} != {hro_array[hro_type]}'>{nb} <zimgunt race="{leg_race}" type="{type}" /></if>
		</foreach>
		</p></if>

		<if cond='{hro_array[hro_id]} != 0 || isset({hro_array[leg_id]})'> 
		<if cond='{leg[leg_id]} == {hro_array[leg_id]}'>
		<fieldset><legend>{hro_array[hro_nom]}</legend>
			<zimgunt race="{leg_race}" type="{hro_array[hro_type]}" />
			<zimgbar per="{hro_array[hro_vie]}" max="{hro_array[hro_vie_conf]}" />
			Vie: {hro_array[hro_vie]} / {hro_array[hro_vie_conf]}
			<p>Expérience: {hro_array[hro_xp]}</p>
			<if cond='{hro_array[hro_vie]} <= 0'><p class="infos">Votre héros est mort...</p></if>
		</fieldset>
		</if>
		</if>


		<if cond="!empty({res_leg[{leg[leg_id]}]})">
		<p>
			<if cond='{_file}=="admin"'>
			<a href="admin-view.html?module=member&amp;mid={leg[leg_mid]}&amp;leg_res_init={leg[leg_id]}"><img src="img/drop.png" title="Vider ses ressources!"/></a>
			</if>
			<foreach cond="{res_leg[{leg[leg_id]}]} as {type} => {nb}">
				<if cond="{nb}">{nb} <zimgres race="{leg_race}" type="{type}" /></if>
			</foreach>
		</p>
		</if>

	</dd>
</if>
</foreach>
</dl>
