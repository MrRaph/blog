+++
author = "MrRaph_"
categories = ["lancer plusieurs instances mysql sur une machine","Multi instances","MySQL","Trucs et Astuces"]
image = "https://techan.fr/images/2014/10/SQL_term.png"
description = ""
slug = "lancer-plusieurs-instances-mysql-sur-une-machine"
draft = false
date = 2015-03-24T09:25:52Z
tags = ["lancer plusieurs instances mysql sur une machine","Multi instances","MySQL","Trucs et Astuces"]
title = "Lancer plusieurs instances MySQL sur une machine"

+++


J’ai dû faire en sorte que l’on puisse faire tourner deux instances MySQL sur une seule machine afin d’en faire une machine « esclave » dans une architecture MySQL répliquée, voir [La réplication multi-maitres avec MySQL ](https://techan.fr/la-replication-multi-maitres-avec-mysql/). Chacune des deux instances va recevoir les modifications apportées à l’une des eux instances de prod (LAN et DMZ). Vous allez voir que c’est plutôt simple de faire tourner deux instances MySQL sur une même machine, mieux que ça, cela a déjà été pensé pour !

Je pars du principe que vous avez déjà installé MySQL sur la machine en question et que MySQL fonctionne correctement et que le daemon est éteint.

 


## Les préparatifs

Afin de bien cloisonner les deux instances, j’ai fais en sorte que les dossiers de données de chaque instance soir placé sur un disque dédié, un LV en fait.

Mon architecture de fichiers est faite comme suit :

/data + mysql + LAN + data + logs + DMZ + data + logs

Mes LVs sont montés sur /data/mysql/LAN et /data/mysql/DMZ ainsi chaque instance est étanche.


## La mise en place

### Création des groupes

Afin de créer chaque instance, il nous faut éditer le fichier /etc/my.cnf et créer des groupes. Le fichier de base en contient déjà, chaque groupe commence par un mot encadré de crochets. Par exemple : [mysqld] en est un.

J’ai besoin de deux instances, je vais donc créer deux groupes, j’ai remplacé le groupe [mysqld] existant par ce qui suit :

    [mysqld1]
    datadir=/data/mysql/LAN/data
    socket=/var/lib/mysql/mysqlLAN.sock
    user=mysql
    symbolic-links=0
    port=3306
    pid-file=/var/run/mysqld/mysqldLAN.pid
    [mysqld2]
    datadir=/data/mysql/DMZ/data
    socket=/var/lib/mysql/mysqlDMZ.sock
    user=mysql
    symbolic-links=0
    port=3307
    pid-file=/var/run/mysqld/mysqldDMZ.pid

###  Le « gros » du problème

En fait, il n’y en a pas, il suffit maintenant d’une commande pour voir l’état des instance MySQL et pour interagir avec elles. Cette commande : « mysqld_multi ».

#### Afficher le statut des instances

    [root@sl-0-mysqlslaveint1 log]# mysqld_multi report
    Reporting MySQL servers
    MySQL server from group: mysqld1 is not running
    MySQL server from group: mysqld2 is not running

La commande nous apprend que les deux instances sont arrêtées.

#### Démarrer les instances MySQL

    [root@sl-0-mysqlslaveint1 log]# mysqld_multi start
    [root@sl-0-mysqlslaveint1 log]# mysqld_multi report
    Reporting MySQL servers
    MySQL server from group: mysqld1 is running
    MySQL server from group: mysqld2 is running

L’option « start » de la commande « mysqld_multi » permet, comme son nom l’indique de démarrer une ou plusieurs instances. Sans paramètre supplémentaire, l’option « start » va démarrer toutes les instances disponibles. Il suffit de préciser après cette option le numéro du groupe a démarrer pour cibler une seule instance.

 

#### Le compte d’arrêt

Maintenant que nos instances démarrent, on va créer le compte technique pour les arrêter. Notez la manière un peu différente de se connecter au instances lorsque l’on est sur la machine locale, je précise le fichier socket afin de me connecter à la bonne instance.

    [root@xxxx ~]# mysql -u root -p -S /var/lib/mysql/mysqlLAN.sock
    Enter password:
    Welcome to the MySQL monitor.
    Commands end with ; or \g.
    Your MySQL connection id is 2 Server version: 5.1.73 Source distribution Copyright (c) 2000, 2013, Oracle and/or its affiliates. All rights reserved. Oracle is a registered trademark of Oracle Corporation and/or its affiliates. Other names may be trademarks of their respective owners.
    Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.
    mysql> GRANT SHUTDOWN ON *.* TO 'multi_admin'@'localhost' IDENTIFIED BY 'password';
    Query OK, 0 rows affected (0.00 sec)
    mysql> FLUSH PRIVILEGES;
    Query OK, 0 rows affected (0.00 sec)
    mysql> exit
    Bye

Une fois le compte créer, on arrête toutes les instances.

    [root@xxxx ~]# mysqld_multi stop
    [root@xxxx ~]# mysqld_multi report
    Reporting MySQL servers
    MySQL server from group: mysqld1 is not running
    MySQL server from group: mysqld2 is not running

Il faut maintenant modifier le fichier /etc/my/cnf pour y ajouter un nouveau groupe.

    [mysqld_multi]
    mysqld = /usr/bin/mysqld_safe
    mysqladmin = /usr/bin/mysqladmin
    user = multi_admin
    password = password
    [mysqld_safe]
    log-error=/var/log/mysqld.log
    pid-file=/var/run/mysqld/mysqld.pid

####  On relance tout est c’est fini !

Il suffit maintenant de redémarrer toutes les instances et le tour est joué !

    [root@xxxx ~]# mysqld_multi start
    [root@xxxx ~]# mysqld_multi report
    Reporting MySQL servers
    MySQL server from group: mysqld1 is running
    MySQL server from group: mysqld2 is running

On vérifie que les instances écoutent bien sur le port que l’on souhaitait :

    [root@xxxx ~]# netstat -anp | grep 330
    tcp 0 0 0.0.0.0:3306 0.0.0.0:* LISTEN 15778/mysqld
    tcp 0 0 0.0.0.0:3307 0.0.0.0:* LISTEN 15784/mysqld

Et voilà comment lancer plusieurs instances MySQL sur une machine !
