<?
class news
{
//nid = news-id
//cid = commentaire-id
//mid = membre-id
//mid -1 = anonyme
//etat 1 = news en attente de validation
//etat 2 = news normale
//etat 3 = news en post-it
//lang est une chaine de 2 lettres comme 'fr', 'en', 'it' ...
var $sql, $flood_time, $prs;

    function news(&$db)
    {
    $this->sql = &$db; //objet de la classe mysql
    $this->flood_time = SITE_FLOOD_TIME; //temps de latence minimum entre 2 actions, format HHMMSS
    }
    
    function add_news($mid, $ip, $titre, $texte, $etat, $lang, $cat, $closed)//ajoute une news
    //add_news(2, '192.168.0.1', 'mon titre', 'mon texte', 3, 'fr') rajoute une news francaise en post it
    //de mid 2, d'ip 192.168.0.1, de titre 'mon titre' et de texte 'mon texte'
    {
    $mid = (int) $mid;
    $ip = htmlentities($ip, ENT_QUOTES);
    $titre = htmlentities($titre, ENT_QUOTES);
    $texte = parser::parse($texte);
    $etat = (int) $etat;
    $lang = htmlentities($lang, ENT_QUOTES);
    $cat = (int) $cat;
    $closed = (int) $closed;
    $req = "INSERT INTO ".$this->sql->prebdd."nws VALUES('','$mid','$cat','$etat','$ip','$lang','$titre',NOW(),'$texte','$closed')";
    return $this->sql->query($req);
    }
    
    function del_news($nid) //supprime une news
    //del_news(3) supprime la news numero 3
    {
    $nid = (int) $nid;
    $req = "DELETE FROM ".$this->sql->prebdd."nws WHERE nws_nid='$nid'";
    $this->sql->query($req);
    $req = "DELETE FROM ".$this->sql->prebdd."cmt WHERE cmt_nid='$nid'";
    return $this->sql->query($req);
    }
    
    function edit_news($nid, $new) //edite une news
    //edit_cmt(2, array('mid' => 2, 'ip' => '192.168.0.1', 'texte' => 'ma news')) edite la news numero 19 en news du membre numero 2
    //ip = 192.168.0.1 et texte = 'ma news'
    //edit_cmt(2, array('texte' => 'nouveau texte', titre => 'nouveau titre')) => edite le texte de la news numero 19 en 'nouveau texte' et son titre en 'nouveau titre'
    {
    $nid = (int) $nid;
    $req = "UPDATE ".$this->sql->prebdd."nws SET ";
        if (isset($new['mid']))
        {
        $mid = (int) $new['mid'];
        $req .= "nws_mid='$mid',";
        }
        if (isset($new['etat']))
        {
        $etat = (int) $new['etat'];
        $req .= "nws_etat='$etat',";
        }
        if (isset($new['cat']))
        {
        $cat = (int) $new['cat'];
        $req .= "nws_cat='$cat',";
        }
        if (isset($new['closed']))
        {
        $closed = (int) $new['closed'];
        $req .= "nws_closed='$closed',";
        }
        if (isset($new['ip']))
        {
        $ip = htmlentities($new['ip'], ENT_QUOTES);
        $req .= "nws_ip='$ip',";
        }
        if (isset($new['titre']))
        {
        $titre = htmlentities($new['titre'], ENT_QUOTES);
        $req .= "nws_titre='$titre',";
        }
        if (isset($new['lang']))
        {
        $lang = htmlentities($new['lang'], ENT_QUOTES);
        $req .= "nws_lang='$lang',";
        }
        if (isset($new['texte']))
        {
        $texte = parser::parse($new['texte'], true);
        $req .= "nws_texte='$texte',";
        }
    $req = substr($req, 0, strlen($req) - 1)." WHERE nws_nid='$nid'";    
    return $this->sql->query($req);
    }
    
    function get_nb_news($lang = 0,$cat = 0) //retourne le nombre de news de langue '$lang' presentes dans la bdd
    //get_nb_news() => nb news total
    //get_nb_news('en') => nb news anglaises
    {
    $req = "SELECT COUNT(*) FROM ".$this->sql->prebdd."nws WHERE nws_etat > 1";
        if ($lang)
        {
        $lang = htmlentities($lang, ENT_QUOTES);    
        $req .= " AND nws_lang='$lang'";
        }
        if($cat)
        {
        $cat = htmlentities($cat, ENT_QUOTES);    
        $req .= " AND nws_cat='$cat'";
        }       
    $res = $this->sql->query($req);
    return mysql_result($res, 0);    
    }
    
