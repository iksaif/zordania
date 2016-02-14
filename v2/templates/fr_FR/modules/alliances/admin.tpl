<if cond='{al_act} == "liste"'>
	<table class="liste">
		<tr>
		<th>Nom</th>
		<th>Points</th>
		<th>Chef</th>
		<th>Membres</th>
		<th>Logo</th>
		</tr>
	<foreach cond='{al_array} as {al_key} => {al_value}'>
	<tr>
		<td><a href="admin-view.html?module=alliances&amp;al_aid={al_value[al_aid]}" title="Infos sur {al_value[al_name]}">{al_value[al_name]}</a></td>
		<td>{al_value[al_points]}</td>
		<td><a href="admin-view.html?module=member&amp;mid={al_value[al_mid]}" title="Infos sur {al_value[mbr_pseudo]}">{al_value[mbr_pseudo]}</td>
		<td>{al_value[al_nb_mbr]}</td>
		<td>
		<a href="admin-view.html?module=alliances&amp;al_aid={al_value[al_aid]}">
   		<img src="img/al_logo/{al_value[al_aid]}-thumb.png" class="mini_al_logo" alt="{al_value[al_name]}" title="{al_value[al_name]}"/>
   		</a>
   		</td>
	</tr>
	</foreach>
	</table>
  <br />Page : 
  <for cond='{i} = 0; {i} < {al_nb}; {i}+={limite_page}'>
  	<if cond='{i} / {limite_page} != {al_page}'>
  		<a href="admin.html?module=alliances&amp;al_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  	</if>
  	<else>
  		<math oper='(({i} / {limite_page})+1)' />
  	</else>	
  </for>
  <hr/>
  	<form action="admin.html?module=alliances" method="post">
		<label for="name">Nom:</label>
		<input type="text" name="name" id="name" value="{al_name}" />
		<input type="submit" value="Rechercher" />
	</form>
</if>

