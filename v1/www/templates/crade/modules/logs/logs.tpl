<p class="menu_module">
[
<a href="index.php?file=admin&amp;module=logs&amp;act=hack" title="Tentatives de Hack">Hack</a>
]-[
<a href="index.php?file=admin&amp;module=logs&amp;act=view&amp;log_file=mysql.log" title="Erreurs mysql">Mysql</a>
]-[
<a href="index.php?file=admin&amp;module=logs&amp;act=bonus" title="Bonus (Allopass)">Bonus</a>
]-[
<a href="index.php?file=admin&amp;module=logs&amp;act=view&amp;log_file=code.log" title="Erreurs code de verif">Codes</a>
]-[
<a href="index.php?file=admin&amp;module=logs&amp;act=crons_temps" title="Crons Temps">Temps crons</a>
]-[
<a href="index.php?file=admin&amp;module=logs&amp;act=crons_result" title="Crons Resultats">Résultats crons</a>
]
<hr />
</p>

<if cond='|{log_act}| == "view"'>
	<if cond='|{log_contenu}|'>
		<div class="block_1 overflow">
			{log_contenu}
		</div>
	</if>
	<else>
		<p class="error">Ce fichier n'existe pas.</p>
	</else>
</if>
<elseif cond='|{log_act}| == "hack"'>
	<if cond='is_array(|{log_array}|)'>
		<foreach cond='|{log_array}| as |{rien}| => |{result}|'>
			<div class="block_1 overflow">
				<h4>Par : {result[mbr_pseudo]} Le 
				{result[log_date_formated]}</h4>
				<br/>
				Url : {result[log_url]}<br/>
				Post : <pre>{result[log_post]}</pre><br/>
				Cookies : <pre>{result[log_cookie]}</pre><br/>
				IP : {result[log_ip]}<br/>
			</div>
			<br/>
		</foreach>
	</if>
	<else>
	<p class="infos">Rien !!!</p>
	</else>
</elseif>
<elseif cond='|{log_act}| == "bonus"'>
	<if cond='is_array(|{bon_array}|) AND count(|{bon_array}|) > 0'>
	<foreach cond='|{bon_array}| as |{rien}| => |{result}|'>
	
			<if cond='|{last_date}| != |{result[bon_date]}|'>
				<if cond='{last_date_nb}'>
				({last_date_nb})
				</if>
				<set name="last_date" value="{result[bon_date]}" />
				<set name="last_date_nb" value="0" />
				<br/>
				<a href="index.php?file=admin&amp;act=bonus&amp;module=logs&amp;bon_date=<math oper='urlencode({result[bon_date]})' />" title="Voir pour {result[bon_date]}">{result[bon_date]}</a>
				
			</if>
			<set name="last_date_nb" value="<math oper='{last_date_nb} +1' />" />
			
			<if cond='|{bon_date}| == |{result[bon_date]}|'>
			<div class="block_1 overflow">
			<h4>Par : {result[mbr_pseudo]} Le 
				{result[bon_date_formated]}</h4>
				<br/>
				Code : {result[bon_code]}<br/>
				Ok : {result[bon_ok]}
			</div>
			<br/>
			</if>
	
	</foreach>
	</if>
	<else>
		Rien
	</else>
</elseif>
<elseif cond='|{log_act}| == "crons_temps"'>
 <if cond='is_array(|{log_array}|)'>
 <foreach cond='|{log_array}| as |{result}|'>
 <a href="index.php?file=admin&amp;module=logs&amp;act=view&amp;log_file={result[name]}" title="Voir {result[name]}">{result[name]}</a>
  - {result[size]} octets - {result[date]} <br/>
 </foreach>
 </if>
 <else>
 Rien
 </else>
</elseif>
<elseif cond='|{log_act}| == "crons_result"'>
 <if cond='is_array(|{log_array}|)'>
 <foreach cond='|{log_array}| as |{result}|'>
 <a href="index.php?file=admin&amp;module=logs&amp;act=view&amp;log_file=cron/logs/{result[name]}" title="Voir {result[name]}">{result[name]}</a>
  - {result[size]} octets - {result[date]} <br/>
 </foreach>
 </if>
 <else>
 Rien
 </else>
</elseif>