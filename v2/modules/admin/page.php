<?php
//Verif
if(!defined("_INDEX_") or !can_d(DROIT_ADM)){ exit; }

$module = request("module", "string", "get");

$_tpl->set("module_tpl","modules/admin/admin.tpl");

if(file_exists(SITE_DIR . "modules/$module/admin.php"))
	require_once(SITE_DIR . "modules/$module/admin.php");
else {
	$handle = opendir(SITE_DIR.'modules/');
	$pages = array();
	while ($file = readdir($handle)) {
		if ($file != "." && $file != ".." && file_exists(SITE_DIR . "modules/$file/admin.php"))
			$pages[]=$file;
	}
	closedir($handle);
	$_tpl->set("admin_array",$pages);
}
?>
