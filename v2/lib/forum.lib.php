<?php

/* catégories & forums triés */
function get_cat_frm($cid = 0, $fid = 0, $mbr = false){
	$result = get_cat($cid, $fid, $mbr);
	$cat_array = array();
	foreach($result as $value){
		if(!isset($cat_array[$value['cid']]))
			$cat_array[$value['cid']] = array('cat_name' => $value['cat_name']);
		$cat_array[$value['cid']]['frm'][] = $value;
	}
	return $cat_array;
}

/* catégories du forum */
function get_cat($cid = 0, $fid = 0, $mbr = false){
	global $_user, $_sql;
	$cid = protect( $cid, 'uint');
	$fid = protect($fid, 'uint');
	$sql = 'SELECT c.id AS cid, c.cat_name, f.id AS fid, f.forum_name, f.forum_desc, 
	f.redirect_url, f.num_topics, f.num_posts, _UDATE_FORMAT(f.last_post) AS last_post, f.last_post AS last_post_unformat, f.last_post_id, f.last_poster, f.last_subject, f.sort_by,
	IFNULL(fp.read_forum, 1) AS read_forum, IFNULL(fp.post_replies, 1) AS post_replies, IFNULL(fp.post_topics, 1) AS post_topics ';
	if($mbr)
		$sql .= ', mbr_mid, mbr_gid ';
	$sql .= ' FROM '.MYSQL_PREBDD_FRM.'categories AS c 
	INNER JOIN '.MYSQL_PREBDD_FRM.'forums AS f ON c.id=f.cat_id 
	LEFT JOIN '.MYSQL_PREBDD_FRM.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$_user['groupe'].') ';
	if($mbr){
		$sql .= ' LEFT JOIN '.MYSQL_PREBDD_FRM.'posts AS p ON f.last_post_id = p.id';
		$sql .= ' LEFT JOIN '.MYSQL_PREBDD.'mbr AS m ON p.poster_id = m.mbr_mid';
	}
	$sql .= ' WHERE (fp.read_forum IS NULL OR fp.read_forum=1) ';
	if($cid)
		$sql .= " AND c.id = $cid ";
	if($fid)
		$sql .= " AND f.id = $fid ";
	$sql .= ' ORDER BY c.disp_position, c.id, f.disp_position';
	return $_sql->make_array($sql);
}

function get_frm_droits($fid, $gid){
	global $_sql;
	$fid = protect($fid, 'uint');
	$gid = protect($gid, 'uint');
	if($fid && $gid){
		$sql = 'SELECT read_forum, post_topics, post_replies ';
		$sql.= ' FROM '.MYSQL_PREBDD_FRM.'forum_perms AS fp ';
		$sql.= " WHERE forum_id = '$fid' AND group_id = '$gid'";
		$ret = $_sql->make_array($sql);
		if(empty($ret)) // autorisé par défaut
			return array('read_forum'=>1, 'post_topics'=>1, 'post_replies'=>1);
		else
			return $ret[0];
	}
	return array('read_forum'=>0, 'post_topics'=>0, 'post_replies'=>0);	
}

function can_create_topic($fid,$group)
{
	$droits = get_frm_droits($fid, $group);
	return $droits['post_topics'];
}