    function has_news($ip = 0, $mid = 0) //retourne 0 si l'ip et/ou le mid n'a pas poste de news depuis un certain temps
    //has_news(0, 19) => regarde avec mid = 19
    //has_news(192.168.0.1, 0) => regarde avec ip = 192.168.0.1
    //has_news(192.168.0.1, 19) => regarde avec ip = 192.168.0.1 et mid = 19
    {
    $ip = htmlentities($ip, ENT_QUOTES);
    $mid = (int) $mid;
    $req = "SELECT COUNT(*) FROM ".$this->sql->prebdd."nws WHERE nws_date > (NOW()- INTERVAL ".$this->flood_time." SECOND) ";
        if ($ip)
        $req .= " AND nws_ip='$ip'";
        if ($mid)
        $req .= " AND nws_mid='$mid'";

    $res = $this->sql->query($req);
    return mysql_result($res, 0);     
    }
    
    function get_news($etat, $nid_or_limit1, $limit2 = 0, $lang = 0, $cat = 0) //renvoit un tableau des $limit2 news quand son etat est strictement superieur a $etat,
    //a partir de $limit1 de langue $lang ou bien la news numero $nid
    //get_news(1, 5, 15, 'fr') => les 15 news francaises d'etat superieur a 1 a partir du rang 5
    //get_news(1, 27) => la news numero 27 si son etat est superieur a 1
    //get_news(0, 27) => la news numero 27
    //get_news(0, 5, 15, 'fr') => les 15 news francaises a partir du rang 5
    //get_news(2, 27) => la news numero 27 si elle est en post it
    {
    $etat = (int) $etat;
        if ($limit2)
        {
        $limit1 = (int) $nid_or_limit1;
        $limit2 = (int) $limit2;
        $lang = htmlentities($lang, ENT_QUOTES);
        $cat = (int) $cat;
        }
    $req = "SELECT nws_nid,nws_mid,nws_ip,nws_titre,nws_lang,nws_etat,nws_cat,";
    $req.="formatdate(nws_date) as nws_date_formated,nws_texte,";
    $req .= "COUNT(cmt_cid) as nb_cmt,mbr_pseudo,mbr_gid,nws_closed ";
    $req .= "FROM ".$this->sql->prebdd."nws ";
    $req .= "LEFT JOIN ".$this->sql->prebdd."cmt ON nws_nid=cmt_nid ";
    $req .= "LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid=nws_mid ";
        
        if ($etat > 0)
        $req .= "WHERE nws_etat > '$etat'";
        
        if ($lang OR $cat)
        {
            if ($etat > 0)
            {
            	if($lang) $req .= " AND nws_lang='$lang' ";
            	if($cat) $req .= " AND nws_cat='$cat' "; 
            }
            else
            {
            	if($lang) $req .= "WHERE nws_lang='$lang' ";
            	if($cat) $req .= "WHERE nws_cat='$cat' ";
            }
        }
        elseif (!$limit2)
        {
        $nid = (int) $nid_or_limit1;
            if ($etat > 0)
            $req .= " AND nws_nid='$nid' ";
            else
            $req .= "WHERE nws_nid='$nid' ";
        }
    	
    	$req .= "GROUP BY nws_nid ";
        if ($limit2)
        {
        $req .= "ORDER BY ";
            if ($etat ==! 0)
            $req .= "nws_etat DESC,";
        $req .= "nws_date DESC LIMIT $limit1, $limit2";
        }
    return $this->sql->make_array($req);
    }
    
    function search_news($lang, $match) //cherche $match dans le titre et le texte des news de langue $lang
    //cf doc mysql fulltext pour avoir les possibilites boolennes de $match
    //search_news('fr', 'mysql') cherche dans les news francaises le mot "mysql"
    {
    $match = htmlentities($match, ENT_QUOTES);
    $lang = htmlentities($lang, ENT_QUOTES);
    $req = "SELECT nws_nid,nws_titre,nws_texte,nws_mid,mbr_pseudo FROM ".$this->sql->prebdd."nws ";
    $req .= "LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid=nws_mid ";
    $req .= "WHERE MATCH(nws_titre,nws_texte) AGAINST('$match') AND nws_lang='$lang' AND nws_etat > 1";
    return $this->sql->make_array($req);
    }

