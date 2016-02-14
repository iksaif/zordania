<?xml version="1.0" encoding="utf-8"?>
<rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"
		 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
		 xmlns="http://purl.org/rss/1.0/">
<channel rdf:about="{cfg_url}"> 
<title>Zordania</title>
<link>{cfg_url}</link>
<description>Zordania</description>
<dc:language>fr</dc:language>

<!-- Déclaration de ressource -->
<image rdf:resource="{cfg_url}skin/metal/img/logo.png" />
	
	<items>
	 <rdf:Seq>
		<foreach cond="{msg_array} as {vars}">
		<rdf:li rdf:resource="{cfg_url}alliances-my.html#{vars[shoot_msgid]}" />	
		</foreach>
	 </rdf:Seq>
	</items>
			
	</channel>
	
	<image rdf:about="{cfg_url}img/metal/logo.png">
	    <title>Zordania</title>
	    <url>{cfg_url}img/metal/logo.png</url>
	    <link>{cfg_url}</link>
	</image>

	<foreach cond="{msg_array} as {vars}">
	<item rdf:about="{cfg_url}alliances-my.html#{vars[shoot_msgid]}">
		<title><zurlmbr mid="{vars[shoot_mid]}" pseudo="{vars[mbr_pseudo]}"/> le {vars[shoot_date_formated]}</title>
		<link>{cfg_url}alliances-my.html#{vars[shoot_msgid]}</link>

		<description>
		<math oper="strip_tags({vars[shoot_texte]})" />
		</description>
		<dc:creator>{vars[mbr_pseudo]}</dc:creator>
		<dc:date>{vars[shoot_date_formated]}+01:00</dc:date>
	</item>
	</foreach>

</rdf:RDF>
