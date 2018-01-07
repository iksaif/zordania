<?php
/* Defines */
define("R10_OR", 1);
define("R10_BOIS", 2);
define("R10_PIERRE", 3);
define("R10_NOURRITURE", 4);
define("R10_FER", 5);
define("R10_CHARBON", 6);
define("R10_CHEVAUX", 7);
define("R10_ACIER", 8);
define("R10_MITHRIL", 9);
define("R10_B_BOIS", 10);
define("R10_B_ACIER", 11);
define("R10_EPEE", 12);
define("R10_EPEE_LON", 13);
define("R10_ARC", 14);
define("R10_ARBALETE", 15);
define("R10_COTTE_MAILLE", 16);
define("R10_COTTE_MITHRIL", 17);

define("T10_FORET", 1);
define("T10_GIS_FER", 2);
define("T10_GIS_CHARBON", 3);
define("T10_FILON_OR", 4);
define("T10_MONTAGNE", 5);

define("B10_DONJON", 1);
define("B10_MARCHE", 2);

define("S10_ARME_1", 1);

define("U10_TRAVAILLEUR", 1);

class config10
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
*	need_btc		uint				Batiment dans le quel c'est construit
*	need_src		uint				A besoin de la recherche
*	prix_res		array(uint=>uint)		Prix type => nombre
*	group			uint				Est dans le groupe
*	cron			bool				Ne peut tre produit que par un cron
*/

//<res>
$this->res[R10_OR]=array(
		"cron"	=>	true
);

$this->res[R10_BOIS]=array(
		"cron"	=>	true
);


$this->res[R10_PIERRE]=array(
		"cron"	=>	true
);

$this->res[R10_NOURRITURE]=array(
		"cron"	=>	true
);

$this->res[R10_FER]=array(
		"cron"	=>	true
);

$this->res[R10_CHARBON]=array(
		"cron"	=>	true
);

$this->res[R10_CHEVAUX]=array(
		"prix_res"	=>	array(R10_NOURRITURE => 150, R10_ACIER => 2),
		"group"	=>	7,
);

$this->res[R10_ACIER]=array(
		"cron"	=>	true,
		"prix_res"	=>	array(R10_FER => 2, R10_CHARBON => 2),
);
		
$this->res[R10_MITHRIL]=array("dummy" => true);

$this->res[R10_B_BOIS]=array(
		"prix_res"	=>	array(R10_BOIS => 1),
		"group"	=>	10,
);
		
$this->res[R10_B_ACIER]=array(
		"prix_res"	=>	array(R10_BOIS => 2, R10_ACIER => 1, R10_FER => 1, R10_CHARBON => 1),
		"group"	=>	10,
);
	
$this->res[R10_EPEE]=array(
		"prix_res"	=>	array(R10_BOIS => 1), 
		"group"	=>	12,
);
	
$this->res[R10_EPEE_LON]=array(
		"prix_res"	=>	array(R10_ACIER => 2, R10_CHARBON => 1, R10_FER => 1),
		"group"	=>	12,
);

$this->res[R10_ARC]=array(
		"prix_res"	=>	array(R10_BOIS => 2),
		"group"	=>	15,
);
		
$this->res[R10_ARBALETE]=array(
		"prix_res"	=>	array(R10_BOIS => 1,R10_ACIER => 2,R10_FER => 1,R10_CHARBON => 1),
		"group"	=>	15,
);
	
$this->res[R10_COTTE_MAILLE]=array(
		"prix_res"	=>	array(R10_ACIER => 2),
		"group"	=>	16,
);

$this->res[R10_COTTE_MITHRIL]=array(
		"prix_res"	=>	array(R10_MITHRIL => 1),
		"group"	=>	16,
);
//</res>

/* Terrains */
//<trn>
$this->trn[T10_FORET] = array();
$this->trn[T10_GIS_FER] = array();
$this->trn[T10_GIS_CHARBON] = array();
$this->trn[T10_FILON_OR] = array();
$this->trn[T10_MONTAGNE] = array();
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
$this->btc[B10_DONJON]=array(
		"vie"		=>	1,
		"limite"	=>	1,
		"tours"		=>	1,
		"bonus" 	=>  array(),
		"prix_res"	=>	array(),
		"prod_pop"	=>	50,
		"prod_src"	=>	true,
		"prod_unt"	=>	80,
		"prod_res_auto"	=>	array(R10_NOURRITURE => 5),
		"com"		=>	array(COM_MAX_NB3,COM_MAX_VENTES3)
);

/*$this->btc[B10_MARCHE]=array(
		"vie"		=>	1,
		"limite"	=>	1,
		"tours"		=>	1,
		"bonus" 	=>  array(),
		"prix_res"	=>	array(),
		"com"		=>	array(COM_MAX_NB3,COM_MAX_VENTES3)
);*/
//</btc>

//<unt>
$this->unt[U10_TRAVAILLEUR]=array(
		"vie"	=>	1,
		"group"	=>	1,
		"role"	=>	TYPE_UNT_CIVIL,
		"prix_res"	=>	array(R10_OR => 1),
		"need_btc"	=>	array(B10_DONJON),
		"in_btc"	=>	array(B10_DONJON),
);
//</unt>

//<src>
$this->src[S10_ARME_1]=array(
		'need_btc' => array(B10_DONJON, ),
		"tours"	=>	1,
		"group"	=>	1,
		"prix_res"	=>	array(),
);
//</src>

/* compétences du ou des héros = aucune (aucun héros) */

//<comp>
$this->comp = array();
//</comp>

/*
*	Config de la race staff
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
	'primary_res'	=>	array(R10_OR, R10_NOURRITURE),
	'second_res'	=>	array(R10_OR, R10_BOIS, R10_PIERRE, R10_NOURRITURE, R10_FER , R10_CHARBON, R10_ACIER),
	'primary_btc'	=>	array(
		'vil'	=>	array( B10_DONJON => array('unt')),
		'ext'	=>	array( B10_DONJON => array('ach'))
		),
	'bonus_res'	=>	array(R10_OR => 0.05),
	'modif_pts_btc'	=>	1,
	'debut'	=>	array(
		'res'	=>	array(R10_OR => 100, R10_BOIS => 100, R10_PIERRE => 100, R10_NOURRITURE => 5000),
		'unt'	=> 	array(U10_TRAVAILLEUR => 1),
		'btc'	=> 	array(B10_DONJON => array()),
		'src'	=>	array(),
	'bonus_map' => array(MAP_EAU => 0, MAP_LAC => 0, MAP_HERBE => 2, MAP_MONTAGNE => 0, MAP_FORET => 0),
	'bonus_period' => array(PERIODS_JOUR => 0, PERIODS_NUIT => 0, PERIODS_AUBE => 0, PERIODS_CREP => 0),
	));
}
}
?>


