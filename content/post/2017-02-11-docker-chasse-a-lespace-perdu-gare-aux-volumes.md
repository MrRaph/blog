+++
slug = "docker-chasse-a-lespace-perdu-gare-aux-volumes"
draft = false
date = "2017-02-11T15:46:12+01:00"
image = "/images/2016/11/docker_clean_up.png"
type = "post"
description = ""
title = "Chasse à l'espace perdu avec Docker, gare aux volumes !"
author = "MrRaph_"
categories = ["Docker","Docker1.12","Trucs et Astuces"]
tags = ["Docker","Docker1.12","Trucs et Astuces"]
+++

Il n'est pas rare de constater que l'espace disque consommé par Docker dans ses dossiers internes - par défaut sur Linux : `/var/lib/docker` - augmente régulièrement, parfois jusqu'à la saturation du file system. Si disque contenant le dossier `/var/lib/docker` venait à être plein, il serait alors impossible de démarrer de nouveaux containers, de télécharger de nouvelles images. Il se pourrait même que certains containers arrêtent de fonctionner. J'ai déjà été confronté plusieurs fois à des cas dans lesquels il était difficile d'identifier la source de la surconsommation d'espace disque. Voici quelques pistes pour la trouver et libérer de l'espace disque.

Nous verrons ici que la façon dont vous écrivez vos Dockerfile peut avoir un impact fort sur la taille que consommera le container - parfois à votre insue - sur le disque local de l'hôte.

# Le ménage dans les containers et les images

Le premier reflexe est de faire le ménage dans les containers arrêtés - attention, il sont parfois nécassires ! - et dans les images non utilisées. Ceci peut être une manière simple et rapide de libérer quelques giga octets. Il faut toute fois noter, que si Docker affiche qu'une image pèse 1,88 GB ni signifie pas forcément que la suppression de cette image libèrera effectivement 1,88 GB. Si vous avez téléchargé plusieurs versions de cette image alors une grande partie de cette taille totale sera partagée par toutes les versions. Docker ne télécharge pas les choses deux fois, il est capable de factoriser des éléments - calques - partagés par plusieurs images.

![Poids images Docker](/images/2017/02/docker_volumes_images.png)

Pour en savoir plus sur la façon de faire du ménage automatiquement dans les containers et les images non utilisés, lisez [Faites du ménage dans Docker avec docker-gc](https://techan.fr/faites-du-menage-dans-docker-avec-docker-gc/).

# Et maintenant, les volumes !

Vous avez déjà purgé tout ce que vous pouviez dans les containers et les images qui trainaient sur vos hôtes Docker, mais la quantité d'espace inutilisée vous semble toujours trop importante ? Alors vous avez peut être des volumes à purger également !

Nous tout d'abord voir comment lister les volumes Docker présents sur votre hôte. Il faut utiliser la commande `docker volume ls` pour les faire apparaître.

![Lister les volumes Docker](/images/2017/02/docker_volumes_ls.png)

Docker n'est pas très bavard lorsqu'il liste les volumes, il n'affiche que les identifiant de ces derniers et le driver utilisé par chacun d'eux. Tous les volumes dont le driver est `local` sont stockés, par défaut, dans le dossier `/var/lib/docker/volumes`.

![Taille des volumes Docker](/images/2017/02/docker_volumes_taille_dossier.png)

Dans mon cas, la taille occupée par ces volumes dans le dossier `/var/lib/docker` reste raisonnable, mais j'ai parfois vu des cas ou ces volumes occupaient preque 40 Go sur le disque.

## Les volumes "fantômes"

Ce que j'appelle des "volumes fantômes" sont des volumes que Docker créer car vous le lui avez demandé mais que vous n'utilisez pas. Dans un Dockerfile, il existe une clause `VOLUME` qui permet de déclarer des éléments qui seront traités de manière spéciale au niveau stockage. Cela peut être le dossier dans lequel vos utilisateurs vos uploader leur avatar, le dossier dans lequel l'application dans le container va générer vos factures, cela peut être n'importe quel dossier. Mais attention !! Il est facile de déclarer des volumes, mais si l'on en déclare trop, cela deviendra vite impactant !

Voyons, en image, un exemple qui va créer un "volume fantôme".

![La recette pour créer des volumes fantômes](/images/2017/02/docker_volumes.png)

Dans cet exemple, nous avons défini que le dossier `/data` du container serait un volume. Puis, dans le fichier `docker-compose.yml` nous définissons l'utilisation d'un volume sur le dossier `/data/app`. Or, le dossier que nous utilisons comme un volume dans le container *n'est pas celui qui a été défini dans le Dockerfile*.

Voici ce qui va se passer lors du démarrage du container. Docker va effectivement monter le dossier `/data/app` de l'hôte sur le dossier `/data/app` du container, comme attendu. Par contre, il va également créer un volume dans le dossier `/var/lib/docker/volumes`, il va ensuite copier le contenu du dossier `/data` du container dans ce nouveau volume et le monter.

Le container fonctionnera comme attendu, mais si dans votre image, le dossier `/data` contient - beaucoup - de données, ces dernières seront copiées dans un nouveau volume "fantôme" à chaque fois que vous démarrerez un nouveau container de cette manière. En plus de vous pénaliser en terme d'occupation d'espace disque, ceci peut également ralentir le démarrage des container à cause de la copie des données entre le container et le volume "fantôme".

## Solutionner le problème

La solution à ce problème est simple, il suffit de valider que chaque volume définit dans vos Dockerfile est bien utilisé ensuite lorsque vous démarrez vos containers - que ce soit avec `docker-compose` ou toute autre méthode.

Vous pouvez également purger les volumes "fantômes" présents sur votre hôtes en utilisant le petit script ci-dessous. Ceci vous permettra de purger les volumes et de gagner de l'espace disque. Vous pouvez le plannifier afin de purger régulièrement les volumes "fantômes" jusqu'à ce que tous vos Dockerfile soient corrigés.

    #!/bin/bash
    for vol in $(docker volume ls | awk '{print $2}' | grep -v VOLUME)
    do
      docker volume rm $vol
    done

L'utilisation de ce script n'est pas dangereuse pour les containers car la commande `docker volume rm` ne supprimera des volumes en cours d'utilisation par des containers.
