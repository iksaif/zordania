<?php

$log_com = "Commerce";
require_once(SITE_DIR . "lib/mch.lib.php");

function glob_com() {
	global $_sql, $_h, $_c;

	// tt les 6h et uniquement à 6h du matin
	if($_h == 6 && $_c == '6h') {
		$sql = "INSERT INTO ".$_sql->prebdd."mch_sem (msem_res,msem_date,msem_cours) ";
		$sql.= "SELECT mcours_res, NOW(), mcours_cours FROM ".$_sql->prebdd."mch_cours ";
		$_sql->query($sql);

		$sql = "UPDATE ".$_sql->prebdd."mch_sem SET  msem_cours = (";
		$sql.= "SELECT ROUND(AVG(mch_prix/mch_nb),2) FROM ".$_sql->prebdd."mch WHERE mch_etat = ".COM_ETAT_ACH." AND msem_res = mch_type";
		$sql.= ") WHERE msem_date = CURDATE() AND msem_res IN (SELECT DISTINCT mch_type FROM ".$_sql->prebdd."mch WHERE mch_etat = ".COM_ETAT_ACH.")";
		$_sql->query($sql);

		//Virer les vieilles ventes qui ne seront plus prises en compte pour le calcul des cours
		$sql = "DELETE FROM ".$_sql->prebdd."mch ";
		$sql.= "WHERE mch_etat = ".COM_ETAT_ACH." AND mch_time < (NOW() - INTERVAL ".MCH_OLD. " DAY)";
		$_sql->query($sql);

		//Moyenne de la semaine /!\
		$sql = "TRUNCATE TABLE ".$_sql->prebdd."mch_cours";
		$_sql->query($sql);

		$sql = "INSERT INTO ".$_sql->prebdd."mch_cours (mcours_res,mcours_cours) ";
		$sql.= " SELECT msem_res,ROUND(AVG(msem_cours),2)";
		$sql.= " FROM ".$_sql->prebdd."mch_sem WHERE  msem_date > (NOW() - INTERVAL 3 DAY)";
		$sql.= " GROUP BY msem_res ";
		$_sql->query($sql);
	}


	//if($_c == '1h') { // tt les heures
		/*
		 * obtenir les ventes en cours pour le PNJ vendeur = MBR_WELC
		 * ajouter N ventes des matières premières au taux nominal COM_TAUX_MAX
		 */
		// ressources primaires à vendre = config
		$res_array = array(2 ,3 ,4 ,5 ,6 ,8 ,9);
		$nb_ventes_max = 5; // config

		$vente_array = get_mch_by_mid(MBR_WELC);
		$vente_nb = array();
		foreach($vente_array as $row)
			if(isset($vente_nb[$row['mch_type']]))
				$vente_nb[$row['mch_type']]++;
			else
				$vente_nb[$row['mch_type']]=1;

		$cours = mch_get_cours();
		$cours = index_array($cours, 'mcours_res');
		foreach($res_array as $res_type){
			if(!isset($vente_nb[$res_type]))
				$vente_nb[$res_type]=0;
			// on calcule le nb de ressources à mettre en vente :
			// pour qu'un joueur level1 puisse acheter
			$res_nb = floor(COM_MAX_NB1 / $cours[$res_type]['mcours_cours'] / COM_TAUX_MAX);
			// rajouter jusqu'à 5 ventes par ressources
			for($i=$vente_nb[$res_type]; $i < $nb_ventes_max; $i++)
				mch_vente(MBR_WELC, $res_type, $res_nb, $res_nb * $cours[$res_type]['mcours_cours'] * COM_TAUX_MAX);
		}
	//} // fin de la vente auto pour le PNJ


	//Faire avancer les ventes dans le marché
	$time = (MCH_ACCEPT + rand(-1,1)) * ZORD_SPEED;  /* temps en minute */
	$max = MCH_MAX * ZORD_SPEED;

	$sql = "UPDATE ".$_sql->prebdd."mch SET mch_etat = ".COM_ETAT_OK.", mch_time = (NOW() + INTERVAL $max MINUTE)";
	$sql.= " WHERE mch_etat = ".COM_ETAT_ATT." AND ";
	$sql.= "NOW() > (mch_time + INTERVAL $time MINUTE)";
	$_sql->query($sql);

	//Virer les ventes en cours non vendues
	$sql = "DELETE FROM ".$_sql->prebdd."mch ";
	$sql.= "WHERE mch_etat = ".COM_ETAT_OK." AND mch_time < NOW()";
	$_sql->query($sql);
}

?>
