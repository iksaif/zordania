<if cond='|{mbr_act}| == "liste"'>
<if cond='is_array(|{mbr_array}|)'>
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
   
  <foreach cond='|{mbr_array}| as |{result}|'>
  <if cond='|{result[mbr_pseudo]}| != "guest"'>
   <tr<if cond='|{session_user[alaid]}| == |{result[mbr_alaid]}| AND |{session_user[alaid]}| != 0'> class="allie"</if>>
   <td>{result[mbr_mid]}</td>
   <td>
   	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   	<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   </td>
   <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
   <td>{result[mbr_population]}</td>
   <td>{result[mbr_points]}</td>
   <td><math oper='round(sqrt(({mbr_map_x}-{result[map_x]})*({mbr_map_x}-{result[map_x]}) + ({mbr_map_y}-{result[map_y]})*({mbr_map_y}-{result[map_y]})),2)' /></td>
   <td>
   <if cond='|{result[mbr_mid]}| != |{session_user[mid]}|'>
   	<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
   	</a>
   </if>
   <if cond='|{result[can_atq]}|'>
		- 
		<a href="index.php?file=war&amp;act=atq&amp;mid={result[mbr_mid]}" OnClick="lien_bg(this.href);return false;" title="Attaquer {result[mbr_pseudo]}">
		<img src="img/{session_user[race]}/div/atq.png" alt="Attaquer" />
		</a> 
   </if>
   &nbsp;
   </td>
   </tr>
  </if>
  </foreach>
  </table>
  <br />Page : 
  <for cond='|{i}| = |{current_i}| ; |{i}| < |{mbr_nb}| AND |{i}|-|{current_i}| < |{limite_nb_page}|*|{limite_page}|; |{i}|+=|{limite_page}|'>
   <if cond='|{i}| / |{limite_page}| != |{mbr_page}|'>
   <a href="index.php?file=member&amp;act=liste&amp;mbr_page=<math oper='({i} / {limite_page})' />&amp;order={mbr_order}&amp;by={mbr_by}"><math oper='(({i} / {limite_page})+1)' /></a>
   </if>
   <else>
   <math oper='(({i} / {limite_page})+1)' />
   </else>
  </for>
  
  <br />
  <hr />
  <form action="index.php?file=member&amp;act=liste" method="post">
  <fieldset>
  <legend>Options</legend>
  <label for="pseudo">Pseudo: </label><input type="text" value="{mbr_pseudo}" id="pseudo" name="pseudo" /><br />
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
   <th>Pseudo</th>
   <th>Race</th>
   <th>Population</th>
   <th>Points</th>
   <th>Page</th>
   <th>Date</th>
   <th>Actions</th>
  </tr>
   
  <foreach cond='|{mbr_array}| as |{result}|'>
  <tr<if cond='|{session_user[alaid]}| == |{result[mbr_alaid]}| AND |{session_user[alaid]}| != 0'> class="allie"</if>>
   <td>
   	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
   	<a href="index.php?file=member&amp;act=view&amp;mid={result[ses_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   </td>
   <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
   <td>{result[mbr_population]}</td>
   <td>{result[mbr_points]}</td>
   <td>{pages[{result[ses_lact]}]}</td>
   <td>{result[ses_ldate]}</td>
   <td>
   <if cond='|{result[mbr_mid]}| != |{session_user[mid]}|'>
   	<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
   		<img src="img/msg.png" alt="" />
   	</a>
   </if>
   <if cond='|{result[can_atq]}|'>
		-
		<a href="index.php?file=war&amp;act=atq&amp;mid={result[mbr_mid]}" OnClick="lien_bg(this.href);return false;" title="Attaquer {result[mbr_pseudo]}">
		<img src="img/{session_user[race]}/div/atq.png" alt="Attaquer" />
		</a> 
   </if>
   &nbsp;
   </td>
    </tr>
  </foreach>
  </table>
  Page : 
  <for cond='|{i}| = 0; |{i}| < |{mbr_nb}|; |{i}|+=|{limite_page}|'>
   <if cond='|{i}| / |{limite_page}| != |{mbr_page}|'>
   <a href="index.php?file=member&amp;act=liste_online&amp;mbr_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
   </if>
   <else>
   <math oper='(({i} / {limite_page})+1)' />
   </else>
  </for>
 </if>
</if>