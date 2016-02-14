Cette partie parle du jeu en général, pour avoir des infos sur une race en particulier, il suffit de cliquer sur la race puis sur la partie qui vous intéresse.
<ul>
 <li><a href="index.php?file=manual&amp;page=1">Le Jeu</a></li>
 <li><a href="index.php?file=manual&amp;page=2">Batîments</a></li>
 <li><a href="index.php?file=manual&amp;page=3">Unités</a></li>
 <li><a href="index.php?file=manual&amp;page=4">Recherches</a></li>
 <li><a href="index.php?file=manual&amp;page=5">Ressources</a></li>
 <li><a href="index.php?file=manual&amp;page=6">Le monde</a></li>
 <li><a href="index.php?file=manual&amp;page=7">Commerce</a></li>
 <li><a href="index.php?file=manual&amp;page=8">Guerres</a></li>
 <li><a href="index.php?file=manual&amp;page=9">Races</a>
 <ul>
 	<foreach cond="|{race}| as |{race_id}| => |{race_name}|">
 	<li><a href="index.php?file=manual&amp;race={race_id}">{race_name}</a></li>
 	</foreach>
 </ul>
 </li>
</ul>
<if cond='isset(|{mnl_tpl}|)'>
	<hr />
	<include file="{mnl_tpl}" cache="1" />
</if>