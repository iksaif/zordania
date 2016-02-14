<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE membre SYSTEM "{cfg_url}templates/fr/xml/xml.dtd">
<if cond='!|{bad_mid}|'>
<?xml-stylesheet type="text/xsl" href="{cfg_url}templates/fr/xml/xml.xsl"?>
<load file='config/config.config' />
<load file='race/{mbr_array[mbr_race]}.config' />
<membre>
	<mid>{mbr_array[mbr_mid]}</mid>
	<pseudo>{mbr_array[mbr_pseudo]}</pseudo>
	<race>
		<race_rid>{mbr_array[mbr_race]}</race_rid>
		<race_nom>{race[{mbr_array[mbr_race]}]}</race_nom>
	</race>
	<if cond='is_array(|{res_array}|)'>
	<foreach cond='|{res_array}| as |{res_vars}|'>
	<if cond='|{res_vars[res_type]}| == 20'>
	<population>
		<util>{mbr_array[mbr_population]}</util>
		<max>{res_vars[res_nb]}</max>
	</population>
	</if>
	<else>
	<ressource>
		<res_type>{res_vars[res_type]}</res_type>
		<res_nom>{res[alt][{res_vars[res_type]}]}</res_nom>
		<res_nb>{res_vars[res_nb]}</res_nb>
	</ressource>
	</else>
	</foreach>
	<points>{mbr_array[mbr_points]}</points>
	</if>
	<alliance>
		<al_nom>{mbr_array[al_name]}</al_nom>
		<al_id>{mbr_array[mbr_alaid]}</al_id>
	</alliance>
</membre>
</if>
<else>
<membre>
	<message>Bad mid/Mauvaix mid</message>
</membre>	
</else>