<if cond='|{man_race}|'>
<if cond='|{man_load}|'>
	  <load file="race/{man_race}.config" />
	  <load file="race/{man_race}.descr.config" />
</if>

<h2>Manuel des {race[{man_race}]} :</h2>
<ul>
	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=unt">Les Unités</a></li>
	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=btc">Les Bâtiments</a></li>
	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=src">Les Recherches</a></li>
	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=res">Les Ressources</a></li>
</ul>
</if> 

<if cond='|{man_act}| == "unt"'>
	<foreach cond='|{man_array}| as |{unt_id}| => |{unt_value}|'>
	      <div class="block_1">
	      <h2><img src="img/{man_race}/unt/{unt_id}.png" alt="{unt[alt][{unt_id}]}" title="{unt[alt][{unt_id}]}" /> - {unt[alt][{unt_id}]}</h2>
	        <br/>{unt[descr][{unt_id}]}  
	        <br />Prix :
 		<if cond='is_array(|{unt_value[prix]}|)'>
 		  <foreach cond='|{unt_value[prix]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		</foreach>
  		<if cond='|{unt_value[needsrc]}|'>
 				<br />Recherche nécessaire :
 				<img src="img/{man_race}/src/{unt_value[needsrc]}.png" alt="{src[alt][{unt_value[needsrc]}]}" title="{src[alt][{unt_value[needsrc]}]}" />
 			</if>
 			<if cond='|{unt_value[speed]}|'>
  		  <br />Unités Nécessaires:
 		  <foreach cond='|{unt_value[needguy]}| as |{unt_type}| => |{unt_nb_for}|'>
 		  	{unt_nb_for}<img src="img/{man_race}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
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
  		 </if>
  		</if>
  		<br />
	      </div>
	      <br />
	</foreach>
</if>
<elseif cond='|{man_act}| == "btc"'>
 <foreach cond='|{man_array}| as |{btc_id}| => |{btc_value}|'>
 	<div class="block_1">
 	<h2><img style="align: left" src="img/{man_race}/btc/{btc_id}.png" alt="{btc[alt][{btc_id}]}" title="{btc[alt][{btc_id}]}" /> {btc[alt][{btc_id}]}</h2>
 	<br/>Description:   {btc[descr][{btc_id}]}  
 	<br />Défense: {btc_value[defense]} 
 	<br />Solidité: {btc_value[vie]} 
 	<if cond='{btc_value[tours]}'><br />Temps : {btc_value[tours]} Tour(s)/Travailleur</if>
 	<span>
 	<if cond='{btc_value[population]}'>
 	<br/>Place : {btc_value[population]} <img src="img/{man_race}/res/20.png" alt="Population" /><br/>
 	</if>
 	<if cond='is_array(|{btc_value[prix]}|)'>
 	<br />Prix :
 		<foreach cond='|{btc_value[prix]}| as |{res_type}| => |{res_nb}|'>
 		 	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		</foreach>
   		<if cond='is_array(|{btc_value[needguy]}|)'>
  		<br />Unités Nécessaires:
 			<foreach cond='|{btc_value[needguy]}| as |{unt_type}| => |{unt_nb}|'>
 			 	{unt_nb}<img src="img/{man_race}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
  			</foreach>	 
  		</if>
 		</span>
 	</if>
 	
	
	<if cond='is_array(|{btc_value[needsrc]}|)'>
 		<br />Recherche nécessaire (il en faut au moins une):
 		<foreach cond='|{btc_value[needsrc]}| as |{res_type}| => |{true}|'>
 		<img src="img/{man_race}/src/{res_type}.png" alt="{src[alt][{res_type}]}" title="{src[alt][{res_type}]}" />
 		</foreach>
 	</if>
 	<elseif cond='|{btc_value[needsrc]}|'>
 	<br />Recherche nécessaire :
 		<img src="img/{man_race}/src/{btc_value[needsrc]}.png" alt="{src[alt][{btc_value[needsrc]}]}" title="{src[alt][{btc_value[needsrc]}]}" />
 	</elseif>
 	<if cond='is_array(|{btc_value[needbat]}|)'>
 	<br />Bâtiments nécessaires :
 		<foreach cond='|{btc_value[needbat]}| as |{btc_type}| => |{btc_nb}|'>
 		 	<img src="img/{man_race}/btc/{btc_type}.png" alt="{btc[alt][{btc_type}]}" title="{btc[alt][{btc_type}]}" />
  		</foreach>
  	</if>
  	
 	<if cond='is_array(|{btc_value[produit]}|)'>
 	<br />Produit :
 		<foreach cond='|{btc_value[produit]}| as |{res_type}| => |{res_nb}|'>
 		 	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		</foreach>
  	</if>
  	<br/>
  	<if cond="{btc_value[limite]}">
  	Maximum: {btc_value[limite]}
  	</if>
 	</div>
 	<br />
 </foreach>
</elseif>
<elseif cond='|{man_act}| == "src"'>
 <foreach cond='|{man_array}| as |{src_id}| => |{src_value}|'>
 	<div class="block_1">
 		      <h2><img src="img/{man_race}/src/{src_id}.png" alt="{src[alt][{src_id}]}" title="{src[alt][{src_id}]}" /> -  {src[alt][{src_id}]}</h2>
	        <br />
	        {src[descr][{src_id}]}
	        <if cond='is_array(|{src_value[prix]}|)'>
	        <br />Prix :
 		  <foreach cond='|{src_value[prix]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		  </foreach>
  		</if>
  		<if cond='{src_value[needsrc]}'>
 		 		<br />Recherche nécessaire : <img src="img/{man_race}/src/{src_value[needsrc]}.png" alt="{src[alt][{src_value[needsrc]}]}" title="{src[alt][{src_value[needsrc]}]}" />
  		</if>
  		<if cond='{src_value[incompat]}'>
  		  <br />Incompatibilité: <img src="img/{man_race}/src/{src_value[incompat]}.png" alt="{src[alt][{src_value[incompat]}]}" title="{src[alt][{src_value[incompat]}]}" />
  		</if>
 	</div>
 	<br />
 </foreach>
</elseif>
<elseif cond='|{man_act}| == "res"'>
 <foreach cond='|{man_array}| as |{res_id}| => |{res_value}|'>
 	<div class="block_1">
 		      <h2><img src="img/{man_race}/res/{res_id}.png" alt="{res[alt][{res_id}]}" title="{res[alt][{res_id}]}" /> -  {res[alt][{res_id}]}</h2>
	        <br />
	        {res[descr][{res_id}]}
	        <if cond='is_array(|{res_value[needres]}|)'>
	        <br />Prix :
 		  <foreach cond='|{res_value[needres]}| as |{res_type}| => |{res_nb}|'>
 		  	{res_nb}<img src="img/{man_race}/res/{res_type}.png" alt="{res[alt][{res_type}]}" title="{res[alt][{res_type}]}" />
  		  </foreach>
  		</if>
  		<if cond='{res_value[needsrc]}'>
  			<br />Recherche : <img src="img/{man_race}/src/{res_value[needsrc]}.png" alt="{src[alt][{res_value[needsrc]}]}" title="{src[alt][{res_value[needsrc]}]}" />
  		</if>
 	</div>
 	<br />
 </foreach>
</elseif>
<else>
<p class="center">
<img src="img/{man_race}/arbre_unites.png" alt="Arbre technologique" /><br/>
<img src="img/{man_race}/arbre_batiment.png" alt="Arbre technologique" />
</p>
</else>