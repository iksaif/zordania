<?xml version="1.0" encoding="utf-8"?>
<post>
<if cond='isset({post})'>
	<foreach cond="{post} as {key} => {value}">
	<{key}><math oper="htmlspecialchars({value})"/></{key}>
	</foreach>
</if>
<elseif cond="isset({noperm})">
	<message>Accès interdit !</message>
</elseif>
<else>
	<message>Message inexistant !</message>
</else>
</post>
