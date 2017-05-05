<include file="commun/races.tpl" select="{man_race}" general="0" url="{man_url}" />
<p class="block_forum">
Le manuel parle du site et du système de jeu en général. Pour avoir des informations sur une race en particulier, il suffit de cliquer sur la race puis sur la partie qui vous intéresse.
</p>
<h3>Manuel des <img src="img/{man_race}/{man_race}.png" alt="{race[{man_race}]}" title="{race[{man_race}]}" />  {race[{man_race}]} :</h3>

<if cond='{man_race}'>
	<if cond='isset({man_load})'>
		<load file="race/{man_race}.config" />
		<load file="race/{man_race}.descr.config" />
	</if>
</if>

<if cond='isset({mnl_tpl})'>
<hr />
<include file="{mnl_tpl}" cache="1" />
<if cond="{mnl_tree}">
<script type="text/javascript" src="js/manuel.js"></script>
<p class="center"><img src="img/{man_race}/arbre.png" alt="Arbre technologique" usemap="#arbre" /></p>

<include file="modules/manual/{man_race}.tpl" cache="1" />

<foreach cond='{man_btc} as {btc_id} => {btc_value}'>
<div id="btc_{btc_id}">
	<dt>
	<a href="manual.html?race={man_race}&type=btc#btc_{btc_id}">
		<img style="align: left" src="img/{man_race}/btc/{btc_id}.png" alt="{btc[{man_race}][alt][{btc_id}]}" title="{btc[{man_race}][alt][{btc_id}]}" /> {btc[{man_race}][alt][{btc_id}]}
	</a>
	</dt>
	<dd>
	<p>{btc[{man_race}][descr][{btc_id}]}  </p>
	<if cond='isset({btc_value[bonus]})'>
		Bonus: 
		<if cond='isset({btc_value[bonus][atq]})'>{btc_value[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus atq" /></if>
		<if cond='isset({btc_value[bonus][def]})'>{btc_value[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus def" /></if>
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
			</foreach>
		</p>
	</if>
	<if cond='isset({btc_value[prix_trn]})'>
		<p>Terrains: 
			<foreach cond='{btc_value[prix_trn]} as {trn_type} => {trn_nb}'>
				{trn_nb} <zimgtrn type="{trn_type}" race="{man_race}" />
			</foreach>
		</p>
	</if>
	<if cond='isset({btc_value[prix_unt]})'>
	<p>Unités Nécessaires :
		<foreach cond='{btc_value[prix_unt]} as {unt_type} => {unt_nb}'>
			{unt_nb} <zimgunt type="{unt_type}" race="{man_race}" />
		</foreach>
	</p>
	</if>
	<if cond='isset({btc_value[need_src]})'>
	<p>Recherche : 
		<foreach cond='{btc_value[need_src]} as {src_type}'>
			<zimgsrc type="{src_type}" race="{man_race}" />
		</foreach>
	</p>
	</if>
	<if cond="isset({btc_value[need_btc]})">
	<p>Bâtiment:
		<foreach cond="{btc_value[need_btc]} as {btc_id}">
			<zimgbtc type="{btc_id}" race="{man_race}" />
		</foreach>
	</p>
	</if>
	<if cond='isset({btc_value[prod_res_auto]})'>
	<p>Produit :
		<foreach cond='{btc_value[prod_res_auto]} as {res_type} => {res_nb}'>
			{res_nb} <zimgres type="{res_type}" race="{man_race}" />
		</foreach>
	</p>
	</if>
	<if cond="isset({btc_value[limite]})">
	<p> Maximum: {btc_value[limite]}</p>
	</if>
	</dd>
</div>
</foreach>


<foreach cond='{man_src} as {src_id} => {src_value}'>
<div id="src_{src_id}">
	<dt>
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
			</foreach>
		</p>
		</if>
		<if cond='isset({src_value[need_src]})'>
		<p>Recherche : 
			<foreach cond='{src_value[need_src]} as {src_type}'>
				<zimgsrc type="{src_type}" race="{man_race}" />
			</foreach>
		</p>
		</if>
		<if cond='isset({src_value[need_no_src]})'>
		<p>Incompatibilité: 
			<foreach cond='{src_value[need_no_src]} as {src_type}'>
				<zimgsrc type="{src_type}" race="{man_race}" />
			</foreach>
		</p>
		</if>
		<if cond='isset({src_value[need_btc]})'>
		<p>Bâtiments: 
			<foreach cond='{src_value[need_btc]} as {btc_type}'>
				<zimgbtc type="{btc_type}" race="{man_race}" />
			</foreach>
		</p>
		</if>
	</dd>
</div>
</foreach>


<foreach cond='{man_res} as {res_id} => {res_value}'>
<div id="res_{res_id}">
	<dt>
	<a href="manual.html?race={man_race}&type=res#res_{res_id}">
		<zimgres type="{res_id}" race="{man_race}" />
		{res[{man_race}][alt][{res_id}]}</a>
	</dt>
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
			</foreach>
		</p>
		</if>
	</dd>
</div>
</foreach>


<foreach cond='{man_unt} as {unt_id} => {unt_value}'>
<div id="unt_{unt_id}">
	<dt>
		<a href="manual.html?race={man_race}&type=unt#unt_{unt_id}">
			<zimgunt type="{unt_id}" race="{man_race}" /> {unt[{man_race}][alt][{unt_id}]}
		</a>
	</dt>
	<dd>
		<p>{unt[{man_race}][descr][{unt_id}]}<br/>
			Type: {roles[{unt_value[role]}]}
		</p>
		<if cond='isset({unt_value[atq_unt]}) OR isset({unt_value[atq_btc]}) OR isset({unt_value[def]})'>
		<p>
			[ <if cond='isset({unt_value[atq_unt]})'>{unt_value[atq_unt]} <img src="img/{man_race}/div/atq.png" alt="Attaque Unité" /></if>
			<if cond="isset({unt_value[atq_btc]})"> - {unt_value[atq_btc]}
			<img src="img/{man_race}/div/atq_btc.png" alt="Attaque Bâtiment" />
			</if>
			<if cond="isset({unt_value[def]})">  - {unt_value[def]} <img src="img/{man_race}/div/def.png" alt="Défense" /></if> ]
<br/></if>	
			
			<if cond="isset({unt_value[vie]})">Vie: {unt_value[vie]}<br /></if>
			<if cond="isset({unt_value[vit]})">Vitesse: {unt_value[vit]}<br /> </if>
			<if cond='isset({unt_value[bonus]})'>
				Bonus: 
				<if cond='isset({unt_value[bonus][atq]})'>{unt_value[bonus][atq]} <img src="img/{man_race}/div/atq.png" alt="Bonus atq" /></if>
				<if cond='isset({unt_value[bonus][def]})'>{unt_value[bonus][def]} <img src="img/{man_race}/div/def.png" alt="Bonus def" /></if>
				<if cond='isset({unt_value[bonus][vie]})'>{unt_value[bonus][vie]} <img src="img/{_user[race]}/div/tir.png" alt="Vie" /></if>
				<br />
			</if>
			<if cond="isset({unt_value[limite]})"><p>Maximum: {unt_value[limite]}</p></if>
			<if cond="isset({unt_value[capacity]})"><p>Capacité de transport: {unt_value[capacity]}</p></if>
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
</div>
</foreach>
</if>
</if>


