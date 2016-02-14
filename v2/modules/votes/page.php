<?php
//Verifications
if(!defined("_INDEX_")){ exit; }
if(can_d(DROIT_PLAY)!=true)
	$_tpl->set("need_to_be_loged",true); 
else
{
	require_once("lib/votes.lib.php");
	require_once("lib/member.lib.php");
	require_once("lib/mch.lib.php");
	require_once("lib/res.lib.php");

	$_tpl->set('module_tpl', 'modules/votes/votes.tpl');

	/*
	$type_res = request("type_res", "uint", "post", request("type_res", "uint", "get"));
	$id = request("id", "uint", "get");
	$votes=get_conf("votes");
	*/

	 $vid = request('vid','uint','get', 0);
        if($vid)
        {
                $vote_ok = add_votes($_user['mid'], $vid);
                $_tpl->set('vote_ok',$vote_ok);
		$votes_up=true;
        }
        //$votes_nb = request('votes_nb','uint','get');
        //$_tpl->set('votes_nb',$votes_nb);
 
        $votes_array = get_votes($_user['mid']);
        $_tpl->set('votes_array',$votes_array);
        $_tpl->set('votes_conf',$_votes);
}
?>
