<?php
if(!defined("_INDEX_")) exit;
$mid = request("mid", "string", "get");
$key = request("key", "string", "get");

require_once("lib/member.lib.php");

if(!$mid OR !$key)
	exit;

$limite1 = LIMIT_PAGE;
$limite2 = 0;

$mbr_array = get_mbr_by_mid_full($mid);
if(!$mbr_array)
	exit;
if($key != calc_key($_file, $mbr_array[0]['mbr_login']))
	exit;
/* bug probable ici... exit dans tous les cas
{
	if($key != calc_key_histo($mbr_array[0]['mbr_mid'], $mbr_array[0]['mbr_login']))
		exit;
	else
		error_handler(0, 'erreur clé histo', 'modules/histo/xml.php', 17, 'zord_context');
}
*/

/* texte en titre */
$histo = array();
$histo[1] = 'Compétence de votre Héros';
$histo[11] = 'Achat / Vente au marché';
$histo[21] = 'Construction terminée';
$histo[22] = 'Réparation d\'un bâtiment terminée';
$histo[23] = 'Bâtiment détruit par les flammes';
$histo[31] = 'Recherche terminée';
$histo[41] = 'Votre légion est arrivée à destination !';
$histo[42] = 'Votre village a été attaqué !';
$histo[43] = 'Votre allié a été attaqué !';
$histo[43] = 'Votre légion vide a été récupérée';
$histo[51] = 'Vous avez reçu un nouveau message';
$histo[61] = 'Votre légion manque de nourriture !';
$histo[71] = 'Votre filleul vous rapporte';
$_tpl->set("histo_title", $histo);

$_module_tpl = 'modules/histo/histo_xml.tpl';

$mbr_array = $mbr_array[0];

$_tpl->set("histo_array", get_histo($mbr_array['mbr_mid'],$limite1,$limite2));
$_tpl->set("_user",array('pseudo' => $mbr_array['mbr_pseudo'],'mid' => $mbr_array['mbr_mid'], 'race' => $mbr_array['mbr_race']));

?>
