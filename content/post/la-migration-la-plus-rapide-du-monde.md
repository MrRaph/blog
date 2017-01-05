+++
categories = ["MariaDB","migration","MySQL"]
image = "https://techan.fr/images/2015/02/mysql_to_mariadb.png"
draft = false
date = 2015-02-05T10:30:00Z
author = "MrRaph_"
tags = ["MariaDB","migration","MySQL"]
description = ""
slug = "la-migration-la-plus-rapide-du-monde"
title = "La migration la plus rapide du monde"

+++


Je vais vous présenter la migration la plus rapide du monde, elle est également à mon sens la plus simple du monde ! Il s’agit du passage de MySQL à MariaDB. MariaDB est un fork de MySQL créé par des anciens de MySQL qui n’ont pas apprécié le passage de MySQL dans le giron d’Oracle. Les deux SGBD sont très proches car l’équipe de MariaDB utilise le code de MySQL, qu’ils améliorent et étoffent pour faire évoluer MariaDB. MariaDB est réputée plus performante que MySQL car pas mal de bugs ont été corrigés.

C’est surtout sur un coup de tête que j’ai entrepris cette migration, mais il est vrai qu’on remarque très vite que MariaDB est un peu plus réactif que MySQL !


## La SUPER migration

J’ai fait, par acquis de conscience, un backup de mes bases MySQL avant la migration car on ne sait jamais … De plus, j’ai éteint MySQL et copié les fichiers de données pour être sûr …

Voici les commandes qui permettent la migration.

root@xxxxxx:~# service mysql stop mysql stop/waiting root@xxxxxx:~# aptitude install mariadb-server

Et voilà, MariaDB démarre et la migration est faite !


