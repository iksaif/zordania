<?php

/*
 * cache de tout ce qui concerne le membre 
 * mbr unt res btc src leg et certains "todo"
 */
class member{
	
	private $mid;
	private $mbr;
	private $mbr_load = false;
    
    /** unites + legions
    ["unt_lid"]=>
    ["unt_type"]=>
    ["unt_rang"]=>
    ["unt_nb"]=>
    ["leg_id"]=>
    ["leg_mid"]=>
    ["leg_cid"]=>
    ["leg_etat"]=>
    ["leg_name"]=>
    ["leg_xp"]=>
    ["leg_vit"]=>
    ["leg_dest"]=>
    ["leg_tours"]=>
    ["leg_fat"]=>
    ["leg_stop"]=>
    */
	private $unt; // unt civiles & militaires
	private $unt_leg; // toutes unités par etat (vlg btc ou liste des legions)
	private $unt_load = false;
	private $unt_todo;
	private $unt_todo_load = false;
    private $nb_unt; // type => nb
    private $nb_unt_load = false;

/** legion + heros
    ["leg_id"]=>
    ["leg_mid"]=>
    ["leg_cid"]=>
    ["leg_etat"]=>
    ["leg_vit"]=>
    ["leg_name"]=>
    ["leg_xp"]=>
    ["leg_dest"]=>
    ["leg_tours"]=>
    ["leg_fat"]=>
    ["leg_stop"]=>
    ["hro_id"]=>
    ["hro_nom"]=>
    ["hro_type"]=>
    ["hro_xp"]=>
    ["hro_vie"]=>
    ["bonus"]=>
    ["hro_bonus_from"]=>
    ["bonus_to"]=>
*/
	private $leg;
	private $leg_load = false;
    
	private $res;
	private $res_load = false;
	private $res_todo;
	private $res_todo_load = false;
    
	private $src;
	private $src_load = false;
	private $src_todo;
	private $src_todo_load = false;
    
	private $btc;
	private $btc_load = false;
	private $nb_btc;
	private $nb_btc_load = false;

    private $trn;
    private $trn_load = false;
    
	private $cache = array();
	
	function __construct($mid){
		$this->mid = $mid;
	}
	
	function get_conf($type = "", $key0 = "", $key1 = "") {
		return get_conf_gen($this->mbr()['mbr_race'], $type, $key0, $key1);
	}

	function mbr(){
		if(!$this->mbr_load){
			$this->mbr = get_mbr_gen(array('mid' => $this->mid));
			$this->mbr = $this->mbr[0];
			$this->mbr_load = true;
		}
		return $this->mbr;
	}
	
	/*** unites et unites en legion ***/
	function unt(){
		if(!$this->unt_load){
			$this->unt = get_leg_gen(array('mid' => $this->mid, 'unt' => true, 'leg'=>true));
			
			$tmp = array();
			foreach($this->unt as $value) {

				if(isset($tmp[$value['leg_etat']][$value['unt_type']]))
					$tmp[$value['leg_etat']][$value['unt_type']] += $value['unt_nb'];
				else
					$tmp[$value['leg_etat']][$value['unt_type']] = $value['unt_nb'];

			}
            $this->unt_leg = $tmp;
			$this->unt_load = true;
		}

		return $this->unt;
	}
	
	function unt_leg($type = null){
		if(!$this->unt_load){
			$this->unt();
		}
		if($type != null)
			return isset($this->unt_leg[$type]) ? $this->unt_leg[$type] : array();
		else
			return $this->unt_leg;
	}
	
    function nb_unt($type = null){
        if(!$this->nb_unt_load){
			$tmp = array();
            foreach($this->unt() as $value){
                if(isset($tmp[$value['unt_type']]))
                    $tmp[$value['unt_type']] += $value['unt_nb'];
                else
                    $tmp[$value['unt_type']] = $value['unt_nb'];
            }
            $this->nb_unt = $tmp;
            $this->nb_unt_load = true;
        }
        
		if($type === null)
            return $this->nb_unt;
        else if (isset($this->nb_unt[$type]))
            return $this->nb_unt[$type];
        else
            return 0;
    }

    /* Les unités faites, mais au village */
    function nb_unt_done($unt = null) {
        $tmp = array();
        foreach($this->unt() as $value){
            if($unt == null || $value['unt_type'] == $unt){ 
                if($value['leg_etat'] == LEG_ETAT_VLG){
                    if(isset($tmp[$value['unt_type']]))
                        $tmp[$value['unt_type']] += $value['unt_nb'];
                    else
                        $tmp[$value['unt_type']] = $value['unt_nb'];
                }
            }
        }
        if($unt == null )
            return $tmp;
        else
            return (isset($tmp[$unt]) ? $tmp[$unt] : 0);
    }

