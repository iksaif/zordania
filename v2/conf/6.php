<?php
/* Defines */
define("R6_OR", 1);
define("R6_BOIS", 2);
define("R6_PIERRE", 3);
define("R6_NOURRITURE", 4);
define("R6_FER", 5);
define("R6_CHARBON", 6);
define("R6_CHEVAUX", 7);
define("R6_ACIER", 8);
define("R6_MITHRIL", 9);
define("R6_B_BOIS", 10);
define("R6_B_ACIER", 11);
define("R6_EPEE", 12);
define("R6_EPEE_LON", 13);
define("R6_ARC", 14);
define("R6_ARBALETE", 15);
define("R6_COTTE_MAILLE", 16);
define("R6_COTTE_MITHRIL", 17);

define("T6_FORET", 1);
define("T6_GIS_FER", 2);
define("T6_GIS_CHARBON", 3);
define("T6_FILON_OR", 4);
define("T6_MONTAGNE", 5);

define("B6_DONJON", 1);
define("B6_MARCHE", 2);

define("U6_DRESSEUR", 1);
define("U6_SOLDAT", 2);
define("U6_ELITE", 3);
define("U6_PAPANOEL", 4);
define("U6_GROSLUTIN", 5);
define("U6_SOLIDELUTIN", 6);
define("U6_LUTIN_MALIN", 7);
define("U6_MERENOEL", 8);
define("U6_GARDE1", 9);
define("U6_GARDE2", 10);
define("U6_COUPLE", 11);
define("U6_GARDE3", 12);

define("S6_ARME_1", 1);

class config6
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
$this->res[R6_OR]=array(
		"cron"	=>	true
);

$this->res[R6_BOIS]=array(
		"cron"	=>	true
);


$this->res[R6_PIERRE]=array(
		"cron"	=>	true
);

$this->res[R6_NOURRITURE]=array(
		"cron"	=>	true
);

$this->res[R6_FER]=array(
		"cron"	=>	true
);

$this->res[R6_CHARBON]=array(
		"cron"	=>	true
);

$this->res[R6_CHEVAUX]=array(
		"prix_res"	=>	array(R6_NOURRITURE => 150, R6_ACIER => 2),
		"group"	=>	7,
);

$this->res[R6_ACIER]=array(
		"cron"	=>	true,
		"prix_res"	=>	array(R6_FER => 2, R6_CHARBON => 2),
);
		
$this->res[R6_MITHRIL]=array("dummy" => true);

$this->res[R6_B_BOIS]=array(
		"prix_res"	=>	array(R6_BOIS => 1),
		"group"	=>	10,
);
		
$this->res[R6_B_ACIER]=array(
		"prix_res"	=>	array(R6_BOIS => 2, R6_ACIER => 1, R6_FER => 1, R6_CHARBON => 1),
		"group"	=>	10,
);
	
$this->res[R6_EPEE]=array(
		"prix_res"	=>	array(R6_BOIS => 1), 
		"group"	=>	12,
);
	
$this->res[R6_EPEE_LON]=array(
		"prix_res"	=>	array(R6_ACIER => 2, R6_CHARBON => 1, R6_FER => 1),
		"group"	=>	12,
);

$this->res[R6_ARC]=array(
		"prix_res"	=>	array(R6_BOIS => 2),
		"group"	=>	15,
);
		
$this->res[R6_ARBALETE]=array(
		"prix_res"	=>	array(R6_BOIS => 1,R6_ACIER => 2,R6_FER => 1,R6_CHARBON => 1),
		"group"	=>	15,
);
	
$this->res[R6_COTTE_MAILLE]=array(
		"prix_res"	=>	array(R6_ACIER => 2),
		"group"	=>	16,
);

$this->res[R6_COTTE_MITHRIL]=array(
		"prix_res"	=>	array(R6_MITHRIL => 1),
		"group"	=>	16,
);
//</res>

