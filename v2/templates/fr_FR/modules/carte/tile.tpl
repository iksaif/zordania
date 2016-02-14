<if cond="isset({result}) && {result}">

	<table class="liste"><tr><td style="width: 50%">
	<if cond='{result[map_type]} != {MAP_VILLAGE}'>
		<set name='case_img' value='{result[map_climat]}/{result[map_type]}/{result[map_rand]}' />
	</if>
	<else>
		<if cond='{result[mbr_points]} > {MBR_NIV_2}'><set name="etat_mbr" value="3" /></if>
		<elseif cond='{result[mbr_points]} > {MBR_NIV_1}'><set name="etat_mbr" value="2" /></elseif>
		<else><set name="etat_mbr" value="1" /></else>
		<set name='case_img' value='{result[map_climat]}/{result[map_type]}/{result[mbr_race]}/{etat_mbr}' />
	</else>

	<img class="blason" src="img/map/tiles/{case_img}.png" alt="{carte[alt][{result[map_climat]}][{result[map_type]}]}" />
	<br/>
	<if cond="{result[map_rand]} % MAP_MODULO == MAP_MOD_EGERIA">
		<h3>Egeria</h3>
		<a href="/manual-egeria.html">La Capitale de Zordania</a><br/>
	</if>

	<else>
		<h3>{carte[alt][{result[map_climat]}][{result[map_type]}]}</h3>
	</else>

	Position: {result[map_x]}*{result[map_y]}<br/>
	Distance: {result[map_dst]}<br/>
	Région: {regions[{result[map_region]}][descr]}<br/>

	<if cond='{result[mbr_mid]}'>
		</td><td style="width: 50%">
		<h3>Membre</h3>
		Village de <img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
		<a href="member-<math oper="str2url({result[mbr_pseudo]})"/>.html?mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a><br/>
		Points: {result[mbr_points]} <br/>
		Race: <img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/>
		<if cond='isset({result[can_atq]}) && {result[can_atq]}'>
		<div class="menu_module">[ <a href="leg-move.html?sub=atq&amp;cid={result[map_cid]}" title="Attaquer">Attaquer</a> ]</div>
		</if>
		<if cond='isset({result[can_pro]}) && {result[can_pro]}'>
		<div class="menu_module">[ <a href="leg-move.html?sub=sou&amp;cid={result[map_cid]}" title="Protéger">Envoyer des renforts</a> ]</div>
		</if>
	</if>
	</tr></td></table>

	<if cond="isset({result_leg}) && {result_leg}">
		<h3>Légions</h3>
		<table class="liste">
		<thead>
			<th>Pseudo</th>
			<th>Légion</th>
			<th>Etat</th>
			<th>Actions</th>
		</thead>
		<tbody>
		<foreach cond="{result_leg} as {value}">
			<if cond="{value[hro_bonus]} != {CP_INVISIBILITE}">
			<tr>
			<td>
				<img src="img/groupes/{value[mbr_gid]}.png" alt="{groupes[{value[mbr_gid]}]}" title="{groupes[{value[mbr_gid]}]}"/>
				<a href="member-<math oper="str2url({value[mbr_pseudo]})"/>.html?mid={value[mbr_mid]}" title="Infos sur {value[mbr_pseudo]}">{value[mbr_pseudo]}</a>
				<img src="img/{value[mbr_race]}/{value[mbr_race]}.png" title="{race[{value[mbr_race]}]}" alt="{race[{value[mbr_race]}]}"/>
			</td>
			<td>
				<if cond="{value[leg_mid]} == {_user[mid]}">{value[leg_name]}</if>
			</td>
			<td>{leg_etat[{value[leg_etat]}]}</td>
			<td>
			<if cond='{value[leg_mid]} == {_user[mid]}'>
				<if cond="{value[leg_cid]} != {_user[mapcid]}">
					[ <a href="leg-move.html?sub=sou&amp;cid={_user[mapcid]}&amp;lid={value[leg_id]}" title="ramener la légion au village">rentrer</a> ]
				</if>
				<if cond="{value[leg_etat]} == {LEG_ETAT_POS} ">
					- [ <a href="leg-view.html?lid={value[leg_id]}">attaquer</a> ]
				</if>
			</if>
			</td>
			</tr>
		</if>
		</foreach>
		</tbody>
		</table>
	</if>

</if>
<else>
	<p class="error">Cet endroit n'existe pas.</p>
</else>
