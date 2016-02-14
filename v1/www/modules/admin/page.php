<?
//Verif
if(_index_!="ok" or $_SESSION['user']['droits']{3}!=1){ exit; }
//include de la classe
include("lib/admin.class.php");

$admin=new admin(SITE_DIR."conf/conf.inc.php");

$_tpl->set("module_tpl","modules/admin/admin.tpl");


//appel des fonctions en fonction de get ou post
if(@file_exists("modules/$_GET[module]/admin.php"))
{
	include("modules/$_GET[module]/admin.php");
}else{
	$_tpl->set("admin_array",$admin->get_admin_page());
}
?>