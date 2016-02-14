<if cond='is_array(|{admin_array}|)'>
Liste des modules qui ont une admin :<br />

<foreach cond='|{admin_array}| as |{module}|'>
<a href="index.php?file=admin&amp;module={module}"><math oper='ucfirst(strtolower({module}))' /></a><br />
</foreach>
</if>
<elseif cond='|{admin_tpl}| AND |{admin_name}|'>
 Administration de : <a href="index.php?file=admin&amp;module={admin_name}"><math oper='ucfirst(strtolower({admin_name}))' /></a><br />
 <include file="{admin_tpl}" cache="1" />
</elseif>
