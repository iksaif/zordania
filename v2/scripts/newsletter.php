<?php
/* Config */
$id = 0;
$src = array();

/* Script en lui même */
require_once("conf/conf.inc.php");
require_once(SITE_DIR."lib/mysql.class.php");
require_once(SITE_DIR."lib/templates.class.php");
require_once(SITE_DIR."lib/member.class.php");
require_once(SITE_DIR."lib/paser.class.php");

$_sql=new mysql(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);

$mbr = new member($_sql);

$mbr_array = $mbr->get_infos($src);

$tpl = new Templates();
$tpl->set_dir();

foreach($mbr_array as $values) {
	$mail = $values['mbr_mail'];
	$pseudo = $values['mbr_pseudo'];
	$ldate = $values['mbr_ldate'];	

	$_tpl->set("mbr_pseudo", $pseudo);
	$_tpl->set("mbr_mail", $mail);
	$_tpl->set("mbr_ldate", $ldate);
	
	$headers = "";

	$objet = $tpl->get("objet_".$id.".tpl");
	$texte = $tpl->get("texte_".$id.".tpl");
	mail();
}
?>