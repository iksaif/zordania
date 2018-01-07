#!/bin/bash
DATE=$(date "+%d_%m_%Y.%H")
#ZPATH=$(dirname `pwd`/$0)/../
ZPATH=/home/pi/Documents/zordania/zordania/v2
echo $ZPATH $DATE
php -q $ZPATH/crons/cron.php >> $ZPATH/logs/crons/out/out_$DATE.log
