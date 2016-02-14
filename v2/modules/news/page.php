<?php
//Verif
if(!defined("_INDEX_")){ exit; }
define('ZORD_NEWS_FID',30); // id du forum correspsondant aux news

//include de la classe
require_once('lib/forum.lib.php');
require_once("lib/parser.lib.php");
$smileys_base = getSmileysBase();
$smileys_more = getSmileysMore($smileys_base);
$_tpl->set("smileys_base", $smileys_base);
$_tpl->set("smileys_more", $smileys_more);
		
$_tpl->set("module_tpl","modules/news/news.tpl");
$_tpl->set('is_modo',can_d(DROIT_PUNBB_MOD));


// Regarde toutes les news + pagination
// tout autre lien renvoie sur le forum
$frm = get_cat(0, ZORD_NEWS_FID);
if (!empty($frm))
{
	$frm = $frm[0];
	$_tpl->set('frm',$frm);
	$nbr_pages = ceil( $frm['num_topics'] / NWS_LIMIT_PAGE);
	if($nbr_pages > 1){// pagination dans le forum
		$page = request('p','uint','get');	
		$page = ( $page < 1 || $page > $nbr_pages) ? 1 : $page;
		$_tpl->set('arr_pge', get_list_page( $page, $nbr_pages));
		$_tpl->set('pge',$page);
		$start = NWS_LIMIT_PAGE * ($page - 1);
	}else
		$start = 0;

	$_tpl->set('frm', $frm);
	$topic_array=get_topic(array('fid'=>ZORD_NEWS_FID, 'start'=>$start, 'limit'=>NWS_LIMIT_PAGE, 'select'=>'first_pid', 'order'=>$frm['sort_by']));
	$_tpl->set('nws_array',$topic_array);
	//if(empty($topic_array)) break;

	$first_pid = array();
	foreach($topic_array as $key => $topic)
		$first_pid[] = $topic['first_pid'];

	$posts_array = get_posts(array('select'=>'mbr', 'pid_list'=>$first_pid), 'pid');
	$_tpl->set('posts_array',$posts_array);
}

?>
