<if cond='{_display} == "xml"'>
{vars[mbr_pseudo]} vous a fait gagner
{vars[histo_vars][res_nb]} {res[{_user[race]}][alt][{vars[histo_vars][res_type]}]}
</if>
<else>
{vars[mbr_pseudo]} vous a fait gagner
{vars[histo_vars][res_nb]} <zimgres type="{vars[histo_vars][res_type]}" race="{_user[race]}" />
</else>