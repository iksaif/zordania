<p class="menu_module">
[ 
<a href="index.php?file=carte&amp;act=lite" title="Version lite de la carte">Version Lite</a>
] - [ 
<a href="index.php?file=carte&amp;act=flash" title="Version flash de la carte">Version Flash</a>
]
<hr />
</p>
<if cond='|{map_type}| == "flash"'>
<p class="infos">Cette page est encore en construction, c'est normal que la carte ne marche pas parfaitement ;)</p>
<object class="center" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="635">
  <param name="movie" value="img/map/{session_user[lang]}/map-xml.swf">
  <param name="quality" value="high">
  <embed src="img/map/{session_user[lang]}/map-xml.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="500" height="635"></embed>
</object>
</if>
<elseif cond='|{map_type}| == "lite"'>
<div class="center">
[
<a id="map" href="index.php?file=carte&amp;map_x=<math oper='{map_x}-1' />&amp;map_y={map_y}#map" title="Aller à l'ouest">
Ouest
<img src="img/left.png" alt="left" />
</a> 
] - [ 
<a href="index.php?file=carte&amp;map_x={map_x}&amp;map_y=<math oper='{map_y}-1' />#map" title="Aller au nord">
Nord
<img src="img/up.png" alt="up" />
</a>
] - [ 
<a href="index.php?file=carte&amp;map_x={map_x}&amp;map_y=<math oper='{map_y}+1' />#map" title="Aller au sud">
Sud
<img src="img/down.png" alt="down" />
</a>
] - [ 
<a href="index.php?file=carte&amp;map_x=<math oper='{map_x}+1' />&amp;map_y={map_y}#map" title="Aller à l'est">
Est
<img src="img/right.png" alt="right" />
</a>
]
<br/>
[
<a id="map" href="index.php?file=carte&amp;map_x=<math oper='{map_x}-5' />&amp;map_y={map_y}#map" title="Aller à l'ouest">
Ouest
<img src="img/left.png" alt="left" /><img src="img/left.png" alt="left" />
</a> 
] - [ 
<a href="index.php?file=carte&amp;map_x={map_x}&amp;map_y=<math oper='{map_y}-5' />#map" title="Aller au nord">
Nord
<img src="img/up.png" alt="up" /><img src="img/up.png" alt="up" />
</a>
] - [ 
<a href="index.php?file=carte&amp;map_x={map_x}&amp;map_y=<math oper='{map_y}+5' />#map" title="Aller au sud">
Sud
<img src="img/down.png" alt="down" /><img src="img/down.png" alt="down" />
</a>
] - [ 
<a href="index.php?file=carte&amp;map_x=<math oper='{map_x}+5' />&amp;map_y={map_y}#map" title="Aller à l'est">
Est
<img src="img/right.png" alt="right" /><img src="img/right.png" alt="right" />
</a>
]
<br/>
<br />
<div class="block_carte zoom_{map_zoom} center">
	<foreach cond='|{map_array[cases]}| as |{rien}| => |{result}|'>
		<if cond='|{result[map_y]}| < |{map_h}|*1/3'>
		 <set name='region' value='1' />
		</if>
		<elseif cond='|{result[map_y]}| >= |{map_h}|*1/3 AND |{result[map_y]}| <= |{map_h}|*2/3'>
		 <set name='region' value='2' />
		</elseif>
		<elseif cond='|{result[map_y]}| > |{map_h}|*2/3'>
		 <set name='region' value='3' />
		</elseif>
		<if cond='|{result[map_type]}| != 5'>
		 <set name='case_title' value='Type: {carte[alt][{region}][{result[map_type]}]} <br/> X:{result[map_x]}  Y:{result[map_y]}' />
		 <set name='case_img' value='{region}_{result[map_type]}_{result[map_rand]}' />
		</if>
		<else>
		 <set name="mbr_array" value="{map_array[members][{result[map_x]}][{result[map_y]}]}" />
		 <set name='case_title' value='Village de {mbr_array[mbr_pseudo]} <br/> Points: {mbr_array[mbr_points]} Race: {race[{mbr_array[mbr_race]}]} <br/> Etat: {etat[{mbr_array[mbr_etat]}]} <br/> X:{result[map_x]} Y:{result[map_y]}' />
		 <if cond='|{mbr_array[mbr_points]}| > |{MAP_LIMITE_2}|'><set name="etat_mbr" value="3" /></if>
		 <elseif cond='|{mbr_array[mbr_points]}| > |{MAP_LIMITE_1}|'><set name="etat_mbr" value="2" /></elseif>
		 <else><set name="etat_mbr" value="1" /></else>
		 <set name='case_img' value='{region}_{result[map_type]}{map_array[members][{result[map_x]}][{result[map_y]}][mbr_race]}_{etat_mbr}' />
		</else>
		<a  href="index.php?file=carte&amp;act=view&amp;map_cid={result[map_cid]}">
		<img src="img/map/{case_img}.png" alt="{carte[alt][{result[map_type]}]}" title="{case_title}" />
		</a>
	</foreach>
