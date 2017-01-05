+++
description = ""
draft = false
title = "[RecoverPoint] Placer des flags nommés sur les points de consistance"
date = 2014-10-14T14:47:16Z
image = "https://techan.fr/images/2014/11/Linux.png"
author = "MrRaph_"
categories = ["EMC","Flags","RecoverPoint"]
tags = ["EMC","Flags","RecoverPoint"]
slug = "recoverpoint-placer-des-flags-nommes-sur-les-points-de-consistance"

+++


Les boitiers RecoverPoint d’EMC servent a synchroniser des données entre des baies EMC. Cette technologie est particulièrement utile dans le cas d’an Plan de Continuité d’Activité (PCA) ou dans un Plan de Reprise d’Activité (PRA).  
  
 Cela permet de transmettre tout ou partie des données sur un site de secours afin de continuer ou reprendre l’activité le plus vite possible.

 

Ces boitiers ont pas mal d’intelligence, dont je ne vais pas faire la publicité ici, mais il permettent entre autre, de « tagger » des points de le temps.

Vous me direz, vu comme ça, que ce n’est pas forcément très utile … Mais si vous avez des bases de données répliquées entre des sites, vous avez surement tout de suite vu l’intérêt.

En effet, certains programmes, comme les bases de données, gagnent a être rallumées sur un point de consistance. Cela évite pas mal d’opérations de restauration et d’administration.

 

RecoverPoint permet de nommer des points dans le temps, ajoutez à cela un script qui passe toutes vos bases Oracle en « begin backup » et vous aurez un point dans le temps pendant lequel vous êtes sûr que toutes vos bases Oracle sont consistantes.

 

Pour ajouter ce fameux flag depuis un script, il est plus pratique d(‘avoir auparavant ajouté [une clef SSH vers les boitiers RecoverPoint](https://techan.fr/ajouter-des-clefs-ssh-pour-se-connecter-sur-un-boitier-recoverpoint/).

Voici donc la fameux commande :

ssh admin@XXXXXXX bookmark_image "group='Nom_Du_Consistency_Group' bookmark='Nom_du_Flag $(date +"%d_%m_%Y__%HH%M")'"

 

 