    /*** unites en legion ***/
	function leg(){
		if(!$this->leg_load){
			$this->leg = get_leg_gen(array('mid' => $this->mid, 'leg' => true));
			$this->leg_load = true;
		}
		return $this->leg;
	}
	
    /***  unites en todo list ***/
	function unt_todo(){
		if(!$this->unt_todo_load){
			$this->unt_todo = get_unt_todo($this->mid);
			$this->unt_todo_load = true;
		}
		return $this->unt_todo;
	}
    
    /* Verifie qu'on peut faire $nb unités du type $type */
    function can_unt($type, $nb) {
        $type = protect($type, "uint");

        $bad_src = array();
        $bad_res = array();
        $bad_btc = array();
        $bad_unt = array();
        $limit_unt = 0;

        if(!$this->get_conf("unt", $type))
            return array("do_not_exist" => true);
        
        /* Bâtiments */
        $need_btc = $this->get_conf("unt", $type, "need_btc");
        $cond_btc = $need_btc;
        $have_btc = $this->nb_btc_done( $cond_btc);
        
        /* Recherches */
        $need_src = $this->get_conf("unt", $type, "need_src");
        $cond_src = $need_src;
        $have_src = $this->src($cond_src);
        
        /* Ressources */
        $prix_res = $this->get_conf("unt", $type, "prix_res");
        $cond_res = array_keys($prix_res);
        $have_res = $this->res( $cond_res);
            
        /* Unités */
        $prix_unt = $this->get_conf("unt", $type, "prix_unt");
        $cond_unt = array_keys($prix_unt);
        
        $limite = $this->get_conf("unt", $type, "limite");
        if($limite)
            $cond_unt += array($type);
        
        $have_unt = $this->unt();
        $have_unt_leg = $this->unt_leg();

        $have_unt_todo = $this->unt_todo();
        $have_unt_todo = index_array($have_unt_todo, "unt_todo");

        /* Les recherches qu'il faut avoir */
        foreach($need_src as $src_type) {
            if(!isset($have_src[$src_type]))
                $bad_src[] = $src_type;
        }
    
        /* Vérifications ressources */
        foreach($prix_res as $res_type => $nombre) {
            $diff =  $nombre * $nb - $have_res[$res_type];
            if($diff > 0) {
                $bad_res[$res_type] =  $diff;
            }
        }

        /* Les unités */
        foreach($prix_unt as $unt_type => $nombre) {
            $diff = $nombre * $nb - $this->nb_unt($unt_type);

            if($diff > 0) {
                $bad_unt[$unt_type] =  $diff;
            }
        }
        
        /* Verifications Bâtiments */
        foreach($need_btc as $btc_type) {
            if(!isset($have_btc[$btc_type]))
                $bad_btc[] = $cond_btc;
        }

        /* La limite */
        $unt_nb = $this->nb_unt($type);
        if(isset($have_unt_todo[$type]['utdo_nb']))
            $unt_nb += $have_unt_todo[$type]['utdo_nb'];

        if($limite && $unt_nb >= $limite)
            $limit_unt = $limite;

        return array('need_src' => $bad_src, 'need_btc' => $bad_btc, 'prix_res' => $bad_res,  'prix_unt' => $bad_unt, 'limit_unt' => $limit_unt);
    }



    /*** ressources ***/
	function res(){
		if(!$this->res_load){
			global $_sql;

			$sql = "SELECT * FROM ".$_sql->prebdd."res ";
			$sql.= "WHERE res_mid = ".$this->mid;

			$array = $_sql->make_array($sql);
			if($array){
				// mise en forme du tableau avec la 1ere ligne uniquement
				$return = array();
				foreach($array[0] as $key => $val) {
					$key = str_replace("res_type","",$key);
					$return[$key] = $val;
            }
            unset($return['res_mid']);
				$this->res = $return;
			}

			$this->res_load = true;
		}
		return $this->res;
    }

	function res_todo(){
		if(!$this->res_todo_load){ // TODO?
			$this->res_todo = get_res_gen(array('mid' => $this->mid));
			$this->res_toto_load = true;
		}
		return $this->res_todo;
	}




    /*** recherches ***/
	function src(){
		if(!$this->src_load){
			$tmp = get_src_done($this->mid);
			$this->src = index_array($tmp, 'src_type');
			$this->src_load = true;
		}
		return $this->src;
	}
	
	function src_todo(){
		if(!$this->src_todo_load){ // TODO?
			$this->src_todo = get_src_todo($this->mid);
			$this->src_todo_load = true;
		}
		return $this->src_todo;
	}
	
    
    
