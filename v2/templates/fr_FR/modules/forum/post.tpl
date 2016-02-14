<div class="block_forum" id="{post[id]}">
	<if cond='isset({tpc_vide})'><p class="error">Il manque un titre ou un message à votre topic.</p></if>
	<else>
		<img class="blason" title="{post[username]}" src="img/mbr_logo/{post[poster_id]}.png" />
		<h4><a href="forum-post.html?tid={tid}&pid={post[id]}#{post[id]}" title="post {post[id]}">{post[subject]}</a></h4>

		<p class="post">{post[message]}</p>
		<if cond='isset({post[edited]})'><p><em>&eacute;dit&eacute; par {post[edited_by]} le {post[edited]}</em></p></if>
		<p>
		<a href="#">le {post[posted]}</a> par <zurlmbr gid="{post[mbr_gid]}" mid="{post[poster_id]}" pseudo="{post[username]}"/>
		<if cond='isset({post[al_aid]})'>
			- <a href="alliances-view.html?al_aid={post[al_aid]}" title="Infos sur {post[al_name]}">
			<img src="img/al_logo/{post[al_aid]}-thumb.png" class="mini_al_logo" />{post[al_name]}</a>
		</if>
		</p>
<#
		<if cond='isset({post[sdg_rep1]})'><p>{post[sdg_rep1]}</p></if>
		<if cond='isset({post[sdg_rep2]})'><p>{post[sdg_rep2]}</p></if>
		<if cond='isset({post[sdg_rep3]})'><p>{post[sdg_rep3]}</p></if>
		<if cond='isset({post[sdg_rep4]})'><p>{post[sdg_rep4]}</p></if>
<debug print="{post}"/>
#>
	</else>
</div>
