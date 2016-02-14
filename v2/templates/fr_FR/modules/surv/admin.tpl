<div class="menu_module">
[ <a href="admin.html?module=surv" title="Liste des surveillances en cours">Membres</a> ]
[ <a href="admin-msg.html?module=msg" title="Messages signalés">Messages</a> ]
</div>
<hr/>

<if cond="isset({no_sid})">
	<p class="error">Vous n'avez pas choisi de surveillance</p>
</if>
<if cond="isset({close_surv})">
	<p class="ok">Surveillance terminee.</p>
</if>
<if cond="isset({no_member})">
	<p class="error">Vous n'avez pas choisi de membre.</p>
</if>
<if cond="isset({add_surv})">
	<p class="ok">Surveillance ajoutee. Big Brother active.</p>
</if>
<if cond="isset({all_assign})">
	<p class="error">Une surveillance est déjà activee pour ce membre.</p>
</if>
<if cond="isset({no_surv_admin})">
	<p class="error">Impossible de surveiller un admin.</p>
</if>

<if cond='{act} == "new"'>
	<include file='modules/surv/new.tpl' cache='1' />
</if>
<elseif cond='{act} == "msg"'>
	<include file='modules/surv/msg.tpl' cache='1' />
</elseif>
<elseif cond='isset({view_surv})'>
	<if cond="isset({info_ally})">
		<fieldset>
			<legend>Surveillance du Grenier</legend>
			<p onclick="javascript:displayToggle(document.getElementById('grenier')); return false;"><img src="img/info.png" alt="Info" title="Info" /> Voir</p>
			<div id="grenier" style="display: none;">
				<if cond="empty({info_ally})">
					<p class="error">Aucune action sur le grenier.</p>
				</if>
				<else>
				<foreach cond="{info_ally} as {result}">
					<li<if cond="{result[mbr_mid]} == {srv_mid}"> class="infos"</if>>
						Le {result[arlog_date_formated]} - 
						<if cond="isset({result[mbr_gid]})">
							<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
						</if>
						<a href="member-view.html?mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
						(Ip: <a href="admin-liste_ip.html?module=member&ip={result[arlog_ip]}">{result[arlog_ip]}</a>)
						-
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
				</else>
			</div>
		</fieldset>
	</if>

	<if cond="isset({mbr_array})">
		<fieldset>
			<legend>Surveillance de l'Ip</legend>
				<p onclick="javascript:displayToggle(document.getElementById('ip')); return false;"><img src="img/info.png" alt="Info" title="Info" /> Voir</p>
				<div id="ip" style="display: none;">
					<if cond='{mbr_array}'>
						<h3>IP connues des dernières connexions</h3>
						<set name='temp_lip' value='' />
						<foreach cond='{mbr_array} as {key} => {mbr_value}'>
							<if cond='{temp_lip} != {mbr_value[mbr_lip]}'>
								<if cond="{temp_lip}"></table></if>
								<set name='temp_lip' value='{mbr_value[mbr_lip]}' />
								<h3>{mbr_value[mbr_lip]} <!-- math oper="@gethostbyaddr({mbr_value[mbr_lip]})" />--></h3>
						
								<table class="liste">
									<tr>
										<th>Pseudo</th>
										<th>lDate</th>
										<th>Mail</th>
										<th>Login</th>
									</tr>
							</if>
							<tr>
								<td><a href="admin-view.html?module=member&mid={mbr_value[mbr_mid]}" title="Infos sur {mbr_value[mbr_pseudo]}">{mbr_value[mbr_pseudo]}</a></td>
								<td>{mbr_value[mbr_ldate]}</td>
								<td>{mbr_value[mbr_mail]}</td>
								<td>{mbr_value[mbr_login]}</td>
							</tr>
						</foreach> 
						</table>
					</if>
					<if cond="!empty({log_ip})">
						<h3>Log des connexions précédentes sur cette IP {log_ip[0][mlog_ip]}</h3>
						<table class="liste">
						<tr>
							<th>Pseudo</th>
							<th>Date de connexion</th>
							<th>Mail</th>
						</tr>
						<foreach cond="{log_ip} as {ip}">
							<if cond="{ip[mbr_gid]}==0">
								<tr class="infos">
									<td><img src="img/surv.png" alt="old" /><a href="admin-old.html?module=member" title="Infos sur {ip[mbr_pseudo]}">{ip[mbr_pseudo]}</a></td>
									<td>{ip[mlog_date]}</td>
									<td>{ip[mbr_mail]}</td>
								</tr>
							</if>
							<else>
								<tr>
									<td><a href="admin-view.html?module=member&mid={ip[mlog_mid]}" title="Infos sur {ip[mbr_pseudo]}"><img src="img/groupes/{ip[mbr_gid]}.png" alt="{groupes[{ip[mbr_gid]}]}" title="{groupes[{ip[mbr_gid]}]}"/> {ip[mbr_pseudo]}</a></td>
									<td>{ip[mlog_date]}</td>
									<td>{ip[mbr_mail]}</td>
								</tr>
							</else>
						</foreach> 
						</table>
					</if>
				</div>
		</fieldset>
	</if>

 	<if cond="isset({info_mp})">
		<fieldset> 
			<legend>Surveillance des Mps</legend>
			<p onclick="javascript:displayToggle(document.getElementById('mp')); return false;"><img src="img/info.png" alt="Info" title="Info" /> Voir</p>
			<div id="mp" style="display: none;">
				<if cond="empty({info_mp})">
					<p class="error">Aucun message envoye recemment.</p>
				</if>
				<else>
					<table class="liste">
						<tr>
							<th>Destinataire</th>
							<th>Titre</th>
							<th>Date</th>
						</tr>
						<foreach cond='{info_mp} as {result}'>
							<tr>
								<td>
									<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
									<a href="member-view.html?mid={result[menv_to]}" title="Infos sur {result[mbr_pseudo]}"> {result[mbr_pseudo]}</a>
								</td>
								<td>
									<a href="admin.html?module=surv&act=view&msg_id={result[menv_id]}&msg_mid={result[menv_mid]}" title="Lire ce message">{result[menv_titre]}</a>
								</td>
								<td>{result[menv_date_formated]}</td>
							
							</tr>
						</foreach>
					</table>
				</else>
			</div>
		</fieldset>
	</if>
	<if cond="isset({srv_mid})">
		<fieldset>
			<legend>Surveillance des messages sur le Forum</legend>
			<a href="forum-search.html?action=show_user&user_id={srv_mid}">Voir tout les messages sur le forum</a>
		</fieldset>
	</if>
