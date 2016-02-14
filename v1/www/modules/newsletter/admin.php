<?
//Verif
if(_index_!="ok" or ($_SESSION['user']['droits']{7}!=1 OR $_SESSION['user']['droits']{6}!=1)){ exit; }
//include de la classe
include('lib/newsletter.class.php');
include('lib/parser.class.php');

$nwsl = new newsletter();

$_tpl->set('module_tpl','modules/newsletter/newsletter.tpl');

$act = isset($_GET['act']) ? $_GET['act'] : '';

//Nouvelle
if(!$act OR (!$_POST['nws_titre'] OR !isset($_POST['nws_diff']) OR !$_POST['nws_message']))
{
	$_tpl->set('nws_act','new');
	
	$_tpl->set('nws_titre',$_POST['nws_titre']);
	$_tpl->set('nws_diff',$_POST['nws_diff']);
	$_tpl->set('nws_message',$_POST['nws_message']);
	
	$_tpl->set('nws_titre_parsed',parser::parse($_POST['nws_titre']));
	$_tpl->set('nws_message_parsed',parser::parse($_POST['nws_message']));
}
//Prévisualiser
//Envoyer
elseif($act == 'send')
{
	$_tpl->set('nws_act','send');
	
	$mails = $mbr->get_emails($_POST['nws_diff'],$_POST['mbr_valide']);
	
	$message = $_tpl->get('commun/mail_debut.tpl',1).parser::parse($_POST['nws_message']).$_tpl->get('commun/mail_fin.tpl',1);
	$nwsl_ok = $nwsl->send($mails, $_POST['nws_titre'], $message, SITE_WEBMASTER_MAIL);
	$_tpl->set('nwsl_ok',$nwsl_ok);
	$_tpl->set('nwsl_nb',$nwsl->nb);
}

?>