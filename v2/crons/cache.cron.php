<?php
$log_cache = "Cache";

require_once(SITE_DIR . "lib/session.class.php");

function glob_cache() {
	global $_t, $_p, $_ts, $_cache;

    // enregistre ces valeurs dans le fichier /cache/global.cache.php
	$_cache->mtime = mtime();
	$_cache->nb_online = (int) nb_online();
	$_cache->nb_mbr = (int) get_nb_mbr();
	$_cache->tour = $_t;
	$_cache->tours = $_ts;
	$_cache->period = $_p;

}

?>