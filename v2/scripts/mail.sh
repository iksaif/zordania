#!/bin/bash
DATE=$(date "+%d_%m_%Y")
ZPATH=/home/zorddev
cd $ZPATH/tools
php -q $ZPATH/tools/relance_mail.php $1 $2 >> $ZPATH/logs/crons/mail_$DATE.log
