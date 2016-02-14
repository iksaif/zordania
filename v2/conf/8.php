<?php
/* Defines */
define("R8_OR", 1);
define("R8_BOIS", 2);
define("R8_PIERRE", 3);
define("R8_NOURRITURE", 4);
define("R8_FER", 5);
define("R8_CHARBON", 6);
define("R8_CHEVAUX", 7);
define("R8_ACIER", 8);
define("R8_MITHRIL", 9);
define("R8_B_BOIS", 10);
define("R8_B_ACIER", 11);
define("R8_EPEE", 12);
define("R8_EPEE_LON", 13);
define("R8_ARC", 14);
define("R8_ARBALETE", 15);
define("R8_COTTE_MAILLE", 16);
define("R8_COTTE_MITHRIL", 17);

define("T8_FORET", 1);
define("T8_GIS_FER", 2);
define("T8_GIS_CHARBON", 3);
define("T8_FILON_OR", 4);
define("T8_MONTAGNE", 5);

define("B8_CAMP", 1);
define("B8_CARRIERE", 2);
define("B8_SCIERIE", 3);
define("B8_MAISON", 4);
define("B8_FERME", 5);
define("B8_CASERNE", 6);
define("B8_MINE_OR", 7);
define("B8_MARCHE", 8);
define("B8_ARMURERIE", 9);
define("B8_LABO", 10);
define("B8_MINE_CHARBON", 11);
define("B8_MINE_FER", 12);
define("B8_FONDERIE", 13);
define("B8_ATELIER", 14);
define("B8_ECURIE", 15);
define("B8_TOURS", 16);
define("B8_FERME_AM", 17);
define("B8_EGLISE", 18);
define("B8_POUDRIERE", 19);
define("B8_ECOLE_MAGIE", 20);
define("B8_GUILDE_DES_HEROS", 21);
define("B8_FORTERESSE", 22);

define("U8_TRAVAILLEUR", 1);
define("U8_FERMIER", 2);
define("U8_FORGERON", 3);
define("U8_BUCHERON", 4);
define("U8_MINEUR", 5);
define("U8_CHERCHEUR", 6);
define("U8_RECRUE", 7);
define("U8_MILICIEN", 8);
define("U8_ARCHER", 9);
define("U8_ARBALETRIER", 10);
define("U8_FANTASSIN", 11);
define("U8_FANTASSIN_XP", 12);
define("U8_CHEVALIER", 13);
define("U8_CHEVALIER_XP", 14);
define("U8_CATAPULTE", 15);
define("U8_BELIER", 16);
define("U8_MOINE", 17);
define("U8_PRETRE", 18);
define("U8_CANON", 19);
define("U8_MAGICIEN", 20);
define("U8_SORCIER", 21);
define("U8_TREBUCHET", 22);
define("U8_PALADIN", 23);
define("U8_GRIFFON", 24);
define("U8_GENERAL", 25);
define("U8_INGENIEUR_GNOME", 26);

define("S8_ARME_1", 1);
define("S8_ARME_2", 2);
define("S8_ARME_3", 3);
define("S8_DEFENSE_1", 4);
define("S8_DEFENSE_2", 5);
define("S8_DEFENSE_3", 6);
define("S8_ACIER", 7);
define("S8_ELEVAGE", 8);
define("S8_COMMERCE_1", 9);
define("S8_COMMERCE_2", 10);
define("S8_COMMERCE_3", 11);
define("S8_ARMEE_1", 12);
define("S8_ARMEE_2", 13);
define("S8_ARMEE_3", 14);
define("S8_MINE_1", 15);
define("S8_MINE_2", 16);
define("S8_ATTELAGE", 17);
define("S8_MOINE", 18);
define("S8_PRETRE", 19);
define("S8_POUDRE", 20);
define("S8_MAGIE_BL", 21);
define("S8_MAGIE_NR", 22);
define("S8_DOMPTAGE", 23);
define("S8_GENERAL", 24);
define("S8_GNOME", 25);

