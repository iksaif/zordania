<?php
/* supprimer des membres par leur mail */
date_default_timezone_set("Europe/Paris");

require_once("/home/zordania/v2/conf/conf.inc.php");
require_once(SITE_DIR . "lib/divers.lib.php");
require_once(SITE_DIR . "lib/mysql.class.php");
require_once(SITE_DIR . "lib/Template.class.php");
require_once(SITE_DIR . "lib/vld.lib.php");
require_once(SITE_DIR . "lib/member.lib.php");

require_once(SITE_DIR ."lib/btc.lib.php");
require_once(SITE_DIR ."lib/res.lib.php");
require_once(SITE_DIR ."lib/unt.lib.php");
require_once(SITE_DIR ."lib/trn.lib.php");
require_once(SITE_DIR ."lib/src.lib.php");
require_once(SITE_DIR ."lib/alliances.lib.php");
require_once(SITE_DIR ."lib/heros.lib.php");
require_once(SITE_DIR ."lib/mch.lib.php");
require_once(SITE_DIR ."lib/war.lib.php");
require_once(SITE_DIR ."lib/histo.class.php");
require_once(SITE_DIR ."lib/vld.lib.php");
require_once(SITE_DIR ."lib/nte.lib.php");
require_once(SITE_DIR ."lib/msg.lib.php");
require_once(SITE_DIR ."lib/map.lib.php");

/* BDD */
$_sql = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
$_sql->set_prebdd(MYSQL_PREBDD);
$_sql->set_debug(SITE_DEBUG);

/* sélection des comptes à supprimer par leur mail */
$arr_mail = array(
	'jeremylecon@hotmail.com',
	'grugeurdu50@yahoo.fr',
	'crepeausucre@live.fr',
	'babacheetienne@hotmail.fr',
	'ed170378@gmx.fr',
	'nad.dore@hotmail.fr',
	'CHbiiidou.skyblog.com@hotmail.fr',
	'lacroix.martine1@caramail.com',
	'romain.g77@wanadoo.fr',
	'Aegorn@hotmail.com',
	'stephanie@desgends.com',
	'ni.re2007@yahoo.fr',
	'henrilenoir.dark@yahoo.fr',
	'erhel.arthur@yahoo.fr',
	'mamie.meme@yahoo.fr',
	'flotrefouel@free.fr',
	'miss_noel96@hotmail.com',
	'joe_854hotmail.fr@iksaif.net',
	'sam41104381@modmailcom.com',
	'the-boy@live.ca',
	'rtavernier@live.fr',
	'loki.w@free.fr',
	'alexhiric@yahoo.fr',
	'chacharosa@hotmail.com',
	'x.laut@caramail.com',
	'tonycool@live.ca',
	'scolyo@live.fr',
	'alexandre.duret91@orange.fr',
	'maximoximo@hotmail.fr',
	'Arayashi54@hotmail.fr',
	'lapoule222@hotmail.fr',
	'serialkiller2610@hotmail.fr',
	'le.marseillais.du57@live.fr',
	'pantoineterrier@live.fr',
	'aefes@caramail.com',
	'a-chretien@wanadoo.fr',
	'legroscriss1@live.ca',
	'maelle1848@live.fr',
	'karadinglol@hotmail.fr',
	'yds-lhefld@hotmail.fr',
	'guillaume.orsini@hotmail.fr',
	'fouine04@yahoo.fr',
	'florentcornuez@yahoo.fr',
	'donpatchsama@hotmail.fr',
	'defeu1@orange.fr',
	'victorcaca@live.ca',
	'supercacarom@live.fr',
	'adamus49@yahoo.fr',
	'nicolas-bayer@hotmail.fr',
	'udroyster@club-internet.fr',
	'mevendragon@yahoo.fr',
	'paben63@hotmail.fr',
	'shade2609@hotmail.com',
	'thomas.soulat@gratimail.zzn.com',
	'godartcyril@hotmail.com',
	'yop.boum@yahoo.fr',
	'louise_attaque38@hotmail.fr',
	'juliendu0001@hotmail.fr',
	'jordancarruggi@hotmail.fr',
	'thomaskepeteke@yahoo.fr',
	'gromain21@caramail.com',
	'mbe@dbmail.com',
	'shadowsx@live.fr',
	'Steven53@live.fr',
	'alainpriou@free.fr',
	'lyonnais_du_69230@hotmail.fr',
	'the_melkor@msn.com',
	'sylvain.lavelle@aeroconseil.com',
	'kelodie4444@yahoo.com',
	'luimoix@yahoo.com',
	'pir57@hotmail.fr',
	'tonio.adam@hotmail.fr',
	'kiki-vincent@orange.fr',
	'ferouzdetalant@hotmail.fr',
	'toto38120@hotmail.fr',
	'aucunom@live.fr',
	'crashlopez@netcourrier.com',
	'lionel_r@noos.fr',
	'jipi17_hiso@hotmail.com',
	'g.bozelec@emc.fr',
	'Grobigrom@live.fr',
	'gustave-b@hotmail.fr',
	'ensousaalex@yahoo.fr',
	'Mathieu-gossiaux@hotmail.com',
	'pierreedouard.sabary@club-internet.fr',
	'djcroutash@hotmail.com',
	'tristan.massot@free.fr',
	'julienarnaut@yahoo.fr',
	'xzordx@hotmail.fr',
	'romain_abiz@hotmail.fr',
	'le-chat-noir-95@hotmail.fr',
	'etjulien3@hotmail.com',
	'loicblanchard@live.fr',
	'leroihibab@hotmail.fr',
	'yohann_guy@hotmail.fr',
	'anakinmaster3@hotmail.com',
	'chrugnkas@hotmail.fr',
	'Marcox78@hotmail.fr',
	'aimane99@hotmail.com',
	'heoward@live.fr',
	'tekos2009@hotmail.fr',
	'evans_liz3@hotmail.com',
	'jerometeckto@yahoo.fr',
	'f.galaad@hotmail.fr',
	'nico-gueko@live.fr',
	'legend_dragon@live.fr',
	'missouille@orange.fr',
	'fatalfantasy@hotmail.fr',
	'mr_pizzas@yahoo.fr',
	'kelkoo@live.be');
