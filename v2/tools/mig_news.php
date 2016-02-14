<?php
/* 
  migration des news des tables nws et cmt vers les tables du forum
  il faut créer d'abord la catégorie, et le forum dédié
*/
define('NEWS_FRM_ID',30); // le "fid" du forum dédié
error_reporting (E_ALL | E_STRICT | E_RECOVERABLE_ERROR);
date_default_timezone_set("Europe/Paris");
define("_INDEX_",true);
echo "<h3>debut migration des news</h3>\n";

require_once("../conf/conf.inc.php");

require_once(SITE_DIR . "lib/mysql.class.php");
require_once(SITE_DIR . 'lib/divers.lib.php');
require_once(SITE_DIR . 'lib/parser.lib.php');

function inserer_posts($sql) {
	global $_sql;

	$sql = 'INSERT INTO zrd_frm_posts (poster, poster_id, poster_ip, message, posted, topic_id) VALUES '.substr($sql,1).';';
	if($_sql->query($sql)) {
		return $_sql->affected_rows();
	} else {
		return false;
	}
}

$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(true);
?>
<pre><?php
// virer l'existant
$_sql->query('DELETE FROM zrd_frm_posts WHERE topic_id IN (SELECT id FROM zrd_frm_topics WHERE forum_id = '.NEWS_FRM_ID.')');
echo "DEL POSTS = ".$_sql->affected_rows()."\n";
$_sql->query('DELETE FROM zrd_frm_topics WHERE forum_id = '.NEWS_FRM_ID);
echo "DEL TOPICS = ".$_sql->affected_rows()."\n";

// SELECT toutes les news
$sql = 'SELECT nws_nid FROM zrd_nws ORDER BY nws_nid';
$nid_array = $_sql->make_array($sql);
$nb_nws = 0;
$nb_pst2 = 0;

foreach($nid_array as $tmp)
{
	$nid = $tmp['nws_nid'];
	// générer la news
	$sql = "INSERT INTO zrd_frm_topics (id, poster, subject, posted, closed, forum_id)
		SELECT NULL, IFNULL(mbr_pseudo,'visiteur'), nws_titre, UNIX_TIMESTAMP(nws_date), nws_closed, ".NEWS_FRM_ID.
		" FROM zrd_nws
		LEFT JOIN zrd_mbr ON nws_mid = mbr_mid
		WHERE nws_nid = $nid";
	$res = $_sql->query($sql);
	// récupérer son ID
	$tid = $_sql->insert_id();
	$nb_pst = 0;

	if($tid){
		/* ajouter tous les commentaires. il faut les parser! */
		$sql = "SELECT IFNULL(mbr_pseudo,'visiteur') AS mbr_pseudo, nws_mid, mbr_lip, nws_texte, UNIX_TIMESTAMP(nws_date) AS cmt_date
			FROM zrd_nws
			LEFT JOIN zrd_mbr ON nws_mid = mbr_mid WHERE nws_nid = $nid
		UNION
			SELECT IFNULL(mbr_pseudo,'visiteur'), cmt_mid, cmt_ip, cmt_texte, UNIX_TIMESTAMP(cmt_date)
			FROM zrd_cmt LEFT JOIN zrd_mbr ON cmt_mid = mbr_mid WHERE cmt_nid = $nid";
		$post_array = $_sql->make_array($sql);
		$sql = '';
		$nb_ins = 0;
		foreach($post_array as $post){
			$sql .= ",\n('".addslashes($post['mbr_pseudo'])."', {$post['nws_mid']}, '{$post['mbr_lip']}', '".
				html_entity_decode(addslashes(unparse(str_replace("http://v2.zordania.com/","",$post['nws_texte']), true)))
				."', {$post['cmt_date']}, $tid)";
			$nb_ins++;
			$nb_pst++;
			if($nb_ins >= 15){
				if(!inserer_posts($sql)){
					echo "ERR POSTS($nid) : " .$_sql->errno." | ".$_sql->err."\n";
					break 2;
				}
				$nb_ins = 0;
				$sql = '';
			}
		}
		if($nb_ins)
			if(!inserer_posts($sql))
				break;
		echo "OK = $nb_pst\n";
		$nb_pst2 += $nb_pst;
	}else
		echo "ERR TOPIC($nid) : " .$_sql->errno." | ".$_sql->err."\n";

	$nb_nws++;
} /* foreach $mid */

echo "$nb_nws TOPICS (news) ajoutees dont $nb_pst2 commentaires\n";

$_sql->query("UPDATE zrd_frm_topics AS a
INNER JOIN zrd_frm_posts AS b ON a.id = b.topic_id
SET a.last_poster = b.poster, a.last_post_id = b.id, a.last_post = b.posted,
  a.num_replies = (SELECT count(c.id) FROM zrd_frm_posts AS c WHERE c.topic_id = a.id)
WHERE a.forum_id = ".NEWS_FRM_ID." AND b.id = (
  SELECT max( id ) -- , count( id )
  FROM zrd_frm_posts
  WHERE topic_id = a.id
)");
echo "TOPIC : nb de topics = ".$_sql->affected_rows()."\n";

$_sql->query('UPDATE zrd_frm_forums AS f
LEFT JOIN zrd_frm_topics AS t ON f.id = t.forum_id AND f.id = '.NEWS_FRM_ID.'
SET f.num_topics = (SELECT COUNT(t1.id) FROM zrd_frm_topics AS t1 WHERE t1.forum_id = f.id GROUP BY t1.forum_id),
  f.num_posts = (SELECT SUM(t2.num_replies) FROM zrd_frm_topics AS t2 WHERE t2.forum_id = f.id GROUP BY t2.forum_id),
  f.last_post = t.last_post,
  f.last_post_id = t.last_post_id,
  f.last_poster = t.last_poster,
  f.last_subject = t.subject
WHERE
  t.posted = (SELECT MAX(t3.posted) FROM zrd_frm_topics AS t3 WHERE f.id = t3.forum_id)');
echo "FORUM : nb de topics = ".$_sql->affected_rows()."\n";

$nb = count($_sql->queries);
echo "$nb requetes\n";
var_dump($_sql->queries[$nb-1]);
var_dump($_sql->queries[$nb]);
?></pre>
