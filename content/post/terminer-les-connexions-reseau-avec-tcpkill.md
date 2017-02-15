+++
draft = false
tags = ["Linux","Sécurité","tcpkill","terminer les connexions réseau avec tcpkill","Trucs et Astuces"]
description = ""
slug = "terminer-les-connexions-reseau-avec-tcpkill"
date = 2015-02-04T18:37:49Z
author = "MrRaph_"
categories = ["Linux","Sécurité","tcpkill","terminer les connexions réseau avec tcpkill","Trucs et Astuces"]
image = "https://techan.fr/images/2014/11/Linux.png"
title = "Terminer les connexions réseau avec tcpkill"

+++


Récemment, un charmant ressortissant d’Albion a gentiment tenté une attaque de brute force sur le présent site. Vous trouverez dans cette article les deux actions que j’ai faite afin de bannir et terminer les connexions réseau avec tcpkill et IPtables.


## Action 1: Empêcher les nouvelles connexions

Pour empêcher que l’attaquant créer de nouvelles connexions, j’ai ajouté une règle dans IPtables.

    iptables -I INPUT -s XXX.XXX.XXX.XXX -j DROP

Voilà qui l’empêche d’ouvrir de nouvelles connexions, mais j’en avais encore pas mal d’actives …


## Action2: Sortir le bazooka

Pour terminer les connexions restantes, j’ai trouvé la commande « tcpkill » que j’ai installé comme ceci sur Ubuntu (sur RedHat le paquet porte le même nom) :

    aptitude install dsniff

Voici un exemple d’utilisation avec une connexion SSH que j’ai ouverte pour le test. Dans un premier temps, je liste les connexions ouvertes depuis « host1 » qui est l’attaquant.

    root@host2:~# netstat -anp | grep host1
    tcp 0 0 host2:22 host1:39524 ESTABLISHED 16882/8

Ensuite, je lance « tcpkill » pour fermer les connexion venant de « host1 » et visant mon port SSH.

    root@host2:~# tcpkill host host1.domain.net and src port 22
    tcpkill: listening on eth0 [host host1.domain.net and src port 22] host2.domain.net:22 > host1.domain.net:39524: R 2052257557:2052257557(0) win 0

Et voilà, le ménage est fait.

    root@host2:~# netstat -anp | grep host1 root@host2:~#

Cette commande est très flexible et permet de filtrer assez facilement les connexions a tuer et celles qu’il faut laisser vivre. Voici d’autre exemple d’utilisation.

###### Tuer toutes les connexions venant de 192.168.0.100

    tcpkill host 192.168.0.100

######  Tuer toutes les connexions sur le port FTP de l’interface eth0

    tcpkill -i eth0 port 21

 

 
