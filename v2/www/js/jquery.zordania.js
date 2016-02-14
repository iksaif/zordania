/* zordania fonctions jQuery */

$(document).ready(  function()
{
	/* un élément avec id et classe 'toggle' permet
     * d'afficher / masquer un élément 'id_toggle'
	 * tous sont masqués au chargement (fin du index.tpl)
	 */

	// Lorsqu'un lien a.toggle est cliqué
	$("a.toggle").click(function() {
		$("#"+$(this).attr('id')+"_toggle" ).toggle('slide');
		return false;
	});
	// Lorsqu'une image .toggle est cliquée
	$("img.toggle").click(function() {
		$("#"+$(this).attr('id')+"_toggle" ).toggle('slide');
		var src=($(this).attr('src')==='img/plus.png'?'img/minus.png':'img/plus.png');
		$(this).attr('src',src);
	});

	// Lorsqu'un button #preview est cliqué
	// forum shoot et shoot diplo
	$("input#btpreview").click(function ()
	{
		$.post(
			cfg_url+"ajax--forum-post.html", 
			$("form#newpost").serialize(), 
			function(txt){ $("#preview").html(txt); }
		);
	});

});

/*
* jQuery ajax get
* variable globale = cfg_url
* GET, pas de data, la réponse est renvoyée dans un id "output"
*/
function jqShowMod(module, output) {
	$.ajax({
		url: cfg_url+"ajax--"+module,
		success: function(html) {
			$("#"+output).html(html);
		}
	});
	return false;
}

/*
 * pour le déménagement: gen.tpl et member/admin.tpl
 * le formulaire contient map_x et map_y ou map_cid
 * le bouton affiche le preview de map dans #carte_infos
 */
function showMapInfo() {
	var cid = $("#map_cid").val();
	if(cid.length==0){
		var map_x = $("#map_x").val();
		var map_y = $("#map_y").val();
		if(map_x.length==0 && map_y.length==0){
			alert('faut donner le map_cid OU les coordonnées X/Y à vérifier!');
			return false;
		}
		var url = "carte-view.html?map_x=" + map_x + '&map_y=' + map_y;
	}else{
		var url = "carte-view.html?map_cid=" + cid;
	}

	jqShowMod(url,'carte_infos');
	return false;
}

