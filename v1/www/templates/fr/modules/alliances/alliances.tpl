<if cond="1 == 1">
	<p class="error">Une alliance ? Jeune seigneur vous n'avez plus d'ami, considérez vos voisins comme une menace !</p>
</if>
<else>
	<p class="menu_module">
	<if cond='|{session_user[alaid]}| > 0 AND |{al_act}| != "view"'>
	[ <a href="index.php?file=alliances&act=admin" title="Gestion de l'Alliance">Gestion</a> ]
	-
	[ <a href="index.php?file=alliances&act=my" title="Discuter, etc ...">Table ronde</a> ]
	-
	[ <a href="index.php?file=alliances&act=descr_rules" title="Decriptifs et Règles ...">Règles</a> ]
	-
	[ <a href="index.php?file=alliances&act=res" title="Stocks de ressources ...">Grenier</a> ]
	</if>
	<hr />
	</p>
	<if cond='|{al_act}| == "view"'>
		<if cond='count(|{al_array}|)'>
			<if cond='{al_logo}'>
				<img class="img_right blason" src="{al_logo}" alt="Blason" />
			</if>
			<h2>{al_array[al_name]}</h2>
			Chef : <a href="index.php?file=member&act=view&mid={al_array[al_mid]}" title="Infos sur {al_array[mbr_pseudo]}">{al_array[mbr_pseudo]}</a><br/>
			Points : {al_array[al_points]}<br/>
			<if cond='|{al_array[al_nb_mbr]}| < |{al_max_mbr_nb}| AND |{al_array[al_open]}| AND |{session_user[alaid]}| == 0'>
			<a href="index.php?file=alliances&act=join&al_aid={al_array[al_aid]}">
			<img src="img/join.png" alt="Rejoindre" title="Rejoindre {al_array[al_name]}" /> Rejoindre
			</a>
			</if>
			<br/>
		<h2>Liste des Joueurs</h2>
		<table class="border1">
		<tr>
		 <th>Id</th>
		 <th>Pseudo</th>
		 <th>Race</th>
		 <th>Population</th>
		 <th>Points</th>
		 <th>Distance</th>
		 <th>Actions</th>
		</tr>	 
		<foreach cond='|{al_mbr}| as |{result}|'>
		 <tr>
		 <td>{result[mbr_mid]}</td>
		 <if cond='|{al_array[al_mid]}| == |{result[mbr_mid]}|'>
		 <th>
			<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
			<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
		 </th>
		 </if>
		 <else>
		 <td>
			<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
			<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
		 </td>
		 </else>
		 <td><img src="img/{result[mbr_race]}/{result[mbr_race]}.png" title="{race[{result[mbr_race]}]}" alt="{race[{result[mbr_race]}]}"/></td>
		 <td>{result[mbr_population]}</td>
		 <td>{result[mbr_points]}</td>
		 <td>{result[mbr_dst]}</td>
			 <td>
			 <if cond='|{result[mbr_mid]}| != |{session_user[mid]}|'>
			<a href="index.php?file=msg&act=new&mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
				<img src="img/msg.png" alt="Msg" />
			</a>
		 </if>
		 <if cond='|{result[can_atq]}|'>
					-
					<a href="index.php?file=war&act=atq&mid={result[mbr_mid]}" title="Attaquer {result[mbr_pseudo]}">
					<img src="img/{session_user[race]}/div/atq.png" alt="Attaquer" />
					</a>
		 </if>
		 &nbsp;
		 </td>
		 </tr>
		</foreach>
		</table>	
		<hr/>
		<h2>Description</h2>
		{al_array[al_descr]}
		</if>
		<else>
			<p class="error">Cette Alliance n'existe pas.</p>
		</else>
	</if>
	<elseif cond='|{al_act}| == "my"'>
		<if cond='{al_no_al}'>
			<p class="infos">Vous n'êtes pas dans une Alliance.</p>
			<if cond='|{session_user[points]}| >= |{ALL_MIN_ADM_PTS}|'>
			<h2>Créer une Alliance</h2>
			Prix: {ALL_CREATE_PRICE} <img src="img/{session_user[race]}/res/{GAME_RES_PRINC}.png" alt="{res[{session_user[race]}][alt][{GAME_RES_PRINC}]}" title="{res[{session_user[race]}][alt][{GAME_RES_PRINC}]}" />
			<form action="index.php?file=alliances&act=new" method="post">
			<label for="al_name">Nom:</label>
			<input type="text" name="al_name" id="al_name" />
			<input type="submit" value="Créer" />
			</form>
			</if>
		</if>
		<elseif cond='{al_waiting}'>
			<p>Votre demande de rejoindre <a href="index.php?file=alliances&act=view&al_aid={al_array[al_aid]}" title="Infos sur {al_array[al_name]}">{al_array[al_name]}</a>
			 n'a pas encore été acceptée. Vous recevrez un message si vous êtes accepté.</p>
			 <a href="index.php?file=alliances&act=cancel" title="Annuler la demande">Annuler</a>
		</elseif>
		<else>
			<table class="border1">
			<tr>
			<td>	
				<if cond='{al_logo}'>
					<img class="img_right" src="{al_logo}" alt="Blason" />
				</if>
				<h2>{al_array[al_name]}</h2>
				Chef : <a href="index.php?file=member&act=view&mid={al_array[al_mid]}" title="Infos sur {al_array[mbr_pseudo]}">{al_array[mbr_pseudo]}</a><br/>
				Points : {al_array[al_points]}<br/>	
				<if cond='|{session_user[mid]}| != |{al_array[al_mid]}|'>
				<a href="index.php?file=alliances&act=part">Quitter l'Alliance</a>	
				</if>
			</td>
			<td>
			<h2>Liste des Joueurs</h2>
			<table class="border1">
			<tr>
			 <th>Pseudo</th>
			 <th>Pop</th>
			 <th>Points</th>
			 <th>Dst</th>
			 <th>Actions</th>
			</tr>	 
			<foreach cond='|{al_mbr}| as |{result}|'>
			 <tr>
			 <if cond='|{al_array[al_mid]}| == |{result[mbr_mid]}|'>
			 <th>
				<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
					<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
			</th>
			</if>
			<else>
			<td>
				<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
				<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
			</td>
			</else>
			<td>{result[mbr_population]}</td>
			<td>{result[mbr_points]}</td>
			<td>{result[mbr_dst]}</td>
				<td>
				<if cond='|{result[mbr_mid]}| != |{session_user[mid]}|'>
				<a href="index.php?file=msg&act=new&mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
					<img src="img/msg.png" alt="Msg" />
				</a>
				</if>
				<if cond='|{al_admin}| AND |{session_user[mid]}| != |{result[mbr_mid]}|'>
				-
				<a href="index.php?file=alliances&act=admin&sub=kick&mid={result[mbr_mid]}" title="Bannir {result[mbr_pseudo]} de l'Alliance">
					<img src="img/drop.png" alt="Drop" />
				</a>
				-
				<a href="index.php?file=alliances&act=admin&sub=chef&mid={result[mbr_mid]}" title="Donner le pouvoir à {result[mbr_pseudo]}">
					<img src="img/join.png" alt="Edit" />
				</a>
				</if>
			</td>
			</tr>
			</foreach>
			</table>	
		</td>
		</tr>
		</table>	
		<hr />
		<div class="block_1">
			<h2>ShootBox</h2>
			<if cond="{al_msg_del}">
				<p class="ok">Message supprimé !</p>
			</if>
			<if cond="{al_msg_post}">
				<p class="ok">Message posté !</p>
			</if>
			<form class="center" action="index.php?file=alliances&act=my&sub=post" method="post">
			<include file='commun/bbcode.tpl' cache='1' /><br/>
			<textarea id="message" name="al_shoot_msg" rows="5" cols="40"></textarea><br />
			<input type="submit" value="Envoyer" />
			</form>
					Page : <for cond='|{i}| = |{current_i}| ; |{i}| < |{al_nb}| AND |{i}|-|{current_i}| < |{limite_nb_page}|*|{limite_page}|; |{i}|+=|{limite_page}|'>
					<if cond='|{i}| / |{limite_page}| != |{al_page}|'>
						<a href="index.php?file=alliances&act=my&al_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
					</if>
					<else>
						<math oper='(({i} / {limite_page})+1)' />
					</else>
			</for>
			<if cond='is_array({al_shoot_array})'>
				<foreach cond='|{al_shoot_array}| as |{result}|'>
					<div class="block_1">
					<img class="img_right" title="{result[mbr_pseudo]}" src="img/mbr_logo/{result[shoot_mid]}.png" />
					<h3><a href="index.php?file=member&act=view&mid={result[shoot_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a> le {result[shoot_date_formated]}<br/></h3>
					<p>
					{result[shoot_texte]}
					</p>
					<p class="signature">{result[mbr_sign]}</p>
					<if cond="|{result[mbr_mid]}| == |{session_user[mid]}| OR |{al_admin}|">
						<a href="index.php?file=alliances&act=my&sub=del&msgid={result[shoot_msgid]}" title="Supprimer">
							<img src="img/drop.png" alt="Supprimer" title="Supprimer" />
						</a>
					</if>
					</div>
					<br />
				</foreach>
				
				Page : <for cond='|{i}| = |{current_i}| ; |{i}| < |{al_nb}| AND |{i}|-|{current_i}| < |{limite_nb_page}|*|{limite_page}|; |{i}|+=|{limite_page}|'>
					<if cond='|{i}| / |{limite_page}| != |{al_page}|'>
						<a href="index.php?file=alliances&act=my&al_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
					</if>
					<else>
						<math oper='(({i} / {limite_page})+1)' />
					</else>
				 </for>
			</if>
		</div>
		</else>
	</elseif>
	<elseif cond='|{al_act}| == "descr_rules"'>
	  <h2>Règles:</h2>
	  {al_array[al_rules]}
	  <h2>Description:</h2>
	  {al_array[al_descr]}
	</elseif>
	<elseif cond='|{al_act}| == "admin"'>
		<if cond='{al_not_admin}'>
			<p class="infos">Vous n'êtes pas chef de votre Alliance.</p>
		</if>
		<else>
			<if cond='!|{al_sub}|'>
				<p class="infos">Le Blason doit être une image de type {logo_type}, de taille inférieure ou égale à {logo_size} octets et {logo_x_y}px</p>
				<form class="block_1" enctype="multipart/form-data" action="index.php?file=alliances&act=admin&sub=logo" method="post">
				<if cond='{al_logo}'>
					<img class="img_right" src="{al_logo}" alt="Blason" />
				</if>
				Envoyez ce fichier: <input name="al_logo" type="file" />
				<input type="submit" value="Envoyer" />
				</form>
				<form class="block_1" action="index.php?file=alliances&act=admin&sub=param" method="post">
				<label for="al_open">Demandes Ouvertes:</label><br/>
				<input id="al_open" type="checkbox" name="al_open" value="1" <if cond='{al_array[al_open]}'>checked="checked"</if> /><label for="al_open">Oui</label><br/>
				<label for="al_name">Nom de l'Alliance:</label><br/>
				<input type="text" id="al_name" name="al_name" value="{al_array[al_name]}" disabled="disabled"/><br />
				<label for="message">Description</label><br/>
				<include file='commun/bbcode.tpl' cache='1' /><br/>
				<textarea id="message" cols="60" rows="11" name="al_descr">{al_array[al_descr]}</textarea> 
				<br/>
				<label for="message2">Règles</label><br/>
				<textarea id="message2" cols="60" rows="11" name="al_rules">{al_array[al_rules]}</textarea> 
				<input type="submit" value="Enregistrer" />
				</form>
				<hr />
				<a href="index.php?file=alliances&act=admin&sub=del">Détruire l'Alliance</a>
				
				<if cond='count(|{al_mbr}|)'>
				<h2>Liste des Joueurs en Attente</h2>
			<table class="border1">
			<tr>
			 <th>Id</th>
			 <th>Pseudo</th>
			 <th>Population</th>
			 <th>Points</th>
			 <th>Actions</th>
			</tr>	 
			<foreach cond='|{al_mbr}| as |{result}|'>
			 <tr>
			 <td>{result[mbr_mid]}</td>
			 <if cond='|{al_array[al_mid]}| == |{result[mbr_mid]}|'>
			 <th>
				<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
					<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
			</th>
			</if>
			<else>
			<td>
				<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
				<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
			</td>
			</else>
			<td>{result[mbr_population]}</td>
			<td>{result[mbr_points]}</td>
				<td>
				<a href="index.php?file=msg&act=new&mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
					<img src="img/msg.png" alt="Msg" />
				</a>
				-
				<a href="index.php?file=alliances&act=admin&sub=accept&mid={result[mbr_mid]}" title="Accepter {result[mbr_pseudo]}">
					<img src="img/join.png" alt="Join" />
				</a>
				-
				<a href="index.php?file=alliances&act=admin&sub=refuse&mid={result[mbr_mid]}" title="Refuser {result[mbr_pseudo]}">
					<img src="img/drop.png" alt="Refuse" />
				</a>
			</td>
			</tr>
			</foreach>
			</table>	
			</if>
			</if>
			<if cond='|{al_sub}| == "logo"'>
				<if cond='{al_logo}'>
					<p class="ok">Ok, blason uploadé !</p>
				</if>
				<else>
					<p class="error">Taille ou type de fichier incorrect.</p>
				</else>
			</if>
		</else>
		<if cond='|{al_sub}| == "param"'>
			<if cond='{al_param}'>
				<p class="ok">Paramètres enregistrés.</p>
			</if>
			<else>
				<p class="error">Erreur.</p>
			</else>
		</if>
		<if cond='|{al_sub}| == "accept"'>
			<if cond='{al_full}'>
				<p class="error">Alliance pleine.</p>
			</if>
			<elseif cond='{al_ok}'>
				<p class="ok">Ok. {al_pseudo} accepté !</p>
			</elseif>
			<elseif cond='|{al_bad_mid}| OR |{al_no_mid}|'>
				<p class="error">Ce membre n'existe pas ou ne demande pas à entrer dans votre Alliance.</p>
			</elseif>
		</if>
		<if cond='|{al_sub}| == "refuse"'>
			<if cond='{al_ok}'>
				<p class="ok">Ok. {al_pseudo} refusé !</p>
			</if>
			<elseif cond='|{al_bad_mid}| OR |{al_no_mid}|'>
				<p class="error">Ce membre n'existe pas ou ne demande pas à entrer dans votre Alliance.</p>
			</elseif>
		</if>
		<if cond='|{al_sub}| == "kick"'>
			<if cond='{al_ok}'>
				<p class="ok">Ok. {al_pseudo} bannit !</p>
			</if>
			<elseif cond='|{al_bad_mid}| OR |{al_no_mid}|'>
				<p class="error">Ce membre n'existe pas ou n'est pas dans votre Alliance.</p>
			</elseif>
		</if>
		<if cond='|{al_sub}| == "chef"'>
			<if cond='{al_ok}'>
				<p class="ok">Ok. {al_pseudo} dirige maintenant l'Alliance !</p>
			</if>
			<elseif cond='|{al_bad_mid}| OR |{al_no_mid}|'>
				<p class="error">Ce membre n'existe pas ou n'est pas dans votre Alliance.</p>
			</elseif>
				<else>
				<div class="infos">Êtes vous sûr de vouloir donner le pouvoir à {al_pseudo} ? </div>
				<form action="index.php?file=alliances&act=admin&sub=chef&mid={mbr_mid}" method="post">
					<input type="submit" name="ok" value="Oui" />
				</form> 
				</else>
		</if>
		<if cond='|{al_sub}| == "del"'>
			<if cond='|{al_del}| === "need_ok"'>
				<p class="error">
				 Attention ! Toutes les ressources dans le Grenier seront perdus !
				</p>
				<p class="infos">Êtes vous sûr de vouloir détruire votre alliance ?
				<form action="index.php?file=alliances&act=admin&sub=del" method="post">
				<input type="submit" name="ok" value="ok" />
				</form>
				</p>
			</if>
			<elseif cond='|{al_del}|'>
				<p class="ok">Ok. Alliance supprimée !</p>
			</elseif>
			<else>
				<p class="error">Cette alliance n'existe pas.</p>
			</else>
		</if>
	</elseif>
	<elseif cond='|{al_act}| == "new"'>
		<if cond='{al_not_enought_pts}'>
			<p class="infos">Il faut au minimum {al_not_enought_pts}pts pour créer une Alliance.</p>
		</if>
		<elseif cond='{al_not_enought_gold}'>
			<p class="infos">Il faut au minimum  {ALL_CREATE_PRICE} <img src="img/{session_user[race]}/res/{GAME_RES_PRINC}.png" alt="{res[{session_user[race]}][alt][{GAME_RES_PRINC}]}" title="{res[{session_user[race]}][alt][{GAME_RES_PRINC}]}" /> pour créer une Alliance.</p>
		</elseif>
		<elseif cond='{al_name_not_correct}'>
			<p class="infos">Nom incorrect, seul les lettres et les chiffres sont autorisés.</p>
		</elseif>
		<elseif cond='{al_new}'>
			<p class="ok">Ok Alliance créée.</p>
		</elseif>
		<else>
			<p class="error">Faut préciser un nom !</p>
		</else>
	</elseif>
	<elseif cond='|{al_act}| == "join"'>
		<if cond='{al_not_enought_pts}'>
			<p class="infos">Il faut au minimum {al_not_enought_pts}pts pour rejoindre une Alliance.</p>
		</if>
		<elseif cond='{al_bad_aid}'>
			<p class="error">Cette Alliance n'existe pas.</p>
		</elseif>
		<elseif cond='{al_full}'>
			<p class="error">Alliance pleine, ou demandes fermées.</p>
		</elseif>
		<elseif cond='{al_join}'>
			<p class="ok">Demande envoyée.</p>
		</elseif>
		<else>
			<p class="error">Demande impossible, une autre est déjà en cours !</p>
		</else>
	</elseif>
	<elseif cond='|{al_act}| == "part"'>
		<if cond='{al_no_al}'>
			<p class="error">Vous n'êtes pas dans une Alliance.</p>
		</if>
		<elseif cond='{al_part}'>
			<p class="ok">Ok, vous avez bien quitté cette Alliance.</p>
		</elseif>
		<else>
			<p class="infos">Le Chef d'une Alliance ne peut pas fuir !</p>
		</else>
	</elseif>
	<elseif cond='|{al_act}| == "cancel"'>
		<if cond='{al_cancel}'>
			<p class="ok">Ok, vous avez bien annulé votre demande.</p>
		</if>
		<else>
			<p class="error">Vous ne faites aucune demande !</p>
		</else>
	</elseif>
	<elseif cond='|{al_act}| == "res"'>

	<div class="infos">
	Pensez a ne pas laisser le grenier trop plein si vous acceptez des membres inconnus.
	<strong>Tout retrait abusif doit être dénoncé et sera puni (suppression de compte).</strong><br/>
	Dépôt minimal: {ALL_MIN_DEP}.
	</div>

	<if cond="|{al_sub}|== 'add' OR |{al_sub}|== 'res'">
		<if cond="{al_ok}">
		<p class="ok">
		Action Effectuée.
		</p>
		</if>
		<else>
		<p class="error">
		Impossible d'effectuer cette action, vous n'avez pas ce que vous voulez Envoyer/Retirer. De plus il est impossible de stoquer moins de {ALL_MIN_DEP} !
		</p>
		</else>
	</if>
	 
	<form method="post" action="index.php?file=alliances&act=res&sub=add">

	<label for="add_res_type">Type</label>
	<select name="res_type" id="add_res_type">
			<foreach cond='|{user_res}| as |{res_id}| => |{res_value}|'>
				<if cond='|{res_value[res_nb]}| > 0 AND |{list_res[{res_id}][vars][nobat]}| != true'>
				<option value="{res_id}"> 
				{res[{session_user[race]}][alt][{res_id}]} 		({res_value[res_nb]})
				</option>
				</if>
			</foreach>
	</select>

	<label for="add_res_nb">Nombre </label>
	<input type="text" id="add_res_nb" name="res_nb" />
	<input type="submit" value="Envoyer" /> (Taxes: <math oper="{ALL_TAX} *100" />%)
	</form>
	<hr />
	<table class="border1">
		<tr>
		<th>Type</th>
		<th>Nombre</th>
		<th>Actions</th>
		</tr>
		<foreach cond="|{res_array}| as |{result}|">
		<tr>
		<td>
			<img src="img/{session_user[race]}/res/{result[al_res_type]}.png" alt="{res[{session_user[race]}][alt][{result[al_res_type]}]}" title="{res[{session_user[race]}][alt][{result[al_res_type]}]}" />
			{res[{session_user[race]}][alt][{result[al_res_type]}]}
		</td>
		<td>{result[al_res_nb]}</td>
		<td>
			<form method="post" action="index.php?file=alliances&act=res&sub=ret">
			<input type="text" name="res_nb" />
			<input type="hidden" name="res_type" value="{result[al_res_type]}" />
			<input type="submit" value="Récuperer" />
			</form>
		</td>
		</tr>
		</foreach>
	</table>
	<hr/>
	<h2>Dernières actions</h2>
	<ul>
	<foreach cond="|{log_array}| as |{result}|">
	<li>
	Le {result[al_res_log_date_formated]} - 
	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
		<a href="index.php?file=member&act=view&mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
		 -
		<if cond="|{result[al_res_log_res_nb]}| > 0">
		<span class="gain">
		</if>
		<else>
		<span class="perte">
		</else>
		{result[al_res_log_res_nb]}
		</span>
		 <img src="img/{session_user[race]}/res/{result[al_res_log_res_type]}.png" alt="{res[{session_user[race]}][alt][{result[al_res_log_res_type]}]}" title="{res[{session_user[race]}][alt][{result[al_res_log_res_type]}]}" />
	</li>
	</foreach>
	</ul>
	</elseif>
	<p class="retour_module">[ <a href="index.php?file=alliances<if cond='|{al_act}| == "admin" OR |{al_act}| == "my"'>&act={al_act}</if>">Retour</a> ]</p>
</else>