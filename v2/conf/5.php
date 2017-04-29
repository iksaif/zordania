<?php

define("R5_OR", 1);
define("R5_BOIS", 2);
define("R5_PIERRE", 3);
define("R5_BAIES", 4);
define("R5_BOIS_IF", 5);
define("R5_CUIR", 6);
define("R5_CHEVAUX", 7);
define("R5_ACIER", 8);
define("R5_MITHRIL", 9);
define("R5_RONDACHE", 10);
define("R5_PAVOIS", 11);
define("R5_LAME", 12);
define("R5_PIQUE", 13);
define("R5_ARC_COURT", 14);
define("R5_ARC_COMPOSITE", 15);
define("R5_A_CUIR", 16);
define("R5_A_MITHRIL", 17);

define("T5_FORET", 1);
define("T5_FORET_IF", 2);
define("T5_ZONE_CHASSE", 3);
define("T5_MONTAGNE", 4);
define("T5_VILLAGE", 5);

define("B5_COLONIE", 1);
define("B5_MAISON_FORESTIER", 2);
define("B5_MAISON", 3);
define("B5_MAISON_CUEILLETTE", 4);
define("B5_TROUPE", 5);
define("B5_TANNEUR", 6);
define("B5_DEMEURE_FORESTIER", 7);
define("B5_AIRE_ENTRAINEMENT", 8);
define("B5_MARCHE", 9);
define("B5_COMPTOIRE_FONTE", 10);
define("B5_ARCHERIE", 11);
define("B5_FORGE", 12);
define("B5_TOUR", 13);
define("B5_CASERNE", 14);
define("B5_ECURIES", 15);
define("B5_THEATRE", 16);
define("B5_BIBLIOTHEQUE", 17);
define("B5_DEMEURE", 18);
define("B5_BOSQUET", 19);
define("B5_ANTRE", 20);
define("B5_ECOLE_MAGIE", 21);
define("B5_FORT", 22);
define("B5_TEMPLE", 23);
define("B5_CITE", 24);

define("U5_SERVITEUR", 1);
define("U5_CUEILLEUR", 2);
define("U5_FORESTIER", 3);
define("U5_FORGERON", 4);
define("U5_ACOLYTE", 5);
define("U5_BARDE", 6);
define("U5_NOBLE", 7);
define("U5_ECLAIREUR", 8);
define("U5_PATROUILLEUR", 9);
define("U5_RODEUR", 10);
define("U5_LANCIER", 11);
define("U5_ARCHER", 12);
define("U5_EPEISTE", 13);
define("U5_PIQUIER", 14);
define("U5_GARDE", 15);
define("U5_DRUIDE", 16);
define("U5_NYMPHE", 17);
define("U5_VENERABLE", 18);
define("U5_COMMANDANT", 19);
define("U5_GARDE_ELITE", 20);
define("U5_MAGE", 21);
define("U5_GARDIEN", 22);
define("U5_AVATAR_CORELLON", 23);
define("U5_AVATAR_AERDRIE", 24);
define("U5_AIGLE", 25);
define("U5_DRAGON", 26);
define("U5_TRANSPOR_INCANT", 27);

define("S5_ARTS_MUSICAUX", 1);
define("S5_ARME_1", 2);
define("S5_ARME_2", 3);
define("S5_DEFENSE_1", 4);
define("S5_DEFENSE_2", 5);
define("S5_FORTIFICATION", 6);
define("S5_ARMEE_1", 7);
define("S5_ARMEE_2", 8);
define("S5_COMMERCE_1", 9);
define("S5_COMMERCE_2", 10);
define("S5_COMMERCE_3", 11);
define("S5_FONTE_ACIER", 12);
define("S5_ATTELAGE", 13);
define("S5_ARTS_DRAMATIQUES", 14);
define("S5_CONNAISSANCES_1", 15);
define("S5_CONNAISSANCES_2", 16);
define("S5_DRUIDISME_1", 17);
define("S5_DRUIDISME_2", 18);
define("S5_MAITRISE_DEFENSIVE", 19);
define("S5_MAITRISE_OFFENSIVE", 20);
define("S5_FIDELITE_AERDRIE", 21);
define("S5_FIDELITE_CORELLON", 22);
define("S5_SANG", 23);
define("S5_INCANT_TRANSPOR", 24);

class config5
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

//<res>
$this->res=array();

$this->res[R5_OR]=array(
		"cron"	=> true,
		"need_btc"	=>	B5_TROUPE,
		);

$this->res[R5_BOIS]=array(
    		"cron"	=> true,
		"need_btc"	=>	B5_MAISON_FORESTIER,
		);

$this->res[R5_PIERRE]=array("dummy" => true);

$this->res[R5_BAIES]=array(
		"cron"	=> true,
		"need_btc"	=>	B5_MAISON_CUEILLETTE,
		);

$this->res[R5_BOIS_IF]=array(
		"cron"	=> true,
		"need_btc"	=>	B5_DEMEURE_FORESTIER,
		);

$this->res[R5_CUIR]=array(
		"cron"	=> true,
		"need_btc"	=>	B5_TANNEUR,
		);

$this->res[R5_CHEVAUX]= array(
		"prix_res"	=>	array(R5_BAIES => 150,R5_ACIER => 3),
		"need_src"	=>	array(S5_ATTELAGE),
		"need_btc"	=>	B5_ECURIES,
		"group"         =>      1,
		);

$this->res[R5_ACIER]=array(
		"cron"	=> true,
		"need_src"	=>	array(S5_FONTE_ACIER),
		"need_btc"	=>	B5_COMPTOIRE_FONTE,
		);

$this->res[R5_MITHRIL]=array("dummy" => true);

$this->res[R5_RONDACHE]=array(
		"prix_res" 	=>	array(R5_BOIS => 2,R5_BOIS_IF => 1,R5_CUIR => 1),
		"need_src"	=>	array(S5_DEFENSE_1),
		"need_btc"	=>	B5_FORGE,
		"group"		=>	10,
		);
		
