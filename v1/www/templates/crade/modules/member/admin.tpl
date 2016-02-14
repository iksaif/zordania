<p class="menu_module">
[
<a href="index.php?file=admin&amp;module=member" title="Retour">Retour</a>
] -
[
<a href="index.php?file=admin&amp;module=member&amp;act=liste" title="Liste">Liste</a>
] -
[
<a href="index.php?file=admin&amp;module=member&amp;act=liste_online" title="Liste Online">Liste Online</a>
] -
[
<a href="index.php?file=admin&amp;module=member&amp;act=liste_ip" title="Liste IP doubles">Liste IP</a>
]
</p>
<hr />
<br />
<if cond='|{mbr_act}| == "liste"'>
 <if cond='is_array(|{mbr_array}|)'>
  <table class="border1">
  <tr>
   <th>Id</th>
   <th>Pseudo</th>
   <th>IP</th>
   <th>Population</th>
   <th>Points</th>
   <th>Groupe</th>
   <th>Etat</th>
   <th>Actions</th>
  </tr>
   
  <foreach cond='|{mbr_array}| as |{result}|'>
  <tr>
   <td>{result[mbr_mid]}</td>
   <td><a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a></td>
   <td>{result[mbr_lip]}</td>
   <td>{result[mbr_population]}</td>
   <td>{result[mbr_points]}</td>
   <td>{result[mbr_gid]}</td>
   <td>{etat[{result[mbr_etat]}]}</td>
   <td>
   	<a href="index.php?file=admin&amp;module=member&amp;act=edit&amp;mid={result[mbr_mid]}"><img src="img/editer.png" alt="Editer" /></a>
   	-
   	<a href="index.php?file=admin&amp;module=member&amp;act=del&amp;mid={result[mbr_mid]}"><img src="img/drop.png" alt="Drop :D" /></a>
   	-
   	 <a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
  	 </a>
   </td>
  </tr>
  </foreach>
  </table>
  Page : 
  <for cond='|{i}| = 0; |{i}| < |{mbr_nb}|; |{i}|+=|{limite_page}|'>
   <a href="index.php?file=admin&amp;module=member&amp;act=liste&amp;mbr_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  </for>
  
  <hr />
  <form action="index.php?file=admin&amp;module=member&amp;act=liste" method="post">
  <fieldset>
  <legend>Options</legend>
  <label for="pseudo">Pseudo: </label><input type="text" value="{mbr_pseudo}" id="pseudo" name="pseudo" /><br />
  <br />
  <label for="ip">Ip: </label><input type="text" value="{mbr_ip}" id="îp" name="ip" /><br />
  <br />
  Trier par:
  <select name="by">
  <option value="pseudo" <if cond='|{mbr_by}| == "pseudo"'> selected="selected"</if>  >Pseudo</option>  
  <option value="population" <if cond='|{mbr_by}| == "population"'> selected="selected"</if> >Population</option>
  <option value="points" <if cond='|{mbr_by}| == "points"'> selected="selected"</if> >Points</option>
  </select>
  <br /><br />
  Ordre :
  <select name="order">
  <option value="1" <if cond='|{mbr_order}| == "1"'> selected="selected"</if>>Ascendant</option>
  <option value="2" <if cond='|{mbr_order}| == "2"'> selected="selected"</if>>Descendant</option>
  </select> <br /><br />
  </fieldset><br />
  <input type="submit" value="Trier" />
  </form>
  
 </if>
