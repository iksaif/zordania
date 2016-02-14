<if cond="isset({Bad_request})"><p class="error">Erreur, mauvaise requête !</p></if>
<if cond="isset({no_hits})"><p class="error">Aucun résultat à votre recherche.</p></if>

<if cond="isset({topic_array})">
	<h4>
	<if cond='{action} == "search"'>Résultats de la recherche par topics</if>
	<elseif cond='{action} == "show_new"'>Nouveaux messages depuis votre dernière connexion</elseif>
	<elseif cond='{action} == "show_24h"'>Nouveaux messages depuis les dernières 24h</elseif>
	<elseif cond='{action} == "show_unanswered"'>Messages sans réponse</elseif>
	<elseif cond='{action} == "show_user"'>Messages d'un utilisateur</elseif>
	</h4>

	<if cond="empty({topic_array})"><p class="infos">Aucun résultat.</p></if>
	<else>

		<if cond="isset({arr_pge})">
			<p>
			<foreach cond="{arr_pge} as {i}">
				<if cond='{i} == {pge} || {i} == "..."'> {i} </if>
				<else> <a href="forum-search.html?search_id={search_id}&p={i}" title="page {i}">{i}</a> </else>
			</foreach>
			</p>
		</if>

		<table class="liste">
		<tr>
			<th></th>
			<th>Sujet</th>
			<th>Forum</th>
			<th>Auteur</th>
			<th>Rép</th>
			<th>Dernière action</th>
		</tr>

		<foreach cond="{topic_array} as {topic}">
		<tr>
			<!-- Image pour l'état du topic -->
			<td>

			<if cond='{lu_forum_ldate} > {topic[posted_unformat]}'><set name="etat" value="lu" /></if>
			<else><set name="etat" value="non_lu" /></else>
			<if cond="{topic[sticky]} == 1 AND {topic[closed]} == 1"><img src="img/forum/sticky-closed-{etat}.png" title="Post-it Fermé - {etat}" /></if>
			<elseif cond="{topic[closed]} == 1"><img src="img/forum/closed-{etat}.png" title="Fermé - {etat}" /></elseif>
			<elseif cond="{topic[sticky]} == 1"><img src="img/forum/sticky-{etat}.png" title="Post-it - {etat}" /></elseif>
			<else><img src="img/forum/{etat}.png" title="{etat}" /></else>

			</td>

	        	<td><if cond='{lu_forum_ldate} <= {topic[posted_unformat]}'><img src='img/reply.png' title='Nouveau' alt='Nouveau' /></if>
			<a href="forum-post.html?tid={topic[tid]}" title="{lu_forum_ldate}- {topic[posted_unformat]}">{topic[subject]}</a>

			<if cond="isset({topic[arr_pgs]})"><!-- pagination -->
				<br />[Page: 
				<foreach cond="{topic[arr_pgs]} as {i}">
					<if cond='{i} == "..."'> ... </if>
					<else><a href="forum-post.html?tid={topic[tid]}&p={i}" title="page {i}"> {i} </a></else>
				</foreach>]
			</if>
			</td>
		        <td><a href="forum-topic.html?fid={topic[forum_id]}" title="{topic[forum_name]}">{topic[forum_name]}</a></td>
			<td>
			<if cond="isset({topic[auth_mid]})"><img src="img/groupes/{topic[auth_gid]}.png" alt="{groupes[{topic[auth_gid]}]}" title="{groupes[{topic[auth_gid]}]}"/> <a href="member-<math oper="str2url({topic[poster]})"/>.html?mid={topic[auth_mid]}" title="Infos sur {topic[poster]}">{topic[poster]}</a></if>
			<else>{topic[poster]}</else>
			</td>
		        <td>{topic[num_replies]}</td>
		        <td>{topic[last_post]}<br />par 
			<if cond="isset({topic[last_poster_mid]})">
			<img src="img/groupes/{topic[last_poster_gid]}.png" alt="{groupes[{topic[last_poster_gid]}]}" title="{groupes[{topic[last_poster_gid]}]}"/>
			<a href="member-<math oper="str2url({topic[last_poster]})"/>.html?mid={topic[last_poster_mid]}" title="Infos sur {topic[last_poster]}">{topic[last_poster]}</a>
			</if>
			<else>{topic[last_poster]}</else>
			[<a href="forum-post.html?tid={topic[tid]}&pid={topic[last_post_id]}#{topic[last_post_id]}"><img src="img/right.png" /></a>]</td>
	        </tr>
		</foreach>
		</table>
	</else>
