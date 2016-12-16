+++
draft = false
date = 2016-09-01T10:04:48Z
tags = ["Docker","Ubuntu","Linux","TroubleShooting","ufw"]
description = ""
slug = "docker-ufw-ubuntu-danger"
image = "/images/2016/09/docker.png"
title = "Docker + UFW + Ubuntu = Danger !"
author = "MrRaph_"
categories = ["Docker","Ubuntu","Linux","TroubleShooting","ufw"]

+++

UFW - Uncomlicated Firewall - est un programme très pratique pour gérer le firewall IPTables sur Ubuntu. J'en suis le premier fan étant assez feignant ... Il permet de ne pas avoir à bidouiler soit même les règles IPTables, ce qui peut se réveller être un travail fastidieux ...

# Un cas simple

Le cas le plus simple est d'installer UFW, de lui demander d'autoriser le SSH, de refuster toute autre connexion entrante et de l'activer !

    ufw allow ssh
    ufw default deny incoming
    ufw enable

Vérifions l'état de notre firewall !

    sudo ufw status
    Status: active
    
    To                         Action      From
    --                         ------      ----
    22                         ALLOW       Anywhere
    22 (v6)                    ALLOW       Anywhere (v6)

Une fois cette manipulation réalisée, il est bien possible de se connecter sur l'hôte en SSH, mais il n'est pas possible d'accéder aux autres services réseaux installés sur la machine - MySQL, MongoDB, ...

Jusque là donc, tout fonctionne comme attendu !

# Ajoutons un soupçon de Docker

La prochaine étape est de démarrer un container Docker dont nous allons exposer un port. Pour l'exemple, je vais utiliser un container Solr - qui me sert à indexer mes mails (voir [Introduction à Docker avec l'indexation full text des mails](https://techan.fr/introduction-a-docker-avec-lindexation-full-text-des-mails/)).

    docker run --name my_solr -d -p 8983:8983 -t solr

Ce container écoute sur le port 8983 de toutes les interfaces réseau du système, mais il ne devrait pas sortir si l'on se fie aux règles que nous avons définie dans UFW.

Détrompez-vous, l'interface de Solr est alors pleinement accessible sur Internet ...

Il semblerait que Docker inclue ses règles avant celles créées par UFW, ce qui est problématique ...

# La solution

La solution est simple, il suffit de passer un paramètre au daemon Docker pour qu'il ne bidouille plus IPtables !

## Sur un system sans systemd

Il faut ajouter l'option `--iptables=false` dans la variable `DOCKER_OPTS` qui se trouve dans le fichier `/etc/default/docker`.

    DOCKER_OPTS="--dns 8.8.8.8 --dns 8.8.4.4 --iptables=false" 

Redémarrez ensuite le daemon Docker avec la commande : `service docker restart`.

## Sur un system avec systemd

Dans ce cas là , la tâche se corse un petit peu, il faut tout d'abord trouver le ficiher de définition du service Docker. Pour cela vous pouvez utiliser la commande `locate docker.service`. Dans mon cas, sur Ubuntu 16.04, ce fichier se trouvait ici : `/etc/systemd/system/docker.service`.

Il faut ajouter l'option `--iptables=false` à la fin de la ligne `ExecStart=`.

    [Service]
    ExecStart=/usr/bin/docker daemon -H unix:///var/run/docker.sock --storage-driver aufs --label provider=scaleway(VC1M) --iptables=false
    MountFlags=slave
    LimitNOFILE=1048576
    LimitNPROC=1048576
    LimitCORE=infinity
    Environment=
    
    [Install]
    WantedBy=multi-user.target


Redémarrez ensuite le daemon Docker avec la commande : `systemctl restart docker.service`.