</if>
<if cond='|{mbr_act}| == "liste_online"'>
 <if cond='is_array(|{mbr_array}|)'>
  <table class="border1">
  <tr>
   <th>Id</th>
   <th>Pseudo</th>
   <th>Langue</th>
   <th>Population</th>
   <th>Points</th>
   <th>Ip</th>
   <th>Act</th>
   <th>Groupe</th>
   <th>Actions</th>
  </tr>
   
  <foreach cond='|{mbr_array}| as |{result}|'>
  <tr>
   <td>{result[ses_mid]}</td>
   <td>
   	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   	<a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={result[ses_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   </td>
   <td><img src="img/{result[mbr_lang]}.png" alt="{result[mbr_lang]}" /></td>
   <td>{result[mbr_population]}</td>
   <td>{result[mbr_points]}</td>
   <td>{result[ses_ip]}</td>
   <td>{pages[{result[ses_lact]}]}</td>
   <td>{result[mbr_gid]}</td>
   <td>
   	<a href="index.php?file=admin&amp;module=member&amp;act=edit&amp;mid={result[mbr_mid]}"><img src="img/editer.png" alt="Editer" /></a>
   	-
   	<a href="index.php?file=admin&amp;module=member&amp;act=del&amp;mid={result[mbr_mid]}"><img src="img/drop.png" alt="Drop :D" /></a>
   	-
   	 <a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
  	 </a>
   </td>
  </tr>
  </foreach>
  </table>
  Page : 
  <for cond='|{i}| = 0; |{i}| < |{mbr_nb}|; |{i}|+=|{limite_page}|'>
   <a href="index.php?file=admin&amp;module=member&amp;act=liste_online&amp;mbr_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
  </for>
 </if>
</if>
<elseif cond='|{mbr_act}| == "view"'>
 <if cond='is_array(|{mbr_array}|)'>
 Id : {mbr_array[mbr_mid]}<br />
 Mail : {mbr_array[mbr_mail]}<br />
 Pseudo : {mbr_array[mbr_pseudo]}<br />
 Race : <img src="img/{mbr_array[mbr_race]}/{mbr_array[mbr_race]}.png" title="{race[{mbr_array[mbr_race]}]}" alt="{race[{mbr_array[mbr_race]}]}"/><br/>
 Langue : <img src="img/{mbr_array[mbr_lang]}.png" alt="{mbr_array[mbr_lang]}" /><br />
 Décalage : {mbr_array[mbr_decal]} H<br /> 
 Points : {mbr_array[mbr_points]}<br />
 Population : {mbr_array[mbr_population]}<br />
 Ip : {mbr_array[mbr_lip]}<br/>
 Dernière connexion : {mbr_array[mbr_ldate]}<br/>
 <div class="block_1">
 <h3>Actions</h3>
    	<a href="index.php?file=admin&amp;module=member&amp;act=edit&amp;mid={mbr_array[mbr_mid]}"><img src="img/editer.png" alt="Editer" /></a>
   	-
   	<a href="index.php?file=admin&amp;module=member&amp;act=del&amp;mid={mbr_array[mbr_mid]}"><img src="img/drop.png" alt="Drop :D" /></a>
   	-
   	 <a href="index.php?file=msg&amp;act=new&amp;mbr_mid={mbr_array[mbr_mid]}" title="Envoyer un message à {mbr_array[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
  	 </a>
 </div>
 <include file='modules/member/liste_infos_max.tpl' cache='1' />
 </if>
 <else>
 <p class="error">Ce membre n'existe pas.</p>
 </else>
</elseif>
<elseif cond='|{mbr_act}| == "del"'>
 <if cond='|{mbr_no_mid}| == true'>
  <p class="error">Aucun mid !</p>
 </if>
 <elseif cond='|{mbr_need_ok}| == true'> 
  Supprimer le membre {mbr_mid} ?
  [ <a href="index.php?file=admin&amp;module=member&amp;act=del&amp;mid={mbr_mid}&amp;ok=ok" title="Oui">Oui</a>
  ][ <a href="index.php?file=admin&amp;module=member" title="Non">Non</a>
  ]
 </elseif>
 <else>
  <p class="ok">Ok, membre {mbr_mid} supprimé !</p>
 </else>
</elseif>
<elseif cond='|{mbr_act}| == "edit"'>
  <if cond='|{mbr_edit}| == true'>
  <p class="ok">Ok, comtpe édité !</p>
  </if>
  <if cond='|{mbr_not_exist}| == true'>
  <p class="error">Ce membre n'existe pas.</p>
  </if>
  <else>
  	<form method="post" action="index.php?file=admin&amp;module=member&amp;act=edit&amp;mid={mbr_mid}">
	
	   Langue :<br />
	   <select name="lang">
	   <foreach cond='|{lang}| as |{lang_abr}| => |{lang_name}|'>
    		<option value="{lang_abr}" <if cond='|{mbr_lang}| == "{lang_abr}"'>selected="selected"</if>>{lang_name}</option>
	 	 </foreach>
	   </select><br />
	    
	   (Format: HH:MM:SS exemple 01:00:00, l'heure du serveur est {mbr_date})
	   <br /> <input type="text" value="{mbr_decal}" name="decal">
	  
	   Mot de Passe : <input type="password" name="pass" /><br /><br />
	   eMail : <input type="text" value="{mbr_mail}" name="mail" /><br/>
	   <label for="mbr_gid">Groupe</label>
	   <select id="mbr_gid" name="gid">
	   <for cond='|{i}| = 1;|{groupes[{i}]}|; |{i}|++'>
	   	<option value="{i}" <if cond="|{mbr_gid}| == |{i}|">selected="selected"</if>>{groupes[{i}]}</option>
	   </for>
	   </select>
	  <input type="submit" value="Envoyer" name="submit" />
	 </form>
	  
  </else>
</elseif>
<elseif cond='|{mbr_act}| == "liste_ip"'>
	<if cond='is_array(|{mbr_array}|)'>
	<foreach cond='|{mbr_array}| as |{key}| => |{mbr_value}|'>
		<if cond='|{temp_lip}| != |{mbr_value[mbr_lip]}|'>
			<set name='temp_lip' value='{mbr_value[mbr_lip]}' />
			<hr />
			<h2>{mbr_value[mbr_lip]} <math oper="@gethostbyaddr({mbr_value[mbr_lip]})" /></h2>
		</if>
		<a href="index.php?file=admin&amp;module=member&amp;act=view&amp;mid={mbr_value[mbr_mid]}" title="Infos sur {mbr_value[mbr_pseudo]}">{mbr_value[mbr_pseudo]}</a>
  		  - {mbr_value[mbr_ldate]}<br />

		
	</foreach> 
	</if>
	<else>
	A Perfect World !
	</else>
</else>