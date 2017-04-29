<?php
/* Defines */
define("R2_OR", 1);
define("R2_BOIS", 2);
define("R2_PIERRE", 3);
define("R2_VIANDE", 4);
define("R2_FER", 5);
define("R2_CHARBON", 6);
define("R2_LOUPS_GEANTS", 7);
define("R2_ACIER", 8);
define("R2_MITHRIL", 9);
define("R2_A_CUIR", 10);
define("R2_A_CLOUT", 11);
define("R2_EPEE", 12);
define("R2_HACHE", 13);
define("R2_ARC", 14);
define("R2_LANCE", 15);
define("R2_A_ACIER", 16);
define("R2_A_MITHRIL", 17);

define("T2_FORET", 1);
define("T2_GIS_FER", 2);
define("T2_GIS_CHARBON", 3);
define("T2_FILON_OR", 4);
define("T2_MONTAGNE", 5);

define("B2_REPAIRE", 1);
define("B2_CARRIERE", 2);
define("B2_SCIERIE", 3);
define("B2_HUTTE", 4);
define("B2_M_CHASSE", 5);
define("B2_AIRE_ENTRE", 6);
define("B2_MINE_OR", 7);
define("B2_MARCHE", 8);
define("B2_FORGE", 9);
define("B2_MINE_CHARBON", 10);
define("B2_MINE_FER", 11);
define("B2_FONDERIE", 12);
define("B2_ATELIER", 13);
define("B2_TANIERE", 14);
define("B2_TOURS", 15);
define("B2_TOTEM", 16);
define("B2_GARDE_MANGER", 17);
define("B2_FORTIN", 18);

define("U2_GOB", 1);
define("U2_GOB_CHASSEUR", 2);
define("U2_GOB_FORGERON", 3);
define("U2_GOB_BUCHERON", 4);
define("U2_GOB_MINEUR", 5);
define("U2_TETE", 6);
define("U2_SOLDAT", 7);
define("U2_TRANCHEUR", 8);
define("U2_EPEISTE", 9);
define("U2_CHAMP_EPEISE", 10);
define("U2_TIREUR", 11);
define("U2_ARCHER", 12);
define("U2_CHAMP_ARCHER", 13);
define("U2_PERCEUR", 14);
define("U2_LANCIER", 15);
define("U2_CHAMP_LANCIER", 16);
define("U2_FENDEUR", 17);
define("U2_PORTE_HACHE", 18);
define("U2_CHAMP_PORTE_HACHE", 19);
define("U2_DRESSEUR", 20);
define("U2_CAVALIER", 21);
define("U2_CHEVAUCHEUR", 22);
define("U2_CATAPULE", 23);
define("U2_BALISTE", 24);
define("U2_BELIER", 25);
define("U2_BELIER_BRISE_CRANE", 26);
define("U2_SHAMAN", 27);
define("U2_COGNEUR", 28);
define("U2_TROLL", 29);
define("U2_BERSERKER", 30);
define("U2_SEIGNEUR_ORC_SUR_SANGLIER", 31);
define("U2_PORTE_ETENDARD", 32);
define("U2_BALUCHON", 33);

define("S2_EPEES", 1);
define("S2_HACHES", 2);
define("S2_ARCS", 3);
define("S2_LANCES", 4);
define("S2_DEFENSE_1", 5);
define("S2_DEFENSE_2", 6);
define("S2_DEFENSE_3", 7);
define("S2_ACIER", 8);
define("S2_ELEVAGE", 9);
define("S2_COMMERCE_1", 10);
define("S2_COMMERCE_2", 11);
define("S2_ARMEE_1", 12);
define("S2_ARMEE_2", 13);
define("S2_ARMEE_3", 14);
define("S2_MINE_1", 15);
define("S2_MINE_2", 16);
define("S2_SHAMANS", 17);
define("S2_COGNEURS", 18);
define("S2_TROLLS", 19);
define("S2_BERSERKER", 20);
define("S2_MACHINES", 21);
define("S2_SANGLIER", 22);
define("S2_ETENDARDS", 23);
define("S2_MEUTE", 24);


class config2
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
$this->res = array();
$this->res[R2_OR] = array(
		"cron"	=> true,
		"need_btc"	=>	B2_MINE_OR);

$this->res[R2_BOIS] = array(
		"cron"	=> true,
		"need_btc"	=>	B2_SCIERIE);

$this->res[R2_PIERRE] = array(
		"cron"	=> true,
		"need_btc"	=>	B2_CARRIERE);

$this->res[R2_VIANDE] = array(
		"cron"	=> true,
		"need_btc"	=>	B2_M_CHASSE);

$this->res[R2_FER] = array(
		"cron"	=> true,
		"need_btc"	=>	B2_MINE_FER);

$this->res[R2_CHARBON] = array(
		"cron"	=> true,
		"need_btc"	=>	B2_MINE_CHARBON);

$this->res[R2_LOUPS_GEANTS] = array(
		"prix_res"	=>	array(R2_VIANDE => 150, R2_ACIER => 2),
		"need_src"	=>	array(S2_ELEVAGE),
		"need_btc"	=>	B2_TANIERE,
		"group"		=>	7,
		);

$this->res[R2_ACIER] = array(
		"cron"	=> true,
		"prix_res"	=>	array(R2_FER => 2, R2_CHARBON => 2),
		"need_src"	=>	array(S2_ACIER),
		"need_btc"	=>	B2_FONDERIE
		);
		
$this->res[R2_MITHRIL] = array("dummy" => true);
				