/* les topics du forum */
function get_topic($cond){
	global $_user, $_sql;
	$select = isset($cond['select']) ? protect($cond['select'], 'string') : '';
	$fid = isset($cond['fid']) ? protect($cond['fid'], 'uint') : 0;
	$group = isset($cond['group']) ? protect($cond['group'], 'uint') : $_user['groupe'];
	$tid = isset($cond['tid']) ? protect($cond['tid'], 'uint') : 0;
	$tid_list = isset($cond['tid_list']) ? protect($cond['tid_list'], 'array') : array();
	$start = isset($cond['start']) ? protect($cond['start'], 'uint') : -1;
	$limit = isset($cond['limit']) ? protect($cond['limit'], 'uint') : LIMIT_PAGE;
	$order = isset($cond['order']) ? protect($cond['order'], 'string') : false;

	if($select == 'topic'){// optimisé: table 'topic' seulement
		// posted_unformat: pour la comparaison de date
		$sql = 'SELECT _UDATE_FORMAT(t.posted) AS posted, t.last_post AS posted_unformat, _UDATE_FORMAT(t.last_post) AS last_post, t.id AS tid, t.poster, t.subject, t.last_post_id, t.last_poster, t.num_views, t.num_replies, t.closed, t.sticky, t.forum_id, t.id ';
		$sql .= ' FROM '.MYSQL_PREBDD_FRM.'topics AS t ';

	}else{// CEIL(1+num_replies/LIMIT_PAGE) = nb de pages
		$sql = 'SELECT _UDATE_FORMAT(t.posted) AS posted, t.last_post AS posted_unformat, _UDATE_FORMAT(t.last_post) AS last_post, t.id AS tid, t.poster, t.subject, t.last_post_id, t.last_poster, t.num_views, t.num_replies, CEIL((t.num_replies)/'.LIMIT_PAGE.') as pgs, t.closed, t.sticky, t.moved_to, t.forum_id, t.id, f.forum_name, f.last_post_id AS frm_last_post_id, c.id AS cid, c.cat_name, IFNULL(fp.read_forum, 1) AS read_forum, IFNULL(fp.post_replies, 1) AS post_replies, IFNULL(fp.post_topics, 1) AS post_topics ';
		if($select=='mbr'){
			$sql .= ', m2.mbr_mid AS auth_mid,  m2.mbr_gid AS auth_gid, m1.mbr_mid AS last_poster_mid, m1.mbr_gid AS last_poster_gid ';
		}
		elseif($select == 'first_pid')// le 1er post de la discussion
			$sql .= ', (SELECT min(pp.id) FROM zrd_frm_posts AS pp WHERE pp.topic_id = t.id) AS first_pid ';
		$sql .= ' FROM '.MYSQL_PREBDD_FRM.'topics AS t ';
		$sql .= " INNER JOIN ".MYSQL_PREBDD_FRM."forums AS f ON f.id=t.forum_id "; 
		$sql .= " INNER JOIN ".MYSQL_PREBDD_FRM."categories AS c ON c.id=f.cat_id ";
		$sql .= " LEFT JOIN ".MYSQL_PREBDD_FRM."forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='$group') ";
		if($select=='mbr'){// récup mid et groupe pour l'auteur et le dernier posteur
			$sql .= 'INNER JOIN '.MYSQL_PREBDD_FRM.'posts AS p1 ON t.`last_post_id` = p1.id
			LEFT JOIN '.MYSQL_PREBDD.'mbr AS m1 ON p1.poster_id = m1.mbr_mid
			INNER JOIN '.MYSQL_PREBDD_FRM.'posts AS p2 ON p2.id = (
				SELECT min( p3.id ) FROM '.MYSQL_PREBDD_FRM.'posts AS p3 WHERE p3.topic_id = t.id)
			LEFT JOIN '.MYSQL_PREBDD.'mbr AS m2 ON p2.poster_id = m2.mbr_mid ';
		}
	}

	$where = ' AND IFNULL(fp.read_forum, 1) = 1'; // droit de lecture au minimum!
	if($fid)
		$where .= " AND t.forum_id=$fid ";
	if($tid)
		$where .= " AND t.id=$tid ";
	else if ($tid_list)
		$where .= " AND t.id IN(".implode(',',$tid_list).") ";
	if($where)
		$sql .= ' WHERE '.substr($where, 4);

	if($select != 'topic'){
		if($order)
			$sql .= ' ORDER BY t.posted DESC';
		else
			$sql .= ' ORDER BY t.sticky DESC, t.last_post DESC';
		if($start>=0)
			$sql .= " LIMIT $start, $limit ";
	}
	return $_sql->make_array($sql);
}

function get_info_topic($tid,$group)
{
	$result = get_topic(array('tid'=>$tid, 'group'=>$group));
	if($result) return $result[0]; else return array();
}



