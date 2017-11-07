<p class="menu_module">
	<foreach cond="{race} as {race_id} => {race_name}">
	<a href="admin.html?module=btc&amp;race={race_id}">
		<img src="img/{race_id}/{race_id}.png" alt="{race_name}" title="{race_name}" /> {race_name}
	</a>
	<load file="race/{race_id}.config" />
	<load file="race/{race_id}.descr.config" />
	</foreach>
</p>


<h3>Comparaison des images de batiments</h3>
<ul>
<li>image normale = visible sur la plupart des pages</li>
<li>village1 = image sur le village sans sa forteresse</li>
<li>village2 = image sur le village avec sa forteresse</li>
</ul>

<table>

<th>img normale</th>
<th>img village1</th>
<th>img village2</th>

<foreach cond="{list_btc} as {cfg_type} => {cfg_value}">
<tr>
	<td><zimgbtc race="{race_sel}" type="{cfg_type}"/></td>
	<td><img src="img/{race_sel}/vlg/0/{cfg_type}.png" /></td>
	<td><img src="img/{race_sel}/vlg/1/{cfg_type}.png" /></td>
</tr>
</foreach>

</table>

