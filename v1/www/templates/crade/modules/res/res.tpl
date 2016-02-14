
<if cond='!|{res_act}|'>
 <if cond='is_array(|{res_dispo}|)'>
   <div class="center list_univ">
   <div style="text-align: left; width: 45%;float:left;">
   <foreach cond='|{res_dispo}| as |{res_id}| => |{res_array}|'>
   
   <if cond='|{nb_is}|++'>
   </if>
   
   <if cond='|{res_nb}| <= |{nb_is}|*2 AND !|{nb_ok}|'>
       </div>
       <div style="text-align: left; width: 45%; float:right;">
       <if cond='|{nb_ok}| = true'>
       </if>
   </if>

     <if cond='|{res_array[in_db][res_nb]}|'>
     {res_array[in_db][res_nb]}
     </if>
     <else>
      0 
     </else>
      
     <img src="img/{session_user[race]}/res/{res_id}.png" alt="{res[alt][{res_id}]}" title="{res[alt][{res_id}]}" /> 
     
        <br />

  </foreach>
  </div>
  <div style="height:<math oper='{res_nb}*10' />px"></div>
  </div>
  <br />
  <p class="center">
  <a href="index.php?file=bonus" OnClick="lien_bg(this.href);return false;" title="Gagner des ressources !" class="bonus">Gagner des ressources</a>
  </p>
 </if>
</if>