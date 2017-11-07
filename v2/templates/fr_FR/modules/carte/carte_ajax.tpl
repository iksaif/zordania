<div class="menu_module">
[ <a href="carte.html?map_cid=94800" title="Egeria sur la carte">Egeria</a> ]
</div>

<script type="text/javascript">
   // <![CDATA[
var mapLib = {
	/* Constantes */
	tileWidth: 50,
	tileHeight: 50,
	mapWidth: {MAP_W},
	mapHeight: {MAP_H},
	blockWidth: 10, /* Nombre de tile en largeur */
	blockHeight: 10, /* Nombre de tile en hauteur */
	defimg: "{cfg_url}img/map/tiles/<region>/5/1.png",
	/* Variables */
	x: 0,
	y: 0,
	gotoX: 0,
	gotoY: 0,
	cases: new Array, /* Cases, avec infos sur légions, etc */
	blocks: new Array, /* blocks de blockWidth,blockHeight images */
	timer: null,
	timerClean: null,
	smooth: true,
	offset: 0.2,
	hibertile: new Array,
	races: new Array("", "Humains", "Orcs", "Nains", "Drows", "Elfes"),
	/* Fonctions publiques */
	init: function(x, y) {
		this.gotoX = this.x = x;
		this.gotoY = this.y = y;
		this.update();
		this.clean();
		this.cleanmsg();
	},
	update: function() { 
	/* Déplace les cases, rajoute les cases inexistantes, ne vire pas les vieilles */
			/* min et max sont un peu décalés pour pouvoir bien mettre hors du champ de vision les trucs invisibles */
		if(this.x == this.gotoX && this.y == this.gotoY && this.timer) {
			clearInterval(this.timer);
			clearInterval(this.timerClean);
			this.timerClean = null;
			this.timer = null;
			this.clean();
		}
					
		/* On fait ça petit a petit, c'est beau comme ça */
		if(this.smooth) {
			dy = dx = this.offset;
		} else {
			dy = dx = 1;
		}

		var dx;
		var dy;
		
		
		if(this.x != this.gotoX) {
			dx *= (this.x > this.gotoX ? -1 : 1);
			this.x = Math.round((this.x + dx) * 1000) /1000;
		}
		if(this.y != this.gotoY) {
			dy *= (this.y > this.gotoY ? -1 : 1);
			this.y = Math.round((this.y + dy) * 1000) /1000;
		}
		
		
		var minX = Math.floor(this.x-1);
		var maxX = Math.ceil(this.x+this.blockWidth);
		var minY = Math.floor(this.y-1);
		var maxY = Math.ceil(this.y+this.blockHeight);
					
		//console.log("lala:", new Array(this.x, this.y, dx, dy));
		/* Parcourt des cases censées être affichées */
		for(var x = minX; x <= maxX; ++x) {
			for(var y = minY; y <= maxY; ++y) {
				var node = this.getTile(x,y); /* est-ce qu'on a déjà l'emplacement de créé ? */
				var loaded = this.isCaseLoaded(x,y);
				if(!loaded) { /* existe pas ? */
					var blockCoord = this.getBlockCoord(x,y);
					var bx = blockCoord[0];
					var by = blockCoord[1];
					//console.log("pas chargé",new Array(blockCoord,x,y));
						
					/* Pas chargé, ou chargé, mais cassé */
					if(!this.blocks[bx] || !this.blocks[bx][by] || this.blocks[bx][by] == 1) {
						//console.log("block non plus");
						this.loadBlock(bx, by);
					/* En chargement */
					} else if(this.blocks[bx][by] == 2) {
						//console.log("block en cours");
					}

					/* On met un tile temporaire */
					this.insertTmpTile(x,y);
				} else {
					var pos = this.convertCoord(x,y);
					
					/* Si c'est un tile temporaire mais qu'on a les infos */
					if(!node || this.isTmpTile(node)) {
						this.insertTile(x,y);/* on remplace par un vrai */
					} else {
						/* On déplace */
						this.moveTile(node, pos[0], pos[1]);
					}
				}
	//			console.log("prout",new Array(x,y));
	//			console.log("akak", new Array(minX, minY, maxX, maxY));
			}
		}
			//console.info("prout "+this.x+ "_" + this.y);
	},
	move: function(dx, dy) { /* se déplace de dx dy */
		if(!this.timer)
			this.moveToCoord(this.x+dx, this.y+dy);
	},
	moveToCoord: function(x, y) { /* Va en x y */
		var coord = this.cleanCoord(x,y);
		
		this.gotoX = coord[0];
		this.gotoY = coord[1];
				
		if(!this.timer) {
			this.timer = setInterval("mapLib.update()", 25);
			this.timerClean = setInterval("mapLib.clean()",2000);
		}

		this.clean();
	},
	goToCoord: function(x,y) {
		var coord = this.cleanCoord(x,y);
		
		this.x = this.gotoX = coord[0];
		this.y = this.gotoY = coord[1];
		
		this.clean();
		this.update();
		this.clean();
	},
	/* Fonctions privées */
	cleanCoord: function(x, y) {
		var coord = new Array;
		x = Math.round(parseFloat(x)*1000)/1000;
		y = Math.round(parseFloat(y)*1000)/1000;
		if(x < 0) x = 0;
		if(x > this.mapWidth - this.blockWidth) x = this.mapWidth - this.blockWidth;
		if(y < 0) y = 0;
		if(y > this.mapHeight - this.blockHeight) y = this.mapHeight - this.blockHeight;
		coord[0] = x;
		coord[1] = y;
		return coord;
	},
	getTileType: function(x, y) {
		return this.cases[x][y]["map_type"];
	},
	getTileRand: function(x, y) {
		return this.cases[x][y]["map_rand"];
	},
	getTileRegion: function(x, y) {
		return this.cases[x][y]["map_climat"];
	},
	getTileCid: function(x, y) {
		return this.cases[x][y]["map_cid"];
	},
	getRegion: function(x, y) {
		if(y < this.mapHeight / 3) {
			return 1;
		} else if(y < 2 * this.mapHeight / 3) {
			return 2;
		} else {
			return 3;
		}
	},
	convertCoord: function(x, y) {  
		var pos = new Array;
		pos[0] = (x-this.x) * this.tileWidth;
		pos[1] = (y-this.y) * this.tileHeight;
		return pos;
	},
	isCoordVisible: function(x, y) {
		var minX = Math.floor(this.x-1);
		var maxX = Math.ceil(this.x+this.blockWidth);
		var minY = Math.floor(this.y-1);
		var maxY = Math.ceil(this.y+this.blockHeight);

		return (x >= minX) && (x <= maxX) && (y >= minY) && (y <= maxY);
	},
	isTileVisible: function(tile) {
		var minX = 0;
		var minY = 0;
		var maxX = this.blockWidth * this.tileWidth;
		var maxY = this.blockHeight * this.tileHeight;
		var x = parseFloat(tile.style.left);
		var y = parseFloat(tile.style.top);

		return (x >= minX) && (x <= maxX) && (y >= minY) && (y <= maxY);
	},
	getTileUrl: function(x, y) { /* Récupere l'url de l'image qui va bien */
		var url = "{cfg_url}img/map/tiles/"
		var region = this.getTileRegion(x,y);
		var type = this.getTileType(x,y);
		var rand = this.getTileRand(x,y);

		if(type == 7) {
			var race = this.cases[x][y]["mbr_array"]["mbr_race"];
			url += region + "/" + type + "/" + race + "/" + this.getVlg(x,y) + ".png";
		} else
			url += region + "/" + type + "/" + rand + ".png";
			
		return url;
		
	},
	getTileId: function(x,y) {
		return "tile_"+x+"_"+y
	},
	getTile: function(x, y) { /* Récupère l'objet qui correspond */
		return document.getElementById(this.getTileId(x,y));
	},
	moveTile: function(tile, x, y) { /* Déplace cette tile là où elle doit être */
		tile.style.left = x+"px";
		tile.style.top = y+"px";
	},
	createTile: function(x, y) {
		var node = this.getTile(x,y);
		var pos = this.convertCoord(x,y);
		
		if(!node) { /* Dans le cas où il y aurait un truc temporaire déjà créé */
			if(this.hibertile.length) {
				node = this.hibertile.pop();
			} else {
				node = document.createElement("img");
				document.getElementById("carte_ajax").appendChild(node);
				node.style.position = "absolute";
				node.title = " ";
				if(toolTipLib) {
					toolTipLib.attachToolTip(node);
				}
			}
		}
	
		if(this.isCaseLoaded(x,y)) {
			var title = "";
			var infos = this.cases[x][y];
			if(infos["map_type"] == 7) {
				title = "Village de " + infos["mbr_array"]["mbr_pseudo"] + "<br/>";
				title+= "Points: " + infos["mbr_array"]["mbr_points"] + " Race: " + this.races[infos["mbr_array"]["mbr_race"]] + "<br/>";
				title+= " X:"+x+" Y:"+y;
			} else {
				title = " X:"+x+" Y:"+y;
			}
			if(toolTipLib)
				node.setAttribute("tip", title);
			else
				node.title = title;
	
		}
		
		node.id = this.getTileId(x,y);
		this.moveTile(node, pos[0], pos[1]);
		
		return node;
	},
	insertTile: function(x, y) { /* Ajoute la tile  */
		var node = this.createTile(x,y);
		
		node.name = node.className = "tile";
		node.setAttribute("onclick", "mapLib.showMapInfo("+this.getTileCid(x,y)+")");
		node.setAttribute("src", this.getTileUrl(x,y));
		return node;
	},
	insertTmpTile: function(x, y) {
		var node = this.createTile(x, y);				
		var url = this.defimg.replace("<region>", this.getRegion(x,y));
		
		node.name = node.className = "tmptile";
		node.setAttribute("src", url);
		return node;
	},
	isTmpTile: function(tile) {
		return (tile.className == "tmptile");
	},
	deleteTile: function(tile) { /* Supprime la tile */
		document.getElementById("carte_ajax").removeChild(tile);
	},
	hibernTile: function (tile) { /* Met la tile à disposition, on ne va pas s'amuser a tout créer/supprimer tout le temps */
		tile.name = tile.className = "hibertile";
		tile.style.left = 0-this.tileWidth+"px"; /* Caché */
		this.hibertile.push(tile);
	},
	getBlockCoord: function(x, y) {
		var bx = Math.floor(x/this.blockWidth);
		var by = Math.floor(y/this.blockHeight);
		return new Array(bx,by);
	},
	loadBlock: function(x, y) { /* Charge le block x,y */
		var x1 = x*this.blockWidth;
		var y1 = y*this.blockHeight;
		var x2 = x1 + this.blockWidth - 1;
		var y2 = y1 + this.blockHeight - 1;
		var mycallback = function(etat) {
			mapLib.blocks[x][y] = etat;
		}
		
		if(!this.blocks[x])
			this.blocks[x] = new Array;
		if(!this.blocks[x][y])
			this.blocks[x][y] = 2; /* En cours */
		
		
		this.load(x1, y1, x2, y2, mycallback);
	},
	load: function(x1, y1, x2, y2, mycallback) { /* Charge les infos sur les cases de x1 ,y1 a x2,y2 */
		/* mycallback prend un argument, 0 1 2, qui permet de savoir si l'opération a réussi */
		var xmlhttp = getHTTPObject();
		var url = "{cfg_url}carte.xml?x1=" + x1 + "&y1=" + y1 + "&x2=" + x2 + "&y2=" + y2;
		var method = "GET";
		var data = 'null';
		var callback = function() { mapLib.loadCallback(xmlhttp, mycallback); }

		ajaxRequest(xmlhttp, method, url, data, callback);
	},
	loadCallback: function(xmlhttp, mycallback) {
		var etat = 2; /* Par defaut = en chargement */
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200)
			{
				if(this.parse(xmlhttp.responseXML))
					etat = 1;
			} else {
				this.error(statusText);
				etat = 0;
			}
		}
		if(mycallback) mycallback(etat);
	},
	clean: function() { /* Nettoie le block et supprime les cases non visibles */
		var root = document.getElementById("carte_ajax");
		for (var iNode = 0; iNode < root.childNodes.length; iNode++) {
			var node = root.childNodes.item(iNode);
			if(node.nodeName == "IMG" && node.name != "hibertile") {
				var coord = node.id.split("_");
				if(!this.isCoordVisible(coord[1],coord[2])) {
					//
					//this.deleteTile(node);
					this.hibernTile(node); /* on met cette tile en hibernation */
				}
			}
		}
	},
	parse: function(root) { /* Parse root (objet dom), et rajoute dans cases */
		for (var iNode = 0; iNode < root.childNodes.length; iNode++) {
			var node = root.childNodes.item(iNode);
			if(node.nodeName == "carte") {
				for (var iNode1 = 0; iNode1 < node.childNodes.length; iNode1++) {
					var node1 = node.childNodes.item(iNode1);
					if(node1.nodeName == "case") {
						this.parseCase(node1);
					}
				}
			}
		}
	},
	isCaseLoaded: function(x, y) {
		return (this.cases[x] && this.cases[x][y]);
	},
	parseCase: function(root) { /* Parse un objet dom étant une case */
		var map_x = root.getElementsByTagName("map_x")[0].firstChild.nodeValue;
		var map_y = root.getElementsByTagName("map_y")[0].firstChild.nodeValue;
		var map_cid = root.getElementsByTagName("map_cid")[0].firstChild.nodeValue;
		var map_type = root.getElementsByTagName("map_type")[0].firstChild.nodeValue;
		var map_climat = root.getElementsByTagName("map_climat")[0].firstChild.nodeValue;
		var map_rand = root.getElementsByTagName("map_rand")[0].firstChild.nodeValue;
		
		var map_array = new Array;
		map_array["map_cid"] = map_cid;
		map_array["map_type"] = map_type;
		map_array["map_climat"] = map_climat;
		map_array["map_rand"] = map_rand;
		map_array["mbr_array"] = this.parseMbr(root);
		map_array["leg_array"] = this.parseLeg(root);
		this.addCase(map_x, map_y, map_array);
	},
	parseMbr: function(root) {
		var members = root.getElementsByTagName("member");
		var member = null;
		
		if(members.length == 1) {
			member = members[0];
			var mbr_array = new Array();
			mbr_array["mbr_pseudo"] = member.getElementsByTagName("mbr_pseudo")[0].firstChild.nodeValue
			mbr_array["mbr_points"] = member.getElementsByTagName("mbr_points")[0].firstChild.nodeValue
			mbr_array["mbr_race"] = member.getElementsByTagName("mbr_race")[0].firstChild.nodeValue
			mbr_array["mbr_etat"] = member.getElementsByTagName("mbr_etat")[0].firstChild.nodeValue
			mbr_array["mbr_mid"] = member.getElementsByTagName("mbr_mid")[0].firstChild.nodeValue
			return mbr_array;
		} else {
			return new Array();
		}
	},
	getVlg: function(x, y) {
		if(this.isCaseLoaded(x,y)) {
			var points = this.cases[x][y]["mbr_array"]["mbr_points"];
			return (points < {MBR_NIV_1}) ? 1 : (points < {MBR_NIV_2}) ? 2 : 3;
		} else
			return 1;
	},
	parseLeg: function(root) {
		return new Array();
	},
	addCase : function(x, y, infos) {
		if(!this.cases[x]) {
			this.cases[x] = new Array;
		}
		if(!this.cases[x][y]) {
			this.cases[x][y] = new Array;
		}
		this.cases[x][y] = infos;
		
		if(this.isCoordVisible(x,y))
			this.insertTile(x,y);
		//console.log("case"+x+"*"+y,this.insertTile(x,y));
	},
	 showMapInfoCallback: function(xmlhttp) {
	 	var text = "";
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200)
				text = xmlhttp.responseText;
			else
				text = statusText;
			document.getElementById("carte_infos").innerHTML = text;
		}
	},
	showMapInfo: function(cid) {
		var xmlhttp = getHTTPObject();
		var url = "{cfg_url}ajax--carte-view.html?map_cid=" + cid;
		var method = "GET";
		var data = 'null';
		var callback = function() { mapLib.showMapInfoCallback(xmlhttp); }
	
		ajaxRequest(xmlhttp, method, url, data, callback);
		return false;
	},
	cleanmsg: function() {
		document.getElementById("carte_msg").innerHTML ="";
	},
	info: function(string) {
		document.getElementById("carte_msg").innerHTML = "<p class=\"infos\">" + string + "</p>";	
	},
	error: function(string) {
		document.getElementById("carte_msg").innerHTML = "<p class=\"error\">" + string + "</p>";	
	}
}
  // ]]>
