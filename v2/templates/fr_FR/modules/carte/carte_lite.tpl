<if cond='{_display} == "module"'>
	<set name="url" value="module--carte.html"/>
</if>
<else>
	<div class="menu_module">[ <a href="module--carte.html?map_y={map_y}&map_x={map_x}" title="Voir la carte en grand">Zoom</a> ] - 
[ <a href="carte.html?map_cid=94800" title="Egeria sur la carte">Egeria</a> ]</div>

	<set name="url" value="carte.html" />
</else>



<div id="map" class="menu_module">
<map name='rosevent'>
<!-- #$-:Image map file created by GIMP Image Map plug-in -->
<!-- #$-:GIMP Image Map plug-in by Maurits Rijk -->
<!-- #$-:Please do not edit lines starting with "#$" -->
<!-- #$VERSION:2.3 -->
<!-- #$AUTHOR:pifou -->
<area shape="poly" coords="0,0,33,0,33,20,20,21,20,31,0,31" alt="Nord-Ouest lointain" href="{url}?map_x=<math oper='{map_x}-5' />&map_y=<math oper='{map_y}-5' />#map" />
<area shape="poly" coords="33,0,66,0,62,31,50,20,39,30" alt="Nord lointain" href="{url}?map_x={map_x}&map_y=<math oper='{map_y}-5' />#map" />
<area shape="poly" coords="67,0,100,0,99,32,83,32,81,21,66,21" alt="Nord-Est lointain" href="{url}?map_x=<math oper='{map_x}+5' />&map_y=<math oper='{map_y}-5' />#map" />
<area shape="poly" coords="99,32,100,67,71,58,80,49,70,40" alt="Est lointain" href="{url}?map_x=<math oper='{map_x}+5' />&map_y={map_y}#map" />
<area shape="poly" coords="100,99,100,67,82,67,82,79,67,79,67,99" alt="Sud-Est lointain" href="{url}?map_x=<math oper='{map_x}+5' />&map_y=<math oper='{map_y}+5' />#map" />
<area shape="poly" coords="66,99,60,67,51,78,41,69,34,99" alt="Sud lointain" href="{url}?map_x={map_x}&map_y=<math oper='{map_y}+5' />#map" />
<area shape="poly" coords="0,100,33,100,33,80,20,80,20,67,0,67" alt="Sud-Ouest lointain" href="{url}?map_x=<math oper='{map_x}-5' />&map_y=<math oper='{map_y}+5' />#map" />
<area shape="poly" coords="0,66,33,60,24,50,32,40,0,33" alt="Ouest lointain" href="{url}?map_x=<math oper='{map_x}-5' />&map_y={map_y}#map" />
<area shape="poly" coords="21,22,36,20,39,35,35,40,20,36" alt="Nord-Ouest" href="{url}?map_x=<math oper='{map_x}-1' />&map_y=<math oper='{map_y}-1' />#map" />
<area shape="poly" coords="39,31,50,21,61,32,61,39,41,39" alt="Nord" href="{url}?map_x={map_x}&map_y=<math oper='{map_y}-1' />#map" />
<area shape="poly" coords="64,21,80,22,83,36,66,41,62,38" alt="Nord-Est" href="{url}?map_x=<math oper='{map_x}+1' />&map_y=<math oper='{map_y}-1' />#map" />
<area shape="poly" coords="69,40,78,48,69,59,61,58,61,42" alt="Est" href="{url}?map_x=<math oper='{map_x}+1' />&map_y={map_y}#map" />
<area shape="poly" coords="81,78,81,62,71,58,64,59,59,62,64,79" alt="Sud-Est" href="{url}?map_x=<math oper='{map_x}+1' />&map_y=<math oper='{map_y}+1' />#map" />
<area shape="poly" coords="60,66,60,57,43,57,41,68,51,78" alt="Sud" href="{url}?map_x={map_x}&map_y=<math oper='{map_y}+1' />#map" />
<area shape="poly" coords="21,79,20,62,38,60,41,64,38,80" alt="Sud-Ouest" href="{url}?map_x=<math oper='{map_x}-1' />&map_y=<math oper='{map_y}+1' />#map" />
<area shape="poly" coords="33,60,25,50,32,40,40,40,41,58" alt="Ouest" href="{url}?map_x=<math oper='{map_x}-1' />&map_y={map_y}#map" />
<area shape="rect" coords="42,40,61,57" alt="Mon village" href="{url}?map_x={map_usr_x}&map_y={map_usr_y}#map" />
</map>
<img usemap='#rosevent' src='img/0.png' alt='Rose de vents' height="100" width="100" />
</div>
<script type="text/javascript">
<!--
 function showMapInfoCallback(xmlhttp) {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200)
			{
				text = xmlhttp.responseText;
			} else {
				text = statusText;
			}
			document.getElementById("carte_infos").innerHTML = text;
		}
}

