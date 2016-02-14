<?
/*************************************************************************
* Configuration de la race elfe en fr                                    *
*                                                                        *
*                                                                        *
*                                                                        *
* Update : 08/05/05 19:00                     Création : 23/03/06  21:23 *
*************************************************************************/
class config5
{
var $res;
var $btc;
var $unt;
var $src;
var $race_cfg;

//**************************************************************//
//
//   1-"or", - important
//   2-"bois", - important
//   3-"pierre",
//   4-"baies", 
//   5-"bois d'if",
//   6-"cuir",
//   7-"chevaux", 
//   8-"acier", 
//   9-"mithril", 
//  10-"rondache",
//  11-"pavois",
//  12-"lame",
//  13-"pique",
//  14-"arc court",
//  15-"arc composite",
//  16-"armure de cuir cloutée",
//  17-"harnois de mithril",
//  18-"forêt",
//  19-"forêt d'if",
//  20-"zone de chasse",
//  21-"montagne",
//  22-"population", 
//  23-"village",
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
function config5()
{

$this->race_cfg = array(
 	'primary_res' => array(1,4,22),
 	'second_res'  => array(1,2,3,4,5,6,8,9,18,19,20,21,22,23),
 	'primary_btc' => array('vil' => array(1 => array('unt','src'),8 => array('unt'),11 => array('res'),12 => array('res'),14 => array('unt'),15 => array('res'),19 => array('unt'),20 => array('unt'),21 => array('unt'),22 => array('unt'),23 => array('unt')), 'ext' => array(9 => array('ach'))),
 	'bonus_res'   => array(1 => 0.05, 2 => 0.040, 3 => 0.040, 4 => 0.075, 5 => 0.025, 6 => 0.025, 8 => 0.02),
 	'modif_pts_btc' => 1
 );
 
$this->res=array();

//or - important
$this->res[1]=array(
		"onlycron"	=> true,
		"needbat"	=>	5,
		);

//bois - important
$this->res[2]=array(
    		"onlycron"	=> true,
		"needbat"	=>	2,
		);

//pierre 
$this->res[3]=array();

//baies
$this->res[4]=array(
		"onlycron"	=> true,
		"needbat"	=>	4,
		);

//bois d'if
$this->res[5]=array(
		"onlycron"	=> true,
		"needbat"	=>	7,
		);

//cuir
$this->res[6]=array(
		"onlycron"	=> true,
		"needbat"	=>	6,
		);

//chevaux
$this->res[7]= array(
		"needres"	=>	array(4 => 150,8 => 4),
		"needsrc"	=>	13,
		"needbat"	=>	15,
		);
		
//acier
$this->res[8]=array(
		"onlycron"	=> true,
		"needsrc"	=>	12,
		"needbat"	=>	10,
		);

//mithril
$this->res[9]=array();

//rondache
$this->res[10]=array(
		"needres" 	=>	array(2 => 2,5 => 1,6 => 1),
		"needsrc"	=>	4,
		"needbat"	=>	12,
		"group"		=>	10,
		);
		
//pavois
$this->res[11]=array(
		"needres"	=>	array(2 => 4,5 => 2,6 => 2,8 => 1),
		"needsrc"	=>	5,
		"needbat"	=>	12,
		"group"		=>	10,
		);
	
//lame
$this->res[12]=array(
		"needres"	=>	array(2 => 1,6 => 1,8 => 1),
		"needsrc"	=>	2,
		"needbat"	=>	12,
		"group"		=>	12,
		);
	
//pique
$this->res[13]=array(
		"needres"	=>	array(2 => 2,6 => 2,8 => 2),
		"needsrc"	=>	3,
		"needbat"	=>	12,
		"group"		=>	12,
		);

//arc court
$this->res[14]=array(
		"needres"	=>	array(5 => 2,6 => 1,8 => 1),
		"needsrc"	=>	2,
		"needbat"	=>	11,
		"group"		=>	14,
		);
		
//arc composite
$this->res[15]=array(
		"needres"	=>	array(2 => 2,5 => 4,6 => 2,8 => 1),
		"needsrc"	=>	3,
		"needbat"	=>	11,
		"group"		=>	14,
		);
	
//armure de cuir cloutée
$this->res[16]=array(
		"needres"	=>	array(6 => 4,8 => 2),
		"needsrc"	=>	4,
		"needbat"	=>	12,
		"group"		=>	16,
		);
		
//harnois de mithril
$this->res[17]=array(
		"needres"	=>	array(6 => 8,8 => 1,9 => 1),
		"needsrc"	=>	5,
		"needbat"	=>	12,
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


//Colonie,
$this->btc[1]=array(
		"bonusdef"	=>	10,
		"vie"		=>	1000,
		"population"	=>	25,
		"limite"	=>	1,
		"btcopt"	=>	array("src" => true, "unt" => true,"def" => true,"pop" => true)
		);

//Maison de Forestier,
$this->btc[2]=array(
		"vie"		=>	250,
		"prix"		=>	array(2 => 10,18 => 1),
		"tours"		=>	5,
		"needbat"	=>	array(1 => true),
		"produit"	=>	array(2 => 3),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
		);

//Maison,		
$this->btc[3]=array(
		"vie"		=>	200,
		"population" 	=> 	5,
		"prix"		=>	array(2 => 25),
		"tours"		=>	10,
		"needbat"	=>	array(2 => true),
		"limite"	=>	35,
		"btcopt"	=>	array("pop" => true)
		);

//Maison de cueillette,
$this->btc[4]=array(
		"vie"		=>	250,
		"prix"	=>	array(2 => 30),
		"tours"	=>	10,
		"needbat"	=>	array(2 => true),
		"needguy"	=>	array(2 => 1),
		"produit"	=>	array(4 => 8),
		"limite"	=>	75,
		"btcopt"	=>	array("prod" => true)
);
		
//Troupe,
$this->btc[5]=array(
		"vie"		=>	350,
		"tours"		=>	100,
		"needsrc"	=>	1,
		"produit"	=>	array(1 => 1),
		"prix"		=>	array(2 => 100,23 => 1),
		"needbat"	=>	array(3 => true,4 => true),
		"needguy"	=>	array(6 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Tanneur,
$this->btc[6]=array(
		"vie"		=>	400,
		"tours"		=>	100,
		"produit"	=>	array(6 => 1),
		"prix"		=>	array(2 => 120,20 => 1),
		"needbat"	=>	array(5 => true),
		"needguy"	=>	array(1 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Demeure de Forestier,
$this->btc[7]=array(
		"vie"		=>	400,
		"tours"		=>	100,
		"produit"	=>	array(5 => 1),
		"prix"		=>	array(2 => 120,19 => 1),
		"needbat"	=>	array(5 => true),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Aire d'entrainement,
$this->btc[8]=array(
		"vie"		=>	300,
		"tours"		=>	60,
		"needsrc"	=>	7,
		"prix"		=>	array(2 => 30,3 => 5),
		"needbat"	=>	array(5 => true),
		"needguy"	=>	array(1 => 1),
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
);
	
//Marché,
$this->btc[9]=array(
		"vie"		=>	600,
		"tours"		=>	120,
		"needsrc"       =>      9,
		"prix"		=>	array(2 => 200,1 => 50),
		"needguy"	=>	array(1 => 2),
		"needbat"	=>	array(5 => true),
		"limite"	=>	1,
		"btcopt"	=>	array("com" => array(9 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
									10 => array(COM_MAX_NB2,COM_MAX_VENTES2),
									11 => array(COM_MAX_NB3,COM_MAX_VENTES3)
									)
						),
);

//Comptoir de fonte,
$this->btc[10]=array(
		"vie"		=>	650,
		"tours"		=>	150,
		"produit"	=>	array(8 => 1),
		"prix"		=>	array(2 => 300,3 => 15,1 => 100,6 => 50),
		"needsrc"       =>      12,
		"needbat"	=>	array(9 => true),
		"needguy"	=>	array(1 => 1,4 => 1),
		"limite"	=>	2,
		"btcopt"	=>	array("prod" => true)
);
		
//Archerie,
$this->btc[11]=array(
		"vie"		=>	600,
		"prix"		=>	array(2 => 250,5 => 150,6 => 100,8 => 10),
		"tours"		=>	120,
		"needbat"	=>	array(10 => true),
		"needguy"	=>	array(3 => 1),
		"needsrc"	=>	2,
		"limite"	=>	3,
		"btcopt"	=>	array("res" => true)
		);
		
//Forge,
$this->btc[12]=array(
		"vie"		=>	650,
		"tours"		=>	250,
		"prix"		=>	array(2 => 250,3 => 20,5 => 50,6 => 150,8 => 20),
		"needsrc"       =>      2,
		"needbat"	=>	array(10 => true),
		"needguy"	=>	array(4 =>2),
		"limite"	=>	5,
		"btcopt"	=>	array("res" => true)
);

//Tour,
$this->btc[13]=array(
		"bonusdef"	=>	6,
		"defense"	=>	25,
		"vie"		=>	900,
		"tours"		=>	150,
		"def_prio"	=>	true,
		"prix"		=>	array(2 => 400,3 => 150,8 => 50),
		"needsrc"       =>      6,
		"needbat"	=>	array(11 => true),
		"needguy"	=>	array(12 => 4),
		"limite"	=>	4,
		"btcopt"	=>	array("def" => true)
);

//Caserne,
$this->btc[14]=array(
		"vie"		=>	800,
		"tours"		=>	250,
		"prix"		=>	array(2 => 300,3 => 50,1 => 100),
		"needsrc"       =>      8,
		"needbat"	=>	array(10 => true),
		"needguy"	=>	array(5 => 1),
		"limite"	=>	5,
		"btcopt"	=>	array("unt" => true)
		);

//Ecuries,
$this->btc[15]=array(
		"vie"		=>	500,
		"tours"		=>	300,
		"needsrc"	=>	13,
		"prix"		=>	array(2 => 500,6 => 200,8 => 50,4 => 400),
		"needbat"	=>	array(14 => true),
		"needguy"	=>	array(1 => 1),
		"limite"	=>	5,
		"btcopt"	=>	array("res" => true)
);

//Théâtre,
$this->btc[16]=array(
		"vie"		=>	600,
		"tours"		=>	120,
		"needsrc"	=>	14,
		"produit"	=>	array(1 => 3),
		"prix"		=>	array(2 => 200,3 => 50,5 => 100,6 => 100,23 => 1),
		"needbat"	=>	array(14 => true),
		"needguy"	=>	array(6 => 2),
		"btcopt"	=>	array("prod" => true)
);

//Bibliothèque,
$this->btc[17]=array(
		"vie"		=>	800,
		"tours"		=>	120,
		"needsrc"	=>	15,
		"prix"		=>	array(2 => 200,3 => 100,5 => 100),
		"needbat"	=>	array(14 => true),
		"needguy"	=>	array(1 => 1),
		"limite"	=>	1,
		//"btcopt"	=>	
);

//Demeure,
$this->btc[18]=array(
		"vie"		=>      150,
		"prix"		=>      array(2 => 20,3 => 10),
		"tours"		=>	25,
		"population" 	=> 	10,
		"needbat"       =>      array(17 => true),
		"limite"	=>	30,
		"btcopt"	=>	array("pop" => true)
		);

//Bosquet,
$this->btc[19]=array(
		"vie"		=>      600,
		"needsrc"	=>      17,
		"prix"		=>      array(2 => 400,5 => 300),
		"tours"		=>      300,
		"needbat" 	=>      array(17 => true),
		"needguy"	=>      array(1 => 1),
		"limite"	=>      3,
		"btcopt"	=>	array("unt" => true)
	);

//Antre,
$this->btc[20]=array(
		"vie"		=>	800,
		"needsrc"	=>      18,
		"tours"		=>	400,
		"prix"		=>	array(2 => 500,5 => 400,3 => 100,4 => 600),
		"needbat"	=>	array(19 => true),
		"needguy"	=>      array(16 => 1),
		"limite"        =>      3,
		"btcopt"	=>	array("unt" => true)
		);

//Ecole de magie,
$this->btc[21]=array(
		"vie"		=>	800,
		"prix"		=>	array(2 => 300, 3 => 100,1 => 200,5 => 150,9 => 20),
		"tours"		=>	250,
		"needbat"	=>	array(17 => true),
		"needguy"	=>	array(7 => 2),
		"needsrc"	=>	16,
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
		);
		
//Fort,
$this->btc[22]=array(
		"vie"		=>	1000,
		"prix"		=>	array(2 => 400,3 => 150),
		"tours"		=>	300,
		"needbat"	=>	array(17 => true),
		"needguy"	=>	array(5 => 1,7 => 2),
		"needsrc"	=>	array(19 => true,20 => true),
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
		);
	
//Temple,
$this->btc[23]=array(
		"vie"		=>	800,
		"prix"		=>	array(3 => 250,3 => 200,5 => 200,1 => 150,9 => 50),
		"tours"		=>	400,
		"needbat"	=>	array(21 => true,22 => true),
		"needguy"	=>	array(1 => 2,7 => 2),
		"needsrc"	=>	array(21 => true,22 => true),
		"limite"	=>	3,
		"btcopt"	=>	array("unt" => true)
		);
	
//Cité Sylvestre
$this->btc[24]=array(
		"defense"	=>	500,
		"bonusdef"	=>	22,
		"def_prio"	=>	true,
		"vie"		=>	5000,
		"population" 	=> 	100,
		"prix"		=>	array(2 => 5000,5 => 1000,3 => 2000,6 => 500,8 => 400,9 => 100),
		"tours"		=>	750,
		"needbat"	=>	array(23 => true),
		"needguy"       =>      array(15 => 10),
		"limite"	=>	1,
		"btcopt"	=>	array("unt" => true, "src" => true,"def" => true,"pop" => true)
		);

//*******************************//
// Unités                        //
//*******************************//


//Serviteur
$this->unt[1]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	1,
		"type"		=>	TYPE_UNT_CIVIL,
		);
//Cueilleur
$this->unt[2]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	2,
		"type"		=>	TYPE_UNT_CIVIL,
		);	
//Forestier
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
//Acolyte
$this->unt[5]=array(
		"prix"		=>	array(1 => 3),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	5,
		"type"		=>	TYPE_UNT_CIVIL,
		);				
//Barde
$this->unt[6]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	6,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Noble
$this->unt[7]=array(
		"prix"		=>	array(1 => 4),
		"vie"		=>	1,
		"needbat"	=>	array(17 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	7,
		"type"		=>	TYPE_UNT_CIVIL,
		);			
//Eclaireur
$this->unt[8]=array(
		"defense"	=>	1,
		"vie"		=>	4,
		"attaque"	=>	3,
		"attaquebat"	=>	0,
		"speed"		=>	6,
		"needsrc"       =>      7,
		"prix"		=>	array(1 => 1,2 => 3,6 => 2),
		"needbat"	=>	array(8 => true),
		"inbat"		=>	array(8 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	8,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_INFANTERIE,
		);

//Patrouilleur
$this->unt[9]=array(
		"defense"	=>	3,
		"vie"		=>	5,
		"attaque"	=>	1,
		"attaquebat"	=>	0,
		"speed"		=>	4,
		"needsrc"       =>      7,
		"prix"		=>	array(1 => 1,5 => 3,6 => 2),
		"needbat"	=>	array(8 => true),
		"inbat"		=>	array(8 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	8,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
		);
		
//Rôdeur
$this->unt[10]=array(
		"defense"	=>	8,
		"vie"		=>	10,
		"attaque"	=>	8,
		"attaquebat"	=>	1,
		"speed"		=>	8,
		"needsrc"       =>      8,
		"prix"		=>	array(10 => 1,12 => 1,16 => 1),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	10,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_INFANTERIE,
);
		
//Lancier
$this->unt[11]=array(
		"defense"	=>	4,
		"vie"		=>	10,
		"attaque"	=>	12,
		"attaquebat"	=>	2,
		"speed"		=>	6,
		"needsrc"       =>      8,
		"prix"		=>	array(10 => 1,13 => 1,16 => 1),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	10,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_INFANTERIE,
);

//Archer
$this->unt[12]=array(
		"defense"	=>	12,
		"vie"		=>	12,
		"attaque"	=>	4,
		"attaquebat"	=>	0,
		"speed"		=>	4,
		"needsrc"       =>      8,
		"prix"		=>	array(14 => 1,16 => 1),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	10,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
);

//Epéiste
$this->unt[13]=array(
		"defense"	=>	14,
		"vie"		=>	14,
		"attaque"	=>	14,
		"attaquebat"	=>	1,
		"speed"		=>	10,
		"needsrc"       =>      8,
		"prix"		=>	array(11 => 1,12 => 1,16 => 1),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_INFANTERIE,
);

//Piquier
$this->unt[14]=array(
		"defense"	=>	10,
		"vie"		=>	14,
		"attaque"	=>	18,
		"attaquebat"	=>	3,
		"speed"		=>	8,
		"needsrc"       =>      8,
		"prix"		=>	array(11 => 1,13 => 1,16 => 1),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_INFANTERIE,
);

//Garde
$this->unt[15]=array(
		"defense"	=>	18,
		"vie"		=>	16,
		"attaque"	=>	10,
		"attaquebat"	=>	0,
		"speed"		=>	4,
		"needsrc"       =>      8,
		"prix"		=>	array(15 => 1,16 => 1),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(5 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
);

//Druide
$this->unt[16]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(19 => true),
		"inbat"		=>	array(1 => true, 24 => true),
		"group"		=>	16,
		"type"		=>	TYPE_UNT_CIVIL,
);

//Nymphe
$this->unt[17]=array(
		"defense"	=>	6,
		"vie"		=>	20,
		"attaque"	=>	20,
		"attaquebat"	=>	5,
		"speed"		=>	12,
		"needsrc"       =>      17,
		"prix"		=>	array(1 => 20,4 => 50,5 => 10,9 => 1),
		"needbat"	=>	array(19 => true),
		"inbat"		=>	array(19 => true),
		"needguy"	=>	array(16 => 1),
		"group"		=>	17,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"          =>      UNT_ROLE_CREATURE,
);

//Vénérable
$this->unt[18]=array(
		"defense"	=>	10,
		"vie"		=>	30,
		"attaque"	=>	10,
		"attaquebat"	=>	100,
		"speed"		=>	2,
		"needsrc"       =>      18,
		"prix"		=>	array(2 => 130,4 => 200,5 => 12),
		"needbat"	=>	array(20 => true),
		"inbat"		=>	array(20 => true),
		"needguy"	=>	array(16 => 3),
		"group"		=>	18,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"          =>      UNT_ROLE_CREATURE,
		);
		
//Commandant
$this->unt[19]=array(
		"defense"	=>	5,
		"vie"		=>	20,
		"attaque"	=>	20,
		"attaquebat"	=>	0,
		"speed"		=>	12,
		"bonus"         =>      array('atq' => 1),
		"needsrc"       =>      20,
		"prix"		=>	array(7 => 1,11 => 1,13 => 1,17 =>1),
		"needbat"	=>	array(22 => true),
		"inbat"		=>	array(22 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	19,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_MONTEE,
		);

//Garde d'élite
$this->unt[20]=array(
		"defense"	=>	20,
		"vie"		=>	20,
		"attaque"	=>	5,
		"attaquebat"	=>	0,
		"speed"		=>	10,
		"bonus"         =>      array('def' => 1),
		"needsrc"       =>      19,
		"prix"		=>	array(7 => 1,15 => 1,17 => 1),
		"needbat"	=>	array(22 => true),
		"inbat"		=>	array(22 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	20,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
);

//Mage
$this->unt[21]=array(
		"defense"	=>	8,
		"vie"		=>	25,
		"attaque"	=>	30,
		"attaquebat"	=>	10,
		"speed"		=>	9,
		"needsrc"       =>      16,
		"prix"		=>	array(1 => 15,4 => 150,5 => 10,6 => 10,9 => 2,17 => 1),
		"needbat"	=>	array(21 => true),
		"inbat"		=>	array(21 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	21,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
);
	
//Gardien
$this->unt[22]=array(
		"defense"	=>	22,
		"vie"		=>	25,
		"attaque"	=>	10,
		"attaquebat"	=>	0,
		"speed"		=>	4,
		"needsrc"       =>      16,
		"prix"		=>	array(1 => 8,4 => 100,5 => 12,9 => 1,17 => 1),
		"needbat"	=>	array(21 => true),
		"inbat"		=>	array(21 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	21,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
);	

//Avatar de Corellon Larethian
$this->unt[23]=array(
		"defense"	=>	100,
		"vie"		=>	140,
		"attaque"	=>	80,
		"bonus"         =>      array('def' => 30),
		"attaquebat"	=>	80,
		"speed"		=>	14,
		"needsrc"       =>      22,
		"prix"		=>	array(1 => 200,9 => 10,8 => 20,4 => 500,15 => 1,17 => 1,7 => 1),
		"needbat"	=>	array(23 => true),
		"inbat"		=>	array(23 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	23,
		"limite"	=>	1,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
);

//Avatar de Aerdrie Faenya
$this->unt[24]=array(  
	  	"defense"	=>	80,
		"vie"		=>	120,
		"attaque"	=>	100,
		"bonus"         =>      array('atq' => 30),
		"attaquebat"	=>	120,
		"speed"		=>	20,
		"needsrc" 	=> 	21,
		"prix"		=>	array(1 => 250,9 => 10,8 => 30,4 => 500,17 => 1),
		"needbat"	=>	array(23 => true),
		"inbat"		=>	array(23 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	24,
		"limite"	=>	1,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"          =>      UNT_ROLE_DISTANCE,
);

	
//*************************************//
//          °o Recherches o°           //
//                                     //
// 'maxdst' = distance max pour        //
//            échange (defaut 5)       //
//*************************************//

//Arts musicaux,
$this->src[1]=array(
		"tours"		=>	4,
		"prix"		=>	array(2 => 30,4 => 50),
		"group"		=>	1,
);

//Armes niv1,
$this->src[2]=array(
		"tours"		=>	5,
		"needbat"	=>	array(10 => true),
		"prix"		=>	array(2 => 50,5 => 30,6 => 30,8 => 20),
		"group"		=>	2,
);

//Armes niv2,
$this->src[3]=array(
		"tours"		=>	10,
		"needsrc"	=>	2,
		"prix"		=>	array(1 => 30,2 => 75,5 => 50,6 => 50,8 => 30),
		"group"		=>	2,
);

//Défense niv1,
$this->src[4]=array(
		"tours"		=>	10,
		"needbat" 	=>      array(10 => true),
		"prix"		=>	array(2 => 30,5 => 25,6 => 40,8 => 30),
		"group"		=>	4,
);

//Défense niv2,
$this->src[5]=array(
		"tours"		=>	15,
		"needsrc" 	=>      4,
		"prix"		=>	array(1 => 75,2 => 40,5 => 30,6 => 60,8 => 40,9 => 10),
		"group"		=>	4,
);

//Fortifications,
$this->src[6]=array(
		"tours"		=>	30,
		"needsrc"	=>	5,
		"prix"		=>	array(2 => 300,3 => 100,8 => 100,9 => 15),
		"group"		=>	4,
);

//Armée niv1,
$this->src[7]=array(
		"tours"		=>	10,
		"needbat" 	=>      array(5 => true),
		"prix"		=>	array(1 => 25,4 => 200,2 => 40),
		"group"		=>	7,
);

//Armée niv2,
$this->src[8]=array(
		"tours"		=>	25,
		"needsrc"	=>	7,
		"prix"		=>	array(1 => 75,4 => 500,2 => 75,5 => 50,6 => 50),
		"group"		=>	7,
);

//Commerce niv1,
$this->src[9]=array(
		"tours"		=>	8,
		"needbat" 	=>      array(5 => true),
		"prix"		=>	array(1 => 50),
		"group"		=>	9,
);

//Commerce niv2,
$this->src[10]=array(
		"tours"		=>	20,
		"needsrc"	=>	9,
		"prix"		=>	array(1 => 200,4 => 1000,9 => 10,6 => 100),
		"group"		=>	9,
);

//Commerce niv3,
$this->src[11]=array(
		"tours"		=>	40,
		"needsrc"	=>	10,
		"prix"		=>	array(1 => 500,4 => 4000,9 => 20,3 => 100),
		"group"		=>	9,
);

//Fonte de l'acier,
$this->src[12]=array(
		"tours"		=>	25,
		"needbat" 	=>      array(9 => true),
		"prix"		=>	array(1 => 120,6 => 50),
		"group"		=>	12,
);

//Attelage,
$this->src[13]=array(
		"tours"		=>	30,
		"needbat" 	=>      array(14 => true),
		"prix"		=>	array(4 => 3000,6 => 150,8 => 50),
		"group"		=>	13,
);

//Arts dramatiques,
$this->src[14]=array(
		"tours"		=>	25,
		"needbat" 	=>      array(14 => true),
		"prix"		=>	array(1 => 150,4 => 1500,2 => 150),
		"group"		=>	14,
);

//Connaissances niv1,
$this->src[15]=array(
		"tours"		=>	20,
		"needbat" 	=>      array(14 => true),
		"prix"		=>	array(1 => 120,2 => 75,3 => 50,6 => 75,9 => 10),
		"group"		=>	15,
);

//Connaissances niv2,
$this->src[16]=array(
		"tours"		=>	40,
		"needsrc"	=>	15,
		"prix"		=>	array(1 => 200,2 => 150,3 => 75,6 => 120,9 => 25),
		"group"		=>	15,
);

//Druidisme niv1,
$this->src[17]=array(
		"tours"		=>	25,
		"needbat" 	=>      array(17 => true),
		"prix"		=>	array(1 => 150,2 => 200,4 => 2000,5 => 250),
		"group"		=>	17,
);

//Druidisme niv2,
$this->src[18]=array(
		"tours"		=>	50,
		"needsrc"	=>	17,
		"prix"		=>	array(1 => 250,2 => 500,4 => 6000,5 => 400),
		"group"		=>	17,
);

//Maitrise Défensive,
$this->src[19]=array(
		"tours"		=>	60,
		"needbat"	=>	array(17 => true),
		"incompat"      =>      20,
		"prix"		=>	array(2 => 150,5 => 200,6 => 300,8 => 50,9 => 30),
		"group"		=>	19,
);

//Maitrise Offensive,
$this->src[20]=array(
		"tours"		=>	60,
		"needbat"	=>	array(17 => true),
		"incompat"      =>      19,
		"prix"		=>	array(2 => 150,5 => 300,6 => 200,8 => 50,9 => 30),
		"group"		=>	20,
);

//Fidélité en Aerdrie Faenya,
$this->src[21]=array(
		"tours"		=>	100,
    		"needbat"	=>	array(21 => true,22 => true),
		"incompat"      =>      22,
		"prix"		=>	array(1 => 300,9 => 30,4 => 3000,8 => 150),
		"group"		=>	21,
);

//Fidélité en Corellon Larethian,
$this->src[22]=array(
		"tours"		=>	100,
		"needbat"	=>	array(21 => true,22 => true),
		"incompat"      =>      21,
		"prix"		=>	array(1 => 300,9 => 30,4 => 3000,8 => 150),
		"group"		=>	22,
);

}
}
?>