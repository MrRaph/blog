+++
author = "MrRaph_"
tags = ["imp","Import","Oracle"]
description = ""
draft = false
categories = ["imp","Import","Oracle"]
image = "https://techan.fr/images/2014/10/SQL_term.png"
slug = "imp-importer-juste-une-table-dans-un-schema"
title = "[imp] Importer juste une table dans un schéma."
date = 2014-09-26T11:30:03Z

+++


Le binaire « imp » fait partie de l’ancien mécanisme d’export/import d’Oracle, cette technologie a été supplantée par DataPump qui est bien plus performant et flexible.  
  
  

Cependant, ces anciens outils sont encore utilisés soit pour les bases en version inférieures à la 10g, soit par faute de migration des scripts.

Nous allons voir comment importer une seule table depuis un fichier exporté avec « exp » dans un schéma.

 

La table présente dans la base contient des erreurs, nous allons la supprimer.

SQL> drop table LE_SCHEMA.LA_TABLE ; Table supprimee.

 

Une fois la table supprimée, il faut se rendre dans le dossier contenant le fichier d’export puis lancer la commande suivante.

[oracle@xxxxx export](BASE)$ imp file=SCHEMA.dmp fromuser=LE_SCHEMA touser=LE_SCHEMA TABLES=\(LA_TABLE\) buffer=1000000000 Import: Release 11.2.0.1.0 - Production on Fri Sep 26 10:42:11 2014 Copyright (c) 1982, 2009, Oracle and/or its affiliates. All rights reserved. Username: system Password: Connected to: Oracle Database 11g Release 11.2.0.1.0 - 64bit Production Export file created by EXPORT:V11.02.00 via conventional path Warning: the objects were exported by SYS, not by you import done in US7ASCII character set and UTF8 NCHAR character set import server uses AL32UTF8 character set (possible charset conversion) export client uses AL32UTF8 character set (possible charset conversion) . importing LE_SCHEMA's objects into LE_SCHEMA . . importing table "LA_TABLE" 11035 rows imported Import terminated successfully without warnings.

 

Vérifions que la table soit bien à la bonne place :

SQL> select table_name, owner from dba_tables where table_name='LA_TABLE' ; TABLE_NAME OWNER ------------------------------ ------------------------------ LA_TABLE LE_SCHEMA

 

Et voilà, le tour est joué !


