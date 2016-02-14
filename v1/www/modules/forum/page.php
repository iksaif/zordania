<?
if(_index_!="ok" or $_SESSION['user']['droits']{1}!=1){ exit; }
/*if($_SESSION['user']['loged']!=true)
{ 
	$_tpl->set("need_to_be_loged",true); 
}
else*/
if($_SESSION['user']['droits']{9}!=1)
{ 
	$_tpl->set("can_view_this",true); 
}
else
{
//ajouter verif forum et index
include('lib/forum.class.php');
include('lib/parser.class.php');

$_tpl->set('module_tpl','modules/forum/forums.tpl');
$frm = new forum($_sql);

$act = isset($_GET['act']) ? $_GET['act'] : "";
$sub = isset($_GET['sub']) ? $_GET['sub'] : "";

$_tpl->set('session_forum',$_SESSION['forum']);

$can_post = $_SESSION['user']['droits']{10};
$can_edit = $_SESSION['user']['droits']{11};
$is_modo  = $_SESSION['user']['droits']{12};

$_tpl->set('can_pst',$can_post);
$_tpl->set('can_edit',$can_edit);
$_tpl->set('is_modo',$is_modo);

if(!$act OR $act=="view_cat")
{
	if($act == "view_cat")
	{
		$_tpl->set('frm_act','view_cat');
	}
	else
	{
		$_tpl->set('frm_act','view_all');
	}
	
	$frm_array = $frm->get_cat($_GET['cat_cid']);
	$frm_array = $frm->can_view($frm_array, array('frm_droit','cat_droit'), $_SESSION['user']['droits']);

	$_tpl->set('frm_array',$frm_array);
}
elseif($act=="view_frm")
{
	$_tpl->set('frm_act','view_frm');

	$frm_page=(int) $_GET['frm_page'];
	$_tpl->set('frm_page',$frm_page);
	$frm_nb = $frm->count_pst(0, $_GET['frm_fid']);
	$limite_page = FRM_LIMIT_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set('limite_nb_page',FRM_LIMIT_NB_PAGE);
	$_tpl->set("pst_nb",$frm_nb);

	$nombre_page = ($frm_nb / $limite_page);
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	
	$current_i = $frm_page - (FRM_LIMIT_NB_PAGE / 2);
	$current_i = round($current_i < 0 ? 0 : $current_i)*FRM_LIMIT_PAGE;
	$_tpl->set('current_i',$current_i);
	
	if(isset($frm_page) AND $frm_page > 0)
	{	 
		$limite_mysql = $limite_page * $frm_page;
	}
	else
	{
		$limite_mysql = 0;
	}

	$frm_array = $frm->get_frm($_GET['frm_fid'], $limite_page, $limite_mysql);
	$frm_array = $frm->can_view($frm_array, array('frm_droit'), $_SESSION['user']['droits']);

	if(!count($frm_array))
	{
		$frm_array = $frm->get_frm_lite($_GET['frm_fid']);
		$frm_array = $frm->can_view($frm_array, array('frm_droit'), $_SESSION['user']['droits']);
	}
	
	if((!$_GET['frm_fid'] OR !count($frm_array))  AND $_GET['frm_fid'])
	{
		$_tpl->set('pst_empty',true);
	}
	else
	{
		$_tpl->set('frm_fid',(int) $_GET['frm_fid']);
		$_tpl->set('frm_array',$frm_array);
	}
}
elseif($act=="view_pst")
{
	$_tpl->set('frm_act','view_pst');

	$pst_page=(int) $_GET['pst_page'];
	$pst_nb = $frm->count_pst($_GET['pst_pid'])+1;
	$limite_page = FRM_LIMIT_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set('limite_nb_page',FRM_LIMIT_NB_PAGE);
	$_tpl->set("pst_nb",$pst_nb);

	$nombre_page = ($pst_nb / $limite_page);
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	
	if($_GET['pst_page'] == "last")
	{
		$pst_page = $nombre;
	}
	$_tpl->set('pst_page',$pst_page);
	
	if(isset($pst_page) AND $pst_page > 0)
	{	 
		$limite_mysql = $limite_page * $pst_page;
	}
	else
	{
		$limite_mysql = 0;
	}

	$_tpl->set('pst_pid',(int) $_GET['pst_pid']);

	$pst_array = $frm->get_pst($_GET['pst_pid'], $limite_page, $limite_mysql);
	$pst_array = $frm->can_view($pst_array, array('frm_droit'), $_SESSION['user']['droits']);
	if(isset($_GET['hl']))
		$pst_array = $frm->highlight_pst($pst_array, $_GET['hl']);
		
		
	
	if((!$_GET['pst_pid'] OR !count($pst_array)))
	{
		$_tpl->set('pst_empty',true);
	}
	else
	{
		$frm_array = $frm->get_frm_lite($pst_array[0]['frm_id']);
		$frm->set_as_readed($_GET['pst_pid']);
		$_tpl->set('frm_array',$frm_array[0]);
		$_tpl->set('pst_array',$pst_array);
	}
}
elseif($act=="new_pst" AND $can_post)
{
	$_tpl->set('module_tpl','modules/forum/actions.tpl');
	$_tpl->set('frm_act','new_pst');
	//si pid
	if($_GET['pst_pid'])
	{
		$pid = (int) $_GET['pst_pid'];
		$_tpl->set('pst_pid',$pid);
		$pst_array = $frm->get_pst($pid);
		$pst_array = $frm->can_view($pst_array, array('frm_droit'), $_SESSION['user']['droits']);
		if(!count($pst_array) OR $pst_array[0]['pst_open'] == 0)//si existe pas ou fermé
		{
			$_tpl->set('bad_pid',true);
		}
		else //sinon
		{
			$frm_array = $frm->get_frm_lite($pst_array[0]['frm_id']);
			$_tpl->set('frm_array',$frm_array[0]);
			$_tpl->set('pst_array',$pst_array);
			
			$pst_array2 = $frm->get_pst($pid, FRM_SHOW_POST_WHEN_REPLY, 0, array('DESC','pst_date'));
			$_tpl->set('pst_array2',$pst_array2);

			if($_POST['pst_message']) //si post
			{
				if($_POST['pst_submit'])
				{
					$frm->new_pst($_SESSION['user']['mid'], $_POST['pst_titre'], parser::parse($_POST['pst_message']), $pid, $pst_array[0]['frm_id'],$pst_array[0]['pst_etat'], $pst_array[0]['pst_open']);
					$_tpl->set('pst_ok',true);		
				}
				else
				{
					$_tpl->set('pst_titre',$_POST['pst_titre']);
					$_tpl->set('pst_message',$_POST['pst_message']);
					$_tpl->set('pst_message_formated',parser::parse($_POST['pst_message']));
					$_tpl->set('pst_ok',false);
				}	
			}
			else //sinon
			{
				$_tpl->set('pst_ok',false);
			}		
		}			
	}
	elseif($_GET['frm_fid'])
	{
		$fid = (int) $_GET['frm_fid'];
		$_tpl->set('frm_fid',$fid);
		
		$frm_array = $frm->get_frm_lite($fid);
		$frm_array = $frm->can_view($frm_array, array('frm_droit'), $_SESSION['user']['droits']);
		if(!count($frm_array))//si existe pas ou fermé
		{
			$_tpl->set('bad_fid',true);
		}
		else //sinon
		{
			$_tpl->set('frm_array',$frm_array[0]);
			if($_POST['pst_titre'] OR $_POST['pst_message']) //si post
			{
				if($_POST['pst_submit'] AND $_POST['pst_titre'] AND $_POST['pst_message'])
				{
					$frm->new_pst($_SESSION['user']['mid'], $_POST['pst_titre'], parser::parse($_POST['pst_message']), 0, $fid,3,1);
					$_tpl->set('pst_ok',true);		
				}
				else
				{
					$_tpl->set('pst_titre',$_POST['pst_titre']);
					$_tpl->set('pst_message',$_POST['pst_message']);
					$_tpl->set('pst_message_formated',parser::parse($_POST['pst_message']));
					$_tpl->set('pst_ok',false);
				}	
			}
			else //sinon
			{
				$_tpl->set('pst_ok',false);
			}		
		}			

	}
	else
	{
		$_tpl->set('can_post_here',true);
	}
}
elseif($act=="edit_pst")
{
//Editer un post
	$_tpl->set('module_tpl','modules/forum/actions.tpl');
	$_tpl->set('frm_act','edit_pst');
	if($_GET['pst_pid'])
	{
		$pid = (int) $_GET['pst_pid'];
		$_tpl->set('pst_pid',$pid);
		$pst_array = $frm->get_pst($pid);
		$pst_array = $frm->can_view($pst_array, array('frm_droit'), $_SESSION['user']['droits']);
		//Infos sur le post (peut voir, existe)
		//Auteur ou modo ?
		if(!count($pst_array) OR !$can_edit OR (!$is_modo AND $_SESSION['user']['mid'] != $pst_array[0]['pst_mid']))
		{
			$_tpl->set('bad_pid',true);
		}
		else //sinon
		{
			$frm_array = $frm->get_cat();
			$_tpl->set('frm_array',$frm_array);
			$_tpl->set('pst_array',$pst_array);

			if($_POST['pst_submit'])
			{
				if($_POST['pst_titre']){ $edit['titre'] = $_POST['pst_titre']; }
				if($_POST['pst_message']){ $edit['texte'] =  parser::parse($_POST['pst_message']); }

				if($is_modo)
				{
					if($_POST['pst_etat']){  $edit['etat']  = $_POST['pst_etat']; }
					if($_POST['pst_forum']){ $edit['fid']   = $_POST['pst_forum']; }
					if($_POST['pst_open']) { $edit['open']  = $_POST['pst_open']; }else{ $edit['open'] = 0; }
				}

				$frm->edit_pst($pid , $edit);
				$_tpl->set('pst_ok',true);		
			}
			else
			{
				$_tpl->set('pst_titre',		$_POST['pst_titre'] ? $_POST['pst_titre'] : $pst_array[0]['pst_titre']);
				$_tpl->set('pst_message',	$_POST['pst_message'] ? $_POST['pst_message'] : parser::unparse($pst_array[0]['pst_texte']));
				$_tpl->set('pst_message_formated',$_POST['pst_message'] ? parser::parse($_POST['pst_message']) : $pst_array[0]['pst_texte']);
				$_tpl->set('pst_etat',		$_POST['pst_etat'] ? $_POST['pst_etat'] : $pst_array[0]['pst_etat']);
				$_tpl->set('pst_open',		$_POST['pst_open'] ? $_POST['pst_open'] : $pst_array[0]['pst_open']);
				$_tpl->set('pst_forum',		$_POST['pst_forum'] ? $_POST['pst_forum'] : $pst_array[0]['frm_id']);
				
				$_tpl->set('pst_ok',false);
			}		
		}	
	}
	else
	{
		$_tpl->set('bad_pid',true);
	}
}
elseif($act=="del_pst")
{
	$_tpl->set('module_tpl','modules/forum/actions.tpl');
	$_tpl->set('frm_act','del_pst');
	if($_GET['pst_pid'])
	{
		$pid = (int) $_GET['pst_pid'];
		$_tpl->set('pst_pid',$pid);
		$pst_array = $frm->get_pst($pid);
		$pst_array = $frm->can_view($pst_array, array('frm_droit'), $_SESSION['user']['droits']);
		$_tpl->set('pst_array',$pst_array);
		//Infos sur le post (peut voir, existe)
		//Auteur ou modo ?
		if(!count($pst_array) OR !$can_edit OR  (!$is_modo AND $_SESSION['user']['mid'] != $pst_array[0]['pst_mid']))
		{
			$_tpl->set('bad_pid',true);
		}
		else //sinon
		{
			if($_GET['ok'])
			{
				$frm->del_pst($pid);
				$_tpl->set('pst_ok',true);
			}
			else
			{
				$_tpl->set('pst_ok',false);
			}
		}
	}
}
elseif($act == "list_modo")
{
	$_tpl->set('frm_act','list_modo');
	$mbr_array  = $mbr->get_infos(0, 20, array('gid' => 6));
	$_tpl->set('mbr_sherif',$mbr_array);
	$mbr_array  = $mbr->get_infos(0, 20, array('gid' => 7));
	$_tpl->set('mbr_modo',$mbr_array);
	
}
elseif($act == "search")
{
	$_tpl->set('frm_act','search');
	$frm_array = $frm->get_cat();
	$_tpl->set('frm_array',$frm_array);
			
	$_tpl->set("pst_forum",$_POST['pst_forum']);
	
	if(isset($_POST['pst_search']))
	{	
		$_tpl->set('pst_search', $_POST['pst_search']);
		
		$pst_array = $frm->search_pst($_POST['pst_search'],$_POST['pst_forum']);
		$pst_array = $frm->can_view($pst_array, array('frm_droit'), $_SESSION['user']['droits']);
		$pst_array = $frm->highlight_pst($pst_array,$_POST['pst_search']);
		
		$_tpl->set('pst_array',$pst_array);
	}
	
}
	
}
?>