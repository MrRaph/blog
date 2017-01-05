+++
draft = false
date = 2015-02-09T10:39:51Z
author = "MrRaph_"
image = "https://techan.fr/images/2015/01/Centreon-Logo-Cube.png"
description = ""
slug = "installer-nagios-et-centreon-sur-centos-6"
title = "Installer Nagios et Centreon sur Centos 6"
categories = ["CentOS 6","Centreon","Linux","Nagios"]
tags = ["CentOS 6","Centreon","Linux","Nagios"]

+++



## Actions préparatoires

#### Désactiver SELinux

[root@xxxxxx ~]# selinuxenabled [root@xxxxxx ~]# echo $? 1 [root@xxxxxx ~]#

 

 

Le résultat est 1 donc SELinux n’est pas activé, si tel était le cas, voici la marche à suivre pour le désactiver.

[root@xxxxxx ~]# vi /etc/sysconfig/selinux # This file controls the state of SELinux on the system. # SELINUX= can take one of these three values: # enforcing - SELinux security policy is enforced. # permissive - SELinux prints warnings instead of enforcing. # disabled - No SELinux policy is loaded. SELINUX=disabled # SELINUXTYPE= can take one of these two values: # targeted - Targeted processes are protected, # mls - Multi Level Security protection. SELINUXTYPE=targeted

Passer le paramètre SELINUX à disabled

 

#### Installation des paquets nécessaires

[root@xxxxxx ~]# yum install phpMyAdmin mysql-server [...] Dépendances résolues ===================================================================================================================================================================================== Paquet Architecture Version Dépôt Taille ===================================================================================================================================================================================== Installation: mysql-server x86_64 5.1.73-3.el6_5 base 8.6 M phpMyAdmin noarch 3.5.7-1.el6.rf rpmforge 4.4 M Installation pour dépendance: httpd x86_64 2.2.15-39.el6.centos base 825 k libmcrypt x86_64 2.5.7-1.2.el6.rf rpmforge 196 k mysql x86_64 5.1.73-3.el6_5 base 894 k perl-DBD-MySQL x86_64 4.013-3.el6 base 134 k perl-DBI x86_64 1.609-4.el6 base 705 k php x86_64 5.3.3-40.el6_6 updates 1.1 M php-cli x86_64 5.3.3-40.el6_6 updates 2.2 M php-common x86_64 5.3.3-40.el6_6 updates 527 k php-gd x86_64 5.3.3-40.el6_6 updates 109 k php-mbstring x86_64 5.3.3-40.el6_6 updates 458 k php-mcrypt x86_64 5.3.3-1.el6.rf rpmforge 42 k php-mysql x86_64 5.3.3-40.el6_6 updates 84 k php-pdo x86_64 5.3.3-40.el6_6 updates 78 k Résumé de la transaction ===================================================================================================================================================================================== Installation de 15 paquet(s) Taille totale des téléchargements : 20 M Taille d'installation : 66 M Est-ce correct [o/N] :

Cela installe Apache, Php, MySQL et phpMyAdmin.

#### Configuration de PHP

Dans le fichier /etc/php.ini, modifier la ligne « date.timezone ».

[Date] ; Defines the default timezone used by the date functions ; http://www.php.net/manual/en/datetime.configuration.php#ini.date.timezone ;date.timezone = date.timezone = Europe/Paris

Puis redémarrer Apache.

[root@sxxxxxx ~]# service httpd restart Arrêt de httpd : [ OK ] Démarrage de httpd : [ OK ]

 


## Passons aux choses sérieuses

#### Ajouter le dépôt Cenreon

 wget http://yum.centreon.com/standard/3.0/stable/ces-standard.repo -O /etc/yum.repos.d/ces-standard.repo

Récupérer la clef GPG du dépôt [à cette adresse](http://yum.centreon.com/standard/3.0/stable/RPM-GPG-KEY-CES) et copier son contenu dans le ficiher /etc/pki/rpm-gpg/RPM-GPG-KEY-CES.

#### Installer Centreon et Nagios

[root@xxxxxx ~]# yum install centreon-base-config-nagios centreon

 

#### Configuration de Centréon

<div class="wp-caption aligncenter" id="attachment_980" style="width: 634px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422450421.png)](https://techan.fr/images/2015/01/screenshot.1422450421.png)Se rendre sur la page http://servername/centreon

</div> 

<div class="wp-caption aligncenter" id="attachment_981" style="width: 634px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422450430.png)](https://techan.fr/images/2015/01/screenshot.1422450430.png)Vérifier que les prérequis sont validés.

</div><div class="wp-caption aligncenter" id="attachment_982" style="width: 630px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422450453.png)](https://techan.fr/images/2015/01/screenshot.1422450453.png)Déplier la liste de choix.

</div><div class="wp-caption aligncenter" id="attachment_983" style="width: 631px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422450504.png)](https://techan.fr/images/2015/01/screenshot.1422450504.png)Choisir Nagios et valider que les chemins affichés sont bons sur le serveur.

</div><div class="wp-caption aligncenter" id="attachment_984" style="width: 634px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422450523.png)](https://techan.fr/images/2015/01/screenshot.1422450523.png)Cliquer sur Next.

</div><div class="wp-caption aligncenter" id="attachment_986" style="width: 632px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422450875.png)](https://techan.fr/images/2015/01/screenshot.1422450875.png)Configurer le compte administrateur de Centréon.

</div><div class="wp-caption aligncenter" id="attachment_987" style="width: 634px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422450997.png)](https://techan.fr/images/2015/01/screenshot.1422450997.png)Configurer les connexions à MySQL.

</div><div class="wp-caption aligncenter" id="attachment_988" style="width: 633px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422451027.png)](https://techan.fr/images/2015/01/screenshot.1422451027.png)Si comme moi vous avez cette erreur, appliquer les actions ci-dessous.

</div> 

Éditer le fichier de configuration de MySQL et ajouter la ligne :

innodb_file_per_table=1

Dans la partie [mysqld].

Puis redémarrer MySQL et cliquer sur Refresh dans l’installateur de Centréon.

 

<div class="wp-caption aligncenter" id="attachment_989" style="width: 642px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422451083.png)](https://techan.fr/images/2015/01/screenshot.1422451083.png)Attendre la fin de l’installation.

</div><div class="wp-caption aligncenter" id="attachment_990" style="width: 635px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422451120.png)](https://techan.fr/images/2015/01/screenshot.1422451120.png)Cliquer sur Next

</div><div class="wp-caption aligncenter" id="attachment_991" style="width: 632px">[![Installer Nagios et Centreon sur Centos 6](https://techan.fr/images/2015/01/screenshot.1422451133.png)](https://techan.fr/images/2015/01/screenshot.1422451133.png)Et voilà !

</div> 

 

Et voilà, il ne reste plus qu’a configurer  la supervision ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

[![screenshot.1422451183](https://techan.fr/images/2015/01/screenshot.1422451183.png)](https://techan.fr/images/2015/01/screenshot.1422451183.png)

 