$this->res[R2_A_CUIR] = array(
		"prix_res"	=>	array(R2_BOIS => 1),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	10,
		);
		
$this->res[R2_A_CLOUT] = array(
		"prix_res"	=>	array(R2_BOIS => 2,R2_CHARBON => 1, R2_FER => 1),
		"need_src"	=>	array(S2_DEFENSE_2),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	10,
		);
	
$this->res[R2_EPEE] = array(
		"prix_res"	=>	array(R2_BOIS => 2), 
		"need_src"	=>	array(S2_EPEES),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	12,
		);
	
$this->res[R2_HACHE] = array(
		"prix_res"	=>	array(R2_ACIER => 2,R2_CHARBON => 1,R2_FER => 1),
		"need_src"	=>	array(S2_HACHES),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	12,
		);

$this->res[R2_ARC] = array(
		"prix_res"	=>	array(R2_BOIS => 3),
		"need_src"	=>	array(S2_ARCS),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	14,
		);
		
$this->res[R2_LANCE] = array(
		"prix_res"	=>	array(R2_BOIS => 1,R2_ACIER => 2,R2_CHARBON => 1,R2_FER => 1),
		"need_src"	=>	array(S2_LANCES),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	14,
		);
	
$this->res[R2_A_ACIER] = array(
		"prix_res"	=>	array(R2_ACIER => 3),
		"need_src"	=>	array(S2_DEFENSE_3),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	16,
		);

$this->res[R2_A_MITHRIL] = array(
		"prix_res"	=>	array(R2_MITHRIL => 1),
		"need_src"	=>	array(S2_DEFENSE_3),
		"need_btc"	=>	B2_FORGE,
		"group"		=>	17,
		);
//</res>

//<trn>
$this->trn[T2_FORET] = array();
$this->trn[T2_GIS_FER] = array();
$this->trn[T2_GIS_CHARBON] = array();
$this->trn[T2_FILON_OR] = array();
$this->trn[T2_MONTAGNE] = array();
//</trn>

//<btc>
$this->btc[B2_REPAIRE] = array(
		"bonus" 	=> array('gen' => 250, 'bon' => 3),
		"vie"			=>	500,
		"prod_pop"	=>	10,
		"limite" 		=>	2,
		"tours"		=>	500,
		"prix_res"		=>	array(R2_BOIS => 950, R2_PIERRE => 1125, R2_ACIER => 100),
		"prod_src"	=>	true,
		"prod_unt"	=>	4
);

$this->btc[B2_CARRIERE] = array(
		"vie"		=>	200,
		"prix_res"		=>	array(R2_BOIS => 4, R2_PIERRE => 8),
		"prix_trn"		=>	array(T2_MONTAGNE => 1),
		"tours"		=>	4,
		"need_btc"	=>	array(B2_REPAIRE),
		"prix_unt"		=>	array(U2_GOB_MINEUR => 1),
		"prod_res_auto"	=>	array(R2_PIERRE => 1),
);

$this->btc[B2_SCIERIE] = array(
		"vie"		=>	200,
		"prix_res"		=>	array(R2_BOIS => 8, R2_PIERRE => 4),
		"prix_trn"		=>	array(T2_FORET => 1),
		"tours"		=>	5,
		"need_btc"	=>	array(B2_REPAIRE),
		"prix_unt"		=>	array(U2_GOB_BUCHERON => 1),
		"prod_res_auto"	=>	array(R2_BOIS => 1),
);

//hutte		
$this->btc[B2_HUTTE] = array(
		"vie"			=>	250,
		"prix_res"		=>	array(R2_BOIS => 12, R2_PIERRE => 15),
		"tours"		=>	6,
		"need_btc"	=>	array(B2_CARRIERE, B2_SCIERIE),
		"prod_pop"	=>	10,
		"limite"	=>	57,
);

$this->btc[B2_M_CHASSE] = array(
		"vie"			=>	250,
		"prix_res"		=>	array(R2_BOIS => 12,R2_PIERRE => 15),
		"tours"		=>	7,
		"need_btc"	=>	array(B2_CARRIERE, B2_SCIERIE),
		"prod_res_auto"	=>	array(R2_VIANDE => 10),
		"prix_unt"		=>	array(U2_GOB_CHASSEUR => 1),
		"limite"		=>	70,
);

$this->btc[B2_AIRE_ENTRE] = array(
		"vie"			=>	500,
		"limite"	=>	5,
		"prix_res"		=>	array(R2_BOIS => 45, R2_PIERRE => 45),
		"tours"		=>	30,
		"prix_unt"		=>	array(U2_TETE => 1),
		"need_src"	=>	array(S2_ARMEE_1),
		"prod_unt"	=>	true,
);
	
$this->btc[B2_MINE_OR] = array(
		"vie"			=>	200,
		"tours"		=>	30,
		"need_src"	=>	array(S2_MINE_1),
		"prod_res_auto"=>	array(R2_OR => 1),
		"prix_res"		=>	array(R2_BOIS => 45,R2_PIERRE => 45),
		"prix_trn"		=>	array(T2_FILON_OR => 1),
		"prix_unt"		=>	array(U2_GOB_MINEUR => 1),
);

$this->btc[B2_MARCHE] = array(
		"vie"			=>	400,
		"tours"		=>	100,
		"need_src" 	=>	array(S2_COMMERCE_1),
		"prix_res"		=>	array(R2_BOIS => 120, R2_PIERRE => 100),
		"prix_unt"		=>	array(U2_GOB => 1),
		"limite"		=>	2,
		"com"	=>	array(
					S2_COMMERCE_1 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
					S2_COMMERCE_2 => array(COM_MAX_NB2,COM_MAX_VENTES2)
					)
);

