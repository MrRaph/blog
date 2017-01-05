+++
description = ""
slug = "deplacer-un-disque-specifique-avec-storage-vmotion"
draft = false
title = "Déplacer un disque spécifique avec Storage vMotion"
author = "MrRaph_"
categories = ["déplacer un disque spécifique avec storage vmotion","Storage vMotion","Trucs et Astuces","VMware","vSphere"]
tags = ["déplacer un disque spécifique avec storage vmotion","Storage vMotion","Trucs et Astuces","VMware","vSphere"]
image = "https://techan.fr/images/2015/01/vmware_vsphere_client_high_def_icon_by_flakshack-d4o96dy.png"
date = 2015-01-12T11:49:50Z

+++


Dans certains cas, il est nécessaire de déplacer une VM d’un DataSotre vers un autre, cela fonctionne très bien et facilement avec Storage vMotion. Cependant, il est parfois nécessaire de déplacer un disque spécifique avec Storage vMotion, sur une VM volumineuse par exemple.

Ceci est possible par la même interface que le Sorage vMotion classique, il y a juste une petite astuce a connaitre.

Comme pour faire un Storage vMotion, cliquer droit sur la VM et choisir « Migrate ».

[![Déplacer un disque spécifique avec Storage vMotion](https://techan.fr/images/2015/01/right_click.png)](https://techan.fr/images/2015/01/right_click.png)

Choisir, « Change datastore ».  
  
[![Déplacer un disque spécifique avec Storage vMotion](https://techan.fr/images/2015/01/vmotion_1.png)](https://techan.fr/images/2015/01/vmotion_1.png)

C’est dans cet ecran que l’astuce réside, au lieu de sélectionner un datastore comme d’habitude, cliquer sur « Advanced ».

[![Déplacer un disque spécifique avec Storage vMotion](https://techan.fr/images/2015/01/vmotion_2.png)](https://techan.fr/images/2015/01/vmotion_2.png)

Un nouvel écran apparait alors listant les différents fichiers composant la VM (configuration et disques de données). Vous pouvez ici choisir une destination personnalisée pour chacun de ces fichiers.

[![Déplacer un disque spécifique avec Storage vMotion](https://techan.fr/images/2015/01/vmotion_3.png)](https://techan.fr/images/2015/01/vmotion_3.png)

Une fois vos modifications faites, validez le formulaire. Un récapitulatif détaillé s’affiche, cliquez sur « Finish » et la migration commence.

[![Déplacer un disque spécifique avec Storage vMotion](https://techan.fr/images/2015/01/vmotion_5.png)](https://techan.fr/images/2015/01/vmotion_5.png)


