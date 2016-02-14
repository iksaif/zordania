<?xml version="1.0" encoding="{charset}"?>
<carte>
<foreach cond='{map_array} as {map_y} => {result_x}'>
	<foreach cond='{result_x} as {map_x} => {result}'>
	<case>
		<map_cid>{result[map_cid]}</map_cid>
		<map_x>{map_x}</map_x>
		<map_y>{map_y}</map_y>
		<map_region>{result[map_region]}</map_region>
		<map_climat>{result[map_climat]}</map_climat>
		<map_type>{result[map_type]}</map_type>
		<map_rand>{result[map_rand]}</map_rand>
		<if cond='isset({result[members]})'>
		<member>
			<foreach cond='{result[members]} as {result_mbr}'>
				<foreach cond='{result_mbr} as {key} => {value}'>
					<{key}>{value}</{key}>
				</foreach>
			</foreach>
		</member>
		</if>
		
		<if cond='isset({result[legions]})'>
			<legions>
			<foreach cond='{result[legions]} as {result_leg}'>
				<legion>
				<foreach cond='{result_leg} as {key} => {value}'>
					<{key}>{value}</{key}>
				</foreach>
				</legion>
			</foreach>
			</legions>
		</if>
	</case>
	</foreach>
</foreach>
</carte>