$this->btc[B2_FORGE] = array(
		"vie"			=>	500,
		"tours"		=>	150,
		"need_src"	=>	array(S2_ARMEE_2),
		"prix_res"		=>	array(R2_BOIS => 200, R2_PIERRE => 180),
		"prix_unt"		=>	array(U2_GOB_MINEUR => 1, U2_GOB_FORGERON => 1),
		"need_btc"	=>	array(B2_AIRE_ENTRE ,B2_MINE_OR),
		"prod_res"	=>	true,
);

$this->btc[B2_MINE_CHARBON] = array(
		"vie"			=>	200,
		"tours"		=>	100,
		"need_src"	=>	array(S2_MINE_2),
		"prod_res_auto"=>	array(R2_CHARBON => 1),
		"prix_res"		=>	array(R2_BOIS => 60,R2_PIERRE => 50),
		"prix_trn"		=>	array(T2_GIS_CHARBON => 1),
		"prix_unt"		=>	array(U2_GOB_MINEUR => 1),
);

$this->btc[B2_MINE_FER] = array(
		"vie"			=>	200,
		"tours"		=>	100,
		"need_src"	=>	array(S2_MINE_2),
		"prod_res_auto"=>	array(R2_FER => 1),
		"prix_res"		=>	array(R2_BOIS => 60,R2_PIERRE => 50),
		"prix_trn"		=>	array(T2_GIS_FER => 1),
		"prix_unt"		=>	array(U2_GOB_MINEUR => 1),
);

$this->btc[B2_FONDERIE] = array(
		"vie"			=>	500,
		"tours"		=>	250,
		"prod_res_auto"=>	array(R2_ACIER => 1),
		"prix_res"		=>	array(R2_BOIS => 250,R2_PIERRE => 280),
		"need_src" 	=>	array(S2_ACIER),
		"need_btc"	=>	array(B2_FORGE),
		"prix_unt"		=>	array(U2_GOB_FORGERON => 1),
);

$this->btc[B2_ATELIER] = array(
		"vie"			=>	500,
		"tours"		=>	400,
		"need_src"	=>	array(S2_MACHINES),
		"prix_res"		=>	array(R2_BOIS => 550, R2_PIERRE => 510),
		"prix_unt"		=>	array(U2_GOB_FORGERON => 1,U2_GOB_BUCHERON => 1,U2_TETE => 1),
		"prod_unt"	=>	true
);

$this->btc[B2_TANIERE] = array(
		"vie"		=>	500,
		"tours"		=>	400,
		"need_src"	=>	array(S2_ELEVAGE),
		"prix_res"		=>	array(R2_BOIS => 330, R2_PIERRE => 330),
		"prix_unt"		=>	array(U2_GOB_CHASSEUR => 1),
		"prod_res"	=>	true,
);

$this->btc[B2_TOURS] = array(
		"vie"			=>	800,
		"tours"		=>	100,
		"need_src"	=>	array(S2_DEFENSE_3),
		"prix_res"		=>	array(R2_BOIS => 250, R2_PIERRE => 300, R2_ACIER => 20),
		"need_btc"	=>	array(B2_FONDERIE),
		"prix_unt"		=>	array(U2_ARCHER => 4),
		"limite"		=> 4,
		"bonus" 	=> array('bon' => 2.5),
);

$this->btc[B2_TOTEM] = array(
		"vie"			=>  250,
		"limite"	=>	5,
		"prix_res"		=>	array(R2_BOIS => 100, R2_PIERRE => 100, R2_OR => 100, R2_VIANDE => 500),
		"tours"		=>	400,
		"need_btc" 	=>	array(B2_TANIERE),
		"prod_unt"	=>	true,
);

$this->btc[B2_GARDE_MANGER] = array(
		"vie"			=>  350,
		"limite"	=>	1,
		"prix_res"		=>	array(R2_BOIS => 160, R2_PIERRE => 180, R2_OR => 150, R2_VIANDE => 750),
		"tours"		=>	400,
		"need_btc"	=>	array(B2_TOTEM),
		"prod_unt"	=>	true,
);

$this->btc[B2_FORTIN] = array(
		"bonus" 	=> array('gen' => 250, 'bon' => 12.5),
		"prod_pop" 	=>	110,
		"vie"			=>	4000,
		"prix_unt"		=>	array(U2_CHAMP_ARCHER => 10),
		"prix_res"		=>	array(R2_BOIS => 3800, R2_PIERRE => 4500, R2_ACIER => 400),
		"tours"		=>	2000,
		"need_btc" 	=>	array(B2_GARDE_MANGER),
		"limite"		=> 	1,
		"prod_unt"	=>	4,
		"prod_src"	=>	true
);
//</btc>

//*******************************//
// Unites                       //
//*******************************//
//<unt>
$this->unt[U2_GOB] = array(
		"prix_res"		=>	array(R2_OR => 1, R2_VIANDE => 1),
		"vie"			=>	1,
		"need_btc"	=>	array(B2_REPAIRE),
		"in_btc"		=>	array(B2_REPAIRE,B2_FORTIN),
		"group"		=>	1,
		"role"		=>	TYPE_UNT_CIVIL,
);

