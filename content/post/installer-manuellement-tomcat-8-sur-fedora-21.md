+++
author = "MrRaph_"
categories = ["installer manuellement tomcat 8 sur fedora 21"]
image = "https://techan.fr/wp-content/uploads/2015/02/120px-Fedora_logo.svg_.png"
slug = "installer-manuellement-tomcat-8-sur-fedora-21"
title = "Installer manuellement Tomcat 8 sur Fedora 21"
tags = ["installer manuellement tomcat 8 sur fedora 21"]
description = ""
draft = false
date = 2015-04-16T14:54:42Z

+++


Voici un procédure pour installer manuellement Tomcat8 sur Fedora 21. L’installation manuelle a des avantages, on peut notamment avoir une version récente avant que l’éditeur de la distribution ne les pousse dans les dépôts. Cependant avec cette méthode, on se prive des mises à jour automatiques et en particulier des patchs de sécurité. Il faut donc peser le pour et le contre avant de choisir…

 

Je souhaitais installer Tomcat8 manuellement pour pouvoir faire des tests en parallèle du Tomcat installé par Fedora 21.


## 


## Installation de Java 8 (Oracle)

Il faut dans un premier temps télécharger le package et le décompresser.

[root@xxxx tmp]# cd /opt/ [root@xxxx opt]# wget --no-cookies --no-check-certificate --header "Cookie: gpw_e24=http%3A%2F%2Fwww.oracle.com%2F; oraclelicense=accept-securebackup-cookie" "http://download.oracle.com/otn-pub/java/jdk/8u31-b13/jdk-8u31-linux-x64.tar.gz" [root@xxxx opt]# tar xzf jdk-8u31-linux-x64.tar.gz

On ajoute la nouvelle alternative pour Java.

[root@xxxx jdk1.8.0_31]# alternatives --install /usr/bin/java java /opt/jdk1.8.0_31/bin/java 2 [root@xxxx jdk1.8.0_31]# alternatives --config java Il existe 2 programmes qui fournissent « java ». Sélection Commande ----------------------------------------------- *+ 1 /usr/lib/jvm/java-1.8.0-openjdk-1.8.0.31-3.b13.fc21.x86_64/jre/bin/java 2 /opt/jdk1.8.0_31/bin/java Entrez pour garder la sélection courante [+] ou saisissez le numéro de type de sélection :2

On met ensuite à jour les alternatives pour que notre nouveau Java devienne la version par défaut du système.

[root@xxxx jdk1.8.0_31]# alternatives --install /usr/bin/jar jar /opt/jdk1.8.0_31/bin/jar 2 [root@xxxx jdk1.8.0_31]# alternatives --install /usr/bin/javac javac /opt/jdk1.8.0_31/bin/javac 2 [root@xxxx jdk1.8.0_31]# alternatives --set jar /opt/jdk1.8.0_31/bin/jar [root@xxxx jdk1.8.0_31]# alternatives --set javac /opt/jdk1.8.0_31/bin/javac

Un petit test :

[root@xxxx jdk1.8.0_31]# java -version java version "1.8.0_31" Java(TM) SE Runtime Environment (build 1.8.0_31-b13) Java HotSpot(TM) 64-Bit Server VM (build 25.31-b07, mixed mode)

 


## Installation de Tomcat 8

On télécharge Tomcat, on le décompresse dans « /opt/tomcat8 ».

[root@xxxx ~]# cd /tmp [root@xxxx tmp]# wget http://mirror.tcpdiag.net/apache/tomcat/tomcat-8/v8.0.18/bin/apache-tomcat-8.0.18.tar.gz [root@xxxx tmp]# tar xvzf apache-tomcat-8.0.18.tar.gz [root@xxxx tmp]# mv apache-tomcat-8.0.18 /opt/tomcat8 [root@xxxx tmp]# ln -s /opt/tomcat8 /opt/tomcat-latest

Le lient symbolique « /opt/tomcat-latest » va nous permettre d’être un peu plus fexible dans la gestion des versions de Tomcat installées manuellement. Le jour ou j’installerais Tomcat 9, je le mettrais à jour et tout mes scripts « suivront » cette évolution.

Maintenant, démarrons Tomcat 8 le plus simplement du monde.

