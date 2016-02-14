<?php
/* Envoit un mail */
function mailtobis($from, $to, $sujet, $message, $html=FALSE)
{
	if($html) {
  		$from ="From: Zordania <".$from."> \n"; 
  		$from .= "MIME-Version: 1.0\n";
		$from .= "Content-type: text/html; charset=iso-8859-1\n";
	 }else
		$from="From: $from";

	return mail($to,$sujet,$message,$from, "-f".SITE_WEBMASTER_MAIL);
}
$array_to = array("nicolas_gras@hotmail.com", "danygras@free.fr", "nicolas.gras@imelavi.fr");
foreach($array_to as $to){
	echo "envoi à $to<br/>";
	mailtobis(SITE_WEBMASTER_MAIL, $to, "coucou bienvenu", "message du mail.");
	//mail($to, "coucou bienvenu", "message du mail.", "From: ".SITE_WEBMASTER_MAIL."\r\nReply-To:".SITE_WEBMASTER_MAIL);
}
die();
?>
