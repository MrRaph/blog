+++
image = "https://techan.fr/images/2014/10/SQL_term.png"
description = ""
draft = false
categories = ["la réplication multi maitres avec mysql","Mult-master","MySQL","Replication","Survival Guide"]
slug = "la-replication-multi-maitres-avec-mysql"
title = "La réplication multi-maitres avec MySQL"
date = 2015-02-25T16:09:46Z
author = "MrRaph_"
tags = ["la réplication multi maitres avec mysql","Mult-master","MySQL","Replication","Survival Guide"]

+++


MySQL, ou MariaDB dans mon cas, proposent depuis longtemps une solution incluse de réplication. Je vais expliquer ici comment utiliser ce mécanisme afin de faire de la réplication multi-maitre d’une base entre deux instances MySQL. Rassurez-vous ce n’est pas très compliqué ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

Dans cet article, je pars du principe que vous avez déjà dans toutes les instances MySQL la même base de donnée, avec la même fraîcheur de données. Dans mon exemple, j’ai deux instance MySQL comportant chacune une base « techd », j’ai créé cette base dans ma deuxième instance avec export mysqldump.

Pour cet exemple, je vais donc partir du principe que ma base « techd » existait sur le serveur A, que je l’ai importé sur le serveur B et que je vais mettre la réplication entre techd@A vers techd@B puis de techd@B vers techd@A.

 


## Préparation des instances MySQL

Afin de pouvoir utiliser la réplication fournie par MySQL/MariaDB, il y a deux prérequis que voici :

- Avoir activé les binlogs
- Avoir configuré un « server-id » différent sur les instances MySQL

Il y a d’autres paramètres que l’on peut spécifier afin de coller plus aux besoins mais ces deux là sont les seuls vraiment nécessaires.

#### Les prérequis au niveau des instances

Dans le fichier de configuration de MySQL, il faut ajouter ou dé-commenter les lignes (pensez également a ajuster les valeurs pour votre cas) :

    server-id = 3456723
    log_bin = /data/mysql/logs/mysql-bin.log

Ces lignes doivent se trouver dans la partie « [mysqld] » du fichier de configuration. Chaque instance MySQL mise en réplication doit avoir une valeur de « sever-id » différente.

Le fait d’ajouter la ligne « log_bin » active les « binlogs » de MySQL, l’équivalent des archive logs d’Oracle. Le chemin spécifié comme valeur de ce paramètres permet de dire à MySQL ou aller stocker ses binlogs.

 

Deux paramètres supplémentaires peuvent être intéressants :

    binlog_do_db = techd
    expire_logs_days = 10

Le paramètre « binlog_do_db » est utilisé pour spécifier pour quelle(s) base(s) ont active les binlogs, si il n’est pas spécifié, ils sont activés pour toutes les bases même pour les bases système … On peut ne pas spécifier ce paramètre et exclure certaines bases, comme les bases système, le paramètre pour faire ça est « binlog_ignore_db ».

Le paramètre « expire_log_days » permet de faire un peu de ménage et de ne pas garder tous les binlogs en ligne.

Une fois que tous les paramètres ont été correctement positionné, il faut redémarrer MySQL.

#### Créer le compte de réplication

Pour que la réplication fonctionne, il faut créer un utilisateur dans chaque instance MySQL. Cet utilisateur aura un privilège spécifique pour pouvoir gérer la réplication, il ne pourra rien faire d’autre dans MySQL.

Voici comment créer cet utilisateur.

    MariaDB [(none)]> create user 'replicator'@'%' identified by 'password';
    Query OK, 0 rows affected (0.00 sec)
    MariaDB [(none)]> grant replication slave on *.* to 'replicator'@'%';
    Query OK, 0 rows affected (0.00 sec)

 

#### Récupérer la position actuelle dans le binlogs

Maintenant que les instances MySQL écrivent des binlogs, il faut récupérer la position de chaque instance dans ses logs. Ce sera la position de départ pour notre réplication.

