<h2>Round {i}</h2>
<if cond="isset({result[inactif]})">
	<dl>
	<if cond="isset({result[btc][deg]}) && {result[btc][deg]}">
		<dt>Attaque sur le village (vous êtes sur?)</dt>
		<dd>
			[
			{result[btc][unt1_nb]}
			<zimgunt type="{result[btc][unt1_type]}" race="{_user[race]}" />
			<if cond="{result[btc][unt1_bonus]}">
				- Bonus: {result[btc][unt1_bonus]}%
			</if>
			]
			<br/>
			Dégâts:<br/>
			<foreach cond="{result[btc][deg]} as {btc_value}">
				{btc_value[btc_deg]} <zimgbtc type="{btc_value[btc_type]}" race="{race2}" />
			</foreach>
		</dd>
	</if>
	<if cond="isset({result[inactif]})">
		<dt>Vos hommes regardent les murs, non défendus, mais ne peuvent attaquer !</dt>
		<dd>{result[btc][unt1_nb]} <zimgunt type="{result[btc][unt1_type]}" race="{_user[race]}" /></dd>
	</if>

	</dl>
</if>
<else>
	<p>
	Initiative: {result[infos][init1]}<br/>
	Initiative ennemie: {result[infos][init2]}
	</p>
	
	<dl>
	<if cond="isset({result[btc][unt1_nb]})">
		<dt>Attaque sur le village</dt>
		<dd>
			[
			{result[btc][unt1_nb]}
			<zimgunt type="{result[btc][unt1_type]}" race="{_user[race]}" />
			<if cond="{result[btc][unt1_bonus]}">
				- Bonus: {result[btc][unt1_bonus]}%
			</if>
			]
			<br/>
			Dégâts:<br/>
			<foreach cond="{result[btc][deg]} as {btc_value}">
				{btc_value[btc_deg]} <zimgbtc type="{btc_value[btc_type]}" race="{race2}" />
				<if cond="isset({btc_value[etat]})">({btc_etat[{btc_value[etat]}]})</if>
			</foreach>
		</dd>
	</if>
	<elseif cond="isset({result[atq]})">
		<dt>Attaque</dt>
		<dd>
			<if cond="{result[infos][init1]} >= {result[infos][init2]}">
				[
				{result[atq][unt1_nb]}
				<zimgunt type="{result[atq][unt1_type]}" race="{_user[race]}" />
				<if cond="{result[atq][unt1_bonus]}">
					- Bonus: {result[atq][unt1_bonus]}%
				</if>
				]
				<img src="img/right.png" alt="Attaque" />
				[
				{result[atq][unt2_nb]}
				<zimgunt type="{result[atq][unt2_type]}" race="{race2}" />
				<if cond="{result[atq][unt2_bonus]}">
					- Bonus: {result[atq][unt2_bonus]}%
				</if>
				]
			</if>
			<else>
				[
				{result[atq][unt2_nb]}
				<zimgunt type="{result[atq][unt2_type]}" race="{_user[race]}" />
				<if cond="{result[atq][unt2_bonus]}">
					- Bonus: {result[atq][unt2_bonus]}%
				</if>
				]
				<img src="img/left.png" alt="Attaque" />
				[
				{result[atq][unt1_nb]}
				<zimgunt type="{result[atq][unt1_type]}" race="{race2}" />
				<if cond="{result[atq][unt1_bonus]}">
					- Bonus: {result[atq][unt1_bonus]}%
				</if>
				]
			</else>
			<br/>
			Dégâts: {result[atq][pdv]}<br/>
			Morts: {result[atq][nb]}
			<if cond="{result[infos][init1]} >= {result[infos][init2]}">
				<zimgunt type="{result[atq][unt2_type]}" race="{race2}" />
			</if>
			<else>
				<zimgunt type="{result[atq][unt2_type]}" race="{_user[race]}" />
			</else>
		</dd>
	</elseif>
	<if cond="isset({result[def]})">
		<dt>Riposte</dt>
		<dd>
			<if cond="{result[infos][init1]} < {result[infos][init2]} && !isset({result[btc][unt1_nb]})">
				[
				{result[def][unt1_nb]}
				<zimgunt type="{result[def][unt1_type]}" race="{_user[race]}" />
				<if cond="{result[def][unt1_bonus]}">
					- Bonus: {result[def][unt1_bonus]}%
				</if>
				]
				<img src="img/right.png" alt="Attaque" />
				[
				{result[def][unt2_nb]}
				<zimgunt type="{result[def][unt2_type]}" race="{race2}" />
				<if cond="{result[def][unt2_bonus]}">
					- Bonus: {result[def][unt2_bonus]}%
				</if>
				]
			</if>
			<else>
				[
				{result[def][unt2_nb]}
				<zimgunt type="{result[def][unt2_type]}" race="{_user[race]}" />
				<if cond="{result[def][unt2_bonus]}">
					- Bonus: {result[def][unt2_bonus]}%
				</if>
				]
				<img src="img/left.png" alt="Attaque" />
				[
				{result[def][unt1_nb]}
				<zimgunt type="{result[def][unt1_type]}" race="{race2}" />
				<if cond="{result[def][unt1_bonus]}">
					- Bonus: {result[def][unt1_bonus]}%
				</if>
				]
			</else>
			<br/>
			Dégâts: {result[def][pdv]}<br/>
			Morts: {result[def][nb]}
			<if cond="{result[infos][init1]} < {result[infos][init2]} && !isset({result[btc][unt1_nb]})">
				<zimgunt type="{result[def][unt2_type]}" race="{race2}" />
			</if>
			<else>
				<zimgunt type="{result[def][unt2_type]}" race="{_user[race]}" />
			</else>
		</dd>
	</if>
	</dl>
</if>
