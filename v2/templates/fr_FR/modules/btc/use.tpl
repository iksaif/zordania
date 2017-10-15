<if cond='!isset({btc_act}) || {btc_act} == "list"'>
	<script type="text/javascript">
		var fortif = 0;
	</script>
	<div id="village">
		<foreach cond='{src_array} as {src_vars}'>
			<if cond="isset({src_conf[{src_vars[src_type]}][vlg]})">
				<zimgsrc race="{_user[race]}" type="{src_vars[src_type]}" class="btc" id="src_{src_vars[src_type]}" />
			</if>
		</foreach>

		<foreach cond='{btc_array} as {btc_vars}'>
			<if cond="{btc_vars[btc_type]} == {btc_max}">
				<script type="text/javascript">fortif = 1;</script>
			</if>
			<else>
			<a href="btc-use.html?btc_type={btc_vars[btc_type]}"><if cond="isset({btc_conf[{btc_vars[btc_type]}][limite]})"><set name="title" value="{btc[{_user[race]}][alt][{btc_vars[btc_type]}]} ({btc_vars[btc_nb]}/{btc_conf[{btc_vars[btc_type]}][limite]})" /></if>
				<else><set name="title" value="{btc[{_user[race]}][alt][{btc_vars[btc_type]}]} ({btc_vars[btc_nb]})" /></else>
				<img class="btc" id="btc_{btc_vars[btc_type]}" src="img/{_user[race]}/btc/{btc_vars[btc_type]}.png" alt="{btc[{_user[race]}][alt][{btc_vars[btc_type]}]}" title="{title}" /> 
			</a>
			</else>
		</foreach>
	</div>
	<script type="text/javascript" src="js/vlg.js"></script>
	<script type="text/javascript">
		Vlg.init({_user[race]}, fortif);
	</script>
</if>
<elseif cond='{btc_act} == "list2"'>
	<form action="alert('javascript!');" method="post" id="form_btc">
	<dl>
	<foreach cond='{btc_array} as {btc_vars}'>

		<set name="btc_vie" value="{btc_conf[{btc_vars[btc_type]}][vie]}" />
		<set name="btc_bid" value="{btc_vars[btc_id]}" />
		<dd>
			<label for="btc{btc_bid}"><input type="checkbox" name="bid[{btc_bid}]" id="btc{btc_bid}">
				<zimgbtc race="{_user[race]}" type="{btc_vars[btc_type]}" />
				{btc[{_user[race]}][alt][{btc_vars[btc_type]}]} 
			</label>

			[ <a href="btc-use.html?btc_type={btc_vars[btc_type]}" title="{btc[{_user[race]}][alt][{btc_vars[btc_type]}]}">Liste
			</a> - <a href="btc-use.html?btc_bid={btc_bid}&amp;sub=det" title="Détruire le Bâtiment et récupérer la moitié des ressources">Détruire</a>
			<if cond="{btc_vars[btc_etat]} == {BTC_ETAT_OK}">
				- <a href="btc-use.html?btc_bid={btc_bid}&amp;sub=des" title="Désactiver le Bâtiment">Désactiver</a>
			</if>
			<elseif cond="{btc_vars[btc_etat]} == {BTC_ETAT_DES} || {btc_vars[btc_etat]} == {BTC_ETAT_REP}">
				- <a href="btc-use.html?btc_bid={btc_bid}&amp;sub=act" title="Activer le Bâtiment">Activer</a>
			</elseif>
			<if cond="{btc_vars[btc_vie]} - {btc_vie} != 0 AND {btc_vars[btc_etat]} != {BTC_ETAT_REP}">
				- <a href="btc-use.html?btc_bid={btc_bid}&amp;sub=rep" title="Réparer le Bâtiment (le rend inutilisable durant la réparation)">Réparer</a>
			</if>
			]
			Solidité : <math oper='round(({btc_vars[btc_vie]} / ({btc_vie})*100))' /> % | Etat : {btc_etat[{btc_vars[btc_etat]}]}

			<zimgba2 per="{btc_vars[btc_vie]}" max="{btc_vie}" />&nbsp;<em>{btc_vars[btc_vie]}/{btc_vie}</em>

		</dd>
	</foreach>
	</dl>
	<!-- // URL détruire: sub = det
	désactiver : sub = des
	réparer : sub = rep
	activer : sub = act
	 -->
	<script type="text/javascript">
	function post_btc(act)
	{
		if(act=='det')
			if(confirm('Êtes vous sûr de vouloir supprimer un ou plusieurs bâtiments?')==false)
				return false;
		document.forms['form_btc'].action = "btc-use.html?sub="+act;
		document.forms['form_btc'].submit();
		return false;
	}
	</script>
	<br />
	<input type="hidden" name="ok" value="oui" />
	[ Pour la sélection : <a href="#" onclick="post_btc('det');">Détruire</a> -
	<a href="#" onclick="post_btc('des');">Désactiver</a> -
	<a href="#" onclick="post_btc('rep');">Réparer</a> -
	<a href="#" onclick="post_btc('act');">Activer</a> ]
	</form>
