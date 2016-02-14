<if cond='|{ses_loged}|'>
<script type="text/javascript"><!--
google_ad_client = "pub-4491026589253322";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_channel ="8613189347";
google_ad_type = "text";
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
<else>
<br/>
<form action="index.php?file=session&amp;act=login" method="post">
<label for="login">Pseudo</label>
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