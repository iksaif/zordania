<p class="menu_module">
[<a href="a_propos.html" title="les membres de l'équipe"> L'équipe </a>]
- [<a href="a_propos-rec.html" title="Les récompenses"> Récompenses </a>]
- [<a href="a_propos-roi.html" title="Les rois"> Les rois de Zordania! </a>]
- [<a href="a_propos-le_site.html" title="l'évolution du site"> Le site </a>]
- [<a href="a_propos-boutons.html" title="Les boutons"> Boutons </a>]
- [<a href="a_propos-legal.html" title="Mentions légales"> Mentions légales </a>]
</p>


<if cond='{a_propos_act} == "rec"'>
	<h1>Les Récompenses</h1>
	<foreach cond='{rec_array} as {rec} => {rec_mbr}'>
		<h4><img src="img/rec/{rec}.png" title="{recompense[{rec}]}" alt="{recompense[{rec}]}" />{recompense[{rec}]}</h4>
		<p>
		<foreach cond='{rec_mbr} as {mbr}'>
		[ <a href="member-view.html?mid={mbr[mbr_mid]}" title="Infos sur {mbr[mbr_pseudo]}">{mbr[mbr_pseudo]}</a> ] 
		</foreach>	
		</p>	
	</foreach>
</if>
<elseif cond='{a_propos_act} == "roi"'>
	<h1>Les rois ou reines  de Zordania!</h1>
	<foreach cond='{rec_array} as {rec_rois} => {rec_mbr}'>
		<h4><img src="img/rec/{rec_rois}.png" title="{recompense[{rec_rois}]}" alt="{recompense[{rec_rois}]}" />{recompense[{rec_rois}]}</h4>
		<p>
		<foreach cond='{rec_mbr} as {mbr}'>
		[ <a href="member-view.html?mid={mbr[mbr_mid]}" title="Infos sur {mbr[mbr_pseudo]}">{mbr[mbr_pseudo]}</a> ] 
		</foreach>	
		</p>	
	</foreach>
</elseif>
<elseif cond='{a_propos_act} == "le_site"'>
	
	<h1>Remerciements</h1>
	<p>
	<strong>Arzhiel, Wharg, Shalimar, Sum Groor, Alexander, Voyisha, Torgon :</strong> RP v2.<br/>
	<strong>Brice (brice) et Guillaume (gui,nop) :</strong> achat/installation/configuration du serveur, tout ça...<br/>
	<strong>Booox (Thomas) :</strong> Design, conseils, etc...<br/>
	<strong>Boris Volkov :</strong> Images des divinités (disponibles <a href="img/rp/">ici</a>).<br/>
	<strong>Elhean :</strong> Manuel refait, conception des drows et des elfes, images des orcs.<br/>
	<strong>Endrihan :</strong> Cartes et CSS.<br/>
	<strong>Fanou :</strong> Base du Gameplay v2.<br/>
	<strong>Karamilo :</strong> Système de templates.<br/>
	<strong>kokotchy :</strong> Une frite une foué !<br/>
	<strong>Mordrar :</strong> Conception des nains.<br/>
	<strong>Talus :</strong> Le favicon.<br/>
	<strong>Venom :</strong> Images 'Village', Conception des humain, CSS, diverses unités.<br/>
	<strong>Zipjo :</strong> Images, design, tout ça...<br/>
	<br></br>
	<strong>Les crapougnais qui se reconnaîtront, et le tassilunois aussi, et puis les autres.</strong><br/>
        <br></br>
	<strong>Le staff ainsi que les bêta-testeurs.</strong><br/>
	</p>
	<hr />
	<h1>Histoire du site</h1>
	<ul>
	<li>Début 2004 - Idée.</li>
	<li>Juillet 2004 - Première version jouable.</li>
	<li>24 Octobre 2004 - Alpha 2, hébergée par cliranet.com</li>
	<li>20 Novembre 2004 - 1.0 Publique.</li>
	<li>30 Janvier 2005 - Anniversaire de la première idée de Zordania !</li>
	<li>18 Mars 2005 - 1.1 Arrivée des Orcs dans Zordania.</li>
	<li>4 Juin 2005 - 1.3 Nouveau système d'attaque, et plein d'autres choses.</li>
	<li>6 Juin 2005 - 1.5 Nouvelles races ! Nains et Drows !</li>
	<li>1 Novembre 2005 - 1.7 Nouveau serveur !</li>
	<li>Juillet 2006 - 1.9 Les Elfes.</li>
	<li>Juillet 2006 - Septembre 2007 - Attente de la v2.</li>
	<li>Septembre 2007 - Sortie de la v2 !</li>
	<li>Juin 2008 - Nouveau serveur: Dedibox.</li>
	<li>Janvier 2009 - Nouveau départ avec une nouvelle équipe.</li>
	<li>Avril 2013 - 2.1 Nouvelle race: les gobelins.</li>
	</ul>
</elseif>
<elseif cond='{a_propos_act} == "boutons"'>

	<h1>Boutons</h1>
	<h4>ElficNight</h4>
	<set name="icon_size" value="46860" />
	<set name="icon_nb" value="3" />
	<set name="icon_type" value="png" />
	<include file="modules/a_propos/bouton.tpl" cache="1" />

	<h4>Par Venom</h4>
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

	<h4>Par drexil</h4>
	<set name="icon_nb" value="5" />
	<set name="icon_type" value="png" />
	<set name="icon_size" value="8831" />
	<include file="modules/a_propos/bouton.tpl" cache="1" />
	<set name="icon_nb" value="6" />
	<include file="modules/a_propos/bouton.tpl" cache="1" />

	<hr/>

	<h4>Par Talus</h4>
	<set name="icon_nb" value="1" />
	<set name="icon_type" value="png" />
	<include file="modules/a_propos/bouton.tpl" cache="1" />
	<set name="icon_size" value="8015" />
	<include file="modules/a_propos/bouton.tpl" cache="1" />
	
	<hr />
	
	<h4>Par Drake</h4>
	<set name="icon_size" value="8831" />
	<set name="icon_nb" value="2" />
	<set name="icon_type" value="png" />
	<include file="modules/a_propos/bouton.tpl" cache="1" />

	<h4>Original</h4>
	<set name="icon_size" value="46860" />
	<set name="icon_nb" value="1" />
	<set name="icon_type" value="png" />
	<include file="modules/a_propos/bouton.tpl" cache="1" />

<script type="text/javascript"><!--
/* select all text on focus */
$("input[type=text]").focus(function(){
    $(this).select();
});
// -->
</script>
</elseif>
<else>
	<h1>L'Equipe</h1>
	<p>
	<foreach cond="{team_order} as {grp} => {mbr_array}">
		<h4><img src="img/groupes/{grp}.png" alt="{groupes[{grp}]}" title="{groupes[{grp}]}" /> {groupes[{grp}]}</h4>
	
		<foreach cond="{mbr_array} as {mbr}">
	[ <a href="member-view.html?mid={mbr[mbr_mid]}" title="Infos sur {mbr[mbr_pseudo]}">{mbr[mbr_pseudo]}</a> ] 
		</foreach>
	</foreach>
</else>