class config8
{
var $res = array();
var $trn = array();
var $btc = array();
var $unt = array();
var $src = array();
var $comp = array();
var $race_cfg = array();

function config8()
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
$this->res[R8_OR]=array(
		"cron"	=>	true,
		"need_btc"	=>	B8_MINE_OR
);

$this->res[R8_BOIS]=array(
		"cron"	=>	true,
		"need_btc"	=>	B8_SCIERIE
);


$this->res[R8_PIERRE]=array(
		"cron"	=>	true,
		"need_btc"	=>	B8_CARRIERE
);

$this->res[R8_NOURRITURE]=array(
		"cron"	=>	true,
		"need_btc"	=>	B8_FERME
);

$this->res[R8_FER]=array(
		"cron"	=>	true,
		"need_btc"	=>	B8_MINE_FER
);

$this->res[R8_CHARBON]=array(
		"cron"	=>	true,
		"need_btc"	=>	B8_MINE_CHARBON
);

$this->res[R8_CHEVAUX]=array(
		"prix_res"	=>	array(R8_NOURRITURE => 150, R8_ACIER => 2),
		"need_btc"	=>	B8_ECURIE,
		"group"	=>	8,
);

$this->res[R8_ACIER]=array(
		"cron"	=>	true,
		"prix_res"	=>	array(R8_FER => 2, R8_CHARBON => 2),
		"need_btc"	=>	B8_FONDERIE
);
		
$this->res[R8_MITHRIL]=array("dummy" => true);

$this->res[R8_B_BOIS]=array(
		"prix_res"	=>	array(R8_BOIS => 1),
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	10,
);
		
$this->res[R8_B_ACIER]=array(
		"prix_res"	=>	array(R8_BOIS => 2, R8_ACIER => 1, R8_FER => 1, R8_CHARBON => 1),
		"need_src"	=>	array(S8_DEFENSE_2),
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	10,
);
	
$this->res[R8_EPEE]=array(
		"prix_res"	=>	array(R8_BOIS => 1), 
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	12,
);
	
$this->res[R8_EPEE_LON]=array(
		"prix_res"	=>	array(R8_ACIER => 2, R8_CHARBON => 1, R8_FER => 1),
		"need_src"	=>	array(S8_ARME_2),
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	12,
);

$this->res[R8_ARC]=array(
		"prix_res"	=>	array(R8_BOIS => 2),
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	15,
);
		
$this->res[R8_ARBALETE]=array(
		"prix_res"	=>	array(R8_BOIS => 1,R8_ACIER => 2,R8_FER => 1,R8_CHARBON => 1),
		"need_src"	=>	array(S8_ARME_2),
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	15,
);
	
$this->res[R8_COTTE_MAILLE]=array(
		"prix_res"	=>	array(R8_ACIER => 2),
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	16,
);

$this->res[R8_COTTE_MITHRIL]=array(
		"prix_res"	=>	array(R8_MITHRIL => 1),
		"need_src"	=>	array(S8_DEFENSE_2),
		"need_btc"	=>	B8_ARMURERIE,
		"group"	=>	16,
);
//</res>

//<trn>
$this->trn[T8_FORET] = array();
$this->trn[T8_GIS_FER] = array();
$this->trn[T8_GIS_CHARBON] = array();
$this->trn[T8_FILON_OR] = array();
$this->trn[T8_MONTAGNE] = array();
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
$this->btc[B8_CAMP]=array(
		"vie"	=>	1000,
		"limite"	=>	3,
		"tours"	=>	500,
		"bonus" 	=>  array('gen' => 300, 'bon' => 4),
		"prix_res"	=>	array(R8_BOIS => 2250, R8_PIERRE => 2250, R8_ACIER => 200),
		"prod_pop"	=>	20,
		"prod_src"	=>	true,
		"prod_unt"	=>	4,
		);
		
$this->btc[B8_CARRIERE]=array(
		"vie"	=>	200,
		"tours"	=>	5,
		"prix_res"	=>	array(R8_BOIS => 5, R8_PIERRE=> 6),
		"prix_trn"	=>	array(T8_MONTAGNE => 1),
		"prix_unt"	=>	array(U8_MINEUR => 1),
		"need_btc"	=>	array(B8_CAMP),
		"prod_res_auto"=>	array(R8_PIERRE => 1),
		);
		
$this->btc[B8_SCIERIE]=array(
		"vie"	=>	200,
		"tours"	=>	5,
		"prix_res"	=>	array(R8_BOIS => 5, R8_PIERRE => 8),
		"prix_trn"	=>	array(T8_FORET => 1),
		"prix_unt"	=>	array(U8_BUCHERON => 1),
		"need_btc"	=>	array(B8_CAMP),
		"prod_res_auto"	=>	array(R8_BOIS => 1),
		);
	
$this->btc[B8_MAISON]=array(
		"vie"	=>	185,
		"tours"	=>	6,
		"limite"	=>	86,
		"prod_pop"	=>	5,
		"prix_res"	=>	array(R8_BOIS => 12, R8_PIERRE => 18),
		"need_btc"	=>	array(B8_CARRIERE, B8_SCIERIE),
		);

$this->btc[B8_FERME]=array(
		"vie"	=>	350,
		"tours"	=>	8,
		"limite"	=>	50,
		"prix_res"	=>	array(R8_BOIS => 12,R8_PIERRE => 18),
		"prix_unt"	=>	array(U8_FERMIER => 1),
		"need_btc"	=>	array(B8_CARRIERE, B8_SCIERIE),
		"prod_res_auto"	=>	array(R8_NOURRITURE => 6),
		);
		
$this->btc[B8_CASERNE]=array(
		"vie"	=>	500,
		"tours"	=>	30,
		"limite"	=>	5,
		"prix_res"	=>	array(R8_BOIS => 45, R8_PIERRE => 50),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_ARMEE_1),
		"prod_unt"	=>	true,
		);
	
$this->btc[B8_MINE_OR]=array(
		"vie"	=>	200,
		"tours"	=>	30,
		"prod_res_auto"	=>	array(R8_OR => 1),
		"prix_res"	=>	array(R8_BOIS => 45, R8_PIERRE => 50),
		"prix_trn"	=>	array(T8_FILON_OR => 1),
		"prix_unt"	=>	array(U8_MINEUR => 1),
		"need_src"	=>	array(S8_MINE_1),
);

$this->btc[B8_MARCHE]=array(
		"vie"	=>	400,
		"tours"	=>	100,
		"limite"	=>	2,
		"prix_res"	=>	array(R8_BOIS => 190, R8_PIERRE => 200),
		"need_src"	=>	array(S8_COMMERCE_1),
		"need_unt"	=>	array(U8_TRAVAILLEUR => 1),
		"com"	=>	array(
					S8_COMMERCE_1 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
					S8_COMMERCE_2 => array(COM_MAX_NB2,COM_MAX_VENTES2),
					S8_COMMERCE_3 => array(COM_MAX_NB3,COM_MAX_VENTES3)
					)
);

