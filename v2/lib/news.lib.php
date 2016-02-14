<?

function add_news($mid, $titre, $texte, $etat, $lang, $cat, $closed)//ajoute une news
//add_news(2, '192.168.0.1', 'mon titre', 'mon texte', 3, 'fr') rajoute une news francaise en post it
//de mid 2, d'ip 192.168.0.1, de titre 'mon titre' et de texte 'mon texte'
{
	global $_sql;
	
	$mid = protect($mid, "uint");
	$titre = protect($titre, "string");
	$texte = protect($texte, "bbcode");
	$etat = protect($etat, "uint");
	$lang = protect($lang, "string");
	$cat = protect($cat, "uint");
	$closed = protect($closed, "uint");
	
	$req = "INSERT INTO ".$_sql->prebdd."nws ";
	$req.= "VALUES('','$mid','$cat','$etat','$lang','$titre',NOW(),'$texte','$closed')";
	return $_sql->query($req);
}

function del_news($nid) //supprime une news
//del_news(3) supprime la news numero 3
{
	global $_sql;
	
	$nid = protect($nid, "uint");
	
	$req = "DELETE FROM ".$_sql->prebdd."nws WHERE nws_nid=$nid";
	$_sql->query($req);
	$nb = $_sql->affected_rows();
	
	$req = "DELETE FROM ".$_sql->prebdd."cmt WHERE cmt_nid=$nid";
	$_sql->query($req);
	return $nb + $_sql->affected_rows();
}

function edit_news($nid, $new) //edite une news
//edit_cmt(2, array('mid' => 2, 'ip' => '192.168.0.1', 'texte' => 'ma news')) edite la news numero 19 en news du membre numero 2
//ip = 192.168.0.1 et texte = 'ma news'
//edit_cmt(2, array('texte' => 'nouveau texte', titre => 'nouveau titre')) => edite le texte de la news numero 19 en 'nouveau texte' et son titre en 'nouveau titre'
{
	global $_sql;
	
	$nid = protect($nid, "uint");
	$req = "UPDATE ".$_sql->prebdd."nws SET ";
	if (isset($new['mid'])) {
		$mid = protect($new['mid'], "uint");
		$req .= "nws_mid='$mid',";
	}
	if (isset($new['etat'])) {
		$etat = protect($new['etat'], "uint");
		$req .= "nws_etat='$etat',";
	}
	if (isset($new['cat'])) {
		$cat = protect($new['cat'], "uint");
		$req .= "nws_cat='$cat',";
	}
	if (isset($new['closed'])) {
		$closed = protect($new['closed'], "uint");
		$req .= "nws_closed='$closed',";
	}
	if (isset($new['titre'])) {
		$titre = protect($new['titre'], "string");
		$req .= "nws_titre='$titre',";
	}
	if (isset($new['lang'])) {
		$lang = protect($new['lang'], "string");
		$req .= "nws_lang='$lang',";
	}
	if (isset($new['texte'])) {
		$texte = protect($new['texte'], "bbcode");
		$req .= "nws_texte='$texte',";
	}
	$req = substr($req, 0, strlen($req) - 1)." WHERE nws_nid='$nid'";
	
	return $_sql->query($req);
}

function get_nb_news($lang = "",$cat = 0) //retourne le nombre de news de langue '$lang' presentes dans la bdd
//get_nb_news() => nb news total
//get_nb_news('en') => nb news anglaises
{
	global $_sql;
	
	$req = "SELECT COUNT(*) FROM ".$_sql->prebdd."nws WHERE nws_etat > 1";
	if ($lang) {
		$lang = protect($lang, "string");
		$req .= " AND nws_lang='$lang'";
	}
	if($cat) {
		$cat = protect($cat, "uint");
		$req .= " AND nws_cat= $cat";
	} 
	$res = $_sql->query($req);
	return $_sql->result($res, 0);
}

