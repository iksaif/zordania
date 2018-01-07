<if cond='isset({admin_array})'>
	Liste des modules qui ont une admin :
	<ul>
	<foreach cond='{admin_array} as {module}'>
		<li><a href="admin.html?module={module}"><math oper='ucfirst(strtolower({module}))' /></a></li>
	</foreach>
	</ul>
</if>
<elseif cond='isset({admin_tpl}) and {admin_tpl} AND {admin_name}'>
	Administration de : <math oper='ucfirst(strtolower({admin_name}))' /><br />
	<include file="{admin_tpl}" cache="1" />
</elseif>
<else><p class="infos">Administration, accès réservé</p></else>
