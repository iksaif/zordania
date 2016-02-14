<?php
if(!defined("_INDEX_")){ exit; }

$_tpl->set("referer_404",request("REQUEST_URI","string","server"));
$_tpl->set("module_tpl","modules/404/404.tpl");
?>