+++
title = "Désactiver FirewallD et remettre iptables sur Fedora 21"
author = "MrRaph_"
tags = ["désactiver firewalld et remettre iptables sur fedora 21","Fedora","FirewallD","iptables","Trucs et Astuces"]
image = "https://techan.fr/images/2015/02/120px-Fedora_logo.svg_.png"
description = ""
draft = false
date = 2015-02-11T11:18:08Z
categories = ["désactiver firewalld et remettre iptables sur fedora 21","Fedora","FirewallD","iptables","Trucs et Astuces"]
slug = "desactiver-firewalld-et-remettre-iptables-sur-fedora-21"

+++


**[Edit 16/03/2015] Testé avec succès sur CentOS 7**

Tout récemment j’ai remplacé mon Ubuntu serveur de la maison par une Fedora 21 et c’est peu de dire qu’il y a beaucoup de nouveautés, en bien ou en mal … Le nouveau systemd est terrible, la bête démarre presque instantanément sur un SSD, mais par contre FirewallD est une daube incommensurable à mes yeux … Il doit falloir un Bac +8 pour l’utiliser … Une actions simple comme bannir une IP me prend exactement une seconde avec iptables mais ça devient un vrai chemin de croix avec FirewallD …

Ce n’est pas le premier outil que je rencontre visant a simplifier ou améliorer iptables, je citerais par exemple UFW sur Ubuntu. Contrairement à FirewallD, UFW ajoute pas mal de simplicité à iptables et est utilisable simplement car il utilise une syntaxe sympa. FirewallD quant à lui apporte une syntaxe assez brouillon et le support de zones et de pleins d’autres trucs dont personne ou presque ne se servira jamais …

Une semaine après l’installation de Fedora, constatant que je n’étais toujours pas protégé, j’ai viré tout ça et réactivé le bon vieux iptables. Voici donc la marche à suivre pour désactiver FirewallD et remettre iptables sur Fedora 21.

 


## La marche à suivre

[root@xxxx ~]# systemctl disable firewalld Removed symlink /etc/systemd/system/dbus-org.fedoraproject.FirewallD1.service. Removed symlink /etc/systemd/system/basic.target.wants/firewalld.service. [root@xxxx ~]# systemctl stop firewalld [root@xxxx ~]# yum install iptables-services Modules complémentaires chargés : fastestmirror, langpacks Loading mirror speeds from cached hostfile * fedora: ftp.free.fr * updates: ftp.free.fr Le paquet iptables-services-1.4.21-13.fc21.x86_64 est déjà installé dans sa dernière version Rien à faire [root@xxxx ~]# touch /etc/sysconfig/iptables [root@xxxx ~]# touch /etc/sysconfig/ip6tables [root@xxxx ~]# systemctl start iptables [root@xxxx ~]# systemctl start ip6tables Job for ip6tables.service failed. See "systemctl status ip6tables.service" and "journalctl -xe" for details. [root@xxxx ~]# systemctl enable iptables Created symlink from /etc/systemd/system/basic.target.wants/iptables.service to /usr/lib/systemd/system/iptables.service. [root@xxxx ~]# systemctl enable ip6tables Created symlink from /etc/systemd/system/basic.target.wants/ip6tables.service to /usr/lib/systemd/system/ip6tables.service. [root@xxxx ~]# systemctl start ip6tables Job for ip6tables.service failed. See "systemctl status ip6tables.service" and "journalctl -xe" for details.

Dans mon cas, j’ai une erreur lors du démarrage d’ip6tables car j’ai désactivé l’IPV6 sur ma machine.  On peut vérifier dans les logs que tout c’est bien passé.

févr. 11 08:48:52 xxxx.domain.net systemd[1]: Unit ip6tables.service entered failed state. févr. 11 08:48:52 xxxx.domain.net systemd[1]: ip6tables.service failed. févr. 11 08:49:00 xxxx.domain.net systemd[1]: Configuration file /usr/lib/systemd/system/auditd.service is marked world-inaccessible. This has no effect as configuration data is acc févr. 11 08:49:00 xxxx.domain.net systemd[1]: Configuration file /usr/lib/systemd/system/wpa_supplicant.service is marked executable. Please remove executable permission bits. Proce févr. 11 08:49:04 xxxx.domain.net systemd[1]: Configuration file /usr/lib/systemd/system/auditd.service is marked world-inaccessible. This has no effect as configuration data is acc févr. 11 08:49:04 xxxx.domain.net systemd[1]: Configuration file /usr/lib/systemd/system/wpa_supplicant.service is marked executable. Please remove executable permission bits. Proce févr. 11 08:49:09 xxxx.domain.net ip6tables.init[9791]: ip6tables: ipv6 is disabled. févr. 11 08:49:09 xxxx.domain.net systemd[1]: ip6tables.service: main process exited, code=exited, status=150/n/a févr. 11 08:49:09 xxxx.domain.net systemd[1]: Failed to start IPv6 firewall with ip6tables. -- Subject: L'unité (unit) ip6tables.service a échoué

 


##  Quelques règles iptables de base

La configuration d’iptables est stockée dans le fichier /etc/sysconfig/iptables, après une modification des règles présentes dans ce fichier, il suffit de relancer le daemon iptables pour les appliquer.

#### Autoriser le réseau local

-A INPUT -s 192.168.0.0/24 -j ACCEPT

####  Autoriser le SSH de partout

-A INPUT -p tcp -m state --state NEW -m tcp --dport 22 -j ACCEPT

 

 


