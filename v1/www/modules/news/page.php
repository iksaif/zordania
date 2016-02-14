<?
//Verif
if(_index_!="ok"){ exit; }
//include de la classe
include("lib/news.class.php");
include("lib/parser.class.php");

//classe module
$prs=new parser();
$news=new news($_sql);
		

$_tpl->set("module_tpl","modules/news/news.tpl");

//Si admin, toutes les langues
$nws_lang = ($_SESSION['user']['droits']{5} OR $_SESSION['user']['droits']{6}) ? 0 : $_SESSION['user']['lang'];



//Droit d'admin
if($_SESSION['user']['droits']{5}==1)
{
	$_tpl->set("cmt_admin",true);
}

//Post les commentaires
if($_GET['nws_nid'] and $_GET['act']=="post_cmt" and $_POST['cmt'] and $_SESSION['user']['loged']==true)
{
	if($news->has_cmt($_SESSION['user']['ip'], $_SESSION['user']['mid']))
	{
		$_tpl->set("cmt_post","flood");		
	}
	elseif($news->add_cmt($_GET['nws_nid'], $_SESSION['user']['mid'], $_SESSION['user']['ip'], $_POST['cmt']))
	{
		$_tpl->set("cmt_post","ok");
		$_tpl->set("nws_nid",(int) $_GET['nws_nid']);
	}else{
		$_tpl->set("cmt_post","pasok");
	}
}


//Regarde toutes les news
if(!$_GET['nws_nid'])
{
	$nws_page=(int) $_GET['nws_page'];
	$_tpl->set('nws_page',$nws_page);
	$nws_nb = $news->get_nb_news($nws_lang);
	$limite_page = '5';
	$nombre_page = $nws_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	if(isset($nws_page) || $nws_page != '0' )
	{	 
		$limite_mysql = $limite_page * $nws_page;
	}else{
		$limite_mysql = '0';
	}
	$nws_array = $news->get_news(1,$limite_mysql,$limite_page,$nws_lang);// ,$_SESSION['user']['lang']);
	$_tpl->set("nws_array",$nws_array);
	$_tpl->set("nws_nb",$nws_nb);
}
elseif($_GET['nws_nid']) //une news précise
{
	$nws_array = $news->get_news(1,$_GET['nws_nid']);
	if(!$nws_array)
	{
		$nws_array=1;
	}
	$_tpl->set("nws_unique",$nws_array);
	$_tpl->set("nws_cmt",$news->get_cmt($_GET['nws_nid']));
	if($_SESSION['user']['loged']==true)
	{
		$_tpl->set("cmt_ok",true);
	}
}

?>