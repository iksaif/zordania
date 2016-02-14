#! /bin/bash

thedate=`/bin/date +%D | /usr/bin/tr ./. .-.`
cd /home/zordania/backup/
/usr/bin/mysqldump -hlocalhost -u zordania -pqima06 zordv2  > zordv2.dump.$thedate
gzip zordv2.dump.$thedate