function get_posts($cond, $index=false)// fonction générale, full options
{
	global $_sql, $_user;

	/*select = tid|pid|post (seulement table posts)|mbr (infos membre+ally+grade)
	substr (pour la recherche, message tronqué)|first_pid (le 1er post de la discussion)
	ou rien (selection posts + infos topic + permissions)*/
	$select = isset($cond['select']) ? protect($cond['select'], 'string') : '';
	$tid = isset($cond['tid']) ? protect($cond['tid'], 'uint') : 0;
	$tid_list = isset($cond['tid_list']) ? protect($cond['tid_list'], 'array') : array();
	$pid = isset($cond['pid']) ? protect($cond['pid'], 'uint') : 0;
	$pid_list = isset($cond['pid_list']) ? protect($cond['pid_list'], 'array') : array();
	$fid = isset($cond['fid']) ? protect($cond['fid'], 'uint') : 0;
	$user = isset($cond['user']) ? protect($cond['user'], 'uint') : 0;
	$show_unanswered = isset($cond['show_unanswered']) ? protect($cond['show_unanswered'], 'bool') : false;
	$new_posts = isset($cond['show_new']) ? protect($cond['show_new'], 'bool') : false;
	$last_24h = isset($cond['show_24h']) ? protect($cond['show_24h'], 'bool') : false;
	$group = isset($cond['group']) ? protect($cond['group'], 'string') : '';// utile ??
	$sort_by = isset($cond['sort_by']) ? protect($cond['sort_by'], 'string') : '';
	$sort_dir = isset($cond['sort_dir']) && $cond['sort_dir'] == 'DESC' ? 'DESC' : 'ASC';
	$start = isset($cond['start']) ? protect($cond['start'], 'uint') : -1;
	$limite = isset($cond['limit']) ? protect($cond['limit'], 'uint') : LIMIT_PAGE;

	if($select == 'tid')
		$sql = 'SELECT DISTINCT t.id AS tid ';
	else if($select == 'pid')
		$sql = 'SELECT p.id AS pid ';
	else if($select == 'substr')
		$sql = 'SELECT p.id AS pid, p.poster AS pposter, _UDATE_FORMAT(p.posted) AS pposted,
		p.poster_id, SUBSTRING(p.message, 1, 1000) AS message, t.id AS tid, t.poster, t.subject, 
		_UDATE_FORMAT(t.last_post) AS last_post, t.last_post_id, t.last_poster, t.num_replies, t.forum_id ';
	else if($select == 'post')
		$sql = 'SELECT p.id AS pid, p.poster, _UDATE_FORMAT(p.posted) AS posted,
		p.poster_id, p.message, p.topic_id AS tid, _UDATE_FORMAT(p.edited) AS edited, p.edited_by ';
	else
		$sql = 'SELECT p.id AS pid, p.poster AS username, p.poster_id, p.message, 
		_UDATE_FORMAT(p.posted) AS posted, _UDATE_FORMAT(p.edited) AS edited, p.edited_by, p.topic_id AS tid,
		t.forum_id, t.subject, t.sticky, t.closed ';
	if($select == 'mbr')
		$sql .= ', a.al_name, a.al_aid, m.mbr_sign, m.mbr_gid ';
	if($select == 'first_pid')// le 1er post de la discussion
		$sql .= ', (SELECT min(pp.id) FROM zrd_frm_posts AS pp WHERE pp.topic_id = t.id) AS first_pid ';

	$sql .= ' FROM '.MYSQL_PREBDD_FRM.'posts AS p ';
	if($select!='post')
		$sql .= ' INNER JOIN '.MYSQL_PREBDD_FRM.'topics AS t ON t.id=p.topic_id ';
	if($select == 'mbr'){
		$sql .= " LEFT JOIN ".$_sql->prebdd."mbr AS m ON m.mbr_mid=p.poster_id ";
		$sql .= " LEFT JOIN ".$_sql->prebdd."al_mbr AS al ON (al.ambr_mid = m.mbr_mid AND ambr_etat <> ".ALL_ETAT_DEM.") ";// zapper les gens qui ne sont pas encore dans l'alliance
		$sql .= " LEFT JOIN ".$_sql->prebdd."al AS a ON a.al_aid = al.ambr_aid ";
	}else if($select != 'substr' && $select!='post'){// substr: spécifique pour la recherche
		$sql .= ' INNER JOIN '.MYSQL_PREBDD_FRM.'forums AS f ON f.id=t.forum_id ';
		$sql .= ' LEFT JOIN '.MYSQL_PREBDD_FRM.'forum_perms AS fp 
			ON (fp.forum_id=f.id AND fp.group_id='.$_user['groupe'].' AND IFNULL(fp.read_forum, 1) = 1) ';// droit de lecture au minimum!
	}

	$where = '';
	if($tid)
		$where .= " AND p.topic_id = $tid ";
	else if ($tid_list)
		$where .= " AND p.topic_id IN(".implode(',',$tid_list).") ";
	else if ($pid)
		$where .= " AND p.id = $pid ";
	else if ($pid_list)
		$where .= " AND p.id IN(".implode(',',$pid_list).") ";
	if($fid)
		$where .= " AND t.forum_id = $fid ";
	if($user)
		$where .= " AND p.poster_id = $user ";
	if($show_unanswered)
		$where .= ' AND t.num_replies=0 AND t.moved_to IS NULL ';
	if($new_posts)
		$where .= ' AND t.last_post>'.$_user['forum_ldate']. ' ';
	if($last_24h)
		$where .= ' AND t.last_post>'.(time() - 86400). ' ';
	if($where)
		$sql .= ' WHERE '.substr($where, 4);

	if($group && $group == 'tid')
		$sql .= ' GROUP BY t.id ';

	if($select!='post'){
		switch ($sort_by){
			case 1:
				$sql .= ' ORDER BY p.poster ';
				break;
			case 2:
				$sql .= ' ORDER BY t.subject ';
				break;
			case 3:
				$sql .= ' ORDER BY t.forum_id ';
				break;
			case 4:
				$sql .= ' ORDER BY t.last_post ';
				break;
			case 5:
				$sql .= ' ORDER BY p.posted ';
				break;
			default:
				$sql .= ' ORDER BY p.id ';
				break;
		}
		$sql .= $sort_dir;

		if($start>=0)
			$sql .= " LIMIT $start, $limite ";
	}

	if($index !== false)
		return $_sql->index_array($sql,$index);
	else
		return $_sql->make_array($sql);
}

function get_last_post($mid)
{
	$pst = get_posts(array('select'=>'posts', 'user'=>$mid, 'sort_dir'=>'DESC', 'start'=>0, 'limit'=>1));
	if($pst) return $pst[0]; else return array();
}

function get_post($pid)
{
	$pst = get_posts(array('select'=>'post', 'pid'=>$pid));
	if($pst) return $pst[0]; else return array();
}
function get_message($pid){
	$msg = get_posts(array('pid'=>$pid));
	return $msg[0]['message'];
}
function get_last_msg($tid){
	return get_posts(array('select'=>'mbr', 'tid'=>$tid, 'sort_dir'=>'DESC', 'start'=>0));
}
function recup_msg($tid,$start,$limite_page){
	return get_posts(array('select'=>'mbr', 'tid'=>$tid, 'start'=>$start, 'limit'=>$limite_page));
}



