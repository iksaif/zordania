 <?
if(INDEX_BTC != true){ exit; }

include("lib/unt.class.php");
$unt = new unt($_sql, $conf, $game);
	
include("lib/src.class.php");
$src = new src($_sql, $conf, $game);
 
//Rien (liste unt + src)
if(!$_sub)
{
	$_tpl->set("btc_act",false);
	
	//on recup la liste
	$unt_array = $unt->get_infos($_SESSION['user']['mid'],0,false);
	$unt_array = $unt_array[0];
	
	//on vire les merdes :p
	if(is_array($unt_array))
	{
	foreach($unt_array as $id => $value)
	{
		if($conf->unt[$id]['inbat'][1] != true)
		{
			unset($unt_array[$id]);
		}
	}
	}
	$unt_array = count($unt_array) ? $unt_array : 0;
	$_tpl->set("unt_array",$unt_array);
	

}
//Annuler unt

//Annuler src

?>