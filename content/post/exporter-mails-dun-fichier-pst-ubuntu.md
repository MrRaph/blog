+++
author = "MrRaph_"
categories = ["Export PST","mail","ThunderBird","Trucs et Astuces","Ubuntu"]
slug = "exporter-mails-dun-fichier-pst-ubuntu"
draft = false
tags = ["Export PST","mail","ThunderBird","Trucs et Astuces","Ubuntu"]
image = "https://techan.fr/wp-content/uploads/2015/04/Ubuntu_Logo.gif"
description = ""
title = "Exporter les mails d'un fichier PST sur Ubuntu"
date = 2015-11-19T09:55:28Z

+++


La migration des mails d’Outlook vers Thunderbird est un des problèmes que l’on rencontre lorsque l’on souhaite passer sur Linux. En effet pour ne pas avoir a re-télécharger tous les mails stockés sur le serveur, ou tout simplement car les mails stockés en local n’existent plus sur le-dit serveur, on est tenté de vouloir importer ses mails stockés dans Outlook. Sur Windows, cette migration d’Outlook vers Thunderbird semble très simplifiée car ce dernier propose l’importation lors de son installation et qu’il embarque les outils nécessaires. Sur Linux, s’est une autre paire de manches, ce n’est pas possible sans utiliser un programme spécial.

 

C’est après quelques recherches plutôt acharnées que j’ai trouvé ce programme magique ! Je vais vous décrire comment vous y prendre pour extraire vos mails des fichiers PST d’Outlook et les importer dans Thunderbrid.


## Exporter les mails stockés dans un fichier PST

Commençons par le commencement, il faut installer le programme magique ! ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

sudo aptitude install readpst

 

Ensuite, on créer un dossier ou seront stockés les mails exportés et on lance la moulinette.

mkdir 2014 readpst -D -M -b -e -o 2014 /media/raphael/Aldata/Outlook/2014.pst

 

Voici la sortie écran que génère cette opération.

[![Exporter les mails d'un fichier PST sur Ubuntu](https://techan.fr/wp-content/uploads/2015/11/avancement-export.png)](https://techan.fr/wp-content/uploads/2015/11/avancement-export.png)

 


## Importer les mails exportés dans Thunderbird

 

Tout d’abord, il vous faudra installer le plugin Kivabien – [ImportExportTools](https://addons.mozilla.org/fr/thunderbird/addon/importexporttools/) – dans Thunderbird.

Une fois ce prérequis installé, rien n’est plus simple, faites un clic droit sur le dossier dans lequel vous souhaitez que les mails soient importés et suivez les options suivantes.

 

1. Importer / Exporter au format « .mbox »/ ».eml »
2. Importer tous les fichiers « .eml » depuis un dossier
3. aussi depuis les sous-dossiers

 

[![importer_les_messages](https://techan.fr/wp-content/uploads/2015/11/importer_les_messages.png)](https://techan.fr/wp-content/uploads/2015/11/importer_les_messages.png)

L’opération prend …. longtemps … mais tout fonctionne au poil !

 


## Sources

- [askubuntu.com (Anglais)](http://askubuntu.com/questions/264368/how-to-integrate-outlook-2003-pst-file-to-thunderbird)
- [Addon ImportExportTools](https://addons.mozilla.org/fr/thunderbird/addon/importexporttools/)


