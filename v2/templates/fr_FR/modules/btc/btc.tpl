<if cond='!{btc_trav}'>
	<p class="error">Vous n'avez aucun {unt[{_user[race]}][alt][1]} !</p>
	<hr />
</if>
<else>
	<p class="menu_module">Vous avez {btc_trav} <zimgunt type="1" race="{_user[race]}" /> disponibles.</p>
</else>

<if cond='{btc_act} == "cancel"'><# annuler construction #>
	<if cond='isset({btc_no_bid})'>
		<p class="error">Aucun bâtiment sélectionné.</p>
	</if>
	<elseif cond='{can_btc_ok}'>
		<p class="ok">Ok, construction annulée.</p>
	</elseif>
	<else>
		<p class="error">Ce bâtiment n'existe pas.</p>
	</else>
</if>

<elseif cond='{btc_act} == "btc"'><# débuter construction #>
	<if cond="isset({btc_no_type})">
		<p class="error">Ce bâtiment n'existe pas.</p>
	</if>
	<elseif cond="isset({another_btc})">
		<p class="error">Il y a déjà d'autres bâtiments en construction ! Vous ne pouvez planifier que {TODO_MAX_BTC} constructions simultanées.</p>
	</elseif>
	<elseif cond="!{const_btc_ok}">
		<p class="error">Impossible de construire ce bâtiment !<br/>
			<foreach cond="{btc_infos[prix_res]} as {res_type} => {res_nb}">
				{res_nb}<img src="img/{_user[race]}/res/{res_type}.png" alt="{res[{_user[race]}][alt][{res_type}]}" title="{res[{_user[race]}][alt][{res_type}]}" />
			</foreach>
			<foreach cond="{btc_infos[prix_trn]} as {trn_type} => {trn_nb}">
				{trn_nb}<img src="img/{_user[race]}/trn/{trn_type}.png" alt="{trn[{_user[race]}][alt][{trn_type}]}" title="{trn[{_user[race]}][alt][{trn_type}]}" />
			</foreach>
			<foreach cond="{btc_infos[prix_unt]} as {unt_type} => {unt_nb}">
				{unt_nb}<img src="img/{_user[race]}/unt/{unt_type}.png" alt="{unt[{_user[race]}][alt][{unt_type}]}" title="{unt[{_user[race]}][alt][{unt_type}]}" />
			</foreach>
			<if cond="{btc_infos[limit_btc]}">
				Limite: {btc_infos[limit_btc]}
			</if>
		</p>
	</elseif>
	<else>
		<p class="ok">Bâtiment en construction.</p>
	</else>
</elseif>

<if cond="isset({btc_todo})">
	Bâtiment en construction : <br />
	<div class="block">
	<foreach cond='{btc_todo} as {btc_infos}'>
		<set name="btc_conf_type" value="{btc_conf[{btc_infos[btc_type]}]}" />
		<h3><zimgbtc type="{btc_infos[btc_type]}" race="{_user[race]}" style="align: left" /> {btc[{_user[race]}][alt][{btc_infos[btc_type]}]}</h3>
		Temps restant : 
		<if cond="{btc_trav}">
			<math oper='ceil((({btc_conf_type[vie]}-{btc_infos[btc_vie]}) / {btc_conf_type[vie]}) * {btc_conf_type[tours]} / {btc_trav})' /> Tour(s)</if>
		<else>Aucun {unt[{_user[race]}][alt][1]} </else> - 
		<a href="btc-btc.html?sub=cancel&amp;bid={btc_infos[btc_id]}" title="Annuler la construction">Annuler</a><br/>

		<zimgba3 per="{btc_infos[btc_vie]}" max="{btc_conf_type[vie]}" /> &nbsp;<em><math oper='floor(100-({btc_conf_type[vie]}-{btc_infos[btc_vie]}) / {btc_conf_type[vie]}*100)' />%</em>
		<br />
	</foreach>
	</div>
</if>

<if cond='isset({btc_const})'>
	<div class="infos">
		Vous ne pouvez construire que les bâtiments pour lesquels vous disposez des unités et des ressources nécessaires.
		<br/>
		Vous ne pouvez voir que les bâtiments pour lesquels vous disposez des recherches et des bâtiments nécessaires.
		<br/>
		Chaque bâtiment ne peut être construit qu'un nombre de fois limité.
		<br/>
		Vous pouvez planifier jusqu'à {TODO_MAX_BTC} constructions simultanées.
		<br/>
		Pour plus d'informations, lire le <a href="manual.html" title="Lire le Manuel">manuel</a>.
	</div>
	
	<h3>Constructibles</h3>
	<dl>
		<foreach cond='{btc_ok} as {btc_id} => {btc_array}'>
			<include file="modules/btc/btc_infos.tpl" cache="1" />
		</foreach>
	</dl>
<h3>Autres</h3>
	<dl>
		<foreach cond='{btc_bad} as {btc_id} => {btc_array}'>
			<include file="modules/btc/btc_infos.tpl" cache="1" />
		</foreach>
	</dl>
<h3>Limite atteinte ou manque de terrain</h3>
	<dl>
		<foreach cond='{btc_limit} as {btc_id} => {btc_array}'>
			<include file="modules/btc/btc_infos.tpl" cache="1" />
		</foreach>
	</dl>
</if>

