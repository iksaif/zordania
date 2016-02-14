<# demenagement formule ajax non utilisee pour l'instant #>
<if cond="{result[map_type]} == MAP_LIBRE">
	<form>
		<fieldset>
			<legend>Déménager ici</legend>
			<label for="map_pseudo">Pseudo:</label>
			<input type="text" name="move_pseudo" id="move_pseudo" />
			<input type="submit" value="Déménager !"/>
		</fieldset>
	</form>
	<script type="text/javascript">
	<!--
	// Ajoute l'autocomplétion sur l'input d'id 'map_pseudo'
	$(document).ready(function(){
		$("#move_pseudo").autocomplete({
			source: "/json--member-search.html?type=ajax"
		});
	});
	// -->
	</script>
</if>
