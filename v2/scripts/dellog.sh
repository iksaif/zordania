#!/bin/bash
ZPATH=/home/zordania/v2/logs
find $ZPATH/crons/out/out*log -mtime +30 -exec rm {} \;
find $ZPATH/crons/bench/bench*log -mtime +30 -exec rm {} \;
find $ZPATH/mysql/mysql*log -mtime +30 -exec rm {} \;
find $ZPATH/phperr/php*log -mtime +30 -exec rm {} \;

