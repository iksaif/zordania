<?php
if(!defined("_INDEX_")){exit;}

$_tpl->set('module_tpl', 'modules/irc/irc.tpl');
$_tpl->set('irc_chat',$_act);

if($_act =="java")
	$_tpl->set('_smileys', $_smileys);
elseif($_act =='webchat')
	$_tpl->set('pseudo',str2url($_user['pseudo']));

?>
