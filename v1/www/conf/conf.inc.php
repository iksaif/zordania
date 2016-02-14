<?
define('ZORD_VERSION',"1.7.1");

define('SITE_MAX_CONNECTED', 150);
define('SITE_MAX_INSCRITS', 7500);

define('SITE_URL', 'http://v1.zordania.com/');
$file = __FILE__;
$pos = strrpos($file, '/');
$dir = (is_integer($pos)) ? substr($file, 0, $pos + 1) : substr($file, 0, strrpos($file, '\\') + 1);
$dir = str_replace('conf\\','',$dir);
$dir = str_replace('conf/','',$dir);
define('SITE_DIR', $dir);

define('SITE_FLOOD_TIME',30);
define('SITE_WEBMASTER_MAIL','webmaster@zordania.com');

define('MYSQL_BASE', 'zordania');
define('MYSQL_URL', 'localhost');
define('MYSQL_LOGIN', 'zordania');
define('MYSQL_PASS', 'xxxxxxx');

define('USER_LANG','fr');
define('USER_RACE','1|2|3|4|5');

define('TYPE_UNT_CIVIL',1);
define('TYPE_UNT_INFANTERIE',2);
define('TYPE_UNT_MACHINE',3);
define('TYPE_UNT_CREATURE',4);

define('UNT_ROLE_CREATURE',1);
define('UNT_ROLE_INFANTERIE',2);
define('UNT_ROLE_MONTEE',3);
define('UNT_ROLE_DISTANCE',4);
define('UNT_ROLE_MACHINE',5);

define('GAME_MAX_BTC',1);
define('GAME_MAX_RES',50);
define('GAME_MAX_UNT',200);
define('GAME_MAX_SRC',5);

define('GAME_MAX_UNT_TOTAL', 1200);
define('GAME_MAX_BTC_TOTAL', 2000);

define('GAME_MAX_BONUS',1000);

define('GAME_MAX_UNT_BONUS',30);
define('GAME_MAX_BTC_BONUS',30);

define('GAME_A_MORT',false);

define('GAME_PRIO',4);

define('GAME_RES_BOUF',4);
define('GAME_RES_PLACE',22);
define('GAME_RES_PRINC',1);

define('MBR_LOGO_SIZE',10*1024);
define('MBR_LOGO_MAX_X_Y',80);
define('MBR_LOGO_TYPE','image/png|image/x-png');
define('MBR_LOGO_DIR',SITE_DIR.'img/mbr_logo/');
define('MBR_LOGO_URL',SITE_URL.'img/mbr_logo/');

define('ALL_MAX',12);
define('ALL_MIN_PTS',7000);
define('ALL_MIN_ADM_PTS',14000);
define('ALL_TAX',0.10);
define('ALL_MIN_DEP',5);
define('ALL_LOGO_SIZE',20*1024);
define('ALL_LOGO_MAX_X_Y',100);
define('ALL_LOGO_TYPE','image/png|image/x-png');
define('ALL_LOGO_DIR',SITE_DIR.'img/al_logo/');
define('ALL_LOGO_URL',SITE_URL.'img/al_logo/');
define('ALL_CREATE_PRICE',750);

define('SHOOT_LIMIT_PAGE',20);
define('SHOOT_LIMIT_NB_PAGE',15);

define('MAP_LIMITE_1',7000);
define('MAP_LIMITE_2',37000);

define('USER_INACTIF',864000);

define('MSG_DEL_OLD',60); //60 jours
define('HISTO_DEL_OLD',7); //7 jours

define('LIMIT_PAGE',15);
define('LIMIT_MBR_PAGE',50);
define('LIMIT_NB_PAGE',15);

define('FRM_LIMIT_PAGE',20);
define('FRM_LIMIT_NB_PAGE',15);
define('FRM_SHOW_POST_WHEN_REPLY',5);
define('FRM_SEARCH_FLOOD',15);
define('FRM_MAX_SEARCH_RESULT',30);
define('FRM_MAX_HL',5);

define('ATQ_NB_MAX_PER_DAY',10);
define('ATQ_BON_MIN',30);
define('ATQ_BON_MAX',10);
define('ATQ_DEL_OLD',864000);
define('ATQ_PTS_MIN',5000);
define('ATQ_PTS_RAP',0.5);
define('ATQ_PTS_DIFF',100000);
define('ATQ_LIM_DIFF',1);
define('ATQ_DETECT_DST',25);
define('ATQ_PERC_DEF',0.4);
define('ATQ_PERC_WIN',1);
define('ATQ_PERC_NUL',0.6);
define('ATQ_BUTIN_MIN',0);
define('ATQ_BUTIN_MDL',0.5);
define('ATQ_BUTIN_MAX',0.5);
define('ATQ_MAX_BTC',2);
define('ATQ_MAX_RES_NB',1000);
define('ATQ_COEF',5);
define('ATQ_PROD_BONUS',48);
define('ATQ_LIM_XP',150);

define('MCH_TMP',-rand(1,2));
define('MCH_MAX',300);

define('SITE_DEBUG',false);

define('MAP_W',450);
define('MAP_H',450);

define('COM_MAX_NB1',50);
define('COM_MAX_NB2',500);
define('COM_MAX_NB3',5000);
define('COM_MAX_VENTES1',3);
define('COM_MAX_VENTES2',6);
define('COM_MAX_VENTES3',12);
define('COM_TAUX_MIN',0.70);
define('COM_TAUX_MAX',1.30);
define('COM_TAX',10);

define('MIN_BONUS_NB',30);
define('ALLOPASS_AUTH','57799/149832/569972');

define('DROIT_RIEN',1);
define('DROIT_SITE',2);
define('DROIT_ADM_MBR',3);
define('DROIT_PLAY',4);
define('DROIT_ADM_CMT',5);
define('DROIT_ADM_NEWS',6);
define('DROIT_ADM_LOG',7);
define('DROIT_ADM_TRAV',8);
define('DROIT_FORUM',9);
define('DROIT_POST',10);
define('DROIT_EDIT',11);
define('DROIT_ADM_EDIT',12);
define('DROIT_FRM_GEN',13);
define('DROIT_FRM_JEU',14);
define('DROIT_FRM_EQP',15);
define('DROIT_FRM_ADM',16);
define('DROIT_ADM_FRM',17);
define('DROIT_ADM_COM',18);
define('DROIT_ANTI_FLOOD',19);

?>
