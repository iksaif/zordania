<?php

define("R4_OR", 1);
define("R4_BOIS", 2);
define("R4_PIERRE", 3);
define("R4_NOURITURE", 4);
define("R4_FER", 5);
define("R4_CHARBON", 6);
define("R4_WORGS", 7);
define("R4_ACIER", 8);
define("R4_MITHRIL", 9);
define("R4_BOUCLIER", 10);
define("R4_MASSUE", 11);
define("R4_HACHE", 12);
define("R4_HALLEBARDE", 13);
define("R4_ARC", 14);
define("R4_ARBALETE", 15);
define("R4_C_NOIR", 16);
define("R4_C_MITHRIL", 17);

define("T4_FORET", 1);
define("T4_GIS_FER", 2);
define("T4_GIS_CHARBON", 3);
define("T4_FILON_OR", 4);
define("T4_MONTAGNE", 5);

define("B4_NID", 1);
define("B4_CARRIERE", 2);
define("B4_SCIERIE", 3);
define("B4_HABITATION", 4);
define("B4_AIRE_CHASSE", 5);
define("B4_SERRE_DE_COMBAT", 6);
define("B4_GALERIE_DOR", 7);
define("B4_MARCHE", 8);
define("B4_MAISON_LAMES", 9);
define("B4_FONDERIE", 10);
define("B4_AIRE_DRESSAGE", 11);
define("B4_G_CHARBON", 12);
define("B4_G_FER", 13);
define("B4_FORGE", 14);
define("B4_G_CHASSEURS", 15);
define("B4_AVANT_POSTE", 16);
define("B4_G_LAMES", 17);
define("B4_G_DRESSEURS", 18);
define("B4_DEMEURE", 19);
define("B4_TEMPLE", 20);
define("B4_AUTEL", 21);
define("B4_G_FORGERONS", 22);
define("B4_AUTEL_MATRONNES", 23);
define("B4_CITADELLE", 24);

define("U4_SERVITEUR", 1);
define("U4_CHASSEUR", 2);
define("U4_DRESSEUR", 3);
define("U4_FORGERON", 4);
define("U4_MINEUR", 5);
define("U4_BUCHERON", 6);
define("U4_CONVOQUE", 7);
define("U4_COMBATTANT", 8);
define("U4_ASSASSIN", 9);
define("U4_OMBRE", 10);
define("U4_BRIGAND", 11);
define("U4_CAPUCHE_NOIRE", 12);
define("U4_HALLEBARDIER_NOIR", 13);
define("U4_ARBLALETRIER_NOIR", 14);
define("U4_GEANT_ROCHE", 15);
define("U4_AILES_NOCTURNES", 16);
define("U4_A_TISSEUSE", 17);
define("U4_W_GUERRIER", 18);
define("U4_A_GUERRIERE", 19);
define("U4_BASILIC", 20);
define("U4_PRETRESSE_DLN", 21);
define("U4_CLERC_DLN", 22);
define("U4_MAITRE_LAME", 23);
define("U4_GUARDIENNE", 24);
define("U4_ENVOYE_LOLTH", 25);
define("U4_ENVOYE_EILISTRAEE", 26);
define("U4_DENVER", 27);
define("U4_OLIPHANT", 28);

define("S4_ARME_1", 1);
define("S4_ARME_2", 2);
define("S4_DEFENSE_1", 3);
define("S4_DEFENSE_2", 4);
define("S4_FORTIFICATION", 5);
define("S4_FONTE_ACIER", 6);
define("S4_DRESSAGE_1", 7);
define("S4_DRESSAGE_2", 8);
define("S4_DRESSAGE_3", 9);
define("S4_ATTELAGE", 10);
define("S4_COMMERCE_1", 11);
define("S4_COMMERCE_2", 12);
define("S4_COMMERCE_3", 13);
define("S4_ARMEE_1", 14);
define("S4_ARMEE_2", 15);
define("S4_ARMEE_3", 16);
define("S4_GALERIES_1", 17);
define("S4_GALERIES_2", 18);
define("S4_DON_DLN", 19);
define("S4_PRETRESSE_DLN", 20);
define("S4_CLERC_DLN", 21);
define("S4_DON_DE_LOLTH", 22);
define("S4_DON_DEILISTRAEE", 23);
define("S4_DENVER", 24);
define("S4_APPEL_MONSTREUX", 25);

