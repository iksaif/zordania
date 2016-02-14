<if cond='!{btc_act}'>
	
	<table class="liste">
		<tr>
			<td class="block">
				<h4>Unités en formation</h4>
				<if cond='{unt_todo}'>
					<foreach cond='{unt_todo} as {unt_result}'>
						<set name="unt_type" value="{unt_result[utdo_type]}" />
						<img src="img/{_user[race]}/unt/{unt_type}.png" alt="{unt[{_user[race]}][alt][{unt_type}]}" title="{unt[{_user[race]}][alt][{unt_type}]}" /> {unt[{_user[race]}][alt][{unt_type}]} - {unt_result[utdo_nb]} - <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_unt&amp;uid={unt_result[utdo_id]}">Annuler</a><br />
					</foreach>
				</if>
				<else>
					Aucune unité en formation.
				</else>
			</td>
			
			<td class="block">
				<h4>Recherches en cours</h4>
				<if cond='{src_todo}'>
					<foreach cond='{src_todo} as {src_type} => {src_result}'>
						<img src="img/{_user[race]}/src/{src_type}.png" alt="{src[{_user[race]}][alt][{src_type}]}" title="{src[{_user[race]}][alt][{src_type}]}" /> {src[{_user[race]}][alt][{src_type}]} -  <a href="index.php?file=btc&amp;act=use&amp;btc_type={btc_id}&amp;sub=cancel_src&amp;sid={src_result[stdo_type]}">Annuler</a><br />
						<div class="barres_moyennes">
							<div style="width:<math oper='floor(100-({src_result[stdo_tours]} / {src_conf[{src_type}][tours]})*100)' />%" class="barre_verte"></div>
							<div style="width:<math oper='floor((({src_result[stdo_tours]} / {src_conf[{src_type}][tours]})*100))' />%" class="barre_rouge"></div>
						</div> &nbsp;<em><math oper='round(100-({src_result[stdo_tours]} / ({src_conf[{src_type}][tours]})*100))' />%</em>
						<br /><br />
					</foreach>
				</if>
				<else>
					Aucune recherche en cours.
				</else>
			</td>
		</tr>
	</table>
</if>