$this->btc[B8_ARMURERIE]=array(
		"vie"	=>	500,
		"tours"	=>	150,
		"limite"	=>	3,
		"need_src"	=>	array(S8_ARMEE_2),
		"prix_res"	=>	array(R8_BOIS => 200, R8_PIERRE => 190),
		"need_unt"	=>	array(U8_BUCHERON => 1, U8_FORGERON => 1),
		"need_btc"	=>	array(B8_CASERNE, B8_MINE_OR),
		"prod_res"	=>	true,
		);

$this->btc[B8_LABO]=array(
		"vie"	=>	500,
		"tours"	=>	150,
		"limite"	=>	2,
		"prix_res"	=>	array(R8_BOIS => 100, R8_PIERRE => 100),
		"prix_unt"	=>	array(U8_CHERCHEUR => 8),
		"need_btc"	=>	array(B8_CASERNE, B8_MINE_OR),
		"prod_src"	=>	true,
);

$this->btc[B8_MINE_CHARBON]=array(
		"vie"	=>	200,
		"tours"	=>	100,
		"prod_res_auto"	=>	array(R8_CHARBON => 1),
		"prix_res"	=>	array(R8_BOIS => 60, R8_PIERRE => 60),
		"prix_trn"	=>	array(T8_GIS_CHARBON => 1),
		"prix_unt"	=>	array(U8_MINEUR => 1),
		"need_src"	=>	array(S8_MINE_2),
);

$this->btc[B8_MINE_FER]=array(
		"vie"	=>	200,
		"tours"	=>	100,
		"prod_res_auto"	=>	array(R8_FER => 1),
		"prix_res"	=>	array(R8_BOIS => 60, R8_PIERRE => 60),
		"prix_trn"	=>	array(T8_GIS_FER => 1),
		"prix_unt"	=>	array(U8_MINEUR => 1),
		"need_src"	=>	array(S8_MINE_2),
);

$this->btc[B8_FONDERIE]=array(
		"vie"	=>	500,
		"tours"	=>	250,
		"prod_res_auto"	=>	array(R8_ACIER => 1),
		"prix_res"	=>	array(R8_BOIS => 250,R8_PIERRE => 250),
		"prix_unt"	=>	array(U8_FORGERON => 1),
		"need_src"	=>	array(S8_ACIER),
);

$this->btc[B8_ATELIER]=array(
		"vie"	=>	500,
		"tours"	=>	400,
		"prix_res"	=>	array(R8_BOIS => 525, R8_PIERRE => 525),
		"prix_unt"	=>	array(U8_FORGERON => 1, U8_BUCHERON => 1,U8_CHERCHEUR => 1),
		"need_src"	=>	array(S8_ARMEE_3),
		"need_btc"	=>	array(B8_ECURIE),
		"prod_unt"	=>	true,
);

$this->btc[B8_ECURIE]=array(
		"vie"	=>	500,
		"tours"	=>	400,
		"limite"	=>	5,
		"prix_unt"	=>	array(U8_FERMIER => 1),
		"prix_res"	=>	array(R8_BOIS => 350,R8_PIERRE => 350),		
		"need_src"	=>	array(S8_ELEVAGE),
		"prod_res"	=>	true,
);

$this->btc[B8_TOURS]=array(
		"bonus"         =>      array('bon' => 3.5),
		"vie"		=>	800,
		"tours"		=>	100,
		"prix_res"	=>	array(R8_BOIS => 285, R8_PIERRE => 300, R8_ACIER => 20),
		"prix_unt"	=>	array(U8_RECRUE => 4),
		"need_src"	=>	array(S8_DEFENSE_3),
		"limite"	=>	4,
);

$this->btc[B8_FERME_AM]=array(
		"vie"		=>	550,
		"tours"		=>	150,
		"prix_res"	=>	array(R8_BOIS => 50, R8_PIERRE => 80, R8_CHEVAUX => 4),
		"prix_unt"	=>	array(U8_FERMIER => 3),
		"need_src"	=>	array(S8_ATTELAGE),
		"prod_pop"	=>	10,
		"prod_res_auto"	=>	array(R8_NOURRITURE => 20),
		"limite"	=>	20,
);

$this->btc[B8_EGLISE]=array(
		"vie"	=>	250,
		"tours"	=>	400,
		"prix_res"	=>	array(R8_BOIS => 100, R8_PIERRE => 100, R8_OR => 100, R8_NOURRITURE => 500),
		"need_btc"	=>	array(B8_FERME_AM),
		"limite"	=>	2,
		"prod_unt"      =>      true,
		);

$this->btc[B8_POUDRIERE]=array(
		"vie"	=>	250,
		"tours"	=>	350,
		"prix_res"	=>	array(R8_PIERRE => 150, R8_BOIS => 150, R8_CHARBON => 100, R8_FER => 100, R8_ACIER => 50),
		"prix_unt"	=>	array(U8_FORGERON => 2, U8_BUCHERON => 1, U8_CHERCHEUR => 2),
		"need_src"	=>	array(S8_POUDRE),
		"need_btc"	=>	array(B8_FONDERIE),
		);

