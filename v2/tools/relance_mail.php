<?php
echo php_sapi_name()."\n";
$mid = (isset($argv[1]) && is_numeric($argv[1]) ? (int)$argv[1] : 0);
$limit = (isset($argv[2]) && is_numeric($argv[2]) ? (int)$argv[2] : 0);

//require_once("/home/zordania/v2/conf/conf.inc.php");
require_once("/home/zorddev/conf/conf.inc.php");
require_once(SITE_DIR . "lib/divers.lib.php");
require_once(SITE_DIR . "lib/mysql.class.php");
require_once(SITE_DIR . "lib/Template.class.php");
require_once(SITE_DIR . "lib/vld.lib.php");
require_once(SITE_DIR . "lib/member.lib.php");

/* BDD */
$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

/* template */
$_tpl = new Template();
$_tpl->set_dir(SITE_DIR .'templates');
$_tpl->set_tmp_dir(SITE_DIR .'tmp');
$_tpl->set_lang('fr_FR');
$_tpl->set("cfg_url",SITE_URL);

/* sélection des comptes non validés 
$sql = 'SELECT mbr_mid, mbr_login, mbr_mail, mbr_pass, mbr_etat, mbr_decal, mbr_ldate, mbr_lmodif_date, mbr_inscr_date, vld_rand, vld_date, vld_act ';
$sql.= ' FROM zrd_mbr LEFT JOIN zrd_vld ON mbr_mid = vld_mid AND vld_act = \'new\' WHERE ';
if($mid) $sql .= "mbr_mid > $mid AND ";
$sql.= ' mbr_etat ='.MBR_ETAT_INI;
$sql.= ' ORDER BY zrd_mbr.mbr_lmodif_date ASC';*/

/* sélection des comptes validés en veille sauf exilés et visiteur vieux de + de 30 jours */
$sql = 'SELECT mbr_mid, mbr_login, mbr_pseudo, mbr_mail, mbr_pass, mbr_etat, mbr_decal, mbr_ldate, mbr_lmodif_date, mbr_inscr_date ';
$sql.= ' FROM '.$_sql->prebdd.'mbr WHERE ';
if($mid) $sql .= "mbr_mid = $mid ";
else $sql.= ' mbr_etat ='.MBR_ETAT_ZZZ.' AND mbr_gid NOT IN ('.GRP_VISITEUR.','.GRP_EXILE.','.GRP_EXILE_TMP.') AND datediff(NOW(), `mbr_ldate`) > 30';
$sql.= ' ORDER BY mbr_ldate ASC';

//echo $sql;

$mbr_array = $_sql->make_array($sql);
$nb=0;
foreach($mbr_array as $mbr){
	/* supprime toute clé de validation existante */
	cls_vld($mbr['mbr_mid']);

	/* nouvelle clé de validation */
	$key = genstring(GEN_LENGHT);
	new_vld($key, $mbr['mbr_mid'], 'rest'); // restauration
	/* les autres valeurs sont new res del et edit */

	/* envoi du mail de relance */
	$_tpl->set('login', $mbr['mbr_login']);
	$_tpl->set('pseudo', $mbr['mbr_pseudo']);
	$_tpl->set('pass', $mbr['mbr_pass']);
	$_tpl->set('mail', $mbr['mbr_mail']);
	$_tpl->set('mid', $mbr['mbr_mid']);
	$_tpl->set('key', $key);

	$txt = $_tpl->get('modules/inscr/mails/text_relance.tpl',1);
	$obj = $_tpl->get('modules/inscr/mails/objet_relance.tpl',1);
	if(mailto('pifou@zordania.com', $mbr['mbr_mail'], $obj, $txt)) {
		// debug !
		echo $mbr['mbr_ldate'].' - mail à '.$mbr['mbr_mail']." : $obj\n";
		if ($mid) echo "$txt\n";

		$sql = 'UPDATE '.$_sql->prebdd.'mbr SET mbr_ldate = NOW() - INTERVAL 30 DAY WHERE mbr_mid = '.$mbr['mbr_mid'];
		$_sql->query($sql);
	} else
		echo $mbr['mbr_ldate'].' - ECHEC à '.$mbr['mbr_mail']."\n";

	$nb++;
	if($limit && $limit<=$nb) break;// limiter le nombre de mails à envoyer

}

echo "fin traitement relance : $nb mails envoyés.\n";

?>
