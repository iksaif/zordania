<p class="menu_module">
	<h1>Village de {gen_mbr}</h1>
	<hr />
</p>
<table class="vue_generale border1">
	<tr>
		<td>
		<h3>Infos :</h3>
		<ul>
			<li>Position sur la carte : X: {gen_map_array[0][map_x]} Y: {gen_map_array[0][map_y]}</li>
			<li>Bâtiments : {gen_nb_btc}</li>
			<li>Population : {gen_population}</li>
			<li>Points : {gen_points}</li>
			<li>Recherches effectuées : {gen_nb_src}</li>
		</ul>
		<br>
		<h3>Ressources Principales :</h3>
		<ul>
		<if cond='is_array(|{res_array}|)'>
			<foreach cond='|{res_array}| AS |{res_vars}|'>
			<li>
			<img src="img/{session_user[race]}/res/{res_vars[res_type]}.png" alt="{res[alt][{res_vars[res_type]}]}" title="{res[alt][{res_vars[res_type]}]}" /> 
			<if cond='|{res_vars[res_type]}| == 20'>
			{gen_population}/
			</if>{res_vars[res_nb]}
			</li>
			</foreach>
		</if>
		</ul>
		</td>
		<td>
		<h3>Attaques :</h3>
		<br />
		<if cond='count(|{atq_array}|) > 0'>
 		<ul>
 		<foreach cond='|{atq_array}| as |{result}|'>
  		<li> 
  		<if cond='|{result[atq_mid]}| != |{session_user[mid]}|'>
  		   <img src="img/{session_user[race]}/div/def.png" alt="def" title="Vous allez être attaqué" /> {result[mbr_pseudo]}
		     - Distance : {result[atq_dst]} 
 		  </if>
  		 <else>
  		  <img src="img/{session_user[race]}/div/atq.png" alt="atq" title="Vous attaquez" /> {result[mbr_pseudo]}
		   - {result[leg_name]}<br/>
  		   Distance : {result[atq_dst]}
 		</else>
   		</li>	    
 		</foreach>
 		</ul>
		 </if>
		 <else>
		  Aucune attaque en ce moment.
		 </else>
		
		</td>
	</tr>
	<tr>
		<td>
		<h3>Bâtiment en réparation :</h3>
		<if cond='is_array(|{btc_en_rep}|)'>
  			<ul>
  			<foreach cond='|{btc_en_rep}| as |{btc_nid}| => |{btc_infos}|'>
  			 <if cond="|{btc_infos[btc_etat]}| == 1">
  			 <li>
  			 <set name="btc_id" value="{btc_infos[btc_type]}" />
  			 <img style="align: left" src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[alt][{btc_id}]}" title="{btc[alt][{btc_id}]}" /> {btc[alt][{btc_id}]}<br/>
  			   <div class="barres_petites">
  			   	<div style="width:<math oper='floor(100-({btc_conf[{btc_id}][vie]}-{btc_infos[btc_vie]}) / {btc_conf[{btc_id}][vie]}*100)' />%" class="barre_verte"></div>
  			     	 <div style="width:<math oper='floor(({btc_conf[{btc_id}][vie]}-{btc_infos[btc_vie]}) / {btc_conf[{btc_id}][vie]}*100)' />%" class="barre_rouge"></div>
   			  </div> &nbsp;<em>{btc_infos[btc_vie]}/{btc_conf[{btc_id}][vie]}</em>
 			  </li>
 			  </if>
   			</foreach>
   			</ul>
		</if>
		<else>
			Aucun.
		</else>
		<h3>Bâtiment en construction :</h3>
		<if cond='is_array(|{btc_en_const}|)'>
  			<ul>
  			<foreach cond='|{btc_en_const}| as |{btc_nid}| => |{btc_infos}|'>
  			 <li>
  			  <set name="btc_id" value="{btc_infos[btc_type]}" />
  			 <img style="align: left" src="img/{session_user[race]}/btc/{btc_id}.png" alt="{btc[alt][{btc_id}]}" title="{btc[alt][{btc_id}]}" /> {btc[alt][{btc_id}]}<br/>
  			   <div class="barres_petites">
  			     	 <div style="width:<math oper='floor(({btc_conf[{btc_id}][tours]}-{btc_infos[btc_tour]}) / {btc_conf[{btc_id}][tours]}*100)' />%" class="barre_verte"></div>
   			 	 <div style="width:<math oper='floor(100-({btc_conf[{btc_id}][tours]}-{btc_infos[btc_tour]}) / {btc_conf[{btc_id}][tours]}*100)' />%" class="barre_rouge"></div>
   			  </div> &nbsp;<em><math oper='round(({btc_conf[{btc_id}][tours]}-{btc_infos[btc_tour]}) / {btc_conf[{btc_id}][tours]}*100)' />%</em>
 			  </li>
   			</foreach>
   			</ul>
		</if>
		<else>
			Aucun.
		</else>
		<h3>Recherches en cours :</h3>
	 	<if cond='is_array(|{src_array}|)'>
	 	 <ul>
	 	 <foreach cond='|{src_array}| as |{src_type}| => |{src_result}|'>
	 	  <li>
	 	  <img src="img/{session_user[race]}/src/{src_type}.png" alt="{src[alt][{src_type}]}" title="{src[alt][{src_type}]}" /> {src[alt][{src_type}]} <br />
	 	  <div class="barres_petites">
	 	   <div style="width:<math oper='floor(100-({src_result[src_tour]} / {src_infos[{src_type}][tours]})*100)' />%" class="barre_verte"></div>
  	 	   <div style="width:<math oper='floor((({src_result[src_tour]} / {src_infos[{src_type}][tours]})*100))' />%" class="barre_rouge"></div>
         	  </div> &nbsp;<em><math oper='round(100-({src_result[src_tour]} / ({src_infos[{src_type}][tours]})*100))' />%</em>
         	  </li>
	 	 </foreach>
	 	 </ul>
	 	</if>
	 	<else>
	 		Aucune
	 	</else>
	 	<h3>Unités en formation :</h3>
	 	<if cond='is_array(|{unt_array}|)'>
	 	 <ul>
	 	 <foreach cond='|{unt_array}| as |{unt_type}| => |{unt_result}|'>
	 	 <li>
	 	 <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" /> {unt_result[unt_nb]} <br />
	 	 </li>
	 	 </foreach>
	 	 </ul>
	 	</if>
	 	<else>
	 	 Aucune unité en formation.
	 	</else>
	 	<h3>Ressources :</h3>
	 	<if cond='is_array(|{res_enc_array}|)'>
	 	 <ul>
	 	 <foreach cond='|{res_enc_array}| as |{res_type}| => |{res_result}|'>
	 	 <li>
	 	 <img src="img/{session_user[race]}/res/{res_type}.png" alt="{res[alt][{resr_type}]}" title="{res[alt][{res_type}]}" /> {res_result[res_nb]} <br />
	 	 </li>
	 	 </foreach>
	 	 </ul>
	 	</if>
	 	<else>
	 	 Aucune ressource en fabrication.
	 	</else>
		</td>
		<td>
		<h3>En vente :</h3>
		<if cond='count(|{vente_array}|) > 0'>
			<ul>
			<foreach cond='|{vente_array}| as |{key}| => |{com_value}|'>
				<li>
				Proposé : {com_value[mch_nb]} 
				<img src="img/{session_user[race]}/res/{com_value[mch_type]}.png" alt="{res[alt][{com_value[mch_type]}]}" title="{res[alt][{com_value[mch_type]}]}" />
				|
				Prix : {com_value[mch_nb2]} 
				<img src="img/{session_user[race]}/res/{com_value[mch_type2]}.png" alt="{res[alt][{com_value[mch_type2]}]}" title="{res[alt][{com_value[mch_type2]}]}" />
				<br />
				</li>
			</foreach>
			</ul>
		</if>
		<else>
			Rien
		</else>
		<br />
		</td>
	</tr>
</table>