$this->btc[B8_ECOLE_MAGIE]=array(
		"vie"	=>	350,
		"tours"	=>	400,
		"prix_res"	=>	array(R8_BOIS => 185, R8_PIERRE => 160, R8_OR => 150, R8_NOURRITURE => 850),
		"need_btc"	=>	array(B8_EGLISE, B8_POUDRIERE),
		"prod_unt"	=>	true,
		"limite"	=>	2,
	);
	
$this->btc[B8_GUILDE_DES_HEROS]=array(
		"vie"	=>	350,
		"tours"	=>	400,
		"prix_res"	=>	array(R8_BOIS => 185, R8_PIERRE => 160, R8_OR => 150, R8_NOURRITURE => 850),
		"need_btc"	=>	array(B8_TOURS),
		"prod_unt"	=>	true,
		"limite"	=>	1,
	);

$this->btc[B8_FORTERESSE]=array(
		"vie"	=>	4500,
		"tours"	=>	2000,
		"bonus"         =>      array('gen' => 300, 'bon' => 13.5),
		"prod_unt"	=>	4,
		"prod_src"	=>	true,
		"prod_pop"	=>	100,
		"prix_res"	=>	array(R8_BOIS => 4500, R8_PIERRE => 4500, R8_ACIER => 400),
		"prix_unt"	=>	array(U8_ARBALETRIER => 10),
		"need_btc"	=>	array(B8_ECOLE_MAGIE, B8_GUILDE_DES_HEROS),
		"limite"	=>	1,
		);
//</btc>

//<unt>
$this->unt[U8_TRAVAILLEUR]=array(
		"vie"	=>	1,
		"group"	=>	1,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R8_OR => 1),
		"need_btc"	=>	array(B8_CAMP),
		"in_btc"	=>	array(B8_CAMP, B8_FORTERESSE),
);

$this->unt[U8_FERMIER]=array(
		"vie"	=>	1,
		"group"	=>	2,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R8_OR => 1),
		"need_btc"	=>	array(B8_CAMP),
		"in_btc"	=>	array(B8_CAMP, B8_FORTERESSE),
);		

$this->unt[U8_FORGERON]=array(
		"vie"	=>	1,
		"group"	=>	2,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R8_OR => 2),
		"need_btc"	=>	array(B8_CAMP),
		"in_btc"	=>	array(B8_CAMP, B8_FORTERESSE),
);		

$this->unt[U8_BUCHERON]=array(
		"vie"	=>	1,
		"group"	=>	4,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R8_OR => 1),
		"need_btc"	=>	array(B8_CAMP),
		"in_btc"	=>	array(B8_CAMP, B8_FORTERESSE),
);		

$this->unt[U8_MINEUR]=array(
		"vie"	=>	1,
		"group"	=>	4,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R8_OR => 1),
		"need_btc"	=>	array(B8_CAMP),
		"in_btc"	=>	array(B8_CAMP, B8_FORTERESSE),
);		

$this->unt[U8_CHERCHEUR]=array(
		"vie"	=>	1,
		"group"	=>	6,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R8_OR => 3),
		"need_btc"	=>	array(B8_CAMP),
		"in_btc"	=>	array(B8_CAMP, B8_FORTERESSE),
);		

$this->unt[U8_RECRUE]=array(
		"vie"	=>	1,
		"group"	=>	6,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R8_OR => 2),
		"need_btc"	=>	array(B8_CAMP),
		"in_btc"	=>	array(B8_CAMP, B8_FORTERESSE),
);		

$this->unt[U8_MILICIEN]=array(
		"vie"	=>	12,
		"def"	=>	1,
		"atq_unt"	=>	2,
		"vit"	=>	9,
		"group"	=>	8,
		"role"	=>	TYPE_UNT_INFANTERIE,
		"rang" => 1,
		"prix_res"	=>	array(),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);

$this->unt[U8_ARCHER]=array(
		"vie"	=>	11,
		"def"	=>	19,
		"atq_unt"	=>	18,
		"vit"	=>	10,
		"group"	=>	9,
		"bonus" => array('vie' => 1),
		"role"	=>	TYPE_UNT_DISTANCE,
		"rang" => 8,
		"prix_res"	=>	array(R8_ARC => 1,R8_COTTE_MAILLE => 1),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);
		
$this->unt[U8_ARBALETRIER]=array(
		"def"	=>	18,
		"vie"	=>	13,
		"atq_unt"	=>	20,
		"vit"	=>	9,
		"bonus" => array('vie' => 1),
		"group"	=>	9,
		"rang" => 8,
		"role"	=>	TYPE_UNT_DISTANCE,
		"prix_res"	=>	array(R8_ARBALETE => 1,R8_COTTE_MAILLE => 1, R8_OR => 5),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_ARMEE_2),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);
		
$this->unt[U8_FANTASSIN]=array(
		"def"	=>	8,
		"vie"	=>	14,
		"atq_unt"	=>	9,
		"vit"	=>	10,
		"group"	=>	11,
		"role"	=>	TYPE_UNT_INFANTERIE,
		"rang" => 2,
		"prix_res"	=>	array(R8_EPEE => 1,R8_B_BOIS => 1),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);

