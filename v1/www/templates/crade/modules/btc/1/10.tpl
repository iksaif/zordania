<p class="menu_module">
[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}">En cours</a> 
]-[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=src">Rechercher</a> 
]
</p>
<br />

<if cond='!|{btc_act}|'>
	<div class="center block_1">
	 <h3>Recherches en cours</h3><br />
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
	</div>
</if>
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
	         <form action="index.php?file=btc&amp;act=use&amp;btc_type=10&amp;sub=add_src" method="post">
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