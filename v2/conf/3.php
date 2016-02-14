<?php

define("R3_OR", 1);

define("R3_BOIS", 2);

define("R3_PIERRE", 3);

define("R3_CHAMPI", 4);

define("R3_FER", 5);

define("R3_CHARBON", 6);

define("R3_CHEVAUX", 7);

define("R3_ACIER", 8);

define("R3_MITHRIL", 9);

define("R3_MASSUE", 10);

define("R3_MARTEAU", 11);

define("R3_HACHE", 12);

define("R3_HACHE_GUERRE", 13);

define("R3_HACHE_COMBAT", 14);

define("R3_MARTEAU_GUERRE", 15);

define("R3_C_MAILLE", 16);

define("R3_C_MITHRIL", 17);

define("T3_FORET", 1);

define("T3_GIS_FER", 2);

define("T3_GIS_CHARBON", 3);

define("T3_FILON_OR", 4);

define("T3_MONTAGNE", 5);

define("B3_BASTION", 1);

define("B3_CAVERNE", 2);

define("B3_CHAMPI", 3);

define("B3_MINE_PIERRE", 4);

define("B3_MINE_CHARBON", 5);

define("B3_MINE_FER", 6);

define("B3_MINE_OR", 7);

define("B3_MARCHE", 8);

define("B3_FONDERIE", 9);

define("B3_CASERNE", 10);

define("B3_ECOLE_MILITAIRE", 11);

define("B3_HAUT_FOURNEAU", 12);

define("B3_FONDERIE_MITHRIL", 13);

define("B3_ARMURERIE", 14);

define("B3_ATELIER", 15);

define("B3_MANUFACTURE", 16);

define("B3_TOURS", 17);

define("B3_TEMPLE", 18);

define("B3_ECOLE_RUNIQUE", 19);

define("B3_HALL", 20);

define("B3_CITADELLE", 21);

define("U3_BATISSEUR", 1);

define("U3_CUEILLEUR", 2);

define("U3_MINEUR", 3);

define("U3_FORGERON", 4);

define("U3_ARTISAN", 5);

define("U3_INGENIEUR", 6);

define("U3_RECRUE", 7);

define("U3_VETERAN", 8);

define("U3_CHAMPION", 9);

define("U3_ECLAIREUR", 10);

define("U3_MILICIEN", 11);

define("U3_COMBATTANT", 12);

define("U3_DEFENSEUR", 13);

define("U3_GUERRIER", 14);

define("U3_PROTECTEUR", 15);

define("U3_P_MURANG", 16);

define("U3_P_TRARKOS", 17);

define("U3_GRAVEUR_R", 18);

define("U3_LANCEUR_R", 19);

define("U3_CATAPULTE", 20);

define("U3_BELIER", 21);

define("U3_BELIER_TETE_MORT", 22);

define("U3_BALISTE", 23);

define("U3_TRANSPORT", 24);

define("U3_GOLEM", 25);

define("U3_TAUREN", 26);

define("U3_SEIGNEUR_DE_GUERRE", 27);
define("U3_TRANSPORT_RUNIQUE", 28);

define("S3_MINE_1", 1);

define("S3_MINE_2", 2);

define("S3_COMMERCE_1", 3);

define("S3_COMMERCE_2", 4);

define("S3_COMMERCE_3", 5);

define("S3_FONTE_ACIER", 6);

define("S3_TRAVAIL_ACIER", 7);

define("S3_FONTE_MITHRIL", 8);

define("S3_MECANISME_SIMPLE", 9);

define("S3_MECANISME_COMPLEXES", 10);

define("S3_FORTIFICATION", 11);

define("S3_GRAVURE_RUNIQUE", 12);

define("S3_ECRITURE_RUNIQUE", 13);

define("S3_CHASSEUR", 14);

define("S3_COMBATTANTS", 15);

define("S3_GUERRIERS", 16);

define("S3_ARME_1", 17);

define("S3_ARME_2", 18);

define("S3_ARMURE_1", 19);

define("S3_ARMURE_2", 20);

define("S3_MACHINE_1", 21);

define("S3_MACHINE_2", 22);

define("S3_MACHINE_3", 23);

define("S3_TRARKOS", 25);

define("S3_MURANG", 24);

define("S3_GOLEM", 26);

define("S3_DRUIDISME", 27);

define("S3_SEIGNEUR", 28);
define("S3_RUNE_VOYAGE", 29);

class config3

