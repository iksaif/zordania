<if cond='{act} == "my" && {_user[achef]} && {act} != "histo"'>
	<h3>Pactes en attente de validation</h3>

		<table>
		<tr>
			<th>Pacte</th>
			<th>Alliance</th>
			<th>Depuis le</th>
			<th>Etat</th>
			<th>Actions</th>
		</tr>
		<foreach cond="{mespactes} as {did} => {pacte}">
		<if cond="{pacte[dpl_etat]} == DPL_ETAT_PROP or {pacte[dpl_etat]} == DPL_ETAT_ATT">
		<tr>
			<td><img src="img/dpl/{pacte[dpl_type]}.png" title="{dpl_type[{pacte[dpl_type]}]}"/></td>
			<td>
				<a href="alliances-view.html?al_aid={pacte[dpl_al]}" title="{pacte[al_name]}">
				<img class="mini_al_logo" alt="{pacte[al_name]}" src="img/al_logo/{pacte[dpl_al]}-thumb.png" />
				{pacte[al_name]}</a>
			</td>
			<td>{pacte[dpl_debut]}</td>
			<td>
				<if cond="{pacte[dpl_etat]} == DPL_ETAT_ATT">En attente d'acceptation...
					<if cond="{_user[achef]}"><a href="diplo-no.html?did={did}"><img alt="Annuler" src="img/dpldrop.png" tip="Annuler"/></a></if>
				</if>
				<else>{dpl_etat[{pacte[dpl_etat]}]}
				<br/><em>proposé par <if cond="{pacte[me]}">nous</if><else>eux</else></em>
				</else>
			</td>
			<td>
				<if cond="{_user[achef]}">
					<if cond="{pacte[me]} == false"><a href="diplo-ok.html?did={did}"><img alt="Accepter" src="img/join.png" tip="Accepter"/></a></if>
					<a href="diplo-no.html?did={did}"><img alt="Refuser" src="img/dpldrop.png" tip="Refuser"/></a>
				</if>
				<a href="msg-new.html?mbr_mid={pacte[al_mid]}" title="Envoyer un message au chef de {pacte[al_name]}">
				<img src="img/msg.png" alt="Msg" />
				</a>
			</td>
		</tr>
		</if>
		</foreach>
		</table>

	<if cond='{act} != "histo"'><h3>Pactes validés</h3></if>
	<else><h3>Anciens Pactes</h3></else>
</if>

<table>
<tr>
	<th>Pacte</th>
	<th>Alliance</th>
	<th>Depuis le</th>
	<th>Etat</th>
	<th>Actions</th>
</tr>
<foreach cond="{mespactes} as {did} => {pacte}">
<if cond='{pacte[dpl_etat]} != DPL_ETAT_PROP and ({act}=="histo" xor {pacte[dpl_etat]} == DPL_ETAT_OK)'>
<tr>
	<td><img src="img/dpl/{pacte[dpl_type]}.png" title="{dpl_type[{pacte[dpl_type]}]}"/></td>
	<td>
		<a href="alliances-view.html?al_aid={pacte[dpl_al]}" title="{pacte[al_name]}">
		<img class="mini_al_logo" alt="{pacte[al_name]}" src="img/al_logo/{pacte[dpl_al]}-thumb.png" />
		{pacte[al_name]}</a>
	</td>
	<td>{pacte[dpl_debut]}</td>
	<td>{dpl_etat[{pacte[dpl_etat]}]}
		<br/><em>proposé par <if cond="{pacte[me]}">nous</if><else>eux</else></em>
	</td>
	<td>
		<if cond="{_user[achef]} && ({pacte[dpl_etat]} == DPL_ETAT_ATT || {pacte[dpl_etat]} == DPL_ETAT_OK)">
			<a href="diplo-del.html?did={did}"><img alt="Rompre le pacte!" src="img/dpldrop.png" tip="Rompre"/></a>
			<if cond="{pacte[dpl_type]} == DPL_TYPE_COM or {pacte[dpl_type]} == DPL_TYPE_MC">
				<a href="alliances-resally.html?al2={pacte[dpl_al]}"><img alt="Soutient matériel" src="img/1/res/1.png" tip="Soutient matériel"/></a>
			</if>
		</if>
		<a href="msg-new.html?mbr_mid={pacte[al_mid]}" title="Envoyer un message au chef de {pacte[al_name]}">
		<img src="img/msg.png" alt="Envoyer un message au chef de {pacte[al_name]}" /></a>
		<a href="diplo-shoot.html?did={did}" title="Ecrire à l'ensemble des membres de {pacte[al_name]}">
		<img src="img/dpl/shoot.png" alt="Ecrire à l'ensemble des membres de {pacte[al_name]}" />
		</a>
	</td>
</tr>
</if>
</foreach>
</table>

<if cond='{act} != "histo"'>
	<p class="menu_module">[ <a href="diplo-histo.html" title="Anciens pactes de l'alliance">Anciens pactes</a> ]</p>
</if>

<p class="infos">Seul le chef d'alliance peut proposer un pacte à une autre alliance. Il doit pour cela passer par la <a href="alliances.html" title="Liste des Alliances">Liste des Alliances</a>.</p>

