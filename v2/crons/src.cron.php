<?php

$dep_src = array("btc");
$log_src = "Recherches";

function mbr_src(&$_user) {
	global $_sql, $_histo;
	$mid = $_user['mbr_mid'];
	$race = $_user['mbr_race'];

	if(isset($_user["no_src_todo"]))
		return;

	$src_todo = get_src_todo($mid);

	if(!$src_todo)
		return;

	$need_btc = array();
	for($i = 1; $i <= get_conf_gen($race, "race_cfg", "btc_nb"); ++$i)
		if(get_conf_gen($race, "btc", $i, "prod_src"))
			$need_btc[] = $i;

	$sql = "SELECT COUNT(btc_type) AS nb FROM ".$_sql->prebdd."btc WHERE btc_mid = $mid AND btc_type IN (".implode(',', $need_btc).")";
	$speed = $_sql->make_array_result($sql)['nb'];

	$sql="UPDATE ".$_sql->prebdd."src_todo SET stdo_tours = CASE ";
	foreach($src_todo as $src_info)  /* Toutes les recherches de ce type là */
	{
		$tours = $src_info['stdo_tours'];
		$type = $src_info['stdo_type'];
		if($tours - $speed > 0) {
			$sql.=" WHEN stdo_type = $type THEN  stdo_tours - $speed";
			$speed = 0;
		} else {
			$sql.=" WHEN stdo_type = $type THEN  0";
			$_histo->add($mid, $mid, HISTO_SRC_DONE,array("src_type" => $type));
			$speed -= $tours;
		}

		if($speed <= 0)
			break;
	}
	$sql .=" ELSE stdo_tours END WHERE stdo_mid = $mid";
	$_sql->query($sql);
}

function glob_src() {
	global $_sql;
	$sql = "DELETE FROM ".$_sql->prebdd."src_todo WHERE stdo_tours = 0";
	$_sql->query($sql);
}
?>