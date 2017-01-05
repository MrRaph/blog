+++
tags = ["Ajouter disques","Linux","Trucs et Astuces"]
image = "https://techan.fr/images/2014/11/Linux.png"
title = "[RedHat] Ajouter un disque à chaud, sans rescan-scsi-bus"
date = 2014-11-03T10:58:04Z
author = "MrRaph_"
categories = ["Ajouter disques","Linux","Trucs et Astuces"]
description = ""
slug = "redhat-ajouter-un-disque-a-chaud-sans-rescan-scsi-bus"
draft = false

+++


Sur les anciennes versions de RedHat, la commande rescan-scsi-bus n’est pas forcément disponible dans les dépôts, il faut donc s’en passer pour ajouter les disques à chaud.


## Ajouter un disque à chaud

Pour cela, il suffit de faire un cat dans des fichiers spéciaux sous le /sys.

[root@xxxxxxx ~]# ll /sys/class/scsi_host/ total 0 lrwxrwxrwx 1 root root 0 22 oct. 16:22 host0 -> ../../devices/pci0000:00/0000:00:07.1/ata1/host0/scsi_host/host0 lrwxrwxrwx 1 root root 0 22 oct. 16:22 host1 -> ../../devices/pci0000:00/0000:00:07.1/ata2/host1/scsi_host/host1 lrwxrwxrwx 1 root root 0 22 oct. 16:22 host2 -> ../../devices/pci0000:00/0000:00:10.0/host2/scsi_host/host2 lrwxrwxrwx 1 root root 0 22 oct. 16:22 host3 -> ../../devices/pci0000:00/0000:00:11.0/0000:02:01.0/host3/scsi_host/host3 lrwxrwxrwx 1 root root 0 22 oct. 16:22 host4 -> ../../devices/pci0000:00/0000:00:11.0/0000:02:02.0/host4/scsi_host/host4 lrwxrwxrwx 1 root root 0 22 oct. 16:22 host5 -> ../../devices/pci0000:00/0000:00:11.0/0000:02:03.0/host5/scsi_host/host5

 

Chacun de ces dossiers « host » contient un fichier « scan », c’est dans ces fichiers que nous allons faire ces cat :

[root@xxxxxxx ~]# echo "- - -" > /sys/class/scsi_host/host0/scan

 

Vérifier que le disque soit bien apparu après quelques secondes en utilisant la commande « fdisk -l ».

 


## Redimensionner un disque à chaud

Pour redimensionner un disque à chaud, par exemple si vous ajouter de l’espace à ce disque dans VMware, il faut faire une manipulation différente.

Déjà, il faut récupérer l’identifiant du disque dans le bus SCSI, par exemple, si je veux étendre le disque /dev/sdb.

# udevadm info -q all -n /dev/sdb | grep sdb P: /devices/pci0000:00/0000:00:10.0/host0/target0:0:1/0:0:1:0/block/sdb N: sdb E: DEVPATH=/devices/pci0000:00/0000:00:10.0/host0/target0:0:1/0:0:1:0/block/sdb E: DEVNAME=/dev/sdb

 

Le disque /dev/sdb à donc comme identifiant « 0:0:1 », pour que l’agrandissement soit vu par le système, il faut passer la commande suivante :

# echo " " > /sys/class/scsi_disk/0\:0\:1\:0/device/rescan

 

 

 


