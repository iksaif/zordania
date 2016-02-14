<# cet include ne conserve pas le nb de joueurs par race #>
<include file="commun/races.tpl" select="{class_race}" url="class.html?act={class_type}&amp;region={class_region}" />


<p class="menu_module">
[
<a href="class.html?act=1&amp;race={class_race}&amp;region={class_region}" title="Top 50 Or">Or</a>
] - [
<a href="class.html?act=6&amp;race={class_race}&amp;region={class_region}" title="Top 50 Héros">Héros</a>
] - [
<a href="class.html?act=3&amp;race={class_race}&amp;region={class_region}" title="Top 50 Points">Points</a>
] - [
<a href="class.html?act=7&amp;race={class_race}&amp;region={class_region}" title="Top 50 Armées">Armées</a>
] - [
<a href="class.html?act=4&amp;race={class_race}&amp;region={class_region}" title="Top 50 Population">Population</a>
] - [
<a href="class.html?act=5&amp;race={class_race}&amp;region={class_region}" title="Top 50 Alliances">Alliances</a>
]
<br/>

<label for="class_region">Régions:</label>
<select name="region" id="class_region" onChange="parent.location.href='class.html?act={class_type}&amp;race={class_race}&amp;region='+this.options[this.selectedIndex].value;">
<if cond="{class_region}==0">
	<option value="0" selected="selected">Toutes</option>
</if>
<else>
	<option value="0">Toutes</option>
</else>
<foreach cond="{regions} as {region_id} =>{region_name}">
	<if cond="{class_region}=={region_id}">
             <option value="{region_id}" selected="selected">{region_name[name]}</option>
	</if>
	<else>
             <option value="{region_id}">{region_name[name]}</option>
	</else>
</foreach>
</select>
</p>

<set name="class_pos" value="0" />
<if cond='{class_array}'>
<if cond='{class_type} == 1'>
	<h3>Classement Or</h3>
  	<table class="liste">
  	<tr>
  	 <th></th>
  	 <th>Al</th>
  	 <th>Pseudo</th>
  	 <th>Race</th>
  	 <th>Or</th>
	 <th>Actions</th>
  	</tr>
   
   	<foreach cond='{class_array} as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
	 	<if cond="{result[ambr_aid]}">
			<a href="alliances-view.html?al_aid={result[ambr_aid]}" title="Infos sur {result[al_name]}">
			<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
   			</a>
		</if>
		<else>
			&nbsp;
		</else>
	</td>
	 <td><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></td>
  	 <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" alt="{race[{result[mbr_race]}]}" title="{race[{result[mbr_race]}]}" /></td>
  	 <td>
  	 	{result[res_nb]} <img src="img/{_user[race]}/res/1.png" alt="Or" title="Or" />
  	 </td>
	 <td>
		<if cond='{result[mbr_mid]} != {_user[mid]}'>
			<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
			<if cond="isset({mbr_dpl[{result[ambr_aid]}]})">
				<img src="img/dpl/{mbr_dpl[{result[ambr_aid]}]}.png" title="{dpl_type[{mbr_dpl[{result[ambr_aid]}]}]}"/>
			</if>
			<elseif cond='{result[ambr_aid]} && {result[ambr_aid]} == {_user[alaid]}'>
				- <a href="leg-move.html?sub=sou&amp;cid={result[mbr_mapcid]}" title="Protéger {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/def.png" alt="Protéger" /></a>
			</elseif>
			<if cond='{result[can_atq]}'>
				- <a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/atq.png" alt="Attaquer" /></a> 
			</if>
		</if>
	</td>
	</tr>
	</foreach>
	</table>
