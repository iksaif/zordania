#!/bin/bash
DATE=$(date "+%d_%m_%Y.%H")
ZPATH=/home/zorddev
cd $ZPATH/tools
php relance_mail.php $1 $2 >> $ZPATH/logs/crons/mail.$DATE.log 
