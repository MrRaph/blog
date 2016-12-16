+++
description = ""
slug = "windows-synchroniser-deux-repertoires-en-conservant-les-permissions-ntfs"
draft = false
title = "[Windows] Synchroniser deux répertoires en conservant les permissions NTFS"
date = 2014-10-23T15:21:36Z
author = "MrRaph_"
categories = ["RoboCopy","Trucs et Astuces","Windows"]
tags = ["RoboCopy","Trucs et Astuces","Windows"]

+++


Pour synchroniser deux dossiers sur Windows, un utilitaire est proposé par défaut depuis Windows 2003, il se lance en ligne de commande, son petit nom … ROBOCOPY !  
  
 L’avantage de cet outil est qu’il permet de copier les fichiers a une vitesse assez folle et qu’il a pas mal d’options, notamment pour conserver les permissions NTFS.

 

Voici un exemple de synchronisation.

robocopy "D:\STAT" "\\autre_serveur\E\STAT" /MIR /SEC /RH:2000-0700 /TEE /LOG+:c:\journal.log

Le dossier source : « D:\STATS », le dossier cible : un chemin UNC ou un dossier « \\autre_serveur\E\STAT »

 

Voici la description des options utilisées ici :

- **/MIR **: Applique les changement de la source sur la cible, si un fichier est créé sur la source, il est créé sur la cible, si un dossier est supprimé sur la source, il est supprimé sur la cible.
- **/RH **: Sert a plannifier, dans ce cas, de 20h à 6h du matin.
- **/SEC **: Migrer les droits NTFS
- **/LOG **: Désactive la sortie écran, et la redirige dans un fichier de log, ici C:\journal.log
- **/TEE** : Rétabli la sortie écran même si le **/LOG** est spécifié.

Et voilà !


