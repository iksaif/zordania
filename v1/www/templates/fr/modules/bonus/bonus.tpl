<if cond='|{bon_error}| == "code_error"'>
 	<p class="error">Code Faux !</p>
</if>
<if cond='|{bon_act}| == "liste"'>
	<form method="post" action="index.php?file=bonus">
    	<fieldset><legend>Choix de la ressource.</legend>
    	<foreach cond='|{bon_list_res}| as |{res_id}| => |{res_nb}|'>
    		<label>
    		<input type="radio" name="bon_type_res" value="{res_id}" />
  		{res_nb} <img src="img/{session_user[race]}/res/{res_id}.png" alt="{res[alt][{res_id}]}" title="{res[alt][{res_id}]}" /> - {res[{session_user[race]}][alt][{res_id}]} 
  		</label>
    		<br />		
	</foreach> 
	<br />
	</fieldset>
	<br />
	<input type="submit" name="submit" value="Suivant >>" />
	</form>
</if>
<elseif cond='|{bon_act}| == "tel"'>
 <div class="center">
 <br />
 <script type="text/javascript">
 <!--
 function allopopup(palier)
 {
 window.open('http://www.allopass.com/show_accessv2.php4?PALIER='+palier+'&SITE_ID=57799&DOC_ID=149832','phone','toolbar=0,location=0,directories=0,status=0,scrollbars=0,resizable=0,copyhistory=0,menuBar=0,width=300,height=162');	
 }
 -->
 </script>
 <img src="http://www.allopass.com/img/acces_title.png" width="300" height="25" align="center" alt="Logo" />
 <br />
 <img name="acces_top" src="http://www.allopass.com/show_top.php4?SITE_ID=57799&DOC_ID=149832" width="300" height="137" alt="Allopass.com" />
 <br />
  <a href="javascript:allopopup(4);">
 <img src="http://www.allopass.com/img/flag_fr.png" width="35" height="29" alt="Fr"></a>
 <a href="javascript:allopopup(32768);">
 <img src="http://www.allopass.com/img/flag_be.png" width="35" height="29" alt="Be"></a>
 <a href="javascript:allopopup(64);">
 <img src="http://www.allopass.com/img/flag_ch.png" width="35" height="29" alt="Ch"></a>
 <a href="javascript:allopopup(256);">
 <img src="http://www.allopass.com/img/flag_ca.png" width="35" height="29" alt="Ca"></a>
 <a href="javascript:allopopup(16);">
 <img src="http://www.allopass.com/img/flag_de.png" width="35" height="29" alt="De"></a>
 <a href="javascript:allopopup(32);">
 <img src="http://www.allopass.com/img/flag_uk.png" width="35" height="29" alt="Uk"></a>
 <a href="javascript:allopopup(4096);">
 <img src="http://www.allopass.com/img/flag_lu.png" width="35" height="29" alt="Lu"></a>
<br />
 <form name="APform" action="http://www.allopass.com/check/index.php4" method="post">
 <input type="hidden" name="SITE_ID" value="57799" />
 <input type="hidden" name="DOC_ID" value="149832" />
 <input type="hidden" name="RECALL" value="1" />
 <input type="hidden" name="DATAS" value="{bon_type_res}" />
 <label for="CODE0">Entrez votre code d'accès</label>
 <input type="text" size="8" maxlength="10" value="" name="CODE0" id="CODE0" />
 <input type="button" name="APsub" value="Envoyer" onClick=" this.form.submit();this.form.APsub.disabled=true;" /> 
 </form>
 </div>
</elseif>
<elseif cond='|{bon_act}| == "donner"'>
	<if cond='|{bon_ok}|'>
 	<div class="ok">Code Ok ! Les ressources ({bon_nb_res} {res[alt][{bon_type_res}]})
 	 demandées on été transferées dans votre Donjon.</div>
	</if>
</elseif>