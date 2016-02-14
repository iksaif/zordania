<if cond='{_display} == "xml"'>
{vars[histo_vars][unt_nb]} {unt[{_user[race]}][alt][{vars[histo_vars][unt_type]}]} sont morts de faim dans votre légion {vars[histo_vars][leg_name]}
</if>
<else>
{vars[histo_vars][unt_nb]} <zimgunt type="{vars[histo_vars][unt_type]}" race="{_user[race]}" />
 sont morts de faim dans votre légion {vars[histo_vars][leg_name]}
</else>