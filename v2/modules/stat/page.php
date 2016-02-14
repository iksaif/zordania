<?php
//Verif
if(!defined("_INDEX_")){ exit; }

require_once('lib/stat.lib.php');

$_tpl->set('module_tpl', 'modules/stat/stat.tpl');

			
$annee = request("annee", "int", "get",date("Y"));
$mois = request("mois", "int", "get",date("m"));
$jour = request("jour", "int", "get",date("d"));


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

$_tpl->set('stq_infos', get_stats("$annee-$mois-$jour","$annee2-$mois2-$jour2"));

?>