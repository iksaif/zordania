<?php
//Verif
if(!defined("_INDEX_") or !can_d(DROIT_ADM)){ exit; }

// liste des rép de log
$arr_rep = array_diff(scandir(SITE_DIR.'logs/'), array('..', '.'));
foreach($arr_rep as $key => $rep) if (!is_dir(SITE_DIR."logs/$rep")) unset($arr_rep[$key]);
$_tpl->set("arr_rep",$arr_rep);

if($_act == 'sql') { // lister / lire les logs
	// lister les tables SQL
	$tables = $_sql->make_array('SHOW TABLES FROM '.MYSQL_BASE);

	$sql = '';
	foreach($tables as $tbl)
		$sql .= ",".$tbl['Tables_in_'.MYSQL_BASE];

	// diagnostic sur toutes les tables
	$tables = $_sql->make_array('CHECK TABLE '.substr($sql, 1)." FAST");
	$_tpl->set("module_tpl","modules/admin/sql.tpl");
	$_tpl->set("arr_tbl",$tables);
} else { // act = log ou vide

	if(!empty($_sub)){
		if (is_dir(SITE_DIR."logs/$_sub")){
			// scan rep, trier rep & fichiers
			$arr_fic = array_diff(scandir(SITE_DIR."logs/$_sub"), array('..', '.'));
			$arr_sub = array();
			foreach($arr_fic as $key => $rep)
				if (is_dir(SITE_DIR."logs/$_sub/$rep")){
					unset($arr_fic[$key]);
					$arr_sub[] = $rep;
				}

			$_tpl->set("arr_fic",$arr_fic);
			$_tpl->set("arr_sub",$arr_sub);
			$_tpl->set("sub",$_sub);
		}
	}
	$fic = request('fic', 'string', 'post');
	if($fic)
		$_tpl->set("content",file_get_contents(SITE_DIR."logs/$_sub/$fic"));

	$_tpl->set("module_tpl","modules/admin/log.tpl");
}
?>
