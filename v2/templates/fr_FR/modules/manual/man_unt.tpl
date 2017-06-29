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
