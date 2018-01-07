<foreach cond="{race} as {race_id} =>{race_name}">
	<load file="race/{race_id}.config" />
	<load file="race/{race_id}.descr.config" />
</foreach>
<div class="menu_module">
	<a href="war-histo.html" title="Historique de vos attaques et de celles de vos ennemis.">Journal de guerre</a> - 
	<a href="leg.html" title="Créer, Modifier, Déplacer vos Légions">Gestion des Légions</a> -
	<a href="leg-hero.html" title="Gérer les compétences de votre héro">Gestion du Héros</a>
	<hr />
</div>
<if cond='{war_act} == "histo"'>
	<include file="modules/war/journal.tpl" cache="1" />
</if>


<elseif cond='{war_act} == "make_atq"'>
	<if cond="isset({atq_no_leg})">
		<div class="error">Cette légion n'éxiste pas.<div>
	</if>
	<elseif cond="isset({atq_no_mbr})">
		<div class="error">Les légions ne peuvent attaquer que dans les villages.</div>
	</elseif>
	<elseif cond="isset({atq_cp_protect})">
		<div class="infos">Les dieux ont accordé leur protection à ce village, il est imprenable pendant la durée du sortilège.</div>
	</elseif>
	<elseif cond="isset({atq_bad_leg1})">
		<div class="error">Cette légion ne vous appartient pas.</div>
	</elseif>
	<elseif cond="isset({atq_bad_etat})">
		<div class="error">Cette légion n'est pas en position d'attaque.</div>
	</elseif>
	<elseif cond="isset({atq_cant})">
		<div class="error">Impossible d'attaquer ce joueur.</div>
	</elseif>
	<elseif cond="isset({atq_aly})">
		<div class="error">Impossible de trahir un allié !</div>
	</elseif>
	<elseif cond="isset({atq_max_atq})">
		<div class="error">Vous avez déjà attaqué ce joueur {ATQ_MAX_NB24H} fois lors des dernières 24h.</div>
	</elseif>
	<elseif cond="isset({atq_leg_empty})">
		<div class="error">Votre légion est vide, attaque impossible !</div>
	</elseif>
	<elseif cond="isset({atq_bad_cid})">
		<div class="error">Votre légion n'est pas sur le village ennemi, attaque impossible !</div>
	</elseif>
	<elseif cond="isset({atq_leg_enn_vide})">
		<div class="error">La légion ennemie est vide, attaque impossible !</div>
	</elseif>
	<else>
		<h3>Vous attaquez {mbr2_array[mbr_pseudo]}</h3>
		<set name="race2" value="{mbr2_array[mbr_race]}" />
		<dl id="atq_0">


<dt>Votre légion : {bilan[att][leg_name]} (vie {bilan[att][vie_leg]})</dt>
<set name="leg" value="{bilan[att]}" />
<dd>
<foreach cond="{leg[leg]} as {type} => {unt_nb}">
	<if cond="{type} != {leg[hro_type]}">{unt_nb} <zimgunt type="{type}" race="{leg[mbr_race]}" /></if>
</foreach>
<if cond="{leg[hro_vie]}">
	<p><zimgunt type="{leg[hro_type]}" race="{leg[mbr_race]}" /> {leg[hro_nom]}
	<zimgbar per="{leg[hro_vie]}" max="{leg[hro_vie_conf]}" />
	Vie: {leg[hro_vie]} / {leg[hro_vie_conf]},
	Expérience: {leg[hro_xp]}
	<if cond="!empty({leg[bonus]})">, Compétence active : <zimgcomp type="{leg[bonus]}" race="{leg[mbr_race]}" /></if>
	</p>
</if>
</dd>



<foreach cond="{bilan[def]} as {key} => {leg}">
	<dt>légion {leg[leg_name]} de 
		<img src="img/{leg[mbr_race]}/{leg[mbr_race]}.png" title="{race[{leg[mbr_race]}]}" alt="{race[{leg[mbr_race]}]}"/> 
		<a href="member-view.html?mid={leg[mbr_mid]}" title="infos sur {leg[mbr_pseudo]}">{leg[mbr_pseudo]}</a>
		(vie {leg[vie_leg]})
		<if cond="{leg[ratio_def]} < 1">Défense groupée à <math oper="{leg[ratio_def]}*100" /> %</if>
	</dt>
	<dd>
	<foreach cond="{leg[leg]} as {type} => {unt_nb}">
		<if cond="{type} != {leg[hro_type]}">{unt_nb} <zimgunt type="{type}" race="{leg[mbr_race]}" /></if>
	</foreach>
	<if cond="{leg[hro_vie]}">
		<p><zimgunt type="{leg[hro_type]}" race="{leg[mbr_race]}" /> {leg[hro_nom]}
		<zimgbar per="{leg[hro_vie]}" max="{leg[hro_vie_conf]}" />
		Vie: {leg[hro_vie]} / {leg[hro_vie_conf]}, 
		Expérience: {leg[hro_xp]}
		<if cond="!empty({leg[bonus]})">, Compétence active : <zimgcomp type="{leg[bonus]}" race="{leg[mbr_race]}" /></if>
		</p>
	</if>
	</dd>
