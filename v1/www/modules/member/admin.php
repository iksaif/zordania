<?
if(_index_!="ok" or $_SESSION['user']['droits']{2}!=1){ exit; }



if(!is_object($mbr))
{
include("lib/member.class.php");
$mbr = new member($_sql, $game);
}

include('lib/parser.class.php');
	
$_tpl->set("module_tpl","modules/member/admin.tpl");

/* Etats
**1 = Validé
**2 = Nouveau en validation
**3 = En Deletage
**4 = En pause
*/

if($_act == "del")
{
	$_tpl->set("mbr_act","del");
	$_tpl->set("mbr_mid",(int) $_GET['mid']);
	if(!$_GET['mid'])
	{
		$_tpl->set("mbr_no_mid",true);
	}
	elseif($_GET['ok'] == "ok")
	{
		if($mbr->del($_GET['mid']))
		{
			$_tpl->set("mbr_ok",true);
		}else{
			$_tpl->set("mbr_error",true);
		}
	}else{
		$_tpl->set("mbr_need_ok",true);
	}
}
elseif($_act == "edit")
{
	$array=$mbr->get_infos($_GET['mid']);
	$array=$array[0];
	$_tpl->set("mbr_act","edit");
	
	$_tpl->set("mbr_mid",(int) $_GET['mid']);
	$_tpl->set("mbr_login",$array['mbr_login']);
	$_tpl->set("mbr_pseudo",$array['mbr_pseudo']);
	$_tpl->set("mbr_mail",$array['mbr_mail']);
	$_tpl->set("mbr_lang",$array['mbr_lang']);
	$_tpl->set("mbr_decal",$array['mbr_decal']);
	$_tpl->set("mbr_date",date("H:i:s"));
	$_tpl->set("mbr_race",$array['mbr_race']);
	$_tpl->set("mbr_gid",$array['mbr_gid']);
	$_tpl->set("mbr_descr",parser::unparse($array['mbr_descr']));
	$_tpl->set("mbr_sign",parser::unparse($array['mbr_sign']));
		
	if(is_array($array))
	{	
		if($_sub == "edit")
		{		
			if($_POST)
			{
				if($_POST['sign']) $_POST['sign'] = parser::parse($_POST['sign']);
				if($_POST['descr']) $_POST['descr'] = parser::parse($_POST['descr']);
				
				if($mbr->edit($_GET['mid'], $_POST))
				{
					$_tpl->set("mbr_edit",true);
					$array=$mbr->get_infos($_GET['mid']);
					$array=$array[0];
				}else{
					$_tpl->set("mbr_edit",false);
				}
			}
			$_tpl->set("mbr_pseudo",$array['mbr_pseudo']);
			$_tpl->set("mbr_login",$array['mbr_login']);
			$_tpl->set("mbr_mail",$array['mbr_mail']);
			$_tpl->set("mbr_lang",$array['mbr_lang']);
			$_tpl->set("mbr_decal",$array['mbr_decal']);
			$_tpl->set("mbr_race",$array['mbr_race']);
			$_tpl->set("mbr_gid",$array['mbr_gid']);
			$_tpl->set("mbr_descr",parser::unparse($array['mbr_descr']));
			$_tpl->set("mbr_sign",parser::unparse($array['mbr_sign']));
		}
		elseif($_sub == "add_rec" AND isset($_POST['rec_type']))
		{
			$_tpl->set("mbr_edit",$mbr->add_rec($_GET['mid'],$_POST['rec_type']));
		}
		elseif($_sub == "del_rec" AND isset($_POST['rec_id']))
		{
			$_tpl->set("mbr_edit",$mbr->del_rec($_POST['rec_id'],$_GET['mid']));
		}
	}else{
		$_tpl->set("mbr_not_exist",true);
	}
	
	$_tpl->set('rec_array',$mbr->get_rec($_GET['mid']));
}
elseif($_act == "liste" OR !$_act)
{
	//liste des membres
	$_tpl->set("mbr_act","liste");
	if($_POST['pseudo'])
	{
		$src['pseudo'] = $_POST['pseudo'];
		$_tpl->set("mbr_pseudo",$_POST['pseudo']);
	}
	
	if($_POST['ip'])
	{
		$src['ip'] = $_POST['ip'];
		$_tpl->set("mbr_ip",$_POST['ip']);
	}
	
	//gestion du order by
	if($_GET['order'])
	{
		$_POST['order'] = $_GET['order'];
	}
	if($_GET['by'])
	{
		$_POST['by'] = $_GET['by'];
	}
	if($_POST['by'])
	{
		$by = $_POST['by'];
		$type_order = array('' => 'ASC', 1 => 'ASC', 2 => 'DESC');
		$order = $type_order[$_POST['order']];
		
		$_tpl->set("mbr_by",$by);
		$_tpl->set("mbr_order",$_POST['order']);
		
		$order_by = array($order, $by);
	}else{
		$order_by = array('DESC', 'points');
	}
	
	$mbr_page=(int) $_GET['mbr_page'];
	$_tpl->set('mbr_page',$mbr_page);
	$mbr_nb = $mbr->get_infos(false, false, $src, false, true);
	$mbr_nb = $mbr_nb[0]['mbr_nb'];
	$limite_page = LIMIT_MBR_PAGE;

	$_tpl->set('limite_page',$limite_page);
	$_tpl->set("mbr_nb",$mbr_nb);
	
	$nombre_page = $mbr_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	if(isset($mbr_page) || $mbr_page != '0' )
	{	 
		$limite_mysql = $limite_page * $mbr_page;
	}else{
		$limite_mysql = '0';
	}
	$mbr_array = $mbr->get_infos($limite_mysql,$limite_page,$src,false,false,array($order,$by));
	$_tpl->set("mbr_array",$mbr_array);	
}
elseif($_act == "liste_online")
{
	//liste online
	$_tpl->set("mbr_act","liste_online");
	$mbr_page=(int) $_GET['mbr_page'];
	$_tpl->set('mbr_page',$mbr_page);
	$mbr_nb = $_ses->nb_online();
	$limite_page = LIMIT_MBR_PAGE;
	
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set("mbr_nb",$mbr_nb);
	
	$nombre_page = $mbr_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	if(isset($mbr_page) || $mbr_page != '0' )
	{	 
		$limite_mysql = $limite_page * $mbr_page;
	}else{
		$limite_mysql = '0';
	}
	$mbr_array = $_ses->get_liste($limite_mysql,$limite_page);
	$_tpl->set("mbr_array",$mbr_array);
}

