<# bandeau [general] [humain] [orc] [nain] [drow] [elfe] [gob]
select = la race sélectionnée
admin (bool) affiche les races cachées
general (bool) affiche l'item [general]
url = lien de redirection sans race={race_id}

include générique :
<include file="commun/races.tpl" select="{race_id}" admin="true" general="false" url="admin.html?module=unt" />
#>

<# liste des variables facultatives : on leur colle une valeur par defaut #>
<if cond="!isset({admin})"><set name="admin" value="0"/></if>
<if cond="!isset({general})"><set name="general" value="1"/></if>
<if cond="!isset({select})"><set name="select" value="0"/></if>

<if cond="!isset({url})"><p class="error">composant 'commun/races.tpl' : variable 'url' non définie.</p></if>

<else>
<p class="menu_module">

<if cond="{general}">[ 
	<if cond="{select} != 0"><a href="{url}&amp;race=0" title="Général">Général</a></if>
	<else>Général</else>
]</else>

<foreach cond="{race} as {race_id} => {race_name}">
<if cond="{race_id} != 0 and (isset({_races[{race_id}]}) or {admin})">[
<if cond="{select} != {race_id}">
	<a href="{url}&amp;race={race_id}">
		<img src="img/{race_id}/{race_id}.png" alt="{race_name}" title="{race_name}" /> {race_name}
	</a>
</if>
<else>
	<img src="img/{race_id}/{race_id}.png" alt="{race_name}" title="{race_name}" /> <strong>{race_name}</strong>
</else>]
</if></foreach>
</p>

</else>
