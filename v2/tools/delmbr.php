<?php
/* supprimer des membres par leur mail */
date_default_timezone_set("Europe/Paris");

require_once("../conf/conf.inc.php");
require_once(SITE_DIR . "lib/divers.lib.php");
require_once(SITE_DIR . "lib/mysql.class.php");
require_once(SITE_DIR . "lib/Template.class.php");
require_once(SITE_DIR . "lib/vld.lib.php");
require_once(SITE_DIR . "lib/member.lib.php");

require_once(SITE_DIR ."lib/btc.lib.php");
require_once(SITE_DIR ."lib/res.lib.php");
require_once(SITE_DIR ."lib/unt.lib.php");
require_once(SITE_DIR ."lib/trn.lib.php");
require_once(SITE_DIR ."lib/src.lib.php");
require_once(SITE_DIR ."lib/alliances.lib.php");
require_once(SITE_DIR ."lib/heros.lib.php");
require_once(SITE_DIR ."lib/mch.lib.php");
require_once(SITE_DIR ."lib/war.lib.php");
require_once(SITE_DIR ."lib/histo.class.php");
require_once(SITE_DIR ."lib/vld.lib.php");
require_once(SITE_DIR ."lib/nte.lib.php");
require_once(SITE_DIR ."lib/msg.lib.php");
require_once(SITE_DIR ."lib/map.lib.php");

/* BDD */
$_sql = new mysqliext(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

/* sélection des comptes à supprimer par leur mail */
// SELECT concat('''',mbr_mail,''',') FROM `zrd_mbr` WHERE mbr_mid not in (1, 9, 7183)

$arr_mail = array(
);

foreach($arr_mail as $mail){
	$array = get_mbr_gen(array('mail' => $mail, 'full' => true));

	if($array) {
		$array = $array[0];
		$race = $array['mbr_race'];
		$cid = $array['mbr_mapcid'];
		$mid = $array['mbr_mid'];

		cls_mbr($mid, $cid, $race);
		echo "$mail supprimé\n";
	}
	else
		echo "echec suppression $mail\n";
}

?>