//pavois
$this->res[R5_PAVOIS]=array(
		"prix_res"	=>	array(R5_BOIS => 4,R5_ACIER => 1),
		"need_src"	=>	array(S5_DEFENSE_2),
		"need_btc"	=>	B5_FORGE,
		"group"		=>	10,
		);
	
//lame
$this->res[R5_LAME]=array(
		"prix_res"	=>	array(R5_BOIS_IF => 1,R5_CUIR => 1,R5_ACIER => 1),
		"need_src"	=>	array(S5_ARME_1),
		"need_btc"	=>	B5_FORGE,
		"group"		=>	12,
		);
	
//pique
$this->res[R5_PIQUE]=array(
		"prix_res"	=>	array(R5_BOIS_IF => 1,R5_CUIR => 1,R5_ACIER => 2),
		"need_src"	=>	array(S5_ARME_2),
		"need_btc"	=>	B5_FORGE,
		"group"		=>	12,
		);

//arc court
$this->res[R5_ARC_COURT]=array(
		"prix_res"	=>	array(R5_BOIS_IF => 2,R5_CUIR => 1,R5_ACIER => 1),
		"need_src"	=>	array(S5_ARME_1),
		"need_btc"	=>	B5_ARCHERIE,
		"group"		=>	14,
		);
		
//arc composite
$this->res[R5_ARC_COMPOSITE]=array(
		"prix_res"	=>	array(R5_BOIS => 1,R5_BOIS_IF => 2,R5_CUIR => 2,R5_ACIER => 1),
		"need_src"	=>	array(S5_ARME_2),
		"need_btc"	=>	B5_ARCHERIE,
		"group"		=>	14,
		);
	
//armure de cuir cloutée
$this->res[R5_A_CUIR]=array(
		"prix_res"	=>	array(R5_CUIR => 4,R5_ACIER => 2),
		"need_src"	=>	array(S5_DEFENSE_1),
		"need_btc"	=>	B5_FORGE,
		"group"		=>	16,
		);
		
//harnois de mithril
$this->res[R5_A_MITHRIL]=array(
		"prix_res"	=>	array(R5_CUIR => 3,R5_BOIS_IF => 3,R5_ACIER => 1,R5_MITHRIL => 1),
		"need_src"	=>	array(S5_DEFENSE_2),
		"need_btc"	=>	B5_FORGE,
		"group"	=>	16,
		);
//</res>

//<trn>
$this->trn[T5_FORET] = array();
$this->trn[T5_FORET_IF] = array();
$this->trn[T5_ZONE_CHASSE] = array();
$this->trn[T5_MONTAGNE] = array();
$this->trn[T5_VILLAGE] = array();
//</trn>

//<btc>
//Colonie,
$this->btc[B5_COLONIE]=array(
		"bonus" 	=> array('gen' => 300, 'bon' => 4),
		"vie"			=>	1000,
		"prod_pop"	=>	25,
		"limite"		=>	1,
		"tours"		=>	500,
		"prix_res"		=>	array(R5_BOIS => 2500,R5_BOIS_IF => 500,R5_PIERRE => 1000,R5_CUIR => 250,R5_ACIER => 200,R5_MITHRIL => 50),
		"prod_src"	=>	true,
		"prod_unt"	=>	4,
		);

//Maison de Forestier,
$this->btc[B5_MAISON_FORESTIER]=array(
		"vie"			=>	250,
		"prix_res"		=>	array(R5_BOIS => 10),
		"prix_trn"		=>	array(T5_FORET => 1),
		"tours"		=>	5,
		"need_btc"	=>	array(B5_COLONIE),
		"prod_res_auto"=>	array(R5_BOIS => 3),
		"prix_unt"		=>	array(U5_FORESTIER => 1),
		);

//Maison,		
$this->btc[B5_MAISON]=array(
		"vie"		=>	200,
		"prod_pop" 	=> 	5,
		"prix_res"		=>	array(R5_BOIS => 25),
		"tours"		=>	10,
		"need_btc"	=>	array(B5_MAISON_FORESTIER),
		"limite"	=>	45,
		);

//Maison de cueillette,
$this->btc[B5_MAISON_CUEILLETTE]=array(
		"vie"		=>	250,
		"prix_res"	=>	array(R5_BOIS => 30),
		"tours"	=>	10,
		"need_btc"	=>	array(B5_MAISON_FORESTIER),
		"prix_unt"	=>	array(U5_CUEILLEUR => 1),
		"prod_res_auto"	=>	array(R5_BAIES => 10),
		"limite"	=>	70,
);

$this->btc[B5_TROUPE]=array(
		"vie"			=>	350,
		"tours"		=>	100,
		"need_src"	=>	array(S5_ARTS_MUSICAUX),
		"prod_res_auto"	=>	array(R5_OR => 1),
		"prix_res"		=>	array(R5_BOIS => 40),
		"prix_trn"		=>	array(T5_VILLAGE => 1),
		"prix_unt"		=>	array(U5_BARDE => 1),
);

//Tanneur,
$this->btc[B5_TANNEUR]=array(
		"vie"			=>	400,
		"tours"		=>	100,
		"prod_res_auto"=>	array(R5_CUIR => 1),
		"prix_res"		=>	array(R5_BOIS => 50),
		"prix_trn"		=>	array(T5_ZONE_CHASSE => 1),
		"need_src"	=>	array(S5_ARTS_MUSICAUX),
		"prix_unt"		=>	array(U5_SERVITEUR => 1),
);

//Demeure de Forestier,
$this->btc[B5_DEMEURE_FORESTIER]=array(
		"vie"			=>	400,
		"tours"		=>	100,
		"prod_res_auto"=>	array(R5_BOIS_IF => 1),
		"prix_res"		=>	array(R5_BOIS => 50),
		"prix_trn"		=>	array(T5_FORET_IF => 1),
		"need_src"	=>	array(S5_ARTS_MUSICAUX),
		"prix_unt"		=>	array(U5_FORESTIER => 1),
);