{

var $res = array();

var $trn = array();

var $btc = array();

var $unt = array();

var $src = array();

var $comp = array();

var $race_cfg = array();

function config3()

{

//<res>

$this->res=array();

$this->res[R3_OR] = array(

                "cron"        => true,

                "need_btc"        =>        B3_MINE_OR);

$this->res[R3_BOIS] = array("dummy" => true);

$this->res[R3_PIERRE] = array(

                "cron"        => true,

                "need_btc"        =>        B3_MINE_PIERRE);

$this->res[R3_CHAMPI] = array(

                "cron"        => true,

                "need_btc"        =>        B3_CHAMPI);

$this->res[R3_FER] = array(

                "cron"        => true,

                "need_btc"        =>        B3_MINE_FER);

$this->res[R3_CHARBON] = array(

                "cron"        => true,

                "need_btc"        =>        B3_MINE_CHARBON);

$this->res[R3_CHEVAUX]= array("dummy" => true);

$this->res[R3_ACIER]=array(

                "cron"        => true,

                "prix_res"        =>        array(R3_CHARBON => 1,R3_FER => 1),

                "need_btc"        =>        B3_FONDERIE

                );

$this->res[R3_MITHRIL]=array(

                "cron"        => true,

                "prix_res"        =>        array(R3_ACIER => 2,R3_OR => 1),

                "need_btc"        =>        B3_FONDERIE_MITHRIL

                );

$this->res[R3_MASSUE]=array(

                "prix_res"        =>        array(R3_PIERRE => 2),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        10,

                );

                

$this->res[R3_MARTEAU]=array(

                "prix_res"        =>        array(R3_ACIER => 2),

                "need_src"        =>        array(S3_ARME_1),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        10,

                );

        

//hache

$this->res[R3_HACHE]=array(

                "prix_res"        =>        array(R3_PIERRE => 2),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        12,

                );

        

//hache de guerre

$this->res[R3_HACHE_GUERRE]=array(

                "prix_res"        =>        array(R3_ACIER => 4),

                "need_src"        =>        array(S3_ARME_2),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        12,

                );

//hache de combat

$this->res[R3_HACHE_COMBAT]=array(

                "prix_res"        =>        array(R3_ACIER => 2),

                "need_src"        =>        array(S3_ARME_1),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        12,

                );

                

//marteau de guerre

$this->res[R3_MARTEAU_GUERRE]=array(

                "prix_res"        =>        array(R3_ACIER => 4),

                "need_src"        =>        array(S3_ARME_2),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        15,

                );

        

//cote de mailles

$this->res[R3_C_MAILLE]=array(

                "prix_res"        =>        array(R3_ACIER => 3),

                "need_src"        =>        array(S3_ARMURE_1),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        16,

                );

                

//cote de mithril

$this->res[R3_C_MITHRIL]=array(

                "prix_res"        =>        array(R3_MITHRIL => 1),

                "need_src"        =>        array(S3_ARMURE_2),

                "need_btc"        =>        B3_ARMURERIE,

                "group"                =>        16,

                );

//</res>

//<trn>

$this->trn[T3_FORET] = array();

$this->trn[T3_GIS_FER] = array();

$this->trn[T3_GIS_CHARBON] = array();

$this->trn[T3_FILON_OR] = array();

$this->trn[T3_MONTAGNE] = array();

//</trn>

//<btc>

$this->btc[B3_BASTION]=array(

                "bonus"         => array('gen' => 500, 'bon' => 5),

                "vie"                        =>        1000,

                "prod_pop"        =>        35,

                "limite"                =>        1,

                "tours"                =>        500,

                "prix_res"                => array(R3_BOIS => 750, R3_PIERRE => 3750, R3_ACIER => 150, R3_MITHRIL => 30),

                "prod_src"        => true,

                "prod_unt"        => 4,

                );

//Caverne,

$this->btc[B3_CAVERNE]=array(

                "vie"                        =>        175,

                "prix_res"                =>        array(R3_PIERRE => 20),

                "tours"                =>        20,

                "need_btc"        =>        array(B3_BASTION),

                "prod_pop"        =>        5,

                "limite"                =>        115,

                );

//Champignonni�e,                

$this->btc[B3_CHAMPI]=array(

                "vie"                        =>        150,

                "prix_res"                =>        array(R3_PIERRE => 25),

                "tours"                =>        7,

                "need_btc"        =>        array(B3_BASTION),

                "prod_res_auto"        =>        array(R3_CHAMPI => 7),

                "prix_unt"                =>        array(U3_CUEILLEUR => 1),

                "limite"                =>        100,

                );

//Mine de pierre,

$this->btc[B3_MINE_PIERRE]=array(

                "vie"                        =>        300,

                "tours"                =>        20,

                "need_src"        =>        array(S3_MINE_1),

                "prod_res_auto"        =>        array(R3_PIERRE => 3),

                "prix_res"                =>        array(R3_PIERRE => 50),

                "prix_trn"                =>        array(T3_MONTAGNE => 1),

                "prix_unt"                =>        array(U3_MINEUR => 1),

);

                

//Mine de charbon,

$this->btc[B3_MINE_CHARBON]=array(

                "vie"                        =>        350,

                "tours"                =>        60,

                "need_src"        =>        array(S3_MINE_1),

                "prod_res_auto"        =>        array(R3_CHARBON => 2),

                "prix_res"                =>        array(R3_PIERRE => 80, R3_OR => 10),

                "prix_trn"                =>        array(T3_GIS_CHARBON => 1),

                "prix_unt"                =>        array(U3_MINEUR => 1),

);

//Mine de fer,

$this->btc[B3_MINE_FER]=array(

                "vie"                =>        350,

                "tours"                =>        60,

                "need_src"        =>        array(S3_MINE_1),

                "prod_res_auto"        =>        array(R3_FER => 2),

                "prix_res"                =>        array(R3_PIERRE => 80, R3_OR => 10),

                "prix_trn"                =>        array(T3_GIS_FER => 1),

                "prix_unt"                =>        array(U3_MINEUR => 1),

);

//Mine d'or,

$this->btc[B3_MINE_OR]=array(

                "vie"                        =>        400,

                "tours"                =>        80,

                "need_src"        =>        array(S3_MINE_2),

                "prod_res_auto"        =>        array(R3_OR => 3),

                "prix_res"                =>        array(R3_PIERRE => 100),

                "prix_unt"                =>        array(U3_MINEUR => 1),

                "prix_trn"      =>      array(T3_FILON_OR => 1)

);

        

//March�

$this->btc[B3_MARCHE]=array(

                "vie"                        =>        600,

                "tours"                =>        150,

                "need_src"         => array(S3_COMMERCE_1),

                "prix_res"                =>        array(R3_PIERRE => 200, R3_OR => 40),

                "prix_unt"                =>        array(U3_CUEILLEUR => 2),

                "limite"                =>        2,

                "com"         => array(S3_COMMERCE_1 => array(COM_MAX_NB1,COM_MAX_VENTES1), 

                                                S3_COMMERCE_2 => array(COM_MAX_NB2,COM_MAX_VENTES2),

                                                S3_COMMERCE_3 => array(COM_MAX_NB3,COM_MAX_VENTES3)

                                ),

);

//Fonderie,

$this->btc[B3_FONDERIE]=array(

                "vie"                        =>        600,

                "tours"                =>        150,

                "prod_res_auto"        =>        array(R3_ACIER => 1),

                "prix_res"                =>        array(R3_OR => 100, R3_PIERRE => 300),

                "need_src"         => array(S3_FONTE_ACIER),

                "prix_unt"                =>        array(U3_BATISSEUR => 2, U3_INGENIEUR => 1),

                "limite"                =>        1,

);

                

//Caserne,

$this->btc[B3_CASERNE]=array(

                "vie"                        =>        650,

                "prix_res"                =>        array(R3_BOIS => 20, R3_PIERRE => 150, R3_OR => 20),

                "tours"                =>        50,

                "prix_unt"                =>        array(U3_RECRUE => 1),

                "need_src"        =>        array(S3_CHASSEUR),

                "limite"                =>        5,

                "prod_unt"        =>        true,

                );

$this->btc[B3_ECOLE_MILITAIRE]=array(

                "vie"                        =>        800,

                "prix_res"                =>        array(R3_BOIS => 50, R3_PIERRE => 300, R3_ACIER => 40),

                "tours"                =>        150,

                "need_src"         =>        array(S3_COMBATTANTS),

                "prix_unt"                =>        array(U3_FORGERON => 1, U3_RECRUE => 2),

                "limite"                =>        5,

                "prod_unt"        =>        true,

                );

                

$this->btc[B3_HAUT_FOURNEAU]=array(

                "vie"                        =>        600,

                "tours"                =>        350,

                "prod_res_auto"        =>        array(R3_ACIER => 1),

                "prix_res"                =>        array(R3_OR => 100, R3_PIERRE => 300),

                "need_src"         =>        array(S3_TRAVAIL_ACIER),

                "prix_unt"                =>        array(U3_BATISSEUR => 3, U3_INGENIEUR => 1),

                "prod_src"        =>        true,

);

$this->btc[B3_FONDERIE_MITHRIL]=array(

                "vie"                        =>        800,

                "tours"                =>        450,

                "prod_res_auto"        =>        array(R3_MITHRIL => 1),

                "prix_res"                =>        array(R3_OR => 200, R3_PIERRE => 400),

                "need_src"         =>        array(S3_FONTE_MITHRIL),

                "prix_unt"                =>        array(U3_BATISSEUR => 4, U3_INGENIEUR => 2, U3_ARTISAN => 1),

);

$this->btc[B3_ARMURERIE]=array(

                "vie"                        =>        600,

                "tours"                =>        150,

                "prix_res"                =>        array(R3_BOIS => 50, R3_PIERRE => 450, R3_OR => 50),

                "prix_unt"                =>        array(U3_FORGERON => 1, U3_INGENIEUR => 1, U3_ARTISAN => 1),

                "need_btc"        =>        array(B3_FONDERIE),

                "limite"                =>        3,

                "prod_res"        =>        true,

                );

$this->btc[B3_ATELIER]=array(

                "vie"                        =>        600,

                "tours"                =>        450,

                "need_src"        =>        array(S3_MECANISME_SIMPLE),

                "prix_res"                =>        array(R3_OR => 75, R3_PIERRE => 400),

                "prix_unt"                =>        array(U3_ARTISAN => 2, U3_FORGERON => 1, U3_INGENIEUR => 1, U3_BATISSEUR => 2),

                "prod_unt"        =>        true,

);

$this->btc[B3_MANUFACTURE]=array(

                "vie"                        =>        400,

                "tours"                =>        300,

                "need_src"        =>        array(S3_MECANISME_COMPLEXES),

                "prix_res"                =>        array(R3_OR => 100, R3_PIERRE => 400, R3_BOIS => 100),

                "prix_unt"                =>        array(U3_ARTISAN => 1, U3_FORGERON => 1, U3_INGENIEUR => 6, U3_BATISSEUR => 2),

                "limite"                =>        2,

                "prod_unt"        =>        true

);

$this->btc[B3_TOURS]=array(

                "bonus"         => array('bon' => 4.5),

                "vie"                        =>        1000,

                "tours"                =>        150,

                "need_src"        =>        array(S3_FORTIFICATION),

                "prix_res"                =>        array(R3_BOIS => 100,R3_PIERRE => 500, R3_ACIER => 20),

                "prix_unt"                =>        array(U3_MILICIEN => 4),

                "limite"                =>        4,

);

//Temple,

$this->btc[B3_TEMPLE]=array(

                "vie"                        =>         300,

                "need_src"        =>        array(S3_FONTE_MITHRIL),

                "prix_res"                =>        array(1 => 100, R3_PIERRE => 200, R3_ACIER => 50, R3_MITHRIL => 30),

                "tours"                =>        400,

                "limite"                =>        3,

                "prod_unt"        =>        true

                );

//Ecole runique,

$this->btc[B3_ECOLE_RUNIQUE]=array(

                "vie"                        => 400,

                "limite"        =>        5,

                "prix_res"                => array(1 => 150, R3_BOIS => 100, R3_PIERRE => 300, R3_ACIER => 50, R3_MITHRIL => 25),

                "tours"                => 500,

                "need_btc"         => array(B3_TEMPLE),

                "limite"                => 2,

                "prod_unt"        =>        true

        );

        

//Hall des Légendes,

$this->btc[B3_HALL]=array(

                "vie"                        => 400,

                "limite"        =>        5,

                "prix_res"                => array(1 => 150, R3_BOIS => 100, R3_PIERRE => 300, R3_ACIER => 50, R3_MITHRIL => 25),

                "tours"                => 500,

                "need_btc"         => array(B3_ECOLE_RUNIQUE),

                "limite"                => 2,

                "prod_unt"        =>        true

);        

//Citadelle

$this->btc[B3_CITADELLE]=array(

        "prod_pop"         =>        90,

                "bonus"         => array('gen' => 500, 'bon' => 18),

                "vie"                        =>      7000,

                "prix_res"                =>        array(R3_BOIS => 1500, R3_PIERRE => 8000, R3_ACIER => 300, R3_MITHRIL => 60),

                "tours"                =>        2000,

                "need_btc"         =>        array(B3_TOURS, B3_HALL),

                "prix_unt"                =>        array(U3_DEFENSEUR => 10),

                "limite"                =>        1,

                "prod_unt"        =>        4,

                "prod_src"        =>        true,

);

//</btc>

//<unt>

$this->unt[U3_BATISSEUR]=array(

                "prix_res"                =>        array(R3_OR => 2),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "group"                =>        1,

                "role"                =>        TYPE_UNT_CIVIL,

);

$this->unt[U3_CUEILLEUR]=array(

                "prix_res"                =>        array(R3_OR => 2),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "group"                =>        1,

                "role"                =>        TYPE_UNT_CIVIL,

);        

$this->unt[U3_MINEUR]=array(

                "prix_res"                =>        array(R3_OR => 2),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "group"                =>        3,

                "role"                =>        TYPE_UNT_CIVIL,

);        

$this->unt[U3_FORGERON]=array(

                "prix_res"                =>        array(R3_OR => 3),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "group"                =>        3,

                "role"                =>        TYPE_UNT_CIVIL,

);                

$this->unt[U3_ARTISAN]=array(

                "prix_res"                =>        array(R3_OR => 2),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "group"                =>        5,

                "role"                =>        TYPE_UNT_CIVIL,

);                                

$this->unt[U3_INGENIEUR]=array(

                "prix_res"                =>        array(R3_OR => 4),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "group"                =>        5,

                "role"                =>        TYPE_UNT_CIVIL,

);                

$this->unt[U3_RECRUE]=array(

                "prix_res"                =>        array(R3_OR => 3),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "need_src" => array(S3_CHASSEUR),

                "group"                =>        7,

                "role"                =>        TYPE_UNT_CIVIL,

                );

$this->unt[U3_VETERAN]=array(

                "prix_res"                =>        array(R3_OR => 4, R3_ACIER => 2),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "need_src" => array(S3_COMBATTANTS),

                "group"                =>        7,

                "role"                =>        TYPE_UNT_CIVIL,

);

                

$this->unt[U3_CHAMPION]=array(

                "prix_res"                =>        array(R3_MITHRIL => 4),

                "vie"                =>        1,

                "need_btc"        =>        array(B3_BASTION),

                "in_btc"                =>        array(B3_BASTION,B3_CITADELLE),

                "need_src" => array(S3_GUERRIERS),

                "group"                =>        7,

                "role"                =>        TYPE_UNT_CIVIL,

);

                                        

$this->unt[U3_ECLAIREUR]=array(

                "def"        =>        3,

                "vie"                =>        20,

                "atq_unt"        =>        3,

                "vit"                =>        12,

                "prix_res"                =>        array(R3_HACHE => 1),

                "need_btc"        =>        array(B3_CASERNE),

                "in_btc"                =>        array(B3_CASERNE),

                "prix_unt"        =>        array(U3_RECRUE => 1),

                "group"                =>        10,

                "role"                =>        TYPE_UNT_INFANTERIE,

                "rang" => 1,

);

$this->unt[U3_MILICIEN]=array(

                "def"        =>        7,

                "vie"                =>        21,

                "atq_unt"        =>        7,

                "vit"                =>        4,

                "prix_res"                =>        array(R3_MASSUE => 1),

                "need_btc"        =>        array(B3_CASERNE),

                "in_btc"                =>        array(B3_CASERNE),

                "prix_unt"        =>        array(U3_RECRUE => 1),

                "group"                =>        10,

                "role"                =>        TYPE_UNT_INFANTERIE,

                "rang" => 2,

);

                

$this->unt[U3_COMBATTANT]=array(

                "def"                        =>        10,

                "vie"                        =>        24,

                "atq_unt"                =>        18,

                "vit"                        =>        7,

                "prix_res"                =>        array(R3_HACHE_COMBAT => 1,R3_C_MAILLE => 1),

                "need_btc"        =>        array(B3_ECOLE_MILITAIRE),

                "in_btc"                =>        array(B3_ECOLE_MILITAIRE),

                "prix_unt"                =>        array(U3_VETERAN => 1),

                "group"                =>        12,

                "role"                =>        TYPE_UNT_INFANTERIE,

                "rang" => 3,

);

                

$this->unt[U3_DEFENSEUR]=array(

                "def"        =>        19,

                "vie"                =>        24,

                "atq_unt"        =>        11,

                "vit"                =>        6,

                "prix_res"                =>        array(R3_MARTEAU => 1,R3_C_MAILLE => 1),

                "need_btc"        =>        array(B3_ECOLE_MILITAIRE),

                "in_btc"                =>        array(B3_ECOLE_MILITAIRE),

                "prix_unt"        =>        array(R3_ACIER => 1),

                "group"                =>        12,

                "role"                =>        TYPE_UNT_INFANTERIE,

                "rang" => 4,

);

$this->unt[U3_GUERRIER]=array(

                "def"        =>        17,

                "vie"                =>        25,

                "atq_unt"        =>        28,

                "vit"                =>        6,

                "need_src"         => array(S3_GUERRIERS),

                "prix_res"                =>        array(R3_HACHE_GUERRE => 1, R3_C_MITHRIL => 1),

                "need_btc"        =>        array(B3_ECOLE_MILITAIRE),

                "in_btc"                =>        array(B3_ECOLE_MILITAIRE),

                "prix_unt"        =>        array(U3_VETERAN => 1),

                "group"                =>        14,

                "role"                =>        TYPE_UNT_INFANTERIE,

                "rang" => 6,

);

$this->unt[U3_PROTECTEUR]=array(

                "def"        =>        26,

                "vie"                =>        27,

                "atq_unt"        =>        19,

                "vit"                =>        5,

                "need_src"         => array(S3_GUERRIERS),

                "prix_res"                =>        array(R3_MARTEAU_GUERRE => 1, R3_C_MITHRIL => 1),

                "need_btc"        =>        array(B3_ECOLE_MILITAIRE),

                "in_btc"                =>        array(B3_ECOLE_MILITAIRE),

                "prix_unt"        =>        array(U3_VETERAN => 1),

                "group"                =>        14,

                "role"                =>        TYPE_UNT_INFANTERIE,

                "rang" => 5,

);

$this->unt[U3_P_MURANG]=array(

                "def"        =>        10,

                "bonus"                => array('atq' => 1),

                "vie"                =>        13,

                "atq_unt"        =>        13,

                "vit"                =>        5,

                "need_src"         => array(S3_MURANG),

                "prix_res"                =>        array(R3_ACIER => 5, R3_C_MITHRIL => 1,R3_MITHRIL => 1),

                "need_btc"        =>        array(B3_TEMPLE),

                "in_btc"                =>        array(B3_TEMPLE),

                "prix_unt"        =>        array(U3_VETERAN => 1),

                "group"                =>        16,

                "role"                =>        TYPE_UNT_MAGIQUE,

                "rang" => 10,

);

$this->unt[U3_P_TRARKOS]=array(

                "def"        =>        13,

                "bonus"                => array('def' => 1),

                "vie"                =>        13,

                "atq_unt"        =>        10,

                "vit"                =>        5,

                "need_src"         => array(S3_TRARKOS),

                "prix_res"                =>        array(R3_ACIER => 5, R3_C_MITHRIL => 1,R3_MITHRIL => 1),

                "need_btc"        =>        array(B3_TEMPLE),

                "in_btc"                =>        array(B3_TEMPLE),

                "prix_unt"        =>        array(U3_VETERAN => 1),

                "group"                =>        16,

                "role"                =>        TYPE_UNT_MAGIQUE,

                "rang" => 9,

);

$this->unt[U3_GRAVEUR_R]=array(

                "def"        =>        23,

                "vie"                =>        16,

                "atq_unt"        =>        15,

                "vit"                =>        4,

                "bonus" => array('vie' => 1),

                "need_src"         => array(S3_GRAVURE_RUNIQUE),

                "prix_res"                =>        array(R3_OR => 8, R3_MITHRIL => 4, R3_C_MITHRIL => 1),

                "need_btc"        =>        array(B3_ECOLE_RUNIQUE),

                "in_btc"                =>        array(B3_ECOLE_RUNIQUE),

                "prix_unt"        =>        array(U3_CHAMPION => 1),

                "group"                =>        18,

                "role"                =>        TYPE_UNT_DISTANCE,

                "rang" => 7,

);

$this->unt[U3_LANCEUR_R]=array(

                "def"        =>        15,

                "vie"                =>        14,

                "atq_unt"        =>        24,

                "vit"                =>        6,

                "bonus" => array('vie' => 1),

                "need_src"         => array(S3_ECRITURE_RUNIQUE),

                "prix_res"                =>        array(R3_OR => 8, R3_MITHRIL => 4, R3_C_MITHRIL => 1),

                "need_btc"        =>        array(B3_ECOLE_RUNIQUE),

                "in_btc"                =>        array(B3_ECOLE_RUNIQUE),

                "prix_unt"        =>        array(U3_CHAMPION => 1),

                "group"                =>        18,

                "role"                =>        TYPE_UNT_DISTANCE,

                "rang" => 8,

);

$this->unt[U3_CATAPULTE]=array(

                "def"        =>        6,

                "vie"                =>        16,

                "atq_unt"        =>        8,

                "atq_btc"        =>        9,

                "vit"                =>        4,

                "need_src"         => array(S3_MACHINE_2),

                "prix_res"                =>        array(R3_BOIS => 10, R3_PIERRE => 20, R3_CHEVAUX => 1, R3_ACIER => 10),

                "need_btc"        =>        array(B3_ATELIER),

                "in_btc"                =>        array(B3_ATELIER),

                "prix_unt"        =>        array(U3_RECRUE => 1),

                "group"                =>        20,

                "role"                =>        TYPE_UNT_MACHINE,

                "rang" => 11,

);

$this->unt[U3_BELIER]=array(

                "def"        =>        2,

                "vie"                =>        16,

                "atq_unt"        =>        0,

                "atq_btc"        =>        7,

                "vit"                =>        3,

                "need_src"         => array(S3_MACHINE_2),

                "prix_res"                =>        array(R3_PIERRE => 10,R3_BOIS => 20,R3_ACIER => 5,R3_CHEVAUX => 1),

                "need_btc"        =>        array(B3_ATELIER),

                "in_btc"                =>        array(B3_ATELIER),

                "prix_unt"        =>        array(U3_RECRUE => 2),

                "group"                =>        20,

                "role"                =>        TYPE_UNT_MACHINE,

                "rang" => 12,

);

        

$this->unt[U3_BELIER_TETE_MORT]=array(

                "def"        =>        5,

                "vie"                =>        18,

                "atq_unt"        =>        0,

                "atq_btc"        =>        15,

                "vit"                =>        2,

                "need_src"        => array(S3_MACHINE_3),

                "prix_res"                =>        array(R3_PIERRE => 50, R3_MITHRIL =>5 ,R3_ACIER => 10, R3_BOIS => 40),

                "need_btc"        =>        array(B3_ATELIER),

                "in_btc"                =>        array(B3_ATELIER),

                "prix_unt"                =>        array(U3_RECRUE => 2),

                "group"                =>        22,

                "role"                =>        TYPE_UNT_MACHINE,

                "rang" => 13,

);        

//Baliste,

$this->unt[U3_BALISTE]=array(

                "def"        =>        5,

                "vie"                =>        13,

                "atq_unt"        =>        10,

                "atq_btc"        =>        5,

                "vit"                =>        3,

                "need_src"         =>        array(S3_MACHINE_1),

                "prix_res"                =>        array(R3_ACIER => 10, R3_BOIS => 20,R3_MITHRIL => 3),

                "need_btc"        =>        array(B3_ATELIER),

                "in_btc"                =>        array(B3_ATELIER),

                "prix_unt"                =>        array(U3_VETERAN => 1),

                "group"                =>        22,

                "role"                =>        TYPE_UNT_MACHINE,

                "rang" => 14,

);

$this->unt[U3_TRANSPORT]=array(  

                  "def"                        =>        5,

                "vie"                        =>        10,

                "vit"                        =>        10,

                "carry"                 =>         20,

                "atq_unt"                =>        0,

                "need_src"         =>         array(S3_MACHINE_3),

                "prix_res"                =>        array(R3_CHEVAUX => 5, R3_BOIS => 150, R3_ACIER => 10),

                "need_btc"        =>        array(B3_MANUFACTURE),

                "in_btc"                =>        array(B3_MANUFACTURE),

                "prix_unt"                =>        array(U3_RECRUE => 1),

                "group"                =>        24,

                "role"                =>        TYPE_UNT_MACHINE,

                "rang" => 15,

);

$this->unt[U3_GOLEM]=array(  

                "def"                        =>        155,

                "vie"                        =>        140,

                "atq_unt"                =>        60,

                "vit"                        =>        8,

                "need_src"         =>        array(S3_GOLEM),

                "prix_res"                =>        array(R3_BOIS => 5,R3_PIERRE => 5, R3_ACIER => 10, R3_FER => 10, R3_CHARBON => 10),

                "need_btc"        =>        array(B3_HALL),

                "in_btc"                =>        array(B3_HALL),

                "prix_unt"                =>        array(U3_BATISSEUR => 3),

                "group"                =>        25,

                   "role"                =>        TYPE_UNT_HEROS,

                "rang" => 16,

);

$this->unt[U3_TAUREN]=array(  

                "def"                        =>        100,

                "vie"                        =>        145,

                "atq_unt"                =>        100,

                "atq_btc"                =>        45,

                "vit"                        =>        10,

                "need_src"         =>        array(S3_DRUIDISME),

                "prix_res"                =>        array(R3_BOIS => 5,R3_PIERRE => 5, R3_ACIER => 10, R3_FER => 10, R3_CHARBON => 10),

                "need_btc"        =>        array(B3_HALL),

                "in_btc"                =>        array(B3_HALL),

                "prix_unt"                =>        array(U3_BATISSEUR => 3),

                "group"                =>        25,

                   "role"                =>        TYPE_UNT_HEROS,

                "rang" => 17,

);

$this->unt[U3_SEIGNEUR_DE_GUERRE]=array(

                "def"                        =>        65,

                "vie"                        =>        140,

                "atq_unt"                =>        160,

                "vit"                        =>        11,

                "need_src"         =>        array(S3_SEIGNEUR),

                "prix_res"                =>        array(R3_BOIS => 5,R3_PIERRE => 5, R3_ACIER => 10, R3_FER => 10, R3_CHARBON => 10),

                "need_btc"        =>        array(B3_HALL),

                "in_btc"                =>        array(B3_HALL),

                "prix_unt"                =>        array(U3_BATISSEUR => 3),

                "group"                =>        25,

                    "role"                =>        TYPE_UNT_HEROS,

                "rang" => 18,

);

$this->unt[U3_TRANSPORT_RUNIQUE] = array(
	'vie' => 9,
	'group' => 21,
	'role' => TYPE_UNT_DEMENAGEMENT,
	//'prix_res' => array(R3_PIERRE => 3000, R3_ACIER => 1000, R3_FER => 500, R3_CHARBON => 500, R3_CHAMPI => 30000),
	'prix_res' => array(R3_PIERRE => 1500, R3_ACIER => 500, R3_FER => 200, R3_CHARBON => 300, R3_CHAMPI => 15000),
	'need_btc' => array(B3_ECOLE_RUNIQUE, ),
	'in_btc' => array(B3_ECOLE_RUNIQUE, ),
	'need_src' => array(S3_RUNE_VOYAGE, ),
	'vit' => 6,
	'prix_unt' => array(U3_BATISSEUR => 3, ),
	'rang' => 11,

);

//</unt>

//<src>

//Mine niv1,

$this->src[S3_MINE_1]=array(

                "tours"                =>        5,

                "need_btc"        =>        array(B3_CAVERNE, B3_CHAMPI),

                "prix_res"                =>        array(R3_CHAMPI => 40),

                "group"                =>        1,

);

//Mine niv2,

$this->src[S3_MINE_2]=array(

                "tours"                =>        15,

                "need_src"        =>        array(S3_MINE_1),

                "prix_res"        =>        array(R3_CHAMPI => 100, R3_PIERRE => 80),

                "group"                =>        1,

);

//Commerce niv1,

$this->src[S3_COMMERCE_1]=array(

                "tours"                =>        8,

                "need_btc"        =>        array(B3_CAVERNE, B3_CHAMPI),

                "prix_res"                =>        array(R3_OR => 100),

                "group"                =>        3,

);

//Commerce niv2,

$this->src[S3_COMMERCE_2]=array(

                "tours"                =>        15,

                "need_btc"        =>        array(B3_FONDERIE),

                "need_src"        =>        array(S3_COMMERCE_1),

                "prix_res"                =>        array(R3_OR => 350, R3_BOIS => 30, R3_CHAMPI => 600, R3_MITHRIL => 20),

                "group"                =>        3,

);

//Commerce niv3,

$this->src[S3_COMMERCE_3]=array(

                "tours"                =>        30,

                "need_src"        =>        array(S3_COMMERCE_2),

                "need_btc"        =>        array(B3_FONDERIE_MITHRIL),

                "prix_res"                =>        array(1        => 1000, R3_CHAMPI => 2000, R3_BOIS => 150, R3_PIERRE => 800, R3_MITHRIL => 40),

                "group"                =>        3,

);

//Fonte de l'acier,

$this->src[S3_FONTE_ACIER]=array(

                "tours"                =>        20,

                "need_btc"        =>        array(B3_MINE_FER, B3_MINE_CHARBON),

                "need_src"        =>        array(S3_MINE_2),

                "prix_res"                =>        array(R3_OR => 40, R3_PIERRE => 150, R3_FER => 60, R3_CHARBON => 60),

                "group"                =>        6,

);

//Travail de l'acier,

$this->src[S3_TRAVAIL_ACIER]=array(

                "tours"                =>        30,

                "need_btc"        =>        array(B3_FONDERIE),

                "prix_res"                =>        array(R3_OR => 80, R3_PIERRE => 300, R3_FER => 180, R3_CHARBON => 180, R3_ACIER => 75),

                "group"                =>        6,

);

//Fonte du mithril,

$this->src[S3_FONTE_MITHRIL]=array(

                "tours"                =>        30,

                "need_btc"        =>        array(B3_HAUT_FOURNEAU),

                "prix_res"                =>        array(R3_OR => 150, R3_PIERRE => 600, R3_ACIER => 400),

                "group"                =>        6,

);

//M�anisles simples,

$this->src[S3_MECANISME_SIMPLE]=array(

                "tours"                =>        20,

                "need_btc"        =>        array(B3_HAUT_FOURNEAU),

                "prix_res"                =>        array(R3_OR => 100, R3_BOIS => 150, R3_PIERRE => 250, R3_ACIER => 100),

                "group"                =>        9,

);

//M�anismes complexes,

$this->src[S3_MECANISME_COMPLEXES]=array(

                "tours"                =>        30,

                "need_btc"        =>        array(B3_FONDERIE_MITHRIL),

                "need_src"        =>        array(S3_MACHINE_2),

                "prix_res"                =>        array(R3_OR => 150, R3_BOIS => 200, R3_PIERRE => 250, R3_ACIER => 150),

                "group"                =>        9,

);

//Fortifications,

$this->src[S3_FORTIFICATION]=array(

                "tours"                =>        30,

                "need_btc"        =>        array(B3_HAUT_FOURNEAU),

                "prix_res"                =>        array(R3_BOIS => 50, R3_PIERRE => 400, R3_ACIER => 75),

                "group"                =>        11,

);

//Ecriture runique,

$this->src[S3_ECRITURE_RUNIQUE]=array(

                "tours"                =>        20,

                "need_btc"        =>        array(B3_ECOLE_RUNIQUE),

                "prix_res"        =>        array(R3_OR => 350, R3_PIERRE => 700,R3_CHAMPI => 1000, R3_MITHRIL => 80),

                "group"                =>        12,

);

//Gravure runique,

$this->src[S3_GRAVURE_RUNIQUE]=array(

                "tours"                =>        50,

                "need_btc"        =>        array(B3_ECOLE_RUNIQUE),

                "prix_res"                =>        array(R3_OR => 350, R3_PIERRE => 600,R3_CHAMPI => 1300, R3_MITHRIL => 100),

                "group"                =>        12,

);

//rune de voyage

$this->src[S3_RUNE_VOYAGE] = array(
	'tours' => 30,
	'group' => 12,
	'need_btc' => array(B3_ECOLE_RUNIQUE, ),
	'prix_res' => array(R3_OR => 1000, R3_PIERRE => 400, R3_CHAMPI => 2000,R3_MITHRIL => 800 ),
);

//Chasseurs nains,

$this->src[S3_CHASSEUR]=array(

                "tours"                =>        20,

                "prix_res"                =>        array(R3_OR => 40, R3_PIERRE => 200, R3_CHAMPI => 200, R3_FER => 50, R3_CHARBON => 50),

                "need_btc"      =>   array(B3_FONDERIE),

                "group"                =>        14,

);

//Combattants nains,

$this->src[S3_COMBATTANTS]=array(

                "tours"                =>        40,

                "need_btc"        =>        array(B3_CASERNE),

                "need_src"        =>        array(S3_ARME_1, S3_ARMURE_1),

                "prix_res"                =>        array(R3_OR => 90, R3_PIERRE => 300, R3_CHAMPI => 400, R3_ACIER => 110),

                "group"                =>        14,

);

//Guerriers nains,

$this->src[S3_GUERRIERS]=array(

                "tours"                =>       30,

                "need_btc"        =>        array(B3_ECOLE_MILITAIRE),

                "need_src"        =>        array(S3_ARME_2, S3_ARMURE_2),

                "prix_res"                =>        array(R3_OR => 180, R3_PIERRE => 400, R3_CHAMPI => 1000, R3_ACIER => 100, R3_MITHRIL => 50),

                "group"                =>        14,

);

//Armes niv1,

$this->src[S3_ARME_1]=array(

                "tours"                =>       10,

                "need_btc"        =>        array(B3_HAUT_FOURNEAU, B3_ARMURERIE),

                "prix_res"                =>        array(R3_ACIER => 10),

                "group"                =>        17,

);

//Armes niv2,

$this->src[S3_ARME_2]=array(

                "tours"                =>        20,

                "need_src"        =>        array(S3_COMBATTANTS),

                "prix_res"                =>        array(R3_BOIS => 25, R3_PIERRE => 100, R3_FER => 100, 6        => 100, R3_ACIER => 40),

                "group"                =>        17,

);

//Armures niv1,

$this->src[S3_ARMURE_1]=array(

                "tours"                =>        10,

                "need_btc"        =>        array(B3_HAUT_FOURNEAU, B3_ARMURERIE),

                "prix_res"                =>        array(R3_ACIER => 10),

                "group"                =>        19,

);

//Armures niv2,

$this->src[S3_ARMURE_2]=array(

                "tours"                =>        20,

                "need_src"        =>        array(S3_COMBATTANTS),

                "prix_res"                =>        array(R3_OR => 40, R3_ACIER => 40, R3_MITHRIL => 30),

                "group"                =>        19,

);

//Machines de guerre niv1,

$this->src[S3_MACHINE_1]=array(

                "tours"                =>        10,

                "need_btc"        =>        array(B3_ATELIER),

                "prix_res"                =>        array(R3_BOIS => 100, R3_PIERRE => 200, R3_ACIER => 100),

                "group"                =>        21,

);

//Machines de guerre niv2,

$this->src[S3_MACHINE_2]=array(

                "tours"                =>        20,

                "need_src"        =>        array(S3_MACHINE_1),

                "prix_res"                =>        array(R3_OR => 100, R3_BOIS => 200, R3_PIERRE => 300, R3_FER => 100, R3_CHARBON => 100),

                "group"                =>        21,

);

//Machines de guerre niv3,

$this->src[S3_MACHINE_3]=array(

                "tours"                =>        30,

                "need_btc"        =>        array(B3_MANUFACTURE),

                "prix_res"                =>        array(R3_BOIS => 300, R3_CHAMPI => 500, R3_CHEVAUX => 20, R3_ACIER => 100, R3_MITHRIL => 100),

                "group"                =>        21,

);

//Suivant de Moradin,

$this->src[S3_TRARKOS]=array(

                "tours"                => 50,

                "need_btc"        =>        array(B3_TEMPLE),

                "prix_res"                =>        array(R3_OR => 200, R3_PIERRE => 400, R3_CHAMPI => 200),

                "group"                =>        24,

);

//Suivant de Dumatho�,

$this->src[S3_MURANG]=array(

                "tours"                => 50,

                "need_btc"        =>        array(B3_TEMPLE),

                "prix_res"                =>        array(R3_OR => 200, R3_PIERRE => 400, R3_CHAMPI => 200),

                "group"                =>        25,

);

$this->src[S3_GOLEM]=array(

                "tours"                => 50,

                "need_btc"        =>        array(B3_HALL),

                "prix_res"                =>        array(R3_OR => 200, R3_PIERRE => 400, R3_CHAMPI => 200),

                "group"                =>        25,

);

$this->src[S3_DRUIDISME]=array(

                "tours"                => 50,

                "need_btc"        =>        array(B3_HALL),

                "prix_res"                =>        array(R3_OR => 200, R3_PIERRE => 400, R3_CHAMPI => 200),

                "group"                =>        25,

);

$this->src[S3_SEIGNEUR]=array(

                "tours"                => 50,

                "need_btc"        =>        array(B3_HALL),

                "prix_res"                =>        array(R3_OR => 200, R3_PIERRE => 400, R3_CHAMPI => 200),

                "group"                =>        25,

);

//</src>

/* compétences du ou des héros ... */

//<comp>

/* ### Off ### */

$this->comp[CP_BOOST_OFF]=array(

        'heros'                => array(U3_SEIGNEUR_DE_GUERRE),

        'tours'                => 3,

        'bonus'                => 10,

        'prix_xp'        => 40,

        'type'                => 1

);

$this->comp[CP_RESURECTION]=array(

        'heros'                => array(U3_SEIGNEUR_DE_GUERRE),

        'tours'                => 24,

        'bonus'                => -50, // perte XP

        'prix_xp'        => 50,

        'type'                => 1

);

$this->comp[CP_VOLEE_DE_FLECHES]=array(

        'heros'                => array(U3_SEIGNEUR_DE_GUERRE),

        'tours'                => 24,

        'bonus'                => 5,

        'prix_xp'        => 50,

        'type'                => 1

);

$this->comp[CP_VITESSE]=array(

        'heros'                => array(U3_SEIGNEUR_DE_GUERRE),

        'tours'                => 24,

        'bonus'                => 50,

        'prix_xp'        => 50,

        'type'                => 1

);

/* ### Def ### */

$this->comp[CP_BOOST_DEF]=array(

        'heros'                => array(U3_GOLEM),

        'tours'                => 8,

        'bonus'                => 8,

        'prix_xp'        => 40,

        'type'                => 2

);

$this->comp[CP_RESISTANCE]=array(

        'heros'                => array(U3_GOLEM),

        'tours'                => 6,

        'bonus'                => 15,

        'prix_xp'        => 60,

        'type'                => 2

);

$this->comp[CP_REGENERATION]=array(

        'heros'                => array(U3_GOLEM),

        'tours'                => 24,

        'bonus'                => 10,

        'prix_xp'        => 50,

        'type'                => 2

);

$this->comp[CP_INVULNERABILITE]=array(

        'heros'                => array(U3_GOLEM),

        'tours'                => 24,

        'bonus'                => -50, // malus sur la production

        'prix_xp'        => 50,

        'type'                => 2

);

/* ### Sou ### */

$this->comp[CP_CASS_BAT]=array(

        'heros'                => array(U3_TAUREN),

        'tours'                => 24,

        'bonus'                => 10,

        'prix_xp'        => 50,

        'type'                => 3

);

$this->comp[CP_GENIE_COMMERCIAL]=array(

        'heros'                => array(U3_TAUREN),

        'tours'                => 24,

        'bonus'                => 10,

        'prix_xp'        => 50,

        'type'                => 3

);

$this->comp[CP_GUERISON]=array(

        'heros'                => array(U3_TAUREN),

        'tours'                => 24,

        'bonus'                => 10,

        'prix_xp'        => 50,

        'type'                => 3

);

 $this->comp[CP_TELEPORTATION]=array(

         'heros'                => array(U3_TAUREN),

         'tours'                => 0,

         'bonus'                => 0,

         'prix_xp'        => 50,

        'type'                => 3

 );

//</comp>

$this->race_cfg = array(

        'res_nb'        =>        count($this->res),

        'trn_nb'        =>        count($this->trn),

        'btc_nb'        =>        count($this->btc),

        'unt_nb'        =>        count($this->unt),

        'src_nb'        =>        count($this->src),

        'primary_res' => array(R3_OR,R3_CHAMPI),

        'second_res'        =>        array(R3_OR, R3_BOIS, R3_PIERRE, R3_CHAMPI, R3_FER , R3_CHARBON, R3_ACIER, R3_MITHRIL),

        'primary_btc' => array(

                'vil' => array(B3_BASTION => array('unt','src'),

                                B3_CASERNE => array('unt'),

                                B3_ECOLE_MILITAIRE => array('unt'),

                                B3_ARMURERIE => array('res'),

                                B3_ATELIER => array('unt'),

                                B3_MANUFACTURE => array('unt'),

                                B3_TEMPLE => array('unt'),

                                B3_ECOLE_RUNIQUE => array('unt'),

                                B3_HALL => array('unt')),

                 'ext' => array(B3_MARCHE => array('ach'))),

        'bonus_res'   => array(R3_OR => 0.05),

        'modif_pts_btc' => 1,

        'debut'        =>        array(

                'res'        =>        array(R3_OR => 70, R3_PIERRE => 300, R3_CHAMPI => 1500),

                'trn'        =>        array(T3_MONTAGNE => 2, T3_GIS_FER => 2, T3_FILON_OR => 1, T3_GIS_CHARBON => 2),

                'unt'        =>         array(U3_BATISSEUR => 1, U3_ECLAIREUR => 1, U3_MILICIEN => 1),

                'btc'        =>         array(B3_BASTION => array()),

                'src'        =>        array()),

        'bonus_map' => array(MAP_EAU => -10, MAP_LAC => -10, MAP_HERBE => 3, MAP_MONTAGNE => 15, MAP_FORET => -10),

        'bonus_period' => array(PERIODS_JOUR => 4, PERIODS_NUIT => 4, PERIODS_AUBE => -8, PERIODS_CREP => 0),

        );

}

}

?>

