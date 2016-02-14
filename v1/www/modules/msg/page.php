<?
if(_index_!="ok"){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else
{
include('lib/msg.class.php');
include('lib/parser.class.php');
$msg = new msg($_sql);

$act = isset($_GET['act']) ? $_GET['act'] : "";
$_tpl->set('module_tpl','modules/msg/msg.tpl');
$_tpl->set('msg_act',$act);

if(!$act)
{
	$msg_array = $msg->get_msg($_SESSION['user']['mid']);
	$_tpl->set('msg_array',$msg_array);
}
elseif($act == "env")
{
	$msg_array = $msg->get_msg($_SESSION['user']['mid'],-1,false);
	$_tpl->set('msg_array',$msg_array);	
}
elseif($act == "read")
{
	if(isset($_GET['msg_msgid']))
	{
		$msg_infos = $msg->get_msg($_SESSION['user']['mid'],$_GET['msg_msgid']);
		if($msg_infos[0]['msg_not_readed'] == 1)
		{
			$msg->mark_as_readed($_SESSION['user']['mid'],$_GET['msg_msgid']);
		}
		$_tpl->set('msg_infos',$msg_infos[0]);
	}
	else
	{
		$_tpl->set('msg_pas_tout',true);
	}
}
elseif($act == "read_env")
{
	if(isset($_GET['msg_msgid']))
	{
		$msg_infos = $msg->get_msg($_SESSION['user']['mid'],$_GET['msg_msgid'],false);
		$_tpl->set('msg_infos',$msg_infos[0]);
	}
	else
	{
		$_tpl->set('msg_pas_tout',true);
	}
}
elseif($act == "del")
{
	if(isset($_GET['msg_msgid']))
	{
		$_tpl->set(
			'msg_del',
			$msg->delete_msg($_SESSION['user']['mid'],$_GET['msg_msgid'])
			);
		
	}
	else
	{
		$_tpl->set('msg_pas_tout',true);
	}	
}
elseif($act == "new")
{
	if($_GET['mbr_mid'])
	{
		$mbr_infos = $mbr->get_infos($_GET['mbr_mid']);
		$_tpl->set('msg_pseudo',$mbr_infos[0]['mbr_pseudo']);
		if(isset($_GET['msg_msgid']))
		{
			$msg_infos = $msg->get_msg($_SESSION['user']['mid'],$_GET['msg_msgid']);
			$texte .= "\n\n\n\n";
			$texte .= "[b]".$mbr_infos[0]['mbr_pseudo']." @ ".$msg_infos[0]['msg_date_formated']."[/b]\n";
			$texte .="| ";
			$texte .= str_replace("\n","\n| ",parser::unparse($msg_infos[0]['msg_texte']));
			$titre = str_replace("Re: Re: ","Re: ","Re: ".$msg_infos[0]['msg_titre']);	

			$_tpl->set('msg_texte',$texte);
			$_tpl->set('msg_titre',$titre);
		}
	}
}
elseif($act == "send")
{
	if(!$_POST['msg_pseudo'] OR !$_POST['msg_texte'] OR !$_POST['msg_titre'])
	{
		$_tpl->set('msg_act','new');
		$_tpl->set('msg_pseudo',$_POST['msg_pseudo']);
		$_tpl->set('msg_texte',$_POST['msg_texte']);
		$_tpl->set('msg_titre',$_POST['msg_titre']);
		$_tpl->set('msg_pas_tout',true);	
	}
	else
	{
		//recuperer le mid avec le pseduo
		$mbr_infos = $mbr->get_infos(false, false, array('pseudo_exact' => $_POST['msg_pseudo']));
		$mid2 = $mbr_infos[0]['mbr_mid'];
		if($mid2 > 0 AND $mbr->mbr_exists($mid2))
		{
			$msg_sended = $msg->new_msg($_SESSION['user']['mid'],$mid2,$_POST['msg_titre'],$_POST['msg_texte'],!$_SESSION['user']['droits']{19});
			$_tpl->set('msg_sended',$msg_sended);

			if($msg_sended) $histo->add($mid2, $_SESSION['user']['mid'], 51,array(0,0,0,0), true);
		}
		else
		{
			$_tpl->set('msg_mbr_not_exist',true);
		}
	}
}
}
?>