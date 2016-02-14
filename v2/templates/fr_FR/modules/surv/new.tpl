<form action="admin.html?module=surv&amp;act=add" method="post">
	<fieldset>
		<legend>Ajouter une surveillance sur {mbr_array[mbr_pseudo]}</legend>
		<input type="hidden" name="mid" id="mid" value="{mbr_array[mbr_mid]}" />
		<p><label for="cause">Cause: </label><input type="text" name="cause" /></p>
		<p><label for="type">Type: </label>
			<select name="type">
			<foreach cond="{array_type} as {key} => {stype}">
				<option value="{key}">{stype}</option>
			</foreach>
			</select>
		</p>
		<input type="submit" value="Surveiller" />
	</fieldset>
</form>

