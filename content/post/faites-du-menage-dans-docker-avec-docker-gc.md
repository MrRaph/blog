+++
date = 2016-11-23T08:49:25Z
image = "/images/2016/11/docker_clean_up.png"
description = ""
draft = false
title = "Faites du ménage dans Docker avec docker-gc"
slug = "faites-du-menage-dans-docker-avec-docker-gc"
author = "MrRaph_"
categories = ["Docker","Docker1.12","Trucs et Astuces"]
tags = ["Docker","Docker1.12","Trucs et Astuces"]

+++

Docker à la fâcheuse tendance de laisser trainer ses jouets un peu partout, notamment les containers qui ont crashés, qui n'ont pas démarrés et les images qui ne sont pas liées à des containers. Ce mécanisme est intéressant pour débugger, savoir pourquoi les containers n'ont pas démarrés, pour mon application fonctionnait avec une ancienne version de l'image mais pas avec la nouvelle. Bref, dans un environnement de développement, ce bazare est important, en production également mais dans une moindre mesure. En effet, en production, je préfère ne pas disposer des containers qui ont plantés il y a trois semaines de cela et gagner quelques précieux giga sur mes disques.

Ce problème est encore plus criant lorsque l'on [utilise les services de Docker 1.12](https://techan.fr/creer-des-services-avec-docker-1-12/). Lorsqu'il est dans [le nouveau Swarm Mode](https://docs.docker.com/engine/swarm/), Docker est capable de rescheduler les containers, laissant derrière lui les containers qui ne fonctionnent plus. Le même problème arriver lorsque l'on fait des ["rolling updates" avec Docker 1.12](https://techan.fr/les-rolling-updates-avec-docker-1-12/). Dans ce cas là, Docker éteint un par un les anciens containers et les redémarre avec le/les nouveau(x) paramètre(s) et ne supprime pas les containers qu'il a éteint ...

C'est dans ce contexte qu'intervient [Spotify](https://www.spotify.com/fr/) - un utilisateur notoire de Docker - a développé un certain nombre d'outil autours de la baleine pour assurer et simplifier sa production dans Docker. La société à par exemple développé son propre outil d'orchestration - [helios](https://github.com/spotify/helios) - , bien avant [l'intégration de Swarm dans le Docker Engine](http://blog.loof.fr/2016/06/dockercon-quand-docker-swarm-laisse-la.html).


<blockquote class="twitter-tweet" data-lang="fr"><p lang="en" dir="ltr">2015: the year of the production ready container.</p>&mdash; Alex Polvi (@polvi) <a href="https://twitter.com/polvi/status/546745257954529281">21 décembre 2014</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>


# Le Garbage Collector de Docker

Spotify a également développé un "[garbage collector](https://github.com/spotify/docker-gc)" qui "nettoie" les containers plantés et/ou arrêtés.

> **Attention !!!**

> *Si vous utilisez un outil comme [Rancher](http://rancher.com/), ou que vous utilisez des containers éteint comme volume, faites attention, cet outil risque de les supprimer. Utilisez les variables d'environnement pour filtrer ces containers.*

Le seul inconvénient de ce que Spotify fourni, c'est que le container fonctionne en "one shot", il faut le lancer sur chaque hôte à chaque fois qu'on veut faire du ménage. Ce n'est pas franchement optimal de mon point de vue, j'ai trouvé un autre projet ([flaccid/docker-docker-gc-crond](https://github.com/flaccid/docker-docker-gc-crond)) - reprenant le développement de Spotify - mais qui lance `docker-gc` toutes les demis heures via cron dans le container.

Voici comment mettre en place ce "garbage collector" sur votre infrastructure Docker. Dans un premier temps, il faut cloner le repostory GitHub et construire l'image Docker.

    # git clone https://github.com/flaccid/docker-docker-gc-crond.git
    # cd docker-docker-gc-crond
    # docker build -t flaccid/docker-gc-crond .


## Lancement avec docker-compose

Le projet fourni un fichier `docker-compose.yml` pour lancer le "garbage collector". Ce fichier présente également comment utiliser les variables d'environnement du container pour exclure des containers et/ou des images de la purge.

<script src="https://gist-it.appspot.com/https://github.com/flaccid/docker-docker-gc-crond/blob/master/docker-compose.yml"></script>


## Lancement avec un service Docker


Voici comment lancer ce même "garbage collector" dans un environnement Docker 1.12 avec un cluster Swarm en place.

    docker service create --mode global \
    --restart-condition any --name gc \
    --mount type=bind,source=/var/run/docker.sock,target=/var/run/docker.sock \
    flaccid/docker-gc-crond


Cette commande va créer un service en mode `global`, ceci a pour effet de placer un container sur chaque hôte.

# Le résultat !

Avant le passage du "garbage collector", j'avais 104 containers purgeables.

    # docker ps -a | grep -v "^CONTAINER ID" | grep -v Run | wc -l
    104
    # df -h
    Filesystem                 Size  Used Avail Use% Mounted on
    /dev/vda                    46G   32G   12G  73% /

Une fois que ce dernier est passé, la magie a opérée ! :)

    # docker ps -a | grep -v "^CONTAINER ID" | grep -v Run | wc -l
    0
    # df -h
    Filesystem                 Size  Used Avail Use% Mounted on
    /dev/vda                    46G   32G   12G  73% /


# Sources

* [How Spotify is ahead of the pack in using container - gigaom.com](https://gigaom.com/2015/02/22/how-spotify-is-ahead-of-the-pack-in-using-containers/)
* [Swarm - Docker docs](https://docs.docker.com/engine/swarm/)
* [For wahtever it's worth, don't run Spotify docker-gc - Rancher forums](https://forums.rancher.com/t/for-whatever-its-worth-dont-run-spotify-docker-gc/1571)