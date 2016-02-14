<?
//Verif
if(!defined("_INDEX_") || !can_d(DROIT_ADM_NWS)){ exit; }

require_once("lib/news.lib.php");
require_once("lib/parser.lib.php");
		
$_tpl->set("admin_tpl","modules/news/admin.tpl");
$_tpl->set("admin_name","News");
$_tpl->set("nws_nb",get_nb_news($_user['lang']));

$nws_nid = request("nws_nid", "uint", "get");
$nws_cid = request("nws_cid", "uint", "get");
$secu = request("secu","string","get");

if(!$nws_nid && !$_act)
{
	$_tpl->set("nws_act", "list");
	
	$nws_page = request("nws_page", "uint", "get");
	$nws_nb = get_nb_news();
	$limite_page = NWS_LIMIT_PAGE;
	$nombre_page = $nws_nb / $limite_page;
	$nombre_total = ceil($nombre_page);
	$nombre = $nombre_total - 1;
	if($nws_page)
		$limite_mysql = $limite_page * $nws_page;
	else
		$limite_mysql = 0;
	
	$nws_array = get_news(0,$limite_mysql,$limite_page);
	$_tpl->set("nws_array",$nws_array);
}
elseif($nws_nid && $_act=="edit")
{
	$_tpl->set("nws_nid", $nws_nid);
	
	
	$nws_array = get_news(0, $nws_nid);
	if($nws_array) {
		$_tpl->set("nws_act","edit");
		
		$nws_array = $nws_array[0];
		$nws_array['nws_texte_parsed'] = $nws_array['nws_texte'];
		$nws_array['nws_texte'] = unparse($nws_array['nws_texte']);
		
		foreach($nws_array as $key => $value)
			$_tpl->set($key,$value);

		$nws_texte = request("nws_texte", "string", "post");
		$nws_titre = request("nws_titre", "string", "post");
		$nws_etat = request("nws_etat", "uint", "post");
		$nws_lang = request("nws_lang", "string", "post");
		$nws_cat = request("nws_cat", "uint", "post");
		$nws_closed = request("nws_closed", "uint", "post");
	
		if($nws_texte || $nws_titre || $nws_lang || $nws_etat || $nws_cat){
			$nws_texte_parsed = parse($nws_texte);
			
			$_tpl->set("nws_texte",htmlspecialchars($nws_texte));
			$_tpl->set("nws_texte_parsed",$nws_texte_parsed);
			$_tpl->set("nws_titre",htmlspecialchars($nws_titre));
			$_tpl->set("nws_etat",$nws_etat);
			$_tpl->set("nws_lang",$nws_lang);
			$_tpl->set("nws_cat",$nws_cat);
			$_tpl->set("nws_closed",$nws_closed);
	
			if($nws_texte && $nws_titre && $nws_lang && $nws_etat && $nws_cat)
			{	
				$edit = array(/*'mid' => $_user['mid'],*/
	        				'etat' => $nws_etat,'titre' => $nws_titre,'lang' => $nws_lang,
	        				'texte' => parse($nws_texte),'cat' => $nws_cat,'closed' => 	$nws_closed);
				if(edit_news($nws_nid,$edit))	
					$_tpl->set("nws_ok","ok");
				else
					$_tpl->set("nws_ok","pasok");
			} else
				$_tpl->set("nws_ok","manque");
		}
	}
}
elseif($nws_nid && $_act=="drop" && !$secu && can_d(DROIT_ADM_NWS))
{
	$_tpl->set("nws_act","drop");
	$_tpl->set("nws_nid",$nws_nid);
}
elseif($nws_nid && $_act=="drop" && $secu && can_d(DROIT_ADM_NWS))
{
	$_tpl->set("nws_act","dropreal");
	$_tpl->set("nws_nid",$nws_nid);
	$_tpl->set("nws_drop_ok",del_news($nws_nid));
}
elseif($_act=="addnews" || $_act=="newnews" && can_d(DROIT_ADM_NWS))
{
	$_tpl->set("nws_act","new");
	
	$nws_texte = request("nws_texte", "string", "post");
	$nws_titre = request("nws_titre", "string", "post");
	$nws_etat = request("nws_etat", "uint", "post");
	$nws_lang = request("nws_lang", "string", "post");
	$nws_cat = request("nws_cat", "uint", "post");
	$nws_closed = request("nws_closed", "uint", "post");
	
	if($nws_texte && $nws_titre && $nws_lang && $nws_etat && $nws_cat) {
		if(add_news($_user['mid'], $nws_titre, parse($nws_texte), $nws_etat, $nws_lang, $nws_cat, $nws_closed))
			$_tpl->set("nws_ok","ok");
		else
			$_tpl->set("nws_ok","pasok");
	}else{
		$_tpl->set("nws_texte", $nws_texte);
		$_tpl->set("nws_titre", $nws_titre);
		$_tpl->set("nws_etat", $nws_etat);
		$_tpl->set("nws_lang", $nws_lang);
		$_tpl->set("nws_cat", $nws_cat);
		$_tpl->set("nws_closed", $nws_closed);
		if($nws_texte || $nws_titre || $nws_lang || $nws_etat || $nws_cat)
			$_tpl->set("nws_not_all_post",true);
	}
}
elseif($_act == "edit_cmt")
{
	$_tpl->set("nws_act","edit_cmt");

	$cmt_texte = request("cmt_texte", "string", "post");
	$cmt_id = request("cmt_id", "uint", "get");

	$_tpl->set("cmt_id",$cmt_id);
	$_tpl->set("cmt_texte",$cmt_texte);
	$_tpl->set("cmt_ok","");

	if($cmt_texte && $cmt_id) {
		if(edit_cmt($cmt_id, array('texte' => parse($cmt_texte))))
		{
			$_tpl->set("cmt_texte", $cmt_texte); 
			$_tpl->set("cmt_ok","ok");
		} else {
			$_tpl->set("cmt_texte", $cmt_texte); 
			$_tpl->set("cmt_ok","pasok");
		}
	} else if($cmt_id) {
		$array = get_one_cmt($cmt_id);
		if($array)
			$txt = unparse($array[0]['cmt_texte']);
		else
			$txt = "";

		$_tpl->set("cmt_texte",$txt);
		$_tpl->set("cmt_ok","");
	} else {
		$_tpl->set("cmt_ok","manque");
	}
}
elseif($_act == "drop_cmt")
{
	$cmt_id = request("cmt_id", "uint", "get");

	$_tpl->set("nws_act","drop_cmt");
	$_tpl->set("cmt_id",$cmt_id);
	$_tpl->set("cmt_ok","");

	if(!$cmt_id)
		$_tpl->set("cmt_ok","manque");
	else if($secu)
		if(del_cmt($cmt_id))
			$_tpl->set("cmt_ok","ok");
		else
			$_tpl->set("cmt_ok","pasok");
}
?>