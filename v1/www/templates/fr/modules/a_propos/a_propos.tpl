<h2>Equipe</h2>
<p>
<foreach cond="|{team_array}| as |{team_value}|">
	<if cond="|{groupe_courant}| != |{team_value[mbr_gid]}|">
		<set name="groupe_courant" value="{team_value[mbr_gid]}" />
		
		<h3><img src="img/groupes/{team_value[mbr_gid]}.png" alt="{groupes[{team_value[mbr_gid]}]}" title="{groupes[{team_value[mbr_gid]}]}" /> {groupes[{team_value[mbr_gid]}]}</h3>
	</if>
	[ <a href="index.php?file=member&amp;act=view&amp;mid={team_value[mbr_mid]}" title="Infos sur {team_value[mbr_pseudo]}">{team_value[mbr_pseudo]}</a> ] 
</foreach>

</p>
<hr />
<h2>Merci à</h2>
<p>
<strong><a href="index.php?file=forum&amp;act=list_modo" title="Modos et Sheriffs">Eux :D</a></strong><br/>
<strong>shadyskull</strong> : Manuel refait :)<br/>
<strong>Zipjo</strong> : images, design, tout ça ...<br/>
<strong>Booox</strong> : design, conseils, etc ...<br/>
<strong>Karamilo</strong> : pour tout ce qu’il a fait (trop long à dire ici).<br/>
<strong>kokotchy</strong> : une frite une foué !<br/>
<strong>Brice (brice) et Guillaume (gui,nop)</strong> : achat/installation/configuration du serveur, tout ça ...<br/>
Les beta-testeurs.<br/>
Talus, le favicon :p.

</p>
<hr />
<h2>Histoire du site</h2>
<ul>
<li>Début 2004 - Idée</li>
<li>Juillet 2004 - Première version jouable</li>
<li>24 Octobre 2004 - Alpha 2, herbergée par cliranet.com</li>
<li>20 Novembre 2004 - 1.0 Publique</li>
<li>30 Janvier 2005 - Anniversaire de la première idée de Zordania !</li>
<li>18 Mars 2005 - Arrivée des Orcs dans Zordania</li>
<li>4 Juin 2005 - 1.3 Nouveau système d'attaque, et pleins d'autres choses</li>
<li>6 Juin 2005 - 1.5 Nouvelles races ! Nains et Drows !</li>
<li>1 Novembre 2005 - 1.7 Nouveau serveur !</li>
</ul>
<hr />
<h2>Contact</h2>
Iksaif
 - <a href="mailto:%77%65%62%6das%74%65r@&#122&#111rd%61%6e&#105a.%63%6f%6d?subject=Zordania">Contact</a>
<hr />
<h2>Boutons</h2>
<h3>Par Venom</h3>
<set name="icon_size" value="46860" />
<set name="icon_nb" value="2" />
<set name="icon_type" value="gif" />
<include file="modules/a_propos/bouton.tpl" cache="1" />

<set name="icon_size" value="8831" />
<set name="icon_nb" value="3" />
<set name="icon_type" value="png" />
<include file="modules/a_propos/bouton.tpl" cache="1" />
<set name="icon_nb" value="4" />
<include file="modules/a_propos/bouton.tpl" cache="1" />
<set name="icon_type" value="gif" />
<include file="modules/a_propos/bouton.tpl" cache="1" />

<hr />

<h3>Par drexil</h3>
<set name="icon_nb" value="5" />
<set name="icon_type" value="png" />
<set name="icon_size" value="8831" />
<include file="modules/a_propos/bouton.tpl" cache="1" />
<set name="icon_nb" value="6" />
<include file="modules/a_propos/bouton.tpl" cache="1" />

<hr/>

<h3>Par Talus</h3>
<set name="icon_nb" value="1" />
<set name="icon_type" value="png" />
<include file="modules/a_propos/bouton.tpl" cache="1" />
<set name="icon_size" value="8015" />
<include file="modules/a_propos/bouton.tpl" cache="1" />

<hr />

<h3>Par Drake</h3>
<set name="icon_size" value="8831" />
<set name="icon_nb" value="2" />
<set name="icon_type" value="png" />
<include file="modules/a_propos/bouton.tpl" cache="1" />
