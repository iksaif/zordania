<?
if(_index_!="ok" or $_SESSION['user']['droits']{1}!=1){ exit; }

include('lib/parser.class.php');
	
$_tpl->set("module_tpl","modules/member/member.tpl");
/* Etats
**1 = Validé
**2 = Nouveau en validation
**3 = En Veille
*/
if(!$_act)
{
	if($_SESSION['user']['loged'] == true)
	{
		$array = $mbr->get_infos($_SESSION['user']['mid']);
		$array = $array[0];
		$_tpl->set("mbr_array",$array);
		$_tpl->set('rec_array',$mbr->get_rec($_SESSION['user']['mid']));
		if(file_exists(MBR_LOGO_DIR.$_SESSION['user']['mid'].'.png'))
		{
			$_tpl->set('mbr_logo',MBR_LOGO_URL.$_SESSION['user']['mid'].'.png');
		}
		$vld_array = $mbr->get_vld($_SESSION['user']['mid']);
		$_tpl->set('vld_array',$vld_array);
		
	}else{
		$_tpl->set("mbr_not_loged",true);
	}
}
elseif($_act == "new")
{
//new
	$_tpl->set("mbr_act","new");
	
	$_tpl->set("mbr_pseudo",$_POST['pseudo']);
	$_tpl->set("mbr_login",$_POST['login']);
	$_tpl->set("mbr_mail",$_POST['mail']);
	$_tpl->set("mbr_lang",$_POST['lang']);
	$_tpl->set("mbr_decal",$_POST['decal']);
	$_tpl->set("mbr_date",date("H:i:s"));
	$_tpl->set("mbr_race",$_POST['race']);
	$_tpl->set("mbr_race_nb",$mbr->get_nb_race());
	$_tpl->set("USER_RACE",USER_RACE);

	include('lib/browser.class.php');
	$browser = browser_detection('full');
	
	$_tpl->set('user_browser',$browser);
	$questions = (isset($_POST['questions']) AND is_array($_POST['questions'])) ? $_POST['questions'] : "";
	
	$max_inscrits = SITE_MAX_INSCRITS;
	$inscrits=$mbr->nb_mbr();

	if($_POST['mail'] && strstr($_POST['mail'], 'dtc'))
		$_POST['mail'] = 0;

	if($max_inscrits <= $inscrits)
	{
		$_tpl->set("mbr_max_inscrit",true);
	}
	elseif($_SESSION['user']['loged'] == true)
	{
		$_tpl->set("mbr_is_loged",true);
	}
	elseif(/*!$_POST['code'] AND */!$_POST['pseudo'] AND !$_POST['login'] AND !$_POST['pass'] AND !$_POST['pass2'] AND !$_div->mailverif($_POST['mail']) AND !$_POST['lang'] AND !$_POST['decal'] AND !$_POST['race'])
	{
		$_tpl->set("mbr_new",true);
	}
	elseif(/*!$_POST['code'] OR */!$_POST['pseudo'] OR  !$_POST['login'] OR !$_POST['pass'] OR !$_POST['pass2'] OR !$_div->mailverif($_POST['mail']) OR !$_POST['lang'] OR !$_POST['decal'] OR !$_POST['race'] OR !strstr(USER_RACE, $_POST['race']) OR !strstr(USER_LANG, $_POST['lang']))
	{			
		$_tpl->set("mbr_notallpost",true);
	}
	/*elseif($_SESSION['code'] != $_POST['code'])
	{
		$text = $_SERVER['HTTP_USER_AGENT']."-".$_SESSION['code']."-".$_POST['code']."\n";
		divers::log_error(SITE_DIR."logs/code.log",$text);
		//$_tpl->set("mbr_bad_code",true);
	}*/
	elseif(!divers::strverif($_POST['pseudo']))
	{
		$_tpl->set('mbr_name_not_correct',true);
	}
	elseif($_POST['pass']!=$_POST['pass2'])
	{			
		$_tpl->set("mbr_pass_inegal",true);	
	}
	elseif($_POST['mail']!=$_POST['mail2'])
	{			
		$_tpl->set("mbr_mail_inegal",true);	
	}
	elseif(!is_array($questions) OR in_array(0,$questions))
	{
		$_tpl->set("mbr_questionaire_faux",true);
	}
	elseif($result = $mbr->mbr_new($_POST['login'],$_POST['pseudo'], $_POST['pass'], $_POST['mail'], $_POST['lang'], 2, 3, $_POST['decal'], $_POST['race'], divers::getip()))
	{
		
		$_tpl->set("vld_key",$result['key']);
		$_tpl->set("vld_mid",$result['mid']);
		$_tpl->set("mbr_pseudo",$_POST['pseudo']);
		$_tpl->set("mbr_login",$_POST['login']);
		$_tpl->set("mbr_pass",$_POST['pass']);
		if(divers::mailto(SITE_WEBMASTER_MAIL,$_POST['mail'],$_tpl->get("modules/member/mails/objet_new.tpl",1),$_tpl->get("modules/member/mails/text_new.tpl",1)))
		{
		$_tpl->set("mbr_ok",true);
		}
		else
		{
		$_tpl->set("mbr_error",true);	
		}
	}
	else
	{
		$_tpl->set("mbr_error",true);	
	}	
}
elseif($_act == "del")
{
	$_tpl->set("mbr_act","del");
	if($_SESSION['user']['loged'] == false)
	{
		$_tpl->set("mbr_is_not_loged",true);
	}elseif($result = $mbr->pre_del($_SESSION['user']['mid']))
	{
		$_tpl->set("vld_key",$result['key']);
		$_tpl->set("vld_mid",$result['mid']);
		
		if(divers::mailto(SITE_WEBMASTER_MAIL,$_SESSION['user']['mail'],$_tpl->get("modules/member/mails/objet_del.tpl",1),$_tpl->get("modules/member/mails/text_del.tpl",1)))
		{
		$_tpl->set("mbr_ok",true);
		}
		else
		{
		$_tpl->set("mbr_error",true);
		}
	}else{
		$_tpl->set("mbr_error",true);
	}
}
elseif($_GET['mid'] AND $_act == "vld" AND $_GET['key'] and !$_GET['pass'] and !$_GET['mail'] and !$_GET['reset'])
{

	$vld_act = $mbr->get_vld($_GET['mid']);
	
	$_tpl->set("mbr_act","vld");
	if($vld_act)
	{
		//nouveau membre: validation
		if($vld_act == 'new')
		{
			$_tpl->set("mbr_act","vld_new");
			if($_SESSION['user']['loged'] == true)
			{
				$_tpl->set("mbr_is_loged",true);
			}
			elseif($mbr->vld($_GET['key'], $_GET['mid']))
			{
				if($mbr->new_mbr($_GET['mid'],$mbr->select_map_rand()))
				{
					$_tpl->set("mbr_vld_ok",true);
				}else{
					$_tpl->set("mbr_vld_ok",false);
				}
			}else{
				$_tpl->set("mbr_vld_ok",false);
			}	
		}elseif($vld_act == 'del') //drop :D
		{
			$_tpl->set("mbr_act","vld_del");
			if($mbr->vld($_GET['key'], $_GET['mid']))
			{
				if($mbr->del($_GET['mid']))
				{
					$_tpl->set("mbr_vld_ok",true);
				}else{
					$_tpl->set("mbr_vld_ok",false);
				}
			}else{
				$_tpl->set("mbr_vld_ok",false);
			}
		}
		elseif($vld_act == 'res')
		{
			$_tpl->set("mbr_act","vld_reset");
			$_tpl->set("USER_RACE",USER_RACE);
			if(strstr(USER_RACE, $_POST['race']) AND $_POST['race'])
			{
				if($mbr->vld($_GET['key'], $_GET['mid']))
				{
					include('conf/0.php');
					$conf0 = new config0();
					$mbr->set_conf($conf0);
					if($mbr->reinit($_GET['mid'],$_POST['race']))
					{
						$_tpl->set("mbr_vld_ok",true);
					}else{
						$_tpl->set("mbr_vld_ok",false);
					}
				}else{
					$_tpl->set("mbr_vld_ok",false);
				}
			}
			else
			{
				$_tpl->set('vld_key',$_GET['key']);
				$_tpl->set('vld_mid',$_SESSION['user']['mid']);
				$_tpl->set("mbr_no_race",true);
			}
		}
	}else{
		$_tpl->set("mbr_not_exist",true);
	}
}
elseif($_GET['mid'] AND $_act == "vld" AND $_GET['key'] and $_GET['pass'] and $_GET['mail'])
{
//edit mdp + password
	$array=$mbr->get_infos($_GET['mid']);
	$array=$array[0];
	$_tpl->set("mbr_act","vld_mail_pass");
	if(is_array($array))
	{
		if($mbr->vld($_GET['key'], $_GET['mid']))
		{
			if($mbr->edit($_GET['mid'], array("pass" => $_GET['pass'],"passmd5" => true, "mail" => $_GET['mail'])))
			{
				$_tpl->set("mbr_vld_ok",true);
			}else{
				$_tpl->set("mbr_vld_ok",false);
			}
		}else{
			$_tpl->set("mbr_vld_ok",false);
		}
	}
}
elseif($_act == "liste")
{
	$_tpl->set("module_tpl","modules/member/liste.tpl");
	$_tpl->set('mbr_act','liste');
	//liste des membres
	
	//Pour avoir la distance
	$map = $mbr->get_infos($_SESSION['user']['mid'], false, false, true, false, false);
	$map = $map[0];
	$_tpl->set("mbr_map_x",$map['map_x']);
	$_tpl->set("mbr_map_y",$map['map_y']);

	//gestion du where
	$src = array('etat' => '1');
	if($_POST['pseudo'])
	{
		$src['pseudo'] = $_POST['pseudo'];
		$_tpl->set("mbr_pseudo",$_POST['pseudo']);
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
	
	$_tpl->set("mbr_act","liste");
	$mbr_page=(int) $_GET['mbr_page'];
	$mbr_nb = $mbr->get_infos(false, false, $src, false, true);
	$mbr_nb = $mbr_nb[0]['mbr_nb'];
	$limite_page = LIMIT_MBR_PAGE;
	$_tpl->set('limite_page',$limite_page);
	$_tpl->set('limite_nb_page',LIMIT_NB_PAGE);
	$current_i = $mbr_page - LIMIT_NB_PAGE/2;
	$current_i = round($current_i < 0 ? 0 : $current_i)*LIMIT_MBR_PAGE;
	$_tpl->set('current_i',$current_i);
	$_tpl->set("mbr_nb",$mbr_nb);
	$nombre_page = ($mbr_nb / $limite_page);
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	
	if(isset($mbr_page) AND $mbr_page > 0)
	{	 
		$limite_mysql = $limite_page * $mbr_page;
	}elseif($_SESSION['user']['loged'] AND !isset($_GET['mbr_page']))
	{
		$src_tmp = $src;
		$src_tmp['pp_points'] = $_SESSION['user']['points'];
		//print_r($src_tmp);
		$position = $mbr->get_infos(false, false, $src_tmp, false, true);
		$position = ($mbr_nb - $position[0]['mbr_nb']);
		$limite_mysql = (floor($position / $limite_page) * $limite_page);
		$mbr_page = $limite_mysql / $limite_page;
	}
	else
	{
		$limite_mysql = '0';
	}

	$mbr_array = $mbr->get_infos($limite_mysql,$limite_page,$src,$map,false,$order_by);
	$mbr_array = $mbr->can_atq_lite($mbr_array, $_SESSION['user']['points'],$_SESSION['user']['mid'],$_SESSION['user']['groupe'], $_SESSION['user']['alaid']);
	//print_r($mbr_array);
	$_tpl->set("mbr_array",$mbr_array);	
	$_tpl->set('mbr_page',$mbr_page);
}
elseif($_act == "liste_online")
{
	//liste online
	$_tpl->set("module_tpl","modules/member/liste.tpl");
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
	$mbr_array = $mbr->can_atq_lite($mbr_array, $_SESSION['user']['points'],$_SESSION['user']['mid'],$_SESSION['user']['groupe'], $_SESSION['user']['alaid']);
	$_tpl->set("mbr_array",$mbr_array);
}
elseif($_act == "edit")
{
	$_tpl->set("mbr_act","edit");
	
	$_tpl->set("mbr_pseudo",$_POST['pseudo']);
	$_tpl->set("mbr_mail",$_POST['mail']);
	$_tpl->set("mbr_lang",$_POST['lang']);
	$_tpl->set("mbr_decal",$_POST['decal']);
	$_tpl->set("mbr_sign",$_POST['sign']);
	$_tpl->set("mbr_descr",$_POST['descr']);
	$_tpl->set("mbr_date",date("H:i:s"));

	if(file_exists(MBR_LOGO_DIR.$_SESSION['user']['mid'].'.png'))
	{
		$_tpl->set('mbr_logo',MBR_LOGO_URL.$_SESSION['user']['mid'].'.png');
	}
	$_tpl->set('logo_type',MBR_LOGO_TYPE);
	$_tpl->set('logo_x_y',MBR_LOGO_MAX_X_Y);
	$_tpl->set('logo_size',MBR_LOGO_SIZE);
	
	if($_SESSION['user']['loged']==false)
	{
		$_tpl->set("mbr_is_not_loged",true);
	}elseif(!$_sub){
		$array=$mbr->get_infos($_SESSION['user']['mid']);
		$array=$array[0];
		$_tpl->set("mbr_pseudo",$array['mbr_pseudo']);
		$_tpl->set("mbr_mail",$array['mbr_mail']);
		$_tpl->set("mbr_lang",$array['mbr_lang']);
		$_tpl->set("mbr_decal",$array['mbr_decal']);
		$_tpl->set("mbr_sign",parser::unparse($array['mbr_sign']));
		$_tpl->set("mbr_descr",parser::unparse($array['mbr_descr']));
		$_tpl->set("mbr_date",date("H:i:s"));
	} elseif($_sub == "pass") {
		$_tpl->set("mbr_sub","pass");
		if(!$_POST['oldpass'] OR !$_POST['pass'] OR !$_POST['pass2'])
		{
			$_tpl->set("mbr_not_all_post",true);	
		}
		elseif(md5($_POST['oldpass']) != $_SESSION['user']['pass'] OR $_POST['pass'] != $_POST['pass2'])
		{
			$_tpl->set("mbr_not_same_pass",true);
		}
		else
		{
			$_tpl->set("mbr_edit",$mbr->edit($_SESSION['user']['mid'], array("pass" => $_POST['pass'])));
		}
	} elseif($_sub == "mail") {
		$_tpl->set("mbr_sub","mail");
		if(!$_POST['mail'] OR !$_POST['pass'])
		{
			$_tpl->set("mbr_not_all_post",true);	
		}
		elseif(md5($_POST['pass']) != $_SESSION['user']['pass'])
		{
			$_tpl->set("mbr_not_same_pass",true);
		}
		else
		{
			$_tpl->set("mbr_edit",$mbr->edit($_SESSION['user']['mid'], array("mail" => $_POST['mail'])));
		}
	}elseif($_sub == "reset"){ 
		$_tpl->set("mbr_sub","mp");
			
		$key=sha1($_div->genstring(20));
		$_tpl->set('vld_mid',$_SESSION['user']['mid']);
		$_tpl->set('vld_key',$key);
			
		if($mbr->new_vld($key, $_SESSION['user']['mid'], 'res'))
		{
			$_div->mailto(
					SITE_WEBMASTER_MAIL,
					$_SESSION['user']['mail'],
					$_tpl->get("modules/member/mails/objet_reset.tpl",1),
					$_tpl->get("modules/member/mails/text_reset.tpl",1));
					
			$_tpl->set("mbr_edit",true);
		}else{
			$_tpl->set("mbr_another_valid",true);
		}
	}elseif($_sub == "oth")
	{
		$_tpl->set("mbr_sub","oth");

		if(isset($_POST['lang']) AND strstr(USER_LANG, $_POST['lang']))
		{ $edit['lang'] = $_POST['lang']; }

		if(isset($_POST['decal']))
		{ $edit['decal'] = $_POST['decal']; }

		if(isset($_POST['sign']))
		{ $edit['sign'] =parser::parse($_POST['sign'], false, true); }
		
		if(isset($_POST['descr']))
		{ $edit['descr'] =parser::parse($_POST['descr']); }
		
		if($mbr->edit($_SESSION['user']['mid'], $edit))
		{
			$_tpl->set("mbr_edit",true);
		}else{
			$_tpl->set("mbr_edit",false);
		}
	}	
	elseif($_sub == 'logo')
	{
		$_tpl->set('mbr_sub','logo');
		if($_FILES['mbr_logo']['name'])
		{
			$_tpl->set('mbr_edit',$mbr->upload_logo($_SESSION['user']['mid'],$_FILES['mbr_logo']));
		}
	}
	elseif($_sub == 'del_vld')
	{
		$_tpl->set('mbr_sub','del_vld');
		$mbr->del_vld($_SESSION['user']['mid']);
		$_tpl->set("mbr_edit",true);
	}
	//edit le compte 
}
elseif($_act == "view" and $_GET['mid'])
{
	//Pour avoir la distance
	$map = $mbr->get_infos($_SESSION['user']['mid'], false, false, true, false, false);
	$map=$map[0];
	$_tpl->set("mbr_map_x",$map['map_x']);
	$_tpl->set("mbr_map_y",$map['map_y']);
	$_tpl->set('rec_array',$mbr->get_rec($_GET['mid']));
	
	//Infos sur un type
	$_tpl->set("mbr_act","view");
	$mbr_array = $mbr->get_infos($_GET['mid'],false,false,$map);
	$mbr_array = $mbr->can_atq_lite($mbr_array, $_SESSION['user']['points'],$_SESSION['user']['mid'],$_SESSION['user']['groupe'], $_SESSION['user']['alaid']);
	$_tpl->set("mbr_array",$mbr_array[0]);
	
	if(file_exists(MBR_LOGO_DIR.$mbr_array[0]['mbr_mid'].'.png'))
	{
			$_tpl->set('mbr_logo',MBR_LOGO_URL.$mbr_array[0]['mbr_mid'].'.png');
	}	
	
	if($mbr_array[0]['mbr_alaid'] > 0)
	{
		include('lib/alliances.class.php');
		$al  = new alliances($_sql);
		$al_array = $al->get_infos($mbr_array[0]['mbr_alaid']);
		$_tpl->set("al_array",$al_array[0]);
	}
}
elseif($_act == "newpass")
{
	
	$_tpl->set("mbr_act","newpass");
	if(!$_POST['mid'])
	{
		$_tpl->set("mbr_form",true);	
	}
	else
	{
		$mbr_array = $mbr->get_infos($_POST['mid'],false,array('mid' => $_POST['mid']));
		if($mbr_array[0] OR $mbr_array[0]['mbr_etat'] != 1 OR $mbr_array[0]['mbr_etat'] != 3)
		{
			$key=sha1($_div->genstring(20));
			if($mbr->new_vld($key, $_POST['mid'], 'edit'))
			{
				$_tpl->set("vld_mail",$mbr_array[0][mbr_mail]);
				$pass = divers::genstring(8);
				$_tpl->set("vld_pass",md5($pass));
				$_tpl->set("vld_pass2",$pass);
				$_tpl->set("vld_key",$key);
				$_tpl->set("vld_mid",$_POST['mid']);
				
				
				$_div->mailto(
						SITE_WEBMASTER_MAIL,
						$mbr_array[0][mbr_mail],
						$_tpl->get("modules/member/mails/objet_edit.tpl",1),
						$_tpl->get("modules/member/mails/text_edit.tpl",1));
						
				$_tpl->set("mbr_edit",true);
			}else{
				$_tpl->set("mbr_another_valid",true);
			}
			
		}else{
			$_tpl->set("mbr_not_exist",true);
		}	
	}
}
?>