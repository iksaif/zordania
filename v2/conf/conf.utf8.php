<?
/* === Configuration Serveur === */
define('MYSQL_BASE', 'zordv2');
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'zordania');
define('MYSQL_PASS', 'xxxxxxxx');
define('MYSQL_PREBDD', 'zrd_');
define('MYSQL_PREBDD_FRM', MYSQL_PREBDD.'frm_');

/* === Configuration Site === */
define('ZORD_VERSION',"2.0.8");
define('ZORD_SPEED_VFAST', 0.16667); // 1 Tour toutes les 30sec
define('ZORD_SPEED_FAST', 5); // 1 Tour toutes les 5 minutes
define('ZORD_SPEED_NORMAL', 30); // 1 Tour par demie heure
define('ZORD_SPEED_SLOW',60); // 1 Tour par heures
define('ZORD_SPEED', ZORD_SPEED_SLOW);

/* === Configuration IRC === */
define('IRC_SERVER','irc.quakenet.org');
define('IRC_PORT',6667);
define('IRC_CHAN', '#zordania');
define('IRC_PSEUDO', 'Barnabe');
define('IRC_PASS', 'xxxxxxxx');
define('IRC_USER', 'zordania');

define('SITE_MAX_CONNECTED', 300);
define('SITE_MAX_INSCRITS', 10000);

$host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : "www.zordania.com";
define('SITE_URL', "http://".$host."/");
define('SITE_DIR', str_replace('conf','',dirname(__FILE__))."/");
define('WWW_DIR', SITE_DIR . "www/");
define('ZORDLOG_URL', 'archives.zordania.com'); // URL des archives

define('SITE_WEBMASTER_MAIL','webmaster@zordania.com');

define('GEN_LENGHT',6); /* Taille des chaines générées aléatoirement (pass, etc ...) */

/* ==== Utilisateurs === */
define('SITE_FLOOD_TIME',30); /* Temps en seconde pour écrire deux messages a la suite */
define('TAILLE_MAX_LOGIN', 50); /* Nombre de caractères max d'un login : limité par les caractéristiques du champ correspondant dans la BDD */
define('TAILLE_MAX_PSEUDO', 50); /* Nombre de caractères max d'un pseudo : limité par les caractéristiques du champ correspondant dans la BDD */
define('TAILLE_MAX_MAIL', 50); /* Nombre de caractères max d'une adresse mail : limité par les caractéristiques du champ correspondant dans la BDD */

/* === Configuration Jeu === */

/* Nombre maximum en todo */
define('TODO_MAX_BTC',1);
define('TODO_MAX_RES',80);
define('TODO_MAX_UNT',80);
define('TODO_MAX_SRC',5);

/* Nombre max */
define('TOTAL_MAX_UNT', 700);

/* Donjon */
// Distance à partir de laquelle une légion est visible dans le donjon
define('DST_VIEW_MAX', 50);

/* Légion */
define('LEG_MAX_NB', 40);
define('LEG_MAX_RANG', 22);
define('LEG_MAX_RANG_UNT', 700);
define('LEG_MAX_RANG_SAME_UNT', 1);

/* Ressource principale (pour le commerce) */
define('GAME_RES_PRINC',1);
/* Nourriture */
define('GAME_RES_BOUF',4);

/* Logo */
define('MBR_LOGO_SIZE',20*1024);
define('MBR_LOGO_MAX_X_Y',80);
define('MBR_LOGO_TYPE','image/png|image/x-png');
define('MBR_LOGO_DIR',SITE_DIR.'www/img/mbr_logo/');
define('MBR_LOGO_URL',SITE_URL.'img/mbr_logo/');

/* Points */
define('MBR_NIV_1',7000);
define('MBR_NIV_2',35000);

