<if cond='|{nws_act}| == "edit"'>
 <if cond='|{nws_ok}| == "ok"'>
 <p class="ok">Ok News enregistrée !</p>
 </if>
 <if cond='|{nws_ok}| == "pasok"'>
 <p class="error">Erreur !</p>
 </if>
 <if cond='|{nws_ok}| == "manque"'>
 <p class="error">Des champs sont restés vides !</p>
 </if>
 <br />
 <form action="index.php?file=admin&amp;module=news&amp;act=edit&amp;nws_nid={nws_nid}" method="post">
 Auteur : <br />
 <input name="nws_auteur" value="{nws_login}" /><br />
 Titre : <br />
  <input name="nws_titre" value="{nws_titre}" /><br /><br />
  Langue :
  <select name="nws_lang">
  <option value="fr" <if cond='|{nws_lang}| == "fr"'>selected="selected"</if>>fr</option>
  <option value="en" <if cond='|{nws_lang}| == "en"'>selected="selected"</if>>en</option>
  </select>
  
  Etat :
  <select name="nws_etat">
  <option value="1" <if cond='|{nws_etat}| == "1"'>selected="selected"</if>>1 : attente de validation</option>
  <option value="2" <if cond='|{nws_etat}| == "2"'>selected="selected"</if>>2 : news normale</option>
  <option value="3" <if cond='|{nws_etat}| == "3"'>selected="selected"</if>>3 : news en post-it</option>
  </select>
  <br />
  
  Cat :
  <select name="nws_cat">
  <foreach cond="|{news_cat}| as |{cat_id}| => |{cat_name}|">
  <option value="{cat_id}" <if cond='|{nws_cat}| == |{cat_id}|'>selected="selected"</if>>{cat_name}</option>
  </foreach>
  </select>
  <br/>
  <label for="nws_closed">Commentaires Fermés:</label>
  <input type="checkbox" id="nws_closed" name="nws_closed" value="1" <if cond="{nws_closed}">checked="checked"</if>/>
 <br />
 <include file='commun/bbcode.tpl' cache='1' /><br/>
 <textarea id="message" name="nws_texte" rows="6" cols="70">{nws_texte}</textarea><br /> 
 <br />
 <input type="submit" value="Envoyer" />
 </form>
 
 <hr />
 <div class="news">
	{nws_titre}</a> :: {nws_login}
  <br /><br />
  {nws_texte_parsed}
  <br />
 </div>
</if>
<elseif cond='|{nws_act}| == "drop"'>
Êtes vous sûr de vouloir supprimer la news {nws_nid} ?<br />
[ <a href="index.php?file=admin&amp;module=news&amp;act=drop&amp;nws_nid={nws_nid}&amp;secu=ok" title="oui">oui</a> - 
<a href="index.php?file=admin&amp;module=news" title="non">non</a> ]
</elseif>
<elseif cond='|{nws_act}| == "dropreal"'>
 <if cond='|{nws_drop_ok}| == true'>
  <p class="ok">News {nws_nid} supprimée.</p><br />
 </if>
</elseif>
<elseif cond='|{nws_act}| == "new"'>
 <if cond='|{nws_ok}| == "ok"'>
 <p class="ok">Ok News enregistrée !</p>
 </if>
 <if cond='|{nws_ok}| == "pasok"'>
 <p class="error">Erreur !</p>
 </if>
 <if cond='|{nws_ok}| == "manque"'>
 <p class="error">Des champs sont restés vides !</p>
 </if>
 <br />
 <form action="index.php?file=admin&amp;module=news&amp;act=newnews" method="post">
 Auteur : <br />
 <input name="nws_auteur" value="{nws_login}" /><br />
 Titre : <br />
  <input name="nws_titre" value="{nws_titre}" /><br /><br />
  Langue :
  <select name="nws_lang">
  <option value="fr" <if cond='|{nws_lang}| == "fr"'>selected="selected"</if>>fr</option>
  <option value="en" <if cond='|{nws_lang}| == "en"'>selected="selected"</if>>en</option>
  </select>
  
  Etat :
  <select name="nws_etat">
  <option value="1" <if cond='|{nws_etat}| == "1"'>selected="selected"</if>>1 : attente de validation</option>
  <option value="2" <if cond='|{nws_etat}| == "2"'>selected="selected"</if>>2 : news normale</option>
  <option value="3" <if cond='|{nws_etat}| == "3"'>selected="selected"</if>>3 : news en post-it</option>
  </select>
    <br />
  
  Cat :
  <select name="nws_cat">
  <foreach cond="|{news_cat}| as |{cat_id}| => |{cat_name}|">
  <option value="{cat_id}" <if cond='|{nws_cat}| == |{cat_id}|'>selected="selected"</if>>{cat_name}</option>
  </foreach>
  </select>
  <br/>
    <label for="nws_closed">Commentaires Fermés:</label>
  <input type="checkbox" id="nws_closed" name="nws_closed" value="1" <if cond="{nws_closed}">checked="checked"</if>/>
 <br />
 <include file='commun/bbcode.tpl' cache='1' /><br/>
 <textarea id="message"  name="nws_texte" rows="6" cols="70">{nws_texte}</textarea><br /> 
 <br />
 <input type="submit" value="Envoyer" />
 </form>
