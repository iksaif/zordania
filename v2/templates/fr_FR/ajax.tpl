<if cond='{_user[race]} >= 1'>
	<load file="race/{_user[race]}.config" />
	<load file="race/{_user[race]}.descr.config" />
</if>
<load file="config/config.config" />
<if cond='{cron_lock} == true'>
	<p class="infos">Calculs des tours en cours...</p>
</if>
<if cond='isset({need_to_be_loged})'>
	<p class="infos">Il faut se connecter pour accéder à cette partie du site.</p>
</if>
<if cond='{cant_view_this} == true'>
	<p class="infos">Vous n'avez pas les droits nécessaires pour voir cette partie du site.</p>
</if>

<elseif cond='isset({module_tpl})'><include file="{module_tpl}" cache="1" /></elseif>
