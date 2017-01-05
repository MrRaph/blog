+++
date = 2015-10-27T11:19:39Z
categories = ["Docker","Dovecot","Indexation full text","introduction a docker avec l indexation full text des mails","Solr","Trucs et Astuces"]
image = "https://techan.fr/images/2015/10/Docker_container_engine_logo.png"
description = ""
draft = false
title = "Introduction à Docker avec l'indexation full text des mails"
slug = "introduction-a-docker-avec-lindexation-full-text-des-mails"
author = "MrRaph_"
tags = ["Docker","Dovecot","Indexation full text","introduction a docker avec l indexation full text des mails","Solr","Trucs et Astuces"]

+++


Au début de l’année j’expliquais comment configurer Solr et Dovecot pour ajouter l’indexation full text des mails (voir [Indexation full text des mails](https://techan.fr/indexation-full-text-des-mails/)). A l’époque, la manipulation était plutôt lourde, Solr est puissant mais assez capricieux lors de sa mise en place. Aujourd’hui, je vais présenter Docker et la façon dont cet outil va vous faciliter la vie !

Commençons tout d’abord par une petite présentation de Docker. Il ne s’agit pas de virtualisation ! Cet outil utilise un mécanisme offert par les normes de programmation. Depuis quelques temps, tous les noyaux Linux respectent les même interfaces, le code les implémentant diverge ensuite en fonction de la distribution. Cependant, pour faire simple, les différentes méthodes implémentée répondent à la même définition sur toutes les implémentations. Docker se sert de ce principe, ainsi il est possible de faire fonctionner un **container** comme CentOS sur un hôte installé avec Ubuntu par exemple.

Un **container**  !?! Qu’est ce que c’est que cette bête là ??? Docker se base sur des **images** pour fonctionner, une image est une installation – de base ou non – d’un système. Il existe des images de Debian, d’Ubutnu, de CentOS, d’Oracle Linux, enfin de tout ce que l’on peut imaginer. Une image peut également être une version modifiée de ces images de base. Par exemple celle que je vais proposer plus bas est une image Ubuntu à dans laquelle j’ai installé Java et Solr. Cool non ? Un **container** est instanciation d’une image. Je démarre une image, j’ai un container, je démarre une deuxième image, j’ai deux containers. Ces containers sont isolés du système de base et isolés entre eux, chacun à sa « vie » propre.

Docker permet donc d’installer des choses sur Linux sans pour autant « polluer » le système de base. Dans mon exemple, on peut installer Solr sans avoir besoin d’installer Java sur la machine hôte. On peut également faire tourner des applications très récentes sur une machine un peu ancienne sans avoir besoin de mettre à jour les librairies de cette ancienne machine. D’autre part, Docker permet d’automatiser beaucoup de choses, mais nous verrons cela dans un prochain article.

Revenons à nos moutons. Voyons comment installer Solr via Docker !

 


## Installation de Docker

Voici comment installer la dernière version de Docker sur Ubuntu. Je vous conseille d’installer Docker depuis leur propre dépôt, plutôt que d’utiliser la version d’Ubuntu. Vous bénéficierez ainsi d’une version bien plus récente.

En tant que root, lancez les commandes suivantes :

`apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D vi /etc/apt/sources.list.d/docker.list`

Dans le fichier, ajoutez le contenu suivant, si le fichier n’est pas vide, remplacez son contenu avec ce qui suit.

    # Ubuntu Precise 14.04 deb https://apt.dockerproject.org/repo ubuntu-precise main
    # Ubuntu Trusty 14.10 deb https://apt.dockerproject.org/repo ubuntu-trusty main
    # Ubuntu Vivid 15.04 deb https://apt.dockerproject.org/repo ubuntu-vivid main
    # Ubuntu Wily 15.10 deb https://apt.dockerproject.org/repo ubuntu-wily main

Décommentez les lignes qui ne correspondent pas à la version d’Ubuntu que vous utilisez. Passez ensuite les commandes suivantes toujours en root.

    apt-get update
    apt-get purge lxc-docker*
    apt-cache policy docker-engine
    apt-get install docker-engine

Lorsque tout est installé, vérifiez que tout fonctionne en lançant la commande qui suit.

`docker run hello-world`

La sortie de la commande devrait être comme ceci.

    Unable to find image 'hello-world:latest' locally
    latest: Pulling from library/hello-world b901d36b6f2f:
    Pull complete 0a6ba66e537a:
    Pull complete Digest: sha256:517f03be3f8169d84711c9ffb2b3235a4d27c1eb4ad147f6248c8040adb93113 
    Status: Downloaded newer image for hello-world:latest
    Hello from Docker. This message shows that your installation appears to be working correctly. To generate this message, Docker took the following steps: 1. The Docker client contacted the Docker daemon. 2. The Docker daemon pulled the "hello-world" image from the Docker Hub. 3. The Docker daemon created a new container from that image which runs the executable that produces the output you are currently reading. 4. The Docker daemon streamed that output to the Docker client, which sent it to your terminal. To try something more ambitious, you can run an Ubuntu container with: $ docker run -it ubuntu bash Share images, automate workflows, and more with a free Docker Hub account: https://hub.docker.com For more examples and ideas, visit: https://docs.docker.com/userguide/

 

Si c’est le cas, tout est bon ! Vous pouvez maintenant utiliser Docker !

 

#### Configuration supplémentaire si vous utilisez UFW

Éditez le fichier suivant.

`vi /etc/default/ufw`

 

Trouvez la ligne :
`
DEFAULT_FORWARD_POLICY="DROP"`

Modifiez la comme suit :
`
DEFAULT_FORWARD_POLICY="ACCEPT"`

Sauvez le fichier et passez ensuite les deux commandes :

`ufw reload ufw allow 2375/tcp`

 

 


## Solr dans Docker

Votre serviteur a créer une image spéciale basée sur Ubuntu, cette image embarque Java et Solr (4.10.4) et la configuration de Solr pour qu’il fonctionne avec Dovecot. En gros, l’image embarque tout ce qui touchait à Solr dans [mon article de Janvier](https://techan.fr/indexation-full-text-des-mails/). Dans un premier temps, nous allons récupérer l’image et voir comment tout cela fonctionne, ensuite nous brancherons Dovecot sur le Solr embarqué.

 

#### Jouons avec Docker

La première étape est de récupérer l’archive, il n’y a rien de plus simple.

`docker pull mrraph/docker-solr_dovecot`

Cette commande télécharge tous les éléments nécessaires au fonctionnement de l’image.

[![Introduction à Docker avec l'indexation full text des mails](https://techan.fr/images/2015/10/screenshot.998.jpg)](https://techan.fr/images/2015/10/screenshot.998.jpg)

Lorsque le téléchargement est terminé, vous pouvez lister les images que votre Docker possède en utilisant la commande suivante.

`docker images`

[![Introduction à Docker avec l'indexation full text des mails](https://techan.fr/images/2015/10/screenshot.999.jpg)](https://techan.fr/images/2015/10/screenshot.999.jpg)

Génial, on a téléchargé l’image, maintenant démarrons la !

`docker run -p 8983:8983 -d mrraph/docker-solr_dovecot`

Voici quelques explications sur les options utilisées :

- -p 8983:8983 - Cette option permet de rediriger le port 8983  du container sur le port 8983 de l’hôte.
- -d - Cette option permet de lancer le container comme un daemon, il va tourner en arrière plan comme un grand.

Pour vérifier que tout fonctionne bien, rendez-vous à l’adresse suivante : **http://<ip de l’hote>:8983/solr**.

 

[![Introduction à Docker avec l'indexation full text des mails](https://techan.fr/images/2015/10/screenshot.1000.jpg)](https://techan.fr/images/2015/10/screenshot.1000.jpg)

<span style="text-decoration: underline;">**Note :**</span> Si vous utilisez Ubuntu 15.10, il y a un bug avec le réseau dans Docker, il suffit de redémarrer le daemon docker – ***service docker restart*** – et de relancer le container.

 

Et voilà, vous avez lancé Solr dans un container Docker ! Cool non ? Bon maintenant, ce n’est pas très sécurisé ainsi car n’importe qui pourrait accéder à l’interface Web et effacer vos index … De plus l’adresse IP des containers change à chaque lancement, il n’y a pas de moyen direct pour donner une IP fixe à un container dans Docker … Rassurez vous, il y a une solution, je vous la donne tout de suite !

 

#### Lancer Solr de manière sécurisée et avec une IP fixe

J’ai adapté un script permettant de fixer l’adresse IP d’un container, [il se trouve dans GitHub](https://github.com/Branlala/Docker-Solr_Dovecot/blob/master/solr_satic_ip.sh). Enregistrez ce script quelque part sur votre système, dans /root/bin par exemple.

 

`cd /root/bin chmod +x solr_satic_ip.sh`

 

Adaptez les valeurs des variables en haut du script, en portant une attention particulière aux deux dernières.

`# docker & network settings
DOCKER_IMAGE_NAME="mrraph/docker-solr_dovecot" DOCKER_CONTAINERS_NAME="solr_dovecot_bridged" DOCKER_NETWORK_INTERFACE_NAME="em1:1" DOCKER_NETWORK_INTERFACE_IP="10.0.0.1"`

 

Dans mon cas, l’interface Ethernet de mon serveur se nomme **em1**, on va donc créer une interface virtuelle nommée **em1:1**. Si votre interface s’appelle **eth0**, nommez l’interface virtuelle **eth0:1**, ou **eth0:2** si  **eth0:1** est déjà prise.

Concernant l’IP de l’interface virtuelle, il faut simplement vérifier qu’elle n’est pas déjà prise sur le système.

 

Lorsque le script est configuré, il n’y a plus qu’a le lancer !

`# ./solr_static_ip.sh ebcf93133424ea22a4c1eab5a4e8e6190677d1e09cc406000529747be607812f`

La chaine que le script écrit est l’identifiant du container démarré, on peut voir les containers en cours d’exécution avec la commande suivante.

`# docker ps CONTAINER ID IMAGE COMMAND CREATED STATUS PORTS NAMES ebcf93133424 mrraph/docker-solr_dovecot:latest "/bin/bash -c 'cd /o About a minute ago Up About a minute 10.0.0.1:8983->8983/tcp solr_dovecot_bridged`

Voilà, Solr fonctionne et est rattaché à une IP fixe, il n’y a plus qu’à configurer Dovecot !

 

#### Configurer Dovecot pour utiliser notre container Solr

On installer le paquet qui va bien.

`apt-get install dovecot-solr`

On édite ensuite le fichier de configuration /etc/dovecot/conf.d/90-plugin.conf.

`vi /etc/dovecot/conf.d/90-plugin.conf`

On ajoute les lignes suivantes à la fin de ce fichier.

`mail_plugins = $mail_plugins fts fts_solr plugin { fts = solr fts_solr = url=http://10.0.0.1:8983/solr/ break-imap-search fts_autoindex = yes }`

Et on redémarre Dovecot !

`service dovecot restart`
 

Vous pouvez forcer l’indexation des mails d’un utilisateur avec les commandes :

`# doveadm fts rescan -u <user> # doveadm index -u <user> '*'`

 


