<?php
if(!defined("_INDEX_")){ exit; }
//if(!can_d(DROIT_PLAY)){ exit; }

require_once("lib/member.lib.php");
require_once("lib/map.lib.php");


switch($_act){
case 'search' :
	$term = str_replace('*', '%', request('term', 'string', 'get'));
	if($term){

		$cond = array();
		$cond['op'] = 'AND';
		$cond['etat'] = array(MBR_ETAT_OK);
		$cond['pseudo'] = "%$term%";
		$cond['mid_excl'] = "1";
		$cond['orderby'] = array('ASC', 'pseudo');
		$cond['limite1'] = 10;

		$mbr = get_mbr_gen($cond);
		$Res = array();
		foreach($mbr as $key => $value)
			$Res[$key] = array('value'=>$value['mbr_pseudo']);
		echo json_encode($Res);
	}
	break;

case 'map':
	$x = request('x', 'uint', 'get');
	$y = request('y', 'uint', 'get');
	if($x>0 and $x<MAP_W and $y>0 and $y<MAP_H){
		//$result = get_map(0, $x-10, $y-10, $x+10, $y+10);
		// les 5 emplacements libres les + proches
		$result = select_free_map( $x, $y);
		echo json_encode($result);
	}
	break;

default :
	break;
} /* switch */

?>
