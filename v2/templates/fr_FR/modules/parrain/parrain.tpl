<h3>Liens</h3>
<p>Donnez ces liens à vos amis !</p>
<dl>
	<dt>Url</dt>
	<dd>{cfg_url}inscr.html?parrain={_user[mid]}</dd>
	<dt>HTML</dt>
	<dd>&lt;a href="{cfg_url}inscr.html?parrain={_user[mid]}" title="Zordania.com" &gt;Zordania&lt;/a&gt;</dd>
	<dt>Forum</dt>
	<dd>[url={cfg_url}inscr.html?parrain={_user[mid]}]Zordania[/url]</dd>
</dl>

<h3>Gains</h3>
<p>Pour chaque bonus acheté par un filleul, vous gagnerez {PARRAIN_BONUS_PRC}% des ressources achetées. De plus, au bout d'un certain nombre de filleuls vous
pourrez gagner une récompense qui sera affichée dans votre profil:</p>
<dl>
	<dt><img src="img/rec/7.png" alt="{recompense[7]}" title="{recompense[7]}" /> {recompense[7]}</dt>
	<dd>{PARRAIN_GRD1} filleuls</dd>
	<dt><img src="img/rec/8.png" alt="{recompense[8]}" title="{recompense[8]}" /> {recompense[8]}</dt>
	<dd>{PARRAIN_GRD2} filleuls</dd>
	<dt><img src="img/rec/9.png" alt="{recompense[9]}" title="{recompense[9]}" /> {recompense[9]}</dt>
	<dd>{PARRAIN_GRD3} filleuls</dd>
</dl>

<h3>Filleuls</h3>
<table class="liste">
       <tr>
	<th>Pseudo</th>
	<th>Race</th>
	<th>Alliance</th>
	<th>Population</th>
	<th>Points</th>
	<th>Actions</th>
	</tr>
<foreach cond='{filleuls} as {result}'>
	<tr<if cond='{_user[alaid]} == {result[ambr_aid]} AND {_user[alaid]} != 0'> class="allie"</if>>
		<td>
			<zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/>
		</td>
		<td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
		<td>
<if cond='{result[ambr_aid]}'>
	<a href="alliances-view.html?al_aid={result[ambr_aid]}">
		<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
	</a>
</if>
<else>
		&nbsp;
</else>
		</td>
		<td>{result[mbr_population]}</td>
		<td>{result[mbr_points]}</td>
		<td>
<if cond='{result[mbr_mid]} != {_user[mid]}'>
	<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
		<img src="img/msg.png" alt="Msg" />
	</a>
</if>
<if cond='{result[can_atq]}'>
	-
	<a href="leg-move.html?cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}">
		<img src="img/{_user[race]}/div/atq.png" alt="Attaquer" />
	</a> 
</if>
&nbsp;
		</td>
	</tr>
</foreach>
</table>
