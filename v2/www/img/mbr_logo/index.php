<?php
header("Content-type: image/png");

$id = (int) isset($_GET['mid']) ? $_GET['mid'] : 0;

if(file_exists($id.".png"))
{
	readfile($id.".png");
}
else
{
	readfile("0.png");
}
?>
