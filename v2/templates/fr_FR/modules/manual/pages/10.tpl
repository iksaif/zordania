<h3>Diplomatie</h3>
À tout moment, le chef d'alliance peut proposer un pacte à une autre alliance. Le chef de l'autre alliance en sera averti par un message privé. Il peut alors accepter ou refuser le pacte. S'il accepte de signer le pacte, celui-ci devient actif après une période de {dpl_proba} tours.

La signature d'un pacte a un prix, qui est prélevé dans le grenier des deux alliances :
<dl>
<foreach cond="{dpl_type} as {dpl_type1} => {dpl_lbl}">
	<dt><img src="img/dpl/{dpl_type1}.png" title="{dpl_lbl}"/> {dpl_lbl}</dt>
	<dd>{dpl_descr[{dpl_type1}]}<br/>
	Prix : 
	<foreach cond="{dpl_prix[{dpl_type1}]} as {ress} => {nb_res}"> {nb_res} <zimgres race="{man_race}" type="{ress}" /> </foreach>
	<br/>Limité à {dpl_max[{dpl_type1}]}
	</dd>
</foreach>
</dl>

<h4>La vie d'un pacte</h4>

<dl>
	<dt>{dpl_etat[{DPL_ETAT_PROP}]}</dt>
	<dd>Une proposition de pacte a été envoyée, mais le chef de l'alliance concernée n'a pas encore donné son acceptation.</dd>

	<dt>{dpl_etat[{DPL_ETAT_NO}]}</dt>
	<dd>Le chef de l'alliance s'est vu proposer un pacte, mais il l'a décliné.</dd>

	<dt>{dpl_etat[{DPL_ETAT_ATT}]}</dt>
	<dd>Le chef de l'alliance a accepté le pacte qu'on lui a proposé. Dès lors, une période probatoire fixe de {dpl_proba} tours doit s'écouler avant que ce pacte ne devienne valide. Une fois le pacte valide, le prix sera déduit dans le grenier et il deviendra actif.</dd>

	<dt>{dpl_etat[{DPL_ETAT_OK}]}</dt>
	<dd>Pacte signé par les deux alliances concernées, et actif, la période probatoire est terminée.</dd>

	<dt>{dpl_etat[{DPL_ETAT_FIN}]}</dt>
	<dd>Ce pacte a été rompu par l'une des deux alliances concernées, après qu'il ait été accepté.</dd>

</dl>

<p align="center" class="menu_module">
[ <a href="manual.html?race={man_race}&page=">Précédent : Alliances</a>  ]
-
[ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
-
[ <a href="manual.html?race={man_race}&page=7">Suivant : Commerce</a> ]
</p>
