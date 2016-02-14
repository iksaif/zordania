<?
if(_index_!="ok"){ exit; }
$_tpl->set("module_tpl","modules/session/session.tpl");



if($_GET[act] == "login")
{
$_tpl->set("ses_act","login");
if($_SESSION['user']['loged'] == true)
{
	$_tpl->set("ses_is_loged",true);	
}else{
	if(!$_POST['login'] or !$_POST['pass'])
	{
		$_tpl->set("ses_noallpost",true);
	}else{
		if($_ses->logout(true) AND $_ses->login($_POST['login'], $_POST['pass']))
		{
			$_tpl->set("ses_redir",true);
			$_tpl->set("no_html",true);
			$_tpl->set('module_tpl',"modules/session/session.tpl");
			//echo $_tpl->get("modules/session/session.tpl", 1);
		}else{
			$_ses->auto_login();
			$_tpl->set("ses_loginerror", true);
		}
	}
}
}

if($_GET[act] == "logout")
{
	$_tpl->set("ses_act","logout");
	if($_SESSION['user']['loged'] != true)
	{
		$_tpl->set("ses_is_not_loged",true);	
	}else{
		$_tpl->set("no_html",true);
		$_tpl->set("ses_redir",true);
		$_ses->logout(true);
		$_tpl->set('module_tpl',"modules/session/session.tpl");
		//echo $_tpl->get("modules/session/session.tpl", 1);
	}	
}
?>