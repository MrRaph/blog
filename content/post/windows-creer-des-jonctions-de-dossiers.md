+++
tags = ["Jonction dossiers","Trucs et Astuces","Windows"]
description = ""
slug = "windows-creer-des-jonctions-de-dossiers"
draft = false
title = "[Windows] Créer des jonctions de dossiers"
date = 2014-10-28T16:09:53Z
author = "MrRaph_"
categories = ["Jonction dossiers","Trucs et Astuces","Windows"]

+++


Le but  de cet article est d’exposer comment créer des liens symboliques sur Windows, ils s’appellent « Jonction » sur ce système.  

 Ceci dans le but de déplacer un dossier sur une autre partition ou un autre disque, cela peut être utile lorsque le programme que vous utilisez ne vous propose pas l’emplacement du dossier a déplacer (Steam, iCloud Drive, …).

 

Dans cet exemple, je crée une « jonction » entre le dossier « P:\iCloud\Drive » et le dossier « D:\Users\xxx\iCloudDrive ».

    D:\Users\xxx>mklink /J "D:\Users\xxx\iCloudDrive" "P:\iCloud\Drive" Jonction créée pour D:\Users\xxx\iCloudDrive <<===>> P:\iCloud\Drive

- **/J **: créer une jonction
- **Dossier cible**
- **Dossier source**

 

On vérifie après coup :

    D:\Users\xxx>dir
    Le volume dans le lecteur D s'appelle DATA
    Le numéro de série du volume est XXXX-XXXX
    Répertoire de D:\Users\xxx
    28/10/2014 12:34 <REP> .
    28/10/2014 12:34 <REP> ..
    28/10/2014 11:32 <REP> Desktop
    28/10/2014 12:09 <REP> Documents
    30/04/2014 14:59 <REP> Documentum
    24/10/2014 13:05 <REP> Downloads
    28/10/2014 12:14 <REP> Favorites
    28/10/2014 12:34 <JONCTION> iCloudDrive [P:\iCloud\Drive]

On voit donc bien que le dossier « D:\Users\xxx\iCloudDrive » est en fait un lien vers le dossier « P:\iCloud\Drive ».
