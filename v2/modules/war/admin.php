<?php

//Verifications
if(!defined("_INDEX_") or !can_d(DROIT_ADM_MBR)){ exit; }
if(!can_d(DROIT_PLAY))
	$_tpl->set("need_to_be_loged",true); 
else {

require_once("lib/war.lib.php");
require_once("lib/member.lib.php");

$_tpl->set('module_tpl', 'modules/war/admin.tpl');

$_tpl->set("war_act", $_act);
$_tpl->set("war_sub", $_sub);

switch($_act) {
case 'histo':
	$mid = request('mid', 'uin', 'get');
	$mbr_array = get_mbr_by_mid_full($mid);
	if($mbr_array)
		$mbr_array = $mbr_array[0];

	if($mbr_array){

		$aid = request('aid', 'uint', 'get');
		if(!$_sub || $_sub == "def") {
			$_sub = "def";
			$cond['type'][] = ATQ_TYPE_DEF;
		} else {
			$_sub = "atq";
			$cond['type'][] = ATQ_TYPE_ATQ;
		}

		// prévisualisation ajax
		if($_display == "ajax" && $aid) {
			$cond['aid'] = $aid;
			$_tpl->set('module_tpl', 'modules/war/bbcodelog.tpl');
			$atq_array= get_atq_gen( $cond);
			if (isset($atq_array[0]))
				$_tpl->set('value',$atq_array[0]);
		} else if ($aid && SITE_DEBUG) {
			$cond['aid'] = $aid;
			$atq_array= get_atq_gen( $cond);
			$_tpl->set('atq_array',$atq_array);		
			$_tpl->set("atq_nb", 0);
			$_debugvars['bilan'] = $atq_array;
		} else {
			$war_page= request("war_page", "uint", "get");
			$war_nb = get_atq_nb($mid, $cond);
			$limite_page = LIMIT_PAGE;
			$nombre_page = $war_nb / $limite_page;
			$nombre_total = ceil($nombre_page);
			$nombre = $nombre_total - 1;

			if($war_page)
				$limite_mysql = $limite_page * $war_page;
			else
				$limite_mysql = 0;

			$cond['limite1']  = $limite_mysql;
			$cond['limite2'] =  $limite_page;

			$_tpl->set('limite_page', $limite_page);
			$_tpl->set("atq_nb", $war_nb);
			$_tpl->set('war_page', $war_page);
			$atq_array= get_atq($mid , $cond);
			$_tpl->set('atq_array',$atq_array);
			$_tpl->set('mbr_array',$mbr_array);
		}
	} // else mbr exist
	break;
}// switch($_act)

}// else can_d(DROIT_PLAY)

?>
