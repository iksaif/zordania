<p class="menu_module">
[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}">En cours</a> 
]-[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=src">Recherches</a> 
]-[
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=unt">Unités Civiles</a>
]
</p>
<br />

<if cond='!|{btc_act}|'>
	
	<table class="width100">
	<tr>
	<td class="block_1">
	 <h3>Unités en formation</h3>
	 <if cond='is_array(|{unt_array}|)'>
	  <foreach cond='|{unt_array}| as |{unt_type}| => |{unt_result}|'>
	  <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" /> {unt[alt][{unt_type}]} - {unt_result[unt_nb]} - <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_unt&amp;uid={unt_result[unt_uid]}">Annuler</a><br />
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
	   <img src="img/{session_user[race]}/src/{src_type}.png" alt="{src[alt][{src_type}]}" title="{src[alt][{src_type}]}" /> {src[alt][{src_type}]} -  <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_src&amp;sid={src_result[src_sid]}">Annuler</a><br />
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
<elseif cond='|{btc_act}| == "cancel_unt"'>
	<if cond='|{btc_no_uid}| == true'>
		<p class="error">Aucune unité sélectionnée.</p>
	</if>
	<elseif cond='|{btc_no_nb}| == true'>
		<p class="infos">Il faut choisir un nombre d'unités à annuler.</p>
 		<form action="index.php?file=btc&amp;act=use&amp;btc_type=1&amp;sub=cancel_unt&amp;uid={btc_uid}" method="post">
	        <input type="text" name="nb" size="1" maxlength="2"  />
	        <input type="submit" value="Annuler" />
	        </form>
	</elseif>	
	<elseif cond='|{btc_ok}| == true'>
		<p class="ok">Formation(s) annulée(s).</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
		<p class="error">Ces unités n'existent pas ou vous tentez d'annuler plus de formations qu'il n'y en a en cours.</p>
	</elseif>
</elseif>
<elseif cond='|{btc_act}| == "unt"'>
	<p class="infos">Les unités "disponibles" sont les unités formées qui ne travaillent pas dans un bâtiments, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
   
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
	      <img src="img/{session_user[race]}/unt/{unt_id}.png" alt="{unt[alt][{unt_id}]}" title="{unt[alt][{unt_id}]}" /> - 
	      {unt[alt][{unt_id}]} <br/>
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
 		  	{res_nb}<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		  </foreach>
	        <div style="display:block;" id="descr_unt_group_{current_group}_{current_group_nb}">
	        <set name="current_group_nb" value="<math oper='{current_group_nb}+1' />" />
  		  <p>
  		  {unt[descr][{unt_id}]}
  		  </p>
  		 </div>
  		<form action="index.php?file=btc&amp;act=use&amp;btc_type=1&amp;sub=add_unt" method="post">
	        <input type="hidden" name="type" value="{unt_id}" />
	        <input type="text" name="nb" size="1" maxlength="2"  />
	        <input type="submit" value="Former" />
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
	<p class="error">Il faut choisir un nombre d'unités à former.</p>
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
<elseif cond='|{btc_act}| == "cancel_src"'>
	<if cond='|{btc_no_sid}| == true'>
		<p class="error">Aucune recherche sélectionnée.</p>
	</if>	
	<elseif cond='|{btc_ok}| == true'>
		<p class="ok">Recherche annulée.</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
		<p class="error">Cette recherche n'existe pas.</p>
	</elseif>
</elseif>	
<elseif cond='|{btc_act}| == "src"'>
	<if cond='is_array(|{src_dispo}|)'>

	   <foreach cond='|{src_dispo}| as |{src_id}| => |{src_array}|'>
	    
	   <if cond='|{src_array[dispo]}| <= 2'>
	   <if cond='!|{current_group}| OR |{current_group}| != |{src_array[vars][group]}|'>
	    	 <if cond='|{current_group}|'>
	    	 </tr>
	    	 </table>
	    	 </div>
	    	 </if>
		<set name="group_open" value="1"/>
	    	<set name="current_group" value="{src_array[vars][group]}" />
	    	<set name="current_group_nb" value="0" />
	    	<div id="src_group_{current_group}">
	    	<a id="src_group_{current_group}_toggle" href="javascript:toggle('src_group_{current_group}');"><img src="img/minus.png" alt="-" /></a>
	    	<table class="border1">
	    	<tr>
	    </if>
	    
  	   <td>
	      <img src="img/{session_user[race]}/src/{src_id}.png" alt="{src[alt][{src_id}]}" title="{src[alt][{src_id}]}" /> 
	       {src[alt][{src_id}]}
	       <if cond='is_array(|{src_array[vars][prix]}|)'>
	        <br />Prix :
 		  <foreach cond='|{src_array[vars][prix]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		  </foreach>
  		</if>
  		<if cond='is_array(|{src_in_db[{src_id}]}|)'>
  		 <br/>
  		 <span class="red">Effectuée</span>
  		 <br/>
  		</if>
  		<else>
	         <form action="index.php?file=btc&amp;act=use&amp;btc_type=1&amp;sub=add_src" method="post">
	         <input type="hidden" name="type" value="{src_id}" />
	         <input type="submit" value="Rechercher" />
	         </form>
	        </else>
	        <div style="display:block;" id="descr_src_group_{current_group}_{current_group_nb}">
	        <set name="current_group_nb" value="<math oper='{current_group_nb}+1' />" />
	        <p>{src[descr][{src_id}]}</p>
	        </div>
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
	  <foreach cond='|{src_dispo}| as |{src_id}| => |{src_array}|'>    
	    <if cond='|{src_array[dispo]}| <= 2 AND !|{group_block_{src_array[vars][group]}}|'>
	    <set name="group_block_{src_array[vars][group]}" value="ok" />
	    toggle('src_group_{src_array[vars][group]}');
	    </if>
	  </foreach>
	  -->
	  </script>
	</if>
	<else>
		<p class="infos">Aucune recherche disponible.</p>
	</else>
</elseif>
<elseif cond='|{btc_act}| == "add_src"'>
	<if cond='|{btc_no_type}| == true'>
	<p class="error">Aucune recherche spécifiée.</p>
	</if>	
	<elseif cond='|{btc_src_not_exist}| == true'>
	<p class="error">Cette recherche n'existe pas.</p>
	</elseif>	
	<elseif cond='|{btc_not_enough_res}| == true'>
	<p class="error">Pas assez de ressources.</p>
	</elseif>
	<elseif cond='|{btc_src_max}| == true'>
	<div class="infos">Nombre maximal de recherches simultanées atteint.</a>
	</elseif>
	<elseif cond='|{btc_ok}| == true'>
	<p class="ok">Recherche en cours !</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
	<p class="error">Erreur.</p>
	</elseif>
</elseif>