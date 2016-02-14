<if cond='!|{irc_chat}|'>

	<div class="infos">
	<strong>Serveur:</strong> irc.quakenet.org
	<strong>Port:</strong> 6667
	<strong>Chan:</strong> #zordania
	</div>
	
	Pour acceder au chat vous devez disposer d'un logiciel permetant de se connecter à irc comme <a href="http://mirc.com">mirc</a>
	ou <a href="http://www.xchat.org">xchat</a>.
	<br/>
	[ <a href="irc://irc.quakenet.org/zordania" title="Rejoindre le chat avec mon logiciel habituel">Rejoindre</a> ]<br/>
	<br/>
	Vous pouvez aussi passer par une interface web :
	<script language="JavaScript"><!--
	function open_chat() {
	 my_popup("irc", "&act=chat", 450, 640);
	 return false;
	}
	-->
	</script>
	<form method="get" action="index.php?file=irc&amp;act=chat" onsubmit="open_chat();return false;">
	<input type="submit" value="Rejoindre" />
	</form>
</if>
<else>
	<applet code="IRCApplet.class" archive="java/irc.jar,java/pixx.jar" width="640" height="400">
	<param name="CABINETS" value="java/irc.cab,java/securedirc.cab,java/pixx.cab" />
	
	<param name="nick" value="{session_user[login]}"/>
	<param name="alternatenick" value="{session_user[pseudo]}??"/>
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
	<param name="style:smiley1" value=":) img/smile/s01.gif" />
	<param name="style:smiley2" value=":-) img/smile/s01.gif" />
	<param name="style:smiley3" value=":p img/smile/s02.gif" />
	<param name="style:smiley4" value="?? img/smile/s03.gif" />
	<param name="style:smiley5" value="??? img/smile/s03.gif" />
	<param name="style:smiley6" value="!! img/smile/s04.gif" />
	<param name="style:smiley7" value="!!! img/smile/s04.gif" />
	<param name="style:smiley8" value=":garde: img/smile/s05.gif" />
	<param name="style:smiley9" value="^_^ img/smile/s06.gif" />
	<param name="style:smiley10" value="^^ img/smile/s06.gif" />
	<param name="style:smiley11" value=":><: img/smile/s07.gif" />
	<param name="style:smiley12" value=":chevalier: img/smile/s08.gif" />
	<param name="style:smiley13" value=";) img/smile/s09.gif" />
	<param name="style:smiley14" value=";o) img/smile/s09.gif" />
	<param name="style:smiley15" value=":| img/smile/s10.gif" />
	<param name="style:smiley16" value=":-° img/smile/s11.gif" />
	<param name="style:smiley17" value=":-* img/smile/s11.gif" />
	<param name="style:smiley18" value=":( img/smile/s12.gif" />
	<param name="style:smiley19" value=":| img/smile/s10.gif" />
      	<param name="style:smiley20" value="<_< img/smile/s13.gif" />
      	<param name="style:smiley21" value="-_-	img/smile/s13.gif" />
      	<param name="style:smiley22" value=":lol: img/smile/s15.gif" />
      	<param name="style:smiley23" value=":D img/smile/s14.gif" />
	
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
	<a href="http://java.sun.com/webapps/getjava/BrowserRedirect?locale=fr&host=www.java.com:80">Plugin Java</a>
	</div>
</else>