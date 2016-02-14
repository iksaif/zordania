<?php
/* 
  réinitialiser les membres en veille en dessous d'un seuil de points
  OU tout le monde = RAZ du jeu
*/

require_once("../conf/conf.inc.php");

require_once(SITE_DIR . "lib/mysql.class.php");
require_once(SITE_DIR . 'lib/divers.lib.php');
require_once(SITE_DIR . 'lib/btc.lib.php');
require_once(SITE_DIR . 'lib/unt.lib.php');
require_once(SITE_DIR . 'lib/trn.lib.php');
require_once(SITE_DIR . 'lib/member.lib.php');
require_once(SITE_DIR . "lib/res.lib.php");
require_once(SITE_DIR . "lib/src.lib.php");
require_once(SITE_DIR . "lib/map.lib.php");
require_once(SITE_DIR . "lib/alliances.lib.php");
require_once(SITE_DIR . "lib/mch.lib.php");
require_once(SITE_DIR . "lib/war.lib.php");
require_once(SITE_DIR . "lib/msg.lib.php");
require_once(SITE_DIR . "lib/nte.lib.php");
require_once(SITE_DIR . "lib/vld.lib.php");
require_once(SITE_DIR . "lib/histo.class.php");

$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

$_tpl = new Template();
$_tpl->set_dir('../templates');
$_tpl->set_tmp_dir('../tmp');
$_tpl->set_lang('fr_FR');
$_tpl->set("cfg_url",SITE_URL);

$exec = true; //isset($_GET['exec']) ? true : false;

// RAZ du jeu, tous les membres réinitialiés
$sql = 'SELECT mbr_mid, mbr_race, mbr_pseudo, mbr_mapcid
FROM zrd_mbr WHERE mbr_mid <> '.MBR_WELC.' AND mbr_etat IN ('.MBR_ETAT_OK.','.MBR_ETAT_ZZZ.')';
/* toutes les membres en veille qui ont moins de xxx points
WHERE mbr_etat = 3 AND mbr_points < 1000
ORDER BY mbr_mid';  */

$mid_array = $_sql->make_array($sql);
$sql=array();
foreach($mid_array as $_user)
{
	$mid  = $_user['mbr_mid'];
	$race = $_user['mbr_race'];
	$cid  = $_user['mbr_mapcid'];
	echo $_user['mbr_pseudo']." ($mid)($race)\n";

	if ($exec) { /* init mbr */
		cls_aly($mid);
		cls_unt($mid);
		cls_btc($mid);
		cls_res($mid);
		cls_src($mid);
		cls_trn($mid);
		cls_com($mid);
		cls_atq($mid);
		cls_histo($mid);
		cls_vld($mid);
		cls_map($mid, $cid);
		//cls_frm($mid);

		/* réinitialise la carte pour $mid */ /* , mbr_pts_armee = 0 */
		$sql = "UPDATE ".$_sql->prebdd."mbr SET mbr_etat = ".MBR_ETAT_INI.", 
		mbr_mapcid = 0, mbr_place = 0, mbr_population = 0, mbr_points = 0 
		WHERE mbr_mid = $mid ";
		$_sql->query($sql);

		/* ajouter une action + clé pour réinit */

		/* envoyer le mail 
		$txt = $_tpl->get('modules/inscr/mails/text_relance.tpl',1);
		$obj = $_tpl->get('modules/inscr/mails/objet_new.tpl',1);
		mailto(SITE_WEBMASTER_MAIL, $mbr['mbr_mail'], $obj, $txt);
		*/
	}

} /* foreach $mid */
?>
