#! /bin/bash

thedate=`/bin/date "+%d_%m_%Y.%H"`
cd /home/zordania/war/logs/crons/out
php -q /home/zordania/crons_war/index.php > out_$thedate.log