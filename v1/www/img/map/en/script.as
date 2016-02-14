function loadXML(x_xml,y_xml, pseudo)
{
	//on crée l'objet xml
	loading = true;
	is_loading = true;
	
	myXML = new LoadVars();
	url ="";
	//url = "http://xf007.ath.cx/test/kotla/";
	url += "img/map/map-xml.php?x="+x_xml+"&y="+y_xml

	if(pseudo != undefined)
	{
		url +=  "&pseudo="+pseudo;
	}
	myXML.load(url);

	
	//Chargement en cours
	this.attachMovie("chargement", "charge", 102);
	charge._x=250;
	charge._y=250;
	
	_root.onEnterFrame=function()
	{
	   if(is_loading)
	   {
		   _root.sendmsg("Chargement ...  "+Math.round(myXML.getBytesLoaded()/1024)+" ko");
	   	   charge.taille = Math.round(myXML.getBytesLoaded()/1024)+" ko";
	   }
	}
	
	//finit
	myXML.onLoad = function(succes)
	{
		if(succes)
		{
			is_loading = false;
			if(myXML.error == 0)
			{
				_root.sendmsg("Chargement ok !");
			}
			else if(myXML.error == 1)
			{
				_root.sendmsg("Impossible de trouver ce pseudo !");
			}
			charge.unloadMovie();
			btcarray();
		}
	}
	
}

function btcarray()
{
	hav_x = Number(myXML.x);
	hav_y = Number(myXML.y);
	
	is_x = Number(myXML.xp);
	is_y = Number(myXML.yp);
	
	if(is_x && is_y)
	{
		x = is_x;
		y = is_y;
	}

	if(x == undefined || y == undefined)
	{
		x = hav_x;
		y = hav_y;
	}

	if(x == undefined || y == undefined)
	{
		x = 0;
		y = 0;
	}
	

	current_min_x=hav_x;
	current_min_y=hav_y;
	current_max_x=(hav_x+100);
	current_max_y=(hav_y+100);
	
	map = new Array();
	other = new Array();
	
	//on parcoure tout ca
	i = 0;
	i2 = 0;
	
	map_array = myXML.cases.split("|");
	other_array = myXML.other.split("|");
	
	 while (other_array[i] != undefined) {
		
		 //i2= 0;
		
		 other_array_this = other_array[i].split(",");
		 oid =  Number(other_array_this[2]);
	 	 opseudo =  String(other_array_this[3]);
		 otype = Number(other_array_this[4]);
		 ox =  Number(other_array_this[0]);
	 	 oy =  Number(other_array_this[1]);
		
		if(otype == "1" or otype == "2")
		{
			if(other[oy] == undefined)
	 		{
				other[oy]=new Array();
	 		}
	 		if(other[oy][ox] == undefined)
			{
				other[oy][ox] = new Array();
				i2 = 0;
			}
			if(other[oy][ox].length != undefined)
			{
				i2 = other[oy][ox].length;
			}
			if(other[oy][ox][i2] == undefined)
	 		{
				other[oy][ox][i2] = new Array(oid, opseudo, otype);
	 		}
		}
		i++;
	 }
	
	i = 0;
    while (map_array[i] != undefined) {

	 map_array_this = map_array[i].split(",");
	 cy = Number(map_array_this[1]);
	 cx = Number(map_array_this[0]);
	 ctype =  Number(map_array_this[3]);
	 cregion =  Number(map_array_this[2]);
	 
	 if(cregion)
	 {
		 if(map[cy] == undefined)
	 	{
			map[cy]=new Array();
		}
		if(map[cy][cx] == undefined)
	 	{
			map[cy][cx]=new Array(cregion,ctype);
	 	}
	 }
	 i++;
    }
	
	btcMap(map)
	loading = false;
}

function btcMap(map)
{
EraseOther();
mapHeight = y + 10;
mapWidth = x + 10;
for (var i = y; i < mapHeight; ++i) {
			for (var j = x; j <mapWidth; ++j) {
				this.attachMovie("all", "cadre"+j+"_"+i, ++d);
				if (map[i][j][0] == null) {
					position = 16;
				} else {
					position = (map[i][j][0]-1)*6+map[i][j][1]+1;
				}
				this["cadre"+j+"_"+i]._x = ((j-x)*tileW) + 25;
				this["cadre"+j+"_"+i]._y = ((i-y)*tileH) + 25;
				this["cadre"+j+"_"+i].gotoAndStop(position);
			}
		}
for (var i = y; i < mapHeight; ++i) {
			for (var j = x; j <mapWidth; ++j) {
				i2 = 0;
				done = false;
				while(other[i][j][i2] != undefined && done == false)
				{
					//if (other[i][j][i2][2] != undefined) {
						position = other[i][j][i2][2];
						this.attachMovie("other", "other"+j+"_"+i, ++d);
						this["other"+j+"_"+i]._x = ((j-x)*tileW) + 25;
						this["other"+j+"_"+i]._y = ((i-y)*tileH) + 25;
						this["other"+j+"_"+i].gotoAndStop(position);
						this["other"+j+"_"+i].player_name.border = false;
						this["other"+j+"_"+i].player_name.background = false;
						this["other"+j+"_"+i].player_name = other[i][j][i2][1];
						if(other[i][j].length > 1)
						{
							this["other"+j+"_"+i].plus = other[i][j].length;
						}
						else
						{
							this["other"+j+"_"+i].plus = "";
						}
					//}
					i2++;
					done =true;
				}
			}
		}
}

