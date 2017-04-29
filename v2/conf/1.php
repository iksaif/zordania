<?php
/* Defines */
define("R1_OR", 1);
define("R1_BOIS", 2);
define("R1_PIERRE", 3);
define("R1_NOURRITURE", 4);
define("R1_FER", 5);
define("R1_CHARBON", 6);
define("R1_CHEVAUX", 7);
define("R1_ACIER", 8);
define("R1_MITHRIL", 9);
define("R1_B_BOIS", 10);
define("R1_B_ACIER", 11);
define("R1_EPEE", 12);
define("R1_EPEE_LON", 13);
define("R1_ARC", 14);
define("R1_ARBALETE", 15);
define("R1_COTTE_MAILLE", 16);
define("R1_COTTE_MITHRIL", 17);

define("T1_FORET", 1);
define("T1_GIS_FER", 2);
define("T1_GIS_CHARBON", 3);
define("T1_FILON_OR", 4);
define("T1_MONTAGNE", 5);

define("B1_DONJON", 1);
define("B1_CARRIERE", 2);
define("B1_SCIERIE", 3);
define("B1_MAISON", 4);
define("B1_FERME", 5);
define("B1_CASERNE", 6);
define("B1_MINE_OR", 7);
define("B1_MARCHE", 8);
define("B1_ARMURERIE", 9);
define("B1_LABO", 10);
define("B1_MINE_CHARBON", 11);
define("B1_MINE_FER", 12);
define("B1_FONDERIE", 13);
define("B1_ATELIER", 14);
define("B1_ECURIE", 15);
define("B1_TOURS", 16);
define("B1_FERME_AM", 17);
define("B1_EGLISE", 18);
define("B1_POUDRIERE", 19);
define("B1_ECOLE_MAGIE", 20);
define("B1_GUILDE_DES_HEROS", 21);
define("B1_FORTERESSE", 22);

define("U1_TRAVAILLEUR", 1);
define("U1_FERMIER", 2);
define("U1_FORGERON", 3);
define("U1_BUCHERON", 4);
define("U1_MINEUR", 5);
define("U1_CHERCHEUR", 6);
define("U1_RECRUE", 7);
define("U1_MILICIEN", 8);
define("U1_ARCHER", 9);
define("U1_ARBALETRIER", 10);
define("U1_FANTASSIN", 11);
define("U1_FANTASSIN_XP", 12);
define("U1_CHEVALIER", 13);
define("U1_CHEVALIER_XP", 14);
define("U1_CATAPULTE", 15);
define("U1_BELIER", 16);
define("U1_MOINE", 17);
define("U1_PRETRE", 18);
define("U1_CANON", 19);
define("U1_MAGICIEN", 20);
define("U1_SORCIER", 21);
define("U1_TREBUCHET", 22);
define("U1_PALADIN", 23);
define("U1_GRIFFON", 24);
define("U1_GENERAL", 25);
define("U1_INGENIEUR_GNOME", 26);
define("U1_GRANDE_CARAVELLE", 27);

define("S1_ARME_1", 1);
define("S1_ARME_2", 2);
define("S1_ARME_3", 3);
define("S1_DEFENSE_1", 4);
define("S1_DEFENSE_2", 5);
define("S1_DEFENSE_3", 6);
define("S1_ACIER", 7);
define("S1_ELEVAGE", 8);
define("S1_COMMERCE_1", 9);
define("S1_COMMERCE_2", 10);
define("S1_COMMERCE_3", 11);
define("S1_ARMEE_1", 12);
define("S1_ARMEE_2", 13);
define("S1_ARMEE_3", 14);
define("S1_MINE_1", 15);
define("S1_MINE_2", 16);
define("S1_ATTELAGE", 17);
define("S1_MOINE", 18);
define("S1_PRETRE", 19);
define("S1_POUDRE", 20);
define("S1_MAGIE_BL", 21);
define("S1_MAGIE_NR", 22);
define("S1_DOMPTAGE", 23);
define("S1_GENERAL", 24);
define("S1_GNOME", 25);
define("S1_DEMENAGEMENT", 26);

