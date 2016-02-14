<p class="menu_module">
[
<a href="index.php?file=war&amp;act=histo" title="Historique de vos attaques, et de celle de vos ennemis.">Journal de guerre</a>
]
- 
[
<a href="index.php?file=leg" title="Créer, Modifier, Déplacer vos Légions">Gestion des Légions</a>
] -
[
<a href="index.php?file=war&amp;act=atq" title="Attaquer un autre membre.">Attaquer</a>
] -
[
<a href="index.php?file=war&amp;act=enc" title="Voir les attaques en cours.">Attaques en cours</a>
]
<hr />

</p>

<if cond='|{war_act}| == "atq"'>
	<if cond='|{war_sub}| == "war_no_mid"'>
		<div class="infos">
		Veuillez choisir un membre à attaquer dans la 
		<a href="index.php?file=member&act=liste" title="Afficher la liste des joueurs">Liste</a> ou sur la 
		<a href="index.php?file=carte" title="Regarder la carte">Carte</a>.
		</div>
		<br/>
		<if cond='{pas_assez_de_pts}'>
		<div class="infos">
		Il vous faut au minimum {pas_assez_de_pts} pour attaquer quelqu'un !
		</div>
		</if>
		
	</if>
	<elseif cond='|{war_sub}| == "war_cant_atq"'>
		<div class="error">
		Impossible d'attaquer ce membre car 
		<if cond='|{war_can_atq}| == 3'>
		ce membre n'existe pas.
		</if>
		<elseif cond='|{war_can_atq}| == 2'>
		vous n'avez pas assez de points (il faut au minimum {atq_min_pts}).
		</elseif>
		<elseif cond='|{war_can_atq}| === 1'>
		son niveau est beaucoup plus faible que le votre.
		</elseif>
		</div>
	</elseif>
	<elseif cond='|{war_sub}| == "choix_leg"'>
	 	<if cond='count(|{leg_array}|) > 0'>
		<form method="post" action="index.php?file=war&act=atq&mid={atq_mid}">
			<foreach cond='|{leg_array}| as |{leg_id}| => |{leg_value}|'>
			<if cond='|{leg_value[leg_etat]}| == 0'>
			<set name="nb_leg" value="<maths oper='{nb_leg}+1' />" />
			<div class="list_univ">
				<input style="float: left;" type="radio" name="lid" value=" {leg_id}" />
  				Légion {leg_id} - Nom {leg_value[leg_name]}<br />
				Experience : {leg_value[leg_xp]} 
				 <br />
					<if cond='is_array(|{unt_array[{leg_id}]}|)'>
						<foreach cond='|{unt_array[{leg_id}]}| as |{unt_type}| => |{unt_value}|'>
						{unt_value[unt_nb]} <img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
						</foreach>
					</if>
					<else>
						<br />Aucune unité dans cette Légion - <a href="index.php?file=leg&act=del_leg&lid={leg_id}" title="Supprimer cette légion">Supprimer</a>
				
					</else>
				</div>
				</if>
			</foreach>
			<if cond='!|{nb_leg}|'>
			<p class="infos">Vous n'avez aucune légion libre ! </p>
			</if>
		<div class="center"><input type="submit" value="Attaquer" name="submit" /></div>
		</form>
		</if>
		<else>
			<p class="infos">Vous n'avez aucune légion disponible.</p>
		</else>
	</elseif>
	<elseif cond='|{war_sub}| == "war_atq"'>
		<if cond='|{war_ok}| == 1'>
			<p class="ok">Votre Légion est en route, dès qu'elle sera arrivée, vous devrez lui donner l'ordre d'attaquer !</p>
		</if>
		<elseif cond='|{war_ok}| == 2'>
			<p class="error">Cette Légion n'existe pas ou n'est pas disponible.</p>
		</elseif>
		<elseif cond='|{war_ok}| == 4'>
			<p class="error">Cette Légion est vide.</p>
		</elseif>
		<elseif cond='|{war_ok}| == 3'>
			<p class="error">Ce joueur n'existe pas.</p>
		</elseif>
	</elseif>
