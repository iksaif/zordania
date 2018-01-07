<?xml version="1.0" encoding="iso-8859-1"?>
<rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"
		 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
		 xmlns="http://purl.org/rss/1.0/">

<load file="config/config.config" cache="1" />

<channel rdf:about="{cfg_url}"> 
	<title>Zordania</title>
	<link>{cfg_url}</link>
	<description>Zordania - News</description>
	<dc:language>fr</dc:language>

	<!-- Déclaration de ressource -->
	<image rdf:resource="{cfg_url}img/logo.png" />

	<items>
	<rdf:Seq>
		<foreach cond="{nws_array} as {result}">
		<rdf:li rdf:resource="{cfg_url}news.html#news_{result[nws_nid]}" />	
		</foreach>
	</rdf:Seq>
	</items>
			
</channel>

<image rdf:about="{cfg_url}img/logo.png">
    <title>Zordania</title>
    <url>{cfg_url}img/logo.png</url>
    <link>{cfg_url}</link>
</image>

<foreach cond="{nws_array} as {result}">
<item rdf:about="{cfg_url}news.html#news_{result[nws_nid]}">
	<title><math oper="substr(strip_tags({result[nws_titre]}), 0, 50)" />...</title>
	<link>{cfg_url}news.html#news_{result[nws_nid]}</link>

	<description>
	<math oper="strip_tags({result[nws_texte]})" />...
	</description>
	<dc:creator>{result[mbr_pseudo]}</dc:creator>
	<dc:date>{result[nws_date]}+01:00</dc:date>
</item>
</foreach>

</rdf:RDF>
