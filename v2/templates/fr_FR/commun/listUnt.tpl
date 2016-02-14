<# une légion : ses unités ses caractéristiques son butin son héro
unit (array) = liste des unités
lrace = _user[race]
label = facultatif
hero  = facultatif pris dans la globale _user

liste des variables facultatives : on leur colle une valeur par defaut #>
<if cond="!isset({leg_etat})"><set name="leg_etat" value="REQUIRED"/></if>
<if cond="!isset({lrace})"><set name="lrace" value="{_user[race]}"/></if>
<if cond="!isset({hero})"><set name="hero" value="{_user[hro_type]}"/></if>
<if cond="!isset({label})"><set name="label" value=""/></if>


<# liste des unités #>
<if cond="isset({unit})"><p>{label}
	<foreach cond="{unit} as {id} => {nb}">
		<if cond='{id} != {_user[hro_type]}'>{nb} <zimgunt race="{lrace}" type="{id}" /></if>
	</foreach>
</p></if>

