<if cond="isset({al_have_al})">
		<p class="error">Une autre demande est déjà en cours, ou vous êtes déjà dans une alliance.</p>
</if>
<elseif cond='isset({al_bad_aid})'>
	<p class="error">Cette Alliance n'existe pas.</p>
</elseif>
<elseif cond='isset({al_ok}) && {al_ok}'>
	<p class="ok">Demande envoyée. Vous recevrez un message si vous êtes accepté.</p>
</elseif>
<else>
	<p>Vous voulez rejoindre l'alliance 
	<a href="alliances-view.html?al_aid={al_array[al_aid]}">
	<img src="img/al_logo/{al_array[al_aid]}-thumb.png" class="mini_al_logo" alt="{al_array[al_name]}" title="{al_array[al_name]}"/>{al_array[al_name]}</a> :
	<br/>
	<foreach cond="{_races_aly[{al_chef[mbr_race]}]} as {race_id} => {nb}">
		<if cond="{_races[{race_id}]} && {nb}">
			[ {al_stat[{race_id}]}/{nb} <img src="img/{race_id}/{race_id}.png" alt="{race[{race_id}]}" title="{race[{race_id}]}" /> ]
		</if>
	</foreach>
	- Total: {al_array[al_nb_mbr]}/{ALL_MAX}
	<br/>Il faut au minimum {ALL_MIN_PTS} points pour rejoindre une alliance et le prix de l'adhésion est de {ALL_JOIN_PRICE} <zimgres race="{_user[race]}" type="1" />.
	</p>
	
	<if cond="isset({al_join_price})">
		<form action="alliances-join.html" method="post">
			<input type="hidden" name="al_aid" value="{al_aid}" />
			<input type="submit" value="Rejoindre cette alliance" />
		</form>
	</if>
	<else>
		<if cond='isset({al_not_enought_pts})'>
			<p class="error">Il faut au minimum {al_not_enought_pts}pts pour rejoindre une Alliance.</p>
		</if>
		<elseif cond='isset({al_not_enought_gold})'>
			<p class="error">Il faut {ALL_JOIN_PRICE} <zimgres race="{_user[race]}" type="1" /> pour rejoindre une alliance.</p>
		</elseif>
		<elseif cond='isset({al_full})'>
			<p class="error">Alliance pleine, ou demandes fermées.</p>
		</elseif>
		<elseif cond='isset({al_bad_race})'>
			<p class="error">Cette alliance ne peut pas accepter plus de personnes de votre race.</p>
		</elseif>
	</else>
</else>

