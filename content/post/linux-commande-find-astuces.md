+++
tags = ["Find","Linux","Trucs et Astuces"]
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
date = 2014-10-15T10:57:51Z
author = "MrRaph_"
categories = ["Find","Linux","Trucs et Astuces"]
slug = "linux-commande-find-astuces"
draft = false
title = "[Edité][Linux] Commande Find : astuces"

+++


La commande find est très puissante et permet de rechercher des fichiers avec des critères de recherche extrêmement nombreux. Elle permet également d’exécuter d’autres commandes sur les fichiers trouvés.  
  
  

Je vous propose de décrire quelques cas d’utilisation, je tâcherai de mettre à jour cet article au fur et à mesure.

 

### Utilisation basique

##### Trouver un fichier à partir de son nom

find /dossier/ou/chercher -name "nom du fichier"

Cette recherche est récursive, find va chercher également dans les sous dossiers.

On peut mettre des « * » dans le nom du fichier afin de faire des recherches génériques par example : « *.log » pour trouver tous les fichiers se terminant par « .log ».

 

##### Trouver un fichier dont le propriétaire n’est pas un certain utilisateur

Pour des questions de sécurité, ou tout simplement de droit d’accès, on peut être amené a chercher les fichier qui n’appartiennent pas à un utilisateur donnée. Dans notre cas, nous cherchons les fichier qui n’appartiennent pas à l’utilisateur « jboss » car nous avons un souci avec une application qui ne peut plus accéder à ces fichiers.

find . \! -user jboss -print

Le « ! » permet la négation de la condition et il nous faut l’échapper sinon le Bash prend le « ! » pour lui.

 

##### Exclure des dossiers d’une recherche

Dans cette recherche, nous allons lister les fichiers d’un dossier en excluant ceux situés dans les sous dossiers « .etc » et « lost+found ».

find .t -type d \( -path .etc -o path lost+found \) \! -prune -o -print

 

### Utilisation avancée

##### Trouver un fichier avec son nom et le renommer

find /dossier/ou/chercher -name "nom du fichier" -exec mv {} /nouveau/chemin/nouveau_nom_du_fichier \;

Dans ce cas, on fait une recherche classique du fichier par son nom et on utilise l’option « exec » qui appelle la commande « mv ».

On remarquera la présence des accolades vides « {} », ceci représente l’élément trouvé par find. L’option exec appelle une commande, cet appel doit se terminer par « \; » !

 

##### Supprimer des fichiers en fonction de leur date de dernière modification

find /dossier/ou/chercher -name "nom du fichier" -mtime +14 -exec rm {} \;

On cherche un fichier basiquement avec son nom, mais on ne garde que ceux qui portent ce nom et qui n’ont pas été modifiés depuis plus de 14 jours.

On appelle ensuite la commande « rm » via l’option « exec » pour supprimer ces anciens fichiers.


