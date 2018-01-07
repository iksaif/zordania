<a name="actbar"></a>
<ul>
    <li>
        <a href="#" id="openmenulat" title="Menu."><img src="img/acts/menu_bg.png" /></a>
    </li>
    <li>
        <a href="forum.html" title="Forum."><img src="img/acts/codu.png" /></a>
    </li>
	<if cond='{_user[alaid]} != 0'>
		<li>
			<a href="alliances-my.html" title="Votre Alliance."><img src="img/acts/aly.png" /></a>
		</li>
	</if>
	<elseif cond='{_user[points]} >= {ALL_MIN_PTS}'>
		<li>
			<a href="alliances-my.html" title="Créer votre alliance."><img src="img/acts/aly.png" /></a>
		</li>
	</else>
	<li>
		<a href="gen.html" title="Informations générales du village."><img src="img/acts/gen.png" /></a>
	</li>
	<li>
		<a href="btc-btc.html" title="Construire des bâtiments."><img src="img/acts/ctr.png" /></a>
	</li>
	<li>
		<a href="unt.html" title="Voir la population."><img src="img/acts/unt{_user[race]}.png" /></a>
	</li>
	<li>
		<a href="leg.html" title="Attaques, Légions."><img src="img/acts/leg.png" /></a>
	</li>
	<li>
		<foreach cond='{stats_prim_btc[ext]} as {btc_menu_type} => {btc_menu_array}'>
			<foreach cond='{btc_menu_array} as {btc_menu_sub}'>
				<a href="btc-use.html?btc_type={btc_menu_type}&amp;sub={btc_menu_sub}" title="{btcact[{_user[race]}][descr][{btc_menu_type}][{btc_menu_sub}]}"><img src="img/acts/{btc_menu_sub}.png" /></a>
			</foreach>
		</foreach>
	</li>
	<li>
		<a href="carte.html" title="Carte de Zordania."><img src="img/acts/map.png" /></a>
	</li>
	<li>
		<a href="btc-use.html" title="Gérer le village."><img src="img/acts/vlg{_user[race]}.png" /></a>
	</li>
	<li>
		<a href="res.html" title="Voir les ressources."><img src="img/acts/res.png" /></a>
		<img src="img/star.png" alt="Popup" title="Popup" onclick="myPopup('res', '', 300,550);return false;" />
	</li>
	<if cond='{ses_admin} OR {_user[groupe]} == {GRP_PRETRE}'><!-- link forum staff -->
		<li>
			<a href="forum.html?cid=3#cid3" title="Forum Staff."><img src="img/acts/codu.png" /></a>
		</li>
	</if>
	<if cond='{ses_admin}'>		
		<li>
			<if cond='{ses_adm_msg}'>
			<a href="admin.html?module=msg" title="Signalement de messages!"><img src="img/acts/adm_hi.png" /></a>
			</if><else>
			<a href="admin.html" title="Administration."><img src="img/acts/adm.png" /></a>
			</else>
		</li>
	</if>
</ul>