function showMapInfo(cid) {
	var xmlhttp = getHTTPObject();
	var url = "{cfg_url}ajax--carte-view.html?map_cid=" + cid;
	var method = "GET";
	var data = 'null';
	var callback = function() { showMapInfoCallback(xmlhttp); }

	ajaxRequest(xmlhttp, method, url, data, callback);
	return false;
}
-->
</script>
<if cond="{map_cid}">
<script type="text/javascript">
   // <![CDATA[
setTimeout("showMapInfo({map_cid})",500);
   // ]]>
</script>
</if>

<if cond='{_display} == "module"'><div id="carte_big"></if>
<else><div id="carte_lite"></else>
	<foreach cond='{map_array} as {map_y} => {result_x}'>
	<foreach cond='{result_x} as {map_x} => {result}'>
		<if cond='{result[map_type]} != {MAP_VILLAGE}'>
			<set name='case_title' value='Type: {carte[alt][{result[map_climat]}][{result[map_type]}]} <br/> X:{map_x}  Y:{map_y}' />
			<set name='case_img' value='{result[map_climat]}/{result[map_type]}/{result[map_rand]}' />
		</if>
		<else>
			<set name="mbr_array" value="{result[members][0]}" />
			<set name='case_title' value='Village de {mbr_array[mbr_pseudo]} <br/> Points: {mbr_array[mbr_points]} Race: {race[{mbr_array[mbr_race]}]} <br/>  X:{map_x} Y:{map_y}' />
			<if cond='{mbr_array[mbr_points]} > {MBR_NIV_2}'><set name="etat_mbr" value="3" /></if>
			<elseif cond='{mbr_array[mbr_points]} > {MBR_NIV_1}'><set name="etat_mbr" value="2" /></elseif>
			<else><set name="etat_mbr" value="1" /></else>
			<set name='case_img' value='{result[map_climat]}/{result[map_type]}/{mbr_array[mbr_race]}/{etat_mbr}' />
		</else>
		<a  href="carte-view.html?map_cid={result[map_cid]}" onclick="showMapInfo({result[map_cid]}); return false;">
			<img class="tile" src="img/map/tiles/{case_img}.png" alt="{carte[alt][{result[map_climat]}][{result[map_type]}]}" title="{case_title}" />
		</a>
		<if cond="isset({result[legions]})">
			<foreach cond="{result[legions]} as {value}">
				<if cond="{value[mbr_etat]} == {MBR_ETAT_OK} and {value[hro_bonus]} != {CP_INVISIBILITE}">
					<set name="leg_race" value="{value[mbr_race]}" />
					<set name="top" value="<math oper='({map_y} - {orig_y}) * 50' />" />
					<set name="left" value="<math oper='({map_x} - {orig_x}) * 50 + 5 * {leg_race}' />" />
					<img style="position: absolute; left: {left}px; top: {top}px;" src="img/{leg_race}/{leg_race}.png" alt="{value[mbr_pseudo]}" />
				</if>
			</if>
		</if>
	</foreach>
	</foreach>
</div>

<hr />
<div id="carte_infos">

</div>
<hr />
<if cond='isset({leg_usr})'>
	<h3>Aller à mes légions</h3>
	<table>
	<tr>
		<th>Légion</th>
		<th>Destination</th>
	</tr>
	<foreach cond='{leg_usr} as {leg} => {value}'>
	<tr>
		<td>{value[leg_name]} : <a href="{url}?map_cid={value[leg_cid]}" title="voir">{value[map_x]} x {value[map_y]}</a> ( xp: {value[leg_xp]})</td>
		<if cond='{value[leg_etat]} == LEG_ETAT_DPL || {value[leg_etat]} == LEG_ETAT_RET || 
		{value[leg_etat]} == LEG_ETAT_ALL'>
			<td><a href="{url}?map_cid={value[leg_dest]}" title="voir la destination">{value[dest_x]} x {value[dest_y]}</a></td>
		</if>
		<else>
			<td>à l'arrêt</td>
		</else>
	</tr>
	</foreach>
	</table>
</if>

<script type="text/javascript">
<!--
// Ajoute l'autocomplétion sur l'input d'id 'map_pseudo'
$(document).ready(function(){
	$("#map_pseudo").autocomplete({
		source: "/json--member-search.html?type=ajax"
	});
});
// -->
</script>
<form action="{url}" method="get">
	<fieldset><legend>Aller à</legend>
		<label for="map_x">X:</label><input type="text" name="map_x" id="map_x" size="6" />
		<label for="map_y">Y:</label><input type="text" name="map_y" id="map_y" size="6" />
		<input type="submit" value="Aller"/>
	</fieldset>
	<fieldset>
	<legend>Chercher</legend>
		<label for="map_pseudo">Pseudo:</label><input type="text" name="map_pseudo" id="map_pseudo" />
		<input type="submit" value="Chercher"/>
	</fieldset>
</form>

