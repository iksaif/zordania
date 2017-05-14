<?php

/*
 * cache de tout ce qui concerne le membre
 */
class member{
	
	private $mid;
	private $mbr;
	private $unt;
	private $unt_todo;
	private $res;
	private $res_todo;
	private $src;
	private $src_todo;
	private $leg;
	
	private $cache = array();
	
	function __construct($mid){
		$this.mid = $mid;
	}
	
	function mbr(){
		if(!isset($this.mbr)){
			$this.mbr = get_mbr_gen(array('mid' => $mid));
		}
		return $this.mbr;
	}
	
	function unt(){
		if(!isset($this.unt)){
			$this.unt = get_unt_gen(array('mid' => $mid));
		}
		return $this.unt;
	}
	
	function res(){
		if(!isset($this.mbr)){
			$this.res = get_res_gen(array('mid' => $mid));
		}
		return $this.res;
	}
	
	function src(){
		if(!isset($this.src)){
			$this.src = get_src_gen(array('mid' => $mid));
		}
		return $this.src;
	}
	
	function leg(){
		if(!isset($this.leg)){
			$this.leg = get_leg_gen(array('mid' => $mid));
		}
		return $this.leg;
	}
	
	function unt_todo(){
		if(!isset($this.unt_todo)){ // TODO?
			$this.unt_todo = get_unt_gen(array('mid' => $mid));
		}
		return $this.unt_todo;
	}

	function res_todo(){
		if(!isset($this.res_todo)){ // TODO?
			$this.res_todo = get_res_gen(array('mid' => $mid));
		}
		return $this.res_todo;
	}

	function src_todo(){
		if(!isset($this.src_todo)){ // TODO?
			$this.src_todo = get_src_gen(array('mid' => $mid));
		}
		return $this.src_todo;
	}
}
?>