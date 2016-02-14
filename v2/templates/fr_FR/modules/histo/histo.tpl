<if cond="{histo_array}">
	<foreach cond="{histo_array} as {vars}">
		<p id="{vars[histo_hid]}" class="block">
			<if cond="{_user[ldate]} < {vars[histo_date]}">
				<img src="img/histo/new.png" alt="Nouveau" />
				<strong>
			</if>
			<small>Le {vars[histo_date_formated]} - </small> <include file="modules/histo/msg/{vars[histo_type]}.tpl" cache="1" />
			<if cond="{_user[ldate]} < {vars[histo_date]}">
				</strong>
			</if>
		</p>	
	</foreach>
	<div class="menu_module">
		[ <a href="histo-all.html" title="Afficher tout">Tout</a> ]
		-
		[ <a href="histo.xml?mid={_user[mid]}&amp;key={histo_key}">Flux Rss</a> ]
	</div>
</if>
<else>
	<p class="infos">Vide ...</p>
</else>