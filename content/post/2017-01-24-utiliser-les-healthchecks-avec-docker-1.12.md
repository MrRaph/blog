+++
categories = ["Docker", "Trucs et Astuces"]
author = "MrRaph_"
tags = ["Docker", "Trucs et Astuces"]
draft = true
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


    HEALTHCHECK [OPTIONS] CMD command (check container health by running a command inside the container)
    HEALTHCHECK NONE (disable any healthcheck inherited from the base image)

En plus de la commande de validation, qui est obligatoire, il est possible de jouer sur différents paramètres concernants la réalisation et la validation des tests de santé.

    --interval=DURATION (default: 30s)
    --timeout=DURATION (default: 30s)
    --retries=N (default: 3)

Dockerfile

    FROM nginx:latest

    ADD ./site /var/wwww
    ADD sites-enabled/www.techan.fr.conf /etc/nginx/sites-enabled/www.techan.fr.conf

    HEALTHCHECK CMD curl --fail http://localhost/ || exit 1

    EXPOSE 80 443
    CMD ["nginx", "-g", "daemon off;"]


    root@docker-machine-1:~# docker ps
    CONTAINER ID        IMAGE                                                                                         COMMAND                  CREATED              STATUS                  PORTS                       NAMES
    6aea82cf2942        mrraph/blog@sha256:256a5eb5651ec578be592e6be0a2dcaa3f1197a3803187eb9f92a1c5401bbc08   "nginx -g 'daemon ..."   22 hours ago        Up 22 hours (healthy)   80/tcp, 443/tcp, 8080/tcp   techan-prod.2.jb5h3e8ce30vjiohxuy1ry7bk

    docker inspect --format='{{.State.Health.Status}}' techan-prod.2.jb5h3e8ce30vjiohxuy1ry7bk
    healthy




# Sources

* [Health Checks : Documentation Docker (Anglais)](https://docs.docker.com/engine/reference/builder/#/healthcheck)