//Aire d'entrainement,
$this->btc[B5_AIRE_ENTRAINEMENT]=array(
		"vie"			=>	300,
		"tours"		=>	60,
		"prix_res"		=>	array(R5_BOIS => 30,R5_PIERRE => 5),
		"need_src"	=>	array(S5_ARMEE_1),
		"prix_unt"		=>	array(U5_SERVITEUR => 1),
		"limite"		=>	5,
		"prod_unt"	=>	true,
);
	
//Marché,
$this->btc[B5_MARCHE]=array(
		"vie"			=>	600,
		"tours"		=>	120,
		"prix_res"		=>	array(R5_BOIS => 200,R5_OR => 50),
		"prix_unt"		=>	array(U5_SERVITEUR => 2),
		"need_src"	=>	array(S5_COMMERCE_1),
		"limite"	=>	2,
		"com" => array(
			S5_COMMERCE_1 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
			S5_COMMERCE_2 => array(COM_MAX_NB2,COM_MAX_VENTES2),
			S5_COMMERCE_3 => array(COM_MAX_NB3,COM_MAX_VENTES3)
			)
);

//Comptoir de fonte,
$this->btc[B5_COMPTOIRE_FONTE]=array(
		"vie"			=>	650,
		"tours"	=>	150,
		"prod_res_auto"=>	array(R5_ACIER => 1),
		"prix_res"		=>	array(R5_BOIS => 300,R5_PIERRE => 15,R5_OR => 100,R5_CUIR => 50),
		"need_src"	=>	array(S5_FONTE_ACIER),
		"prix_unt"		=>	array(U5_SERVITEUR => 1, U5_FORGERON => 1),
		"limite"		=>	1,
);
		
//Archerie,
$this->btc[B5_ARCHERIE]=array(
		"vie"			=>	600,
		"prix_res"		=>	array(R5_BOIS => 250,R5_BOIS_IF => 150,R5_CUIR => 100,R5_ACIER => 10),
		"tours"		=>	120,
		"need_btc"	=>	array(B5_COMPTOIRE_FONTE),
		"prix_unt"		=>	array(U5_FORESTIER => 1),
		"need_src"	=>	array(S5_ARME_1),
		"limite"		=>	3,
		"prod_res"	=>	true,
		);
		
//Forge,
$this->btc[B5_FORGE]=array(
		"vie"			=>	650,
		"tours"		=>	250,
		"prix_res"		=>	array(R5_BOIS => 250,R5_PIERRE => 20,R5_BOIS_IF => 50,R5_CUIR => 150,R5_ACIER => 20),
		"need_src"       =>    array(S5_ARME_1),
		"need_btc"	=>	array(B5_COMPTOIRE_FONTE),
		"prix_unt"		=>	array(U5_FORGERON =>2),
		"limite"		=>	5,
		"prod_res"	=>	true,
);

//Tour,
$this->btc[B5_TOUR]=array(
		"bonus" 	=> array('bon' => 3),
		"vie"			=>	900,
		"tours"		=>	150,
		"prix_res"		=>	array(R5_BOIS => 400,R5_PIERRE => 150,R5_ACIER => 50),
		"need_src"       =>	array(S5_FORTIFICATION),
		"prix_unt"		=>	array(U5_ARCHER => 4),
		"limite"		=>	4,
);

//Caserne,
$this->btc[B5_CASERNE]=array(
		"vie"			=>	800,
		"tours"		=>	250,
		"prix_res"		=>	array(R5_BOIS => 300,R5_PIERRE => 50,R5_OR => 100),
		"need_src"       =>	array(S5_ARMEE_2),
		"prix_unt"		=>	array(U5_ACOLYTE => 1),
		"limite"		=>	5,
		"prod_unt"	=>	true,
		);

//Ecuries,
$this->btc[B5_ECURIES]=array(
		"vie"			=>	500,
		"tours"		=>	300,
		"need_src"	=>	array(S5_ATTELAGE),
		"prix_res"		=>	array(R5_BOIS => 500,R5_CUIR => 200,R5_ACIER => 50,R5_BAIES => 400),
		"prix_unt"		=>	array(U5_SERVITEUR => 1),
		"limite"		=>	5,
		"prod_res"	=>	true,
);

//Théâtre,
$this->btc[B5_THEATRE]=array(
		"vie"			=>	600,
		"tours"		=>	120,
		"need_src"	=>	array(S5_ARTS_DRAMATIQUES),
		"prod_res_auto"=>	array(R5_OR => 3),
		"prix_res"		=>	array(R5_BOIS => 200,R5_PIERRE => 50,R5_BOIS_IF => 100,R5_CUIR => 100),
		"prix_trn"		=>	array(T5_VILLAGE => 1),
		"prix_unt"		=>	array(U5_BARDE => 2),
);

//Bibliothèque,
$this->btc[B5_BIBLIOTHEQUE]=array(
		"vie"			=>	800,
		"tours"		=>	120,
		"need_src"	=>	array(S5_CONNAISSANCES_1),
		"prix_res"		=>	array(R5_BOIS => 200,R5_PIERRE => 100,R5_BOIS_IF => 100),
		"prix_unt"		=>	array(U5_SERVITEUR => 1),
		"limite"		=>	1,
		"prod_src"	=>	true,
);

//Demeure,
$this->btc[B5_DEMEURE]=array(
		"vie"		=>      175,
		"prix_res"		=>      array(R5_BOIS => 20,R5_PIERRE => 10),
		"tours"		=>	25,
		"prod_pop" 	=> 	10,
		"need_btc"       =>      array(B5_BIBLIOTHEQUE),
		"limite"	=>	35,
);

