<?php
/*
 * exemple vide pour un module smartirc
 */
class Net_SmartIRC_module_exemple
{

	/* variables requises */
	var $name = 'exemple';
	var $description = 'description de ce que fait le module';
	var $author = 'pifou';
	var $license = 'license (c)';

	/* methodes requises */
	function module_init(){
	}
	function module_exit(){
	}

	function helloworld(){
		echo "hello world";
	}
}

?>
