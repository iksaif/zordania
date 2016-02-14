<if cond='{_display} == "xml"'>
Votre vente de 
{vars[histo_vars][mch_nb]} {res[{_user[race]}][alt][{vars[histo_vars][mch_type]}]}
contre 
{vars[histo_vars][mch_prix]} {res[{_user[race]}][alt][1]}
a été achetée par {vars[mbr_pseudo]}
</if>
<else>
Votre vente de 
{vars[histo_vars][mch_nb]} <zimgres type="{vars[histo_vars][mch_type]}" race="{_user[race]}" /> 
contre 
{vars[histo_vars][mch_prix]} <zimgres type="1" race="{_user[race]}" /> 
a été achetée par
<img src="img/groupes/{vars[mbr_gid]}.png" alt="{groupes[{vars[mbr_gid]}]}" title="{groupes[{vars[mbr_gid]}]}"/>{vars[mbr_pseudo]}
</else>