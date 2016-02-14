<if cond='|{ses_loged}|'>
	<set name="rand" value="<math oper='rand(0,100)' />" />

	<if cond="|{rand}| <= 90">
		<script type="text/javascript"><!--
		google_ad_client = "pub-8111064150683008";
		google_alternate_ad_url = "http://www.zordania.com/img/pub/zord_46860_1.png";
		google_ad_width = 468;
		google_ad_height = 60;
		google_ad_format = "468x60_as";
		google_ad_type = "text_image";
		google_ad_channel ="";
		google_color_border = "231E17";
		google_color_bg = "352D21";
		google_color_link = "FFFFFF";
		google_color_url = "00CC66";
		google_color_text = "E7D6B5";
		//--></script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</if>
	<elseif cond="|{rand}| <= 97">
		<script type="text/javascript"><!--
		google_ad_client = "pub-8111064150683008";
		google_ad_width = 468;
		google_ad_height = 60;
		google_ad_format = "468x60_as_rimg";
		google_cpa_choice = "CAAQxYv7zwEaCDQ24eD-KfakKJW593M";
		//--></script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</elseif>
	<else>
		<script type="text/javascript">mtshow(683,5);</script>
	</else>
</if>
<else>
<br/>
<form action="index.php?file=session&amp;act=login" method="post">
<label for="login">Login</label>
<input name="login" id="login" type="text" />
<label for="pass">Password</label>
<input name="pass" id="pass" type="password" />
<input type="submit" value="Connexion" />
</form>
[ <a href="index.php?file=member&amp;act=new" title="S'inscrire">Inscription</a>
] - [
<a href="index.php?file=member&amp;act=newpass" title="Récuperer son mot de passe"> Mot de Passe perdu </a>
]
</else>