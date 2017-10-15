<?php
if(!defined("_INDEX_")){ exit; }

include('lib/forum.lib.php');
include('lib/parser.lib.php');

$_tpl->set("module_tpl","modules/forum/forum.tpl");
$pid = request('pid','uint','get');
if(!$pid)
	exit;

$_module_tpl = "modules/forum/forum_xml.tpl";
$post = get_posts(array('pid'=>$pid));
if(!empty($post)){
	$droits = get_frm_droits($post[0]['forum_id'], $_user['groupe']);
	if($droits['read_forum'] == 1)
		$_tpl->set('post', $post[0]);
	else
		$_tpl->set('noperm', true);
}
?>