Voici la marche à suivre pour avoir ces informations, il faut faire cette manipulation sur les deux instance MySQL.

    MariaDB [(none)]> show master status;
    +------------------+----------+--------------+------------------+
    | File | Position | Binlog_Do_DB | Binlog_Ignore_DB |
    +------------------+----------+--------------+------------------+
    | mysql-bin.000191 | 245 | techd | |
    +------------------+----------+--------------+------------------+
    1 row in set (0.00 sec)


##  La réplication multi-maitres avec MySQL

#### Sur le serveur B, réplication de techd@A vers techd@B

Dans un premier temps, on arrête le processus esclave, au cas ou il tournerait déjà.

    MariaDB [(none)]> stop slave ;
    Query OK, 0 rows affected, 1 warning (0,00 sec)

**<span style="text-decoration: underline;"> Note :</span>** Ceci est la syntaxe pour MariaDB, pour MySQL, il faut inverser les mots. Dans ce cas, la commande pour MySQL aurait été : « slave stop; »

Maintenant on définit le maître, il faut adapter l’IP, le mot de passe et la position dans le binlogs avec ce que l’on a récupéré plus tôt.

    MariaDB [(none)]> CHANGE MASTER TO MASTER_HOST = 'IP DE A', MASTER_USER = 'replicator', MASTER_PASSWORD = 'password', MASTER_LOG_FILE = 'mysql-bin.000190', MASTER_LOG_POS = 22182220;
    Query OK, 0 rows affected (0,04 sec)

Et enfin, on démarre l’esclave.

    MariaDB [(none)]> start slave ;
    Query OK, 0 rows affected (0,00 sec)

 

#### Sur le serveur A, réplication de techd@B vers techd@A

Même manipulation dans l’autre sens, toujours en adaptant le password, l’IP et les positions dans les binlogs.

    MariaDB [(none)]> stop slave ;
    Query OK, 0 rows affected, 1 warning (0.00 sec)
    MariaDB [(none)]> CHANGE MASTER TO MASTER_HOST = 'IP de B', MASTER_USER = 'replicator', MASTER_PASSWORD = 'password', MASTER_LOG_FILE = 'mysql-bin.000001', MASTER_LOG_POS = 631;
    Query OK, 0 rows affected (0.18 sec)
    MariaDB [(none)]> start slave ;
    Query OK, 0 rows affected (0.01 sec)

####  Vérifier l’état de la synchronisation

On peut vérifier l’état de la synchronisation dans des outils comme phpMyAdmin, mais on peut également le faire avec le client MySQL sur la machine.

    MariaDB [(none)]> show slave status \G
    *************************** 1. row ***************************
    Slave_IO_State: Waiting for master to send event
    Master_Host: IP du Maitre Master_User: replicator
    Master_Port: 3306
    Connect_Retry: 60
    Master_Log_File: mysql-bin.000001
    Read_Master_Log_Pos: 631
    Relay_Log_File: mysqld-relay-bin.000002
    Relay_Log_Pos: 532
    Relay_Master_Log_File: mysql-bin.000001
    Slave_IO_Running: Yes
    Slave_SQL_Running: Yes
    Replicate_Do_DB:
    Replicate_Ignore_DB:
    Replicate_Do_Table:
    Replicate_Ignore_Table:
    Replicate_Wild_Do_Table:
    Replicate_Wild_Ignore_Table:
    Last_Errno: 0
    Last_Error:
    Skip_Counter: 0
    Exec_Master_Log_Pos: 631
    Relay_Log_Space: 827
    Until_Condition: None
    Until_Log_File:
    Until_Log_Pos: 0
    Master_SSL_Allowed: No
    Master_SSL_CA_File:
    Master_SSL_CA_Path:
    Master_SSL_Cert:
    Master_SSL_Cipher:
    Master_SSL_Key:
    Seconds_Behind_Master: 0
    Master_SSL_Verify_Server_Cert: No
    Last_IO_Errno: 0
    Last_IO_Error:
    Last_SQL_Errno: 0
    Last_SQL_Error:
    Replicate_Ignore_Server_Ids:
    Master_Server_Id: 3456723
    1 row in set (0.00 sec)

 