</elseif>

<elseif cond="isset({array_msg})">
	<foreach cond="{array_msg} as {value}">
		<h4>{value[menv_titre]}</h4>
		<img src="img/mbr_logo/{value[menv_to]}.png" title="{value[mbr_pseudo]}" class="blason" />
		Envoyés :
		<img src="img/groupes/{value[mbr_gid]}.png" alt="{groupes[{value[mbr_gid]}]}" title="{groupes[{value[mbr_gid]}]}"/>
		<a href="member-view.html?mid={value[menv_to]}" title="infos sur {value[mbr_pseudo]}">{value[mbr_pseudo]}</a>
		le {value[menv_date_formated]}
				
		<div class="block">
				{value[menv_texte]}
		</div>
	</foreach>
</elseif>

<else>
<h3> Surveillance(s) en cours </h3>
<if cond="!empty({list_surv})">
<table class="liste">
	<tr>
		<th>Pseudo</th>
		<th>Par</th>
		<th>Date</th>
		<th>Type</th>
		<th>Cause</th>
		<th>Action</th>
	</tr>
<foreach cond="{list_surv} as {value}">
	<tr>
		<th><img src="img/surv.png" alt="Surveillance" /> <a href="admin-view.html?module=member&mid={value[surv_mid]}">{value[surv_pseudo]}</a></th>
		<th><a href="admin-view.html?module=member&mid={value[surv_admin]}">{value[surv_adm_pseudo]}</a></th>
		<th>{value[surv_debut]}</th>
		<th>{array_type[{value[surv_type]}]}</th>
		<th>{value[surv_cause]}</th>
		<th><a href="admin-view.html?module=surv&act=view&sid={value[surv_id]}">Voir</a> - <a href="admin-del.html?module=surv&act=close&sid={value[surv_id]}"><img src="img/drop.png" alt="Clore" /></a></th>
	</tr>
</foreach>
</table>
</if>
<else><p class="infos">Aucune surveillance en cours.</p></else>

<h3> Surveillance(s) finie(s) depuis moins d'un mois </h3>
<table class="liste">
	<tr>
		<th>Pseudo</th>
		<th>Par</th>
		<th>Date de fin</th>
		<th>Type</th>
		<th>Cause</th>
	</tr>
<foreach cond="{list_fin_surv} as {value}">
	<tr>
		<th><img src="img/surv.png" alt="Surveillance" /> <a href="admin-view.html?module=member&mid={value[surv_mid]}">{value[surv_pseudo]}</a></th>
		<th><a href="admin-view.html?module=member&mid={value[surv_admin]}">{value[surv_adm_pseudo]}</a></th>
		<th>{value[surv_fin]}</th>
		<th>{array_type[{value[surv_type]}]}</th>
		<th>{value[surv_cause]}</th>
	</tr>
</foreach>
</table>

</else>	
