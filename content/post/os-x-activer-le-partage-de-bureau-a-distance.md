+++
title = "[OS X] Activer le partage de bureau à distance"
date = 2014-11-18T11:51:17Z
author = "MrRaph_"
categories = ["Activer partage d'écran","Apple","CLI","OS X","Trucs et Astuces"]
tags = ["Activer partage d'écran","Apple","CLI","OS X","Trucs et Astuces"]
description = ""
slug = "os-x-activer-le-partage-de-bureau-a-distance"
draft = false

+++


Toujours le même souci lorsque l’on a pas de tête et qu’on oublie d’activer l’accès distant sur sa machine, il faut fouiller sur l’Internet Multimédia pour essayer de faire ça à distance et par SSH …

Nous avons déjà vu que c’est possible avec Ubuntu (voir: [[Ubuntu] Activer le partage d’écran depuis la ligne de commande](https://techan.fr/ubuntu-activer-le-partage-decran-depuis-la-ligne-de-commande/)), et bien c’est également possible avec OS X !

 

J’ai testé avec la version 10.10 « Yosemite », cela fonctionne !! L’auteur [du post que j’ai trouvé](http://hints.macworld.com/comment.php?mode=view&cid=111315) le faisait lui sur Lion, cela doti donc fonctionner pour toutes les versions récentes de l’OS d’Apple.

 

Voici donc l’astuce, ouvrez le Terminal.app et tapez le commandes suivantes :

cd /System/Library/LaunchDaemons/ sudo launchctl load -w com.apple.screensharing.plist

Et pour arrêter le partage d’écran :

cd /System/Library/LaunchDaemons/ sudo launchctl unload -w com.apple.screensharing.plist

 