$this->unt[U2_GOB_CHASSEUR] = array(
		"prix_res"		=>	array(R2_OR => 1, R2_VIANDE => 1),
		"vie"			=>	1,
		"need_btc"	=>	array(B2_REPAIRE),
		"in_btc"		=>	array(B2_REPAIRE,B2_FORTIN),
		"group"		=>	1,
		"role"		=>	TYPE_UNT_CIVIL,
);		

$this->unt[U2_GOB_FORGERON] = array(
		"prix_res"		=>	array(R2_OR => 2, R2_VIANDE => 1),
		"vie"			=>	1,
		"need_btc"	=>	array(B2_REPAIRE),
		"in_btc"		=>	array(B2_REPAIRE,B2_FORTIN),
		"group"		=>	3,
		"role"		=>	TYPE_UNT_CIVIL,
);		

$this->unt[U2_GOB_BUCHERON] = array(
		"prix_res"		=>	array(R2_OR => 1, R2_VIANDE => 1),
		"vie"			=>	1,
		"need_btc"	=>	array(B2_REPAIRE),
		"in_btc"		=>	array(B2_REPAIRE,B2_FORTIN),
		"group"		=>	3,
		"role"		=>	TYPE_UNT_CIVIL,
);		

$this->unt[U2_GOB_MINEUR] = array(
		"prix_res"		=>	array(R2_OR => 1, R2_VIANDE => 1),
		"vie"			=>	1,
		"need_btc"	=>	array(B2_REPAIRE),
		"in_btc"		=>	array(B2_REPAIRE,B2_FORTIN),
		"group"		=>	5,
		"role"		=>	TYPE_UNT_CIVIL,
);		

$this->unt[U2_TETE] = array(
		"prix_res"		=>	array(R2_OR => 2, R2_VIANDE => 1),
		"vie"			=>	1,
		"need_btc"	=>	array(B2_REPAIRE),
		"in_btc"		=>	array(B2_REPAIRE,B2_FORTIN),
		"group"		=>	6,
		"role"		=>	TYPE_UNT_CIVIL,
);		

$this->unt[U2_SOLDAT] = array(
		"def"	=>	1,
		"vie"		=>	12,
		"atq_unt"	=>	2,
		"vit"		=>	8,
//		"prix_res"		=>	array(R2_OR => 1,R2_BOIS => 1,R2_VIANDE => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"		=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	7,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 1,
);

$this->unt[U2_TRANCHEUR] = array(
		"def"	=>	4,
		"vie"		=>	14,
		"atq_unt"	=>	7,
		"vit"		=>	10,
		"need_src" 	=> 	array(S2_DEFENSE_1),
		"prix_res"		=>	array(R2_A_CUIR => 1,R2_EPEE => 1,R2_VIANDE => 1),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	8,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 2,
);

