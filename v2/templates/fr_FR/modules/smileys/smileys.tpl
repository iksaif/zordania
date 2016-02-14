<table class="liste">
	<tr>
		<th style="width:30%;">Symbole</th>
		<th style="width:20%;">Image</th>
		<th style="width:30%;">Symbole</th>
		<th style="width:20%;">Image</th>
	</tr>
	
	<tr>
	<set name="i" value="0" />
	<foreach cond="{_smileys} as {img} => {str}">
		<td>
			<if cond="is_array({str})">
				<foreach cond="{str} as {key} => {val}">
					<if cond="{key} != 0"><img style='vertical-align:middle;' src='img/sep.png' alt='SEP' title='séparateur' /></if>{val}</foreach>
			</if>
			<else>{str}</else>
		</td>
		<td>
			<if cond="is_array({str})">
				<set name="title" value="" />
				<foreach cond="{str} as {key} => {val}">
					<if cond="{key} != 0">
						<set name="title" value="{title}<img style='vertical-align:middle;' src='img/sep.png' alt='SEP' title='séparateur' />" />
					</if>
					<set name="title" value="{title}{val}" />
				</foreach>
			</if>
			<else>
				<set name="title" value="{str}" />
			</else>
			<img src="img/smile/{img}" alt="{title}" title="{title}" />
		</td>
		<if cond="fmod({i}, 2)">
			</tr><tr>
		</if>
		<set name="i" value='<math oper="{i}+1" />' />
	</foreach>
	</tr>
</table>

<foreach cond="{_smileys} as {img} => {str}">
	<if cond="is_array({str})">
		<foreach cond="{str} as {val}">
			<img src="img/smile/{img}" alt="{val}" title="{val}" />
		</foreach>
	</if>
	<else>
		<img src="img/smile/{img}" alt="{str}" title="{str}" />
	</else>
</foreach>

