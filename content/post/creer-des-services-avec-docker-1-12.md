+++
slug = "creer-des-services-avec-docker-1-12"
draft = false
title = "Créer des Services avec Docker 1.12"
date = 2016-07-29T12:35:54Z
author = "MrRaph_"
categories = ["Docker","Linux","How To","Docker1.12","Swarm"]
tags = ["Docker","Linux","How To","Docker1.12","Swarm"]
description = ""

+++

Nous avons dans l'article précédent comment [créer un cluster Swarm avec Docker 1.12](https://techan.fr/creer-un-cluster-swarm-avec-docker-1-12/). L'une des autres nouveautés de cette version est l'arrivée des "Services". Un service permet de répliquer, load-balancer, distribuer un container. Le service permet également une montée en charge facilitée - sur le modèle du docker-compose scale ....

Un service peut être global ou répliqué. Un service global fournira un container sur chacun des hôtes du cluster Swarm. Un service répliqué quant à lui fournira le nombre de container demandé lors de sa création - par défaut un seul. Il est tout à fait possible d'augmenter le nombre de containers d'un service après son démarrage.

## Création d'un service simple

Nous allons commencer par créer un service simple. Dans cet exemple, je vais démarrer des containers pour héberger mon blog sur [Ghost](https://techan.fr/creer-un-cluster-swarm-avec-docker-1-12/).

Le prérequis à cette action est de créer un réseau multi-hôte dans le cluster Swarm. La commande pour réaliser celà n'a pas changée avec l'arrivée de Docker 1.12.

    docker network create --driver=overlay web

Maintenant que le réseau `web` est créé, démarrons notre service.

    docker service create --name techan_ghost \
    --restart-condition any \
    --network web \
    --replicas 2 \
    -e NODE_ENV=production \
    --mount type=bind,source=/data/ghost/ghost/techan,target=/var/lib/ghost \
    ghost

La commande si dessus créer un service nommé `techan_ghost` connecté au réseau `web`. Le container à besoin de recevoir la variable d'environnement `NODE_ENV`.

Vous avez peut être remarqué quelques options différentes par rapport à la création d'un container avec la commande `docker run`.

* `--restart-condition` : équivalent de l'ancien `--restart`
* `--replicas` : cette option permet de spécifier le nombres de containers pour le service, deux dans notre cas.
* `--mount` : c'est l'équivalent d'ancien `-v` pour monter des volumes/dossiers/fichiers mais la syntaxe change complètement.


Nous souhaitons avoir deux containers dans le service `techan_ghost`, dans l'hypothèse ou nous aurions exposé un port sur l'hôte pour accéder à nos container et que tous les containers du service aient été créés sur le même hôte, Docker n'aurait exposé le port qu'une fois et aurait fait du load balancing entre les containers du service. Ceci représente une grande avancée par rapport aux autres versions. Avant, pour avoir le même comportement, nous autions été obligés de démarrer nos containers et de prévoir un load balancing en supplément.

## Création d'un Service "global"

Un service global créera un container sur chacun des hôtes du cluster Swarm. Je m'en sert pour mon reverse proxy - HAProxy.

    docker service create --name haproxy \
    -p 80:80 -p 443:443 \
    --mode global --restart-condition any \
    --network web \
    --mount type=bind,source=/data/haproxy/haproxy.cfg,target=/usr/local/etc/haproxy/haproxy.cfg \
    --mount type=bind,source=/data/haproxy/certs,target=/haproxy-override/certs \
    haproxy:1.6.4-alpine

La syntaxe est la même que pour créer un Service classique, il suffit juste de préciser `--mode global`.


## Récolter des informations sur les Services du cluster

La commande `docker service ls` permet de lister les Services créés dans le cluster et d'en voir un status rapide.


root@scw-625da5:/data/haproxy# docker service ls
ID            NAME            REPLICAS  IMAGE                 COMMAND
3ywx5ic0igbo  haproxy         global    haproxy:1.6.4-alpine                
ae88qaulg0ac  techan_ghost    2/2       ghost                 
bo1m8jo1r38f  techan_static   2/2       nginx                 
di23iov1jnkh  techan_indispo  2/2       nginx  


La commande `docker service ps <nom du service>` fournie quant à elle l'état et les erreurs éventuelles rencontré par les containers composant le Service.

    root@scw-625da5:/data/haproxy# docker service ps techan_ghost
    ID                         NAME            IMAGE  NODE        DESIRED STATE  CURRENT STATE        ERROR
    bbnoqcuc3rbl63k5tfhsbhf53  techan_ghost.1  ghost  scw-625da5  Running        Running 2 hours ago  
    5o3o0grkoljbi8tnoj3vx4czr  techan_ghost.2  ghost  scw-625da5  Running        Running 2 hours ago  


## Augmenter le nombre de containers dans un Service

La commande pour augmenter le nombre de containers dans un Service est la suivante :


    root@scw-625da5:/data/haproxy# docker service scale techan_ghost=3
    techan_ghost scaled to 3

Vérifons que tout s'est bien passé :

    root@scw-625da5:/data/haproxy# docker service ls
    ID            NAME            REPLICAS  IMAGE                 COMMAND
    3ywx5ic0igbo  haproxy         global    haproxy:1.6.4-alpine  
    ae88qaulg0ac  techan_ghost    3/3       ghost                 
    bo1m8jo1r38f  techan_static   2/2       nginx                 
    di23iov1jnkh  techan_indispo  2/2       nginx                 
    root@scw-625da5:/data/haproxy# docker service ps techan_ghost
    ID                         NAME            IMAGE  NODE        DESIRED     STATE  CURRENT STATE           ERROR
    bbnoqcuc3rbl63k5tfhsbhf53  techan_ghost.1  ghost  scw-625da5  Running        Running 2 hours ago     
    5o3o0grkoljbi8tnoj3vx4czr  techan_ghost.2  ghost  scw-625da5  Running        Running 2 hours ago     
    7vwx42qsza5pw71xjc9kv9hq5  techan_ghost.3  ghost  scw-625da5  Running        Running 10 seconds ago  


## Accéder à un service via un autre container connecté au même réseau

Le gros intérêt des réseau logiciels de Docker est de pouvoir facilement accéder à un container depuis un autre container connecté au même réseau.

Par exemple s'il l'on avait un container serveur web - `web1` - et un container reverse proxy - `haproxy1` - connectés au même réseau `web`. On pouvait utiliser la chaîne `web1.web` pour proxyfier le contenu du container `web1` avec le container `haproxy1`.

Avec Docker 1.12, vous allez créer des Services et vous ne voudrez plus accéder à un seul container mais à tout le service ! Pour celà, rien de plus simple, dans le même réseau, on peut accéder à un service via le FQDN `nom-du-service`.`nom-du-réseau`. On profite en plus du load balancing fourni par Docker 1.12.


## Sources
* [Doc. Docker 1.12](https://docs.docker.com/engine/swarm/swarm-tutorial/) (Anglais)