#! /bin/bash

thedate=`/bin/date "+%d_%m_%Y.%H"`
cd /home/zordania/v1/www/logs/crons/out
php -q /home/zordania/v1/crons/index.php > out_$thedate.log