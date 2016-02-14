<if cond='|{al_act}| == "liste"'>
	<if cond='count(|{al_array}|) > 0'>
		<table class="border1">
			<tr>
			<th>Nom</th>
			<th>Points</th>
			<th>Chef</th>
			<th>Membres</th>
			<th>Logo</th>
			<th>Actions</th>
			</tr>
		<foreach cond='|{al_array}| as |{al_key}| => |{al_value}|'>
		<tr>
			<td><a href="index.php?file=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
			<td>{al_value[al_points]}</td>
			<td><a href="index.php?file=member&amp;act=view&amp;mid={al_value[al_mid]}" title="Infos sur {al_value[mbr_pseudo]}">{al_value[mbr_pseudo]}</td>
			<td>{al_value[al_nb_mbr]}</td>
			<td>
			<a href="index.php?file=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}">
			<img src="img/al_logo/{al_value[al_aid]}-thumb.png" class="mini_al_logo" alt="{al_value[al_name]}" title="{al_value[al_name]}"/>
			</a>
			</td>
			<td>
			<if cond='|{al_array[al_nb_mbr]}| < |{al_max_mbr_nb}| AND |{al_value[al_open]}| AND |{session_user[alaid]}| == 0'>
			<a href="index.php?file=alliances&amp;act=join&amp;al_aid={al_value[al_aid]}">
			<img src="img/join.png" alt="Rejoindre" title="Rejoindre {al_value[al_name]}" />
			</a> - 
			</if>
			<if cond='|{session_user[alaid]}| != |{al_value[al_aid]}|'>
			<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={al_value[al_mid]}" title="Envoyer un message au chef de {al_value[al_name]}">
			<img src="img/msg.png" alt="Msg" />
			</a>
			</if>
			</td>
		</tr>
		</foreach>
		</table>
	<br />Page : 
	<for cond='|{i}| = 0; |{i}| < |{al_nb}|; |{i}|+=|{limite_page}|'>
		<if cond='|{i}| / |{limite_page}| != |{al_page}|'>
			<a href="index.php?file=alliances&amp;al_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
		</if>
		<else>
		<math oper='(({i} / {limite_page})+1)' />
		</else>	
	</for>
	</if>
	<else>
	<p class="infos">Aucune Alliance</p>
	</else>
	<div class="infos">Vous ne pouvez rejoindre une Alliance que si vous avez plus de {ALL_MIN_PTS} points et qu'une Alliance accepte encore des joueurs (bouton Rejoindre présent).
	<br/>
	Pour créer une Alliance il faut {ALL_MIN_ADM_PTS} points.</div>
</if>
<elseif cond='|{al_act}| == "search"'>
	<if cond='count(|{al_array}|) > 0'>
		<table class="border1">
			<tr>
			<th>Nom</th>
			<th>Points</th>
			<th>Chef</th>
			<th>Membres</th>
			<th>Logo</th>
			<th>Actions</th>
			</tr>
		<foreach cond='|{al_array}| as |{al_key}| => |{al_value}|'>
		<tr>
			<td><a href="index.php?file=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
			<td>{al_value[al_points]}</td>
			<td><a href="index.php?file=member&amp;act=view&amp;mid={al_value[al_mid]}" title="Infos sur {al_value[mbr_pseudo]}">{al_value[mbr_pseudo]}</td>
			<td>{al_value[al_nb_mbr]}</td>
			<td>
			<a href="index.php?file=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}">
			<img src="img/al_logo/{al_value[al_aid]}-thumb.png" class="mini_al_logo" alt="{al_value[al_name]}" title="{al_value[al_name]}"/>
			</a>
			</td>
			<td>
			<if cond='|{al_array[al_nb_mbr]}| < |{al_max_mbr_nb}| AND |{al_value[al_open]}| AND |{session_user[alaid]}| == 0'>
			<a href="index.php?file=alliances&amp;act=join&amp;al_aid={al_value[al_aid]}">
			<img src="img/join.png" alt="Rejoindre" title="Rejoindre {al_value[al_name]}" />
			</a> - 
			</if>
			<if cond='|{session_user[alaid]}| != |{al_value[al_aid]}|'>
			<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={al_value[al_mid]}" title="Envoyer un message au chef de {al_value[al_name]}">
			<img src="img/msg.png" alt="Msg" />
			</a>
			</if>
			</td>
		</tr>
		</foreach>
		</table>
	</if>
	<else>
		<p class="infos">Aucune Alliance</p>
	</else>
</elseif>
<hr />
<form action="index.php?file=alliances&amp;act=search" method="post">
	<label for="name">Nom:</label>
	<input type="text" name="name" id="name" />
	<input type="submit" value="Rechercher" />
</form>