class config1
{
var $res = array();
var $trn = array();
var $btc = array();
var $unt = array();
var $src = array();
var $comp = array();
var $race_cfg = array();

function __construct()
{
 
$this->res = array();
$this->btc = array();
$this->unt = array();
$this->src = array();
$this->trn = array();

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
$this->res[R1_OR]=array(
		"cron"	=>	true,
		"need_btc"	=>	B1_MINE_OR
);

$this->res[R1_BOIS]=array(
		"cron"	=>	true,
		"need_btc"	=>	B1_SCIERIE
);


$this->res[R1_PIERRE]=array(
		"cron"	=>	true,
		"need_btc"	=>	B1_CARRIERE
);

$this->res[R1_NOURRITURE]=array(
		"cron"	=>	true,
		"need_btc"	=>	B1_FERME
);

$this->res[R1_FER]=array(
		"cron"	=>	true,
		"need_btc"	=>	B1_MINE_FER
);

$this->res[R1_CHARBON]=array(
		"cron"	=>	true,
		"need_btc"	=>	B1_MINE_CHARBON
);

$this->res[R1_CHEVAUX]=array(
		"prix_res"	=>	array(R1_NOURRITURE => 150, R1_ACIER => 2),
		"need_btc"	=>	B1_ECURIE,
		"group"	=>	7,
);

$this->res[R1_ACIER]=array(
		"cron"	=>	true,
		"prix_res"	=>	array(R1_FER => 2, R1_CHARBON => 2),
		"need_btc"	=>	B1_FONDERIE
);
		
$this->res[R1_MITHRIL]=array("dummy" => true);

$this->res[R1_B_BOIS]=array(
		"prix_res"	=>	array(R1_BOIS => 1),
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	10,
);
		
$this->res[R1_B_ACIER]=array(
		"prix_res"	=>	array(R1_BOIS => 2, R1_ACIER => 1, R1_FER => 1, R1_CHARBON => 1),
		"need_src"	=>	array(S1_DEFENSE_2),
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	10,
);
	
$this->res[R1_EPEE]=array(
		"prix_res"	=>	array(R1_BOIS => 1), 
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	12,
);
	
$this->res[R1_EPEE_LON]=array(
		"prix_res"	=>	array(R1_ACIER => 2, R1_CHARBON => 1, R1_FER => 1),
		"need_src"	=>	array(S1_ARME_2),
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	12,
);

$this->res[R1_ARC]=array(
		"prix_res"	=>	array(R1_BOIS => 2),
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	15,
);
		
$this->res[R1_ARBALETE]=array(
		"prix_res"	=>	array(R1_BOIS => 1,R1_ACIER => 2,R1_FER => 1,R1_CHARBON => 1),
		"need_src"	=>	array(S1_ARME_2),
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	15,
);
	
$this->res[R1_COTTE_MAILLE]=array(
		"prix_res"	=>	array(R1_ACIER => 2),
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	16,
);

$this->res[R1_COTTE_MITHRIL]=array(
		"prix_res"	=>	array(R1_MITHRIL => 1),
		"need_src"	=>	array(S1_DEFENSE_2),
		"need_btc"	=>	B1_ARMURERIE,
		"group"	=>	16,
);
//</res>
		
/* Terrains */
//<trn>
$this->trn[T1_FORET] = array();
$this->trn[T1_GIS_FER] = array();
$this->trn[T1_GIS_CHARBON] = array();
$this->trn[T1_FILON_OR] = array();
$this->trn[T1_MONTAGNE] = array();
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
$this->btc[B1_DONJON]=array(
		"vie"	=>	1000,
		"limite"	=>	1,
		"tours"	=>	500,
		"bonus" 	=>  array('gen' => 300, 'bon' => 4),
		"prix_res"	=>	array(R1_BOIS => 2250, R1_PIERRE => 2250, R1_ACIER => 200),
		"prod_pop"	=>	20,
		"prod_src"	=>	true,
		"prod_unt"	=>	4,
		);
		
$this->btc[B1_CARRIERE]=array(
		"vie"	=>	200,
		"tours"	=>	5,
		"prix_res"	=>	array(R1_BOIS => 5, R1_PIERRE=> 6),
		"prix_trn"	=>	array(T1_MONTAGNE => 1),
		"prix_unt"	=>	array(U1_MINEUR => 1),
		"need_btc"	=>	array(B1_DONJON),
		"prod_res_auto"=>	array(R1_PIERRE => 1),
		);
		
$this->btc[B1_SCIERIE]=array(
		"vie"	=>	200,
		"tours"	=>	5,
		"prix_res"	=>	array(R1_BOIS => 5, R1_PIERRE => 8),
		"prix_trn"	=>	array(T1_FORET => 1),
		"prix_unt"	=>	array(U1_BUCHERON => 1),
		"need_btc"	=>	array(B1_DONJON),
		"prod_res_auto"	=>	array(R1_BOIS => 1),
		);
	
$this->btc[B1_MAISON]=array(
		"vie"	=>	175,
		"tours"	=>	6,
		"limite"	=>	76,
		"prod_pop"	=>	5,
		"prix_res"	=>	array(R1_BOIS => 12, R1_PIERRE => 18),
		"need_btc"	=>	array(B1_CARRIERE, B1_SCIERIE),
		);

$this->btc[B1_FERME]=array(
		"vie"	=>	350,
		"tours"	=>	7,
		"limite"	=>	50,
		"prix_res"	=>	array(R1_BOIS => 12,R1_PIERRE => 18),
		"prix_unt"	=>	array(U1_FERMIER => 1),
		"need_btc"	=>	array(B1_CARRIERE, B1_SCIERIE),
		"prod_res_auto"	=>	array(R1_NOURRITURE => 6),
		);
		
$this->btc[B1_CASERNE]=array(
		"vie"	=>	500,
		"tours"	=>	30,
		"limite"	=>	5,
		"prix_res"	=>	array(R1_BOIS => 45, R1_PIERRE => 50),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_ARMEE_1),
		"prod_unt"	=>	true,
		);
	
$this->btc[B1_MINE_OR]=array(
		"vie"	=>	200,
		"tours"	=>	30,
		"prod_res_auto"	=>	array(R1_OR => 1),
		"prix_res"	=>	array(R1_BOIS => 45, R1_PIERRE => 50),
		"prix_trn"	=>	array(T1_FILON_OR => 1),
		"prix_unt"	=>	array(U1_MINEUR => 1),
		"need_src"	=>	array(S1_MINE_1),
);

$this->btc[B1_MARCHE]=array(
		"vie"	=>	400,
		"tours"	=>	100,
		"limite"	=>	2,
		"prix_res"	=>	array(R1_BOIS => 90, R1_PIERRE => 120),
		"need_src"	=>	array(S1_COMMERCE_1),
		"need_unt"	=>	array(U1_TRAVAILLEUR => 1),
		"com"	=>	array(
					S1_COMMERCE_1 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
					S1_COMMERCE_2 => array(COM_MAX_NB2,COM_MAX_VENTES2),
					S1_COMMERCE_3 => array(COM_MAX_NB3,COM_MAX_VENTES3)
					)
);

$this->btc[B1_ARMURERIE]=array(
		"vie"	=>	500,
		"tours"	=>	150,
		"limite"	=>	3,
		"need_src"	=>	array(S1_ARMEE_2),
		"prix_res"	=>	array(R1_BOIS => 150, R1_PIERRE => 100),
		"need_unt"	=>	array(U1_BUCHERON => 1, U1_FORGERON => 1),
		"need_btc"	=>	array(B1_CASERNE, B1_MINE_OR),
		"prod_res"	=>	true,
		);

$this->btc[B1_LABO]=array(
		"vie"	=>	500,
		"tours"	=>	150,
		"limite"	=>	2,
		"prix_res"	=>	array(R1_BOIS => 100, R1_PIERRE => 100),
		"prix_unt"	=>	array(U1_CHERCHEUR => 8),
		"need_btc"	=>	array(B1_CASERNE, B1_MINE_OR),
		"prod_src"	=>	true,
);

$this->btc[B1_MINE_CHARBON]=array(
		"vie"	=>	200,
		"tours"	=>	100,
		"prod_res_auto"	=>	array(R1_CHARBON => 1),
		"prix_res"	=>	array(R1_BOIS => 60, R1_PIERRE => 60),
		"prix_trn"	=>	array(T1_GIS_CHARBON => 1),
		"prix_unt"	=>	array(U1_MINEUR => 1),
		"need_src"	=>	array(S1_MINE_2),
);

$this->btc[B1_MINE_FER]=array(
		"vie"	=>	200,
		"tours"	=>	100,
		"prod_res_auto"	=>	array(R1_FER => 1),
		"prix_res"	=>	array(R1_BOIS => 60, R1_PIERRE => 60),
		"prix_trn"	=>	array(T1_GIS_FER => 1),
		"prix_unt"	=>	array(U1_MINEUR => 1),
		"need_src"	=>	array(S1_MINE_2),
);

$this->btc[B1_FONDERIE]=array(
		"vie"	=>	500,
		"tours"	=>	250,
		"prod_res_auto"	=>	array(R1_ACIER => 1),
		"prix_res"	=>	array(R1_BOIS => 200,R1_PIERRE => 200),
		"prix_unt"	=>	array(U1_FORGERON => 1),
		"need_src"	=>	array(S1_ACIER),
);

$this->btc[B1_ATELIER]=array(
		"vie"	=>	500,
		"tours"	=>	400,
		"prix_res"	=>	array(R1_BOIS => 525, R1_PIERRE => 525),
		"prix_unt"	=>	array(U1_FORGERON => 1, U1_BUCHERON => 1,U1_CHERCHEUR => 1),
		"need_src"	=>	array(S1_ARMEE_3),
		"need_btc"	=>	array(B1_ECURIE),
		"prod_unt"	=>	true,
);

$this->btc[B1_ECURIE]=array(
		"vie"	=>	500,
		"tours"	=>	400,
		"limite"	=>	5,
		"prix_unt"	=>	array(U1_FERMIER => 1),
		"prix_res"	=>	array(R1_BOIS => 350,R1_PIERRE => 350),		
		"need_src"	=>	array(S1_ELEVAGE),
		"prod_res"	=>	true,
);

$this->btc[B1_TOURS]=array(
		"bonus"         =>      array('bon' => 3.5),
		"vie"		=>	800,
		"tours"		=>	100,
		"prix_res"	=>	array(R1_BOIS => 275, R1_PIERRE => 300, R1_ACIER => 20),
		"prix_unt"	=>	array(U1_RECRUE => 4),
		"need_src"	=>	array(S1_DEFENSE_3),
		"limite"	=>	4,
);

$this->btc[B1_FERME_AM]=array(
		"vie"		=>	550,
		"tours"		=>	150,
		"prix_res"	=>	array(R1_BOIS => 50, R1_PIERRE => 70, R1_CHEVAUX => 4),
		"prix_unt"	=>	array(U1_FERMIER => 3),
		"need_src"	=>	array(S1_ATTELAGE),
		"prod_pop"	=>	10,
		"prod_res_auto"	=>	array(R1_NOURRITURE => 20),
		"limite"	=>	20,
);

$this->btc[B1_EGLISE]=array(
		"vie"	=>	250,
		"tours"	=>	400,
		"prix_res"	=>	array(R1_BOIS => 100, R1_PIERRE => 100, R1_OR => 100, R1_NOURRITURE => 500),
		"need_btc"	=>	array(B1_FERME_AM),
		"limite"	=>	2,
		"prod_unt"      =>      true,
		);

$this->btc[B1_POUDRIERE]=array(
		"vie"	=>	250,
		"tours"	=>	350,
		"prix_res"	=>	array(R1_PIERRE => 150, R1_BOIS => 150, R1_CHARBON => 100, R1_FER => 100, R1_ACIER => 50),
		"prix_unt"	=>	array(U1_FORGERON => 2, U1_BUCHERON => 1, U1_CHERCHEUR => 2),
		"need_src"	=>	array(S1_POUDRE),
		"need_btc"	=>	array(B1_FONDERIE),
		);

$this->btc[B1_ECOLE_MAGIE]=array(
		"vie"	=>	350,
		"tours"	=>	400,
		"prix_res"	=>	array(R1_BOIS => 175, R1_PIERRE => 160, R1_OR => 150, R1_NOURRITURE => 750),
		"need_btc"	=>	array(B1_EGLISE, B1_POUDRIERE),
		"prod_unt"	=>	true,
		"limite"	=>	2,
	);
	
$this->btc[B1_GUILDE_DES_HEROS]=array(
		"vie"	=>	350,
		"tours"	=>	400,
		"prix_res"	=>	array(R1_BOIS => 175, R1_PIERRE => 160, R1_OR => 150, R1_NOURRITURE => 750),
		"need_btc"	=>	array(B1_TOURS),
		"prod_unt"	=>	true,
		"limite"	=>	1,
	);

$this->btc[B1_FORTERESSE]=array(
		"vie"	=>	4500,
		"tours"	=>	2000,
		"bonus"         =>      array('gen' => 300, 'bon' => 13.5),
		"prod_unt"	=>	4,
		"prod_src"	=>	true,
		"prod_pop"	=>	100,
		"prix_res"	=>	array(R1_BOIS => 4500, R1_PIERRE => 4500, R1_ACIER => 400),
		"prix_unt"	=>	array(U1_ARBALETRIER => 10),
		"need_btc"	=>	array(B1_ECOLE_MAGIE, B1_GUILDE_DES_HEROS),
		"limite"	=>	1,
		);
//</btc>

/*
* Unt
*/
//<unt>
$this->unt[U1_TRAVAILLEUR]=array(
		"vie"	=>	1,
		"group"	=>	1,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R1_OR => 1),
		"need_btc"	=>	array(B1_DONJON),
		"in_btc"	=>	array(B1_DONJON, B1_FORTERESSE),
);

