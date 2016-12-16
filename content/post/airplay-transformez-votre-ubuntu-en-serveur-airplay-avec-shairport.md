+++
categories = ["AirPlay","ShairPort","Ubuntu"]
description = ""
slug = "airplay-transformez-votre-ubuntu-en-serveur-airplay-avec-shairport"
draft = false
title = "[AirPlay] Transformez votre Ubuntu en serveur AirPlay avec ShairPort"
date = 2014-11-19T10:24:38Z
author = "MrRaph_"
tags = ["AirPlay","ShairPort","Ubuntu"]
image = "https://techan.fr/wp-content/uploads/2015/04/Ubuntu_Logo.gif"

+++


Dans cet article, nous allons voir comment transformez votre Ubuntu en serveur AirPlay avec ShairPort. Tout comme les Freebox, votre ordinateur peut vous permettre de lire les fichiers audio de votre iPad/iPhone/iPod sur ses enceintes, ou sur votre Home Cinema.  
  
 C’est assez sympathique pour passer votre playlist, ou celle de vos amis en soirée. ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

 

Installer les paquets nécessaires.

root@xxxx:/srv# aptitude install libshairport2 libshairport-dev libpulse-dev unzip make gcc openssl pkg-config libavahi-client-dev libasound2-dev build-essential mesa-utils libao-common libcrypt-openssl-rsa-perl libao-dev libio-socket-inet6-perl libwww-perl avahi-utils libasound2-doc libglib2.0-doc Les NOUVEAUX paquets suivants vont être installés : libao-common libao-dev libao4{a} libasound2-dev libasound2-doc libcrypt-openssl-bignum-perl{a} libcrypt-openssl-rsa-perl libglib2.0-dev{a} libglib2.0-doc libpcre3-dev{a} libpcrecpp0{a} libpulse-dev libshairport-dev libshairport2 0 paquets mis à jour, 14 nouvellement installés, 0 à enlever et 0 non mis à jour. Il est nécessaire de télécharger 4 069 ko d'archives. Après dépaquetage, 46,8 Mo seront utilisés. Voulez-vous continuer ? [Y/n/?]

Pour ma part, j’ai choisi d’installer le tout sous /srv, on va utiliser Git pour récupérer les sources.

root@xxxx:/srv# git clone https://github.com/abrasive/shairport.git shairport Clonage dans 'shairport'... remote: Counting objects: 1632, done. remote: Total 1632 (delta 0), reused 0 (delta 0) Réception d'objets: 100% (1632/1632), 419.59 KiB | 380.00 KiB/s, fait. Résolution des deltas: 100% (944/944), fait. Vérification de la connectivité... fait.

On procède à la compilation de tout ça :

root@xxxx:/srv/shairport# ./configure Configuring Shairport OpenSSL found libao found PulseAudio found ALSA found Avahi client found getopt.h found CFLAGS: -D_REENTRANT -I/usr/include/alsa -D_REENTRANT LDFLAGS: -lm -lpthread -lssl -lcrypto -lao -lpulse-simple -lpulse -lasound -lavahi-common -lavahi-client Configure successful. You may now build with 'make'

 

root@xxxx:/srv/shairport# make cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT shairport.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT daemon.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT rtsp.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT mdns.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT mdns_external.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT mdns_tinysvcmdns.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT common.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT rtp.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT metadata.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT player.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT alac.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT audio.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT audio_dummy.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT audio_pipe.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT tinysvcmdns.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT audio_ao.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT audio_pulse.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT audio_alsa.c cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT mdns_avahi.c cc shairport.o daemon.o rtsp.o mdns.o mdns_external.o mdns_tinysvcmdns.o common.o rtp.o metadata.o player.o alac.o audio.o audio_dummy.o audio_pipe.o tinysvcmdns.o audio_ao.o audio_pulse.o audio_alsa.o mdns_avahi.o -lm -lpthread -lssl -lcrypto -lao -lpulse-simple -lpulse -lasound -lavahi-common -lavahi-client -o shairport

 

root@xxxx:/srv/shairport# make install cc -c -O2 -Wall -D_REENTRANT -I/usr/include/alsa -D_REENTRANT shairport.c cc shairport.o daemon.o rtsp.o mdns.o mdns_external.o mdns_tinysvcmdns.o common.o rtp.o metadata.o player.o alac.o audio.o audio_dummy.o audio_pipe.o tinysvcmdns.o audio_ao.o audio_pulse.o audio_alsa.o mdns_avahi.o -lm -lpthread -lssl -lcrypto -lao -lpulse-simple -lpulse -lasound -lavahi-common -lavahi-client -o shairport install -m 755 -d /usr/local/bin install -m 755 shairport /usr/local/bin/shairport

 

On crée un petit script pour lancer le serveur AirPlay.

root@xxxx:/srv/shairport# echo " #!/bin/bash cd /srv/shairport/ ./shairport -a 'Shairport' -d read " >> run_shairport.sh root@xxxx:/srv/shairport# chmod +x run_shairport.sh

Et on le lance :

root@xxxx:/srv/shairport# ./run_shairport.sh Starting Shairport 1.1.1-22-gd679d19 Listening for connections. 7551 ^CShutting down...

 

Ensuite, depuis votre appareil Apple, il suffit de choisir votre ordinateur comme sortie ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

Dans mon cas, il porte le nom par défaut « shairport ».

[![Transformez votre Ubuntu en serveur AirPlay avec ShairPort](https://techan.fr/wp-content/uploads/2014/11/shairport.png)](https://techan.fr/wp-content/uploads/2014/11/shairport.png)

 


