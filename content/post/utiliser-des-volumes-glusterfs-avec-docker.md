+++
slug = "utiliser-des-volumes-glusterfs-avec-docker"
title = "Utiliser des volumes GlusterFS avec Docker"
date = 2016-11-11T15:33:00Z
author = "MrRaph_"
categories = ["Docker","Trucs et Astuces","GlusterFS"]
tags = ["Docker","Trucs et Astuces","GlusterFS"]
image = "/images/2016/11/gluster_et_docker.png"
description = ""
draft = false

+++

L'un des grands défis avec Docker est de gérer la perstistance des données. Dans une grande majorité des cas, le plus simple est de présenter aux containers des fichiers/dossiers stockés directement sur l'hôte. Cette solution présente plusieurs incovénients, dans le cas ou l'on a un cluster d'hôtes Docker, il faut mettre en place des mécanismes pour répliquer ces dossiers, ou utiliser un stockage partagé. Un autre incovénient est qu'il faut être sûr que sur chacun de nos hôtes, les chemins vers ces fichiers/dossiers soient les mêmes sinon, les containers ne retrouveront pas leurs données.

Pour ma part, j'ai testé GlusterFS afin "synchroniser" les données de mes containers. Dans un premier temps, je l'ai utilisé basiquement, j'ai créé un seul gros volume qui contenait les données de tous mes containers et l'ai monté au même endroit sur chacun de mes hôtes. Ainsi les containers accédaient à leurs données via le montage du GlusterFS réalisé sur l'hôte.

J'ai récement testé une méthod plus satisfaisante intellectuellement. J'ai installé et utilisé un plugin Docker pour GlusterFS. Maintenant je créer des volumes GlusterFS pour mes containers et je configure mes containers pour qu'ils utilisent directement ce volume GlusterFS sans avoir à le monter sur l'hôte. 

Je vais vous détailler comment j'ai mis en place ce plugin.

# Mise en garde

Dans cet article, je pars du principe que vous votre GlusterFS est déjà opérationnel et que vous savez l'administrer - créer des volumes, ...

Il m'a semblé que le plugin [docker-volume-glusterfs](https://github.com/calavera/docker-volume-glusterfs) mis en avant sur [la page de documentation sur le site de Docker](https://docs.docker.com/engine/extend/legacy_plugins/) n'est plus maintenu, j'ai donc pris le parti d'utiliser [un fork de ce projet](https://github.com/amarkwalder/docker-volume-glusterfs).

# Installation du driver pour Docker

Tout d'abord, nous devons installer quelques prérequis sur nos machines Docker.

    # apt install golang gccgo mercurial

Nous allons configurer deux variables d'environnement pour Go et les sourcer pour quelles soient prises en compte.

    # echo 'export GOPATH=$HOME/go
    PATH=$PATH:$HOME/.local/bin:$HOME/bin:$GOPATH/bin' >> ~/.bashrc
    # source ~/.bashrc

On installe le plugin depuis le repository GitHub.

    # go get github.com/amarkwalder/docker-volume-glusterfs

Et on créer les fichiers nécessaires - `/etc/systemd/system/docker-volume-glusterfs.service` et `/etc/default/docker-volume-glusterfs` - pour que Systemd puisse gérer ce plugin. Ces deux fichiers doivent avoir le contenu suivant :


    # cat /etc/systemd/system/docker-volume-glusterfs.service
    [Unit]
    Description=Docker Volume GlusterFS
    Requires=network-online.target
    After=network-online.target
    
    [Service]
    EnvironmentFile=-/etc/default/docker-volume-glusterfs
    Restart=on-failure
    ExecStart=/root/go/bin/docker-volume-glusterfs -servers ${GLUSTERFS_SERVERS}
    ExecReload=/bin/kill -HUP $MAINPID
    KillSignal=SIGINT
    
    [Install]
    WantedBy=multi-user.target

Et :

    # cat /etc/default/docker-volume-glusterfs
    GLUSTERFS_SERVERS=ip-server1:ip-server2:ip-server3:...

On active active la nouvelle configuration et on lance le service :

    # systemctl daemon-reload
    # systemctl start docker-volume-glusterfs

Nous sommes maintenant parés pour utiliser des volumes GlusterFS avec nos containers Docker !

# Utiliser le drivers avec des containers

Je pars du principe que vous avez déjà créé les volumes nécessaires - dans l'exemple suivant le volume utilisé s'appelle `openvpn`.

Je vais reprendre l'exemple que j'avais déjà donné sur [l'utilisation d'OpenVPN dans des containers Docker](https://techan.fr/protegez-votre-vie-privee-avec-openvpn-sur-docker/).

Dans un premier temps, nous allons ajouter une variable d'environnement dans notre fichier `~/.bashrc` afin de ne pas avoir à se rappeler du nom du volume par la suite. ==Le nom configuré dans cette variable doit être le nom du volume créé dans GlusterFS pour cet effet !==

    # echo 'export OVPN_DATA=openvpn' >> ~/.bashrc
    # source ~/.bashrc

Nous lançons ensuite la configuration du serveur OpenVPN avec les deux commandes qui suivent.

    # docker run --volume-driver glusterfs --volume $OVPN_DATA:/etc/openvpn --rm kylemanna/openvpn ovpn_genconfig -u udp://VPN.SERVERNAME.COM
    # docker run -v $OVPN_DATA:/etc/openvpn --rm -it kylemanna/openvpn ovpn_initpki

Si nous regardons dans Docker ce qui s'est passé, on peut voir qu'un tout nouveau volume de type `glusterfs` a été ajouté !


    # docker volume ls
    DRIVER              VOLUME NAME
    glusterfs           openvpn

Il ne reste plus qu'à créer un fichier `docker-compose.yml` comme suit pour démarrer notre serveur OpenVPN qui utilisera ce volume.

    version: '2'

    services:
      vpn:
        image: kylemanna/openvpn
        ports:
          - "1194:1194"
          - "1194:1194/udp"
        volumes:
          - openvpn:/etc/openvpn
        restart: always
        cap_add:
          - NET_ADMIN
        network_mode: "host"

    volumes:
      openvpn:
        external: true

Dans la partie `volumes` du service, on dit à docker-compose d'utiliser un volume nommé `openvpn`. Puis dans la section `volumes` à la fin du fichier, on lui explique qu'il ne devra pas le créer lui même mais utiliser le volume nommé `openvpn` qui existe déjà sur l'hôte. Nous avons vu que Docker l'a créé lorsque nous avons lancé nos commandes pour configurer le serveur OpenVPN.

On peut aller vérfier que Docker écrit bien dans ce volume GlusterFS en le montant sur l'hôte.

    # mount -t glusterfs ip-server1:/openvpn /mnt
    # ls -lrt /mnt
    total 6
    drwxr-xr-x  6 root root  102 Nov  9 07:59 ./
    drwxr-xr-x 27 root root 4096 Nov  9 08:16 ../
    drwxr-xr-x  2 root root    6 Nov  9 07:58 ccd/
    -rw-r--r--  1 root root  637 Nov  9 07:58 openvpn.conf
    -rw-r--r--  1 root root  587 Nov  9 07:58 ovpn_env.sh
    drwx------  6 root root  242 Nov  9 08:25 pki/
    drwxr-xr-x  3 root root   25 Nov  9 07:49 .trashcan/

Et voilà ! :)