<?
if(_index_!="ok" or $_SESSION['user']['droits']{2}!=1 or $_SESSION['user']['droits']{17}!=1){ exit; }

$act = isset($_GET['act']) ? $_GET['act'] : "";
$sub = isset($_GET['sub']) ? $_GET['sub'] : "";

include('lib/forum.class.php');
$al  = new alliances($_sql);

$_tpl->set("module_tpl","modules/forum/forum.tpl");


?>
//verifications des droits (le droit d'admin du forum est le 17)

//includes

//Page principale
//Affiche tout un peu comme ibp
//liens suprimer  - modifier - nouveau forum ici
//Nouvelle cat

//Edition  des cats
	//edit
		//Possibiliter de changer : nom - position - droit
	//del
		//pas besoin de confirmation les admins sont pas cons
		//faut preciser la cat vers la quelle deplacer :)
	//new
	
//Editions des frm
	//edit
		//Possibilitée de changer : nom - position - droit - cat (affiche les noms des cat possibles)
		//Description parsée avec le parseur
	//del
		//pas besoin de confiramtion, admin pas cons
	//new

