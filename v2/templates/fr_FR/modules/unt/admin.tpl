<include file="commun/races.tpl" select="{man_race}" admin="1" general="0" url="admin.html?module=unt" />

<if cond='{man_race}'>
	<if cond='isset({man_load})'>
		<load file="race/{man_race}.config" />
		<load file="race/{man_race}.descr.config" />
	</if>
</if>

<h3>Liste des unités</h3>
<form action="admin.html?module=unt&amp;race={man_race}" method="post">
<dl>
<foreach cond="{man_unt} as {key} => {value}">
	<if cond="{value[role]} != TYPE_UNT_CIVIL">
	<dt><zimgunt race="{man_race}" type="{key}" /> {unt[{man_race}][alt][{key}]} : {roles[{value[role]}]}
		<input type="text" id="nbr[{key}]" name="nbr[{key}]" value="{nbr[{key}]}" />
	</dt>
	<dd>

		<p>
		<if cond='isset({value[prix_res]})'>Prix :
			<foreach cond='{value[prix_res]} as {res_type} => {res_nb}'>
				{res_nb} <zimgres type="{res_type}" race="{man_race}" />
			</foreach>
		</if>
		<if cond="isset({value[need_src]})">Recherches :
			<foreach cond="{value[need_src]} as {src_id}">
				  <zimgsrc type="{src_id}" race="{man_race}" />
			</foreach>
		</if>
		<if cond="isset({value[need_btc]})">Bâtiment :
			<foreach cond="{value[need_btc]} as {btc_id}">
				  <zimgbtc type="{btc_id}" race="{man_race}" />
			</foreach>
		</if>
		<if cond="isset({value[prix_unt]})">Unités :
			<foreach cond='{value[prix_unt]} as {unt_type} => {unt_nb_for}'>
				{unt_nb_for} <zimgunt type="{unt_type}" race="{man_race}" />
			</foreach>
		</if>
		</p>

       <if cond='isset({value[vit]})'>
           <p>[ 
			<if cond="isset({value[atq_unt]})">{value[atq_unt]} <img src="img/{man_race}/div/atq.png" alt="Attaque Unité" /></if>
           <if cond="isset({value[atq_btc]})"> - {value[atq_btc]} <img src="img/{man_race}/div/atq.png" alt="Attaque Bâtiment" /></if>
           <if cond="isset({value[atq_def]})">- {value[def]} <img src="img/{man_race}/div/def.png" alt="Défense" /></if>
           - Vie: {value[vie]}
           - Vitesse: {value[vit]}
           <if cond='isset({value[bonus]})'>
                - Bonus: 
                <if cond='isset({value[bonus][atq]})'>
					{value[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus atq" />
				</if>
                <if cond='isset({value[bonus][def]})'>
					{value[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus def" />
				</if>
                <if cond='isset({value[bonus][vie]})'>
					{value[bonus][vie]} <img src="img/{man_race}/div/tir.png" alt="Bonus vie" />
				</if>
           </if> ]
           </p>
           <if cond="isset({value[limite]})">
                <p>Maximum: {value[limite]}</p>
           </if>
           <if cond="isset({value[carry]})">
                <p>Capacité de transport: {value[carry]}</p>
           </if>
       </if>

	</dd>
   </if>
</foreach>
<input type="submit" value="recalculer" />
</form>


<dt>Cout et stats Totales de l'armée<br/>
	<foreach cond="{nbr} as {key} => {nb}">
		<if cond="{nb}">{nb} <zimgunt race="{man_race}" type="{key}" />; </if>
	</foreach>
</dt>
<dd>
	<p>
	<if cond='isset({total[prix_res]})'>Prix :
		<foreach cond='{total[prix_res]} as {res_type} => {res_nb}'>
			<if cond="{res_nb} != 0">{res_nb} <zimgres type="{res_type}" race="{man_race}" />; </if>
		</foreach>
	</if>
	<if cond="isset({total[prix_unt]})">Unités :
		<foreach cond='{total[prix_unt]} as {unt_type} => {unt_nb_for}'>
			{unt_nb_for} <zimgunt type="{unt_type}" race="{man_race}" />; 
		</foreach>
	</if>
	</p>

   <if cond='isset({total[atq_unt]})'>
       <p>[ {total[atq_unt]} <img src="img/{man_race}/div/atq.png" alt="Attaque Unité" />
       <if cond="isset({total[atq_btc]})"> - {total[atq_btc]} <img src="img/{man_race}/div/atq.png" alt="Attaque Bâtiment" /></if>
       - {total[def]} <img src="img/{man_race}/div/def.png" alt="Défense" />
       - Vie: {total[vie]}
       - bonus : {total[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus Attaque" />
       / {total[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus Défense" />
       / {total[bonus][vie]} <img src="img/{man_race}/div/tir.png" alt="Bonus Vie" /> (addition) ]
        </p>
       <if cond="isset({total[carry]})">
            <p>Capacité de transport: {total[carry]}</p>
       </if>
   </if>

</dd>

</dl>
