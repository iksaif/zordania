<pre><?php
/* migration des légions de formation 12 rangs x 35 avec 2 maxi de même type
   vers une légion avec 1 seul rang par type d'unités, sans limite de nombre
   les civils ont tous le rang 0 et les unités militaires ont un rang défini
   dans les fichiers de conf -> unt [$unt] ['rang']
   paramètre ?del_hro=1 pour "forcer" la suppression des unités héros
*/

require_once("../conf/conf.inc.php");

require_once(SITE_DIR . "lib/mysql.class.php");
require_once(SITE_DIR . 'lib/res.lib.php');
require_once(SITE_DIR . 'lib/divers.lib.php');

$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

for($race = 1; $race <= 5; $race++)
{// charger les 5 fichiers de config de race
	include "../conf/$race.php";
	$confname = "config$race";
	$_conf[$race] = new $confname;
}
// toutes les légions de tous les membres, sauf non initialisé (2)
$sql = 'SELECT mbr_mid, mbr_race, mbr_pseudo, leg_id, leg_etat, unt_type, sum( unt_nb ) AS nb, count( unt_rang ) AS nb_rangs, min( unt_rang ) AS rang_mini, max( unt_rang ) AS rang_max
FROM zrd_mbr
INNER JOIN zrd_leg ON mbr_mid = leg_mid
INNER JOIN zrd_unt ON unt_lid = leg_id
WHERE mbr_etat IN (1, 3)
GROUP BY mbr_mid, mbr_race, mbr_pseudo, leg_id, leg_etat, unt_type
ORDER BY mbr_mid ';

$unt_array = $_sql->make_array($sql);
$mid = 0;
$sql=array();
$del_hro = $_GET['del_hro']==1? true: false;
$exec = ($_GET['exec']==1) ? true: false;
foreach($unt_array as $unt)
{
	if($unt['mbr_mid']!=$mid){ // changement de joueur...
		if(!empty($sql)){ // exécuter les requêtes en cours
			if ($exec)
				foreach($sql as $sql1) $_sql->query($sql1);
			print_r($sql);
			$sql = array();
			if ($exec)
				edit_res_gen(array('mid' => $unt['mbr_mid'], 'comp' => true), $res_edit);
			print_r($res_edit);
		}
		echo "joueur $mid - {$unt[mbr_pseudo]}\n";
		$mid = $unt['mbr_mid'];
		$res_edit = array();
	}

	$conf_unt = $_conf[$unt['mbr_race']]->unt[$unt['unt_type']]; // config de l'unité
	$rang = $conf_unt['role'] == TYPE_UNT_CIVIL ? 0 : $conf_unt['rang'];
	if($conf_unt['role'] == TYPE_UNT_HEROS && $unt['nb'] > 1) { // unité type héros, unique et à  créer par le joueur : on supprime
		if ($del_hro)
			$sql[] = "DELETE FROM zrd_unt WHERE unt_lid = {$unt[leg_id]} AND unt_type = {$unt[unt_type]};\n";
		else
			echo "Héros à supprimer\n";
		// et on rembourse le prix des unités
		foreach($conf_unt['prix_res'] as $res => $nb)
			if (isset($res_edit[$res])) $res_edit[$res] += $nb * $unt['nb'];
			else $res_edit[$res] = $nb * $unt['nb'];
	}// else if($unt['nb_rangs']==1 && $unt['rang_mini']==$rang)// rien à  faire
		//echo "OK pour {$unt[unt_lid]} {$unt[unt_type]} $rang\n";
	else  if($unt['nb_rangs']!=1 || $unt['rang_mini']!=$rang){
		if($unt['nb_rangs']!=1){ // cas compliqué : DELETE tous les autres rangs sauf 1 et faire UPDATE sur ce dernier
			$sql[] = "DELETE FROM zrd_unt WHERE unt_lid = {$unt[leg_id]} AND unt_type = {$unt[unt_type]} AND unt_rang <> {$unt[rang_max]};\n";
			$sql[] = "UPDATE zrd_unt SET unt_rang = $rang, unt_nb = {$unt[nb]} WHERE unt_lid = {$unt[leg_id]} AND unt_type = {$unt[unt_type]};\n";
		}else // cas simple
			$sql[] = "UPDATE zrd_unt SET unt_rang = $rang WHERE unt_lid = {$unt[leg_id]} AND unt_type = {$unt[unt_type]};\n";
	}
}
?></pre>
