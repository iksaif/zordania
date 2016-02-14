<if cond='isset({cant_form})'>
	<p class="error">Vous pensez vraiment qu'avec la fin du monde des hommes sont prêt à vous suivre ? Peine perdu, vous êtes seul...</p>
</if>
<elseif cond='|{btc_act}| == "cancel_unt"'>
	<if cond='|{btc_no_uid}| == true'>
		<p class="error">Aucune unité sélectionnée.</p>
	</if>
	<elseif cond='|{btc_no_nb}| == true'>
		<p class="infos">Il faut choisir un nombre d'unités à annuler.</p>
 		<form action="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_unt&amp;uid={btc_uid}" method="post">
	        <input type="text" name="nb" size="1" maxlength="2"  />
	        <input type="submit" value="Annuler" />
	        </form>
	</elseif>	
	<elseif cond='|{btc_ok}| == true'>
		<p class="ok">Unité(s) annulée(s).</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
		<p class="error">Ces unités n'existent pas ou vous tentez d'en annuler plus qu'il n'y en a en cours.</p>
	</elseif>
</elseif>
<elseif cond='|{btc_act}| == "unt"'>
 	<if cond='is_array(|{unt_array}|)'>
	 <div class="block_1">
	 <h3>{btcopt[{session_user[race]}][{btc_id}][unt_enc]}</h3>
	  <foreach cond='|{unt_array}| as |{unt_type}| => |{unt_result}|'>
	  <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[{session_user[race]}][alt][{unt_type}]}" title="{unt[{session_user[race]}][alt][{unt_type}]}" /> {unt[{session_user[race]}][alt][{unt_type}]} - {unt_result[unt_nb]} - <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_unt&amp;uid={unt_result[unt_uid]}">Annuler</a><br />
	  </foreach>
	</div>
	</if>
	
	<p class="infos">Les unités "disponibles" sont les unités formées qui ne travaillent pas dans un bâtiments, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
   	
   	<if cond='is_array(|{res_array}|)'>
   			<a id="res_infos_toggle" href="javascript:toggle('res_infos');"><img src="img/minus.png" alt="-" /></a> Ressources
   			<div id="res_infos" class="border1">
   			<div style="display:block;" id="descr_res_infos_0">
   			<table class="border1">
   				<tr>
   					<th>Type</th>
   					<th>Nombre</th>
   				</tr>
   				<foreach cond='|{res_array}| as |{res_id}| => |{res_value}|'>
   				<tr>
 					<td><img src="img/{session_user[race]}/res/{res_id}.png" alt="{res[{session_user[race]}][alt][{res_id}]}" title="{res[{session_user[race]}][alt][{res_id}]}" /> {res[{session_user[race]}][alt][{res_id}]}</td>
   					<td><math oper="{res_value[res_nb]}+0" /></td>      
   				</tr>
   				</foreach>
   			</table>
   			</div>
   			</div>
   			<script type="text/javascript">
			toggle("res_infos");
   			</script>
   	</if>
   	  <if cond='is_array(|{unt_utils}|)'>
   			<a id="unt_infos_toggle" href="javascript:toggle('unt_infos');"><img src="img/minus.png" alt="-" /></a> Unités
   			<div id="unt_infos" class="border1">
   			<div style="display:block;" id="descr_unt_infos_0">
   			<table class="border1">
   				<tr>
   					<th>Type</th>
   					<th>Nombre</th>
   				</tr>
   				<foreach cond='|{unt_utils}| as |{unt_id}| => |{unt_value}|'>
   				<tr>
 					<td><img src="img/{session_user[race]}/unt/{unt_id}.png" alt="{unt[{session_user[race]}][alt][{unt_id}]}" title="{unt[{session_user[race]}][alt][{unt_id}]}" /> {unt[{session_user[race]}][alt][{unt_id}]}</td>
   					<td><math oper="{unt_value}+0" /></td>      
   				</tr>
   				</foreach>
   			</table>
   			</div>
   			</div>
   			<script type="text/javascript">
			toggle("unt_infos");
   			</script>
   	</if>
   	<br/>
	<if cond='is_array(|{unt_dispo}|)'>

	   <foreach cond='|{unt_dispo}| as |{unt_id}| => |{unt_array}|'>
	    
	    <if cond='|{unt_array[dispo]}| <= 2'>
	   
	    <if cond='!|{current_group}| OR |{current_group}| != |{unt_array[vars][group]}|'>
	    	 <if cond='|{current_group}|'>
	    	 </tr>
	    	 </table>
	    	 </div>
	    	 </if>
		<set name="group_open" value="1"/>
	    	<set name="current_group" value="{unt_array[vars][group]}" />
	    	<set name="current_group_nb" value="0" />
	    	<div id="unt_group_{current_group}">
	    	<a id="unt_group_{current_group}_toggle" href="javascript:toggle('unt_group_{current_group}');"><img src="img/minus.png" alt="-" /></a>
	    	<table class="border1">
	    	<tr>
	    </if>
	    
	    <td>
	      <img src="img/{session_user[race]}/unt/{unt_id}.png" alt="{unt[{session_user[race]}][alt][{unt_id}]}" title="{unt[{session_user[race]}][alt][{unt_id}]}" /> - 
	      {unt[{session_user[race]}][alt][{unt_id}]} <br/>
	      <if cond='|{unt_in_db[1][{unt_id}][unt_nb]}|'>
	      Disponibles: {unt_in_db[1][{unt_id}][unt_nb]} / Total: <math oper='({unt_in_db[0][{unt_id}][unt_nb]} + {unt_in_db[1][{unt_id}][unt_nb]})' />
	      </if>
	      <elseif cond='|{unt_in_db[0][{unt_id}][unt_nb]}|'>
	       Disponible: 0 / Total: {unt_in_db[0][{unt_id}][unt_nb]}
	      </elseif>
	      <else>
	       Disponible: 0 / Total: 0
	      </else>  
	        <br />
	        Prix :
 		<if cond='is_array(|{unt_array[vars][prix]}|)'>
 		  <foreach cond='|{unt_array[vars][prix]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[{session_user[race]}][alt][{res_type}]}" title="{res[{session_user[race]}][alt][{res_type}]}" />
  		  </foreach>
  		  <if cond="is_array({unt_array[vars][needguy]})">
  		   <foreach cond='|{unt_array[vars][needguy]}| as |{unt_type}| => |{unt_nb}|'>
 		  	{unt_nb}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[{session_user[race]}][alt][{unt_type}]}" title="{unt[{session_user[race]}][alt][{unt_type}]}" />
  		  </foreach>
  		  </if>
	        <div style="display:block;" id="descr_unt_group_{current_group}_{current_group_nb}">
	        <set name="current_group_nb" value="<math oper='{current_group_nb}+1' />" />
  		  <if cond="{unt_array[vars][speed]}">
  		  <p>
  		  Attaque: {unt_array[vars][attaque]}<br />
  		  Attaque Batîments: {unt_array[vars][attaquebat]}<br />
  		  Défense: {unt_array[vars][defense]}<br />
  		  Vie: {unt_array[vars][vie]}<br />
  		  Vitesse: {unt_array[vars][speed]}	<br /> 
  		  </p>
  		  </if>
  		  <p>
  		  {unt[{session_user[race]}][descr][{unt_id}]}
  		  </p>
  		 </div>
  		<form action="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=add_unt" method="post">
	        <input type="hidden" name="type" value="{unt_id}" />
	        <input type="text" name="nb" size="1" maxlength="2"  />
	        <input type="submit" value="{btcopt[{session_user[race]}][{btc_id}][unt]}" />
	        </form>
  		</if>
  	     </td>
	    </if>
	  </foreach>
	  <if cond="{group_open}">
	  	</tr>
	  	</table>
	  	</div>
	  </if>	 
	  <script type="text/javascript">
	  <!--
	  <foreach cond='|{unt_dispo}| as |{unt_id}| => |{unt_array}|'>    
	    <if cond='|{unt_array[dispo]}| <= 2 AND !|{group_block_{unt_array[vars][group]}}|'>
	    <set name="group_block_{unt_array[vars][group]}" value="ok" />
	    toggle('unt_group_{unt_array[vars][group]}');
	    </if>
	  </foreach>
	  -->
	  </script>
	</if>
	<else>
		<p class="infos">Vous n'avez pas assez d'or.</p>
	</else>
</elseif>
<elseif cond='|{btc_act}| == "add_unt"'>
	<if cond='|{btc_no_type}| == true'>
	<p class="error">Aucun type spécifié.</p>
	</if>
	<elseif cond='|{btc_no_nb}| == true'>
	<p class="error">Il faut choisir un nombre d'unités.</p>
	</elseif>	
	<elseif cond='|{btc_unt_not_exist}| == true'>
	<p class="error">Ce type d'unité n'existe pas.</p>
	</elseif>	
	<elseif cond='|{btc_unt_max}| == true'>
	<p class="infos">Nombre maximal de formations simultanées atteint</p>
	</elseif>
	<elseif cond='|{btc_not_enough_res}| == true'>
	<p class="error">Pas assez de ressources, de logements (maisons) ou nombre maximal d'unité atteint ({max_unt_nb}).</p>
	</elseif>
	<elseif cond='|{btc_ok}| == true'>
	<p class="ok">Unité(s) en formation !</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
	<p class="error">Erreur.</p>
	</elseif>
</elseif>