class config4
{
var $res = array();
var $trn = array();
var $btc = array();
var $unt = array();
var $src = array();
var $comp = array();
var $race_cfg = array();

function config4()
{
//<res>
$this->res=array();

$this->res[R4_OR]=array(
		"cron"	=> true,
		"need_btc"	=>	B4_GALERIE_DOR,
		);

$this->res[R4_BOIS]=array(
    		"cron"	=> true,
		"need_btc"	=>	B4_SCIERIE,
		);

$this->res[R4_PIERRE]=array(
		"cron"	=> true,
		"need_btc"	=>	B4_CARRIERE,
		);

$this->res[R4_NOURITURE]=array(
		"cron"	=> true,
		"need_btc"	=>	B4_AIRE_CHASSE,
		);

$this->res[R4_FER]=array(
		"cron"	=> true,
		"need_btc"	=>	B4_G_FER,
		);

$this->res[R4_CHARBON]=array(
		"cron"	=> true,
		"need_btc"	=>	B4_G_CHARBON,
		);

$this->res[R4_WORGS]= array(
		"prix_res"	=>	array(R4_NOURITURE => 150,R4_ACIER => 4),
		"need_src"	=>	array(S4_DRESSAGE_2),
		"need_btc"	=>	B4_G_DRESSEURS,
		"group"         =>      1,
		);
		
$this->res[R4_ACIER]=array(
		"prix_res"	=>	array(R4_CHARBON => 2, R4_FER => 2),
		"need_src"	=>	array(S4_FONTE_ACIER),
		"need_btc"	=>	B4_FONDERIE,
		);

$this->res[R4_MITHRIL]=array("dummy" => true);

$this->res[R4_BOUCLIER]=array(
		"prix_res" 	=>	array(R4_ACIER => 1),
		"need_src"	=>	array(S4_DEFENSE_1),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	10,
		);
		
$this->res[R4_MASSUE]=array(
		"prix_res"	=>	array(R4_ACIER => 2),
		"need_src"	=>	array(S4_ARME_2),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	11,
		);
	
//hache
$this->res[R4_HACHE]=array(
		"prix_res"	=>	array(R4_ACIER => 1,R4_BOIS => 1),
		"need_src"	=>	array(S4_ARME_1),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	11,
		);
	
//hallebarde
$this->res[R4_HALLEBARDE]=array(
		"prix_res"	=>	array(R4_ACIER => 2,R4_BOIS => 2),
		"need_src"	=>	array(S4_ARME_2),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	11,
		);

//arc
$this->res[R4_ARC]=array(
		"prix_res"	=>	array(R4_ACIER => 1,R4_BOIS => 1),
		"need_src"	=>	array(S4_ARME_1),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	14,
		);
		
//arbalète
$this->res[R4_ARBALETE]=array(
		"prix_res"	=>	array(R4_ACIER => 2,R4_BOIS => 2),
		"need_src"	=>	array(S4_ARME_2),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	14,
		);
	
//cotte noire
$this->res[R4_C_NOIR]=array(
		"prix_res"	=>	array(R4_ACIER => 2),
		"need_src"	=>	array(S4_DEFENSE_1),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	16,
		);
		
//cotte de mithril
$this->res[R4_C_MITHRIL]=array(
		"prix_res"	=>	array(R4_MITHRIL => 1),
		"need_src"	=>	array(S4_DEFENSE_2),
		"need_btc"	=>	B4_FORGE,
		"group"		=>	16,
		);
//</res>

//<trn>
$this->trn[T4_FORET] = array();
$this->trn[T4_GIS_FER] = array();
$this->trn[T4_GIS_CHARBON] = array();
$this->trn[T4_FILON_OR] = array();
$this->trn[T4_MONTAGNE] = array();
//</trn>

//<btc>
$this->btc[B4_NID]=array(
		"bonus" 	=> array('gen' => 350, 'bon' => 4),
		"vie"		=>	1000,
		"prod_pop"	=>	30,
		"limite"	=>	1,
		"tours"		=>	500,
		"prix_res"	=>	array(R4_PIERRE => 2250,R4_BOIS => 750,R4_ACIER => 200),
		"prod_unt"  =>      4,
		"prod_src"  =>      true,
		);

//Carrière,
$this->btc[B4_CARRIERE]=array(
		"vie"		=>	250,
		"prix_res"		=>	array(R4_BOIS => 5, R4_PIERRE => 8),
		"prix_trn"		=>	array(T4_MONTAGNE => 1),
		"tours"		=>	5,
		"need_btc"	=>	array(B4_NID),
		"prod_res_auto"	=>	array(R4_PIERRE => 2),
		"prix_unt"	=>	array(U4_MINEUR => 1),
		);

//Scierie,		
$this->btc[B4_SCIERIE]=array(
		"vie"		=>	250,
		"prix_res"		=>	array(R4_BOIS => 5, R4_PIERRE => 8),
		"tours"		=>	5,
		"prix_trn"		=>	array(T4_FORET => 1),
		"need_btc"	=>	array(B4_NID),
		"prod_res_auto"	=>	array(R4_BOIS => 1),
		"prix_unt"	=>	array(U4_BUCHERON => 1),
		);

//Habitation,
$this->btc[B4_HABITATION]=array(
		"vie"		=>	175,
		"prod_pop" 	=> 	8,
		"tours"		=>	8,
		"prix_res"		=>	array(R4_BOIS => 10,R4_PIERRE => 20),
		"need_btc"	=>	array(B4_CARRIERE,B4_SCIERIE),
		"limite"	=>	33,
);
		
//Aire de Chasse,
$this->btc[B4_AIRE_CHASSE]=array(
		"vie"		=>	200,
		"tours"		=>	8,
		"prod_res_auto"	=>	array(R4_NOURITURE => 10),
		"prix_res"		=>	array(R4_BOIS => 10, R4_PIERRE => 20,),
		"need_btc"	=>	array(B4_CARRIERE, B4_SCIERIE),
		"prix_unt"		=>	array(U4_CHASSEUR => 1),
		"limite"		=>	37,
);

//Serre de Combat,
$this->btc[B4_SERRE_DE_COMBAT]=array(
		"vie"		=>	300,
		"tours"		=>	15,
		"need_src"	=>	array(S4_ARMEE_1),
		"prix_res"		=>	array(R4_BOIS => 16, R4_PIERRE => 24),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"limite"	=>	5,
		"prod_unt"	=>	true,
);

//Galerie d'or,
$this->btc[B4_GALERIE_DOR]=array(
		"vie"		=>	300,
		"tours"		=>	50,
		"need_src"	=>	array(S4_GALERIES_1),
		"prod_res_auto"	=>	array(R4_OR => 2),
		"prix_res"		=>	array(R4_BOIS => 45,R4_PIERRE => 55),
		"prix_trn"		=>	array(T4_FILON_OR => 1),
		"prix_unt"	=>	array(U4_MINEUR => 1),
);
	
//Marché,
$this->btc[B4_MARCHE]=array(
		"vie"		=>	600,
		"tours"		=>	120,
		"need_src"   =>  array(S4_COMMERCE_1),
		"prix_res"		=>	array(R4_BOIS => 90, R4_PIERRE => 185,R4_OR => 50),
		"prix_unt"	=>	array(U4_SERVITEUR => 2),
 		"limite"	=>	2,
		"com" => array(
		S4_COMMERCE_1 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
		S4_COMMERCE_2 => array(COM_MAX_NB2,COM_MAX_VENTES2),
		S4_COMMERCE_3 => array(COM_MAX_NB3,COM_MAX_VENTES3))
);

//Maison des Lames,
$this->btc[B4_MAISON_LAMES]=array(
		"vie"		=>	500,
		"tours"		=>	150,
		"prix_res"		=>	array(R4_BOIS => 100, R4_PIERRE => 150),
		"need_src"   =>  array(S4_ARMEE_2),
		"prix_unt"	=>	array(U4_SERVITEUR => 1, U4_CONVOQUE => 1),
		"limite"	=>	5,
		"prod_unt"      =>      true,
);
		
//Fonderie,
$this->btc[B4_FONDERIE]=array(
		"vie"		=>	600,
		"prix_res"		=>	array(R4_BOIS => 160,R4_PIERRE => 240,R4_FER => 50,R4_CHARBON => 50),
		"tours"		=>	150,
		"prix_unt"		=>	array(U4_FORGERON => 1),
		"need_src"	=>	array(S4_FONTE_ACIER),
		"prod_res_auto"	=>	array(R4_ACIER => 1),
		"limite"	=>	3,
		);
		
//Aire de dressage,
$this->btc[B4_AIRE_DRESSAGE]=array(
		"vie"		=>	300,
		"tours"		=>	20,
		"prix_res"		=>	array(R4_BOIS => 80, R4_PIERRE => 120),
		"need_src"   =>  array(S4_DRESSAGE_1),
		"prix_unt"	=>	array(U4_SERVITEUR => 1, U4_CHASSEUR => 1, U4_DRESSEUR => 2),
		"limite"	=>	3,
		"prod_unt"	=>	true,
);

//Galerie de Charbon,
$this->btc[B4_G_CHARBON]=array(
		"vie"		=>	300,
		"tours"		=>	100,
		"prod_res_auto"	=>	array(R4_CHARBON => 1),
		"prix_res"		=>	array(R4_BOIS => 70,R4_PIERRE => 90),
		"prix_trn"		=>	array(T4_GIS_CHARBON => 1),
		"need_src"   =>  array(S4_GALERIES_2),
		"prix_unt"	=>	array(U4_MINEUR => 1),
);

//Galerie de Fer,
$this->btc[B4_G_FER]=array(
		"vie"		=>	300,
		"tours"		=>	100,
		"prod_res_auto"	=>	array(R4_FER => 1),
		"prix_res"		=>	array(R4_BOIS => 70,R4_PIERRE => 90),
		"prix_trn"		=>	array(T4_GIS_FER => 1),
		"need_src"   =>  array(S4_GALERIES_2),
		"prix_unt"	=>	array(U4_MINEUR => 1),
		);

//Forge,
$this->btc[B4_FORGE]=array(
		"vie"		=>	600,
		"tours"		=>	250,
		"need_src"	=>	array(S4_ARME_1),
		"prix_res"		=>	array(R4_BOIS => 100,R4_PIERRE => 150,R4_OR => 50,R4_ACIER => 20),
		"need_btc"	=>	array(B4_FONDERIE),
		"prix_unt"	=>	array(U4_FORGERON => 1),
		"limite"	=>	5,
		"prod_res"	=>	true,
);

//Guilde des Chasseurs,
$this->btc[B4_G_CHASSEURS]=array(
		"vie"		=>	400,
		"tours"		=>	80,
		"prod_res_auto"	=>	array(R4_NOURITURE => 15),
		"prix_res"		=>	array(R4_BOIS => 20, R4_PIERRE => 40, R4_WORGS => 2),
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"prix_unt"		=>	array(U4_CHASSEUR => 2),
		"limite" => 22,
);

//Avant-poste,
$this->btc[B4_AVANT_POSTE]=array(
		"bonus" 	=> array('bon' => 3),
		"vie"		=>	950,
		"tours"		=>	150,
		"need_src"	=>	array(S4_FORTIFICATION),
		"prix_res"		=>	array(R4_BOIS => 100,R4_PIERRE => 300, R4_ACIER => 20),
		"prix_unt"		=>	array(U4_CAPUCHE_NOIRE => 4),
		"limite"		=>	4,
);

//Guilde des Lames,
$this->btc[B4_G_LAMES]=array(
		"vie"		=>  1000,
		"need_src"	=>  array(S4_ATTELAGE),
		"prix_res"		=> array(R4_BOIS => 250,R4_PIERRE => 350,R4_ACIER => 50),
		"tours"		=>	500,
		"prix_unt"	=> array(U4_SERVITEUR => 2, U4_CONVOQUE => 2),
		"limite"	=>	5,
		"prod_unt"	=>	true,
);

//Guilde des Dresseurs,
$this->btc[B4_G_DRESSEURS]=array(
		"vie"		=> 400,
		"need_src"	=> array(S4_DRESSAGE_2),
		"prix_res"		=> array(R4_BOIS => 180, R4_PIERRE => 220,R4_ACIER => 30),
		"tours"		=> 400,
		"prix_unt"	=> array(U4_SERVITEUR => 1, U4_CHASSEUR => 2, U4_DRESSEUR => 2),
		"limite"	=> 3,
		"prod_res"	=>	true,
		"prod_unt"	=>	true,
);

//Demeure
$this->btc[B4_DEMEURE]=array(
		"vie"		=>	175,
		"prod_pop" => 18,
		"tours"		=>	20,
		"prix_res"		=>	array(R4_BOIS => 10,R4_PIERRE => 20),
		"need_btc"	=>	array(B4_G_LAMES),
		"limite" => 17,
);

//Temple
$this->btc[B4_TEMPLE]=array(
		"vie"			=>	800,
		"prix_res"		=>	array(R4_BOIS => 125, R4_PIERRE => 175,R4_OR => 200,R4_MITHRIL => 20),
		"tours"		=>	350,
		"prix_unt"		=>	array(U4_SERVITEUR => 3),
		"need_src"	=>	array(S4_DON_DLN),
		"limite"		=>	3,
		"prod_unt"	=>	true
);
		
//Autel
$this->btc[B4_AUTEL]=array(
		"vie"			=>	500,
		"prix_res"		=>	array(R4_PIERRE => 200,R4_OR => 100,R4_MITHRIL => 15),
		"tours"		=>	300,
		"need_src"	=>	array(S4_CLERC_DLN),
		"limite"		=>	3,
		"prod_unt"	=>	true,
);
		
//Guilde des Forgerons
$this->btc[B4_G_FORGERONS]=array(
		"vie"			=>	500,
		"prix_res"		=>	array(R4_PIERRE => 200,R4_BOIS => 200,R4_OR => 150),
		"tours"		=>	300,
		"prix_unt"		=>	array(U4_FORGERON => 2, U4_SERVITEUR => 1),
		"need_src"	=>	array(S4_PRETRESSE_DLN),
		"limite"		=>	3,
		"prod_unt"	=>	true,
);

//Autel des Matrones
$this->btc[B4_AUTEL_MATRONNES]=array(
		"vie"			=>	900,
		"prix_res"		=>	array(R4_PIERRE => 500,R4_BOIS => 100,R4_OR => 300,R4_MITHRIL => 25),
		"tours"		=>	500,
		"need_btc"	=>	array(B4_TEMPLE),
		"limite"		=>	1,
		"prod_unt"	=>	true,
);

//Cité noire
$this->btc[B4_CITADELLE]=array(
		"bonus" 	=> array('gen' => 350, 'bon' => 15),
		"vie"		 	=>	4600,
		"prod_pop" 	=> 	100,
		"prix_res"		=>	array(R4_PIERRE => 4500,R4_BOIS => 1500,R4_ACIER => 400),
		"tours"		=>	2000,
		"need_btc"	=>	array(B4_AUTEL_MATRONNES),
		"prix_unt" 		=>	array(U4_CAPUCHE_NOIRE => 10),
		"limite"		=>	1,
		"prod_unt"	=>	4,
		"prod_src"	=>	true,
);
//</btc>

//<unt>
$this->unt[U4_SERVITEUR]=array(
		"prix_res"		=>	array(R4_OR => 2),
		"vie"			=>	1,
		"need_btc"	=>	array(B4_NID),
		"in_btc"		=>	array(B4_NID, B4_CITADELLE),
		"group"		=>	1,
		"role"		=>	TYPE_UNT_CIVIL,
);

$this->unt[U4_CHASSEUR]=array(
		"prix_res"		=>	array(R4_OR => 2),
		"vie"		=>	1,
		"need_btc"	=>	array(B4_NID),
		"in_btc"		=>	array(B4_NID, B4_CITADELLE),
		"group"		=>	2,
		"role"		=>	TYPE_UNT_CIVIL,
);	

$this->unt[U4_DRESSEUR]=array(
		"prix_res"		=>	array(R4_OR => 2),
		"vie"		=>	1,
		"need_btc"	=>	array(B4_NID),
		"in_btc"		=>	array(B4_NID, B4_CITADELLE),
		"group"		=>	2,
		"role"		=>	TYPE_UNT_CIVIL,
);	

$this->unt[U4_FORGERON]=array(
		"prix_res"		=>	array(R4_OR => 2),
		"vie"		=>	1,
		"need_btc"	=>	array(B4_NID),
		"in_btc"		=>	array(B4_NID, B4_CITADELLE),
		"group"		=>	2,
		"role"		=>	TYPE_UNT_CIVIL,
);		

$this->unt[U4_MINEUR]=array(
		"prix_res"		=>	array(R4_OR => 2),
		"vie"		=>	1,
		"need_btc"	=>	array(B4_NID),
		"in_btc"		=>	array(B4_NID, B4_CITADELLE),
		"group"		=>	5,
		"role"		=>	TYPE_UNT_CIVIL,
);				

$this->unt[U4_BUCHERON]=array(
		"prix_res"		=>	array(R4_OR => 2),
		"vie"		=>	1,
		"need_btc"	=>	array(B4_NID),
		"in_btc"		=>	array(B4_NID, B4_CITADELLE),
		"group"		=>	5,
		"role"		=>	TYPE_UNT_CIVIL,
);		

$this->unt[U4_CONVOQUE]=array(
		"prix_res"		=>	array(R4_OR => 3),
		"vie"		=>	1,
		"need_btc"	=>	array(B4_NID),
		"in_btc"		=>	array(B4_NID, B4_CITADELLE),
		"group"		=>	6,
		"role"		=>	TYPE_UNT_CIVIL,
);			

$this->unt[U4_COMBATTANT]=array(
		"def"	=>	1,
		"vie"		=>	13,
		"atq_unt"	=>	3,
		"vit"		=>	10,
		"prix_res"		=>	array(),
		"need_btc"	=>	array(B4_SERRE_DE_COMBAT),
		"in_btc"		=>	array(B4_SERRE_DE_COMBAT),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	8,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 1,
);

$this->unt[U4_ASSASSIN]=array(
		"def"	=>	6,
		"vie"		=>	16,
		"atq_unt"	=>	11,
		"vit"		=>	9,
		"prix_res"		=>	array(R4_HACHE => 1),
		"need_btc"	=>	array(B4_MAISON_LAMES),
		"in_btc"		=>	array(B4_MAISON_LAMES),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	9,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 2,
);
		
$this->unt[U4_OMBRE]=array(
		"def"	=>	10,
		"vie"		=>	18,
		"atq_unt"	=>	17,
		"vit"		=>	7,
		"prix_res"		=>	array(R4_HACHE => 1,R4_BOUCLIER => 1, R4_ACIER =>1),
		"need_btc"	=>	array(B4_MAISON_LAMES),
		"in_btc"		=>	array(B4_MAISON_LAMES),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	9,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 3,
);
		
$this->unt[U4_BRIGAND]=array(
		"def"	=>	7,
		"vie"		=>	15,
		"atq_unt"	=>	10,
		"vit"		=>	9,
		"prix_res"		=>	array(R4_ARC => 1),
		"need_btc"	=>	array(B4_MAISON_LAMES),
		"in_btc"		=>	array(B4_MAISON_LAMES),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	11,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 11,
);

$this->unt[U4_CAPUCHE_NOIRE]=array(
		"def"	=>	17,
		"vie"		=>	18,
		"atq_unt"	=>	16,
		"vit"		=>	7,
		"prix_res"		=>	array(R4_ARC => 1,R4_BOUCLIER => 1,R4_ACIER => 1),
		"need_btc"	=>	array(B4_MAISON_LAMES),
		"in_btc"		=>	array(B4_MAISON_LAMES),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	11,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 12,
);

$this->unt[U4_HALLEBARDIER_NOIR]=array(
		"def"	=>	16,
		"vie"		=>	20,
		"atq_unt"	=>	29,
		"vit"		=>	12,
		"need_src" =>	array(S4_ARMEE_3),


		"prix_res"		=>	array(R4_WORGS => 1, R4_BOUCLIER => 1,R4_HALLEBARDE => 1),
		"need_btc"	=>	array(B4_G_LAMES),
		"in_btc"		=>	array(B4_G_LAMES),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	13,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 8,
);

$this->unt[U4_ARBLALETRIER_NOIR]=array(
		"def"	=>	18,
		"vie"		=>	13,
		"atq_unt"	=>	13,
		"vit"		=>	8,
		"bonus" => array('vie' => 1),
		"need_src" =>	array(S4_ARMEE_3),
		"prix_res"		=>	array(R4_WORGS => 1,R4_ARBALETE => 1,R4_C_NOIR => 1,R4_OR =>6),
		"need_btc"	=>	array(B4_G_LAMES),
		"in_btc"		=>	array(B4_G_LAMES),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	13,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 13,
);

$this->unt[U4_GEANT_ROCHE]=array(
		"def"	=>	20,
		"vie"		=>	28,
		"atq_unt"	=>	20,

		"vit"		=>	7,
		"need_src" =>	array(S4_ARMEE_3),
		"prix_res"		=>	array(R4_NOURITURE => 200, R4_MASSUE => 1, R4_ACIER => 2, R4_C_MITHRIL => 1),
		"need_btc"	=>	array(B4_G_LAMES),
		"in_btc"		=>	array(B4_G_LAMES),
		"prix_unt"		=>	array(U4_DRESSEUR => 1),
		"group"		=>	13,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 4,
);

$this->unt[U4_AILES_NOCTURNES]=array(
		"def"	=>	3,
		"vie"		=>	12,
		"atq_unt"	=>	7,
		"vit"		=>	20,
		"prix_res"		=>	array(R4_NOURITURE => 50),
		"need_btc"	=>	array(B4_AIRE_DRESSAGE),
		"in_btc"		=>	array(B4_AIRE_DRESSAGE),
		"prix_unt"		=>	array(U4_DRESSEUR => 1),
		"group"		=>	16,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 9,
);

$this->unt[U4_A_TISSEUSE]=array(
		"def"	=>	25,
		"vie"		=>	20,
		"atq_unt"	=>	18,
		"vit"		=>	8,
		"prix_res"		=>	array(R4_NOURITURE => 200, R4_ACIER => 4),
		"need_btc"	=>	array(B4_AIRE_DRESSAGE),
		"in_btc"		=>	array(B4_AIRE_DRESSAGE),
		"prix_unt"		=>	array(U4_DRESSEUR => 1),
		"group"		=>	16,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 6,
);

$this->unt[U4_W_GUERRIER]=array(
		"def"	=>	12,
		"vie"		=>	16,
		"atq_unt"	=>	18,
		"atq_btc"	=>	3,
		"vit"		=>	12,
		"prix_res"		=>	array(R4_NOURITURE => 300, R4_ACIER => 2),
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"in_btc"		=>	array(B4_G_DRESSEURS),
		"prix_unt"		=>	array(U4_DRESSEUR => 1),
		"group"		=>	18,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 7,
);
		
$this->unt[U4_A_GUERRIERE]=array(
		"def"	=>	5,
		"vie"		=>	16,
		"atq_unt"	=>	16,
		"atq_btc"	=>	7,
		"vit"		=>	8,
		"prix_res"		=>	array(R4_NOURITURE => 300,R4_ACIER => 3,R4_OR => 3),
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"in_btc"		=>	array(B4_G_DRESSEURS),
		"prix_unt"		=>	array(U4_DRESSEUR => 1),
		"group"		=>	18,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 5,
);

$this->unt[U4_BASILIC]=array(
		"def"	=>	14,
		"vie"		=>	18,
		"atq_unt"	=>	5,
		"atq_btc"	=>	13,
		"vit"		=>	6,
		"need_src" =>	array(S4_DRESSAGE_3),
		"prix_res"		=>	array(R4_NOURITURE => 200,R4_PIERRE => 10,R4_ACIER => 5,R4_MITHRIL => 3),
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"in_btc"		=>	array(B4_G_DRESSEURS),
		"prix_unt"		=>	array(U4_DRESSEUR => 1),
		"group"		=>	18,
		"role"		=>	TYPE_UNT_MACHINE,
		"rang" => 18,
);

$this->unt[U4_PRETRESSE_DLN]=array(
		"def"	=>	15,
		"bonus"		=>	array('def' => 1),
		"vie"		=>	12,
		"atq_unt"	=>	11,
		"vit"		=>	7,
		"need_src" =>	array(S4_PRETRESSE_DLN),
		"prix_res"		=>	array(R4_C_NOIR => 1,R4_MITHRIL => 1,R4_OR => 10),
		"need_btc"	=>	array(B4_TEMPLE),
		"in_btc"		=>	array(B4_TEMPLE),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	21,
		"role"		=>	TYPE_UNT_MAGIQUE,
		"rang" => 17,
);

$this->unt[U4_CLERC_DLN]=array(
		"def"	=>	11,
		"bonus"		=>	array('atq' => 1),
		"vie"		=>	12,
		"atq_unt"	=>	15,
		"vit"		=>	8,
		"need_src" =>	array(S4_CLERC_DLN),
		"prix_res"		=>	array(R4_C_NOIR => 1,R4_MITHRIL => 1,R4_OR => 10),
		"need_btc"	=>	array(B4_TEMPLE),
		"in_btc"		=>	array(B4_TEMPLE),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	21,
		"role"		=>	TYPE_UNT_MAGIQUE,
		"rang" => 16,
);	

$this->unt[U4_MAITRE_LAME]=array(
		"def"	=>	20,
		"vie"		=>	22,
		"atq_unt"	=>	22,
		"vit"		=>	15,
		"prix_res"		=>	array(R4_C_MITHRIL => 1,R4_HACHE => 1,R4_BOUCLIER => 1,R4_WORGS => 1),
		"need_btc"	=>	array(B4_G_FORGERONS),
		"in_btc"		=>	array(B4_G_FORGERONS),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	23,
		"role"		=>	TYPE_UNT_CAVALERIE,
		"rang" => 10,
);

$this->unt[U4_GUARDIENNE]=array(
	  	"def"	=>	13,
		"vie"		=>	12,
		"atq_unt"	=>	18,
		"vit"		=>	9,
		"bonus" => array('vie' => 1),
		"prix_res"		=>	array(R4_C_MITHRIL => 1,R4_ARBALETE => 1,R4_BOUCLIER => 1),
		"need_btc"	=>	array(B4_AUTEL),
		"in_btc"		=>	array(B4_AUTEL),
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"group"		=>	23,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 14,
);

$this->unt[U4_ENVOYE_LOLTH]=array(  
		"def"	=>	45,
		"vie"		=>	130,
		"atq_unt"	=>	175,
		"vit"		=>	12,
		"need_src" =>	array(S4_DON_DE_LOLTH),
		"prix_res"		=>	array(R4_C_MITHRIL => 1,R4_MITHRIL => 1,R4_MASSUE => 4,R4_OR =>5,R4_NOURITURE => 100),
		"need_btc"	=>	array(B4_AUTEL_MATRONNES),
		"in_btc"		=>	array(B4_AUTEL_MATRONNES),
		"group"		=>	25,
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"role"		=>	TYPE_UNT_HEROS,
		"rang" => 19,
);
		
$this->unt[U4_ENVOYE_EILISTRAEE]=array(  
		"def"		=>	160,
		"vie"			=>	120,
		"atq_unt"		=>	50,
		"vit"			=>	12,
		"need_src" =>	array(S4_DON_DEILISTRAEE),
		"prix_res"		=>	array(R4_C_MITHRIL => 1,R4_MITHRIL => 1,R4_BOUCLIER => 4,R4_OR =>5,R4_NOURITURE => 100),
		"need_btc"	=>	array(B4_AUTEL_MATRONNES),
		"in_btc"		=>	array(B4_AUTEL_MATRONNES),
		"group"		=>	25,
		"prix_unt"		=>	array(U4_CONVOQUE => 1),
		"role"		=>	TYPE_UNT_HEROS,
		"rang" => 20,
);

$this->unt[U4_DENVER]=array(
		"def"		=>	90,
		"vie"			=>	135,
		"atq_unt"		=>	100,
		"atq_btc"		=>	30,
		"vit"			=>	10,
		"need_src" =>	array(S4_DENVER),
		"prix_res"		=>	array(R4_C_NOIR => 1,R4_HALLEBARDE => 2,R4_BOUCLIER => 3, R4_NOURITURE => 400),
		"need_btc"	=>	array(B4_AUTEL_MATRONNES),
		"in_btc"		=>	array(B4_AUTEL_MATRONNES),
		"group"		=>	25,
		"prix_unt"		=>	array(U4_DRESSEUR => 1, U4_CONVOQUE => 1),
		"role"		=>	TYPE_UNT_HEROS,
		"rang" => 21,
);

$this->unt[U4_OLIPHANT] = array(
	'vie' => 9,
	'group' => 21,
	'role' => TYPE_UNT_DEMENAGEMENT,
	//'prix_res' => array(R4_NOURITURE => 30000, R4_OR => 5000, R4_ACIER => 900, R4_MITHRIL => 400, ),
	'prix_res' => array(R4_NOURITURE => 15000, R4_OR => 2500, R4_ACIER => 450, R4_MITHRIL => 200, ),
	'need_btc' => array(B4_G_DRESSEURS, ),
	'in_btc' => array(B4_G_DRESSEURS, ),
	'need_src' => array(S4_APPEL_MONSTREUX, ),
	'vit' => 6,
	'prix_unt' => array(U4_DRESSEUR => 1, ),
	'rang' => 11,
);
//</unt>

//<src>
$this->src[S4_ARME_1]=array(
		"tours"		=>	4,
		"need_src"	=>	array(S4_FONTE_ACIER),
		"prix_res"		=>	array(R4_FER => 20,R4_CHARBON => 20,R4_ACIER => 10,R4_BOIS => 25,R4_PIERRE => 25),
		"group"		=>	1,
);

//Armes niv2,
$this->src[S4_ARME_2]=array(
		"tours"		=>	8,
		"need_src"	=>	 array(S4_ARME_1, S4_DEFENSE_1),
		"prix_res"		=>	array(R4_FER => 30, R4_CHARBON => 30 ,R4_ACIER => 25 ,R4_BOIS => 50 ,R4_PIERRE => 50, R4_MITHRIL => 10, R4_OR => 20),
		"group"		=>	1,
);

//Défense niv1,
$this->src[S4_DEFENSE_1]=array(
		"tours"		=>	4,
		"need_src"	=>	array(S4_FONTE_ACIER),
		"prix_res"		=>	array(R4_FER => 30, R4_CHARBON => 30, R4_ACIER => 20),
		"group"		=>	3,
);

//Défense niv2,
$this->src[S4_DEFENSE_2]=array(
		"tours"		=>	8,
		"need_src"	=>	array(S4_DEFENSE_1, S4_ARMEE_1),
		"prix_res"		=>	array(R4_FER => 40, R4_CHARBON => 40, R4_ACIER => 30, R4_MITHRIL => 10, R4_OR => 40),
		"group"		=>	3,
);

//Fortifications,
$this->src[S4_FORTIFICATION]=array(
		"tours"		=>	10,
		"need_btc" 	=>  array(B4_FORGE),
		"need_src"	=>	array(S4_DEFENSE_2),
		"prix_res"		=>	array(R4_BOIS => 150, R4_PIERRE => 250, R4_ACIER => 100, R4_MITHRIL => 10),
		"group"		=>	3,
);

//Fonte de l'acier,
$this->src[S4_FONTE_ACIER]=array(
		"tours"		=>	20,
		"need_btc"	=>	array(B4_G_FER, B4_G_CHARBON),
		"prix_res"		=>	array(R4_OR => 80, R4_FER => 150,R4_CHARBON => 150),
		"group"		=>	6,
);

//Dressage niv1,
$this->src[S4_DRESSAGE_1]=array(
		"tours"		=>	8,
		"need_btc"	=>	array(B4_MAISON_LAMES),
		"prix_res"		=>	array(R4_OR => 50, R4_NOURITURE => 500, R4_BOIS => 40, R4_PIERRE => 60),
		"group"		=>	7,
);

//Dressage niv2,
$this->src[S4_DRESSAGE_2]=array(
		"tours"		=>	16,
		"need_btc"	=>	array(B4_AIRE_DRESSAGE),
		"prix_res"		=>	array(R4_OR => 80, R4_NOURITURE => 1000, R4_BOIS => 80, R4_PIERRE => 100, R4_ACIER => 10, R4_MITHRIL => 10),
		"group"		=>	7,
);

//Dressage niv3,
$this->src[S4_DRESSAGE_3]=array(
		"tours"		=>	24,
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"prix_res"		=>	array(R4_OR => 150, R4_NOURITURE => 1500, R4_BOIS => 120, R4_PIERRE => 150, R4_ACIER => 50, R4_MITHRIL => 20),
		"group"		=>	7,
);

//Attelage,
$this->src[S4_ATTELAGE]=array(
		"tours"		=>	20,
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"prix_res"		=>	array(R4_NOURITURE => 800,R4_ACIER => 40, R4_BOIS => 50, R4_PIERRE => 50, R4_WORGS => 10),
		"group"		=>	10,
);

//Commerce niv1,
$this->src[S4_COMMERCE_1]=array(
		"tours"		=>	8,
		"need_btc"	=>	array(B4_HABITATION, B4_AIRE_CHASSE),
		"prix_res"		=>	array(R4_OR => 60),
		"group"		=>	11,
);

//Commerce niv2,
$this->src[S4_COMMERCE_2]=array(
		"tours"		=>	20,
		"need_src"	=>	array(S4_COMMERCE_1),
		"prix_res"		=>	array(R4_OR => 200, R4_NOURITURE => 1000, R4_MITHRIL => 20),
		"group"		=>	11,
);

//Commerce niv3,
$this->src[S4_COMMERCE_3]=array(
		"tours"		=>	40,
		"need_src"	=>	array(S4_COMMERCE_2, S4_ATTELAGE),
		"prix_res"		=>	array(R4_OR => 500, R4_NOURITURE => 3500, R4_BOIS => 250, R4_PIERRE => 300, R4_MITHRIL => 50),
		"group"		=>	11,
);

//Armée niv1,
$this->src[S4_ARMEE_1]=array(
		"tours"		=>	8,
		"need_btc"	=>	array(B4_HABITATION, B4_AIRE_CHASSE),
		"prix_res"		=>	array(R4_OR => 25, R4_NOURITURE => 100, R4_BOIS => 25),
		"group"		=>	14,
);

//Armée niv2,
$this->src[S4_ARMEE_2]=array(
		"tours"		=>	20,
		"need_src"	=>	array(S4_DEFENSE_1, S4_ARME_1),
		"prix_res"		=>	array(R4_OR => 75, R4_NOURITURE => 200, R4_FER => 75, R4_CHARBON => 75),
		"group"		=>	14,
);

//Armée niv3,
$this->src[S4_ARMEE_3]=array(
		"tours"		=>	40,
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"need_src"	=>	array(S4_DEFENSE_2, S4_ARME_2),
		"prix_res"		=>	array(R4_OR => 200, R4_ACIER => 125, R4_BOIS => 100, R4_PIERRE => 140, R4_MITHRIL => 10),
		"group"		=>	14,
);

//Galeries niv1,
$this->src[S4_GALERIES_1]=array(
		"tours"		=>	8,
		"need_btc"	=>	array(B4_HABITATION, B4_AIRE_CHASSE),
		"prix_res"		=>	array(R4_BOIS => 20,R4_PIERRE => 30),
		"group"		=>	17,
);

//Galeries niv2,
$this->src[S4_GALERIES_2]=array(
		"tours"		=>	12,
		"need_btc"	=>	array(B4_SERRE_DE_COMBAT, B4_GALERIE_DOR),
		"prix_res"		=>	array(R4_BOIS => 60, R4_PIERRE => 100, R4_OR => 30),
		"group"		=>	17,
);

//Don de la Nuit,
$this->src[S4_DON_DLN]=array(
		"tours"		=>	80,
		"need_btc"	=>	array(B4_G_LAMES),
		"prix_res"		=>	array(R4_OR => 120,R4_ACIER => 75,R4_MITHRIL => 25,R4_PIERRE => 150),
		"group"		=>	19,
);

//OLIPHANT
$this->src[S4_APPEL_MONSTREUX]=array(
		"tours"		=>	30,
		"need_btc"	=>	array(B4_G_DRESSEURS),
		"prix_res"		=>	array(R4_OR => 1000,R4_MITHRIL => 450,R4_NOURITURE => 3000,R4_ACIER => 500),
		"group"		=>	19,
);

//Prêtresse de la Nuit,
$this->src[S4_PRETRESSE_DLN]=array(
		"tours"		=>	40,
		"need_btc"	=>	array(B4_TEMPLE),
		"need_src"	=>	array(S4_ARMEE_3),
		"prix_res"		=>	array(R4_NOURITURE => 500,R4_ACIER => 60,R4_MITHRIL => 15,R4_OR => 200),
		"group"		=>	20,
);

//Clerc de la Nuit,
$this->src[S4_CLERC_DLN]=array(
		"tours"		=>	40,
		"need_btc"	=>	array(B4_TEMPLE),
		"need_src"	=>	array(S4_ARMEE_3),
		"prix_res"		=>	array(R4_NOURITURE => 500,R4_ACIER => 60,R4_MITHRIL => 15,R4_OR => 200),
		"group"		=>	20,
);

//Don de Lolth,
$this->src[S4_DON_DE_LOLTH]=array(
		"tours"		=>	50,
		"need_btc"	=>	array(B4_AUTEL_MATRONNES),
		"prix_res"		=>	array(R4_OR => 300,R4_MITHRIL => 30,R4_NOURITURE => 3000,R4_ACIER => 160),
		"group"		=>	22,
);

//Don d'Eilistraée,
$this->src[S4_DON_DEILISTRAEE]=array(
		"tours"		=>	50,
		"need_btc"	=>	array(B4_AUTEL_MATRONNES),
		"prix_res"		=>	array(R4_OR => 300,R4_MITHRIL => 30,R4_NOURITURE => 3000,R4_ACIER => 160),
		"group"		=>	22,
);

//griffes prédatrices
$this->src[S4_DENVER]=array(
		"tours"		=>	50,
		"need_btc"	=>	array(B4_AUTEL_MATRONNES),
		"prix_res"		=>	array(R4_OR => 300,R4_MITHRIL => 30,R4_NOURITURE => 3000,R4_ACIER => 160),
		"group"		=>	22,
);


//</src>

/* compétences du ou des héros ... */

//<comp>
/* ### Off ### */
$this->comp[CP_BOOST_OFF]=array(
	'heros'		=> array(U4_ENVOYE_LOLTH),
	'tours'		=> 3,
	'bonus'		=> 10,
	'prix_xp'	=> 40,
	'type'		=> 1
);

$this->comp[CP_RESURECTION]=array(
	'heros'		=> array(U4_ENVOYE_LOLTH),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_VOLEE_DE_FLECHES]=array(
	'heros'		=> array(U4_ENVOYE_LOLTH),
	'tours'		=> 24,
	'bonus'		=> 5,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_SURVIVANT]=array(
	'heros'		=> array(U4_ENVOYE_LOLTH),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

/* ### Def ### */

$this->comp[CP_BOOST_DEF]=array(
	'heros'		=> array(U4_ENVOYE_EILISTRAEE),
	'tours'		=> 8,
	'bonus'		=> 8,
	'prix_xp'	=> 40,
	'type'		=> 2
);

$this->comp[CP_RESISTANCE]=array(
	'heros'		=> array(U4_ENVOYE_EILISTRAEE),
	'tours'		=> 6,
	'bonus'		=> 15,
	'prix_xp'	=> 60,
	'type'		=> 2
);

$this->comp[CP_REGENERATION]=array(
	'heros'		=> array(U4_ENVOYE_EILISTRAEE),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 2
);

$this->comp[CP_MURAILLES_LEGENDAIRES]=array(
	'heros'		=> array(U4_ENVOYE_EILISTRAEE),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 2
);

/* ### Sou ### */

$this->comp[CP_CASS_BAT]=array(
	'heros'		=> array(U4_DENVER),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GENIE_COMMERCIAL]=array(
	'heros'		=> array(U4_DENVER),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GUERISON]=array(
	'heros'		=> array(U4_DENVER),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_BOOST_OFF_DEF]=array(
	'heros'		=> array(U4_DENVER),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);
//</comp>

/* configuration générale */
$this->race_cfg = array(
	'res_nb'	=>	count($this->res),
	'trn_nb'	=>	count($this->trn),
	'btc_nb'	=>	count($this->btc),
	'unt_nb'	=>	count($this->unt),
	'src_nb'	=>	count($this->src),
	'primary_res' => array(R4_OR,R4_NOURITURE),
	'second_res'	=>	array(R4_OR, R4_BOIS, R4_PIERRE, R4_NOURITURE, R4_FER , R4_CHARBON, R4_ACIER, R4_MITHRIL),
 	'primary_btc' => array(
 		'vil' => array(
 			B4_NID => array('unt','src'),
 			B4_SERRE_DE_COMBAT => array('unt'),
 			B4_MAISON_LAMES => array('unt'),
 			B4_G_LAMES => array('unt'),
 			B4_AIRE_DRESSAGE => array('unt'),
 			B4_G_DRESSEURS => array('unt'),
 			B4_FORGE => array('res'),
 			B4_G_FORGERONS => array('unt'),
 			B4_TEMPLE => array('unt'),
 			B4_AUTEL => array('unt'),
 			B4_AUTEL_MATRONNES => array('unt')),
 		'ext' => array(B4_MARCHE => array('ach'))),
 	'bonus_res'   => array(R4_OR => 0.05),
 	'modif_pts_btc' => 1,
	'debut'	=>	array(
		'res'	=>	array(R4_OR => 70, R4_PIERRE => 40, R4_BOIS => 40, R4_NOURITURE => 1500),
		'trn'	=>	array(T4_FORET => 2, T4_MONTAGNE => 2, T4_GIS_FER => 2, T4_FILON_OR => 3, T4_GIS_CHARBON => 2),
		'unt'	=> 	array(U4_SERVITEUR => 1, U4_COMBATTANT => 5),
		'btc'	=> 	array(B4_NID => array()),
		'src'	=>	array()),
	'bonus_map' => array(MAP_EAU => -7, MAP_LAC => -7, MAP_HERBE => -2, MAP_MONTAGNE => 10, MAP_FORET => 10),
	'bonus_period' => array(PERIODS_JOUR => -10, PERIODS_NUIT => 10, PERIODS_AUBE => -5, PERIODS_CREP => 5),
	);
}
}
?>
