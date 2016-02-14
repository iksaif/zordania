<?php
/*
 * le new bot de zordania
 * CPU econome grace a smartirc
 * v2
 */

/* les constantes du jeu */
require_once('../../conf/conf.inc.php');
/* autoload gestion d'erreur et autres fonctions */
require_once(SITE_DIR . "lib/divers.lib.php");

define('IRC_CHAN_DEV', '#zorddev');

error_reporting (E_ALL | E_STRICT | E_RECOVERABLE_ERROR);
date_default_timezone_set("Europe/Paris");

/*
$date_format = "Y_m_d";
$log = new log(SITE_DIR .'logs/irc/log_irc_'.date($date_format).'.log', false, false); //On ouvre la gestion des logs
$date=date($date_format); //Pour avoir un fichier de log journalier
*/
include_once(SITE_DIR . 'lib/SmartIRC/SmartIRC.php');
$Net_SmartIRC = new Net_SmartIRC();

/* debug du bot : ceci n'est pas le log du chan */
$Net_SmartIRC->setDebug(SMARTIRC_DEBUG_ALL);
$Net_SmartIRC->setLogFile(SITE_DIR . '/tools/zordbot/ircbot.log');
$Net_SmartIRC->setLogdestination(SMARTIRC_FILE);


$Net_SmartIRC->setUseSockets(TRUE);
$Net_SmartIRC->setAutoReconnect(TRUE);
$Net_SmartIRC->setAutoRetry(TRUE);
$Net_SmartIRC->setChannelSyncing(TRUE); // track all users

/* compter le nombre de relances */
$instance = ( isset($argv[1]) ? (int) $argv[1] : 1);



/*
// enregistrer des réponses à de messages
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!ops', $mybot, 'op_list');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!kick', $mybot, 'kick');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!time', $mybot, 'saytime_once');
// log tout ce qui est dit sur le chan
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '.*', $mybot, 'logging');
// message d'accueil
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_JOIN, '.*', $mybot, 'onjoin_greeting');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!quit', $mybot, 'quit');
$Net_SmartIRC->registerActionhandler(SMARTIRC_TYPE_QUERY|SMARTIRC_TYPE_NOTICE, '^test', $mybot, 'query_test');

// register saytime() to be called every 5 x 60 sec. (300,000 milliseconds)
$Net_SmartIRC->registerTimehandler(300000, $mybot, 'saytime');
// register saytime_once() to be called in 10 sec. (10,000 milliseconds) and save the assigned id
// which is needed for unregistering the timehandler.
$saytime_once_id = $Net_SmartIRC->registerTimehandler(10000, $mybot, 'saytime_once');
*/

$chan_actions = array(
	'op' => 'op', // [chan] nick
	'deop' => 'deop',
	'voice' => 'voice',
	'devoice' => 'devoice',
	'kick' => 'kick', // (raison?)
	'invite' => 'invite',
	'ban' => 'ban', // (raison?)
	'topic' => 'setTopic', // topic
	'ops' => 'op_list',
	'quit' => 'quit',
	'reboot' => 'restart',
	'join' => 'join',
	'part' => 'part',
);

 
$Net_SmartIRC->connect(IRC_SERVER, IRC_PORT);
$Net_SmartIRC->login(IRC_PSEUDO, 'Net_SmartIRC Client '.SMARTIRC_VERSION.' pour zordania.com', 0, IRC_USER);
// identification sur Q@CServe.quakenet.org
$Net_SmartIRC->message(SMARTIRC_TYPE_QUERY, "Q@CServe.quakenet.org", "auth ".IRC_USER." ".IRC_PASS);

$mybot = new bot(IRC_CHAN, $Net_SmartIRC, $instance);

// appele Q sur le chan de test
//$Net_SmartIRC->message(SMARTIRC_TYPE_QUERY, "R", "REQUESTBOT " . IRC_CHAN_DEV);


/* juste pour test */
$Net_SmartIRC->setModulepath(SITE_DIR .'lib/SmartIRC/modules');
$Net_SmartIRC->loadModule('exemple');


$Net_SmartIRC->listen();
$Net_SmartIRC->disconnect();

die('fin bot irc OK');

?>
