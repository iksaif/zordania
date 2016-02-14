/* Javascript pour afficher le village */
var Vlg = {
	w: 500,
	h: 350,
	VlgCoords: new Array(),
	SrcCoords: new Array(),
	init: function(race, back) {
		if(race < 1 || race > 7) race = 1;
		/* initialiser les coordonnées par race */
		this.initCoord(race);

		/* mettre le fond de l'image */
		$("#village").css('width', this.w + "px").css('height', this.h + "px")
			.css('backgroundImage', "url(img/"+ race + "/vlg/back" + back + ".png)");

		/* positionner les recherches si y'a */
		$.each(this.VlgCoords, function(index, value) { 
		  if(value) {
			var img = $("#btc_"+index);
			img.attr('src', "img/"+ race + "/vlg/" + back + "/" + index + ".png");
			img.css('top', value[1]).css('left', value[0]).css('position', 'absolute');
		  }
		});

		/* positionner les batiments */
		$.each(this.SrcCoords, function(index, value) { 
		  if(value) {
			var img = $("#src_"+index);
			img.attr('src', "img/"+ race + "/vlg/src/" + index + ".png");
			img.css('top', value[1]).css('left', value[0]).css('position', 'absolute');
		  }
		});

	},

	initCoord: function(race) {
		switch(race) {
		case 1:
			this.VlgCoords[1] = new Array(22,89);
			this.VlgCoords[2] = new Array(328,71);
			this.VlgCoords[3] = new Array(240,285);
			this.VlgCoords[4] = new Array(88,128);
			this.VlgCoords[5] = new Array(341,297);
			this.VlgCoords[6] = new Array(151,153);
			this.VlgCoords[7] = new Array(24,178);
			this.VlgCoords[8] = new Array(94,100);
			this.VlgCoords[9] = new Array(214,54);
			this.VlgCoords[10] = new Array(152,63);
			this.VlgCoords[11] = new Array(291,40);
			this.VlgCoords[12] = new Array(134,40);
			this.VlgCoords[13] = new Array(166,40);
			this.VlgCoords[14] = new Array(242,98);
			this.VlgCoords[15] = new Array(311,97);
			this.VlgCoords[16] = new Array(456,43);
			this.VlgCoords[17] = new Array(398,188);
			this.VlgCoords[18] = new Array(76,147);
			this.VlgCoords[19] = new Array(63,34);
			this.VlgCoords[20] = new Array(62,198);
			this.VlgCoords[21] = new Array(186,86);
			break;
		case 2:
			this.VlgCoords[1] = new Array(245,143);
			this.VlgCoords[2] = new Array(316,32);
			this.VlgCoords[3] = new Array(102,19);
			this.VlgCoords[4] = new Array(178,168);
			this.VlgCoords[5] = new Array(231,82);
			this.VlgCoords[6] = new Array(122,211);
			this.VlgCoords[7] = new Array(140,267);
			this.VlgCoords[8] = new Array(268,225);
			this.VlgCoords[9] = new Array(92,161);
			this.VlgCoords[10] = new Array(59,112);
			this.VlgCoords[11] = new Array(426,265);
			this.VlgCoords[12] = new Array(297,81);
			this.VlgCoords[13] = new Array(341,133);
			this.VlgCoords[14] = new Array(179,26);
			this.VlgCoords[15] = new Array(61,273);
			this.VlgCoords[16] = new Array(235,185);
			this.VlgCoords[17] = new Array(133,94);
			this.VlgCoords[18] = new Array(187,122);
			break;
		case 3:
			this.VlgCoords[1] = new Array(223,31);
			this.VlgCoords[2] = new Array(281,149);
			this.VlgCoords[3] = new Array(275,132);
			this.VlgCoords[4] = new Array(61,215);
			this.VlgCoords[5] = new Array(323,212);
			this.VlgCoords[6] = new Array(307,224);
			this.VlgCoords[7] = new Array(336,167);
			this.VlgCoords[8] = new Array(254,159);
			this.VlgCoords[9] = new Array(400,180);
			this.VlgCoords[10] = new Array(298,241);
			this.VlgCoords[11] = new Array(223,229);
			this.VlgCoords[12] = new Array(419,191);
			this.VlgCoords[13] = new Array(341,190);
			this.VlgCoords[14] = new Array(355,165);
			this.VlgCoords[15] = new Array(174,220);
			this.VlgCoords[16] = new Array(121,209);
			this.VlgCoords[17] = new Array(138,107);
			this.VlgCoords[18] = new Array(202,119);
			this.VlgCoords[19] = new Array(159,93);
			this.VlgCoords[20] = new Array(249,259);
			break;
		case 4:
			this.VlgCoords[1] = new Array(137,130);
			this.VlgCoords[2] = new Array(450,204);
			this.VlgCoords[3] = new Array(304,296);
			this.VlgCoords[4] = new Array(271,80);
			this.VlgCoords[5] = new Array(404,205);
			this.VlgCoords[6] = new Array(94,169);
			this.VlgCoords[7] = new Array(124,211);
			this.VlgCoords[8] = new Array(138,89);
			this.VlgCoords[9] = new Array(237,109);
			this.VlgCoords[10] = new Array(172,24);
			this.VlgCoords[11] = new Array(13,188);
			this.VlgCoords[12] = new Array(10,47);
			this.VlgCoords[13] = new Array(134,18);
			this.VlgCoords[14] = new Array(103,33);
			this.VlgCoords[15] = new Array(447,256);
			this.VlgCoords[16] = new Array(387,290);
			this.VlgCoords[17] = new Array(282,91);
			this.VlgCoords[18] = new Array(36,215);
			this.VlgCoords[19] = new Array(108,66);
			this.VlgCoords[20] = new Array(24,98);
			this.VlgCoords[21] = new Array(4,122);
			this.VlgCoords[22] = new Array(44,32);
			this.VlgCoords[23] = new Array(73,83);
			break;
		case 5:
			this.VlgCoords[1] = new Array(277,138);
			this.VlgCoords[2] = new Array(436,113);
			this.VlgCoords[3] = new Array(334,44);
			this.VlgCoords[4] = new Array(242,23);
			this.VlgCoords[5] = new Array(20,182);
			this.VlgCoords[6] = new Array(125,18);
			this.VlgCoords[7] = new Array(417,206);
			this.VlgCoords[8] = new Array(225,112);
			this.VlgCoords[9] = new Array(363,79);
			this.VlgCoords[10] = new Array(114,147);
			this.VlgCoords[11] = new Array(112,82);
			this.VlgCoords[12] = new Array(157,126);
			this.VlgCoords[13] = new Array(362,279);
			this.VlgCoords[14] = new Array(225,198);
			this.VlgCoords[15] = new Array(398,29);
			this.VlgCoords[16] = new Array(294,106);
			this.VlgCoords[17] = new Array(256,86);
			this.VlgCoords[18] = new Array(236,270);
			this.VlgCoords[19] = new Array(13,59);
			this.VlgCoords[20] = new Array(121,282);
			this.VlgCoords[21] = new Array(229,130);
			this.VlgCoords[22] = new Array(164,164);
			this.VlgCoords[23] = new Array(347,137);
			break;
		case 6:
			this.VlgCoords[1] = new Array(277,138);
			this.VlgCoords[2] = new Array(436,113);
			break;
		case 7:
			this.VlgCoords[1] = new Array(340,205);
			this.VlgCoords[2] = new Array(210,17);
			this.VlgCoords[3] = new Array(341,297);
			this.VlgCoords[4] = new Array(88,100);
			this.VlgCoords[5] = new Array(409,316);
			this.VlgCoords[6] = new Array(20,218);
			this.VlgCoords[7] = new Array(134,10);
			this.VlgCoords[8] = new Array(82,218);
			this.VlgCoords[9] = new Array(10,138);
			this.VlgCoords[10] = new Array(155,150);
			this.VlgCoords[11] = new Array(5,95);
			this.VlgCoords[12] = new Array(17,60);
			this.VlgCoords[13] = new Array(242,98);
			this.VlgCoords[14] = new Array(30,175);
			this.VlgCoords[15] = new Array(290,93);
			this.VlgCoords[16] = new Array(447,262);
			this.VlgCoords[17] = new Array(155,185);
			this.VlgCoords[18] = new Array(90,170);
			this.VlgCoords[19] = new Array(70,54);
			this.VlgCoords[20] = new Array(356,32);
			this.VlgCoords[21] = new Array(3,275);
			// recherches affichent une img?
			this.SrcCoords[15] = new Array(75,0);
			this.SrcCoords[16] = new Array(0,22);
			break;
		}
	}
};

