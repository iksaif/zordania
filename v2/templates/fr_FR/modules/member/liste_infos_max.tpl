<if cond="{_user[race]} != {mbr_array[mbr_race]}">
	<load file="race/{mbr_array[mbr_race]}.config" />
	<load file="race/{mbr_array[mbr_race]}.descr.config" />
</if>

<if cond="isset({edit_res})"><p class="ok">Ressources éditées : 
	<foreach cond="{edit_res} as {res_type} => {res_nb}">{res_nb} <zimgres race="{mbr_array[mbr_race]}" type="{res_type}" />.
	</foreach></p>
</if>

<if cond="isset({mbr_array[pts]})">
	<h3>Debug comptage des points</h3>
	<ul class="infos">
	<li>{mbr_array[pts][src][nb]} Recherches (coef = {mbr_array[pts][src][coef]}) = {mbr_array[pts][src][pts]}</li>
	<li>{mbr_array[pts][btc][nb]} Bâtiments (vie={mbr_array[pts][btc][vie]}) = {mbr_array[pts][btc][pts]}</li>
	<li><if cond="{hro_array[hro_id]}"> XP heros = {hro_array[hro_xp]}</if><else>aucun héros</else></li>
	<li>unités = {mbr_array[pts][unt][pts]} points. Détail (nb x pts = total) (les civils ne comptent pas)</li>
	<li><foreach cond="{unt_done} as {value}">
	{value[unt_sum]}<zimgunt type="{value[unt_type]}" race="{mbr_array[mbr_race]}" /> x {value[pts]} = {value[total]} /
	</foreach>
	</li>
	<li>Armée = <math oper="{mbr_array[pts][unt][pts]}+(isset({hro_array[hro_xp]})?{hro_array[hro_xp]}:0)" /> / Total = <math oper="{mbr_array[pts][src][pts]}+{mbr_array[pts][btc][pts]}+{mbr_array[pts][unt][pts]}+(isset({hro_array[hro_xp]})?{hro_array[hro_xp]}:0)" /></li>
	</ul>
</if>

<div class="content" id="infos_leg" style="display: none;">
	<a name="leg"></a><hr />
	<if cond="isset({lres_ok})"><p class="ok">Ressources de la légion vidées.</p></if>
	<include file="modules/member/leg_list.tpl" cache="1" />
</div>


<div class="content" id="infos_res" style="display: none;">
	<a name="res" /><h3>Ressources :</h3>
	<table class="liste">
	<tr>
		<td>
			<h4>Finies</h4>
			<if cond='{res_done}'>
				<form action="admin-view.html?module=member&amp;mid={mbr_array[mbr_mid]}" method="post" />
					<table class="liste">
					<tr>
						<th>Type</th>
						<th>Nombre</th>
						<th>Ajouter</th>
					</tr>
					<foreach cond='{res_done} as {res_type} => {res_nb}'>
					<tr>
						<td><zimgres race="{mbr_array[mbr_race]}" type="{res_type}" /></td>
						<td>{res_nb}</td>
						<td><input type="text" id="res{res_type}" name="add_res[{res_type}]" size="8" /></td>
					</tr>
					</foreach>
					</table>
					<input type="submit" name="ok" value="Ajouter" />
				</form>
			</if>
			<else>
				Rien
			</else>
		</td>
		<td>
			<h4>En Cours</h4>
			<if cond='{res_todo}'>
			<table class="liste">
			<tr>
				<th>Type</th>
				<th>Nombre</th>
			</tr>
			<foreach cond='{res_todo} as {res_array}'>
			<tr>
				<td><zimgres race="{mbr_array[mbr_race]}" type="{res_array[rtdo_type]}" /></td>
				<td>{res_array[rtdo_nb]}</td>
			</tr>
			</foreach>
			</table>
			</if>
			<else>
				Rien
			</else> 
		</td>
	</tr>
	</table>
</div>


<div class="content" id="infos_trn" style="display: none;">
	<a name="trn" /><h3>Terrains :</h3>
	<table class="liste">
	<tr>
		<td>
		<h4>Finis</h4>
		<if cond='{trn_done}'>
			<table class="liste">
			<tr>
				<th>Type</th>
				<th>Nombre</th>
			</tr>
			<foreach cond='{trn_done} as {trn_type} => {trn_nb}'>
			<tr>
				<td><zimgtrn race="{mbr_array[mbr_race]}" type="{trn_type}" /></td>
				<td>{trn_nb}</td>
			</tr>
			</foreach>
			</table>
		</if>
		<else>
			Rien
		</else>
		</td>
	</tr>
	</table>
</div>


