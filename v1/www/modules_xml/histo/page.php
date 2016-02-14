<?
if(_index_!="ok"){ exit; }
$mid = (int) isset($_GET['mid']) ? $_GET['mid'] : "";
$key = (int) isset($_GET['key']) ? $_GET['key'] : "";
if(!$mid OR !$key)
{
	echo"test";exit;
}



$limite1 = LIMIT_PAGE;
$limite2 = 0;

$conf=array();
$mbr = new member($_sql, $game, $conf);

include('lib/histo.class.php');
$histo = new histo($_sql);

$mbr_array = $mbr->get_infos($_GET['mid']);
$mbr_array = $mbr_array[0];
if(!is_array($mbr_array) OR $key != $histo->calc_key($mbr_array['mbr_mid'],$mbr_array['mbr_pseudo'],$mbr_array['mbr_pass']))
{
	exit;
}
else
{
	$_tpl->set("histo_array",$histo->get_infos($mbr_array['mbr_mid'],$limite1,$limite2));
	$_tpl->set("session_user",array('pseudo' => $mbr_array['mbr_pseudo'],'mid' => $mbr_array['mbr_mid'], 'race' => $mbr_array['mbr_race']));
}


?>