</if>
<elseif cond='{class_type} == 6'>
	<foreach cond="{race} as {race_id} =>{race_name}">
		<load file="race/{race_id}.config" />
		<load file="race/{race_id}.descr.config" />
	</foreach>
	<h3>Classement Héros</h3>
  	<table class="liste">
  	<tr>
  	 <th></th>
  	 <th>Pseudo</th>
  	 <th>Race</th>
  	 <th>Héros</th>
  	 <th>XP</th>
  	</tr>
   
   	<foreach cond='{class_array} as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></td>
  	 <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" alt="{race[{result[mbr_race]}]}" title="{race[{result[mbr_race]}]}" /></td>
  	 <td>
  	 	<zimgunt type="{result[hro_type]}" race="{result[mbr_race]}" /> {result[hro_nom]}
  	 </td>
  	 <td>
  	 	{result[hro_xp]}
  	 </td>
	</tr>
	</foreach>
	</table>
</elseif>
<elseif cond='{class_type} == 3'>
	<h3>Classement Points</h3>
  	<table class="liste">
  	<tr>
		<th></th>
		<th>Al</th>
		<th>Pseudo</th>
		<th>Race</th>
		<th>Points</th>
		<th>Armées</th>
		<th>Actions</th>
  	</tr>

   	<foreach cond='{class_array} as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
	 	<if cond="{result[ambr_aid]}">
			<a href="alliances-view.html?al_aid={result[ambr_aid]}" title="Infos sur {result[al_name]}">
			<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
   			</a>
		</if>
		<else>
			&nbsp;
		</else>
	</td>
	 <td><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></td>
  	 <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" alt="{race[{result[mbr_race]}]}" title="{race[{result[mbr_race]}]}" /></td>
  	 <td>
  	 	{result[mbr_points]}
  	 </td>
  	 <td>
  	 	{result[mbr_pts_armee]}
  	 </td>
	 	 <td>
		<if cond='{result[mbr_mid]} != {_user[mid]}'>
			<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
			<if cond="isset({mbr_dpl[{result[ambr_aid]}]})">
				<img src="img/dpl/{mbr_dpl[{result[ambr_aid]}]}.png" title="{dpl_type[{mbr_dpl[{result[ambr_aid]}]}]}"/>
			</if>
			<elseif cond='{result[ambr_aid]} && {result[ambr_aid]} == {_user[alaid]}'>
				- <a href="leg-move.html?sub=sou&amp;cid={result[mbr_mapcid]}" title="Protéger {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/def.png" alt="Protéger" /></a>
			</elseif>
			<if cond='{result[can_atq]}'>
				- <a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/atq.png" alt="Attaquer" /></a> 
			</if>
		</if>
		&nbsp;
	</td>
	</tr>
	</foreach>
	</table>
</elseif>
<elseif cond='{class_type} == 4'>
	<h3>Classement Population</h3>
  	<table class="liste">
  	<tr>
  	 <th></th>
  	 <th>Al</th>
  	 <th>Pseudo</th>
  	 <th>Population</th>
	 <th>Actions</th>
  	</tr>
   
   	<foreach cond='{class_array} as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
	 	<if cond="{result[ambr_aid]}">
			<a href="alliances-view.html?al_aid={result[ambr_aid]}" title="Infos sur {result[al_name]}">
			<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
   			</a>
		</if>
		<else>
			&nbsp;
		</else>
	</td>
	 <td><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></td>
  	 <td>
  	 	{result[mbr_population]} / {result[mbr_place]} <img src="img/{result[mbr_race]}/{result[mbr_race]}.png" alt="Place" title="Place" />
  	 </td>
	 	 <td>
		<if cond='{result[mbr_mid]} != {_user[mid]}'>
			<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
			<if cond="isset({mbr_dpl[{result[ambr_aid]}]})">
				<img src="img/dpl/{mbr_dpl[{result[ambr_aid]}]}.png" title="{dpl_type[{mbr_dpl[{result[ambr_aid]}]}]}"/>
			</if>
			<elseif cond='{result[ambr_aid]} && {result[ambr_aid]} == {_user[alaid]}'>
				- <a href="leg-move.html?sub=sou&amp;cid={result[mbr_mapcid]}" title="Protéger {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/def.png" alt="Protéger" /></a>
			</elseif>
			<if cond='{result[can_atq]}'>
				- <a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/atq.png" alt="Attaquer" /></a> 
			</if>
		</if>
		&nbsp;
	</td>
	</tr>
	</foreach>
	</table>
