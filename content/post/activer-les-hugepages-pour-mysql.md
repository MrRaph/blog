+++
tags = ["HugePages","Linux","MySQL","Trucs et Astuces"]
description = ""
slug = "activer-les-hugepages-pour-mysql"
title = "Activer les HugePages pour MySQL"
date = 2015-04-23T09:21:17Z
author = "MrRaph_"
categories = ["HugePages","Linux","MySQL","Trucs et Astuces"]
image = "https://techan.fr/images/2015/04/MariaDB-seal.png"
draft = false

+++


Tout comme Oracle, MySQL support les HugePages, et pour les même raisons que pour Oracle, cela peut valoir le coup de les activer. Les Huge Pages sont des pages mémoires allouées au démarrage du système, elles font 2 Mo, les pages mémoire classique font elles 4 Ko. Les performances des applications qui font beaucoup d’accès mémoire – comme les SGBD – peuvent être améliorées en activant ces Huge Pages. Cela réduit le nombre d’appels systèmes pour faire les liens entre les multiples pages de 4 Ko, vu que les Huge Pages font 2 Mo !

<span style="text-decoration: underline;">Note :</span> Dans MySQL, les Huge Pages sont utilisées par le moteur InnoDB, si vous ne l’utilisez peu ou pas, ce n’est pas la peine de les activer. Les Huge Pages ne sont supportées par MySQL que sur les systèmes Linux.

***<span style="text-decoration: underline;">Attention :</span> L’activation des Huge Pages nécessite la modification de paramètres systèmes avancés, n’entrepenez pas les actions décrites ci-dessous si vous ne les comprenez pas !***

 


## 


## Collecter les données requises

#### Vérifier que le noyau est capable de gérer les Huge Pages

Si la commande ci-dessous retourne des lignes, votre noyau supporte les Huge Pages.

# grep -i huge /proc/meminfo AnonHugePages: 1404928 kB HugePages_Total: 0 HugePages_Free: 0 HugePages_Rsvd: 0 HugePages_Surp: 0 Hugepagesize: 2048 kB

 

#### Récupérer le gid auquel appartient mysql

Notez bien le gid affecté à l’utilisateur MySQL, il nous sera utile par la suite.

# id mysql uid=106(mysql) gid=114(mysql) groups=114(mysql)

 

#### Calculer les valeurs de SHMMAX et SHMALL pour votre système

Ces paramètres définissent les tailles de mémoire partagée, il faut les positionner à des valeurs cohérentes en fonction de votre système et de la taille de mémoire que vous souhaitez allouer aux Huge Pages.

Les script ci-dessous – écrit par *DANGLADE JEAN-SEBASTIEN* sur le site dev.mysql.com, voir sources – vous donnera un bon point de départ. Spécifiez la mémoire que vous voulez laisser disponible au système – je laisse 6 Go sur mes 8 disponibles.

##### SCRIPT START ######### #!/bin/bash # keep 6go memory for system keep_for_system=6291456 mem=$(free|grep Mem|awk '{print$2}') mem=$(echo "$mem-$keep_for_system"|bc) totmem=$(echo "$mem*1024"|bc) huge=$(grep Hugepagesize /proc/meminfo|awk '{print $2}') max=$(echo "$totmem*75/100"|bc) all=$(echo "$max/$huge"|bc) echo "kernel.shmmax = $max" echo "kernel.shmall = $all" ######### SCRIPT END #########

Voici le résultat de ce script, noter les deux lignes.

# /tmp/hugepages.sh kernel.shmmax = 1437026304 kernel.shmall = 701673

 


## La configuration

#### Côté système

Éditez le fichier /etc/sysctl.conf.

vi /etc/sysctl.conf

Ajouter les lignes suivantes à la fin du fichier, modifiez les si elles existent déjà.

vm.nr_hugepages=512 vm.hugetlb_shm_group=114 kernel.shmmax = 1437026304 kernel.shmall = 701673

Je crée ici 512 Huge Pages de 4 Mo, soit 2 Go de mémoire réservées aux Huge Pages.

 

On va modifier le fichier /etc/security/limits.conf afin de ne plus limiter la mémoire que MySQL va pouvoir locker.

vi /etc/security/limits.conf

Ajouter les lignes suivantes à la fin du fichier.

@mysql soft memlock unlimited @mysql hard memlock unlimited # End of file

 

#### Côté MySQL

Éditer le fichier /etc/mysql/my.cnf.

vi /etc/mysql/my.cnf

Ajouter la ligne « large-pages » dans la section « [mysqld] ».

[mysqld] large-pages

Éditer également le script d’initialisation de MySQL.

vi /etc/init.d/mysql

Ajouter la ligne « ulimit -l unlimited » dans ce fichier comme suit :

#!/bin/bash # ### BEGIN INIT INFO # Provides: mysql # Required-Start: $remote_fs $syslog # Required-Stop: $remote_fs $syslog # Should-Start: $network $named $time # Should-Stop: $network $named $time # Default-Start: 2 3 4 5 # Default-Stop: 0 1 6 # Short-Description: Start and stop the mysql database server daemon # Description: Controls the main MariaDB database server daemon "mysqld" # and its wrapper script "mysqld_safe". ### END INIT INFO # set -e set -u ulimit -l unlimited ${DEBIAN_SCRIPT_DEBUG:+ set -v -x} test -x /usr/sbin/mysqld || exit 0 . /lib/lsb/init-functions

 


## Application des modifications

On regarde le total de Huge Pages allouées avant le reboot.

# cat /proc/meminfo | grep -i huge AnonHugePages: 1261568 kB HugePages_Total: 39 HugePages_Free: 37 HugePages_Rsvd: 6 HugePages_Surp: 0 Hugepagesize: 2048 kB

On redémarre la machine.

# reboot

Après le reboot, on revérifie et magie, on a nos 512 Huge Pages et MySQL en a réservé 124.

# cat /proc/meminfo | grep -i huge AnonHugePages: 120832 kB HugePages_Total: 512 HugePages_Free: 388 HugePages_Rsvd: 124 HugePages_Surp: 0 Hugepagesize: 2048 kB

 

<span style="text-decoration: underline;">Sources :</span>

- [dev.mysql.com](https://dev.mysql.com/doc/refman/5.0/en/large-page-support.html) (notamment le commentaire de « DANGLADE JEAN-SEBASTIEN  » à la fin)
- [ashwinvasani.wordpress.com](https://ashwinvasani.wordpress.com/2011/03/03/reserving-huge-pages-for-mysql/)


