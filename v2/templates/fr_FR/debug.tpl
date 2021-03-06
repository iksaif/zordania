<div style="text-align:left" class="block">
	<h1>Debug</h1>
	<dl>
		<if cond="false"><math oper="print_debug()" /></if>

		<dt>_user</dt>
		<dd>
		<foreach cond="{_user} as {key} => {value}">
			[{key}] => 
			<if cond="is_array({value})">( array )</if><else>{value}</else><br/>
		</foreach>
		</dd>
		<if cond="{_get}">
		<dt>_GET</dt>
		<dd><foreach cond="{_get} as {key} => {value}">
			[{key}] => 
			<if cond="is_array({value})">( array )</if><else>{value}</else><br/>
		</foreach></dd>
		</if>
		<if cond="{_post}">
		<dt>_POST</dt>
		<dd><foreach cond="{_post} as {key} => {value}">
			[{key}] => 
			<if cond="is_array({value})">( array )</if><else>{value}</else><br/>
		</foreach></dd>
		</if>
		<if cond="{_files}">
		<dt>_FILES</dt>
		<dd><foreach cond="{_files} as {key} => {value}">[{key}] => {value}<br/></foreach></dd>
		</if>
		<if cond="{_cookie}">
		<dt>_COOKIE</dt>
		<dd><foreach cond="{_cookie} as {key} => {value}">
			[{key}] => 
			<if cond="is_array({value})">( array )</if><else>{value}</else><br/>
		</foreach></dd>
		</if>
<if cond="true">
		<dt>SQL</dt>
		<dd>
			<ol>
			<if cond="{sv_queries}">
			<foreach cond='{sv_queries} as {values}'>
			<li>
				<math oper="htmlspecialchars({values[req]})" /><br/>
				Err: {values[errno]} {values[err]} <br/>
				<if cond="{values[infos]}">
				Infos: {values[infos]} <br/>
				</if>
				<if cond="{values[num]}">
				Num: {values[num]} <br/>
				</if>
				<if cond="isset({values[explain]}) && is_array({values[explain]})">
				Explain:
					<div class="code">
					<foreach cond="{values[explain]} as {key} => {value}">
						 <foreach cond="{value} as {key2} => {value2}">
							<if cond="{value2}">{key2} = {value2}<br/></if>
						</foreach>
						<br/>
					</foreach>
					</div>
				</if>
				<pre>Callstack:
				<math oper='implode("<br/>",{values[callstack]})' /></pre>
				Temps: <math oper="round({values[time]}*1000,2)" /> ms
			</li>
			</foreach>
			</if>
			</ol>
			Au total: <math oper='round({sv_total_sql_time},4)' /> sur <math oper='round(mtime()-{sv_diff},4)' /> secondes<br/>
			Donc: <math oper='round({sv_total_sql_time} /  (mtime()-{sv_diff}) * 100,2)' /> % du temps.
		</dd>
</if>
	</dl>
</div>
