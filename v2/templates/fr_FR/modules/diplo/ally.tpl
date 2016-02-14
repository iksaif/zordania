<if cond='{act} != "histo"'>
	<h3>Diplomatie de l'alliance {al_name}</h3>
{al_diplo_descr}

	<h3>Liste des pactes de {al_name}</h3>
</if>
<else>
	<h3>Liste des anciens pactes de {al_name}</h3>
</else>

<table>
<tr>
	<th>Pacte</th>
	<th>Alliance</th>
	<th>Depuis le</th>
	<th>Etat</th>
</tr>
<foreach cond="{mespactes} as {pacte}">
<if cond='{pacte[dpl_etat]} != {DPL_ETAT_PROP} and {pacte[dpl_etat]} != {DPL_ETAT_ATT} and ({act}=="histo" xor {pacte[dpl_etat]} == {DPL_ETAT_OK})'>
<tr>
	<td><img src="img/dpl/{pacte[dpl_type]}.png" title="{dpl_type[{pacte[dpl_type]}]}"/></td>
	<td>
		<a href="alliances-view.html?al_aid={pacte[dpl_al]}" title="{pacte[al_name]}">
		<img class="mini_al_logo" alt="{pacte[al_name]}" src="img/al_logo/{pacte[dpl_al]}-thumb.png" />
		{pacte[al_name]}</a>
	</td>
	<td>{pacte[dpl_debut]}</td>
	<td>{dpl_etat[{pacte[dpl_etat]}]}</td>
</tr>
</if>
</foreach>
</table>

<if cond='{act} != "histo"'>
	<p class="menu_module">[ <a href="diplo-histo.html?al1={al1}" title="Anciens pactes de l'alliance">Anciens pactes</a> ]</p>
</if>
<else>
	<p class="menu_module">[ <a href="diplo.html?aid={al1}" title="Pactes actuels de l'alliance">Pactes valides</a> ]</p>
</else>

<p class="infos">Seul le chef d'alliance ou le diplomate peuvent proposer un pacte à une autre alliance. Ils doivent pour cela passer par la <a href="alliances.html" title="Liste des Alliances">Liste des Alliances</a>.</p>

