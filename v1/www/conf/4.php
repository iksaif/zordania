<?
/*************************************************************************
* Configuration de la race drow en fr                                    *
*                                                                        *
*                                                                        *
*                                                                        *
* Update : 08/05/05 19:00                     Création : 09/03/05  15:46 *
*************************************************************************/
class config4
{
var $res;
var $btc;
var $unt;
var $src;
var $race_cfg;

//**************************************************************//
//
//   1-"or", - important
//   2-"bois", 
//   3-"pierre", - important
//   4-"nourriture", 
//   5-"fer", - important
//   6-"charbon", -important
//   7-"worgs", 
//   8-"acier", 
//   9-"mithril", 
//  10-"bouclier",
//  11-"massue",
//  12-"hache",
//  13-"hallebarde",
//  14-"arc",
//  15-"arbalète",
//  16-"cotte noire",
//  17-"cotte de mithril",
//  18-"forêt",
//  19-"gisement de fer",
//  20-"gisement de charbon",
//  21-"filon d'or",
//  22-"population", 
//  23-"montagne",
//
//**************************************************************//

//**************************************************************//
//                      °o Ressources	o°						            //
//	Certains array sont vides mais c normal :)		              //
//needress 	-> idress*nbress+idress2*nbress2		                //
//needsrc 	-> idsrc					                                  //
//needbat	-> idbat					                                    //
//import	-> important					                                //
//nobat 	-> ne peu pas bouger (être vendu)		                  //
//**************************************************************//
function config4()
{

$this->race_cfg = array(
 	'primary_res' => array(1,4,22),
 	'second_res'  => array(1,2,3,4,5,6,8,9,18,19,20,21,22,23),
 	'primary_btc' => array('vil' => array(1 => array('unt','src'),6 => array('unt'),9 => array('unt'),17 => array('unt'),11 => array('unt'),18 => array('unt'),14 => array('res'),22 => array('unt'),20 => array('unt'),21 => array('unt'),23 => array('unt')), 'ext' => array(8 => array('ach'))),
 	'bonus_res'   => array(1 => 0.05, 2 => 0.040, 3 => 0.040, 4 => 0.075, 5 => 0.025, 6 => 0.025, 8 => 0.02),
 	'modif_pts_btc' => 1
 );
 
$this->res=array();

//or - important
$this->res[1]=array(
		"onlycron"	=> true,
		"needbat"	=>	7,
		);

//bois
$this->res[2]=array(
    "onlycron"	=> true,
		"needbat"	=>	3,
		);

//pierre - important
$this->res[3]=array(
		"onlycron"	=> true,
		"needbat"	=>	2,
		);

//nourriture 
$this->res[4]=array(
		"onlycron"	=> true,
		"needbat"	=>	5,
		);

//fer - important
$this->res[5]=array(
		"onlycron"	=> true,
		"needbat"	=>	13,
		);

//charbon - important
$this->res[6]=array(
		"onlycron"	=> true,
		"needbat"	=>	12,
		);

//worgs
$this->res[7]= array(
		"needres"	=>	array(4 => 150,8 => 4),
		"needsrc"	=>	8,
		"needbat"	=>	18,
		);
		
//acier
$this->res[8]=array(
		"needres"	=>	array(6 => 2,5 => 2),
		"needsrc"	=>	6,
		"needbat"	=>	10,
		);

//mithril
$this->res[9]=array();

//bouclier
$this->res[10]=array(
		"needres" =>	array(8 => 1),
		"needsrc"	=>	3,
		"needbat"	=>	14,
		"group"		=>	10,
		);
		
//massue
$this->res[11]=array(
		"needres"	=>	array(8 => 2),
		"needsrc"	=>	2,
		"needbat"	=>	14,
		"group"		=>	11,
		);
	
//hache
$this->res[12]=array(
		"needres"	=>	array(8 => 1,2 => 1),
		"needsrc"	=>	1,
		"needbat"	=>	14,
		"group"		=>	11,
		);
	
//hallebarde
$this->res[13]=array(
		"needres"	=>	array(8 => 2,2 => 2),
		"needsrc"	=>	2,
		"needbat"	=>	14,
		"group"		=>	11,
		);

//arc
$this->res[14]=array(
		"needres"	=>	array(8 => 1,2 => 1),
		"needsrc"	=>	1,
		"needbat"	=>	14,
		"group"		=>	14,
		);
		
//arbalète
$this->res[15]=array(
		"needres"	=>	array(8 => 2,2 => 2),
		"needsrc"	=>	2,
		"needbat"	=>	14,
		"group"		=>	14,
		);
	
//cotte noire
$this->res[16]=array(
		"needres"	=>	array(8 => 2),
		"needsrc"	=>	3,
		"needbat"	=>	14,
		"group"		=>	16,
		);
		
//cotte de mithril
$this->res[17]=array(
		"needres"	=>	array(9 => 1),
		"needsrc"	=>	4,
		"needbat"	=>	14,
		"group"		=>	16,
		);
		
$this->res[18] = array('nobat' => true);
$this->res[19] = array('nobat' => true);
$this->res[20] = array('nobat' => true);
$this->res[21] = array('nobat' => true);
$this->res[22] = array('nobat' => true);
$this->res[23] = array('nobat' => true);
	
//**************************************************************//
//                      °o Batîments o°  							          //
//Lise des atribut:						                                  //
//defense 	: pour faire mal a ceux qui attaquent		            //
//vie 		: soliditée					                                  //
//population 	: le nombre de gens qu'il peu y avoir dedans	    //
//prix 		: ce que ca fait depenser			                        //
//		: idress*nbress+idress2*nbress2 		                      //
//		: a voir ca ca peu changer			                          //
//produit	: production marche comme le prix mais par tour       //
//		: si necessite autre chose : idress*x                     //
//tours		: nb de tours avec un travailleur		                  //
//needbat	: besoin de idbat-idbat pour être dispo		            //
//needsrc	: besoin de idsrc-idsrc pour être dispo		            //
//needguy	: besoin de idunit pour être construit et 	          //
//                fonctionner					                          //
//**************************************************************//


//Nid,
$this->btc[1]=array(
		"bonusdef"	=>	10,
		"vie"		=>	1000,
		"population"	=>	30,
		"limite"	=>	1,
		"btcopt"	=>	array("src" => true, "unt" => true,"def" => true,"pop" => true)
		);

//Carrière,
$this->btc[2]=array(
		"vie"		=>	250,
		"prix"		=>	array(2 => 5, 3 => 8,23 => 1),
		"tours"		=>	5,
		"needbat"	=>	array(1 => true),
		"produit"	=>	array(3 => 2),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
		);

//Scierie,		
$this->btc[3]=array(
		"vie"		=>	250,
		"prix"		=>	array(2 => 5, 3 => 8,18 => 1),
		"tours"		=>	5,
		"needbat"	=>	array(1 => true),
		"produit"	=>	array(2 => 1),
		"needguy"	=>	array(6 => 1),
		"btcopt"	=>	array("prod" => true)
		);

//Habitation,
$this->btc[4]=array(
		"vie"		=>	200,
		"population" 	=> 	8,
		"tours"		=>	8,
		"prix"		=>	array(2 => 10,3 => 20),
		"needbat"	=>	array(2 => true,3 => true),
		"limite"	=>	30,
		"btcopt"	=>	array("pop" => true)
);
		
//Aire de Chasse,
$this->btc[5]=array(
		"vie"		=>	200,
		"tours"		=>	8,
		"produit"	=>	array(4 => 10),
		"prix"		=>	array(2 => 10, 3 => 20,),
		"needbat"	=>	array(2 => true, 3 => true),
		"needguy"	=>	array(2 => 1),
		"limite"	=>	30,
		"btcopt"	=>	array("prod" => true)
);

//Serre de Combat,
$this->btc[6]=array(
		"vie"		=>	300,
		"tours"		=>	15,
		"needsrc"	=>	14,
		"prix"		=>	array(2 => 16, 3 => 24),
		"needbat"	=>	array(4 => true, 5 => true),
		"needguy"	=>	array(7 => 1),
		"limite"	=>	5,
		"btcopt"	=>	array("unt" => true)
);

//Galerie d'or,
$this->btc[7]=array(
		"vie"		=>	300,
		"tours"		=>	50,
		"needsrc"	=>	17,
		"produit"	=>	array(1 => 2),
		"prix"		=>	array(2 => 45,3 => 55,21 => 1),
		"needbat"	=>	array(4 => true,5 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);
	
//Marché,
$this->btc[8]=array(
		"vie"		=>	600,
		"tours"		=>	120,
		"needsrc"   =>  11,
		"prix"		=>	array(2 => 90, 3 => 185,1 => 50),
		"needguy"	=>	array(1 => 2),
		"needbat"	=>	array(4 => true,5 => true),
		"limite"	=>	1,
		"btcopt"	=>	array("com" => array(11 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
									12 => array(COM_MAX_NB2,COM_MAX_VENTES2),
									13 => array(COM_MAX_NB3,COM_MAX_VENTES3)
									)
						),
);

//Maison des Lames,
$this->btc[9]=array(
		"vie"		=>	500,
		"tours"		=>	150,
		"prix"		=>	array(2 => 100, 3 => 150),
		"needsrc"   =>  15,
		"needbat"	=>	array(6 => true, 7 => true),
		"needguy"	=>	array(1 => 1, 7 => 1),
		"limite"	=>	5,
		"btcopt"	=>	array("unt" => true)
);
		
//Fonderie,
$this->btc[10]=array(
		"vie"		=>	600,
		"prix"		=>	array(2 => 160,3 => 240,5 => 50,6 => 50),
		"tours"		=>	150,
		"needbat"	=>	array(12 => true,13 => true),
		"needguy"	=>	array(4 => 1),
		"needsrc"	=>	6,
		"produit"	=>	array(8 => 1),
		"limite"	=>	3,
		"btcopt"	=>	array("prod" => true)
		);
		
//Aire de dressage,
$this->btc[11]=array(
		"vie"		=>	300,
		"tours"		=>	20,
		"prix"		=>	array(2 => 80, 3 => 120),
		"needsrc"   =>  7,
		"needbat"	=>	array(9 => true),
		"needguy"	=>	array(1 => 1, 2 => 1, 3 => 2),
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
);

//Galerie de Charbon,
$this->btc[12]=array(
		"vie"		=>	300,
		"tours"		=>	100,
		"produit"	=>	array(6 => 1),
		"prix"		=>	array(2 => 70,3 => 90,20 => 1),
		"needsrc"   =>  18,
		"needbat"	=>	array(6 => true, 7 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Galerie de Fer,
$this->btc[13]=array(
		"vie"		=>	300,
		"tours"		=>	100,
		"produit"	=>	array(5 => 1),
		"prix"		=>	array(2 => 70,3 => 90,19 => 1),
		"needsrc"   =>  18,
		"needbat"	=>	array(6 => true, 7 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
		);

//Forge,
$this->btc[14]=array(
		"vie"		=>	600,
		"tours"		=>	250,
		"needsrc"	=>	1,
		"prix"		=>	array(2 => 100,3 => 150,1 => 50,8 => 20),
		"needbat"	=>	array(10 => true),
		"needguy"	=>	array(4 => 1),
		"limite"	=>	5,
		"btcopt"	=>	array("res" => true)
);

//Guilde des Chasseurs,
$this->btc[15]=array(
		"vie"		=>	400,
		"tours"		=>	80,
		"produit"	=>	array(4 => 15),
		"prix"		=>	array(2 => 20, 3 => 40, 7 => 2),
		"needbat"	=>	array(18 => true),
		"needguy"	=>	array(2 => 2),
		"limite" => 20,
		"btcopt"	=>	array("prod" => true)
);

//Avant-poste,
$this->btc[16]=array(
		"bonusdef"	=>	5.5,
		"defense"	=>	25,
		"vie"		=>	950,
		"tours"		=>	150,
		"def_prio"	=>	true,
		"needsrc"	=>	5,
		"prix"		=>	array(2 => 100,3 => 300, 8 => 20),
		"needguy"	=>	array(12 => 4),
		"limite"	=>	4,
		"btcopt"	=>	array("def" => true)
);

//Guilde des Lames,
$this->btc[17]=array(
		"vie"		=>  1000,
		"needsrc"	=>  10,
		"prix"		=> array(2 => 250,3 => 350,8 => 50),
		"tours"		=>	500,
		"needbat"   => array(18 => true),
		"needguy"	=> array(1 => 2,7 => 2),
		"limite"	=>	5,
		"btcopt"	=>	array("unt" => true)
		);

//Guilde des Dresseurs,
$this->btc[18]=array(
		"vie"		=> 400,
		"needsrc"	=> 8,
		"prix"		=> array(2 => 180, 3 => 220,8 => 30),
		"tours"		=> 400,
		"needbat" 	=> array(11 => true),
		"needguy"	=> array(1 => 1,2 => 2,3 => 2),
		"limite"	=> 3,
		"btcopt"	=>	array("res" => true, "unt" => true)
	);

//Demeure
$this->btc[19]=array(
		"vie"		=>	200,
		"population" => 15,
		"tours"		=>	20,
		"prix"		=>	array(2 => 10,3 => 20),
		"needbat"	=>	array(17 => true),
		"limite" => 20,
		"btcopt"	=>	array("pop" => true)
		);

//Temple
$this->btc[20]=array(
		"vie"		=>	800,
		"prix"		=>	array(2 => 125, 3 => 175,1 => 200,9 => 20),
		"tours"		=>	350,
		"needbat"	=>	array(17 => true),
		"needguy"	=>	array(1 => 3),
		"needsrc"	=>	19,
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
		);
		
//Autel
$this->btc[21]=array(
		"vie"		=>	500,
		"prix"		=>	array(3 => 200,1 => 100,9 => 15),
		"tours"		=>	300,
		"needbat"	=>	array(20 => true),
		"needsrc"	=>	21,
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
		);
		
//Guilde des Forgerons
$this->btc[22]=array(
		"vie"		=>	500,
		"prix"		=>	array(3 => 200,2 => 200,1 => 150),
		"tours"		=>	300,
		"needbat"	=>	array(20 => true),
		"needguy"	=>	array(4 => 2,1 => 1),
		"needsrc"	=>	20,
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
		);
		
//Autel des Matrones
$this->btc[23]=array(
		"vie"		=>	900,
		"prix"		=>	array(3 => 500,2 => 100,1 => 300,9 => 25),
		"tours"		=>	500,
		"needbat"	=>	array(20 => true),
		"limite"	=>	1,
		"btcopt"	=>	array("unt" => true)
		);
		
//Cité noire
$this->btc[24]=array(
		"defense"	=>	450,
		"bonusdef"	=>	22,
		"def_prio"	=>	true,
		"vie"		=>	4600,
		"population" 	=> 	80,
		"prix"		=>	array(3 => 4500,2 => 1500,8 => 400),
		"tours"		=>	750,
		"needbat"	=>	array(23 => true),
		"needguy" =>  array(14 => 10),
		"limite"	=>	1,
		"btcopt"	=>	array("unt" => true, "src" => true,"def" => true,"pop" => true)
		);

//*******************************//
// Unités                        //
//*******************************//


//Esclave Serviteur
$this->unt[1]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	1,
		"type"		=>	TYPE_UNT_CIVIL,
		);
//Chasseur
$this->unt[2]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	2,
		"type"		=>	TYPE_UNT_CIVIL,
		);	
//Dresseur
$this->unt[3]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	2,
		"type"		=>	TYPE_UNT_CIVIL,
		);	
//Forgeron
$this->unt[4]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	2,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Esclave Mineur
$this->unt[5]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	5,
		"type"		=>	TYPE_UNT_CIVIL,
		);				
//Esclave Bûcheron
$this->unt[6]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	5,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Convoqué
$this->unt[7]=array(
		"prix"		=>	array(1 => 3),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	6,
		"type"		=>	TYPE_UNT_CIVIL,
		);			
//Combattant
$this->unt[8]=array(
		"defense"	=>	1,
		"vie"		=>	2,
		"attaque"	=>	2,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"needsrc" => 14,
		"prix"		=>	array(1 => 1,2 => 3),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	8,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
		);

//Assassin
$this->unt[9]=array(
		"defense"	=>	2,
		"vie"		=>	4,
		"attaque"	=>	5,
		"attaquebat"	=>	0,
		"speed"		=>	6,
		"needsrc" => 15,
		"prix"		=>	array(12 => 1),
		"needbat"	=>	array(9 => true),
		"inbat"		=>	array(9 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	9,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
		);
		
//Ombre
$this->unt[10]=array(
		"defense"	=>	3,
		"vie"		=>	6,
		"attaque"	=>	7,
		"attaquebat"	=>	0,
		"speed"		=>	7,
		"needsrc" => 15,
		"prix"		=>	array(12 => 1,10 => 1),
		"needbat"	=>	array(9 => true),
		"inbat"		=>	array(9 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	9,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);
		
//Brigand
$this->unt[11]=array(
		"defense"	=>	4,
		"vie"		=>	5,
		"attaque"	=>	2,
		"attaquebat"	=>	0,
		"speed"		=>	5,
		"needsrc" => 15,
		"prix"		=>	array(14 => 1),
		"needbat"	=>	array(9 => true),
		"inbat"		=>	array(9 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	11,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Capuche Noire
$this->unt[12]=array(
		"defense"	=>	6,
		"vie"		=>	8,
		"attaque"	=>	4,
		"attaquebat"	=>	0,
		"speed"		=>	6,
		"needsrc" => 15,
		"prix"		=>	array(14 => 1,10 => 1),
		"needbat"	=>	array(9 => true),
		"inbat"		=>	array(9 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	11,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Hallebardier noir
$this->unt[13]=array(
		"defense"	=>	10,
		"vie"		=>	12,
		"attaque"	=>	16,
		"attaquebat"	=>	1,
		"speed"		=>	14,
		"needsrc" => 16,
		"prix"		=>	array(7 => 1, 10 => 1,13 => 1,16 => 1),
		"needbat"	=>	array(17 => true),
		"inbat"		=>	array(17 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Arbalètrier noir
$this->unt[14]=array(
		"defense"	=>	14,
		"vie"		=>	14,
		"attaque"	=>	10,
		"attaquebat"	=>	0,
		"speed"		=>	12,
		"needsrc" => 16,
		"prix"		=>	array(7 => 1, 10 => 1,15 => 1,16 => 1),
		"needbat"	=>	array(17 => true),
		"inbat"		=>	array(17 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Géant des Roches
$this->unt[15]=array(
		"defense"	=>	14,
		"vie"		=>	25,
		"attaque"	=>	20,
		"attaquebat"	=>	17,
		"speed"		=>	6,
		"needsrc" => 16,
		"prix"		=>	array(4 => 200, 11 => 1, 3 => 30, 17 => 1, 9 => 2),
		"needbat"	=>	array(17 => true),
		"inbat"		=>	array(17 => true),
		"needguy"	=>	array(3 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_CREATURE,
);

//Ailes nocturnes
$this->unt[16]=array(
		"defense"	=>	3,
		"vie"		=>	6,
		"attaque"	=>	4,
		"attaquebat"	=>	0,
		"speed"		=>	15,
		"needsrc" => 7,
		"prix"		=>	array(4 => 50, 8 => 2),
		"needbat"	=>	array(11 => true),
		"inbat"		=>	array(11 => true),
		"needguy"	=>	array(3 => 1),
		"group"		=>	16,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Arachnide Tisseuse
$this->unt[17]=array(
		"defense"	=>	6,
		"vie"		=>	12,
		"attaque"	=>	5,
		"attaquebat"	=>	2,
		"speed"		=>	12,
		"needsrc" => 7,
		"prix"		=>	array(4 => 200, 8 => 5),
		"needbat"	=>	array(11 => true),
		"inbat"		=>	array(11 => true),
		"needguy"	=>	array(3 => 2),
		"group"		=>	16,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"  => UNT_ROLE_CREATURE,
);

//Worg Guerrier
$this->unt[18]=array(
		"defense"	=>	3,
		"vie"		=>	10,
		"attaque"	=>	10,
		"attaquebat"	=>	3,
		"speed"		=>	10,
		"needsrc" => 8,
		"prix"		=>	array(4 => 300, 8 => 2),
		"needbat"	=>	array(18 => true),
		"inbat"		=>	array(18 => true),
		"needguy"	=>	array(3 => 2),
		"group"		=>	18,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"  => UNT_ROLE_CREATURE,
		);
		
//Arachnide Guerrière
$this->unt[19]=array(
		"defense"	=>	16,
		"vie"		=>	18,
		"attaque"	=>	10,
		"attaquebat"	=>	5,
		"speed"		=>	8,
		"needsrc" => 8,
		"prix"		=>	array(4 => 300,8 => 8,1 => 3),
		"needbat"	=>	array(18 => true),
		"inbat"		=>	array(18 => true),
		"needguy"	=>	array(3 => 3),
		"group"		=>	18,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"  => UNT_ROLE_CREATURE,
		);

//Basilic
$this->unt[20]=array(
		"defense"	=>	6,
		"vie"		=>	12,
		"attaque"	=>	12,
		"attaquebat"	=>	40,
		"speed"		=>	6,
		"needsrc" => 9,
		"prix"		=>	array(4 => 200,3 => 10,8 => 2,9 => 3),
		"needbat"	=>	array(18 => true),
		"inbat"		=>	array(18 => true),
		"needguy"	=>	array(3 => 4),
		"group"		=>	18,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"  => UNT_ROLE_MONTEE,
);

//Prêtresse de la Nuit
$this->unt[21]=array(
		"defense"	=>	15,
		"vie"		=>	20,
		"attaque"	=>	9,
		"attaquebat"	=>	2,
		"speed"		=>	6,
		"needsrc" => 20,
		"prix"		=>	array(5 => 8,6 => 8,9 => 1,1 => 12,8 => 2),
		"needbat"	=>	array(20 => true),
		"inbat"		=>	array(20 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	21,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);
	
//Clerc de la Nuit
$this->unt[22]=array(
		"defense"	=>	9,
		"vie"		=>	20,
		"attaque"	=>	15,
		"attaquebat"	=>	2,
		"speed"		=>	6,
		"needsrc" => 21,
		"prix"		=>	array(5 => 8,6 => 8,9 => 1,1 => 12,8 => 2),
		"needbat"	=>	array(20 => true),
		"inbat"		=>	array(20 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	21,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);	

//Maître-Lame
$this->unt[23]=array(
		"defense"	=>	10,
		"vie"		=>	20,
		"attaque"	=>	16,
		"attaquebat"	=>	5,
		"speed"		=>	12,
		"bonus"  => array('def' => 1/4,'atq' => 1/2),
		"needsrc" => 20,
		"prix"		=>	array(17 => 1,12 => 1,7 => 1,10 => 1),
		"needbat"	=>	array(22 => true),
		"inbat"		=>	array(22 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	23,
		//"limite"	=>	30,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);

//Gardienne
$this->unt[24]=array(  
	  	"defense"	=>	16,
		"vie"		=>	25,
		"attaque"	=>	10,
		"attaquebat"	=>	4,
		"speed"		=>	10,
		"bonus"  	=> 	array('def' => 1/2,'atq' => 1/4),
		"needsrc" 	=> 	21,
		"prix"		=>	array(17 => 1,15 => 1,7 => 1,10 => 1),
		"needbat"	=>	array(21 => true),
		"inbat"		=>	array(21 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	23,
		//"limite"	=>	30,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);

//Envoyée de Lolth
$this->unt[25]=array(  
    "defense"	=>	60,
		"vie"		=>	120,
		"attaque"	=>	80,
		"attaquebat"	=>	60,
		"speed"		=>	20,
		"needsrc" => 22,
		"prix"		=>	array(1 => 200,9 => 10,4 => 500,8 => 40),
		"needbat"	=>	array(23 => true),
		"inbat"		=>	array(23 => true),
		"group"		=>	25,
		"limite"	=>	1,
		"needguy"	=>	array(4 => 3),
		"type"		=>	TYPE_UNT_INFANTERIE,
		"bonus"		=>	array('atq' => 30),
		"role"  => UNT_ROLE_DISTANCE,
		);
		
//Envoyée d'Eilistraée
$this->unt[26]=array(  
    "defense"	=>	80,
		"vie"		=>	140,
		"attaque"	=>	60,
		"attaquebat"	=>	40,
		"speed"		=>	20,
		"needsrc" => 23,
		"prix"		=>	array(1 => 200,9 => 10,4 => 500,8 => 40),
		"needbat"	=>	array(23 => true),
		"inbat"		=>	array(23 => true),
		"group"		=>	25,
		"limite"	=>	1,
		"needguy"	=>	array(4 => 3),
		"type"		=>	TYPE_UNT_INFANTERIE,
		"bonus"		=>	array('def' => 30),
		"role"  => UNT_ROLE_DISTANCE,
		);
	
//*************************************//
//          °o Recherches o°           //
//                                     //
// 'maxdst' = distance max pour        //
//            échange (defaut 5)       //
//*************************************//

//Armes niv1,
$this->src[1]=array(
		"tours"		=>	4,
		"needsrc"	=>	6,
		"prix"		=>	array(5 => 20,6 => 20,8 => 10,2 => 25,3 => 25),
		"group"		=>	1,
);

//Armes niv2,
$this->src[2]=array(
		"tours"		=>	8,
		"needsrc"	=>	 1,
		"prix"		=>	array(5 => 30, 6 => 30 ,8 => 25 ,2 => 50 ,3 => 50, 9 => 10, 1 => 20),
		"group"		=>	1,
);

//Défense niv1,
$this->src[3]=array(
		"tours"		=>	4,
		"needsrc"	=>	6,
		"prix"		=>	array(5 => 30, 6 => 30, 8 => 20),
		"group"		=>	3,
);

//Défense niv2,
$this->src[4]=array(
		"tours"		=>	8,
		"needsrc"	=>	3,
		"prix"		=>	array(5 => 40, 6 => 40, 8 => 30, 9 => 10, 1 => 40),
		"group"		=>	3,
);

//Fortifications,
$this->src[5]=array(
		"tours"		=>	20,
		"needbat" 	=>  array(14 => true),
		"prix"		=>	array(2 => 150, 3 => 250, 8 => 100, 9 => 10),
		"group"		=>	3,
);

//Fonte de l'acier,
$this->src[6]=array(
		"tours"		=>	32,
		"needsrc"	=>	18,
		"prix"		=>	array(1 => 80, 5 => 150,6 => 150),
		"group"		=>	6,
);

//Dressage niv1,
$this->src[7]=array(
		"tours"		=>	8,
		"prix"		=>	array(1 => 50, 4 => 500, 2 => 40, 3 => 60),
		"group"		=>	7,
);

//Dressage niv2,
$this->src[8]=array(
		"tours"		=>	16,
		"needsrc"	=>	7,
		"prix"		=>	array(1 => 80, 4 => 1000, 2 => 80, 3 => 100, 8 => 10, 9 => 10),
		"group"		=>	7,
);

//Dressage niv3,
$this->src[9]=array(
		"tours"		=>	24,
		"needsrc"	=>	8,
		"prix"		=>	array(1 => 150, 4 => 1500, 2 => 120, 3 => 150, 8 => 50, 9 => 20),
		"group"		=>	7,
);

//Attelage,
$this->src[10]=array(
		"tours"		=>	20,
		"needsrc"	=>	8,
		"prix"		=>	array(4 => 800,8 => 40, 2 => 50, 3 => 50, 7 => 10),
		"group"		=>	10,
);

//Commerce niv1,
$this->src[11]=array(
		"tours"		=>	8,
		"prix"		=>	array(1 => 60),
		"group"		=>	11,
);

//Commerce niv2,
$this->src[12]=array(
		"tours"		=>	20,
		"needsrc"	=>	11,
		"prix"		=>	array(1 => 200, 4 => 1000, 9 => 20),
		"group"		=>	11,
);

//Commerce niv3,
$this->src[13]=array(
		"tours"		=>	40,
		"needsrc"	=>	12,
		"prix"		=>	array(1 => 500, 4 => 3500, 2 => 250, 3 => 300, 9 => 50),
		"group"		=>	11,
);

//Armée niv1,
$this->src[14]=array(
		"tours"		=>	8,
		"prix"		=>	array(1 => 25, 4 => 100, 2 => 25),
		"group"		=>	14,
);

//Armée niv2,
$this->src[15]=array(
		"tours"		=>	20,
		"needsrc"	=>	14,
		"prix"		=>	array(1 => 75, 4 => 200, 5 => 75, 6 => 75),
		"group"		=>	14,
);

//Armée niv3,
$this->src[16]=array(
		"tours"		=>	40,
		"needsrc"	=>	15,
		"prix"		=>	array(1 => 200, 8 => 125, 2 => 100, 3 => 140, 9 => 10),
		"group"		=>	14,
);

//Galeries niv1,
$this->src[17]=array(
		"tours"		=>	8,
		"prix"		=>	array(2 => 20,3 => 30),
		"group"		=>	17,
);

//Galeries niv2,
$this->src[18]=array(
		"tours"		=>	12,
		"needsrc"	=>	17,
		"prix"		=>	array(2 => 60, 3 => 100, 1 => 30),
		"group"		=>	17,
);

//Don de la Nuit,
$this->src[19]=array(
		"tours"		=>	80,
		"needbat"	=>	array(17 => true),
		"prix"		=>	array(1 => 120,8 => 75,9 => 25,3 => 150),
		"group"		=>	19,
);

//Prêtresse de la Nuit,
$this->src[20]=array(
		"tours"		=>	40,
		"needbat"	=>	array(20 => true),
		"incompat"  =>  21,
		"prix"		=>	array(4 => 500,8 => 60,9 => 15,1 => 200),
		"group"		=>	20,
);

//Clerc de la Nuit,
$this->src[21]=array(
		"tours"		=>	40,
    		"needbat"	=>	array(20 => true),
		"incompat"  =>  20,
		"prix"		=>	array(4 => 500,8 => 60,9 => 15,1 => 200),
		"group"		=>	20,
);

//Don de Lolth,
$this->src[22]=array(
		"tours"		=>	100,
		"needbat"	=>	array(23 =>true),
		"incompat"  =>  23,
		"prix"		=>	array(1 => 300,9 => 30,4 => 3000,8 => 160),
		"group"		=>	22,
);

//Don d'Eilistraée,
$this->src[23]=array(
		"tours"		=>	100,
		"needbat"	=>	array(23 => true),
		"incompat"  =>  22,
		"prix"		=>	array(1 => 300,9 => 30,4 => 3000,8 => 160),
		"group"		=>	22,
);

}
}
?>