function get_news($etat, $nid_or_limit1, $limit2 = 0, $lang = "", $cat = 0) //renvoit un tableau des $limit2 news uand son etat est strictement superieur a $etat,
//a partir de $limit1 de langue $lang ou bien la news numero $nid
//get_news(1, 5, 15, 'fr') => les 15 news francaises d'etat superieur a 1 a partir du rang 5
//get_news(1, 27) => la news numero 27 si son etat est superieur a 1
//get_news(0, 27) => la news numero 27
//get_news(0, 5, 15, 'fr') => les 15 news francaises a partir du rang 5
//get_news(2, 27) => la news numero 27 si elle est en post it
{
	global $_sql;
	
	$etat = protect($etat, "uint");
	$limit1 = protect($nid_or_limit1, "uint");
	$limit2 = protect($limit2, "uint");
	$lang = protect($lang, "string");
	$cat = protect($cat, "uint");

	$req = "SELECT nws_nid,nws_mid,nws_titre,nws_lang,nws_etat,nws_cat";
	$req.= "_DATE_FORMAT(nws_date) as nws_date_formated,nws_texte";
	$req.= "nws_date,";
	$req.= "COUNT(cmt_cid) as nb_cmt,mbr_pseudo,mbr_gid,nws_closed ";
	$req.= "FROM ".$_sql->prebdd."nws ";
	$req.= "LEFT JOIN ".$_sql->prebdd."cmt ON nws_nid=cmt_nid ";
	$req.= "JOIN ".$_sql->prebdd."mbr ON mbr_mid=nws_mid ";
	$req.= "WHERE mbr_etat = ".MBR_ETAT_OK;
	if($etat || $lang || $cat || !$limit2) {
		$req.= " AND ";
		if ($etat > 0)
			$req .= "nws_etat > $etat AND ";
		if($lang)
			$req .= "nws_lang='$lang' AND ";
		if($cat)
			$req .= "nws_cat=$cat AND "; 

		if(!$limit2) {
			$nid = protect($nid_or_limit1, "uint");
			$req .= "nws_nid=$nid AND ";
		}
		$req = substr($req, 0, strlen($req) - 4);
	}


	$req.= " GROUP BY nws_nid ";

	if ($limit2) {
		$req.= "ORDER BY ";
		if ($etat)
			$req .= "nws_etat DESC";
		$req.= "nws_date DESC ";
		$req.= "LIMIT $limit1, $limit2";
	}
	return $_sql->make_array($req);
}

function search_news($lang, $match) //cherche $match dans le titre et le texte des news de langue $lang
//cf doc mysql fulltext pour avoir les possibilites boolennes de $match
//search_news('fr', 'mysql') cherche dans les news francaises le mot "mysql"
{
	global $_sql;
	
	$match = protect($match, "string");
	$lang = protect($lang, "string");
	
	$req = "SELECT nws_nid,nws_titre,nws_texte,nws_mid,mbr_pseudo FROM ".$_sql->prebdd."nws ";
	$req .= "LEFT JOIN ".$_sql->prebdd."mbr ON mbr_mid=nws_mid ";
	$req .= "WHERE MATCH(nws_titre,nws_texte) AGAINST('$match') AND nws_lang='$lang' AND nws_etat > 1";
	return $_sql->make_array($req);
}
	
function add_cmt($nid, $mid, $ip, $texte) //ajoute un commentaire
//add_cmt(4, 2, '192.168.0.1', 'mon commentaire') rajoute le commentaire du membre numero 2 dans la news numero 4
//ip = 192.168.0.1 et texte = 'mon commentaire'
{
	global $_sql;
	
	$nid = protect($nid, "uint");
	$mid = protect($mid, "uint");
	$ip = protect($ip, "string");

	$texte = protect($texte, "bbcode");
	$req = "INSERT INTO ".$_sql->prebdd."cmt VALUES('',$nid,$mid,NOW(),'$texte','$ip')";
	return $_sql->query($req);
}
	
