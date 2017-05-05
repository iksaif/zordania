<?php
//Verif
if(!defined("_INDEX_")){ exit; }

if(!can_d(DROIT_SITE))
	$_tpl->set("need_to_be_loged",true);
else if(!can_d(DROIT_ADM))
	$_tpl->set("cant_view_this",true);
else {

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
}
?>