if($_act == "view" and $_GET['mid'])
{
	//Infos sur un type
	$_tpl->set("mbr_act","view");
	$mbr_array = $mbr->get_infos($_GET['mid']);
	$_tpl->set("mbr_array",$mbr_array[0]);	
	
	if($mbr_array[0]['mbr_alaid'] > 0)
	{
		include('lib/alliances.class.php');
		$al  = new alliances($_sql);
		$al_array = $al->get_infos($mbr_array[0]['mbr_alaid']);
		$_tpl->set("al_array",$al_array[0]);
	}
	
	$_tpl->set('btc_array_fini',$game->get_infos_btc($_GET['mid'], 0, true));
	$_tpl->set('btc_array_encours',$game->get_infos_btc($_GET['mid'], 0, false));
	
	$_tpl->set('res_array_fini',$game->get_infos_res($_GET['mid'],0,true));
	$_tpl->set('res_array_encours',$game->get_infos_res($_GET['mid'],0,false));
	
	$_tpl->set('src_array_fini',$game->get_infos_src($_GET['mid'],0,true));
	$_tpl->set('src_array_encours',$game->get_infos_src($_GET['mid'],0,false));
	
	$_tpl->set('unt_array_fini',$game->get_infos_unt($_GET['mid'],0,true));
	$_tpl->set('unt_array_encours',$game->get_infos_unt($_GET['mid'],0,false));
}

if($_act == "liste_ip")
{
	$_tpl->set("mbr_act","liste_ip");
	$mbr_array = $mbr->get_infos_ip();
	$_tpl->set("mbr_array",$mbr_array);	
}
?>