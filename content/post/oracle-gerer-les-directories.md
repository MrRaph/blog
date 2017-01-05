+++
author = "MrRaph_"
tags = ["Oracle","Survival Guide","Trucs et Astuces"]
image = "https://techan.fr/images/2014/10/SQL_term.png"
categories = ["Oracle","Survival Guide","Trucs et Astuces"]
description = ""
slug = "oracle-gerer-les-directories"
draft = false
title = "[Oracle] Gérer les directories"
date = 2014-10-16T09:57:50Z

+++


Dans cet article nous allons voir comment lister les directories présents dans une base Oracle et comment les administrer.  
  
  

Les directories sont des alias vers un dossier système dans une bases Oracle, ils permettent à Oracle de connaitre quelques uns des dossiers présents sur l’OS. Ils sont utilisées notamment pour les export/import avec DataPump.

Un directory appartient à l’utilisateur qui le crée, le privilège « CREATE ANY DIRECTORY » est nécessaire pour créer des directories dans une base Oracle.

 

### Lister les directories présents dans une base Oracle

La commande SQL ci-dessous liste tous les directories créés dans la base de données à laquelle on est connecté.

select * from dba_directories ;

 

[![image2014-4-4 10-10-35](https://techan.fr/images/2014/10/image2014-4-4-10-10-35.png)](https://techan.fr/images/2014/10/image2014-4-4-10-10-35.png)

Dans cet exemple, on voit que le directory qui s’appelle « DATA_PUMP_DIR » pointe vers le dossier UNIX/Linux « /data/oracle/admin/TFTI1/dpdump ».

A l’intérieur de la base de » données, toutes opérations réalisées en utilisant le dossier système « /data/oracle/admin/TFTI1/dpdump » doivent être faites en utilisant le directory « DATA_PUMP_DIR ».

 

### Administrer les directories

##### Donner le droit de créer des directories à un utilisateur

grant create any directory to <username> ;

 

[![image2014-4-4 10-33-58](https://techan.fr/images/2014/10/image2014-4-4-10-33-58.png)](https://techan.fr/images/2014/10/image2014-4-4-10-33-58.png)

L’utilisateur « scott » peut maintenant crée des directories.

 

##### Créer un directory

La création d’un directory est faite par la commande SQL suivante :

create directory <DIRECTORY_NAME> as '/path/to/system/directory' ;

[![image2014-4-4 10-34-47](https://techan.fr/images/2014/10/image2014-4-4-10-34-47.png)](https://techan.fr/images/2014/10/image2014-4-4-10-34-47.png)

L’utilisateur « scott » dispose maintenant d’un directory « DATAPUMP » qui pointe vers le dossier système « /data/oracle/admin/TFTI1/dpdump ».

 