</if>
<elseif cond='|{war_act}| == "histo"'>
 <div class="infos">Ce journal est régulièrement vidé pour ne pas encombrer la base de donnée du site.
 </div>
 <br />
 <if cond='count(|{atq_array}|) > 0'>
 <foreach cond='|{atq_array}| as |{result}|'>
   <div class="list_univ">
   <if cond='|{result[atq_mid]}| != |{user_mid}|'>
    <h3><img src="img/{session_user[race]}/div/def.png" alt="def" title="Vous avez été attaqué" /> Vous avez été attaqué par {result[mbr_pseudo]}</h3>
    <if cond='(|{result[atq_atq_btc]}| < |{result[atq_def]}|) OR (|{result[atq_tues]}| AND |{result[atq_atq_unt]}| <  |{result[atq_def]}|)'>
    	<div class="victoire">Victoire</div>
    </if>
    <elseif cond='|{result[atq_btc]}| > 0'>
    	<div class="defaite">Défaite Partielle</div>
    </elseif>
    <else>
    	<div class="defaite">Défaite</div> 
    </else>
    Date : {result[atq_date_arv_formated]}
    <br/>
    Force d'attaque :
    <ul>
     <li>Unités: {result[atq_atq_unt]} <img src="img/{session_user[race]}/div/atq.png" alt="Attaque Unités" title="Attaque Unités" /></li>
     <li>Bâtiments: {result[atq_atq_btc]} <img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bâtiments" title="Attaque Bâtiments" /></li>
    </ul>
    Défense : {result[atq_def]} <img src="img/{session_user[race]}/div/def.png" alt="Défense" title="Défense" /><br/>
    ---<br/>
    Tués : {result[atq_morts]}
    <if cond='is_array(|{result[atq_unt_mid1]}|)'>
	<foreach cond='|{result[atq_unt_mid1]}| as |{leg_lid}| => |{leg_value}|'>
	 <foreach cond='|{leg_value}| as |{unt_type}| => |{unt_nb}|'>
	  <if cond='|{unt_nb}| > 0'>
	   {unt_nb}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
	  </if>
	 </foreach>
	</foreach>
    </if><br/>
    Pertes : <br/>
    <ul>
     <li>
     	Unités: {result[atq_tues]}
     	<if cond='is_array(|{result[atq_unt_mid2]}|)'>
	<foreach cond='|{result[atq_unt_mid2]}| as |{leg_lid}| => |{leg_value}|'>
	 <foreach cond='|{leg_value}| as |{unt_type}| => |{unt_nb}|'>
	  <if cond='|{unt_nb}| > 0'>
	   {unt_nb}<img src="img/{result[mbr_race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
	  </if>
	 </foreach>
	</foreach>
        </if>
    </li>
     <li>
        Bâtiments: {result[atq_btc]}
        <if cond='is_array(|{result[atq_btc_mid2]}|)'>
        <foreach cond='|{result[atq_btc_mid2]}| as |{btc_bid}| => |{btc_value}|'>
		<if cond="|{btc_value[btc_vie]}| <= 0">
		<img src="img/{result[mbr_race]}/btc/{btc_value[btc_type]}.png" alt="Bâtiment détruit" />
		</if>
	</foreach>
	</if>
     </li>
    </ul>
    Pillages : {result[atq_res1_nb]}<img src="img/{session_user[race]}/res/{result[atq_res1_type]}.png" alt="{res[alt][{result[atq_res1_type]}]}" title="{res[alt][{result[atq_res1_type]}]}" />
    Butin : {result[atq_res2_nb]}<img src="img/{session_user[race]}/res/{result[atq_res2_type]}.png" alt="{res[alt][{result[atq_res2_type]}]}" title="{res[alt][{result[atq_res2_type]}]}" />
   </if>
   <else>
    <h3><img src="img/{session_user[race]}/div/atq.png" alt="atq" title="Vous attaquez" />Vous avez attaqué {result[mbr_pseudo]}</h3>
    <if cond='(|{result[atq_atq_btc]}| > |{result[atq_def]}|) OR (|{result[atq_tues]}| AND |{result[atq_atq_unt]}| >  |{result[atq_def]}|)'>
    	<div class="victoire">Victoire</div>
    </if>
    <elseif cond='|{result[atq_btc]}| > 0'>
    	<div class="victoire">Victoire Partielle</div>
    </elseif>
    <else>
    	<div class="defaite">Défaite</div> 
    </else>
    Légion : {result[leg_name]}<br/>
    Date de Départ : {result[atq_date_dep_formated]}
    <br/>Date de la bataille : {result[atq_date_arv_formated]}
    <br/>
    ---<br/>
    Force d'attaque :
    <ul>
     <li>Unités: {result[atq_atq_unt]}  <img src="img/{session_user[race]}/div/atq.png" alt="Attaque Unités" title="Attaque Unités" /></li>
     <li>Bâtiments: {result[atq_atq_btc]}  <img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bâtiments" title="Attaque Bâtiments" /></li>
    </ul>
    Défense : {result[atq_def]} <br/>
    ---<br/>
    Pertes : {result[atq_morts]}
    <if cond='is_array(|{result[atq_unt_mid1]}|)'>
	<foreach cond='|{result[atq_unt_mid1]}| as |{leg_lid}| => |{leg_value}|'>
	 <foreach cond='|{leg_value}| as |{unt_type}| => |{unt_nb}|'>
	  <if cond='|{unt_nb}| > 0'>
	   {unt_nb}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
	  </if>
	 </foreach>
	</foreach>
    </if>
    <br/>
    Détruit : <br/>
    <ul>
     <li>
     	Unités: {result[atq_tues]}
     	<if cond='is_array(|{result[atq_unt_mid2]}|)'>
	<foreach cond='|{result[atq_unt_mid2]}| as |{leg_lid}| => |{leg_value}|'>
	 <foreach cond='|{leg_value}| as |{unt_type}| => |{unt_nb}|'>
	  <if cond='|{unt_nb}| > 0'>
	   {unt_nb}<img src="img/{result[mbr_race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
	  </if>
	 </foreach>
	</foreach>
        </if>
    </li>
     <li>
        Bâtiments: {result[atq_btc]}
        <if cond='is_array(|{result[atq_btc_mid2]}|)'>
        <foreach cond='|{result[atq_btc_mid2]}| as |{btc_bid}| => |{btc_value}|'>
		<if cond="|{btc_value[btc_vie]}| <= 0">
		<img src="img/{result[mbr_race]}/btc/{btc_value[btc_type]}.png" alt="Bâtiment détruit" />
		</if>
	</foreach>
	</if>
     </li>
    </ul>
    Butin : {result[atq_res1_nb]}<img src="img/{session_user[race]}/res/{result[atq_res1_type]}.png" alt="{res[alt][{result[atq_res1_type]}]}" title="{res[alt][{result[atq_res1_type]}]}" />
   </else>
   </div> 	    
 </foreach>

  <br />Page : 
  <for cond='|{i}| = 0; |{i}| < |{atq_nb}|; |{i}|+=|{limite_page}|'>
   <if cond='|{i}| / |{limite_page}| != |{war_page}|'>
   <a href="index.php?file=war&amp;act=histo&amp;war_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
   </if>
   <else>
   <math oper='(({i} / {limite_page})+1)' />
   </else>
  </for>
 </if>