//Bosquet,
$this->btc[B5_BOSQUET]=array(
		"vie"			=>      600,
		"need_src"	=>      array(S5_DRUIDISME_1),
		"prix_res"		=>      array(R5_BOIS => 400,R5_BOIS_IF => 300),
		"tours"		=>      300,
		"prix_unt"		=>      array(U5_SERVITEUR => 1),
		"limite"		=>      3,
		"prod_unt"	=>	true,
	);

//Antre,
$this->btc[B5_ANTRE]=array(
		"vie"		=>	800,
		"need_src"	=>	array(S5_DRUIDISME_2),
		"tours"		=>	400,
		"prix_res"		=>	array(R5_BOIS => 500,R5_BOIS_IF => 400,R5_PIERRE => 100,R5_BAIES => 600),
		"prix_unt"		=>	array(U5_DRUIDE => 1),
		"limite"        	=> 	3,
		"prod_unt"	=>	true,
		);

//Ecole de magie,
$this->btc[B5_ECOLE_MAGIE]=array(
		"vie"		=>	800,
		"prix_res"		=>	array(R5_BOIS => 300, R5_PIERRE => 100,R5_OR => 200,R5_BOIS_IF => 150,R5_MITHRIL => 20),
		"tours"		=>	250,
		"prix_unt"		=>	array(U5_ACOLYTE => 2),
		"need_src"	=>	array(S5_CONNAISSANCES_2),
		"limite"		=>	4,
		"prod_unt"	=>	true,
		);
		
//Fort,
$this->btc[B5_FORT]=array(
		"vie"			=>	1000,
		"prix_res"		=>	array(R5_BOIS => 400,R5_PIERRE => 150),
		"tours"		=>	300,
		"need_btc"	=>	array(B5_BIBLIOTHEQUE),
		"prix_unt"		=>	array(U5_ACOLYTE => 1,U5_NOBLE => 2),
		"limite"		=>	4,
		"prod_unt"	=>	1,
		);
	
//Temple,
$this->btc[B5_TEMPLE]=array(
		"vie"		=>	800,
		"prix_res"	=>	array(R5_PIERRE => 250,R5_PIERRE => 200,R5_BOIS_IF => 200,R5_OR => 150,R5_MITHRIL => 50),
		"tours"		=>	400,
		"need_btc"	=>	array(B5_ECOLE_MAGIE,B5_FORT),
		"prix_unt"	=>	array(U5_SERVITEUR => 2,U5_NOBLE => 2),
		"limite"	=>	1,
		"prod_unt"	=>	1,
);

//Cité Sylvestre
$this->btc[B5_CITE]=array(
	"bonus" 	=> array('gen' => 350, 'bon' => 15),
	"vie"		=>5000,
	"prod_pop"	=> 100,
	"prix_res"	=>array(R5_BOIS => 5000,R5_BOIS_IF => 1000,R5_PIERRE => 2000,R5_CUIR => 500,R5_ACIER => 400,R5_MITHRIL => 100),
	"tours"		=>2000,
	"need_btc"	=>array(B5_TEMPLE),
	"prix_unt"	=>array(U5_GARDE => 10),
	"limite"	=>1,
	"prod_unt"	=>4,
	"prod_src"	=>true,
);
//</btc>

//*******************************//
// Unités                        //
//*******************************//

//<unt>
//Serviteur
$this->unt[U5_SERVITEUR]=array(
		"prix_res"=>array(R5_OR => 2),
		"vie"=>1,
		"need_btc"=>array(B5_COLONIE),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>1,
		"role"=>TYPE_UNT_CIVIL,
);
//Cueilleur
$this->unt[U5_CUEILLEUR]=array(
		"prix_res"=>array(R5_OR => 2),
		"vie"=>1,
		"need_btc"=>array(B5_COLONIE),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>2,
		"role"=>TYPE_UNT_CIVIL,
);
//Forestier
$this->unt[U5_FORESTIER]=array(
		"prix_res"=>array(R5_OR => 2),
		"vie"=>1,
		"need_btc"=>array(B5_COLONIE),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>2,
		"role"=>TYPE_UNT_CIVIL,
);
//Forgeron
$this->unt[U5_FORGERON]=array(
		"prix_res"=>array(R5_OR => 2),
		"vie"=>1,
		"need_btc"=>array(B5_COLONIE),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>2,
		"role"=>TYPE_UNT_CIVIL,
);
//Acolyte
$this->unt[U5_ACOLYTE]=array(
		"prix_res"=>array(R5_OR => 3),
		"vie"=>1,
		"need_btc"=>array(B5_COLONIE),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>5,
		"role"=>TYPE_UNT_CIVIL,
);
//Barde
$this->unt[U5_BARDE]=array(
		"prix_res"=>array(R5_OR => 2),
		"vie"=>1,
		"need_btc"=>array(B5_COLONIE),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>6,
		"role"=>TYPE_UNT_CIVIL,
);
//Noble
$this->unt[U5_NOBLE]=array(
		"prix_res"=>array(R5_OR => 4),
		"vie"=>1,
		"need_btc"=>array(B5_BIBLIOTHEQUE),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>7,
		"role"=>TYPE_UNT_CIVIL,
);

//Eclaireur
$this->unt[U5_ECLAIREUR]=array(
		"def"=>2,
		"vie"=>12,
		"atq_unt"=>2,
		"vit"=>11,
		"prix_res"=>array(),
		"need_btc"=>array(B5_AIRE_ENTRAINEMENT),
		"in_btc"=>array(B5_AIRE_ENTRAINEMENT),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>8,
		"role"=>TYPE_UNT_INFANTERIE,
		"rang" => 1,
);

