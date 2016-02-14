<?php
class a {
	private $var = array();
	/* méthodes set & get */
	public function __set($key, $value) {
		//$this->row->$key = $value;
		$this->var[$key] = $value;
	}
	public function __get($key) {
		//return $this->row->$key;
		return $this->var[$key];
	}
}

class b extends a {
	private $var = 'toto';
	/* méthodes set & get
	function __set($key, $value) {
		//$this->row->$key = $value;
		parent::__set($key, $value);
	}
	function __get($key) {
		//return $this->row->$key;
		return parent::__get($key);
	} */
	public function fillin($var){
		$this->fillin = $var;
	} 
}

$a = new b('too');
$a->toto = 'fait du vélo';
$a->var = 'test';
echo $a->var;
$a->fillin('test');
var_dump($a);
?>
