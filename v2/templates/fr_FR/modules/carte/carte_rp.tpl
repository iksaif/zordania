<div class="menu_module">
[ <a href="carte-rp.html?sub=rp" title="Carte normale">Normale</a> ] -
[ <a href="carte-rp.html?sub=pts" title="Carte des points">Points</a> ] -
[ <a href="carte-rp.html?sub=pop" title="Carte de la population">Population</a> ] - 
[ <a href="carte.html?map_cid=94800" title="Egeria sur la carte">Egeria</a> ]
</div>
<br/>
<div id="carte_lite">
     <if cond="isset({_user[map_x]})">
	 <a href="carte.html?map_x=<math oper='{_user[map_x]}-4' />&map_y=<math oper='{_user[map_y]}-4' />#map">
     <img src="img/plus.png" style="position:absolute; top: <math oper='{_user[map_x]}-4' />px; left: <math oper='{_user[map_y]}-4' />px" alt="{_user[pseudo]}" />
	 </a>
     </if>

     <if cond='{map_sub} == "pop"'>
          <a href="img/map/rp-lite/pop-big.jpg"><img src="img/map/rp-lite/pop.png" alt="Carte Role Play" id="carte_img" /></a>
     </if>
     <elseif cond='{map_sub} == "pts"'>
          <img src="img/map/rp-lite/pts.png" alt="Carte Role Play" id="carte_img" />
     </elseif>
     <else>
          <img src="img/map/rp-lite/princ.png" alt="Carte Role Play" id="carte_img" />
     </else>
</div>

<form action="carte.html" method="get">
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

<script type="text/javascript">
<!-- // coordonnées du clic sur l'image
$("#carte_img").click(function(e){
	var pos = $("#carte_img").offset();
	$("#map_x").val(parseInt(e.pageX-pos.left));
	$("#map_y").val(parseInt(e.pageY-pos.top));
});
// Ajoute l'autocomplétion sur l'input d'id 'map_pseudo'
$(document).ready(function(){
	$("#map_pseudo").autocomplete({
		source: "/json--member-search.html?type=ajax", delay: 500, minLength: 2
	});
});
 function updateMap() {
	var map_x=$("#map_x").val();
	var map_y=$("#map_y").val();
     $.getJSON({
         url: 'json--member-map.html?type=ajax', data: {x: map_x, y: map_y},
         success: function(response) {
             // update status element
             $('#status').html(response);
         },
        error: function(xhr) {alert('Erreur!  Status = ' + xhr.status);}
     });
 }
$("#searchmbr").click(function(e){alert('pas trouvé!');}); // -->
</script>

<div class="menu_module">
	<a href="img/map/rp/" title="Télécharger les cartes Role Play en taille réelle">Télécharger les cartes</a>
</div>
