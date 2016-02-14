<p>Compétence <zimgcomp type="{cpt[cpid]}" race="{cpt[race]}" /> active, procurant une réduction de {cpt[bonus]} % sur tous les achats !
<if cond="isset({cpt[res]})">
<foreach cond="{cpt[res]} as {type} => {nb}">
	<if cond="{type} == {GAME_RES_PRINC}">Vous payez {nb} <zimgres type="{type}" race="{cpt[race]}" /> pour acheter : </if>
	<else>{nb} <zimgres type="{type}" race="{cpt[race]}" /></if>
</foreach>
</if>
</p>