</div>
	<hr />
	<form action="index.php?file=carte" method="get">
	<fieldset>
	<legend>Aller à</legend>
	<label for="map_x">X:</label>
	<input type="text" name="map_x" id="map_x" />
	<label for="map_y">Y:</label>
	<input type="text" name="map_y" id="map_y" />
	<input type="submit" value="Aller"/>
	</fieldset>
	<fieldset>
	<legend>Chercher</legend>
	<label for="map_pseudo">Pseudo:</label>
	<input type="text" name="map_pseudo" id="map_pseudo" />
	<input type="submit" value="Chercher"/>
	</fieldset>
	</form>
</div>
</elseif>
<elseif cond='|{map_type}| == "view"'>
	<if cond='is_array(|{map_array}|)'>
		<if cond='|{map_array[0][map_y]}| < |{map_h}|*1/3'>
			 <set name='region' value='1' />
		</if>
		<elseif cond='|{map_array[0][map_y]}| >= |{map_h}|*1/3 AND |{map_array[0][map_y]}| <= |{map_h}|*2/3'>
			 <set name='region' value='2' />
		</elseif>
		<elseif cond='|{map_array[0][map_y]}| > |{map_h}|*2/3'>
			 <set name='region' value='3' />
		</elseif>
		
		<if cond='|{map_array[0][map_type]}| != 5'>
			 <set name='case_title' value='Type: {carte[alt][{region}][{map_array[0][map_type]}]} <br/> X:{map_array[0][map_x]}  Y:{map_array[0][map_y]}' />
			 <set name='case_img' value='{region}_{map_array[0][map_type]}_{map_array[0][map_rand]}' />
		</if>
		<else>
			 <set name="mbr_array" value="{map_array[members][{map_array[0][map_x]}][{map_array[0][map_y]}]}" />
			 <set name='case_title' value='Village de {map_array[0][mbr_pseudo]} <br/> Points: {map_array[0][mbr_points]} Race: {race[{map_array[0][mbr_race]}]} <br/> Etat: {etat[{map_array[0][mbr_etat]}]} <br/> X:{map_array[0][map_x]} Y:{map_array[0][map_y]}' />
		 	<if cond='|{map_array[0][mbr_points]}| > |{MAP_LIMITE_2}|'><set name="etat_mbr" value="3" /></if>
		 	<elseif cond='|{map_array[0][mbr_points]}| > |{MAP_LIMITE_1}|'><set name="etat_mbr" value="2" /></elseif>
		 	<else><set name="etat_mbr" value="1" /></else>
		 	<set name='case_img' value='{region}_{map_array[0][map_type]}{map_array[0][mbr_race]}_{etat_mbr}' />
		</else>
		
		<a  href="index.php?file=carte&amp;act=view&amp;map_cid={map_array[0][map_cid]}">
		<img src="img/map/{case_img}.png" alt="{carte[alt][{map_array[0][map_type]}]}" title="{case_title}" />
		</a>
		
		<br/>
		Type: {carte[alt][{map_array[0][map_type]}]}<br/>
		Position: {map_array[0][map_x]}*{map_array[0][map_y]}<br/>
		<if cond='{map_array[0][mbr_mid]}'>
		Pseudo : <a href="index.php?file=member&amp;act=view&amp;mid={map_array[0][mbr_mid]}" title="Infos sur {map_array[0][mbr_pseudo]}">{map_array[0][mbr_pseudo]}</a>
		</if>
	    <p class="retour_module">[ <a href="index.php?file=carte" title="Retourner à la carte">Retour</a> ]
	</if>
	<else>
	<p class="error">Cet endroit n'existe pas.</p>
	</else>
</elseif>