/*
	'basmie@tele2.fr',
	'vizath@hotmail.com',
	'amaurysabran@hotmail.fr',
	'ambianth@yahoo.fr',
	'jean.gros69@orange.fr',
	'lzordl@hotmail.fr');
/*
	'filouuujeux@free.fr',
	'123@hotmail.com',
	'manuelcharbonneau@orange.fr',
	'alex.turtle@wanadoo.fr',
	'christ59@wanadoo.fr',
	'Monalysme@hotmail.com',
	'cinna_razavi@msn.com',
	'thomasetmaison@hotmail.fr',
	'splitpas@hotmail.com',
	'7g2a9880ezpdobm@jetable.org');
/*
	'moyenage514@hotmail.com',
	'aviflo@msn.com',
	'jeveuxdevenirkalife@yahoo.fr',
	'famillegiacherio@orange.fr',
	'david92_nexus@hotmail.com',
	'lucasfelixe@hotmail.com',
	'vegeta5_89@hotmail.com',
	'laura_53@live.be',
	'vianeb666@orange.fr',
	'donosent@msn.com');
/*
	'gui.gui.du.91@hotmail.fr',
	'maftes-wow@hotmail.com',
	'avengedsevenfold64@hotmail.com',
	'yannick.cladiere@hotmail.fr',
	'kiannean@voila.fr',
	'meylanjd@bluwin.ch',
	'yome33@numericable.fr',
	'lord_knight40@hotmail.com',
	'ange_diabolique_06@hotmail.fr',
	'mallyscia@hotmail.fr');
/*
	'mhx.91@hotmail.fr',
	'freyrdaarm@hotmail.fr',
	'l.turmo@voila.fr',
	'styli_graf@hotmail.com',
	'karlen@vtxnet.ch',
	'general_adr@hotmail.com',
	'zarktas@hotmail.fr',
	'lemecdebanlieu@hotmail.com',
	'alex34nico@hotmail.fr',
	'fauccon@orange.fr');
/*
	'victorpipi@live.ca',
	'soulfly-prophecypowa@hotmail.fr',
	'lenjin@live.fr',
	'acomoretto@wanadoo.fr',
	'email6942904@fishfuse.com',
	'jems2@live.fr',
	'la_cavaliere_willow1987@hotmail.com',
	'auto.cad.123@hotmail.com',
	'choko__888@hotmail.com',
	'jona-love@live.be');
*/
foreach($arr_mail as $mail){
	$array = get_mbr_gen(array('mail' => $mail, 'full' => true));

	if($array) {
		$array = $array[0];
		$race = $array['mbr_race'];
		$cid = $array['mbr_mapcid'];
		$mid = $array['mbr_mid'];

		cls_mbr($mid, $cid, $race);
		echo "$mail supprimé\n";
	}
	else
		echo "echec suppression $mail\n";
}

?>
