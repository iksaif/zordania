<ul>
	<li>
	Période: <img src="img/period/{_cache[period]}.png" alt="{periods[{_cache[period]}]}" title="{periods[{_cache[period]}]}" />
	 - Heure: {_cache[tour]}
	</li>
	<li> {stats_date}</li>
	<# <!-- afficher date+heure --><li> Prochain Tour : {stats_next_turn}</li>  #>
<if cond='isset({stats_prim_res}) AND is_array({stats_prim_res})'>
	<li>
	<foreach cond='{stats_prim_res} as {res_type} => {res_nb}'>
		<img src="img/{_user[race]}/res/{res_type}.png" alt="{res[{_user[race]}][alt][{res_type}]}" title="{res[{_user[race]}][alt][{res_type}]}" /> {res_nb}
	</foreach>
		<img src="img/{_user[race]}/{_user[race]}.png" alt="Place" title="Place" /> {_user[population]}/{_user[place]}
	</li>
	<li>
	<img src="img/groupes/{_user[groupe]}.png" alt="{groupes[{_user[groupe]}]}" title="{groupes[{_user[groupe]}]}"/>
	{_user[pseudo]} Points: {_user[points]}
	</li>
</if>
<elseif cond="{_user[etat]} == MBR_ETAT_INI">
	<li>&nbsp;</li>
	<li>{_user[pseudo]}</li>
	<li><a href="ini.html" title="Initialiser!">Compte non initialisé !</a></li>
</elseif>
<else>
	<li>&nbsp;</li>
	<li>Vous êtes un visiteur !</li>
	<li>&nbsp;</li>
</else>
</ul>
<if cond='{ses_loged} && {_user[login]} != "guest"'>
	<div class="menu_module">
	<br />
	[
	<a href="notes.html" title="Gérez vos notes...">Notes</a>
	-
	<a href="histo.html" title="Événements importants ...">Événements</a>
	-
	<if cond='{_user[msg]} == 1'>
	 	<a href="msg.html" title="Vous avez {_user[msg]} nouveau message."><strong>{_user[msg]}</strong><img src="img/msg.png"/></a>
	</if>
	<elseif cond='{_user[msg]} > 1'>
	 	<a href="msg.html" title="Vous avez {_user[msg]} nouveaux messages."><strong>{_user[msg]}</strong><img src="img/msg.png"/></a>
	</elseif>
	<else>
	 	<a href="msg.html" title="Envoyer/Recevoir des messages.">{_user[msg]}<img src="img/msg.png"/></a>
	</else>
	]
	</div>
</if>