/* Alliance */
define('ALL_MAX',12); // Nombre maximum de joueurs
define('ALL_MIN_PTS', 7000); // Points pour entrer
define('ALL_MIN_ADM_PTS', 10000); // Points pour créer une alliance
define('ALL_CREATE_PRICE', 1000); // Prix pour créer une alliance
define('ALL_JOIN_PRICE', 200); //Prix pour rejoindre une alliance
define('ALL_NOOB_TIME', 3); // Temps en jour pendant le quel on reste "NOOB"
define('ALL_MIN_DEP', 10); // Dépot minimal

define('ALL_TAX',10); // Taxe du grenier (%)
define('ALL_SEUIL_PILLAGE', 200); //En dessous de 200 on ne considère pas un retrait comme un pillage potentiel

define('ALL_LOGO_SIZE',20*1024);
define('ALL_LOGO_MAX_X_Y',100);
define('ALL_LOGO_TYPE','image/png|image/x-png');
define('ALL_LOGO_DIR',SITE_DIR.'www/img/al_logo/');
define('ALL_LOGO_URL',SITE_URL.'img/al_logo/');

define('SHOOT_LIMIT_PAGE',20);
define('SHOOT_LIMIT_NB_PAGE',15);

$_limite_grenier = array(
						 1 =>  4294967295,   // # Or
						 2 =>  120000,        // # Bois
						 3 =>  120000,        // # Pierre
						 4 =>  1200000,      // # Nourriture
						 5 =>  25000,        // # Fer
						 6 =>  25000,        // # Charbon
						 7 =>  4500,         // # Chevaux
						 8 =>  10000,        // # Acier
						 9 =>  8000,         // # Mithril
						 10 => 4500,         // # Bouclier en bois
						 11 => 4500,         // # Bouclier en acier
						 12 => 4500,         // # Epee
						 13 => 4500,         // # Epee longue
						 14 => 4500,         // # Arc
						 15 => 4500,         // # Arbalete
						 16 => 4500,         // # Cotte de mail
						 17 => 4500          // # Cotte de mithril
						 );

/* Attaques */
define('ATQ_MAX_NB24H', 5);
define('ATQ_PTS_DIFF', 3200);  /* Trop de points de différences */
define('ATQ_PTS_MIN', 50);  /* Pas assez de points armée pour attaquer */
define('ATQ_LIM_DIFF', 24000); /* Arène  =>  dépends des points armée */
define('ATQ_RATIO_COEF_ATQ', 7); /* dégats créé par l'attaquant */
define('ATQ_RATIO_COEF_DEF', 8); /* dégats créé par le défenseur */
define('ATQ_RATIO_COEF_BAT', 0.6); /* dégats batiments */
define('ATQ_RATIO_HEROS', 1.3); /* % perte dégats PDV héros */
define('ATQ_RATIO_DIST', 33); /* bonus unités à distance $nb*log($nb)/[ratio] */
define('ATQ_FAT', 5); /* inutile ici */

/* Butins */
define('BUT_PILLAGE_COEF', 4); // On ne peux piller au maximum que le ($stock_d'une_ressource / BUT_PILLAGE_COEF)

/* Mise en veille (en jours)
 * Conseillé : ZZZ_TRIGGER >= ZZZ_MIN
 */
define('ZZZ_TRIGGER',7); // Temps de mise en veille automatique
define('ZZZ_MIN',6); // Durée minimale de mise en veille

/* Limites de points pour afficher un donjon ou une forteresse */
define('MAP_REGIONS', 9); /* Divisé en 9 */
/* News */
define('NWS_LIMIT_PAGE',5);

/* Limites de pages */
define('LIMIT_PAGE',15);
define('LIMIT_MBR_PAGE',50);
define('LIMIT_NB_PAGE',15);

/* Messages */
define('MSG_DEL_OLD',30); //60 jours
define('MSG_FLOOD_TIME',30); /* 30 secondes */
define('MSG_MAX_MMSG',5); /* Max de multi messages */
/* mid qui envoie le msg d'accueil cf ini/page.php */
define('MBR_WELC', 6791 );