/* Terrains */
//<trn>
$this->trn[T6_FORET] = array();
$this->trn[T6_GIS_FER] = array();
$this->trn[T6_GIS_CHARBON] = array();
$this->trn[T6_FILON_OR] = array();
$this->trn[T6_MONTAGNE] = array();
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
$this->btc[B6_DONJON]=array(
		"vie"	=>	10000,
		"limite"	=>	1,
		"tours"	=>	500,
		"bonus" 	=>  array('gen' => 300, 'bon' => 40),
		"prix_res"	=>	array(R6_BOIS => 2250, R6_PIERRE => 2250, R6_ACIER => 200),
		"prod_pop"	=>	700,
		"prod_src"	=>	true,
		"prod_unt"	=>	80,
		"prod_res_auto"	=>	array(R6_NOURRITURE => 1000, R6_OR => 20)
);

$this->btc[B6_MARCHE]=array(
		"vie"	=>	10000,
		"limite"	=>	1,
		"tours"	=>	5,
		"bonus" 	=>  array('gen' => 300, 'bon' => 40),
		"prix_res"	=>	array(R6_BOIS => 200, R6_PIERRE => 200, R6_OR => 200),
		"com"	=>	array(S6_ARME_1 => array(COM_MAX_NB3,COM_MAX_VENTES3))
);
//</btc>

