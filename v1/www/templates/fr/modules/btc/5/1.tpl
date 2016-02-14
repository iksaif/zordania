<if cond='!|{btc_act}|'>
	
	<table class="width100">
	<tr>
	<td class="block_1">
	 <h3>Unités en formation</h3>
	 <if cond='is_array(|{unt_array}|)'>
	  <foreach cond='|{unt_array}| as |{unt_type}| => |{unt_result}|'>
	  <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[{session_user[race]}][alt][{unt_type}]}" title="{unt[{session_user[race]}][alt][{unt_type}]}" /> {unt[{session_user[race]}][alt][{unt_type}]} - {unt_result[unt_nb]} - <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_unt&amp;uid={unt_result[unt_uid]}">Annuler</a><br />
	  </foreach>
	 </if>
	 <else>
	  Aucune unité en formation.
	 </else>
	 </div>
	</td>
	
	<td class="block_1">
	 <h3>Recherches en cours</h3>
	 <if cond='is_array(|{src_array}|)'>
	  <foreach cond='|{src_array}| as |{src_type}| => |{src_result}|'>
	   <img src="img/{session_user[race]}/src/{src_type}.png" alt="{src[{session_user[race]}][alt][{src_type}]}" title="{src[{session_user[race]}][alt][{src_type}]}" /> {src[{session_user[race]}][alt][{src_type}]} -  <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_src&amp;sid={src_result[src_sid]}">Annuler</a><br />
	   <div class="barres_moyennes">
	    <div style="width:<math oper='floor(100-({src_result[src_tour]} / {src_infos[{src_type}][tours]})*100)' />%" class="barre_verte"></div>
  	    <div style="width:<math oper='floor((({src_result[src_tour]} / {src_infos[{src_type}][tours]})*100))' />%" class="barre_rouge"></div>
           </div> &nbsp;<em><math oper='round(100-({src_result[src_tour]} / ({src_infos[{src_type}][tours]})*100))' />%</em>
           <br /><br />
	  </foreach>
	 </if>
	 <else>
	  Aucune recherche en cours.
	 </else>
	</td>
	</tr>
	</table>
</if>