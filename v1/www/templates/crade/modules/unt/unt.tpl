<if cond='!|{unt_act}|'>
<if cond='{unt_type}'>
	<h2>Gerer les {unt[alt][{unt_type}]}</h2>
	Actions possibles :
	<form method="post" action="index.php?file=unt&act=pend&unt_type={unt_type}">
	<fieldset><legend>Pendaison.</legend>
	<img class="left" src="img/{session_user[race]}/div/pendre.png" alt="" />
	<label for="nb">Nombre</label>
	<input type="text" name="unt_nb" id="nb" />
	<input type="submit" value="Pendez les !!!" />
	</fieldset>
	</form>
	<form method="post" action="index.php?file=btc&amp;act=use&amp;btc_type={btc_type}&amp;sub=add_unt">
	<fieldset><legend>Former/Entrainer.</legend>
	<img class="left" src="img/{session_user[race]}/btc/{btc_type}.png" alt="" />
	<label for="nb">Nombre</label>
	<input type="hidden" name="type" value="{unt_type}" />
	<input type="text" name="nb" id="nb" />
	<input type="submit" value="Ok" />
	</fieldset>
	</form>
</if>
<if cond='is_array(|{unt_dispo}|)'>
   <p class="infos">Les unités "disponibles" sont celles qui ne travaillent pas dans un bâtiment et qui ne sont pas dans une légion, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
   <div style="height:500px;">
   <div style="width: 45%;float:left;">
   <foreach cond='|{unt_dispo}| as |{unt_id}| => |{unt_array}|'>
   
    <if cond='|{nb_is}|++'>
    </if>
    
    <if cond='|{unt_nb}| <= |{nb_is}|*2 AND !|{nb_ok}|'>
        </div>
        <div style="width: 45%;float:right;">
        <if cond='|{nb_ok}| = true'>
        </if>
    </if>
    <if cond='|{unt_array[dispo]}| <= 2'>
      <a href="index.php?file=unt&unt_type={unt_id}&only_file={no_html}" title="Gerer les {unt[alt][{unt_id}]}">
      <img src="img/{session_user[race]}/unt/{unt_id}.png" alt="{unt[alt][{unt_id}]}"  />
      </a> - 
	      <if cond='|{unt_infos[1][{unt_id}][unt_nb]}|'>
	      Disponibles: {unt_infos[1][{unt_id}][unt_nb]} / Total: <math oper='({unt_infos[0][{unt_id}][unt_nb]} + {unt_infos[1][{unt_id}][unt_nb]})' />
	      </if>
	      <elseif cond='|{unt_infos[0][{unt_id}][unt_nb]}|'>
	       Disponible: 0 / Total: {unt_infos[0][{unt_id}][unt_nb]}
	      </elseif>
	      <else>
	       Disponible: 0 / Total: 0
	      </else>
	          <br />
    </if>
  </foreach>
  </div>
  &nbsp;
  </div>
</if>
</if>
<elseif cond='|{unt_act}| == "pend"'>
	<if cond='|{unt_sub}| == "error"'>
		<p class="error">Erreur, il manque des paramètres.</p>
	</if>
	<elseif cond='|{unt_sub}| == "paspossible"'>
		<p class="error">Impossible de pendre des unités qui travaillent (civils dans les bâtiments, ou soldats dans les légions).</p>
	</elseif>
	<elseif cond='|{unt_sub}| == "ok"'>
		<p class="ok">Ok, ils ont bien été pendus !</p>
	</elseif>
</elseif>

<div class="retour_module">[ <a href="index.php?file=unt" title="Retour">Retour</a> ]</div>