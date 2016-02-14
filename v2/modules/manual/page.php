<?php
if(!defined("_INDEX_")){ exit; }

$_tpl->set("module_tpl","modules/manual/index.tpl");
$page = request("page", "uint", "get");
$race = request("race", "uint", "get", $_user['race']);
$type = request("type", "string", "get");

if(!isset($_races[$race]) or !$_races[$race])
	$race = 1;

load_conf($race);
/* virer les races invisibles ici */
foreach($_races as $key => $value)
	if(!$value)
		unset($_races[$key]);

/* correspondance nom => page */
$arr = array('jeu' => 1, 'batiment' => 2, 'unite' => 3, 'zordania' => 6, 'guerre' => 8, 'diplomatie' => 10, 'commerce' => 7, 
	'egeria' => 23, 'res' => 'res');
if(isset($arr[$_act]))
	$page = $arr[$_act];
else if(is_numeric($_act))
	$page = (int)$_act;

if($race != $_user['race'])
	$_tpl->set('man_load', $race);

$_tpl->set('man_race',$race);
$_tpl->set('mnl_tree', $page === 0);

if($page == 0) /* page des arbres, toutes les infos necessaires */
{
	$_tpl->set('man_unt',$_conf[$race]->unt);
	$_tpl->set('man_btc',$_conf[$race]->btc);
	$_tpl->set('man_src',$_conf[$race]->src);
	$_tpl->set('man_res',$_conf[$race]->res);
	$_tpl->set('man_url',"manual.html?page=$page");
} 

if(!$type && is_numeric($page) && $page >= 0 && $page <= 26)
{
	$_tpl->set('mnl_tpl','modules/manual/pages/'.$page.'.tpl');
	$_tpl->set_ref('conf', $_conf[$race]);
	$_tpl->set('man_url',"manual.html?page=$page");
	// diplomatie
	if ($page == 10) {
		$_tpl->set('dpl_prix', diplo::$prix);
		$_tpl->set('dpl_max', diplo::$max);
		$_tpl->set('dpl_proba', diplo::DUREE_PROBA);
		$_tpl->set('dpl_tax', diplo::DPL_TAX);
	}
} elseif($page === 'res') {
	$res_array = array();
	/* decroiser le tableau : $res_array[res type][race] = conf */
	foreach ($_races as $i => $value)
		if($i != 0 and $value) {
			$tmp = get_conf_gen($i, 'res');
			foreach($tmp as $res => $val)
				 $res_array[$res][$i] = $val;
		}

	$_tpl->set('res_array',$res_array);
	$_tpl->set('mnl_tpl','modules/manual/res.tpl');

} elseif($race) { /* detail d'une race (btc unt res src comp trn) */

	$_tpl->set('mnl_tree', 0);
	$_tpl->set('mnl_tpl','modules/manual/race.tpl');

	$types = array("btc", "unt", "res", "src", "trn", "comp");

	if(!in_array($type, $types))
		$_tpl->set('man_act','liste');
	else {
		$cfg = $_conf[$race]->$type;
		if ($type == 'unt') { /* filtre sous-type d'unites */
			$stype = request("stype", "uint", "get");
			foreach ($cfg as $key => $unt)
				if ($stype == TYPE_UNT_CIVIL) {
					if ($unt['role'] != TYPE_UNT_CIVIL) unset($cfg[$key]); // ne garder que les civils
				} else if ($stype == TYPE_UNT_HEROS) {
					if ($unt['role'] != TYPE_UNT_HEROS) unset($cfg[$key]); // ne garder que les heros
				} else if ($unt['role'] == TYPE_UNT_CIVIL || $unt['role'] == TYPE_UNT_HEROS)
					unset($cfg[$key]); // sinon virer les civils ET les heros
			/* trier les unités militaires par leur placement */
			if ($stype != TYPE_UNT_CIVIL) sksort($cfg, 'rang', true);
			/* pour les unités civiles, renseigner le 'new' id */
			else foreach($cfg as $key => $unt) $cfg[$key]['nid'] = $key;

			$_tpl->set('man_stype',$stype);
		}
		$_tpl->set('man_array',$cfg);
		$_tpl->set('man_act',$type);
		$_tpl->set('man_url',"manual.html?type=$type".($type=='unt'?"&amp;stype=$stype":""));
	}
}
?>