</elseif>
<elseif cond='|{nws_act}| == "edit_cmt"'>
 <if cond='|{cmt_ok}| == "ok"'>
  <p class="ok">Ok edité !</p>
 </if>
 <elseif cond='|{cmt_ok}| == "pasok"'>
  <p class="error">Erreur !</p>
 </elseif>
 <elseif cond='|{cmt_ok}| == "manque"'>
  <p class="error">Il manque des parametres !</p>
 </elseif>
 <h2>Poster un commentaire :</h2>
 <form method="post" action="index.php?file=admin&amp;module=news&amp;act=edit_cmt&amp;cmt_id={cmt_id}">
 <include file='commun/bbcode.tpl' cache='1' /><br/>
 <textarea id="message"  name="cmt_texte" rows="6" cols="70">
 {cmt_texte}
 </textarea><br />
 <input type="submit" value="Envoyer">
  </form>
</elseif>
<elseif cond='|{nws_act}| == "drop_cmt"'>
 <if cond='|{cmt_ok}| == "ok"'>
  <p class="ok">Ok Supprimé !</p>
 </if>
 <elseif cond='|{cmt_ok}| == "pasok"'>
  <p class="error">Erreur !</p>
 </elseif>
 <elseif cond='|{cmt_ok}| == "manque"'>
  <p class="error">Il manque des parametres !</p>
 </elseif>
 <else>
 Êtes vous sûr de vouloir supprimer le commentaire {cmt_id} ?<br />
 [ <a href="index.php?file=admin&amp;module=news&amp;act=drop_cmt&amp;cmt_id={cmt_id}&amp;secu=ok" title="oui">oui</a> - 
 <a href="index.php?file=admin&amp;module=news" title="non">non</a> ]
 </else>
</elseif>
<else>
 <a href="index.php?file=admin&amp;module=news&amp;act=addnews" title="ajouter une news">Nouvelle news</a><br />
 <if cond='is_array(|{nws_array}|)'>
  <table class="border1">
  <tr>
   <th>
    Id
   </th>
   <th>
    Titre
   </th>
   <th>
    Date
   </th>
   <th>
    Auteur
   </th>
   <th>
    Langue
   </th>
   <th>
   Etat
   </th>
   <th>
    Editer
   </th>
   <th>
    Drop 
   </th>
  </tr>
  <foreach cond='|{nws_array}| as |{result}|'>
   <tr>
   <td>
   <a name="news_{result[nws_nid]}">{result[nws_nid]}</a>
   </td>
   <td>
   <a href="index.php?file=news&amp;nws_nid={result[nws_nid]}" title="Lire la news {result[nws_nid]}">{result[nws_titre]}</a>
   </td>
   <td>
   {result[nws_date_formated]}
   </td>
   <td>
   <a href="index.php?file=member&amp;act=view&amp;mid={result[nws_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
   </td>
   <td>  
   <img src="img/{result[nws_lang]}.png" alt="{result[nws_lang]}" />
   </td>
   <td>
      {result[nws_etat]}
   </td>
   <td>
   <a href="index.php?file=admin&amp;module=news&amp;act=edit&amp;nws_nid={result[nws_nid]}"><img src="img/editer.png" alt="editer" /></a>
   </td>
   <td>
   <a href="index.php?file=admin&amp;module=news&amp;act=drop&amp;nws_nid={result[nws_nid]}"><img src="img/drop.png" alt="del" /></a>
   </td>
   </tr>
  </foreach>
  </table>
  <br />
  Page : 
  <for cond='|{i}| = 0; |{i}| < |{nws_nb}|; |{i}|+=10'>
   <a href="index.php?file=admin&amp;module=news&amp;nws_page=<math oper='({i} / 10)' />"><math oper='(({i} / 10)+1)' /></a>
  </for>
 </if>
 <else>
 <p class="error">Il n'y a pas de news !</p>
 </else>
</else>

  <br />
  <p class="retour_module">
  [ <a href="index.php?file=admin&amp;module=news" title="Retour a l'admin">Retour</a> 
  ]
  </p>