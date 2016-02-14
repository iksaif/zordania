<p class="menu_module">
[
<a href="index.php?file=class&amp;act=1" title="Top 50 Or">Or</a>
] - [
<a href="index.php?file=class&amp;act=2" title="Top 50 Légions">Légions</a>
] - [
<a href="index.php?file=class&amp;act=3" title="Top 50 Points">Points</a>
] - [
<a href="index.php?file=class&amp;act=4" title="Top 50 Population">Population</a>
] - [
<a href="index.php?file=class&amp;act=5" title="Top 50 Alliances">Alliances</a>
]
</p>

<if cond='is_array(|{class_array}|)'>
<if cond='|{class_type}| == 1'>
	<h2>Classement Or</h2>
  	<table class="border1">
  	<tr>
  	 <th></th>
  	 <th>Pseudo</th>
  	 <th>Or</th>
  	</tr>
   
   	<foreach cond='|{class_array}| as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
   		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </td>
  	 <td>
  	 	{result[res_nb]} <img src="img/{session_user[race]}/res/1.png" alt="Or" title="Or" />
  	 </td>
	</tr>
	</foreach>
	</table>
</if>
<elseif cond='|{class_type}| == 2'>
	<h2>Classement Légion</h2>
  	<table class="border1">
  	<tr>
  	 <th></th>
  	 <th>Pseudo</th>
  	 <th>Légion</th>
  	 <th>XP</th>
  	</tr>
   
   	<foreach cond='|{class_array}| as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
   		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </td>
  	 <td>
  	 	{result[leg_name]}
  	 </td>
  	 <td>
  	 	{result[leg_xp]}
  	 </td>
	</tr>
	</foreach>
	</table>
</elseif>
<elseif cond='|{class_type}| == 3'>
	<h2>Classement Points</h2>
  	<table class="border1">
  	<tr>
  	 <th></th>
  	 <th>Pseudo</th>
  	 <th>Points</th>
  	</tr>
   
   	<foreach cond='|{class_array}| as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
   		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </td>
  	 <td>
  	 	{result[mbr_points]}
  	 </td>
	</tr>
	</foreach>
	</table>
</elseif>
<elseif cond='|{class_type}| == 4'>
	<h2>Classement Population</h2>
  	<table class="border1">
  	<tr>
  	 <th></th>
  	 <th>Pseudo</th>
  	 <th>Population</th>
  	</tr>
   
   	<foreach cond='|{class_array}| as {bidule} => {result}'>
	<tr>
	 <td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
	 <td>
   		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </td>
  	 <td>
  	 	{result[mbr_population]} / {result[res_nb]} <img src="img/{session_user[race]}/res/20.png" alt="Population" title="Population" />
  	 </td>
	</tr>
	</foreach>
	</table>
</elseif>
<elseif cond='|{class_type}| == 5'>
	<h2>Classement Alliances</h2>
	<table class="border1">
		<tr>
		<th></th>
		<th>Nom</th>
		<th>Points</th>
		<th>Chef</th>
		<th>Membres</th>
		</tr>
	<foreach cond='|{class_array}| as |{al_key}| => |{al_value}|'>
	<tr>
		<td><set name="class_pos" value="<math oper='{class_pos}+1' />" />{class_pos}</td>
		<td><a href="index.php?file=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
		<td>{al_value[al_points]}</td>
		<td><a href="index.php?file=member&amp;act=view&amp;mid={al_value[al_mid]}" title="Infos sur {al_value[mbr_pseudo]}">{al_value[mbr_pseudo]}</td>
		<td>{al_value[al_nb_mbr]}</td>
	</tr>
	</foreach>
	</table>
</if>
</if>
