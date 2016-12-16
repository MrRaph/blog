+++
categories = ["Docker","Docker 1.12","Rolling Updates","How To"]
slug = "les-rolling-updates-avec-docker-1-12"
date = 2016-07-30T13:49:02Z
author = "MrRaph_"
tags = ["Docker","Docker 1.12","Rolling Updates","How To"]
image = "https://sif.info-ufr.univ-montp2.fr/docker-talk/images/docker.png"
description = ""
draft = false
title = "Les rolling updates avec Docker 1.12"

+++

Maitenant que nous avons [créé un cluster Swarm avec Docker 1.12](https://techan.fr/creer-un-cluster-swarm-avec-docker-1-12/) et que nos containers sont lancés avec [les tout nouveaux Services de Docker 1.12](https://techan.fr/creer-des-services-avec-docker-1-12/), voyons comment mettre à jour nos containers avec le mécanisme des "rolling updates".

Plusieurs raisons peuvent pousser à la mise à jour d'un Service, la plus évidente d'entre elle est la disponibilité d'une image plus récente, mais on peut également envisager de changer l'image de utilisée par le service ...


# Les pré-requis

Il faut évidement que vous disposiez de Docker 1.12 sur vos hôtes, que vous ayez configuré un [cluster Swarm](https://techan.fr/creer-un-cluster-swarm-avec-docker-1-12/) et que vos containers soient [gérés par des Services](https://techan.fr/creer-des-services-avec-docker-1-12/) !

Il faut également que les services que vous souhaitez updater avec les "rolling updates" aient été créés avec l'option `--update-delay`. Par exemple pour le service `techan-ghost` :

    docker service create --name techan_ghost \
    --restart-condition any \
    --network web \
    --update-delay 30s \
    --replicas 2 \
    -e NODE_ENV=production \
    --mount type=bind,source=/data/ghost/ghost/techan,target=/var/lib/ghost \
    ghost

Rassurez, si vous avez créé votre Service sans cette option, il est également possible de l'ajouter après coup comme ceci :

    docker service update --update-delay 30s techan_ghost


# La mise à jour 

Lancer la mise est un jeu d'enfant, il suffit d'utiliser la commande suivante.

    docker service update --image ghost:latest techan_ghost

Cette dernière va informer le moteur Docker qu'il doit mettre à jour le Service `techan_ghost` avec l'image `ghost:latest`.

Voici les différentes étapes que le moteur Docker va suivre pour procéder à ce "rolling update".


* Il va d'abord arrêter la première tâche du Service
* Il va lancer la mise à jour - en téléchargeant la nouvele image - pour la tâche qu'il vient d'arrêter.
* Ensuite il démarre la tâche ainsi mise à jour.
* Si la tâche mise à jour passe à l'état `RUNNING`, il va attendre le `--update-delay` spécifié puis stopper la tâche suivante du Service.
* Si à n'importe quel moment du processus, une tâche passe au status `FAILED`, il met toute la mise à jour en pause.

La commande `docker service inspect --pretty <nom_du_service>` permet de suivre l'avancement de la mise à jour et d'en connaître le status.

    root@scw-625da5:~# docker service inspect --pretty techan_ghost
    ID:             2427y1503y5hfa166btv9skwo
    Name:           techan_ghost
    Mode:           Replicated
     Replicas:      2
    Update status:
     State:         completed
     Started:       10 minutes ago
     Completed:     9 minutes ago
     Message:       update completed
    Placement:
    UpdateConfig:
     Parallelism:   1
     Delay:         30s
     On failure:    pause
    ContainerSpec:
     Image:         ghost:latest
     Env:           NODE_ENV=production
     Mounts:
      Target = /var/lib/ghost
      Source = /data/ghost/ghost/techan
      ReadOnly = false
      Type = bind
    Resources:

Si la mise à jour venait à ne pas se terminer correctement, elle est mise en pause. Il faudra alors modifier le Service - avec la commande `docker service update` - puis relancer la relancer - avec la commande `docker service update <nom_du_service>`. 

Et voilà pour le processus de mise à jour avec Docker 1.12 :-)


# Sources 
* [docs.docker.com - Apply rolling updates](https://docs.docker.com/engine/swarm/swarm-tutorial/rolling-update/) (Anglais)