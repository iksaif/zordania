<# Liste des ressources
res (array) = butin 
leg_race = facultatif = {user[race]} 
#>

<# liste des variables facultatives : on leur colle une valeur par defaut #>
<if cond="!isset({leg_race})"><set name="leg_race" value="{_user[race]}"/></if>

<if cond="isset({res})">
	<p><foreach cond="{res} as {id} => {nb}">
		<if cond="{nb}">{nb} <zimgres race="{leg_race}" type="{id}" /></if>
	</foreach></p>
</if>

