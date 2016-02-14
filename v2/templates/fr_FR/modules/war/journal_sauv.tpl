<div class="infos">Ce journal est régulièrement vidé pour ne pas encombrer la base de données du site</div>
<div class="menu_module">
	[ <a href="war-histo.html?sub=atq" title="Attaques de vos légions sur les autres joueurs">Attaque</a> ]
	- 
	[ <a href="war-histo.html?sub=def" title="Attaques des autres joueurs sur vos légions">Défense</a> ]
</div>

<if cond='{war_sub} == "def"'>
	<h2>Défense</h2>
</if>
<else>
	<h2>Attaque</h2>
</else>

<script type="text/javascript">
<!-- // requete ajax : copier journal vers bbcode ...
function GetAjaxResponse(xmlhttp, aid) {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200)
			text = xmlhttp.responseText;
		else
			text = statusText;
		if (copyToClipboard(text))
			document.getElementById("log"+aid).innerHTML = '<p class="ok">Journal copié avec succès ! Ctrl+v ou menu \'coller\' pour le copier dans un forum, une note, un message privé ou sur la shootbox.</p>';
		else {
			document.getElementById("log"+aid).innerHTML = '<p class="error">Echec de copie dans le presse-papier. Récupérez le BBCode dans la zone ci dessous pour la copier sur les forums.</p>\n<textarea cols="60" rows="10">'+text+'</textarea>';
		}
	}
}

function CopyJournalToBBCode(aid) {
	var xmlhttp = getHTTPObject();
	var url = "{cfg_url}ajax--war-histo.html?aid="+aid;
	var method = "GET";
	var data = 'null';
	var callback = function() { GetAjaxResponse(xmlhttp, aid); }

	ajaxRequest(xmlhttp, method, url, data, callback);
	return false; /* ne pas suivre le lien */
}

function copyToClipboard(s) {
	if( window.clipboardData && clipboardData.setData )
		clipboardData.setData("Text", s);
	else {
		/* à faire pour FF ou autre... */
		return false;
	}
	return true;
}
// -->
</script>

<dl>
<foreach cond="{atq_array} as {value}">

	<dt>
	<a href="war-histo.html?aid={value[atq_aid]}&amp;sub={war_sub}">Le {value[atq_date_formated]}</a>
	<if cond="{value[atq_mid1]} == {_user[mid]}">
		Vous attaquez <a href="member-<math oper="str2url({value[mbr_pseudo2]})"/>.html?mid={value[atq_mid2]}">{value[mbr_pseudo2]}</a>
	</if>
	<elseif cond="{value[atq_mid2]} == {_user[mid]}">
		Vous êtes attaqué par <a href="member-<math oper="str2url({value[atq_bilan][att][mbr_pseudo]})"/>.html?mid={value[atq_bilan][att][mbr_mid]}">{value[atq_bilan][att][mbr_pseudo]}</a>
	</elseif>
	<else>
		<a href="member-<math oper="str2url({value[atq_bilan][att][mbr_pseudo]})"/>.html?mid={value[atq_bilan][att][mbr_mid]}">{value[atq_bilan][att][mbr_pseudo]}</a>
		attaque votre allié <a href="member-<math oper="str2url({result[mbr_pseudo]})"/>.html?mid={value[atq_mid2]}">{value[atq_bilan][def][{value[atq_lid2]}][mbr_pseudo]}</a>, vous prenez sa défense
	</else>
	</dt>


	<dd class="block_forum">
	<include file="modules/war/armee.tpl" cache="1" leg="{value[atq_bilan][att]}" />

	<include file="modules/war/armee.tpl" cache="1" leg="{value[atq_bilan][def][{value[atq_lid2]}]}" />

	<h3>Légions en défense :</h3>
	<foreach cond="{value[atq_bilan][def]} as {lid} => {leg}">
		<if cond="{lid} != {value[atq_lid2]}">
		<include file="modules/war/armee.tpl" cache="1" /><# ici {leg} est déjà défini #>
		</if>
	</foreach>


	<set name="leg" value="{value[atq_bilan][def][{value[atq_lid2]}]}" />
	<if cond="{value[atq_bilan][btc_def]}">
		<h3>Bâtiments défensifs :</h3>
		<foreach cond="{value[atq_bilan][btc_def]} as {btc2} => {nb}">
			{nb} <zimgbtc type="{btc2}" race="{leg[mbr_race]}" />
		</foreach>
		<if cond="isset({value[atq_bilan][btc_bonus][bon]})"><p>Bonus fourni par les bâtiments = {value[atq_bilan][btc_bonus][bon]} % (y compris le donjon)</p>
		</if>
	</if>

	<if cond="{value[atq_bilan][btc_edit]}">
		L'attaque sur les bâtiments a produit {value[atq_bilan][atq_bat]} points de dégâts.
		<h3>Bâtiments détruits :</h3>
		<foreach cond="{value[atq_bilan][btc_edit]} as {btc2}">
			<if cond="{btc2[vie]} == 0">
				{btc2[vie]} / {btc2[vie_max]} <zimgbtc type="{btc2[type]}" race="{leg[mbr_race]}" />
			</if>
		</foreach>

		<h3>Bâtiments endommagés :</h3>
		<foreach cond="{value[atq_bilan][btc_edit]} as {btc2}">
			<if cond="{btc2[vie]} != 0">
				<if cond='{war_sub} == "def"'>
					<a href="btc-use.html?btc_type={btc2[type]}&amp;sub=list" title="Réparer">
					{btc2[vie]} / {btc2[vie_max]} <zimgbtc type="{btc2[type]}" race="{leg[mbr_race]}" /></a>
				</if>
				<else>
					{btc2[vie]} / {btc2[vie_max]} <zimgbtc type="{btc2[type]}" race="{leg[mbr_race]}" />
				</else>
			</if>
		</foreach>
	</if>

	<h3>Butin attaquant :</h3>
	<foreach cond="{value[atq_bilan][butin][att]} as {type} => {nb}">
		<if cond="{nb}">{nb} <zimgres type="{type}" race="{_user[race]}" /></if>
	</foreach>
	<br/>
	<h3>Butin défenseur :</h3>
	<foreach cond="{value[atq_bilan][butin][def]} as {type} => {nb}">
		<if cond="{nb}">{nb} <zimgres type="{type}" race="{_user[race]}" /></if>
	</foreach>
	</dd>


	<div id="log{value[atq_aid]}">	<a href="#" onclick="return CopyJournalToBBCode('{value[atq_aid]}');">Copy To BbCode</a>
</div>


</foreach>
</dl>


<p>Page :
<for cond='{i} = 0; {i} < {atq_nb}; {i}+={limite_page}'>
<if cond='{i} / {limite_page} != {war_page}'>
	<a href="war-histo.html?sub={war_sub}&amp;war_page=<math oper='({i} / {limite_page})' />"><math oper='(({i} / {limite_page})+1)' /></a>
</if>
<else>
	<math oper='(({i} / {limite_page})+1)' />
</else>
</for>
</p>

