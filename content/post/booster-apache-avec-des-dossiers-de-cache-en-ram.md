+++
categories = ["Boost","Cache","Linux","RAM","web"]
tags = ["Boost","Cache","Linux","RAM","web"]
draft = false
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
slug = "booster-apache-avec-des-dossiers-de-cache-en-ram"
title = "Booster Apache avec des dossiers de cache en RAM"
date = 2014-09-23T15:29:06Z
author = "MrRaph_"

+++


Une des astuces pour bosster apache est de stocker des fichiers très accédés directement en RAM, pour cela on va utiliser le « tmpfs ».  
  
 C’est une astuce qui permet de monter des morceaux de la RAM de l’ordinateur comme une partition classique.

Ceci évite de trop solliciter le disque dur qui évite ainsi beaucoup d’accès sur des fichiers « chaud ».

 

Voici deux exemples d’utilisation.

 

### Booster un site WordPress en mettant les fichiers de cache en RAM

Un site WordPress est installé dans le dossier : /data/web/wordpress, cette installation utilise de la mise en cache du contenu. Les fichiers créés pour cette mise en cache sont stockés dans le dossier : /data/web/wordpress/wp-content/cache.

 

Nous allons monter 10 Mo de RAM dans le dossier /data/web/wordpress/wp-content/cache afin d’écrire les fichiers en cache en RAM.

mount -t tmpfs -o size=10M,mode=0744 tmpfs /data/web/wordpress/wp-content/cache

 

Afin de rendre cette manipulation permanente, voici la ligne a ajouter à la fstab :

tmpfs /data/web/wordpress/wp-content/cache tmpfs size=10M,mode=0777 0 0

 

 

### Booster Apache en mettant les sessions PHP en RAM

Nous allons créer le dossier /cache/apache2/sessions et monter 50 Mo de RAM dessus.

 

mkdir -p /cache/apache2/sessions mount -t tmpfs -o size=50M,mode=0744 tmpfs /cache/apache2/sessions chown -R www-data: /cache/apache2/sessions/

 

Les sessions PHP sont par défaut, stockées dans le repertoire /tmp de votre Linux, vous pouvez modifier ce chemin en mettant une valeur à la variable « session.save_path » dans votre fichier php.ini

session.save_path = "/cache/apache2/sessions"

 *N’oubliez pas de redémarrer Apache pour prendre en compte cette modification.*

 

Afin de rendre cette manipulation permanente, voici la ligne a ajouter à la fstab :

tmpfs /cache/apache2/sessions tmpfs size=50M,mode=0777 0 0

 

### Augmenter à chaud la taille d’un TMPFS

root@kelthuzad:~# df -h /cache/apache2/sessions/ Sys. de fichiers Taille Utilisé Dispo Uti% Monté sur tmpfs 50M 0 50M 0% /cache/apache2/sessions root@kelthuzad:~# mount -o remount,size=100M /cache/apache2/sessions root@kelthuzad:~# df -h /cache/apache2/sessions/ Sys. de fichiers Taille Utilisé Dispo Uti% Monté sur tmpfs 100M 0 100M 0% /cache/apache2/sessions

N’oubliez pas de modifier la taille dans votre fstab ! ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

 

### Autres cas d’utilisation

Les cas d’utilisation des TMPFS sont presques infinis tant que vous avez de la RAM à foison.

Un autre exemple, j’ai un ami qui a utilisé du TMPFS, sur mon conseil,  pour booster un serveur Team Fortresss 2, il en est plus que ravi ! 