</elseif>
<elseif cond='{class_type} == 5'>
	<h3>Classement Alliances</h3>
	<table class="liste">
		<tr>
		<th></th>
		<th>Logo</th>
		<th>Nom</th>
		<th>Points</th>
		<th>Chef</th>
		<th>Membres</th>
		<th>Pacte</th>
		</tr>
	<foreach cond='{class_array} as {al_key} => {al_value}'>
	<tr>
		<td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
		<td><img src="img/al_logo/{al_value[ambr_aid]}-thumb.png" alt="{al_value[al_name]}" title="{al_value[al_name]}" class="mini_al_logo" /></td>
		<td><a href="alliances-view.html?al_aid={al_value[ambr_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
		<td>{al_value[al_points]}</td>
		<td><zurlmbr mid="{al_value[al_mid]}" pseudo="{al_value[mbr_pseudo]}"/></td>
		<td>{al_value[al_nb_mbr]}</td>
		<td>
			<if cond="isset({mbr_dpl[{al_value[ambr_aid]}]})">
				<img src="img/dpl/{mbr_dpl[{al_value[ambr_aid]}]}.png" title="{dpl_type[{mbr_dpl[{al_value[ambr_aid]}]}]}"/>
			</if>
		</td>
	</tr>
	</foreach>
	</table>
</elseif>
<elseif cond='{class_type} == 7'>
	<h3>Classement Armées</h3>
  	<table class="liste">
  	<tr>
		<th></th>
		<th>Al</th>
		<th>Pseudo</th>
		<th>Race</th>
		<th>Armées</th>
		<th>Actions</th>
  	</tr>

   	<foreach cond='{class_array} as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
	 	<if cond="{result[ambr_aid]}">
			<a href="alliances-view.html?al_aid={result[ambr_aid]}" title="Infos sur {result[al_name]}">
			<img src="img/al_logo/{result[ambr_aid]}-thumb.png" class="mini_al_logo" alt="{result[al_name]}" title="{result[al_name]}"/>
   			</a>
		</if>
		<else>
			&nbsp;
		</else>
	</td>
	 <td><zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/></td>
  	 <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" alt="{race[{result[mbr_race]}]}" title="{race[{result[mbr_race]}]}" /></td>
  	 <td>
  	 	{result[mbr_pts_armee]}
  	 </td>
	 	 	 <td>
		<if cond='{result[mbr_mid]} != {_user[mid]}'>
			<a href="msg-new.html?mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
			<if cond="isset({mbr_dpl[{result[ambr_aid]}]})">
				<img src="img/dpl/{mbr_dpl[{result[ambr_aid]}]}.png" title="{dpl_type[{mbr_dpl[{result[ambr_aid]}]}]}"/>
			</if>
			<elseif cond='{result[ambr_aid]} && {result[ambr_aid]} == {_user[alaid]}'>
				- <a href="leg-move.html?sub=sou&amp;cid={result[mbr_mapcid]}" title="Protéger {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/def.png" alt="Protéger" /></a>
			</elseif>
			<if cond='{result[can_atq]}'>
				- <a href="leg-move.html?sub=atq&amp;cid={result[mbr_mapcid]}" title="Attaquer {result[mbr_pseudo]}">
				<img src="img/{_user[race]}/div/atq.png" alt="Attaquer" /></a> 
			</if>
		</if>
		&nbsp;
	</td>
  	 </tr>
	</foreach>
	</table>
</elseif>
</if>

<p class="menu_module">
<foreach cond="{class_race_nb} as {race_id} => {race_nb}"><if cond="{race_id}!=0 and isset({_races[{race_id}]}) and {_races[{race_id}]}">
<img src="img/{race_id}/{race_id}.png" alt="{race[{race_id}]}" title="{race[{race_id}]}" /> {race[{race_id}]} ({race_nb[race_nb]})
</if></foreach>
</p>

