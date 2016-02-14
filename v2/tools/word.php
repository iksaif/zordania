<?php
date_default_timezone_set("Europe/Paris");

require_once("../conf/conf.inc.php");
require_once("../lib/divers.lib.php");
require_once("../lib/mysql.class.php");

$conf = array();
for($i = 1; $i <= 5; ++$i) {
	require_once("../conf/" . $i . ".php");
	$name = "config".$i;
	$conf[$i] = new $name();
}

$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);


$sql = "SELECT id, word FROM ".$_sql->prebdd."frm_search_words";
$arr_words = $_sql->make_array($sql);
$_words = array();
foreach($arr_words as $wrd)
	$_words[$wrd['id']] = $wrd['word'];

$file = SITE_DIR . "cache/words.cache.php";
$fp = fopen($file, "w");

$txt = '<?php $_words = ';
$txt .=  var_export($_words, true);
$txt .= '; ?>';

fwrite($fp, $txt);
fclose($fp);
?>
