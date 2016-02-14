<if cond='{al_act} == "resally"'>
	<div class="infos">
	Vous pouvez donner des ressources à votre allié <a href="alliances-view.html?al_aid={arr_al2[al_aid]}" title="Infos sur {arr_al2[al_name]}">{arr_al2[al_name]}</a>, l'alliance de 
	<zurlmbr gid="{arr_al2[mbr_gid]}" mid="{arr_al2[al_mid]}" pseudo="{arr_al2[mbr_pseudo]}"/>,
	mais un certain pourcentage sera prélevé. (<a href="manual.html?page=10" title="Plus d'informations...">manuel</a>)
	<strong>Tout pillage d'alliance sera sévèrement puni !</strong>
	</div>
</if>

<else>
	<div class="infos">
	Pensez à ne pas laisser le grenier trop plein si vous acceptez des membres inconnus.
	<strong>Tout pillage d'alliance sera sévèrement puni !</strong>
	<br/>
	<em>Dépôt minimal: {ALL_MIN_DEP}. Une taxe de {ALL_TAX}% est prélevée sur ce que vous déposez au grenier.</em>
	</div>
	<div class="menu_module">
	[ <a href="alliances-reslog.html" title="Historique">Voir tout l'historique</a> -
	<a href="alliances-ressyn.html" title="Synthèse">Voir la synthèse</a> ]
	</div>
</else>

<if cond='{_user[aetat]} == {ALL_ETAT_NOOB}'>
	<div class="error">Les nouveaux membres ne peuvent pas utiliser le grenier avant
	{ALL_NOOB_TIME} jours.</div>
</if>
<elseif cond='{_user[aetat]} == {ALL_ETAT_NOP}'>
	<div class="error">Le chef de l'alliance vous a interdit l'accès au grenier !</div>
</elseif>
<else>
	<if cond="!empty({res_ok})">
		<p class="ok">Action Effectuée :
		<foreach cond="{res_ok} as {res_id} => {nb}"><zimgres type="{res_id}" race="{_user[race]}" />&nbsp;{nb} 
		</foreach>
		</p>
	</if>
	<if cond="!empty({res_limit})">
		<p class="error">
			<if cond='{al_sub}== "res"'>
Le grenier de l'alliance ne peut pas stocker plus de cette ressource, ou bien vous n'avez pas les ressources que vous voulez déposer :
			</if>
			<else>
Le grenier de votre allié ne peut pas stocker plus de cette ressource, ou bien votre grenier n'en possède pas la quantité demandée :
			</else>
			<foreach cond="{res_limit} as {res_id} => {nb}"><zimgres type="{res_id}" race="{_user[race]}" />&nbsp;Max={nb} 
			</foreach>
		</p>
	</if>
</else>

<if cond='{al_act} == "resally" and {al2} === false'>
	<div class="error">Vous n'avez pas signé un pacte commercial avec cette alliance !</div>
</if>
<elseif cond='{al_act} == "resally" and {al2} == 0 '>
	<div class="error">L'alliance alliée n'existe pas !</div>
</elseif>
<else>
	<hr />
	<form method="post" action="alliances-{al_act}.html">
	<table class="liste">
		<tr>
		<th>Ressource</th>
		<th>Grenier</th>
		<th>Maximum</th>
		<th>Actions</th>
		<if cond='{al_act} == "res"'><th>Stock perso</th>
		</if>
		</tr>
		<foreach cond="{liste_res} as {res_id} => {zero}">
		<tr>
			<td><zimgres type="{res_id}" race="{_user[race]}" />&nbsp;{res[{_user[race]}][alt][{res_id}]}</td>
			<td>&nbsp;<if cond="isset({res_array[{res_id}]})">{res_array[{res_id}]}</if></td>
			<td><if cond="{res_id} != 1">{_limite_grenier[{res_id}]}</if>
		        <else>Infini</else>
			</td>
		    <td><input type="text" name="res_nb[{res_id}]" value="0" /></td>
			<if cond='{al_act} == "res"'>
			<td>&nbsp;<if cond="isset({have_res[{res_id}]})">
				<zimgres type="{res_id}" race="{_user[race]}" /> &nbsp;{have_res[{res_id}]}</if>
			</td>
			</if>
		</tr>
		</foreach>
	</table>

	<if cond='{al_act} == "resally"'>
		<input type="hidden" name="al2" value="{al2}" size="6" />
		<input type="submit" name="get" value="Envoyer" />
	</if>
	<else>
		<input type="submit" name="put" value="Donner des ressources ! ( - {ALL_TAX} % )" />
		<input type="submit" name="get" value="Récupérer des ressources !" />
	</else>
	</form>
</else>

<hr/>
<h3>Dernières actions</h3>
<ul>
<foreach cond="{log_array} as {result}">
	<li>
	Le {result[arlog_date_formated]} -
	   <if cond="isset({result[mbr_gid]})">
		<zurlmbr gid="{result[mbr_gid]}" mid="{result[mbr_mid]}" pseudo="{result[mbr_pseudo]}"/>
	   	 -
	   </if>
	   <else>
		???? -
	   </else>

		<if cond="{result[arlog_nb]} > 0">
			<span class="gain">
		</if>
		<else>
			<span class="perte">
		</else>
		{result[arlog_nb]}
		</span>
		 <zimgres type="{result[arlog_type]}" race="{_user[race]}" />
	</li>
</foreach>
</ul>
<div class="menu_module">
[ <a href="alliances-reslog.html" title="Historique">Voir tout l'historique</a> -
<a href="alliances-ressyn.html" title="Synthèse">Voir la synthèse</a> ]
</div>
