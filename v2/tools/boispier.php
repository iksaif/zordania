<?php
/*
 *  ce script php ajoute 1000 ressources pierre (4)
 * et aussi génère 100 ventes au marché de 50 bois contre 50 or, et 50 pierres contre 50 or
 */
require_once("../lib/divers.lib.php");
require_once("../conf/conf.inc.php");
require_once("../lib/mysql.class.php");
require_once("../lib/unt.lib.php");



$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

$sql = "UPDATE zrd_res SET res_type4 = res_type4 + 1000 ";
$_sql->query($sql);

for($i = 0; $i < 100; ++$i) {
	$sql = "INSERT INTO zrd_mch VALUES ( NULL , '2', '2', '50', '50', NOW( ) , '2')";
	$_sql->query($sql);

	$sql = "INSERT INTO zrd_mch VALUES ( NULL , '2', '3', '50', '50', NOW( ) , '2')";
	$_sql->query($sql);
}
?>
