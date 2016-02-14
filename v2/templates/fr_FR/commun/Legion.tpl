<# une légion : ses unités ses caractéristiques son butin son héro
unit (array) = liste des unités
res (array) = butin 
leg_race = {user[race]} 
hero pris dans la globale {_user}

include générique :
<include file="commun/listUnt.tpl" ... />
#>

<# liste des variables facultatives : on leur colle une valeur par defaut #>
<if cond="!isset({leg_etat})"><set name="leg_etat" value="0"/></if>
<if cond="!isset({leg_race})"><set name="leg_race" value="{_user[race]}"/></if>


<# liste des unités #>
<if cond="isset({unit})"><include file="commun/listUnt.tpl" leg_race="{leg_race}" unit="{unit}" /></if>

<# le héro s'il est dans cette légion #>
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

<# le butin #>
<if cond="isset({res})"><include file="commun/listRes.tpl" leg_race="{leg_race}" res="{res}" /></if>