$this->unt[U1_FERMIER]=array(
		"vie"	=>	1,
		"group"	=>	2,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R1_OR => 1),
		"need_btc"	=>	array(B1_DONJON),
		"in_btc"	=>	array(B1_DONJON, B1_FORTERESSE),
);		

$this->unt[U1_FORGERON]=array(
		"vie"	=>	1,
		"group"	=>	2,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R1_OR => 2),
		"need_btc"	=>	array(B1_DONJON),
		"in_btc"	=>	array(B1_DONJON, B1_FORTERESSE),
);		

$this->unt[U1_BUCHERON]=array(
		"vie"	=>	1,
		"group"	=>	4,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R1_OR => 1),
		"need_btc"	=>	array(B1_DONJON),
		"in_btc"	=>	array(B1_DONJON, B1_FORTERESSE),
);		

$this->unt[U1_MINEUR]=array(
		"vie"	=>	1,
		"group"	=>	4,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R1_OR => 1),
		"need_btc"	=>	array(B1_DONJON),
		"in_btc"	=>	array(B1_DONJON, B1_FORTERESSE),
);		

$this->unt[U1_CHERCHEUR]=array(
		"vie"	=>	1,
		"group"	=>	6,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R1_OR => 3),
		"need_btc"	=>	array(B1_DONJON),
		"in_btc"	=>	array(B1_DONJON, B1_FORTERESSE),
);		

