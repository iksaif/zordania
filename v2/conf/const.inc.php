<?php
/* 
 * constantes du jeu
 * ces constantes ne doivent en aucun cas être modifiées
 * bien souvent elles correspondent à un champs en BD
 */

/* Logo membres */
define('MBR_LOGO_SIZE',20*1024);
define('MBR_LOGO_MAX_X_Y',80);
define('MBR_LOGO_TYPE','image/png|image/x-png');
define('MBR_LOGO_DIR',SITE_DIR.'www/img/mbr_logo/');
define('MBR_LOGO_URL',SITE_URL.'img/mbr_logo/');

/* Logo alliances */
define('ALL_LOGO_SIZE',20*1024);
define('ALL_LOGO_MAX_X_Y',100);
define('ALL_LOGO_TYPE','image/png|image/x-png');
define('ALL_LOGO_DIR',SITE_DIR.'www/img/al_logo/');
define('ALL_LOGO_URL',SITE_URL.'img/al_logo/');

/* Etat des membres d'alliance = zrd_al_mbr.ambr_etat  */
define('ALL_ETAT_NULL',0);  // pas dans une alliance
define('ALL_ETAT_DEM', 1); // demande a entrer dans l'alliance
define('ALL_ETAT_NOOB', 2); // Peut pas utiliser le grenier, peut pas changer d'état
define('ALL_ETAT_OK', 3); // Peut utiliser le grenier 
define('ALL_ETAT_NOP', 4); // Peut pas utiliser le grenier
define('ALL_ETAT_INTD', 5); // intendant (accès grenier)
define('ALL_ETAT_DPL', 6); // diplomate (gestion des pactes)
define('ALL_ETAT_RECR', 7); // recruteur (accepter des membres)
define('ALL_ETAT_SECD', 8); // second
define('ALL_ETAT_CHEF', 9); // chef

/* etat des alliances = zrd_al.al_open */
define('ALLY_CLOSE',0); /* recrutement fermé */
define('ALLY_OPEN',1); /* recrutement ouvert */
define('ALLY_CREA',3); /* en cours de création */
define('ALLY_ZZZ',4); /* veille (dissolution?) */

/* achats du marché = zrd_mch?mch_etat */
define('COM_ETAT_ATT',1);
define('COM_ETAT_OK',2);
define('COM_ETAT_ACH',3);

/* Etat des bâtiments = zrd_btc.btc_etat */
define('BTC_ETAT_TODO', 1); // Construction
define('BTC_ETAT_OK', 2); // Fini
define('BTC_ETAT_DES', 3); // Désactivé
define('BTC_ETAT_REP', 4); // Réparation
define('BTC_ETAT_BRU', 5); // Brûle
define('BTC_ETAT_KO', 6); // détruit

/* Types d'unités = dans les fichiers de conf des races */
define('TYPE_UNT_CIVIL',1);
define('TYPE_UNT_INFANTERIE',2);
define('TYPE_UNT_CAVALERIE',3);
define('TYPE_UNT_DISTANCE',4);
define('TYPE_UNT_MAGIQUE',5);
define('TYPE_UNT_MACHINE',6);
define('TYPE_UNT_HEROS',7);
define('TYPE_UNT_DEMENAGEMENT',8);

/* Attaques = zrd_atq.atq_type */
define('ATQ_TYPE_DEF', 1);
define('ATQ_TYPE_ATQ', 2);

/* Légions = zrd_leg.leg_etat */
define('LEG_ETAT_VLG', 1); /* Le village */
define('LEG_ETAT_BTC', 2); /* Bâtiment */
define('LEG_ETAT_GRN', 3); /* En attente */
define('LEG_ETAT_POS', 4); /* En position d'attaque */
define('LEG_ETAT_DPL', 5); /* En déplacement pour attaquer */
define('LEG_ETAT_ALL', 6); /* En déplacement vers un allié */
define('LEG_ETAT_RET', 7); /* Retour (deplacement inarretable) */
define('LEG_ETAT_ATQ', 8); /* Attaque */

/* Etat des joueurs = zrd_mbr.mbr_etat */
define("MBR_ETAT_INSCR",0);
define("MBR_ETAT_OK",1);
define("MBR_ETAT_INI",2);
define("MBR_ETAT_ZZZ",3);

/* diplo : Etat des pactes = zrd_diplo.dpl_etat */
define("DPL_ETAT_PROP",0); // pacte proposé
define("DPL_ETAT_NO",1); // refusé
define("DPL_ETAT_ATT",2); // ok période probatoire
define("DPL_ETAT_OK",3); // ok appliqué
define("DPL_ETAT_FIN",4); // rompu

/* diplo : Type de pacte = zrd_diplo.dpl_type */
define("DPL_TYPE_PNA",1); // PNA
define("DPL_TYPE_MIL",2); // pacte militaire
define("DPL_TYPE_COM",3); // pacte commercial
define("DPL_TYPE_MC",4); // pacte militaire & commercial
define("DPL_TYPE_WAR",5); // déclaration de guerre

/* Carte = zrd_map.map_type */
define('MAP_LAC', 1);
define('MAP_EAU', 2);
define('MAP_FORET', 3);
define('MAP_MONTAGNE', 4);
define('MAP_HERBE', 5);
define('MAP_LIBRE', 6);
define('MAP_VILLAGE', 7);
/* modulo sur le map_rand */
define('MAP_MODULO', 1000);
define('MAP_MOD_EGERIA', 999);

define('PERIODS_AUBE', 1);
define('PERIODS_JOUR', 2);
define('PERIODS_CREP', 3);
define('PERIODS_NUIT', 4);