function edit_post_gen($cond){ // fonction générale full options
	global $_sql, $_user;
	$pid = isset($cond['pid']) ? protect($cond['pid'], 'uint') : 0;
	$msg = isset($cond['msg']) ? protect($cond['msg'], 'bbcode') : '';
	$silent = isset($cond['silent']) ? protect($cond['silent'], 'bool') : false;
	$title = isset($cond['title']) ? protect($cond['title'], 'string') : '';
	$closed = isset($cond['closed']) ? protect($cond['closed'], 'uint') : -1;
	$sticky = isset($cond['sticky']) ? protect($cond['sticky'], 'uint') : -1;
	$fid = isset($cond['fid']) ? protect($cond['fid'], 'uint') : 0;
	$tid = isset($cond['tid']) ? protect($cond['tid'], 'uint') : 0;

	if($msg){ // éditer le post
		if(!$pid) return false;
		$sql = "UPDATE ".MYSQL_PREBDD_FRM."posts SET message = '$msg'";
		if(!$silent)
			$sql .= ', edited = UNIX_TIMESTAMP(), edited_by = "'.$_user['pseudo'].'" ';
		$sql .= " WHERE id = $pid ";
		$_sql->query($sql);
	}

	if($closed>=0 || $sticky>=0 || $title || $fid){ // éditer le topic
		if(!$tid) return false;

		if($fid){// /!\ déplacement topic : mettre à jour le nombre de sujets dans chaque forum /!\
			$sql = "SELECT last_poster, last_post, last_post_id, subject, forum_id, num_replies 
				FROM ".MYSQL_PREBDD_FRM."topics WHERE id = '$tid'";
			$donnees_topic = $_sql->make_array_result($sql);
	
			$sql = "SELECT last_post_id FROM ".MYSQL_PREBDD_FRM."forums 
				WHERE id = '{$donnees_topic['forum_id']}'";
			$tab = $_sql->make_array_result($sql);

			//on met à jour le forum de départ : le nb de posts / topics
			$sql = "UPDATE ".MYSQL_PREBDD_FRM."forums SET num_topics = num_topics-1, num_posts = num_posts - {$donnees_topic['num_replies']}";

			if ($donnees_topic['last_post_id'] == $tab['last_post_id'])
			{// si le post déplacé était le dernier sur ce forum, rechercher le précédent :
				$sql1 = "SELECT last_poster, last_post, last_post_id, subject 
					FROM ".MYSQL_PREBDD_FRM."topics 
					WHERE id <> $tid AND forum_id = {$donnees_topic['forum_id']}
					ORDER BY last_post DESC LIMIT 0,1";
				$donnees = $_sql->make_array_result($sql1);

				if($donnees) { // protÃ©ger les donnÃ©es : addslashes
					$donnees['subject'] = addslashes($donnees['subject']);
					$donnees['last_poster'] = addslashes($donnees['last_poster']);
					$sql .= ", last_post='{$donnees['last_post']}', last_post_id = '{$donnees['last_post_id']}',
							last_poster = '{$donnees['last_poster']}', last_subject = '{$donnees['subject']}'";
				}
			}
			$sql .= " WHERE id = {$donnees_topic['forum_id']}";
			$_sql->query($sql);

			//on met à jour le forum d'arrivé
			$donnees_topic['subject'] = addslashes($donnees_topic['subject']);
			$donnees_topic['last_poster'] = addslashes($donnees_topic['last_poster']);
			$sql = "UPDATE ".MYSQL_PREBDD_FRM."forums SET num_topics = num_topics +1, num_posts =  num_posts + '{$donnees_topic['num_replies']}', last_post='{$donnees_topic['last_post']}', ";
			$sql .= "last_post_id = '{$donnees_topic['last_post_id']}', last_poster = '{$donnees_topic['last_poster']}', last_subject = '{$donnees_topic['subject']}' WHERE id = $fid";
			$_sql->query($sql);
		}

		// UPDATE du topic
		$sql = 'UPDATE '.MYSQL_PREBDD_FRM.'topics SET ';
		$update = '';
		if($closed>=0) $update .= ', closed = '.($closed ?1:0).' ';
		if($sticky>=0) $update .= ', sticky = '.($sticky ?1:0).' ';
		if($title) $update .= ", subject = '$title' ";
		if($fid) $update .= ", forum_id = $fid ";
		$sql .= substr($update, 2) . " WHERE id = $tid";
		$_sql->query($sql);

	}// fin edition topic

	if($pid){//indexation pour la recherche!
		if($tid && $title)
			update_search_index('edit', $pid, $msg, $title);
		else
			update_search_index('edit', $pid, $msg);
	}

	return true;
}

function stick($tid, $stick = true){
	edit_post_gen(array('tid'=>$tid, 'sticky'=>$stick));
	return $stick;
}
function close($tid, $close = true){
	edit_post_gen(array('tid'=>$tid, 'closed'=>$close));
	return $close;
}




function add_tpc($pseudo,$pst_titre,$fid, $closed=0, $sticky=0)
{
	global $_sql;

	$pseudo = protect($pseudo, 'string');
	$pst_titre = protect($pst_titre,'string');
	$fid = protect($fid,'uint');

	$sql = "INSERT INTO ".MYSQL_PREBDD_FRM."topics (poster, subject, posted, last_post, last_poster, forum_id";
	if($closed) $sql .= ", closed";
	if($sticky) $sql .= ", sticky";
	$sql .= ") VALUES('$pseudo', '$pst_titre', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), '$pseudo', $fid";
	if($closed) $sql .= ", 1";
	if($sticky) $sql .= ", 1";
	$sql .= ')';
	$_sql->query($sql);
	return $_sql->insert_id();
}