$this->unt[U1_RECRUE]=array(
		"vie"	=>	1,
		"group"	=>	6,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R1_OR => 2),
		"need_btc"	=>	array(B1_DONJON),
		"in_btc"	=>	array(B1_DONJON, B1_FORTERESSE),
);		

$this->unt[U1_MILICIEN]=array(
		"vie"	=>	12,
		"def"	=>	1,
		"atq_unt"	=>	2,
		"vit"	=>	9,
		"group"	=>	8,
		"role"	=>	TYPE_UNT_INFANTERIE,
		"rang" => 1,
		"prix_res"	=>	array(),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);

$this->unt[U1_ARCHER]=array(
		"vie"	=>	11,
		"def"	=>	19,
		"atq_unt"	=>	17,
		"vit"	=>	10,
		"group"	=>	9,
		"bonus" => array('vie' => 1),
		"role"	=>	TYPE_UNT_DISTANCE,
		"rang" => 7,
		"prix_res"	=>	array(R1_ARC => 1,R1_COTTE_MAILLE => 1),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);
		
$this->unt[U1_ARBALETRIER]=array(
		"def"	=>	17,
		"vie"	=>	13,
		"atq_unt"	=>	20,
		"vit"	=>	9,
		"bonus" => array('vie' => 1),
		"group"	=>	9,
		"rang" => 8,
		"role"	=>	TYPE_UNT_DISTANCE,
		"prix_res"	=>	array(R1_ARBALETE => 1,R1_COTTE_MAILLE => 1, R1_OR => 5),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_ARMEE_2),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);
		
$this->unt[U1_FANTASSIN]=array(
		"def"	=>	7,
		"vie"	=>	14,
		"atq_unt"	=>	9,
		"vit"	=>	10,
		"group"	=>	11,
		"role"	=>	TYPE_UNT_INFANTERIE,
		"rang" => 2,
		"prix_res"	=>	array(R1_EPEE => 1,R1_B_BOIS => 1),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);

$this->unt[U1_FANTASSIN_XP]=array(
		"def"	=>	22,
		"vie"	=>	25,
		"atq_unt"	=>	22,
		"vit"	=>	9,
		"group"	=>	11,
		"role"	=>	TYPE_UNT_INFANTERIE,
		"rang" => 3,
		"prix_res"	=>	array(R1_EPEE_LON => 1,R1_B_ACIER => 1, R1_COTTE_MAILLE => 1, R1_ACIER => 2),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_ARMEE_2),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);

