#!/bin/bash
DATE=$(date "+%d_%m_%Y.%H")
#ZPATH=$(dirname `pwd`/$0)/../
#echo $ZPATH
ZPATH=/home/zordania/v2
php -q $ZPATH/crons/cron.php >> $ZPATH/logs/crons/out/out_$DATE.log