</script>

<div id="map" class="menu_module">
<map name='rosevent'>
  <area shape='polygon' href='javascript:mapLib.move(-8,-8)' alt='lointain Nord-Ouest' title='lointain Nord-Ouest' coords='13,11 19,42 32,44 27,26 43,32 41,20' />
  <area shape='polygon' href='javascript:mapLib.move(0,-8)' alt='lointain Nord' title='lointain Nord' coords='44,30 43,18 51,2 60,20 59,31 54,25' />
  <area shape='polygon' href='javascript:mapLib.move(8,-8)' alt='lointain Nord-Est' title='lointain Nord-Est' coords='58,32 60,18 89,10 85,40 70,46 73,29' />
  <area shape='polygon' href='javascript:mapLib.move(8,0)' alt='lointain Est' title='lointain Est' coords='72,44 83,44 100,51 83,60 72,59 79,51' />
  <area shape='polygon' href='javascript:mapLib.move(8,8)' alt='lointain Sud-Est' title='lointain Sud-Est' coords='71,58 84,60 89,90 61,83 58,71 73,72' />
  <area shape='polygon' href='javascript:mapLib.move(0,8)' alt='lointain Sud' title='lointain Sud' coords='44,73 50,80 58,73 60,82 51,97 43,84' />
  <area shape='polygon' href='javascript:mapLib.move(-8,8)' alt='lointain Sud-Ouest' title='lointain Sud-Ouest' coords='43,71 41,85 12,91 18,60 30,59 29,72' />
  <area shape='polygon' href='javascript:mapLib.move(-8,0)' alt='lointain Ouest' title='lointain Ouest' coords='30,57 18,59 4,50 19,42 30,44 23,51' />
  <area shape='polygon' href='javascript:mapLib.move(-4,-4)' alt='Nord-Ouest' title='Nord-Ouest' coords='39,45 32,43 27,28 44,30 46,40' />
  <area shape='polygon' href='javascript:mapLib.move(0,-4)' alt='Nord' title='Nord' coords='45,41 44,29 50,22 57,30 54,40' />
  <area shape='polygon' href='javascript:mapLib.move(4,-4)' alt='Nord-Est' title='Nord-Est' coords='55,41 58,32 74,28 71,44 61,47' />
  <area shape='polygon' href='javascript:mapLib.move(4,0)' alt='Est' title='Est' coords='61,45 71,44 79,51 72,57 61,56' />
  <area shape='polygon' href='javascript:mapLib.move(4,4)' alt='Sud-Est' title='Sud-Est' coords='62,56 70,59 73,74 57,72 57,62' />
  <area shape='polygon' href='javascript:mapLib.move(0,4)' alt='Sud' title='Sud' coords='47,63 56,64 58,72 51,80 45,71' />
  <area shape='polygon' href='javascript:mapLib.move(-4,4)' alt='Sud-Ouest' title='Sud-Ouest' coords='46,62 43,70 28,74 31,57 39,56' />
  <area shape='polygon' href='javascript:mapLib.move(-4,0)' alt='Ouest' title='Ouest' coords='40,56 30,59 23,52 30,45 41,45' />
  <area shape='polygon' href="?map_x=0&map_y=0#map" alt='Centre' title='Centre' coords='46,60 42,55 41,45 45,40 56,41 60,47 60,57 57,62' />
