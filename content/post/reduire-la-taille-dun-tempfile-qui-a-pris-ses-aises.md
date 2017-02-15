+++
tags = ["Oracle","réduire la taille d un tempfile qui a pris ses aises","tempfile","Trucs et Astuces"]
draft = false
author = "MrRaph_"
title = "Réduire la taille d'un tempfile qui a pris ses aises"
date = 2015-02-04T10:30:31Z
categories = ["Oracle","réduire la taille d un tempfile qui a pris ses aises","tempfile","Trucs et Astuces"]
image = "https://techan.fr/images/2014/10/SQL_term.png"
description = ""
slug = "reduire-la-taille-dun-tempfile-qui-a-pris-ses-aises"

+++


Parfois les tempfiles prennent un peu leurs aises sur leur file system, notamment s’ils sont configurés en auto extend avec une limite haute, je crois que par défaut la taille max est de 32 Go. Quand ils abusent vraiment, ils peuvent bloquer le file system à 100% et comme évidement, il est sur le même que vos data files, vous êtes coincés …

Voici donc la marche à suivre pour réduire la taille de ce fichier indélicat sans en créer de nouveau et sans manipulation compliquée. Il faut par contre avoir une base en version 10g minimum …


## Le constat

[![Réduire la taille d'un tempfile qui a pris ses aises](https://techan.fr/images/2015/01/temp_file_plein_avant_reduction.png)](https://techan.fr/images/2015/01/temp_file_plein_avant_reduction.png)

Le voilà ce méchant temp01.dbf qui prend toute la couette avec ses 31,3 Go … On va lui régler son compte !


## Réduire la taille d’un tempfile qui a pris ses aises

Voilà comment procéder pour réduire la taille d’un tempfile qui a explosé :

    [oracle@xxxxxx trace](DWH)$ sqlplus
    SQL*Plus: Release 11.2.0.1.0 Production on Wed Jan 28 15:42:11 2015 Copyright (c) 1982, 2009, Oracle. All rights reserved.
    Enter user-name: /as sysdba
    Connecte a : Oracle Database 11g Release 11.2.0.1.0 - 64bit Production
    SQL> alter tablespace TEMP shrink space keep 1G; Tablespace modifie.
    SQL> alter database tempfile '/u02/oradata/DWH/temp01.dbf' resize 1G;
    Base de donnees modifiee.

J’ai ensuite bloqué sa taille max à 10G au lieu de 32G avant.

    SQL> alter database tempfile '/u02/oradata/DWH/temp01.dbf' autoextend on maxsize 10G ;
    Base de donnees modifiee.

Et voilà, le file system respire :-)

    [oracle@xxxxxx trace](DWH)$ df -h /u02
    Sys. de fichiers Taille Uti. Disp. Uti% Monté sur
    /dev/mapper/VolGroup--u02-vol--u02 102G 70G 30G 71% /u02

[![Réduire la taille d'un tempfile qui a pris ses aises](https://techan.fr/images/2015/01/temp_file_plein_aprest_reduction.png)](https://techan.fr/images/2015/01/temp_file_plein_aprest_reduction.png)