<div class="content" id="infos_src" style="display: none;">
	<debug print="{src_done}" />
	<a name="src" /><h3>Recherches :</h3>
	<table class="liste">
	<tr>
		<td>
			<h4>Finies</h4>
			<if cond='{src_done}'>
			<table class="liste">
				<tr>
					<th>Type</th><th>Type</th><th>Type</th>
				</tr>
				<tr>
				<foreach cond='{src_done} as {key} => {src_array}'>
					<set name="src_type" value="{src_array[src_type]}" />
					<td><zimgsrc race="{mbr_array[mbr_race]}" type="{src_array[src_type]}" /></td>
					<if cond="({key}+1)%3==0"></tr><tr>
					</if>
				</foreach>
				</tr>
			</table>
			</if>
			<else>
				Rien
			</else>
		</td>
		<td>
			<h4>En Cours</h4>
			<if cond='is_array({src_todo})'>
			<table class="liste">
				<tr>
					<th>Type</th>
					<th>Tours</th>
				</tr>
				<foreach cond='{src_todo} as {src_array}'>
				<tr>
					<td><zimgsrc race="{mbr_array[mbr_race]}" type="{src_array[stdo_type]}" /></td>
					<td>{src_array[stdo_tours]}</td>
				</tr>
				</foreach>
			</table>
			</if>
			<else>
				Rien
			</else> 
		</td>
	</tr>
	</table>
</div>


<div class="content" id="infos_btc" style="display: none;">
	<debug print="{btc_done}" />
	<a name="bat" /><h3>Bâtiments :</h3>
	<table class="liste">
	<tr>
		<td>
			<h4>Finis</h4>
			<if cond='is_array({btc_done})'>
			<table class="liste">
			<tr>
				<th>Type</th>
				<th>Nombre / maxi</th>
				<th>unités</th>
			</tr>
			<foreach cond='{btc_done} as {btc_array}'>
			<tr>
				<td><zimgbtc race="{mbr_array[mbr_race]}" type="{btc_array[btc_type]}" />({btc_array[btc_type]})</td>
				<td>{btc_array[btc_nb]}
				<if cond='isset({conf_btc[{btc_array[btc_type]}][limite]})'> / {conf_btc[{btc_array[btc_type]}][limite]}</if>
				</td>
				<td>
				<if cond='isset({conf_btc[{btc_array[btc_type]}][prix_unt]})'>
					<foreach cond="{conf_btc[{btc_array[btc_type]}][prix_unt]} as {bunt} => {nb}">
						{nb}<zimgunt race="{mbr_array[mbr_race]}" type="{bunt}" />
					</foreach>
				</if>
				</td>
			</tr>
			</foreach>
			</table>
			</if>
			<else>
				Rien
			</else>
		</td>
		<td>
			<h4>En Cours</h4>
			<if cond='{btc_todo}'>
				<table class="liste">
				<tr>
					<th>Type</th>
					<th>Vie</th>
				</tr>
				<foreach cond='{btc_todo} as {btc_array}'>
				<tr>
					<td><zimgbtc race="{mbr_array[mbr_race]}" type="{btc_array[btc_type]}" /></td>
					<td>{btc_array[btc_vie]}</td>
				</tr>
				</foreach>
				</table>
			</if>
			<else>
				Rien
			</else> 
		</td>
	</tr>
	</table>
</div>


<div class="content" id="infos_unt" style="display: none;">

	<a name="unt" /><h3>Unités :</h3>
	<table class="liste">
	<tr>
		<td>
			<h4>dans les bâtiments</h4>			
			<table class="liste">
				<tr>
					<th>Unité</td>
					<th>théorique</th>
					<th>différence</th>
				</tr>
				<foreach cond="{leg_bat_diff} as {type} => {nb}">
				<tr>
					<td><if cond="isset({leg_bat_reel[{type}]})">{leg_bat_reel[{type}]}</if>
					<else>0</else><zimgunt race="{mbr_array[mbr_race]}" type="{type}" />({type})</td>
					<td><if cond="isset({leg_bat_th[{type}]})">{leg_bat_th[{type}]}</if></td>
					<td><if cond="{nb}==0">{nb}</if>
						<else><span class="red">{nb}</span></else>
					</td>
				</tr>
				</foreach>
			</table>
		</td>
		<td>
			<h4>En Cours</h4>
			<if cond='{unt_todo}'>
			<table class="liste">
				<tr>
					<th>Type</th>
					<th>Nombre</th>
				</tr>
				<foreach cond='{unt_todo} as {unt_array}'>
				<tr>
					<td><zimgunt race="{mbr_array[mbr_race]}" type="{unt_array[utdo_type]}" /></td>
					<td>{unt_array[utdo_nb]}</td>
				</tr>
				</foreach>
			</table>
			</if>
			<else>
				Rien
			</else> 
		</td>
	</tr>
	</table>
</div>
