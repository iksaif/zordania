<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE membre SYSTEM "{cfg_url}xml/member.dtd">
<if cond='!isset({bad_mid})'>
<?xml-stylesheet type="text/xsl" href="{cfg_url}xml/member.xsl"?>
<load file='config/config.config' />
<load file='race/{mbr_array[mbr_race]}.config' />
<membre>
	<mid>{mbr_array[mbr_mid]}</mid>
	<pseudo>{mbr_array[mbr_pseudo]}</pseudo>
	<race>
		<race_rid>{mbr_array[mbr_race]}</race_rid>
		<race_nom>{race[{mbr_array[mbr_race]}]}</race_nom>
	</race>
	<population>
		<util>{mbr_array[mbr_population]}</util>
		<max>{mbr_array[mbr_place]}</max>
	</population>
	<foreach cond='{res_array} as {res_type} => {res_nb}'>
	<ressource>
		<res_type>{res_type}</res_type>
		<res_nom>{res[{mbr_array[mbr_race]}][alt][{res_type}]}</res_nom>
		<res_nb>{res_nb}</res_nb>
	</ressource>
	</foreach>
	<points>{mbr_array[mbr_points]}</points>
	<alliance>
		<al_nom>{mbr_array[al_name]}</al_nom>
		<al_id>{mbr_array[ambr_aid]}</al_id>
	</alliance>
	<position>
		<x>{mbr_array[map_x]}</x>
		<y>{mbr_array[map_y]}</y>
	</position>
	<online>{mbr_online}</online>
</membre>
</if>
<else>
<membre>
	<message>Bad mid/Mauvais mid</message>
</membre>	
</else>