function EraseOther()
{
	d=100;
	while(d < 201)
	{
		this.attachMovie("blank", "blank", ++d);
	}
	d=1;
}

function rebuildmap(nx,ny)
{
	//si on est pas deja en train de charger
	if(!loading)
	{
		//on remet tout a zero
		i2 = 0;
    	j2 = 0;
		d = 1;
		
		//on empeche de sortir de la map
		if(nx < 0)
		{
			nx = 0;
		}	
		if(nx > 440)
		{
			nx = 440;
		}
		if(ny < 0)
		{
			ny = 0;
		}
		if(ny > 440)
		{
			ny = 440;
		}
	
		//on definit les limites de ce dont on va avoir besoin
		
		need_min_x=nx;
		need_min_y=ny;
		need_max_x=nx+10;
		need_max_y=ny+10;
			
		//on modifie x et y
		x = nx;
    	mapWidth = x + 10;
		y = ny;
    	mapHeight = y + 10;
		
		//trace("need "+need_min_x+"-have "+current_min_x+"- need "+need_min_y+"- have "+current_min_y+"-"+nx+"-"+ny);
		if(need_max_x >= current_max_x || need_max_y >= current_max_y || need_min_x < current_min_x || need_min_y < current_min_y )
		{
			//on télécharge les données de facon a ce que le joueur sois au centre du buffer
			loadXML((need_max_x-50),(need_max_y-50));
		}else{
			btcMap(map);
		}
		updateMouse()
	}
}

function sendmsg(msg)
{
	_root.messages.message = msg;
}

function updateMouse()
{
	if(_xmouse >= 0 && _xmouse <= 500 && _ymouse >=0 && _ymouse <= 500)
	{
		xmouse= (Math.floor(_xmouse/50) + x);
		ymouse= (Math.floor(_ymouse/50) + y);
		if(other[ymouse][xmouse].length) // == 1)
		{
			if(other[ymouse][xmouse][0][2] == 2)
			{
				this["cadre"+xmouse+"_"+ymouse].useHandCursor(true);
				this["cadre"+xmouse+"_"+ymouse].onPress = function() {
					getURL("?file=leg","_parent");
				}	
				txt = "X: "+xmouse+" | Y: "+ymouse+" | Armée de "+other[ymouse][xmouse][0][1];
			}else if(other[ymouse][xmouse][0][2] == 1)
			{
				this["cadre"+xmouse+"_"+ymouse].useHandCursor(true);
				this["cadre"+xmouse+"_"+ymouse].onPress = function() {
					getURL("?file=member&act=view&mid="+other[ymouse][xmouse][0][0],"_parent");
				}
				txt = "X: "+xmouse+" | Y: "+ymouse+" | Village de "+other[ymouse][xmouse][0][1];
			}
		}
		/*else if(other[ymouse][xmouse].length > 1)
		{
			//plus d'un truc  !!
			this["cadre"+xmouse+"_"+ymouse].useHandCursor(true);
			j = 0;
			i = 0;
			i2 = 0;
			d= 201;
			_root.other_right = new Array();
			while(other[ymouse][xmouse][i2] != undefined)
			{
				//if (other[i][j][i2][2] != undefined) {
				position = other[ymouse][xmouse][i2][2];
				this.attachMovie("other", "other_right"+j+"_"+i, ++d);
				this["other_right"+j+"_"+i]._x = ((j)*tileW) + 525;
				this["other_right"+j+"_"+i]._y = ((i)*tileH) + 25;
				this["other_right"+j+"_"+i].gotoAndStop(position);
				this["other_right"+j+"_"+i].player_name.border = false;
				this["other_right"+j+"_"+i].player_name.background = false;
				this["other_right"+j+"_"+i].player_name = other[ymouse][xmouse][i2][1];
				this["other_right"+j+"_"+i].plus = "";
				i++;
				i2++;
			}
		}*/
		else
		{
				this["cadre"+xmouse+"_"+ymouse].useHandCursor(false);
				txt = "X: "+xmouse+" | Y: "+ymouse;
		}
		sendmsg(txt);
	}
}
