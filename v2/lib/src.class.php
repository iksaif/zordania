<?php

class src {
    
    private $mid;
    private $_sql;
    
	function __construct($mid){
		$this->mid = $mid;
        $this->_sql = mysqliext::$bdd;
	}

    /* Rajouter la recherche dont la conf est $conf en prévision */
    public function scl($type) {

        $type = protect($type, "uint");

        add_src($this->mid, $type);
        $tours = get_conf("src", $type, "tours");

        $sql = "INSERT INTO ".$this->_sql->prebdd."src_todo VALUES ($this->mid, $type, $tours, NOW())";
        return $this->_sql->query($sql);
    }

    /* Ajoute une recherche pour de vrai */
    public function add($type) {
  
        $type = protect($type, "uint");

        $sql = "INSERT INTO ".$this->_sql->prebdd."src VALUES ($this->mid, $type)";
        return $this->_sql->query($sql);
    }

    /* Verifie qu'on peut faire telle ou telle recherche */
    public function can($type, & $cache = array()) {
        $type = protect($type, "uint");
        $cache = protect($cache, "array");

        $bad_src = array('need_src' => array(), 'need_no_src' => array());
        $bad_btc = array();
        $bad_res = array();
        $done = false;
        
        if(!get_conf("src", $type))
            return array("do_not_exist" => true);

        /* Bâtiments */
        $need_btc = get_conf("src", $type, "need_btc");
        $cond_btc = $need_btc;

        if(!isset($cache['btc_done'])) {
            $have_btc = get_nb_btc_done($this->mid, $cond_btc);
            $have_btc = index_array($have_btc, "btc_type");
        } else
            $have_btc = $cache['btc_done'];

        /* Recherches */
        $cond_src = array($type);

        $need_src = get_conf("src", $type, "need_src");
        $need_no_src = get_conf("src", $type, "need_no_src");
        $cond_src = array_merge($need_src,$need_no_src);

        if(!isset($cache['src'])) {
            $have_src = get_src_done($this->mid, $cond_src);
            $have_src = index_array($have_src, "src_type");
        } else
            $have_src = $cache['src'];

        if(!isset($cache['src_todo'])) {
            $todo_src = get_src_todo($this->mid, array($type));
            $todo_src = index_array($todo_src, "src_type");
        } else
            $todo_src = $cache['src_todo'];

        /* Les recherches qu'on ne doit pas avoir */
        foreach($need_no_src as $src_type) {
            if(isset($have_src[$src_type]))
                $bad_src['need_no_src'][$src_type] = $src_type;
        }

        /* Les recherches qu'il faut avoir */
        foreach($need_src as $src_type) {
            if(!isset($have_src[$src_type]))
                $bad_src['need_src'][$src_type] = $src_type;
        }

        /* La recherche qu'on veut est elle déjà en cours ? */
        $todo = isset($todo_src[$type]);
        $done = (isset($todo_src[$type]) || isset($have_src[$type]));

        /* Ressources */
        $prix_res = get_conf("src", $type, "prix_res");
        $cond_res = array_keys($prix_res);

        if(!isset($cache['res'])) {
            $have_res = get_res_done($this->mid, $cond_res);
            $have_res = clean_array_res($have_res);
            $have_res = $have_res[0];
        } else
            $have_res = $cache['res'];

        foreach($prix_res as $res_type => $nombre) {
            $diff =  $nombre - $have_res[$res_type];
            if($diff > 0)
                $bad_res[$res_type] =  $diff;
        }

        /* Verifications Bâtiments */
        foreach($need_btc as $btc_type) {
            if(!isset($have_btc[$btc_type]))
                $bad_btc[] = $btc_type;
        }

        return array('need_btc' => $bad_btc, 'need_src' => $bad_src['need_src'], 'need_no_src' => $bad_src['need_no_src'], 'todo' => $todo, 'done' => $done,  'prix_res' => $bad_res);
    }

    /* Annule la recherche $type */
    public function cnl($type) {
        $type = protect($type, "uint");

        $this->del($type);

        $sql = "DELETE FROM ".$this->_sql->prebdd."src_todo WHERE stdo_type = $type AND stdo_mid = $this->mid";
        $this->_sql->query($sql);

        return $this->_sql->affected_rows();
    }

    /* Supprimer la recherche $type */
    public function del($type = 0) {
        $type = protect($type, "uint");

        $sql = "DELETE FROM ".$this->_sql->prebdd."src ";
        $sql.=" WHERE src_mid = $this->mid ";
        if($type)
            $sql .= " AND src_type = $type";
        
        $this->_sql->query($sql);

        return $this->_sql->affected_rows();
    }

    /* Récupere les recherches de $this->mid [ et de type $type ] */
    public function get($src = array()) {
        $src = protect($src, "array");
        
        $sql = "SELECT src_mid,src_type ";
        $sql.= "FROM ".$this->_sql->prebdd."src ";
        $sql.= "WHERE src_mid = $this->mid AND ";
        $sql.= " src_type NOT IN ";
        $sql.= "(SELECT stdo_type FROM ".$this->_sql->prebdd."src_todo WHERE stdo_mid = $this->mid)";
        if($src) {
            $sql.= " AND src_type IN ( ".implode(',', protect($src, array('uint'))).') ';
        }

        $result = $this->_sql->make_array($sql);
        $result = index_array($result, "src_type");
        return $result;
    }

    public function get_todo($src = array()) {
        $src = protect($src, "array");
        
        $sql = "SELECT stdo_mid,stdo_type, stdo_tours ";
        $sql.= "FROM ".$this->_sql->prebdd."src_todo ";
        $sql.= "WHERE stdo_mid = $this->mid ";
        
        if($src) {
            $sql.= " AND stdo_type IN ( ".implode(',', protect($src, array('uint'))).') ';
        }
        $sql.= " ORDER BY stdo_time ASC";
        
        $result = $this->_sql->make_array($sql);
        $result = index_array($result, "stdo_type");
        return $result;
    }

    /* Quand on crée un membre */
    public function ini() {
        $debut = get_conf("race_cfg", "debut", "src");
        foreach($debut as $type) {
            $this->add($type);
        }
    }

    /* Quand on le vire */
    public function cls() {
        $nb = del_src($this->mid);
        
        /* les recherches a faire */
        $sql = "DELETE FROM ".$this->_sql->prebdd."src_todo WHERE stdo_mid = $this->mid";
        $res = $this->_sql->query($sql);
        
        return $this->_sql->affected_rows() + $nb;
    }

}

?>