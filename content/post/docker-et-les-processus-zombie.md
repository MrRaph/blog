+++
slug = "docker-et-les-processus-zombie"
draft = false
title = "Docker et les processus Zombie"
date = 2016-06-20T07:53:12Z
author = "MrRaph_"
categories = ["Docker","Processus Zombie","PID 1","bug","Trucs et Astuces"]
tags = ["Docker","Processus Zombie","PID 1","bug","Trucs et Astuces"]
description = ""

+++

# Introduction

Docker est un outil permettant d'exécuter des processus de manière completèment isolée et indépendement du système d'exploitation. Cette technologie de plus en plus utilisée car elle permet par exemple de faire tourner sur un même hôte deux applications Java utilisant des JVM différentes sans avoir à installer ces JVM sur l'hôtes - cela évite donc pas mal de casse tête. Docker permet également de déployer une application de manière strictement identique sur plusieurs machines. Ce mécanisme facilite grandement la monté en charge d'une application.

Docker est une technologie récente mais qui monte, qui monte très vite. Il y a cependant quelques pièges à connaître et à éviter impérativement. C'est le cas du fameux problème des processus zombie créés par Docker.

# Le problème


Dans le monde UNIX, les processus sont organisés dans un arbre, chaque processus à son identifiant - PID - et l'identifiant de son père - PPID - ceci permet de créer l'arbre. Le seul processus à ne pas avoir de père est le processus au PID 1 - que l'on appelle "init". Ce dernier est le père de tous les autres processus, c'est la racine de notre arbre. C'est l'"init" qui démarre tous les autres processus de la machine qui eux mêmes pourront ensuite créer des fils.

![Unix process hierarchy](https://blog.phusion.nl/wp-content/uploads/2015/01/Unix-process-hierarchy.png)


Maintenant, qu'arriverait-il si un de ces prossus se terminait de façon inattendue ? Prennont l'exemple du processu "bash" - PID 5 - il devient alors une processus "DEFUNCT", aussi appelé "Zombie".


![Zombie 1](https://blog.phusion.nl/wp-content/uploads/2015/01/zombie.png)

Le père de notre processus "bash" est maintenant sensé "attendre" son fil - "wait" - afin de récupérer son code retour. Tant que le père d'un processus n'a pas collecté ce code retour, le zombie reste présent. Le père doit pour ce faire, utiliser l'appel système "waitpid()". Cette opération spécifique s'appelle le "reaping", la plupart des applications font cela très bien.



![Reaping](https://blog.phusion.nl/wp-content/uploads/2015/01/reaping.png)


Dans notre exemple, si "bash" se termine, le système d'exploitation va envoyer un signal "SIGHLD" au processus "sshd" pour qu'il se réveille et qu'il "reap" son fils disparu.


Il y a cependant un cas spécial, si un processus parent de processus fils se termine soit intentionnellement soit à cause d'un kill. Qu'arrive-t'il à ses enfants ? Ils deviennent alors "orphaned" - orphelins (c'est le terme technique).

C'est à ce moment là qu'"init" va refaire parler de lui. Considérons l'exemple ci-dessous, "init" démarre "nginx" qui lui même crée un fils. Lorsque "nginx" se termine, son fils - PID 16 - n'a plus de père et est donc considéré comme "orphaned". Comme un processus ne peux pas rester dans la nature comme cela, "init" va l'adopter. "init" est désormais le père de notre processus "nginx" au PID 16.


![Adoption](https://blog.phusion.nl/wp-content/uploads/2015/01/adoption.png)

Maintenant "init" à la responsabilité de "reap"er ce processus adopté et ainsi de nettoyer le système. C'est une responsabilité très important dans un système UNIX, cela garanti que le système reste sain. Quasiment tous les daemons s'attendent à ce que leurs enfants soient ainsi nettoyés par "init". Ceci est également vrai pour la très grande majorité des processus du monde UNIX.


# Le rapport avec Docker

Dans l'image ci-dessous, on peut voir un processus "php-fpm" orphelin, il a perdu son père et son grand-père. En général, les processus zombie ne consomment pas de mémoire ni de CPU, ce qui est le cas des ancètres de notre processus "php-fpm" par contre lui consomme 100% des ressources CPU de notre machine. Il est donc primordial de pouvoir éviter que ce processus puissent être de nouveau orphelin.

![PHP Zombie dans Docker](https://techan.fr/content/images/2016/06/docker_zombie_php_process.jpg)

## Falshback !

Comment en étons arrivé à ce point là ? Le processus "php-fpm" à été lancé par [s6](http://skarnet.org/software/s6/) - un équivalent supervisor ou upstart - ce dernier a lui même été lancé par un script shell. Comme "php-pfm" ne répondait plus, nous avons essayé de terminer le container - avec la commande `docker stop <container name>` - sans succès, nous avons donc tué le container - avec la commande `docker kill <container name>`. Le script shell a bien été terminé, [s6](http://skarnet.org/software/s6/) également, mais "php-fpm" n'a jamais rendu l'âme, ce processus devient un zombie - comme l'indique htop avec un "Z" dans la colonne "S". Personne n'a adopé ce processus pour le tuer et le nettoyer correctement.

# Ajouter un mini "init" dans les images Docker

Vous devez maintenant comprendre l'intérêt d'"init", il est donc primordial de disposer d'un tel système dans un environnement Docker. La meilleur solution serait que Docker embarque nativement une sorte d'"init" qui adopte et qui "reap" les processus. Mais comme cela ne semble pas au programme, il va falloir en ajouter nous même à nos images.

Pour ce faire, [Phusion](https://blog.phusion.nl) à développer un [script en Python - my_init](https://github.com/phusion/baseimage-docker/blob/rel-0.9.16/image/bin/my_init). Voici les principales fonctionnalités de ce script :

* Il "reap" les processus adoptés.
* Il lance les sous processus
* Il attend que tous les sous processus soient terminés avant de se terminer lui même - avec un timeout maximum.
* Il log son activité dans les logs Docker : `docker logs`

Ce script est inclus - en plus d'autres correctifs - dans l'excellente image [phusion/baseimage](https://hub.docker.com/r/phusion/baseimage/)


# Conclusion

Le problème des processus zombie ainsi que le fonctionnement du "reaping" et de l'adoption de processus orphelins sont à connaître, il est possible d'éviter les problèmes en utilisant la très bonne image [phusion/baseimage](https://hub.docker.com/r/phusion/baseimage/) ou en s'en inspirant en créant votre propre image de base.

# Sources
* [Wikipedia : Zombie processes (Anglais)](https://en.wikipedia.org/wiki/Zombie_process)
* [Phusion : Docker and the PID 1 zombie reaping problem (Anglais)](https://blog.phusion.nl/2015/01/20/docker-and-the-pid-1-zombie-reaping-problem/)

* Crédit images : [blog.phusion.nl](https://blog.phusion.nl)