<if cond='{ses_loged}'>
	<set name="rand" value="<math oper='rand(0,100)' />" />
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5781750090543674";
/* zorddev brown bandeau */
google_ad_slot = "7666016117";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<!-- script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script -->
	<# if cond="{_user[loged]} && {rand} >= 95">
		<div class="ok">Le site fonctionne grâce à la pub, pensez-y une fois par jour !</div>
	</if #>
</if>
<else>
	<div id="formulaire">
		<form action="module--session-login.html" method="post">
			<label for="login">Login</label>
			<input name="login" id="login" type="text" />
			<label for="pass">Password</label>
			<input name="pass" id="pass" type="password" />
			<input type="submit" value="Connexion" />
		</form>
		[ <a href="inscr-new.html" title="S'inscrire">Inscription</a>
		] - [
		<a href="inscr-newpass.html" title="Récupérer son mot de passe"> Mot de Passe perdu </a>
		]
	</div>
</else>
