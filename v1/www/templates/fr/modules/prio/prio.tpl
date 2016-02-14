<p class="menu_module">
[
<a href="index.php?file=prio&amp;act=unt" title="Gestion des unités">Unités</a>
] - [
<a href="index.php?file=prio&amp;act=res" title="Gestion des ressources">Ressources</a>
]
</p>
<if cond="|{prio_act}| == 'unt'">

   <form action="index.php?file=prio&amp;act=unt" method="post">
   <table class="border1">
   <tr>
    <th>Type</th>
    <th>Priorité</th>
   </tr>
    <foreach cond='|{unt_dispo}| as |{unt_id}| => |{unt_array}|'>   
    <if cond='|{unt_array[dispo]}| <= 2'>
      <tr>
      <td>
      	<a href="index.php?file=unt&unt_type={unt_id}" title="Gerer les {unt[{session_user[race]}][alt][{unt_id}]}">
      	<img src="img/{session_user[race]}/unt/{unt_id}.png" alt="{unt[{session_user[race]}][alt][{unt_id}]}"  />
      	</a>
      	{unt[{session_user[race]}][alt][{unt_id}]}
      </td>
      <td>
      <select name="unt_prio[{unt_id}]">
      <foreach cond="|{prios}| as |{key}| => |{value}|">
      	<option value="{key}" <if cond="|{unt_infos[1][{unt_id}][unt_prio]}| == |{key}|">selected="selected"</if>>{value}</option>
      </foreach>
      </select>
      </td>
    </if>
  </foreach>
  </table>
  <input type="submit" value="Appliquer" />
  </form>
 </if>
<elseif cond="|{prio_act}| == 'res'">
   <if cond='is_array(|{res_dispo}|)'>
   <form action="index.php?file=prio&amp;act=res" method="post">
   <table class="border1">
   <tr>
    <th>Type</th>
    <th>Priorité</th>
   </tr>
   <foreach cond='|{res_dispo}| as |{res_id}| => |{res_array}|'>
   <if cond='|{res_array[dispo]}| <= 2 AND !|{res_conf[{res_id}][onlycron]}| AND !empty(|{res_conf[{res_id}]}|) AND !|{res_conf[{res_id}][nobat]}|'>
     <tr>
     <td>
     <img src="img/{session_user[race]}/res/{res_id}.png" alt="{res[{session_user[race]}][alt][{res_id}]}" title="{res[{session_user[race]}][alt][{res_id}]}" /> 
     {res[{session_user[race]}][alt][{res_id}]}
     </td>
     <td>
      <select name="res_prio[{res_id}]">
      <foreach cond="|{prios}| as |{key}| => |{value}|">
      	<option value="{key}" <if cond="|{res_infos[{res_id}][res_prio]}| == |{key}|">selected="selected"</if>>{value}</option>
      </foreach>
      </select>
     </td>
   </if>
  </foreach>
  </table>
    <input type="submit" value="Appliquer" />
  </form>
  </if>
</elseif>
