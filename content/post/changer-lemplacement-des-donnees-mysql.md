+++
image = "https://techan.fr/images/2014/10/SQL_term.png"
date = 2015-01-28T12:52:37Z
author = "MrRaph_"
draft = false
title = "Changer l'emplacement des données MySQL"
categories = ["changer l emplacement des données mysql","Linux","MySQL","Trucs et Astuces"]
tags = ["changer l emplacement des données mysql","Linux","MySQL","Trucs et Astuces"]
description = ""
slug = "changer-lemplacement-des-donnees-mysql"

+++


Par défaut, sur Linux, MySQL stocke ses données dans le dossier /var/lib/mysql. Ce comportement peut être dangereux car dans la grande majorité des cas, le /var n’est pas sur un disque à part et donc MySQL écrit dans le /. On changer l’emplacement des données MySQL par quelques actions simple que vous trouverez ci-dessous.


## Création du nouvel emplacement

J’ai choisi de créer un nouveau Logical Volume LVM pour héberger les data de MySQL.

[root@xxxxxx ~]# pvcreate /dev/sdb Physical volume "/dev/sdb" successfully created [root@xxxxxx ~]# vgcreate vg_mysql /dev/sdb Volume group "vg_mysql" successfully created [root@xxxxxx ~]# lvcreate -n lv_mysql -l 100%VG vg_mysql Logical volume "lv_mysql" created [root@xxxxxx ~]# mkfs.ext4 /dev/mapper/vg_mysql-lv_mysql mke2fs 1.41.12 (17-May-2010) Étiquette de système de fichiers= Type de système d'exploitation : Linux Taille de bloc=4096 (log=2) Taille de fragment=4096 (log=2) « Stride » = 0 blocs, « Stripe width » = 0 blocs 655360 i-noeuds, 2620416 blocs 131020 blocs (5.00%) réservés pour le super utilisateur Premier bloc de données=0 Nombre maximum de blocs du système de fichiers=2684354560 80 groupes de blocs 32768 blocs par groupe, 32768 fragments par groupe 8192 i-noeuds par groupe Superblocs de secours stockés sur les blocs : 32768, 98304, 163840, 229376, 294912, 819200, 884736, 1605632 Écriture des tables d'i-noeuds : complété Création du journal (32768 blocs) : complété Écriture des superblocs et de l'information de comptabilité du système de fichiers : complété Le système de fichiers sera automatiquement vérifié tous les 26 montages ou après 180 jours, selon la première éventualité. Utiliser tune2fs -c ou -i pour écraser la valeur. [root@xxxxxx1 ~]# mkdir -p /data/mysql [root@xxxxxx ~]# vi /etc/fstab [root@xxxxxx ~]# mount /data/mysql/

Voici la ligne que j’ai ajoutée dans le fichier /etc/fstab :

/dev/mapper/vg_mysql-lv_mysql /data/mysql ext4 defaults 1 2

J’ai donc un tout nouveau file system de 10 Go rien que pour MySQL.


## Configurer MySQL et migrer les données

Tout d’abord, on arrête MySQL.

[root@xxxxxx ~]# service mysqld stop Arrêt de mysqld : [ OK ]

On passe ensuite à la configuration.

[root@xxxxxx ~]# vi /etc/my.cnf [mysqld] datadir=/data/mysql socket=/var/lib/mysql/mysql.sock user=mysql # Disabling symbolic-links is recommended to prevent assorted security risks symbolic-links=0 [mysqld_safe] log-error=/var/log/mysqld.log pid-file=/var/run/mysqld/mysqld.pid

Vous avez compris, dans le fichier /etc/my.cnf, il faut changer la ligne « datadir ».

On prépare la nouvelle destination et on copie les données existantes.

[root@xxxxxx ~]# rm -rf /data/mysql/lost+found/ [root@xxxxxx ~]# chown -R mysql: /data/mysql/ [root@xxxxxx ~]# cp -rp /var/lib/mysql/* /data/mysql/ [root@xxxxxx ~]# mv /var/lib/mysql{,.moved}

Enfin, on redémarre MySQL ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

[root@xxxxxx ~]# service mysqld start Démarrage de mysqld : [ OK ]


