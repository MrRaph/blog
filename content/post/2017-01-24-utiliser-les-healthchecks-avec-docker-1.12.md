+++
categories = ["Docker", "Trucs et Astuces"]
author = "MrRaph_"
tags = ["Docker", "Trucs et Astuces"]
draft = false
title = "Utiliser les Health Checks avec Docker 1.12"
date = "2017-01-24T08:00:59+01:00"
type = "post"
image = '/images/2016/11/docker.png'
slug = "utiliser-les-healthchecks-avec-docker-1.12"
description = ""
+++

# La surveillance du processus principal c'est bien mais ...

Les "[Health Checks](https://docs.docker.com/engine/reference/builder/#/healthcheck)" ont été introduits dans le monde Docker avec la version 1.12, ils répondent à un manque flagrant dans cet environnement de "containérisation" : la surveillance des processus dans les containers. Historiquement, Docker surveillait uniquement le processus "principal" des ses containers, c'est à dire le processus définit dans les instructions `CMD` ou `ENTRYPOINT` des Dockerfiles. On constatait alors qu'un container mourait lorsque le daemon Docker ne détectait plus ce processus principal. En gros, c'est un peu comme surveiller si la bouteille d'huile d'olive n'est pas fendue pour surveiller la quantité d'huile qu'elle contient.

Ce mécanisme est toujours présent malgré l'arrivée des "[Health Checks](https://docs.docker.com/engine/reference/builder/#/healthcheck)", mais ces derniers enrichissent les possibilité de validation de la santé d'un container. Prenons un exemple simple, vous avez une image dans laquelle vous lancez un serveur web qui servira un site statique - oui, l'exemple n'est pas innocent :p. Le processus principal des containers engendrés par cette image sera sans doute le serveur web lui même, disons NGinx. Il est possible que dans certains cas, sous une forte charge par exemple, le processus NGinx soit bien présent dans le container mais que le serveur web ne soit pas au mieux de sa forme et que donc, le site réponde mal.

# Les Health Checks apportent des possibiltés supplémentaires plus poussées !

Dans ce type de cas, il est intéressant de tester si le serveur web répond réellement ou si le processus fait de la figuration. Avec l'arrivée des "[Health Checks](https://docs.docker.com/engine/reference/builder/#/healthcheck)", il est maintenant possible de déléguer ce type de validation  directement à Docker.

Les "Health Checks" peuvent être définis dans le Dockerfile afin que chaque container créé à partir de l'image ainsi définie implémente ces validations. Ils peuvent également être définis au lancement d'un container, ils ne seront dans ce cas valable que pour le container démarré de cette façon.

## Définition des Health Checks dans un Dockerfile

Voici la commande à ajouter dans un Dockerfile pour ajouter des validations de bonne santé.

    HEALTHCHECK [OPTIONS] CMD command (check container health by running a command inside the container)
    HEALTHCHECK NONE (disable any healthcheck inherited from the base image)

En plus de la commande de validation, qui est obligatoire, il est possible de jouer sur différents paramètres concernants la réalisation et la validation des tests de santé.

    --interval=DURATION (default: 30s)
    --timeout=DURATION (default: 30s)
    --retries=N (default: 3)

Voici un exemple de Dockerfile très simple qui utilise un test de bonne santé qui valide que le serveur web NGinx répond toujours en HTTP. Petite remarque bête, on est obligé d'installer `curl` sinon le test serait forcément en erreur !

    FROM nginx:latest

    RUN DEBIAN_FRONTEND=noninteractive apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y  curl && \
    rm -rf /var/lib/apt/lists/* && \

    ADD ./site /var/wwww
    ADD sites-enabled/www.techan.fr.conf /etc/nginx/sites-enabled/www.techan.fr.conf

    HEALTHCHECK CMD curl --fail http://localhost/ || exit 1

    EXPOSE 80 443
    CMD ["nginx", "-g", "daemon off;"]

Voici ce qu'affiche Docker lorsque l'on liste les container qui sont en cours d'exécution. On peut voir la nouvelle information `(healthy)` affichée à côté du statut du container.

    root@docker-machine-1:~# docker ps
    CONTAINER ID        IMAGE                                                                                         COMMAND                  CREATED              STATUS                  PORTS                       NAMES
    6aea82cf2942        mrraph/blog   "nginx -g 'daemon ..."   22 hours ago        Up 22 hours (healthy)   80/tcp, 443/tcp, 8080/tcp   techan-prod.2.jb5h3e8ce30vjiohxuy1ry7bk

On peut également interroger Docker pour avoir directement le statut du Health Check avec la commande ci-dessous.

    docker inspect --format='{{.State.Health.Status}}' techan-prod.2.jb5h3e8ce30vjiohxuy1ry7bk
    healthy



## Définir un Health Check au lancement d'un container

Il est également possible de définir les paramètres de Health Check au démarrage d'un container. Ces paramètres ne seront alors valables que pendant la durée de vie du container.

Si l'on reprend l'exemple précédent, voici à quoi ressemblerait la commande pour démarrer le container avec le même test de bonne santé.

    $ docker run --name=test -d \
    --health-cmd='curl --fail http://localhost/ || exit 1' \
    --health-interval=2s \
    mrraph/blog
    
Cette méthode permet de valider que le test fonctionne comme attendu.


# Sources

* [Health Checks : Documentation Docker (Anglais)](https://docs.docker.com/engine/reference/builder/#/healthcheck)
