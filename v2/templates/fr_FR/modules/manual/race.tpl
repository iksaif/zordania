<if cond='{man_act} == "unt"'>
	<p class="menu_module">[ <a href="manual.html?race={man_race}&type=unt&stype={TYPE_UNT_CIVIL}" alt="Unités Civiles" title="Unités Civiles">Unités Civiles</a> ] -
	[ <a href="manual.html?race={man_race}&type=unt&stype={TYPE_UNT_INFANTERIE}" alt="Unités Militaires" title="Unités Militaires">Unités Militaires</a> ] -
	[ <a href="manual.html?race={man_race}&type=unt&stype={TYPE_UNT_HEROS}" alt="Héros" title="Héros">Héros</a> ]
	</p>

	<if cond="{man_stype} != {TYPE_UNT_CIVIL}"><p class='infos'>Les unités militaires sont présentées dans l'ordre de leur placement dans les légions.</p></if>

     <dl>
     <foreach cond='{man_array} as {unt_rang} => {unt_value}'>
     <dt id="unt_{unt_value[nid]}">
          <a href="manual.html?race={man_race}&type=unt#unt_{unt_value[nid]}">
               <zimgunt type="{unt_value[nid]}" race="{man_race}" /> {unt[{man_race}][alt][{unt_value[nid]}]}
          </a>
     </dt>
     <dd>
         <p>{unt[{man_race}][descr][{unt_value[nid]}]}<br/>
         Type: {roles[{unt_value[role]}]} <if cond="isset({unt_value[rang]})">( placement : {unt_value[rang]} )</if><br/>

<if cond='isset({unt_value[atq_unt]}) OR isset({unt_value[atq_btc]}) OR isset({unt_value[def]})'>
		[ <if cond='isset({unt_value[atq_unt]})'>{unt_value[atq_unt]} <img src="img/{man_race}/div/atq.png" alt="Attaque Unité" /></if>
		<if cond="isset({unt_value[atq_btc]})"> - {unt_value[atq_btc]} <img src="img/{man_race}/div/atq_btc.png" alt="Attaque Bâtiment" /></if>
		<if cond="isset({unt_value[def]})">  - {unt_value[def]} <img src="img/{man_race}/div/def.png" alt="Défense" /></if> ]
		<br/>
