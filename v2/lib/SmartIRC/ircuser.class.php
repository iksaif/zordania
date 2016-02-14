<?php
/* user online irc, + gestion de ses droits IRC + session zordania */

class ircuser extends session {
	var $pseudo; // sur IRC
	var $user;
	var $host;
	var $qlogin; // sur Q
	var $ope = false; // opérateur
	var $admin = false;

	function __construct(&$sql, $pseudo) {
		$this->pseudo = $pseudo;
		//$this->_sql = &$sql;
		parent::__construct($sql);
	}

	function __destruct() {
	}

	function login($login, $pass, $raw = false) {
		if(parent::login($login, $pass, $raw)){
			// connexion OK
			//foreach($_ses->get_vars() as $key => $value)
				//$mybot->say("TEST: [$key] = *$value*", $array['pseudo']);
			if(in_array(parent::get('groupe'), array(GRP_DIEU, GRP_DEMI_DIEU, GRP_PRETRE, GRP_GARDE, GRP_DEV, GRP_ADM_DEV)))
			{
				$this->admin = true;
			}
			if(in_array(parent::get('groupe'), array(GRP_DIEU, GRP_DEMI_DIEU, GRP_PRETRE, GRP_GARDE, GRP_DEV, GRP_ADM_DEV, GRP_SAGE, GRP_NOBLE)))
			{
				$this->ope = true;
			}
			return true;
		} else
			return false;
	}
}

?>

