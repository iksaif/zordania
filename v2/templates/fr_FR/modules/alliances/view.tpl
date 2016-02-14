<if cond="!empty({ally})">
		<if cond='{al_logo}'>
			<img class="blason blason" src="{al_logo}" alt="Blason" />
		</if>
		<h3>{ally[al_name]}</h3>
		Chef : <zurlmbr gid="{chef[mbr_gid]}" mid="{chef[mbr_mid]}" pseudo="{chef[mbr_pseudo]}"/>
		<br/>
		Race : <img src="img/{chef[mbr_race]}/{chef[mbr_race]}.png" alt="{race[{chef[mbr_race]}]}" title="{race[{chef[mbr_race]}]}" /><br/>
		Points : {ally[al_points]}<br/>
		<if cond="isset({mbr_dpl[{ally[al_aid]}]})">
			Pacte : <img src="img/dpl/{mbr_dpl[{ally[al_aid]}]}.png" title="{dpl_type[{mbr_dpl[{ally[al_aid]}]}]}"/> {dpl_type[{mbr_dpl[{ally[al_aid]}]}]}
			<br/>
		</if>

		<a href="http://{zordlog_url}/alliance.html?al_id={ally[al_aid]}" title="Plus d'informations sur les Archives" ><img src="img/sablier.png"/> Archives</a>

		- <a href="diplo.html?al1={ally[al_aid]}" title="Voir la diplomatie de cette alliance"><img src="img/info.png"/> Diplomatie</a>

		<if cond="{_user[achef]}"> - <a href="diplo-add.html?al2={ally[al_aid]}" title="Proposer un nouveau pacte avec {ally[al_name]}"><img src="img/join.png"/> Proposer un pacte
		</a></if>

		<if cond='{ally[al_nb_mbr]} < {ALL_MAX} AND {ally[al_open]} AND {_user[alaid]} == 0'>
			- <a href="alliances-join.html?al_aid={ally[al_aid]}" title="Rejoindre {ally[al_name]}" >
			<img src="img/join.png"/> Rejoindre
			</a>
		</if>

		<if cond='{ses_admin} == "1"'>
			<span class="infos">
		   	<a href="admin-view.html?module=alliances&al_aid={ally[al_aid]}"><img src="img/plus.png" alt="Plus d'infos Admin" /></a> Admin
			</span>
		</if>


		<h3>Liste des Joueurs</h3>
		<table class="liste">
			<tr>
				<th>Pseudo</th>
				<th>Race</th>
				<th>Population</th>
				<th>Points</th>
				<th>Distance</th>
				<th>Msg</th>
				<th>Forces armées</th>
			</tr>	 
		<foreach cond='{al_mbr} as {result}'>
		<tr>
			<if cond='{chef[mbr_mid]} == {result[mbr_mid]}'>
				<th><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></th>
			</if>
			<else>
				<td><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></td>
			</else>
			<td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
			<td>{result[mbr_population]}</td>
			<td>{result[mbr_points]}</td>
			<td>{result[mbr_dst]}</td>
			<td><if cond='{result[mbr_mid]} != {_user[mid]}'>
				<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png"/>
				</a>
			</if></td>
			<td>{result[mbr_pts_armee]}

			<if cond='{result[mbr_mid]} != {_user[mid]} && {result[mbr_etat]} == {MBR_ETAT_OK}'>
				<if cond='{result[can_def]}'> - 
					<a href="leg-move.html?sub=atq&cid={result[mbr_mapcid]}" title="Soutenir {result[mbr_pseudo]}"><img src="img/{_user[race]}/div/def.png" /></a>
				</if>
				<elseif cond='{result[can_atq]}'> - 
					<a href="leg-move.html?sub=atq&cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}"><img src="img/{_user[race]}/div/atq.png" /></a>
				</elseif>
			</if>
			</td>
		</tr>
		</foreach>
		</table>	
		<hr/>
		<h3>Description</h3>
		{ally[al_descr]}
	</if>
	<else>
		<p class="error">Cette Alliance n'existe pas.</p>
	</else>
