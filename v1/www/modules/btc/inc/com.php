<?

if(INDEX_BTC != true){ exit; }

$is_sherif = $_SESSION['user']['droits']{18};

//Recuperer la distance max (fct recherches)
if(!is_object($res)) {
	include('lib/res.class.php');
	$res = new ressources($_sql, $conf, $game);
}

if(!is_object($com)) {
	include('lib/com.class.php');
	$com = new mch($_sql, $res);
}

$src = $game->get_infos_src($_SESSION['user']['mid']);

$max_nb = 0;
$max_ventes = 0;
foreach($conf->btc[$btc_type]['btcopt']['com'] as $src_id => $max_array) {
	if($src[$src_id]) {
		if($max_nb < $max_array[0]) $max_nb = $max_array[0];
		if($max_ventes < $max_array[1]) $max_ventes = $max_array[1];
	}
}

$_tpl->set('max_nb',$max_nb);

$only_gold = true;
$_tpl->set('com_only_gold',true);

$is_sherif = $_SESSION['user']['droits']{DROIT_ADM_COM};	
$_tpl->set('is_sherif',$is_sherif);
	
$_tpl->set('MCH_MAX',MCH_MAX);
$_tpl->set('MCH_TMP',MCH_TMP);
$_tpl->set('COM_TAX',COM_TAX);
$_tpl->set('COM_TAUX_MIN',COM_TAUX_MIN);
$_tpl->set('COM_TAUX_MAX',COM_TAUX_MAX);