<elseif cond='{al_act} == "view"'>
	<if cond="isset({al_array}) && count({al_array})">

	<if cond='{al_logo}'>
		<img class="blason blason" src="{al_logo}" alt="Blason" />
	</if>
	<h3>{al_array[al_name]}</h3>
	Chef : <a href="admin-view.html?module=member&amp;mid={chef[mbr_mid]}" title="Infos sur {chef[mbr_pseudo]}">{chef[mbr_pseudo]}</a><br/>
	Points : {al_array[al_points]}<br/>
	<br/>
 
	<form action="admin-view.html?module=alliances&amp;al_aid={al_array[al_aid]}&amp;sub=edit_mbr" method="post">
 	<h3>Liste des Joueurs</h3>
	<if cond="isset({set_chef})">
		<if cond="{set_chef}"><p class="ok">Ok, un nouveau chef désigné.</p></if>
		<else><p class="error">Erreur! Aucune modification enregistrée.</p></else>
	</if>
	<if cond="isset({err_msg_aly})">
		<if cond="{err_msg_aly} === true">
			<p class="ok">Changements effectués !</p>
		</if>
		<else>
			<p class="error">Erreur dans les grades !<if cond="isset({err_msg_aly[vide]})"> Aucune modification effectuée.</if></p>
			<p>Il faut respecter le nombre maximum pour les grades suivants : <if cond="isset({err_msg_aly[chef]})">... Et surtout, un et un seul {algrp[9]} !</if></p>
			<ul class="infos"><foreach cond="{max_perm} as {grp} => {nb}">
				<li>
				<if cond="isset({err_msg_aly[count][{grp}]})"><strong>{nb} {algrp[{grp}]} ({err_msg_aly[count][{grp}]})</strong></if>
				<else>{nb} {algrp[{grp}]}</else>
				</li>
			</foreach></ul>
		</else>
	</else>

  	<table class="liste">
  	<tr>
  	 <th>Id</th>
  	 <th>Pseudo</th>
  	 <th>Race</th>
  	 <th>Pop.</th>
  	 <th>Points</th>
  	 <th>Actions</th>
  	</tr>	 
  	<foreach cond='{al_mbr} as {result}'>
  	 <tr>
  	 <td>{result[mbr_mid]}</td>
  	 <if cond='{al_array[al_mid]} == {result[mbr_mid]}'>
  	 <th>
  	 	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
  	 	<a href="admin-view.html?module=member&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </th>
  	 </if>
  	 <else>
  	 <td>
  	 	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
  	 	<a href="admin-view.html?module=member&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </td>
  	 </else>
  	 <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
  	 <td>{result[mbr_population]}</td>
  	 <td>{result[mbr_points]}</td>
	 <td>
  	 	<a href="admin-new.html?module=msg&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
  	 		<img src="img/msg.png" alt="Msg" />
  	 	</a>
		-
		<a href="admin-view.html?module=alliances&amp;al_aid={al_array[al_aid]}&amp;sub=chef&amp;mid={result[mbr_mid]}" title="Donner le pouvoir à {result[mbr_pseudo]}">
			<img src="img/join.png" alt="Chef" />
		</a>
		&nbsp;
		<select id="grd{result[mbr_mid]}" name="grd[{result[mbr_mid]}]">
			<foreach cond="{al_grades} as {key} => {value}">
				<if cond="{key}=={result[ambr_etat]}">
					<option value="{key}" selected="selected">{algrp[{key}]}</option>
				</if>
				<else>
					<option value="{key}">{algrp[{key}]}</option>
				</else>
			</foreach>
		</select>
  	 </td>
  	 </tr>
  	</foreach>
  	</table>
	<input type="submit" value="Modifier" />
	</form>
  	<hr/>

  	<h3>Grenier</h3>
	<script type="text/javascript">
	// init du formulaire admin grenier
	$(document).ready(  function()
	{
		// Lorsqu'un lien a.com est cliqué
		$("#table_grenier a.res").click(   function () 
		{
			var act = $(this).attr('id');
			$("#table_grenier input[type=text]").each(function(index){
				if(act == 'adm_res_init')
					$(this).attr('value', '-'+$("#init_res"+(1+index)).text());
				else
					$(this).attr('value', 0);
			});
			return false;
		});
	});
	</script>

	<form action="admin-view.html?module=alliances&amp;al_aid={al_array[al_aid]}&amp;sub=add_res" method="post">
	<table class="liste" id="table_grenier">
	<tr>
		<th>Type</th>
		<th><a class="res" id="adm_res_init" title="vider le grenier!">Nombre</a></th>
		<th><a class="res" id="adm_res_vide" title="RAZ du formulaire">Ajouter</a></th>
		<th>Max</th>
	</tr>		
	<foreach cond="{res_array} as {res_type} => {res_nb}">
	<tr>
		<td>
			<zimgres type="{res_type}" race="{_user[race]}" />
			{res[{_user[race]}][alt][{res_type}]}
		</td>
		<td><span id="init_res{res_type}">{res_nb}</span></td>
		<td><input type="text" id="res_nb{res_type}" name="res_nb[{res_type}]" value="0" size="6" /></td>
		<td><zimgres type="{res_type}" race="{_user[race]}" />
			<if cond="{res_type}==1">infini</if>
			<else>{_limite_grenier[{res_type}]}</else>
		</td>
	</tr>
	</foreach>
	</table>
	<input type="submit" value="Modifier" />
	</form>
	<hr/>
	
	<h3>Shoutbox</h3>
	<form action="admin-view.html?module=alliances&amp;al_aid={al_array[al_aid]}&amp;sub=shoot" method="post">
	<textarea id="message" name="text" rows="5" cols="40"></textarea>
	<br />
	<input type="submit" value="Envoyer" />
	</form>
	
	<h3 id="res_histo">Dernières actions</h3>
	<ul>
	<foreach cond="{log_array} as {result}">
	<li>
	Le {result[arlog_date_formated]} - 
   <if cond="isset({result[mbr_gid]})">
	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
	   	<a href="admin-view.html?module=member&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
	   	 - </if><else> ???? - </else>
		<if cond="{result[arlog_nb]} > 0">
		<span class="gain">
		</if>
		<else>
		<span class="perte">
		</else>
		{result[arlog_nb]}
		</span>
		<zimgres type="{result[arlog_type]}" race="{_user[race]}" />
	</li>
	</foreach>
	</ul>
	<a href="admin-view.html?module=alliances&amp;al_aid={al_array[al_aid]}&amp;al_page=<math oper="{al_page}-1" />#res_histo">
	<img src="img/left.png" alt="<<" />
	</a>
	-
	<a href="admin-view.html?module=alliances&amp;al_aid={al_array[al_aid]}&amp;al_page=<math oper="{al_page}+1" />#res_histo">
	<img src="img/right.png" alt=">>" />
	</a>
	<hr/>
	<h3>Description</h3>
  	{al_array[al_descr]}

	</if>
	<else>
		<p class="error">Cette Alliance n'existe pas.</p>
	</else>
</elseif>
