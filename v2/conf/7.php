<?php
/* Defines */
define("R7_OR", 1);
define("R7_BOIS", 2);
define("R7_GRANIT", 3);
define("R7_LICHEN", 4);
define("R7_ADAMANTITE", 5);
define("R7_SARONITE", 6);
define("R7_TORTUE", 7);
define("R7_ACIER", 8);
define("R7_MITHRIL", 9);
define("R7_BOUCLIER_ROND", 10);
define("R7_CASQUE", 11);
define("R7_BATON", 12);
define("R7_CIMETERRE", 13);
define("R7_FRONDE", 14);
define("R7_LANCE", 15);
define("R7_BRIGANDINE", 16);
define("R7_COTTE_MITHRIL", 17);

define("T7_FORET", 1);
define("T7_GIS_ADAM", 2);
define("T7_GIS_SARO", 3);
define("T7_FILON_OR", 4);
define("T7_MONTAGNE", 5);

define("B7_RUINE_OUBLIEE", 1);
define("B7_MINE_GRANIT", 2);
define("B7_CABANE", 3);
define("B7_SOUTERRAIN", 4);
define("B7_TANIERE", 5);
define("B7_HONNEUR", 6);
define("B7_PHILOSOPHALE", 7);
define("B7_CARREFOUR", 8);
define("B7_ARSENAL", 9);
define("B7_SONDEUR_ABYSSAL", 10);
define("B7_GIS_ADAM", 11);
define("B7_GIS_SARO", 12);
define("B7_ACIERIE", 13);
define("B7_INGE", 14);
define("B7_MINE_PROF", 15);
define("B7_TOURS", 16);
define("B7_TOUR_SAGE", 17);
define("B7_TOUR_HERO", 18);
define("B7_TRANSMU", 19);
define("B7_CANYON_PROF", 20);
define("B7_LAC_SOUT", 21);
define("B7_RUINE_RENFORCEE", 22);


define("U7_RESCAPE", 1);
define("U7_ARTISAN", 2);
define("U7_COLLECTEUR", 3);
define("U7_CHASSEUR", 4);
define("U7_GOB_BRIG", 5);
define("U7_RECRUTEUR", 6);
define("U7_DRESSEUR", 7);
define("U7_INGENIEUR", 8);
define("U7_GOB_SOLDAT", 9);
define("U7_GOB_FRONDEUR", 10);
define("U7_HOB_GOB", 11);
define("U7_OGRE", 12);
define("U7_SEMI_OGRE", 13);
define("U7_CERBERE", 14);
define("U7_GNOME_PROF", 15);
define("U7_ZEPPELIN", 16);
define("U7_GOBLOURS", 17);
define("U7_BATRASOG", 18);
define("U7_FREMLIN", 19);
define("U7_MAGE_GOB", 20);
define("U7_DRUIDE", 21);
define("U7_KAMIKAZE", 22);
define("U7_TYRAN", 23);
define("U7_HOBGOB_OFF", 24);
define("U7_CHEVAUCH_TORT", 25);
define("U7_MEDUSA", 26);
define("U7_TAUPE", 27);

define("S7_PIERRE_PHILO", 1);
define("S7_COM_1", 2);
define("S7_COM_2", 3);
define("S7_COM_3", 4);
define("S7_ARMES_POING", 5);
define("S7_ARMES_DIST", 6);
define("S7_ARME_DEF", 7);
define("S7_EXPLO_SURFACE", 8);
define("S7_RECRUTEMENT_AVANCE", 9);
define("S7_DRESSAGE", 10);
define("S7_FONTE_ACIER", 11);
define("S7_MAGIE_CHAMAN", 12);
define("S7_TRANSMUTEUR", 13);
define("S7_RENOVATION", 14);
define("S7_EXPLO_PROF", 15);
define("S7_EXPLO_AQUA", 16);
define("S7_RENFORT_COLL", 17);
define("S7_GENERALISSIME", 18);
define("S7_CREATURE_DESTRUCTRICE", 20);
define("S7_DRESSEUR_EXP", 19);
define("S7_FORAGE", 21);

