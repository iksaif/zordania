<?php
$log_cache = "Cache";

require_once(SITE_DIR . "lib/session.class.php");

function glob_cache() {
	global $_t, $_p, $_ts;

	$file = SITE_DIR . "cache/global.cache.php";
	$fp = fopen($file, "w");

	$cache = array();
	$cache['mtime'] = mtime();
	$cache['nb_online'] = (int) nb_online();
	$cache['nb_mbr'] = (int) get_nb_mbr();
	$cache['tour'] = $_t;
	$cache['tours'] = $_ts;
	$cache['period'] = $_p;

	$txt = '<?php $_cache = ';
	$txt .=  var_export($cache, true);
	$txt .= '; ?>';

	fwrite($fp, $txt);
	fclose($fp);
}

?>