$this->unt[U1_CHEVALIER]=array(
		"def"	=>	8,
		"vie"	=>	17,
		"atq_unt"	=>	12,
		"vit"	=>	16,
		"group"	=>	13,
		"role"	=>	TYPE_UNT_CAVALERIE,
		"rang" => 4,
		"prix_res"	=>	array(R1_EPEE => 1, R1_B_BOIS => 1, R1_CHEVAUX => 1),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);

$this->unt[U1_CHEVALIER_XP]=array(
		"def"	=>	25,
		"vie"	=>	19,
		"atq_unt"	=>	19,
		"vit"	=>	13,
		"group"	=>	10,
		"role"	=>	TYPE_UNT_CAVALERIE,
		"rang" => 5,
		"prix_res"	=>	array(R1_EPEE_LON => 1, R1_COTTE_MAILLE => 1, R1_CHEVAUX => 1, R1_B_ACIER => 1, R1_ACIER => 2),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_ARMEE_2),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);

$this->unt[U1_CATAPULTE]=array(
		"def"	=>	5,
		"vie"	=>	14,
		"atq_unt"	=>	10,
		"atq_btc"	=>	7,
		"vit"	=>	5,
		"group"	=>	15,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 13,
		"prix_res"	=>	array(R1_PIERRE => 10, R1_BOIS => 10, R1_ACIER => 5),
		"prix_unt"	=>	array(U1_RECRUE => 2),
		"need_btc"	=>	array(B1_ATELIER),
		"in_btc"	=>	array(B1_ATELIER),
);

$this->unt[U1_BELIER]=array(
		"def"	=>	12,
		"vie"	=>	15,
		"atq_unt"	=>	0,
		"atq_btc"	=>	6,
		"vit"	=>	2,
		"group"	=>	16,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 14,
		"prix_res"	=>	array(R1_PIERRE => 7, R1_BOIS => 7, R1_ACIER => 4),
		"prix_unt"	=>	array(U1_RECRUE => 2),
		"need_btc"	=>	array(B1_ATELIER),
		"in_btc"	=>	array(B1_ATELIER),
);		

$this->unt[U1_MOINE]=array(
		"def"	=>	14,
		"bonus"	=>	array("atq" => 0.75),
		"vie"	=>	12,
		"atq_unt"	=>	15,
		"vit"	=>	9,
		"group"	=>	17,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 9,
		"prix_res"	=>	array(R1_OR => 6, R1_NOURRITURE => 30, R1_ACIER => 2, R1_MITHRIL => 1),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_MOINE),
		"need_btc"	=>	array(B1_EGLISE),
		"in_btc"	=>	array(B1_EGLISE),
);
	
$this->unt[U1_PRETRE]=array(
		"def"	=>	15,
		"bonus"	=> array('def' => 0.75),
		"vie"	=>	12,
		"atq_unt"	=>	14,
		"vit"	=>	10,
		"group"	=>	18,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 10,
		"prix_res"	=>	array(R1_OR => 6, R1_NOURRITURE => 30, R1_ACIER => 2, R1_MITHRIL => 1),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_PRETRE),
		"need_btc"	=>	array(B1_EGLISE),
		"in_btc"	=>	array(B1_EGLISE),
);
	
$this->unt[U1_CANON]=array(
		"def"	=>	5,
		"vie"	=>	16,
		"atq_unt"	=>	10,
		"atq_btc"	=>	8,
		"vit"	=>	6,
		"group"	=>	19,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 15,
		"prix_res"	=>	array(R1_FER => 15, R1_CHARBON => 15, R1_ACIER => 12),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_btc"	=>	array(B1_ATELIER, B1_POUDRIERE),
		"in_btc"	=>	array(B1_ATELIER),
);	

$this->unt[U1_MAGICIEN]=array(
		"def"	=>	6,
		"bonus"	=> array('def' => 1.5),
		"vie"	=>	10,
		"atq_unt"	=>	7,
		"vit"	=>	4,
		"group"	=>	20,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 12,
		"prix_res"	=>	array(R1_NOURRITURE => 30, R1_OR => 5, R1_ACIER =>2, R1_MITHRIL => 2),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_MAGIE_BL),
		"need_btc"	=>	array(B1_ECOLE_MAGIE),
		"in_btc"	=>	array(B1_ECOLE_MAGIE),
);	

$this->unt[U1_SORCIER]=array(
		"def"	=>	7,
		"bonus"	=> array('atq' => 1.5),
		"vie"	=>	9,
		"atq_unt"	=>	6,
		"vit"	=>	5,
		"group"	=>	21,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 11,
		"prix_res"	=>	array(R1_NOURRITURE => 30, R1_OR => 5, R1_ACIER =>2, R1_MITHRIL => 2),
		"prix_unt"	=>	array(U1_RECRUE => 1),
		"need_src"	=>	array(S1_MAGIE_NR),
		"need_btc"	=>	array(B1_ECOLE_MAGIE),
		"in_btc"	=>	array(B1_ECOLE_MAGIE),
);	

$this->unt[U1_TREBUCHET]=array(
		"def"	=>	14,
		"vie"	=>	12,
		"atq_unt"	=>	10,
		"atq_btc"	=>	11,
		"vit"	=>	3,
		"group"	=>	22,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 16,
		"prix_res"	=>	array(R1_BOIS => 25, R1_PIERRE => 25, R1_ACIER => 15),
		"prix_unt"	=>	array(U1_RECRUE => 4),
		"need_src"	=>	array(S1_ARME_3),
		"need_btc"	=>	array(B1_ATELIER),
		"in_btc"	=>	array(B1_ATELIER),
);	

