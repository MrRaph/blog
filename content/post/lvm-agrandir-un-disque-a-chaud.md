+++
author = "MrRaph_"
tags = ["A Chaud","Agrandir","Linux","LVM"]
slug = "lvm-agrandir-un-disque-a-chaud"
draft = false
title = "[LVM] Agrandir un disque à chaud"
date = 2014-10-22T16:40:03Z
categories = ["A Chaud","Agrandir","Linux","LVM"]
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""

+++


Une des choses assez pratique a savoir faire lorsque l’on utilise du LVM sur Linux, c’est de pouvoir agrandir le LV à chaud.  

 Partons par exemple d’un VG se nommant « VolGroup-u02 » ne comportant qu’un LV nommé « Vol-u02 » faisant 100% de la taille du VG. Ce VG utilise un disque entier comme PV « /dev/sde ».

 

    [root@xxxxxxxx ~]# vgdisplay VolGroup-u02 -v
    Using volume group(s) on command line
    Finding volume group "VolGroup-u02"
    --- Volume group ---
    VG Name VolGroup-u02
    System ID Format lvm2
    Metadata Areas 1
    Metadata Sequence No 10
    VG Access read/write
    VG Status resizable
    MAX LV 0
    Cur LV 1
    Open LV 1
    Max PV 0
    Cur PV 1
    Act PV 1
    VG Size 200,00 GiB
    PE Size 4,00 MiB
    Total PE 51199
    Alloc PE / Size 51199 / 200,00 GiB
    Free PE / Size 0 / 0
    VG UUID YACmCL-D8Le-40m9-z1i7-nwxc-odko-dzILpS
    --- Logical volume ---
    LV Path /dev/VolGroup-u02/Vol-u02
    LV Name Vol-u02
    VG Name VolGroup-u02
    LV UUID ZtWasj-EII1-Nu9Y-Nv3a-ffaq-VJVP-l3mHsm
    LV Write Access read/write
    LV Creation host, time sl-0-vdbtpl2.example.fr, 2014-06-11 11:38:13 +0200
    LV Status available # open 1
    LV Size 200,00 GiB
    Current LE 51199 Segments 1
    Allocation inherit
    Read ahead sectors auto - currently set to 256
    Block device 252:3
    --- Physical volumes ---
    PV Name /dev/sde
    PV UUID cXHbmH-d56b-yLSz-A0KL-3URd-i6A1-3mD2Pw
    PV Status allocatable
    Total PE / Free PE 51199 / 0

 

Le disque a été agrnadi du côté de VMware, nous allons utiliser un outil sur Linux pour le forcer a rescaner ses bus et découvrir l’agrandissement. Cet outil s’appelle « rescan-scsi-bus.sh » et peut être installé avec le package « sg3_utils » sur RedHat / CentOS.

 

    [root@xxxxxxxx ~]# rescan-scsi-bus.sh --forcerescan
    Host adapter 0 (ata_piix) found.
    Host adapter 1 (ata_piix) found.
    Host adapter 2 (mptspi) found.
    Host adapter 3 (mptspi) found.
    Host adapter 4 (mptspi) found.
    Host adapter 5 (mptspi) found.
    Scanning SCSI subsystem for new devices and remove devices that have disappeared
    Scanning host 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs
    Scanning host 1 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs
    Scanning for device 1 0 0 0 ... REM: Host: scsi1
    Channel: 00 Id: 00 Lun: 00 DEL: Vendor: NECVMWar Model: VMware IDE CDR10 Rev: 1.00 Type: CD-ROM ANSI SCSI revision: 05
    Scanning host 2 channels 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs
    Scanning for device 2 0 0 0 ... OLD: Host: scsi2
    Channel: 00 Id: 00 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02
    Scanning host 3 channels 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs Scanning for device 3 0 0 0 ...
    OLD: Host: scsi3 Channel: 00 Id: 00 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02
    Scanning host 4 channels 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs
    Scanning for device 4 0 0 0 ... OLD: Host: scsi4
    Channel: 00 Id: 00 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02
    Scanning for device 4 0 1 0 ...
    OLD: Host: scsi4 Channel: 00 Id: 01 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02
    Scanning host 5 channels 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs
    Scanning for device 5 0 0 0 ... OLD: Host: scsi5
    Channel: 00 Id: 00 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02
    Scanning for device 5 0 1 0 ... OLD: Host: scsi5
    Channel: 00 Id: 01 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02
    0 new device(s) found. 1 device(s) removed.

 

Vérifions la taille de disque avant le resize :

    [root@xxxxxxxx ~]# pvdisplay /dev/sde
    --- Physical volume ---
    PV Name /dev/sde
    VG Name VolGroup-u02
    PV Size 200,00 GiB / not usable 3,00 MiB
    Allocatable yes (but full)
    PE Size 4,00 MiB
    Total PE 51199
    Free PE 0
    Allocated PE 51199
    PV UUID cXHbmH-d56b-yLSz-A0KL-3URd-i6A1-3mD2Pw

On étend le disque

    [root@xxxxxxxx ~]# pvresize /dev/sde Physical volume "/dev/sde" changed 1 physical volume(s) resized / 0 physical volume(s) not resized

Validons que cela a bien fonctionné.

    [root@xxxxxxxx ~]# pvdisplay /dev/sde --- Physical volume --- PV Name /dev/sde VG Name VolGroup-u02 PV Size 220,00 GiB / not usable 3,00 MiB Allocatable yes PE Size 4,00 MiB Total PE 56319 Free PE 5120 Allocated PE 51199 PV UUID cXHbmH-d56b-yLSz-A0KL-3URd-i6A1-3mD2Pw

Maintenant, on va étendre le LV :

    [root@xxxxxxxx ~]# lvextend -l 100%VG /dev/VolGroup-u02/Vol-u02 Extending logical volume Vol-u02 to 220,00 GiB Logical volume Vol-u02 successfully resized

Puis le File System :

    [root@xxxxxxxx ~]# resize2fs /dev/VolGroup-u02/Vol-u02
    resize2fs 1.43-WIP (20-Jun-2013) Le système de fichiers de /dev/VolGroup-u02/Vol-u02 est monté sur /u02 ; le changement de taille doit être effectué en ligne old_desc_blocks = 13, new_desc_blocks = 14
    Le système de fichiers /dev/VolGroup-u02/Vol-u02 a maintenant une taille de 57670656 blocs.

 

On valide que le FS fait bien 220 Go maintenant :

    [root@xxxxxxxx ~]# df -h /u02/ Filesystem Size Used Avail Use% Mounted on /dev/mapper/VolGroup--u02-Vol--u02 217G 152G 57G 73% /u02

 

Et voila !
