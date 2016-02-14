<h3> Message(s) signalé(s) </h3>

<if cond="{nb_sign}!=0"><p class="infos">Il y a {nb_sign} message(s) signalé(s) non pris en charge.
<a href="admin-maj.html?module=msg">Recalculer !</a></p></if>

<p>
<foreach cond="{arr_pge} as {i}">
	<if cond='{i} == {pge} || {i} == "..."'> {i} </if>
	<else> <a href="admin.html?module=msg&amp;pge={i}" title="page {i}">{i}</a> </else>
</foreach>
</p>

<table class="liste">
	<tr>
		<th>Destinataire</th>
		<th>Expéditeur</th>
		<th>Titre message</th>
		<th>Admin</th>
		<th>Date signalement</th>
		<th>Dernière action</th>
	</tr>
<foreach cond="{list_sign} as {value}">
	<tr>
		<td>
			<img src="img/groupes/{value[sign_to_gid]}.png" alt="{groupes[{value[sign_to_gid]}]}" title="{groupes[{value[sign_to_gid]}]}"/>
			<a href="admin-view.html?module=member&mid={value[mrec_mid]}" title="Plus d'infos Admin">{value[sign_to_pseudo]}</a>

		</td>
		<td>
			<img src="img/groupes/{value[mbr_gid]}.png" alt="{groupes[{value[mbr_gid]}]}" title="{groupes[{value[mbr_gid]}]}"/>
			<a href="admin-view.html?module=member&mid={value[mrec_from]}" title="Plus d'infos Admin">{value[mbr_pseudo]}</a>

		</td>

		<td><a href="admin-read.html?module=msg&amp;mrec_id={value[mrec_id]}" title="Lire ce message">{value[mrec_titre]}</a></td>
		<td><if cond='{value[sign_adm_pseudo]}=="aucun"'><p class="error">{value[sign_adm_pseudo]}</p></if>
			<else>{value[sign_adm_pseudo]}</else>
		</td>

		<td>{value[sign_debut]}</td>
		<td>{value[sign_fin]}</td>
	</tr>
</foreach>
</table>

<p>
<foreach cond="{arr_pge} as {i}">
	<if cond='{i} == {pge} || {i} == "..."'> {i} </if>
	<else> <a href="admin.html?module=msg&amp;pge={i}" title="page {i}">{i}</a> </else>
</foreach>
</p>

