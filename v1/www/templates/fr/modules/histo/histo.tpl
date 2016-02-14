<if cond="count(|{histo_array}|)">
	<foreach cond="|{histo_array}| as |{vars}|">
		<p id="{vars[histo_hid]}" class="block_1">
		<if cond="|{session_user[ldate]}| < |{vars[histo_date]}|">
		<img src="img/histo/new.png" alt="Nouveau" />
		<strong>
		</if>
		<small>Le {vars[histo_date_formated]} - </small> <include file="modules/histo/msg/{vars[histo_type]}.tpl" cache="1" />
		<if cond="|{session_user[ldate]}| < |{vars[histo_date]}|">
		</strong>
		</if>
		</p>	
	</foreach>
	<p class="menu_module">
	[ <a href="index.php?file=histo&amp;act=all" title="Afficehr tout">Tout</a> ]
	-
	[ <a href="xml.php?file=histo&amp;mid={session_user[mid]}&amp;key={histo_key}">Flux Rss</a> ]
	</p>
</if>
<else>
	<p class="infos">Vide ...</p>
</else>