function add_post($mid,$pseudo,$ip,$pst_msg,$tid)
{
	global $_sql;
	
	$pseudo = protect($pseudo, 'string');
	$ip = protect($ip,'string');
	$pst_msg = protect($pst_msg,'bbcode');
	$tid = protect($tid, 'uint');
	$mid = protect($mid, 'uint');
	
	$sql = "INSERT INTO ".MYSQL_PREBDD_FRM."posts (poster, poster_id, poster_ip, message, hide_smilies, posted, topic_id) ";
	$sql .= "VALUES('$pseudo', '$mid', '$ip', '$pst_msg', 0, UNIX_TIMESTAMP(), '$tid')";
	$_sql->query($sql);	
	return $_sql->insert_id();
}

function maj_all($pid,$pseudo,$tid,$fid,$topic,$mid,$subject,$msg)
{// MAJ suite à ajout d'un topic ou post (pas suite à edit ni delete)
	global $_sql;
	$pseudo = protect($pseudo, 'string');
	$pid = protect($pid, 'uint');
	$mid = protect($mid, 'uint');
	$tid = protect($tid, 'uint');
	$subject = protect($subject, 'string');

	//maj topics
	$sql = "UPDATE ".MYSQL_PREBDD_FRM."topics SET last_post = UNIX_TIMESTAMP(), last_post_id = '$pid', last_poster = '$pseudo' ";
	if(!$topic)
		$sql .= ", num_replies=num_replies+1 ";
	$sql .= "WHERE id = '$tid'";
	$_sql->query($sql);

	//maj forums
	$sql = "UPDATE ".MYSQL_PREBDD_FRM."forums SET num_posts = num_posts + 1, last_post = UNIX_TIMESTAMP(), ";
	if($topic)
		$sql .= " num_topics = num_topics + 1, ";
	$sql .= "last_post_id = '$pid', last_poster = '$pseudo', last_subject = '$subject' WHERE id = '$fid'";
	$_sql->query($sql);

	//maj users
	//$sql = "UPDATE ".MYSQL_PREBDD_FRM."users SET num_posts = num_posts + 1, last_post = '$pid' WHERE id = '$mid'";
	//$_sql->query($sql);

	//maj indexation recherche
	if($topic)
		update_search_index('edit', $pid, $msg, $subject);
	else
		update_search_index('edit', $pid, $msg);

}


function ajout_view($tid)
{
	global $_sql;
	protect($tid,'uint');

	$sql = "UPDATE ".MYSQL_PREBDD_FRM."topics SET num_views=num_views+1 WHERE id = '$tid'";

	$_sql->query($sql);
}

function search_page($pid,$tid,$num_posts,$limite_page)
{// rechercher à quelle page se trouve $pid dans $tid
	global $_sql;
	$tid = protect($tid,'uint');
	$sql = "SELECT Count(id)+1 AS cnt FROM ".MYSQL_PREBDD_FRM."posts WHERE topic_id = $tid AND id <= $pid ORDER BY id";
	$result = $_sql->make_array_result($sql);
	return ceil($result['cnt'] / $limite_page);
}


