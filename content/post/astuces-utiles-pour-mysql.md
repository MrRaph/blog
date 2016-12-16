+++
author = "MrRaph_"
tags = ["MySQL","Trucs et Astuces"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
slug = "astuces-utiles-pour-mysql"
draft = false
title = "Astuces utiles pour MySQL"
date = 2015-04-15T14:44:07Z
categories = ["MySQL","Trucs et Astuces"]
description = ""

+++


Voici une compilation de différentes astuces utiles pour MySQL. Je les ai trouvées sur différents sites et j’en avais marre de refaire les mêmes recherches à chaque fois que ces petits tracas se représente.


## Recréer le user « debian-sys-maint »

Cet utilisateur privilégié est créé lors de l’installation de MySQL sur les plateformes de la famille Debian. Il permet au système de faire des actions d’administration sans avoir à demander le mot de passe « root ». Par exemple, il me sert à faire les backups MySQL avec BackupNinja. Cependant, il arrive que ce compte soit mal créé ou qu’il soit supprimé … Ça m’est arrivé lorsque j’ai voulu installer un outil psycho -rigide qui voulait forcer l’installation de MySQL en lieu et place de mon serveur MariaDB.

#### Bon à savoir

Le mot de passe de l’utilisateur « debian-sys-maint’ est renseigné dans le fichier de configuration « /etc/mysql/debian.cnf ».

#### La marche à suivre

Il suffit de se connecter à MySQL en root et lancer les commandes SQL suivantes.

use mysql ; INSERT INTO `user` ( `Host`, `User`, `Password`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Reload_priv`, `Shutdown_priv`, `Process_priv`, `File_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Show_db_priv`, `Super_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Execute_priv`, `Repl_slave_priv`, `Repl_client_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Create_user_priv`, `ssl_type`, `ssl_cipher`, `x509_issuer`, `x509_subject`, `max_questions`, `max_updates`, `max_connections`, `max_user_connections` ) VALUES ( 'localhost', 'debian-sys-maint', password('A recuperer dans le fichier /etc/mysql/debian.cnf'), 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', '', '', '', '', 0, 0, 0, 0 ); FLUSH PRIVILEGES;

####  Plus de fun

Si le compte est toujours là mais que le mot de passe a été changé, la méthode ci-avant ne fonctionnera pas. Dans ce cas précis, il faut utiliser la commande suivante.

use mysql; update user set password=password('A recuperer dans le fichier /etc/mysql/debian.cnf') where User='debian-sys-maint' ;

####  La source

L’astuce vient du site : [www.electrictoolbox.com](http://www.electrictoolbox.com/restore-debian-sys-maint-mysql-user/ "www.electrictoolbox.com")

 


## Réinitialiser le mot de passe root

Si comme moi vous n’avez pas de mémoire ou tout simplement que vous n’avez jamais su le mot de passe root d’une instance MySQL, il est possible de le changer. <span style="text-decoration: underline;">Attention toute fois</span>, ceci nécessite un arrêt de l’instance MySQL <span style="text-decoration: underline;">et</span> les programmes se connectant à cette instance MySQL avec le compte root n’y auront plus accès !

#### La marche à suivre

Comme je vous le disais, la première chose à faire est d’arrêter MySQL.

# service mysql stop * Stopping MariaDB database server mysqld [ OK ]

On redémarre sans la gestion des privilèges et on se connecte à l’instance en root, <span style="text-decoration: underline;">aucun mot de passe n’est demandé dans ce mode</span>.

Notez bien le PID lors du démarrage.

# mysqld --skip-grant-tables & [1] 27126 # mysql -u root mysql Reading table information for completion of table and column names You can turn off this feature to get a quicker startup with -A Welcome to the MariaDB monitor. Commands end with ; or \g. Your MariaDB connection id is 2 Server version: 10.0.17-MariaDB-1~utopic mariadb.org binary distribution Copyright (c) 2000, 2015, Oracle, MariaDB Corporation Ab and others. Type 'help;' or '\h' for help. Type '\c' to clear the current input statement. MariaDB [mysql]>

On peut alors mettre à jour le mot de passe de l’utilisateur ‘root’.

MariaDB [mysql]> UPDATE user SET Password=PASSWORD('NOUVEAU MOT DE PASSE') WHERE User='root'; Query OK, 4 rows affected (0.00 sec) Rows matched: 4 Changed: 4 Warnings: 0 MariaDB [mysql]> FLUSH PRIVILEGES; Query OK, 0 rows affected (0.03 sec) MariaDB [mysql]> exit; Bye

On éteint le serveur MySQL en lançant un ‘kill’ sur le PID qu’on a noté juste avant.

# kill 27126

On attend quelques secondes, on appuie plusieurs fois sur la touche Entrée jusqu’à voir ceci :

# # [1]+ Done mysqld --skip-grant-tables # #

On peut maintenant redémarrer MySQL normalement.

# service mysql start * Starting MariaDB database server mysqld [ OK ] * Checking for corrupt, not cleanly closed and upgrade needing tables.

Et se connecter avec le nouveau mot de passe root.

# mysql -u root -p Enter password: Welcome to the MariaDB monitor. Commands end with ; or \g. Your MariaDB connection id is 2 Server version: 10.0.17-MariaDB-1~utopic mariadb.org binary distribution Copyright (c) 2000, 2015, Oracle, MariaDB Corporation Ab and others. Type 'help;' or '\h' for help. Type '\c' to clear the current input statement. MariaDB []>

####  La source

L’astuce vient du site : [ubuntu.flowconsult.at](http://ubuntu.flowconsult.at/en/mysql-set-change-reset-root-password/)