/* Historique */
define('HISTO_DEL_OLD',7); //7 jours
define('HISTO_DEL_LOG_ALLY', 15); // 15 jours

/* Commerce */
define('MCH_ACCEPT',4); //Nombre de tours avant acceptation (avec un petit rand() dans le cron)
define('MCH_MAX',300); //Nombre de tours max
define('MCH_COURS_MIN',1);
define('MCH_OLD',30); //calcul des cours du marché sur NB jours (les ventes plus vieilles sont supprimées)

define('COM_MAX_NB1',75);
define('COM_MAX_NB2',750);
define('COM_MAX_NB3',5000);
define('COM_MAX_VENTES1',6);
define('COM_MAX_VENTES2',12);
define('COM_MAX_VENTES3',24);
define('COM_TAUX_MIN',0.80);
define('COM_TAUX_MAX',1.20);
define('COM_TAX',10);
define('COM_NEGO_TAUX',10);

/* Carte */
define('MAP_W',500);
define('MAP_H',500);

/* Allopass */
define('GAME_MAX_BONUS',1000);
define('MIN_BONUS_NB',30);

/* Bâtiments */
define('BTC_BRU_PERC', 95);

/* Parrains */
define('PARRAIN_GRD1', 5);
define('PARRAIN_GRD2', 20);
define('PARRAIN_GRD3', 50);
define('PARRAIN_BONUS_PRC', 5);

/* === Constantes === */
define('ALL_ETAT_NULL',0);  // pas dans une alliance
define('ALL_ETAT_DEM', 1); // demande a entrer dans l'alliance
define('ALL_ETAT_NOOB', 2); // Peut pas utiliser le grenier, peut pas changer d'état
define('ALL_ETAT_OK', 3); // Peut utiliser le grenier 
define('ALL_ETAT_NOP', 4); // Peut pas utiliser le grenier

define('COM_ETAT_ATT',1);
define('COM_ETAT_OK',2);
define('COM_ETAT_ACH',3);

/* Etat des bâtiments */
define('BTC_ETAT_TODO', 1); // Construction
define('BTC_ETAT_OK', 2); // Fini
define('BTC_ETAT_DES', 3); // Désactivé
define('BTC_ETAT_REP', 4); // Réparation
define('BTC_ETAT_BRU', 5); // Brûle
define('BTC_ETAT_KO', 6); // détruit

/* Types d'unités */
define('TYPE_UNT_CIVIL',1);
define('TYPE_UNT_INFANTERIE',2);
define('TYPE_UNT_CAVALERIE',3);
define('TYPE_UNT_DISTANCE',4);
define('TYPE_UNT_MAGIQUE',5);
define('TYPE_UNT_MACHINE',6);
define('TYPE_UNT_HEROS',7);

/* Attaques */
define('ATQ_TYPE_DEF', 1);
define('ATQ_TYPE_ATQ', 2);
/* coefficient de dÃ©fense groupÃ©e: modules/war/page.php */
$cst_ratio_def = array(0 => 1, 1 => 0.5, 2 => 0.33);

/* Légions */
define('LEG_ETAT_VLG', 1); /* Le village */
define('LEG_ETAT_BTC', 2); /* BÃ¢timent */
define('LEG_ETAT_GRN', 3); /* En attente */
define('LEG_ETAT_POS', 4); /* En position d'attaque */
define('LEG_ETAT_DPL', 5); /* En dÃ©placement pour attaquer */
define('LEG_ETAT_ALL', 6); /* En dÃ©placement vers un alliÃ© */
define('LEG_ETAT_RET', 7); /* Retour (deplacement inarretable) */
define('LEG_ETAT_ATQ', 8); /* Attaque */

/* Etat des joueurs */
define("MBR_ETAT_INSCR",0);
define("MBR_ETAT_OK",1);
define("MBR_ETAT_INI",2);
define("MBR_ETAT_ZZZ",3);