[root@xxxx tmp]# cd /opt/tomcat-latest/ [root@xxxx tomcat-latest]# ll total 116 drwxr-xr-x. 2 root root 4096 11 févr. 08:40 bin drwxr-xr-x. 2 root root 4096 28 janv. 16:54 conf drwxr-xr-x. 2 root root 4096 11 févr. 08:40 lib -rw-r--r--. 1 root root 56812 28 janv. 16:54 LICENSE drwxr-xr-x. 2 root root 4096 28 janv. 16:51 logs -rw-r--r--. 1 root root 1192 28 janv. 16:54 NOTICE -rw-r--r--. 1 root root 8963 28 janv. 16:54 RELEASE-NOTES -rw-r--r--. 1 root root 16204 28 janv. 16:54 RUNNING.txt drwxr-xr-x. 2 root root 4096 11 févr. 08:40 temp drwxr-xr-x. 7 root root 4096 28 janv. 16:53 webapps drwxr-xr-x. 2 root root 4096 28 janv. 16:51 work [root@xxxx tomcat7]# ./bin/startup.sh Using CATALINA_BASE: /opt/tomcat-latest Using CATALINA_HOME: /opt/tomcat-latest Using CATALINA_TMPDIR: /opt/tomcat-latest/temp Using JRE_HOME: / Using CLASSPATH: /opt/tomcat-latest/bin/bootstrap.jar:/opt/tomcat7/bin/tomcat-juli.jar Tomcat started.


## 


## Configuration de Tomcat 8

####  Création de l’utilisateur admin

On se rend dans le dossier « /opt/tomcat-latest » et on édite le fichier « conf/tomcat-users.xml ».

[root@xxxx ~]# cd /opt/tomcat-latest/ [root@xxxx tomcat-latest]# vi conf/tomcat-users.xml

Voici à quoi ce fichier doit ressembler pour que l’utilisateur « admin » ai accès à l’interface d’administration de Tomcat 8.

xmlns="http://tomcat.apache.org/xml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://tomcat.apache.org/xml tomcat-users.xsd" version="1.0">

On positionne les droits comme il faut.

[root@xxxx ~]# chown -R tomcat:tomcat /opt/tomcat-latest/

####  Configuration avec Systemd

On va créer un nouveau fichier « tomcat8.service » dans le dossier « /etc/systemd/system/ ». Ce fichier remplace le bon vieux « /etc/init.d/tomcat8 » et va nous permettre de démarrer Tomcat 8 avec le système et/ou la commande « service ».

[root@xxxx tomcat-latest]# vi /etc/systemd/system/tomcat8.service

Voici le contenu de ce fichier.

[Unit] Description=Tomcat8 After=network.target [Service] Type=forking User=tomcat Group=tomcat Environment=CATALINA_PID=/opt/tomcat-latest/tomcat8.pid Environment=TOMCAT_JAVA_HOME=/opt/jdk1.8.0_31/ Environment=CATALINA_HOME=/opt/tomcat-latest Environment=CATALINA_BASE=/opt/tomcat-latest Environment=CATALINA_OPTS= Environment="JAVA_OPTS=-Dfile.encoding=UTF-8 -Dnet.sf.ehcache.skipUpdateCheck=true -XX:+UseConcMarkSweepGC -XX:+CMSClassUnloadingEnabled -XX:+UseParNewGC -XX:MaxPermSize=128m -Xms512m -Xmx512m" ExecStart=/opt/tomcat-latest/bin/startup.sh ExecStop=/bin/kill -15 $MAINPID [Install] WantedBy=multi-user.target

On démarre Tomcat 8 !

[root@xxxx tomcat-latest]# systemctl daemon-reload [root@xxxx tomcat-latest]# systemctl restart tomcat8

On peut maintenant se rendre à l’adresse : http://localhost:8080/ et voir cette magnifique page.

[![screenshot.1423643818](https://techan.fr/wp-content/uploads/2015/02/screenshot.1423643818.png)](https://techan.fr/wp-content/uploads/2015/02/screenshot.1423643818.png)Et dans les logs :

[root@xxxx logs]# journalctl -f -- Logs begin at dim. 2015-02-01 15:14:43 CET. -- févr. 11 09:35:49 xxxx.domain.net startup.sh[20397]: Using CATALINA_BASE: /opt/tomcat-latest févr. 11 09:35:49 xxxx.domain.net startup.sh[20397]: Using CATALINA_HOME: /opt/tomcat-latest févr. 11 09:35:49 xxxx.domain.net startup.sh[20397]: Using CATALINA_TMPDIR: /opt/tomcat-latest/temp févr. 11 09:35:49 xxxx.domain.net startup.sh[20397]: Using JRE_HOME: /usr févr. 11 09:35:49 xxxx.domain.net startup.sh[20397]: Using CLASSPATH: /opt/tomcat-latest/bin/bootstrap.jar:/opt/tomcat-latest/bin/tomcat-juli.jar févr. 11 09:35:49 xxxx.domain.net startup.sh[20397]: Using CATALINA_PID: /opt/tomcat-latest/tomcat8.pid févr. 11 09:35:49 xxxx.domain.net startup.sh[20397]: Tomcat started.


