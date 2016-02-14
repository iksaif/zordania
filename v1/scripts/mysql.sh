#! /bin/bash

thedate=`/bin/date +%D | /usr/bin/tr ./. .-.`
cd /home/zordania/backup/
/usr/bin/mysqldump -hlocalhost -u zordania -pJnptqdb zordania  > zordania.dump.$thedate
gzip zordania.dump.$thedate
