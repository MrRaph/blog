+++
slug = "empecher-les-mises-a-jour-dun-paquet-sur-ubuntu"
categories = ["Debian","empêcher les mises à jour d un paquet sur ubuntu","Linux","Mises à jour","Trucs et Astuces","Ubuntu"]
tags = ["Debian","empêcher les mises à jour d un paquet sur ubuntu","Linux","Mises à jour","Trucs et Astuces","Ubuntu"]
image = "https://techan.fr/wp-content/uploads/2015/04/UBUNTU.png"
description = ""
draft = false
title = "Empêcher les mises à jour d'un paquet sur Ubuntu"
date = 2015-06-19T10:25:08Z
author = "MrRaph_"

+++


Lorsque j’ai fait l’upgrade de mes Ubuntu de la version 14.10 vers la toute nouvelle 15.04, j’ai été surpris que l’utilitaire me propose de supprimer MariaDB pour remettre MySQL. Je ne voulais évidement pas de cette « solution ». J’ai donc cherché un moyen d’empêcher la mise à jour des paquets liés à MariaDB afin de réaliser leurs mises à jour après coup.

**<span style="text-decoration: underline;">Note :</span>** Cette astuce fonctionne également sur Debian ainsi que sur toutes les distributions qui en dérivent.

Pour empêcher les mises à jour d’un paquet sur Ubuntu, il faut dire à « apt » – le gestionnaire de paquets – de ne pas prendre en compte les nouvelles versions des paquets. Dans cet article, je décris également comment faire la même chose pour l’outil « aptitude » que je préfère souvent à « apt ».

 


## Trouver les paquets à conserver

Afin de placer des verrous sur les paquets à protéger, il faut déjà connaitre leur nom et la liste exacte. Dans l’exemple ci-dessous, je cherches tous les paquets liés à mon installation de MariaDB. La commande « dpkg » me permet de lister les paquets installés sur ma machine.

# dpkg -l | grep maria ii libmariadbclient18 10.0.20+maria-1~vivid amd64 MariaDB database client library ii libmysqlclient18 10.0.20+maria-1~vivid amd64 Virtual package to satisfy external depends ii mariadb-client-10.0 10.0.20+maria-1~vivid amd64 MariaDB database client binaries ic mariadb-client-5.5 5.5.41-1ubuntu0.14.10.1 amd64 MariaDB database client binaries ii mariadb-client-core-10.0 10.0.20+maria-1~vivid amd64 MariaDB database core client binaries ii mariadb-common 10.0.20+maria-1~vivid all MariaDB database common files (e.g. /etc/mysql/conf.d/mariadb.cnf) ii mariadb-server 10.0.20+maria-1~vivid all MariaDB database server (metapackage depending on the latest version) ii mariadb-server-10.0 10.0.20+maria-1~vivid amd64 MariaDB database server binaries ic mariadb-server-5.5 5.5.41-1ubuntu0.14.10.1 amd64 MariaDB database server binaries ii mariadb-server-core-10.0 10.0.20+maria-1~vivid amd64 MariaDB database core server files ii mysql-common 10.0.20+maria-1~vivid all MariaDB database common files (e.g. /etc/mysql/my.cnf)

Maintenant que l’on a la liste des paquets, on va pouvoir les verrouiller.


## La méthode pour APT

#### Holder un paquet

On utilise la commande « apt-mark » pour verrouiller le paquet en lui précisant qu’on souhaite ajouter un verrou – « hold ».

# apt-mark hold mariadb-client-10.0 mariadb-client-10.0 was already set on hold.

 

#### Dé-holder un paquet

On utilise la commande « apt-mark » pour déverrouiller le paquet en lui précisant qu’on souhaite enlever un verrou – « unhold ».

# apt-mark unhold mariadb-client-10.0 Canceled hold on mariadb-client-10.0.

 


## La méthode pour APTITUDE

#### Holder un paquet

On utilise la directement commande « aptitude » pour verrouiller le paquet en lui précisant qu’on souhaite ajouter un verrou – « hold ».

# aptitude hold mariadb-client-10.0

 

#### Dé-holder un paquet

On utilise la directement commande « aptitude » pour déverrouiller le paquet en lui précisant qu’on souhaite enlever un verrou – « unhold ».

# aptitude unhold mariadb-client-10.0

 


## La méthode massive

#### Holder des paquets

Voici la méthode massive pour holder les paquets – utile lorsque vous avez une bonne liste de paquets à verrouiller. J’ai repris ici les deux méthodes APT/APTITUDE.

# dpkg -l | grep maria | awk '{print $2}' | while read package ; do apt-mark hold ${package}; done # dpkg -l | grep maria | awk '{print $2}' | while read package ; do aptitude hold ${package}; done

<span style="text-decoration: underline;">L’explication :</span>

On fait la recherche de paquets via « dpkg » et « grep », on récupère le nom des paquets avec « awk » et on boucle sur tous ces noms pour les holder.

 

#### Dé-holder des paquets

Même méthode pour déverrouiller.

# dpkg -l | grep maria | awk '{print $2}' | while read package ; do apt-mark unhold ${package}; done # dpkg -l | grep maria | awk '{print $2}' | while read package ; do aptitude unhold ${package}; done

 


