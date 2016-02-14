#!/bin/bash
# backup de la version en cours de zord
DATE=$(date +'%Y%m%d%H%M%S')
ZPATH=/home/zordania/v2
BKPATH=$ZPATH/backup/php_$DATE
clear
echo sauvegarde vers $BKPATH...

# création du répertoire backup s'il n'existe pas
mkdir -p $ZPATH/backup

echo création de l\'archive
if rsync --archive --cvs-exclude $ZPATH/ $BKPATH --exclude-from='exclude.rsync' ; then
  echo compression de $BKPATH...
  tar -zcf $BKPATH.tar.gz $BKPATH
  echo suppression
  rm -r $BKPATH/
else
  echo Erreur sur la compression.
fi

