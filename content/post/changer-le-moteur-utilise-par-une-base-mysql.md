+++
author = "MrRaph_"
draft = false
title = "Changer le moteur utilisé par une base MySQL"
date = 2015-02-02T11:20:21Z
tags = ["changer le moteur utilisé par une base mysql","Changer moteur","MyISAM","MySQL","Trucs et Astuces"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
description = ""
slug = "changer-le-moteur-utilise-par-une-base-mysql"
categories = ["changer le moteur utilisé par une base mysql","Changer moteur","MyISAM","MySQL","Trucs et Astuces"]

+++


Il est parfois nécessaire de changer le moteur qu’utilise MySQL pour gérer une ou plusieurs tables. Les deux moteurs principaux sont MyISAM et InnoDB. Chacun a ses avantages et ses inconvénients et parfois, on a pas trop le choix, certaines applications utilisent une fonctionnalité d’un de ces moteurs et est donc figée sur celui-ci.  Il reste cependant possible d’en changer en cours de route, c’est ce que nous allons voir ici.

Je pars du principe que l’on veut changer le moteur de toutes les tables de la base, pour ne le changer que sur une table, c’est très simple, il suffit de jouer la requête SQL à la fin de cet article juste une fois sur la table visée.


## La table INFORMATION_SCHEMA.tables

[![Changer le moteur utilisé par une base MySQL](https://techan.fr/wp-content/uploads/2015/01/describe_information_schema_tables.png)](https://techan.fr/wp-content/uploads/2015/01/describe_information_schema_tables.png)

Cette table stocke les informations liées à toutes les tables existantes dans l’instance MySQL. On y trouve notamment, les champs « table_name » et « table_schema ».

- Table_name, est bizarrement le nom de la table
- Table_schema est le nom de la base dans laquelle la table a été créée.


## Générer le code SQL pour changer le moteur utilisé par une base MySQL

 La requête suivante est ce que l’on appelle du méta-SQL, un bien grand mot pour désigner une requête qui en génère d’autre. Une fois exécutée elle retourne une requête customisée par ligne de résultat qu’elle aurait normalement retournée.

mysql> select concat('ALTER TABLE ', table_name, ' ENGINE = MyISAM;') from (select table_name from INFORMATION_SCHEMA.tables where TABLE_schema='xxxx') a ; +---------------------------------------------------------+ | concat('ALTER TABLE ', table_name, ' ENGINE = MyISAM;') | +---------------------------------------------------------+ | ALTER TABLE wp_commentmeta ENGINE = MyISAM; | | ALTER TABLE wp_comments ENGINE = MyISAM; | | ALTER TABLE wp_wfVulnScanners ENGINE = MyISAM; | +---------------------------------------------------------+ 36 rows in set (0.00 sec)

 Il suffit en suite d’exécuter les requêtes qu’elle génère et les tables passent en MyISAM.

mysql> ALTER TABLE wp_commentmeta ENGINE = MyISAM; Query OK, 0 rows affected (0.03 sec) Records: 0 Duplicates: 0 Warnings: 0

[![Changer le moteur utilisé par une base MySQL](https://techan.fr/wp-content/uploads/2015/01/table_transformee_myisam.png)](https://techan.fr/wp-content/uploads/2015/01/table_transformee_myisam.png)