	/***  batiments ***/
	function btc($btc = array(), $etat = array()){
        // mise en cache du resultat sql
		if(!$this->btc_load){
			$this->btc = get_btc_gen(array('mid' => $this->mid));
			$this->btc_load = true;
        }
        $result = $this->btc;
        
        if(!empty($etat)){
            // filtrer sur l'etat des btc
            $result = array_filter( $result, function($v) use($etat){
                return in_array($v['btc_etat'], $etat);
            });
        }

        // filtrer les types de btc
        if(!empty($btc)){
            $result = array_filter( $result, function($v) use($btc){
                return in_array($v['btc_type'], $btc);
            });
        }
        
		return $result;
	}
	
	function nb_btc($btc = array(), $etat = array()){
        $tmp = $this->btc( $btc, $etat);
        // compter les btc par type
        $result = array();
        foreach($tmp as $key => $value){
            if(isset($result[$value['btc_type']]))
                $result[$value['btc_type']]['btc_nb']++;
            else
                $result[$value['btc_type']] = array('btc_mid'=>$this->mid, 'btc_nb'=>1);
        }

		return $result;
	}
	
    function nb_btc_done($btc = array()) {
        return $this->nb_btc($btc, array(BTC_ETAT_OK, BTC_ETAT_DES, BTC_ETAT_REP, BTC_ETAT_BRU));
    }


    /* Verifie qu'on peut faire tel ou tel bâtiment */
    function can_btc($type) {

        $bad_src = array();
        $bad_res = array();
        $bad_btc = array();
        $bad_unt = array();
        $bad_trn = array();
        $limit_btc = 0;

        if(!$this->get_conf("btc", $type))
            return array("do_not_exist" => true);
        
        /* Bâtiments */
        $need_btc = $this->get_conf("btc", $type, "need_btc");
        $cond_btc = $need_btc;
        
        $limite = (int) $this->get_conf("btc", $type, "limite");
        if($limite)
            $cond_btc[] = $type;

        $have_btc = $this->nb_btc_done( $cond_btc);
        
        /* Recherches */
        $need_src = $this->get_conf("btc", $type, "need_src");
        $cond_src = $need_src;
        $have_src = $this->src($cond_src);
       
        /* Ressources */
        $prix_res = $this->get_conf("btc", $type, "prix_res");
        $cond_res = array_keys($prix_res);
        $have_res = $this->res( $cond_res);
            
        /* Terrains */
        $prix_trn = $this->get_conf("btc", $type, "prix_trn");
        $cond_trn = array_keys($prix_trn);
        $have_trn = $this->trn();
            
        /* Unités */
        $have_unt = $this->nb_unt_done();
    
        /* Les recherches qu'il faut avoir */
        foreach($need_src as $src_type) {
            if(!isset($have_src[$src_type]))
                $bad_src['need_src'][] = $src_type;
        }

        /* Vérifications ressources */
        foreach($prix_res as $res_type => $nombre) {
            $diff =  $nombre - $have_res[$res_type];
            if($diff > 0)
                $bad_res[$res_type] =  $diff;

        }
        
        /* Les terrains */
        foreach($prix_trn as $trn_type => $nombre) {
            $diff =  $nombre - $have_trn[$trn_type];
            if($diff > 0)
                $bad_trn[$trn_type] =  $diff;
        }
        
        /* Les unités */
        foreach($prix_unt as $unt_type => $nombre) {
            if(!isset($have_unt[$unt_type]))
                $diff = $nombre;
            else
                $diff =  $nombre - $have_unt[$unt_type];
                
            if($diff > 0)
                $bad_unt[$unt_type] =  $diff;
        }
        
        /* Verifications Bâtiments */
        foreach($need_btc as $btc_type) {
            if(!isset($have_btc[$btc_type]))
                $bad_btc[] = $btc_type;
        }
        
        /* La limite */
        if($limite && isset($have_btc[$type]['btc_nb']) && $have_btc[$type]['btc_nb'] >= $limite)
            $limit_btc = $limite;

        return array('need_src' => $bad_src, 'need_btc' => $bad_btc, 'prix_res' => $bad_res, 'prix_trn' => $bad_trn, 'prix_unt' => $bad_unt, 'limit_btc' => $limit_btc);
    }

    /*** terrains ***/
    function trn(){
        if(!$this->trn_load){
            $have_trn = get_trn($mid);
            $have_trn = clean_array_trn($have_trn);
            $this->trn = $have_trn[0];
            $this->trn_load = true;
        }
        return $this->trn;
    }
    

}
?>