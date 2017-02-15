+++
title = "IP Failover avec uCARP"
categories = ["Centos","FailOver IP","Linux","Trucs et Astuces"]
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
date = 2015-04-07T11:22:33Z
author = "MrRaph_"
tags = ["Centos","FailOver IP","Linux","Trucs et Astuces"]
slug = "ip-failover-avec-ucarp"
draft = false

+++


Comme je l’ai fait avec KeepAlived (voir [IP Failover avec KeepAlived](https://techan.fr/ip-failover-avec-keepalived/)), j’ai voulu tester le FailOver IP avec uCarp.  [uCarp](http://www.pureftpd.org/project/ucarp) est le portage sur Linux de Carp – *Common Address Redundancy Protocol –* disponible sur OpenBSD.

Vous allez le voir, son implémentation est encore plus simple que celle de KeepAlived, qui n’était déjà pas très complexe … Il suffit en effet de configurer une interface virtuelle sur les nœuds du cluster qui doivent monter l’IP virtuelle puis de renseigner le nom de cette interface dans le fichier de configuration d’uCarp.


## Ajouter une interface virtuelle

    # vi /etc/sysconfig/network-scripts/ifcfg-eth0:0
    DEVICE=eth0:0
    BOOTPRO=none
    ONBOOT=no
    IPADDR=172.16.17.87
    NETMASK=255.255.255.0
    IPV6INIT=no

Faire de même sur les autres nœuds du cluster uCarp.


## Installation et configuration d’uCarp

Tout d’abord on installe les paquets nécessaires, j’ajoute Apache pour faire des tests.

    # yum install ucarp httpd.x86_64

On duplique l’exemple de configuration.

    # cp /etc/sysconfig/carp/vip-001.conf.example /etc/sysconfig/carp/vip-001.conf

On renseigne la configuration avec les informations nécessaires, le nom de l’interface sur laquelle monter l’IP virtuelle – *eth0 dans mon cas* – le nom de l’interface VIP que l’on vient de créer – *eth0:0* – et un mot de passe à votre discrétion.

    vi /etc/sysconfig/carp/vip-001.conf
    # Configuration de CARP
    #172.16.17.87 ha-0-extappdev vip
    #172.16.17.85 sl-0-extappdev1.domain.fr
    #172.16.17.86 sl-0-extappdev2.domain.fr
    #
    #
    # Nom de l'interface ou accrocher la VIP
    BIND_INTERFACE="eth0"
    # Nom de l'interface virtuel. Voir le fichier /etc/sysconfig/network-scripts/ifcfg-eth0:0
    # Attention : forcer bootpro=none
    VIP_INTERFACE="eth0:0"
    # Mot de passe du cluster: le mot de passe doit être identique pour tous les noeud du cluster.
    PASSWORD="password"

Il faut ensuite copier ce fichier sur tous les nœuds du cluster utilisant uCarp.

#### Petite correction de bug

Le paquet pour CentOS 6 est buggé, rassurez-vous, rien de bien grave, il suffit de corriger une ligne du fichier d’init d’uCarp. [Un bug est référencé à ce sujet](%20http://bugs.centos.org/view.php?id=6651).

    # vi /etc/init.d/carp

Remplacer la lige 55 comme suit :

    #BIND_ADDRESS="`ifconfig ${BIND_INTERFACE} | sed -n 's/.*inet addr:\([^ ]*\) .*/\1/p' | head -n 1`"
    BIND_ADDRESS="`ifconfig ${BIND_INTERFACE} | sed -n 's/.*inet adr:\([^ ]*\) .*/\1/p' | head -n 1`"


##  Et on est bon !

Il ne reste plus qu’a démarrer uCarp.

    # service carp start
    Démarrage de démon du protocole de redondance d'adresses co[ OK ]
    # chkconfig --level 2345 carp on

[Les mêmes tests que pour KeepAlived](https://techan.fr/ip-failover-avec-keepalived/) peuvent être joués pour valider que l’IP bascule bien.
