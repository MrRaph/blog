+++
categories = ["mail in a box migrer la base de donnees sqlite vers mysql","Mail-in-a-Box","MySQL","Trucs et Astuces"]
tags = ["mail in a box migrer la base de donnees sqlite vers mysql","Mail-in-a-Box","MySQL","Trucs et Astuces"]
image = "https://techan.fr/images/2015/09/Mailinabox.jpg"
slug = "mail-in-a-box-migrer-la-base-de-donnees-sqlite-vers-mysql"
title = "Mail-in-a-Box migrer la base de données SQLite vers MySQL"
author = "MrRaph_"
description = ""
draft = false
date = 2015-11-09T10:50:49Z

+++


Par défaut, Mail in a Box utilise des bases de données SQLite pour stocker vos données, ces dernières sont très pratique, portables et légères. Elles sont tout à fait adaptées pour l’utilisation qu’en fait Mail in a Box, cependant, j’ai rencontré quelques soucis avec une de ces bases de données, celle qui est utilisée pour OwnCloud. OwnCloud permet de stocker les contacts, les calendriers et les fichiers des utilisateurs de Mail in a Box.

 

Dans mon cas, lorsque j’initialise Mail in a Box, j’ai plus de 600 contacts et 5 agendas à importer dans OwnCloud et c’est peu dire que la petite base souffre un peu lors de ces imports. Il est même quasiment impossible d’importer les 600 contacts car des verrous bloquent ce processus … J’ai donc pris le parti d’utiliser un serveur MySQL pour OwnCloud. Voici les étapes à suivre pour procéder à cette migration.

**<span style="text-decoration: underline;">Note :</span>** Vous ne perdrez aucun données déjà stockée dans OwnCloud, la migration embarque également les données des utilisateurs.

 


## Installation de MySQL et pré-requis

 

Voici les commandes qui vous permettront d’installer le serveur et le client MySQL sur votre box.

    root@box:/usr/local/lib/owncloud# aptitude install mariadb-client-5.5 mariadb-server-5.5
    The following NEW packages will be installed: libmariadbclient18{a} libreadline5{a} libterm-readkey-perl{a} mariadb-client-5.5 mariadb-client-core-5.5{a} mariadb-common{a} mariadb-server-5.5 mariadb-server-core-5.5{a} 0 packages upgraded, 8 newly installed, 0 to remove and 0 not upgraded.
    Need to get 8,933 kB of archives. After unpacking 97.8 MB will be used.
    Do you want to continue? [Y/n/?]

Il faut également installer le module PHP pour MySQL.

    root@box:/usr/local/lib/owncloud# aptitude install php5-mysql
     The following NEW packages will be installed: php5-mysql 0 packages upgraded, 1 newly installed, 0 to remove and 0 not upgraded.

 

#### Création de la base de données MySQL

Maintenant, nous allons créer la base de données dans laquelle OwnCloud va stocker vos informations.

    root@box:/usr/local/lib/owncloud# mysql -u root -p
    Enter password:
    Welcome to the MariaDB monitor. Commands end with ; or \g.
    Your MariaDB connection id is 36 Server version: 5.5.44-MariaDB-1ubuntu0.14.04.1 (Ubuntu)
    Copyright (c) 2000, 2015, Oracle, MariaDB Corporation Ab and others.

    Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

    MariaDB [(none)]> create database owncloud ;
    Query OK, 1 row affected (0.00 sec)
    MariaDB [(none)]> grant all privileges on owncloud.* to owncloud@'localhost' identified by 'password' ;
    Query OK, 0 rows affected (0.00 sec)
    MariaDB [(none)]> flush privileges ;
    Query OK, 0 rows affected (0.00 sec)

**<span style="text-decoration: underline;">Note :</span>**Prenez soin de modifier le mot de passe de l’utilisateur ‘owncloud’.

 

Nous allons modifier l’utilisateur **www-data** afin de pouvoir lancer le script de migration, nous remettrons cet utilisateur d’aplomb à la fin de cet article.

Éditez le fichier **/etc/passwd**.

    vi /etc/passwd

 

Repérez la ligne commençant par **www-data**.

    www-data:x:33:33:www-data:/var/www:/usr/sbin/nologin

Remplacez **/usr/sbin/nologin** par **/bin/bash**.

 


## Migrons !

Maintenant que tout est en place, nous allons migrer les données. La commande **occ** est fournie par OwnCloud. Elle a créer les tables nécessaires dans la base MySQL, migrer vos données et modifier le fichier de configuration d’OwnCloud pour qu’il utiliser désormais la base MySQL.

    root@box:/usr/local/lib/owncloud# su - www-data -c 'cd /usr/local/lib/owncloud && php ./occ db:convert-type --all-apps mysql owncloud 127.0.0.1 owncloud'
    What is the database password?
    Creating schema in new database oc_activity 45/45
    [============================] 100% oc_activity_mq 0/0 
    [============================] 0% oc_appconfig 73/73     
    [============================] 100% oc_clndr_calendars 9/9 
    [============================] 100% oc_clndr_objects 966/966 
    [============================] 100% oc_clndr_repeat 63/63 
    [============================] 100% oc_clndr_share_calendar 0/0 
    [============================] 0% oc_clndr_share_event 0/0 
    [============================] 0% oc_contacts_addressbooks 5/5 
    [============================] 100% oc_contacts_cards 625/625 
    [============================] 100% oc_contacts_cards_properties 3355/3355 
    [============================] 100% oc_file_map 0/0 
    [============================] 0% oc_filecache 73/73 
    [============================] 100% oc_files_trash 0/0 
    [============================] 0% oc_group_admin 0/0 
    [============================] 0% oc_group_user 1/1 
    [============================] 100% oc_groups 1/1 
    [============================] 100% oc_jobs 3/3 
    [============================] 100% oc_mimetypes 11/11 
    [============================] 100% oc_preferences 11/11 
    [============================] 100% oc_privatedata 0/0 
    [============================] 0% oc_properties 0/0 
    [============================] 0% oc_share 0/0 
    [============================] 0% oc_share_external 0/0 
    [============================] 0% oc_storages 7/7 
    [============================] 100% oc_users 1/1 
    [============================] 100% oc_users_external 5/5 
    [============================] 100% oc_vcategory 33/33 
    [============================] 100% oc_vcategory_to_object 3352/3352 
    [============================] 100%

 

Et voilà ! Il ne reste plus qu’à remettre l’utilisateur **www-data** d’aplomb et tout sera OK !

 

Éditez le fichier **/etc/passwd**.

    vi /etc/passwd

Repérez la ligne commençant par **www-data**.

    www-data:x:33:33:www-data:/var/www:/bin/bash

Remplacez **/bin/bash** par **/usr/sbin/nologin **.

 

 


