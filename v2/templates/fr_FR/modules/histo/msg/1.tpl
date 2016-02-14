<if cond='{_display} == "xml"'>
<if cond="{vars[histo_vars][cpid]} == 0">
Votre héros a annulé une compétence active.
</if><else>
Votre héros a invoqué sa compétence {comp[{_user[race]}][alt][{vars[histo_vars][cpid]}]} pour une durée de {vars[histo_vars][tours]} tours
</else>
</if>
<elseif cond="{vars[histo_vars][cpid]} == 0">
Votre héros a annulé une compétence active.
</elseif>
<else>
Votre héros a invoqué sa compétence <zimgcomp type="{vars[histo_vars][cpid]}" race="{_user[race]}" /> pour une durée de {vars[histo_vars][tours]} tours
</else>