//Patrouilleur
$this->unt[U5_PATROUILLEUR]=array(
		"def"=>5,
		"vie"=>8,
		"atq_unt"=>6,
		"vit"=>8,
		"prix_res"=>array(R5_ARC_COURT => 1),
		"need_btc"=>array(B5_AIRE_ENTRAINEMENT),
		"in_btc"=>array(B5_AIRE_ENTRAINEMENT),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>8,
		"role"=>TYPE_UNT_DISTANCE,
		"rang" => 8,
);

//Rôdeur
$this->unt[U5_RODEUR]=array(
		"def"=>8,
		"vie"=>17,
		"atq_unt"=>10,
		"vit"=>8,
		"prix_res"=>array(R5_RONDACHE => 1,R5_LAME => 1,R5_A_CUIR => 1),
		"need_btc"=>array(B5_CASERNE),
		"in_btc"=>array(B5_CASERNE),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>10,
		"role"=>TYPE_UNT_INFANTERIE,
		"rang" => 2,
);

//Lancier
$this->unt[U5_LANCIER]=array(
		"def"=>10,
		"vie"=>18,
		"atq_unt"=>10,
		"vit"=>8,
		"prix_res"=>array(R5_RONDACHE => 1,R5_PIQUE => 1,R5_A_CUIR => 1),
		"need_btc"=>array(B5_CASERNE),
		"in_btc"=>array(B5_CASERNE),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>10,
		"role"=>TYPE_UNT_INFANTERIE,
		"rang" => 3,
);

//Archer
$this->unt[U5_ARCHER]=array(
		"def"=>16,
		"vie"=>12,
		"atq_unt"=>15,
		"vit"=>10,
		"bonus" => array('vie' => 1),
		"prix_res"=>array(R5_ARC_COURT => 1,R5_A_CUIR => 1),
		"need_btc"=>array(B5_CASERNE),
		"in_btc"=>array(B5_CASERNE),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>10,
		"role"=>TYPE_UNT_DISTANCE,
		"rang" => 9,
);

//Epéiste
$this->unt[U5_EPEISTE]=array(
		"def"=>18,
		"vie"=>25,
		"atq_unt"=>19,
		"vit"=>10,
		"prix_res"=>array(R5_PAVOIS => 1,R5_LAME => 1,R5_A_CUIR => 1),
		"need_btc"=>array(B5_CASERNE),
		"in_btc"=>array(B5_CASERNE),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>13,
		"role"=>TYPE_UNT_INFANTERIE,
		"rang" => 4,
);

//Piquier
$this->unt[U5_PIQUIER]=array(
		"def"=>25,
		"vie"=>19,
		"atq_unt"=>20,
		"vit"=>9,
		"prix_res"=>array(R5_PAVOIS => 1,R5_PIQUE => 1,R5_A_CUIR => 1),
		"need_btc"=>array(B5_CASERNE),
		"in_btc"=>array(B5_CASERNE),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>13,
		"role"=>TYPE_UNT_INFANTERIE,
		"rang" => 5,
);

//Garde
$this->unt[U5_GARDE]=array(
		"def"=>14,
		"vie"=>10,
		"atq_unt"=>15,
		"vit"=>10,
		"prix_res"=>array(R5_ARC_COMPOSITE => 1,R5_A_CUIR => 1,R5_RONDACHE => 1),
		"need_btc"=>array(B5_CASERNE),
		"in_btc"=>array(B5_CASERNE),
		"prix_unt"=>array(U5_ACOLYTE => 1),
		"group"=>13,
		"role"=>TYPE_UNT_DISTANCE,
		"rang" => 10,
);

//Druide
$this->unt[U5_DRUIDE]=array(
		"prix_res"=>array(R5_OR => 2),
		"vie"=>1,
		"need_btc"=>array(B5_BOSQUET),
		"in_btc"=>array(B5_COLONIE, B5_CITE),
		"group"=>16,
		"role"=>TYPE_UNT_CIVIL,
);

//Nymphe
$this->unt[U5_NYMPHE]=array(
		"def"=>16,
		"vie"=>21,
		"atq_unt"=>22,
		"vit"=>14,
		"prix_res"=>array(R5_OR => 20,R5_MITHRIL => 2),
		"need_btc"=>array(B5_BOSQUET),
		"in_btc"=>array(B5_BOSQUET),
		"prix_unt"=>array(U5_DRUIDE => 1),
		"group"=>17,
		"role"=>TYPE_UNT_INFANTERIE,
		"rang" => 6,
);

//Vénérable
$this->unt[U5_VENERABLE]=array(
		"def"=>12,
		"vie"=>20,
		"atq_unt"=>14,
		"atq_btc"=>8,
		"vit"=>4,
		"prix_res"=>array(R5_BOIS => 200,R5_BAIES => 200,R5_BOIS_IF => 20,R5_CUIR => 20),
		"need_btc"=>array(B5_ANTRE),
		"in_btc"=>array(B5_ANTRE),
		"prix_unt"=>array(U5_DRUIDE => 2),
		"group"=>18,
		"role"=>TYPE_UNT_MACHINE,
		"rang" => 15,
);

//Commandant
$this->unt[U5_COMMANDANT]=array(
		"def"=>17,
		"vie"=>19,
		"atq_unt"=>28,
		"vit"=>11,
		"need_src"       =>      array(S5_MAITRISE_OFFENSIVE),
		"prix_res"=>array(R5_CHEVAUX => 1,R5_PAVOIS => 1,R5_PIQUE => 1,R5_A_MITHRIL =>1),
		"need_btc"=>array(B5_FORT),
		"in_btc"=>array(B5_FORT),
		"prix_unt"=>array(U5_NOBLE => 1),
		"group"=>19,
		"role"=>TYPE_UNT_CAVALERIE,
		"rang" => 7,
);

