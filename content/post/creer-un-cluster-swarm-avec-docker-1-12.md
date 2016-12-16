+++
draft = false
title = "Créer un cluster Swarm avec Docker 1.12"
date = 2016-07-29T11:47:00Z
author = "MrRaph_"
categories = ["Docker","Linux","DevOps","How To"]
tags = ["Docker","Linux","DevOps","How To"]
description = ""
slug = "creer-un-cluster-swarm-avec-docker-1-12"

+++

Ca y est ! [Docker 1.12 est enfin disponible au téléchargement](https://blog.docker.com/2016/06/docker-1-12-built-in-orchestration/) avec son lot de nouveautés. Il faut dire qu'on est gâtés avec cette version ! L'une des nouveautés de cette version est l'intégration de Swarm dans le moteur de Docker. Finie l'installation de Swarm avec pleins de containers et finie également la dépendance pénible avec un stockage clé / valeur. Tout ceci est maintenant directement intégré dans Docker ! 

Voyons comment mettre en place un cluster avec cette nouvelle méthode, vous allez voir, c'est très simple !


## Création d'un cluster swarm

Nous allons voir comment créer un cluster Swarm 3 noeuds avec Docker 1.12. Dans ce cluster, chacun des trois noeuds seront maîtres ce qui permettra de toujours avoir un maître élu même si l'un des noeuds venait à défaillir. Allez, rentrons dans le vif du sujet et créons notre cluster !!


    root@mail:~# docker swarm init --listen-addr 0.0.0.0:2377
    Swarm initialized: current node (<node id>) is now a manager.

        To add a worker to this swarm, run the following command:
        docker swarm join \
        --token <swarm token> \
        <node IP>:2377

    To add a manager to this swarm, run the following command:
        docker swarm join \
        --token <swarm token> \
        <node IP>:2377

Et voilà, notre premier maître est prêt ... Pour ajouter les autres noeuds, il suffit d'utiliser les commandes que le premier noeud nous donne.



    root@docker02:~# docker swarm join \
    > --token <swarm token> \
    > <node IP>:2377
    This node joined a swarm as a manager.

Répétez cette opération sur chacun des noeuds, et vous aurez vos trois noeuds maîtres.

Visualisons maintenant l'état de notre cluster Swarm :

    root@mail:~# docker node ls
    ID                           HOSTNAME            STATUS  AVAILABILITY  MANAGER STATUS
    13ylpzq4r0c9qbq07r2rlyhhf    docker01  Ready   Active        Reachable
    1g1mmc6me3kq2satp2xhgg2rm    docker02  Ready   Active        Reachable
    at3h2ljyjnc8j6fx87dgbyohq *  mail                Ready   Active        Leader

Super ! Maintenant le cluster Swarm est opérationnel !

### Retirer un hôte de la liste des hôtes pouvant recevoir des containers


Il peut être intéressant de retirer un des hôtes du cluster Swarm afin de ne pas le surcharger. Dans mon cas, il m'a fallu le faire pour mon hôte "mail" car je ne souhaite pas ajouter autre chose que mon serveur de mail sur cette machine.

Cette opération est facilement réalisable en utilisant la commande suivate.

    docker node update --availability drain mail

Le status du noeud change alors dans la liste des noeuds.

    root@scw-625da5:/data/haproxy# docker node list
    ID                           HOSTNAME    STATUS  AVAILABILITY  MANAGER STATUS
    69kcrle97im0rnbdl982ki3fm    mail        Ready   Drain         Reachable

Le status "Drain" vous assure que cet hôte ne recevra pas de containers et plus encore, les containers qui tournaient sur cet hôte avant son changement de status seront disptachés sur les autres hôtes - à condition que les containers aient-été créés via des "[Services](https://techan.fr/creer-des-services-avec-docker-1-12/)".