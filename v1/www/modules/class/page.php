<?
if(_index_!="ok"){ exit; }

include("lib/class.class.php");
$top50 = new top50($_sql);

$_tpl->set("module_tpl","modules/class/class.tpl");

$type = isset($_GET['act']) ? $_GET['act'] : 0;
$race = (int) isset($_GET['race']) ? (strstr(USER_RACE,$_GET['race']) ? $_GET['race'] : 0) : 0;

$_tpl->set("class_race",$race);
$_tpl->set("class_type",$type);
$_tpl->set("class_race_nb",$mbr->get_nb_race());

if($type != 0)
{
	$array = $top50->make_class($type,$race);
	$_tpl->set("class_array",$array);
}

?>