//Garde d'élite
$this->unt[U5_GARDE_ELITE]=array(
		"def"=>18,
		"vie"=>13,
		"atq_unt"=>19,
		"vit"=>11,
		"bonus" => array('vie' => 1),
		"need_src"       =>      array(S5_MAITRISE_DEFENSIVE),
		"prix_res"=>array(R5_CHEVAUX => 1,R5_ARC_COMPOSITE => 1,R5_A_MITHRIL => 1),
		"need_btc"=>array(B5_FORT),
		"in_btc"=>array(B5_FORT),
		"prix_unt"=>array(U5_NOBLE => 1),
		"group"=>20,
		"role"=>TYPE_UNT_DISTANCE,
		"rang" => 11,
);

//Mage
$this->unt[U5_MAGE]=array(
		"def"=>10,
		"vie"=>8,
		"atq_unt"=>12,
		"vit"=>8,
		"bonus"         =>      array('atq' => 1),
		"prix_res"=>array(R5_OR => 5,R5_ACIER => 5,R5_MITHRIL => 1),
		"need_btc"=>array(B5_ECOLE_MAGIE),
		"in_btc"=>array(B5_ECOLE_MAGIE),
		"prix_unt"=>array(U5_NOBLE => 1),
		"group"=>21,
		"role"=>TYPE_UNT_MAGIQUE,
		"rang" => 12,
);

//Gardien
$this->unt[U5_GARDIEN]=array(
		"def"=>12,
		"vie"=>8,
		"atq_unt"=>10,
		"vit"=>10,
		"bonus"         =>      array('def' => 1),
		"prix_res"=>array(R5_OR => 5,R5_ACIER => 5,R5_MITHRIL => 1),
		"need_btc"=>array(B5_ECOLE_MAGIE),
		"in_btc"=>array(B5_ECOLE_MAGIE),
		"prix_unt"=>array(U5_NOBLE => 1),
		"group"=>21,
		"role"=>TYPE_UNT_MAGIQUE,
		"rang" => 13,
);

//Avatar de Corellon Larethian
$this->unt[U5_AVATAR_CORELLON]=array(
		"def"=>165,
		"vie"=>125,
		"atq_unt"=>45,
		"vit"=>14,
		"need_src"       =>    array(S5_FIDELITE_CORELLON),
		"prix_res"=>array(R5_ARC_COMPOSITE => 4,R5_A_MITHRIL => 1,R5_CHEVAUX => 1,R5_OR => 8),
		"need_btc"=>array(B5_TEMPLE),
		"in_btc"=>array(B5_TEMPLE),
		"prix_unt"=>array(U5_NOBLE => 1),
		"group"=>23,
		"role"=>TYPE_UNT_HEROS,
		"rang" => 16,
);

//Avatar de Aerdrie Faenya
$this->unt[U5_AVATAR_AERDRIE]=array(
		"def"=>85,
		"vie"=>135,
		"atq_unt"=>110,
		"atq_btc"=>20,
		"vit"=>10,
		"need_src" => array(S5_FIDELITE_AERDRIE),
		"prix_res"=>array(R5_ACIER => 3,R5_RONDACHE => 2,R5_PAVOIS => 2,R5_A_MITHRIL => 1,R5_MITHRIL => 1),
		"need_btc"=>array(B5_TEMPLE),
		"in_btc"=>array(B5_TEMPLE),
		"prix_unt"=>array(U5_NOBLE => 1),
		"group"=>24,
		"role"=>TYPE_UNT_HEROS,
		"rang" => 17,
);

$this->unt[U5_AIGLE]=array(  
		"def"=>5,
		"vie"=>13,
		"atq_unt"=>0,
		"atq_btc"=>13,
		"vit"=>9,
		"need_src" =>array(S5_CONNAISSANCES_2),
		"prix_res"=>array(R5_BAIES => 200 ,R5_MITHRIL => 5,R5_BOIS_IF => 50, R5_CUIR => 50),
		"need_btc"=>array(B5_ANTRE),
		"in_btc"=>array(B5_ANTRE),
		"group"=>25,
		"prix_unt"=>array(U5_DRUIDE => 2),
		"role"=>TYPE_UNT_MACHINE,
		"rang" => 14,
);

$this->unt[U5_DRAGON]=array(  
		"def"=>55,
		"vie"=>130,
		"atq_unt"=>165,
		"vit"=>15,
		"need_src" =>array(S5_SANG),
		"prix_res"=>array(R5_BAIES => 200 ,R5_MITHRIL => 5,R5_BOIS_IF => 50, R5_CUIR => 50),
		"need_btc"=>array(B5_TEMPLE),
		"in_btc"=>array(B5_TEMPLE),
		"group"=>25,
		"prix_unt"=>array(U5_DRUIDE => 2),
		"role"=>TYPE_UNT_HEROS,
		"rang" => 18,
);

$this->unt[U5_TRANSPOR_INCANT]=array(  

		"vie"=>130,
		"vit"=>9,
		"need_src" =>array(S5_INCANT_TRANSPOR),
		//"prix_res"=>array(R5_BAIES => 20000 ,R5_MITHRIL => 500,R5_BOIS_IF => 500, R5_CUIR => 500),
		"prix_res"=>array(R5_BAIES => 10000 ,R5_MITHRIL => 250,R5_BOIS_IF => 200, R5_CUIR => 300),
		"need_btc"=>array(B5_ECOLE_MAGIE),
		"in_btc"=>array(B5_ECOLE_MAGIE),
		"group"=>25,
		"prix_unt"=>array(U5_DRUIDE => 2),
		"role"=>TYPE_UNT_DEMENAGEMENT,
		"rang" => 18,
);
//</unt>

//<src>
//Arts musicaux,
$this->src[S5_ARTS_MUSICAUX]=array(
"tours"=>4,
"need_btc"=>array(B5_MAISON, B5_MAISON_CUEILLETTE),
"prix_res"=>array(R5_BOIS => 30,R5_BAIES => 50),
"group"=>1,
);