</if>


<elseif cond="isset({posts_array})"><h4>Résultats de la recherche par posts</h4>
	<if cond="empty({posts_array})"><p class="infos">Aucun résultat.</p></if>
	<else>

	<foreach cond='{posts_array} as {post}'>
		<div class="block_forum" id="{post[pid]}">
		<img class="blason" title="{post[pposter]}" src="img/mbr_logo/{post[poster_id]}.png" />
		<h4><a href="forum-post.html?tid={post[tid]}&pid={post[pid]}#{post[pid]}" title="post {post[pid]}">{post[subject]}</a></h4>
		<p class="post"><math oper="parse({post[message]})" /></p>
		<p class="stat">Le {post[pposted]} par <a href="member-<math oper="str2url({post[pposter]})"/>.html?mid={post[poster_id]}" title="Infos sur {post[pposter]}">{post[pposter]}</a></p>
		</div>
	</foreach>
	</else>
</elseif>

<else>

<fieldset>
	<legend>Testez la recherche "google est mon ami"</legend>
<form action="http://www.google.fr/cse" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="partner-pub-5781750090543674:4095529098" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="55" />
    <input type="submit" name="sa" value="Rechercher" />
  </div>
</form>

	<script type="text/javascript" src="http://www.google.fr/coop/cse/brand?form=cse-search-box&amp;lang=fr"></script>
</fieldset>


<form id="search" method="get" action="forum-search.html">
	<fieldset>
		<legend>Sélectionnez vos critères de recherche</legend>
		<div class="news">

			<input type="hidden" name="action" value="search" />
			<label class="conl">Mots clés<br /><input type="text" name="keywords" size="30" maxlength="100" /><br /></label>
			<label class="conl">Rechercher un auteur<br /><input id="author" type="text" name="author" size="25" maxlength="25" /><br /></label>
			<p class="clearb">Pour effectuer une recherche par mots clés, saisissez le ou les termes à rechercher. Séparez chaque terme avec des espaces. Utilisez AND, OR, NOT pour affiner votre recherche. Pour rechercher par auteur, saisissez le nom d'utilisateur auquel les messages appartiennent. Utilisez le joker * pour des recherches sur des mots incomplets.</p>
		</div>
	</fieldset>

	<fieldset>
		<legend>Sélectionnez où vous souhaitez chercher</legend>
		<div class="news">
			<label class="conl">Forum
			<br /><select id="forum" name="forum">
				<option value="-1">Tous les forums</option>
				<foreach cond="{cat_array} as {cid} => {cat}">
					<optgroup label="{cat[cat_name]}">
					<foreach cond="{cat[frm]} as {forum}">
						<option value="{forum[fid]}">{forum[forum_name]}</option>
					</foreach>
					</optgroup>
				</foreach>
			</select>
			<br /></label>
			<label class="conl">Rechercher dans
			<br /><select id="search_in" name="search_in">
				<option value="all">Texte du message et du sujet</option>
				<option value="message">Texte du message seulement</option>
				<option value="topic">Texte du sujet seulement</option>
			</select>

			<br /></label>
			<p class="clearb">Choisissez dans quel forum vous souhaitez lancer votre recherche et si vous souhaitez rechercher dans les sujets des discussions ou les textes des messages ou bien les deux à la fois.</p>
		</div>
	</fieldset>


	<fieldset>
		<legend>Sélectionnez le mode d'affichage des résultats</legend>

		<div class="news">
			<label class="conl">Trier par
			<br /><select name="sort_by">
				<option value="5">Date du message</option>
				<option value="1">Auteur</option>
				<option value="2">Sujet</option>
				<option value="3">Forum</option>

			</select>
			<br /></label>
			<label class="conl">Ordre
			<br /><select name="sort_dir">
				<option value="DESC">Décroissant</option>
				<option value="ASC">Croissant</option>
			</select>
			<br /></label>

			<label class="conl">Voir les résultats
			<br /><select name="show_as">
				<option value="topics">Discussions</option>
				<option value="posts">Messages</option>
			</select>
			<br /></label>
			<p class="clearb">Vous pouvez choisir comment vous voulez classer et afficher les résultats.</p>
		</div>

	</fieldset>
<p><input type="submit" name="search" value="Envoyer" accesskey="s" /></p>
</form>

</else>
