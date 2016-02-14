<p class="menu_module">
[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}">En Cours</a> 
]-[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=res">Dresser</a> 
]
</p>
<br />
<if cond='!|{btc_act}|'>
	<div class="block_1 center">
	 <h3>Dressages</h3><br />
	 <if cond='is_array(|{res_array}|)'>
	  <foreach cond='|{res_array}| as |{res_type}| => |{res_result}|'>
	  <img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" /> {res[alt][{res_type}]} - {res_result[res_nb]} - <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_res&amp;rid={res_result[res_rid]}">Annuler</a><br />
	  </foreach>
	 </if>
	 <else>
	  Aucun cheval en cours de dressage.
	 </else>
	</div>
</if>
<elseif cond='|{btc_act}| == "cancel_res"'>
	<if cond='|{btc_no_rid}| == true'>
		<p class="error">Aucune dressage sélectionnée.</p>
	</if>
	<elseif cond='|{btc_no_nb}| == true'>
		<p class="infos">Il faut choisir un nombre de chevaux à annuler.</p>
 		<form action="index.php?file=btc&amp;act=use&amp;btc_type=15&amp;sub=cancel_res&amp;rid={btc_rid}" method="post">
	        <input type="text" name="nb" size="1" maxlength="2"  />
	        <input type="submit" value="Annuler" />
	        </form>
	</elseif>	
	<elseif cond='|{btc_ok}| == true'>
		<p class="ok">Dressage annulée.</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
		<p class="error">Ces chevaux n'existent pas ou vous tentez d'annuler plus de chevaux qu'il n'y en a en cours de dressage.</p>
	</elseif>
</elseif>
<elseif cond='|{btc_act}| == "res"'>
	<if cond='is_array(|{res_dispo}|)'>
	  
	   <foreach cond='|{res_dispo}| as |{res_id}| => |{res_array}|'>
	    
	    <if cond='|{res_array[dispo]}| <= 2'>
	    
	    <if cond='!|{current_group}| OR |{current_group}| != |{res_array[vars][group]}|'>
	    	<if cond='|{current_group}|'>
	    	 </tr>
	    	 </table>
	    	 </div>
	    	</if>
		<set name="group_open" value="1"/>
	    	<set name="current_group" value="{res_array[vars][group]}" />
	    	<set name="current_group_nb" value="0" />
	    	<div id="res_group_{current_group}">
	    	<a id="res_group_{current_group}_toggle" href="javascript:toggle('res_group_{current_group}');"><img src="img/minus.png" alt="-" /></a>
	    	<table class="border1">
	    	<tr>
	    </if>
	    
	    <td>
	       <img src="img/{session_user[race]}/res/{res_id}.png" alt="{res[alt][{res_id}]}" title="{res[alt][{res_id}]}" /> 
	       {res[alt][{res_id}]} <br/>
	       <if cond='|{res_in_db[{res_id}][res_nb]}|'>
	        Stock: {res_in_db[{res_id}][res_nb]}
	       </if>
	       <else>
	        Stock: 0
	       </else>
	       <br/>
	       Prix :
 	       <if cond='is_array(|{res_array[vars][needres]}|)'>
 		 <foreach cond='|{res_array[vars][needres]}| as |{res_type}| => |{res_this_nb}|'>
 		 	{res_this_nb}<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		 </foreach>
  	       </if>
	       <div style="display:block;" id="descr_res_group_{current_group}_{current_group_nb}">
	        <set name="current_group_nb" value="<math oper='{current_group_nb}+1' />" />
  	       <p>
  	       {res[descr][{res_id}]}
  	       </p>
  	       </div>
	       <form action="index.php?file=btc&amp;act=use&amp;btc_type=15&amp;sub=add_res" method="post">
	       <input type="hidden" name="type" value="{res_id}" />
	       <input type="text" name="nb" size="1" maxlength="2"  />
	       <input type="submit" value="Dresser" />
	       </form>
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
	  <foreach cond='|{res_dispo}| as |{src_id}| => |{res_array}|'>    
	    <if cond='|{res_array[dispo]}| <= 2 AND !|{group_block_{res_array[vars][group]}}|'>
	    <set name="group_block_{res_array[vars][group]}" value="ok" />
	    toggle('res_group_{res_array[vars][group]}');
	    </if>
	  </foreach>
	  -->
	  </script>
	 </if>
</elseif>
<elseif cond='|{btc_act}| == "add_res"'>
	<if cond='|{btc_no_type}| == true'>
	<p class="error">Aucun type spécifié.</p>
	</if>
	<elseif cond='|{btc_no_nb}| == true'>
	<p class="error">Il faut choisir un nombre de chevaux à dresser.</p>
	</elseif>	
	<elseif cond='|{btc_res_not_exist}| == true'>
	<p class="error">Ce type n'existe pas.</p>
	</elseif>	
	<elseif cond='|{btc_res_max}|'>
	<p class="infos">Nombre maximal de ressource en fabrication simultanées atteint ({btc_res_max})</p>
	</elseif>
	<elseif cond='|{btc_not_enough_res}| == true'>
	<p class="error">Pas assez de ressources.</p>
	</elseif>
	<elseif cond='|{btc_ok}| == true'>
	<p class="ok">Chevaux en dressage !</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
	<p class="error">Erreur.</p>
	</elseif>			
</elseif>