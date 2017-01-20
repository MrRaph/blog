+++
tags = ["Docker","Traefik","Reverse Proxy"]
description = ""
slug = "traefik-et-docker-le-couple-ultime"
draft = false
author = "MrRaph_"
categories = ["Docker","Traefik","Reverse Proxy"]
image = "/images/2016/11/docker_traefik.png"
title = "Traefik et Docker, le couple ultime !"
date = 2016-11-08T12:27:46Z

+++

# Docker c'est bien, mais ...

Docker est de plus en plus utilisé dans le monde de l'informatique, la croissance de l'utilisation a été révélée par Ben Golub, le CEO de Docker durant la [DockerCon au mois de Juin dernier](https://www.youtube.com/watch?v=vE1iDPx6-Ok). La progression est ahurissante, 30% d'adoption supplémentaire en un an et le nombre de containers en production à quintuplé !


![Docker adoption](/content/images/2016/11/docker_adoption.png)

Docker c'est très sympa, mais sans certains outils, ça devient compliqué. Partons d'un consat simple, vous avez mis en place vos hôtes Docker, vous avez installé et configuré votre cluster Swarm, c'est déjà bien ! Manque de chance, vous déployez majoritairement des applications web, donc il vous faut choisir un port différent pour chaque application, pas cool. En cherchant un peu sur le net, vous avez vu qu'il vous faut un Reverse Proxy comme point d'entrée pour que toutes vos applications puissent passer par les ports 80 et 443. Là encore, vous avez réussi à le mettre en place, mais dès que vous ajoutez une nouvelle application, il vous faut modifier la configuration de ce Reverse Proxy et le relancer, ce qui engendre éventuellement une petite coupure de service - plus longue si vous vous trompez dans la configuration ...


Voilà ce qu'était ma vie avant de me pencher sur le cas de [Traefik](https://traefik.io/) !


# L'outil ultime : Trafik !

Voyons maintenant comment ce petit Gopher devenu contrôleur aérien a changé ma vie par rapport à lorsque j'utilisais HAProxy.

![Traefik Gopher](https://traefik.io/traefik.logo.png)


Traefik est un reverse proxy moderne écrit en Go pensé pour déployer facilement des micro services. Cet outil supporte une foule de backends - Kubernetes, Marathons, Etcd, Consul, ... - dont Docker et le nouveau Docker Swarm Mode.

Nous allons voir comment utiliser Traefik dans un environnement Docker 1.11.2 avec Swarm - je n'utilise plus le Swarm Mode ni Docker 1.12 pour des raisons de stabilité.


## Installation de Traefik

[Traefik](https://traefik.io/) peut être installé en dur sur l'hôte, mais tant qu'a faire, nous allons utiliser la version containerisée de l'outil ! Voici le fichier `docker-compose` que j'utilise pour le démarrer - je pars du postulat que Swarm écoute sur le port `3375` de l'IP `192.168.1.10`.

    version: "2"

    services:
      traefik:
        image: traefik:v1.1.0-rc3
        ports:
          - "80:80"
          - "443:443"
          - "8080:8080"
        volumes:
          - /dev/null:/traefik.toml
        command: --web -c /dev/null  --docker --logLevel=INFO --docker.endpoint=tcp://192.168.1.10:3375 --docker.watch --entryPoints='Name:https Address::443 TLS' --entryPoints='Name:http Address::80 Redirect.EntryPoint:https' --defaultentrypoints=http,https
        networks:
          - web
        restart: always
        environment:
          - "affinity:container!=traefik*"
    networks:
      web:
        external:
          name: web


Voici une description de quelques options interressantes :

* `--docker` : Active le support de Docker 
* `--docker.watch` : Intercepte les évennements du daemon Docker et se reconfigure automatiquement
* `--entryPoints` : Définit sur quoi on va écouter, dans mon `:80` et `:443`
* `affinity:container!=traefik*` : Règle d'anti-affinité dans Swarm pour n'avoir qu'un container Traefik par hôte

Il ne reste plus qu'à démarrer Traefik avec la commande `docker-compose up -d`.



## Configuration des Backends


Dans Traefik - comme dans les autre reverse proxies -, il faut définir sur quoi on écoute - les entryPoints - et ou seront dirigées les connexions reçues - les Backends - via des Routes.

Dans notre cas, notre container Traefik à accès directement au daemon Docker, donc dès que vous l'aurez démarré il devrait avoir généré une configuration pour les containers présent sur votre environnements. Cette configuration sera à améliorer !

Vous pouvez avoir accès aux Routes et aux Backends que Traefik a généré en vous rendant sur son interface web : *http://ip_sur_laquelle_est_bindée_traefik:8080*.

Afin d'afiner cette configuration par défaut, nous allons aider Traefik en lui donnant des instructions. Ces dernières se présentent sous la forme de "labels" que l'on positionne sur les containers.

Pour l'exemple, voici le `docker-compose` de mon blog :


    version: '2'
    
    services:
      techan:
        image: ghost
        environment:
          - NODE_ENV=production
        volumes:
          - /ghost/ghost/techan:/var/lib/ghost
        networks:
          - web
          - bdd
        restart: always
        labels:
          - "traefik.backend=ghost"
          - "traefik.backend.ghost.loadbalancer.sticky=true"
          - "traefik.frontend.rule=Host:techan.fr,www.techan.fr"
          - "traefik.port=2368"
          - "traefik.docker.network=web"
    networks:
      web:
        external:
          name: web
      bdd:
        external:
          name: bdd

Observez les différents "labels" que j'ai passé à Traefik. Ils me permettent de définir que les containers de ce service devront répondre sur le DNS `techan.fr` ou `www.techan.fr`, qu'ils font partie du Backend nommé `ghost`, que je souhaites activer les sticky sessions. Nous spécifions également à Traefik que le port sur lequel les containers répondent est le 2368 et qu'il faut qu'il les atteignent pas le réseau `overlay` nommé `web`.

Il suffit de lancer la commande `docker-compose up -d` pour démarrer ou recréer les containers existants. Voici les Backends vus par Traefik, une fois qu'ils ont tous été recréés.

![](/content/images/2016/11/traefik_ghost.png)

Et la Route que l'outil à générée en ce basant sur les règles fournies :

![](/content/images/2016/11/traefik_ghost_route.png)



### Corsons le tout avec un deuxième service


Mon blog est propulsé par [Ghost](https://ghost.org/fr/), mais j'ai pris le parti de servir le contenu static par un autre biais, avec des containers NGinx qui ne font que ça. Il me faut donc configurer cela dans Traefik afin que les URL entrantes dont le début est `wp-content` soitent routées vers ces containers NGinx et non vers les containers Ghost.


J'ai donc ajouté un nouveau service dans le fichier `docker-compose` de mon blog :

      techan_static:
        image: nginx
        volumes:
          - /data/ghost/wp-content:/usr/share/nginx/html:ro
          - /data/ghost/techan_static/default.conf:/etc/nginx/conf.d/default.conf:ro
        networks:
          - web
        restart: always
        labels:
          - "traefik.backend=ghost-static"
          - "traefik.frontend.rule=Host:techan.fr,www.techan.fr;PathPrefixStrip:/wp-content"
          - "traefik.port=80"
          - "traefik.docker.network=web"
    networks:
      web:
        external:
          name: web

Les labels utilisés par Traefik sont relativement semblables à ceux utilisés dans le service de Ghost, je l'ai un petit épuré car certaines options n'étaient pas nécessaires. L'élément principal de la configuration est la ligne `traefik.frontend.rule`, j'ai repris la même que celle du blog Ghost - car ces containers servent le même site - mais j'y ai ajouté une règle de type `PathPrefixStrip`. Cette dernière regarde les URL reçues, si une URL commence par `/wp-content`, elle sera routée vers les containers NGinx du service `techan_static` et non vers les containers Ghost.


## Et maintenant, le HTTPS


Depuis quelques temps, j'utilise [Let’s Encrypt](https://letsencrypt.org/) pour me fournir les certificats SSL qui protègent mes sites. Le truc génial, c'est que Traefik supporte nativement Let’s Encrypt. Il est capable d'aller demander en temps réel les certificats pour les domaines dont il a besoin et de les installer. Il suffit pour cela que les enregistrements DNS A/AAAA soient positionnés. Voyons comment activer le support de Let’s Encrypt par Traefik, pour cela, il nous faut modifier le fichier `docker-compose` de Traefik.

    version: "2"

    services:
      traefik:
        image: traefik:v1.1.0-rc3
        ports:
          - "80:80"
          - "443:443"
          - "8080:8080"
        volumes:
          - /dev/null:/traefik.toml
          - /data/traefik/acme://etc/traefik/acme
          - /data/traefik/ssl:/etc/ssl
        command: --web -c /dev/null  --docker --logLevel=INFO --docker.endpoint=tcp://192.168.1.1:3375 --docker.watch --acme --acme.storage=/etc/traefik/acme/acme.json acme.email=me@domain.net --acme.entryPoint=https --entryPoints='Name:https Address::443 TLS' --entryPoints='Name:http Address::80 Redirect.EntryPoint:https' --defaultentrypoints=http,https --acme.domains="techan.fr,www.techan.fr"
        networks:
          - web
        restart: always
        environment:
          - "affinity:container!=traefik*"
    networks:
      web:
        external:
          name: web

Il faut renseigner quelques informations afin que Let's Encrypt puisse nous créer des certificats :

* `acme.email=me@domain.net` : L'email a utiliser pour Let's Encypt
* `--acme.domains="techan.fr,www.techan.fr"` : Les domaines pour lesquels demander un certificat. 


Il ne vous reste plus qu'à recréer vos containers Traefik !