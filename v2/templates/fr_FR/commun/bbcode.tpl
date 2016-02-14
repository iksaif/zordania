<# bbcode : variables
message = nom du textarea (facultatif)

include générique :
<include file='commun/bbcode.tpl' cache='1' />
#>
<if cond="!isset({message})"><set name="message" value="message"/></if>
<p>
	<script language="javascript" src="js/bbcode.js" type="text/javascript"></script>
	<input type="button" class="strong" accesskey="b" id="addbbcode0" name="addbbcode0" onclick="bbstyle(0,'{message}')" value="B" />
	<input type="button" class="italique" accesskey="i" id="addbbcode2" name="addbbcode2" onclick="bbstyle(2,'{message}')" value="I" />
	<input type="button" class="souligne" accesskey="s" id="addbbcode12" name="addbbcode12" onclick="bbstyle(12,'{message}')" value="U" />
	<input type="button" accesskey="l" id="addbbcode4" name="addbbcode4" onclick="bbstyle(4,'{message}')" value="Liste" />
	<input type="button" accesskey="m" id="addbbcode6" name="addbbcode6" onclick="bbstyle(6,'{message}')" value="IMG" />
	<input type="button" accesskey="u" id="addbbcode8" name="addbbcode8" onclick="bbstyle(8,'{message}')" value="URL" />
	<input type="button" accesskey="q" id="addbbcode10" name="addbbcode10" onclick="bbstyle(10,'{message}')" value="QUOTE" />
	<input type="button" accesskey="c" id="addbbcode14" name="addbbcode14" onclick="bbstyle(14,'{message}')" value="CENTER" />
&nbsp;
	<foreach cond="{smileys_base} as {img} => {str}">
		<a href="javascript:emoticon('{str}','{message}');"><img src="img/smile/{img}" alt="{str}" title="{str}" /></a>
	</foreach>
	<img id="smileys" src="img/plus.png" alt="Tous les smileys" class="toggle" />
	<div id="smileys_toggle">
		<foreach cond="{smileys_more} as {img} => {str}">
			<a href="javascript:emoticon('{str}','{message}');"><img src="img/smile/{img}" alt="{str}" title="{str}" /></a>
		</foreach>
		<img onclick="myPopup('smileys', '', 700,550);return false;" src="img/star.png" title="Popup" alt="Popup">
	</div>
</p>

