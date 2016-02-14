#!/bin/bash
DATE=$(date "+%d_%m_%Y.%H")
#ZPATH=$(dirname `pwd`/$0)/../
#echo $ZPATH
ZPATH=/home/zorddev

i="0"

while [ $i -lt 5 ]
do
	php -q $ZPATH/crons/cron.php >> $ZPATH/logs/crons/out/out_$DATE.log &
	sleep 10
	i=$[$i+1]
done