</foreach>


	<dt>Batiments défensifs présents dans le village : </dt>
	<dd>
	<foreach cond="{bilan[btc_def]} as {type} => {nb}">
		{nb} <zimgbtc type="{type}" race="{race2}" />
	</foreach>
	</dd>


	<if cond="!empty({bilan[legs]})">
	<h3>Autres légions en présence</h3>
	<foreach cond="{bilan[legs]} as {key} => {leg}">
		<dd>légion {leg[leg_name]} de 
<img src="img/{leg[mbr_race]}/{leg[mbr_race]}.png" title="{race[{leg[mbr_race]}]}" alt="{race[{leg[mbr_race]}]}"/> 
<a href="member-view.html?mid={leg[mbr_mid]}" title="infos sur {leg[mbr_pseudo]}">{leg[mbr_pseudo]}</a>
		<if cond="{leg[hro_id]}">menée par 
			<zimgunt type="{leg[hro_type]}" race="{leg[mbr_race]}" /> {leg[hro_nom]}
		</if>
		<if cond="{leg[statut]}">(légion vide)</if><else>(légion non alliée du défenseur)</else>
		</dd>
	</foreach>
	</if>


		</dl>
		<div>
		<h2>Résultat</h2>
		<dl>


	<dt>Votre légion {bilan[att][leg_name]} reçoit {bilan[att][pertes][deg_sub]} dégats et perd : </dt>
	<dd>
	<if cond="isset({bilan[att][pertes][unt]})">
		<foreach cond="{bilan[att][pertes][unt]} as {type} => {nb}">
			{nb} <zimgunt type="{type}" race="{_user[race]}" />
		</foreach>
	</if>
	<if cond="{bilan[att][hro_vie]}">
		<br /><zimgunt type="{bilan[att][hro_type]}" race="{_user[race]}" /> {bilan[att][hro_nom]} 
		a perdu {bilan[att][pertes][deg_hro]} Points de vie
		<zimgbar per="{bilan[att][pertes][hro_reste]}" max="{_user[hro_vie_conf]}" />
		Vie : {bilan[att][pertes][hro_reste]} / {_user[hro_vie_conf]}
		<if cond="{bilan[att][pertes][hro_reste]} == 0">
			<p class="error">{bilan[att][hro_nom]} a succombé à ses blessures !</p>
		</if>
	</if>
	<p>attaque unité totale : {bilan[att][stat][unt]}, inflige {bilan[att][stat][fin]} dégat, l'armée prend {bilan[att][pertes][deg_sub]} et le héros perd {bilan[att][pertes][deg_hro]}</p>
	<if cond="!empty({bilan[att][bonus]})">
		<include file="modules/comp/{bilan[att][bonus]}.tpl" cache="1" cpt="{bilan[att][comp]}" /><br />
	</if>
	</dd>



	<foreach cond="{bilan[def]} as {key} => {leg}">
	<if cond="isset({leg[pertes][deg_sub]})">
		<dt>La légion {leg[leg_name]} de <img src="img/{leg[mbr_race]}/{leg[mbr_race]}.png" title="{race[{leg[mbr_race]}]}" alt="{race[{leg[mbr_race]}]}"/> 
