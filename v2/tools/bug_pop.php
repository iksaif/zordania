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


// toutes les légions de tous les membres, sauf non initialisé (2)
$sql = 'SELECT mbr_mid, mbr_race, mbr_pseudo, leg_etat, unt_lid, unt_type, unt_nb, unt_rang '
. ' FROM zrd_mbr '
. ' INNER JOIN zrd_leg ON mbr_mid = leg_mid '
. ' INNER JOIN zrd_unt ON unt_lid = leg_id '
. ' WHERE mbr_race <> 0 ORDER BY mbr_mid ASC';

$unt_array = $_sql->make_array($sql);
$mid = 0;
$sql=array();
$i = 0;
$exec = (isset($_GET['exec']) && $_GET['exec']==1);
foreach($unt_array as $unt)
{
	// vérifier que nb est > 0
	if($unt['unt_nb'] <= 0){
		$i++;
		echo "ZERO : {$unt['mbr_race']} {$unt['mbr_pseudo']} {$unt['mbr_mid']} {$unt['unt_lid']} {$unt['unt_type']} {$unt['unt_rang']} {$unt['unt_nb']}\n";
	}

	if(get_conf_gen($unt['mbr_race'], 'unt', $unt['unt_type'], 'role') != TYPE_UNT_CIVIL)
		$rang = get_conf_gen($unt['mbr_race'], 'unt', $unt['unt_type'], 'rang');
	else
		$rang = 0;
	if($unt['unt_rang'] != $rang) { //$_conf[$unt['mbr_race']][$unt['unt_type']]['rang']){
		$i++;
		echo "RANG ($rang) : {$unt['mbr_race']} {$unt['mbr_pseudo']} {$unt['mbr_mid']} {$unt['unt_lid']} {$unt['unt_type']} {$unt['unt_rang']} {$unt['unt_nb']}\n";
	}
}

echo "\n$i\n";

?></pre>
