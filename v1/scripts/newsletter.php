<?php
define("DIR","../public_html/");
include(DIR.'lib/mysql.class.php');
include(DIR.'lib/divers.class.php');
include(DIR.'conf/conf.inc.php');
include(DIR.'lib/forum.class.php');



$sql=new mysql(MYSQL_URL, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BASE);
set_time_limit(0);
$req="SELECT mbr_pseudo,mbr_mail FROM zrd_mbr";
$mbr_array = $sql->make_array($req);
$i=0;
foreach($mbr_array as $value) {
  $txt = "Bonjour {$value['mbr_pseudo']} !\r\n";
  $txt.= "La nouvelle version de Zordania est là ! Pour découvrir les nouveautées rend toi sur http://www.zordania.com ! \r\n";
  $txt.= "Bon Jeu !\r\n";
  $txt.=" L'équipe de www.zordania.com.";
  $to      = $value['mbr_mail'];
  $subject = 'Zordania.com';
  $headers =  'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $txt, $headers);
  usleep(200000);
  $i++;
  if(!($i%100)) echo "$i\n";
}

?>