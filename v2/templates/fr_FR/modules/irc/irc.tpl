<if cond='empty({irc_chat})'>

	<h2>Vous aussi, partagez votre passion avec vos amis !</h2>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="https://www.facebook.com/pages/Zordania/487159031358707" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial" data-colorscheme="dark"></div>



	<br/>

	<a href="http://twitter.com/share" class="twitter-share-button" data-url="{SITE_URL}inscr.html?parrain={_user[mid]}" data-text="Je suis devenu le maitre sur Zordania, viendra-tu te mesurer à moi?" data-count="horizontal" data-via="Zordania" data-lang="fr">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>

	<hr/>

	<p class="infos">
	<strong>Serveur:</strong> irc.quakenet.org
	<strong>Port:</strong> 6667
	<strong>Chan:</strong> #zordania
	</p>
	<p>
	Pour accéder au chat vous devez disposer d'un logiciel permettant de vous connecter à l'IRC comme <a href="http://mirc.com">mIRC</a>, <a href="http://www.xchat.org">xchat</a>.
	</p>
	
	<script type="text/javascript">
	<!--
	function openChat(act) {
	 	myPopup("irc", "&act="+act, 800, 600);
	 	return false;
	}
	-->
	</script>
	<div class="menu_module">
	<a href="#" onclick="openChat('webchat');" title="Aucune installation nécessaire !">Utiliser l'interface web</a>
	- <a href="irc://irc.quakenet.org/zordania" title="Rejoindre le chat avec mon logiciel habituel">Utiliser mon logiciel habituel</a>
	</div>
</if>

<elseif cond='{irc_chat} == "webchat"'>

	<if cond="{_user[mid]} != 1">
		<iframe src="http://webchat.quakenet.org/?nick={pseudo}&channels=zordania&uio=OT10cnVlde" width="800" height="600"></iframe>
	</if>
	<else>Vous n'êtes pas connecté !</else>
</elseif>

<else>

	<applet code="IRCApplet.class" archive="java/irc.jar,java/pixx.jar" width="640" height="400">
	<param name="CABINETS" value="java/irc.cab,java/securedirc.cab,java/pixx.cab" />
	
	<param name="nick" value="{_user[pseudo]}"/>
	<param name="alternatenick" value="{_user[pseudo]}??"/>
	<param name="name" value="Zord Player"/>
	<param name="host" value="irc.uk.quakenet.org"/>
	<param name="alternateserver1" value="irc.uk.quakenet.org 6667">
	<param name="command1" value="/join #zordania"/>
	<param name="language" value="java/french">
	<param name="pixx:language" value="java/pixx-french">
	<param name="gui" value="pixx"/>
	
	<param name="quitmessage" value="Zordania forever !"/>
	<param name="asl" value="false"/>
	<param name="useinfo" value="true"/>
	
	<param name="style:bitmapsmileys" value="true"/>
	<set name="i" value="1" />
	<foreach cond="{_smileys} as {img} => {sign}">
		<if cond="is_array({sign})">
			<foreach cond="{sign} as {val}">
				<param name="style:smiley{i}" value="{val} img/smile/{img}" />
				<eval oper="{i}++" />
			</foreach>			
		</if>
		<else>
			<param name="style:smiley{i}" value="{sign} img/smile/{img}" />
			<eval oper="{i}++" />
		</else>
	</foreach>
	
	<param name="style:backgroundimage" value="false"/>
	<param name="style:backgroundimage1" value="all all 0 background.gif"/>
	
	<param name="style:sourcefontrule1" value="all all Verdana 9"/>
	<param name="style:sourcecolorrule1" value="none+Channel all 0=231e17 1=ffffff">
	<param name="pixx:color5" value="352d21">
	<param name="pixx:color6" value="231e17">
	      		
	    
	<param name="style:floatingasl" value="false"/>
	
	<param name="pixx:timestamp" value="true"/>
	<param name="pixx:highlight" value="true"/>
	<param name="pixx:highlightnick" value="true"/>
	<param name="pixx:nickfield" value="true"/>
	<param name="pixx:styleselector" value="false"/>
	<param name="pixx:setfontonstyle" value="false"/>
	<param name="pixx:showconnect" value="false">
	<param name="pixx:showchanlist" value="false">
	<param name="pixx:showabout" value="false">
	<param name="pixx:showhelp" value="false">
	
	</applet>

	<div class="infos">Vous pouvez télécharger le plugin Java ici :
		<a href="http://java.sun.com/">Plugin Java</a>
	</div>
</else>

