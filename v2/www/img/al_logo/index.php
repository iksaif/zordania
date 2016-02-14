<?php
header("Content-type: image/png");

$id = (int) isset($_GET['alid']) ? $_GET['alid'] : 0;

if(isset($_GET['thumb']))
{
	$id.="-thumb";
}

if(file_exists($id.".png"))
{
	readfile($id.".png");
}
else
{
	readfile("0.png");
}
?>