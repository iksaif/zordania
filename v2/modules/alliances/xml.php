<?php
if(!defined("_INDEX_")) exit;
$mid = request("mid", "uint", "get");
$key = request("key", "string", "get");

require_once("lib/member.lib.php");
require_once("lib/alliances.lib.php");

if(!$mid OR !$key)
	exit;

$mbr_array = get_mbr_by_mid_full($mid);
if(!$mbr_array)
	exit;
if($key != calc_key($_file, $mbr_array[0]['mbr_login']))
	exit;

$_module_tpl = 'modules/alliances/xml.tpl';
$mbr_array = $mbr_array[0];

$_tpl->set("msg_array", get_aly_msg($mbr_array['ambr_aid'], LIMIT_PAGE, 0));
//$_tpl->set("mbr_array", $mbr_array);
$_tpl->set("key", $key);
$_tpl->set("mid", $mid);
?>
