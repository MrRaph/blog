+++
author = "MrRaph_"
categories = ["Backup","MySQL","script","script de backup mysql","Shell"]
tags = ["Backup","MySQL","script","script de backup mysql","Shell"]
image = "https://techan.fr/images/2014/11/Linux.png"
title = "Script de backup MySQL"
description = ""
slug = "script-de-backup-mysql"
draft = false
date = 2015-01-23T16:02:37Z

+++


Voici un simple script de backup MySQL.

Son utilisation est simple, il suffit de changer les quelques variables dans le haut du script et de créer l’arborescence ou seront stockés les backups. Ce script se connecte à l’instance MySQL, sort la liste des bases présentes et en fait des mysqldump. Il crée ainsi un fichier pour chaque base qu’il compresse ensuite.

 

#!/bin/bash user='root' password='password' destination="/backup/$(date "+%d")" mail='destinataire@domaine.fr' mkdir -p $destination for i in `echo "show databases;" | mysql -u$user -p$password | grep -v Database`; do mysqldump -u$user -p$password --opt --add-drop-table --routines --triggers --events --single-transaction -B $i > $destination/$i.sql gzip -f $destination/$i.sql done problem_text='' problem=0 for i in `ls $destination/*` ; do size=`du -sk $i | awk '{ print $1 }'` if [ $size -le 2 ] ; then problem_text="$problem_text- $i database. Backupped database size is equal or under 4k ($size)\n" problem=1 fi done if [ $problem -ne 0 ] ; then echo -e "Backups problem detected on :\n\n$problem_text" | mail -s "$HOSTNAME - MySQL backup problem" $mail else echo `echo "show databases;" | mysql -u$user -p$password | grep -v Database` | mail -s "[sl-0-mysql1] Bases sauvegardees" $mail fi find $destination -name "*.gz" -mtime +14 -exec rm {} \;

Il ne reste plus qu’à l’ajouter à la crontab 