$this->unt[U1_PALADIN]=array(
		"def"	=>	20,
		"vie"	=>	20,
		"atq_unt"	=>	30,
		"vit"	=>	11,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_CAVALERIE,
		"rang" => 6,
		"prix_res"	=>	array(R1_EPEE_LON => 1, R1_COTTE_MITHRIL => 1, R1_B_ACIER => 1, R1_CHEVAUX => 1),
		"prix_unt"	=>	array(7 => 1),
		"need_src" 	=>	array(S1_ARMEE_3),
		"need_btc"	=>	array(B1_CASERNE),
		"in_btc"	=>	array(B1_CASERNE),
);

$this->unt[U1_GRIFFON]=array(
		"def"	=>	130,
		"vie"	=>	132,
		"atq_unt"	=>	70,
		"vit"	=>	12,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_HEROS,
		"rang" => 18,
		"prix_res"	=>	array(R1_EPEE_LON => 1, R1_COTTE_MITHRIL => 1, R1_B_ACIER => 1, R1_MITHRIL => 1, R1_NOURRITURE => 50),
		"prix_unt"	=>	array(7 => 1),
		"need_src" 	=>	array(S1_DOMPTAGE),
		"need_btc"	=>	array(B1_GUILDE_DES_HEROS, B1_ECOLE_MAGIE),
		"in_btc"	=>	array(B1_GUILDE_DES_HEROS),
);

$this->unt[U1_GENERAL]=array(
		"def"	=>	70,
		"vie"	=>	130,
		"atq_unt"	=>	130,
		"vit"	=>	13,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_HEROS,
		"rang" => 17,
		"prix_res"	=>	array(R1_EPEE_LON => 1, R1_COTTE_MITHRIL => 1, R1_B_ACIER => 1, R1_MITHRIL => 1, R1_NOURRITURE => 50),
		"prix_unt"	=>	array(7 => 1),
		"need_src" 	=>	array(S1_GENERAL),
		"need_btc"	=>	array(B1_GUILDE_DES_HEROS),
		"in_btc"	=>	array(B1_GUILDE_DES_HEROS),
);

$this->unt[U1_INGENIEUR_GNOME]=array(
		"def"	=>	90,
		"vie"	=>	132,
		"atq_unt"	=>	100,
		"atq_btc"	=>	30,
		"vit"	=>	13,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_HEROS,
		"rang" => 19,
		"prix_res"	=>	array(R1_EPEE_LON => 1, R1_COTTE_MITHRIL => 1, R1_B_ACIER => 1, R1_MITHRIL => 1, R1_NOURRITURE => 50),
		"prix_unt"	=>	array(7 => 1),
		"need_src" 	=>	array(S1_GNOME),
		"need_btc"	=>	array(B1_GUILDE_DES_HEROS, B1_ATELIER),
		"in_btc"	=>	array(B1_GUILDE_DES_HEROS),
);

$this->unt[U1_GRANDE_CARAVELLE]=array(

		"vie"	=>	12,
		"vit"	=>	8,
		"group"	=>	22,
		"role"	=>	TYPE_UNT_DEMENAGEMENT,
		"rang" => 16,
		//"prix_res"	=>	array(R1_BOIS => 5000, R1_PIERRE => 6000, R1_ACIER => 1000, R1_OR => 2000,R1_NOURRITURE => 50000),
		"prix_res"	=>	array(R1_BOIS => 2500, R1_PIERRE => 3000, R1_ACIER => 500, R1_OR => 1000,R1_NOURRITURE => 25000),
		"prix_unt"	=>	array(U1_RECRUE => 4),
		"need_src"	=>	array(S1_DEMENAGEMENT),
		"need_btc"	=>	array(B1_ATELIER),
		"in_btc"	=>	array(B1_ATELIER),
);

//</unt>

//<src>
$this->src[S1_ARME_1]=array(
		"tours"	=>	10,
		"group"	=>	1,
		"prix_res"	=>	array(R1_BOIS => 10, R1_PIERRE => 10),
		"need_btc" => array(B1_CASERNE),
);

$this->src[S1_ARME_2]=array(
		"tours"	=>	15,
		"group"	=>	1,
		"need_src"	=>	array(S1_ARMEE_2),
		"prix_res"	=>	array(R1_OR => 30, R1_FER => 75, R1_CHARBON => 75, R1_BOIS => 30, R1_PIERRE => 20, R1_ACIER => 25),
);

$this->src[S1_ARME_3]=array(
		"tours"	=>	25,
		"group"	=>	1,
		"need_btc"	=>	array(B1_ECURIE),
		"need_src"	=>	array(S1_ARMEE_3),
		"prix_res"	=>	array(R1_OR => 70, R1_ACIER => 200, R1_BOIS => 80, R1_PIERRE => 120),
);

$this->src[S1_DEFENSE_1]=array(
		"tours"	=>	10,
		"group"	=>	4,
		"need_src" => array(S1_ARMEE_1),
		"prix_res"	=>	array(R1_BOIS => 10, R1_PIERRE => 10),
);

$this->src[S1_DEFENSE_2]=array(
		"tours"	=>	20,
		"group"	=>	4,
		"need_src"	=>	array(S1_ARMEE_2),
		"prix_res"	=>	array(R1_OR => 30, R1_FER => 50,R1_CHARBON => 50, R1_BOIS => 30, R1_PIERRE => 20, R1_ACIER => 25),
);