</if>
		<if cond="isset({unt_value[vie]})"> Vie: {unt_value[vie]}<br /></if>
		<if cond="isset({unt_value[vit]})"> Vitesse: {unt_value[vit]} <br /></if>    

		<if cond='isset({unt_value[bonus]})'>
			Bonus: 
			<if cond='isset({unt_value[bonus][atq]})'>{unt_value[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus atq" /></if>
			<if cond='isset({unt_value[bonus][def]})'>{unt_value[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus def" /></if>
			<if cond='isset({unt_value[bonus][vie]})'>{unt_value[bonus][vie]} (tir) <img src="img/{_user[race]}/div/tir.png" alt="Tir" /></if>
			<br />
		</if>
		<if cond="isset({unt_value[limite]})">Maximum: {unt_value[limite]}<br /></if>
		<if cond="isset({unt_value[capacity]})">Capacité de transport: {unt_value[capacity]}<br /></if>
		</p>
		<hr />
          
		<p>
		<if cond='isset({unt_value[prix_res]})'>
			Prix :
			<foreach cond='{unt_value[prix_res]} as {res_type} => {res_nb}'>
				{res_nb} <zimgres type="{res_type}" race="{man_race}" />
			</foreach><br/>
		</if>
		<if cond="isset({unt_value[need_src]})">
			Recherches:
			<foreach cond="{unt_value[need_src]} as {src_id}">
				<zimgsrc type="{src_id}" race="{man_race}" />
			</foreach><br/>
		</if>
		<if cond="isset({unt_value[need_btc]})">
			Bâtiment:
			<foreach cond="{unt_value[need_btc]} as {btc_id}">
				<zimgbtc type="{btc_id}" race="{man_race}" />
			</foreach><br/>
		</if>
           
		<if cond="isset({unt_value[prix_unt]})">
			Unités Nécessaires:
			<foreach cond='{unt_value[prix_unt]} as {unt_type} => {unt_nb_for}'>
			{unt_nb_for} <zimgunt type="{unt_type}" race="{man_race}" />
			</foreach><br/>
		</if>
		</p>
	</dd>
	</foreach>
	</dl>
     
     <p align="center" class="menu_module">
     [ <a href="manual.html?race={man_race}&page=3">Précédent : Unités (Explications)</a>  ]
     -
     [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
     -
     [ <a href="manual.html?race={man_race}&page=26">Suivant : Compétences des Héros (Explications)</a> ]
     </p>

</if>


<elseif cond='{man_act} == "btc"'>
 <dl>
 <foreach cond='{man_array} as {btc_id} => {btc_value}'>
      <dt id="btc_{btc_id}">
      <a href="manual.html?race={man_race}&type=btc#btc_{btc_id}">
      <img style="align: left" src="img/{man_race}/btc/{btc_id}.png" alt="{btc[{man_race}][alt][{btc_id}]}" title="{btc[{man_race}][alt][{btc_id}]}" /> {btc[{man_race}][alt][{btc_id}]}
      </a>
      </dt>
      <dd>
      <p>{btc[{man_race}][descr][{btc_id}]}  </p>
     <if cond='isset({btc_value[bonus]})'>
          Bonus: 
          <if cond='isset({btc_value[bonus][gen]})'>{btc_value[bonus][gen]} <img src="img/{man_race}/div/atq.png" alt="Valeur d'attaque" /></if>
          <if cond='isset({btc_value[bonus][bon]})'>{btc_value[bonus][bon]} % <img src="img/{man_race}/div/def.png" alt="Bonus défense" /></if>
          <br />
     </if>
      <p>Solidité: {btc_value[vie]} </p>
      <p>Temps : {btc_value[tours]} Tour(s)/Travailleur</p>
      <if cond='isset({btc_value[prod_pop]})'>
      <p>Place : {btc_value[prod_pop]} <img src="img/{man_race}/{man_race}.png" alt="Place" title="Place" /></p>
      </if>

     <if cond='isset({btc_value[prix_res]})'>
          <p>Prix :
          <foreach cond='{btc_value[prix_res]} as {res_type} => {res_nb}'>
               {res_nb} <zimgres type="{res_type}" race="{man_race}" />
          </foreach></p>
     </if>
     <if cond='isset({btc_value[prix_trn]})'>
          <p>Terrains: 
          <foreach cond='{btc_value[prix_trn]} as {trn_type} => {trn_nb}'>
               {trn_nb} <zimgtrn type="{trn_type}" race="{man_race}" />
          </foreach></p>
     </if>
     <if cond='isset({btc_value[prix_unt]})'>
          <p>Unités Nécessaires :
          <foreach cond='{btc_value[prix_unt]} as {unt_type} => {unt_nb}'>
               {unt_nb} <zimgunt type="{unt_type}" race="{man_race}" />
          </foreach></p>
     </if>
     <if cond='isset({btc_value[need_src]})'>
            <p>Recherche : 
            <foreach cond='{btc_value[need_src]} as {src_type}'>
                 <zimgsrc type="{src_type}" race="{man_race}" />
            </foreach></p>
       </if>
     <if cond="isset({btc_value[need_btc]})">
          <p>Bâtiment:
          <foreach cond="{btc_value[need_btc]} as {btc_id}">
               <zimgbtc type="{btc_id}" race="{man_race}" />
          </foreach></p>
     </if>

     <if cond='isset({btc_value[prod_res_auto]})'>
          <p>Produit :
          <foreach cond='{btc_value[prod_res_auto]} as {res_type} => {res_nb}'>
               {res_nb} <zimgres type="{res_type}" race="{man_race}" />
          </foreach></p>
     </if>
     
       <if cond="isset({btc_value[limite]})">
            <p> Maximum: {btc_value[limite]}</p>
       </if>
      </dd>
 </foreach>
 </dl>
 
 <p align="center" class="menu_module">
     [ <a href="manual.html?race={man_race}&page=2">Précédent : Bâtiments (Explications)</a>  ]
     -
     [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
     -
     [ <a href="manual.html?race={man_race}&page=3">Suivant : Unités (Explications)</a> ]
     </p>
</elseif>


<elseif cond='{man_act} == "src"'>
 <dl>
 <foreach cond='{man_array} as {src_id} => {src_value}'>
      <dt id="src_{src_id}">
          <a href="manual.html?race={man_race}&type=src#src_{src_id}">
          <zimgsrc type="{src_id}" race="{man_race}" /> {src[{man_race}][alt][{src_id}]}
          </a>
          </dt>
          
          <dd>
          <p>{src[{man_race}][descr][{src_id}]}</p>
          <if cond='isset({src_value[prix_res]})'>
          <p>Prix :
          <foreach cond='{src_value[prix_res]} as {res_type} => {res_nb}'>
               {res_nb} <zimgres type="{res_type}" race="{man_race}" />
          </foreach></p>
          </if>
          <if cond='isset({src_value[need_src]})'>
                 <p>Recherche : 
                 <foreach cond='{src_value[need_src]} as {src_type}'>
                      <zimgsrc type="{src_type}" race="{man_race}" />
                 </foreach></p>
            </if>
            <if cond='isset({src_value[need_no_src]})'>
                 <p>Incompatibilité: 
                 <foreach cond='{src_value[need_no_src]} as {src_type}'>
                      <zimgsrc type="{src_type}" race="{man_race}" />
                 </foreach></p>
            </if>
            <if cond='isset({src_value[need_btc]})'>
                 <p>Bâtiments: 
                 <foreach cond='{src_value[need_btc]} as {btc_type}'>
                      <zimgbtc type="{btc_type}" race="{man_race}" />
                 </foreach></p>
            </if>
      </dd>
 </foreach>
 </dl>
 <p align="center" class="menu_module">
     [ <a href="manual.html?race={man_race}&page=4">Précédent : Recherches (Explications)</a>  ]
     -
     [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
     -
     [ <a href="manual.html?race={man_race}&page=5">Suivant : Ressources (Explications)</a> ]
     </p>
</elseif>


<elseif cond='{man_act} == "res"'>
 <dl>
 <foreach cond='{man_array} as {res_id} => {res_value}'>
           <dt id="res_{res_id}">
                 <a href="manual.html?race={man_race}&type=res#res_{res_id}">
                 <zimgres type="{res_id}" race="{man_race}" />
                 {res[{man_race}][alt][{res_id}]}
                 </a></dt>
             <dd>
            <p> {res[{man_race}][descr][{res_id}]}</p>
             <if cond='isset({res_value[prix_res]})'>
          <p>Prix :
          <foreach cond='{res_value[prix_res]} as {res_type} => {res_nb}'>
               {res_nb} <zimgres type="{res_type}" race="{man_race}" />
          </foreach>
          </p>
            </if>
            <if cond='isset({res_value[need_btc]})'>
                <p>Bâtiments nécessaires :
                      <zimgbtc type="{res_value[need_btc]}" race="{man_race}" />
                 </p>
            </if>
            <if cond='isset({res_value[need_src]})'>
                 <p>Recherche : 
                 <foreach cond='{res_value[need_src]} as {src_type}'>
                      <zimgsrc type="{src_type}" race="{man_race}" />
                 </foreach></p>
            </if>
      </dd>
 </foreach>
 </dl>
 <p align="center" class="menu_module">
     [ <a href="manual.html?race={man_race}&page=5">Précédent : Ressources (Explications)</a>  ]
     -
     [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
     -
     [ <a href="manual.html?race={man_race}&page=11">Suivant : Terrains (Explications)</a> ]
     </p>
</elseif>


<elseif cond='{man_act} == "trn"'>
 <dl>
 <foreach cond='{man_array} as {trn_id} => {trn_value}'>
           <dt id="trn_{trn_id}">
                 <a href="manual.html?race={man_race}&type=trn#trn_{trn_id}">
                 <zimgtrn type="{trn_id}" race="{man_race}" /> {trn[{man_race}][alt][{trn_id}]}
                 </a></dt>
             <dd>
             <p>{trn[{man_race}][descr][{trn_id}]}</p>
      </dd>
 </foreach>
 </dl>
 <p align="center" class="menu_module">
     [ <a href="manual.html?race={man_race}&page=11">Précédent : Terrains (Explications)</a>  ]
     -
     [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
     -
     [ <a href="manual.html?race={man_race}&page=12">Suivant : Guide du Débutant</a> ]
     </p>
</elseif>


<elseif cond='{man_act} == "comp"'>
<dl>
<foreach cond='{man_array} as {comp_id} => {comp_value}'>
	<dt id="comp_{comp_id}">
		<a href="manual.html?race={man_race}&type=comp#comp_{comp_id}">
		{comp[{man_race}][alt][{comp_id}]}</a>
	</dt>
	<dd>
		<span class="right"><zimgcomp type="{comp_id}" race="{man_race}" /></span>
		<p><strong>Compétence {type_comp[{comp_value[type]}]}</strong> : 
		<printf string="{comp[{man_race}][descr][{comp_id}]}" vars="{comp_value[bonus]},{comp_value[tours]}" />
		</p>
		<p><em>Prix (en expérience) :</em> {comp_value[prix_xp]} XP
<#
		<if cond="{comp_value[tours]}">- <em>durée :</em> {comp_value[tours]} tours</if>
		<if cond="{comp_value[bonus]}">
			- <em>
			<if cond="{comp_value[bonus]} > 0">Bonus accordé :</if>
			<else>Malus :</else>
			</em> {comp_value[bonus]} %</p>
		</if>
#>
		<p>Les Héros qui peuvent avoir cette compétence :
		<foreach cond="{comp_value[heros]} as {unit}"><zimgunt type="{unit}" race="{man_race}" />
		</foreach>
	</dd>
</foreach>
</dl>
<p align="center" class="menu_module">
[ <a href="manual.html?race={man_race}&page=26">Précédent : Compétences des héros (explications)</a>  ]
-
[ <a href="manual.html?race={man_race}" title="Accueil du Manuel">Manuel</a> ]
-
[ <a href="manual.html?race={man_race}&page=4">Suivant : Recherches (explications)</a> ]
</p>
</elseif>

