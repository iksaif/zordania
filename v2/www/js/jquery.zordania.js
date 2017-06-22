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
	
    // réponse ajax dans la page
	// module unt, formation des unités
	$("table#showUntForm a").each(function(){
		$(this).click(function(){
            $(".jqBlock").remove(); // virer l'ancienne requete ajax
            var url = $(this).attr('href');
            var output = $(this).parents('tr');
            var len = output.children('td').length;
            output.after('<tr class="jqBlock"><td id="ajaxContent" colspan="' + len + '"></td></tr>');
			jqShowMod(url, $('#ajaxContent'));
			return false;
		});
	});

    // Commerce - achat : module/fr/btc/inc/com.tpl - Lorsqu'un lien a.com est cliqué
    $("table#showComForm a").each(function(){
		$(this).click(function(){
            var url = $(this).attr('href');
            var output = $(this).parents('tr');
            var len = output.children('td').length;
            output.html('<td colspan="' + len + '"></td>');
			jqShowMod(url, output.children());
			return false;
		});
	});
        
        
	traiterFormulaires();
    
    // réponse ajax dans une popup
    traiterZrdPopUp();
    
});


function traiterFormulaires(){
	$("form.ajax").each(function(){
		$(this).submit(function(event){
			// Stop form from submitting normally
			event.preventDefault();

			// Get some values from elements on the page:
			var $form = $( this ),
			term = $form.serialize(),
			url = "ajax--" + $form.attr( "action" );

			$form.attr("action", url);
			// Send the data using post
			$.post( url, term, function(data){
				$("#output").html(data);
			});


		});
	});
}

/*
* jQuery ajax get
* variable globale = cfg_url
* module = url cible de la requete ajax
* GET, pas de data, la réponse est renvoyée dans le html du jquery ouput
*/
function jqShowMod(module, output) {
	$.ajax({
		url: cfg_url+"ajax--"+module,
		success: function(html) {
            output.html(html);
			// gérer les nouveaux formulaires & popup
			traiterFormulaires();
            traiterZrdPopUp();
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

	jqShowMod(url,$('#carte_infos'));
	return false;
}

// ce script pilote les popup ajax
// unt.html
function traiterZrdPopUp() {
    
    $(".zrdPopUp").each(function(){
        
        $(this).click(function(){ // au clic sur le lien

            var url = $(this).attr('href');
            var title = $(this).attr('title');
            console.log('popup ' + title + ' vers url=' + url);
            var output = $("#dialog-modal");
            $.ajax({
                url: cfg_url+"ajax--"+url,
                success: function(html) {
                    output.html(html);
                    output.dialog({ // popup
                        buttons: [{
                            text: "Fermer", // bouton annuler
                            click: function() {
                            $( this ).dialog( "close" );}
                        }],
                        title: title
                    });
                }
            });
            return false;
        });
    });
}
