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
