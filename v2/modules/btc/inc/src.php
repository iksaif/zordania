<?php
if(!defined("INDEX_BTC")){ exit; }


require_once("lib/res.lib.php");
require_once("lib/unt.lib.php");
require_once("lib/src.lib.php");
require_once("lib/btc.lib.php");
 
 if($_sub == "cancel_src")
{
	$_tpl->set("btc_act","cancel_src");
	$sid = request("sid", "uint", "get");
	
	if(!$sid)
		$_tpl->set("btc_no_sid",true);
	else {
		if(cnl_src($_user['mid'], $sid)) {
			mod_res($_user['mid'], get_conf("src", $sid, "prix_res"), 0.5);
			$_tpl->set("btc_ok",true);
		} else
		$_tpl->set("btc_ok",false);
	}
	
}
//Formulaire src + Liste src
elseif($_sub == "src")
{
	$_tpl->set("btc_act","src");
	
	$src_todo = get_src_todo($_user['mid']);
	
	$_tpl->set("src_todo",index_array($src_todo, 'stdo_type'));
	
	$conf_src = get_conf("src");
	$need_src = array();
	$need_res = array();
	$need_btc = array();

	foreach($conf_src as $type => $value) { 
		if(isset($value['prix_res']))
			$need_res = array_merge(array_keys($value['prix_res']), $need_res);
		if(isset($value['need_src']))
			$need_src = array_merge($value['need_src'], $need_src);
		if(isset($value['need_btc']))
			$need_btc = array_merge($value['need_btc'], $need_btc);
		array_push($need_src, $type);
	}
	$need_btc = array_unique($need_btc);
	$need_res = array_unique($need_res);
	$need_src = array_unique($need_src);
	asort($need_res);
	asort($need_src);
	asort($need_btc);

	$cache = array();
	$cache['src'] = get_src_done($_user['mid'], $need_src);
	$cache['src'] = index_array($cache['src'], "src_type");
	$cache['res'] = clean_array_res(get_res_done($_user['mid'], $need_res));
	$cache['res'] = $cache['res'][0];
	$cache['src_todo'] = index_array($src_todo, "stdo_type");
	$cache['btc_done'] = get_nb_btc_done($_user['mid'], $need_btc);
	$cache['btc_done'] = index_array($cache['btc_done'], "btc_type");
	$src_tmp = array();

	foreach($conf_src as $type => $value) { 
		$src_tmp[$type]['bad'] = can_src($_user['mid'],  $type, $cache);
		$src_tmp[$type]['conf'] = $value;
	}

	$src_array = array();
	foreach($src_tmp as $sid => $array) {
		if($array['bad']['need_src'] || $array['bad']['need_no_src'] || $array['bad']['need_btc']) continue;
		$src_array[$sid] = $array;
	}

	unset($src_tmp);

	$_tpl->set("src_dispo", $src_array);
	$_tpl->set("res_utils", $cache['res']);
	$_tpl->set("src_conf", $conf_src);
}
//Nouvelle src
elseif($_sub == "add_src")
{
	$type = request("type", "uint", "post");
	
	$src_todo = get_src_todo($_user['mid']);
	$src_todo = index_array($src_todo, 'stdo_type');
	$_tpl->set("btc_act","add_src");
	$_tpl->set("src_type", $type);
	if(!$type)
		$_tpl->set("btc_no_type",true);
	else if(count($src_todo) + 1 > TODO_MAX_SRC)
		$_tpl->set("btc_src_max",TODO_MAX_SRC);
	else if(isset($src_todo[$type]))
		$_tpl->set("src_pending", true);
	else
	{
		$array = can_src($_user['mid'], $type);
		if(isset($array['do_not_exist']))
			$_tpl->set("btc_no_type",true);
		else {
			$ok = !($array['need_no_src'] || $array['prix_res'] || $array['need_src'] || $array['done'] || $array['need_btc']);
			$_tpl->set("src_infos", $array);
			$_tpl->set("btc_ok", $ok);
			if($ok) {
				scl_src($_user['mid'], $type);
				mod_res($_user['mid'], get_conf("src", $type, "prix_res"), -1);
			}
		}
	}
}
?>
