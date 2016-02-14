<if cond='{zzz_act} == "ronflz"'>
	<p class="ok">Ok, compte mis en veille !</p>
</if>
<elseif cond='{zzz_act} == "dring"'>
	<if cond='{zzz_ok}'>
		<p class="ok">Ok, compte réactivé. <a href="gen.html" title="Aller au donjon">Aller au donjon</a></p>
	</if>
	<else>
		<p class="error">Vous devez encore attendre pour réactiver votre compte.</p>
	</else>
</elseif>
<elseif cond='{zzz_act} == "stats"'>
	<if cond='{zzz_ok}'>
		<p>
		Votre compte est en veille depuis le {zzz_date}.<br/>
		Vous pouvez maintenant réactiver votre compte et continuer à jouer normalement.
		</p>
		<a href="zzz-dring.html" title="Réactiver votre compte">Réactiver</a>
	</if>
	<else>
		<div class="error">Vous devez encore attendre pour réactiver votre compte.<br/>
		Il a été mis en veille le {zzz_date} et la durée minimale de mise en veille est {ZZZ_MIN} jours.</div>
	</else>
</elseif>
<elseif cond='{zzz_act} == "rien"'>
<p>
Vous pouvez mettre en veille votre compte à partir de cette page.
Il sera mis en veille pour une durée minimale de {ZZZ_MIN} jours.
Pour réactiver votre compte après cette durée, il suffit de revenir sur le site.
</p>
<form method="post" action="zzz-ronflz.html">
	<label for="mbr_pass">Mot de passe</label>
	<input name="mbr_pass" type="password" />
	<input type="submit" value="Mettre en veille" />
</form>
<p class="infos">Si vous partez longtemps, votre compte se mettra automatiquement en veille après {ZZZ_TRIGGER} jours d'inactivité.</p>
</elseif>
