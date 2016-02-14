<div style="text-align:left" class="block_1">
	<h1>Debug</h1>
	<dl>
		<dt>SQL</dt>
		<dd>
			<ol>
			<foreach cond='|{sv_queries}| as |{values}|'>
			<li>
				{values[req]}<br/>
				Err: {values[errno]} {values[err]} <br/>
				<if cond="{values[infos]}">
				Infos: {values[infos]} <br/>
				</if>
				<if cond="{values[num]}">
				Num: {values[num]} <br/>
				</if>
				<if cond="is_array(|{values[explain]}|)">
				Explain:
					<foreach cond="|{values[explain]}| as |{key}| => |{value}|">
					<if cond="{value}">{key} = {value}<br/></if>
					</foreach>
				</if>
				Temps: <math oper="round({values[time]}*1000,2)" /> ms
			</li>
			</foreach>
			</ol>
			Au total: <math oper='round({sv_total_sql_time},4)' /> sur <math oper='round(divers::getmicrotime()-{sv_diff},4)' /> secondes<br/>
			Donc: <math oper='round({sv_total_sql_time} /  (divers::getmicrotime()-{sv_diff}) * 100,2)' /> % du temps.
		</dd>
	</dl>
</div>