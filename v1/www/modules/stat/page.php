<?
//Verif
if(_index_!="ok"){ exit; }

include('lib/stat.class.php');
$stq = new stats($_sql);

$_tpl->set('module_tpl', 'modules/stat/stat.tpl');
$possible_act = array('mbr' => 3,
			'res' => 2,
			'unt' => 2,
			'btc' => 2,
			'src' => 2
			);
			
$annee = isset($_GET['annee']) ? (int) $_GET['annee'] : date("Y");
$mois = isset($_GET['mois']) ? (int) $_GET['mois'] : date("m");
$jour = isset($_GET['jour']) ? (int) $_GET['jour'] : date("d");
$act  = (isset($_GET['act']) AND isset($possible_act[$_GET['act']])) ? $_GET['act'] : 'mbr';

if($mois > 12){ $mois = 1; $annee++;}
if($mois < 1){ $mois = 12; $annee--;}
$nb_jours = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
if($jour > $nb_jours){ $jour = 1;$mois ++; }
if($jour < 1){ $mois--;  }
if($mois > 12){ $mois = 1; $annee++;}
if($mois < 1){ $mois = 12; $annee--;}
if($jour < 1){ $jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);}

if(strlen ($jour) < 2){ $jour = "0".$jour; }
if(strlen ($mois) < 2){ $mois = "0".$mois; }


$_tpl->set('stq_annee',$annee);
$_tpl->set('stq_mois',$mois);
$_tpl->set('stq_jour',$jour);

$possible_act = $possible_act[$act];
$_tpl->set('stq_possible',$possible_act);
$_tpl->set('stq_act',$act);
if($possible_act == 3)
{
	if(@file_exists(SITE_DIR."img/stats/".$act."_".$jour."-".$mois."-".$annee.".png"))
	{
		$_tpl->set('stq_image_jour',true);
	} 	
}else{
	$_tpl->set('stq_image_jour','no');
}

if(@file_exists(SITE_DIR."img/stats/".$act."_".$mois."-".$annee.".png"))
{
	$_tpl->set('stq_image_mois',true);
} 
if(@file_exists(SITE_DIR."img/stats/".$act."_".$annee.".png"))
{
	$_tpl->set('stq_image_annee',true);
} 	

$annee2 = $annee;
$mois2 = $mois;
$jour2 = $jour -1;

if($mois2 > 12){ $mois2 = 1; $annee2++;}
if($mois2 < 1){ $mois2 = 12; $annee2--;}
$nb_jours2 = cal_days_in_month(CAL_GREGORIAN, $mois2, $annee2);
if($jour2 > $nb_jours2){ $jour2 = 1;$mois2 ++; }
if($jour2 < 1){ $mois2--;  }
if($mois2 > 12){ $mois2 = 1; $annee2++;}
if($mois2 < 1){ $mois2 = 12; $annee2--;}
if($jour2 < 1){ $jour2 = cal_days_in_month(CAL_GREGORIAN, $mois2, $annee2);}

if(strlen ($jour2) < 2){ $jour2 = "0".$jour2; }
if(strlen ($mois2) < 2){ $mois2 = "0".$mois2; }

$_tpl->set('stq_infos',$stq->get_infos("$annee-$mois-$jour","$annee2-$mois2-$jour2"));

?>