$this->src[S1_DEFENSE_3]=array(
		"tours"	=>	30,
		"group"	=>	4,
		"need_src"	=>	array(S1_ARME_3),
		"need_btc"	=> array(B1_FONDERIE),
		"prix_res"	=>	array(R1_OR => 90, R1_ACIER => 100, R1_BOIS => 180, R1_PIERRE => 220, R1_MITHRIL => 10),
);

$this->src[S1_ACIER]=array(
		"tours"	=>	15,
		"group"	=>	7,
		"need_btc"	=>	array(B1_MINE_CHARBON, B1_MINE_FER),
		"need_src"	=>	array(S1_COMMERCE_1),
		"prix_res"	=>	array(R1_BOIS => 20, R1_PIERRE => 120, R1_FER => 75, R1_CHARBON => 75),
);

$this->src[S1_ELEVAGE]=array(
		"tours"	=>	20,
		"group"	=>	8,
		"need_src"	=>	array(S1_ACIER, S1_ARMEE_2),
		"prix_res"	=>	array(R1_NOURRITURE => 500, R1_ACIER => 25, R1_BOIS => 75, R1_PIERRE => 75),
);

$this->src[S1_COMMERCE_1]=array(
		"tours"	=>	8,
		"group"	=>	9,
		"need_btc"	=>	array(B1_MAISON, B1_FERME),
		"prix_res"	=>	array(R1_OR => 50),
);

$this->src[S1_COMMERCE_2]=array(
		"tours"	=>	15,
		"group"	=>	9,
		"need_src"	=>	array(S1_ACIER),
		"prix_res"	=>	array(R1_OR => 200, R1_BOIS => 50, R1_PIERRE => 30, R1_NOURRITURE => 1000),
);

$this->src[S1_COMMERCE_3]=array(
		"tours"	=>	20,
		"group"	=>	9,
		"need_btc"	=>	array(B1_ECURIE),
		"need_src"	=>	array(S1_COMMERCE_2),
		"prix_res"	=>	array(R1_OR => 800, R1_NOURRITURE => 4000, R1_BOIS => 450, R1_PIERRE => 550, R1_MITHRIL => 50),
);

$this->src[S1_ARMEE_1]=array(
		"tours"	=>	8,
		"group"	=>	12,
		"need_btc"	=>	array(B1_MAISON, B1_FERME),
		"prix_res"	=>	array(R1_OR => 20, R1_NOURRITURE => 50, R1_BOIS => 10, R1_PIERRE => 10),
);

$this->src[S1_ARMEE_2]=array(
		"tours"		=>	15,
		"group"		=>	12,
		"need_src"	=>	array(S1_ARME_1, S1_DEFENSE_1),
		"prix_res"	=>	array(R1_OR => 75, R1_BOIS => 50, R1_PIERRE => 50),
);

$this->src[S1_ARMEE_3]=array(
		"tours"	=>	25,
		"group"	=>	12,
		"need_src"	=>	array(S1_ARME_2, S1_DEFENSE_2, S1_ELEVAGE),
		"need_btc"	=>  array(B1_ARMURERIE),
		"prix_res"	=>	array(R1_OR => 180, R1_ACIER => 200, R1_BOIS => 100, R1_PIERRE => 120, R1_MITHRIL => 20),
);

$this->src[S1_MINE_1]=array(
		"tours"	=>	8,
		"group"	=>	15,
		"need_btc"	=>	array(B1_MAISON, B1_FERME),
		"prix_res"	=>	array(R1_BOIS => 20, R1_PIERRE => 25),
);

$this->src[S1_MINE_2]=array(
		"tours"	=>	15,
		"group"	=>	15,
		"need_btc"	=>	array(B1_CASERNE, B1_MINE_OR),
		"prix_res"	=>	array(R1_OR => 30, R1_BOIS => 75, R1_PIERRE => 80),
);

$this->src[S1_ATTELAGE]=array(
		"tours"		=>	20,
		"group"		=>	17,
		"need_btc"	=>	array(B1_ECURIE),
		"need_src"	=>	array(S1_COMMERCE_2),
		"prix_res"	=>	array(R1_NOURRITURE => 750, R1_ACIER => 25, R1_BOIS => 60, R1_PIERRE => 40, R1_CHEVAUX => 10),
		);


$this->src[S1_DEMENAGEMENT]=array(
		"tours"	=>	30,
		"group"	=>	17,
		"need_btc"	=>	array(B1_ATELIER),
		"prix_res"	=>	array(R1_NOURRITURE => 1000, R1_OR => 800, R1_MITHRIL => 200, R1_CHARBON => 400, R1_FER => 450),
		);

$this->src[S1_MOINE]=array(
		"tours"	=>	25,
		"group"	=>	18,
		"need_btc"	=>	array(B1_EGLISE),
		"prix_res"	=>	array(R1_NOURRITURE => 300, R1_OR => 80, R1_FER => 50, R1_MITHRIL => 5),
		);

$this->src[S1_PRETRE]=array(
		"tours"	=>	25,
		"group"	=>	18,
		"need_btc"	=>	array(B1_EGLISE),
		"prix_res"	=>	array(R1_NOURRITURE => 300, R1_OR => 80, R1_CHARBON => 50, R1_MITHRIL => 5),
		);

$this->src[S1_POUDRE]=array(
		"tours"	=>	50,
		"group"	=>	20,
		"need_btc"	=>	array(B1_ATELIER, B1_LABO),
		"prix_res"	=> 	array(R1_FER => 125, R1_CHARBON => 125, R1_ACIER => 25),
		);

