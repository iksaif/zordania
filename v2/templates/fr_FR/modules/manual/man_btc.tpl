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
