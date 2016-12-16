+++
slug = "forcer-un-programme-a-utiliser-une-carte-reseau-sur-windows"
date = 2015-08-07T10:44:43Z
categories = ["ForceBindIP","réseau","Trucs et Astuces","Windows"]
draft = false
title = "Forcer un programme à utiliser une carte réseau sur Windows"
author = "MrRaph_"
tags = ["ForceBindIP","réseau","Trucs et Astuces","Windows"]
image = "https://techan.fr/wp-content/uploads/2015/06/windows_10_logo.png"
description = ""

+++


Une des choses un peu pénibles sur Windows, c’est qu’il est très difficile – voire impossible – de forcer un programme à utiliser une carte réseau spécifique. C’est un problème pour moi car sur mon serveur – qui est désormais sous Windows 10 – j’héberge mon Media Center Plex, Steam pour le streaming local et j’utilise également cette machine pour faire du surf sur Internet à distance. Le problème c’est que je ne souhaite pas « polluer » la connexion Ethernet de la machine, que je veux dédier à Plex, avec mon surf internet.

Mon souhait était donc de forcer Plex à utiliser la carte Ethernet et Firefox la carte Wifi de la machine. La bonne nouvelle ? J’ai trouvé un petit programme qui permet de gérer ça assez facilement !!

 


## ForceBindIP

ForceBindIP, c’est le nom de cet utilitaire. Sur le [site de l’éditeur](http://old.r1ch.net/stuff/forcebindip/), il est indiqué qu’il est compatible avec Windows NT/2000/XP/2003, pour ma part, j’ai testé sur Windows 10 cela fonctionne également ! ![:-)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

 

#### L’installation de l’outil

Alors là attention, c’est très très compliqué ! Le seul truc a savoir c’est que l’installeur n’a pas fonctionné, j’ai du utiliser [la version zippée](http://old.r1ch.net/stuff/forcebindip/download/ForceBindIP-1.2a.zip). Téléchargez donc ce zip et extrayez-en les deux fichiers qu’il contient :

- BindIP.dll
- ForceBindIP.exe

La librairie **BindIP.dll** doit être copiée dans le dossier **C:\Windows\System32**, le fichier exécutable lui, peut être placé ou vous le souhaitez. Pour ma part je l’ai mis dans **C:\Tools**.

Il ne vous reste plus qu’à modifier la variable d’environnement **path** afin de pouvoir utilise le programme de manière plus souple.

<span style="text-decoration: underline;">Note :</span> Cette étape n’est pas obligatoire, si vous ne la faites pas, il suffira d’appeler le programme avec son chemin complet au lieu du seul nom de l’exécutable.

 

#### Ajouter le dossier au « path »

 

Ouvrez un explorateur de fichier, faites un clic droit sur **Ce PC** et cliquez sur **Propriétés**.

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.709.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.709.jpg)

Sur la gauche de la fenêtre qui s’ouvre, cliquez sur **Paramètres système avancés**.

 

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.710.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.710.jpg)

Dans la nouvelle fenêtre, cliquez sur **Variables d’environnement…**.

 

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.711.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.711.jpg)

 

Scrollez jusqu’à voir la ligne de la variable **path** et sélectionnez la et cliquez sur **Modifier**. Une pop-up s’ouvre, allez jusqu’à la fin de la **Valeur de la variable** et ajoutez la chaine suivante :

;C:\Tools

Adaptez ce chemin en fonction de là ou vous avez enregistré le l’exécutable **ForceBinIP.exe**.

 

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.712.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.712.jpg)

Validez le tout, fermez votre session et rouvrez la pour que les modifications soient prisent en compte.

 


## Forcer un programme à utiliser une carte réseau sur Windows

Maintenant que ForceBindIP est installé sur votre machine, voici comment l’utiliser.

 

Tout d’abord, il va falloir identifier les différentes adresses IP attribuées à votre ordinateur. Pour cela, appuyez sur les touches **Windows** et **R** simultanément.

 

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.714.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.714.jpg)

Tapez **cmd** dans la pop-up et cliquez sur **OK**. Une invite de commandes s’ouvre, tapez la commande :

ipconfig /all

Ceci va lister les informations concernant toutes les cartes réseau de la machine avec leur IP.

 

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.715.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.715.jpg)

Notez la valeur en face du libellé **Adresse IPv4**.

Maintenant, configurons une application pour utiliser ForceBinIP. Je vais prendre l’exemple de mon Firefox. Je lance habituellement ce programme via le raccourci qui se trouve sur le Bureau, on va donc faire un clic droit dessus.

 

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.713.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.713.jpg)

Cliquez sur **Propriétés**.

 

[![Forcer un programme à utiliser une carte réseau sur Windows](https://techan.fr/wp-content/uploads/2015/08/screenshot.716.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.716.jpg)

C’est dans le champs **Cible** que tout va se jouer. Par défaut, ce champ ne contient que le chemin vers le binaire de Firefox, nous allons ajouter **ForceBindIP **juste avant.

 

<span style="text-decoration: underline;">Si vous avez configuré la variable **path** et que vous vous êtes reconnecté</span> modifiez le champ **Cible **pour qu’il ressemble à ceci :

ForceBindIP.exe <IP de la carte> "C:\Program Files (x86)\Mozilla Firefox\firefox.exe"

<span style="text-decoration: underline;">Si vous n’avez pas configuré la variable **path** ou que vous ne vous êtes pas reconnecté</span> modifiez le champ **Cible **pour qu’il ressemble à ceci :

C:\Tools\ForceBindIP.exe <IP de la carte> "C:\Program Files (x86)\Mozilla Firefox\firefox.exe"

 

Validez les changements de relancez Firefox !

Cette méthode peut être appliquée à bien d’autre programmes ! 