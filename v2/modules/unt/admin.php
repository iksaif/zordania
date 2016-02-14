<?php

if(!defined("_INDEX_")) exit;

if (can_d(DROIT_ADM)) {

$_tpl->set("module_tpl","modules/unt/admin.tpl");

$race = request("race", "uint", "get", $_user['race']);
if(!in_array($race,$_races))
	$race = 1;
load_conf($race);
$race_config = $_conf[$race];

$_tpl->set('man_race',$race);
if($race != $_user['race'])
	$_tpl->set('man_load', $race);
$race_cfg = $race_config->unt;
$_tpl->set('man_unt',$race_cfg);

$nbr = request('nbr', 'array', 'post');
$total = array('prix_res' => array(), 'prix_unt' => array(),
	'bonus' => array('atq' => 0, 'def' => 0, 'vie' => 0)
);
$boucle = array('vie', 'def', 'atq_unt', 'atq_btc', 'carry'); // pas la vitesse

foreach ($race_cfg as $key => $value) {
	// cumuler les stats & prix
	if (isset($nbr[$key]))
		$nbr[$key] = protect($nbr[$key], 'uint', 0);
	else
		$nbr[$key] = 0;

	foreach($boucle as $item) // cumul stats
		if (isset($value[$item])) {
			if (isset($total[$item]))
				$total[$item] += $nbr[$key] * $value[$item];
			else
				$total[$item] = $nbr[$key] * $value[$item];
	}

	if(isset($value['bonus'])) // cumul des bonus
		foreach($value['bonus'] as $bon => $val)
			$total['bonus'][$bon] += $nbr[$key] * $val;

	if (isset($value['prix_res'])) // prix en ressources
	foreach ($value['prix_res'] as $res => $nb) {
			if (isset($total['prix_res'][$res]))
				$total['prix_res'][$res] += $nbr[$key] * $nb;
			else
				$total['prix_res'][$res] = $nbr[$key] * $nb;
	}

	if (isset($value['prix_unt'])) // prix en unitÃ©s
	foreach ($value['prix_unt'] as $unt => $nb) {
			if (isset($total['prix_unt'][$unt]))
				$total['prix_unt'][$unt] += $nbr[$key] * $nb;
			else
				$total['prix_unt'][$unt] = $nbr[$key] * $nb;
	}

}
$total['atq_unt'] += $total['atq_unt'] * ($total['bonus']['atq']/100);
$total['atq_btc'] += $total['atq_btc'] * ($total['bonus']['atq']/100);
$total['def']     += $total['def'] * ($total['bonus']['def']/100);

$_tpl->set('nbr',$nbr);
$_tpl->set('total',$total);

} //  if can_d(DROIT_ADM_MBR)
?>