function del_post($pst, $tpc) 
{//efface le post; renvoie true si le topic a aussi été supprimé, false sinon
	global $_sql;

	// MAJ indexation recherche
	strip_search_index($pst['pid']);

	//on commence par mettre à  jour la table users
	$sql = "UPDATE ".MYSQL_PREBDD_FRM."users SET num_posts = num_posts - 1 WHERE id = {$pst['poster_id']}";
	$_sql->query($sql);

	//puis on supprime le post lui-même
	$sql = "DELETE FROM ".MYSQL_PREBDD_FRM."posts WHERE id = {$pst['pid']}";
	$_sql->query($sql);

	//on regarde si le topic n'avait qu'un seul message
	if ($tpc['num_replies'] == 1)
	{
		// on suprime le topic
		$sql = "DELETE FROM ".MYSQL_PREBDD_FRM."topics WHERE id = {$tpc['tid']}";
		$_sql->query($sql);

		if ($tpc['frm_last_post_id'] == $pst['pid'])
		{// si c'était aussi le dernier post du forum /!\
			$sql = "UPDATE ".MYSQL_PREBDD_FRM."forums AS f
			LEFT JOIN ".MYSQL_PREBDD_FRM."topics AS t ON t.forum_id = f.id
			SET f.num_topics = f.num_topics-1, f.num_posts = f.num_posts-1, f.last_post = t.last_post, 
			f.last_post_id = t.last_post_id, f.last_poster = t.last_poster, f.last_subject = t.subject 
			WHERE f.id = {$tpc['forum_id']} AND (t.id = (SELECT id FROM ".MYSQL_PREBDD_FRM."topics WHERE forum_id = {$tpc['forum_id']} ORDER BY t.last_post ASC LIMIT 0,1) OR t.id IS NULL)";
			$_sql->query($sql);
		}
		else
		{
			$sql = "UPDATE ".MYSQL_PREBDD_FRM."forums SET num_topics = num_topics - 1, num_posts = num_posts - 1 WHERE id = {$tpc['forum_id']}";
			$_sql->query($sql);
		}

		return true;
	}
	//si il y avait plusieurs messages : on ne supprime pas le topic
	else
	{
		//on met à  jour la table topics, en changeant le dernier post si il le faut
		if ($tpc['last_post_id'] == $pst['pid'])
		{
			$sql = "UPDATE ".MYSQL_PREBDD_FRM."topics AS t
			INNER JOIN ".MYSQL_PREBDD_FRM."posts AS p ON t.id = p.topic_id
			SET t.last_poster= p.poster, t.last_post = p.posted, t.last_post_id = p.id, t.num_replies = t.num_replies - 1 
			WHERE t.id = {$tpc['tid']} 
			AND p.id = (SELECT max(id) FROM ".MYSQL_PREBDD_FRM."posts WHERE topic_id = {$tpc['tid']})";
			$_sql->query($sql);
		}
		else
		{
			// on recherche le 1er post de la discussion (c'est p-e celui qu'on a supprimé)
			$sql = "SELECT Min(id) AS min_id FROM ".MYSQL_PREBDD_FRM."posts WHERE topic_id = {$tpc['tid']}";
			$min_id = $_sql->make_array_result($sql);

			if($min_id && $pst['pid'] < $min_id['min_id'])
			{// on met à jour le topic avec le nouveau 1er post
				$sql = "UPDATE ".MYSQL_PREBDD_FRM."topics AS t
				INNER JOIN ".MYSQL_PREBDD_FRM."posts AS p ON t.id = p.topic_id
				SET t.poster= p.poster, t.posted = p.posted, t.num_replies = t.num_replies - 1 
				WHERE t.id = {$tpc['tid']} AND p.id = {$min_id['min_id']}";
				$_sql->query($sql);
			}
			else
			{
				$sql = "UPDATE ".MYSQL_PREBDD_FRM."topics SET num_replies = num_replies - 1 WHERE id = {$tpc['tid']}";
				$_sql->query($sql);
			}
		}
		//on regarde si c'était le dernier message du forum
		if ($tpc['frm_last_post_id'] == $pst['pid'])
		{
			$sql = "UPDATE ".MYSQL_PREBDD_FRM."forums AS f
			LEFT JOIN ".MYSQL_PREBDD_FRM."topics AS t ON t.forum_id = f.id
			SET f.num_posts = f.num_posts-1, f.last_post = t.last_post, 
			f.last_post_id = t.last_post_id, f.last_poster = t.last_poster, f.last_subject = t.subject 
			WHERE f.id = {$tpc['forum_id']} AND (t.id = (SELECT max(id) FROM ".MYSQL_PREBDD_FRM."topics WHERE forum_id = {$tpc['forum_id']} ORDER BY t.last_post DESC LIMIT 0,1) OR t.id IS NULL)";
			$_sql->query($sql);
		}
		else
		{	
			$sql = "UPDATE ".MYSQL_PREBDD_FRM."forums SET num_posts = num_posts - 1 WHERE id = {$tpc['forum_id']}";
			$_sql->query($sql);
		}

		return false;	
	}

}



/***********************************/
/***  FONCTIONS  DE  RECHERCHE   ***/
/***********************************/

/***********************************************************************
  This file is part of PunBB.
  
 The contents of this file are very much inspired by the file functions_search.php
 from the phpBB Group forum software phpBB2 (http://www.phpbb.com).

 Now modified to work with zordania :p 
************************************************************************/


function search_user_id($id){// retrouver une recherche en cache
	global $_sql, $_user;
	$id = protect($id, 'uint');

	$row = $_sql->make_array('SELECT search_data FROM '.MYSQL_PREBDD_FRM.'search_cache 
	WHERE id='.$id.' AND ident=\''.protect($_user['pseudo'], 'string').'\'');
	if (!empty($row))
		return unserialize($row[0]['search_data']);
	else
		return false;
}

