<?
/*************************************************************************
* Configuration de la race orcs                                          *
*                                                                        *
* Update : 08/05/05 19:00                     Création : 17/01/04  19:10 *
*************************************************************************/
class config2
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
//   3-"pierre",
//   4-"nourriture", - important
//   5-"fer",
//   6-"charbon",
//   7-"loup",
//   8-"acier",
//   9-"mitryl"
//  10-"armure 1",
//  11-"armure 2",
//  12-"epee",
//  13-"hache",
//  14-"arc",
//  15-"lance",
//  16-"armure 3",
//  17-"armure mirtyl"
//  18-"Emplacement bois",
//  19-"Emplacement fer",
//  20-"Emplacement charbon",
//  21-"Emplacement or",
//  22-"Population", -important
//  23-"Montagne",
//
//**************************************************************//

/*
|[9-15] +1
|[16-21] +2
*/

//**************************************************************//
// Ressources							//
//	Certains array sont vides mais c normal :)		//
//needress 	-> idress*nbress+idress2*nbress2		//
//needsrc 	-> idsrc					//
//needbat	-> idbat					//
//nobat 	-> ne peu pas bouger (être vendu)		//
//**************************************************************//
function config2()
{

$this->race_cfg = array(
	'primary_res' => array(1,4,22),
	'second_res'  => array(1,2,3,4,5,6,8,18,19,20,21,22,23),
	'primary_btc' => array('vil' => array(1 => array('unt','src'),6 => array('unt'),9 => array('res'),13 => array('unt'),14 => array('res'),16 => array('unt'),17 => array('unt')), 'ext' => array(8 => array('ach'))),
	'bonus_res'   => array(1 => 0.03, 2 => 0.040, 3 => 0.040, 4 => 0.075, 5 => 0.025, 6 => 0.025, 8 => 0.020),
	'modif_pts_btc' => 1.1
	);
	
$this->res=array();
//or - important
$this->res[1]=array(
		"onlycron"	=> true,
		"needbat"	=>	7);

//bois
$this->res[2]=array(
		"onlycron"	=> true,
		"needbat"	=>	3);

//pierre
$this->res[3]=array(
		"onlycron"	=> true,
		"needbat"	=>	2);

//nourriture - important
$this->res[4]=array(
		"onlycron"	=> true,
		"needbat"	=>	5);

//fer
$this->res[5]=array(
		"onlycron"	=> true,
		"needbat"	=>	11);

//charbon
$this->res[6]=array(
		"onlycron"	=> true,
		"needbat"	=>	10);

//loup
$this->res[7]=array(
		"needres"	=>	array(4 => 150,8 => 2),
		"needsrc"	=>	9,
		"needbat"	=>	14,
		"group"		=>	7,
		);

//acier
$this->res[8]=array(
		"onlycron"	=> true,
		"needres"	=>	array(6 => 2,5 => 2),
		"needsrc"	=>	8,
		"needbat"	=>	12
		);
		
//mitril
$this->res[9]=array(
		"group" => 10
		);
				
//armure 1
$this->res[10]=array(
		"needres"	=>	array(2 => 1),
		"needsrc"	=>	5,
		"needbat"	=>	9,
		"group"		=>	10,
		);
		
//armure 2
$this->res[11]=array(
		"needres"	=>	array(2 => 2,6 => 1, 5 => 1),
		"needsrc"	=>	6,
		"needbat"	=>	9,
		"group"		=>	10,
		);
	
//epee
$this->res[12]=array(
		"needres"	=>	array(2 => 2), //,5 => 1,6 => 1
		"needsrc"	=>	1,
		"needbat"	=>	9,
		"group"		=>	12,
		);
	
//hache
$this->res[13]=array(
		"needres"	=>	array(8 => 2,6 => 1,5 => 1),
		"needsrc"	=>	2,
		"needbat"	=>	9,
		"group"		=>	12,
		);

//arc
$this->res[14]=array(
		"needres"	=>	array(2 => 3),
		"needsrc"	=>	3,
		"needbat"	=>	9,
		"group"		=>	14,
		);
		
//lance
$this->res[15]=array(
		"needres"	=>	array(2 => 1,8 => 2,6 => 1,5 => 1),
		"needsrc"	=>	4,
		"needbat"	=>	9,
		"group"		=>	14,
		);
	
//armure 3
$this->res[16]=array(
		"needres"	=>	array(8 => 3),
		"needsrc"	=>	7,
		"needbat"	=>	9,
		"group"		=>	16,
		);

//armure 3
$this->res[17]=array(
		"needres"	=>	array(9 => 1),
		"needsrc"	=>	7,
		"needbat"	=>	9,
		"group"		=>	17,
		);		
$this->res[18] = array('nobat' => true);
$this->res[19] = array('nobat' => true);
$this->res[20] = array('nobat' => true);
$this->res[21] = array('nobat' => true);
$this->res[22] = array('nobat' => true);
$this->res[23] = array('nobat' => true);

	
//**************************************************************//
// Batîments  							//
//Lise des atribut:						//
//defense 	: pour faire mal a ceux qui attaquent		//
//vie 		: soliditée					//
//population 	: le nombre de gens qu'il peu y avoir dedans	//
//prix 		: ce que ca fait depenser			//
//		: idress*nbress+idress2*nbress2 		//
//		: a voir ca ca peu changer			//
//produit	: production marche comme le prix mais par tour //
//		: si necessite autre chose : idress*x           //
//tours		: nb de tours avec un travailleur		//
//needbat	: besoin de idbat-idbat pour être dispo		//
//needsrc	: besoin de idsrc-idsrc pour être dispo		//
//needguy	: besoin de idunit pour être construit et 	//
//                fonctionner					//
//**************************************************************//


//Donjon*
$this->btc[1]=array(
		"bonusdef"	=>	5,
		"vie"		=>	500,
		"population"	=>	10,
		"limite" => 2,
		"btcopt"	=>	array("unt" => true,"src" => true,"pop" => true,"def" => true),
		);

//Carrière*
$this->btc[2]=array(
		"vie"		=>	200,
		"prix"		=>	array(2 => 4,3 => 8, 23 => 1),
		"tours"		=>	5,
		"needbat"	=>	array(1 => true),
		"needguy"	=>	array(5 => 1),
		"produit"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
		);
		
//Scierie*
$this->btc[3]=array(
		"vie"		=>	200,
		"prix"		=>	array(3 => 8,2 => 4,18 => 1),
		"tours"		=>	5,
		"needbat"	=>	array(1 => true),
		"needguy"	=>	array(4 => 1),
		"produit"	=>	array(2 => 1),
		"btcopt"	=>	array("prod" => true)
		);

//hutte		
$this->btc[4]=array(
		"vie"		=>	250,
		"prix"		=>	array(2 => 12,3 => 15),
		"tours"		=>	6,
		"needbat"	=>	array(2 => true,3 => true),
		"population"	=>	10,
		"limite"	=>	53,
		"btcopt"	=>	array("pop" => true)
		);

//chasseur	
$this->btc[5]=array(
		"vie"		=>	250,
		"prix"		=>	array(2 => 12,3 => 15),
		"tours"		=>	7,
		"needbat"	=>	array(2 => true,3 => true),
		"produit"	=>	array(4 => 12),
		"needguy"	=>	array(2 => 1),
		"limite"	=>	50,
		"btcopt"	=>	array("prod" => true)
		);
		
//caserne
$this->btc[6]=array(
		"vie"		=>	500,
		"prix"		=>	array(2 => 45,3 => 45),
		"tours"		=>	30,
		"needbat"	=>	array(5 => true,4 => true),
		"needguy"	=>	array(6 => 1),
		"needsrc"	=>	12,
		"btcopt"	=>	array("unt" => true)
		);
	
//Mine d'or,*
$this->btc[7]=array(
		"vie"		=>	200,
		"tours"		=>	30,
		"needsrc"	=>	15,
		"produit"	=>	array(1 => 1),
		"prix"		=>	array(2 => 45,3 => 45, 21 => 1),
		"needbat"	=>	array(4 => true,5 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Marché,
$this->btc[8]=array(
		"vie"		=>	400,
		"tours"		=>	100,
		"needsrc" 	=> 10,
		"prix"		=>	array(2 => 180,3 => 200),
		"needguy"	=>	array(1 => 1),
		"needbat"	=>	array(4 => true,5 => true),
		"btcopt"	=>	array("com" => array(10 => array(COM_MAX_NB1,COM_MAX_VENTES1), 11 => array(COM_MAX_NB2,COM_MAX_VENTES2))),
);

//Armurerie,
$this->btc[9]=array(
		"vie"		=>	500,
		"tours"		=>	150,
		"needsrc"	=>	13,
		"prix"		=>	array(2 => 200,3 => 180),
		"needguy"	=>	array(4 => 1,3 => 1),
		"needbat"	=>	array(6 => true,7 => true),
		"btcopt"	=>	array("res" => true)
		);

//Mine de charbon,*
$this->btc[10]=array(
		"vie"		=>	200,
		"tours"		=>	100,
		"needsrc"	=>	16,
		"produit"	=>	array(6 => 1),
		"prix"		=>	array(2 => 60,3 => 50, 20 => 1),
		"needbat"	=>	array(6 => true,7 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Mine de fer,*
$this->btc[11]=array(
		"vie"		=>	200,
		"tours"		=>	100,
		"needsrc"	=>	16,
		"produit"	=>	array(5 => 1),
		"prix"		=>	array(2 => 50,3 => 60, 19 => 1),
		"needbat"	=>	array(6 => true,7 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Fonderie,
$this->btc[12]=array(
		"vie"		=>	500,
		"tours"		=>	250,
		"produit"	=>	array(8 => 1),
		"prix"		=>	array(2 => 250,3 => 280),
		"needsrc" => 8,
		"needbat"	=>	array(9 => true, 10 => true,11 => true),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Atelier,
$this->btc[13]=array(
		"vie"		=>	500,
		"tours"		=>	400,
		"needsrc"	=>	21,
		"prix"		=>	array(2 => 550,3 => 510),
		"needbat"	=>	array(9 => true,10 => true,11 => true),
		"needguy"	=>	array(3 => 1,4 => 1,6 => 1),
		"btcopt"	=>	array("unt" => true)
);

//louverie,
$this->btc[14]=array(
		"vie"		=>	500,
		"tours"		=>	400,
		"needsrc"	=>	9,
		"prix"		=>	array(2 => 330,3 => 330),
		"needbat"	=>	array(6 => true,7 => true,5 => true),
		"needguy"	=>	array(2 => 1),
		"btcopt"	=>	array("res" => true)
);

//Tours,
$this->btc[15]=array(
		"bonusdef"	=>	4,
		"defense"	=>	20,
		"vie"		=>	800,
		"tours"		=>	100,
		"needsrc"	=>	7,
		"def_prio"	=> true,
		"prix"		=>	array(2 => 250,3 => 300, 8 => 20),
		"needbat"	=>	array(6 => true,2 => true,12 => true),
		"needguy"	=>	array(12 => 4),
		"limite"	=> 4,
		"btcopt"	=>	array("def" => true)
);


//Temple
$this->btc[16]=array(
		"vie"		=>  250,
		"needsrc"	=> array(17 => true,18 => true),
		"prix"		=> array(2 => 100, 3 => 100, 1 => 100, 4 => 500),
		"tours"		=>	400,
		"needbat" 	=> array(6 => true, 14 => true),
		"btcopt"	=>	array("unt" => true)
		);

//Portail
$this->btc[17]=array(
		"vie"			=>  350,
		"needsrc"	=>  array(19 => true ,20 => true),
		"prix"		=> array(2 => 160, 3 => 180, 1 => 150, 4 => 750),
		"tours"		=>	400,
		"needbat" => array(16 => true),
		"btcopt"	=>	array("unt" => true)
	);

//Fortin
$this->btc[18]=array(
		"population" 	=> 100,
		"defense"	=> 350,
		"bonusdef"	=> 16,
		"vie"		=> 4000,
		"needguy"	=>	array(13 => 10),
		"prix"		=> array(2 => 3800, 3 => 4500, 8 => 400),
		"tours"		=> 2000,
		"def_prio"	=> true,
		"needbat" 	=> array(17 => true),
		"limite"	=> 1,
		"btcopt"	=>	array("unt" => true,"src" => true,"pop" => true,"def" => true)
		);

//*******************************//
// Unitées                       //
//*******************************//


//Travailleurs
$this->unt[1]=array(
		"prix"		=>	array(1 => 1, 4 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"	=>	array(1 => true,18 => true),
		"group"		=>	1,
		"type"		=>	TYPE_UNT_CIVIL,
		);
//Fermiers
$this->unt[2]=array(
		"prix"		=>	array(1 => 1, 4 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"	=>	array(1 => true,18 => true),
		"group"		=>	1,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Forgerons
$this->unt[3]=array(
		"prix"		=>	array(1 => 2, 4 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"	=>	array(1 => true,18 => true),
		"group"		=>	3,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Bucherons
$this->unt[4]=array(
		"prix"		=>	array(1 => 1, 4 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"	=>	array(1 => true,18 => true),
		"group"		=>	3,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Mineurs
$this->unt[5]=array(
		"prix"		=>	array(1 => 1, 4 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"	=>	array(1 => true,18 => true),
		"group"		=>	5,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
			
//Orc
$this->unt[6]=array(
		"prix"		=>	array(1 => 2, 4 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"	=>	array(1 => true,18 => true),
		"group"		=>	6,
		"type"		=>	TYPE_UNT_CIVIL,
		);		

//Soldat orc,
$this->unt[7]=array(
		"defense"	=>	1,
		"vie"		=>	1,
		"attaque"	=>	1,
		"attaquebat"	=>	0,
		"speed"		=>	7,
		"prix"		=>	array(1 => 1,2 => 1,4 => 2),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	7,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
		);

//Guerrier Epee I
$this->unt[8]=array(
		"defense"	=>	2,
		"vie"		=>	4,
		"attaque"	=>	2,
		"attaquebat"	=>	0,
		"speed"		=>	5,
		"needsrc" 	=> 	5,
		"prix"		=>	array(10 => 1,12 => 1,4 => 3),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	8,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Epee II
$this->unt[9]=array(
		"defense"	=>	5,
		"vie"		=>	8,
		"attaque"	=>	5,
		"attaquebat"	=>	0,
		"speed"		=>	5,
		"needsrc" 	=> 	6,
		"prix"		=>	array(11 => 1,12 => 1,4 => 4),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	8,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Epee III
$this->unt[10]=array(
		"defense"	=>	8,
		"vie"		=>	10,
		"attaque"	=>	9,
		"attaquebat"	=>	1,
		"speed"		=>	5,
		"needsrc" 	=> 	7,
		"prix"		=>	array(16 => 1,12 => 1,4 => 5),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	8,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Arc I
$this->unt[11]=array(
		"defense"	=>	2,
		"vie"		=>	3,
		"attaque"	=>	3,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"needsrc" 	=> 	5,
		"prix"		=>	array(10 => 1,14 => 1,4 => 3),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	11,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Guerrier Arc II
$this->unt[12]=array(
		"defense"	=>	4,
		"vie"		=>	6,
		"attaque"	=>	7,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"needsrc" 	=> 	6,
		"prix"		=>	array(11 => 1,14 => 1,4 => 4),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	11,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Guerrier Arc III
$this->unt[13]=array(
		"defense"	=>	6,
		"vie"		=>	10,
		"attaque"	=>	12,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"needsrc" 	=> 	7,
		"prix"		=>	array(16 => 1,14 => 1,4 => 5),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	11,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Guerrier Lance I
$this->unt[14]=array(
		"defense"	=>	5,
		"vie"		=>	4,
		"attaque"	=>	5,
		"attaquebat"	=>	0,
		"speed"		=>	5,
		"needsrc" 	=> 	5,
		"prix"		=>	array(10 => 1,15 => 1,4 => 3),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	14,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Lance II
$this->unt[15]=array(
		"defense"	=>	9,
		"vie"		=>	6,
		"attaque"	=>	8,
		"attaquebat"	=>	0,
		"speed"		=>	4,
		"needsrc" 	=> 	6,
		"prix"		=>	array(11 => 1,15 => 1,4 => 4),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	14,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Lance III
$this->unt[16]=array(
		"defense"	=>	12,
		"vie"		=>	9,
		"attaque"	=>	13,
		"attaquebat"	=>	1,
		"speed"		=>	4,
		"needsrc" 	=> 	7,
		"prix"		=>	array(16 => 1,15 => 1,4 => 5),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	14,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Hache I
$this->unt[17]=array(
		"defense"	=>	3,
		"vie"		=>	4,
		"attaque"	=>	5,
		"attaquebat"	=>	0,
		"speed"		=>	5,
		"needsrc" 	=> 	2,
		"prix"		=>	array(10 => 1,13 => 1,4 => 3),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	17,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Hache II
$this->unt[18]=array(
		"defense"	=>	5,
		"vie"		=>	8,
		"attaque"	=>	8,
		"attaquebat"	=>	1,
		"speed"		=>	6,
		"needsrc" 	=> 	2,
		"prix"		=>	array(11 => 1,13 => 1,4 => 4),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	17,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier Hache III
$this->unt[19]=array(
		"defense"	=>	8,
		"vie"		=>	12,
		"attaque"	=>	12,
		"attaquebat"	=>	2,
		"speed"		=>	6,
		"needsrc" 	=> 	2,
		"prix"		=>	array(16 => 1,13 => 1,4 => 5),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	17,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);


//Dresseur de loup
$this->unt[20]=array(
		"defense"	=>	6,
		"vie"		=>	8,
		"attaque"	=>	10,
		"attaquebat"	=>	1,
		"speed"		=>	12,
		"needsrc" 	=> 	5,
		"prix"		=>	array(10 => 1,13 => 1,4 => 3,7 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	20,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);

//Chevaucheur de loup
$this->unt[21]=array(
		"defense"	=>	8,
		"vie"		=>	12,
		"attaque"	=>	13,
		"attaquebat"	=>	2,
		"speed"		=>	11,
		"needsrc" 	=> 	6,
		"prix"		=>	array(11 => 1,13 => 1,4 => 4,7 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	20,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);

//Grand chevaucheur de loup
$this->unt[22]=array(
		"defense"	=>	10,
		"vie"		=>	16,
		"attaque"	=>	15,
		"attaquebat"	=>	3,
		"speed"		=>	10,
		"needsrc" 	=> 	7,
		"prix"		=>	array(16 => 1,13 => 1,4 => 5,7 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"	=>	array(6 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	20,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);

//Catapulte
$this->unt[23]=array(
		"defense"	=>	5,
		"vie"		=>	6,
		"attaque"	=>	8,
		"attaquebat"	=>	50,
		"speed"		=>	3,
		"needsrc" 	=> 14,
		"prix"		=>	array(3 => 10,2 => 10,8 => 5),
		"needbat"	=>	array(13 => true),
		"inbat"	=>	array(13 => true),
		"needguy"	=>	array(6 => 2),
		"group"		=>	23,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);

//Baliste
$this->unt[24]=array(
		"defense"	=>	10,
		"vie"		=>	6,
		"attaque"	=>	12,
		"attaquebat"	=>	30,
		"speed"		=>	3,
		"needsrc" 	=> 	14,
		"prix"		=>	array(3 => 10,2 => 10,8 => 5),
		"needbat"	=>	array(13 => true),
		"inbat"	=>	array(13 => true),
		"needguy"	=>	array(6 => 2),
		"group"		=>	24,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);
//Belier
$this->unt[25]=array(
		"defense"	=>	0,
		"vie"		=>	6,
		"attaque"	=>	0,
		"attaquebat"	=>	60,
		"speed"		=>	3,
		"needsrc" => 14,
		"prix"		=>	array(3 => 10,2 => 10,8 => 5),
		"needbat"	=>	array(13 => true),
		"inbat"	=>	array(13 => true),
		"needguy"	=>	array(6 => 3),
		"group"		=>	25,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);
//Gros belier
$this->unt[26]=array(
		"defense"	=>	0,
		"vie"		=>	10,
		"attaque"	=>	0,
		"attaquebat"	=>	120,
		"speed"		=>	2,
		"needsrc" 	=> 	14,
		"prix"		=>	array(3 => 75,2 => 75,8 => 25),
		"needbat"	=>	array(13 => true),
		"inbat"	=>	array(13 => true),
		"needguy"	=>	array(6 => 5),
		"group"		=>	25,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);
//Guerriseur
$this->unt[27]=array(
		"defense"	=>	8,
		"bonus"		=> 	array('def' => 1),
		"vie"		=>	10,
		"attaque"	=>	6,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"needsrc"	=>	17,
		"prix"		=>	array(4 => 50,1 => 10),
		"needbat"	=>	array(16 => true),
		"inbat"	=>	array(16 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	27,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
		
);
//Shaman
$this->unt[28]=array(
		"defense"	=>	6,
		"bonus"		=> 	array('atq' => 1),
		"vie"		=>	10,
		"attaque"	=>	8,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"prix"		=>	array(4 => 50,1 => 10),
		"needbat"	=>	array(16 => true),
		"inbat"	=>	array(16 => true),
		"needsrc"	=>	18,
		"needguy"	=>	array(6 => 1),
		"group"		=>	28,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);
//Troll
$this->unt[29]=array(
		"defense"	=>	12,
		"vie"		=>	20,
		"attaque"	=>	18,
		"attaquebat"	=>	14,
		"speed"		=>	7,
		"needsrc" 	=> 	19,
		"prix"		=>	array(17 => 1,13 => 2,4 => 150, 1 => 6),
		"needbat"	=>	array(17 => true),
		"inbat"	=>	array(17 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	29,
		"type"		=>	TYPE_UNT_CREATURE,
		"role"  => UNT_ROLE_CREATURE,
);
//Bersheker
$this->unt[30]=array(
		"defense"	=>	8,
		"vie"		=>	24,
		"attaque"	=>	24,
		"attaquebat"	=>	5,
		"speed"		=>	9,
		"needsrc" 	=> 	20,
		"prix"		=>	array(16 => 1,13 => 2,4 => 5,1 => 10, 7 => 1),
		"needbat"	=>	array(17 => true),
		"inbat"	=>	array(17 => true),
		"needguy"	=>	array(6 => 1),
		"group"		=>	30,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_CREATURE,
		);


//*******************************//
// Recherches                    //
// 'maxdst' = distance max pour  //
//            échange (defaut 5) //
//*******************************//
//!\\ REVOIR LES COUT DES RECHERCHES //!\\


//Epée,
$this->src[1]=array(
		"tours"		=>	10,
		"prix"		=>	array(2 => 20),
		"group"		=>	1,
);

//Hache,
$this->src[2]=array(
		"tours"		=>	50,
		"prix"		=>	array(5 => 75,6	=> 75, 3 => 50, 8 => 25),
		"group"		=>	1,
);

//Arc,
$this->src[3]=array(
		"tours"		=>	100,
		"prix"		=>	array(5 => 75,6	=> 75, 2 => 25, 3 => 25, 8 => 25),
		"group"		=>	1,
);

//Lance,
$this->src[4]=array(
		"tours"		=>	100,
		"prix"		=>	array(5 => 75,6	=> 75, 2 => 50, 8 => 25),
		"group"		=>	1,
);

//Défense niv1,
$this->src[5]=array(
		"tours"		=>	10,
		"prix"		=>	array(2 => 20),
		"group"		=>	5,
);

//Défense niv2,
$this->src[6]=array(
		"tours"		=>	50,
		"needsrc"	=>	 5,
		"prix"		=>	array(1 => 20, 5 => 50,6	=> 50, 2 => 30, 3 => 20, 8 => 25),
		"group"		=>	5,
);

//Défense niv3,
$this->src[7]=array(
		"tours"		=>	100,
		"needsrc"	=>	 6,
		"prix"		=>	array(1 => 70, 8 => 100, 2 => 200, 3 => 200),
		"group"		=>	5,
);

//Acier,
$this->src[8]=array(
		"tours"		=>	50,
		"prix"		=>	array(1 => 50, 2 => 60,3 => 90,5 => 75, 6 => 75),
		"group"		=>	8,
);

//Elevage,
$this->src[9]=array(
		"tours"		=>	50,
		"prix"		=>	array(4 => 500, 8 => 25, 2 => 80, 3 => 70),
		"group"		=>	9,
);

//Commerce niv1,
$this->src[10]=array(
		"tours"		=>	20,
		"prix"		=>	array(1 => 50),
		"group"		=>	10,
);

//Commerce niv2,
$this->src[11]=array(
		"tours"		=>	75,
		"needsrc"	=>	 10,
		"prix"		=>	array(1 => 200, 2 => 20, 3 => 20, 4 => 1000, 9 => 25),
		"group"		=>	10,
);

//Armée niv1,
$this->src[12]=array(
		"tours"		=>	20,
		"prix"		=>	array(1 => 20, 4 => 50, 2 => 12, 3 => 8),
		"group"		=>	12,
);

//Armée niv2,
$this->src[13]=array(
		"tours"		=>	50,
		"needsrc"	=>	 12,
		"prix"		=>	array(1 => 80, 2 => 60, 3 => 40),
		"group"		=>	12,
);

//Armée niv3,
$this->src[14]=array(
		"tours"		=>	125,
		"needsrc"	=>	 13,
		"prix"		=>	array(1 => 180, 8 => 200, 2 => 100, 3 => 100),
		"group"		=>	12,
);

//Mines niv1,
$this->src[15]=array(
		"tours"		=>	15,
		"prix"		=>	array(2 => 20, 3 => 25),
		"group"		=>	15,
);

//Mines niv2,
$this->src[16]=array(
		"tours"		=>	30,
		"needsrc"	=>	 15,
		"prix"		=>	array(1 => 30, 2 => 75, 3 => 80),
		"group"		=>	15,
);


//Guerisseurs
$this->src[17]=array(
		"tours"		=>	75,
		"needsrc"	=>	 14,
		"prix"		=>	array(4 => 300, 1 => 80, 5 => 50),
		"incompat"=> 18,
		"group"		=>	17,
		);

//Shamans
$this->src[18]=array(
		"tours"		=>	75,
		"needsrc"	=>	 14,
		"prix"		=>	array(4 => 300, 1 => 100, 6 => 50),
		"incompat"=> 17,
		"group"		=>	17,
		);


//Troll
$this->src[19]=array(
		"tours"		=>	200,
		"needsrc"	=>	 14,
		"prix"		=>	array(5 => 100,4 => 800, 1 => 80, 9 => 10),
		"incompat"=> 20,
		"group"		=>	19,
		);

//Berserker
$this->src[20]=array(
		"tours"		=>	200,
		"needsrc"	=>	 14,
		"prix"		=>	array(6 => 100,4 => 300, 1 => 80, 9 => 20),
		"incompat"=> 19,
		"group"		=>	19,
		);
		
//Siege
$this->src[21]=array(
		"tours"		=>	200,
		"needsrc"	=>	 14,
		"prix"		=>	array(6 => 50, 5 => 50, 8 => 150, 1 => 50),
		"group"		=>	21,
		);		
}

}
?>