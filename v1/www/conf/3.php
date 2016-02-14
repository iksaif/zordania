<?
/*************************************************************************
* Configuration de la race naine en fr                                   *
*                                                                        *
*                                                                        *
*                                                                        *
* Update : 05/07/05 23:45                     Cr�tion : 12/02/05  18:33 *
*************************************************************************/
class config3
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
//   7-"chevaux", - pas utilis� ici
//   8-"acier",
//   9-"mithril", - nouveau, seul producteur
//  10-"massue",
//  11-"marteau de combat",
//  12-"hache",
//  13-"hache de guerre",
//  14-"hache de combat",
//  15-"marteau de guerre",
//  16-"cote de maille",
//  17-"cote de mithril",
//  18-"Emplacement bois",
//  19-"Emplacement fer",
//  20-"Emplacement charbon",
//  21-"Emplacement or",
//  22-"Population", -important
//  23-"Montagne",
//
//**************************************************************//

//**************************************************************//
//                      o Ressources	o			//
//	Certains array sont vides mais c normal :)		//
//needress 	-> idress*nbress+idress2*nbress2		//
//needsrc 	-> idsrc					//
//needbat	-> idbat					//
//import	-> important					//
//**************************************************************//
function config3()
{

$this->race_cfg = array(
	'primary_res' => array(1,4,22),
	'second_res'  => array(1,2,3,4,5,6,8,9,18,19,20,21,22,23),
	'primary_btc' => array('vil' => array(1 => array('unt','src'),10 => array('unt'),11 => array('unt'),14 => array('res'),15 => array('unt'),16 => array('unt'),18 => array('unt'),19 => array('unt')), 'ext' => array(8 => array('ach'))),
	'bonus_res'   => array(1 => 0.05, 3 => 0.040, 4 => 0.075, 5 => 0.025, 6 => 0.025, 8 => 0.020, 9 => 0.005),
	'modif_pts_btc' => 0.9
	);
	
$this->res=array();

//or - important
$this->res[1]=array(
		"onlycron"	=> true,
		"needbat"	=>	7);

//bois
$this->res[2]=array();

//pierre
$this->res[3]=array(
		"onlycron"	=> true,
		"needbat"	=>	4);

//nourriture - important
$this->res[4]=array(
		"onlycron"	=> true,
		"needbat"	=>	3);

//fer
$this->res[5]=array(
		"onlycron"	=> true,
		"needbat"	=>	6);

//charbon
$this->res[6]=array(
		"onlycron"	=> true,
		"needbat"	=>	5);

//chevaux
$this->res[7]= array();

//acier
$this->res[8]=array(
		"onlycron"	=> true,
		"needres"	=>	array(6 => 1,5 => 1),
		"needsrc"	=>	6,
		"needbat"	=>	9
		);

//mithril
$this->res[9]=array(
		"onlycron"	=> true,
		"needres"	=>	array(8 => 2,1 => 1),
		"needsrc"	=>	8,
		"needbat"	=>	13
		);
				
//massue
$this->res[10]=array(
		"needres"	=>	array(3 => 2),
		"needbat"	=>	14,
		"group"		=>	10,
		);
		
//marteau de combat
$this->res[11]=array(
		"needres"	=>	array(8 => 2),
		"needsrc"	=>	17,
		"needbat"	=>	14,
		"group"		=>	10,
		);
	
//hache
$this->res[12]=array(
		"needres"	=>	array(3 => 2),
		"needbat"	=>	14,
		"group"		=>	12,
		);
	
//hache de guerre
$this->res[13]=array(
		"needres"	=>	array(8 => 4),
		"needsrc"	=>	18,
		"needbat"	=>	14,
		"group"		=>	12,
		);

//hache de combat
$this->res[14]=array(
		"needres"	=>	array(8 => 2),
		"needsrc"	=>	17,
		"needbat"	=>	14,
		"group"		=>	12,
		);
		
//marteau de guerre
$this->res[15]=array(
		"needres"	=>	array(8 => 4),
		"needsrc"	=>	18,
		"needbat"	=>	14,
		"group"		=>	15,
		);
	
//cote de mailles
$this->res[16]=array(
		"needres"	=>	array(8 => 3),
		"needsrc"	=>	19,
		"needbat"	=>	14,
		"group"		=>	16,
		);
		
//cote de mithril
$this->res[17]=array(
		"needres"	=>	array(9 => 1),
		"needsrc"	=>	20,
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
//                      o Bat�ents o  				        //
//Lise des atribut:						                        //
//defense 	: pour faire mal a ceux qui attaquent		        //
//vie 		: solidit�					                        //
//population 	: le nombre de gens qu'il peu y avoir dedans    //
//prix 		: ce que ca fait depenser			                //
//		: idress*nbress+idress2*nbress2 		                      //
//		: a voir ca ca peu changer			                          //
//produit	: production marche comme le prix mais par tour       //
//		: si necessite autre chose : idress*x                     //
//tours		: nb de tours avec un travailleur		                  //
//needbat	: besoin de idbat-idbat pour �re dispo		            //
//needsrc	: besoin de idsrc-idsrc pour �re dispo		            //
//needguy	: besoin de idunit pour �re construit et 	          //
//                fonctionner					                          //
//**************************************************************//


//Bastion,
$this->btc[1]=array(
		"bonusdef"	=>	10,
		"vie"		=>	1000,
		"population"	=>	20,
		"limite"	=>	1,
		"btcopt"	=>	array("src" => true, "unt" => true,"pop" => true,"def" => true)
		);

//Caverne,
$this->btc[2]=array(
		"vie"		=>	150,
		"prix"		=>	array(3 => 20),
		"tours"		=>	20,
		"needbat"	=>	array(1 => true),
		"population"	=>	5,
		"limite"	=>	114,
		"btcopt"	=>	array("pop" => true)
		);

//Champignonni�e,		
$this->btc[3]=array(
		"vie"		=>	150,
		"prix"		=>	array(3 => 25),
		"tours"		=>	7,
		"needbat"	=>	array(1 => true),
		"produit"	=>	array(4 => 4),
		"needguy"	=>	array(2 => 1),
		"limite"	=>	150,
		"btcopt"	=>	array("prod" => true)
		);

//Mine de pierre,
$this->btc[4]=array(
		"vie"		=>	300,
		"tours"		=>	20,
		"needsrc"	=>	1,
		"produit"	=>	array(3 => 3),
		"prix"		=>	array(3 => 50, 23 => 1),
		"needbat"	=>	array(2 => true,3 => true),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
);
		
//Mine de charbon,
$this->btc[5]=array(
		"vie"		=>	350,
		"tours"		=>	60,
		"needsrc"	=>	1,
		"produit"	=>	array(6 => 2),
		"prix"		=>	array(3 => 80, 1 => 10, 20 => 1),
		"needbat"	=>	array(2 => true, 3 => true),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Mine de fer,
$this->btc[6]=array(
		"vie"		=>	350,
		"tours"		=>	60,
		"needsrc"	=>	1,
		"produit"	=>	array(5 => 2),
		"prix"		=>	array(3 => 80, 1 => 10, 19 => 1),
		"needbat"	=>	array(2 => true, 3 => true),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Mine d'or,
$this->btc[7]=array(
		"vie"		=>	400,
		"tours"		=>	80,
		"needsrc"	=>	2,
		"produit"	=>	array(1 => 2),
		"prix"		=>	array(3 => 100, 21 => 1),
		"needbat"	=>	array(2 => true,3 => true),
		"needguy"	=>	array(3 => 1),
		"btcopt"	=>	array("prod" => true)
);
	
//March�
$this->btc[8]=array(
		"vie"		=>	600,
		"tours"		=>	150,
		"needsrc" => 3,
		"prix"		=>	array(3 => 450, 1 => 50),
		"needguy"	=>	array(1 => 2),
		"needbat"	=>	array(2 => true,3 => true),
		"btcopt"	=>	array("com" => array(3 => array(COM_MAX_NB1,COM_MAX_VENTES1), 
									4 => array(COM_MAX_NB2,COM_MAX_VENTES2),
									5 => array(COM_MAX_NB3,COM_MAX_VENTES3)
									)
						),
);

//Fonderie,
$this->btc[9]=array(
		"vie"		=>	600,
		"tours"		=>	150,
		"produit"	=>	array(8 => 1),
		"prix"		=>	array(1 => 100, 3 => 300),
		"needsrc" => 6,
		"needbat"	=>	array(5 => true, 6 => true),
		"needguy"	=>	array(1 => 2, 6 => 1),
		"limite"	=>	1,
		"btcopt"	=>	array("prod" => true)
);
		
//Caserne,
$this->btc[10]=array(
		"vie"		=>	650,
		"prix"		=>	array(2 => 20, 3 => 150, 1 => 20),
		"tours"		=>	50,
		"needbat"	=>	array(9 => true),
		"needguy"	=>	array(7 => 1),
		"needsrc"	=>	14,
		"limite"	=>	5,
		"btcopt"	=>	array("unt" => true)
		);

//Ecole militaire,
$this->btc[11]=array(
		"vie"		=>	800,
		"prix"		=>	array(2 => 50, 3 => 300, 8 => 40),
		"tours"		=>	150,
		"needbat"	=>	array(10 => true),
		"needsrc" => 15,
		"needguy"	=>	array(4 => 1, 7 => 2),
		"limite"	=>	5,
		"btcopt"	=>	array("unt" => true)
		);
		
//Haut-fourneau,
$this->btc[12]=array(
		"vie"		=>	600,
		"tours"		=>	350,
		"produit"	=>	array(8 => 1),
		"prix"		=>	array(1 => 100, 3 => 300),
		"needsrc" => 7,
		"needbat"	=>	array(9 => true),
		"needguy"	=>	array(1 => 3, 6 => 1),
		"doublesrc"	=>	true,
		"btcopt"	=>	array("prod" => true)
);

//Fonderie de mithril,
$this->btc[13]=array(
		"vie"		=>	800,
		"tours"		=>	450,
		"produit"	=>	array(9 => 1),
		"prix"		=>	array(1 => 200, 3 => 400),
		"needsrc" => 8,
		"needbat"	=>	array(12 => true),
		"needguy"	=>	array(1 => 4, 6 => 2, 5 => 1),
		"btcopt"	=>	array("prod" => true)
);

//Armurerie,
$this->btc[14]=array(
		"vie"		=>	600,
		"tours"		=>	150,
		"prix"		=>	array(2 => 50, 3 => 450, 1 => 50),
		"needguy"	=>	array(4 => 1, 5 => 1, 6 => 1),
		"needbat"	=>	array(9 => true),
		"limite"	=>	3,
		"btcopt"	=>	array("res" => true)
		);

//Atelier,
$this->btc[15]=array(
		"vie"		=>	600,
		"tours"		=>	450,
		"needsrc"	=>	9,
		"prix"		=>	array(1 => 75, 3 => 400),
		"needbat"	=>	array(12 => true),
		"needguy"	=>	array(5 => 2, 4 => 1, 6 => 1, 1 => 2),
		"btcopt"	=>	array("unt" => true)
);

//Manufacture naine,
$this->btc[16]=array(
		"vie"		=>	400,
		"tours"		=>	300,
		"needsrc"	=>	10,
		"prix"		=>	array(1 => 100, 3 => 400, 2 => 100),
		"needbat"	=>	array(15 => true),
		"needguy"	=>	array(5 => 1, 4 => 1, 6 => 6, 1 => 2),
		"limite"	=>	2,
		"btcopt"	=>	array("unt" => true)
);

//Tour,
$this->btc[17]=array(
		"bonusdef"	=>	6,
		"defense"	=>	15,
		"vie"		=>	1000,
		"tours"		=>	150,
		"needsrc"	=>	11,
		"def_prio"	=> true,
		"prix"		=>	array(2 => 100,3 => 500, 8 => 20),
		"needbat"	=>	array(12 => true),
		"needguy"	=>	array(11 => 4),
		"limite"	=>	4,
		"btcopt"	=>	array("def" => true)
);

//Temple,
$this->btc[18]=array(
		"vie"		=>  300,
		"needsrc"	=> 8,
		"prix"		=> array(1 => 100, 3 => 200, 8 => 50, 9 => 30),
		"tours"		=>	400,
		"needbat" => array(12 => true),
		"limite"	=>	2,
		"btcopt"	=>	array("unt" => true)
		);

//Ecole runique,
$this->btc[19]=array(
		"vie"		=> 400,
		"prix"		=> array(1 => 150, 2 => 100, 3 => 300, 8 => 50, 9 => 25),
		"tours"		=> 500,
		"needbat" 	=> array(18 => true),
		"limite"	=> 2,
		"btcopt"	=>	array("unt" => true)
	);

//Citadelle
$this->btc[20]=array(
		"population" 	=> 60,
		"defense"	=> 500,
		"bonusdef"	=> 24,
		"vie"		=> 6500,
		"prix"		=> array(2 => 1500, 3 => 7500, 8 => 300, 9 => 60),
		"tours"		=> 750,
		"def_prio"	=> true,
		"needbat" 	=> array(17 => true, 19 => true),
		"needguy"	=>	array(13 => 10),
		"limite"	=> 1,
		"btcopt"	=>	array("unt" => true, "src" => true,"def" => true,"pop" => true)
		);

//*******************************//
// Unit�s                       //
//*******************************//


//B�isseurs
$this->unt[1]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"group"		=>	1,
		"type"		=>	TYPE_UNT_CIVIL,
		
		);
//Cueilleurs
$this->unt[2]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"group"		=>	1,
		"type"		=>	TYPE_UNT_CIVIL,
		);	
//Mineurs
$this->unt[3]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"group"		=>	3,
		"type"		=>	TYPE_UNT_CIVIL,
		);	
//Ma�re Forgeron
$this->unt[4]=array(
		"prix"		=>	array(1 => 3),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"group"		=>	3,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Ma�re Artisan
$this->unt[5]=array(
		"prix"		=>	array(1 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"group"		=>	5,
		"type"		=>	TYPE_UNT_CIVIL,
		);				
//Ing�ieur
$this->unt[6]=array(
		"prix"		=>	array(1 => 4),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"group"		=>	5,
		"type"		=>	TYPE_UNT_CIVIL,
		);		
//Recrue
$this->unt[7]=array(
		"prix"		=>	array(1 => 3),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"needsrc" => 14,
		"group"		=>	7,
		"type"		=>	TYPE_UNT_CIVIL,
		);

//V��an
$this->unt[8]=array(
		"prix"		=>	array(1 => 4, 8 => 2),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"needsrc" => 15,
		"group"		=>	7,
		"type"		=>	TYPE_UNT_CIVIL,
		);
		
//H�os
$this->unt[9]=array(
		"prix"		=>	array(9 => 4),
		"vie"		=>	1,
		"needbat"	=>	array(1 => true),
		"inbat"		=>	array(1 => true,20 => true),
		"needsrc" => 16,
		"group"		=>	7,
		"type"		=>	TYPE_UNT_CIVIL,
		);
					
//Eclaireur,
$this->unt[10]=array(
		"defense"	=>	1,
		"vie"		=>	4,
		"attaque"	=>	3,
		"attaquebat"	=>	0,
		"speed"		=>	4,
		"needsrc" => 14,
		"prix"		=>	array(12 => 1),
		"needbat"	=>	array(10 => true),
		"inbat"		=>	array(10 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	10,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
		);

//Milicien,
$this->unt[11]=array(
		"defense"	=>	3,
		"vie"		=>	5,
		"attaque"	=>	1,
		"attaquebat"	=>	0,
		"speed"		=>	4,
		"needsrc" => 14,
		"prix"		=>	array(10 => 1),
		"needbat"	=>	array(10 => true),
		"inbat"		=>	array(10 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	10,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
		);
		
//Combattant nain,
$this->unt[12]=array(
		"defense"	=>	8,
		"vie"		=>	10,
		"attaque"	=>	16,
		"attaquebat"	=>	1,
		"speed"		=>	4,
		"needsrc" => 15,
		"prix"		=>	array(14 => 1,16 => 1),
		"needbat"	=>	array(11 => true),
		"inbat"		=>	array(11 => true),
		"needguy"	=>	array(8 => 1),
		"group"		=>	12,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);
		
//D�enseur nain,
$this->unt[13]=array(
		"defense"	=>	16,
		"vie"		=>	12,
		"attaque"	=>	8,
		"attaquebat"	=>	1,
		"speed"		=>	4,
		"needsrc" => 15,
		"prix"		=>	array(11 => 1,16 => 1),
		"needbat"	=>	array(11 => true),
		"inbat"		=>	array(11 => true),
		"needguy"	=>	array(8 => 1),
		"group"		=>	12,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Guerrier nain,
$this->unt[14]=array(
		"defense"	=>	7,
		"vie"		=>	16,
		"attaque"	=>	20,
		"attaquebat"	=>	2,
		"speed"		=>	4,
		"needsrc" => 16,
		"prix"		=>	array(13 => 1, 17 => 1),
		"needbat"	=>	array(11 => true),
		"inbat"		=>	array(11 => true),
		"needguy"	=>	array(9 => 1),
		"group"		=>	14,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Protecteur nain,
$this->unt[15]=array(
		"defense"	=>	20,
		"vie"		=>	18,
		"attaque"	=>	8,
		"attaquebat"	=>	1,
		"speed"		=>	4,
		"needsrc" => 16,
		"prix"		=>	array(15 => 1, 17 => 1),
		"needbat"	=>	array(11 => true),
		"inbat"		=>	array(11 => true),
		"needguy"	=>	array(9 => 1),
		"group"		=>	14,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_INFANTERIE,
);

//Pr�re de Dumathoin,
$this->unt[16]=array(
		"defense"	=>	12,
		"bonus"		=> array('def' => 1),
		"vie"		=>	16,
		"attaque"	=>	4,
		"attaquebat"	=>	0,
		"speed"		=>	3,
		"needsrc" => 25,
		"prix"		=>	array(9 => 5, 16 => 1),
		"needbat"	=>	array(18 => true),
		"inbat"		=>	array(18 => true),
		"needguy"	=>	array(8 => 1),
		"group"		=>	16,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Pr�re de Moradin,
$this->unt[17]=array(
		"defense"	=>	4,
		"bonus"		=> array('atq' => 1),
		"vie"		=>	14,
		"attaque"	=>	12,
		"attaquebat"	=>	1,
		"speed"		=>	3,
		"needsrc" => 24,
		"prix"		=>	array(9 => 5, 16 => 1),
		"needbat"	=>	array(18 => true),
		"inbat"		=>	array(18 => true),
		"needguy"	=>	array(8 => 1),
		"group"		=>	16,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Graveur de runes,
$this->unt[18]=array(
		"defense"	=>	30,
		"bonus"		=> array('def' => 2),
		"vie"		=>	25,
		"attaque"	=>	10,
		"attaquebat"	=>	3,
		"speed"		=>	5,
		"needsrc" => 13,
		"prix"		=>	array(1 => 10, 9 => 6, 17 => 1),
		"needbat"	=>	array(19 => true),
		"inbat"		=>	array(19 => true),
		"needguy"	=>	array(9 => 1),
		"group"		=>	18,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Lanceur de runes,
$this->unt[19]=array(
		"defense"	=>	10,
		"bonus"		=> array('atq' => 2),
		"vie"		=>	25,
		"attaque"	=>	30,
		"attaquebat"	=>	4,
		"speed"		=>	8,
		"needsrc" => 12,
		"prix"		=>	array(1 => 10, 9 => 6, 17 => 1),
		"needbat"	=>	array(19 => true),
		"inbat"		=>	array(19 => true),
		"needguy"	=>	array(9 => 1),
		"group"		=>	18,
		"type"		=>	TYPE_UNT_INFANTERIE,
		"role"  => UNT_ROLE_DISTANCE,
);

//Catapulte attel�
$this->unt[20]=array(
		"defense"	=>	4,
		"vie"		=>	6,
		"attaque"	=>	20,
		"attaquebat"	=>	55,
		"speed"		=>	4,
		"needsrc" 	=> 22,
		"prix"		=>	array(2 => 10, 3 => 20, 7 => 1, 8 => 5),
		"needbat"	=>	array(15 => true),
		"inbat"		=>	array(15 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	20,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);

//B�ier attel�
$this->unt[21]=array(
		"defense"	=>	0,
		"vie"		=>	6,
		"attaque"	=>	0,
		"attaquebat"	=>	80,
		"speed"		=>	4,
		"needsrc" => 22,
		"prix"		=>	array(3 => 10,2 => 20,8 => 5,7 => 1),
		"needbat"	=>	array(15 => true),
		"inbat"		=>	array(15 => true),
		"needguy"	=>	array(7 => 2),
		"group"		=>	20,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);
	
//B�ier T�e-de-mort,
$this->unt[22]=array(
		"defense"	=>	5,
		"vie"		=>		10,
		"attaque"	=>	20,
		"attaquebat"	=>	150,
		"speed"		=>	2,
		"needsrc" => 21,
		"prix"		=>	array(3 => 80, 9 => 10,8 => 20, 2 => 40),
		"needbat"	=>	array(15 => true),
		"inbat"		=>	array(15 => true),
		"needguy"	=>	array(7 => 2),
		"group"		=>	22,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);	

//Baliste,
$this->unt[23]=array(
		"defense"	=>	10,
		"vie"		=>		4,
		"attaque"	=>	20,
		"attaquebat"	=>	45,
		"speed"		=>	2,
		"needsrc" => 21,
		"prix"		=>	array(8 => 10, 2 => 20),
		"needbat"	=>	array(15 => true),
		"inbat"		=>	array(15 => true),
		"needguy"	=>	array(8 => 1),
		"group"		=>	22,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);

//Transport de troupes
//** ATTENTION! **
//Doit comporter une fonction sp�iale pour la modification de la vitesse des unit� d'infanterie charg�s
//Peu embarquer 5 unit� d'infanteries (tout sauf ce qui sort des ateliers)
//La vitesse des unit� charg�s devient �ale �celle du transport de troupes
$this->unt[24]=array(  
	  "defense"	=>	0,
		"vie"		=>	4,
		"attaque"	=>	0,
		"attaquebat"	=>	0,
		"speed"		=>	10,
		"carry" 	=> 	TYPE_UNT_INFANTERIE,
    		"capacity" 	=> 	20,
		"needsrc" 	=> 	23,
		"prix"		=>	array(7 => 16, 2 => 150, 8 => 30),
		"needbat"	=>	array(16 => true),
		"inbat"		=>	array(16 => true),
		"needguy"	=>	array(7 => 1),
		"group"		=>	24,
		"type"		=>	TYPE_UNT_MACHINE,
		"role"  => UNT_ROLE_MACHINE,
);

//Golem d'acier
//$this->unt[25]=array(  
//	  "defense"	=>	20,
//		"vie"		=>		80,
//		"attaque"	=>	60,
//		"attaquebat"	=>	20,
//		"speed"		=>	1,  //attention, �verrifier
//		"needsrc" => 22,
//		"prix"		=>	array(2 => 60, 8 => 30, 9 => 10),
//		"needbat"	=>	array(15 => true),
//		"needguy"	=>	array(1 => 4),
//		"group"		=>	24,
//    "type"		=>	TYPE_UNT_MACHINE,
//		"role"  => UNT_ROLE_CREATURE,
//);
	
//*************************************//
//          o Recherches o           //
//                                     //
// 'maxdst' = distance max pour        //
//            �hange (defaut 5)       //
//*************************************//

//Mine niv1,
$this->src[1]=array(
		"tours"		=>	5,
		"prix"		=>	array(4 => 40),
		"group"		=>	1,
);

//Mine niv2,
$this->src[2]=array(
		"tours"		=>	15,
		"needsrc"	=>	 1,
		"prix"		=>	array(4 => 100, 3 => 80),
		"group"		=>	1,
);

//Commerce niv1,
$this->src[3]=array(
		"tours"		=>	15,
		"prix"		=>	array(1 => 100),
		"group"		=>	3,
);

//Commerce niv2,
$this->src[4]=array(
		"tours"		=>	50,
		"needsrc"	=>	 3,
		"prix"		=>	array(1 => 350, 2 => 50, 4 => 600),
		"group"		=>	3,
);

//Commerce niv3,
$this->src[5]=array(
		"tours"		=>	125,
		"needsrc"	=>	 4,
		"prix"		=>	array(1	=> 1000, 4 => 2000, 2 => 200, 3 => 800),
		"group"		=>	3,
);

//Fonte de l'acier,
$this->src[6]=array(
		"tours"		=>	20,
		"needbat"	=>	array(5 => true, 6 => true),
		"prix"		=>	array(1 => 40, 3 => 150, 5 => 60, 6 => 60),
		"group"		=>	6,
);

//Travail de l'acier,
$this->src[7]=array(
		"tours"		=>	30,
		"needsrc"	=>	6,
		"prix"		=>	array(1 => 80, 3 => 300, 5 => 180, 6 => 180, 8 => 75),
		"group"		=>	6,
);

//Fonte du mithril,
$this->src[8]=array(
		"tours"		=>	150,
		"needsrc"	=>	7,
		"prix"		=>	array(1 => 150, 3 => 600, 8 => 400),
		"group"		=>	6,
);

//M�anisles simples,
$this->src[9]=array(
		"tours"		=>	100,
		"needbat"	=>	array(12 => true),
		"prix"		=>	array(1 => 100, 2 => 150, 3 => 250, 8 => 100),
		"group"		=>	9,
);

//M�anismes complexes,
$this->src[10]=array(
		"tours"		=>	150,
		"needsrc"	=>	9,
		"prix"		=>	array(1 => 150, 2 => 200, 3 => 250, 8 => 150),
		"group"		=>	9,
);

//Fortifications,
$this->src[11]=array(
		"tours"		=>	150,
		"needbat"	=>	array(12 => true),
		"prix"		=>	array(2 => 50, 3 => 400, 8 => 75),
		"group"		=>	11,
);

//Ecriture runique,
$this->src[12]=array(
		"tours"		=>	250,
		"needbat"	=>	array(19 => true),
		"needsrc"	=>	8,
		"prix"		=>	array(1 => 350, 3 => 700,4 => 1000, 9 => 80),
		"incompat"=>  13,
		"group"		=>	12,
);

//Gravure runique,
$this->src[13]=array(
		"tours"		=>	250,
		"needbat"	=>	array(19 => true),
		"needsrc"	=>	8,
		"prix"		=>	array(1 => 350, 3 => 600,4 => 1300, 9 => 100),
		"incompat"=>  12,
		"group"		=>	12,
);

//Chasseurs nains,
$this->src[14]=array(
		"tours"		=>	25,
		"needbat"	=>	array(9 => true),
		"prix"		=>	array(1 => 40, 3 => 200, 4 => 200, 5 => 50, 6 => 50),
		"group"		=>	14,
);

//Combattants nains,
$this->src[15]=array(
		"tours"		=>	80,
		"needsrc"	=>	14,
		"prix"		=>	array(1 => 90, 3 => 300, 4 => 400, 8 => 110),
		"group"		=>	14,
);

//Guerriers nains,
$this->src[16]=array(
		"tours"		=>	160,
		"needsrc"	=>	15,
		"prix"		=>	array(1 => 180, 3 => 400, 4 => 1000, 8 => 100, 9 => 50),
		"group"		=>	14,
);

//Armes niv1,
$this->src[17]=array(
		"tours"		=>	25,
		"needbat"	=>	array(14 => true),		
		"needsrc"	=>	7,
		"prix"		=>	array(8 => 10),
		"group"		=>	17,
);

//Armes niv2,
$this->src[18]=array(
		"tours"		=>	80,
		"needsrc"	=>	17,
		"prix"		=>	array(2 => 25, 3 => 100, 5 => 100, 6	=> 100, 8 => 40),
		"group"		=>	17,
);

//Armures niv1,
$this->src[19]=array(
		"tours"		=>	25,
		"needbat"	=>	array(14 => true),
		"needsrc"	=>	7,
		"prix"		=>	array(8 => 10),
		"group"		=>	19,
);

//Armures niv2,
$this->src[20]=array(
		"tours"		=>	80,
		"needsrc"	=>	19,
		"prix"		=>	array(1 => 40, 8 => 40, 9 => 30),
		"group"		=>	19,
);

//Machines de guerre niv1,
$this->src[21]=array(
		"tours"		=>	80,
		"needbat"	=>	array(15 => true),
		"prix"		=>	array(2 => 100, 3 => 200, 8 => 100),		
		"group"		=>	21,
);

//Machines de guerre niv2,
$this->src[22]=array(
		"tours"		=>	160,
		"needsrc"	=>	 21,
		"prix"		=>	array(1 => 100, 2 => 200, 3 => 300, 5 => 100, 6 => 100),
		"group"		=>	21,
);

//Machines de guerre niv3,
$this->src[23]=array(
		"tours"		=>	250,
		"needsrc"	=>	 22,
		"prix"		=>	array(2 => 300, 4 => 500, 7 => 20, 8 => 100, 9 => 100),
		"group"		=>	21,
);

//Suivant de Moradin,
$this->src[24]=array(
		"tours"		=> 150,
		"needbat"	=>	array(18 => true),
		"needsrc"	=>	 8,
		"prix"		=>	array(1 => 200, 3 => 400, 4 => 200),
		"incompat"=>  25,
		"group"		=>	24,
);

//Suivant de Dumatho�,
$this->src[25]=array(
		"tours"		=> 150,
		"needbat"	=>	array(18 => true),
		"needsrc"	=>	 8,
		"prix"		=>	array(1 => 200, 3 => 400, 4 => 200),
		"incompat"=>  24,
		"group"		=>	25,
);

}
}
?>