<a href="member-view.html?mid={leg[mbr_mid]}" title="infos sur {leg[mbr_pseudo]}">{leg[mbr_pseudo]}</a>
		reçoit {leg[pertes][deg_sub]} dégats (ratio <math oper="round({leg[ratio]}*100,2)" /> % - XP <math oper="round({leg[xp_won]},2)" />) et perd :</dt>
		<dd>
		<if cond="isset({leg[pertes][unt]})">
		<foreach cond="{leg[pertes][unt]} as {type} => {nb}">
			{nb} <zimgunt type="{type}" race="{leg[mbr_race]}" />
		</foreach>
		</if>
		<if cond="{leg[hro_vie]}">
			<br /><zimgunt type="{leg[hro_type]}" race="{leg[mbr_race]}" /> {leg[hro_nom]}
			a perdu {leg[pertes][deg_hro]} Points de vie
			<zimgbar per="{leg[pertes][hro_reste]}" max="{leg[hro_vie_conf]}" />
			Vie : {leg[pertes][hro_reste]} / {leg[hro_vie_conf]}
			<if cond="{leg[pertes][hro_reste]} == 0">
				<p class="error">{leg[hro_nom]} a succombé à ses blessures !</p>
			</if>
		</if>
		</dd>
	<p>attaque unité totale : {leg[stat][unt]}, inflige {leg[stat][fin]} dégat, l'armée prend {leg[pertes][deg_sub]} et le héros perd {leg[pertes][deg_hro]}</p>
	</if>
	<if cond="!empty({leg[bonus]})">
		<include file="modules/comp/{leg[bonus]}.tpl" cache="1" cpt="{leg[comp]}" /><br />
	</if>
	</foreach>


	<dt>Bâtiments endommagés ou détruits :</dt>
	<dd>
	<foreach cond="{bilan[btc_edit]} as {value}">
		{value[vie]} / {value[vie_max]} <zimgbtc type="{value[type]}" race="{race2}" />
	</foreach>
	<br />{bilan[atq_bat]} dégâts sur les bâtiments
	<br />
	<foreach cond="{bilan[btc_unt]} as {leg}">
	<foreach cond="{leg} as {rang}">
	<foreach cond="{rang} as {type} => {nb}">
		{nb} <zimgunt type="{type}" race="{race2}" />
	</foreach>
	</foreach>
	</foreach>
	</dd>


	<dt>Votre Butin :</dt>
	<dd>
	<foreach cond="{bilan[butin][att]} as {res} => {nb}">
		{nb} <zimgres type="{res}" race="{_user[race]}" />
	</foreach>
	</dd>


	<dt>Butin concédé à l'ennemi :</dt>
	<dd>
	<foreach cond="{bilan[butin][def]} as {res} => {nb}">
		{nb} <zimgres type="{res}" race="{_user[race]}" />
	</foreach>
	</dd>

	<if cond="!empty({bilan[att][hro_id]})">
		<if cond="{bilan[att][pertes][hro_reste]} == 0">
			<if cond="{bilan[att][bonus]} == {CP_RESURECTION}">
				<p class="ok"><zimgcomp type="{bilan[att][bonus]}" race="{bilan[att][mbr_race]}" /> Votre héros succombe à ses blessures... puis ressucite au village ! Ce combat lui rapporte {bilan[att][xp_won]} XP.</p>
			</if><else>
				<p class="error">Votre héros est mort... Ce combat lui rapporte {bilan[att][xp_won]} XP à titre posthume.</p>
			</else>
		</if>
		<else>
			<p class="ok">Votre héros gagne {bilan[att][xp_won]} XP</p>
		</else>
	</if>
	<else>
		<p class="ok">Ce combat aurait rapporté {bilan[att][xp_won]} XP</p>
	</else>


		</dl>
		</div>

<if cond="{SITE_DEBUG}">
		<h2>Résumé du combat</h2>
		 {bilan[att][stat][unt]} unités, <strong>Attaque unité</strong>= {bilan[att][stat][unt]}, finale = {bilan[att][stat][fin]} dégat unité et {bilan[att][stat][bat]} dégat bâtiment<br />
		<foreach cond="{bilan[def]} as {key} => {leg}">
			 {leg[stat][unt]} unités, <strong>Défense {leg[leg_name]}</strong> = {leg[stat][unt]}, finale = {leg[stat][fin]} dégat unité<br />
		</foreach>


		<table>
		<tr>
			<th>Légion (xp)</th>
			<th>Vie</th>
			<th>atq ou déf
				unité</th>
			<th>Bonus</th>
			<th>attaque finale</th>
			<th>Dégat subit</th>
			<th>Gain XP</th>
			<th>Perte vie Heros</th>
		</tr>
		<tr>
			<td>{bilan[att][leg_name]} ({bilan[att][hro_xp]})</td>
			<td>{bilan[att][vie_leg]}</td>
			<td>{bilan[att][stat][unt]}</td>
			<td>{bilan[att][stat][bonus][atq]} %</td>
			<td>{bilan[att][stat][fin]}</td>

			<td><if cond="isset({bilan[att][deg_sub]})">{bilan[att][pertes][deg_sub]}</if></td>
			<td><if cond="isset({bilan[att][xp_won]})">{bilan[att][xp_won]}</if></td>
			<td><if cond="isset({bilan[att][deg_hro]})">{bilan[att][pertes][deg_hro]}</if></td>
		</tr>

		<foreach cond="{bilan[def]} as {key} => {leg}">
		<tr>
			<td>{leg[leg_name]} ({leg[leg_xp]})</td>
			<td>{leg[vie_leg]}</td>
			<td><if cond="isset({leg[stat]})">{leg[stat][unt]}</if> </td>
			<td><if cond="isset({leg[stat]})">{leg[stat][bonus][atq]} %</if> </td>

			<td><if cond="isset({leg[stat]})">{leg[stat][fin]}</if> </td>
			<td><if cond="isset({leg[deg_sub]})">{leg[pertes][deg_sub]}</if></td>
			<td><if cond="isset({leg[xp_won]})"><math oper="round({leg[xp_won]},2)" /></if></td>
			<td><if cond="isset({leg[deg_hro]})">{leg[pertes][deg_hro]}</if></td>
		</tr>
		</foreach>
		</table>
</if>

	</else>
</elseif>