/* diplo : Etat des pactes */
define("DPL_ETAT_PROP",0); // pacte proposé
define("DPL_ETAT_NO",1); // refusé
define("DPL_ETAT_ATT",2); // ok période probatoire
define("DPL_ETAT_OK",3); // ok appliqué
define("DPL_ETAT_FIN",4); // rompu

/* diplo : Type de pacte */
define("DPL_TYPE_PNA",1); // PNA
define("DPL_TYPE_MIL",2); // pacte militaire
define("DPL_TYPE_COM",3); // pacte commercial
define("DPL_TYPE_MC",4); // pacte militaire & commercial

/* Carte */
define('MAP_LAC', 1);
define('MAP_EAU', 2);
define('MAP_FORET', 3);
define('MAP_MONTAGNE', 4);
define('MAP_HERBE', 5);
define('MAP_LIBRE', 6);
define('MAP_VILLAGE', 7);

/* Historique */
define('HISTO_HRO_CP',1);
define('HISTO_COM_ACH',11);
define('HISTO_BTC_OK',21);
define('HISTO_BTC_REP',22);
define('HISTO_BTC_BRU',23);
define('HISTO_SRC_DONE',31);
define('HISTO_LEG_ARV', 41);
define('HISTO_LEG_ATQ_VLG', 42);
define('HISTO_LEG_ATQ_LEG', 43);
define('HISTO_LEG_VIDE_BACK', 44);
define('HISTO_MSG_NEW',51);
define('HISTO_UNT_BOUFF',61);
define('HISTO_PARRAIN_BONUS',71);

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
define('DROIT_ADM_NWS',10); /* admin news */
define('DROIT_ADM_COM',11); /* admin commerce */
define('DROIT_ADM_TRAV',12); /* acceder au site en travaux */
define('DROIT_ANTI_FLOOD',13); /* anti-anti-flood */
define('DROIT_SDG',14); /* Lancer un sondage */
define('DROIT_ADM_EDIT', 15);
define('DROIT_SITE_NOTE', 16); /* Accèder aux notes */

/* Forum */
define('DROIT_PUNBB_ADMIN', 20);
define('DROIT_PUNBB_MOD', 21);
define('DROIT_PUNBB_GUEST', 22);
define('DROIT_PUNBB_MEMBER', 23);

/* Groupes */
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

/* Langues disponibles */
$_langues = array('unknown' => 'fr_FR', 'fr' => 'fr_FR');
/* Races */
$_races = array(1,2,3,4,5);
$_races_aly = array(1 => array(1 => 12, 2 => 12, 3 => 12, 4 => 12, 5 => 12),
				2 => array(1 => 12, 2 => 12, 3 => 12, 4 => 12, 5 => 12),
				3 => array(1 => 12, 2 => 12, 3 => 12, 4 => 12, 5 => 12),
				4 => array(1 => 12, 2 => 12, 3 => 12, 4 => 12, 5 => 12),
				5 => array(1 => 12, 2 => 12, 3 => 12, 4 => 12, 5 => 12)
);
$_css = array(4,3,2,1,14,10,11,15,16);
$_forum_css = array(1 => "marron", 2 => "metal", 3 => "classik", 4 => "zord2",
		    10 => "elficnight", 11 => "elfpower", 14 => "brown_underground",
		    15 => "last_hope");

$_regions = array(1 => array(1 => 25, 2 => 10, 3 => 0, 4 => 0, 5 => 65),
				2 => array(1 => 10, 2 => 50, 3 => 0, 4 => 30, 5 => 10),
				3 => array(1 => 0, 2 => 20, 3 => 40, 4 => 40, 5 => 0),
				4 => array(1 => 15, 2 => 20, 3 => 25, 4 => 0, 5 => 40),
				5 => array(1 => 25, 2 => 15, 3 => 40, 4 => 20, 5 => 0),
				6 => array(1 => 0, 2 => 0, 3 => 30, 4 => 50, 5 => 20),
				7 => array(1 => 25, 2 => 35, 3 => 0, 4 => 0, 5 => 40),
				8 => array(1 => 40, 2 => 35, 3 => 10, 4 => 15, 5 => 0),
				9 => array(1 => 60, 2 => 0, 3 => 20, 4 => 20, 5 => 0));

