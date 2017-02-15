+++
image = "https://techan.fr/images/2014/11/Linux.png"
draft = false
title = "[LVM] Les bases"
date = 2014-09-29T14:41:14Z
author = "MrRaph_"
categories = ["Les bases","Linux","LVM"]
tags = ["Les bases","Linux","LVM"]
description = ""
slug = "lvm-les-bases"

+++


Voici les bases de la manipulation des LVM sur Linux.

Vous trouverez dans cet articles les bases de cet outil.  

  

### Ajout d’un PV, d’un VG et d’un LV.

Création d’un « Physical Volume « (PV)

    [root@sl-0-syslogint1 ~]# pvcreate /dev/sdb Writing physical volume data to disk "/dev/sdb" Physical volume "/dev/sdb" successfully created

 

Création d’un « Volum Group » (VG) sur ce PV

    [root@xxxx ~]# vgcreate vg_syslog /dev/sdb Volume group "vg_syslog" successfully created

Le VG ainsi créé s’appelle « vg_syslog ».

 

Création d’un « Logical Volume » (LV) utilisant toute la place disponible dans ce VG

    [root@xxxx ~]# lvcreate -n lv_syslog -l 100%VG vg_syslog Logical volume "lv_syslog" created

Le LV créé s’appelle « lv_syslog ».

 

Maintenant, il ne reste plus qu’a créer un File System sur ce LV.

<span style="text-decoration: underline;">**Note : **</span>Tous les LV créés sont référencés dans le dossier /dev/mapper.

    [root@xxxx ~]# mkfs.ext4 /dev/mapper/vg_syslog-lv_syslog
    mke2fs 1.41.12 (17-May-2010)
    Étiquette de système de fichiers=
    Type de système d'exploitation : Linux
    Taille de bloc=4096 (log=2)
    Taille de fragment=4096 (log=2) « Stride » = 0 blocs, « Stripe width » = 0 blocs 2621440 i-noeuds, 10484736 blocs 524236 blocs (5.00%) réservés pour le super utilisateur
    Premier bloc de données=0
    Nombre maximum de blocs du système de fichiers=4294967296
    320 groupes de blocs 32768 blocs par groupe, 32768 fragments par groupe 8192 i-noeuds par groupe
    Superblocs de secours stockés sur les blocs : 32768, 98304, 163840, 229376, 294912, 819200, 884736, 1605632, 2654208, 4096000, 7962624
    Écriture des tables d'i-noeuds : complété
    Création du journal (32768 blocs) : complété
    Écriture des superblocs et de l'information de comptabilité du système de fichiers : complété
    Le système de fichiers sera automatiquement vérifié tous les 29 montages ou après 180 jours, selon la première éventualité.
    Utiliser tune2fs -c ou -i pour écraser la valeur.

 

 
