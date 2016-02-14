<?
//Verif
if(_index_!="ok" or ($_SESSION['user']['droits']{7}!=1 AND $_SESSION['user']['droits']{18}!=1)){ exit; }

include('lib/com.class.php');
$com = new mch($_sql, $res);

$_tpl->set("admin_tpl","modules/com/admin.tpl");
$_tpl->set("admin_name","Commerce");

$_tpl->set('COM_TAUX_MIN',COM_TAUX_MIN);
$_tpl->set('COM_TAUX_MAX',COM_TAUX_MAX);

if($_GET['act'] == "ach" OR !$_GET['act'])
{
	$_tpl->set('btc_act','ach');
	//Liste complete
	
	$com_liste = $com->list_mch($_SESSION['user']['mid']);
	$_tpl->set('com_liste',$com_liste);
	if($_GET['com_type'])
	{
		$_tpl->set('com_type',(int) $_GET['com_type']);
		$com_array = $com->list_mch_res($_SESSION['user']['mid'], $_GET['com_type']);
		$_tpl->set('com_array',$com_array);
		
		$com_infos = $com->make_infos($com_array,(int) $_GET['com_type']);
		$_tpl->set('com_infos',$com_infos);
	}	

	if($_GET['com_type2'])
	{
		$_tpl->set('com_type2',(int) $_GET['com_type2']);
	}
}
elseif($_GET['act'] == "list_sherif")
{
	$_tpl->set('btc_act','list_sherif');
	$mbr_array  = $mbr->get_infos(0, 20, array('gid' => 6));
	$_tpl->set('mbr_array',$mbr_array);
}
elseif($_GET['act'] == "sherif")
{
	$_tpl->set('btc_act','sherif');

	if($_GET['sub'] == "cancel" OR $_GET['sub'] == "del")
	{
		$_tpl->set('com_sub','cancel_del');
		$remb =  ($_GET['sub2'] == "cancel") ? 1 : 0;
		$_tpl->set('remb',$remb);
		
		$com_array = $com->get_mch($_GET['com_cid']);
		$com_array = $com_array[0];
		$_tpl->set('com_array',$com_array);
			
		$mid = $com->sher_cancel($_GET['com_cid'], $remb);

		if($mid)
		{
			$histo->add($mid, $_SESSION['user']['mid'], (13-$remb), array($com_array['mch_nb'],$com_array['mch_type'],$com_array['mch_nb2'],$com_array['mch_type2']), true);
			
			$mbr_array = $mbr->get_infos($mid);
			$_tpl->set('mbr_array',$mbr_array[0]);
		
			$_tpl->set('com_cid',$_GET['com_cid']);
			$_tpl->set('com_ok',$mid);
		
			include('lib/msg.class.php');
			include('lib/parser.class.php');
			
			$msg = new msg($_sql);
			
			$titre = $_tpl->get('modules/btc/msg/mch_sherif_titre.tpl',1);
			$texte = $_tpl->get('modules/btc/msg/mch_sherif_texte.tpl',1);
			$msg->new_msg($_SESSION['user']['mid'], $mid, $titre, $texte,false);
		}
	}
	elseif($_GET['sub'] == 'tmp')
	{
		$_tpl->set('com_sub','tmp');
		$mch_array = $com->list_mch_res(0,0,false);
		$_tpl->set("com_liste",$mch_array);
	}
	
}
elseif($_GET['act'] == "cours")
{
	$_tpl->set('btc_act','cours');
	
	$com_nb = isset($_POST['com_nb']) ? (int) $_POST['com_nb'] : 1;
	
	if(isset($_POST['com_mod']) AND is_array($_POST['com_mod']))
	{
		foreach($_POST['com_mod'] as $res_id => $res_cours)
			$com->update_cours($res_id,$res_cours/$com_nb);
	}
	
	$_tpl->set('mch_cours',$com->get_cours());
	$_tpl->set('com_nb',$com_nb);
}
elseif($_GET['act'] == "cours_sem")
{
	$_tpl->set('btc_act','cours_sem');
	
	if(isset($_POST['com_mod']) AND is_array($_POST['com_mod']))
	{
		foreach($_POST['com_mod'] as $res_jour => $res_value)
			foreach($res_value as $res_id => $res_cours)
				$com->update_cours_sem($res_id,$res_cours,$res_jour); 
	}
	
	$tmp = $com->get_cours_sem();
	foreach($tmp as $result)
		$mch_cours[$result['mch_sem_res']][] = $result;
		
	$_tpl->set('mch_cours',$mch_cours);
}
?>