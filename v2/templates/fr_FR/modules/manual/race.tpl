<if cond='{man_act} == "unt"'>
	<p class="menu_module">[ <a href="manual.html?race={man_race}&type=unt&stype={TYPE_UNT_CIVIL}" alt="Unités Civiles" title="Unités Civiles">Unités Civiles</a> ] -
	[ <a href="manual.html?race={man_race}&type=unt&stype={TYPE_UNT_INFANTERIE}" alt="Unités Militaires" title="Unités Militaires">Unités Militaires</a> ] -
	[ <a href="manual.html?race={man_race}&type=unt&stype={TYPE_UNT_HEROS}" alt="Héros" title="Héros">Héros</a> ]
	</p>

	<if cond="{man_stype} != {TYPE_UNT_CIVIL}"><p class='infos'>Les unités militaires sont présentées dans l'ordre de leur placement dans les légions.</p></if>

    <include file="modules/manual/man_unt.tpl" cache="1" />
     
     <p align="center" class="menu_module">
     [ <a href="manual.html?race={man_race}&page=3">Précédent : Unités (Explications)</a>  ]
     -
     [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
     -
     [ <a href="manual.html?race={man_race}&page=26">Suivant : Compétences des Héros (Explications)</a> ]
     </p>

</if>


<elseif cond='{man_act} == "btc"'>

    <include file="modules/manual/man_btc.tpl" cache="1" />
     <p align="center" class="menu_module">
         [ <a href="manual.html?race={man_race}&page=2">Précédent : Bâtiments (Explications)</a>  ]
         -
         [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
         -
         [ <a href="manual.html?race={man_race}&page=3">Suivant : Unités (Explications)</a> ]
    </p>
</elseif>

<elseif cond='{man_act} == "src"'>

    <include file="modules/manual/man_src.tpl" cache="1" />
    <p align="center" class="menu_module">
         [ <a href="manual.html?race={man_race}&page=4">Précédent : Recherches (Explications)</a>  ]
         -
         [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
         -
         [ <a href="manual.html?race={man_race}&page=5">Suivant : Ressources (Explications)</a> ]
    </p>
</elseif>


<elseif cond='{man_act} == "res"'>

    <include file="modules/manual/man_res.tpl" cache="1" />
    <p align="center" class="menu_module">
         [ <a href="manual.html?race={man_race}&page=5">Précédent : Ressources (Explications)</a>  ]
         -
         [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
         -
         [ <a href="manual.html?race={man_race}&page=11">Suivant : Terrains (Explications)</a> ]
    </p>
</elseif>


<elseif cond='{man_act} == "trn"'>
 <dl>
 <foreach cond='{man_array} as {trn_id} => {trn_value}'>
           <dt id="trn_{trn_id}">
                 <a href="manual.html?race={man_race}&type=trn#trn_{trn_id}">
                 <zimgtrn type="{trn_id}" race="{man_race}" /> {trn[{man_race}][alt][{trn_id}]}
                 </a></dt>
             <dd>
             <p>{trn[{man_race}][descr][{trn_id}]}</p>
      </dd>
 </foreach>
 </dl>
 <p align="center" class="menu_module">
     [ <a href="manual.html?race={man_race}&page=11">Précédent : Terrains (Explications)</a>  ]
     -
     [ <a href="manual.html?race={man_race}&page=0" title="Accueil du Manuel">Manuel</a> ]
     -
     [ <a href="manual.html?race={man_race}&page=12">Suivant : Guide du Débutant</a> ]
</p>
</elseif>


<elseif cond='{man_act} == "comp"'>

    <include file="modules/manual/man_comp.tpl" cache="1" />
    <p align="center" class="menu_module">
    [ <a href="manual.html?race={man_race}&page=26">Précédent : Compétences des héros (explications)</a>  ]
    -
    [ <a href="manual.html?race={man_race}" title="Accueil du Manuel">Manuel</a> ]
    -
    [ <a href="manual.html?race={man_race}&page=4">Suivant : Recherches (explications)</a> ]
    </p>
</elseif>

