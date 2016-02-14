<if cond='|{man_act}| == "unt"'>
	<dl>
	<foreach cond='|{man_array}| as |{unt_id}| => |{unt_value}|'>
	      <dt id="unt_{unt_id}">
	      <a href="index.php?file=manual&amp;race={man_race}&amp;type=unt#unt_{unt_id}">
	          <img src="img/{man_race}/unt/{unt_id}.png" alt="{unt[{man_race}][alt][{unt_id}]}" title="{unt[{man_race}][alt][{unt_id}]}" /> - {unt[{man_race}][alt][{unt_id}]}
	          </a>
	      </dt>
	      <dd>
	        <br/>{unt[{man_race}][descr][{unt_id}]}  
	        <br />Prix :
 		<if cond='is_array(|{unt_value[prix]}|)'>
 		 <foreach cond='|{unt_value[prix]}| as |{res_type}| => |{res_nb}|'>
 		   	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[{man_race}][alt][{res_type}]}" title="{res[{man_race}][alt][{res_type}]}" />
  		 </foreach>
  		 <if cond='|{unt_value[needsrc]}|'>
 				<br />Recherche nécessaire :
 				<img src="img/{man_race}/src/{unt_value[needsrc]}.png" alt="{src[{man_race}][alt][{unt_value[needsrc]}]}" title="{src[{man_race}][alt][{unt_value[needsrc]}]}" />
 		</if>
 		<br/>Bâtiment:
 		<foreach cond="|{unt_value[needbat]}| as |{btc_id}| => |{value}|">
 		 <img src="img/{man_race}/btc/{btc_id}.png" alt="{btc[{man_race}][alt][{btc_id}]}" title="{btc[{man_race}][alt][{btc_id}]}" />
 		</foreach>
 		
 		<if cond='|{unt_value[speed]}|'>
  		  <br />Unités Nécessaires:
 		  <foreach cond='|{unt_value[needguy]}| as |{unt_type}| => |{unt_nb_for}|'>
 		  	{unt_nb_for}<img src="img/{man_race}/unt/{unt_type}.png" alt="{unt[{man_race}][alt][{unt_type}]}" title="{unt[{man_race}][alt][{unt_type}]}" />
  		  </foreach>
  		  <br />
  		  Attaque: {unt_value[attaque]}<br />
  		  Attaque Batîments: {unt_value[attaquebat]}<br />
  		  Défense: {unt_value[defense]}<br />
  		  Vie: {unt_value[vie]}<br />
  		  Vitesse: {unt_value[speed]}	<br /> 
  		  <if cond='is_array(|{unt_value[bonus]}|)'>
  		  Bonus: 
  		  <if cond='{unt_value[bonus][atq]}'>{unt_value[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus atq" /></if>
  		  <if cond='{unt_value[bonus][def]}'>{unt_value[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus def" /></if>
  		  <br/>
  		  </if>
  	   	  <if cond="{unt_value[limite]}">
  		  Maximum: {unt_value[limite]}
  		  </if>
  		  <if cond="{unt_value[capacity]}">
  		  Capacité: {unt_value[capacity]}
  		  </if>
  		 </if>
  		</if>
  		<br />
	      </dd>
	</foreach>
	</dl>
</if>
<elseif cond='|{man_act}| == "btc"'>
 <dl>
 <foreach cond='|{man_array}| as |{btc_id}| => |{btc_value}|'>
 	<dt id="btc_{btc_id}">
 	<a href="index.php?file=manual&amp;race={man_race}&amp;type=btc#btc_{btc_id}">
 	<img style="align: left" src="img/{man_race}/btc/{btc_id}.png" alt="{btc[{man_race}][alt][{btc_id}]}" title="{btc[{man_race}][alt][{btc_id}]}" /> {btc[{man_race}][alt][{btc_id}]}
 	</a>
 	</dt>
 	<dd>
 	<br/>Description:   {btc[{man_race}][descr][{btc_id}]}  
 	<if cond='{btc_value[defense]}'><br />Défense: {btc_value[defense]} </if>
 	<if cond='{btc_value[bonusdef]}'><br />Bonus de Défense: {btc_value[bonusdef]} % </if>
 	<br />Solidité: {btc_value[vie]} 
 	<if cond='{btc_value[tours]}'><br />Temps : {btc_value[tours]} Tour(s)/Travailleur</if>
 	<span>
 	<if cond='{btc_value[population]}'>
 	<br/>Place : {btc_value[population]} <img src="img/{man_race}/res/{GAME_RES_PLACE}.png" alt="{res[{man_race}][alt][{GAME_RES_PLACE}]}" title="{res[{man_race}][alt][{GAME_RES_PLACE}]}" /><br/>
 	</if>
 	<if cond='is_array(|{btc_value[prix]}|)'>
 	<br />Prix :
 		<foreach cond='|{btc_value[prix]}| as |{res_type}| => |{res_nb}|'>
 		 	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[{man_race}][alt][{res_type}]}" title="{res[{man_race}][alt][{res_type}]}" />
  		</foreach>
   		<if cond='is_array(|{btc_value[needguy]}|)'>
  		<br />Unités Nécessaires:
 			<foreach cond='|{btc_value[needguy]}| as |{unt_type}| => |{unt_nb}|'>
 			 	{unt_nb}<img src="img/{man_race}/unt/{unt_type}.png" alt="{unt[{man_race}][alt][{unt_type}]}" title="{unt[{man_race}][alt][{unt_type}]}" />
  			</foreach>	 
  		</if>
 		</span>
 	</if>
 	
	
	<if cond='is_array(|{btc_value[needsrc]}|)'>
 		<br />Recherche nécessaire (il en faut au moins une):
 		<foreach cond='|{btc_value[needsrc]}| as |{res_type}| => |{true}|'>
 		<img src="img/{man_race}/src/{res_type}.png" alt="{src[{man_race}][alt][{res_type}]}" title="{src[{man_race}][alt][{res_type}]}" />
 		</foreach>
 	</if>
 	<elseif cond='|{btc_value[needsrc]}|'>
 	<br />Recherche nécessaire :
 		<img src="img/{man_race}/src/{btc_value[needsrc]}.png" alt="{src[{man_race}][alt][{btc_value[needsrc]}]}" title="{src[{man_race}][alt][{btc_value[needsrc]}]}" />
 	</elseif>
 	<if cond='is_array(|{btc_value[needbat]}|)'>
 	<br />Bâtiments nécessaires :
 		<foreach cond='|{btc_value[needbat]}| as |{btc_type}| => |{btc_nb}|'>
 		 	<img src="img/{man_race}/btc/{btc_type}.png" alt="{btc[{man_race}][alt][{btc_type}]}" title="{btc[{man_race}][alt][{btc_type}]}" />
  		</foreach>
  	</if>
  	
 	<if cond='is_array(|{btc_value[produit]}|)'>
 	<br />Produit :
 		<foreach cond='|{btc_value[produit]}| as |{res_type}| => |{res_nb}|'>
 		 	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[{man_race}][alt][{res_type}]}" title="{res[{man_race}][alt][{res_type}]}" />
  		</foreach>
  	</if>
  	<br/>
  	<if cond="{btc_value[limite]}">
  	Maximum: {btc_value[limite]}
  	</if>
 	</dd>
 </foreach>
 </dl>
</elseif>
<elseif cond='|{man_act}| == "src"'>
 <dl>
 <foreach cond='|{man_array}| as |{src_id}| => |{src_value}|'>
 	<dt id="src_{src_id}">
 		     <a href="index.php?file=manual&amp;race={man_race}&amp;type=src#src_{src_id}">
 		      <img src="img/{man_race}/src/{src_id}.png" alt="{src[{man_race}][alt][{src_id}]}" title="{src[{man_race}][alt][{src_id}]}" /> -  {src[{man_race}][alt][{src_id}]}
 		      </a>
 		      </dt>
 		      
	        <dd>
	        {src[{man_race}][descr][{src_id}]}
	        <if cond='is_array(|{src_value[prix]}|)'>
	        <br />Prix :
 		  <foreach cond='|{src_value[prix]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[{man_race}][alt][{res_type}]}" title="{res[{man_race}][alt][{res_type}]}" />
  		  </foreach>
  		</if>
  		<if cond='{src_value[needsrc]}'>
 		 		<br />Recherche nécessaire : <img src="img/{man_race}/src/{src_value[needsrc]}.png" alt="{src[{man_race}][alt][{src_value[needsrc]}]}" title="{src[{man_race}][alt][{src_value[needsrc]}]}" />
  		</if>
  		<if cond='{src_value[incompat]}'>
  		  <br />Incompatibilité: <img src="img/{man_race}/src/{src_value[incompat]}.png" alt="{src[{man_race}][alt][{src_value[incompat]}]}" title="{src[{man_race}][alt][{src_value[incompat]}]}" />
  		</if>
  		 <if cond="is_array(|{src_value[needbat]}|)">
  		 <br/>Bâtiment:
 		<foreach cond="|{src_value[needbat]}| as |{btc_id}| => |{value}|">
 		 <img src="img/{man_race}/btc/{btc_id}.png" alt="{btc[{man_race}][alt][{btc_id}]}" title="{btc[{man_race}][alt][{btc_id}]}" />
 		</foreach>
 		</if>
 	</dd>
 </foreach>
 </dl>
</elseif>
<elseif cond='|{man_act}| == "res"'>
 <dl>
 <foreach cond='|{man_array}| as |{res_id}| => |{res_value}|'>
 		<dt id="res_{res_id}">
 		      <a href="index.php?file=manual&amp;race={man_race}&amp;type=res#res_{res_id}">
 		      <img src="img/{man_race}/res/{res_id}.png" alt="{res[{man_race}][alt][{res_id}]}" title="{res[{man_race}][alt][{res_id}]}" /> -  {res[{man_race}][alt][{res_id}]}
 		      </a></dt>
	        <dd>
	        {res[{man_race}][descr][{res_id}]}
	        <if cond='is_array(|{res_value[needres]}|)'>
	        <br />Prix :
 		  <foreach cond='|{res_value[needres]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[{man_race}][alt][{res_type}]}" title="{res[{man_race}][alt][{res_type}]}" />
  		  </foreach>
  		</if>
  		<if cond='is_array(|{btc_value[needbat]}|)'>
 			<br />Bâtiments nécessaires :
 			<foreach cond='|{btc_value[needbat]}| as |{btc_type}| => |{btc_nb}|'>
 			 	<img src="img/{man_race}/btc/{btc_type}.png" alt="{btc[{man_race}][alt][{btc_type}]}" title="{btc[{man_race}][alt][{btc_type}]}" />
  			</foreach>
  		</if>
  		<if cond='{res_value[needsrc]}'>
  			<br />Recherche : <img src="img/{man_race}/src/{res_value[needsrc]}.png" alt="{src[{man_race}][alt][{res_value[needsrc]}]}" title="{src[{man_race}][alt][{res_value[needsrc]}]}" />
  		</if>
 	</dd>
 </foreach>
 </dl>
</elseif>
<else>
<p class="center">
<img src="img/{man_race}/arbre_unites.png" alt="Arbre technologique" /><br/>
<img src="img/{man_race}/arbre_batiment.png" alt="Arbre technologique" />
</p>
</else>