class config7
{
var $res = array();
var $trn = array();
var $btc = array();
var $unt = array();
var $src = array();
var $comp = array();
var $race_cfg = array();

function config7()
{
 
/*
*	Ressources
*	Nom			Type				Fonction
*	need_btc		uint				Btiment dans le quel c'est construit
*	need_src		uint				A besoin de la recherche
*	prix_res		array(uint=>uint)		Prix type => nombre
*	group			uint				Est dans le groupe
*	cron			bool				Ne peut tre produit que par un cron
*/

//<res>
$this->res[R7_OR]=array(
		"cron"	=>	true,
		"prix_res"	=>	array(R7_GRANIT => 2),
		"need_btc"	=>	B7_PHILOSOPHALE
);

$this->res[R7_BOIS]=array(
		"cron"	=>	true,
		"need_btc"	=>	B7_CABANE
);


$this->res[R7_GRANIT]=array(
		"cron"	=>	true,
		"need_btc"	=>	B7_MINE_GRANIT
);

$this->res[R7_LICHEN]=array(
		"cron"	=>	true,
		"need_btc"	=>	B7_SOUTERRAIN
);

$this->res[R7_ADAMANTITE]=array(
		"cron"	=>	true,
		"need_btc"	=>	B7_GIS_ADAM
);

$this->res[R7_SARONITE]=array(
		"cron"	=>	true,
		"need_btc"	=>	B7_GIS_SARO
);

$this->res[R7_TORTUE]=array(
		"prix_res"	=>	array(R7_LICHEN => 150, R7_ADAMANTITE => 1, R7_SARONITE => 1),
		"need_btc"	=>	B7_MINE_PROF,
		"group"	=>	7,
);

$this->res[R7_ACIER]=array(
		"cron"	=>	true,
		"prix_res"	=>	array(R7_ADAMANTITE => 2, R7_SARONITE => 2),
		"need_btc"	=>	B7_ACIERIE,
		"group"	=>	1,
);
		
$this->res[R7_MITHRIL]=array(
		"prix_res"	=>	array(R7_ACIER => 1, R7_OR => 3,),
		"need_btc"	=>	B7_TRANSMU,
		"group"	=>	1,
);

$this->res[R7_BOUCLIER_ROND]=array(
		"prix_res"	=>	array(R7_BOIS => 1),
		"need_src"	=>	array(S7_ARME_DEF, S7_FONTE_ACIER),
		"need_btc"	=>	B7_ARSENAL,
		"group"	=>	1,
);
		
$this->res[R7_CASQUE]=array(
		"prix_res"	=>	array(R7_ACIER => 2),
		"need_src"	=>	array(S7_ARMES_POING),
		"need_btc"	=>	B7_ACIERIE,
		"group"	=>	1,
);
	
$this->res[R7_BATON]=array(
		"prix_res"	=>	array(R7_BOIS => 2), 
		"need_btc"	=>	B7_ARSENAL,
		"need_src"	=>	array(S7_ARME_DEF),
		"group"	=>	1,
);
	
$this->res[R7_CIMETERRE]=array(
		"prix_res"	=>	array(R7_BOIS => 1, R7_SARONITE => 1, R7_ADAMANTITE => 1),
		"need_btc"	=>	B7_ACIERIE,
		"need_src"	=>	array(S7_FONTE_ACIER),
		"group"	=>	1,
);

$this->res[R7_FRONDE]=array(
		"prix_res"	=>	array(R7_BOIS => 2),
		"need_btc"	=>	B7_ARSENAL,
		"need_src"	=>	array(S7_ARMES_POING),
		"group"	=>	1,
);
		
$this->res[R7_LANCE]=array(
		"prix_res"	=>	array(R7_BOIS => 1,R7_ACIER => 2,),
		"need_src"	=>	array(S7_ARMES_DIST),
		"need_btc"	=>	B7_ACIERIE,
		"group"	=>	2,
);
	
$this->res[R7_BRIGANDINE]=array(
		"prix_res"	=>	array(R7_ACIER => 2),
		"need_btc"	=>	B7_ACIERIE,
		"need_src"	=>	array(S7_FONTE_ACIER),
		"group"	=>	2,
);

$this->res[R7_COTTE_MITHRIL]=array(
		"prix_res"	=>	array(R7_MITHRIL => 1,R7_BRIGANDINE => 1),
		"need_btc"	=>	B7_TRANSMU,
		"need_src"	=>	array(S7_TRANSMUTEUR),
		"group"	=>	1,
);
//</res>

//<trn>
$this->trn[T7_FORET] = array();
$this->trn[T7_GIS_ADAM] = array();
$this->trn[T7_GIS_SARO] = array();
$this->trn[T7_FILON_OR] = array();
$this->trn[T7_MONTAGNE] = array();
//</trn>

/*
*	Batiment
*	Nom			Type				Fonction
*	bonusdef		uint				Bonus de d?ence
*	vie			uint				Points de vie du btc
*	population		uint				Crée x places
*	tours			uint				Met x tour a être construit
*	com			array()				Recherche => array(quantitée, vente)
*/

//<btc>
//<btc-1>
$this->btc[B7_RUINE_OUBLIEE] = array(
	'vie' => 1000,
	'prod_pop' => 20,
	"bonus" 	=>  array('gen' => 300, 'bon' => 4),
	'tours' => 500,
	'limite' => 1,
	'prix_res' => array(R7_OR => 1500, R7_BOIS => 2250, R7_GRANIT => 2250, R7_ACIER => 200, ),
	'prod_src' => 1,
	'prod_unt' => 4,
);
//</btc-1>

//<btc-2>
$this->btc[B7_MINE_GRANIT] = array(
	'vie' => 200,
	'tours' => 5,
	'prix_res' => array(R7_BOIS => 5, R7_GRANIT => 6, ),
	'prix_trn' => array(T7_MONTAGNE => 1, ),
	'prix_unt' => array(U7_RESCAPE => 1, ),
	'prod_res_auto' => array(R7_GRANIT => 4, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</btc-2>

//<btc-3>
$this->btc[B7_CABANE] = array(
	'vie' => 200,
	'tours' => 5,
	'prix_res' => array(R7_BOIS => 5, R7_GRANIT => 8, ),
	'prix_trn' => array(T7_FORET => 1, ),
	'prix_unt' => array(U7_COLLECTEUR => 1, ),
	'prod_res_auto' => array(R7_BOIS => 2, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</btc-3>

//<btc-4>
$this->btc[B7_SOUTERRAIN] = array(
	'vie' => 175,
	'prod_pop' => 17,
	'tours' => 6,
	'prix_unt' => array(U7_CHASSEUR => 1, ),
	'limite' => 50,
	'prix_res' => array(R7_BOIS => 12, R7_GRANIT => 18, ),
	'prod_res_auto' => array(R7_LICHEN => 10, ),
	'need_btc' => array(B7_MINE_GRANIT, B7_CABANE, ),
);
//</btc-4>

//<btc-5>
$this->btc[B7_TANIERE] = array(
	'vie' => 350,
	'tours' => 7,
	'limite' => 25,
	'prix_res' => array(R7_BOIS => 80, R7_GRANIT => 150, R7_TORTUE => 4,),
	'prix_unt' => array(U7_CHASSEUR => 1, ),
	'prod_res_auto' => array(R7_LICHEN => 20, ),
	'need_src' => array(S7_RENFORT_COLL),
);
//</btc-5>

//<btc-6>
$this->btc[B7_HONNEUR] = array(
	'vie' => 500,
	'tours' => 30,
	'limite' => 4,
	'prix_res' => array(R7_BOIS => 90, R7_GRANIT => 130, ),
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'need_src' => array(S7_RECRUTEMENT_AVANCE, ),
	"prod_unt"	=>	2,
);
//</btc-6>

//<btc-7>
$this->btc[B7_PHILOSOPHALE] = array(
	'vie' => 200,
	'tours' => 30,
	'prix_res' => array(R7_BOIS => 45, R7_GRANIT => 50, ),
	'prix_unt' => array(U7_COLLECTEUR => 1, ),
	'prod_res_auto' => array(R7_OR => 1, ),
	'need_src' => array(S7_EXPLO_SURFACE, S7_PIERRE_PHILO),
);
//</btc-7>

//<btc-8>
$this->btc[B7_CARREFOUR] = array(
	'vie' => 400,
	'tours' => 100,
	'limite' => 2,
	'prix_res' => array(R7_BOIS => 100, R7_GRANIT => 150, ),
	'prix_unt' => array(U7_INGENIEUR => 1, ),
	'need_src' => array(S7_COM_1, ),
	'need_btc' => array(B7_SONDEUR_ABYSSAL ),
	'com' 	=> array(S7_COM_1 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
						S7_COM_2 => array(COM_MAX_NB2,COM_MAX_VENTES2),
						S7_COM_3 => array(COM_MAX_NB3,COM_MAX_VENTES3))
);
//</btc-8>

//<btc-9>
$this->btc[B7_ARSENAL] = array(

	'vie' => 500,
	'tours' => 150,
	'limite' => 2,
	'prix_res' => array(R7_BOIS => 70, R7_GRANIT => 110, ),
	'prix_unt' => array(U7_ARTISAN => 1, ),
	'need_btc' => array(B7_SONDEUR_ABYSSAL, ),
	"prod_res"	=>	true,
);
//</btc-9>

//<btc-10>
$this->btc[B7_SONDEUR_ABYSSAL] = array(
	'vie' => 500,
	'tours' => 150,
	'limite' => 2,
	'prix_res' => array(R7_OR => 50, R7_BOIS => 100, R7_GRANIT => 100, ),
	'prix_unt' => array(U7_INGENIEUR => 8, ),
	'prod_src' => 1,
	'need_src' => array(S7_EXPLO_SURFACE, S7_RECRUTEMENT_AVANCE),
);
//</btc-10>

//<btc-11>
$this->btc[B7_GIS_ADAM] = array(
	'vie' => 200,
	'tours' => 100,
	'prix_res' => array(R7_BOIS => 50, R7_GRANIT => 120, ),
	'prix_trn' => array(T7_GIS_ADAM => 1, ),
	'prix_unt' => array(U7_ARTISAN => 1, ),
	'prod_res_auto' => array(R7_ADAMANTITE => 1, ),
	'need_src' => array(S7_EXPLO_PROF, ),
);
//</btc-11>

//<btc-12>
$this->btc[B7_GIS_SARO] = array(
	'vie' => 200,
	'tours' => 100,
	'prix_res' => array(R7_BOIS => 50, R7_GRANIT => 120, ),
	'prix_trn' => array(T7_GIS_SARO => 1, ),
	'prix_unt' => array(U7_ARTISAN => 1, ),
	'prod_res_auto' => array(R7_SARONITE => 1, ),
	'need_src' => array(S7_EXPLO_PROF, ),
);
//</btc-12>

//<btc-13>
$this->btc[B7_ACIERIE] = array(
	'vie' => 500,
	'tours' => 250,
	'limite' => 2,
	'prix_res' => array(R7_BOIS => 250, R7_GRANIT => 250, R7_ADAMANTITE => 10, R7_SARONITE => 10),
	'prix_unt' => array(U7_RESCAPE => 1,  U7_INGENIEUR => 1),
	'prod_res_auto' => array(R7_ACIER => 1,),
	"prod_res"	=>	true,
	'need_src' => array(S7_FONTE_ACIER),
);
//</btc-13>

//<btc-14>
$this->btc[B7_INGE] = array(
	'vie' => 500,
	'tours' => 400,
	'limite' => 4,
	'prix_res' => array(R7_BOIS => 150, R7_GRANIT => 200, R7_ADAMANTITE => 20, R7_SARONITE => 20),
	'prix_unt' => array(U7_ARTISAN => 1, U7_INGENIEUR => 1, U7_RECRUTEUR => 1, ),
	'need_btc' => array(B7_CARREFOUR, B7_GIS_ADAM, B7_GIS_SARO),
	"prod_unt"	=>	2,
);
//</btc-14>

//<btc-15>
$this->btc[B7_MINE_PROF] = array(
	'vie' => 500,
	'tours' => 400,
	'limite' => 4,
	'prix_res' => array(R7_BOIS => 100, R7_GRANIT => 160, R7_ADAMANTITE => 10, R7_SARONITE => 10),
	'prix_unt' => array(U7_RECRUTEUR => 2 ),
	'need_src' => array(S7_EXPLO_PROF, ),
	"prod_unt"	=>	2,
	"prod_res"	=>	true,
);
//</btc-15>

//<btc-16>
$this->btc[B7_TOURS] = array(
	'vie' => 800,
	'tours' => 100,
	'limite' => 4,
	"bonus"         =>      array('bon' => 3.5),
	'prix_res' => array(R7_BOIS => 100, R7_GRANIT => 300, R7_ACIER => 20, ),
	'prix_unt' => array(U7_GOB_FRONDEUR => 4, ),
	'need_src' => array(S7_ARMES_DIST, ),
);
//</btc-16>

//<btc-17>
$this->btc[B7_TOUR_SAGE] = array(
	'vie' => 550,
	'tours' => 150,
	'limite' => 3,
	'prix_res' => array(R7_BOIS => 200, R7_GRANIT => 350, R7_ADAMANTITE => 10, R7_SARONITE => 10 ),
	'prix_unt' => array(U7_ARTISAN => 1, ),
	'need_src' => array(S7_MAGIE_CHAMAN, ),
	"prod_unt"	=>	true,
);
//</btc-17>

//<btc-18>
$this->btc[B7_TOUR_HERO] = array(
	'vie' => 250,
	'tours' => 400,
	'limite' => 1,
	'prix_res' => array(R7_BOIS => 100, R7_GRANIT => 300, R7_OR => 100, R7_LICHEN => 500, ),
	'prix_unt' => array(U7_RECRUTEUR => 1, ),
	'need_btc' => array(B7_TOUR_SAGE, B7_LAC_SOUT),
	"prod_unt"	=>	true,
);
//</btc-18>

//<btc-19>
$this->btc[B7_TRANSMU] = array(
	'vie' => 250,
	'tours' => 350,
	'limite' => 1,
	'prix_res' => array(R7_GRANIT => 120, R7_BOIS => 250, R7_SARONITE => 50, R7_ADAMANTITE => 50, R7_ACIER => 20, ),
	'prix_unt' => array(U7_COLLECTEUR => 2, U7_INGENIEUR => 1, U7_RECRUTEUR => 2, ),
	'need_btc' => array(B7_ACIERIE, ),
	'need_src' => array(S7_TRANSMUTEUR),
	"prod_res"	=>	true,
);
//</btc-19>

//<btc-20>
$this->btc[B7_CANYON_PROF] = array(
	'vie' => 350,
	'tours' => 400,
	'limite' => 4,
	'prix_res' => array(R7_BOIS => 180, R7_GRANIT => 275, R7_OR => 150, R7_LICHEN => 750, ),
	'prix_unt' => array(U7_DRESSEUR => 1, U7_RECRUTEUR => 1),
	'need_src' => array(S7_EXPLO_PROF, ),
	'need_btc' => array(B7_INGE, B7_TANIERE),
	"prod_unt"	=>	2,
);
//</btc-20>

//<btc-21>
$this->btc[B7_LAC_SOUT] = array(
	'vie' => 350,
	'tours' => 400,
	'limite' => 3,
	'prix_res' => array(R7_BOIS => 195, R7_GRANIT => 240, R7_OR => 150, R7_LICHEN => 750, ),
	'prix_unt' => array(U7_RECRUTEUR => 1, ),
	'need_src' => array(S7_EXPLO_AQUA, ),
	"prod_unt"	=>	true,
);
//</btc-21>

//<btc-22>
$this->btc[B7_RUINE_RENFORCEE] = array(
	'vie' => 4200,
	'tours' => 2000,
	'prod_pop' => 130,
	"bonus"         =>      array('gen' => 300, 'bon' => 13.5),
	'prix_unt' => array(U7_GOB_FRONDEUR => 10), 
	"prod_unt"	=>	4,
	"prod_src"	=>	true,
	'limite' => 1,
	'prix_res' => array(R7_BOIS => 1500, R7_GRANIT => 2000, R7_OR => 2500, R7_ACIER => 350, ),
	'need_btc' => array(B7_TOUR_HERO, ),
);
//</btc-22>


//</btc>

//<unt>
//<unt-1>
$this->unt[U7_RESCAPE] = array(
	'vie' => 1,
	'group' => 1,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 2, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-1>

//<unt-2>
$this->unt[U7_ARTISAN] = array(
	'vie' => 1,
	'group' => 1,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 2, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-2>

//<unt-3>
$this->unt[U7_COLLECTEUR] = array(
	'vie' => 1,
	'group' => 2,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 2, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-3>

//<unt-4>
$this->unt[U7_CHASSEUR] = array(
	'vie' => 1,
	'group' => 2,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 2, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-4>

//<unt-5>
$this->unt[U7_GOB_BRIG] = array(
	'vie' => 1,
	'group' => 4,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 3, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-5>

//<unt-6>
$this->unt[U7_RECRUTEUR] = array(
	'vie' => 1,
	'group' => 6,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 5, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-6>

//<unt-7>
$this->unt[U7_DRESSEUR] = array(
	'vie' => 1,
	'group' => 6,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 2, R7_LICHEN => 10, ),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-7>

//<unt-8>
$this->unt[U7_INGENIEUR] = array(
	'vie' => 1,
	'group' => 6,
	'role' => TYPE_UNT_CIVIL,
	'prix_res' => array(R7_OR => 3,),
	'need_btc' => array(B7_RUINE_OUBLIEE, ),
	'in_btc' => array(B7_RUINE_OUBLIEE, ),
);
//</unt-8>


//<unt-10>
$this->unt[U7_GOB_FRONDEUR] = array(
	'vie' => 5,
	'group' => 9,
	'role' => TYPE_UNT_DISTANCE,
	'prix_res' => array(R7_FRONDE => 2, ),
	'need_btc' => array(B7_HONNEUR, ),
	'in_btc' => array(B7_HONNEUR, ),
	'def' => 6,
	'atq_unt' => 4,
	'vit' => 6,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 9,
	'bonus' => array(
		'vie' => 1),
);
//</unt-10>

//<unt-11>
$this->unt[U7_HOB_GOB] = array(
	'vie' => 5,
	'group' => 9,
	'role' => TYPE_UNT_INFANTERIE,
	'prix_res' => array(R7_BATON => 1, R7_BOUCLIER_ROND => 1, ),
	'need_btc' => array(B7_HONNEUR, ),
	'in_btc' => array(B7_HONNEUR, ),
	'def' => 5,
	'atq_unt' => 7,
	'vit' => 8,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 8,
);
//</unt-11>

//<unt-9>
$this->unt[U7_GOB_SOLDAT] = array(
	'vie' => 7,
	'group' => 10,
	'role' => TYPE_UNT_DISTANCE,
	'prix_res' => array(R7_LANCE => 1,R7_BRIGANDINE => 1, R7_BOUCLIER_ROND => 1, ),
	'need_btc' => array(B7_HONNEUR, ),
	'in_btc' => array(B7_HONNEUR, ),
	'need_src' => array(S7_ARMES_DIST, ),
	'def' => 6,
	'atq_unt' => 12,
	'vit' => 9,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 7,
	'bonus' => array(
		'vie' => 1),
);
//</unt-9>

//<unt-13>
$this->unt[U7_SEMI_OGRE] = array(
	'vie' => 13,
	'group' => 1,
	'role' => TYPE_UNT_MACHINE,
	'prix_res' => array(R7_CIMETERRE => 2, R7_ACIER => 4, R7_BOIS => 6,  ),
	'need_btc' => array(B7_CANYON_PROF, ),
	'in_btc' => array(B7_CANYON_PROF, ),
	'need_src' => array(S7_DRESSAGE, ),
	'def' => 9,
	'atq_unt' => 5,
	'atq_btc' => 8,
	'vit' => 6,
	'prix_unt' => array(U7_DRESSEUR => 1, ),
	'rang' => 4,
);
//</unt-13>

//<unt-12>
$this->unt[U7_OGRE] = array(
	'vie' => 14,
	'group' => 1,
	'role' => TYPE_UNT_INFANTERIE,
	'prix_res' => array(R7_BATON => 1, R7_BRIGANDINE => 1, R7_ACIER => 2, ),
	'need_btc' => array(B7_CANYON_PROF, ),
	'in_btc' => array(B7_CANYON_PROF, ),
	'need_src' => array(S7_DRESSAGE, ),
	'def' => 12,
	'atq_unt' => 16,
	'vit' => 6,
	'prix_unt' => array(U7_DRESSEUR => 1, ),
	'rang' => 2,
);
//</unt-12>


//<unt-14>
$this->unt[U7_CERBERE] = array(
	'vie' => 10,
	'group' => 10,
	'role' => TYPE_UNT_CAVALERIE,
	'prix_res' => array(R7_LICHEN => 200, R7_ACIER => 3, ),
	"need_btc"	=>	array(B7_MINE_PROF),
	'in_btc' => array(B7_MINE_PROF ),
	'need_src' => array(S7_EXPLO_AQUA, ),
	'def' => 17,
	'atq_unt' => 9,
	'vit' => 13,
	'prix_unt' => array(U7_DRESSEUR => 2, ),
	'rang' => 11,
);
//</unt-14>

//<unt-15>
$this->unt[U7_GNOME_PROF] = array(
	'vie' => 2,
	'group' => 15,
	'role' => TYPE_UNT_INFANTERIE,
	'prix_res' => array(R7_CIMETERRE => 2, R7_BOIS => 1, R7_TORTUE => 1,),
	'need_btc' => array(B7_CANYON_PROF, ),
	'in_btc' => array(B7_CANYON_PROF, ),
	'def' => 3,
	'atq_unt' => 21,

	'vit' => 15,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 12,
);
//</unt-15>

//<unt-16>
$this->unt[U7_ZEPPELIN] = array(
	'vie' => 7,
	'group' => 16,
	'role' => TYPE_UNT_MACHINE,
	'prix_res' => array(R7_GRANIT => 9, R7_BOIS => 11, R7_ACIER => 8, ),
	'need_btc' => array(B7_INGE, ),
	'in_btc' => array(B7_INGE, ),
	'def' => 5,
	'atq_unt' => 0,
	'atq_btc' => 12,
	'vit' => 15,
	'prix_unt' => array(U7_INGENIEUR => 2, ),
	'rang' => 13,
);
//</unt-16>

//<unt-17>
$this->unt[U7_GOBLOURS] = array(
	'vie' => 5,
	'group' => 17,
	'role' => TYPE_UNT_MAGIQUE,
	'prix_res' => array(R7_OR => 6, R7_LICHEN => 30, R7_ACIER => 2, R7_MITHRIL => 1, ),
	'need_btc' => array(B7_LAC_SOUT, ),
	'in_btc' => array(B7_LAC_SOUT, ),
	'def' => 8,
	'atq_unt' => 11,
	'vit' => 6,
	'prix_unt' => array(U7_DRESSEUR => 1, ),
	'rang' => 18,
	'bonus' => array(
		'atq' => 1.5),
);
//</unt-17>

//<unt-18>
$this->unt[U7_BATRASOG] = array(
	'vie' => 5,
	'group' => 17,
	'role' => TYPE_UNT_MAGIQUE,
	'prix_res' => array(R7_OR => 6, R7_LICHEN => 30, R7_ACIER => 2, R7_MITHRIL => 1, ),
	'need_btc' => array(B7_LAC_SOUT, ),
	'in_btc' => array(B7_LAC_SOUT, ),
	'def' => 11,
	'atq_unt' => 8,
	'vit' => 6,
	'prix_unt' => array(U7_DRESSEUR => 1, ),
	'rang' => 17,
	'bonus' => array(
		'def' => 1.5),
);
//</unt-18>

//<unt-19>
$this->unt[U7_FREMLIN] = array(
	'vie' => 5,
	'group' => 18,
	'role' => TYPE_UNT_INFANTERIE,
	'prix_res' => array(R7_CIMETERRE => 1, R7_LICHEN => 30,R7_ACIER => 2,),
	'need_btc' => array(B7_LAC_SOUT),
	'in_btc' => array(B7_LAC_SOUT),
	'def' => 20,
	'atq_unt' => 6,
	'vit' =>8,
	'prix_unt' => array(U7_DRESSEUR => 1, ),
	'rang' => 14,
);
//</unt-19>

//<unt-20>
$this->unt[U7_MAGE_GOB] = array(
	'vie' => 6,
	'group' => 20,
	'role' => TYPE_UNT_MAGIQUE,
	'prix_res' => array(R7_LICHEN => 30, R7_OR => 3, R7_ACIER => 2, ),
	'need_btc' => array(B7_TOUR_SAGE, ),
	'in_btc' => array(B7_TOUR_SAGE, ),
	'def' => 3,
	'atq_unt' => 5,
	'vit' => 9,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 15,
	'bonus' => array(
		'atq' => 0.75),
);
//</unt-20>

//<unt-21>
$this->unt[U7_DRUIDE] = array(
	'vie' => 6,
	'group' => 20,
	'role' => TYPE_UNT_MAGIQUE,
	'prix_res' => array(R7_LICHEN => 30, R7_OR => 3, R7_ACIER => 2, ),
	'need_btc' => array(B7_TOUR_SAGE, ),
	'in_btc' => array(B7_TOUR_SAGE, ),
	'def' => 5,
	'atq_unt' => 3,
	'vit' => 9,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 16,
	'bonus' => array(
		'def' => 0.75),
);
//</unt-21>

//<unt-22>
$this->unt[U7_KAMIKAZE] = array(
	'vie' => 1,
	'group' => 16,
	'role' => TYPE_UNT_MACHINE,
	'prix_res' => array(R7_BOIS => 15, R7_GRANIT => 13, R7_ACIER => 9, ),
	'need_btc' => array(B7_INGE, ),
	'in_btc' => array(B7_INGE, ),
	'need_src' => array(S7_COM_2, ),
	'def' => 5,
	'atq_unt' => 6,
	'atq_btc' => 18,
	'vit' => 2,
	'prix_unt' => array(U7_INGENIEUR => 2, ),
	'rang' => 3,
);
//</unt-22>

//<unt-23>
$this->unt[U7_TYRAN] = array(
	'vie' => 8,
	'group' => 10,
	'role' => TYPE_UNT_CAVALERIE,
	'prix_res' => array(R7_CIMETERRE => 1, R7_COTTE_MITHRIL => 1, R7_CASQUE => 1, R7_TORTUE => 1, ),
	'need_btc' => array(B7_HONNEUR, ),
	'in_btc' => array(B7_HONNEUR, ),
	'need_src' => array(S7_DRESSAGE, ),
	'def' => 8,
	'atq_unt' => 22,
	'vit' => 8,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 6,
);
//</unt-23>

//<unt-24>
$this->unt[U7_HOBGOB_OFF] = array(
	'vie' => 125,
	'group' => 23,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R7_CIMETERRE => 1, R7_COTTE_MITHRIL => 1, R7_CASQUE => 1, R7_MITHRIL => 1,  R7_LICHEN => 50, ),
	'need_btc' => array(B7_TOUR_HERO, ),
	'in_btc' => array(B7_TOUR_HERO, ),
	'need_src' => array(S7_GENERALISSIME, ),
	'def' => 75,
	'atq_unt' => 135,
	'vit' => 12,
	'prix_unt' => array(U7_GOB_BRIG => 1, ),
	'rang' => 20,
);
//</unt-24>

//<unt-25>
$this->unt[U7_CHEVAUCH_TORT] = array(
	'vie' => 130,
	'group' => 23,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R7_CIMETERRE => 1, R7_COTTE_MITHRIL => 1, R7_CASQUE => 1, R7_TORTUE =>1, R7_MITHRIL => 1, R7_LICHEN => 50, ),
	'need_btc' => array(B7_TOUR_HERO, ),
	'in_btc' => array(B7_TOUR_HERO, ),
	'need_src' => array(S7_DRESSEUR_EXP, ),
	'def' => 95,
	'atq_unt' => 105,
	'atq_btc' => 35,
	'vit' => 10,
	'prix_unt' => array(U7_DRESSEUR => 1, ),
	'rang' => 21,
);
//</unt-25>

//<unt-26>
$this->unt[U7_MEDUSA] = array(
	'vie' => 134,
	'group' => 23,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R7_CIMETERRE => 1, R7_COTTE_MITHRIL => 1, R7_CASQUE => 1, R7_MITHRIL => 1, R7_LICHEN => 50, ),
	'need_btc' => array(B7_TOUR_HERO, ),
	'in_btc' => array(B7_TOUR_HERO, ),
	'need_src' => array(S7_CREATURE_DESTRUCTRICE, ),
	'def' => 133,
	'atq_unt' => 75,
	'vit' => 9,
	'prix_unt' => array(U7_DRESSEUR => 1, ),
	'rang' => 22,
);
//</unt-26>

//<unt-27>
$this->unt[U7_TAUPE] = array(
	'vie' => 9,
	'group' => 21,
	'role' => TYPE_UNT_DEMENAGEMENT,
	//'prix_res' => array(R7_LICHEN => 30000, R7_OR => 5000, R7_ACIER => 900, R7_MITHRIL => 400, ),
	'prix_res' => array(R7_LICHEN => 15000, R7_OR => 2500, R7_ACIER => 400, R7_MITHRIL => 200, ),
	'need_btc' => array(B7_INGE, ),
	'in_btc' => array(B7_INGE, ),
	'need_src' => array(S7_FORAGE, ),
	'vit' => 6,
	'prix_unt' => array(U7_GOB_BRIG => 1,U7_INGENIEUR => 1 ),
	'rang' => 19,

);
//</unt-27>

//</unt>

//<src>
$this->src[S7_PIERRE_PHILO]=array(
		"tours"	=>	6,
		"group"	=>	1,
		"prix_res"	=>	array(R7_BOIS => 10, R7_GRANIT => 10),
		"need_btc" => array(B7_SOUTERRAIN),
);

$this->src[S7_FONTE_ACIER]=array(
		"tours"	=>	20,
		"group"	=>	1,
		"need_btc"	=>	array(B7_GIS_ADAM, B7_GIS_SARO, B7_INGE),
		"prix_res"	=>	array(R7_OR => 150, R7_LICHEN => 4000, R7_BOIS => 450, R7_GRANIT => 550, R7_ADAMANTITE => 75, R7_SARONITE => 75),
);

$this->src[S7_TRANSMUTEUR]=array(
		"tours"		=>	20,
		"group"		=>	1,
		"need_btc"	=>	array(B7_ACIERIE),
		"prix_res"	=>	array(R7_OR => 75, R7_BOIS => 50, R7_GRANIT => 50, R7_ADAMANTITE => 75, R7_SARONITE => 75, R7_ACIER => 20),
);

$this->src[S7_COM_1]=array(
		"tours"	=>	10,
		"group"	=>	2,
		"need_src"	=>	array(S7_RECRUTEMENT_AVANCE),
		"prix_res"	=>	array(R7_OR => 55),
);

$this->src[S7_COM_2]=array(
		"tours"	=>	15,
		"group"	=>	2,
		"need_btc"	=>	array(B7_ACIERIE, B7_CARREFOUR),
		"prix_res"	=>	array(R7_OR => 200, R7_BOIS => 150, R7_GRANIT => 120, R7_LICHEN => 1000, R7_ACIER => 20),
);

$this->src[S7_COM_3]=array(
		"tours"	=>	20,
		"group"	=>	2,
		"need_src" => array(S7_COM_2),
		"need_btc"	=>	array(B7_TRANSMU),
		"prix_res"	=>	array(R7_OR => 800, R7_BOIS => 300, R7_ACIER => 100, R7_GRANIT => 500, R7_LICHEN => 1000),
);

$this->src[S7_ARMES_POING]=array(
		"tours"	=>	10,
		"group"	=>	4,
		"need_btc"	=>	array(B7_ARSENAL),
		"prix_res"	=>	array(R7_OR => 30,  R7_BOIS => 30, R7_GRANIT => 20, ),
);

$this->src[S7_ARME_DEF]=array(
		"tours"	=>	10,
		"group"	=>	4,
		"need_btc"	=>	array(B7_ARSENAL),
		"prix_res"	=>	array(R7_BOIS => 20, R7_GRANIT => 120, R7_OR => 10),
);

$this->src[S7_ARMES_DIST]=array(
		"tours"	=>	20,
		"group"	=>	4,
		"need_btc"	=> array(B7_ACIERIE, B7_INGE),
		"prix_res"	=>	array(R7_OR => 120, R7_ACIER => 70, R7_BOIS => 180, R7_GRANIT => 400),
);

$this->src[S7_EXPLO_SURFACE]=array(
		"tours"	=>	10,
		"group"	=>	8,
		"need_btc"	=>	array(B7_SOUTERRAIN),
		"need_src"	=>	array(S7_RENOVATION),
		"prix_res"	=>	array(R7_LICHEN => 100, R7_BOIS => 75, R7_GRANIT => 75),
);

$this->src[S7_EXPLO_PROF]=array(
		"tours"	=>	13,
		"group"	=>	8,
		"need_btc"	=>  array(B7_SONDEUR_ABYSSAL),
		"prix_res"	=>	array(R7_BOIS => 100, R7_GRANIT => 120, ),
		'vlg' => true
);

$this->src[S7_EXPLO_AQUA]=array(
		"tours"	=>	16,
		"group"	=>	8,
		"need_btc"	=>	array(B7_MINE_PROF),
		"need_src"	=>	array(S7_EXPLO_PROF),
		"prix_res"	=>	array(R7_OR => 30, R7_BOIS => 75, R7_GRANIT => 80, R7_ADAMANTITE => 75, R7_SARONITE => 75),
		'vlg' => true
);

$this->src[S7_RENOVATION]=array(
		"tours"	=>	5,
		"group"	=>	12,
		"need_btc"	=>  array(B7_MINE_GRANIT, B7_CABANE),
		"prix_res"	=>	array(R7_BOIS => 10, R7_GRANIT => 10,),
);

$this->src[S7_RECRUTEMENT_AVANCE]=array(
		"tours"	=>	20,
		"group"	=>	12,
		"need_btc"	=>	array(B7_SOUTERRAIN),
		"need_src"	=>	array(S7_RENOVATION),
		"prix_res"	=>	array(R7_OR => 25),
);

$this->src[S7_MAGIE_CHAMAN]=array(
		"tours"	=>	20,
		"group"	=>	9,
		"need_src"	=>	array(S7_EXPLO_AQUA),
		"prix_res"	=>	array(R7_OR => 20, R7_LICHEN => 50, R7_BOIS => 10, R7_GRANIT => 10, R7_ADAMANTITE => 75, R7_SARONITE => 75),
);

$this->src[S7_RENFORT_COLL]=array(
		"tours"		=>	15,
		"group"		=>	9,
		"need_btc"	=>	array(B7_MINE_PROF, B7_SONDEUR_ABYSSAL),
		"prix_res"	=>	array(R7_LICHEN => 750, R7_BOIS => 120, R7_GRANIT => 150, R7_TORTUE => 15, R7_ADAMANTITE => 40, R7_SARONITE => 40),

		);

$this->src[S7_DRESSAGE]=array(
		"tours"	=>	25,
		"group"	=>	20,
		"need_btc"	=>	array(B7_ACIERIE, B7_TANIERE),
		"prix_res"	=>	array(R7_OR => 200, R7_BOIS => 50, R7_GRANIT => 30, R7_LICHEN => 1000, R7_ACIER => 50),
);

$this->src[S7_FORAGE]=array(
		"tours"	=>	50,
		"group"	=>	20,
		"need_btc"	=>	array(B7_INGE),
		"prix_res"	=> 	array(R7_LICHEN => 30000, R7_OR => 580, R7_SARONITE => 350,  R7_ADAMANTITE => 375, R7_ACIER => 75),
		);

$this->src[S7_GENERALISSIME]=array(
		"tours"	=>	50,
		"group"	=>	18,
		"need_btc"	=>	array(B7_TOUR_HERO),
		"prix_res"	=>	array(R7_LICHEN => 3000, R7_OR => 250, R7_ACIER => 50, R7_MITHRIL => 20),
		);

$this->src[S7_CREATURE_DESTRUCTRICE]=array(
		"tours"	=>	50,
		"group"	=>	18,
		"need_btc"	=>	array(B7_TOUR_HERO),
		"prix_res"	=>	array(R7_LICHEN => 2500, R7_OR => 200, R7_SARONITE => 50, R7_MITHRIL => 5, R7_ADAMANTITE => 75, R7_SARONITE => 75),
		);

$this->src[S7_DRESSEUR_EXP]=array(
		"tours"	=>	50,
		"group"	=>	18,
		"need_btc"	=>	array(B7_TOUR_HERO),
		"prix_res"	=> 	array(R7_LICHEN => 3500, R7_OR => 260, R7_SARONITE => 60, R7_TORTUE =>5, R7_MITHRIL => 10, R7_ADAMANTITE => 40, R7_SARONITE => 75),
		);

//</src>	

/* compétences du héros - offensif / défensif / soutient */

//<comp>
$this->comp[CP_BOOST_OFF]=array(
	'heros'		=> array(U7_HOBGOB_OFF),
	'tours'		=> 3,
	'bonus'		=> 10,
	'prix_xp'	=> 40,
	'type'		=> 1
);

$this->comp[CP_RESURECTION]=array(
	'heros'		=> array(U7_HOBGOB_OFF),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_VOLEE_DE_FLECHES]=array(
	'heros'		=> array(U7_HOBGOB_OFF),
	'tours'		=> 24,
	'bonus'		=> 5,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_TELEPORTATION]=array(
	'heros'		=> array(U7_HOBGOB_OFF),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

/* ### Def ### */

$this->comp[CP_BOOST_DEF]=array(
	'heros'		=> array(U7_MEDUSA),
	'tours'		=> 8,
	'bonus'		=> 8,
	'prix_xp'	=> 40,
	'type'		=> 2
);

$this->comp[CP_RESISTANCE]=array(
	'heros'		=> array(U7_MEDUSA),
	'tours'		=> 6,
	'bonus'		=> 15,
	'prix_xp'	=> 60,
	'type'		=> 2
);

$this->comp[CP_REGENERATION]=array(
	'heros'		=> array(U7_MEDUSA),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 2
);

$this->comp[CP_APPEL_CREATURE]=array(
	'heros'		=> array(U7_MEDUSA),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 2
);

/* ### Sou ### */

$this->comp[CP_CASS_BAT]=array(
	'heros'		=> array(U7_CHEVAUCH_TORT),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GENIE_COMMERCIAL]=array(
	'heros'		=> array(U7_CHEVAUCH_TORT),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_INGE_ACCRUE]=array(
	'heros'		=> array(U7_CHEVAUCH_TORT),
	'tours'		=> 24,
	'bonus'		=> 200,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GUERISON]=array(
	'heros'		=> array(U7_CHEVAUCH_TORT),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 3
);
//</comp>


/*
*	Config de la race
*	'primary_res'	Ressources les plus importantes, affichées en haut a gauche
*	'second_res'	Ressources importantes, affichées dans le donjon
*	'primary_btc'	Bâtiment les plus importants, affichés dans le menu
*	'bonus_res'	Coef pour calculer combien de bonus en fonction des points .. en pratique, seul celui
*				de l'or est censé être utilisé
*	'modif_pts_btc'	Coef pour determiner combien les bâtiments rapportent de points
*	'debut'		Trucs a donner au début
*	'trn'		Terrains a donner en fonction de la carte
*/

$this->race_cfg = array(
	'res_nb'	=>	count($this->res),
	'trn_nb'	=>	count($this->trn),
	'btc_nb'	=>	count($this->btc),
	'unt_nb'	=>	count($this->unt),
	'src_nb'	=>	count($this->src),
	'primary_res'	=>	array(R7_OR, R7_LICHEN),
	'second_res'	=>	array(R7_OR, R7_BOIS, R7_GRANIT, R7_LICHEN, R7_ADAMANTITE , R7_SARONITE, R7_ACIER, R7_MITHRIL),
	'primary_btc'	=>	array(
		'vil'	=>	array(  B7_RUINE_OUBLIEE => array('unt','src'),
					B7_HONNEUR => array('unt'),
					B7_ARSENAL => array('res'),
					B7_ACIERIE => array('res'),
					B7_INGE => array('unt'),
					B7_MINE_PROF => array('res'),
					B7_TOUR_HERO => array('unt'),
					B7_TOUR_SAGE => array('unt'),
					B7_TRANSMU => array('res'),
					B7_CANYON_PROF => array('unt'),
					B7_LAC_SOUT => array('unt'),
		),

		'ext'	=>	array( B7_CARREFOUR => array('ach'))
	),
	'bonus_res'	=>	array(R7_OR => 0.05),
	'modif_pts_btc'	=>	1,
	'debut'	=>	array(
		'res'	=>	array(R7_OR => 70, R7_BOIS => 50, R7_GRANIT => 50, R7_LICHEN => 1500),
		'trn'	=>	array(T7_FORET => 2, T7_MONTAGNE => 2, T7_GIS_ADAM => 2, T7_GIS_SARO => 2),
		'unt'	=> 	array(U7_RESCAPE => 2, U7_HOB_GOB => 5),
		'btc'	=> 	array(B7_RUINE_OUBLIEE => array()),
		'src'	=>	array()
	),
	'bonus_map' => array(MAP_EAU => 0, MAP_LAC => 0, MAP_HERBE => 2, MAP_MONTAGNE => 0, MAP_FORET => 0),
	'bonus_period' => array(PERIODS_JOUR => 2, PERIODS_NUIT => -2, PERIODS_AUBE => 2, PERIODS_CREP => -2),
);

}
}
?>