$this->unt[U8_FANTASSIN_XP]=array(
		"def"	=>	22,
		"vie"	=>	25,
		"atq_unt"	=>	22,
		"vit"	=>	9,
		"group"	=>	11,
		"role"	=>	TYPE_UNT_INFANTERIE,
		"rang" => 3,
		"prix_res"	=>	array(R8_EPEE_LON => 1,R8_B_ACIER => 1, R8_COTTE_MAILLE => 1, R8_ACIER => 2),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_ARMEE_2),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);

$this->unt[U8_CHEVALIER]=array(
		"def"	=>	8,
		"vie"	=>	18,
		"atq_unt"	=>	12,
		"vit"	=>	16,
		"group"	=>	13,
		"role"	=>	TYPE_UNT_CAVALERIE,
		"rang" => 4,
		"prix_res"	=>	array(R8_EPEE => 1, R8_B_BOIS => 1, R8_CHEVAUX => 1),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);

$this->unt[U8_CHEVALIER_XP]=array(
		"def"	=>	25,
		"vie"	=>	19,
		"atq_unt"	=>	19,
		"vit"	=>	13,
		"group"	=>	10,
		"role"	=>	TYPE_UNT_CAVALERIE,
		"rang" => 5,
		"prix_res"	=>	array(R8_EPEE_LON => 1, R8_COTTE_MAILLE => 1, R8_CHEVAUX => 1, R8_B_ACIER => 1, R8_ACIER => 2),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_ARMEE_2),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);

$this->unt[U8_CATAPULTE]=array(
		"def"	=>	5,
		"vie"	=>	14,
		"atq_unt"	=>	10,
		"atq_btc"	=>	8,
		"vit"	=>	5,
		"group"	=>	15,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 13,
		"prix_res"	=>	array(R8_PIERRE => 10, R8_BOIS => 10, R8_ACIER => 5),
		"prix_unt"	=>	array(U8_RECRUE => 2),
		"need_btc"	=>	array(B8_ATELIER),
		"in_btc"	=>	array(B8_ATELIER),
);

$this->unt[U8_BELIER]=array(
		"def"	=>	12,
		"vie"	=>	15,
		"atq_unt"	=>	0,
		"atq_btc"	=>	6,
		"vit"	=>	2,
		"group"	=>	16,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 14,
		"prix_res"	=>	array(R8_PIERRE => 8, R8_BOIS => 8, R8_ACIER => 4),
		"prix_unt"	=>	array(U8_RECRUE => 2),
		"need_btc"	=>	array(B8_ATELIER),
		"in_btc"	=>	array(B8_ATELIER),
);		

$this->unt[U8_MOINE]=array(
		"def"	=>	14,
		"bonus"	=>	array("atq" => 0.85),
		"vie"	=>	12,
		"atq_unt"	=>	15,
		"vit"	=>	9,
		"group"	=>	18,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 9,
		"prix_res"	=>	array(R8_OR => 6, R8_NOURRITURE => 30, R8_ACIER => 2, R8_MITHRIL => 1),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_MOINE),
		"need_btc"	=>	array(B8_EGLISE),
		"in_btc"	=>	array(B8_EGLISE),
);
	
$this->unt[U8_PRETRE]=array(
		"def"	=>	15,
		"bonus"	=> array('def' => 0.85),
		"vie"	=>	12,
		"atq_unt"	=>	14,
		"vit"	=>	10,
		"group"	=>	18,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 10,
		"prix_res"	=>	array(R8_OR => 6, R8_NOURRITURE => 30, R8_ACIER => 2, R8_MITHRIL => 1),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_PRETRE),
		"need_btc"	=>	array(B8_EGLISE),
		"in_btc"	=>	array(B8_EGLISE),
);
	
$this->unt[U8_CANON]=array(
		"def"	=>	5,
		"vie"	=>	16,
		"atq_unt"	=>	10,
		"atq_btc"	=>	8,
		"vit"	=>	6,
		"group"	=>	19,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 15,
		"prix_res"	=>	array(R8_FER => 15, R8_CHARBON => 15, R8_ACIER => 12),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_btc"	=>	array(B8_ATELIER, B8_POUDRIERE),
		"in_btc"	=>	array(B8_ATELIER),
);	

$this->unt[U8_MAGICIEN]=array(
		"def"	=>	6,
		"bonus"	=> array('def' => 1.5),
		"vie"	=>	10,
		"atq_unt"	=>	8,
		"vit"	=>	4,
		"group"	=>	20,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 12,
		"prix_res"	=>	array(R8_NOURRITURE => 30, R8_OR => 5, R8_ACIER =>2, R8_MITHRIL => 2),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_MAGIE_BL),
		"need_btc"	=>	array(B8_ECOLE_MAGIE),
		"in_btc"	=>	array(B8_ECOLE_MAGIE),
);	

$this->unt[U8_SORCIER]=array(
		"def"	=>	8,
		"bonus"	=> array('atq' => 1.5),
		"vie"	=>	9,
		"atq_unt"	=>	6,
		"vit"	=>	5,
		"group"	=>	21,
		"role"	=>	TYPE_UNT_MAGIQUE,
		"rang" => 11,
		"prix_res"	=>	array(R8_NOURRITURE => 30, R8_OR => 5, R8_ACIER =>2, R8_MITHRIL => 2),
		"prix_unt"	=>	array(U8_RECRUE => 1),
		"need_src"	=>	array(S8_MAGIE_NR),
		"need_btc"	=>	array(B8_ECOLE_MAGIE),
		"in_btc"	=>	array(B8_ECOLE_MAGIE),
);	