</elseif>
<elseif cond='{btc_act} == "det"'>
	<if cond='isset({btc_no_bid})'>
			<p class="error">Aucun bâtiment sélectionné.</p>
	</if>
	<elseif cond='{btc_ok}'>
		<if cond='{btc_det_ok}'>
			<p class="ok">Ok, Bâtiment détruit.</p>
		</if>
		<else>
			<p class="error">Ce bâtiment n'existe pas ou ne peut pas être détruit.</p>
		</else>
	</elseif>
	<else>
		Êtes-vous sûr de vouloir détruire ce bâtiment ?
		<form action="btc-use.html?sub=det" method="post">
			<foreach cond="{btc_bid} as {val} => {validation}">
				<input type="hidden" name="bid[{val}]" value="on" />
			</foreach>
			<input type="submit" name="ok" value="Oui" />
		</form>
	</else>
</elseif>
<elseif cond='{btc_act} == "mod_etat"'>
	<if cond='isset({btc_no_bid})'>
		<p class="error">Aucun bâtiment sélectionné.</p>
	</if>
	<elseif cond='{btc_mod_etat}'>
		<if cond='{btc_mod_etat} < 0'>
		    <p class="error">Impossible de désactiver un bâtiment qui donne un bonus.</p>
		</if>
		<else>
		    <p class="ok">Ok, action effectuée.</p>
		</else>
	</elseif>
	<else>
		<p class="error">Ce Bâtiment n'existe pas.</p>
	</else>
</elseif>
<elseif cond='{btc_act} == "no_btc"'>
	<br />
	<p class="error">Vous ne possédez pas encore le bâtiment pour effectuer cette action ({btc[{_user[race]}][alt][{btc_id}]}).
		<br/>Il est aussi possible que ce bâtiment soit en réparation ou inactif.</p>
</elseif>
<if cond='isset({btc_tpl})'>
	<h3>
	<zimgbtc race="{_user[race]}" type="{btc_id}" /> {btc[{_user[race]}][alt][{btc_id}]}</h3>
	{btc[{_user[race]}][descr][{btc_id}]} <hr />
	<br/>
	<p class="menu_module">
		<a href="btc-use.html?btc_type={btc_id}">Infos</a>
		<if cond="isset({btc_conf[prod_src]})">
			- <a href="btc-use.html?btc_type={btc_id}&amp;sub=src">{btcopt[{_user[race]}][{btc_id}][src]}</a>
		</if>
		<if cond="isset({btc_conf[prod_unt]})">
			- <a href="btc-use.html?btc_type={btc_id}&amp;sub=unt">{btcopt[{_user[race]}][{btc_id}][unt]}</a>
		</if>
		<if cond="isset({btc_conf[prod_res]})">
			- <a href="btc-use.html?btc_type={btc_id}&amp;sub=res">{btcopt[{_user[race]}][{btc_id}][res]}</a>
		</if>
		<if cond="isset({btc_conf[com]})">
			- <a href="btc-use.html?btc_type={btc_id}&amp;sub=my">Vos Ventes</a> 
			-
			<a href="btc-use.html?btc_type={btc_id}&amp;sub=ven">Vendre</a> 
			-
			<a href="btc-use.html?btc_type={btc_id}&amp;sub=ach">Acheter</a> 
			-
			<a href="btc-use.html?btc_type={btc_id}&amp;sub=cours" title="Cours moyens">Cours</a>
			-
			<a href="btc-use.html?btc_type={btc_id}&amp;sub=cours_sem" title="Cours sur la semaine">Cours de la Semaine</a>
		</if>
	</p>
	<include file="{btc_tpl}" cache="1" />
	<if cond="isset({btc_conf[prod_unt]})">
		<include file="modules/btc/inc/unt.tpl" cache="1" />
	</if>
	<if cond="isset({btc_conf[prod_src]})">
		<include file="modules/btc/inc/src.tpl" cache="1" />
	</if>
	<if cond="isset({btc_conf[prod_res]})">
		<include file="modules/btc/inc/res.tpl" cache="1" />
	</if>
	<if cond="isset({btc_conf[com]})">
		<include file="modules/btc/inc/com.tpl" cache="1" />
	</if>
	<if cond='{btc_act} == "infos"'>
		<include file="modules/btc/inc/info.tpl" cache="1" />
	</if>
</if>

<br />

<p class="retour_module">
	[ <a href="btc-use.html" title="Retour Au Village">Retour</a>
	]  
	<if cond="!isset({btc_id})">
		- [ <a href="btc-use.html?sub=list" title="Liste complète de tous les bâtiments">Liste complète</a> ]
	</if>
	<else>
 		- [ <a href="btc-use.html?btc_type={btc_id}&amp;sub=list" title="Liste complète des bâtiments de ce type">Liste</a> ]
	</else>
	- [ <a href="btc-use.html?sub=vue" title="Vue générale">Vue générale</a>
	]
</p>