//Armes niv1,
$this->src[S5_ARME_1]=array(
"tours"=>5,
"need_btc"=>array(B5_AIRE_ENTRAINEMENT),
"prix_res"=>array(R5_BOIS => 50,R5_BOIS_IF => 30,R5_CUIR => 30,R5_ACIER => 20),
"group"=>2,
);

//Armes niv2,
$this->src[S5_ARME_2]=array(
"tours"=>10,
"need_btc"=>array(B5_ARCHERIE),
"need_src"=>array(S5_ARMEE_2),
"prix_res"=>array(R5_OR => 30,R5_BOIS => 75,R5_BOIS_IF => 50,R5_CUIR => 50,R5_ACIER => 30),
"group"=>2,
);

//Défense niv1,
$this->src[S5_DEFENSE_1]=array(
"tours"=>10,
"need_btc" =>array(B5_AIRE_ENTRAINEMENT),
"prix_res"=>array(R5_BOIS => 30,R5_BOIS_IF => 25,R5_CUIR => 40,R5_ACIER => 30),
"group"=>4,
);

//Défense niv2,
$this->src[S5_DEFENSE_2]=array(
"tours"=>15,
"need_src"=>array(S5_ARMEE_2),
"prix_res"=>array(R5_OR => 75,R5_BOIS => 40,R5_BOIS_IF => 30,R5_CUIR => 60,R5_ACIER => 40,R5_MITHRIL => 10),
"group"=>4,
);

//Fortifications,
$this->src[S5_FORTIFICATION]=array(
"tours"=>30,
"need_btc"=>array(B5_ARCHERIE),
"prix_res"=>array(R5_BOIS => 300,R5_PIERRE => 100,R5_ACIER => 100,R5_MITHRIL => 15),
"group"=>4,
);

//Armée niv1,
$this->src[S5_ARMEE_1]=array(
"tours"=>10,
"need_btc" =>array(B5_TROUPE),
"prix_res"=>array(R5_OR => 25,R5_BAIES => 200,R5_BOIS => 40),
"group"=>7,
);

//Armée niv2,
$this->src[S5_ARMEE_2]=array(
"tours"=>25,
"need_btc"=>array(B5_COMPTOIRE_FONTE),
"need_src"=>array(S5_ARMEE_1, S5_DEFENSE_1),
"prix_res"=>array(R5_OR => 75,R5_BAIES => 500,R5_BOIS => 75,R5_BOIS_IF => 50,R5_CUIR => 50),
"group"=>7,
);

//Commerce niv1,
$this->src[S5_COMMERCE_1]=array(
"tours"=>8,
"need_btc" =>array(B5_TROUPE),
"prix_res"=>array(R5_OR => 50),
"group"=>9,
);

//Commerce niv2,
$this->src[S5_COMMERCE_2]=array(
"tours"=>20,
"need_btc"=>array(B5_MARCHE),
"prix_res"=>array(R5_OR => 200,R5_BAIES => 1000,R5_MITHRIL => 10,R5_CUIR => 100),
"group"=>9,
);

//Commerce niv3,
$this->src[S5_COMMERCE_3]=array(
"tours"=>40,
"need_btc"=>array(B5_ECURIES),
"need_src"=>array(S5_COMMERCE_2),
"prix_res"=>array(R5_OR => 500,R5_BAIES => 4000,R5_MITHRIL => 20,R5_PIERRE => 100),
"group"=>9,
);

//Fonte de l'acier,
$this->src[S5_FONTE_ACIER]=array(
"tours"=>25,
"need_btc" =>      array(B5_MARCHE),
"prix_res"=>array(R5_OR => 120,R5_CUIR => 50),
"group"=>12,
);

//Attelage,
$this->src[S5_ATTELAGE]=array(
"tours"=>30,
"need_btc" =>      array(B5_CASERNE),
"prix_res"=>array(R5_BAIES => 3000,R5_CUIR => 150,R5_ACIER => 50),
"group"=>13,
);

//Arts dramatiques,
$this->src[S5_ARTS_DRAMATIQUES]=array(
"tours"=>25,
"need_btc" =>      array(B5_CASERNE),
"prix_res"=>array(R5_OR => 150,R5_BAIES => 1500,R5_BOIS => 150),
"group"=>14,
);

//Connaissances niv1,
$this->src[S5_CONNAISSANCES_1]=array(
"tours"=>20,
"need_btc" =>      array(B5_CASERNE),
"prix_res"=>array(R5_OR => 120,R5_BOIS => 75,R5_PIERRE => 50,R5_CUIR => 75,R5_MITHRIL => 10),
"group"=>15,
);

//Connaissances niv2,
$this->src[S5_CONNAISSANCES_2]=array(
"tours"=>40,
"need_btc"=>array(B5_BIBLIOTHEQUE),
"prix_res"=>array(R5_OR => 200,R5_BOIS => 150,R5_PIERRE => 75,R5_CUIR => 120,R5_MITHRIL => 25),
"group"=>15,
);

//Druidisme niv1,
$this->src[S5_DRUIDISME_1]=array(
"tours"=>15,
"need_btc" =>      array(B5_BIBLIOTHEQUE),
"prix_res"=>array(R5_OR => 150,R5_BOIS => 200,R5_BAIES => 2000,R5_BOIS_IF => 250),
"group"=>17,
);

//Druidisme niv2,
$this->src[S5_DRUIDISME_2]=array(
"tours"=>20,
"need_btc"=>array(B5_BOSQUET),
"prix_res"=>array(R5_OR => 250,R5_BOIS => 500,R5_BAIES => 6000,R5_BOIS_IF => 400),
"group"=>17,
);

//Maitrise Défensive,
$this->src[S5_MAITRISE_DEFENSIVE]=array(
"tours"=>15,
"need_btc"=>array(B5_FORT),
"prix_res"=>array(R5_BOIS => 150,R5_BOIS_IF => 200,R5_CUIR => 300,R5_ACIER => 50,R5_MITHRIL => 30),
"group"=>20,
);