$this->unt[U8_TREBUCHET]=array(
		"def"	=>	14,
		"vie"	=>	12,
		"atq_unt"	=>	10,
		"atq_btc"	=>	11,
		"vit"	=>	3,
		"group"	=>	22,
		"role"	=>	TYPE_UNT_MACHINE,
		"rang" => 16,
		"prix_res"	=>	array(R8_BOIS => 25, R8_PIERRE => 25, R8_ACIER => 15),
		"prix_unt"	=>	array(U8_RECRUE => 4),
		"need_src"	=>	array(S8_ARME_3),
		"need_btc"	=>	array(B8_ATELIER),
		"in_btc"	=>	array(B8_ATELIER),
);	

$this->unt[U8_PALADIN]=array(
		"def"	=>	20,
		"vie"	=>	20,
		"atq_unt"	=>	30,
		"vit"	=>	11,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_CAVALERIE,
		"rang" => 6,
		"prix_res"	=>	array(R8_EPEE_LON => 1, R8_COTTE_MITHRIL => 1, R8_B_ACIER => 1, R8_CHEVAUX => 1),
		"prix_unt"	=>	array(8 => 1),
		"need_src" 	=>	array(S8_ARMEE_3),
		"need_btc"	=>	array(B8_CASERNE),
		"in_btc"	=>	array(B8_CASERNE),
);

$this->unt[U8_GRIFFON]=array(
		"def"	=>	130,
		"vie"	=>	132,
		"atq_unt"	=>	80,
		"vit"	=>	12,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_HEROS,
		"rang" => 18,
		"prix_res"	=>	array(R8_EPEE_LON => 1, R8_COTTE_MITHRIL => 1, R8_B_ACIER => 1, R8_MITHRIL => 1, R8_NOURRITURE => 50),
		"prix_unt"	=>	array(8 => 1),
		"need_src" 	=>	array(S8_DOMPTAGE),
		"need_btc"	=>	array(B8_GUILDE_DES_HEROS, B8_ECOLE_MAGIE),
		"in_btc"	=>	array(B8_GUILDE_DES_HEROS),
);

$this->unt[U8_GENERAL]=array(
		"def"	=>	80,
		"vie"	=>	130,
		"atq_unt"	=>	130,
		"vit"	=>	13,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_HEROS,
		"rang" => 18,
		"prix_res"	=>	array(R8_EPEE_LON => 1, R8_COTTE_MITHRIL => 1, R8_B_ACIER => 1, R8_MITHRIL => 1, R8_NOURRITURE => 50),
		"prix_unt"	=>	array(8 => 1),
		"need_src" 	=>	array(S8_GENERAL),
		"need_btc"	=>	array(B8_GUILDE_DES_HEROS),
		"in_btc"	=>	array(B8_GUILDE_DES_HEROS),
);

$this->unt[U8_INGENIEUR_GNOME]=array(
		"def"	=>	90,
		"vie"	=>	132,
		"atq_unt"	=>	100,
		"atq_btc"	=>	30,
		"vit"	=>	13,
		"group"	=>	23,
		"role"	=>	TYPE_UNT_HEROS,
		"rang" => 19,
		"prix_res"	=>	array(R8_EPEE_LON => 1, R8_COTTE_MITHRIL => 1, R8_B_ACIER => 1, R8_MITHRIL => 1, R8_NOURRITURE => 50),
		"prix_unt"	=>	array(8 => 1),
		"need_src" 	=>	array(S8_GNOME),
		"need_btc"	=>	array(B8_GUILDE_DES_HEROS, B8_ATELIER),
		"in_btc"	=>	array(B8_GUILDE_DES_HEROS),
);
//</unt>

//<src>
$this->src[S8_ARME_1]=array(
		"tours"	=>	10,
		"group"	=>	1,
		"prix_res"	=>	array(R8_BOIS => 10, R8_PIERRE => 10),
		"need_btc" => array(B8_CASERNE),
);

$this->src[S8_ARME_2]=array(
		"tours"	=>	50,
		"group"	=>	1,
		"need_src"	=>	array(S8_ARMEE_2),
		"prix_res"	=>	array(R8_OR => 30, R8_FER => 85, R8_CHARBON => 85, R8_BOIS => 30, R8_PIERRE => 20, R8_ACIER => 25),
);

$this->src[S8_ARME_3]=array(
		"tours"	=>	100,
		"group"	=>	1,
		"need_btc"	=>	array(B8_ECURIE),
		"need_src"	=>	array(S8_ARMEE_3),
		"prix_res"	=>	array(R8_OR => 80, R8_ACIER => 200, R8_BOIS => 80, R8_PIERRE => 120),
);

$this->src[S8_DEFENSE_1]=array(
		"tours"	=>	10,
		"group"	=>	4,
		"need_src" => array(S8_ARMEE_1),
		"prix_res"	=>	array(R8_BOIS => 10, R8_PIERRE => 10),
);

$this->src[S8_DEFENSE_2]=array(
		"tours"	=>	50,
		"group"	=>	4,
		"need_src"	=>	array(S8_ARMEE_2),
		"prix_res"	=>	array(R8_OR => 30, R8_FER => 50,R8_CHARBON => 50, R8_BOIS => 30, R8_PIERRE => 20, R8_ACIER => 25),
);

