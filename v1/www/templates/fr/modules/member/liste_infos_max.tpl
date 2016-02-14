<if cond="|{session_user[race]}| != |{mbr_array[mbr_race]}|">
<load file="race/{mbr_array[mbr_race]}.config" />
<load file="race/{mbr_array[mbr_race]}.descr.config" />
</if>
<hr />
<h2>Ressources :</h2>
<table class="border1">
 <tr>
 <td>
  <h3>Finies</h3>
  <if cond='is_array(|{res_array_fini}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   	<th>Nombre</th>
   </tr>
   <foreach cond='|{res_array_fini}| as |{res_type}| => |{res_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/res/{res_type}.png" title="{res[{mbr_array[mbr_race]}][alt][{res_type}]}" alt="{res[{mbr_array[mbr_race]}][alt][{res_type}]}" /></td>
   	<td>{res_array[res_nb]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else>
 </td>
 <td>
  <h3>En Cours</h3>
  <if cond='is_array(|{res_array_encours}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   	<th>Nombre</th>
   	<th>Btc</th>
   </tr>
   <foreach cond='|{res_array_encours}| as |{res_type}| => |{res_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/res/{res_type}.png" title="{res[{mbr_array[mbr_race]}][alt][{res_type}]}" alt="{res[{mbr_array[mbr_race]}][alt][{res_type}]}" /></td>
   	<td>{res_array[res_nb]}</td>
   	<td>{res_array[res_btc]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else> 
 </td>
 </tr>
</table>

<h2>Unités :</h2>
<table class="border1">
 <tr>
 <td>
  <h3>Finies Pas Dispo</h3>
  <if cond='is_array(|{unt_array_fini[0]}|)'>
   <table class="border1">
   <tr>
   	<th>Type</td>
   	<th>Nombre</th>
   	<th>Légion</th>
   </tr>
   <foreach cond='|{unt_array_fini[0]}| as |{unt_type}| => |{unt_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/unt/{unt_type}.png" title="{unt[{mbr_array[mbr_race]}][alt][{unt_type}]}" alt="{unt[{mbr_array[mbr_race]}][alt][{unt_type}]}" /></td>
   	<td>{unt_array[unt_nb]}</td>
   	<td>{unt_array[unt_lid]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else>
  <h3>Finies Dispo</h3>
  <if cond='is_array(|{unt_array_fini[1]}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   	<th>Nombre</th>
   	<th>Légion</th>
   </tr>
   <foreach cond='|{unt_array_fini[1]}| as |{unt_type}| => |{unt_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/unt/{unt_type}.png" title="{unt[{mbr_array[mbr_race]}][alt][{unt_type}]}" alt="{unt[{mbr_array[mbr_race]}][alt][{unt_type}]}" /></td>
   	<td>{unt_array[unt_nb]}</td>
   	<td>{unt_array[unt_lid]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else>
 </td>
 <td>
  <h3>En Cours</h3>
  <if cond='is_array(|{unt_array_encours[0]}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   	<th>Nombre</th>
   	<th>Légion</th>
   </tr>
   <foreach cond='|{unt_array_encours[0]}| as |{unt_type}| => |{unt_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/unt/{unt_type}.png" title="{unt[{mbr_array[mbr_race]}][alt][{unt_type}]}" alt="{unt[{mbr_array[mbr_race]}][alt][{unt_type}]}" /></td>
   	<td>{unt_array[unt_nb]}</td>
   	<td>{unt_array[unt_lid]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else> 
 </td>
 </tr>
</table>

<h2>Recherches :</h2>
<table class="border1">
 <tr>
 <td>
  <h3>Finies</h3>
  <if cond='is_array(|{src_array_fini}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   </tr>
   <foreach cond='|{src_array_fini}| as |{src_type}| => |{src_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/src/{src_type}.png" title="{src[{mbr_array[mbr_race]}][alt][{src_type}]}" alt="{src[{mbr_array[mbr_race]}][alt][{src_type}]}" /></td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else>
 </td>
 <td>
  <h3>En Cours</h3>
  <if cond='is_array(|{src_array_encours}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   	<th>Tours</th>
   </tr>
   <foreach cond='|{src_array_encours}| as |{src_type}| => |{src_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/src/{src_type}.png" title="{src[{mbr_array[mbr_race]}][alt][{src_type}]}" alt="{src[{mbr_array[mbr_race]}][alt][{src_type}]}" /></td>
   	<td>{src_array[src_tour]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else> 
 </td>
 </tr>
</table>

<h2>Batiments :</h2>
<table class="border1">
 <tr>
 <td>
  <h3>Finis</h3>
  <if cond='is_array(|{btc_array_fini}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   	<th>Nombre</th>
   </tr>
   <foreach cond='|{btc_array_fini}| as |{btc_type}| => |{btc_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/btc/{btc_type}.png" title="{btc[{mbr_array[mbr_race]}][alt][{btc_type}]}" alt="{btc[{mbr_array[mbr_race]}][alt][{btc_type}]}" /></td>
      	<td>{btc_array[btc_nb]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else>
 </td>
 <td>
  <h3>En Cours</h3>
  <if cond='is_array(|{btc_array_encours}|)'>
   <table class="border1">
   <tr>
   	<th>Type</th>
   	<th>Tours</th>
   </tr>
   <foreach cond='|{btc_array_encours}| as |{btc_type}| => |{btc_array}|'>
      <tr>
   	<td><img src="img/{mbr_array[mbr_race]}/btc/{btc_type}.png" title="{btc[{mbr_array[mbr_race]}][alt][{btc_type}]}" alt="{btc[{mbr_array[mbr_race]}][alt][{btc_type}]}" /></td>
   	<td>{btc_array[btc_tour]}</td>
      </tr>
   </foreach>
   </table>
  </if>
  <else>
   Rien
  </else> 
 </td>
 </tr>
</table>