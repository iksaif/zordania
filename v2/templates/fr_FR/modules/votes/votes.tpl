<if cond="isset({vote_ok})">
        <if cond="{vote_ok}">
                <p class="ok">vote enregistré !</p>
        </if>
        <else>
                <p class="error">Erreur : vote non enregistré.</p>
        </else> 
</if>
<else>
 
<h2>Votez pour Zordania <!--et achetez des récompenses!--></h2>
 
<h4>Votes</h4> 
 
<script type="text/javascript">
<!-- // jquery sur les formulaires de vote
$(document).ready(function()
{
        // Lorsqu'un formulaire est soumis
        $("form.vote").submit(function(event) {
 
                // bloquer l'envoi
                event.preventDefault(); 
 
                // nouvelle fenetre pour le site de vote
                var urlVote = $(this).attr('action');
                window.open(urlVote);
 
                // compter le vote
                var hiddenid = $(this).attr( 'id' ) + 'vid';
                var hiddenvalue = $( "#" + hiddenid ).val();
                var urlCpte = 'ajax--votes.html?vid=' + hiddenvalue;
 
                $.get( urlCpte, 
                        function( data ) {
                                //alert(data);
                                $( "#ajaxVote" ).html( data);
                                //$(this).submit();
                        }
                );
 
        });
 
});
// -->
</script>
 
 
<table>
 
<tr>
        <foreach cond="{votes_conf} as {vid} => {vote_conf}">
                <td>
                        <form id="form{vid}" action="{vote_conf[url]}" method="get" target="_blank" class="vote">
                        <input type="hidden" id="form{vid}vid" name="form{vid}vid" value="{vid}"/>
                        <input src="{vote_conf[img]}" type="image" value="submit" />
                        </form>
                </td>
        </foreach>
</tr>
 
<tr>
        <foreach cond="{votes_conf} as {vid} => {vote_conf}">
                <td>
                        <if cond="isset({votes_array[{vid}]})">
                                {votes_array[{vid}][votes_nb]}
                        </if>
                        <else>0</else>
                </td>
        </foreach>
</tr>
 
</table>
 
<div id="ajaxVote"></div>
 
<!--<h4>Boutique</h4>-->
 
 
</else>
