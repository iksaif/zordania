<?php
while(true) {
	$sec = date("s");
	while($sec == date("s") || date("s") % 10) {
		usleep(200000);
	}
	passthru("php cron.php");
}
?>