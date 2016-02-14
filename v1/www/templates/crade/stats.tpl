Connectés <em>{stats_connected}</em>
<div class="barres_petites">
 <div class="barre_grisef" style="width:{stats_max_connected[0]}%"></div>
 <div class="barre_grisec" style="width:{stats_max_connected[1]}%"></div>
</div>  
<br />
Inscrits <em>{stats_inscrits}</em>
<div class="barres_petites">
 <div class="barre_grisef" style="width:{stats_max_inscrits[0]}%"></div>
 <div class="barre_grisec" style="width:{stats_max_inscrits[1]}%"></div>
</div>  
<br />
<span id="date_rebour">
{stats_date}<br />
Prochain Tour : <span id="comptearebour">{stats_next_turn}</span> min
</span>
<br />
<if cond='!|{ses_loged}|'>
  <foreach cond='|{lang}| as |{lang_abr}| => |{lang_name}|'>
  <a href="index.php?lang={lang_abr}"><img src="img/{lang_abr}.png" alt="{lang_abr}" title="{lang_name}" /></a>
	</foreach>
</if>
<if cond='is_array(|{stats_prim_res}|)'>
	<foreach cond='|{stats_prim_res}| as |{res_vars}|'>
	<img src="img/{session_user[race]}/res/{res_vars[res_type]}.png" alt="{res[alt][{res_vars[res_type]}]}" title="{res[alt][{res_vars[res_type]}]}" /> 
	<if cond='|{res_vars[res_type]}| == 20'>
	{stats_population}/
	</if>{res_vars[res_nb]}
	</foreach>
	<br />
	Points: {stats_points}
</if>
