<?
if(_index_!="ok"){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else
{
$_tpl->set('module_tpl','modules/notes/notes.tpl');

include('lib/notes.class.php');
include('lib/parser.class.php');
$nte = new notes($_sql);

$act = isset($_GET['act']) ? $_GET['act'] : "";
$nid = isset($_GET['nid']) ? $_GET['nid'] : -1;

$_tpl->set('nte_act',$act);

if($act == "add")
{
	
	$titre = isset($_POST['nte_titre']) ? $_POST['nte_titre'] : "";
	$texte = isset($_POST['nte_texte']) ? $_POST['nte_texte'] : "";
	$import = isset($_POST['nte_import']) ? $_POST['nte_import'] : "";
	
	if($titre AND $texte)
	{
		$_tpl->set('nte_ok',$nte->add($_SESSION['user']['mid'], $titre, parser::parse($texte), $import));
	}
	else
	{
		$_tpl->set('nte_titre',$titre);
		$_tpl->set('nte_texte',$texte);
		$_tpl->set('nte_import',$import);	
	}	
}
elseif($act == "del")
{
	//Effacer
	if($nid >= 0)
	{
		$_tpl->set('nte_ok',$nte->del($_SESSION['user']['mid'], $nid));
	}
	else
	{
		$_tpl->set('nte_bad_nid',true);
	}
}
elseif($act == "edit")
{
	
	//Editer
	if($nid)
	{
		$titre = isset($_POST['nte_titre']) ? $_POST['nte_titre'] : "";
		$texte = isset($_POST['nte_texte']) ? $_POST['nte_texte'] : "";
		$import = isset($_POST['nte_import']) ? $_POST['nte_import'] : "";
		
		$_tpl->set('nte_nid',$nid);
		
		if($titre AND $texte)
		{
			$_tpl->set('nte_ok',$nte->edit($_SESSION['user']['mid'], $nid, $titre, parser::parse($texte), $import));
		}
		
		if($titre OR $texte OR $import)
		{
			$_tpl->set('nte_titre',$titre);
			$_tpl->set('nte_texte',$texte);
			$_tpl->set('nte_import',$import);	
		}
		else
		{
			$nte_array = $nte->get_infos($_SESSION['user']['mid'], $nid);
			$nte_array = $nte_array[0];
			$_tpl->set('nte_titre',$nte_array['nte_titre']);
			$_tpl->set('nte_texte',parser::unparse($nte_array['nte_texte']));
			$_tpl->set('nte_import',$nte_array['nte_import']);
		}
	}
	else
	{
		$_tpl->set('nte_bad_nid',true);
	}
}
elseif($act == "view")
{
	//Voir
	if($nid)
	{
		$nte_array = $nte->get_infos($_SESSION['user']['mid'], $nid);
		$_tpl->set('nte_array',$nte_array[0]);
	}
	else
	{
		$_tpl->set('nte_bad_nid',true);
	}	
}
else
{
	$nte_array = $nte->get_infos($_SESSION['user']['mid']);
	$_tpl->set('nte_array',$nte_array);
}
}
?>