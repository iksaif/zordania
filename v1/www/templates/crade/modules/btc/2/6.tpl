<p class="menu_module">
[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}">En Cours</a> 
]-[ 
<a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=unt">Entrainer</a> 
]-[
<a href="index.php?file=res" OnClick="my_popup('res', '', 300,300);return false;">Armes Disponibles</a>
]
</p>
<br />
<if cond='!|{btc_act}|'>
	<div class="block_1 center">
	 <h3>Unités en formation</h3><br />
	 <if cond='is_array(|{unt_array}|)'>
	  <foreach cond='|{unt_array}| as |{unt_type}| => |{unt_result}|'>
	  <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" /> {unt[alt][{unt_type}]} - {unt_result[unt_nb]} - <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_unt&amp;uid={unt_result[unt_uid]}">Annuler</a><br />
	  </foreach>
	 </if>
	 <else>
	  Aucune unité en formation.
	 </else>
	</div>
</if>
<elseif cond='|{btc_act}| == "cancel_unt"'>
	<if cond='|{btc_no_uid}| == true'>
		<p class="error">Aucune unité sélectionnée.</p>
	</if>
	<elseif cond='|{btc_no_nb}| == true'>
		<p class="infos">Il faut choisir un nombre d'unités à annuler.</p>
 		<form action="index.php?file=btc&amp;act=use&amp;btc_type=6&amp;sub=cancel_unt&amp;uid={btc_uid}" method="post">
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
	<div class="center">Orcs disponibles: {unt_in_db[1][6][unt_nb]} <img src="img/{session_user[race]}/unt/7.png" alt="{unt[alt][7]}" title="{unt[alt][7]}" /></div><br />
	
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
	      <img src="img/{session_user[race]}/unt/{unt_id}.png" alt="{unt[alt][{unt_id}]}" title="{unt[alt][{unt_id}]}" />
	      {unt[alt][{unt_id}]} <br/> 
	      <if cond='(|{unt_in_db[0][{unt_id}][unt_nb]}| + |{unt_in_db[1][{unt_id}][unt_nb]}|) > 0'>
	      Dans votre armée: <math oper='({unt_in_db[0][{unt_id}][unt_nb]} + {unt_in_db[1][{unt_id}][unt_nb]})' />
	      </if>
	      <else>
	      Dans votre armée:  aucun
	      </else> 
	        <br />
	        Prix :
 		<if cond='is_array(|{unt_array[vars][prix]}|)'>
 		  <foreach cond='|{unt_array[vars][prix]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		  </foreach>
	        <div style="display:block;" id="descr_unt_group_{current_group}_{current_group_nb}">
	        <set name="current_group_nb" value="<math oper='{current_group_nb}+1' />" />
  		 <br />Unités Nécessaires:
 		 <if cond='is_array(|{unt_array[vars][needguy]}|)'>
 		  <foreach cond='|{unt_array[vars][needguy]}| as |{unt_type}| => |{unt_nb_for}|'>
 		  	{unt_nb_for}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
  		  </foreach>
  		  <br />
  		  Attaque: {unt_array[vars][attaque]}<br />
  		  Attaque Batîments: {unt_array[vars][attaquebat]}<br />
  		  Défense: {unt_array[vars][defense]}<br />
  		  Vie: {unt_array[vars][vie]}<br />
  		  Vitesse: {unt_array[vars][speed]}	<br /> 
  		  <p>
  		  {unt[descr][{unt_id}]}
  		  </p>
  		 </if>
  		 </div>
  		 <form action="index.php?file=btc&amp;act=use&amp;btc_type=6&amp;sub=add_unt" method="post">
	         <input type="hidden" name="type" value="{unt_id}" />
	         <input type="text" name="nb" size="1" maxlength="2"  />
	         <input type="submit" value="Entrainer" />
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
	<p class="error">Il faut choisir un nombre d'unités à entrainer.</p>
	</elseif>	
	<elseif cond='|{btc_unt_not_exist}| == true'>
	<p class="error">Ce type d'unité n'existe pas.</p>
	</elseif>	
	<elseif cond='|{btc_unt_max}| == true'>
	<p class="infos">Nombre maximal de formations simultanées atteint</p>
	</elseif>
	<elseif cond='|{btc_not_enough_res}| == true'>
	<p class="error">Pas assez de ressources, de recrues, de place (maisons) ou nombre maximal d'unité atteint ({max_unt_nb}).</p>
	</elseif>
	<elseif cond='|{btc_ok}| == true'>
	<p class="ok">Unité(s) en formation !</p>
	</elseif>
	<elseif cond='|{btc_error}| == true'>
	<p class="error">Erreur.</p>
	</elseif>			
</elseif>