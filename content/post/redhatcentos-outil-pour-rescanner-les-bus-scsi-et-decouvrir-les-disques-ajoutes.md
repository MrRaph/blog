+++
slug = "redhatcentos-outil-pour-rescanner-les-bus-scsi-et-decouvrir-les-disques-ajoutes"
title = "[RedHat/Centos] Outil pour rescanner les bus SCSI et découvrir les disques ajoutés"
date = 2014-09-29T11:23:52Z
author = "MrRaph_"
categories = ["Ajouter des disques","Centos","Linux","RedHat","SCSI"]
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
tags = ["Ajouter des disques","Centos","Linux","RedHat","SCSI"]
draft = false

+++


Il est toujours délicat d’ajouter de l’espace disque sur une machine de production et de pouvoir l’utiliser sans avoir a redémarrer cette dernière.  
  
 L’outil « rescan-scsi-bus », fourni par le paquet « sg3_utils » peut rendre bien des services pour se faire.

 

[root@sxxxx~]# yum install sg3_utils Loaded plugins: fastestmirror, refresh-packagekit, security Loading mirror speeds from cached hostfile * base: centos.crazyfrogs.org * extras: centos.crazyfrogs.org * rpmforge: apt.sw.be * updates: centos.mirror.fr.planethoster.net Setting up Install Process Resolving Dependencies --> Running transaction check ---> Package sg3_utils.x86_64 0:1.28-5.el6 will be installed --> Processing Dependency: sg3_utils-libs = 1.28-5.el6 for package: sg3_utils-1.28-5.el6.x86_64 --> Running transaction check ---> Package sg3_utils-libs.x86_64 0:1.28-4.el6 will be updated ---> Package sg3_utils-libs.x86_64 0:1.28-5.el6 will be an update --> Finished Dependency Resolution Dependencies Resolved ============================================================================================================================================================================================================ Package Arch Version Repository Size ============================================================================================================================================================================================================ Installing: sg3_utils x86_64 1.28-5.el6 base 471 k Updating for dependencies: sg3_utils-libs x86_64 1.28-5.el6 base 51 k Transaction Summary ============================================================================================================================================================================================================ Install 1 Package(s) Upgrade 1 Package(s) Total download size: 522 k Is this ok [y/N]: y Downloading Packages: (1/2): sg3_utils-1.28-5.el6.x86_64.rpm | 471 kB 00:01 (2/2): sg3_utils-libs-1.28-5.el6.x86_64.rpm | 51 kB 00:00 ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ Total 317 kB/s | 522 kB 00:01 Running rpm_check_debug Running Transaction Test Transaction Test Succeeded Running Transaction Warning: RPMDB altered outside of yum. Updating : sg3_utils-libs-1.28-5.el6.x86_64 1/3 Installing : sg3_utils-1.28-5.el6.x86_64 2/3 Cleanup : sg3_utils-libs-1.28-4.el6.x86_64 3/3 Verifying : sg3_utils-1.28-5.el6.x86_64 1/3 Verifying : sg3_utils-libs-1.28-5.el6.x86_64 2/3 Verifying : sg3_utils-libs-1.28-4.el6.x86_64 3/3 Installed: sg3_utils.x86_64 0:1.28-5.el6 Dependency Updated: sg3_utils-libs.x86_64 0:1.28-5.el6 Complete!

 

### Ajout de disque sur une VM Centos

Voici l’état avant l’ajout, nous avons un disque sda et des partitions LVM.

[root@xxxx ~]# fdisk -l | grep Disque Disque /dev/sda: 17.2 Go, 17179869184 octets Disque /dev/mapper/VolGroupSystem-LogVol00Racine: 12.7 Go, 12675186688 octets Disque /dev/mapper/VolGroupSystem-LogVol01: 2143 Mo, 2143289344 octets Disque /dev/mapper/VolGroupLog-LogVol00Log: 2143 Mo, 2143289344 octets

Nous utilisons l’outil pour découvrir le disque nouvelle ajouté.

[root@xxxx~]# rescan-scsi-bus.sh Host adapter 0 (mptspi) found. Host adapter 1 (ata_piix) found. Host adapter 2 (ata_piix) found. Scanning SCSI subsystem for new devices Scanning host 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs Scanning for device 0 0 0 0 ... OLD: Host: scsi0 Channel: 00 Id: 00 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02 Scanning for device 0 0 1 0 ... NEW: Host: scsi0 Channel: 00 Id: 01 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02 Scanning for device 0 0 1 0 ... OLD: Host: scsi0 Channel: 00 Id: 01 Lun: 00 Vendor: VMware Model: Virtual disk Rev: 1.0 Type: Direct-Access ANSI SCSI revision: 02 Scanning host 1 channels 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs Scanning host 2 channels 0 for SCSI target IDs 0 1 2 3 4 5 6 7, all LUNs Scanning for device 2 0 0 0 ... OLD: Host: scsi2 Channel: 00 Id: 00 Lun: 00 Vendor: NECVMWar Model: VMware IDE CDR10 Rev: 1.00 Type: CD-ROM ANSI SCSI revision: 05 0 new device(s) found. 0 device(s) removed.

Et voilà, le nouveau disque est reconnu !

 

[root@sxxxx ~]# fdisk -l | grep Disque Disque /dev/sda: 17.2 Go, 17179869184 octets Disque /dev/mapper/VolGroupSystem-LogVol00Racine: 12.7 Go, 12675186688 octets Disque /dev/mapper/VolGroupSystem-LogVol01: 2143 Mo, 2143289344 octets Disque /dev/mapper/VolGroupLog-LogVol00Log: 2143 Mo, 2143289344 octets Disque /dev/sdb: 42.9 Go, 42949672960 octets

 

 

 