$this->src[S8_DEFENSE_3]=array(
		"tours"	=>	100,
		"group"	=>	4,
		"need_src"	=>	array(S8_ARME_3),
		"need_btc"	=> array(B8_FONDERIE),
		"prix_res"	=>	array(R8_OR => 90, R8_ACIER => 100, R8_BOIS => 180, R8_PIERRE => 220, R8_MITHRIL => 10),
);

$this->src[S8_ACIER]=array(
		"tours"	=>	50,
		"group"	=>	8,
		"need_btc"	=>	array(B8_MINE_CHARBON, B8_MINE_FER),
		"need_src"	=>	array(S8_COMMERCE_1),
		"prix_res"	=>	array(R8_BOIS => 20, R8_PIERRE => 120, R8_FER => 85, R8_CHARBON => 85),
);

$this->src[S8_ELEVAGE]=array(
		"tours"	=>	50,
		"group"	=>	8,
		"need_src"	=>	array(S8_ACIER, S8_ARMEE_2),
		"prix_res"	=>	array(R8_NOURRITURE => 500, R8_ACIER => 25, R8_BOIS => 85, R8_PIERRE => 85),
);

$this->src[S8_COMMERCE_1]=array(
		"tours"	=>	20,
		"group"	=>	9,
		"need_btc"	=>	array(B8_MAISON, B8_FERME),
		"prix_res"	=>	array(R8_OR => 50),
);

$this->src[S8_COMMERCE_2]=array(
		"tours"	=>	85,
		"group"	=>	9,
		"need_src"	=>	array(S8_ACIER),
		"prix_res"	=>	array(R8_OR => 200, R8_BOIS => 50, R8_PIERRE => 30, R8_NOURRITURE => 1000),
);

$this->src[S8_COMMERCE_3]=array(
		"tours"	=>	125,
		"group"	=>	9,
		"need_btc"	=>	array(B8_ECURIE),
		"need_src"	=>	array(S8_COMMERCE_2),
		"prix_res"	=>	array(R8_OR => 800, R8_NOURRITURE => 4000, R8_BOIS => 450, R8_PIERRE => 550, R8_MITHRIL => 50),
);

$this->src[S8_ARMEE_1]=array(
		"tours"	=>	20,
		"group"	=>	12,
		"need_btc"	=>	array(B8_MAISON, B8_FERME),
		"prix_res"	=>	array(R8_OR => 20, R8_NOURRITURE => 50, R8_BOIS => 10, R8_PIERRE => 10),
);

$this->src[S8_ARMEE_2]=array(
		"tours"		=>	50,
		"group"		=>	12,
		"need_src"	=>	array(S8_ARME_1, S8_DEFENSE_1),
		"prix_res"	=>	array(R8_OR => 85, R8_BOIS => 50, R8_PIERRE => 50),
);

$this->src[S8_ARMEE_3]=array(
		"tours"	=>	125,
		"group"	=>	12,
		"need_src"	=>	array(S8_ARME_2, S8_DEFENSE_2, S8_ELEVAGE),
		"need_btc"	=>  array(B8_ARMURERIE),
		"prix_res"	=>	array(R8_OR => 180, R8_ACIER => 200, R8_BOIS => 100, R8_PIERRE => 120, R8_MITHRIL => 20),
);

$this->src[S8_MINE_1]=array(
		"tours"	=>	15,
		"group"	=>	15,
		"need_btc"	=>	array(B8_MAISON, B8_FERME),
		"prix_res"	=>	array(R8_BOIS => 20, R8_PIERRE => 25),
);

$this->src[S8_MINE_2]=array(
		"tours"	=>	30,
		"group"	=>	15,
		"need_btc"	=>	array(B8_CASERNE, B8_MINE_OR),
		"prix_res"	=>	array(R8_OR => 30, R8_BOIS => 85, R8_PIERRE => 80),
);

$this->src[S8_ATTELAGE]=array(
		"tours"		=>	50,
		"group"		=>	18,
		"need_btc"	=>	array(B8_ECURIE),
		"need_src"	=>	array(S8_COMMERCE_2),
		"prix_res"	=>	array(R8_NOURRITURE => 850, R8_ACIER => 25, R8_BOIS => 60, R8_PIERRE => 40, R8_CHEVAUX => 10),
		);

$this->src[S8_MOINE]=array(
		"tours"	=>	85,
		"group"	=>	18,
		"need_btc"	=>	array(B8_EGLISE),
		"prix_res"	=>	array(R8_NOURRITURE => 300, R8_OR => 80, R8_FER => 50, R8_MITHRIL => 5),
		);

$this->src[S8_PRETRE]=array(
		"tours"	=>	85,
		"group"	=>	18,
		"need_btc"	=>	array(B8_EGLISE),
		"prix_res"	=>	array(R8_NOURRITURE => 300, R8_OR => 80, R8_CHARBON => 50, R8_MITHRIL => 5),
		);

$this->src[S8_POUDRE]=array(
		"tours"	=>	125,
		"group"	=>	20,
		"need_btc"	=>	array(B8_ATELIER, B8_LABO),
		"prix_res"	=> 	array(R8_FER => 125, R8_CHARBON => 125, R8_ACIER => 25),
		);