//<unt>
//<unt-1>
$this->unt[U6_DRESSEUR] = array(
	'vie' => 30,
	'group' => 1,
	'role' => TYPE_UNT_INFANTERIE,
	'prix_res' => array(R6_MITHRIL => 5, R6_FER => 20, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 10,
	'atq_unt' => 10,
	'vit' => 12,
	'rang' => 1,
);
//</unt-1>

//<unt-2>
$this->unt[U6_SOLDAT] = array(
	'vie' => 20,
	'group' => 1,
	'role' => TYPE_UNT_CAVALERIE,
	'prix_res' => array(R6_ACIER => 10, R6_CHARBON => 20, R6_COTTE_MAILLE => 1, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 30,
	'atq_unt' => 10,
	'vit' => 12,
	'rang' => 3,
	'bonus' => array(
		'vie' => 1),
);
//</unt-2>

//<unt-3>
$this->unt[U6_ELITE] = array(
	'vie' => 20,
	'group' => 1,
	'role' => TYPE_UNT_DISTANCE,
	'prix_res' => array(R6_ACIER => 10, R6_MITHRIL => 3, R6_CHARBON => 20, R6_COTTE_MITHRIL => 1, R6_EPEE_LON => 2, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 10,
	'atq_unt' => 30,
	'atq_btc' => 8,
	'vit' => 12,
	'rang' => 8,
	'bonus' => array(
		'atq' => 0.5),
);
//</unt-3>

//<unt-4>
$this->unt[U6_PAPANOEL] = array(
	'vie' => 30000,
	'group' => 2,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R6_PIERRE => 1000, R6_NOURRITURE => 50000, R6_CHARBON => 1000, R6_COTTE_MAILLE => 1000, R6_B_ACIER => 1000, R6_BOIS => 1000, R6_ACIER => 1000, R6_MITHRIL => 1000, R6_FER => 1000, R6_CHEVAUX => 1000, R6_B_BOIS => 1000, R6_EPEE_LON => 1000, R6_EPEE => 1000, R6_ARC => 1000, R6_ARBALETE => 1000, R6_COTTE_MITHRIL => 1000, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 2000,
	'atq_unt' => 0,
	'atq_btc' => 0,
	'vit' => 1,
	'rang' => 8,
	'bonus' => array(
		'atq' => 30.0),
);
//</unt-4>

//<unt-8>
$this->unt[U6_MERENOEL] = array(
	'vie' => 6000,
	'group' => 2,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R6_PIERRE => 1500, R6_NOURRITURE => 50000, R6_CHARBON => 1500, R6_COTTE_MAILLE => 1500, R6_B_ACIER => 1500, R6_BOIS => 1500, R6_ACIER => 1500, R6_MITHRIL => 1500, R6_FER => 1500, R6_CHEVAUX => 1500, R6_B_BOIS => 3000, R6_EPEE_LON => 1500, R6_EPEE => 3000, R6_ARC => 1500, R6_ARBALETE => 1500, R6_COTTE_MITHRIL => 1500, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 1000,
	'atq_unt' => 0,
	'atq_btc' => 0,
	'vit' => 1,
	'rang' => 8,
	'bonus' => array(
		'atq' => 30.0),
);
//</unt-8>

//<unt-11>
$this->unt[U6_COUPLE] = array(
	'vie' => 30000,
	'group' => 2,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R6_PIERRE => 1000, R6_NOURRITURE => 50000, R6_CHARBON => 1000, R6_COTTE_MAILLE => 1000, R6_B_ACIER => 1000, R6_BOIS => 1000, R6_ACIER => 1000, R6_MITHRIL => 1000, R6_FER => 1000, R6_CHEVAUX => 1000, R6_B_BOIS => 1000, R6_EPEE_LON => 1000, R6_EPEE => 1000, R6_ARC => 1000, R6_ARBALETE => 1000, R6_COTTE_MITHRIL => 1000, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 18000,
	'atq_unt' => 6000,
	'atq_btc' => 0,
	'vit' => 1,
	'rang' => 8,
	'bonus' => array(
		'atq' => 30.0),
);
//</unt-11>

//<unt-9>
$this->unt[U6_GARDE1] = array(
	'vie' => 2500,
	'group' => 3,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R6_PIERRE => 500, R6_NOURRITURE => 50000, R6_CHARBON => 500, R6_COTTE_MAILLE => 500, R6_B_ACIER => 500, R6_BOIS => 500, R6_ACIER => 500, R6_MITHRIL => 500, R6_FER => 500, R6_CHEVAUX => 500, R6_B_BOIS => 1000, R6_EPEE_LON => 500, R6_EPEE => 1000, R6_ARC => 500, R6_ARBALETE => 500, R6_COTTE_MITHRIL => 500, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 800,
	'atq_unt' => 2000,
	'atq_btc' => 0,
	'vit' => 10,
	'rang' => 8,
	'bonus' => array(
		'atq' => 30.0),
);
//</unt-9>

//<unt-10>
$this->unt[U6_GARDE2] = array(
	'vie' => 5500,
	'group' => 3,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R6_PIERRE => 500, R6_NOURRITURE => 50000, R6_CHARBON => 500, R6_COTTE_MAILLE => 500, R6_B_ACIER => 500, R6_BOIS => 500, R6_ACIER => 500, R6_MITHRIL => 500, R6_FER => 500, R6_CHEVAUX => 500, R6_B_BOIS => 1000, R6_EPEE_LON => 500, R6_EPEE => 1000, R6_ARC => 500, R6_ARBALETE => 500, R6_COTTE_MITHRIL => 500, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 3500,
	'atq_unt' => 3500,
	'atq_btc' => 0,
	'vit' => 10,
	'rang' => 8,
	'bonus' => array(
		'atq' => 30.0),
);
//</unt-10>

//<unt-12>
$this->unt[U6_GARDE3] = array(
	'vie' => 11000,
	'group' => 3,
	'role' => TYPE_UNT_HEROS,
	'prix_res' => array(R6_PIERRE => 500, R6_NOURRITURE => 50000, R6_CHARBON => 500, R6_COTTE_MAILLE => 500, R6_B_ACIER => 500, R6_BOIS => 500, R6_ACIER => 500, R6_MITHRIL => 500, R6_FER => 500, R6_CHEVAUX => 500, R6_B_BOIS => 1000, R6_EPEE_LON => 500, R6_EPEE => 1000, R6_ARC => 500, R6_ARBALETE => 500, R6_COTTE_MITHRIL => 500, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 3500,
	'atq_unt' => 5000,
	'atq_btc' => 0,
	'vit' => 10,
	'rang' => 8,
	'bonus' => array(
		'atq' => 30.0),
);
//</unt-12>

//<unt-5>
$this->unt[U6_GROSLUTIN] = array(
	'vie' => 50,
	'group' => 4,
	'role' => TYPE_UNT_DISTANCE,
	'prix_res' => array(R6_ACIER => 30, R6_MITHRIL => 60, R6_CHARBON => 60, R6_COTTE_MITHRIL => 30, R6_EPEE_LON => 30, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 30,
	'atq_unt' => 30,
	'atq_btc' => 1,
	'vit' => 12,
	'rang' => 1,
	'bonus' => array(
		'atq' => 0.5),
);
//</unt-5>

//<unt-6>
$this->unt[U6_SOLIDELUTIN] = array(
	'vie' => 50,
	'group' => 4,
	'role' => TYPE_UNT_DISTANCE,
	'prix_res' => array(R6_ACIER => 30, R6_MITHRIL => 60, R6_CHARBON => 60, R6_COTTE_MITHRIL => 30, R6_EPEE_LON => 30, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 30,
	'atq_unt' => 10,
	'atq_btc' => 1,
	'vit' => 12,
	'rang' => 2,
	'bonus' => array(
		'atq' => 0.5),
);
//</unt-6>

//<unt-7>
$this->unt[U6_LUTIN_MALIN] = array(
	'vie' => 25,
	'group' => 4,
	'role' => TYPE_UNT_DISTANCE,
	'prix_res' => array(R6_ACIER => 60, R6_MITHRIL => 120, R6_CHARBON => 120, R6_COTTE_MITHRIL => 60, R6_EPEE_LON => 50, ),
	'need_btc' => array(B6_DONJON, ),
	'in_btc' => array(B6_DONJON, ),
	'def' => 25,
	'atq_unt' => 12,
	'atq_btc' => 1,
	'vit' => 12,
	'rang' => 3,
	'bonus' => array(
		'atq' => 0.5),
);
//</unt-7>



//</unt>

//<src>
$this->src[S6_ARME_1]=array(
		"tours"	=>	10,
		"group"	=>	1,
		"prix_res"	=>	array(R6_BOIS => 10, R6_PIERRE => 10),
		"need_btc" => array(B6_DONJON),
);
//</src>

/* compétences du ou des héros = aucune (aucun héros) */

//<comp>
$this->comp = array();
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
	'primary_res'	=>	array(R6_OR, R6_NOURRITURE),
	'second_res'	=>	array(R6_OR, R6_BOIS, R6_PIERRE, R6_NOURRITURE, R6_FER , R6_CHARBON, R6_ACIER),
	'primary_btc'	=>	array(
		'vil'	=>	array( B6_DONJON => array('unt')),
		'ext'	=>	array( B6_MARCHE => array('ach'))
		),
	'bonus_res'	=>	array(R6_OR => 0.05),
	'modif_pts_btc'	=>	10,
	'debut'	=>	array(
		'res'	=>	array(R6_OR => 10000, R6_BOIS => 10000, R6_PIERRE => 10000, R6_NOURRITURE => 500000),
		'unt'	=> 	array(U6_DRESSEUR => 1),
		'btc'	=> 	array(B6_DONJON => array()),
		'src'	=>	array(S6_ARME_1)),
	'bonus_map' => array(MAP_EAU => 0, MAP_LAC => 0, MAP_HERBE => 2, MAP_MONTAGNE => 0, MAP_FORET => 0),
	'bonus_period' => array(PERIODS_JOUR => 0, PERIODS_NUIT => 0, PERIODS_AUBE => 0, PERIODS_CREP => 0),
	);

}
}
?>
