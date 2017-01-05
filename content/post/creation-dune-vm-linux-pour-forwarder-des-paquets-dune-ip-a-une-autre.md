+++
categories = ["forwarding","iptables","Linux","réseau"]
slug = "creation-dune-vm-linux-pour-forwarder-des-paquets-dune-ip-a-une-autre"
draft = false
title = "Création d'une VM Linux pour forwarder des paquets d'une IP à une autre"
author = "MrRaph_"
tags = ["forwarding","iptables","Linux","réseau"]
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
date = 2014-09-23T11:00:43Z

+++


Dans le cadre d’un test de PCA, j’ai du créé une VM Linux qui fait du forward de paquets d’une IP vers une autre car nous ne disposions plus des ressources physique du site principal, notamment certain Domain Controler avec le rôle de DNS.

 

Cette VM avait donc pour but d’intercepter les paquets qui était envoyé sur le réseau a destination des ressources inaccessibles et de les transférer vers une autre machine capable de traiter les demandes (un autre DC).

/p>

<span style="text-decoration: underline;"><span style="color: #ff0000;">**Attention !**</span></span>

Cette manipulation est dangereuse sur un système de production !

Cette VM devra disposer d’une adresse IP qui lui ai propre afin de pouvoir facilement l’administrer et d’une carte réseau supplémentaire par adresse IP source a forwarder.

### Configuration IP

L’adresse IP propre à cette VM sera 192.168.0.200

[root@vm-forward ~]# cat /etc/sysconfig/network-scripts/ifcfg-eth0 DEVICE=eth0 ONBOOT=yes TYPE=ETHERNET BOOTPRO=static IPADDR=192.168.0.200 NETMASK=255.255.255.0 GATEWAY=192.168.0.1 DNS1=192.168.0.2 DNS2=192.168.0.3 DNS3=192.168.0.4 IPV6INIT=no USERCTL=no

L’adresse IP a intercepter sera 192.168.0.4, un des serveurs DNS de la VM.

[root@vm-forward ~]# cat /etc/sysconfig/network-scripts/ifcfg-eth1 DEVICE=eth1 ONBOOT=yes TYPE=ETHERNET BOOTPRO=static IPADDR=192.168.0.4 NETMASK=255.255.255.0 GATEWAY=192.168.0.1 DNS1=192.168.0.2 DNS2=192.168.0.3 DNS3=192.168.0.4 IPV6INIT=no USERCTL=no

 

### Configuration dans le fichier sysctl.conf

Afin que le Linux puisse faire du fowrd, il faut activer l’option dans le fichier /etc/sysctl.conf

[root@vm-forward ~]# cat /etc/sysctl.conf | grep forward # Controls IP PAcket forwarding net.ipv4.ip_forward = 1

Pour que cette option soit prise en compte, rebootez le système ou exécuter :

sysctl -p

 

### Activation d’IPtables au démarrage du système

[root@vm-forward ~]# chkconfig --level 2345 iptables on

 

### Configuration d’IPtables

Dans IPtables, on va ajouter des règles de NAT et un règle Filter pour autoriser le forward.

 

[root@vm-forward ~]# cat /etc/sysconfig/iptables ##Les regles de routage NAT ## A AJOUTER AU DEBUT DU FICHIER, APRES LES COMMENTAIRES *nat :PREROUTING ACCEPT [0:0] :POSTROUTING ACCEPT [0:0] -A PREROUTING -i eth1 -p tcp --dport 53 -j DNAT --to-destination 192.168.0.2:53 -A POSTROUTING -o eth1 -j MASQUERADE COMMIT *filter *:INPUT ACCEPT [0:0] *:FORWARD ACCEPT [0:0] *:OUTPUT ACCEPT [0:0] ## VOS REGLES EXISTANTES -A FORWARD -j ACCEPT COMMIT

 

 


