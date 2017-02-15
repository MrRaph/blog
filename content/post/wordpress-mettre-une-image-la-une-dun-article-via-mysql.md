+++
image = "https://techan.fr/images/2014/10/SQL_term.png"
description = ""
draft = false
title = "[Wordpress] Mettre une image à la une d'un article via MySQL"
date = 2014-11-21T15:01:06Z
author = "MrRaph_"
categories = ["Image à la une","mettre une image à la une d un article via mysql","MySQL","WordPress"]
tags = ["Image à la une","mettre une image à la une d un article via mysql","MySQL","WordPress"]
slug = "wordpress-mettre-une-image-la-une-dun-article-via-mysql"

+++


Les images à la une (Featured Image) sur les articles WordPress, ça fait tout de suite classe et un certains effet visuel, avec une bonne image à la une, on arrive a en savoir plus sur le contenu de l’article alors que l’on a encore lu que le son titre.

Je me suis attelé à la tâche d’en ajouter les plus possible sur les articles que j’avais déjà produits, mais comme je suis u peu flemmard, j’ai cherché comment mettre une image à la une d’un article via MySQL afin de pas avoir a ouvrir toutes les pages de modification …  

  

J’ai trouvé un post sur le site  [wpmudev.org](http://premium.wpmudev.org/forums/topic/query-for-missing-featured-images). Ce brave Paul nous donne une requête qui liste tous les articles et les metas associées à l’image à la une.

    mysql> SELECT p.ID, p.post_title, pm.* FROM wp_posts p -> LEFT JOIN wp_postmeta pm ON p.ID=pm.post_id AND pm.meta_key='_thumbnail_id' -> WHERE p.post_type in ('post') -> AND p.post_status in ('publish');
     +-----+--------------------------------------------------------------------------------------+---------+---------+---------------+------------+
     | ID |  post_title | meta_id | post_id | meta_key | meta_value |
     +-----+--------------------------------------------------------------------------------------+---------+---------+---------------+------------+
     | 8 | Flush du cache DNS | NULL | NULL | NULL | NULL | | 25 | Fichier Hosts sur Windows | NULL | NULL | NULL | NULL |
     | 27 | Ajouter des clefs SSH pour se connecter sur un boîtier RecoverPoint | 1318 | 27 | _thumbnail_id | 457 |
     | 29 | Désactiver les alertes par mail dans la crontab | 1319 | 29 | _thumbnail_id | 457 |
     | 31 | Création d'une VM Linux pour forwarder des paquets d'une IP à une autre | 1320 | 31 | _thumbnail_id | 457 |
     +-----+--------------------------------------------------------------------------------------+---------+---------+---------------+------------+
     66 rows in set (0.01 sec)

 

J’en ai donc extra-paulé (pardon, elle était trop facile celle la … :D) une requête pour **ajouter** une image à la une sur des articles qui n’en n’ont pas.

    insert into wp_postmeta(meta_key,meta_value,post_id) values ('_thumbnail_id', '457', '27');

Cette requête ajoute l’image [![Linux](https://techan.fr/images/2014/11/Linux.png)](https://techan.fr/images/2014/11/Linux.png) comme image à la une de l’article [Ajouter des clefs SSH pour se connecter sur un boîtier RecoverPoint](https://techan.fr/ajouter-des-clefs-ssh-pour-se-connecter-sur-un-boitier-recoverpoint/ "Ajouter des clefs SSH pour se connecter sur un boîtier RecoverPoint").

On passe la requête, on rafraichit la page, et l’image apparait comme par magie (ou presque !).

 
