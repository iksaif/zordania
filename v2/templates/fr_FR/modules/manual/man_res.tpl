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
