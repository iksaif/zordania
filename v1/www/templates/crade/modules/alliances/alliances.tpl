<p class="menu_module">
<if cond='|{session_user[alaid]}| > 0'>
[ <a href="index.php?file=alliances&amp;act=admin" title="Gestion de l'Alliance">Gestion</a> ]
-
[ <a href="index.php?file=alliances&amp;act=my" title="Discuter, etc ...">Table ronde</a> ]
-
[ <a href="index.php?file=alliances&amp;act=descr_rules" title="Decriptifs et Règles ...">Règles</a> ]
</if>
<hr />
</p>
<if cond='|{al_act}| == "view"'>
	<if cond='count(|{al_array}|)'>
		<if cond='{al_logo}'>
			<img class="img_right blason" src="{al_logo}" alt="Blason" />
		</if>
		<h2>{al_array[al_name]}</h2>
		Chef : <a href="index.php?file=member&amp;act=view&amp;mid={al_array[al_mid]}" title="Infos sur {al_array[mbr_pseudo]}">{al_array[mbr_pseudo]}</a><br/>
		Points : {al_array[al_points]}<br/>
		<if cond='|{al_array[al_nb_mbr]}| < |{al_max_mbr_nb}| AND |{al_array[al_open]}| AND |{session_user[alaid]}| == 0'>
		<a href="index.php?file=alliances&amp;act=join&amp;al_aid={al_array[al_aid]}">
		<img src="img/join.png" alt="Rejoindre" title="Rejoindre {al_array[al_name]}" /> Rejoindre
		</a>
		</if>
		<br/>
  	<h2>Liste des Joueurs</h2>
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
  	 	<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </th>
  	 </if>
  	 <else>
  	 <td>
  	 	<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
  	 	<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 </td>
  	 </else>
  	 <td>{result[mbr_population]}</td>
  	 <td>{result[mbr_points]}</td>
		 <td>
		 <if cond='|{result[mbr_mid]}| != |{session_user[mid]}|'>
  	 	<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
  	 		<img src="img/msg.png" alt="" />
  	 	</a>
  	 </if>
  	 <if cond='|{result[can_atq]}|'>
				-
				<a href="index.php?file=war&amp;act=atq&amp;mid={result[mbr_mid]}" OnClick="lien_bg(this.href);return false;" title="Attaquer {result[mbr_pseudo]}">
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
		<form action="index.php?file=alliances&amp;act=new" method="post">
		<label for="al_name">Nom:</label>
		<input type="text" name="al_name" id="al_name" />
		<input type="submit" value="Envoyer" />
		</form>
		</if>
	</if>
	<elseif cond='{al_waiting}'>
		<p>Votre demande de rejoindre <a href="index.php?file=alliances&amp;act=view&amp;al_aid={al_array[al_aid]}" title="Infos sur {al_array[al_name]}">{al_array[al_name]}</a>
		 n'a pas encore été acceptée. Vous recevrez un message si vous êtes accepté.</p>
		 <a href="index.php?file=alliances&amp;act=cancel" title="Annuler la demande">Annuler</a>
	</elseif>
	<else>
		<table class="border1">
		<tr>
		<td>	
			<if cond='{al_logo}'>
				<img class="img_right" src="{al_logo}" alt="Blason" />
			</if>
			<h2>{al_array[al_name]}</h2>
			Chef : <a href="index.php?file=member&amp;act=view&amp;mid={al_array[al_mid]}" title="Infos sur {al_array[mbr_pseudo]}">{al_array[mbr_pseudo]}</a><br/>
			Points : {al_array[al_points]}<br/>	
			<if cond='|{session_user[mid]}| != |{al_array[al_mid]}|'>
			<a href="index.php?file=alliances&amp;act=part">Quitter l'Alliance</a>	
			</if>
		</td>
		<td>
  		<h2>Liste des Joueurs</h2>
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
  			 	<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 	</th>
  	 	</if>
  	 	<else>
  	 	<td>
  	 		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
  	 		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 	</td>
  	 	</else>
  	 	<td>{result[mbr_population]}</td>
  	 	<td>{result[mbr_points]}</td>
		 	<td>
  	 		<if cond='|{result[mbr_mid]}| != |{session_user[mid]}|'>
  	 		<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
  	 			<img src="img/msg.png" alt="" />
  	 		</a>
  	 		</if>
  	 		<if cond='|{al_admin}| AND |{session_user[mid]}| != |{result[mbr_mid]}|'>
  	 		<a href="index.php?file=alliances&amp;act=admin&amp;sub=kick&amp;mid={result[mbr_mid]}" title="Bannir {result[mbr_pseudo]} de l'Alliance">
  	 			<img src="img/drop.png" alt="" />
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
  		<form class="center" action="index.php?file=alliances&amp;act=my&amp;sub=post" method="post">
  		<include file='commun/bbcode.tpl' cache='1' /><br/>
   		<textarea id="message" name="al_shoot_msg" rows="5" cols="40"></textarea><br />
   		<input type="submit" value="Envoyer" />
   		</form>
   		<if cond='is_array({al_shoot_array})'>
   			<foreach cond='|{al_shoot_array}| as |{result}|'>
   				<div class="block_1">
   				<img class="img_right" title="{result[mbr_pseudo]}" src="img/mbr_logo/{result[shoot_mid]}.png" />
   				<h3><a href="index.php?file=member&amp;act=view&amp;mid={result[shoot_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a> le {result[shoot_date_formated]}<br/></h3>
   				<p>
   				{result[shoot_texte]}
   				</p>
   				</div>
   				<br />
   			</foreach>
   			
   			<for cond='|{i}| = 0; |{i}| < |{al_nb}|; |{i}|+=|{limite_page}|'>
			  <if cond='|{i}| / |{limite_page}| != |{al_page}|'>
			   <a href="index.php?file=alliances&amp;act=my&amp;al_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
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
			<form class="block_1" enctype="multipart/form-data" action="index.php?file=alliances&amp;act=admin&amp;sub=logo" method="post">
			<if cond='{al_logo}'>
				<img class="img_right" src="{al_logo}" alt="Blason" />
			</if>
 			Envoyez ce fichier: <input name="al_logo" type="file" />
 			<input type="submit" value="Envoyer" />
			</form>
			<form class="block_1" action="index.php?file=alliances&amp;act=admin&amp;sub=param" method="post">
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
			<a href="index.php?file=alliances&amp;act=admin&amp;sub=del">Détruire l'Alliance</a>
			
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
  			 	<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 	</th>
  	 	</if>
  	 	<else>
  	 	<td>
  	 		<img src="img/groupes/{result[mbr_gid]}.png" alt="{groupes[{result[mbr_gid]}]}" title="{groupes[{result[mbr_gid]}]}"/>
  	 		<a href="index.php?file=member&amp;act=view&amp;mid={result[mbr_mid]}" title="Infos sur {result[mbr_pseudo]}">{result[mbr_pseudo]}</a>
  	 	</td>
  	 	</else>
  	 	<td>{result[mbr_population]}</td>
  	 	<td>{result[mbr_points]}</td>
		 	<td>
  	 		<a href="index.php?file=msg&amp;act=new&amp;mbr_mid={result[mbr_mid]}" title="Envoyer un message à {result[mbr_pseudo]}">
  	 			<img src="img/msg.png" alt="" />
  	 		</a>
  	 		-
  	 		<a href="index.php?file=alliances&amp;act=admin&amp;sub=accept&amp;mid={result[mbr_mid]}" title="Accepter {result[mbr_pseudo]}">
  	 			<img src="img/join.png" alt="" />
  	 		</a>
  	 		-
  	 		<a href="index.php?file=alliances&amp;act=admin&amp;sub=refuse&amp;mid={result[mbr_mid]}" title="Refuser {result[mbr_pseudo]}">
  	 			<img src="img/drop.png" alt="" />
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
	<if cond='|{al_sub}| == "del"'>
		<if cond='|{al_del}| === "need_ok"'>
			<p class="infos">Êtes vous sûr de vouloir détruire votre alliance ?
			<form action="index.php?file=alliances&amp;act=admin&amp;sub=del" method="post">
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
<p class="retour_module">[ <a href="index.php?file=alliances<if cond='|{al_act}| == "admin" OR |{al_act}| == "my"'>&amp;act={al_act}</if>">Retour</a> ]</p>