$_fat = array(1 => 40, 2 => 42, 3 => 60, 4 => 36, 5 => 35);

/* Droits */
$_droits = array();
$_droits[GRP_VISITEUR] = array(DROIT_SITE, DROIT_PUNBB_GUEST);
$_droits[GRP_EXILE] = array();
$_droits[GRP_EXILE_TMP] = array(DROIT_SITE, DROIT_MSG, DROIT_PUNBB_GUEST, DROIT_SITE_NOTE);
$_droits[GRP_JOUEUR] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER);
$_droits[GRP_CHEF_REG] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER);
$_droits[GRP_CHAMP_REG] = array(DROIT_SITE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER);
$_droits[GRP_SCRIBE] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER);
$_droits[GRP_NOBLE] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER);
$_droits[GRP_SAGE] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT,  DROIT_PUNBB_MEMBER, DROIT_ANTI_FLOOD);
$_droits[GRP_GARDE] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER, DROIT_ANTI_FLOOD, DROIT_ADM, DROIT_ADM_AL, DROIT_ADM_MBR);
$_droits[GRP_PRETRE] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER,DROIT_PUNBB_MOD, DROIT_ANTI_FLOOD, DROIT_ADM_NWS);
$_droits[GRP_DEV] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_NWS_CMT, DROIT_PUNBB_MEMBER, DROIT_PUNBB_MOD, DROIT_ADM, DROIT_ADM_TRAV);
$_droits[GRP_ADM_DEV] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_MMSG, DROIT_NWS_CMT,
	DROIT_ADM, DROIT_ADM_AL, DROIT_ADM_NWS, DROIT_ADM_COM, DROIT_ADM_MBR, DROIT_ADM_TRAV, DROIT_ADM_EDIT,
	DROIT_PUNBB_MEMBER,DROIT_PUNBB_MOD,DROIT_PUNBB_ADMIN, DROIT_SDG,DROIT_ANTI_FLOOD);
$_droits[GRP_DEMI_DIEU] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_MMSG, DROIT_NWS_CMT,
	DROIT_ADM, DROIT_ADM_AL, DROIT_ADM_NWS, DROIT_ADM_COM, DROIT_ADM_MBR, DROIT_ADM_EDIT,
	DROIT_PUNBB_MEMBER,DROIT_PUNBB_MOD,DROIT_PUNBB_ADMIN, DROIT_SDG,DROIT_ANTI_FLOOD);
$_droits[GRP_DIEU] = array(DROIT_SITE, DROIT_SITE_NOTE, DROIT_PLAY, DROIT_MSG, DROIT_MMSG, DROIT_NWS_CMT,
	DROIT_ADM, DROIT_ADM_AL, DROIT_ADM_NWS, DROIT_ADM_COM, DROIT_ADM_MBR, DROIT_ADM_TRAV,DROIT_SDG, DROIT_ADM_EDIT,
	DROIT_PUNBB_MEMBER,DROIT_PUNBB_MOD,DROIT_PUNBB_ADMIN, DROIT_ANTI_FLOOD);

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
	's21.png'		=>	':love:',
	's22.png'		=>	':songeur:',
	's23.png'		=>	':gné:',
	's24.png'		=>	'Oo',
	's25.png'		=>	':o:',
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

/*if(isset($_GET['kdebug']))
	define('SITE_DEBUG',true);
	else*/
define('SITE_DEBUG',false);
define('SITE_TRAVAUX',false);
// CRON ou INTERNET ?
define('CRON', substr(php_sapi_name(), 0, 3) == 'cli');

?>