if($_sub == "my")
{
	$_tpl->set('btc_act','my');
		
	if(!$_GET['com_cid'])
	{
		$vente_array = $com->get_infos($_SESSION['user']['mid']);
		$_tpl->set('vente_array',$vente_array);
	}elseif($_GET['ok'] != 'ok')
	{
		$_tpl->set('com_cid',(int) $_GET['com_cid']);
	}else{
		if($com->cancel($_SESSION['user']['mid'], $_GET['com_cid']))
		{
			$_tpl->set('com_cancel',true);
		}
		else
		{
			$_tpl->set('com_cancel',false);	
		}
	}
}
elseif($_sub == "ach")
{
	$_tpl->set('btc_act','ach');
	//Liste complete
	
	if(!$_GET['com_cid'])
	{
		$com_liste = $com->list_mch($_SESSION['user']['mid']);
		$_tpl->set('com_liste',$com_liste);
		if($_GET['com_type'])
		{
			$cours_tmp = $com->get_cours($_GET['com_type']);
			foreach($cours_tmp as $key => $cours_value)
				$cours[$cours_value['mch_cours_res']] = $cours_value['mch_cours_cours']; 
			$_tpl->set('com_cours',$cours);
		
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
	}else
	{
		$_tpl->set('btc_sub','achat');
		
		$com_array = $com->get_mch($_GET['com_cid']);
		$com_array = $com_array[0];
		
		if($_GET['com_neg'])
		{
			$rand_neg = rand(1,4);
			if($rand_neg == 1 OR $rand_neg == 2) $com_mod = 1;
			if($rand_neg == 3) $com_mod = 1.05;
			if($rand_neg == 4) $com_mod = 0.95;
			$_tpl->set('com_neg',$com_mod);
		}
		else
		{
			$com_mod = 1;
		}
		
		$result = $com->achat($_SESSION['user']['mid'],$_GET['com_cid'],$max_nb,$com_mod);
		if($result == 1)
		{
			//ok
			$histo->add($com_array['mch_mid'], $_SESSION['user']['mid'], 11, array($com_array['mch_nb'],$com_array['mch_type'],$com_array['mch_nb2'],$com_array['mch_type2']), true);		
			
			$_tpl->set('btc_achat','ok');
		}elseif($result == 2)
		{
			//manque res
			$_tpl->set('btc_achat','nores');
		}elseif($result == 3)
		{
			$_tpl->set('btc_max_nb',$max_nb);
		}else{
			//merde
			$_tpl->set('btc_achat','error');
		}
	}
}
elseif($_sub == "ven")
{
	$_tpl->set('btc_act','ven');
	$nb_ventes = count($com->get_infos($_SESSION['user']['mid']));
	
	$_tpl->set('max_ventes',$max_ventes);
	$_tpl->set('nb_ventes',$nb_ventes);
	
	if($max_ventes > $nb_ventes)
	{

	//si y'a déjà des choses
	if($_POST['com_type'] AND $_POST['com_type2'])
	{
		//Cours
		$cours_tmp = $com->get_cours($_POST['com_type']);
		foreach($cours_tmp as $cours_value)
			$cours[$cours_value['mch_cours_res']] = $cours_value['mch_cours_cours'];
		
		$_tpl->set('com_cours',$cours);
		$cours_min = round($cours[$_POST['com_type']]*COM_TAUX_MIN,2);
		$cours_max = round($cours[$_POST['com_type']]*COM_TAUX_MAX,2);
		$can_build = $res->can_build($_SESSION['user']['mid'],array($_POST['com_type'],$_POST['com_type2']),0);
	}
	
	if($_POST['com_nb'])
		$_POST['com_nb'] = ceil(abs($_POST['com_nb']));

	if($_POST['com_nb2'])
		$_POST['com_nb2'] = ceil(abs($_POST['com_nb2']));
	
	if($_POST['com_nb'] AND $_POST['com_nb2'])
		$com_cours = round($_POST['com_nb2'] / $_POST['com_nb'],2);
		
	if(!$_POST['com_type'] OR !$_POST['com_nb'] OR !$_POST['com_nb2'] OR !$_POST['com_type2'] OR $can_build > 2 OR $com_cours > $cours_max OR $com_cours < $cours_min OR $_POST['com_type2'] != 1)
	{
		if(!$_POST['com_type'] OR !$_POST['com_type2'] OR $can_build >= 3 OR ($_POST['com_type2'] != 1 AND $only_gold == true))
		{
			//choix du type de la ressource
			$_tpl->set('btc_sub','choix_type');
			$list_res =  $res->get_infos($_SESSION['user']['mid']);
			$_tpl->set('com_user_res',$list_res);
			$list_res2 = $res->list_res($_SESSION['user']['mid']);
			$_tpl->set('com_list_res',$list_res2);
		}else{
			//choix des param (prix & nb)
			$prices = $com->get_price($_POST['com_type'], $_POST['com_type2']);
			$com_array = $com->list_mch_res($_SESSION['user']['mid'], $_POST['com_type']);
			$com_infos = $com->make_infos($com_array,(int) $_POST['com_type']);
			$_tpl->set('com_infos',$com_infos);
			$_tpl->set('com_max_nb',$max_nb);
			$_tpl->set('com_other_price',$prices);
			$_tpl->set('btc_sub','choix_param');
			$_tpl->set('com_type',$_POST['com_type']);
			$_tpl->set('com_nb',$_POST['com_nb']);
			$_tpl->set('com_type2',$_POST['com_type2']);
			$_tpl->set('com_nb2',$_POST['com_nb2']);
		}
	}else{
		//mise en vente apres verif
		$_tpl->set('btc_sub','vente');
		if($_POST['com_nb'] > $max_nb OR $_POST['com_nb2'] > $max_nb)
		{
			$_tpl->set('btc_max_nb',$max_nb);
			$_tpl->set('vente_ok',false);
		}elseif($com->vente($_SESSION['user']['mid'], $_POST['com_type'], $_POST['com_nb'] ,$_POST['com_type2'], $_POST['com_nb2']))
		{
			$_tpl->set('vente_ok',true);
		}else{
			$_tpl->set('vente_ok',false);
		}
		
	}
	}
}
elseif($_sub == "cours")
{
	$_tpl->set('btc_act','cours');
	$_tpl->set('mch_cours',$com->get_cours());
	if(isset($_POST['com_nb']))
	{
		$com_nb = (int) $_POST['com_nb'];
	}
	else
	{
		$com_nb = 1;
	}
	$_tpl->set('com_nb',$com_nb);
}
elseif($_sub == "cours_sem")
{
	$_tpl->set('btc_act','cours_sem');
	if(!$_GET['com_type'])
	{
		$tmp = $com->get_cours_sem();
		foreach($tmp as $result)
			$mch_cours[$result['mch_sem_res']][] = $result;
			
		$_tpl->set('mch_cours',$mch_cours);
		
	}
	else
	{	
		$tmp = $com->get_cours_sem($_GET['com_type']);
		foreach($tmp as $result)
			$mch_cours[$_GET['com_type']][] = $result;
			
		$_tpl->set('mch_cours',$mch_cours);
	}
}

?>