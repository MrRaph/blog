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

    --interval=DURATION (default: 30s)
    --timeout=DURATION (default: 30s)
    --retries=N (default: 3)

Dockerfile

    FROM nginx:latest

    ENV VERSION=0.18.1 \
        SRC=hugo_${VERSION}_Linux-64bit \
        EXTENSION=tar.gz \
        BINARY=hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64

    RUN DEBIAN_FRONTEND=noninteractive apt-get purge -y nginx && \
      DEBIAN_FRONTEND=noninteractive apt-get update && \
      DEBIAN_FRONTEND=noninteractive apt-get -y dist-upgrade && \
      DEBIAN_FRONTEND=noninteractive apt-get install -y liblua5.1-json nginx-extras \
      python-pygments python git python-pip curl && \
      rm -rf /var/lib/apt/lists/* && \
      git clone https://github.com/shoonoise/lua-nginx-statistics.git /lua-nginx-statistics && \
      mkdir -p /usr/share/nginx/ && cp /lua-nginx-statistics/*.lua /usr/share/nginx/ && \
      cp -rp /lua-nginx-statistics/static /usr/share/nginx/ && \
      rm -rf /lua-nginx-statistics && \
      git clone --recursive https://github.com/MrRaph/blog.git /src

    WORKDIR /src

    ADD https://github.com/spf13/hugo/releases/download/v${VERSION}/hugo_${VERSION}_Linux-64bit.tar.gz /tmp/
    RUN mkdir -p /tmp/hugo /var/www/blog && \
        tar xzf /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION} -C /tmp/hugo && \
        /tmp/hugo/hugo_${VERSION}_linux_amd64/hugo_${VERSION}_linux_amd64 -t hugo-future-imperfect-0.3 || exit 0

    WORKDIR /var/www

    RUN cp -rp /src/public/* /var/www/ && \
        rm /tmp/hugo_${VERSION}_Linux-64bit.${EXTENSION} && \
        rm -rf /src && \
        chown -R nginx:nginx /var/www && \
        rm /etc/nginx/sites-enabled/default
       rm -rf /tmp/hugo* /src

    ADD sites-enabled/www.techan.fr.conf /etc/nginx/sites-enabled/www.techan.fr.conf
    ADD sites-enabled/stats.conf /etc/nginx/sites-enabled/stats.conf
    ADD conf.d/stats.conf /etc/nginx/conf.d/stats.conf

    HEALTHCHECK CMD curl --fail http://localhost/ || exit 1

    EXPOSE 80 443 8080
    CMD ["nginx", "-g", "daemon off;"]

# Sources

* [Health Checks : Documentation Docker (Anglais)](https://docs.docker.com/engine/reference/builder/#/healthcheck)
