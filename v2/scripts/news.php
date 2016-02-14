<?php
define("DIR","../");
include(DIR.'lib/divers.lib.php');
include(DIR.'lib/mysql.class.php');
include(DIR.'conf/conf.inc.php');

$sql=new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BASE);
set_time_limit(0);
$req="SELECT mbr_pseudo,mbr_mail FROM zrd_mbr";
$mbr_array = $sql->make_array($req);
$i=0;
foreach($mbr_array as $value) {
  $txt = "Bonjour {$value['mbr_pseudo']} !\r\n";
  $txt.= "Le site est de nouveau en ligne. Excusez-nous du derangement.\r\n";
  $txt.= "Bon Jeu !\r\n";
  $txt.=" L'équipe de www.zordania.com.";
  $to      = $value['mbr_mail'];
  $subject = 'Zordania.com';
  $headers =  'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $txt, $headers);
  usleep(100000);
  $i++;
  if(!($i%100)) echo "$i\n";
}

?>