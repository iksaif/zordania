<p class="menu_module">
[ 
<a href="carte-lite.html" title="Version lite de la carte">Version Lite</a>
] - [ 
<a href="carte-ajax.html" title="Version AJAX de la carte">Version AJAX</a>
] - [
<a href="carte-rp.html" title="Version RP de la carte">Version Role Play</a>
]
<hr />
</p>



<if cond='{map_type} == "rp"'>
	<include file="modules/carte/carte_rp.tpl" cache="1" />
</if>
<elseif cond='{map_type} == "lite"'>
	<include file="modules/carte/carte_lite.tpl" cache="1" />
</elseif>
<elseif cond='{map_type} == "ajax"'>
	<include file="modules/carte/carte_ajax.tpl" cache="1" />
</elseif>
<elseif cond='{map_type} == "view"'>
	<include file="modules/carte/carte_view.tpl" cache="1" />
</elseif>