function del_cmt($cid) //supprime un commentaire
//del_cmt(19) supprime le commentaire numero 19
{
	global $_sql;
	
	$cid = protect($cid, "uint");
	$req = "DELETE FROM ".$_sql->prebdd."cmt WHERE cmt_cid=$cid";
	return $_sql->query($req);
}

function edit_cmt($cid, $new) //edite un commentaire
//edit_cmt(19, array('nid' => 4, 'mid' => 2, 'ip' => '192.168.0.1', 'texte' => 'mon commentaire')) edite le commentaire numero 19 en commentaire du membre numero 2 dans la news numero 4
//ip = 192.168.0.1 et texte = 'mon commentaire'
//edit_cmt(19, array('texte' => 'nouveau texte')) => edite le texte du commentaire numero 19 en 'nouveau texte'
{
	global $_sql;

	$cid = protect($cid, "uint");
	$req = "UPDATE ".$_sql->prebdd."cmt SET ";
	if (isset($new['mid'])) {
		$mid = protect($new['mid'], "uint");
		$req .= "cmt_mid=$mid,";
	}
	if (isset($new['ip'])) {
		$ip = protect($new['ip'], "string");
		$req .= "cmt_ip='$ip',";
	}
	if (isset($new['texte'])) {
		$texte = protect($new['texte'], "bbcode");
		$req .= "cmt_texte='$texte',";
	}
	$req = substr($req, 0, strlen($req) - 1)." WHERE cmt_cid=$cid"; 
	return $_sql->query($req);
}

function get_cmt($nid) //renvoit un tableau des commentaires d'une news $nid
//get_cmt(4) renvoit les commentaires de la news numero 4
{
	global $_sql;
	
	$nid = protect($nid, "uint");
	$req = "SELECT cmt_cid,cmt_mid,cmt_texte,cmt_ip,mbr_pseudo,mbr_gid";
	$req .= "_DATE_FORMAT(cmt_date) as cmt_date_formated ";
	$req .= "FROM ".$_sql->prebdd."cmt ";
	$req .= " JOIN ".$_sql->prebdd."mbr ON mbr_mid = cmt_mid WHERE cmt_nid=$nid ";
	$req .= "ORDER BY cmt_date DESC";
	return $_sql->make_array($req);
}

function get_one_cmt($cid) //renvoit le tableau d'un commentaire
//get_one_cmt(21) => commentaire numero 21
{
	global $_sql;

	$cid = protect($cid, "uint");
	$req = "SELECT cmt_cid,cmt_mid,cmt_nid,cmt_texte,cmt_ip,mbr_pseudo";
	$req .= "_DATE_FORMAT(cmt_date) as cmt_date ";
	$req .= "FROM ".$_sql->prebdd."cmt ";
	$req .= "LEFT JOIN ".$_sql->prebdd."mbr ON mbr_mid=cmt_mid WHERE cmt_cid=$cid";
	return $_sql->make_array($req);
}

function has_cmt($ip = 0, $mid = 0) //retourne 0 si l'ip et/ou le mid n'a pas poste de commentaires depuis un certain emps
//has_cmt(0, 19) => regarde avec mid = 19
//has_cmt(192.168.0.1, 0) => regarde avec ip = 192.168.0.1
//has_cmt(192.168.0.1, 19) => regarde avec ip = 192.168.0.1 et mid = 19
{
	global $_sql;
	
	$ip = protect($ip, "string");
	$mid = protect($mid, "uint");
	$req = "SELECT COUNT(*) FROM ".$_sql->prebdd."cmt WHERE cmt_date > (NOW()- INTERVAL ".SITE_FLOOD_TIME." SECOND) ";
	if ($ip)
		$req .= " AND cmt_ip='$ip'";
	if ($mid)
		$req .= " AND cmt_mid='$mid'";

	$res = $_sql->query($req);
	return $_sql->result($res, 0);
}
?>
