<?php
if(!defined("_INDEX_")){ exit; }
$_tpl->set("module_tpl","modules/session/session.tpl");

if($_act == "login")
{
	$_tpl->set("ses_act","login");
	if(can_d(DROIT_PLAY))
		$_tpl->set("ses_is_loged",true);	
	else {
		$login = request("login", "string", "post");
		$pass = request("pass", "raw", "post");
		if(!$login || !$pass)
		{
			$_tpl->set("ses_noallpost",true);
		}else{
			if($_ses->logout() && $_ses->login($login, $pass))
			{
				$_tpl->set("ses_redir",true);
				$_tpl->set("module_tpl","modules/session/session.tpl");
				$_display = "module";
			}else{
				$_ses->auto_login();
				$_tpl->set("ses_loginerror", true);
			}
		}
	}
}

if($_act == "logout")
{
	$_tpl->set("ses_act","logout");
	if(!can_d(DROIT_PLAY))
	{
		$_tpl->set("ses_is_not_loged",true);
	}else{
		$_tpl->set("no_html",true);
		$_tpl->set("ses_redir",true);
		$_ses->logout();
		$_tpl->set('module_tpl',"modules/session/session.tpl");
	}
}
?>