</elseif>
<elseif cond='|{war_act}| == "enc"'>
 <if cond='count(|{atq_array}|) > 0'>
 <foreach cond='|{atq_array}| as |{result}|'>
   <div class="list_univ">
   <if cond='|{result[atq_mid]}| != |{user_mid}|'>
    <h3><img src="img/{session_user[race]}/div/def.png" alt="def" title="Vous allez être attaqué" />Vous allez être attaqué par {result[mbr_pseudo]}</h3>
    Distance : {result[atq_dst]} 
   </if>
   <else>
    <h3><img src="img/{session_user[race]}/div/atq.png" alt="atq" title="Vous attaquez" />Vous attaquez {result[mbr_pseudo]}</h3>
    
    Légion : {result[leg_name]}<br/>
    Vitesse : {result[atq_speed]}<br />
    Date de Départ : {result[atq_date_dep_formated]}<br />
    Distance : {result[atq_dst]}<br />
    Temps avant attaque : <math oper='ceil({result[atq_dst]} / {result[atq_speed]})' />H<br />
    ---<br/>
    Force d'attaque :
    <ul>
     <li>Unités: {result[atq_atq_unt]} <img src="img/{session_user[race]}/div/atq.png" alt="Attaque Unités" title="Attaque Unités" /></li>
     <li>Bâtiments: {result[atq_atq_btc]} <img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bâtiments" title="Attaque Bâtiments" /></li>
    </ul>
    ---<br/>
    [ <a href="index.php?file=war&amp;act=cancel&amp;aid={result[atq_aid]}" title="Rappeler vos hommes">Annuler</a> ]
    <if cond='|{result[mbr_atq_nb]}| >= |{ATQ_NB_MAX_PER_DAY}|'>
    - Barre des {ATQ_NB_MAX_PER_DAY} attaques journalières depassée pour ce membre.
    </if>
    <elseif cond='|{result[atq_dst]}| == 0'>
    [
     <a href="index.php?file=war&amp;act=make_attack&amp;sub=esp&amp;aid={result[atq_aid]}" title="Récupérer des informations sur les défenses de l'ennemi !">Espionner</a>
    ]
    -
    [ 
    <a href="index.php?file=war&amp;act=make_attack&amp;aid={result[atq_aid]}" title="Lancer l'attaque !">Attaquer</a>
    ] - Attaques possibles aujourd'hui: <math oper="({result[mbr_atq_nb]}-{ATQ_NB_MAX_PER_DAY})" />/{ATQ_NB_MAX_PER_DAY}
    </elseif>
   </else>
   </div> 	    
 </foreach>

  <br />Page : 
  <for cond='|{i}| = 0; |{i}| < |{atq_nb}|; |{i}|+=|{limite_page}|'>
   <if cond='|{i}| / |{limite_page}| != |{war_page}|'>
   <a href="index.php?file=war&amp;act=enc&amp;war_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
   </if>
   <else>
   <math oper='(({i} / {limite_page})+1)' />
   </else>
  </for>
 </if>
 <else>
  <p class="infos">Aucune attaque en ce moment.</p>
 </else>
