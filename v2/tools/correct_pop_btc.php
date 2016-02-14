<?php
/* 
  correction de la place ET de la légion batiment
*/

require_once("../conf/conf.inc.php");

require_once(SITE_DIR . "lib/mysql.class.php");
require_once(SITE_DIR . 'lib/divers.lib.php');
require_once(SITE_DIR . 'lib/btc.lib.php');
require_once(SITE_DIR . 'lib/unt.lib.php');
require_once(SITE_DIR . 'lib/trn.lib.php');
require_once(SITE_DIR . 'lib/member.lib.php');

$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

for($race = 1; $race <= 5; $race++)
{// charger les 5 fichiers de config de race
	include "../conf/$race.php";
	$confname = "config$race";
	$_conf[$race] = new $confname;
	/* definition des constantes terrains toutes races */
	$_trn[$race] = get_const($race);
}

if (isset($_GET['clean'])) { // supprimer toutes les légions bat avant de les refaire propre...
	$sql = " DELETE FROM zrd_unt WHERE unt_lid IN (
		SELECT leg_id FROM zrd_leg WHERE leg_etat =2)";
	$_sql->query($sql);
}

// tous les membres, sauf non initialisé (2)
$sql = 'SELECT mbr_mid, mbr_race, mbr_pseudo, mbr_place
FROM zrd_mbr
WHERE mbr_etat IN (1, 3) AND mbr_race <> 0 
ORDER BY mbr_mid ';

$mid_array = $_sql->make_array($sql);
$sql=array();
/* PHP en mode web 
$exec = request('exec', 'uint', 'get');
/* PHP en mode CLI */
$exec = (isset($argv[1]) && $argv[1] == 'exec');
$debug = (isset($argv[1]) && $argv[1] == 'debug');

foreach($mid_array as $_user)
{
	$mid  = $_user['mbr_mid'];
	$race = $_user['mbr_race'];
	if(!$exec and $debug) echo $_user['mbr_pseudo']." (mid=$mid)(race=$race)\n";
	$place_totale = 0;
	$leg_bat = array();
	$trn_debut = get_conf_gen($race, 'race_cfg', 'debut', 'trn');

	$btc_array = get_btc_gen(array('mid' => $mid, 'count' => true));
	foreach ($btc_array as $btc) {

		/* compter la place totale */
		$prod_pop = get_conf_gen($race, 'btc', $btc['btc_type'], 'prod_pop');
		if ($prod_pop)
			$place_totale += $prod_pop * $btc['btc_nb'];

		/* compter la legion batiments */
		$prix_unt = get_conf_gen($race, 'btc', $btc['btc_type'], 'prix_unt');
		if ($prix_unt)
			array_ksum( $leg_bat, $prix_unt, $btc['btc_nb']);
		
		/* verifier qu'on depasse pas le nombre max initial de terrains
		$prix_trn = get_conf_gen($race, 'btc', $btc['btc_type'], 'prix_trn');
		if ($prix_trn)
			array_ksum( $trn_debut, $prix_trn, $btc['btc_nb']);
 */
	} /* fin boucle batiments */

	if ($place_totale != $_user['mbr_place']) {
		echo "{$_user['mbr_pseudo']} place : {$_user['mbr_place']} corrigee $place_totale\n";
		if ($exec) edit_mbr($mid, array('place' => $place_totale));
	}

	/* vérifier la légion batiment */
	$legions = new legions(array('mid' => $mid, 'etat' => LEG_ETAT_BTC), true);
	$edit_unt = array();
	if (!$legions->btc_lid) {
		echo "Legion batiment introuvable, creation...\n";
	} else {
		$arr_unt = $legions->legs[$legions->btc_lid]->get_unt();

		foreach ($arr_unt as $unt => $nb)
			if (!isset($leg_bat[$unt])) //unites n'ayant pas leur place dans la legion : $nb unites $unt
				$edit_unt[$unt] = - $nb + isset($edit_unt[$unt]) ? $edit_unt[$unt] : 0;
			else if ($leg_bat[$unt] != $nb) // $nb unites $unt au lieu de {$leg_bat[$unt]}
				$edit_unt[$unt] = $leg_bat[$unt] - $nb;
			else
				$edit_unt[$unt] = 0;
	}
	foreach ($leg_bat as $unt => $nb)
		if (!isset($edit_unt[$unt])) // manque $nb unites $unt
			$edit_unt[$unt] = $nb;
		else if ($edit_unt[$unt] == 0)
			unset($edit_unt[$unt]);

	if (!empty($edit_unt)) print_r($edit_unt);
	if (!empty($edit_unt)){
		echo "edit de la légion btc aussi...\n";
		if($exec)
			edit_unt_gen($mid, LEG_ETAT_BTC, $edit_unt);
	}
	
	/* vérifier les terrains libres ou occupés
	$trn_arr = get_trn($mid, $_trn[$race]);
	if ($trn_arr) {
		$trn_arr = $trn_arr[0];
		$nb_trn = get_conf_gen($race, "race_cfg", "trn_nb");
		foreach ($_trn[$race] as $i) { // chaque type de terrain de la race
			if ($trn_debut[$i]) {
				if (isset($trn_arr['trn_type'.$i])) // enlever le nb de terrains restant
					$trn_debut[$i] -= $trn_arr['trn_type'.$i];
			} else if (isset($trn_arr['trn_type'.$i]))
				$trn_debut[$i] = $trn_arr['trn_type'.$i];
		}
	}
	$trn_array = array();
	foreach ($trn_debut as $trn => $nb) {
		if ((int) $nb < 0)
			echo "$nb TERRAINS $trn en trop !\n";
		else if ((int) $nb > 0)
			echo "$nb TERRAINS $trn qui manquent !\n";
		if ((int) $nb != 0)
			$trn_array[$trn] = $nb;
		//if ($exec) mod_trn($mid, $trn_array);
	} */
} /* foreach $mid */
if($exec) echo "!!! mise à jour effectuée !!!\n";
else echo "mode simulation, aucune modification en BDD. Relancer le script avec l'option exec pour MAJ\n";
?>
