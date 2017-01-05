+++
author = "MrRaph_"
description = ""
draft = false
tags = ["Linux","Logs","rsyslog","Trucs et Astuces"]
image = "https://techan.fr/images/2014/11/Linux.png"
slug = "linux-envoyer-des-logs-sur-un-serveur-central-avec-rsyslog"
title = "[Linux] Envoyer des logs sur un serveur central avec rsyslog"
date = 2014-10-08T08:13:18Z
categories = ["Linux","Logs","rsyslog","Trucs et Astuces"]

+++


Nous allons voir comment envoyer des logs sur un serveur distant avec rsyslog. Cette manipulation est très intéressante car elle permet d’avoir tous les logs dans un même endroit et de pouvoir les analyser ensuite avec des programme supplémentaire comme Graylog2 et/ou Logstash.  
  
  

Tout d’abord, sur le serveur qui va recevoir les logs, il est nécessaire de configurer le rsyslog local pour qu’il écoute sur le réseau. Le port « classique » pour cela est 514 en TCP et en UDP.

 

### Sur le serveur de logs

 

Cette configuration va se trouver dans le fichier /etc/rsyslog.conf sur RedHat/Centos.

Décommentez les lignes suivantes :

# Provides UDP syslog reception $ModLoad imudp $UDPServerRun 514 # Provides TCP syslog reception $ModLoad imtcp $InputTCPServerRun 514

 

Nous allons demander à rsyslog de stocker les logs dans un dossier que le classique /var/log.

Pour cela, nous créons un template et nous redirigeons tous les messages reçus par rsyslog dans ce template :

#### RULES #### $template TmplAuth, "/data/syslog/%HOSTNAME%/%PROGRAMNAME%.log" # Log all kernel messages to the console. # Logging much else clutters up the screen. #kern.* /dev/console # Log anything (except mail) of level info or higher. # Don't log private authentication messages! *.info;mail.none;authpriv.none;cron.none ?TmplAuth # The authpriv file has restricted access. authpriv.* ?TmplAuth # Log all the mail messages in one place. mail.* ?TmplAuth # Log cron stuff cron.* ?TmplAuth # Everybody gets emergency messages *.emerg ?TmplAuth # Save news errors of level crit and higher in a special file. uucp,news.crit ?TmplAuth # Save boot messages also to boot.log local7.* ?TmplAuth authpriv.* ?TmplAuth *.info,mail.none,authpriv.none,cron.none ?TmplMsg local1.*,local2.*,local3.*,local4.*,local5.*,local6.*, local7.* ?TmplAuth

 

Tous les logs seront maintenant écrit dans le dossier /data/syslog/[hostnamede la machine émettrice]/[nom du programme qui envoie le log].log

 

### Sur les machines émettrices

La configuration est également a réaliser dans le fichier /etc/rsyslog.conf

Ajouter à la fin du fichier :

$WorkDirectory /var/lib/rsyslog $ActionQueueFileName fwdRule1 $ActionQueueMaxDiskSpace 2g $ActionQueueSaveOnShutdown on $ActionQueueType LinkedList $ActionResumeRetryCount -1 *.* @ip.du.serveur.rsyslog

 

 

Et voilà, un petit rester du service rsyslog sur chaque machine et le tour est joué !

 