//Maitrise Offensive,
$this->src[S5_MAITRISE_OFFENSIVE]=array(
"tours"=>25,
"need_btc"=>array(B5_FORT),
"prix_res"=>array(R5_BOIS => 150,R5_BOIS_IF => 300,R5_CUIR => 200,R5_ACIER => 50,R5_MITHRIL => 30),
"group"=>20,
);


$this->src[S5_INCANT_TRANSPOR]=array(
"tours"=>30,
"need_btc"=>array(B5_ECOLE_MAGIE),
"prix_res"=>array(R5_OR => 3000,R5_MITHRIL => 450,R5_BAIES => 3000,R5_ACIER => 800),
"group"=>21,
);

//Fidélité en Aerdrie Faenya,
$this->src[S5_FIDELITE_AERDRIE]=array(
"tours"=>50,
"need_btc"=>array(B5_TEMPLE),
"prix_res"=>array(R5_OR => 300,R5_MITHRIL =>  30,R5_BAIES => 3000,R5_ACIER => 150),
"group"=>22,
);

//Fidélité en Corellon Larethian,
$this->src[S5_FIDELITE_CORELLON]=array(
"tours"=>50,
"need_btc"=>array(B5_TEMPLE),
"prix_res"=>array(R5_OR => 300,R5_MITHRIL => 30,R5_BAIES => 3000,R5_ACIER => 150),
"group"=>22,
);

$this->src[S5_SANG]=array(
"tours"=>50,
"need_btc"=>array(B5_TEMPLE),
"prix_res"=>array(R5_OR => 300,R5_MITHRIL => 30,R5_BAIES => 3000,R5_ACIER => 150),
"group"=>22,
);
//</src>

/* compétences du ou des héros ... */

//<comp>
/* ### Off ### */
$this->comp[CP_BOOST_OFF]=array(
	'heros'		=> array(U5_DRAGON),
	'tours'		=> 3,
	'bonus'		=> 10,
	'prix_xp'	=> 40,
	'type'		=> 1
);

$this->comp[CP_RESURECTION]=array(
	'heros'		=> array(U5_DRAGON),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_VOLEE_DE_FLECHES]=array(
	'heros'		=> array(U5_DRAGON),
	'tours'		=> 24,
	'bonus'		=> 5,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_INVISIBILITE]=array(
	'heros'		=> array(U5_DRAGON),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

/* ### Def ### */

$this->comp[CP_BOOST_DEF]=array(
	'heros'		=> array(U5_AVATAR_CORELLON),
	'tours'		=> 8,
	'bonus'		=> 8,
	'prix_xp'	=> 40,
	'type'		=> 2
);

$this->comp[CP_RESISTANCE]=array(
	'heros'		=> array(U5_AVATAR_CORELLON),
	'tours'		=> 6,
	'bonus'		=> 15,
	'prix_xp'	=> 60,
	'type'		=> 2
);

$this->comp[CP_REGENERATION]=array(
	'heros'		=> array(U5_AVATAR_CORELLON),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 2
);

$this->comp[CP_FLECHES_SALVATRICES]=array(
	'heros'		=> array(U5_AVATAR_CORELLON),
	'tours'		=> 24,
	'bonus'		=> 8,
	'prix_xp'	=> 50,
	'type'		=> 2
);

/* ### Sou ### */

$this->comp[CP_CASS_BAT]=array(
	'heros'		=> array(U5_AVATAR_AERDRIE),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GENIE_COMMERCIAL]=array(
	'heros'		=> array(U5_AVATAR_AERDRIE),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GUERISON]=array(
	'heros'		=> array(U5_AVATAR_AERDRIE),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_COLLABORATION]=array(
	'heros'		=> array(U5_AVATAR_AERDRIE),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);
//</comp>

$this->race_cfg = array(
	'res_nb'	=>	count($this->res),
	'trn_nb'	=>	count($this->trn),
	'btc_nb'	=>	count($this->btc),
	'unt_nb'	=>	count($this->unt),
	'src_nb'	=>	count($this->src),
 	'primary_res' => array(R5_OR,R5_BAIES),
 	'second_res'  => array(R5_OR,R5_BAIES,R5_BOIS,R5_PIERRE,R5_BOIS_IF,R5_CUIR,R5_ACIER,R5_MITHRIL),
 	'primary_btc' => array(
 		'vil' => array(
 			B5_COLONIE => array('unt','src'),
 			B5_AIRE_ENTRAINEMENT => array('unt'),
 			B5_ARCHERIE => array('res'),
 			B5_FORGE => array('res'),
 			B5_CASERNE => array('unt'),
 			B5_ECURIES => array('res'),
 			B5_BOSQUET => array('unt'),
 			B5_ANTRE => array('unt'),
 			B5_ECOLE_MAGIE => array('unt'),
 			B5_FORT => array('unt'),
 			B5_TEMPLE => array('unt')),
 		'ext' => array(B5_MARCHE => array('ach'))),
 	'bonus_res'   => array(R5_OR => 0.05),
 	'modif_pts_btc' => 1,
	'debut'	=>	array(
		'res'	=>	array(R5_OR => 70,  R5_BOIS => 150, R5_BAIES => 1500),
		'trn'	=>	array(T5_FORET => 2, T5_ZONE_CHASSE => 2, T5_VILLAGE => 1, T5_FORET_IF => 3),
		'unt'	=> 	array(U5_SERVITEUR => 1, U5_ECLAIREUR => 5),
		'btc'	=> 	array(B5_COLONIE => array()),
		'src'	=>	array()),
	'bonus_map' => array(MAP_EAU => 0, MAP_LAC => 0, MAP_HERBE => -2, MAP_MONTAGNE => -5, MAP_FORET => 15),
	'bonus_period' => array(PERIODS_JOUR => 3, PERIODS_NUIT => -3, PERIODS_AUBE => 0, PERIODS_CREP => 0),
);

}
}
?>
