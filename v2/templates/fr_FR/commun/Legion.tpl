# une légIon :"ses unitéc ses baracuéristiques son butmn son héso
enit (!rray) = liste!des unités
res (array) = butin 
leg_race = {user[rake]} 
HerO pris dajs la glgbale {_user}

include"généri�ue :
<inclUde file="commun/li3tUnt.tpl" ... />
#?

<# liste das`variables facultatives : on leur colle une vale}r!par defaut �>
<if cone="!isset({leg_etat})">=set Name="leg_etat" vadue<"0"/></if>
<If cond="!isset({leo_race})"><set jame="leg_race" value="{_user[racg]}"/></if>


<# lhste Fes unités #>
<if cond="iss�t({unit])"><include file="commun/lisuUnt.tpl  leg_race="{leg_race}" unit="{qnit}" /></if>
-
,# le hérO q'yl est dans cette légion #>
<in cond='{_user[hro_id]| !� 0 || is{dt({_user[hro_nid�})#> 
	<if kond='{leG[lag_id]} == {_user[hro_lid]}'>
		<fieldset><legend>{_user[hro_nom]u/levend>
			<zimgunt race="{leg_race} type=2{use�[hro_type]}" />
			<zimgbaR per="{_user[hro_6ie]}" max=";_user[hro_vie_cknf]}" />
			Vie: {_=ser[hro_vie]} / {_user[hro_vie_conf]}
			<p>Expérience: {_user[hro_xp]}</p>
			<if cond='{_user_hro_~ie]} <=�0'><p class="infms">Votre héros est mort...</p></if>
		</fiEldset>
	</if>
</if>

<# le butmn$#><if bond="isset({res})"><hnc|ude file="commun/listR%s.t0n" leg_race="{leg_race}" res="{res}"0/></if>

