<?
//Verif
if(_index_!="ok" or ($_SESSION['user']['droits']{5}!=1 AND $_SESSION['user']['droits']{6}!=1)){ exit; }
//include de la classe
include("lib/news.class.php");
include("lib/parser.class.php");

//classe module
$prs=new parser();
$news=new news($_sql);
		

$_tpl->set("admin_tpl","modules/news/admin.tpl");
$_tpl->set("admin_name","News");
$_tpl->set("nws_nb",$news->get_nb_news($_SESSION['user']['lang']));

$_GET['nws_nid'] = (int) $_GET['nws_nid'];
$_GET['cmt_id'] = (int) $_GET['cmt_id'];


if(!$_GET['nws_nid'] and !$_GET['act'])
{
	$nws_page=(int) $_GET['nws_page'];
	$nws_nb = $news->get_nb_news();
	$limite_page = '10';
	$nombre_page = $nws_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	if(isset($nws_page) || $nws_page != '0' )
	{	 
		$limite_mysql = $limite_page * $nws_page;
	}else{
		$limite_mysql = '0';
	}
	$nws_array = $news->get_news(0,$limite_mysql,$limite_page );
	$_tpl->set("nws_array",$nws_array);
}
elseif($_GET['nws_nid'] and $_GET['act']=="edit" and $_SESSION['user']['droits']{6}==1)
{
	$_tpl->set("nws_nid",$_GET['nws_nid']);
	$_tpl->set("nws_act","edit");
	$nws_array=$news->get_news(0,$_GET['nws_nid']);
	$_tpl->set("nws_login",$nws_array[0]['mbr_pseudo']);
	$_tpl->set("nws_texte_parsed",$nws_array[0]['nws_texte']);
	$_tpl->set("nws_texte",parser::unparse($nws_array[0]['nws_texte']));
	$_tpl->set("nws_titre",$nws_array[0]['nws_titre']);
	$_tpl->set("nws_etat",$nws_array[0]['nws_etat']);
	$_tpl->set("nws_lang",$nws_array[0]['nws_lang']);
	$_tpl->set("nws_cat",$nws_array[0]['nws_cat']);
	$_tpl->set("nws_closed",$nws_array[0]['nws_closed']);
	if($_POST['nws_texte'] and $_POST['nws_titre'] and $_POST['nws_auteur'] and $_POST['nws_lang'] and $_POST['nws_etat'] AND $_POST['nws_cat'])
	{
		$_tpl->set("nws_login",$_POST['nws_auteur']);
		$_tpl->set("nws_texte",$_POST['nws_texte']);
		$_tpl->set("nws_texte_parsed",parser::parse($_POST['nws_texte']));
		$_tpl->set("nws_titre",$_POST['nws_titre']);
		$_tpl->set("nws_etat",$_POST['nws_etat']);
		$_tpl->set("nws_lang",$_POST['nws_lang']);
		$_tpl->set("nws_cat",$_POST['nws_cat']);
		$_tpl->set("nws_closed",$_POST['nws_closed']);
		if($news->edit_news(
			$_GET[nws_nid],
        		array(
        			'mid' => $_SESSION['user']['mid'],
        			'etat' => $_POST['nws_etat'],
        			'ip' => $_SESSION['user']['ip'],
        			'titre' => $_POST['nws_titre'],
        			'lang' => $_POST['nws_lang'],
        			'texte' => $_POST['nws_texte'],
        			'cat' => $_POST['nws_cat'],
        			'closed' => (int) $_POST['nws_closed'],
        			)
			))
		{
		$_tpl->set("nws_ok","ok");
		}else{
		$_tpl->set("nws_ok","pasok");
		}
	}
	elseif($_POST['nws_texte'] or $_POST['nws_titre'] or $_POST['nws_auteur'] or $_POST['nws_lang'] or $_POST['nws_etat'] or $_POST['nws_cat'])
	{
		$_tpl->set("nws_login",$_POST['nws_auteur']);
		$_tpl->set("nws_texte",$_POST['nws_texte']);
		$_tpl->set("nws_titre",$_POST['nws_titre']);
		$_tpl->set("nws_etat",$_POST['nws_etat']);
		$_tpl->set("nws_lang",$_POST['nws_lang']);
		$_tpl->set("nws_cat",$_POST['nws_cat']);
		$_tpl->set("nws_closed",$_POST['nws_closed']);
		$_tpl->set("nws_ok","manque");
	}
}
elseif($_GET['nws_nid'] and $_GET['act']=="drop" and $_GET['secu']!="ok" and $_SESSION['user']['droits']{6}==1)
{
	$_tpl->set("nws_act","drop");
	$_tpl->set("nws_nid",$_GET[nws_nid]);
}
elseif($_GET['nws_nid'] and $_GET['act']=="drop" and $_GET['secu']=="ok" and $_SESSION['user']['droits']{6}==1)
{
	$_tpl->set("nws_act","dropreal");
	$_tpl->set("nws_nid",$_GET['nws_nid']);
	$_tpl->set("nws_drop_ok",$news->del_news($_GET['nws_nid']));
}
elseif($_GET['act']=="addnews" and $_SESSION['user']['droits']{6}==1)
{
	$_tpl->set("nws_act","new");
	$_tpl->set("nws_login",$_SESSION['user']['pseudo']);
}
elseif($_GET['act']=="newnews" and $_SESSION['user']['droits']{6}==1)
{
	$_tpl->set("nws_act","new");
	if($_POST['nws_texte'] and $_POST['nws_titre'] and $_POST['nws_auteur'] and $_POST['nws_lang'] and $_POST['nws_cat'] and $_POST['nws_etat'])
	{
		if($news->add_news($_SESSION['user']['mid'], $_SESSION['user']['ip'], $_POST['nws_titre'], $_POST['nws_texte'], $_POST['nws_etat'], $_POST['nws_lang'], $_POST['nws_cat'], $_POST['nws_closed']))
		{
		$_tpl->set("nws_ok","ok");
		}else{
		$_tpl->set("nws_ok","pasok");
		}
	}else{
		$_tpl->set("nws_login",$_POST['nws_auteur']);
		$_tpl->set("nws_texte",$_POST['nws_texte']);
		$_tpl->set("nws_titre",$_POST['nws_titre']);
		$_tpl->set("nws_etat",$_POST['nws_etat']);
		$_tpl->set("nws_lang",$_POST['nws_lang']);
		$_tpl->set("nws_cat",$_POST['nws_cat']);
		$_tpl->set("nws_closed",$_POST['nws_closed']);
		$_tpl->set("nws_ok","manque");
	}
}
elseif($_GET['act'] == "edit_cmt"  and $_SESSION['user']['droits']{5}==1)
{
	$_tpl->set("nws_act","edit_cmt");
	if($_POST['cmt_texte'] AND $_GET['cmt_id'])
	{
		$_tpl->set("cmt_id",$_GET['cmt_id']);
		$_tpl->set("cmt_texte",$_POST['cmt_texte']); 
		if($news->edit_cmt($_GET['cmt_id'], array( 
					'texte' => $_POST['cmt_texte']
					)
					))
		{
			$_tpl->set("cmt_texte",$_POST['cmt_texte']); 
			$_tpl->set("cmt_ok","ok");
		}else{
			$_tpl->set("cmt_texte",$_POST['cmt_texte']); 
			$_tpl->set("cmt_ok","pasok");
		}
	}
	elseif($_POST['cmt_texte'])
	{
		echo "kaka";
		$_tpl->set("cmt_ok","manque");
	}
	elseif($_GET['cmt_id'])
	{
		$_tpl->set("cmt_id",$_GET['cmt_id']);
		$array=$news->get_one_cmt($_GET['cmt_id']);
		$txt=$prs->unparse($array[0]['cmt_texte']);
		$_tpl->set("cmt_texte",$txt); 
	}
	else
	{
		$_tpl->set("cmt_ok","manque");
	}
}
elseif($_GET['act'] == "drop_cmt" and $_SESSION['user']['droits']{5}==1)
{
	$_tpl->set("nws_act","drop_cmt");
	$_tpl->set("cmt_id",$_GET['cmt_id']);
	if(!$_GET['cmt_id'])
	{
		$_tpl->set("cmt_ok","manque");

	}	
	elseif($_GET['secu']=="ok")
	{
		if($news->del_cmt($_GET['cmt_id']))
		{
			$_tpl->set("cmt_ok","ok");
		}
		else
		{
			$_tpl->set("cmt_ok","pasok");
		}		
	}	
}
?>