<?
if(_index_!="ok"){exit;}

$_tpl->set('module_tpl', 'modules/irc/irc.tpl');
if($_GET['act'] =="chat")
{
	$_tpl->set('irc_chat',true);
}

?>