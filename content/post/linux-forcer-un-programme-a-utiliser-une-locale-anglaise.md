+++
date = 2014-10-14T17:41:23Z
author = "MrRaph_"
description = ""
slug = "linux-forcer-un-programme-a-utiliser-une-locale-anglaise"
title = "[Linux] Forcer un programme a utiliser une locale anglaise"
categories = ["Anglais","Linux","Locale"]
tags = ["Anglais","Linux","Locale"]
image = "https://techan.fr/wp-content/uploads/2014/11/Linux.png"
draft = false

+++


Certains programmes supportent assez mal d’être lancés sur un système utilisant une langue autre que l’anglais.

Cela peut, au mieux, apporter des bugs à l’outil voir l’empêche de fonctionner purement et simplement …

 

Voici la méthode a utiliser pour forcer ce programme a utiliser une locale anglaise.  
  
 Pour un programme que l’on lancerait via la ligne de commande suivante :

/path/to/mon/programme -argument1 valeur1 -argumenté valeur2

Il suffit d’ajouter « LANG=C » au tout début de la ligne de commande et le programme utilisera l’anglais.

LANG=C /path/to/mon/programme -argument1 valeur1 -argumenté valeur2

 


