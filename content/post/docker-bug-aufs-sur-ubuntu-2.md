+++
title = "Docker sur Ubuntu et le vilain bug AUFS"
date = 2016-07-28T12:32:54Z
author = "MrRaph_"
categories = ["Docker","AUFS","bug","Ubuntu"]
tags = ["Docker","AUFS","bug","Ubuntu"]
description = ""
slug = "docker-bug-aufs-sur-ubuntu-2"
draft = false

+++

#Le méchant bug ...

Cela fait déjà quelques fois que je rencontre un bug très pénalisant qui impacte Docker sur Ubuntu. Voici ses symptômes : vous avez un container qui tourne, vous souhaitez l'arrêter mais la commande nous vous rend jamais la main, ou elle vous la rend mais le container ne s'arrête jamais. Il est probable qu'un des processus de ce container consomme 100% de CPU sur la machine. Ce processus ne semble par ailleurs plus relié à aucun autre processus - ses ancètres sont morts.


![Docker planté](/content/images/2016/07/docker_plante.jpg)

Dans ce cas là, votre machine ne veut plus rien comprendre et vous serez obligé de la redémarrer avec un "hard reboot".


## Uniquement sur Ubuntu ?

Ce phénomène semble ne se produire que sur un hôte Ubuntu et serait lié à un [bug](https://bugs.launchpad.net/ubuntu/+source/linux/+bug/1533043) dans l'[AUFS](https://fr.wikipedia.org/wiki/Aufs) - [Another Union File System Tutorial](https://fr.wikipedia.org/wiki/Aufs). AUFS est un des drivers de stockage supporté par Docker - par défaut sur Ubuntu - qui permet de fusionner les différents calques d'une image ou d'un container.


Voici une méthode - donnée dans le [ticket ouvert chez Ubuntu](https://bugs.launchpad.net/ubuntu/+source/linux/+bug/1533043) - pour identifier si un hôte est touché par ce bug :

Il suffit de lancer la commande suivante sur l'hôte :
**ATTENTION : Si l'hôte est touché, il deviendra instable et devra être "hard rebooté", utilisez ceci avec précaution ! ;-)**


    docker run -it --rm akihirosuda/test18180

# La solution !

Il m'a fallut un certain temps pour identifier le bug la première fois, d'autant plus qu'il est train pénalisant. La bonne nouvelle c'est qu'il suffit de mettre à jour le noyau de l'Ubuntu et de redémarrer dessus pour être tranquile !


Voici les version du noyau Ubuntu à partir desquelles le bug à été résolu :

    3.13.0-78
    3.16.0-61
    3.19.0-50
    4.2.0-28

Si votre Ubuntu à un noyau plus récent, vous ne devriez pas être sujet à ce bug ! :-)

###Sources :
* [bugs.launchpad.net](https://bugs.launchpad.net/ubuntu/+source/linux/+bug/1533043) (Anglais)
* [github.com/docker - Bug 1533043](https://github.com/docker/docker/issues/18758) (Anglais)
* [github.com/docker - Bug 18180](https://github.com/docker/docker/issues/18180#issuecomment-170267519) (Anglais)