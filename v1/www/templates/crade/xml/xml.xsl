<?xml version="1.0" encoding="iso-8859-1" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/">
		<html xml:lang="fr">
			<head>
				<title>Infos sur <xsl:value-of select="membre/pseudo" /></title>
				<link media="screen,projection" href="css/xml.css" type="text/css" rel="stylesheet" />
			</head>
			<body>
				<h1>Infos sur <xsl:value-of select="membre/pseudo" /></h1>
				<div class="mid">MID <xsl:value-of select="membre/mid" /></div>
				<div class="pseudo">Pseudo <xsl:value-of select="membre/pseudo" /></div>
				<div class="alliance">Alliance <xsl:value-of select="membre/alliance/al_id" /> : <xsl:value-of select="membre/alliance/al_nom" /></div>
				<div class="race">
					Race 
					<xsl:value-of select="membre/race/race_nom" />
					(<xsl:value-of select="membre/race/race_rid" />)
				</div>
				<div class="population">
					Population 
					<xsl:value-of select="membre/population/util" /> /
					<xsl:value-of select="membre/population/max" />
					<xsl:element name="img">
							<xsl:attribute name="src">img/<xsl:value-of select="membre/race/race_rid" />/res/20.png</xsl:attribute>
							<xsl:attribute name="alt">pop</xsl:attribute>
					</xsl:element>
				</div>

				<xsl:for-each select="membre/ressource">
					<div class="ressource">
							<xsl:value-of select="res_nb" />
							<xsl:element name="img">
							<xsl:attribute name="src">img/<xsl:value-of select="/membre/race/race_rid" />/res/<xsl:value-of select="res_type" />.png</xsl:attribute>
							<xsl:attribute name="alt"><xsl:value-of select="res_nom" /></xsl:attribute>
							</xsl:element>
					</div>
				</xsl:for-each>
				<div class="points">Points <xsl:value-of select="membre/points" /></div>
			</body>

		</html>
	</xsl:template>
</xsl:stylesheet>