</elseif>
<elseif cond='|{war_act}| == "cancel"'>
 <if cond='|{war_cancel}| == "ok"'>
 	<p class="ok">Attaque annulée, vos hommes sont sur le chemin du retour</p>
 </if>
 <elseif cond='|{war_cancel}| == "error"'>
 	<p class="error">Erreur, cette attaque n'existe probablement pas.</p>
 </elseif>
 <elseif cond='|{war_cancel}| == "no_aid"'>
 	<p class="error">Aucune attaque spécifiée</p>
 </elseif> 
</elseif>
<elseif cond='|{war_act}| == "make_attack"'>
	<if cond='|{no_atq_aid}| == true'>
	<p class="error">Cette légion n'attend aucun ordre !</p>
	</if>
	<elseif cond='|{atq_canceled}| == true'>
	<p class="infos">Le village était abandonné depuis des siècles, la légion est sur le chemin du retour ...</p>
	</elseif>
	<elseif cond='|{atq_esp_ok}| == true'>
	 <p class="infos">
	 Estimations de vos observateurs 
		<if cond="|{bilan_war[mid2_def_unt]}| > 0">
		<img src="img/{session_user[race]}/div/atq.png" alt="Défense Unités" title="Défense Unités" />
		{bilan_war[mid2_def_unt]}
		</if>
		<else>
		<img src="img/{session_user[race]}/div/atq_btc.png" alt="Défense Bâtiments" title="Défense Bâtiments" />
		{bilan_war[mid2_def_btc]}
		</else>
		.<br/>
		 [ <a href="index.php?file=war&amp;act=cancel&amp;aid={atq_aid}" title="Rappeler vos hommes">Annuler</a> ] 
		 - 
		 [  <a href="index.php?file=war&amp;act=make_attack&amp;aid={atq_aid}" title="Lancer l'attaque !">Attaquer</a> ]
	 </p>
	</elseif>
	<else>
	  <h2 class="center">Résumé de l'attaque contre {atq_array[mbr_pseudo]}</h2>
	  <div class="block_1">
	  <p>
	  
	  <if cond="{atq_esp}">
	  Vos observateurs on étés découverts par {atq_array[mbr_pseudo]} !<br/><br/>
	  </if>
	  
	  Vous attaquez avec :<br/>
	 	<foreach cond='|{unt_array}| as |{unt_type}| => |{unt_value}|'>
	  	{unt_value[unt_nb]}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
	 	</foreach>
	  <br/><br/>
	  Force d'attaque contre les unités : {atq_array[atq_atq_unt]}  <img src="img/{session_user[race]}/div/atq.png" alt="Attaque Unités" title="Attaque Unités" /><br/>
	  Force d'attaque contre les bâtiments : {atq_array[atq_atq_btc]}  <img src="img/{session_user[race]}/div/atq_btc.png" alt="Attaque Bâtiments" title="Attaque Bâtiments" /><br/>
	  <if cond='{bilan_war[bonus_atq]}'>
	  Bonus d'attaque : {bilan_war[bonus_atq]} 
	  </if>
	  </p>
	  
	  <p>
	  Défense de {atq_array[mbr_pseudo]} : {bilan_war[atq_def]} <img src="img/{session_user[race]}/div/def.png" alt="Défense" title="Défense" /><br/>
	  <if cond='{bilan_war[bonus_def]}'>
	  Bonus de défense : {bilan_war[bonus_def]}
	  </if>
	  </p>
	  
	  <p>
	  Vous perdez {bilan_war[atq_morts]} soldat(s).<br/>
	  <if cond='is_array(|{bilan_war[details_unt][{session_user[mid]}]}|)'>
	  <foreach cond='|{bilan_war[details_unt][{session_user[mid]}]}| as |{leg_lid}| => |{leg_value}|'>
	  	<foreach cond='|{leg_value}| as |{unt_type}| => |{unt_nb}|'>
	  	<if cond='|{unt_nb}| > 0'>
	  	{unt_nb}<img src="img/{session_user[race]}/unt/{unt_type}.png" alt="{unt[alt][{unt_type}]}" title="{unt[alt][{unt_type}]}" />
	  	</if>
	  	</foreach>
	  </foreach>
	  </if>
	  </p>
	  
	  <if cond='|{session_user[race]}| != |{atq_array[mbr_race]}|'>
	  	<load file="race/{atq_array[mbr_race]}.config" />
	  </if>	
	  <p>
	  Vos soldats tuent {bilan_war[atq_tues]} soldat(s).<br/>
	  <if cond='is_array(|{bilan_war[details_unt][{atq_array[atq_mid2]}]}|)'>
	  <foreach cond='|{bilan_war[details_unt][{atq_array[atq_mid2]}]}| as |{leg_lid}| => |{leg_value}|'>
	  	<foreach cond='|{leg_value}| as |{unt_type}| => |{unt_nb}|'>
	  	<if cond='|{unt_nb}| > 0'>
	  	{unt_nb} <img src="img/{atq_array[mbr_race]}/unt/{unt_type}.png" alt="Type: {unt_type}" />
	  	</if>
	  	</foreach>
	  </foreach>
	  </if>
	  </p>
	  
	  <p>
	  <if cond='is_array(|{bilan_war[details_btc]}|)'>
	  	<if cond='|{bilan_war[atq_btc]}| > 0'>
	  		Vos soldats détruisent {bilan_war[atq_btc]} bâtiment.<br/>
	  	</if>
	  	<foreach cond='|{bilan_war[details_btc]}| as |{btc_bid}| => |{btc_value}|'>
	  		<if cond="|{btc_value[btc_vie]}| <= 0">
	  		<img src="img/{atq_array[mbr_race]}/btc/{btc_value[btc_type]}.png" alt="Bâtiment détruit" />
	  		</if>
	  	</foreach>
	  	<br/>
	  	<if cond='|{bilan_war[atq_btc_end]}| > 0'>
	  		Vos soldats endommagent {bilan_war[atq_btc_end]} bâtiment.<br/>
	  	</if>
	  	<foreach cond='|{bilan_war[details_btc]}| as |{btc_bid}| => |{btc_value}|'>
	  		<if cond="|{btc_value[btc_vie]}| > 0">
	  		<img src="img/{atq_array[mbr_race]}/btc/{btc_value[btc_type]}.png" alt="Bâtiment endommagé" />
	  		</if>
	  	</foreach>
	  </if>
	  </p>  
	  
	  <p>
	  <strong>Butin:</strong>
	  	{bilan_war[atq_res1_nb]}<img src="img/{session_user[race]}/res/{bilan_war[atq_res1_type]}.png" alt="{res[alt][{bilan_war[atq_res1_type]}]}" title="{res[alt][{bilan_war[atq_res1_type]}]}" />
	  <br/>
	  <strong>Vos Soldats Laissent:</strong>
	  	{bilan_war[atq_res2_nb]}<img src="img/{session_user[race]}/res/{bilan_war[atq_res2_type]}.png" alt="{res[alt][{bilan_war[atq_res2_type]}]}" title="{res[alt][{bilan_war[atq_res2_type]}]}" />	  
	  
	  <if cond="|{bilan_war[atq_prod_nb]}| > 0">
	  <br/><strong>Bonus:</strong>
	  	{bilan_war[atq_prod_nb]}<img src="img/{session_user[race]}/res/{bilan_war[atq_prod_type]}.png" alt="{res[alt][{bilan_war[atq_prod_type]}]}" title="{res[alt][{bilan_war[atq_prod_type]}]}" />
	  </if>
	  </p>
	  
    <if cond='(|{atq_array[atq_atq_btc]}| > |{bilan_war[atq_def]}| AND !|{bilan_war[atq_tues]}|) OR (|{bilan_war[atq_tues]}| AND |{atq_array[atq_atq_unt]}| >  |{bilan_war[atq_def]}|)'>
    	<div class="victoire">Victoire</div>
    </if>
    <elseif cond='|{bilan_war[atq_btc]}| > 0'>
    	<div class="defaite">Défaite Partielle</div>
    </elseif>
    <else>
    	<div class="defaite">Défaite</div> 
    </else>
    </div>
	</else>
</elseif>