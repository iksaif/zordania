<if cond="!empty({al_diplo_descr})">
	<h3>Diplomatie de l'alliance {ally}</h3>
	{al_diplo_descr}
</if>

<h3>Créer un nouveau pacte</h3>
<if cond='isset({dpl_add})'>
	<if cond="{dpl_add}"><p class="ok">Une proposition de pacte a été envoyée.</p></if>
	<else><p class="error">Erreur : {err}</p></else>
</if>

<form action="diplo-add.html" method="post">

	<p><label for="ally">Alliance</label>
		<input type="text" name="ally" id="ally" value="{ally}" />
	</p>

	<p>Sélectionnez le type de pacte demandé :</p>
	<foreach cond="{dpl_type} as {dpl_id} => {dpl_type_nom}">
		<if cond="{al1_pactes[{dpl_id}]} >= {max_pactes[{dpl_id}]}">
			<p class="error"><img src="img/dpl/{dpl_id}.png" title="{dpl_type_nom}"/> Nombre maximum de {dpl_type_nom} atteint ( {max_pactes[{dpl_id}]} ) pour mon alliance.</p>
		</if>
		<elseif cond="isset({al2_pactes}) && {al2_pactes[{dpl_id}]} >= {max_pactes[{dpl_id}]}">
			<p class="error"><img src="img/dpl/{dpl_id}.png" title="{dpl_type_nom}"/> Nombre maximum de {dpl_type_nom} atteint ( {max_pactes[{dpl_id}]} ) pour {ally}.</p>
		</elseif>
		<else>
			<p><input type="radio" id="type{dpl_id}" name="type" value="{dpl_id}" />
			<label for="type{dpl_id}">
			<img src="img/dpl/{dpl_id}.png" title="{dpl_type_nom}"/> {dpl_type_nom} ( {al1_pactes[{dpl_id}]} / {max_pactes[{dpl_id}]} )
			prix : <foreach cond="{prix_pactes[{dpl_id}]} as {key} => {value}"> {value} <zimgres race="{_user[race]}" type="{key}" /></foreach>
			</label></p>
		</else>
	</foreach>

	<input type="submit" name="dpl_add" value="Proposer un nouve pacte" />
</form>
