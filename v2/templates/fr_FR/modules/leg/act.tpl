<div class="menu_module">
	[ <a href="leg-view.html?lid={leg[leg_id]}" title="Gérer cette légion">Gérer</a> ]
	<if cond="empty({unt_leg[{leg[leg_id]}]})">
	 - [ <a href="leg-del.html?lid={leg[leg_id]}" title="Supprimer cette légion">Supprimer</a> ]
	</if>

	<if cond="{leg[leg_cid]} != {_user[mapcid]}">
		<if cond="empty({unt_leg[{leg[leg_id]}]})">
		- [ <a href="leg-recup.html?lid={leg[leg_id]}" title="récupérer cette légion">récupérer</a> ]
		</if>
		<elseif cond="{leg[leg_dest]} != {_user[mapcid]}">
		- [ <a href="leg-move.html?sub=sou&amp;cid={_user[mapcid]}&amp;lid={leg[leg_id]}" title="ramener la légion au village">rentrer</a> ]
		</elseif>
	</if>
	<elseif cond='isset({thisetat}) && {thisetat} != {LEG_ETAT_VLG}'>
		- [ <a href="leg-view.html?sub=butin&amp;lid={leg[leg_id]}" title="récupérer butin">butin</a> ]
	</elseif>

	<if cond="{leg[leg_etat]} == {LEG_ETAT_POS} && !empty({unt_leg[{leg[leg_id]}]})">
		- [ <a href="war-make_atq.html?lid1={leg[leg_id]}" id="make_atq">attaquer</a> ]
	</if>

<div id="dialog-modal" title="A L'attaque !" style="display:none;">
<p>Souhaitez vous lancer votre armée à l'attaque ?</p>
</div>

<script langage="javascript">
// ce script pilote le popup de confirmation
$(document).ready( function(){ // quand la page a fini de se charger
	$("#make_atq").click(function(){ // au clic sur le lien
		$("#dialog-modal").dialog({ // popup
			buttons: [{
				text: "Annuler", // bouton annuler
				click: function() {
				$( this ).dialog( "close" );}
			},{
				text: "Attaquer", // bouton attaquer renvoie vers le lien #make_atq
				click: function() {
				window.location = $("#make_atq").attr('href');}
			}]
		});
		return false;
	});
});
</script>

</div>
