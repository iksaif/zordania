<if cond='|{btc_trav}| == 0'>
	<p class="error">Vous n'avez aucun travailleur !</p>
	<hr />
</if>
<else>
	<p class="menu_module">Vous avez {btc_trav} <img src="img/{session_user[race]}/unt/1.png" alt="{unt[alt][1]}" title="{unt[alt][1]}" /> disponibles</p>
</else>
<if cond='!|{btc_act}|'>
 <if cond='is_array(|{btc_dispo}|)'>
  <div class="infos">
  Vous ne pouvez construire que les bâtiments pour lesquels vous disposez des unités et des ressources nécessaires.
  <br/>
  Vous ne pouvez voir que les bâtiments pour lesquels vous disposez des recherches et des bâtiments nécessaires.
  <br/>
  Chaque bâtiments ne peut être construit qu'un nombre de fois limité.
  <br/>
  Pour plus d’informations, lire le <a href="index.php?file=manual" title="Lire le Manuel">manuel</a>.
  </div>
  
<foreach cond='|{btc_dispo}| as |{btc_id}| => |{btc_array}|'>
   <if cond='|{btc_id}| != 1 AND |{btc_array[dispo]}| == 1'> 
 	<div class="list_univ">
 	<h2><img style="align: left" src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[alt][{btc_id}]}" title="{btc[alt][{btc_id}]}" /> {btc[alt][{btc_id}]}</h2>
 	<br />Défense: {btc_array[vars][defense]} 
 	<br />Temps : <if cond="{btc_trav}"><math oper='ceil({btc_array[vars][tours]} / {btc_trav})' /></if><else>{btc_array[vars][tours]}</else> Tour(s)
 	<span>
 	<br />Prix :
 	<if cond='is_array(|{btc_array[vars][prix]}|)'>
 		<foreach cond='|{btc_array[vars][prix]}| as |{res_type}| => |{res_nb}|'>
 		 	{res_nb}<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		</foreach>
  		<br />Unités Nécessaires:
 		<if cond='is_array(|{btc_array[vars][needguy]}|)'>
 			<foreach cond='|{btc_array[vars][needguy]}| as |{unt_type}| => |{unt_nb}|'>
 			 	{unt_nb}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
  			</foreach>	 
  		</if>
  		<else>
  		 	Aucune
  		</else>
  		<if cond='{btc_array[vars][population]}'>
 		<br/>Place : {btc_array[vars][population]} <img src="img/{session_user[race]}/res/20.png" alt="Population" /><br/>
 		</if>
 		</span>
		<if cond='|{btc_array[dispo]}| == 1'>
 			<br /><br /><a href="index.php?file=btc&amp;act=btc&amp;sub=btc&amp;type={btc_id}">Construire</a>
 		</if>
 	</if>
 	</div>
   </if>
  </foreach>
  <hr />
  <foreach cond='|{btc_dispo}| as |{btc_id}| => |{btc_array}|'>
   <if cond='|{btc_id}| != 1 AND |{btc_array[dispo]}| == 2'> 
 	<div class="list_univ disabled">
 	<h2><img style="align: left" src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[alt][{btc_id}]}" title="{btc[alt][{btc_id}]}" /> {btc[alt][{btc_id}]}</h2>
 	<br />Défense: {btc_array[vars][defense]} 
 	<br />Temps : <if cond="{btc_trav}"><math oper='ceil({btc_array[vars][tours]} / {btc_trav})' /></if><else>{btc_array[vars][tours]}</else> Tour(s)
 	<span>
 	<br />Prix :
 	<if cond='is_array(|{btc_array[vars][prix]}|)'>
 		<foreach cond='|{btc_array[vars][prix]}| as |{res_type}| => |{res_nb}|'>
 		 	{res_nb}<img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		</foreach>
  		<br />Unités Nécessaires:
 		<if cond='is_array(|{btc_array[vars][needguy]}|)'>
 			<foreach cond='|{btc_array[vars][needguy]}| as |{unt_type}| => |{unt_nb}|'>
 			 	{unt_nb}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
  			</foreach>	 
  		</if>
  		<else>
  		 	Aucune
  		</else>
 		</span>
 	</if>
 	<if cond='{btc_array[vars][population]}'>
 	<br/>Place : {btc_array[vars][population]} <img src="img/{session_user[race]}/res/20.png" alt="Population" /><br/>
 	</if>
 	</div>
   </if>
  </foreach>
 </if>
 <else>
  Batîment en construction : <br />
  <if cond='is_array(|{btc_en_const}|)'>
  <foreach cond='|{btc_en_const}| as |{btc_id}| => |{btc_infos}|'>
   <h2><img style="align: left" src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[alt][{btc_id}]}" title="{btc[alt][{btc_id}]}" /> {btc[alt][{btc_id}]}</h2>
   Tour(s) :  <if cond="{btc_trav}"><math oper='ceil({btc_infos[btc_tour]} / {btc_trav})' /> Heure(s)</if><else>Aucun travailleur </else> <br/><br/>
    <div class="barres_grandes">
     	 <div style="width:<math oper='floor(({btc_tours[{btc_id}]}-{btc_infos[btc_tour]}) / {btc_tours[{btc_id}]}*100)' />%" class="barre_verte"></div>
  	 <div style="width:<math oper='floor(100-({btc_tours[{btc_id}]}-{btc_infos[btc_tour]}) / {btc_tours[{btc_id}]}*100)' />%" class="barre_rouge"></div>
   </div> &nbsp;<em><math oper='round(({btc_tours[{btc_id}]}-{btc_infos[btc_tour]}) / {btc_tours[{btc_id}]}*100)' />%</em>
   <br />
   <br /><a href="index.php?file=btc&amp;act=btc&amp;sub=cancel&amp;bid={btc_infos[btc_bid]}" title="Annuler la construction">Annuler</a>
  </foreach>
 </if>
 </else>
</if>
<elseif cond='|{btc_act}| == "cancel"'>
	<if cond='|{btc_no_bid}| == true'>
 	<p class="error">Aucun bâtiment sélectionné.</p>
 	</if>
 	<if cond='|{btc_ok}| == true'>
 	<p class="ok">Ok construction annulée.</p>
 	</if>
 	<if cond='|{btc_not_exist}| == true'>
 	<p class="error">Ce bâtiment n'existe pas.</p>
 	</if>
</elseif>
<elseif cond='|{btc_act}| == "btc"'>
 <if cond='|{btc_peuconstruire}| == "0"'>
 <p class="infos">Il y'a déjà un autre bâtiment en construction !</p>
 </if>
 <elseif cond='|{btc_peuconstruire}| == "1"'>
 	<if cond='|{btc_ok}| == false'>
 	<p class="error">Erreur !</p>
 	</if>
 	<else>
 	<p class="ok">Ok Bâtiment en construction !</p>
 	</else>
 </elseif>
 <elseif cond='|{btc_peuconstruire}| == "2"'>
 <p class="infos">Il vous manque des ressources ou des unités pour construire ce bâtiment.</p>
 </elseif> 
 <elseif cond='|{btc_peuconstruire}| == "3" OR |{btc_no_type}| == true'>
 <p class="error">Ce type de bâtiment n'existe pas.</p>
 </elseif> 
</elseif>