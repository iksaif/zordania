<if cond="!|{al_act}|">
<if cond='count(|{al_array}|) > 0'>
	<table class="border1">
		<tr>
		<th>Nom</th>
		<th>Points</th>
		<th>Chef</th>
		<th>Membres</th>
		<th>Logo</th>
		</tr>
	<foreach cond='|{al_array}| as |{al_key}| => |{al_value}|'>
	<tr>
		<td><a href="index.php?file=admin&amp;module=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
		<td>{al_value[al_points]}</td>
		<td><a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={al_value[al_mid]}" title="Infos sur {al_value[mbr_pseudo]}">{al_value[mbr_pseudo]}</td>
		<td>{al_value[al_nb_mbr]}</td>
		<td>
		<a href="index.php?file=admin&amp;module=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}">
   		<img src="img/al_logo/{al_value[al_aid]}-thumb.png" class="mini_al_logo" alt="{al_value[al_name]}" title="{al_value[al_name]}"/>
   		</a>
   		</td>
	</tr>
	</foreach>
	</table>
  <br />Page : 
  <for cond='|{i}| = 0; |{i}| < |{al_nb}|; |{i}|+=|{limite_page}|'>
  	<if cond='|{i}| / |{limite_page}| != |{al_page}|'>
  		<a href="index.php?file=admin&amp;module=alliances&amp;al_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  	</if>
  	<else>
  	<math oper='(({i} / {limite_page})+1)' />
  	</else>	
  </for>
</if>
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
			</tr>
		<foreach cond='|{al_array}| as |{al_key}| => |{al_value}|'>
		<tr>
			<td><a href="index.php?file=admin&amp;module=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
			<td>{al_value[al_points]}</td>
			<td><a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={al_value[al_mid]}" title="Infos sur {al_value[mbr_pseudo]}">{al_value[mbr_pseudo]}</td>
			<td>{al_value[al_nb_mbr]}</td>
			<td>
			<a href="index.php?file=admin&amp;module=alliances&amp;act=view&amp;al_aid={al_value[al_aid]}">
			<img src="img/al_logo/{al_value[al_aid]}-thumb.png" class="mini_al_logo" alt="{al_value[al_name]}" title="{al_value[al_name]}"/>
			</a>
			</td>
		</tr>
		</foreach>
		</table>
	</if>
	<else>
		<p class="infos">Aucune Alliance</p>
	</else>
</elseif>
<elseif cond='|{al_act}| == "view"'>
	<if cond='count(|{al_array}|)'>
		<if cond='{al_logo}'>
			<img class="img_right blason" src="{al_logo}" alt="Blason" />
		</if>
		<h2>{al_array[al_name]}</h2>
		Chef : <a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={al_array[al_mid]}" title="Infos sur {al_array[mbr_pseudo]}">{al_array[mbr_pseudo]}</a><br/>
		Points : {al_array[al_points]}<br/>
		<br/>
  	<h2>Liste des Joueurs</h2>
  	<table class="border1">
  	<tr>
  	 <th>Id</th>
  	 <th>Pseudo</th>
  	 <th>Race</th>
  	 <th>Population</th>
  	 <th>Points</th>
  	 <th>Distance</th>
  	 <th>Actions</th>
  	</tr>	 
  	<foreach cond='|{al_mbr}| as |{result}|'>
  	 <tr>
  	 <td>{result[mbr_mid]}</td>
  	 <if cond='|{al_array[al_mid]}| == |{result[mbr_mid]}|'>
  	 <th>
  	 	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
  	 	<a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </th>
  	 </if>
  	 <else>
  	 <td>
  	 	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
  	 	<a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </td>
  	 </else>
  	 <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
  	 <td>{result[mbr_population]}</td>
  	 <td>{result[mbr_points]}</td>
  	 <td>{result[mbr_dst]}</td>
		 <td>
		 <if cond='|{result[mbr_mid]}| != |{session_user[mid]}|'>
  	 	<a href="index.php?file=admin&amp;module=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
  	 		<img src="img/msg.png" alt="Msg" />
  	 	</a>
  	 </if>
  	 <if cond='|{result[can_atq]}|'>
				-
				<a href="index.php?file=admin&amp;module=war&amp;act=atq&amp;mid={result[mbr_mid]}" title="Attaquer {result[mbr_pseudo]}">
				<img src="img/{session_user[race]}/div/atq.png" alt="Attaquer" />
				</a>
  	 </if>
  	 &nbsp;
  	 </td>
  	 </tr>
  	</foreach>
  	</table>	
  	<hr/>
  	<h2>Grenier</h2>
	<table class="border1">
		<tr>
		<th>Type</th>
		<th>Nombre</th>
		<th>&nbsp;</th>
		</tr>		
		<foreach cond="|{res_array}| as |{result}|">
		<tr>
		<td>
			<img src="img/{session_user[race]}/res/{result[al_res_type]}.png" alt="{res[{session_user[race]}][alt][{result[al_res_type]}]}" title="{res[{session_user[race]}][alt][{result[al_res_type]}]}" />
			{res[{session_user[race]}][alt][{result[al_res_type]}]}
		</td>
		<td>{result[al_res_nb]}</td>
		<td>
		<form action="index.php?file=admin&amp;module=alliances&amp;act=view&amp;al_aid={al_array[al_aid]}&amp;sub=add_res&amp;res_type={result[al_res_type]}" method="post">
		<input type="text" id="res_nb" name="res_nb" value="0" />
		<input type="submit" value="Modifier" />
		</form>
		</td>
		</tr>
		</foreach>
	</table>
	<hr/>
	<h2>Dernières actions</h2>
	<ul>
	<foreach cond="|{log_array}| as |{result}|">
	<li>
	Le {result[al_res_log_date_formated]} - 
	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
	   	<a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
	   	 -
		<if cond="|{result[al_res_log_res_nb]}| > 0">
		<span class="gain">
		</if>
		<else>
		<span class="perte">
		</else>
		{result[al_res_log_res_nb]}
		</span>
		 <img src="img/{session_user[race]}/res/{result[al_res_log_res_type]}.png" alt="{res[{session_user[race]}][alt][{result[al_res_log_res_type]}]}" title="{res[{session_user[race]}][alt][{result[al_res_log_res_type]}]}" />
	</li>
	</foreach>
	</ul>
	<a href="index.php?file=admin&amp;module=alliances&amp;act=view&amp;al_aid={al_array[al_aid]}&amp;al_page=<math oper="{al_page}-1" />">
	<img src="img/left.png" alt="<<" />
	</a>
	-
	<a href="index.php?file=admin&amp;module=alliances&amp;act=view&amp;al_aid={al_array[al_aid]}&amp;al_page=<math oper="{al_page}+1" />">
	<img src="img/right.png" alt=">>" />
	</a>
	<hr/>
	<h2>Description</h2>
  	{al_array[al_descr]}
	</if>
	<else>
		<p class="error">Cette Alliance n'existe pas.</p>
	</else>
</elseif>
