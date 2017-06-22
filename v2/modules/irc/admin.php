<?php
//Verif
if(!defined("_INDEX_") || !can_d(DROIT_ADM)){ exit; }

//require_once("lib/mch.lib.php");

$_tpl->set("admin_tpl","modules/irc/admin.tpl");
$_tpl->set("admin_name","Barnabe");
$_tpl->set("act",$_act);


if($_act == "kill")
{
	$pid = request("pid", "uint", "get", 0);
	if($pid)
		exec("kill $pid", $lres);
	$_tpl->set('lres', $lres);
	$_tpl->set('pid', $pid);
}
else if($_act == "go")
{
    //exec("php ".SITE_DIR."/tools/ircbot.php > ".SITE_DIR."/logs/irc/irc.log &", $lres);
	exec("php ".SITE_DIR."/tools/ircbot.php > /dev/null &", $lres);
	$_tpl->set('lres', $lres);
}

// liste des processus PHP
exec("ps -C php -f", $pids);
if($pids[0]){ // titre tableau
	$tmp = explode(' ', $pids[0]);
	unset($pids[0]);
	$titre = array();
	foreach($tmp as $value)
		if (trim($value)!='')
			$titre[] = trim($value);
}
foreach($pids as $key => $lres){ // contenu tableau
	$arr = array();
	$lres = explode(' ', $lres);
	foreach($lres as $value) if(trim($value)!='') $arr[] = trim($value);
	$pids[$key] = $arr;
}
$pid2 = array(); // trouver le pid
$lpid = 0;
foreach($titre as $key => $value) if ($value == 'PID') {$lpid = $key; break;}
foreach($pids as $value) $pid2[$value[$lpid]] = $value;

$_tpl->set('titre',$titre);
$_tpl->set('pids',$pid2);

?>
