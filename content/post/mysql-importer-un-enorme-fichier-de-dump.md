+++
description = ""
slug = "mysql-importer-un-enorme-fichier-de-dump"
draft = false
title = "[MySQL] Importer un énorme fichier de dump"
date = 2014-09-30T11:10:20Z
author = "MrRaph_"
categories = ["Gros Dump","Import","MySQL","Trucs et Astuces"]
tags = ["Gros Dump","Import","MySQL","Trucs et Astuces"]

+++


MySQL a par défaut des limitations en terme de taille maximales de paquets, dans certains cas, il est nécessaire de les augmenter pour pouvoir importer de très gros fichiers de dump.  

 Dans notre exemple, le fichier fait presque 1,5 Go.

    [root@xxxx mysql]# du -sh dump_databaseName.sql 1,3G dump_databaseName.sql

 

Voici deux commandes a passer dans une commande MySQL afin d’augmenter les seuils :

    [root@xxxx mysql]# mysql -u root -p
    Enter password:
    Welcome to the MySQL monitor.
    Commands end with ; or \g.
    Your MySQL connection id is 323
    Server version: 5.1.73 Source distribution Copyright (c) 2000, 2013, Oracle and/or its affiliates. All rights reserved. Oracle is a registered trademark of Oracle Corporation and/or its affiliates. Other names may be trademarks of their respective owners.
    Type 'help;' or '\h' for help.
    Type '\c' to clear the current input statement.
    mysql> set global net_buffer_length=10000000000000;
    Query OK, 0 rows affected, 2 warnings (0.00 sec)
    mysql> set global max_allowed_packet=1000000000000000000;
    Query OK, 0 rows affected, 1 warning (0.00 sec)
    mysql> exit
    Bye

Ceci modifie temporairement les seuils, les valeurs originales seront restaurées au prochain redémarrage du serveur MySQL.

 

Si vous voulez gardez ces valeurs de manière permanente, il faut les renseigner dans votre fichier my.cnf.

 

Ensuite, on peut importer le dump en passant un option supplémentaire au client MySQL.

    [root@xxxx mysql]# mysql --max_allowed_packet=2048M -u root -pPassword -D databaseName < dump_databaseName.sql

 

 