$this->unt[U2_EPEISTE] = array(
		"def"	=>	7,
		"vie"		=>	17,
		"atq_unt"	=>	11,
		"vit"		=>	9,
		"need_src" 	=> 	array(S2_DEFENSE_2),
		"prix_res"		=>	array(R2_A_CLOUT => 1,R2_EPEE => 1,R2_VIANDE => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	8,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 3,
);

$this->unt[U2_CHAMP_EPEISE] = array(
		"def"	=>	15,
		"vie"		=>18,
		"atq_unt"	=>	22,
		"vit"		=>	8,
		"need_src" 	=> 	array(S2_DEFENSE_3),
		"prix_res"		=>	array(R2_A_ACIER => 1,R2_EPEE => 1,R2_VIANDE => 5,R2_OR => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	8,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 7,
);

$this->unt[U2_TIREUR] = array(
		"def"	=>	3,
		"vie"		=>	15,
		"atq_unt"	=>	8,
		"vit"		=>	6,
		"need_src" 	=> 	array(S2_DEFENSE_1),
		"prix_res"		=>	array(R2_A_CUIR => 1,R2_ARC => 1,R2_VIANDE => 1),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	11,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 13,
);

$this->unt[U2_ARCHER] = array(
		"def"	=>	6,
		"vie"		=>	16,
		"atq_unt"	=>	12,
		"vit"		=>	7,
		"need_src" 	=> 	array(S2_DEFENSE_2),
		"prix_res"		=>	array(R2_A_CLOUT => 1,R2_ARC => 1,R2_VIANDE => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	11,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 12,
);

$this->unt[U2_CHAMP_ARCHER] = array(
		"def"	=>	10,
		"vie"		=>	13,
		"atq_unt"	=>	15,
		"vit"		=>	8,
		"bonus" => array('vie' => 1),
		"need_src" 	=> 	array(S2_DEFENSE_3),
		"prix_res"		=>	array(R2_A_ACIER => 1,R2_ARC => 1,R2_VIANDE => 5,R2_OR => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	11,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 17,
);

$this->unt[U2_PERCEUR] = array(
		"def"	=>	7,
		"vie"		=>	17,
		"atq_unt"	=>	6,
		"vit"		=>	4,
		"need_src" 	=> 	array(S2_DEFENSE_1),
		"prix_res"		=>	array(R2_A_CUIR => 1,R2_LANCE => 1,R2_VIANDE => 1),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	14,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 15,
);

$this->unt[U2_LANCIER] = array(
		"def"	=>	12,
		"vie"		=>	15,
		"atq_unt"	=>	10,
		"vit"		=>	6,
		"need_src" 	=> 	array(S2_DEFENSE_2),
		"prix_res"		=>	array(R2_A_CLOUT => 1,R2_LANCE => 1,R2_VIANDE => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	14,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 14,
);

$this->unt[U2_CHAMP_LANCIER] = array(
		"def"	=>	15,
		"vie"		=>	14,
		"atq_unt"	=>	10,
		"vit"		=>	8,
		"bonus" => array('vie' => 1),
		"need_src" 	=> 	array(S2_DEFENSE_3),
		"prix_res"		=>	array(R2_A_ACIER => 1,R2_LANCE => 1,R2_VIANDE => 5,R2_OR => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	14,
		"role"		=>	TYPE_UNT_DISTANCE,
		"rang" => 16,
);

$this->unt[U2_FENDEUR] = array(
		"def"	=>	5,
		"vie"		=>	13,
		"atq_unt"	=>	8,
		"vit"		=>	6,
		"need_src" 	=> array(S2_DEFENSE_1),
		"prix_res"		=>	array(R2_A_CUIR => 1,R2_HACHE => 1,R2_VIANDE => 1),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	17,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 4,
);

$this->unt[U2_PORTE_HACHE] = array(
		"def"	=>	9,
		"vie"		=>	13,
		"atq_unt"	=>	13,
		"vit"		=>	8,
		"need_src" 	=> 	array(S2_DEFENSE_2),
		"prix_res"		=>	array(R2_A_CLOUT => 1,R2_HACHE => 1,R2_VIANDE => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	17,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 5,
);

$this->unt[U2_CHAMP_PORTE_HACHE] = array(
		"def"	=>	22,
		"vie"		=>	26,
		"atq_unt"	=>	17,
		"vit"		=>	6,
		"need_src" 	=> 	array(S2_DEFENSE_3),
		"prix_res"		=>	array(R2_A_ACIER => 1,R2_HACHE => 1,R2_VIANDE => 5),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	17,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 6,
);

$this->unt[U2_DRESSEUR] = array(
		"def"	=>	6,
		"vie"		=>	12,
		"atq_unt"	=>	10,
		"vit"		=>	14,
		"need_src" 	=> 	array(S2_DEFENSE_1),
		"prix_res"		=>	array(R2_A_CUIR => 1,R2_HACHE => 1,R2_LOUPS_GEANTS => 1,R2_VIANDE => 1),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	20,
		"role"		=>	TYPE_UNT_CAVALERIE,
		"rang" => 9,
);

$this->unt[U2_CAVALIER] = array(
		"def"	=>	12,
		"vie"		=>	15,
		"atq_unt"	=>	14,
		"vit"		=>	16,
		"need_src" 	=> 	array(S2_DEFENSE_2),
		"prix_res"		=>	array(R2_A_CLOUT => 1,R2_HACHE => 1,R2_VIANDE => 2,R2_LOUPS_GEANTS => 1),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	20,
		"role"		=>	TYPE_UNT_CAVALERIE,
		"rang" => 10,
);

$this->unt[U2_CHEVAUCHEUR] = array(
		"def"	=>	20,
		"vie"		=>	20,
		"atq_unt"	=>	24,
		"vit"		=>	13,
		"need_src" 	=> 	array(S2_DEFENSE_3),
		"prix_res"		=>	array(R2_A_ACIER => 1,R2_HACHE => 1,R2_VIANDE => 5,R2_LOUPS_GEANTS => 1,R2_OR => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	20,
		"role"		=>	TYPE_UNT_CAVALERIE,
		"rang" => 11,
);

$this->unt[U2_CATAPULE] = array(
		"def"	=>	10,
		"vie"		=>	14,
		"atq_unt"	=>	14,
		"atq_btc"	=>	7,
		"vit"		=>	2,
		"prix_res"		=>	array(R2_PIERRE => 10,R2_BOIS => 10,R2_ACIER => 5),
		"need_btc"	=>	array(B2_ATELIER),
		"in_btc"	=>	array(B2_ATELIER),
		"prix_unt"	=>	array(U2_TETE => 2),
		"group"		=>	23,
		"role"		=>	TYPE_UNT_MACHINE,
		"rang" => 20,
);

$this->unt[U2_BALISTE] = array(
		"def"	=>	8,
		"vie"		=>	12,
		"atq_unt"	=>	10,
		"atq_btc"	=>	9,
		"vit"		=>	6,
		"prix_res"		=>	array(R2_PIERRE => 10,R2_BOIS => 10,R2_ACIER => 8),
		"need_btc"	=>	array(B2_ATELIER),
		"in_btc"	=>	array(B2_ATELIER),
		"prix_unt"	=>	array(U2_TETE => 2),
		"group"		=>	24,
		"role"		=>	TYPE_UNT_MACHINE,
		"rang" => 21,
);

$this->unt[U2_BELIER] = array(
		"def"	=>	8,
		"vie"		=>	12,
		"atq_unt"	=>	0,
		"atq_btc"	=>	10,
		"vit"		=>	6,
		"prix_res"		=>	array(R2_PIERRE => 7,R2_BOIS => 7,R2_ACIER => 4),
		"need_btc"	=>	array(B2_ATELIER),
		"in_btc"	=>	array(B2_ATELIER),
		"prix_unt"	=>	array(U2_TETE => 3),
		"group"		=>	25,
		"role"		=>	TYPE_UNT_MACHINE,
		"rang" => 22,
);

$this->unt[U2_BELIER_BRISE_CRANE] = array(
		"def"	=>	15,
		"vie"		=>	15,
		"atq_unt"	=>	10,
		"atq_btc"	=>	12,
		"vit"		=>	4,
		"prix_res"		=>	array(R2_PIERRE => 75,R2_BOIS => 75,R2_ACIER => 15),
		"need_btc"	=>	array(B2_ATELIER),
		"in_btc"	=>	array(B2_ATELIER),
		"prix_unt"	=>	array(U2_TETE => 5),
		"group"		=>	25,
		"role"		=>	TYPE_UNT_MACHINE,
		"rang" => 23,
);

$this->unt[U2_SHAMAN] = array(
		"def"	=>	12,
		"bonus"		=> 	array('def' => 1),
		"vie"		=>	12,
		"atq_unt"	=>	9,
		"vit"		=>	9,
		"need_src"	=>	array(S2_SHAMANS),
		"prix_res"		=>	array(R2_VIANDE => 100,R2_OR => 5,R2_MITHRIL => 1),
		"need_btc"	=>	array(B2_TOTEM),
		"in_btc"	=>	array(B2_TOTEM),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	27,
		"role"		=>	TYPE_UNT_MAGIQUE,
		"rang" => 18,
);

$this->unt[U2_COGNEUR] = array(
		"def"	=>	9,
		"bonus"		=> 	array('atq' => 1),
		"vie"		=>	12,
		"atq_unt"	=>	12,
		"vit"		=>	9,
		"prix_res"		=>	array(R2_VIANDE => 100,R2_OR => 5,R2_MITHRIL => 1),
		"need_btc"	=>	array(B2_TOTEM),
		"in_btc"	=>	array(B2_TOTEM),
		"need_src"	=>	array(S2_COGNEURS),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	28,
		"role"		=>	TYPE_UNT_MAGIQUE,
		"rang" => 19,
);

$this->unt[U2_BERSERKER] = array(
		"def"	=>	15,
		"vie"		=>	17,
		"atq_unt"	=>	31,
		"vit"		=>	11,
		"need_src" 	=> 	array(S2_BERSERKER),
		"prix_res"		=>	array(R2_A_ACIER => 1,R2_HACHE => 2,R2_VIANDE => 20, R2_ACIER => 2),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"in_btc"	=>	array(B2_AIRE_ENTRE),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	30,
		"role"		=>	TYPE_UNT_INFANTERIE,
		"rang" => 8,
);

$this->unt[U2_TROLL] = array(
		"def"	=>	130,
		"vie"		=>	136,
		"atq_unt"	=>	70,
		"vit"		=>	12,
		"need_src" 	=> 	array(S2_TROLLS),
		"prix_res"		=>	array(R2_A_MITHRIL => 1,R2_HACHE => 2,R2_VIANDE => 60),
		"need_btc"	=>	array(B2_GARDE_MANGER),
		"in_btc"	=>	array(B2_GARDE_MANGER),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	29,
		"role"		=>	TYPE_UNT_HEROS,
		"rang" => 24,
);

$this->unt[U2_PORTE_ETENDARD] = array(
		"def"	=>	90,
		"vie"		=>	130,
		"atq_unt"	=>	110,
		"atq_btc"	=>	25,
		"vit"		=>	10,
		"need_src" 	=> 	array(S2_ETENDARDS),
		"prix_res"		=>	array(R2_A_MITHRIL => 1,R2_HACHE => 2,R2_VIANDE => 60),
		"need_btc"	=>	array(B2_GARDE_MANGER),
		"in_btc"	=>	array(B2_GARDE_MANGER),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	29,
		"role"		=>	TYPE_UNT_HEROS,
		"rang" => 25,
);

$this->unt[U2_SEIGNEUR_ORC_SUR_SANGLIER] = array(
		"def"	=>	40,
		"vie"		=>	134,
		"atq_unt"	=>	170,
		"vit"		=>	14,
		"need_src" 	=> 	array(S2_SANGLIER),
		"prix_res"		=>	array(R2_A_MITHRIL => 1,R2_HACHE => 2,R2_VIANDE => 60),
		"need_btc"	=>	array(B2_GARDE_MANGER),
		"in_btc"	=>	array(B2_GARDE_MANGER),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	29,
		"role"		=>	TYPE_UNT_HEROS,
		"rang" => 26,
);

$this->unt[U2_BALUCHON] = array(

		"vit"		=>	14,
		"need_src" 	=> 	array(S2_MEUTE),
		//"prix_res"		=>	array(R2_A_MITHRIL => 400,R2_PIERRE => 450,R2_BOIS => 450,R2_VIANDE =>10000, R2_OR => 1000),
		"prix_res"		=>	array(R2_A_MITHRIL => 200,R2_PIERRE => 225,R2_BOIS => 220,R2_VIANDE =>5000, R2_OR => 500),
		"need_btc"	=>	array(B2_ATELIER),
		"in_btc"	=>	array(B2_ATELIER),
		"prix_unt"	=>	array(U2_TETE => 1),
		"group"		=>	29,
		"role"		=>	TYPE_UNT_DEMENAGEMENT,
		"rang" => 26,
);
//</unt>

//<src>
$this->src[S2_EPEES] = array(
		"tours"		=>	10,
		"prix_res"		=>	array(R2_BOIS => 20),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"group"		=>	1,
);

$this->src[S2_HACHES] = array(
		"tours"		=>	20,
		"prix_res"		=>	array(R2_CHARBON => 75, R2_FER=> 75, R2_PIERRE => 50, R2_ACIER => 25),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"group"		=>	1,
);

$this->src[S2_ARCS] = array(
		"tours"		=>	30,
		"prix_res"		=>	array(R2_CHARBON => 75, R2_FER=> 75, R2_PIERRE => 25, R2_BOIS => 25, R2_ACIER => 25),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"group"		=>	1,
);

$this->src[S2_LANCES] = array(
		"tours"		=>	20,
		"prix_res"		=>	array(R2_CHARBON => 75, R2_FER=> 75, R2_PIERRE => 50, R2_ACIER => 25),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"group"		=>	1,
);

$this->src[S2_DEFENSE_1] = array(
		"tours"		=>	10,
		"prix_res"		=>	array(R2_BOIS => 20),
		"need_btc"	=>	array(B2_AIRE_ENTRE),
		"group"		=>	5,
);

$this->src[S2_DEFENSE_2] = array(
		"tours"		=>	15,
		"prix_res"		=>	array(R2_OR => 20, R2_FER => 50, R2_CHARBON => 50, R2_BOIS => 30, R2_PIERRE => 20, R2_ACIER => 25),
		"need_btc"	=>	array(B2_FORGE),
		"need_src"	=>	array(S2_ACIER),
		"group"		=>	5,
);

$this->src[S2_DEFENSE_3] = array(
		"tours"		=>	20,
		"need_btc"	=>	array(B2_TANIERE),
		"need_src"	=>	array(S2_ARMEE_3),
		"prix_res"		=>	array(R2_OR => 70, R2_ACIER => 100, R2_BOIS => 200, R2_PIERRE => 200),
		"group"		=>	5,
);

$this->src[S2_ACIER] = array(
		"tours"		=>	15,
		"need_btc"	=>	array(B2_MINE_CHARBON, B2_MINE_FER),
		"prix_res"		=>	array(R2_OR => 50, R2_BOIS => 60, R2_PIERRE => 90, R2_CHARBON => 75, R2_FER => 75),
		"group"		=>	8,
);

$this->src[S2_ELEVAGE] = array(
		"tours"		=>	15,
		"need_src"	=>	array(S2_ACIER),
		"prix_res"		=>	array(R2_VIANDE => 500, R2_ACIER => 25, R2_BOIS => 80, R2_PIERRE => 70),
		"group"		=>	9,
);

$this->src[S2_COMMERCE_1] = array(
		"tours"		=>	8,
		"need_btc"	=>	array(B2_HUTTE, B2_M_CHASSE),
		"prix_res"		=>	array(R2_OR => 50),
		"group"		=>	10,
);

$this->src[S2_COMMERCE_2] = array(
		"tours"		=>	14,
		"need_btc"	=>	array(B2_TANIERE),
		"need_src"	=>	array(S2_COMMERCE_1),
		"prix_res"		=>	array(R2_OR => 200, R2_BOIS => 20, R2_PIERRE => 20, R2_VIANDE => 1000, R2_ACIER => 15),
		"group"		=>	10,
);

$this->src[S2_ARMEE_1] = array(
		"tours"		=>	10,
		"need_btc"	=>	array(B2_HUTTE, B2_M_CHASSE),
		"prix_res"		=>	array(R2_OR => 20, R2_VIANDE => 50, R2_BOIS => 12, R2_VIANDE => 8),
		"group"		=>	12,
);

$this->src[S2_ARMEE_2] = array(
		"tours"		=>	20,
		"need_src"	=>	array(S2_DEFENSE_1),
		"prix_res"		=>	array(R2_OR => 80, R2_BOIS => 60, R2_PIERRE => 40),
		"group"		=>	12,
);

$this->src[S2_ARMEE_3] = array(
		"tours"		=>	30,
		"need_btc"	=>	array(B2_FORGE),
		"need_src"	=>	array(S2_ACIER),
		"prix_res"		=>	array(R2_OR => 180, R2_ACIER => 200, R2_BOIS => 100, R2_PIERRE => 100),
		"group"		=>	12,
);

$this->src[S2_MINE_1] = array(
		"tours"		=>	10,
		"need_btc"	=>	array(B2_HUTTE, B2_M_CHASSE),
		"prix_res"		=>	array(R2_BOIS => 20, R2_PIERRE => 25),
		"group"		=>	15,
);

$this->src[S2_MINE_2] = array(
		"tours"		=>	19,
		"need_btc"	=>	array(B2_AIRE_ENTRE, B2_MINE_OR),
		"prix_res"		=>	array(R2_OR => 30, R2_BOIS => 75, R2_PIERRE => 80),
		"group"		=>	15,
);

$this->src[S2_SHAMANS] = array(
		"tours"		=>	20,
		"need_btc"	=>	array(B2_TOTEM),
		"prix_res"		=>	array(R2_VIANDE => 300, R2_OR => 80, R2_FER => 50),
		"group"		=>	17,
		);

$this->src[S2_COGNEURS] = array(
		"tours"		=>	20,
		"need_btc"	=>	array(B2_TOTEM),
		"prix_res"		=>	array(R2_VIANDE => 300, R2_OR => 100, R2_CHARBON => 50),
		"group"		=>	17,
		);

$this->src[S2_SANGLIER] = array(
		"tours"		=>	40,
		"need_btc"	=>	array(B2_GARDE_MANGER),
		"prix_res"		=>	array(R2_CHARBON => 100,R2_VIANDE => 300, R2_OR => 80, R2_MITHRIL => 20),
		"group"		=>	17,
		);
		
$this->src[S2_MACHINES] = array(
		"tours"		=>	40,
		"need_src"	=>	array(S2_ARMEE_3),
		"prix_res"		=>	array(R2_CHARBON => 50, R2_FER => 50, R2_ACIER => 150, R2_OR => 50),
		"group"		=>	18,
		);

$this->src[S2_MEUTE] = array(
		"tours"		=>	50,
		"need_btc"	=>	array(B2_ATELIER),
		"prix_res"		=>	array(R2_CHARBON => 450,R2_VIANDE => 20000, R2_OR => 1500, R2_MITHRIL => 500),
		"group"		=>	18,
		);

$this->src[S2_ETENDARDS] = array(
		"tours"		=>	50,
		"need_btc"	=>	array(B2_GARDE_MANGER),
		"prix_res"		=>	array(R2_CHARBON => 100,R2_VIANDE => 300, R2_OR => 80, 9 => 20),
		"group"		=>	21,
		);

$this->src[S2_BERSERKER] = array(
		"tours"		=>	50,
		"need_src"	=>	array(S2_SHAMANS, S2_COGNEURS),
		"prix_res"		=>	array(R2_CHARBON => 100,R2_VIANDE => 300, R2_OR => 80, R2_MITHRIL => 20),
		"group"		=>	21,
		);

$this->src[S2_TROLLS] = array(
		"tours"		=>	50,
		"need_btc"	=>	array(B2_GARDE_MANGER),
		"prix_res"		=>	array(R2_FER => 100,R2_VIANDE => 800, R2_OR => 80, R2_MITHRIL => 10),
		"group"		=>	21,
		);	
//</src>	

/* competences du ou des heros ... */

//<comp>
/* ### Off ### */
$this->comp[CP_BOOST_OFF]=array(
	'heros'		=> array(U2_SEIGNEUR_ORC_SUR_SANGLIER),
	'tours'		=> 3,
	'bonus'		=> 10,
	'prix_xp'	=> 40,
	'type'		=> 1
);

$this->comp[CP_RESURECTION]=array(
	'heros'		=> array(U2_SEIGNEUR_ORC_SUR_SANGLIER),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_VOLEE_DE_FLECHES]=array(
	'heros'		=> array(U2_SEIGNEUR_ORC_SUR_SANGLIER),
	'tours'		=> 24,
	'bonus'		=> 5,
	'prix_xp'	=> 50,
	'type'		=> 1
);

$this->comp[CP_REGENERATION_ORC]=array(
	'heros'		=> array(U2_SEIGNEUR_ORC_SUR_SANGLIER),
	'tours'		=> 24,
	'bonus'		=> 100,
	'prix_xp'	=> 50,
	'type'		=> 1
);

/* ### Def ### */

$this->comp[CP_BOOST_DEF]=array(
	'heros'		=> array(U2_TROLL),
	'tours'		=> 8,
	'bonus'		=> 8,
	'prix_xp'	=> 40,
	'type'		=> 2
);

$this->comp[CP_RESISTANCE]=array(
	'heros'		=> array(U2_TROLL),
	'tours'		=> 6,
	'bonus'		=> 15,
	'prix_xp'	=> 60,
	'type'		=> 2
);

$this->comp[CP_REGENERATION]=array(
	'heros'		=> array(U2_TROLL),
	'tours'		=> 24,
	'bonus'		=> 50,
	'prix_xp'	=> 50,
	'type'		=> 2
);

$this->comp[CP_DEFENSE_EPIQUE]=array(
	'heros'		=> array(U2_TROLL),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 2
);

/* ### Sou ### */

$this->comp[CP_CASS_BAT]=array(
	'heros'		=> array(U2_PORTE_ETENDARD),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GENIE_COMMERCIAL]=array(
	'heros'		=> array(U2_PORTE_ETENDARD),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_GUERISON]=array(
	'heros'		=> array(U2_PORTE_ETENDARD),
	'tours'		=> 24,
	'bonus'		=> 10,
	'prix_xp'	=> 50,
	'type'		=> 3
);

$this->comp[CP_INVISIBILITE]=array(
	'heros'		=> array(U2_PORTE_ETENDARD),
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
	'primary_res'	=>	array(R2_OR, R2_VIANDE),
	'second_res'	=>	array(R2_OR, R2_BOIS, R2_PIERRE, R2_VIANDE, R2_FER , R2_CHARBON, R2_ACIER),
	'primary_btc'	=>	array(
		'vil'	=>	array(  B2_REPAIRE => array('unt','src'),
					B2_AIRE_ENTRE => array('unt'),
					B2_FORGE => array('res'),
					B2_ATELIER => array('unt'),
					B2_TANIERE => array('res'),
					B2_TOTEM => array('unt'),
					B2_GARDE_MANGER => array('unt')),
		'ext'	=>	array( B2_MARCHE => array('ach'))),
	'bonus_res'	=>	array(R2_OR => 0.05),
	'modif_pts_btc'	=>	1.1,
	'debut'	=>	array(
		'res'	=>	array(R2_OR => 70, R2_BOIS => 40, R2_PIERRE => 40, R2_VIANDE => 1500),
		'trn'	=>	array(T2_FORET => 2, T2_MONTAGNE => 2, T2_GIS_FER => 3, T2_FILON_OR => 1, T2_GIS_CHARBON => 3),
		'unt'	=> 	array(U2_GOB => 1, U2_SOLDAT => 5),
		'btc'	=> 	array(B2_REPAIRE => array()),
		'src'	=>	array()),
	'bonus_map' => array(MAP_EAU => -5, MAP_LAC => -5, MAP_HERBE => 7, MAP_MONTAGNE => -2, MAP_FORET => -2),
	'bonus_period' => array(PERIODS_JOUR => -8, PERIODS_NUIT => 8, PERIODS_AUBE => -5, PERIODS_CREP => 5),
);

}
}
?>