</map>
<img border='0' usemap='#rosevent' src='img/0.png' alt='Rose de vents' height="100" width="100" />
</div>

<div id="carte_ajax" />
<hr/>
<div id="carte_msg" />
<div id="carte_infos" />

<hr />
<script type="text/javascript">
   // <![CDATA[
setTimeout("mapLib.init({map_x},{map_y})",1000);
mapLib.info("Chargement ....");
   // ]]>
</script>

<form onsubmit="mapLib.goToCoord(this.map_x.value,this.map_y.value); return false;">
	<fieldset>
		<legend>Aller à</legend>
		<label for="map_x">X:</label>
		<input type="text" name="map_x" id="map_x" />
		<label for="map_y">Y:</label>
		<input type="text" name="map_y" id="map_y" />
		<input type="submit" value="Aller"/>
	</fieldset>
</form>
<form onsubmit="mapLib.moveToCoord(this.map_x.value,this.map_y.value); return false;">
	<fieldset>
		<legend>Aller à (mode fluide)</legend>
		<label for="map_x">X:</label>
		<input type="text" name="map_x" id="map_x" />
		<label for="map_y">Y:</label>
		<input type="text" name="map_y" id="map_y" />
		<input type="submit" value="Aller"/>
	</fieldset>
</form>
<script type="text/javascript">
<!--
// Ajoute l'autocomplétion sur l'input d'id 'map_pseudo'
$(document).ready(function(){
	$("#"+"map_pseudo").autocomplete({
		source: "/json--member-search.html?type=ajax"
	});
});
// -->
</script>
<form>
	<fieldset>
		<legend>Chercher</legend>
		<label for="map_pseudo">Pseudo:</label>
		<input type="text" name="map_pseudo" id="map_pseudo" />
		<input type="submit" value="Chercher"/>
	</fieldset>
</form>
