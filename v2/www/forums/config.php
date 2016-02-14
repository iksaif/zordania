<?php

require_once("../../conf/conf.inc.php");
require_once("../../lib/divers.lib.php");

$db_type = 'mysql';
$db_host = MYSQL_HOST;
$db_name = MYSQL_BASE;
$db_username = MYSQL_USER;
$db_password = MYSQL_PASS;
$db_prefix = MYSQL_PREBDD_FRM;
$p_connect = false;

define('PUN', 1);
define('PUN_DEBUG',1);
?>