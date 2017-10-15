<if cond='{_user[alaid]} AND {act} != "" and {act} != "histo" '>
<p class="menu_module">[ <a tip="Gestion de l'Alliance" href="alliances-admin.html">Gestion</a> ]
	-
	[ <a tip="Discuter, ect." href="alliances-my.html">Table ronde</a> ]
	-
	[ <a tip="Decriptifs et Règles" href="alliances-descr_rules.html">Règles</a> ]
	-
	[ <a tip="Stocks de Ressources" href="alliances-res.html">Grenier</a> ]
	-
	[ <a tip="Gestion de la Diplomatie" href="diplo-my.html">Diplomatie</a> ]
</p>
</if>

<if cond="isset({err})">
	<if cond='{err}=="no_aid"'><p class="error">Vous n'êtes pas dans une alliance.</p></if>
	<elseif cond='{err}=="no_chef"'><p class="error">Vous n'êtes pas le chef de votre alliance.</p></elseif>
	<elseif cond='{err}=="nb_pactes"'><p class="error">Votre alliance ne saurait cumuler tant de pactes !</p></elseif>
	<elseif cond='{err}=="meme_al"'><p class="error">Inutile de vouloir faire un pacte avec votre propre alliance !</p></elseif>
	<elseif cond='{err}=="exist"'><p class="error">Vous avez déjà un pacte signé ou en cours de proposition avec cette alliance.</p></elseif>
	<else><p class="error">Action ou pacte inexistant ! ( {err} )</p></else>
</if>

<else>
	<hr/>

	<if cond='{act} == "add"'>
		<include file='modules/diplo/add.tpl' cache='1' />
	</if>
	<else>
		<if cond='{act} == "no"'>
			<if cond='{act_ok}'><p class="ok">Cette proposition de pacte a été refusée.</p></if>
			<else><p class="error">Erreur : {err}</p></else>
		</if>
		<elseif cond='{act} == "del"'>
			<if cond='{act_ok}'><p class="ok">Vous venez de rompre un pacte !</p></if>
			<else><p class="error">Erreur : {err}</p></else>
		</elseif>
		<elseif cond='{act} == "ok"'>
			<if cond='{act_ok}'><p class="ok">Vous venez de signer un nouveau pacte !</p></if>
			<else><p class="error">Erreur : {err}</p></else>
		</elseif>

		<if cond='{act} == "my" || {act} == "ok" || {act} == "no" || {act} == "del"'>
			<include file='modules/diplo/my.tpl' cache='1' />
		</if>
		<elseif cond='{act} == "shoot"'>
			<include file='modules/diplo/shoot.tpl' cache='1' />
		</elseif>
		<else>
			<include file='modules/diplo/ally.tpl' cache='1' />
		</else>
	</else>
</else>
