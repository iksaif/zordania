<if cond='|{cmt_post}|=="ok"'>
<p class="ok">Commentaire posté !</p><br />
<meta http-equiv="refresh" content="3; url={cfg_url}?file=news&amp;nws_nid={nws_nid}">
</if>
<elseif cond='|{cmt_post}|=="pasok"'>
<p class="error">Erreur !</p><br />
</elseif>
<elseif cond='|{cmt_post}|=="flood"'>
<p class="error">Contrôle antiflood activé !</p><br />
</elseif>

<hr />

<if cond='is_array(|{nws_unique}|)'>
  <div class="news">
 <a name="news_{nws_unique[0][nws_nid]}"></a>
 :: <a href="index.php?file=news&amp;nws_nid={nws_unique[0][nws_nid]}" title="Lire la news {nws_unique[0][nws_nid]}" class="gras">{nws_unique[0][nws_titre]}</a> ::
  <br /><br />
  {nws_unique[0][nws_texte]}<br /><br />
  Le {nws_unique[0][nws_date_formated]} par <a href="index.php?file=member&amp;act=view&amp;mid={nws_unique[0][nws_mid]}" title="Infos sur {nws_unique[0][mbr_pseudo]}">{nws_unique[0][mbr_pseudo]}</a>
  </div>

  <if cond='is_array(|{nws_cmt}|)'>
  <h2>Commentaires :</h2>
  <foreach cond='|{nws_cmt}| as |{result}|'>
  <div class="news">
  <if cond='|{cmt_admin}| == true'>
  <a href="index.php?file=admin&amp;module=news&amp;act=edit_cmt&amp;cmt_id={result[cmt_cid]}"><img class="img_left" src="img/editer.png" alt="editer" /></a>
  <a href="index.php?file=admin&amp;module=news&amp;act=drop_cmt&amp;cmt_id={result[cmt_cid]}"><img class="img_left" src="img/drop.png" alt="del" /></a>
  </if>
  Le {result[cmt_date_formated]} par <a href="index.php?file=member&amp;act=view&amp;mid={result[cmt_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  <br />
  {result[cmt_texte]}
  </div>
  <br />
  </foreach>
  </if>
  <else>
  <h2>Pas de commentaire.</h2>
  </else>
  <if cond='|{cmt_ok}| == true'>
   <h2>Poster un commentaire :</h2>
   <form method="post" action="index.php?file=news&amp;nws_nid={nws_unique[0][nws_nid]}&amp;act=post_cmt">
   <include file='commun/bbcode.tpl' cache='1' /><br/>
   <textarea id="message" name="cmt" rows="5" cols="40"></textarea><br />
   <input type="submit" value="Envoyer">
   </form>
  </if>
  <else>
  <p class="infos">Vous devez être connecté pour poster un commentaire.</p>
  </else>
</if>
<elseif cond='is_array(|{nws_array}|)'>
  <p class="infos">
  C'est votre première venue ? <a href="index.php?file=a_propos&amp;act=whatiszord">C'est quoi Zordania ?</a>
  </p>
  <foreach cond='|{nws_array}| as |{result}|'>
  <div class="news">
  <h3 class="titre_news"><a name="news_{result[nws_nid]}">{result[nws_titre]}</a></h3>
  {result[nws_texte]}<br /><br />
  Le {result[nws_date_formated]} par <a href="index.php?file=member&amp;act=view&amp;mid={result[nws_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  :: <a href="index.php?file=news&amp;nws_nid={result[nws_nid]}" title="Commenter la news {result[nws_nid]}">Commentaires ({result[nb_cmt]})</a>
  :: <img src="img/{result[nws_lang]}.png" alt="{result[nws_lang]}" />
  </div>
  <br />
 </foreach>
 <for cond='|{i}| = 0; |{i}| < |{nws_nb}|; |{i}|+=5'>
  <if cond='|{i}| / 5 != |{nws_page}|'>
   <a href="index.php?nws_page=<math oper='({i} / 5)' />"><math oper='(({i} / 5)+1)' /></a>
  </if>
  <else>
   <math oper='(({i} / 5)+1)' />
  </else>
 </for>
</elseif>
<elseif cond='|{nws_unique}| == 1'>
 <p class="error">Cette news n'existe pas ou n'a pas été validée !</p>
</elseif>
<else>
 <p class="error">Il n'y a pas de news pour le moment.</p>
</else>