$this->src[S8_MAGIE_BL]=array(
		"tours"	=>	200,
		"group"	=>	21,
		"need_btc"	=>	array(B8_ECOLE_MAGIE),
		"prix_res"	=>	array(R8_FER => 100, R8_NOURRITURE => 500, R8_OR => 80, R8_MITHRIL => 15),
		);

$this->src[S8_MAGIE_NR]=array(
		"tours"	=>	200,
		"group"	=>	21,
		"need_btc"	=>	array(B8_ECOLE_MAGIE),
		"prix_res"	=>	array(R8_CHARBON => 100, R8_NOURRITURE => 500, R8_OR => 80, R8_MITHRIL => 15),
		);

$this->src[S8_DOMPTAGE]=array(
		"tours"	=>	200,
		"group"	=>	21,
		"need_src"	=>	array(S8_MAGIE_NR, S8_MAGIE_BL),
		"prix_res"	=>	array(R8_NOURRITURE => 1000, R8_OR => 80, R8_MITHRIL => 15),
		);
		
$this->src[S8_GENERAL]=array(
		"tours"	=>	200,
		"group"	=>	21,
		"need_src"	=>	array(S8_MAGIE_NR, S8_MAGIE_BL),
		"prix_res"	=>	array(R8_NOURRITURE => 1000, R8_OR => 80, R8_MITHRIL => 15),
		);
		
$this->src[S8_GNOME]=array(
		"tours"	=>	200,
		"group"	=>	21,
		"need_src"	=>	array(S8_MAGIE_NR, S8_MAGIE_BL),
		"prix_res"	=>	array(R8_NOURRITURE => 1000, R8_OR => 80, R8_MITHRIL => 15),
		);
//</src>	

/* compétences du héros - offensif / défensif / soutient */

//<comp>
$this->comp[CP_BOOST_OFF]=array(
	'heros'		=> array(U8_GENERAL),
	'tours'		=> 3,
	'bonus'		=> 10,
	'prix_xp'	=> 40,
	'type'		=> 1
);

$this->comp[CP_RESURECTION]=array(
	'heros'		=> array(U8_GENERAL),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_VOLEE_DE_FLECHES]=array(
	'heros'		=> array(U8_GENERAL),
	'tours'		=> 24,
	'bonus'		=> 5,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_TELEPORTATION]=array(
	'heros'		=> array(U8_GENERAL),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

/* ### Def ### */

$this->comp[CP_BOOST_DEF]=array(
	'heros'		=> array(U8_GRIFFON),
	'tours'		=> 8,
	'bonus'		=> 8,
	'prix_xp'	=> 40,
	'type'		=> 2
);

$this->comp[CP_RESISTANCE]=array(
	'heros'		=> array(U8_GRIFFON),
	'tours'		=> 6,
	'bonus'		=> 15,
	'prix_xp'	=> 60,
	'type'		=> 2
);

$this->comp[CP_REGENERATION]=array(
	'heros'		=> array(U8_GRIFFON),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 2
);

$this->comp[CP_COLLABORATION]=array(
	'heros'		=> array(U8_GRIFFON),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 2
);

/* ### Sou ### */

$this->comp[CP_CASS_BAT]=array(
	'heros'		=> array(U8_INGENIEUR_GNOME),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GENIE_COMMERCIAL]=array(
	'heros'		=> array(U8_INGENIEUR_GNOME),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_PRODUCTIVITE]=array(
	'heros'		=> array(U8_INGENIEUR_GNOME),
	'tours'		=> 24,
	'bonus'		=> 200,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GUERISON]=array(
	'heros'		=> array(U8_INGENIEUR_GNOME),
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
	'primary_res'	=>	array(R8_OR, R8_NOURRITURE),
	'second_res'	=>	array(R8_OR, R8_BOIS, R8_PIERRE, R8_NOURRITURE, R8_FER , R8_CHARBON, R8_ACIER),
	'primary_btc'	=>	array(
		'vil'	=>	array(  B8_CAMP => array('unt','src'),
					B8_CASERNE => array('unt'),
					B8_ARMURERIE => array('res'),
					B8_ATELIER => array('unt'),
					B8_ECURIE => array('res'),
					B8_EGLISE => array('unt'),
					B8_ECOLE_MAGIE => array('unt'), 
					B8_GUILDE_DES_HEROS => array('unt')),
		'ext'	=>	array( B8_MARCHE => array('ach'))
	),
	'bonus_res'	=>	array(R8_OR => 0.05),
	'modif_pts_btc'	=>	1,
	'debut'	=>	array(
		'res'	=>	array(R8_OR => 40, R8_BOIS => 30, R8_PIERRE => 30, R8_NOURRITURE => 1250),
		'trn'	=>	array(T8_FORET => 2, T8_MONTAGNE => 2, T8_GIS_FER => 2, T8_FILON_OR => 2, T8_GIS_CHARBON => 2),
		'unt'	=> 	array(U8_TRAVAILLEUR => 1, U8_MILICIEN => 5),
		'btc'	=> 	array(B8_CAMP => array()),
		'src'	=>	array()),
	'bonus_map' => array(MAP_EAU => 0, MAP_LAC => 0, MAP_HERBE => 2, MAP_MONTAGNE => 0, MAP_FORET => 0),
	'bonus_period' => array(PERIODS_JOUR => 2, PERIODS_NUIT => -2, PERIODS_AUBE => 2, PERIODS_CREP => -2),
);

}
}
?>
