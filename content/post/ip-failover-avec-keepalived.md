+++
categories = ["Centos","FailOver IP","ip failover avec keepalived","Linux","Trucs et Astuces"]
tags = ["Centos","FailOver IP","ip failover avec keepalived","Linux","Trucs et Astuces"]
description = ""
title = "IP Failover avec KeepAlived"
date = 2015-03-27T09:18:15Z
author = "MrRaph_"
image = "https://techan.fr/images/2014/11/Linux.png"
slug = "ip-failover-avec-keepalived"
draft = false

+++


Je vais expliquer ici comme faire du failover IP sur Centos / RedHat en utilisant [KeepAlived](http://www.keepalived.org/index.html). Même si cet outil peut faire bien plus, je n’utilise que cette fonctionnalité déjà très pratique et très facile à mettre en place !

[![refonte_DMZ](https://techan.fr/images/2015/03/refonte_DMZ.png)](https://techan.fr/images/2015/03/refonte_DMZ.png)

Voici donc l’infrastructure cible. Deux serveurs avec chacun une IP et une vIP qui passera d’un serveur à l’autre (172.16.17.83). C’est KeepAlived qui va s’occuper de vérifier lequel des serveurs doit avoir la vIP et la remonter sur une serveur si celui qui la possède n’est plus disponible.


## Installation de KeepAlived

    yum -y install keepalived chkconfig --add keepalived chkconfig --level 2345 keepalived on cp /etc/keepalived/keepalived.conf{,.ori}

Ce n’est pas plus compliqué que ça, on en profite pour faire un backup du fichier de configuration original.


## Configuration de KeepAlived

 

    vi /etc/keepalived/keepalived.conf

Voici le fichier de configuration type pour du failover IP.

    ! Configuration File for keepalived
    global_defs {
      notification_email { acassen@firewall.loc failover@firewall.loc sysadmin@firewall.loc }
      notification_email_from Alexandre.Cassen@firewall.loc
      smtp_server 127.0.0.1
      smtp_connect_timeout 30
      router_id LVS_DEVEL
    }
    vrrp_instance VI_1 {
       state MASTER
       interface eth0
       virtual_router_id 51
       priority 100
       advert_int 1
       authentication {
          auth_type PASS
          auth_pass 1111
       }
       virtual_ipaddress { 172.16.17.83/24 dev eth0 }
     }

Les deux seuls modifications a faire sont :

- Modifier la « virtual_ipaddress » et l’interface sur laquelle elle va être bindée
- Adapter la « priority » en mettant 101 sur le serveur maître et 100 sur le serveur backup.

On redémarre KeepAlived.

    service keepalived restart
    Arrêt de keepalived : [ OK ]
    Démarrage de keepalived : [ OK ]

Et on vérifie sur le serveur maître que la vIP est bien montée.

    # ip addr show
    eth0 2: eth0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc pfifo_fast state UP qlen 1000 link/ether 00:50:56:a0:29:8f brd ff:ff:ff:ff:ff:ff inet 172.16.17.82/24 brd 172.16.17.255 scope global eth0 inet 172.16.17.83/24 scope global secondary eth0 inet6 fe80::250:56ff:fea0:298f/64 scope link valid_lft forever preferred_lft forever

Et voilà !

 

 