    function add_cmt($nid, $mid, $ip, $texte) //ajoute un commentaire
    //add_cmt(4, 2, '192.168.0.1', 'mon commentaire') rajoute le commentaire du membre numero 2 dans la news numero 4
    //ip = 192.168.0.1 et texte = 'mon commentaire'
    {
    $nid = (int) $nid;
    $mid = (int) $mid;
    $ip = htmlentities($ip, ENT_QUOTES);
    $req = "SELECT nws_closed FROM ".$this->sql->prebdd."nws WHERE nws_nid='$nid'";
    $res = $this->sql->query($req);
        if (mysql_result($res, 0,'nws_closed') == 0)
        {
        $texte = parser::parse($texte);
        $req = "INSERT INTO ".$this->sql->prebdd."cmt VALUES('','$nid','$mid',NOW(),'$texte','$ip')";
        return $this->sql->query($req);
        }
        else
        return false;
    }
    
    function del_cmt($cid) //supprime un commentaire
    //del_cmt(19) supprime le commentaire numero 19
    {
    $cid = (int) $cid;
    $req = "DELETE FROM ".$this->sql->prebdd."cmt WHERE cmt_cid='$cid'";
    return $this->sql->query($req);
    }
    
    function edit_cmt($cid, $new) //edite un commentaire
    //edit_cmt(19, array('nid' => 4, 'mid' => 2, 'ip' => '192.168.0.1', 'texte' => 'mon commentaire')) edite le commentaire numero 19 en commentaire du membre numero 2 dans la news numero 4
    //ip = 192.168.0.1 et texte = 'mon commentaire'
    //edit_cmt(19, array('texte' => 'nouveau texte')) => edite le texte du commentaire numero 19 en 'nouveau texte'
    {
    $cid = (int) $cid;
    $req = "UPDATE ".$this->sql->prebdd."cmt SET ";
        if (isset($new['mid']))
        {
        $mid = (int) $new['mid'];
        $req .= "cmt_mid='$mid',";
        }
        if (isset($new['ip']))
        {
        $ip = htmlentities($new['ip'], ENT_QUOTES);
        $req .= "cmt_ip='$ip',";
        }
        if (isset($new['texte']))
        {
        $texte = parser::parse($new['texte']);
        $req .= "cmt_texte='$texte',";
        }
        if (isset($new['nid']))
        {
        $nid = (int) $new['nid'];
        $req2 = "SELECT COUNT(*) FROM ".$this->sql->prebdd."nws WHERE nws_nid='$nid'";
        $res = $this->sql->query($req2);
            if (!mysql_result($res, 0))
            return false;
        $req .= "cmt_nid='$nid',";
        }
    $req = substr($req, 0, strlen($req) - 1)." WHERE cmt_cid='$cid'";    
    return $this->sql->query($req);
    }
    
    function get_cmt($nid) //renvoit un tableau des commentaires d'une news $nid
    //get_cmt(4) renvoit les commentaires de la news numero 4
    {
    $nid = (int) $nid;
    $req = "SELECT cmt_cid,cmt_mid,cmt_texte,cmt_ip,mbr_pseudo,mbr_gid,";
    $req .= "formatdate(cmt_date) as cmt_date_formated ";
    $req .= "FROM ".$this->sql->prebdd."cmt ";
    $req .= "LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid=cmt_mid WHERE cmt_nid='$nid' ";
    $req .= "ORDER BY cmt_date DESC";
    return $this->sql->make_array($req);
    }
    
    function get_one_cmt($cid) //renvoit le tableau d'un commentaire
    //get_one_cmt(21) => commentaire numero 21
    {
    $cid = (int) $cid;
    $req = "SELECT cmt_cid,cmt_mid,cmt_nid,cmt_texte,cmt_ip,mbr_pseudo,";
    $req .= "formatdate(cmt_date) as cmt_date ";
    $req .= "FROM ".$this->sql->prebdd."cmt ";
    $req .= "LEFT JOIN ".$this->sql->prebdd."mbr ON mbr_mid=cmt_mid WHERE cmt_cid='$cid'";
    return $this->sql->make_array($req);
    }
    
    function has_cmt($ip = 0, $mid = 0) //retourne 0 si l'ip et/ou le mid n'a pas poste de commentaires depuis un certain temps
    //has_cmt(0, 19) => regarde avec mid = 19
    //has_cmt(192.168.0.1, 0) => regarde avec ip = 192.168.0.1
    //has_cmt(192.168.0.1, 19) => regarde avec ip = 192.168.0.1 et mid = 19
    {
    $ip = htmlentities($ip, ENT_QUOTES);
    $mid = (int) $mid;
    $req = "SELECT COUNT(*) FROM ".$this->sql->prebdd."cmt WHERE cmt_date > (NOW()- INTERVAL ".$this->flood_time." SECOND) ";
        if ($ip)
        $req .= " AND cmt_ip='$ip'";
        if ($mid)
        $req .= " AND cmt_mid='$mid'";

    $res = $this->sql->query($req);
    return mysql_result($res, 0);     
    }
}
?>
