<p class="menu_module">
<foreach cond="|{race}| as |{race_id}| => |{race_name}|">
[ 
<if cond="|{man_race}| != |{race_id}|">
	<a href="index.php?file=manual&amp;race={race_id}">
	<img src="img/{race_id}/{race_id}.png" alt="{race_name}" title="{race_name}" /> {race_name}
	</a>
</if>
<else>
		<a href="index.php?file=manual&amp;race={race_id}">
	<img src="img/{race_id}/{race_id}.png" alt="{race_name}" title="{race_name}" /> <strong>{race_name}</strong>
	</a>
</else>
] 
</foreach>
</p>
Cette partie parle du jeu en général, pour avoir des infos sur une race en particulier, il suffit de cliquer sur la race puis sur la partie qui vous intéresse.
<h2>Manuel des <img src="img/{man_race}/{man_race}.png" alt="{race[{man_race}]}" title="{race[{man_race}]}" />  {race[{man_race}]} :</h2>
<ul>
 <li><a href="index.php?file=manual&amp;race={man_race}&amp;page=1">Le Jeu</a></li>
 <li><a href="index.php?file=manual&amp;race={man_race}&amp;page=6">Le monde</a></li>
 <li> Bâtiments
 <ul>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;page=2">Explications</a></li>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=btc">Caractéristiques</a></li>
 </ul>
 </li> 
 <li> Unités
 <ul>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;page=3">Explications</a></li>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=unt">Caractéristiques</a></li>
 </ul>
 </li> 
 <li> Recherches
 <ul>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;page=4">Explications</a></li>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=src">Caractéristiques</a></li>
 </ul>
 </li> 
 <li> Ressources
 <ul>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;page=5">Explications</a></li>
 	<li><a href="index.php?file=manual&amp;race={man_race}&amp;type=res">Caractéristiques</a></li>
 </ul>
 </li>
 <li><a href="index.php?file=manual&amp;race={man_race}&amp;page=7">Commerce</a></li>
 <li><a href="index.php?file=manual&amp;race={man_race}&amp;page=8">Guerres</a></li>
 <li><a href="index.php?file=manual&amp;race={man_race}&amp;page=9">Héros</a></li>
 <li><a href="index.php?file=manual&amp;race={man_race}&amp;page=10">Votre Race</a></li>
</ul>
<if cond='|{man_race}|'>
<if cond='|{man_load}|'>
	  <load file="race/{man_race}.config" />
	  <load file="race/{man_race}.descr.config" />
</if>
</if> 

<if cond='isset(|{mnl_tpl}|)'>
	<hr />
	<include file="{mnl_tpl}" cache="1" />
</if>

