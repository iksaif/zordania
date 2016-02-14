<?php
//Gestions des votes pour les bonus

// pas utile pour le moment
function count_votes($vid)/* nb de votes */
{
	global $_sql;

	$vid = protect($vid, "uint");

	$sql="SELECT COUNT(*) FROM ".$_sql->prebdd."votes WHERE votes_vid = $vid";
	return $_sql->result($_sql->query($sql), 0 );
}

// liste et nombre de votes par site et pour un joueur $mid
function get_votes($mid)
{
	global $_sql;
	
	$mid = protect($mid, "uint");

	$sql="SELECT mbr_mid, votes_vid, votes_mid, votes_nb,_DATE_FORMAT(votes_date) as votest_date_formated,
		DATE_FORMAT(votes_date,'%a, %d %b %Y %T') as votes_date_rss";
	$sql.=" FROM ".$_sql->prebdd."votes ";
	$sql.=" JOIN ".$_sql->prebdd."mbr ON mbr_mid = votes_mid ";
	$sql.=" WHERE votes_mid = '$mid' ";
	$sql.=" ORDER BY votes_date DESC";

	return $_sql->index_array($sql, 'votes_vid');
}

function add_votes($mid,$vid)
// ajouter $nb votes sur le joueur $mid et le site $vid 
//il arriver à executer : UPDATE `zrd_votes` SET `votes_nb`=`votes_nb`+1 WHERE `votes_mid` = ... and `votes_vid` = ...
{
	global $_sql;
	$mid = protect($mid, "uint");
	$vid = protect($vid, "uint");
	//faudra mettre à jour la date et vérifier qu'on peut ajouter à la condition que le délais est passé mais une chose à la fois !
	// et return true ou false selon si on a pu voter ou pas

	if($votes_up=true)
		{
		$sql = "UPDATE ".$_sql->prebdd."votes SET `votes_nb`=`votes_nb`+1 WHERE votes_mid='$mid' AND votes_vid='$vid'";
		}

	return $_sql->query($sql);
}

// supprimer $nb votes au joueur $mid et sur le site $vid
function del_votes($vid,$mid,$nb)
{
	global $_sql;

	$vid = protect($vid, "uint");
	$mid = protect($mid, "uint");
	$nb = protect($nb, "uint");

	$sql="DELETE FROM ".$_sql->prebdd."votes WHERE votes_vid=$vid AND votes_mid=$mid";

	$_sql->query($sql);
	return $_sql->affected_rows(); 

}
?>
