
<if cond='!|{res_act}|'>
 <if cond='is_array(|{res_dispo}|)'>
   <table class="border1">
   <tr>
    <th>Type</th>
    <th>Nombre</th>
   </tr>
   <foreach cond='|{res_dispo}| as |{res_id}| => |{res_array}|'>
   <tr>
   <td><img src="img/{session_user[race]}/res/{res_id}.png" alt="{res[{session_user[race]}][alt][{res_id}]}" title="{res[{session_user[race]}][alt][{res_id}]}" /> {res[{session_user[race]}][alt][{res_id}]}</td>
   <td><math oper="{res_array[in_db][res_nb]}+0" /></td>      
   </tr>    
  </foreach>
  </table>
  <br />
  <p class="center">
  <a href="index.php?file=bonus" OnClick="lien_bg(this.href);return false;" title="Gagner des ressources !" class="bonus">Gagner des ressources</a>
  </p>
 </if>
</if>