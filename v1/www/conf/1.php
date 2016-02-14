<?
/*************************************************************************
* Configuration de la race humain en fr                                  *
*                                                                        *
* Update : 08/05/05 19:00                     Création : 17/01/04  19:10 *
*************************************************************************/

class config1
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
//   7-"chevaux",
//   8-"acier",
//   9-"mitryl"
//  10-"bouclier en bois",
//  11-"bouclier en acier",
//  12-"epee",
//  13-"epee longue",
//  14-"arc",
//  15-"arbalette",
//  16-"cote de maille",
//  17-"cote en mitryl"
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
function config1()
{

$this->race_cfg = array(
	'primary_res' => array(1,4,22),
	'second_res'  => array(1,2,3,4,5,6,8,18,19,20,21,22,23),
	'primary_btc' => array('vil' => array(1 => array('unt','src'),6 => array('unt'),9 => array('res'),14 => array('unt'),15 => array('res'),18 => array('unt'),20 => array('unt')), 'ext' => array(8 => array('ach'))),
	'bonus_res'   => array(1 => 0.03, 2 => 0.040, 3 => 0.040, 4 => 0.075, 5 => 0.025, 6 => 0.025, 8 => 0.020),
	'modif_pts_btc' => 1
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
		"needbat"	=>	12);

//charbon
$this->res[6]=array(
		"onlycron"	=> true,
		"needbat"	=>	11);

//Chevaux
$this->res[7]=array(
		"needres"	=>	array(4 => 150,8 => 2),
		"needsrc"	=>	8,
		"needbat"	=>	15,
		"group"		=>	7,
		);

//acier
$this->res[8]=array(
		"onlycron"	=> true,
		"needres"	=>	array(6 => 2,5 => 2),
		"needsrc"	=>	7,
		"needbat"	=>	13
		);

//mitril
$this->res[9]=array(
		"group"		=>	9,
	);
					
//Bouclier en bois
$this->res[10]=array(
		"needres"	=>	array(2 => 1),
		"needsrc"	=>	4,
		"needbat"	=>	9,
		"group"		=>	10,
		);
		
//Bouclier en acier
$this->res[11]=array(
		"needres"	=>	array(2 => 2,8 => 1,6 => 1, 5 => 1),
		"needsrc"	=>	5,
		"needbat"	=>	9,
		"group"		=>	10,
		);
	
//epee
$this->res[12]=array(
		"needres"	=>	array(2 => 1), //,5 => 1,6 => 1
		"needsrc"	=>	1,
		"needbat"	=>	9,
		"group"		=>	12,
		);
	
//epee longue
$this->res[13]=array(
		"needres"	=>	array(8 => 2,6 => 1,5 => 1),
		"needsrc"	=>	2,
		"needbat"	=>	9,
		"group"		=>	12,
		);

//arc
$this->res[14]=array(
		"needres"	=>	array(2 => 2),
		"needsrc"	=>	1,
		"needbat"	=>	9,
		"group"		=>	15,
		);
		
//arbalette
$this->res[15]=array(
		"needres"	=>	array(2 => 1,8 => 2,6 => 1,5 => 1),
		"needsrc"	=>	2,
		"needbat"	=>	9,
		"group"		=>	15,
		);
	
//cote de mailles
$this->res[16]=array(
		"needres"	=>	array(8 => 2),
		"needsrc"	=>	5 ,
		"needbat"	=>	9,
		"group"		=>	16,
		);

//cote de mitril
$this->res[17]=array(
		"needres"	=>	array(9 => 1),
		"needsrc"	=>	5 ,
		"needbat"	=>	9,
		"group"		=>	16,
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
//produit	: production e comme le prix mais par tour //
//		: si necessite autre chose : idress*x           //
//tours		: nb de tours avec un travailleur		//
//needbat	: besoin de idbat-idbat pour être dispo		//
//needsrc	: besoin de idsrc-idsrc pour être dispo		//
//needguy	: besoin de idunit pour être construit et 	//
//                fonctionner					//
//**************************************************************//


//Donjon*
$this->btc[1]=array(
		"bonusdef"	=>	10,
		"vie"		=>	1000,
		"population"	=>	20,
		"limite"	=>	1,
		"btcopt"	=>	array("src" => true, "unt" => true,"pop" => true, "def" => true)
		);

//Carrière*
$this->btc[2]=array(
		"vie"		=>	200,
		"prix"		=>	array(2 => 5,3 => 6, 23 => 1),
		"tours"		=>	5,
		"needbat"	=>	array(1 => true),
		"needguy"	=>	array(5 => 1),
		"produit"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
		);
		
//Scierie*
$this->btc[3]=array(
		"vie"		=>	200,
		"prix"		=>	array(2 => 5,3 => 8,18 => 1),
		"tours"		=>	5,
		"needbat"	=>	array(1 => true),
		"needguy"	=>	array(4 => 1),
		"produit"	=>	array(2 => 1),
		"btcopt"	=>	array("prod" => true)	
		);

//maison*		
$this->btc[4]=array(
		"vie"		=>	175,
		"prix"		=>	array(2 => 12,3 => 18),
		"tours"		=>	6,
		"needbat"	=>	array(2 => true,3 => true),
		"population"	=>	5,
		"limite"	=>	78,
		"btcopt"	=>	array("pop" => true)
		);

//ferme	*	
$this->btc[5]=array(
		"vie"		=>	350,
		"prix"		=>	array(2 => 12,3 => 18),
		"tours"		=>	7,
		"needbat"	=>	array(2 => true,3 => true),
		"produit"	=>	array(4 => 7),
		"needguy"	=>	array(2 => 1),
		"limite"	=>	40,
		"btcopt"	=>	array("prod" => true)
		);
		
//caserne
$this->btc[6]=array(
		"vie"		=>	500,
		"prix"		=>	array(2 => 45,3 => 50),
		"tours"		=>	30,
		"needbat"	=>	array(5 => true,4 => true),
		"needguy"	=>	array(7 => 1),
		"needsrc"	=>	12,
		"limite"	=>	5,
		"btcopt"	=>	array("unt" => true)
		);
	
//Mine d'or,*
$this->btc[7]=array(
		"vie"		=>	200,
		"tours"		=>	30,
		"needsrc"	=>	15,
		"produit"	=>	array(1 => 1),
		"prix"		=>	array(2 => 45,3 => 50, 21 => 1),
		"needbat"	=>	array(4 => true,5 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Marché,
$this->btc[8]=array(
		"vie"		=>	400,
		"tours"		=>	100,
		"needsrc" 	=> 	9,
		"prix"		=>	array(2 => 190,3 => 200),
		"needguy"	=>	array(1 => 1),
		"needbat"	=>	array(4 => true,5 => true),
		"btcopt"	=>	array("com" => array(9 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
									10 => array(COM_MAX_NB2,COM_MAX_VENTES2),
									11 => array(COM_MAX_NB3,COM_MAX_VENTES3)
									)
						),
);

//Armurerie,
$this->btc[9]=array(
		"vie"		=>	500,
		"tours"		=>	150,
		"needsrc"	=>	13,
		"prix"		=>	array(2 => 200,3 => 190),
		"needguy"	=>	array(4 => 1,3 => 1),
		"needbat"	=>	array(6 => true,7 => true),
		"limite"	=>	3,
		"btcopt"	=>	array("res" => true)
		);

//Labo,
$this->btc[10]=array(
		"vie"		=>	500,
		"tours"		=>	150,
		"prix"		=>	array(2 => 100,3 => 100),
		"needguy"	=>	array(6 => 8),
		"needbat"	=>	array(6 => true,7 => true),
		"doublesrc"	=>	true,
		"limite"	=>	2,
		"btcopt"	=>	array("src" => true)
);

//Mine de charbon,*
$this->btc[11]=array(
		"vie"		=>	200,
		"tours"		=>	100,
		"needsrc"	=>	16,
		"produit"	=>	array(6 => 1),
		"prix"		=>	array(2 => 60,3 => 60, 20 => 1),
		"needbat"	=>	array(6 => true,7 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Mine de fer,*
$this->btc[12]=array(
		"vie"		=>	200,
		"tours"		=>	100,
		"needsrc"	=>	16,
		"produit"	=>	array(5 => 1),
		"prix"		=>	array(2 => 60,3 => 60, 19 => 1),
		"needbat"	=>	array(6 => true,7 => true),
		"needguy"	=>	array(5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Fonderie,
$this->btc[13]=array(
		"vie"		=>	500,
		"tours"		=>	250,
		"produit"	=>	array(8 => 1),
		"prix"		=>	array(2 => 250,3 => 250),
		"needsrc" 	=> 7,
		"needbat"	=>	array(9 => true, 11 => true,12 => true),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Atelier,
$this->btc[14]=array(
		"vie"		=>	500,
		"tours"		=>	400,
		"needsrc"	=>	3,
		"prix"		=>	array(2 => 525,3 => 525),
		"needbat"	=>	array(9 => true,11 => true,12 => true),
		"needguy"	=>	array(3 => 1,4 => 1,6 => 1),
		"btcopt"	=>	array("unt" => true)
);

//Ecurie,
$this->btc[15]=array(
		"vie"		=>	500,
		"tours"		=>	400,
		"needsrc"	=>	8,
		"prix"		=>	array(2 => 350,3 => 350),
		"needbat"	=>	array(6 => true,7 => true),
		"needguy"	=>	array(2 => 1),
		"btcopt"	=>	array("res" => true)
);

//Tours,
$this->btc[16]=array(
		"bonusdef"	=>	5,
		"defense"	=>	20,
		"vie"		=>	800,
		"tours"		=>	100,
		"needsrc"	=>	6,
		"def_prio"	=> 	true,
		"prix"		=>	array(2 => 275,3 => 300, 8 => 20),
		"needbat"	=>	array(6 => true,2 => true,13 => true),
		"needguy"	=>	array(9 => 4),
		"limite"	=>	4,
		"btcopt"	=>	array("def" => true)
);

//Ferme améliorée
$this->btc[17]=array(
		"vie"		=>	550,
		"needsrc"	=>	17,
		"prix"		=>	array(2 => 50,3 => 70,7 => 4),
		"tours"		=>	150,
		"needbat"	=>	array(15 => true),
		"produit"	=>	array(4 => 20),
		"population" 	=> 	10,
		"needguy"	=>	array(2 => 3),
		"limite"	=>	16,
		"btcopt"	=>	array("prod" => true,"pop" => true)
);

//eglise
$this->btc[18]=array(
		"vie"		=>  250,
		"needsrc"	=> array(18 => true,19 => true),
		"prix"		=> array(2 => 100, 3 => 100, 1 => 100, 4 => 500),
		"tours"		=>	400,
		"needbat" => array(17 => true),
		"limite"	=>	2,
		"btcopt"	=>	array("unt" => true)
		);

//poudrière
$this->btc[19]=array(
		"vie"		=> 250,
		"needsrc" 	=> 20,
		"tours"		=> 350,
		"needbat" 	=> array(14 => true),
		"needguy"	=> array(3 => 2,4 => 1,6 => 2),
		"prix"	=> array(2 => 150, 3 => 150, 5 => 100, 6 => 100, 8 => 50),
		);

//école de magie
$this->btc[20]=array(
		"vie"		=> 350,
		"needsrc"	=> array(21 => true ,22 => true),
		"prix"		=> array(2 => 175, 3 => 160, 1 => 150, 4 => 750),
		"tours"		=> 400,
		"needbat" 	=> array(18 => true),
		"limite"	=> 2,
		"btcopt"	=>	array("unt" => true)
	);

//forteresse
$this->btc[21]=array(
		"population" 	=> 80,
		"bonusdef"	=> 20,
		"defense"	=> 400,
		"vie"		=> 4500,
		"prix"		=> array(2 => 4500, 3 => 4500, 8 => 400),
		"tours"		=> 2000,
		"def_prio"	=> true,
		"needbat" 	=> array(20 => true, 19 => true),
		"needguy"	=> array(10 => 10),
		"limite"	=> 1,
		"btcopt"	=>	array("unt" => true,"src" => true, "pop" => true,"def" => true)
		);

//*******************************//
// Unitées                       //
//*******************************//


//Travailleurs
$this->unt[1]=array(
		"prix"		=>	array(1 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 21 => true),
		"group"		=>	1,
		"type"		=>	TYPE_UNT_CIVIL,
		);
//Fermiers
$this->unt[2]=array(
		"prix"		=>	array(1 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 21 => true),
		"group"		=>	2,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Forgerons
$this->unt[3]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 21 => true),
		"group"		=>	2,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Bucherons
$this->unt[4]=array(
		"prix"		=>	array(1 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 21 => true),
		"group"		=>	4,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Mineurs
$this->unt[5]=array(
		"prix"		=>	array(1 => 1),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 21 => true),
		"group"		=>	4,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Chercheurs
$this->unt[6]=array(
		"prix"		=>	array(1 => 3),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 21 => true),
		"group"		=>	6,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Recrue
$this->unt[7]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true, 21 => true),
		"group"		=>	6,
		"type"		=>	TYPE_UNT_CIVIL,
		);		

//Miliciens,
$this->unt[8]=array(
		"defense"	=>	1,
		"vie"		=>	2,
		"attaque"	=>	1,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"prix"		=>	array(1 => 1,2 => 1),
		"inbat"		=>	array(6 => true),
		"needbat"	=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	8,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role" 		=> 	UNT_ROLE_INFANTERIE,
		);

//Archers,
$this->unt[9]=array(
		"defense"	=>	4,
		"vie"		=>	4,
		"attaque"	=>	2,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"prix"		=>	array(14 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	9,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  	=> 	UNT_ROLE_DISTANCE,
		);
		
//Arbalestiers,
$this->unt[10]=array(
		"defense"	=>	15,
		"vie"		=>	8,
		"attaque"	=>	8,
		"attaquebat"	=>	0,
		"speed"		=>	6,
		"needsrc" => 13,
		"prix"		=>	array(15 => 1,16 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	9,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);
		
//Fantassins,
$this->unt[11]=array(
		"defense"	=>	2,
		"vie"		=>	4,
		"attaque"	=>	4,
		"attaquebat"	=>	0,
		"speed"		=>	8,
		"prix"		=>	array(12 => 1,10 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	11,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Fantassins Xp,
$this->unt[12]=array(
		"defense"	=>	8,
		"vie"		=>	10,
		"attaque"	=>	12,
		"attaquebat"	=>	1,
		"speed"		=>	6,
		"needsrc" => 13,
		"prix"		=>	array(13 => 1,11 => 1,16 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	11,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Chevalier,
$this->unt[13]=array(
		"defense"	=>	6,
		"vie"		=>	8,
		"attaque"	=>	14,
		"attaquebat"	=>	2,
		"speed"		=>	12,
		"prix"		=>	array(12 => 1,10 => 1,7 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);

//Chevalier xp,
$this->unt[14]=array(
		"defense"	=>	10,
		"vie"		=>	14,
		"attaque"	=>	18,
		"attaquebat"	=>	3,
		"speed"		=>	10,
		"needsrc" => 13,
		"prix"		=>	array(13 => 1,16 => 1,7 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	13,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);

//Catapulte
$this->unt[15]=array(
		"defense"	=>	5,
		"vie"		=>	4,
		"attaque"	=>	5,
		"attaquebat"	=>	40,
		"speed"		=>	2,
		"needsrc" 	=> 14,
		"prix"		=>	array(3 => 10,2 => 10,8 => 5),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(7 => 2),
		"group"		=>	15,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);

//Belier,
$this->unt[16]=array(
		"defense"	=>	0,
		"vie"		=>	4,
		"attaque"	=>	0,
		"attaquebat"	=>	50,
		"speed"		=>	2,
		"needsrc" => 14,
		"prix"		=>	array(3 => 10,2 => 10,8 => 5),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(7 => 3),
		"group"		=>	16,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);		

//Moine,
$this->unt[17]=array(
		"defense"	=>	3,
		"bonus"		=> array('atq' => 1),
		"vie"		=>	8,
		"attaque"	=>	6,
		"attaquebat"	=>	0,
		"speed"		=>	6,
		"prix"		=>	array(1 => 8),
		"needbat"	=>	array(18 => true),
		"inbat"		=>	array(18 => true),
		"needsrc"	=>	18,
		"needguy"	=>	array(7 => 1),
		"group"		=>	17,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);
	
//Pretre,
$this->unt[18]=array(
		"defense"	=>	6,
		"bonus"		=> array('def' => 1),
		"vie"		=>	8,
		"attaque"	=>	3,
		"attaquebat"	=>	0,
		"speed"		=>	6,
		"needsrc"	=>	19,
		"prix"		=>	array(1 => 8),
		"needbat"	=>	array(18 => true),
		"inbat"		=>	array(18 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	18,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);
	
//Canon,
$this->unt[19]=array(
		"defense"	=>	10,
		"vie"		=>	6,
		"attaque"	=>	20,
		"attaquebat"	=>	70,
		"speed"		=>	2,
		"prix"		=>	array(5 => 15, 6 => 15,8 => 12),
		"needbat"	=>	array( 19 => true,14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	19,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);	

//Magicien,
$this->unt[20]=array(
		"defense"	=>	10,
		"bonus"		=> array('def' => 1),
		"vie"		=>		12,
		"attaque"	=>	6,
		"attaquebat"	=>	1,
		"speed"		=>	8,
		"prix"		=>	array(4 => 30, 1 => 5, 9 => 1),
		"needbat"	=>	array(20 => true),
		"inbat"		=>	array(20 => true),
		"needsrc"	=>	21,
		"needguy"	=>	array(7 => 1),
		"group"		=>	20,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);	

//Sorcier,
$this->unt[21]=array(
		"defense"	=>	6,
		"bonus"		=> array('atq' => 1),
		"vie"		=>		12,
		"attaque"	=>	10,
		"attaquebat"	=>	2,
		"speed"		=>	8,
		"needsrc"	=>	22,
		"prix"		=>	array(4 => 30, 1 => 5, 9 => 1),
		"needbat"	=>	array(20 => true),
		"inbat"		=>	array(20 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	21,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);	

//Trebuchet,
$this->unt[22]=array(
		"defense"	=>	0,
		"vie"		=>	4,
		"attaque"	=>	0,
		"attaquebat"	=>	120,
		"speed"		=>	1,
		"needsrc" => 14,
		"prix"		=>	array(3 => 25, 2 => 25, 8 => 25),
		"needbat"	=>	array(14 => true),
		"inbat"		=>	array(14 => true),
		"needguy"	=>	array(7 => 5),
		"group"		=>	22,
		"type"		=> 	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);	

//Paladin,
$this->unt[23]=array(
		"defense"	=>	14,
		"vie"		=>	20,
		"attaque"	=>	23,
		"attaquebat"	=>	4,
		"speed"		=>	11,
		"needsrc" 	=> 13,
		"prix"		=>	array(13 => 1,11 => 1,17 => 1,7 => 1),
		"needbat"	=>	array(6 => true),
		"inbat"		=>	array(6 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	23,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_MONTEE,
);
//*******************************//
// Recherches                    //
// 'maxdst' = distance max pour  //
//            échange (defaut 5) //
//*******************************//
//!\\ REVOIR LES COUT DES RECHERCHES //!\\


//Arme niv1,
$this->src[1]=array(
		"tours"		=>	10,
		"prix"		=>	array(2 => 10, 3 => 10),
		"group"		=>	1,
);

//Arme niv2,
$this->src[2]=array(
		"tours"		=>	50,
		"needsrc"	=>	 1,
		"prix"		=>	array(1 => 30, 5 => 75, 6 => 75, 2 => 30, 3 => 20, 8 => 25),
		"group"		=>	1,
);

//Arme niv3,
$this->src[3]=array(
		"tours"		=>	100,
		"needsrc"	=>	 2,
		"prix"		=>	array(1 => 70, 8 => 200, 2 => 80, 3 => 120),
		"group"		=>	1,
);

//Défense niv1,
$this->src[4]=array(
		"tours"		=>	10,
		"prix"		=>	array(2 => 10, 3 => 10),
		"group"		=>	4,
);

//Défense niv2,
$this->src[5]=array(
		"tours"		=>	50,
		"needsrc"	=>	 4,
		"prix"		=>	array(1 => 30, 5 => 50,6	=> 50, 2 => 30, 3=> 20, 8 => 25),
		"group"		=>	4,
);

//Défense niv3,
$this->src[6]=array(
		"tours"		=>	100,
		"needsrc"	=>	 5,
		"prix"		=>	array(1 => 90, 8 => 100, 2 => 180, 3 => 220, 9 => 10),
		"group"		=>	4,
);

//Acier,
$this->src[7]=array(
		"tours"		=>	50,
		"prix"		=>	array(2 => 20, 3 => 120, 5 => 75, 6 => 75),
		"group"		=>	7,
);

//Elevage,
$this->src[8]=array(
		"tours"		=>	50,
		"prix"		=>	array(4 => 500, 8 => 25, 2 => 75, 3 => 75),
		
		"group"		=>	8,
);

//Commerce niv1,
$this->src[9]=array(
		"tours"		=>	20,
		"prix"		=>	array(1 => 50),
		"group"		=>	9,
);

//Commerce niv2,
$this->src[10]=array(
		"tours"		=>	75,
		"needsrc"	=>	 9,
		"prix"		=>	array(1 => 200, 2 => 50, 3 => 30, 4 => 1000),
		"group"		=>	9,
);

//Commerce niv3,
$this->src[11]=array(
		"tours"		=>	125,
		"needsrc"	=>	 10,
		"prix"		=>	array(1	=> 800, 4 => 4000, 2 => 450, 3 => 550, 9 => 50),
		"group"		=>	9,
);

//Armée niv1,
$this->src[12]=array(
		"tours"		=>	20,
		"prix"		=>	array(1 => 20, 4 => 50, 2 => 10, 3 => 10),
		"group"		=>	12,
);

//Armée niv2,
$this->src[13]=array(
		"tours"		=>	50,
		"needsrc"	=>	 12,
		"prix"		=>	array(1 => 75, 2 => 50, 3 => 50),
		"group"		=>	12,
);

//Armée niv3,
$this->src[14]=array(
		"tours"		=>	125,
		"needsrc"	=>	 13,
		"prix"		=>	array(1 => 180, 8 => 200, 2 => 100, 3 => 120, 9 => 20),
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

//attelage
$this->src[17]=array(
		"tours"		=>	50,
		"needsrc"	=>	 8,
		"prix"		=>	array(4 => 750, 8 => 25, 2 => 60, 3 => 40, 7 => 10),
		"group"		=>	17,
		);

//moine
$this->src[18]=array(
		"tours"		=>	75,
		"needsrc"	=>	 14,
		"prix"		=>	array(4 => 300, 1 => 80, 5 => 50, 9 => 5),
		"incompat"=> 19,
		"group"		=>	18,
		);

//pretre
$this->src[19]=array(
		"tours"		=>	75,
		"needsrc"	=>	 14,
		"prix"		=>	array(4 => 300, 1 => 80, 6 => 50, 9 => 5),
		"incompat"=> 18,
		"group"		=>	18,
		);

//poudre
$this->src[20]=array(
		"tours"		=>	125,
		"needsrc"	=>	 14,
		"prix"		=> array(5 => 125, 6 => 125, 8 => 25),
		"group"		=>	20,
		);

//magie blanche
$this->src[21]=array(
		"tours"		=>	200,
		"needsrc"	=>	 20,
		"prix"		=>	array(5 => 100, 4 => 500, 1 => 100, 5 => 80, 9 => 15),
		"incompat"=> 22,
		"group"		=>	21,
		);

//magie noire
$this->src[22]=array(
		"tours"		=>	200,
		"needsrc"	=>	 20,
		"prix"		=>	array(6 => 100, 4 => 500, 1 => 80, 9 => 15),
		"incompat"=> 21,
		"group"		=>	21,
		);
}
}
?>