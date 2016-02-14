<?
if(_index_!="ok" or $_SESSION['user']['droits']{DROIT_PLAY}!=1){ exit; }
if($_SESSION['user']['loged']!=true)
{ 
$_tpl->set("need_to_be_loged",true); 
}
else
{

include('lib/msg.class.php');
include('lib/alliances.class.php');
include('lib/parser.class.php');

$msg = new msg($_sql);
$al  = new alliances($_sql);


if(isset($_GET['al_aid'])){ $_GET['al_aid'] = abs($_GET['al_aid']); }

$order = array('DESC','points');

$_tpl->set('module_tpl','modules/alliances/alliances.tpl');
$_tpl->set('ALL_MIN_ADM_PTS',ALL_MIN_ADM_PTS);
$_tpl->set('ALL_MIN_PTS',ALL_MIN_PTS);
$_tpl->set('ALL_MIN_DEP',ALL_MIN_DEP);
$_tpl->set('ALL_CREATE_PRICE',ALL_CREATE_PRICE);
$_tpl->set('GAME_RES_PRINC',GAME_RES_PRINC);

//Liste des alliances
if(!$_act)
{
	$_tpl->set('module_tpl','modules/alliances/liste.tpl');
	$_tpl->set('al_act','liste');
	
	$al_page=(int) $_GET['al_page'];
	$_tpl->set('al_page',$al_page);
	$al_nb = $al->nb();
	$limite_page = LIMIT_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set('limite_nb_page',LIMIT_NB_PAGE);
	$_tpl->set("al_nb",$al_nb);
	
	$nombre_page = $al_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;

	$current_i = $frm_page - (LIMIT_NB_PAGE / 2);
	$current_i = round($current_i < 0 ? 0 : $current_i)*LIMIT_PAGE;
	$_tpl->set('current_i',$current_i);
	
	if(isset($al_page) AND $al_page > 0 )
	{	 
		$limite_mysql = $limite_page * $al_page;
	}else{
		$limite_mysql = 0;
	}
	$al_array = $al->get_infos($limite_mysql,$limite_page);

	$_tpl->set('al_array',$al_array);
	$_tpl->set('al_max_mbr_nb',ALL_MAX);
}
elseif($_act=='search')
{
	$_tpl->set('module_tpl','modules/alliances/liste.tpl');
	$_tpl->set('al_act','search');
	
	$al_array = $al->search($_POST);

	$_tpl->set('al_array',$al_array);
	$_tpl->set('al_max_mbr_nb',ALL_MAX);	
}
//Infos sur une alliance
elseif($_act == 'view')
{
	$_tpl->set('al_act','view');
	
	$al_array = $al->get_infos($_GET['al_aid']);
	$_tpl->set('al_array',$al_array[0]);
	$_tpl->set('al_max_mbr_nb',ALL_MAX);
	
	if(is_array($al_array[0]))
	{
		if(file_exists(ALL_LOGO_DIR.$_GET['al_aid'].'.png'))
		{
			$_tpl->set('al_logo',ALL_LOGO_URL.$_GET['al_aid'].'.png');
		}
	}
	
	$map = $mbr->get_infos($_SESSION['user']['mid'], false, false, true, false, false);
	$map = $map[0];
	
	$al_mbr = $mbr->get_infos(0, ALL_MAX, array('alaid' => $_GET['al_aid']), $map, false, $order);
	$al_mbr = $mbr->can_atq_lite($al_mbr, $_SESSION['user']['points'],$_SESSION['user']['mid'],$_SESSION['user']['groupe'], $_SESSION['user']['alaid']);
	
	$_tpl->set('al_mbr',$al_mbr);
}
//Mon alliance (Infos (pts, etc ..) + Liste joueurs + Shootbox)
elseif($_act == 'my')
{
	$_tpl->set('al_act','my');
	
	if($_SESSION['user']['alaid'] == 0)
	{
		$_tpl->set('al_no_al',true);
	}
	else if($_SESSION['user']['alaid'] > 0)
	{
		
		$al_array = $al->get_infos($_SESSION['user']['alaid']);
		$_tpl->set('al_array',$al_array[0]);
		
		//Sub = post => post un message sur la shootbox
		if($_sub == 'post' AND $_POST['al_shoot_msg'])
		{
			$_tpl->set('al_msg_post',$al->add_msg($_SESSION['user']['alaid'],parser::parse($_POST['al_shoot_msg']),$_SESSION['user']['mid']));
		}
		else if($_sub == "del" AND $_GET['msgid'])
		{
			if($al_array[0]['al_mid'] == $_SESSION['user']['mid'])
				$chef = true;
			else
				$chef = false;
			$_tpl->set('al_msg_del',$al->del_msg($_SESSION['user']['alaid'],$_GET['msgid'],$_SESSION['user']['mid'],$chef));
		}
	
		if($al_array[0]['al_mid'] == $_SESSION['user']['mid'])
		{
			$_tpl->set('al_admin',true);
		}
		
		$al_page=(int) $_GET['al_page'];
		$al_nb = $al->count_msg($_SESSION['user']['alaid']);
		$limite_page = LIMIT_PAGE;
		$_tpl->set('limite_page',$limite_page);
		$_tpl->set("al_nb",$al_nb);

		$nombre_page = ($al_nb / $limite_page);
		$nombre_total = ceil($nombre_page);
		$nombre = $nombre_total - 1;
	
		
		$_tpl->set('limite_nb_page',LIMIT_NB_PAGE);
		$current_i = $al_page - LIMIT_NB_PAGE/2;
		$current_i = 0+round($current_i < 0 ? 0 : $current_i)*LIMIT_PAGE;
		
		$_tpl->set('current_i',$current_i);
	
		if($_GET['pst_page'] == "last")
		{
			$al_page = $nombre;
		}
		$_tpl->set('al_page',$al_page);
	
		if(isset($al_page) AND $al_page > 0)
		{	 
			$limite_mysql = $limite_page * $al_page;
		}
		else
		{
			$limite_mysql = 0;
		}
	
		$al_shoot_array = $al->get_msg($_SESSION['user']['alaid'], $limite_page, $limite_mysql);
		$_tpl->set('al_shoot_array',$al_shoot_array);
	
	
		$map = $mbr->get_infos($_SESSION['user']['mid'], false, false, true, false, false);
		$map = $map[0];
	
		$al_mbr = $mbr->get_infos(0, ALL_MAX, array('alaid' => $_SESSION['user']['alaid']), $map, false, $order);
		$_tpl->set('al_mbr',$al_mbr);
		
		if(file_exists(ALL_LOGO_DIR.$_SESSION['user']['alaid'].'.png'))
		{
			$_tpl->set('al_logo',ALL_LOGO_URL.$_SESSION['user']['alaid'].'.png');
		}

	}
	elseif($_SESSION['user']['alaid'] < 0)
	{
		$_tpl->set('al_waiting',-$_SESSION['user']['alaid']);
		
		$al_array = $al->get_infos(-$_SESSION['user']['alaid']);
		$_tpl->set('al_array',$al_array[0]);
	}
}
elseif($_act == 'descr_rules')
{
	$_tpl->set('al_act','descr_rules');
	
	if($_SESSION['user']['alaid'] == 0)
	{
		$_tpl->set('al_no_al',true);
	}
	if($_SESSION['user']['alaid'] > 0)
	{	
		$al_array = $al->get_infos($_SESSION['user']['alaid']);
		$_tpl->set('al_array',$al_array[0]);
	}
}
//Admin alliances (Param + demandes)
elseif($_act == 'admin' AND $_SESSION['user']['alaid'] > 0)
{
	$_tpl->set('al_act','admin');
	
	$al_array = $al->get_infos($_SESSION['user']['alaid']);
	$al_array[0]['al_descr'] = parser::unparse($al_array[0]['al_descr']);
	$al_array[0]['al_rules'] = parser::unparse($al_array[0]['al_rules']);
	$_tpl->set('al_array',$al_array[0]);
	
	if($al_array[0]['al_mid'] != $_SESSION['user']['mid'])
	{
		$_tpl->set('al_not_admin',true);
	}	
	//upload ->logo
	elseif(!$_sub)
	{	
		$al_mbr = $mbr->get_infos(0, ALL_MAX, array('alaid' => -$_SESSION['user']['alaid']), false, false, $order);
		$_tpl->set('al_mbr',$al_mbr);
		
		if(file_exists(ALL_LOGO_DIR.$_SESSION['user']['alaid'].'.png'))
		{
			$_tpl->set('al_logo',ALL_LOGO_URL.$_SESSION['user']['alaid'].'.png');
		}
		$_tpl->set('logo_type',ALL_LOGO_TYPE);
		$_tpl->set('logo_x_y',ALL_LOGO_MAX_X_Y);
		$_tpl->set('logo_size',ALL_LOGO_SIZE);
	}
	elseif($_sub == 'logo')
	{
		$_tpl->set('al_sub','logo');
		if($_FILES['al_logo']['name'])
		{
			$_tpl->set('al_logo',$al->upload_logo($_SESSION['user']['alaid'],$_FILES['al_logo']));
		}
	}
	//Param -> (ouvert)
	elseif($_sub == 'param')
	{
		$_tpl->set('al_sub','param');
		/*if($_POST['al_name'])
		{*/
			$_tpl->set('al_param',$al->edit($_SESSION['user']['alaid'],array('open' => (0+$_POST['al_open']),'descr' => parser::parse($_POST['al_descr']), 'rules' => parser::parse($_POST['al_rules']))));
		/*}
		else
		{
			$_tpl->set('al_param',false);
		}*/
	}
	//Accepter
	elseif($_sub == 'accept')
	{
		$_tpl->set('al_sub','accept');
		if($al_array[0]['al_nb_mbr'] >= ALL_MAX)
		{
			$_tpl->set('al_full',true);
		}
		elseif($_GET['mid'])
		{
			//Verifier que le membre demande bien.
			$mbr_infos = $mbr->get_infos($_GET['mid']);
			if($mbr_infos[0]['mbr_alaid'] == -$_SESSION['user']['alaid'])
			{
				$mbr->edit($_GET['mid'],array('alaid' => $_SESSION['user']['alaid']));
				$al->edit($_SESSION['user']['alaid'], array('nb_mbr' => 1));
				
				$text = $_tpl->get('modules/alliances/msg/accept.tpl',1);
				$titre = $_tpl->get('modules/alliances/msg/titre.tpl',1);
				$msg->new_msg($_SESSION['user']['mid'], $_GET['mid'], $titre, $text);
				$_tpl->set('al_ok',true);
				$_tpl->set('al_pseudo',$mbr_infos[0]['mbr_pseudo']);
			}
			else
			{
				$_tpl->set('al_bad_mid',true);
			}
		}
		else
		{
			$_tpl->set('al_no_mid',true);
		}	
	}
	//Refuser
	elseif($_sub == 'refuse')
	{
		$_tpl->set('al_sub','refuse');
		if($_GET['mid'])
		{
			//Verifier que le membre demande bien.
			$mbr_infos = $mbr->get_infos($_GET['mid']);
			if($mbr_infos[0]['mbr_alaid'] == -$_SESSION['user']['alaid'])
			{
				$mbr->edit($_GET['mid'],array('alaid' => 0));
				
				$text = $_tpl->get('modules/alliances/msg/refuse.tpl',1);
				$titre = $_tpl->get('modules/alliances/msg/titre.tpl',1);
				$msg->new_msg($_SESSION['user']['mid'], $_GET['mid'], $titre, $text);
				$_tpl->set('al_ok',true);
				$_tpl->set('al_pseudo',$mbr_infos[0]['mbr_pseudo']);
			}
			else
			{
				$_tpl->set('al_bad_mid',true);
			}
		}
		else
		{
			$_tpl->set('al_no_mid',true);
		}
	}
	//supprimer
	elseif($_sub == 'kick')
	{
		$_tpl->set('al_sub','kick');
		if($_GET['mid'] AND $_GET['mid'] != $_SESSION['user']['mid'])
		{
			//Verifier que y est bien
			$mbr_infos = $mbr->get_infos($_GET['mid']);
			if($mbr_infos[0]['mbr_alaid'] == $_SESSION['user']['alaid'])
			{
				$mbr->edit($_GET['mid'],array('alaid' => 0));
				$al->edit($_SESSION['user']['alaid'], array('nb_mbr' => -1));
				
				$_tpl->set('al_ok',true);
				$_tpl->set('al_pseudo',$mbr_infos[0]['mbr_pseudo']);
			}
			else
			{
				$_tpl->set('al_bad_mid',true);
			}
		}
		else
		{
			$_tpl->set('al_no_mid',true);
		}
	}
	elseif($_sub == 'chef')
	{
		$_tpl->set('al_sub','chef');
		if($_GET['mid'] AND $_GET['mid'] != $_SESSION['user']['mid'])
		{
			//Verifier que y est bien
			$mbr_infos = $mbr->get_infos($_GET['mid']);
			if($mbr_infos[0]['mbr_alaid'] == $_SESSION['user']['alaid'])
			{
				if(isset($_POST['ok'])) {
				  $al->edit($_SESSION['user']['alaid'], array('mid' => $_GET['mid']));
				  $_tpl->set('al_ok',true);
				}
				$_tpl->set('mbr_mid', $_GET['mid']);
				$_tpl->set('al_pseudo',$mbr_infos[0]['mbr_pseudo']);
			}
			else
			{
				$_tpl->set('al_bad_mid',true);
			}
		}
		else
		{
			$_tpl->set('al_no_mid',true);
		}
	}
	elseif($_sub == 'del')
	{
		$_tpl->set('al_sub','del');
		if(!$_POST['ok'])
		{
			$_tpl->set('al_del','need_ok');
		}
		else
		{
			if($al->del_al($_SESSION['user']['alaid']))
			{
				$_tpl->set('al_del',true);
			}
			else
			{
				$_tpl->set('al_del',false);
			}
		}
	}
}
elseif($_act == 'res' AND $_SESSION['user']['alaid'] > 0)
{

//Ressources
	$_tpl->set('al_act','res');

	include("lib/res.class.php");
	$res = new ressources($_sql,$conf,$game);
	
	$_tpl->set('ALL_TAX',ALL_TAX);
	//Ajouter
	if(isset($_POST['res_type']) AND (!is_array($conf->res[$_POST['res_type']]) OR $conf->res[$_POST['res_type']]['nobat'])) unset($_sub); 
	
	$nb = abs((int) $_POST['res_nb']);
	
	if($_sub == 'add')
	{	
		if($nb >= ALL_MIN_DEP)
			$_tpl->set('al_ok',$al->add_res($_SESSION['user']['alaid'], $_SESSION['user']['mid'], $_POST['res_type'], $nb));
		else
			$_tpl->set('al_ok',false);
	}
	//Retirer
	elseif($_sub == 'ret')
	{
		$_tpl->set('al_ok',$al->add_res($_SESSION['user']['alaid'], $_SESSION['user']['mid'], $_POST['res_type'], -$nb));
	}

	//Affiche les ressources
	$list_res =  $res->get_infos($_SESSION['user']['mid']);
	$_tpl->set('user_res',$list_res);
	$list_res2 = $res->list_res($_SESSION['user']['mid']);
	$_tpl->set('list_res',$list_res2);
	
	$res_array = $al->get_infos_res($_SESSION['user']['alaid']);
	$_tpl->set('res_array',$res_array);
	
	$res_log = $al->get_log_res($_SESSION['user']['alaid'],LIMIT_PAGE);
	$_tpl->set('log_array',$res_log);

	$_tpl->set('al_sub',$_sub);
}
elseif($_act == 'new' AND $_SESSION['user']['alaid'] == 0)
{
	//Verifier le nombre de points
	$_tpl->set('al_act','new');
	
	
	$res_array = $game->get_infos_res($_SESSION['user']['mid'],GAME_RES_PRINC);

	if($_SESSION['user']['points'] < ALL_MIN_ADM_PTS)
	{
		$_tpl->set('al_not_enought_pts',ALL_MIN_ADM_PTS);
	}
	elseif($res_array[1]['res_nb'] < ALL_CREATE_PRICE)
	{
		$_tpl->set('al_not_enought_gold',true);	
	}
	elseif(!divers::strverif($_POST['al_name']))
	{
		$_tpl->set('al_name_not_correct',true);
	}
	elseif($_POST['al_name'])
	{
		$al_id = $al->add_al($_SESSION['user']['mid'],$_POST['al_name']);
		$game->add_res($_SESSION['user']['mid'],GAME_RES_PRINC,-ALL_CREATE_PRICE,0);
		$mbr->edit($_SESSION['user']['mid'],array('alaid' => $al_id));
		$_tpl->set('al_new',true);
	}
	else
	{
		$_tpl->set('al_new',false);
	}
	//Si post nom -> on crée
}
elseif($_act == 'join')
{
	$_tpl->set('al_act','join');
	//Si alaid, et ouverte, et pas trop
	if($_SESSION['user']['alaid'] != 0)
	{
		$_tpl->set('al_join',false);
	}
	elseif($_SESSION['user']['points'] < ALL_MIN_PTS)
	{
		$_tpl->set('al_not_enought_pts',ALL_MIN_PTS);
	}
	else
	{
		$al_array = $al->get_infos($_GET['al_aid']);
		$_tpl->set('al_array',$al_array[0]);
		if(!count($al_array[0]))
		{
			$_tpl->set('al_bad_aid',true);
		}
		elseif($al_array[0]['al_nb_mbr'] >= ALL_MAX OR !$al_array[0]['al_open'])
		{
			$_tpl->set('al_full',true);
		}
		else
		{
			//Verifier que le membre demande bien.
			$mbr->edit($_SESSION['user']['mid'],array('alaid' => -$_GET['al_aid']));
			
			$text = $_tpl->get('modules/alliances/msg/demande.tpl',1);
			$titre = $_tpl->get('modules/alliances/msg/titre.tpl',1);
			$msg->new_msg($_SESSION['user']['mid'], $al_array[0]['al_mid'], $titre, $text);
			$_tpl->set('al_join',true);
		}
	}
}
elseif($_act == 'part')
{
	$_tpl->set('al_act','part'); 
	$al_array = $al->get_infos($_SESSION['user']['alaid']);
	
	if($_SESSION['user']['mid'] == $al_array[0]['al_mid'])
	{
		$_tpl->set('al_part', false);
	}
	elseif($_SESSION['user']['alaid'])
	{
		$mbr->edit($_SESSION['user']['mid'],array('alaid' => 0));
		$al->edit($_SESSION['user']['alaid'], array('nb_mbr' => -1));
		$_tpl->set('al_part', true);
	}
	else
	{
		$_tpl->set('al_no_al',true);
	}
}
elseif($_act == 'cancel')
{
	$_tpl->set('al_act','cancel'); 
	
	if($_SESSION['user']['alaid'] < 0)
	{
		$mbr->edit($_SESSION['user']['mid'],array('alaid' => 0));
		$_tpl->set('al_cancel', true);
	}
	else
	{
		$_tpl->set('al_cancel',false);
	}
}

}
?>