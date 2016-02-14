<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>

	<title>Zordania - my Shoot</title>
	<link>{cfg_url}</link>
	<description>Shootbox de mon alliance</description>
	<atom:link href="{cfg_url}alliances.xml?mid={mid}&amp;key={key}" rel="self" type="application/rss+xml" />

	<foreach cond="{msg_array} as {vars}">
	<item>
		<title>{vars[mbr_pseudo]} le {vars[shoot_date_formated]}</title>
		<link>{cfg_url}alliances-my.html#{vars[shoot_msgid]}</link>
		<guid isPermaLink="true">{cfg_url}alliances-my.html#{vars[shoot_msgid]}</guid>
		<description><math oper="strip_tags({vars[shoot_texte]})" /></description>
		<pubDate>{vars[shoot_date_rss]} +0100</pubDate>
	</item>
	</foreach>
</channel>
</rss>

