<if cond="!{_user[loged]}">
	<p class="infos">C'est votre première venue ? <a href="a_propos-whatiszord.html">C'est quoi Zordania ?</a></p>
</if>

<h3 class="head_forum"><a href="forum.html">Forums</a> <img src="img/right.png" /> <a href="forum.html?cid={frm[cid]}">{frm[cat_name]}</a> <img src="img/right.png" /> <a href="forum-topic.html?fid={frm[fid]}">{frm[forum_name]}</a> <img src="img/right.png" />

<if cond="isset({arr_pge})">
	<foreach cond="{arr_pge} as {i}">
		<if cond='{i} == {pge} || {i} == "..."'> {i} </if>
		<else> <a href="news.html?p={i}" title="page {i}">{i}</a> </else>
	</foreach>
</if>
</h3>

<if cond='isset({nws_array}) AND is_array({nws_array})'>
	<foreach cond='{nws_array} as {nws}'>
		<set name="post" value="{posts_array[{nws[first_pid]}]}"/>

		<div class="block_forum" id="{post[pid]}">
			<img class="blason" title="{post[username]}" src="img/mbr_logo/{post[poster_id]}.png" />
			<a class="titre" href="forum-<math oper="str2url({post[subject]})"/>.html?pid={post[pid]}#{post[pid]}">{post[subject]}</a>

			<p class="post"><math oper="parse({post[message]})" /></p>
			<if cond='{post[edited]}'>
				<p><em>édité par {post[edited_by]} le {post[edited]}</em></p>
			</if>

			<p>
			<a href="forum-rep.html?tid={post[tid]}&qt={post[pid]}"><img src="img/forum/post.png"  title="citer"/></a>
			<if cond='{is_modo} || ({_user[mid]} == {post[poster_id]})'>
				<a href="forum-post.html?sub=conf&pid={post[pid]}">
					<img src="img/drop.png" alt="Supprimer" title="Supprimer" />
				</a>
				<a href="forum-rep.html?sub=edit&pid={post[pid]}">
					<img src="img/editer.png" alt="Editer" title="Editer" />
				</a>
			</if>
			<a href="forum-post.html?pid={post[pid]}#{post[pid]}">le {post[posted]}</a> par 
			<if cond="{post[mbr_gid]}">
				<zurlmbr gid="{post[mbr_gid]}" mid="{post[poster_id]}" pseudo="{post[username]}"/>
				<if cond='{post[al_aid]}'>
					- <a href="alliances-view.html?al_aid={post[al_aid]}" title="Infos sur {post[al_name]}"><img src="img/al_logo/{post[al_aid]}-thumb.png" class="mini_al_logo"/> </a>
				</if>
			</if>
			<else>{post[username]}</else>
			- <a href="forum-rep.html?tid={nws[tid]}">{nws[num_replies]} commentaires</a>
			</p>

			<if cond="!empty({post[mbr_sign]})"><p class="signature">{post[mbr_sign]}</p></if>
		</div>
	</foreach>

	<if cond="isset({arr_pge})">
		<p>
		<foreach cond="{arr_pge} as {i}">
			<if cond='{i} == {pge} || {i} == "..."'> {i} </if>
			<else> <a href="news.html?p={i}" title="page {i}">{i}</a> </else>
		</foreach>
		</p>
	</if>

</elseif>

<else>
	<p class="error">Il n'y a pas de news pour le moment.</p>
</else>
