<?php
if(INDEX_BTC != true){ exit; }

require_once("lib/src.lib.php");
require_once("lib/unt.lib.php");

//Rien (liste unt + src)
if(!$_sub)
{
        $_tpl->set("btc_act",false);


        $unt_todo = get_unt_todo($_user['mid']);

        foreach($unt_todo as $id => $value) {
                if(!in_array($btc_type,get_conf("unt",$value['utdo_type'],"need_btc")))
                        unset($unt_todo[$id]);
        }


        $src_todo = get_src_todo($_user['mid']);
        $src_todo = index_array($src_todo, "stdo_type");

        $_tpl->set("unt_todo",$unt_todo);
        $_tpl->set("src_todo",$src_todo);
        $_tpl->set("src_conf",get_conf("src"));

}
?>