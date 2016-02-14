<if cond='!|{unt_act}|'>
<if cond='{unt_type}'>
	<h2>Gerer les {unt[{session_user[race]}][alt][{unt_type}]}</h2>
	Actions possibles :
	<form method="post" action="index.php?file=unt&act=pend&unt_type={unt_type}">
	<fieldset><legend>Pendaison.</legend>
	<img class="left" src="img/{session_user[race]}/div/pendre.png" alt="Pendre" />
	<label for="nb">Nombre</label>
	<input type="text" name="unt_nb" id="nb" />
	<input type="submit" value="Pendez les !!!" />
	</fieldset>
	</form>
	<form method="post" action="index.php?file=btc&amp;act=use&amp;btc_type={btc_type}&amp;sub=add_unt">
	<fieldset><legend>Former/Entrainer.</legend>
	<img class="left" src="img/{session_user[race]}/btc/{btc_type}.png" alt="{btc[{session_user[race]}][alt][{btc_type}]}" title="{btc[{session_user[race]}][alt][{btc_type}]}" />
	<label for="nb">Nombre</label>
	<input type="hidden" name="type" value="{unt_type}" />
	<input type="text" name="nb" id="nb" />
	<input type="submit" value="Ok" />
	</fieldset>
	</form>
</if>
<if cond='is_array(|{unt_dispo}|)'>
   <p class="infos">Les unités "disponibles" sont celles qui ne travaillent pas dans un bâtiment et qui ne sont pas dans une légion, "Total" indique la somme des unités disponibles et de celles qui ne le sont pas.</p> 
   <table class="border1">
   <tr>
    <th>Type</th>
    <th>Disponibles</th>
    <th>Total</th>
    <th>Infos</th>
   </tr>
   <foreach cond='|{unt_dispo}| as |{unt_id}| => |{unt_array}|'>

    <if cond='|{unt_array[dispo]}| <= 2 OR (|{unt_infos[0][{unt_id}][unt_nb]}| + |{unt_infos[1][{unt_id}][unt_nb]}|) >= 0'>
      <tr>
      <td>
      <a href="index.php?file=unt&unt_type={unt_id}" title="Gerer les {unt[{session_user[race]}][alt][{unt_id}]}">
      <img src="img/{session_user[race]}/unt/{unt_id}.png" alt="{unt[{session_user[race]}][alt][{unt_id}]}"  />
      </a>
      {unt[{session_user[race]}][alt][{unt_id}]}
      </td>      
	      <td>{unt_infos[1][{unt_id}][unt_nb]}</td><td><math oper='({unt_infos[0][{unt_id}][unt_nb]} + {unt_infos[1][{unt_id}][unt_nb]})' /></td>
      <td>
      {types[{unt_array[vars][type]}]}
      
      <if cond="|{unt_array[vars][defense]}| OR |{unt_array[vars][attaque]}| OR |{unt_array[vars][attaquebat]}|">
      ({roles[{unt_array[vars][role]}]})
      [
      <if cond="{unt_array[vars][defense]}">{unt_array[vars][defense]}<img src="img/{session_user[race]}/div/def.png" alt="Defense" title="Defense" /> </if>
      <if cond="{unt_array[vars][attaque]}">{unt_array[vars][attaque]}<img src="img/{session_user[race]}/div/atq.png" alt="Attaque" title="Attaque" /> </if>
      <if cond="{unt_array[vars][attaquebat]}">{unt_array[vars][attaquebat]}<img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bat" title="Attaque Bat" /> </if>
      ]
      </if>
	</td>
      </tr>
    </if>
  </foreach>
  </table>
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