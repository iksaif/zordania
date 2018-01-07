<?php
/*
 * classe des joueurs - membres
 */
class members extends row {

	// liste des membres chargés = cache
	private static $membres = array();

	/* constructeur */
	function __construct( $arg)
	{
		if(is_int($arg))
		{
			$mid = (int) $arg;
			// cache
			if(isset(self::$membres[$mid]))
				return self::$membres[$mid];

			// lecture
			$tmp = Mbr::get_aly($mid);
			parent::__construct($tmp);
			self::$membres[$mid] = $this;
		}
		else if(is_object($arg) && get_class($arg) == 'mysqli_result')
		{
			// utilisation du résultat
			parent::__construct($arg);
			// self::$membres[$mid] = $this;

var_dump($this);

		}
	}

}
?>
