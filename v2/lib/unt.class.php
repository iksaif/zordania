<?php
/*
 unt.class.php
 gestion des unités table zrd_unt
 lid (légion) - unt_type - unt_rang - unt_nb
*/
class unt {

	/*
	 * gestion des unités
	 */
	function del_leg_unt($mid, $lid = 0) {
	}

	function edit_unt_gen($mid, $etat, $unt, $factor = 1) {
	}

	/* Peut on rajouter ces unités dans cette légion a ce rang là ? */
	function can_add_unt_leg($mid, $lid, $rang, $type, $nb) {
	}

	/*
	 * ressources des légions
	 */
	function del_leg_res($mid, $lid = 0) {
	}

}
?>

