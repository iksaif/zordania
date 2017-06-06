<?php

/*
 * cache de tout ce qui concerne le membre 
 * mbr unt res btc src leg et certains "todo"
 */
class member{
	
	private $mid;
	private $mbr;
	private $mbr_load = false;
	private $unt;
	private $unt_leg;
	private $unt_load = false;
	private $unt_todo;
	private $unt_todo_load = false;
	private $res;
	private $res_load = false;
	private $res_todo;
	private $res_todo_load = false;
	private $src;
	private $src_load = false;
	private $src_todo;
	private $src_todo_load = false;
	private $leg;
	private $leg_load = false;
	private $btc;
	private $btc_load = false;
	private $nb_btc;
	private $nb_btc_load = false;
	
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
			$unt_tmp = get_leg_gen(array('mid' => $this->mid, 'unt' => array(), 'leg' => true));
			$this->unt = array();
			$this->unt_leg = array();
			foreach($unt_tmp as $value) {
				$t_type = $value['unt_type'];
				$t_nb = $value['unt_nb'];
				if($value['leg_etat'] == LEG_ETAT_VLG) {
					if(isset($this->unt[$t_type]))
						$this->unt[$t_type] += $t_nb;
					else
						$this->unt[$t_type] = $t_nb;
				} else {
					if(isset($this->unt_leg[$t_type]))
						$this->unt_leg[$t_type] += $t_nb;
					else
						$this->unt_leg[$t_type] = $t_nb;
				}
			}
			$this->unt_load = true;
		}
		return $this->unt;
	}
	
	function unt_leg(){
		if(!$this->unt_load){
			$this->unt();
		}
		return $this->unt_leg;
	}
	
	
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
				$this->res = $return;
			}

			$this->res_load = true;
		}
		return $this->res;
	}
	
	function src(){
		if(!$this->src_load){
			$tmp = get_src_done($this->mid);
			$this->src = index_array($tmp, 'src_type');
			$this->src_load = true;
		}
		return $this->src;
	}
	
	function leg(){
		if(!$this->leg_load){
			// TODO
			$this->leg = get_leg_gen(array('mid' => $this->mid));
			$this->leg_load = true;
		}
		return $this->leg;
	}
	
	function unt_todo(){
		if(!$this->unt_todo_load){ // TODO?
			$this->unt_todo = get_unt_gen(array('mid' => $this->mid));
			$this->unt_todo_load = true;
		}
		return $this->unt_todo;
	}

	function res_todo(){
		if(!$this->res_todo_load){ // TODO?
			$this->res_todo = get_res_gen(array('mid' => $this->mid));
			$this->res_toto_load = true;
		}
		return $this->res_todo;
	}

	function src_todo(){
		if(!$this->src_todo_load){ // TODO?
			$this->src_todo = get_src_gen(array('mid' => $this->mid));
			$this->src_todo_load = true;
		}
		return $this->src_todo;
	}
	
	/***  batiments ***/
	function btc(){
		if(!$this->btc_load){
			$this->btc = get_btc_gen(array('mid' => $this->mid));
			//, 'etat' => array(BTC_ETAT_OK, BTC_ETAT_DES, BTC_ETAT_REP, BTC_ETAT_BRU), 'count' => true
			$this->btc_load = true;
		}
		return $this->btc;
	}
	
	function nb_btc(){
		if(!$this->nb_btc_load){
			$btc = $this->btc();
			// compter les btc par type
			$result = array();
			foreach($btc as $key => $value){
				if(isset($result[$value['btc_type']]))
					$result[$value['btc_type']]['btc_nb']++;
				else
					$result[$value['btc_type']] = array('btc_mid'=>$this->mid, 'btc_nb'=>1);
			}
			$this->nb_btc_load = true;
			$this->nb_btc = $result;
		}
		return $this->nb_btc;
	}
	
}
?>