$this->src[S1_MAGIE_BL]=array(
		"tours"	=>	30,
		"group"	=>	21,
		"need_btc"	=>	array(B1_ECOLE_MAGIE),
		"prix_res"	=>	array(R1_FER => 100, R1_NOURRITURE => 500, R1_OR => 80, R1_MITHRIL => 15),
		);

$this->src[S1_MAGIE_NR]=array(
		"tours"	=>	30,
		"group"	=>	21,
		"need_btc"	=>	array(B1_ECOLE_MAGIE),
		"prix_res"	=>	array(R1_CHARBON => 100, R1_NOURRITURE => 500, R1_OR => 80, R1_MITHRIL => 15),
		);

$this->src[S1_DOMPTAGE]=array(
		"tours"	=>	50,
		"group"	=>	22,
		"need_src"	=>	array(S1_MAGIE_NR, S1_MAGIE_BL),
		"prix_res"	=>	array(R1_NOURRITURE => 1000, R1_OR => 80, R1_MITHRIL => 15),
		);
		
$this->src[S1_GENERAL]=array(
		"tours"	=>	50,
		"group"	=>	22,
		"need_src"	=>	array(S1_MAGIE_NR, S1_MAGIE_BL),
		"prix_res"	=>	array(R1_NOURRITURE => 1000, R1_OR => 80, R1_MITHRIL => 15),
		);
		
$this->src[S1_GNOME]=array(
		"tours"	=>	50,
		"group"	=>	22,
		"need_src"	=>	array(S1_MAGIE_NR, S1_MAGIE_BL),
		"prix_res"	=>	array(R1_NOURRITURE => 1000, R1_OR => 80, R1_MITHRIL => 15),
		);
//</src>

/* compétences du ou des héros ... */

//<comp>
/* ### Off ### */
$this->comp[CP_BOOST_OFF]=array(
	'heros'		=> array(U1_GENERAL),
	'tours'		=> 3,
	'bonus'		=> 10,
	'prix_xp'	=> 40,
	'type'		=> 1
);

$this->comp[CP_RESURECTION]=array(
	'heros'		=> array(U1_GENERAL),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_VOLEE_DE_FLECHES]=array(
	'heros'		=> array(U1_GENERAL),
	'tours'		=> 24,
	'bonus'		=> 5,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_TELEPORTATION]=array(
	'heros'		=> array(U1_GENERAL),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

/* ### Def ### */

$this->comp[CP_BOOST_DEF]=array(
	'heros'		=> array(U1_GRIFFON),
	'tours'		=> 8,
	'bonus'		=> 8,
	'prix_xp'	=> 40,
	'type'		=> 2
);

$this->comp[CP_RESISTANCE]=array(
	'heros'		=> array(U1_GRIFFON),
	'tours'		=> 6,
	'bonus'		=> 15,
	'prix_xp'	=> 60,
	'type'		=> 2
);

$this->comp[CP_REGENERATION]=array(
	'heros'		=> array(U1_GRIFFON),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 2
);

$this->comp[CP_COLLABORATION]=array(
	'heros'		=> array(U1_GRIFFON),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 2
);

/* ### Sou ### */

$this->comp[CP_CASS_BAT]=array(
	'heros'		=> array(U1_INGENIEUR_GNOME),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GENIE_COMMERCIAL]=array(
	'heros'		=> array(U1_INGENIEUR_GNOME),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_PRODUCTIVITE]=array(
	'heros'		=> array(U1_INGENIEUR_GNOME),
	'tours'		=> 24,
	'bonus'		=> 200,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GUERISON]=array(
	'heros'		=> array(U1_INGENIEUR_GNOME),
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
	'primary_res'	=>	array(R1_OR, R1_NOURRITURE),
	'second_res'	=>	array(R1_OR, R1_BOIS, R1_PIERRE, R1_NOURRITURE, R1_FER , R1_CHARBON, R1_ACIER),
	'primary_btc'	=>	array(
		'vil'	=>	array(  B1_DONJON => array('unt','src'),
					B1_CASERNE => array('unt'),
					B1_ARMURERIE => array('res'),
					B1_ATELIER => array('unt'),
					B1_ECURIE => array('res'),
					B1_EGLISE => array('unt'),
					B1_ECOLE_MAGIE => array('unt'), 
					B1_GUILDE_DES_HEROS => array('unt')),
		'ext'	=>	array( B1_MARCHE => array('ach'))),
	'bonus_res'	=>	array(R1_OR => 0.05),
	'modif_pts_btc'	=>	1,
	'debut'	=>	array(
		'res'	=>	array(R1_OR => 70, R1_BOIS => 40, R1_PIERRE => 40, R1_NOURRITURE => 1500),
		'trn'	=>	array(T1_FORET => 2, T1_MONTAGNE => 2, T1_GIS_FER => 2, T1_FILON_OR => 2, T1_GIS_CHARBON => 2),
		'unt'	=> 	array(U1_TRAVAILLEUR => 1, U1_MILICIEN => 5),
		'btc'	=> 	array(B1_DONJON => array()),
		'src'	=>	array()),
	'bonus_map' => array(MAP_EAU => 0, MAP_LAC => 0, MAP_HERBE => 2, MAP_MONTAGNE => 0, MAP_FORET => 0),
	'bonus_period' => array(PERIODS_JOUR => 2, PERIODS_NUIT => -2, PERIODS_AUBE => 2, PERIODS_CREP => -2),
	);

}
}
?>