function add_search_user($search, $ident){// ajouter la recherche dans le cache
	global $_sql;
	// vider le cache des anciennes recherches
	//$_sql->query('DELETE FROM '. MYSQL_PREBDD_FRM .'search_cache WHERE ident NOT IN(SELECT ident FROM '. MYSQL_PREBDD_FRM .'online)');
	$_sql->query('DELETE FROM '. MYSQL_PREBDD_FRM .'search_cache WHERE ident NOT IN(SELECT ses_mid FROM '. MYSQL_PREBDD .'ses WHERE ses_mid <> 1)');

	$search_id = mt_rand(1, 2147483647);
	$_sql->query('INSERT INTO '.MYSQL_PREBDD_FRM.'search_cache (id, ident, search_data) 
	VALUES('.$search_id.', \''.protect($ident, 'string').'\', \''.mysql_real_escape_string(serialize($search)).'\')');
	return $search_id;
}


// construire la liste des résultats pour les mots clés recherchés
function search_keywords_results($keywords, $search_in){
	global $_sql, $_tpl;

	$stopwords = (array)file($_tpl->var->tpl->dir2.$_tpl->var->tpl->dir.$_tpl->var->tpl->lang.'/modules/forum/stopwords.txt');
	$stopwords = array_map('trim', $stopwords);

	// filtrer caractères non alphabétiques
	$noise_match = array('^', '$', '&', '(', ')', '<', '>', '`', '\'', '"', '|', ',', '@', '_', '?', '%', '~', '[', ']', '{', '}', ':', '\\', '/', '=', '#', '\'', ';', '!');

	$noise_replace = array(' ', ' ', ' ', ' ', ' ', ' ', ' ', '',  '',   ' ', ' ', ' ', ' ', '',  ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '' ,  ' ', ' ', ' ', ' ',  ' ', ' ');
	$keywords = str_replace($noise_match, $noise_replace, $keywords);

	// supprimer espaces multiples
	$keywords = trim(preg_replace('#\s+#', ' ', $keywords));

	// remplir un tableau des mots clés
	$keywords_array = explode(' ', $keywords);

	if (empty($keywords_array))
		{$_tpl->set('no_hits', true); return false;}

	foreach($keywords_array as $i => $word)
	{
		$num_chars = strlen($word);
		if ($num_chars < 3 || $num_chars > 20 || in_array($word, $stopwords))
			unset($keywords_array[$i]);
	}

	// recherche dans le texte ou uniquement le sujet ?
	$search_in_cond = ($search_in) ? (($search_in > 0) ? ' AND m.subject_match = 0' : ' AND m.subject_match = 1') : '';

	$word_count = 0;
	$match_type = 'and';
	$result_list = array();
	@reset($keywords_array);
	while (list(, $cur_word) = @each($keywords_array))
	{
		switch ($cur_word)
		{
			case 'and':
			case 'or':
			case 'not':
				$match_type = $cur_word;
				break;

			default:
			{
				$cur_word = str_replace('*', '%', $cur_word);
				$sql = 'SELECT m.post_id FROM '.MYSQL_PREBDD_FRM.'search_words AS w INNER JOIN '.MYSQL_PREBDD_FRM.'search_matches AS m ON m.word_id = w.id WHERE w.word LIKE \''.$cur_word.'\''.$search_in_cond;

				$result = $_sql->make_array($sql);

				$row = array();
				foreach($result as $key => $temp)
				{
					$row[$temp['post_id']] = 1;

					if (!$word_count)
						$result_list[$temp['post_id']] = 1;
					else if ($match_type == 'or')
						$result_list[$temp['post_id']] = 1;
					else if ($match_type == 'not')
						$result_list[$temp['post_id']] = 0;
				}

				if ($match_type == 'and' && $word_count)
				{
					@reset($result_list);
					foreach($result_list as $post_id => $value)
						if (!isset($row[$post_id]))
							$result_list[$post_id] = 0;
				}

				++$word_count;
				break;
			}
		}// fin switch
	}// fin foreach

	@reset($result_list);
	$keyword_results = array();
	while (list($post_id, $matches) = @each($result_list))
		if ($matches)
			$keyword_results[] = $post_id;

	return $keyword_results;
}

// construire la liste des résultats pour l'auteur recherché
function search_author_results($author){
	global $_sql;
	$author = protect($author, 'string');

	$result = $_sql->make_array('SELECT id FROM '.MYSQL_PREBDD_FRM.'posts 
	WHERE poster_id IN(SELECT id 
			FROM '.MYSQL_PREBDD_FRM.'users WHERE username LIKE \''.$author.'\')');

	$search_ids = array();
	foreach ($result as $row)
		$author_results[] = $row['id'];
	return $author_results;
}


//
// "Cleans up" a text string and returns an array of unique words
// This function depends on the current locale setting
//
function split_words($text)
{
	global $_tpl;
	static $noise_match, $noise_replace, $stopwords;

	if (empty($noise_match))
	{
		$noise_match = 		array('[quote', '[code', '[url', '[img', '[email', '[color', '[colour', 'quote]', 'code]', 'url]', 'img]', 'email]', 'color]', 'colour]', '^', '$', '&', '(', ')', '<', '>', '`', '\'', '"', '|', ',', '@', '_', '?', '%', '~', '+', '[', ']', '{', '}', ':', '\\', '/', '=', '#', ';', '!', '*');
		$noise_replace =	array('',       '',      '',     '',     '',       '',       '',        '',       '',      '',     '',     '',       '',       '',        ' ', ' ', ' ', ' ', ' ', ' ', ' ', '',  '',   ' ', ' ', ' ', ' ', '',  ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '' ,  ' ', ' ', ' ', ' ', ' ', ' ');

		$stopwords = (array)file($_tpl->var->tpl->dir2.$_tpl->var->tpl->dir.$_tpl->var->tpl->lang.'/modules/forum/stopwords.txt');
		$stopwords = array_map('trim', $stopwords);
	}

	// Clean up
	$patterns[] = '#&[\#a-z0-9]+?;#i';
	$patterns[] = '#\b[\w]+:\/\/[a-z0-9\.\-]+(\/[a-z0-9\?\.%_\-\+=&\/~]+)?#';
	$patterns[] = '#\[\/?[a-z\*=\+\-]+(\:?[0-9a-z]+)?:[a-z0-9]{10,}(\:[a-z0-9]+)?=?.*?\]#';
	$text = preg_replace($patterns, ' ', ' '.strtolower($text).' ');

	// Filter out junk
	$text = str_replace($noise_match, $noise_replace, $text);

	// Strip out extra whitespace between words
	$text = trim(preg_replace('#\s+#', ' ', $text));

	// Fill an array with all the words
	$words = explode(' ', $text);

	if (!empty($words))
	{
		while (list($i, $word) = @each($words))
		{
			$words[$i] = trim($word, '.');
			$num_chars = strlen($word);

			if ($num_chars < 3 || $num_chars > 20 || in_array($word, $stopwords))
				unset($words[$i]);
		}
	}

	return array_unique($words);
}


//
// Updates the search index with the contents of $post_id (and $subject)
//
function update_search_index($mode, $post_id, $message, $subject = null)
{
	global $_sql;

	// Split old and new post/subject to obtain array of 'words'
	$words_message = split_words($message);
	$words_subject = ($subject) ? split_words($subject) : array();

	if ($mode == 'edit')
	{
		$result = $_sql->make_array('SELECT w.id, w.word, m.subject_match FROM '.MYSQL_PREBDD_FRM.'search_words AS w INNER JOIN '.MYSQL_PREBDD_FRM.'search_matches AS m ON w.id=m.word_id WHERE m.post_id='.$post_id);

		// Declare here to stop array_keys() and array_diff() from complaining if not set
		$cur_words['post'] = array();
		$cur_words['subject'] = array();

		foreach ($result as $row)
		{
			$match_in = ($row['subject_match']) ? 'subject' : 'post';
			$cur_words[$match_in][$row['word']] = $row['id'];
		}

		$words['add']['post'] = array_diff($words_message, array_keys($cur_words['post']));
		$words['add']['subject'] = array_diff($words_subject, array_keys($cur_words['subject']));
		$words['del']['post'] = array_diff(array_keys($cur_words['post']), $words_message);
		$words['del']['subject'] = array_diff(array_keys($cur_words['subject']), $words_subject);
	}
	else
	{
		$words['add']['post'] = $words_message;
		$words['add']['subject'] = $words_subject;
		$words['del']['post'] = array();
		$words['del']['subject'] = array();
	}

	unset($words_message);
	unset($words_subject);

	// Get unique words from the above arrays
	$unique_words = array_unique(array_merge($words['add']['post'], $words['add']['subject']));

	if (!empty($unique_words))
	{
		$result = $_sql->make_array('SELECT id, word FROM '.MYSQL_PREBDD_FRM.'search_words WHERE word IN('.implode(',', preg_replace('#^(.*)$#', '\'\1\'', $unique_words)).')');

		$word_ids = array();
		foreach ($result as $row)
			$word_ids[$row['word']] = $row['id'];

		$new_words = array_diff($unique_words, array_keys($word_ids));
		unset($unique_words);

		if (!empty($new_words))
			$_sql->query('INSERT INTO '.MYSQL_PREBDD_FRM.'search_words (word) VALUES'.implode(',', preg_replace('#^(.*)$#', '(\'\1\')', $new_words)));

		unset($new_words);
	}

	// Delete matches (only if editing a post)
	while (list($match_in, $wordlist) = @each($words['del']))
	{
		$subject_match = ($match_in == 'subject') ? 1 : 0;

		if (!empty($wordlist))
		{
			$sql = '';
			while (list(, $word) = @each($wordlist))
				$sql .= (($sql != '') ? ',' : '').$cur_words[$match_in][$word];

			$_sql->query('DELETE FROM '.MYSQL_PREBDD_FRM.'search_matches WHERE word_id IN('.$sql.') AND post_id='.$post_id.' AND subject_match='.$subject_match);
		}
	}

	// Add new matches
	while (list($match_in, $wordlist) = @each($words['add']))
	{
		$subject_match = ($match_in == 'subject') ? 1 : 0;

		if (!empty($wordlist))
			$_sql->query('INSERT INTO '.MYSQL_PREBDD_FRM.'search_matches (post_id, word_id, subject_match) SELECT '.$post_id.', id, '.$subject_match.' FROM '.MYSQL_PREBDD_FRM.'search_words WHERE word IN('.implode(',', preg_replace('#^(.*)$#', '\'\1\'', $wordlist)).')');
	}

	unset($words);
}


//
// Strip search index of indexed words in $post_ids
//
function strip_search_index($post_ids)
{
	global $_sql;

	$result = $_sql->make_array('SELECT word_id FROM '.MYSQL_PREBDD_FRM.'search_matches WHERE post_id IN('.$post_ids.') GROUP BY word_id');

	if (!empty($result))
	{
		$word_ids = '';
		foreach ($result as $row)
			$word_ids .= ($word_ids != '') ? ','.$row['word_id'] : $row['word_id'];

		$result = $_sql->make_array('SELECT word_id FROM '.MYSQL_PREBDD_FRM.'search_matches WHERE word_id IN('.$word_ids.') GROUP BY word_id HAVING COUNT(word_id)=1');

		if (!empty($result))
		{
			$word_ids = '';
			foreach ($result as $row)
				$word_ids .= ($word_ids != '') ? ','.$row['word_id'] : $row['word_id'];

			$_sql->query('DELETE FROM '.MYSQL_PREBDD_FRM.'search_words WHERE id IN('.$word_ids.')');
		}
	}

	$_sql->query('DELETE FROM '.MYSQL_PREBDD_FRM.'search_matches WHERE post_id IN('.$post_ids.')');
}
//*****     FIN DES FONCTIONS dédiées à la recherche     ******

?>