/* === Droits === */
/* Généraux */
define('DROIT_SITE',1); /* acceder au site */
define('DROIT_PLAY',2); /* jouer */
define('DROIT_MSG',3); /* utiliser la messagerie */
define('DROIT_MMSG',4); /* Envoyer plusieurs messages en même temps */
define('DROIT_NWS_CMT',5); /* poster un commentaire */
define('DROIT_NWS_MODO',6); /* modérer les commentaires */
define('DROIT_ADM',7); /* acceder au panneau d'admin */
define('DROIT_ADM_MBR',8); /* admin membres */
define('DROIT_ADM_AL',9); /* admin alliances */
define('DROIT_ADM_NWS',10); /* admin news = INUTILE */
define('DROIT_ADM_COM',11); /* admin commerce */
define('DROIT_ADM_TRAV',12); /* acceder au site en travaux */
define('DROIT_ANTI_FLOOD',13); /* anti-anti-flood */
define('DROIT_SDG',14); /* Lancer un sondage */
define('DROIT_ADM_EDIT', 15);
define('DROIT_SITE_NOTE', 16); /* Accèder aux notes ?UTILE? */
/* Forum */
define('DROIT_PUNBB_ADMIN', 20);
define('DROIT_PUNBB_MOD', 21);
define('DROIT_PUNBB_GUEST', 22);
define('DROIT_PUNBB_MEMBER', 23);

/* Groupes = zrd_mbr.mbr_gid */
define('GRP_VISITEUR',1);
define('GRP_EXILE',2);
define('GRP_JOUEUR',3);
define('GRP_SCRIBE',4);
define('GRP_NOBLE',5);
define('GRP_SAGE',6);
define('GRP_GARDE',7);
define('GRP_PRETRE',8);
define('GRP_DEMI_DIEU',9);
define('GRP_DIEU',10);
define('GRP_CHEF_REG',11);
define('GRP_EXILE_TMP',12);
define('GRP_DEV',13);
define('GRP_ADM_DEV',14);
define('GRP_CHAMP_REG',15);
define('GRP_PNJ',16);
define('GRP_EVENT',17);

/* Smileys */
// Tous les Smileys
$_smileys = array(
	's01.png'		=>	array(':)', ':-)'),
	's02.png'		=>	':p',
	's03.png'		=>	':??:',
	's04.png'		=>	':!!:',
	's05.png'		=>	':garde:',
	's06.png'		=>	array('^^', '^_^'),
	's07.png'		=>	':&gt;&lt;:',
	's08.png'		=>	':chevalier:',
	's09.png'		=>	array(';)', ';o)'),
	's10.png'		=>	array(':/', ':|'),
	's11.png'		=>	array(':-°', ':-*'),
	's12.png'		=>	array(':(', ':\'('),
	's13.png'		=>	array('&lt;_&lt;', '-_-'),
	's14.png'		=>	':D',
	's15.png'		=>	':lol:',
	's16.png'		=>	':humain:',
	's17.png'		=>	':nain:',
	's18.png'		=>	':orc:',
	's19.png'		=>	':elfe:',
	's20.png'		=>	':drow:',
	's26.png'		=>	':gob:',
	's21.png'		=>	':love:',
	's22.png'		=>	':songeur:',
	's23.png'		=>	':gné:',
	's24.png'		=>	'Oo',
	's25.png'		=>	':o:',
	's27.png'		=>	':zord:',

);

// Les images des Smileys de base
$_smileys_img_base = array(
	's01.png',
	's02.png',
	's03.png',
	's06.png',
	's08.png',
	's09.png',
	's12.png',
);


/*  Compétences  */	
define('CP_BOOST_OFF', 1);
define('CP_BOOST_DEF', 2);
define('CP_BOOST_OFF_DEF', 3);
define('CP_RESISTANCE', 4);
define('CP_VITESSE', 5);
define('CP_CASS_BAT', 6);
define('CP_REGENERATION', 7);
define('CP_TELEPORTATION', 8);
define('CP_SURVIVANT', 9);
define('CP_GUERISON', 10);
define('CP_RESURECTION', 11);
define('CP_INVISIBILITE', 12);
define('CP_VOLEE_DE_FLECHES', 13);
define('CP_GENIE_COMMERCIAL', 14);
define('CP_INVULNERABILITE', 15);
define('CP_COLLABORATION', 16);
define('CP_MURAILLES_LEGENDAIRES', 17);
define('CP_DEFENSE_EPIQUE', 18);
define('CP_PRODUCTIVITE', 19);
define('CP_FLECHES_SALVATRICES', 20);
define('CP_REGENERATION_ORC', 21);
//define('CP_LEVER_VOILE', 22); gobz quand il y aura le voile sur la carte comp off
define('CP_APPEL_CREATURE', 23);
define('CP_INGE_ACCRUE', 24);

/* Surveillance */
// Etat de la surveillance
define('SURV_OK', 1);
define('SURV_CLOSE', 2);

define('SURV_DUREE', 2592000);
// Type de surveillance
define('SURV_TYPE_ALY', 1); // Alliance
define('SURV_TYPE_IP',  2); // Ip
define('SURV_TYPE_MP',  3); // Message Privé
define('SURV_TYPE_FRM', 4); // Forum
define('SURV_TYPE_ALL', 5); // All

/* Votes */
define('VOTES_HIT', 1); // hit parade 
define('VOTES_RPG',  2); // RPG paradize
define('VOTES_TOP',  3); // xtreme top100
?>
